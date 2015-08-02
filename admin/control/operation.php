<?php
/**
 * 网站设置
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class operationControl extends SystemControl{
	private $links = array(
		array('url'=>'act=operation&op=setting','lang'=>'nc_operation_set'),
	);
	public function __construct(){
		parent::__construct();
		Language::read('setting');
	}

	/**
	 * 基本设置
	 */
	public function settingOp(){
		$model_setting = Model('setting');
		if (chksubmit()){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(

			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$update_array = array();
                $update_array['promotion_allow'] = $_POST['promotion_allow'];
                $update_array['groupbuy_allow'] = $_POST['groupbuy_allow'];
                $update_array['points_isuse'] = $_POST['points_isuse'];
                $update_array['pointshop_isuse'] = $_POST['pointshop_isuse'];
                $update_array['voucher_allow'] = $_POST['voucher_allow'];
                $update_array['pointprod_isuse'] = $_POST['pointprod_isuse'];
                $update_array['points_reg'] = intval($_POST['points_reg'])?$_POST['points_reg']:0;
                $update_array['points_login'] = intval($_POST['points_login'])?$_POST['points_login']:0;
                $update_array['points_comments'] = intval($_POST['points_comments'])?$_POST['points_comments']:0;
                $update_array['points_orderrate'] = intval($_POST['points_orderrate'])?$_POST['points_orderrate']:0;
                $update_array['points_ordermax'] = intval($_POST['points_ordermax'])?$_POST['points_ordermax']:0;
				$update_array['points_invite'] = intval($_POST['points_invite'])?$_POST['points_invite']:0;
				$update_array['points_rebate'] = intval($_POST['points_rebate'])?$_POST['points_rebate']:0;
				$result = $model_setting->updateSetting($update_array);
				if ($result === true){
					$this->log(L('nc_edit,nc_operation,nc_operation_set'),1);
					showMessage(L('nc_common_save_succ'));
				}else {
					showMessage(L('nc_common_save_fail'));
				}
			}
		}
		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);
		Tpl::output('top_link',$this->sublink($this->links,'setting'));
		Tpl::showpage('operation.setting');
	}
}
