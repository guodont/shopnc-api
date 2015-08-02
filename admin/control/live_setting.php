<?php
/**
 * 订单管理
 *
 *
 *
 *
 * */

defined('InShopNC') or exit('Access Invalid!');
class live_settingControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('live');
	}

	public function indexOp(){
		$model_setting = Model('setting');
		if(chksubmit()){
			$update = array();
			if(!empty($_FILES['live_pic1']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_LIVE);
				$result = $upload->upfile('live_pic1');
				if ($result){
					$update['live_pic1'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}

			if(!empty($_POST['live_link1'])){
				$update['live_link1'] = $_POST['live_link1'];
			}

			if(!empty($_FILES['live_pic2']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_LIVE);
				$result = $upload->upfile('live_pic2');
				if ($result){
					$update['live_pic2'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}

			if(!empty($_POST['live_link2'])){
				$update['live_link2'] = $_POST['live_link2'];
			}

			if(!empty($_FILES['live_pic3']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_LIVE);
				$result = $upload->upfile('live_pic3');
				if ($result){
					$update['live_pic3'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}

			if(!empty($_POST['live_link3'])){
				$update['live_link3'] = $_POST['live_link3'];
			}

			if(!empty($_FILES['live_pic4']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_LIVE);
				$result = $upload->upfile('live_pic4');
				if ($result){
					$update['live_pic4'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}

			if(!empty($_POST['live_link4'])){
				$update['live_link4'] = $_POST['live_link4'];
			}

			$list_setting = $model_setting->getListSetting();
			$result = $model_setting->updateSetting($update);
			if($result){
				if($list_setting['live_pic1'] != '' && isset($update['live_pic1'])){
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_LIVE.DS.$list_setting['live_pic1']);
				}

				if($list_setting['live_pic2'] != '' && isset($update['live_pic2'])){
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_LIVE.DS.$list_setting['live_pic2']);
				}

				if($list_setting['live_pic3'] != '' && isset($update['live_pic3'])){
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_LIVE.DS.$list_setting['live_pic3']);
				}

				if($list_setting['live_pic4'] != '' && isset($update['live_pic4'])){
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_LIVE.DS.$list_setting['live_pic4']);
				}

				$this->log('修改线下抢设置',1);
				showMessage('编辑成功','','','succ');
			}else{
				showMessage('编辑失败','','','error');
			}
		}

		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);
		Tpl::showpage('live_setting.index');
	}


	public function clearOp(){
		$model_setting = Model('setting');
		$update = array();
		$update['live_pic1'] = '';
		$update['live_link1'] = '';
		$update['live_pic2'] = '';
		$update['live_link2'] = '';
		$update['live_pic3'] = '';
		$update['live_link3'] = '';
		$update['live_pic4'] = '';
		$update['live_link4'] = '';
		$res = $model_setting->updateSetting($update);
		if($res){
			$this->log('清空线下抢设置',1);
			echo json_encode(array('result'=>'true'));
		}else{
			echo json_encode(array('result'=>'false'));
		}
		exit;
	}
}
