<?php
/**
 * 合作伙伴管理
 *
 *
 *
 *
 */



defined('InShopNC') or exit('Access Invalid!');
class mb_adControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('mobile');
	}
	/**
	 *
	 */
	public function mb_ad_listOp(){
		$model_mb_ad = Model('mb_ad');

		$link_list = $model_mb_ad->getMbAdList(array());
		Tpl::output('link_list',$link_list);

		Tpl::showpage('mb_ad.list');
	}

	/**
	 * 广告删除
	 */
	public function mb_ad_delOp(){
        $link_id = intval($_GET['link_id']);
		if ($link_id > 0){
			$model_mb_ad = Model('mb_ad');

			//删除图片
			$model_mb_ad->delMbAd($link_id);
			showMessage(L('link_index_del_succ'),'index.php?act=mb_ad&op=mb_ad_list');
		}else {
			showMessage(L('link_index_choose_del'),'index.php?act=mb_ad&op=mb_ad_list');
		}
	}

	/**
	 * 添加
	 */
	public function mb_ad_addOp(){
		$model_mb_ad = Model('mb_ad');

		//最多发布6条
		$count = $model_mb_ad->getMbAdCount();
		if ($count > 5){
			showMessage(L('link_add_count_limit'));
		}
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["link_title"], "require"=>"true", "message"=>L('link_add_title_null')),
				array("input"=>$_POST["link_keyword"], "require"=>"true","message"=>L('link_add_url_wrong')),
				array("input"=>$_POST["link_sort"], "require"=>"true", 'validator'=>'Number', "message"=>L('link_add_sort_int')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				/**
				 * 上传图片
				 */
				if ($_FILES['link_pic']['name'] != ''){
					$upload = new UploadFile();
					$upload->set('default_dir',ATTACH_MOBILE.'/ad');

					$result = $upload->upfile('link_pic');
					if ($result){
						$_POST['link_pic'] = $upload->file_name;
					}else {
						showMessage($upload->error);
					}
				}

				$insert_array = array();
				$insert_array['link_title'] = trim($_POST['link_title']);
				$insert_array['link_keyword'] = trim($_POST['keyword']);
				$insert_array['link_pic'] = trim($_POST['link_pic']);
				$insert_array['link_sort'] = trim($_POST['link_sort']);

				$result = $model_mb_ad->addMbAd($insert_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=mb_ad&op=mb_ad_list',
							'msg'=>L('link_add_back_to_list'),
						)
					);
					showMessage(L('link_add_succ'),$url);
				}else {
					showMessage(L('link_add_fail'));
				}
			}
		}

		Tpl::showpage('mb_ad.add');
	}

	/**
	 * 编辑
	 */
	public function mb_ad_editOp(){
		$model_mb_ad = Model('mb_ad');
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["link_title"], "require"=>"true", "message"=>L('link_add_title_null')),
				array("input"=>$_POST["link_url"], "require"=>"true", "message"=>L('link_add_url_wrong')),
				array("input"=>$_POST["link_sort"], "require"=>"true", 'validator'=>'Number', "message"=>L('link_add_sort_int')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				/**
				 * 上传图片
				 */
				if ($_FILES['link_pic']['name'] != ''){
					$upload = new UploadFile();
					$upload->set('default_dir',ATTACH_MOBILE.'/ad');

					$result = $upload->upfile('link_pic');
					if ($result){
						$_POST['link_pic'] = $upload->file_name;
					}else {
						showMessage($upload->error);
					}
				}
				$link_array = $model_mb_ad->getMbAdInfoByID(intval($_POST['link_id']));
				$update_array = array();
				$update_array['link_title'] = trim($_POST['link_title']);
				$update_array['link_keyword'] = trim($_POST['link_keyword']);
				if ($_POST['link_pic']){
					$update_array['link_pic'] = $_POST['link_pic'];
				}
				$update_array['link_sort'] = trim($_POST['link_sort']);

                $result = $model_mb_ad->editMbAd($update_array, array('link_id' => intval($_POST['link_id'])));
				if ($result){
				    //删除图片
				    if (!empty($_POST['link_pic']) && !empty($link_array['link_pic'])){
				        @unlink(BASE_ROOT_PATH.DS.DIR_UPLOAD.DS.ATTACH_MOBILE.'/ad'.DS.$link_array['link_pic']);
				    }
					$url = array(
						array(
							'url'=>'index.php?act=mb_ad&op=mb_ad_list',
							'msg'=>L('link_add_back_to_list'),
						)
					);
					showMessage(L('link_edit_succ'),$url);
				}else {
					showMessage(L('link_edit_fail'));
				}
			}
		}

		$link_array = $model_mb_ad->getMbAdInfoByID(intval($_GET['link_id']));
		if (empty($link_array)){
			showMessage(L('wrong_argument'));
		}

		Tpl::output('link_array',$link_array);
		Tpl::showpage('mb_ad.edit');
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 合作伙伴 排序
			 */
			case 'link_sort':
				$model_mb_ad = Model('mb_ad');
				$update_array = array();
				$update_array[$_GET['column']] = trim($_GET['value']);
                $condition = array();
				$condition['link_id'] = intval($_GET['id']);
				$result = $model_mb_ad->editMbAd($update_array, $condition);
				echo 'true';exit;
				break;
		}
	}
}
