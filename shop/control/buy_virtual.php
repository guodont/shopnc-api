<?php
/**
 * 虚拟商品购买
 ***/


defined('InShopNC') or exit('Access Invalid!');
class buy_virtualControl extends BaseBuyControl {

    public function __construct() {
        parent::__construct();
        if (!$_SESSION['member_id']){
            redirect('index.php?act=login&ref_url='.urlencode(request_uri()));
        }
        //验证该会员是否禁止购买
        if(!$_SESSION['is_buy']){
            showMessage(Language::get('cart_buy_noallow'),'','html','error');
        }
        Tpl::output('hidden_rtoolbar_cart', 1);
    }

    /**
     * 虚拟商品购买第一步
     */
    public function buy_step1Op() {
        $logic_buy_virtual = Logic('buy_virtual');
        $result = $logic_buy_virtual->getBuyStep1Data($_GET['goods_id'], $_GET['quantity'], $_SESSION['member_id']);
        if (!$result['state']) {
            showMessage($result['msg'], '', 'html', 'error');
        }

        Tpl::output('goods_info',$result['data']['goods_info']);
        Tpl::output('store_info',$result['data']['store_info']);

        Tpl::showpage('buy_virtual_step1');
    }

    /**
     * 虚拟商品购买第二步
     */
    public function buy_step2Op() {
        $logic_buy_virtual = Logic('buy_virtual');
        $result = $logic_buy_virtual->getBuyStep2Data($_POST['goods_id'], $_POST['quantity'], $_SESSION['member_id']);
        if (!$result['state']) {
            showMessage($result['msg'], '', 'html', 'error');
        }
        
        //处理会员信息
        $member_info = array_merge($this->member_info,$result['data']['member_info']);
        
        Tpl::output('goods_info',$result['data']['goods_info']);
        Tpl::output('store_info',$result['data']['store_info']);
        Tpl::output('member_info',$member_info);
        Tpl::showpage('buy_virtual_step2');
    }

    /**
     * 虚拟商品购买第三步
     */
    public function buy_step3Op() {
        $logic_buy_virtual = Logic('buy_virtual');
        $_POST['order_from'] = 1;
        $result = $logic_buy_virtual->buyStep3($_POST,$_SESSION['member_id']);
        if (!$result['state']) {
            showMessage($result['msg'], 'index.php', 'html', 'error');
        }
        //转向到商城支付页面
        redirect('index.php?act=buy_virtual&op=pay&order_id='.$result['data']['order_id']);
    }

    /**
     * 下单时支付页面
     */
    public function payOp() {
        $order_id	= intval($_GET['order_id']);
        if ($order_id <= 0){
            showMessage('该订单不存在','index.php?act=member_vr_order','html','error');
        }

        $model_vr_order = Model('vr_order');
        //取订单信息
        $condition = array();
        $condition['order_id'] = $order_id;
        $order_info = $model_vr_order->getOrderInfo($condition,'*',true);
        if (empty($order_info) || !in_array($order_info['order_state'],array(ORDER_STATE_NEW,ORDER_STATE_PAY))) {
            showMessage('未找到需要支付的订单','index.php?act=member_order','html','error');
        }

        //重新计算在线支付金额
        $pay_amount_online = 0;
        //订单总支付金额
        $pay_amount = 0;

        $payed_amount = floatval($order_info['rcb_amount']) + floatval($order_info['pd_amount']);

        //计算所需要支付金额
        $diff_pay_amount = ncPriceFormat(floatval($order_info['order_amount'])-$payed_amount);

        //显示支付方式与支付结果
        if ($payed_amount > 0) {
            $payed_tips = '';
                if (floatval($order_info['rcb_amount']) > 0) {
                    $payed_tips = '充值卡已支付：￥'.$order_info['rcb_amount'];
                }
                if (floatval($order_info['pd_amount']) > 0) {
                    $payed_tips .= ' 预存款已支付：￥'.$order_info['pd_amount'];
                }
                $order_info['goods_price'] .= " ( {$payed_tips} )";
        }
        Tpl::output('order_info',$order_info);

        //如果所需支付金额为0，转到支付成功页
        if ($diff_pay_amount == 0) {
            redirect('index.php?act=buy_virtual&op=pay_ok&order_sn='.$order_info['order_sn'].'&order_id='.$order_info['order_id'].'&order_amount='.ncPriceFormat($order_info['order_amount']));
        }

        Tpl::output('diff_pay_amount',ncPriceFormat($diff_pay_amount));

        //显示支付接口列表
        $model_payment = Model('payment');
        $condition = array();
        $payment_list = $model_payment->getPaymentOpenList($condition);
        if (!empty($payment_list)) {
            unset($payment_list['predeposit']);
            unset($payment_list['offline']);
        }
        if (empty($payment_list)) {
            showMessage('暂未找到合适的支付方式','index.php?act=member_vr_order','html','error');
        }
        Tpl::output('payment_list',$payment_list);

        Tpl::showpage('buy_virtual_step3');
    }

    /**
     * 支付成功页面
     */
    public function pay_okOp() {
        $order_sn	= $_GET['order_sn'];
        if (!preg_match('/^\d{18}$/',$order_sn)){
            showMessage('该订单不存在','index.php?act=member_vr_order','html','error');
        }
        Tpl::showpage('buy_virtual_step4');
    }
}