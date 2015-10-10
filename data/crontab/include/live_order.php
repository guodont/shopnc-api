<?php
/**
 * 任务计划 - 订单处理
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class  live_orderControl {

    /**
     * 初始化对象
     */
    public function __construct(){
        register_shutdown_function(array($this,"shutdown"));
    }

    /**
     * 订单回收
     */	
	public function orderdealOp(){
		$day = OFFLINE_ORDER_CANCEL_TIME;

		$time = $day*24*60*60;
		$model_live_order = Model('live_order');
		$list = $model_live_order->getList(array('state'=>1));//未支付状态

		if(!empty($list)){
			$model_live_groupbuy = Model('live_groupbuy');
			
			foreach($list as $key=>$val){
				if(($val['add_time']+$time)<time()){
					$model_live_order->updateLiveOrder(array('order_id'=>$val['order_id']),array('state'=>4));
					
					$condition_live_groupbuy = array();
					$condition_live_groupbuy['groupbuy_id'] = $val['item_id'];

					$params_live_groupbuy = array();
					$params_live_groupbuy['buyer_count'] = array('exp','buyer_count+'.$val['number']);
					$params_live_groupbuy['buyer_num']	 = array('exp','buyer_num-'.$val['number']);

					$model_live_groupbuy->edit($condition_live_groupbuy,$params_live_groupbuy);
				}
			}
		}
	}



    /**
     * 执行完成提示信息
     *
     */
    public function shutdown(){
        exit("success at ".date('Y-m-d H:i:s',TIMESTAMP)."\n");
    }
}