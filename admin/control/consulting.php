<?php
/**
 * 咨询管理
 ***/

defined('InShopNC') or exit('Access Invalid!');

class consultingControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('consulting');
	}

	/**
	 * 咨询管理
	 */
	public function consultingOp(){
		$condition	= array();
		if(chksubmit()){
		    $member_name = trim($_GET['member_name']);
			if($member_name != ''){
				$condition['member_name'] = array('like', '%' . $member_name . '%');
                Tpl::output('member_name', $member_name);
			}
			$consult_content = trim($_GET['consult_content']);
			if($consult_content != ''){
				$condition['consult_content'] = array('like', '%' . $consult_content . '%');
				Tpl::output('consult_content', $consult_content);
			}
			$ctid = intval($_GET['ctid']);
            if ($ctid > 0) {
                $condition['ct_id'] = $ctid;
                Tpl::output('ctid', $ctid);
            }
		}
		$model_consult	= Model('consult');
		$consult_list	= $model_consult->getConsultList($condition,'*', 0, 10);
		Tpl::output('show_page',$model_consult->showpage());
		Tpl::output('consult_list',$consult_list);


		// 咨询类型
		$consult_type = rkcache('consult_type', true);
		Tpl::output('consult_type', $consult_type);

		Tpl::showpage('consulting.index');
	}

	public function deleteOp(){
		if(empty($_REQUEST['consult_id'])){
			showMessage(Language::get('nc_common_del_fail'));
		}
		$array_id	= array();
		if(!empty($_GET['consult_id'])){
			$array_id[]	= intval($_GET['consult_id']);
		}
		if(!empty($_POST['consult_id'])){
			$array_id	= $_POST['consult_id'];
		}
		$consult	= Model('consult');
		if($consult->delConsult(array('consult_id' => array('in', $array_id)))){
			$this->log(L('nc_delete,consulting').'[ID:'.$array_id.']',null);
			showMessage(Language::get('nc_common_del_succ'));
		}else{
			showMessage(Language::get('nc_common_del_fail'));
		}
	}

    /**
     * 咨询设置
     */
    public function settingOp() {
        $model_setting = Model('setting');
        if (chksubmit()){
            $update_array = array();
            $update_array['consult_prompt'] = $_POST['consult_prompt'];
            $result = $model_setting->updateSetting($update_array);
            if ($result === true){
                $this->log('编辑咨询文字提示',1);
                showMessage(L('nc_common_save_succ'));
            }else {
                $this->log('编辑咨询文字提示',0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        $setting_list = $model_setting->getListSetting();
        Tpl::output('setting_list', $setting_list);

        Tpl::showpage('consulting.setting');
    }

    /**
     * 咨询类型列表
     */
    public function type_listOp() {
        $model_ct = Model('consult_type');
        if (chksubmit()) {
            $ctid_array = $_POST['del_id'];
            if (!is_array($ctid_array)) {
                showMessage(L('param_error'));
            }
            foreach ($ctid_array as $val){
                if (!is_numeric($val)) {
                    showMessage(L('param_error'));
                }
            }

            $result = $model_ct->delConsultType(array('ct_id' => array('in', $ctid_array)));

            if ($result) {
                $this->log('删除咨询类型 ID:'.implode(',', $ctid_array), 1);
                showMessage(L('nc_common_del_succ'));
            } else {
                $this->log('删除咨询类型 ID:'.implode(',', $ctid_array), 0);
                showMessage(L('nc_common_del_fail'));
            }
        }
        $type_list = $model_ct->getConsultTypeList(array(), 'ct_id,ct_name,ct_sort');
        Tpl::output('type_list', $type_list);
        Tpl::showpage('consulting.type_list');
    }

    /**
     * 新增咨询类型
     */
    public function type_addOp() {
        if (chksubmit()) {
            // 验证
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["ct_name"], "require"=>"true", "message"=>'请填写咨询类型名称'),
                array("input"=>$_POST["ct_sort"], "require"=>"true", 'validator'=>'Number', "message"=>'请正确填写咨询类型排序'),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage(Language::get('error').$error,'','','error');
            }
            $insert = array();
            $insert['ct_name'] = trim($_POST['ct_name']);
            $insert['ct_sort'] = intval($_POST['ct_sort']);
            $insert['ct_introduce'] = $_POST['ct_introduce'];
            $result = Model('consult_type')->addConsultType($insert);
            if ($result){
                $this->log('新增咨询类型',1);
                showMessage(L('nc_common_save_succ'), urlAdmin('consulting', 'type_list'));
            }else {
                $this->log('新增咨询类型',0);
                showMessage(L('nc_common_save_fail'));
            }
        }
        Tpl::showpage('consulting.type_add');
    }

    /**
     * 编辑咨询类型
     */
    public function type_editOp() {
        $model_ct = Model('consult_type');
        if (chksubmit()) {
            // 验证
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                    array("input"=>$_POST["ct_name"], "require"=>"true", "message"=>'请填写咨询类型名称'),
                    array("input"=>$_POST["ct_sort"], "require"=>"true", 'validator'=>'Number', "message"=>'请正确填写咨询类型排序'),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage(Language::get('error').$error,'','','error');
            }
            $where = array();
            $where['ct_id'] = intval($_POST['ct_id']);
            $update = array();
            $update['ct_name'] = trim($_POST['ct_name']);
            $update['ct_sort'] = intval($_POST['ct_sort']);
            $update['ct_introduce'] = $_POST['ct_introduce'];
            $result = $model_ct->editConsultType($where, $update);
            if ($result){
                $this->log('编辑咨询类型 ID:'.$where['ct_id'],1);
                showMessage(L('nc_common_op_succ'), urlAdmin('consulting', 'type_list'));
            }else {
                $this->log('编辑咨询类型 ID:'.$where['ct_id'],0);
                showMessage(L('nc_common_op_fail'));
            }
        }

        $ct_id = intval($_GET['ct_id']);
        if ($ct_id <= 0) {
            showMessage(L('param_error'));
        }
        $ct_info = $model_ct->getConsultTypeInfo(array('ct_id' => $ct_id));
        Tpl::output('ct_info', $ct_info);
        Tpl::showpage('consulting.type_edit');
    }

    /**
     * 删除咨询类型
     */
    public function type_delOp() {
        $ct_id = intval($_GET['ct_id']);
        if ($ct_id <= 0) {
            showMessage(L('param_error'));
        }
        $result = Model('consult_type')->delConsultType(array('ct_id' => $ct_id));
        if ($result) {
            $this->log('删除咨询类型 ID:'.$ct_id, 1);
            showMessage(L('nc_common_del_succ'));
        } else {
            $this->log('删除咨询类型 ID:'.$ct_id, 0);
            showMessage(L('nc_common_del_fail'));
        }
    }
}
