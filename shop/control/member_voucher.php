<?php
/**
 * 代金券
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class member_voucherControl extends BaseMemberControl{
	public function __construct() {
		parent::__construct();
		Language::read('member_layout,member_voucher');
		//判断系统是否开启代金券功能
		if (intval(C('voucher_allow')) !== 1){
			showMessage(Language::get('member_voucher_unavailable'),urlShop('member', 'home'),'html','error');
		}
	}
	/*
	 * 默认显示代金券模版列表
	 */
	public function indexOp() {
        $this->voucher_listOp() ;
    }

	/*
	 * 获取代金券模版详细信息
	 */
    public function voucher_listOp(){
		$model = Model('voucher');
        $list = $model->getMemberVoucherList($_SESSION['member_id'], $_GET['select_detail_state'], 10);

		//取已经使用过并且未有voucher_order_id的代金券的订单ID
		$used_voucher_code = array();
		$voucher_order = array();
		if (!empty($list)) {
		    foreach ($list as $v) {
		        if ($v['voucher_state'] == 2 && empty($v['voucher_order_id'])) {
		            $used_voucher_code[] = $v['voucher_code'];
		        }
		    }
		}
        if (!empty($used_voucher_code)) {
            $order_list = Model('order')->getOrderCommonList(array('voucher_code'=>array('in',$used_voucher_code)),'order_id,voucher_code');
            if (!empty($order_list)) {
                foreach ($order_list as $v) {
                    $voucher_order[$v['voucher_code']] = $v['order_id'];
                    $model->editVoucher(array('voucher_order_id'=>$v['order_id']),array('voucher_code'=>$v['voucher_code']));
                }
            }
        }

		Tpl::output('list', $list);
		Tpl::output('voucherstate_arr', $model->getVoucherStateArray());
        Tpl::output('show_page',$model->showpage(2)) ;
        $this->profile_menu('voucher_list');
        Tpl::showpage('member_voucher.list');
    }

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @param array 	$array		附加菜单
	 * @return
	 */
	private function profile_menu($menu_key='') {
		$menu_array = array(
			1=>array('menu_key'=>'voucher_list','menu_name'=>Language::get('nc_myvoucher'),'menu_url'=>'index.php?act=member_voucher&op=voucher_list'),
		);
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
    }

}
