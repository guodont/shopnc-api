<?php
/**
 * 卖家退款
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_refundControl extends BaseSellerControl {
	public function __construct() {
		parent::__construct();
		$model_refund = Model('refund_return');
		$model_refund->getRefundStateArray();
        Language::read('member_store_index');
	}
	/**
	 * 退款记录列表页
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

		$refund_list = $model_refund->getRefundList($condition,10);
		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$model_refund->showpage());
		self::profile_menu('refund',$order_lock);
		Tpl::showpage('store_refund');
	}
	/**
	 * 退款审核页
	 *
	 */
	public function editOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['refund_id'] = intval($_GET['refund_id']);
		$refund_list = $model_refund->getRefundList($condition);
		$refund = $refund_list[0];
		if (chksubmit()) {
			$reload = 'index.php?act=store_refund&lock=1';
			if ($refund['order_lock'] == '2') {
			    $reload = 'index.php?act=store_refund&lock=2';
			}
			if ($refund['seller_state'] != '1') {//检查状态,防止页面刷新不及时造成数据错误
				showDialog(Language::get('wrong_argument'),$reload,'error');
			}
			$order_id = $refund['order_id'];
			$refund_array = array();
			$refund_array['seller_time'] = time();
			$refund_array['seller_state'] = $_POST['seller_state'];//卖家处理状态:1为待审核,2为同意,3为不同意
			$refund_array['seller_message'] = $_POST['seller_message'];
			if ($refund_array['seller_state'] == '3') {
			    $refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
			} else {
			    $refund_array['seller_state'] = '2';
			    $refund_array['refund_state'] = '2';
			}
			$state = $model_refund->editRefundReturn($condition, $refund_array);
			if ($state) {
    			if ($refund_array['seller_state'] == '3' && $refund['order_lock'] == '2') {
    			    $model_refund->editOrderUnlock($order_id);//订单解锁
    			}
    			$this->recordSellerLog('退款处理，退款编号：'.$refund['refund_sn']);

    			// 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $refund['buyer_id'];
                $param['param'] = array(
                    'refund_url'=> urlShop('member_refund', 'view', array('refund_id' => $refund['refund_id'])),
                    'refund_sn' => $refund['refund_sn']
                );
                QueueClient::push('sendMemberMsg', $param);

				showDialog(Language::get('nc_common_save_succ'),$reload,'succ');
			} else {
				showDialog(Language::get('nc_common_save_fail'),$reload,'error');
			}
		}
		Tpl::output('refund',$refund);
		$info['buyer'] = array();
	    if(!empty($refund['pic_info'])) {
	        $info = unserialize($refund['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		$model_member = Model('member');
		$member = $model_member->getMemberInfoByID($refund['buyer_id']);
		Tpl::output('member',$member);
		$condition = array();
		$condition['order_id'] = $refund['order_id'];
		$model_refund->getRightOrderList($condition, $refund['order_goods_id']);
		Tpl::showpage('store_refund_edit');
	}
	/**
	 * 退款记录查看页
	 *
	 */
	public function viewOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['refund_id'] = intval($_GET['refund_id']);
		$refund_list = $model_refund->getRefundList($condition);
		$refund = $refund_list[0];
		Tpl::output('refund',$refund);
		$info['buyer'] = array();
	    if(!empty($refund['pic_info'])) {
	        $info = unserialize($refund['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		$model_member = Model('member');
		$member = $model_member->getMemberInfoByID($refund['buyer_id']);
		Tpl::output('member',$member);
		$condition = array();
		$condition['order_id'] = $refund['order_id'];
		$model_refund->getRightOrderList($condition, $refund['order_goods_id']);
		Tpl::showpage('store_refund_view');
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
			case 'refund':
				$menu_array = array(
					array('menu_key'=>'2','menu_name'=>'售前退款',	'menu_url'=>'index.php?act=store_refund&lock=2'),
					array('menu_key'=>'1','menu_name'=>'售后退款','menu_url'=>'index.php?act=store_refund&lock=1')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
