<?php
/**
 * 物流自提服务站管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class deliveryControl extends SystemControl{
    public function __construct() {
        parent::__construct();
    }
    /**
     * 物流自提服务站列表
     */
    public function indexOp() {
        $model_dp = Model('delivery_point');
        $where = array();
        if ($_GET['search_name'] != '') {
            $where['dlyp_truename'] = array('like', '%' . $_GET['search_name'] . '%');
            Tpl::output('search_name', $_GET['search_name']);
        }
        if ($_GET['sign'] == 'verify') {
            Tpl::output('sign', 'verify');
            $dp_list = $model_dp->getDeliveryPointWaitVerifyList($where, 10);
        }else {
            $dp_list = $model_dp->getDeliveryPointList($where, 10);
        }
        Tpl::output('show_page', $model_dp->showpage());
        Tpl::output('dp_list', $dp_list);

        Tpl::output('delivery_state', $model_dp->getDeliveryState());
        
        Tpl::showpage('delivery.index');
    }
    /**
     * 物流自提服务站设置
     */
    public function settingOp() {
        $list_setting = Model('setting')->getListSetting();
        Tpl::output('list_setting',$list_setting);
        Tpl::showpage('delivery.setting');
    }
    /**
     * 提说站设置保存
     */
    public function save_settingOp() {
        if (!chksubmit()){
            showMessage(L('nc_common_save_fail'));
        }
        $update_array = array();
        $update_array['delivery_isuse'] = intval($_POST['delivery_isuse']);
        $result = Model('setting')->updateSetting($update_array);
        if ($result === true){
            $log = '开启';
            if ($update_array['delivery_isuse'] == 0) {
                $log = '关闭';
                // 删除相关联的收货地址
                Model('address')->delAddress(array('dlyp_id' => array('neq', 0)));
            }
            $this->log($log.'物流自提服务站功能', 1);
            showMessage(L('nc_common_save_succ'));
        }else {
            $this->log($log.'物流自提服务站功能', 0);
            showMessage(L('nc_common_save_fail'));
        }
    }
    /**
     * 编辑物流自提服务站信息
     */
    public function edit_deliveryOp() {
        $dlyp_id = intval($_GET['d_id']);
        if ($dlyp_id <= 0) {
            showMessage(L('param_error'));
        }
        $dlyp_info = Model('delivery_point')->getDeliveryPointInfo(array('dlyp_id' => $dlyp_id));
        if (empty($dlyp_info)) {
            showMessage(L('param_error'));
        }
        Tpl::output('dlyp_info', $dlyp_info);
        Tpl::showpage('delivery.edit');
    }
    /**
     * 编辑保存
     */
    public function save_editOp() {
        $dlyp_id = intval($_POST['did']);
        if (!chksubmit() || $dlyp_id <= 0) {
            showMessage(L('param_error'));
        }
        $where = array('dlyp_id' => $dlyp_id);
        $update = array();
        $update['dlyp_mobile']          = $_POST['dmobile'];
        $update['dlyp_telephony']       = $_POST['dtelephony'];
        $update['dlyp_address_name']    = $_POST['daddressname'];
        $update['dlyp_address']         = $_POST['daddress'];
        if ($_POST['dpasswd'] != '') {
            $update['dlyp_passwd']      = md5($_POST['dpasswd']);
        }
        $update['dlyp_state']           = intval($_POST['dstate']);
        $update['dlyp_fail_reason']     = $_POST['fail_reason'];
        $result = Model('delivery_point')->editDeliveryPoint($update, $where);
        if ($result) {
            // 删除相关联的收货地址
            Model('address')->delAddress(array('dlyp_id' => $dlyp_id));
            $this->log('编辑物流自提服务站功能，ID：'.$dlyp_id, 1);
            showMessage(L('nc_common_op_succ'), urlAdmin('delivery', 'index'));
        } else {
            $this->log('编辑物流自提服务站功能，ID：'.$dlyp_id, 0);
            showMessage(L('nc_common_op_fail'));
        }
    }
    /**
     * 订单列表
     */
    public function order_listOp() {
        $dlyp_id = intval($_GET['d_id']);
        if ($dlyp_id <= 0) {
            showMessage(L('param_error'));
        }
        $model_do = Model('delivery_order');
        $where = array();
        $where['dlyp_id'] = $dlyp_id;
        if ($_GET['search_name'] != '') {
            $where['order_sn|shipping_code'] = array('like', '%' . $_GET['search_name'] . '%');
            Tpl::output('search_name', $_GET['search_name']);
        }
        $dorder_list = $model_do->getDeliveryOrderList($where, 10);
        Tpl::output('dorder_list', $dorder_list);
        Tpl::output('show_page', $model_do->showpage());
        
        $dorder_state = $model_do->getDeliveryOrderState();
        Tpl::output('dorder_state', $dorder_state);
        
        Tpl::showpage('delivery.order_list');
    }
}
