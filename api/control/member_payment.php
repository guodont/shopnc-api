<?php
/**
 * 支付
 *
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */

use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_paymentControl extends apiMemberControl
{

    private $payment_code = 'alipay';

    public function __construct()
    {
        parent::__construct();
        $this->payment_code = isset($_GET['payment_code']) && trim($_GET['payment_code']) != '' ? trim($_GET['payment_code']) : 'alipay';
    }

    /**
     * 实物订单支付
     */
    public function payOp()
    {
        $pay_sn = $_GET['pay_sn'];

        $model_mb_payment = Model('mb_payment');
        $logic_payment = Logic('payment');

        $condition = array();
        $condition['payment_code'] = $this->payment_code;
        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);
        if (!$mb_payment_info) {
            output_error('系统不支持选定的支付方式');
        }

        //重新计算所需支付金额
        $result = $logic_payment->getRealOrderInfo($pay_sn, $this->member_info['member_id']);

        if (!$result['state']) {
            output_error($result['msg']);
        }

        //第三方API支付
        $this->_api_pay($result['data'], $mb_payment_info);
    }

    /**
     * 虚拟订单支付
     */
    public function vr_payOp()
    {
        $order_sn = $_GET['pay_sn'];

        $model_mb_payment = Model('mb_payment');
        $logic_payment = Logic('payment');

        $condition = array();
        $condition['payment_code'] = $this->payment_code;
        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);
        if (!$mb_payment_info) {
            output_error('系统不支持选定的支付方式');
        }

        //重新计算所需支付金额
        $result = $logic_payment->getVrOrderInfo($order_sn, $this->member_info['member_id']);

        if (!$result['state']) {
            output_error($result['msg']);
        }

        //第三方API支付
        $this->_api_pay($result['data'], $mb_payment_info);
    }

    /**
     * 第三方在线支付接口
     *
     */
    private function _api_pay($order_pay_info, $mb_payment_info)
    {
        $inc_file = BASE_PATH . DS . 'api' . DS . 'payment' . DS . $this->payment_code . DS . $this->payment_code . '.php';
        if (!is_file($inc_file)) {
            output_error('支付接口不存在');
        }
        require($inc_file);
        $param = array();
        $param = $mb_payment_info['payment_config'];
        $param['order_sn'] = $order_pay_info['pay_sn'];
        $param['order_amount'] = $order_pay_info['api_pay_amount'];
        $param['order_type'] = ($order_pay_info['order_type'] == 'real_order' ? 'r' : 'v');
        $payment_api = new $this->payment_code();
        $return = $payment_api->submit($param);
        echo $return;
        exit;
    }

    /**
     * 可用支付参数列表
     */
    public function payment_listOp()
    {
        $model_mb_payment = Model('mb_payment');

        $payment_list = $model_mb_payment->getMbPaymentOpenList();

        $payment_array = array();
        if (!empty($payment_list)) {
            foreach ($payment_list as $value) {
                $payment_array[] = $value['payment_code'];
            }
        }

        output_data(array('payment_list' => $payment_array));
    }
}
