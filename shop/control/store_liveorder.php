<?php
/**
 * 商家中心线下抢管理
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_liveorderControl extends BaseSellerControl {

    public function __construct() {
        parent::__construct();
        //读取语言包
        Language::read('member_live');
    }

    /**
     * 订单管理
     **/
    public function indexOp() {
        $this->store_liveorderOp();
    }


    /*
     * 订单管理
     */
	public function store_liveorderOp(){
		$condition = array();
		$condition['live_order.store_id'] = $_SESSION['store_id'];
		if(!empty($_GET['state'])){
			$condition['live_order.state'] = intval($_GET['state']);
		}

		if(!empty($_GET['order_sn'])){
			$condition['live_order.order_sn'] = trim($_GET['order_sn']);
		}

		$model_live_order = Model('live_order');
		$list = $model_live_order->getOrderGroupbuy($condition);

		Tpl::output('list',$list);
		Tpl::output('show_page',$model_live_order->showpage('5'));

		$this->profile_menu('store_liveorder');
		Tpl::showpage('store_liveorder');
	}


	/*
	 * 订单详情
	 */
	public function store_livedetailOp(){
		$condition = array();
		$condition['order_id'] = intval($_GET['order_id']);
		$condition['store_id'] = $_SESSION['store_id'];

		$model_live_order = Model('live_order');
		$order = $model_live_order->live_orderInfo($condition);
		if(empty($order)){
			showMessage('该订单不存在','','','error');
		}
		Tpl::output('order',$order);

		$pwd_condition		= array();
		$pwd_condition['order_id']  = intval($_GET['order_id']);
		$order_pwd = $model_live_order->getLiveOrderPwd($pwd_condition);//抢购券
		Tpl::output('order_pwd',$order_pwd);


		$model_live_groupbuy = Model('live_groupbuy');
		$live_groupbuy = $model_live_groupbuy->live_groupbuyInfo(array('groupbuy_id'=>$order['item_id']));
		Tpl::output('live_groupbuy',$live_groupbuy);

		$this->profile_menu('store_livedetail');
		Tpl::showpage('store_livedetail');
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
			$condition['store_id'] = $_SESSION['store_id'];

			$params = array();
			$params['state'] = 4;//取消订单
			$params['cancel_time'] = time();
			$params['cancel_reason'] = trim($_POST['state_info']);


			$res = $model_live_order->updateLiveOrder($condition,$params);

			if($res){
				$model_live_groupbuy = Model('live_groupbuy');//抢购券回收
				$condition_live_groupbuy = array();
				$condition_live_groupbuy['groupbuy_id'] = $live_order['item_id'];

				$params_live_groupbuy = array();
				$params_live_groupbuy['buyer_count'] = array('exp','buyer_count+'.$live_order['number']);
				$params_live_groupbuy['buyer_num']	 = array('exp','buyer_num-'.$live_order['number']);
				$model_live_groupbuy->edit($condition_live_groupbuy,$params_live_groupbuy);

				if($live_order['py_amount']>0){
					$model_member = Model('member');
					$member = $model_member->getMemberInfo(array('member_id'=>$live_order['member_id']));

					$model_predeposit = Model('predeposit');
					$change_type = 'live_groupbuy_refund';

					$data = array();
					$data['amount'] = $live_order['py_amount'];
					$data['order_sn'] = $live_order['order_sn'];
					$data['member_id'] = $member['member_id'];
					$data['member_name'] = $member['member_name'];

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
			Tpl::showpage('store_liveorder.cancel','null_layout');exit();
		}
	}
	/*
	 * 操作日志
	 */
	public function store_liveverifylogOp(){

		$condition = array();
		$condition['live_order.store_id'] = $_SESSION['store_id'];
		$condition['live_order_pwd.state'] = 2;//消费
		$model_live_order = Model('live_order');
		$fields = 'live_order.order_id,live_order.order_sn,live_order_pwd.order_pwd,live_order_pwd.use_time';
		$log = $model_live_order->getOrderVerifyLog($condition,$fields);

		Tpl::output('log',$log);
		Tpl::output('show_page',$model_live_order->showpage('5'));

		$this->profile_menu('store_liveverifylog');

		Tpl::showpage('store_liveverifylog');
	}


	/**
     * 线下抢购验证
     **/
	public function store_liveverifyOp(){
		if(chksubmit()){//线下抢购验证

			$params = array();
			$params['live_order_pwd.order_pwd'] = trim($_POST['order_pwd']);
			$model = Model();
			$order_pwd = $model->table('live_order_pwd,live_order')->field('live_order_pwd.order_id,live_order_pwd.state,live_order.mobile,live_order.item_id,live_order.item_name')->join('left')->on('live_order_pwd.order_id = live_order.order_id')->where(array('order_pwd'=>$_POST['order_pwd']))->find();

			if(empty($order_pwd)){
				showDialog('线下抢兑换码验证失败，请核对后重新填写并再次提交验证。','','error','');
			}

			if($order_pwd['state'] == 2){//2.已使用
				showDialog('该线下抢兑换码已使用','','error','');
			}

			$model_live_groupbuy = Model('live_groupbuy');
			$live_groupbuy = $model_live_groupbuy->live_groupbuyInfo(array('groupbuy_id'=>$order_pwd['item_id']));
			if($live_groupbuy['validity']<time()){//已过期
				showDialog('该线下抢兑换码已过期','','error','');
			}

			$params = array();
			$params['state']	= 2;
			$params['use_time']	= time();

			$res = $model->table('live_order_pwd')->where(array('order_pwd'=>trim($_POST['order_pwd'])))->update($params);
			if($res){
				$order_params		= array();
				$order_params['use_time'] = $params['use_time'];

				$count = $model->table('live_order_pwd')->where(array('order_id'=>$order_pwd['order_id'],'state'=>1))->count();
				if($count==0){
					$order_params['state'] = 3;//3.已消费
					$order_params['finish_time'] = time();
				}

				$model->table('live_order')->where(array('order_id'=>$order_pwd['order_id']))->update($order_params);
				$content = '您的抢购'.$order_pwd['item_name'].'验证成功';
				$sms = new Sms;
				$sms->send($order_pwd['mobile'],$content.'【'.C('site_name').'】');
				showDialog('验证成功','','succ','');
			}else{
				showDialog('验证失败','','error','');
			}
		}
		Tpl::showpage('store_liveverify','null_layout');
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
				1=>array('menu_key'=>'store_liveorder','menu_name'=>'线下抢订单','menu_url'=>'index.php?act=store_liveorder&op=store_liveorder'),
				2=>array('menu_key'=>'store_liveverifylog','menu_name'=>'操作日志','menu_url'=>'index.php?act=store_liveorder&op=store_liveverifylog'),
		);

		switch($menu_key){
			case 'store_livedetail':
				$menu_array[]=array('menu_key'=>'store_livedetail','menu_name'=>'订单详情','menu_url'=>'');
				break;
		}

		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
