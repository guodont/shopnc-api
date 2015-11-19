<?php
/**
 * 单位管理
 *
***/

defined('InShopNC') or exit('Access Invalid!');
Base::autoload('vendor/autoload');
use JPush\Model as M;
use JPush\JPushClient;
use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;

class companyControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('company');
	}

	
	/**
	 * 单位管理
	 */
	public function companyOp(){
		$lang	= Language::getLangContent();
		$model_company = Model('company');
		/**
		 * 删除
		 */
		if (chksubmit()){
			if (is_array($_POST['del_id']) && !empty($_POST['del_id'])){
				$model_upload = Model('upload');
				foreach ($_POST['del_id'] as $k => $v){
					$v = intval($v);
					/**
					 * 删除图片
					 */
					$condition['upload_type'] = '1';
					$condition['item_id'] = $v;
					$upload_list = $model_upload->getUploadList($condition);
					if (is_array($upload_list)){
						foreach ($upload_list as $k_upload => $v_upload){
							$model_upload->del($v_upload['upload_id']);
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_COMPANY.DS.$v_upload['file_name']);
						}
					}
					$model_company->del($v);
				}
				$this->log(L('company_index_del_succ').'[ID:'.implode(',',$_POST['del_id']).']',null);
				showMessage($lang['company_index_del_succ']);
			}else {
				showMessage($lang['company_index_choose']);
			}
		}
		/**
		 * 检索条件
		 */
		$condition['ac_id'] = intval($_GET['search_ac_id']);
		$condition['like_title'] = trim($_GET['search_title']);
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		/**
		 * 列表
		 */
		$company_list = $model_company->getcompanyList($condition,$page);
		/**
		 * 整理列表内容
		 */
		if (is_array($company_list)){
			/**
			 * 取单位分类
			 */
			$model_service = Model('service');
			$service_list = $model_service->Listgoods($condition);
			$tmp_class_name = array();
			if (is_array($service_list)){
				foreach ($service_list as $k => $v){
					$tmp_class_name[$v['service_id']] = $v['service_name'];
				}
			}

			foreach ($company_list as $k => $v){
				/**
				 * 发布时间
				 */
				$company_list[$k]['company_time'] = date('Y-m-d H:i:s',$v['company_time']);
				/**
				 * 所属分类
				 */
				if (@array_key_exists($v['ac_id'],$tmp_class_name)){
					$company_list[$k]['service_name'] = $tmp_class_name[$v['ac_id']];
				}
			}
		}
		

		Tpl::output('company_list',$company_list);
		Tpl::output('page',$page->show());
		Tpl::output('search_title',trim($_GET['search_title']));
		Tpl::output('search_ac_id',intval($_GET['search_ac_id']));
		Tpl::output('service_list',$service_list);
		Tpl::showpage('company.index');
	}

	/**
	 * 单位添加
	 */
	public function company_addOp(){
		$lang	= Language::getLangContent();
		$model_company = Model('company');
		/**
		 * 取服务列表
		*/
		$model_service = Model('service');
		$service_list = $model_service->listGoods($condition);
		$tmp_class_name = array();
		if (is_array($service_list)){
			foreach ($service_list as $k => $v){
		    $tmp_class_name[$v['service_id']] = $v['service_name'];
			}
		}
		/**
		 * 保存
		 */
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["company_title"], "require"=>"true", "message"=>$lang['company_add_title_null']),
				array("input"=>$_POST["ac_id"], "require"=>"true", "message"=>$lang['company_add_class_null']),
				array("input"=>$_POST["company_abstract"], 'require'=>'true', "message"=>$lang['company_add_abstract_null']),
				array("input"=>$_POST["company_content"], "require"=>"true", "message"=>$lang['company_add_content_null']),
				array("input"=>$_POST["company_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['company_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$insert_array = array();
				$insert_array['company_title'] = trim($_POST['company_title']);
				$insert_array['ac_id'] = intval($_POST['ac_id']);
				$insert_array['company_address'] = trim($_POST['company_address']);
				$insert_array['company_show'] = trim($_POST['company_show']);
				$insert_array['company_recommend'] = trim($_POST['company_recommend']);				
				$insert_array['company_sort'] = trim($_POST['company_sort']);
				$insert_array['company_abstract'] = trim($_POST['company_abstract']);				
				$insert_array['company_content'] = trim($_POST['company_content']);
				$insert_array['company_time'] = time();
				$result = $model_company->add($insert_array);
				if ($result){
					/**
					 * 更新图片信息ID
					 */
					$model_upload = Model('upload');
					if (is_array($_POST['file_id'])){
						foreach ($_POST['file_id'] as $k => $v){
							$v = intval($v);
							$update_array = array();
							$update_array['upload_id'] = $v;
							$update_array['item_id'] = $result;
							$model_upload->update($update_array);
							unset($update_array);
						}
					}

					$url = array(
						array(
							'url'=>'index.php?act=company&op=company',
							'msg'=>"{$lang['company_add_tolist']}",
						),
						array(
							'url'=>'index.php?act=company&op=company_add&ac_id='.intval($_POST['ac_id']),
							'msg'=>"{$lang['company_add_continueadd']}",
						),
					);
					$this->log(L('company_add_ok').'['.$_POST['company_title'].']',null);
					showMessage("{$lang['company_add_ok']}",$url);
				}else {
					showMessage("{$lang['company_add_fail']}");
				}
			}
		}

		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$condition['upload_type'] = '1';
		$condition['item_id'] = '0';
		$file_upload = $model_upload->getUploadList($condition);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_COMPANY.'/'.$file_upload[$k]['file_name'];
			}
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('ac_id',intval($_GET['ac_id']));
		Tpl::output('service_list',$service_list);
		Tpl::output('file_upload',$file_upload);
		Tpl::showpage('company.add');
	}

	/**
	 * 单位编辑
	 */
	public function company_editOp(){
		$lang	 = Language::getLangContent();
		$model_company = Model('company');

		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["company_title"], "require"=>"true", "message"=>$lang['company_add_title_null']),
				array("input"=>$_POST["ac_id"], "require"=>"true", "message"=>$lang['company_add_class_null']),
				//array("input"=>$_POST["company_address"], 'validator'=>'Url', "message"=>$lang['company_add_url_wrong']),
				array("input"=>$_POST["company_content"], "require"=>"true", "message"=>$lang['company_add_content_null']),
				array("input"=>$_POST["company_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['company_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$update_array = array();
				$update_array['company_id'] = intval($_POST['company_id']);
				$update_array['company_title'] = trim($_POST['company_title']);
				$update_array['ac_id'] = intval($_POST['ac_id']);
				$update_array['company_address'] = trim($_POST['company_address']);
				$update_array['company_show'] = trim($_POST['company_show']);
				$update_array['company_recommend'] = trim($_POST['company_recommend']);
				$update_array['company_sort'] = trim($_POST['company_sort']);
				$update_array['company_content'] = trim($_POST['company_content']);

				$result = $model_company->update($update_array);
				if ($result){
					/**
					 * 更新图片信息ID
					 */
					$model_upload = Model('upload');
					if (is_array($_POST['file_id'])){
						foreach ($_POST['file_id'] as $k => $v){
							$update_array = array();
							$update_array['upload_id'] = intval($v);
							$update_array['item_id'] = intval($_POST['company_id']);
							$model_upload->update($update_array);
							unset($update_array);
						}
					}

					$url = array(
						array(
							'url'=>$_POST['ref_url'],
							'msg'=>$lang['company_edit_back_to_list'],
						),
						array(
							'url'=>'index.php?act=company&op=company_edit&company_id='.intval($_POST['company_id']),
							'msg'=>$lang['company_edit_edit_again'],
						),
					);
					$this->log(L('company_edit_succ').'['.$_POST['company_title'].']',null);
					showMessage($lang['company_edit_succ'],$url);
				}else {
					showMessage($lang['company_edit_fail']);
				}
			}
		}

		$company_array = $model_company->getOneCompany(intval($_GET['company_id']));
		if (empty($company_array)){
			showMessage($lang['param_error']);
		}
		/**
		 * 取单位分类
		*/
		$model_service = Model('service');
		$service_list = $model_service->Listgoods($condition);
		$tmp_class_name = array();
		if (is_array($service_list)){
			foreach ($service_list as $k => $v){
		    $tmp_class_name[$v['service_id']] = $v['service_name'];
			}
		}
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$condition['upload_type'] = '1';
		$condition['item_id'] = $company_array['company_id'];
		$file_upload = $model_upload->getUploadList($condition);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_COMPANY.'/'.$file_upload[$k]['file_name'];
			}
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('file_upload',$file_upload);
		Tpl::output('service_list',$service_list);
		Tpl::output('company_array',$company_array);
		Tpl::showpage('company.edit');
	}
	/**
	 * 单位图片上传
	 */
	public function company_pic_uploadOp(){
		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_COMPANY);
		$result = $upload->upfile('fileupload');
		if ($result){
			$_POST['pic'] = $upload->file_name;
		}else {
			echo 'error';exit;
		}
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		/**
		 * 图片数据入库
		 */
		$insert_array = array();
		$insert_array['file_name'] = $_POST['pic'];
		$insert_array['upload_type'] = '7';
		$insert_array['file_size'] = $_FILES['fileupload']['size'];
		$insert_array['upload_time'] = time();
		$insert_array['item_id'] = intval($_POST['item_id']);
		$result = $model_upload->add($insert_array);
		if ($result){
			$data = array();
			$data['file_id'] = $result;
			$data['file_name'] = $_POST['pic'];
			$data['file_path'] = $_POST['pic'];
			/**
			 * 整理为json格式
			 */
			$output = json_encode($data);
			echo $output;
		}

	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 删除单位图片
			 */
			case 'del_file_upload':
				if (intval($_GET['file_id']) > 0){
					$model_upload = Model('upload');
					/**
					 * 删除图片
					 */
					$file_array = $model_upload->getOneUpload(intval($_GET['file_id']));
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_COMPANY.DS.$file_array['file_name']);
					/**
					 * 删除信息
					 */
					$model_upload->del(intval($_GET['file_id']));
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
		}
	}
}