<?php
/**
 * 购买
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */


defined('InShopNC') or exit('Access Invalid!');

class member_vr_buyControl extends apiMemberControl {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * 虚拟商品购买第一步，设置购买数量
	 * POST
	 * 传入：cart_id:商品ID，quantity:购买数量
	 */
	public function buy_step1Op() {
	    $_POST['goods_id'] = $_POST['cart_id'];

	    $logic_buy_virtual = Logic('buy_virtual');
	    $result = $logic_buy_virtual->getBuyStep2Data($_POST['goods_id'], $_POST['quantity'], $this->member_info['member_id']);
	    if(!$result['state']) {
	        output_error($result['msg']);
	    } else {
	        $result = $result['data'];
	    }
	    unset($result['member_info']);
	    output_data($result);
	}

    /**
     * 虚拟商品购买第二步，设置接收手机号
	 * POST
	 * 传入：goods_id:商品ID，quantity:购买数量
	 */
    public function buy_step2Op() {

        $logic_buy_virtual = Logic('buy_virtual');
        $result = $logic_buy_virtual->getBuyStep2Data($_POST['goods_id'], $_POST['quantity'], $this->member_info['member_id']);
        if(!$result['state']) {
            output_error($result['msg']);
        } else {
	        $result = $result['data'];
            $member_info = array();
            $member_info['member_mobile'] = $result['member_info']['member_mobile'];
            $member_info['available_predeposit'] = $result['member_info']['available_predeposit'];
            $member_info['available_rc_balance'] = $result['member_info']['available_rc_balance'];
            unset($result['member_info']);
            $result['member_info'] = $member_info;
            output_data($result);
        }
    }

    /**
     * 虚拟订单第三步，产生订单
	 * POST
	 * 传入：goods_id:商品ID，quantity:购买数量，buyer_phone：接收手机，buyer_msg:下单留言,pd_pay:是否使用预存款支付0否1是，password：支付密码
	 */
    public function buy_step3Op() {
        $logic_buy_virtual = Logic('buy_virtual');
        $input = array();
        $input['goods_id'] = $_POST['goods_id'];
        $input['quantity'] = $_POST['quantity'];
        $input['buyer_phone'] = $_POST['buyer_phone'];
        $input['buyer_msg'] = $_POST['buyer_msg'];
        //支付密码
        $input['password'] = $_POST['password'];

        //是否使用充值卡支付0是/1否
        $input['rcb_pay'] = intval($_POST['rcb_pay']);

        //是否使用预存款支付0是/1否
        $input['pd_pay'] = intval($_POST['pd_pay']);

        $input['order_from'] = 2;
        $result = $logic_buy_virtual->buyStep3($input,$this->member_info['member_id']);
        if (!$result['state']) {
            output_error($result['msg']);
        } else {
            output_data($result['data']);
        }
    }
}
