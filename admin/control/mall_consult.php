<?php
/**
 * 平台客观咨询管理
 ***/

defined('InShopNC') or exit('Access Invalid!');

class mall_consultControl extends SystemControl{
    public function __construct(){
        parent::__construct();
    }

    /**
     * 咨询管理
     */
    public function indexOp(){
        $condition = array();
        if(chksubmit()){
            $member_name = trim($_GET['member_name']);
            if($member_name != ''){
                $condition['member_name'] = array('like', '%' . $member_name . '%');
                Tpl::output('member_name', $member_name);
            }
            $mct_id = intval($_GET['mctid']);
            if ($mct_id > 0) {
                $condition['mct_id'] = $mct_id;
                Tpl::output('mctid', $mct_id);
            }
        }
        $model_mallconsult = Model('mall_consult');
        $consult_list = $model_mallconsult->getMallConsultList($condition,'*', 10);
        Tpl::output('show_page',$model_mallconsult->showpage());
        Tpl::output('consult_list',$consult_list);



        // 咨询类型列表
        $type_list = Model('mall_consult_type')->getMallConsultTypeList(array(), 'mct_id,mct_name', 'mct_id');
        Tpl::output('type_list', $type_list);

        // 回复状态
        $state = array('0'=>'未回复', '1'=>'已回复');
        Tpl::output('state', $state);

        Tpl::showpage('mall_consult.index');
    }

    /**
     * 回复咨询
     */
    public function consult_replyOp() {
        $model_mallconsult = Model('mall_consult');
        if (chksubmit()) {
            $mc_id = intval($_POST['mc_id']);
            $reply_content = trim($_POST['reply_content']);
            if ($mc_id <= 0 || $reply_content == '') {
                showMessage(L('param_error'));
            }
            $update['is_reply'] = 1;
            $update['mc_reply'] = $reply_content;
            $update['mc_reply_time'] = TIMESTAMP;
            $update['admin_id'] = $this->admin_info['id'];
            $update['admin_name'] = $this->admin_info['name'];
            $result = $model_mallconsult->editMallConsult(array('mc_id' => $mc_id), $update);
            if ($result) {
                $consult_info = $model_mallconsult->getMallConsultInfo(array('mc_id' => $mc_id));
                // 发送用户消息
                $param = array();
                $param['code'] = 'consult_mall_reply';
                $param['member_id'] = $consult_info['member_id'];
                $param['param'] = array(
                    'consult_url' => urlShop('member_mallconsult', 'mallconsult_info', array('id' => $mc_id))
                );
                QueueClient::push('sendMemberMsg', $param);

                showMessage('回复成功', urlAdmin('mall_consult', 'index'));
            } else {
                showMessage('回复失败');
            }
        }
        $id = intval($_GET['id']);
        if ($id <= 0) {
            showMessage(L('param_error'));
        }

        $consult_info = $model_mallconsult->getMallConsultDetail($id);
        Tpl::output('consult_info', $consult_info);
        Tpl::showpage('mall_consult.reply');
    }

    /**
     * 删除平台客服咨询
     */
    public function del_consultOp(){
        $id = $_GET['id'];
        if($id <= 0){
            showMessage(Language::get('nc_common_del_fail'));
        }
        $result = Model('mall_consult')->delMallConsult(array('mc_id' => $id));
        if($result){
            $this->log('删除平台客服咨询'.'[ID:'.$id.']',null);
            showMessage(Language::get('nc_common_del_succ'));
        }else{
            showMessage(Language::get('nc_common_del_fail'));
        }
    }

    /**
     * 批量删除平台客服咨询
     */
    public function del_consult_batchOp(){
        $ids = $_POST['id'];
        if(empty($ids)){
            showMessage(Language::get('nc_common_del_fail'));
        }
        $result = Model('mall_consult')->delMallConsult(array('mc_id' => array('in', $ids)));
        if($result){
            $this->log('删除平台客服咨询'.'[ID:'.implode(',', $ids).']',null);
            showMessage(Language::get('nc_common_del_succ'));
        }else{
            showMessage(Language::get('nc_common_del_fail'));
        }
    }

