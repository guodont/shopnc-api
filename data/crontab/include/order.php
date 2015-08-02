<?php
/**
 * 任务计划 - 生成结算单
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class orderControl {

    /**
     * 初始化对象
     */
    public function __construct(){
        register_shutdown_function(array($this,"shutdown"));
    }

    /**
     * 生成结算单
     */
    public function create_billOp() {
        $this->_create_order_statis();
    }

    /**
     * 生成上月账单
     */
    public function _create_order_statis() {
        $model_order = Model('order');
        $model_bill = Model('bill');
        $order_statis_max_info = $model_bill->getOrderStatisInfo(array(),'os_end_date','os_month desc');
        //计算起始时间点，自动生成以月份为单位的空结算记录
        if (!$order_statis_max_info){
            $order_min_info = $model_order->getOrderInfo(array(),array(),'min(add_time) as add_time');
            $start_unixtime = is_numeric($order_min_info['add_time']) ? $order_min_info['add_time'] : TIMESTAMP;
        } else {
            $start_unixtime = $order_statis_max_info['os_end_date'];
        }
        $data = array();
        $i = 1;
        $start_unixtime = strtotime(date('Y-m-01 00:00:00', $start_unixtime));
        $current_time = strtotime(date('Y-m-01 00:00:01',TIMESTAMP));
        while (($time = strtotime('-'.$i.' month',$current_time)) >= $start_unixtime) {
            if (date('Ym',$start_unixtime) == date('Ym',$time)) {
                //如果两个月份相等检查库是里否存在
                $order_statis = $model_bill->getOrderStatisInfo(array('os_month'=>date('Ym',$start_unixtime)));
                if ($order_statis) {
                    break;
                }
            }
            $first_day_unixtime = strtotime(date('Y-m-01 00:00:00', $time));	//该月第一天0时unix时间戳
            $last_day_unixtime = strtotime(date('Y-m-01 23:59:59', $time)." +1 month -1 day"); //该月最后一天最后一秒时unix时间戳
            $key = count($data);
            $os_month = date('Ym',$first_day_unixtime);
            $data[$key]['os_month'] = $os_month;
            $data[$key]['os_year'] = date('Y',$first_day_unixtime);
            $data[$key]['os_start_date'] = $first_day_unixtime;
            $data[$key]['os_end_date'] = $last_day_unixtime;

            //生成所有店铺月订单出账单
            $this->_create_order_bill($data[$key]);

            $fileds = 'sum(ob_order_totals) as ob_order_totals,sum(ob_shipping_totals) as ob_shipping_totals,
                    sum(ob_order_return_totals) as ob_order_return_totals,
                    sum(ob_commis_totals) as ob_commis_totals,sum(ob_commis_return_totals) as ob_commis_return_totals,
                    sum(ob_store_cost_totals) as ob_store_cost_totals,sum(ob_result_totals) as ob_result_totals';
            $order_bill_info = $model_bill->getOrderBillInfo(array('os_month'=>$os_month),$fileds);
            $data[$key]['os_order_totals'] = floatval($order_bill_info['ob_order_totals']);
            $data[$key]['os_shipping_totals'] = floatval($order_bill_info['ob_shipping_totals']);
            $data[$key]['os_order_return_totals'] = floatval($order_bill_info['ob_order_return_totals']);
            $data[$key]['os_commis_totals'] = floatval($order_bill_info['ob_commis_totals']);
            $data[$key]['os_commis_return_totals'] = floatval($order_bill_info['ob_commis_return_totals']);
            $data[$key]['os_store_cost_totals'] = floatval($order_bill_info['ob_store_cost_totals']);
            $data[$key]['os_result_totals'] = floatval($order_bill_info['ob_result_totals']);
            $i++;
        }
        krsort($data);
        $model_bill->addOrderStatis($data);
    }

    /**
     * 生成所有店铺月订单出账单
     *
     * @param int $data
     */
    private function _create_order_bill($data){
        $model_order = Model('order');
        $model_bill = Model('bill');
        $model_store = Model('store');
    
        //批量插件order_bill表
        //         $condition = array();
        //         $condition['order_state'] = ORDER_STATE_SUCCESS;
        //         $condition['finnshed_time'] = array(array('egt',$data['os_start_date']),array('elt',$data['os_end_date']),'and');
        //         取出有最终成交订单的店铺ID数量（ID不重复）
        //         $store_count =  $model_order->getOrderInfo($condition,array(),'count(DISTINCT store_id) as c');
        //         $store_count = $store_count['c'];
    
        //取店铺表数量(因为可能存在无订单，但有店铺活动费用，所以不再从订单表取店铺数量)
        $store_count = $model_store->getStoreCount(array());

        //分批生成该月份的店铺空结算表，每批生成300个店铺
        $insert = false;
        for ($i=0;$i<=$store_count;$i=$i+300){
            //         	$store_list = $model_order->getOrderList($condition,'','DISTINCT store_id','',"{$i},300");
            $store_list = $model_store->getStoreList(array(),null,'','store_id',"{$i},300");
            if ($store_list){
                //自动生成以月份为单位的空结算记录
                $data_bill = array();
                foreach($store_list as $store_info){
                    $data_bill['ob_no'] = $data['os_month'].$store_info['store_id'];
                    $data_bill['ob_start_date'] = $data['os_start_date'];
                    $data_bill['ob_end_date'] = $data['os_end_date'];
                    $data_bill['os_month'] = $data['os_month'];
                    $data_bill['ob_state'] = 0;
                    $data_bill['ob_store_id'] = $store_info['store_id'];
                    if (!$model_bill->getOrderBillInfo(array('ob_no'=>$data_bill['ob_no']))) {
                        $insert = $model_bill->addOrderBill($data_bill);
                        //对已生成空账单进行销量、退单、佣金统计
                        if ($insert){
                            $update = $this->_calc_order_bill($data_bill);
                            if (!$update){
                                showMessage('生成账单['.$data['os_month'].']失败','','html','error');
                            }
                            
                            // 发送店铺消息
                            $param = array();
                            $param['code'] = 'store_bill_affirm';
                            $param['store_id'] = $store_info['store_id'];
                            $param['param'] = array(
                                'state_time' => date('Y-m-d H:i:s', $data_bill['ob_start_date']),
                                'end_time' => date('Y-m-d H:i:s', $data_bill['ob_end_date']),
                                'bill_no' => $data_bill['ob_no']
                            );
                            QueueClient::push('sendStoreMsg', $param);
                            
                        }else{
                            showMessage('生成账单['.$data['os_month'].']失败','','html','error');
                        }
                    }
                }
            }
        }
    }

    /**
     * 计算某月内，某店铺的销量，退单量，佣金
     *
     * @param array $data_bill
     */
    private function _calc_order_bill($data_bill){
        $model_order = Model('order');
        $model_bill = Model('bill');
        $model_store = Model('store');

        $order_condition = array();
        $order_condition['order_state'] = ORDER_STATE_SUCCESS;
        $order_condition['store_id'] = $data_bill['ob_store_id'];
        $order_condition['finnshed_time'] = array('time',array($data_bill['ob_start_date'],$data_bill['ob_end_date']));

        $update = array();

        //订单金额
        $fields = 'sum(order_amount) as order_amount,sum(shipping_fee) as shipping_amount,store_name';
        $order_info =  $model_order->getOrderInfo($order_condition,array(),$fields);
        $update['ob_order_totals'] = floatval($order_info['order_amount']);
        //运费
        $update['ob_shipping_totals'] = floatval($order_info['shipping_amount']);
        //店铺名字
        $store_info = $model_store->getStoreInfoByID($data_bill['ob_store_id']);
        $update['ob_store_name'] = $store_info['store_name'];
    
        //佣金金额
        $order_info =  $model_order->getOrderInfo($order_condition,array(),'count(DISTINCT order_id) as count');
        $order_count = $order_info['count'];
        $commis_rate_totals_array = array();
        //分批计算佣金，最后取总和
        for ($i = 0; $i <= $order_count; $i = $i + 300){
            $order_list = $model_order->getOrderList($order_condition,'','order_id','',"{$i},300");
            $order_id_array = array();
            foreach ($order_list as $order_info) {
                $order_id_array[] = $order_info['order_id'];
            }
            if (!empty($order_id_array)){
                $order_goods_condition = array();
                $order_goods_condition['order_id'] = array('in',$order_id_array);
                $field = 'SUM(goods_pay_price*commis_rate/100) as commis_amount';
                $order_goods_info = $model_order->getOrderGoodsInfo($order_goods_condition,$field);
                $commis_rate_totals_array[] = $order_goods_info['commis_amount'];
            }else{
                $commis_rate_totals_array[] = 0;
            }
        }
        $update['ob_commis_totals'] = floatval(array_sum($commis_rate_totals_array));

        //退款总额
        $model_refund = Model('refund_return');
        $refund_condition = array();
        $refund_condition['seller_state'] = 2;
        $refund_condition['store_id'] = $data_bill['ob_store_id'];
        $refund_condition['goods_id'] = array('gt',0);
        $refund_condition['admin_time'] = array(array('egt',$data_bill['ob_start_date']),array('elt',$data_bill['ob_end_date']),'and');
        $refund_info = $model_refund->getRefundReturnInfo($refund_condition,'sum(refund_amount) as amount');
        $update['ob_order_return_totals'] = floatval($refund_info['amount']);

        //退款佣金
        $refund  =  $model_refund->getRefundReturnInfo($refund_condition,'sum(refund_amount*commis_rate/100) as amount');
        if ($refund) {
            $update['ob_commis_return_totals'] = floatval($refund['amount']);
        } else {
            $update['ob_commis_return_totals'] = 0;
        }

        //店铺活动费用
        $model_store_cost = Model('store_cost');
        $cost_condition = array();
        $cost_condition['cost_store_id'] = $data_bill['ob_store_id'];
        $cost_condition['cost_state'] = 0;
        $cost_condition['cost_time'] = array(array('egt',$data_bill['ob_start_date']),array('elt',$data_bill['ob_end_date']),'and');
        $cost_info = $model_store_cost->getStoreCostInfo($cost_condition,'sum(cost_price) as cost_amount');
        $update['ob_store_cost_totals'] = floatval($cost_info['cost_amount']);

        //本期应结
        $update['ob_result_totals'] = $update['ob_order_totals'] - $update['ob_order_return_totals'] -
        $update['ob_commis_totals'] + $update['ob_commis_return_totals']-
        $update['ob_store_cost_totals'];
        $update['ob_create_date'] = TIMESTAMP;
        $update['ob_state'] = 1;
        $result = $model_bill->editOrderBill($update,array('ob_no'=>$data_bill['ob_no']));
        return $result;
    }

    /**
     * 执行完成提示信息
     *
     */
    public function shutdown(){
        exit("success at ".date('Y-m-d H:i:s',TIMESTAMP)."\n");
    }
}