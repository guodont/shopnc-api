<?php
/**
 * 我的订单
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */


defined('InShopNC') or exit('Access Invalid!');

class member_vr_orderControl extends apiMemberControl {

	public function __construct(){
		parent::__construct();
	}

    /**
     * 订单列表
     */
    public function order_listOp() {

        $model_vr_order = Model('vr_order');
        
        $condition = array();
        $condition['buyer_id'] = $this->member_info['member_id'];
        $order_list = $model_vr_order->getOrderList($condition, $this->page, '*', 'order_id desc');

        foreach ($order_list as $key => $order) {
            //显示取消订单
            $order_list[$key]['if_cancel'] = $model_vr_order->getOrderOperateState('buyer_cancel',$order);
        
            //显示支付
            $order_list[$key]['if_pay'] = $model_vr_order->getOrderOperateState('payment',$order);

            $order_list[$key]['goods_image_url'] = cthumb($order['goods_image'], 240, $order['store_id']);
        }

        $page_count = $model_vr_order->gettotalpage();

        output_data(array('order_list' => $order_list), mobile_page($page_count));
    }

    public function indate_code_listOp() {
        $order_id = intval($_POST['order_id']);
        if ($order_id <= 0) {
            output_error('订单不存在');
        }
        $model_vr_order = Model('vr_order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['buyer_id'] = $this->member_info['member_id'];
        $order_info = $model_vr_order->getOrderInfo($condition);
        if (empty($order_info) || $order_info['delete_state'] == ORDER_DEL_STATE_DROP) {
            output_error('订单不存在');
        }
        $order_list = array();
        $order_list[$order_id] = $order_info;
        $order_list = $model_vr_order->getCodeRefundList($order_list);//没有使用的兑换码列表
        $code_list = array();
        if(!empty($order_list[$order_id]['code_list'])) {
            foreach ($order_list[$order_id]['code_list'] as $value) {
                $code = array();
                $code['vr_code'] = $value['vr_code'];
                $code['vr_indate'] = $value['vr_indate'];
                $code_list[] = $code;
            }
        }
        output_data(array('code_list' => $code_list));
    }

    /**
     * 取消订单
     */
    public function order_cancelOp() {
        $model_vr_order = Model('vr_order');
        $condition = array();
        $condition['order_id'] = intval($_POST['order_id']);
        $condition['buyer_id'] = $this->member_info['member_id'];
        $order_info	= $model_vr_order->getOrderInfo($condition);

        $if_allow = $model_vr_order->getOrderOperateState('buyer_cancel',$order_info);
        if (!$if_allow) {
            output_data('无权操作');
        }

        $logic_vr_order = Logic('vr_order');
        $result = $logic_vr_order->changeOrderStateCancel($order_info,'buyer', '其它原因');

        if(!$result['state']) {
            output_data($result['msg']);
        } else {
            output_data('1');
        }
    }

}
