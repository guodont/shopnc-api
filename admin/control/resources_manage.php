<?php
/**
 * cms管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class resources_manageControl extends SystemControl{

	public function __construct(){
		parent::__construct();
		Language::read('resources');
	}

	public function indexOp() {
        $this->resources_manageOp();
	}

	/**
	 * cms设置
	 */
	public function resources_manageOp() {
        $model_setting = Model('setting');
        $setting_list = $model_setting->getListSetting();
        Tpl::output('setting',$setting_list);
        Tpl::showpage('resources_manage');
	}

	/**
	 * cms设置保存
	 */
	public function resources_manage_saveOp() {
        $model_setting = Model('setting');
        $update_array = array();
        $update_array['resources_isuse'] = intval($_POST['resources_isuse']);
        $update_array['resources_submit_verify_flag'] = intval($_POST['resources_submit_verify_flag']);
        $update_array['resources_comment_flag'] = intval($_POST['resources_comment_flag']);
        $update_array['resources_submit_flag'] = intval($_POST['resources_submit_flag']);
        $result = $model_setting->updateSetting($update_array);
        if ($result === true){
            $this->log(Language::get('resources_log_manage_save'), 0);
            showMessage(Language::get('nc_common_save_succ'));
        }else {
            $this->log(Language::get('resources_log_manage_save'), 0);
            showMessage(Language::get('nc_common_save_fail'));
        }
	}
}
