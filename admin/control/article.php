<?php
/**
 * 文章管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class articleControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('article');
	}
	/**
	 * 文章管理
	 */
	public function articleOp(){
		$lang	= Language::getLangContent();
		$model_article = Model('article');
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
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_ARTICLE.DS.$v_upload['file_name']);
						}
					}
					$model_article->del($v);
				}
				$this->log(L('article_index_del_succ').'[ID:'.implode(',',$_POST['del_id']).']',null);
				showMessage($lang['article_index_del_succ']);
			}else {
				showMessage($lang['article_index_choose']);
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
		$article_list = $model_article->getArticleList($condition,$page);
		/**
		 * 整理列表内容
		 */
		if (is_array($article_list)){
			/**
			 * 取文章分类
			 */
			$model_class = Model('article_class');
			$class_list = $model_class->getClassList($condition);
			$tmp_class_name = array();
			if (is_array($class_list)){
				foreach ($class_list as $k => $v){
					$tmp_class_name[$v['ac_id']] = $v['ac_name'];
				}
			}

			foreach ($article_list as $k => $v){
				/**
				 * 发布时间
				 */
				$article_list[$k]['article_time'] = date('Y-m-d H:i:s',$v['article_time']);
				/**
				 * 所属分类
				 */
				if (@array_key_exists($v['ac_id'],$tmp_class_name)){
					$article_list[$k]['ac_name'] = $tmp_class_name[$v['ac_id']];
				}
			}
		}
		/**
		 * 分类列表
		 */
		$model_class = Model('article_class');
		$parent_list = $model_class->getTreeClassList(2);
		if (is_array($parent_list)){
			$unset_sign = false;
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['ac_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['ac_name'];
			}
		}

		Tpl::output('article_list',$article_list);
		Tpl::output('page',$page->show());
		Tpl::output('search_title',trim($_GET['search_title']));
		Tpl::output('search_ac_id',intval($_GET['search_ac_id']));
		Tpl::output('parent_list',$parent_list);
		Tpl::showpage('article.index');
	}

	/**
	 * 文章添加
	 */
	public function article_addOp(){
		$lang	= Language::getLangContent();
		$model_article = Model('article');
		/**
		 * 保存
		 */
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["article_title"], "require"=>"true", "message"=>$lang['article_add_title_null']),
				array("input"=>$_POST["ac_id"], "require"=>"true", "message"=>$lang['article_add_class_null']),
				//array("input"=>$_POST["article_url"], 'validator'=>'Url', "message"=>$lang['article_add_url_wrong']),
				array("input"=>$_POST["article_content"], "require"=>"true", "message"=>$lang['article_add_content_null']),
				array("input"=>$_POST["article_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['article_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$insert_array = array();
				$insert_array['article_title'] = trim($_POST['article_title']);
				$insert_array['ac_id'] = intval($_POST['ac_id']);
				$insert_array['article_url'] = trim($_POST['article_url']);
				$insert_array['article_show'] = trim($_POST['article_show']);
				$insert_array['article_sort'] = trim($_POST['article_sort']);
				$insert_array['article_content'] = trim($_POST['article_content']);
				$insert_array['article_time'] = time();
				$result = $model_article->add($insert_array);
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
							'url'=>'index.php?act=article&op=article',
							'msg'=>"{$lang['article_add_tolist']}",
						),
						array(
							'url'=>'index.php?act=article&op=article_add&ac_id='.intval($_POST['ac_id']),
							'msg'=>"{$lang['article_add_continueadd']}",
						),
					);
					$this->log(L('article_add_ok').'['.$_POST['article_title'].']',null);
					showMessage("{$lang['article_add_ok']}",$url);
				}else {
					showMessage("{$lang['article_add_fail']}");
				}
			}
		}
		/**
		 * 分类列表
		 */
		$model_class = Model('article_class');
		$parent_list = $model_class->getTreeClassList(2);
		if (is_array($parent_list)){
			$unset_sign = false;
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['ac_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['ac_name'];
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
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/'.$file_upload[$k]['file_name'];
			}
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('ac_id',intval($_GET['ac_id']));
		Tpl::output('parent_list',$parent_list);
		Tpl::output('file_upload',$file_upload);
		Tpl::showpage('article.add');
	}

	/**
	 * 文章编辑
	 */
	public function article_editOp(){
		$lang	 = Language::getLangContent();
		$model_article = Model('article');

		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["article_title"], "require"=>"true", "message"=>$lang['article_add_title_null']),
				array("input"=>$_POST["ac_id"], "require"=>"true", "message"=>$lang['article_add_class_null']),
				//array("input"=>$_POST["article_url"], 'validator'=>'Url', "message"=>$lang['article_add_url_wrong']),
				array("input"=>$_POST["article_content"], "require"=>"true", "message"=>$lang['article_add_content_null']),
				array("input"=>$_POST["article_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['article_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {

				$update_array = array();
				$update_array['article_id'] = intval($_POST['article_id']);
				$update_array['article_title'] = trim($_POST['article_title']);
				$update_array['ac_id'] = intval($_POST['ac_id']);
				$update_array['article_url'] = trim($_POST['article_url']);
				$update_array['article_show'] = trim($_POST['article_show']);
				$update_array['article_sort'] = trim($_POST['article_sort']);
				$update_array['article_content'] = trim($_POST['article_content']);

				$result = $model_article->update($update_array);
				if ($result){
					/**
					 * 更新图片信息ID
					 */
					$model_upload = Model('upload');
					if (is_array($_POST['file_id'])){
						foreach ($_POST['file_id'] as $k => $v){
							$update_array = array();
							$update_array['upload_id'] = intval($v);
							$update_array['item_id'] = intval($_POST['article_id']);
							$model_upload->update($update_array);
							unset($update_array);
						}
					}

					$url = array(
						array(
							'url'=>$_POST['ref_url'],
							'msg'=>$lang['article_edit_back_to_list'],
						),
						array(
							'url'=>'index.php?act=article&op=article_edit&article_id='.intval($_POST['article_id']),
							'msg'=>$lang['article_edit_edit_again'],
						),
					);
					$this->log(L('article_edit_succ').'['.$_POST['article_title'].']',null);
					showMessage($lang['article_edit_succ'],$url);
				}else {
					showMessage($lang['article_edit_fail']);
				}
			}
		}

		$article_array = $model_article->getOneArticle(intval($_GET['article_id']));
		if (empty($article_array)){
			showMessage($lang['param_error']);
		}
		/**
		 * 文章类别模型实例化
		 */
		$model_class = Model('article_class');
		/**
		 * 父类列表，只取到第一级
		 */
		$parent_list = $model_class->getTreeClassList(2);
		if (is_array($parent_list)){
			$unset_sign = false;
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['ac_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['ac_name'];
			}
		}
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$condition['upload_type'] = '1';
		$condition['item_id'] = $article_array['article_id'];
		$file_upload = $model_upload->getUploadList($condition);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/'.$file_upload[$k]['file_name'];
			}
		}

		Tpl::output('PHPSESSID',session_id());
		Tpl::output('file_upload',$file_upload);
		Tpl::output('parent_list',$parent_list);
		Tpl::output('article_array',$article_array);
		Tpl::showpage('article.edit');
	}
	/**
	 * 文章图片上传
	 */
	public function article_pic_uploadOp(){
		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_ARTICLE);
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
		$insert_array['upload_type'] = '1';
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
			 * 删除文章图片
			 */
			case 'del_file_upload':
				if (intval($_GET['file_id']) > 0){
					$model_upload = Model('upload');
					/**
					 * 删除图片
					 */
					$file_array = $model_upload->getOneUpload(intval($_GET['file_id']));
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_ARTICLE.DS.$file_array['file_name']);
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
