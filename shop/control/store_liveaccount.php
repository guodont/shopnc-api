<?php
/**
 * 商家中心线下抢管理
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_liveaccountControl extends BaseSellerControl {

    public function __construct() {
        parent::__construct();
        //读取语言包
        Language::read('member_live');
    }

	public function indexOp(){
		$this->store_liveaccountOp();
	}

	/**
     * 线下抢购结算
     **/
	public function store_liveaccountOp(){
		$model_live_order = Model('live_order');
		$condition		= array();
		$condition['live_groupbuy.validity'] = array('elt',time());
		$condition['live_groupbuy.store_id'] = $_SESSION['store_id'];
		$condition['live_order.state'] = array('in',array(2,3));//2.已支付 3.已消费
		$list = $model_live_order->getOrderGroupbuy($condition);
		if(!empty($list)){
			$model = Model();
			foreach($list as $key=>$val){
				$count = $model->table('live_order_pwd')->where(array('order_id'=>$val['order_id'],'state'=>2))->count();
				$list[$key]['use_price'] = $count*$val['groupbuy_price'];
			}
		}

		Tpl::output('list',$list);
		Tpl::output('show_page',$model_live_order->showpage(2));

		$this->profile_menu('store_liveaccount');
		Tpl::showpage('store_liveorder.account');
	}


	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key) {
		$menu_array	= array(
				1=>array('menu_key'=>'store_liveaccount','menu_name'=>'线下结算','menu_url'=>'index.php?act=store_liveaccount'),
		);

		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
