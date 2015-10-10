<?php
/**
 * 卖家退货
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_returnControl extends BaseSellerControl {
	public function __construct() {
		parent::__construct();
		$model_refund = Model('refund_return');
		$model_refund->getRefundStateArray();
        Language::read('member_store_index');
	}
	/**
	 * 退货记录列表页
	 *
	 */
	public function indexOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];

		$keyword_type = array('order_sn','refund_sn','buyer_name');
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != '') {
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false) {
				$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
			}
		}
		$seller_state = intval($_GET['state']);
		if ($seller_state > 0) {
		    $condition['seller_state'] = $seller_state;
		}
		$order_lock = intval($_GET['lock']);
		if ($order_lock != 1) {
		    $order_lock = 2;
		}
		$_GET['lock'] = $order_lock;
		$condition['order_lock'] = $order_lock;

		$return_list = $model_refund->getReturnList($condition,10);
		Tpl::output('return_list',$return_list);
		Tpl::output('show_page',$model_refund->showpage());
		self::profile_menu('return',$order_lock);
		Tpl::showpage('store_return');
	}
	/**
	 * 退货审核页
	 *
	 */
	public function editOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['refund_id'] = intval($_GET['return_id']);
		$return_list = $model_refund->getReturnList($condition);
		$return = $return_list[0];
		if (chksubmit()) {
			$reload = 'index.php?act=store_return&lock=1';
			if ($return['order_lock'] == '2') {
			    $reload = 'index.php?act=store_return&lock=2';
			}
			if ($return['seller_state'] != '1') {//检查状态,防止页面刷新不及时造成数据错误
				showDialog(Language::get('wrong_argument'),$reload,'error');
			}
			$order_id = $return['order_id'];
			$refund_array = array();
			$refund_array['seller_time'] = time();
			$refund_array['seller_state'] = $_POST['seller_state'];//卖家处理状态:1为待审核,2为同意,3为不同意
			$refund_array['seller_message'] = $_POST['seller_message'];

			if ($refund_array['seller_state'] == '2' && empty($_POST['return_type'])) {
			    $refund_array['return_type'] = '2';//退货类型:1为不用退货,2为需要退货
			} elseif ($refund_array['seller_state'] == '3') {
			    $refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
			} else {
			    $refund_array['seller_state'] = '2';
			    $refund_array['refund_state'] = '2';
			    $refund_array['return_type'] = '1';//选择弃货
			}
			$state = $model_refund->editRefundReturn($condition, $refund_array);
			if ($state) {
    			if ($refund_array['seller_state'] == '3' && $return['order_lock'] == '2') {
    			    $model_refund->editOrderUnlock($order_id);//订单解锁
    			}
    			$this->recordSellerLog('退货处理，退货编号：'.$return['refund_sn']);

    			// 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $return['buyer_id'];
                $param['param'] = array(
                    'refund_url' => urlShop('member_return', 'view', array('return_id' => $return['refund_id'])),
                    'refund_sn' => $return['refund_sn']
                );
                QueueClient::push('sendMemberMsg', sendMemberMsg);

				showDialog(Language::get('nc_common_save_succ'),$reload,'succ');
			} else {
				showDialog(Language::get('nc_common_save_fail'),$reload,'error');
			}
		}
		Tpl::output('return',$return);
		$info['buyer'] = array();
	    if(!empty($return['pic_info'])) {
	        $info = unserialize($return['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		$model_member = Model('member');
		$member = $model_member->getMemberInfoByID($return['buyer_id']);
		Tpl::output('member',$member);
		$condition = array();
		$condition['order_id'] = $return['order_id'];
		$model_refund->getRightOrderList($condition, $return['order_goods_id']);
		Tpl::showpage('store_return_edit');
	}
	/**
	 * 收货
	 *
	 */
	public function receiveOp() {
		$model_refund = Model('refund_return');
		$model_trade = Model('trade');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['refund_id'] = intval($_GET['return_id']);
		$return_list = $model_refund->getReturnList($condition);
		$return = $return_list[0];
		Tpl::output('return',$return);
		$return_delay = $model_trade->getMaxDay('return_delay');//发货默认5天后才能选择没收到
		$delay_time = time()-$return['delay_time']-60*60*24*$return_delay;
		Tpl::output('return_delay',$return_delay);
		Tpl::output('return_confirm',$model_trade->getMaxDay('return_confirm'));//卖家不处理收货时按同意并弃货处理
		Tpl::output('delay_time',$delay_time);
		if (chksubmit()) {
			if ($return['seller_state'] != '2' || $return['goods_state'] != '2') {//检查状态,防止页面刷新不及时造成数据错误
				showDialog(Language::get('wrong_argument'),'reload','error','CUR_DIALOG.close();');
			}
			$refund_array = array();
			if ($_POST['return_type'] == '3' && $delay_time > 0) {
			    $refund_array['goods_state'] = '3';
			} else {
    			$refund_array['receive_time'] = time();
    			$refund_array['receive_message'] = '确认收货完成';
    			$refund_array['refund_state'] = '2';//状态:1为处理中,2为待管理员处理,3为已完成
    			$refund_array['goods_state'] = '4';
			}
			$state = $model_refund->editRefundReturn($condition, $refund_array);
			if ($state) {
			    $this->recordSellerLog('退货确认收货，退货编号：'.$return['refund_sn']);

			    // 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $return['buyer_id'];
                $param['param'] = array(
                    'refund_url' => urlShop('member_return', 'view', array('return_id' => $return['refund_id'])),
                    'refund_sn' => $return['refund_sn']
                );
                QueueClient::push('sendMemberMsg', sendMemberMsg);

				showDialog(Language::get('nc_common_save_succ'),'reload','succ','CUR_DIALOG.close();');
			} else {
				showDialog(Language::get('nc_common_save_fail'),'reload','error','CUR_DIALOG.close();');
			}
		}
		$express_list  = rkcache('express',true);
		if ($return['express_id'] > 0 && !empty($return['invoice_no'])) {
			Tpl::output('e_name',$express_list[$return['express_id']]['e_name']);
			Tpl::output('e_code',$express_list[$return['express_id']]['e_code']);
		}
		Tpl::showpage('store_return_receive','null_layout');
	}
	/**
	 * 退货记录查看页
	 *
	 */
	public function viewOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['refund_id'] = intval($_GET['return_id']);
		$return_list = $model_refund->getReturnList($condition);
		$return = $return_list[0];
		Tpl::output('return',$return);
		$express_list  = rkcache('express',true);
		if ($return['express_id'] > 0 && !empty($return['invoice_no'])) {
			Tpl::output('e_name',$express_list[$return['express_id']]['e_name']);
			Tpl::output('e_code',$express_list[$return['express_id']]['e_code']);
		}
		$info['buyer'] = array();
	    if(!empty($return['pic_info'])) {
	        $info = unserialize($return['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		$model_member = Model('member');
		$member = $model_member->getMemberInfoByID($return['buyer_id']);
		Tpl::output('member',$member);
		$condition = array();
		$condition['order_id'] = $return['order_id'];
		$model_refund->getRightOrderList($condition, $return['order_goods_id']);
		Tpl::showpage('store_return_view');
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array = array();
		switch ($menu_type) {
			case 'return':
				$menu_array = array(
					array('menu_key'=>'2','menu_name'=>'售前退货',	'menu_url'=>'index.php?act=store_return&lock=2'),
					array('menu_key'=>'1','menu_name'=>'售后退货','menu_url'=>'index.php?act=store_return&lock=1')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
