<?php
/**
 * 网站设置
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class searchControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('setting');
	}

	/**
	 * 搜索设置
	 */
	public function searchOp(){
		if (chksubmit()){
			$lang	= Language::getLangContent();
			$model_setting = Model('setting');

			/**
			 * 转码  防止GBK下用中文逗号截取不正确
			 */
			$comma = '，';
			if (strtoupper(CHARSET) == 'GBK'){
				$comma = Language::getGBK($comma);
			}
			$result = $model_setting->updateSetting(array(
				'hot_search'=>str_replace($comma,',',$_POST['hot_search'])));
			if ($result){
				showMessage($lang['nc_common_save_succ']);
			}else {
				showMessage($lang['nc_common_save_fail']);
			}
		}
		$model_setting = Model('setting');
		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);

		Tpl::showpage('setting.search');
	}


}
