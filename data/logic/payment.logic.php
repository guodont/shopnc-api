<?php
/**
 * 支付行为
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class paymentLogic {

    /**
     * 取得实物订单所需支付金额等信息
     * @param int $pay_sn
     * @param int $member_id
     * @return array
     */
    public function getRealOrderInfo($pay_sn, $member_id = null) {
    
        //验证订单信息
        $model_order = Model('order');
        $condition = array();
        $condition['pay_sn'] = $pay_sn;
        if (!empty($member_id)) {
            $condition['buyer_id'] = $member_id;
        }
        $order_pay_info = $model_order->getOrderPayInfo($condition);
        if(empty($order_pay_info)){
            return callback(false,'该支付单不存在');
        }

        $order_pay_info['subject'] = '实物订单_'.$order_pay_info['pay_sn'];
        $order_pay_info['order_type'] = 'real_order';

        $condition = array();
        $condition['pay_sn'] = $pay_sn;
        $order_list = $model_order->getNormalOrderList($condition);
		
		
        //计算本次需要在线支付的订单总金额
        $pay_amount = 0;
        if (!empty($order_list)) {
            foreach ($order_list as $order_info) {
				//计算所需要支付金额(支付卡+余额支付了)//zmr>v60
		        $payed_amount = floatval($order_info['rcb_amount']) + floatval($order_info['pd_amount']);
				$pay_amount += ncPriceFormat(floatval($order_info['order_amount']) - $payed_amount);
		        //zmr<v60
                //$pay_amount += ncPriceFormat(floatval($order_info['order_amount']) - floatval($order_info['pd_amount']));
            }            
        }

        $order_pay_info['api_pay_amount'] = $pay_amount;
        $order_pay_info['order_list'] = $order_list;
    
        return callback(true,'',$order_pay_info);
    }

    /**
     * 取得虚拟订单所需支付金额等信息
     * @param int $order_sn
     * @param int $member_id
     * @return array
     */
    public function getVrOrderInfo($order_sn, $member_id = null) {
    
        //验证订单信息
        $model_order = Model('vr_order');
        $condition = array();
        $condition['order_sn'] = $order_sn;
        if (!empty($member_id)) {
            $condition['buyer_id'] = $member_id;
        }
        $order_info = $model_order->getOrderInfo($condition);
        if(empty($order_info)){
            return callback(false,'该订单不存在');
        }

        $order_info['subject'] = '虚拟订单_'.$order_sn;
        $order_info['order_type'] = 'vr_order';
        $order_info['pay_sn'] = $order_sn;




         //计算所需要支付金额(支付卡+余额支付了)//zmr>v60
        $payed_amount = floatval($order_info['rcb_amount']) + floatval($order_info['pd_amount']);
		$pay_amount += ncPriceFormat(floatval($order_info['order_amount']) - $payed_amount);
		 //zmr<v60
				
        //计算本次需要在线支付的订单总金额
        //$pay_amount = ncPriceFormat(floatval($order_info['order_amount']) - floatval($order_info['pd_amount']));

        $order_info['api_pay_amount'] = $pay_amount;
    
        return callback(true,'',$order_info);
    }

    /**
     * 取得充值单所需支付金额等信息
     * @param int $pdr_sn
     * @param int $member_id
     * @return array
     */
    public function getPdOrderInfo($pdr_sn, $member_id = null) {

        $model_pd = Model('predeposit');
        $condition = array();
        $condition['pdr_sn'] = $pdr_sn;
        if (!empty($member_id)) {
            $condition['pdr_member_id'] = $member_id;
        }

        $order_info = $model_pd->getPdRechargeInfo($condition);
        if(empty($order_info)){
            return callback(false,'该订单不存在');
        }

        $order_info['subject'] = '预存款充值_'.$order_info['pdr_sn'];
        $order_info['order_type'] = 'pd_order';
        $order_info['pay_sn'] = $order_info['pdr_sn'];
        $order_info['api_pay_amount'] = $order_info['pdr_amount'];
        return callback(true,'',$order_info);
    }

    /**
     * 取得所使用支付方式信息
     * @param unknown $payment_code
     */
    public function getPaymentInfo($payment_code) {
        if (in_array($payment_code,array('offline','predeposit')) || empty($payment_code)) {
            return callback(false,'系统不支持选定的支付方式');
        }
        $model_payment = Model('payment');
        $condition = array();
        $condition['payment_code'] = $payment_code;
        $payment_info = $model_payment->getPaymentOpenInfo($condition);
        if(empty($payment_info)) {
            return callback(false,'系统不支持选定的支付方式');
        }

        $inc_file = BASE_PATH.DS.'api'.DS.'payment'.DS.$payment_info['payment_code'].DS.$payment_info['payment_code'].'.php';
        if(!file_exists($inc_file)){
            return callback(false,'系统不支持选定的支付方式');
        }
        require_once($inc_file);
        $payment_info['payment_config']	= unserialize($payment_info['payment_config']);

        return callback(true,'',$payment_info);
    }

    /**
     * 支付成功后修改实物订单状态
     */
    public function updateRealOrder($out_trade_no, $payment_code, $order_list, $trade_no) {
        $post['payment_code'] = $payment_code;
        $post['trade_no'] = $trade_no;
        return Logic('order')->changeOrderReceivePay($order_list, 'system', '系统', $post);
    }

    /**
     * 支付成功后修改虚拟订单状态
     */
    public function updateVrOrder($out_trade_no, $payment_code, $order_info, $trade_no) {
        $post['payment_code'] = $payment_code;
        $post['trade_no'] = $trade_no;
        return Logic('vr_order')->changeOrderStatePay($order_info, 'system', $post);
    }

    /**
     * 支付成功后修改充值订单状态
     * @param unknown $out_trade_no
     * @param unknown $trade_no
     * @param unknown $payment_info
     * @throws Exception
     * @return multitype:unknown
     */
    public function updatePdOrder($out_trade_no,$trade_no,$payment_info,$recharge_info) {

        $condition = array();
        $condition['pdr_sn'] = $recharge_info['pdr_sn'];
        $condition['pdr_payment_state'] = 0;
        $update = array();
        $update['pdr_payment_state'] = 1;
        $update['pdr_payment_time'] = TIMESTAMP;
        $update['pdr_payment_code'] = $payment_info['payment_code'];
        $update['pdr_payment_name'] = $payment_info['payment_name'];
        $update['pdr_trade_sn'] = $trade_no;

        $model_pd = Model('predeposit');
        try {
            $model_pd->beginTransaction();
			$pdnum=$model_pd->getPdRechargeCount(array('pdr_sn'=>$recharge_info['pdr_sn'],'pdr_payment_state'=>1));
			if (intval($pdnum)>0) {
                throw new Exception('订单已经处理');
            }
            //更改充值状态
            $state = $model_pd->editPdRecharge($update,$condition);
            if (!$state) {
                throw new Exception('更新充值状态失败');
            }
            //变更会员预存款
            $data = array();
            $data['member_id'] = $recharge_info['pdr_member_id'];
            $data['member_name'] = $recharge_info['pdr_member_name'];
            $data['amount'] = $recharge_info['pdr_amount'];
            $data['pdr_sn'] = $recharge_info['pdr_sn'];
            $model_pd->changePd('recharge',$data);
            $model_pd->commit();
            return callback(true);

        } catch (Exception $e) {
            $model_pd->rollback();
            return callback(false,$e->getMessage());
        }
    }
}