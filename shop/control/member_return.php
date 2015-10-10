<?php
/**
 * 买家退货
 *
 *
 *
 *
 */



defined('InShopNC') or exit('Access Invalid!');

class member_returnControl extends BaseMemberControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_member_index');
		$model_refund = Model('refund_return');
		$model_refund->getRefundStateArray();
		$this->_getCommonOperationsAndNavLink('member_refund');
	}
	/**
	 * 退货记录列表页
	 *
	 */
	public function indexOp(){
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];

		$keyword_type = array('order_sn','refund_sn','goods_name');
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)){
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != ''){
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false){
				$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
			}
		}
		$return_list = $model_refund->getReturnList($condition,10);
		Tpl::output('return_list',$return_list);
		Tpl::output('show_page',$model_refund->showpage());
        $store_list = $model_refund->getRefundStoreList($return_list);
        Tpl::output('store_list', $store_list);
		self::profile_menu('member_order','buyer_return');
		Tpl::showpage('member_return');
	}
	/**
	 * 发货
	 *
	 */
	public function shipOp(){
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['refund_id'] = intval($_GET['return_id']);
		$return_list = $model_refund->getReturnList($condition);
		$return = $return_list[0];
		Tpl::output('return',$return);
		$express_list  = rkcache('express',true);
		Tpl::output('express_list',$express_list);
		if ($return['seller_state'] != '2' || $return['goods_state'] != '1') {//检查状态,防止页面刷新不及时造成数据错误
			showDialog(Language::get('wrong_argument'),'reload','error');
		}
		if (chksubmit()) {
			$refund_array = array();
			$refund_array['ship_time'] = time();
			$refund_array['delay_time'] = time();
			$refund_array['express_id'] = $_POST['express_id'];
			$refund_array['invoice_no'] = $_POST['invoice_no'];
			$refund_array['goods_state'] = '2';
			$state = $model_refund->editRefundReturn($condition, $refund_array);
			if ($state) {
				showDialog(Language::get('nc_common_save_succ'),'index.php?act=member_return&op=index','succ');
			} else {
				showDialog(Language::get('nc_common_save_fail'),'reload','error');
			}
		}
		$info['buyer'] = array();
	    if(!empty($return['pic_info'])) {
	        $info = unserialize($return['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		$condition = array();
		$condition['order_id'] = $return['order_id'];
		$model_refund->getRightOrderList($condition, $return['order_goods_id']);
		$model_trade = Model('trade');
		$return_delay = $model_trade->getMaxDay('return_delay');//发货默认5天后才能选择没收到
		Tpl::output('return_delay',$return_delay);
		Tpl::output('return_confirm',$model_trade->getMaxDay('return_confirm'));//卖家不处理收货时按同意并弃货处理
		Tpl::output('ship',1);
		Tpl::showpage('member_return_view');
	}
	/**
	 * 延迟时间
	 *
	 */
	public function delayOp(){
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['refund_id'] = intval($_GET['return_id']);
		$return_list = $model_refund->getReturnList($condition);
		$return = $return_list[0];
		Tpl::output('return',$return);
		if (chksubmit()) {
			if ($return['seller_state'] != '2' || $return['goods_state'] != '3') {//检查状态,防止页面刷新不及时造成数据错误
				showDialog(Language::get('wrong_argument'),'reload','error','CUR_DIALOG.close();');
			}
			$refund_array = array();
			$refund_array['delay_time'] = time();
			$refund_array['goods_state'] = '2';
			$state = $model_refund->editRefundReturn($condition, $refund_array);
			if ($state) {
				showDialog(Language::get('nc_common_save_succ'),'reload','succ','CUR_DIALOG.close();');
			} else {
				showDialog(Language::get('nc_common_save_fail'),'reload','error','CUR_DIALOG.close();');
			}
		}
		$model_trade = Model('trade');
		$return_delay = $model_trade->getMaxDay('return_delay');//发货默认5天后才能选择没收到
		Tpl::output('return_delay',$return_delay);
		Tpl::output('return_confirm',$model_trade->getMaxDay('return_confirm'));//卖家不处理收货时按弃货处理
		Tpl::showpage('member_return_delay','null_layout');
	}
	/**
	 * 退货记录查看页
	 *
	 */
	public function viewOp(){
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['refund_id'] = intval($_GET['return_id']);
		$return_list = $model_refund->getReturnList($condition);
		$return = $return_list[0];
		Tpl::output('return',$return);
		$express_list  = rkcache('express',true);
		if ($return['express_id'] > 0 && !empty($return['invoice_no'])) {
			Tpl::output('return_e_name',$express_list[$return['express_id']]['e_name']);
		}
		$info['buyer'] = array();
	    if(!empty($return['pic_info'])) {
	        $info = unserialize($return['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		$condition = array();
		$condition['order_id'] = $return['order_id'];
		$model_refund->getRightOrderList($condition, $return['order_goods_id']);
		Tpl::showpage('member_return_view');
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array	= array();
		switch ($menu_type) {
			case 'member_order':
				$menu_array = array(
				array('menu_key'=>'buyer_refund','menu_name'=>Language::get('nc_member_path_buyer_refund'),	'menu_url'=>'index.php?act=member_refund'),
				array('menu_key'=>'buyer_return','menu_name'=>Language::get('nc_member_path_buyer_return'),	'menu_url'=>'index.php?act=member_return'),
				array('menu_key'=>'buyer_vr_refund','menu_name'=>'虚拟兑码退款',	'menu_url'=>'index.php?act=member_vr_refund'));
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
