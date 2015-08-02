<?php
/**
 * 买家 我的虚拟订单
 *
 * */


defined('InShopNC') or exit('Access Invalid!');

class member_vr_orderControl extends BaseMemberControl {

    public function __construct() {
        parent::__construct();
        Language::read('member_member_index');
    }

    /**
     * 买家我的订单
     *
     */
    public function indexOp() {
        $model_vr_order = Model('vr_order');

        //搜索
        $condition = array();
        $condition['buyer_id'] = $_SESSION['member_id'];
        if ($_GET['order_sn'] != '') {
            $condition['order_sn'] = $_GET['order_sn'];
        }
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
        $start_unixtime = $if_start_date ? strtotime($_GET['query_start_date']) : null;
		$end_unixtime = $if_end_date ? strtotime($_GET['query_end_date']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }
        if ($_GET['state_type'] != '') {
            $condition['order_state'] = str_replace(
                    array('state_new','state_pay','state_success','state_cancel'),
                    array(ORDER_STATE_NEW,ORDER_STATE_PAY,ORDER_STATE_SUCCESS,ORDER_STATE_CANCEL), $_GET['state_type']);
        }

        $order_list = $model_vr_order->getOrderList($condition, 20, '*', 'order_id desc');
        //没有使用的兑换码列表
        $order_list = $model_vr_order->getCodeRefundList($order_list);

        foreach ($order_list as $key => $order) {

            //显示取消订单
            $order_list[$key]['if_cancel'] = $model_vr_order->getOrderOperateState('buyer_cancel',$order);

            //显示支付
            $order_list[$key]['if_pay'] = $model_vr_order->getOrderOperateState('payment',$order);

            //显示删除订单(放入回收站)
            $order_list[$key]['if_delete'] = $model_vr_order->getOrderOperateState('delete',$order);

            //显示永久删除
            $order_list[$key]['if_drop'] = $model_vr_order->getOrderOperateState('drop',$order);

            //显示还原订单
            $order_list[$key]['if_restore'] = $model_vr_order->getOrderOperateState('restore',$order);

            //显示退款
            $order_list[$key]['if_refund'] = $model_vr_order->getOrderOperateState('refund',$order);

            //显示评价
            $order_list[$key]['if_evaluation'] = $model_vr_order->getOrderOperateState('evaluation',$order);

            //显示分享
            $order_list[$key]['if_share'] = $model_vr_order->getOrderOperateState('share',$order);

            //显示商家信息(QQ,WW)
            $order_list[$key]['extend_store'] = Model('store')->getStoreInfoByID($order['store_id']);
        }

        Tpl::output('order_list',$order_list);
		Tpl::output('show_page',$model_vr_order->showpage());

		self::profile_menu($_GET['recycle'] ? 'member_order_recycle' : 'member_order');
        Tpl::showpage('member_vr_order.index');
    }

