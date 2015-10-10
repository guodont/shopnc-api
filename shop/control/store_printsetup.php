<?php
/**
 * 会员中心——我是卖家
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_printsetupControl extends BaseSellerControl {
	public function __construct() {
		parent::__construct();
		Language::read('member_store_index');
	}

	/**
	 * 店铺打印设置
	 */
	public function indexOp(){
		$model = Model();
		$store_info = $model->table('store')->where(array('store_id'=>$_SESSION['store_id']))->find();
		if(empty($store_info)){
			showDialog(Language::get('store_storeinfo_error'),'index.php?act=store_printsetup','error');
		}
		if(chksubmit()){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST['store_printdesc'], "require"=>"true","validator"=>"Length","min"=>1,"max"=>200,"message"=>Language::get('store_printsetup_desc_error'))
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showDialog($error);
			}
			$update_arr = array();
			//上传认证文件
			if($_FILES['store_stamp']['name'] != '') {
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_STORE);
				if($_FILES['store_stamp']['name'] != '') {
					$result = $upload->upfile('store_stamp');
					if ($result){
						$update_arr['store_stamp'] = $upload->file_name;
						//删除旧认证图片
						if (!empty($store_info['store_stamp'])){
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$store_info['store_stamp']);
						}
					}
				}
			}
			$update_arr['store_printdesc'] = $_POST['store_printdesc'];
			$rs = $model->table('store')->where(array('store_id'=>$_SESSION['store_id']))->update($update_arr);
			if ($rs){
				showDialog(Language::get('nc_common_save_succ'),'index.php?act=store_printsetup','succ');
			}else {
				showDialog(Language::get('nc_common_save_fail'),'index.php?act=store_printsetup','error');
			}
		}else{
			Tpl::output('store_info',$store_info);
			self::profile_menu('store_printsetup');
			Tpl::showpage('store_printsetup');
		}
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
            1=>array('menu_key'=>'store_printsetup','menu_name'=>'打印设置','menu_url'=>'index.php?act=store_printsetup&op=index'),
        );
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }

}
