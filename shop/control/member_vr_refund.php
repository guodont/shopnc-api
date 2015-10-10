<?php
/**
 * 买家虚拟兑码退款
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class member_vr_refundControl extends BaseMemberControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_member_index,refund');
		$model_vr_refund = Model('vr_refund');
		$model_vr_refund->getRefundStateArray();
		$this->_getCommonOperationsAndNavLink('member_refund');
	}
	/**
	 * 添加兑换码退款
	 *
	 */
	public function add_refundOp(){
		$model_vr_refund = Model('vr_refund');
		$order_id = intval($_GET['order_id']);
		if ($order_id < 1) {//参数验证
			showDialog(Language::get('wrong_argument'),'index.php?act=member_vr_refund&op=index','error');
		}
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$order = $model_vr_refund->getRightOrderList($condition);
		$order_id = $order['order_id'];
		if (!$order['if_refund']) {//检查状态,防止页面刷新不及时造成数据错误
			showDialog(Language::get('wrong_argument'),'index.php?act=member_vr_order&op=index','error');
		}
		if (chksubmit() && $order['if_refund']){
		    $code_list = $order['code_list'];
			$refund_array = array();
			$goods_num = 0;//兑换码数量
			$refund_amount = 0;//退款金额
			$code_sn = '';
			$rec_id_array = $_POST['rec_id'];
			if (!empty($rec_id_array) && is_array($rec_id_array)) {//选择退款的兑换码
			    foreach ($rec_id_array as $key => $value) {
			        $code = $code_list[$value];
        			if (!empty($code)) {
        			    $goods_num += 1;
        			    $refund_amount += $code['pay_price'];//实际支付金额
        			    $code_sn .= $code['vr_code'].',';//兑换码编号
        			}
			    }
			}
			if ($goods_num < 1) {
			    showDialog(Language::get('wrong_argument'),'reload','error');
			}
			$refund_array['code_sn'] = rtrim($code_sn, ',');
			$refund_array['admin_state'] = '1';//状态:1为待审核,2为同意,3为不同意
			$refund_array['refund_amount'] = ncPriceFormat($refund_amount);
			$refund_array['goods_num'] = $goods_num;
			$refund_array['buyer_message'] = $_POST['buyer_message'];
			$refund_array['add_time'] = time();
			$state = $model_vr_refund->addRefund($refund_array,$order);

			if ($state) {
				showDialog(Language::get('nc_common_save_succ'),'index.php?act=member_vr_refund&op=index','succ');
			} else {
				showDialog(Language::get('nc_common_save_fail'),'reload','error');
			}
		}
		Tpl::showpage('member_vr_refund_add');
	}
	/**
	 * 退款记录列表页
	 *
	 */
	public function indexOp(){
		$model_vr_refund = Model('vr_refund');
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
		$refund_list = $model_vr_refund->getRefundList($condition,10);
		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$model_vr_refund->showpage());
        $store_list = $model_vr_refund->getRefundStoreList($refund_list);
        Tpl::output('store_list', $store_list);
		self::profile_menu('member_order','buyer_vr_refund');
		Tpl::showpage('member_vr_refund');
	}
	/**
	 * 退款记录查看
	 *
	 */
	public function viewOp(){
		$model_vr_refund = Model('vr_refund');
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['refund_id'] = intval($_GET['refund_id']);
		$refund_list = $model_vr_refund->getRefundList($condition);
		$refund = $refund_list[0];
		Tpl::output('refund',$refund);
		$code_array = explode(',', $refund['code_sn']);
		Tpl::output('code_array',$code_array);
		$condition = array();
		$condition['order_id'] = $refund['order_id'];
		$model_vr_refund->getRightOrderList($condition);
		Tpl::showpage('member_vr_refund_view');
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