    /**
     * 订单详细
     *
     */
    public function show_orderOp() {
        $order_id = intval($_GET['order_id']);
        if ($order_id <= 0) {
            showMessage(Language::get('member_order_none_exist'),'','html','error');
        }
        $model_vr_order = Model('vr_order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['buyer_id'] = $_SESSION['member_id'];
        $order_info = $model_vr_order->getOrderInfo($condition);
        if (empty($order_info) || $order_info['delete_state'] == ORDER_DEL_STATE_DROP) {
            showMessage(Language::get('member_order_none_exist'),'','html','error');
        }
        $order_list = array();
        $order_list[$order_id] = $order_info;
        $order_list = $model_vr_order->getCodeRefundList($order_list);//没有使用的兑换码列表
        $order_info = $order_list[$order_id];

        $store_info = Model('store')->getStoreInfo(array('store_id' => $order_info['store_id']));

        //取兑换码列表
        $vr_code_list = $model_vr_order->getOrderCodeList(array('order_id' => $order_info['order_id']));
        $order_info['extend_vr_order_code'] = $vr_code_list;

        //显示取消订单
        $order_info['if_cancel'] = $model_vr_order->getOrderOperateState('buyer_cancel',$order_info);

        //显示订单进行步骤
        $order_info['step_list'] = $model_vr_order->getOrderStep($order_info);

        //显示退款
        $order_info['if_refund'] = $model_vr_order->getOrderOperateState('refund',$order_info);

        //显示评价
        $order_info['if_evaluation'] = $model_vr_order->getOrderOperateState('evaluation',$order_info);

        //显示分享
        $order_info['if_share'] = $model_vr_order->getOrderOperateState('share',$order_info);

        //显示系统自动取消订单日期
        if ($order_info['order_state'] == ORDER_STATE_NEW) {
            $order_info['order_cancel_day'] = $order_info['add_time'] + ORDER_AUTO_CANCEL_DAY * 24 * 3600;
        }

        Tpl::output('order_info',$order_info);
        Tpl::output('store_info',$store_info);

		Tpl::showpage('member_vr_order.show');
    }

	/**
	 * 买家订单状态操作
	 *
	 */
	public function change_stateOp() {
	    $model_vr_order = Model('vr_order');
	    $condition = array();
	    $condition['order_id'] = intval($_GET['order_id']);
	    $condition['buyer_id'] = $_SESSION['member_id'];
	    $order_info	= $model_vr_order->getOrderInfo($condition);

	    if ($_GET['state_type'] == 'order_cancel') {
	        $result = $this->_order_cancel($order_info,$_POST);
	    }

	    if(!$result['state']) {
	        showDialog($result['msg'],'','error');
	    } else {
	        showDialog($result['msg'],'reload','js');
	    }
    }

    /**
     * 取消订单
     */
    private function _order_cancel($order_info, $post) {
        if (!chksubmit()) {
            Tpl::output('order_info', $order_info);
            Tpl::showpage('member_vr_order.cancel','null_layout');
            exit();
        } else {
            $model_vr_order = Model('vr_order');
            $logic_vr_order = Logic('vr_order');
            $if_allow = $model_vr_order->getOrderOperateState('buyer_cancel',$order_info);
            if (!$if_allow) {
                return callback(false,'无权操作');
            }

            $msg = $post['state_info1'] != '' ? $post['state_info1'] : $post['state_info'];
            return $logic_vr_order->changeOrderStateCancel($order_info,'buyer', $msg);            
        }
    }

    /**
     * 发送兑换码到手机
     */
    public function resendOp() {
        if (!chksubmit()) {
            Tpl::showpage('member_vr_order.resend','null_layout');exit();
        }
        if (!preg_match('/^[\d]{11}$/',$_POST['buyer_phone'])) {
            showDialog('请正确填写手机号');
        }
        $order_id	= intval($_POST['order_id']);
        if ($order_id <= 0) {
            showDialog('参数错误');
        }

        $model_vr_order = Model('vr_order');

        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['buyer_id'] = $_SESSION['member_id'];
        $order_info	= $model_vr_order->getOrderInfo($condition);
        if (empty($order_info) && $order_info['order_state'] != ORDER_STATE_PAY) {
            showDialog('订单信息发生错误');
        }
        if ($order_info['vr_send_times'] >= 5) {
            showDialog('您发送的次数过多，无法发送');
        }

        //发送兑换码到手机
        $param = array('order_id'=>$order_id,'buyer_id'=>$_SESSION['member_id'],'buyer_phone'=>$order_info['buyer_phone']);
        QueueClient::push('sendVrCode', $param);

        $model_vr_order->editOrder(array('vr_send_times'=>array('exp','vr_send_times+1')),array('order_id'=>$order_id));

        showDialog('发送成功','','succ',"DialogManager.close('vr_code_resend');");
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
	        array('menu_key'=>'member_order','menu_name'=>Language::get('nc_member_path_order_list'), 'menu_url'=>'index.php?act=member_vr_order'),
	    );
	    Tpl::output('member_menu',$menu_array);
	    Tpl::output('menu_key',$menu_key);
	}
}
