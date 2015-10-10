<?php
/**
 * 买家 我的订单
 *
 * */


defined('InShopNC') or exit('Access Invalid!');

class member_liveControl extends BaseMemberControl {

    public function __construct() {
        parent::__construct();
        Language::read('member_member_index');
    }

	public function indexOp(){
		$this->member_liveOp();
	}

	/*
	 * 线下抢购列表
	 */
	public function member_liveOp(){
		$condition = array();//查询条件
		$condition['member_id'] = $_SESSION['member_id'];
		if(isset($_GET['state']) && !empty($_GET['state'])){//抢购状态
			$condition['state'] = intval($_GET['state']);
			Tpl::output('state',intval($_GET['state']));
		}

		if(isset($_GET['order_sn']) && !empty($_GET['order_sn'])){//订单编号
			$condition['order_sn'] = trim($_GET['order_sn']);
			Tpl::output('order_sn',trim($_GET['order_sn']));
		}

		if(!empty($_GET['query_start_date']) || !empty($_GET['query_end_date'])){//下单时间
			$condition['add_time'] = array('time',array(strtotime($_GET['query_start_date']),strtotime($_GET['query_end_date'])));
 		}


		$model_live_order = Model('live_order');
		$list = $model_live_order->getOrderGroupbuy($condition);

		if(!empty($list)){
			$model = Model();
			foreach($list as $key=>$val){
				$store = $model->table('store')->field('store_qq,store_ww,member_id')->where(array('store_id'=>$val['store_id']))->find();
				$list[$key]['store_member_id'] = $store['member_id'];
				$list[$key]['store_qq'] = $store['store_qq'];
				$list[$key]['store_ww'] = $store['store_ww'];
			}
		}

		Tpl::output('list',$list);
		Tpl::output('show_page',$model_live_order->showpage());

		$this->profile_menu('member_live');
		Tpl::showpage('member_live.index');
	}

	/*
	 * 线下抢购详情
	 */
	public function member_livedetailOp(){

		$condition = array();
		$condition['order_id'] = $_GET['order_id'];
		$condition['member_id']= $_SESSION['member_id'];
		$model_live_order = Model('live_order');
		$order = $model_live_order->getOrderGroupbuy($condition);
		$order = $order[0];
		if(empty($order)){
			showMessage('订单不存在','','','error');
		}
		Tpl::output('order',$order);

		$order_pwd = $model_live_order->getLiveOrderPwd(array('order_id'=>$order['order_id']));
		Tpl::output('order_pwd',$order_pwd);

		$use_pwd = 0;//使用数量
		$no_use_pwd = 0;//未使用数量

		if(!empty($order_pwd)){
			foreach($order_pwd as $pwd){
				if($pwd['state']==1){//1.未使用
					$no_use_pwd++;
				}elseif($pwd['state']==2){//2.已使用
					$use_pwd++;
				}
			}
		}

		Tpl::output('use_pwd',$use_pwd);
		Tpl::output('no_use_pwd',$no_use_pwd);


		$model_store = Model('store');
		$store = $model_store->getStoreInfo(array('store_id'=>$order['store_id']));
		Tpl::output('store',$store);

		$this->profile_menu('member_live_detail');
		Tpl::showpage('member_live.detail');
	}

	/*
	 * 取消订单
	 */
	public function cancelOp(){
		if(chksubmit()){
			$model_live_order = Model('live_order');
			$live_order = $model_live_order->live_orderInfo(array('order_id'=>$_GET['order_id']));

			if(empty($live_order)){
				showDialog('操作失败','','error','');
			}

			$condition = array();
			$condition['order_id'] = $_GET['order_id'];
			$condition['member_id']= $_SESSION['member_id'];

			$params = array();
			$params['state'] = 4;//取消订单
			$params['cancel_time'] = time();
			$params['cancel_reason'] = trim($_POST['state_info']);

			$res = $model_live_order->updateLiveOrder($condition,$params);

			if($res){
				if($live_order['py_amount']>0){
					$model_predeposit = Model('predeposit');
					$change_type = 'live_groupbuy_refund';

					$data = array();
					$data['amount'] = $live_order['py_amount'];
					$data['order_sn'] = $live_order['order_sn'];
					$data['member_id'] = $_SESSION['member_id'];
					$data['member_name'] = $_SESSION['member_name'];

					$model_predeposit->changePd($change_type,$data);
				}
				showDialog('操作成功','reload','succ','');
			}else{
				showDialog('操作失败','','error','');
			}
		}else{
			$model_live_order = Model('live_order');
			$condition	= array();
			$condition['order_id'] = intval($_GET['order_id']);
			$condition['state'] = 1;//1.未支付

			$order = $model_live_order->live_orderInfo($condition);
			Tpl::output('order',$order);
			Tpl::showpage('member_live.cancel','null_layout');exit();
		}
	}

    /**
     * 用户中心右边，小导航
     *
     * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key='') {
	    Language::read('member_layout');
	    $menu_array = array(
	        array('menu_key'=>'member_live','menu_name'=>'线下抢购', 'menu_url'=>'index.php?act=member_live'),
	    );

		switch($menu_key){
			case 'member_live_detail':
				$menu_array[]=array('menu_key'=>'member_live_detail','menu_name'=>'订单详情','menu_url'=>'');
				break;
		}
	    Tpl::output('member_menu',$menu_array);
	    Tpl::output('menu_key',$menu_key);
	}
}
