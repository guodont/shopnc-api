<?php
/**
 * 圈子分类管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class circle_settingControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('circle');
	}
	/**
	 * 圈子设置
	 */
	public function indexOp(){
		$model_setting = Model('setting');
		if(chksubmit()){
			$update = array();
			$update['circle_isuse']		= intval($_POST['c_isuse']);
			$update['circle_name']		= $_POST['c_name'];
			$update['circle_createsum']	= intval($_POST['c_createsum']);
			$update['circle_joinsum']	= intval($_POST['c_joinsum']);
			$update['circle_managesum']	= intval($_POST['c_managesum']);
			$update['circle_iscreate']	= intval($_POST['c_iscreate']);
			$update['circle_istalk']	= intval($_POST['c_istalk']);
			$update['circle_wordfilter']	= $_POST['c_wordfilter'];
			$update['taobao_api_isuse']	= intval($_POST['taobao_api_isuse']);
			$update['taobao_app_key']	= $_POST['taobao_app_key'];
			$update['taobao_secret_key']= $_POST['taobao_secret_key'];
			if (!empty($_FILES['c_logo']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_CIRCLE);
				$result = $upload->upfile('c_logo');
				if ($result){
					$update['circle_logo'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}
			$list_setting = $model_setting->getListSetting();
			$result = $model_setting->updateSetting($update);
			if($result){
				if($list_setting['circle_logo'] != '' && isset($update['circle_logo'])){
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_CIRCLE.DS.$list_setting['circle_logo']);
				}
				if(intval($_POST['c_isuse']) == 1){
					$this->log(L('nc_circle_open'));
				}else{
					$this->log(L('nc_circle_close'));
				}
				showMessage(L('nc_common_op_succ'));
			}else{
				showMessage(L('nc_common_op_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);
		Tpl::showpage('circle_setting.index');
	}
	/**
	 * SEO 设置
	 */
	public function seoOp(){
		$model_setting = Model('setting');
		if (chksubmit()){
			$update = array();
			$update['circle_seotitle']	= $_POST['c_seotitle'];
			$update['circle_seokeywords']	= $_POST['c_seokeywords'];
			$update['circle_seodescription']= $_POST['c_seodescription'];
			$result = $model_setting->updateSetting($update);
			if($result){
				showMessage(L('nc_common_op_succ'));
			}else{
				showMessage(L('nc_common_op_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);
		Tpl::showpage('circle_setting.seo');
	}
	/**
	 * SEC 设置
	 */
	public function secOp(){
		$model_setting = Model('setting');
		if (chksubmit()){
			$update = array();
			$update['circle_intervaltime']		= intval($_POST['c_intervaltime']);
			$update['circle_contentleast']		= intval($_POST['c_contentleast']);
			$result = $model_setting->updateSetting($update);
			if($result){
				showMessage(L('nc_common_op_succ'));
			}else{
				showMessage(L('nc_common_op_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);
		Tpl::showpage('circle_setting.sec');
	}
	/**
	 * 成员等级
	 */
	public function expOp(){
		$model_setting = Model('setting');
		if(chksubmit()){
			$update = array();
			$update['circle_exprelease']	= intval($_POST['c_exprelease']);
			$update['circle_expreply']		= intval($_POST['c_expreply']);
			$update['circle_expreleasemax']	= intval($_POST['c_expreleasemax']);
			$update['circle_expreplied']	= intval($_POST['c_expreplied']);
			$update['circle_exprepliedmax']	= intval($_POST['c_exprepliedmax']);
			$result = $model_setting->updateSetting($update);
			if ($result){
				showMessage(L('nc_common_op_succ'));
			}else {
				showMessage(L('nc_common_op_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);
		Tpl::showpage('circle_setting.exp');
	}
	/**
	 * 圈子首页广告
	 */
	public function adv_manageOp(){
		$model_setting = Model('setting');
		if (chksubmit()){
			$input = array();
			//上传图片
			$upload = new UploadFile();
			$upload->set('default_dir',ATTACH_CIRCLE);
			$upload->set('thumb_ext',	'');
			$upload->set('file_name','1.jpg');
			$upload->set('ifremove',false);
			if (!empty($_FILES['adv_pic1']['name'])){
				$result = $upload->upfile('adv_pic1');
				if (!$result){
					showMessage($upload->error,'','','error');
				}else{
					$input[1]['pic'] = $upload->file_name;
					$input[1]['url'] = $_POST['adv_url1'];
				}
			}elseif ($_POST['old_adv_pic1'] != ''){
				$input[1]['pic'] = $_POST['old_adv_pic1'];
				$input[1]['url'] = $_POST['adv_url1'];
			}

			$upload->set('default_dir',ATTACH_CIRCLE);
			$upload->set('thumb_ext',	'');
			$upload->set('file_name','2.jpg');
			$upload->set('ifremove',false);
			if (!empty($_FILES['adv_pic2']['name'])){
				$result = $upload->upfile('adv_pic2');
				if (!$result){
					showMessage($upload->error,'','','error');
				}else{
					$input[2]['pic'] = $upload->file_name;
					$input[2]['url'] = $_POST['adv_url2'];
				}
			}elseif ($_POST['old_adv_pic2'] != ''){
				$input[2]['pic'] = $_POST['old_adv_pic2'];
				$input[2]['url'] = $_POST['adv_url2'];
			}

			$upload->set('default_dir',ATTACH_CIRCLE);
			$upload->set('thumb_ext', '');
			$upload->set('file_name', '3.jpg');
			$upload->set('ifremove', false);
			if (!empty($_FILES['adv_pic3']['name'])){
				$result = $upload->upfile('adv_pic3');
				if (!$result){
					showMessage($upload->error,'','','error');
				}else{
					$input[3]['pic'] = $upload->file_name;
					$input[3]['url'] = $_POST['adv_url3'];
				}
			}elseif ($_POST['old_adv_pic3'] != ''){
				$input[3]['pic'] = $_POST['old_adv_pic3'];
				$input[3]['url'] = $_POST['adv_url3'];
			}

			$upload->set('default_dir',ATTACH_CIRCLE);
			$upload->set('thumb_ext',	'');
			$upload->set('file_name','4.jpg');
			$upload->set('ifremove',false);
			if (!empty($_FILES['adv_pic4']['name'])){
				$result = $upload->upfile('adv_pic4');
				if (!$result){
					showMessage($upload->error,'','','error');
				}else{
					$input[4]['pic'] = $upload->file_name;
					$input[4]['url'] = $_POST['adv_url4'];
				}
			}elseif ($_POST['old_adv_pic4'] != ''){
				$input[4]['pic'] = $_POST['old_adv_pic4'];
				$input[4]['url'] = $_POST['adv_url4'];
			}

			$update_array = array();
			if (count($input) > 0){
				$update_array['circle_loginpic'] = serialize($input);
			}

			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				$this->log(L('nc_edit,loginSettings'),1);
				showMessage(L('nc_common_save_succ'));
			}else {
				$this->log(L('nc_edit,loginSettings'),0);
				showMessage(L('nc_common_save_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		if ($list_setting['circle_loginpic'] != ''){
			$list = unserialize($list_setting['circle_loginpic']);
		}
		Tpl::output('list', $list);
		Tpl::showpage('circle_setting.adv');
	}

    /**
     * 添加超级管理
     */
    public function superaddOp() {
        if (chksubmit()) {
            if (intval($_POST['member_id']) <= 0) {
                showMessage(L('nc_common_op_fail'));
            }
            $insert = array();
            $insert['member_id'] = intval($_POST['member_id']);
            $insert['member_name'] = $_POST['member_name'];
            $result = Model('circle_member')->addSuper($insert);
            if ($result) {
                showMessage(L('nc_common_op_succ'), urlAdmin('circle_setting', 'super_list'));
            } else {
                showMessage(L('nc_common_op_fail'));
            }
        }
        Tpl::showpage('circle_setting.super_add');
    }

    /**
     * 超级管理列表
     */
    public function super_listOp() {
        $model_circlemember = Model('circle_member');
        if (chksubmit()) {
            $id_array = $_POST['del_id'];
            if (empty($id_array)) {
                showMessage(L('miss_argument'));
            }
            foreach ($id_array as $val) {
                if (!is_numeric($val)) {
                    showMessage(L('param_error'));
                }
            }
            $result = $model_circlemember->delSuper(array('member_id' => array('in', $id_array)));
            if ($result) {
                showMessage(L('nc_common_del_succ'));
            } else {
                showMessage(L('nc_common_del_fail'));
            }
        }
        $cm_list = $model_circlemember->getSuperList(array());
        Tpl::output('cm_list', $cm_list);
        Tpl::showpage('circle_setting.super_list');
    }

    /**
     * 选择超管
     */
    public function choose_superOp(){
        Tpl::output('search_url', urlAdmin('circle_setting', 'member_search'));
        Tpl::showpage('circle.choose_master', 'null_layout');
    }

    /**
     * 删除超级管理员
     */
    public function del_superOp() {
        $member_id = intval($_GET['member_id']);
        if ($member_id < 0) {
            showMessage(L('param_error'));
        }

        $result = Model('circle_member')->delSuper(array('member_id' => $member_id));
        if ($result) {
            showMessage(L('nc_common_del_succ'));
        } else {
            showMessage(L('nc_common_del_fail'));
        }
    }

    /**
     * 搜索会员
     */
    public function member_searchOp() {
        $cm_list = Model('circle_member')->getSuperList(array(), 'member_id');

        $where = array();
        if (!empty($_GET['name'])) {
            $where['member_name'] = array('like', '%' . trim($_GET['name']) . '%');
        }
        if (!empty($cm_list)) {
            $cm_list = array_under_reset($cm_list, member_id);
            $memberid_array = array_keys($cm_list);
            $where['member_id'] = array('not in', $memberid_array);
        }
        $member_list = Model('member')->getMemberList($where, 'member_id,member_name');
        echo json_encode($member_list);die;
    }
}
