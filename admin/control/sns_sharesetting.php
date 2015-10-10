<?php
/**
 * */

defined('InShopNC') or exit('Access Invalid!');
class sns_sharesettingControl extends SystemControl{
	private $app_arr = array();

	public function __construct(){
		parent::__construct();
		Language::read('sns_sharesetting');
		$model = Model('sns_binding');
		$this->app_arr = $model->getApps();
	}

	/**
	 * 绑定接口列表
	 */
	public function sharesettingOp(){
		$model_setting = Model('setting');
		$list_setting = $model_setting->getListSetting();
		//sinaweibo
		if($list_setting['share_qqweibo_isuse']){
			$this->app_arr['qqweibo']['isuse'] = '1';
		}
		//qqweibo
		if($list_setting['share_sinaweibo_isuse']){
			$this->app_arr['sinaweibo']['isuse'] = '1';
		}
		Tpl::output('app_arr',$this->app_arr);
		Tpl::showpage('snssharesetting.index');
	}

	/**
	 * 开启和禁用功能
	 */
	public function setOp(){
		$key = trim($_GET['key']);
		if(!$key){
			showMessage(Language::get('param_error'));
		}
		$app_key = array_keys($this->app_arr);
		if(empty($app_key) || !in_array($key,$app_key)){
			showMessage(Language::get('param_error'));
		}
		$setting_model = Model('setting');
		$update_array = array();
		$key = "share_{$key}_isuse";
		$state = intval($_GET['state']) == 1 ?1:0;
		$update_array[$key] = $state;
		$result = $setting_model->updateSetting($update_array);
		if ($result){
			$this->log(L('nc_edit,nc_binding_manage'),null);
			showMessage(Language::get('nc_common_op_succ'));
		}else {
			showMessage(Language::get('nc_common_op_fail'));
		}
	}
	/**
	 * 编辑接口设置功能
	 */
	public function editOp(){
		$key = trim($_GET['key']);
		if(!$key){
			showMessage(Language::get('param_error'));
		}
		$app_key = array_keys($this->app_arr);
		if(empty($app_key) || !in_array($key,$app_key)){
			showMessage(Language::get('param_error'));
		}
		$setting_model = Model('setting');
		if(chksubmit()){
			$update_array = array();
			$update_array["share_{$key}_isuse"] = intval($_POST['isuse']) == 1 ?1:0;
			$update_array["share_{$key}_appid"] = $_POST['appid'];
			$update_array["share_{$key}_appkey"] = $_POST['appkey'];
			//只更新需要code的app
			if(isset($_POST['appcode'])){
				$update_array["share_{$key}_appcode"] = $_POST['appcode'];
			}
			//只更新需要secretkey的app
			if(isset($_POST['secretkey'])){
				$update_array["share_{$key}_secretkey"] = $_POST['secretkey'];
			}
			$result = $setting_model->updateSetting($update_array);
			if ($result){
				$this->log(L('nc_edit,nc_binding_manage'),null);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=sns_sharesetting&op=sharesetting');
			}else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}else{
			$list_setting = $setting_model->getListSetting();
			$edit_arr = array();
			$edit_arr = $this->app_arr[$key];
			$edit_arr['key'] = $key;
			$edit_arr['isuse'] = $list_setting["share_{$key}_isuse"];
			$edit_arr['appid'] = $list_setting["share_{$key}_appid"];
			$edit_arr['appkey'] = $list_setting["share_{$key}_appkey"];
			//需要code的app
			if(in_array($key,array('qqzone','sinaweibo'))){
				$edit_arr['appcode'] = "{$list_setting["share_{$key}_appcode"]}";
			}
			Tpl::output('edit_arr',$edit_arr);
			Tpl::showpage('snssharesetting.edit');
		}
	}
}