    /**
     * 咨询类型列表
     */
    public function type_listOp() {
        $model_mct = Model('mall_consult_type');
        if (chksubmit()) {
            $mctid_array = $_POST['del_id'];
            if (!is_array($mctid_array)) {
                showMessage(L('param_error'));
            }
            foreach ($mctid_array as $val){
                if (!is_numeric($val)) {
                    showMessage(L('param_error'));
                }
            }

            $result = $model_mct->delMallConsultType(array('mct_id' => array('in', $mctid_array)));

            if ($result) {
                $this->log('删除平台客服咨询类型 ID:'.implode(',', $mctid_array), 1);
                showMessage(L('nc_common_del_succ'));
            } else {
                $this->log('删除平台客服咨询类型 ID:'.implode(',', $mctid_array), 0);
                showMessage(L('nc_common_del_fail'));
            }
        }
        $type_list = $model_mct->getMallConsultTypeList(array(), 'mct_id,mct_name,mct_sort');
        Tpl::output('type_list', $type_list);
        Tpl::showpage('mall_consult.type_list');
    }

    /**
     * 新增咨询类型
     */
    public function type_addOp() {
        if (chksubmit()) {
            // 验证
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["mct_name"], "require"=>"true", "message"=>'请填写咨询类型名称'),
                array("input"=>$_POST["mct_sort"], "require"=>"true", 'validator'=>'Number', "message"=>'请正确填写咨询类型排序'),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage(Language::get('error').$error,'','','error');
            }
            $insert = array();
            $insert['mct_name'] = trim($_POST['mct_name']);
            $insert['mct_introduce'] = $_POST['mct_introduce'];
            $insert['mct_sort'] = intval($_POST['mct_sort']);
            $result = Model('mall_consult_type')->addMallConsultType($insert);
            if ($result){
                $this->log('新增咨询类型',1);
                showMessage(L('nc_common_save_succ'), urlAdmin('mall_consult', 'type_list'));
            }else {
                $this->log('新增咨询类型',0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        Tpl::showpage('mall_consult.type_add');
    }

    /**
     * 编辑咨询类型
     */
    public function type_editOp() {
        $model_mct = Model('mall_consult_type');
        if (chksubmit()) {
            // 验证
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                    array("input"=>$_POST["mct_name"], "require"=>"true", "message"=>'请填写咨询类型名称'),
                    array("input"=>$_POST["mct_sort"], "require"=>"true", 'validator'=>'Number', "message"=>'请正确填写咨询类型排序'),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage(Language::get('error').$error,'','','error');
            }
            $where = array();
            $where['mct_id'] = intval($_POST['mct_id']);
            $update = array();
            $update['mct_name'] = trim($_POST['mct_name']);
            $update['mct_introduce'] = $_POST['mct_introduce'];
            $update['mct_sort'] = intval($_POST['mct_sort']);
            $result = $model_mct->editMallConsultType($where, $update);
            if ($result){
                $this->log('编辑平台客服咨询类型 ID:'.$where['mct_id'],1);
                showMessage(L('nc_common_op_succ'), urlAdmin('mall_consult', 'type_list'));
            }else {
                $this->log('编辑平台客服咨询类型 ID:'.$where['mct_id'],0);
                showMessage(L('nc_common_op_fail'));
            }
        }

        $mct_id = intval($_GET['mct_id']);
        if ($mct_id <= 0) {
            showMessage(L('param_error'));
        }
        $mct_info = $model_mct->getMallConsultTypeInfo(array('mct_id' => $mct_id));
        Tpl::output('mct_info', $mct_info);
        Tpl::showpage('mall_consult.type_edit');
    }

    /**
     * 删除咨询类型
     */
    public function type_delOp() {
        $mct_id = intval($_GET['mct_id']);
        if ($mct_id <= 0) {
            showMessage(L('param_error'));
        }
        $result = Model('mall_consult_type')->delMallConsultType(array('mct_id' => $mct_id));
        if ($result) {
            $this->log('删除平台客服咨询类型 ID:'.$mct_id, 1);
            showMessage(L('nc_common_del_succ'));
        } else {
            $this->log('删除平台客服咨询类型 ID:'.$mct_id, 0);
            showMessage(L('nc_common_del_fail'));
        }
    }
}
