<?php
/**
 * 订单管理
 *
 *
 *
 *
 * */

defined('InShopNC') or exit('Access Invalid!');
class live_orderControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('live');
	}

	public function indexOp(){
		$this->live_orderOp();
	}

	/*
	 * 订单列表
	 */
	public function live_orderOp(){

		$condition = array();
		if(!empty($_GET['order_sn'])){
			$condition['order_sn'] = $_GET['order_sn'];
		}

		if($_GET['store_name']) {
            $condition['store_name'] = $_GET['store_name'];
        }

		if(in_array($_GET['state'],array('1','2','3','4'))){
        	$condition['state'] = $_GET['state'];
        }

		if($_GET['payment_code']) {
            $condition['payment_code'] = $_GET['payment_code'];
        }

		if($_GET['member_name']) {
            $condition['member_name'] = $_GET['member_name'];
        }


        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_time']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_time']);
        $start_unixtime = $if_start_time ? strtotime($_GET['query_start_time']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['query_end_time']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }

		$model_live_order = Model('live_order');
		$list = $model_live_order->getList($condition);

		Tpl::output('list',$list);
		Tpl::output('show_page',$model_live_order->showpage(2));

		//显示支付接口列表(搜索)
        $payment_list = Model('payment')->getPaymentOpenList();
        Tpl::output('payment_list',$payment_list);

		Tpl::showpage('live_order.list');
	}

	/*
	 * 订单详情
	 */
	public function order_detailOp(){
		$condition = array();
		$condition['live_order.order_id'] = $_GET['order_id'];
		$model_live_order = Model('live_order');
		$live_order = $model_live_order->getOrderGroupbuy($condition);
		if(empty($live_order[0])){
			showMessage('订单不存在');
		}
		Tpl::output('live_order',$live_order[0]);

		$pwd_condition = array();
		$pwd_condition['order_id'] = $_GET['order_id'];
		$live_order_pwd = $model_live_order->getLiveOrderPwd($pwd_condition);
		Tpl::output('live_order_pwd',$live_order_pwd);

		Tpl::showpage('live_order.detail');
	}

	/*
	 * 结算订单
	 */
	public function live_area_accountOp(){
		$model_live_order = Model('live_order');
		$condition		= array();
		$condition['live_groupbuy.validity'] = array('elt',time());
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

		Tpl::showpage('live_order.account');
	}


	/*
	 * 订单删除
	 */
	public function del_orderOp(){
		$model_live_order = Model('live_order');
		$res = $model_live_order->del(array('in'=>array('order_id',$_POST['order_id'])));
		if($res){
			showMessage('删除成功','index.php?act=live_order','','succ');
		}else{
			showMessage('删除成功','index.php?act=live_order','','error');
		}
	}
}
