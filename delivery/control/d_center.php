<?php
/**
 * 物流自提服务站首页
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');

class d_centerControl extends BaseDeliveryCenterControl{
    public function __construct(){
        parent::__construct();
    }
    /**
     * 操作中心
     */
    public function indexOp() {
        $model_do = Model('delivery_order');
        $where = array();
        $where['dlyp_id'] = $_SESSION['dlyp_id'];
        if ($_GET['search_name'] != '') {
            $where['order_sn|shipping_code|reciver_mobphone'] = array('like', '%' . $_GET['search_name'] . '%');
            Tpl::output('search_name', $_GET['search_name']);
        }
        if ($_GET['hidden_success'] == 1) {
            $dorder_list = $model_do->getDeliveryOrderDefaultAndArriveList($where, '*', 10);
            Tpl::output('hidden_success', 1);
        } else {
            $dorder_list = $model_do->getDeliveryOrderList($where, '*', 10);
        }
        Tpl::output('dorder_list', $dorder_list);
        Tpl::output('show_page', $model_do->showpage());

        $dorder_state = $model_do->getDeliveryOrderState();
        Tpl::output('dorder_state', $dorder_state);
        
        Tpl::showpage('d_center.index');
    }
    /**
     * 详细资料
     */
    public function informationOp() {
        $model_dp = Model('delivery_point');
        $delivery_info = $model_dp->getDeliveryPointInfo(array('dlyp_id' => $_SESSION['dlyp_id']));
        Tpl::output('delivery_info', $delivery_info);
        Tpl::output('delivery_state', $model_dp->getDeliveryState());
        Tpl::showpage('d_center.information', 'null_layout');
    }
    /**
     * 修改密码
     */
    public function change_passwordOp() {
        if (chksubmit()) {
            if ($_POST['password'] != $_POST['passwd_confirm']) {
                showDialog('新密码与确认密码填写不同', '', 'error', 'DialogManager.close("change_password")');
            }
            $model_dp = Model('delivery_point');
            $where = array();
            $where['dlyp_id'] = $_SESSION['dlyp_id'];
            $where['dlyp_passwd'] = md5($_POST['old_password']);
            $dp_info = $model_dp->getDeliveryPointInfo($where);
            if (empty($dp_info)) {
                showDialog('原密码填写错误', '', 'error', 'DialogManager.close("change_password")');
            }
            $model_dp->editDeliveryPoint(array('dlyp_passwd' => md5($_POST['password'])), $where);

            unset($_SESSION['delivery_login']);
            unset($_SESSION['dlyp_id']);
            unset($_SESSION['dlyp_name']);
            showDialog('修改成功', 'reload', 'succ', 'DialogManager.close("change_password")');
        }
        Tpl::showpage('d_center.change_password', 'null_layout');
    }
    /**
     * 查看物流
     */
    public function get_expressOp() {
        Tpl::showpage('d_center.get_express', 'null_layout');
    }
    /**
     * 从第三方取快递信息
     */
    public function ajax_get_expressOp(){
        $url = 'http://www.kuaidi100.com/query?type='.$_GET['e_code'].'&postid='.$_GET['shipping_code'].'&id=1&valicode=&temp='.random(4).'&sessionid=&tmp='.random(4);
        import('function.ftp');
        $content = dfsockopen($url);
        $content = json_decode($content,true);
    
        if ($content['status'] != 200) exit(json_encode(false));
        $content['data'] = array_reverse($content['data']);
        $output = array();
        if (is_array($content['data'])){
            foreach ($content['data'] as $k=>$v) {
                if ($v['time'] == '') continue;
                $output[]= $v['time'].'&nbsp;&nbsp;'.$v['context'];
            }
        }
        if (empty($output)) exit(json_encode(false));
        echo json_encode($output);
    }
    /**
     * 取件通知
     */
    public function arrive_pointOp() {
        $order_id = intval($_GET['order_id']);
        if ($order_id <= 0) {
            showDialog(L('wrong_argument'));
        }
        $pickup_code = $this->createPickupCode();
        // 更新提货订单表数据
        $update = array();
        $update['dlyo_pickup_code'] = $pickup_code;
        Model('delivery_order')->editDeliveryOrderArrive($update, array('order_id' => $order_id, 'dlyp_id' => $_SESSION['dlyp_id']));
        // 更新订单扩展表数据
        Model('order')->editOrderCommon($update, array('order_id' => $order_id));
        // 发送短信提醒
        QueueClient::push('sendPickupcode', array('pickup_code' => $pickup_code, 'order_id' => $order_id));
        showDialog('操作成功', 'reload', 'succ');
    }
    /**
     * 提货验证
     */
    public function pickup_parcelOp() {
        if (chksubmit()) {
            $order_id = intval($_POST['order_id']);
            $pickup_code = intval($_POST['pickup_code']);
            if ($order_id <= 0 || $pickup_code <= 0) {
                showDialog(L('wrong_argument'), '', 'error', 'DialogManager.close("pickup_parcel")');
            }
            $model_do = Model('delivery_order');
            $dorder_info = $model_do->getDeliveryOrderInfo(array('order_id' => $order_id, 'dlyp_id' => $_SESSION['dlyp_id'], 'dlyo_pickup_code' => $pickup_code));
            if (empty($dorder_info)) {
                showDialog('提货码错误', '', 'error', 'DialogManager.close("pickup_parcel")');
            }
            $result = $model_do->editDeliveryOrderPickup(array(), array('order_id' => $order_id, 'dlyp_id' => $_SESSION['dlyp_id'], 'dlyo_pickup_code' => $pickup_code));
            if ($result) {
                // 更新订单状态
                $order_info = Model('order')->getOrderInfo(array('order_id' => $order_id));
                Logic('order')->changeOrderStateReceive($order_info, 'buyer', '物流自提服务站', '物流自提服务站确认收货');
                showDialog('操作成功，订单完成', 'reload', 'succ', 'DialogManager.close("pickup_parcel")');
            } else {
                showDialog('操作失败', '', 'error', 'DialogManager.close("pickup_parcel")');
            }
        }
        Tpl::showpage('d_center.pickup_parcel', 'null_layout');
    }
    /**
     * 生成提货码
     */
    private function createPickupCode() {
        return rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    }
}

