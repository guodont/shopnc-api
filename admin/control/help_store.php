<?php
/**
 * 店铺帮助管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class help_storeControl extends SystemControl{
	public function __construct(){
		parent::__construct();
	}

	/**
	 * 帮助列表
	 */
	public function help_storeOp() {
		$model_help = Model('help');
		$condition = array();
		$condition['help_id'] = array('gt','99');//内容列表不显示系统自动添加的数据
		if (trim($_GET['key']) != '') {
			$condition['help_title'] = array('like','%'.$_GET['key'].'%');
		}
		$type_id = intval($_GET['type_id']);
		if ($type_id > 0) {
			$condition['type_id'] = $type_id;
		}
		$help_list = $model_help->getStoreHelpList($condition,10);
		Tpl::output('help_list',$help_list);
		Tpl::output('show_page',$model_help->showpage());

		$type_list = $model_help->getStoreHelpTypeList();
		Tpl::output('type_list',$type_list);

		Tpl::showpage('help_store.list');
	}

	/**
	 * 帮助类型
	 */
	public function help_typeOp() {
		$model_help = Model('help');
		$condition = array();

		$type_list = $model_help->getStoreHelpTypeList($condition,10);
		Tpl::output('type_list',$type_list);
		Tpl::output('show_page',$model_help->showpage());

		Tpl::showpage('help_store_type.list');
	}

	/**
	 * 新增帮助
	 *
	 */
	public function add_helpOp() {
		$model_help = Model('help');
		if (chksubmit()) {
		    $help_array = array();
		    $help_array['help_title'] = $_POST['help_title'];
		    $help_array['help_url'] = $_POST['help_url'];
		    $help_array['help_info'] = $_POST['content'];
		    $help_array['help_sort'] = intval($_POST['help_sort']);
		    $help_array['type_id'] = intval($_POST['type_id']);
		    $help_array['update_time'] = time();
		    $help_array['page_show'] = '1';//页面类型:1为店铺,2为会员
		    $state = $model_help->addHelp($help_array);
			if ($state) {
			    if (!empty($_POST['file_id']) && is_array($_POST['file_id'])){
			        $model_help->editHelpPic($state, $_POST['file_id']);
			    }
			    $this->log('新增店铺帮助，编号'.$state);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=help_store&op=help_store');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		$type_list = $model_help->getStoreHelpTypeList();
		Tpl::output('type_list',$type_list);
		$condition = array();
		$condition['item_id'] = '0';
		$pic_list = $model_help->getHelpPicList($condition);
		Tpl::output('pic_list',$pic_list);
	    Tpl::showpage('help_store.add');
	}

	/**
	 * 编辑帮助
	 *
	 */
	public function edit_helpOp() {
		$model_help = Model('help');
		$condition = array();
		$help_id = intval($_GET['help_id']);
		$condition['help_id'] = $help_id;
		$help_list = $model_help->getStoreHelpList($condition);
		$help = $help_list[0];
		Tpl::output('help',$help);
		if (chksubmit()) {
		    $help_array = array();
		    $help_array['help_title'] = $_POST['help_title'];
		    $help_array['help_url'] = $_POST['help_url'];
		    $help_array['help_info'] = $_POST['content'];
		    $help_array['help_sort'] = intval($_POST['help_sort']);
		    $help_array['type_id'] = intval($_POST['type_id']);
		    $help_array['update_time'] = time();
		    $state = $model_help->editHelp($condition, $help_array);
			if ($state) {
			    $this->log('编辑店铺帮助，编号'.$help_id);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=help_store&op=help_store');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		$type_list = $model_help->getStoreHelpTypeList();
		Tpl::output('type_list',$type_list);
		$condition = array();
		$condition['item_id'] = $help_id;
		$pic_list = $model_help->getHelpPicList($condition);
		Tpl::output('pic_list',$pic_list);
	    Tpl::showpage('help_store.edit');
	}

	/**
	 * 删除帮助
	 *
	 */
	public function del_helpOp() {
		$model_help = Model('help');
		$condition = array();
		$condition['help_id'] = intval($_GET['help_id']);
		$state = $model_help->delHelp($condition,array($condition['help_id']));
		if ($state) {
		    $this->log('删除店铺帮助，编号'.$condition['help_id']);
		    showMessage(Language::get('nc_common_del_succ'),'index.php?act=help_store&op=help_store');
		} else {
		    showMessage(Language::get('nc_common_del_fail'));
		}
	}

	/**
	 * 新增帮助类型
	 *
	 */
	public function add_typeOp() {
		$model_help = Model('help');
		if (chksubmit()) {
		    $type_array = array();
		    $type_array['type_name'] = $_POST['type_name'];
		    $type_array['type_sort'] = intval($_POST['type_sort']);
		    $type_array['help_show'] = intval($_POST['help_show']);//是否显示,0为否,1为是
		    $type_array['page_show'] = '1';//页面类型:1为店铺,2为会员

		    $state = $model_help->addHelpType($type_array);
			if ($state) {
			    $this->log('新增店铺帮助类型，编号'.$state);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=help_store&op=help_type');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::showpage('help_store_type.add');
	}

	/**
	 * 编辑帮助类型
	 *
	 */
	public function edit_typeOp() {
		$model_help = Model('help');
		$condition = array();
		$condition['type_id'] = intval($_GET['type_id']);
		$type_list = $model_help->getHelpTypeList($condition);
		$type = $type_list[0];
		if (chksubmit()) {
		    $type_array = array();
		    $type_array['type_name'] = $_POST['type_name'];
		    $type_array['type_sort'] = intval($_POST['type_sort']);
		    $type_array['help_show'] = intval($_POST['help_show']);//是否显示,0为否,1为是
			$state = $model_help->editHelpType($condition, $type_array);
			if ($state) {
			    $this->log('编辑店铺帮助类型，编号'.$condition['type_id']);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=help_store&op=help_type');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::output('type',$type);
		Tpl::showpage('help_store_type.edit');
	}

	/**
	 * 删除帮助类型
	 *
	 */
	public function del_typeOp() {
		$model_help = Model('help');
		$condition = array();
		$condition['type_id'] = intval($_GET['type_id']);
		$state = $model_help->delHelpType($condition);
		if ($state) {
		    $this->log('删除店铺帮助类型，编号'.$condition['type_id']);
		    showMessage(Language::get('nc_common_del_succ'),'index.php?act=help_store&op=help_type');
		} else {
		    showMessage(Language::get('nc_common_del_fail'));
		}
	}

	/**
	 * 上传图片
	 */
	public function upload_picOp() {
	    $data = array();
		if (!empty($_FILES['fileupload']['name'])) {//上传图片
		    $fprefix = 'help_store';
			$upload = new UploadFile();
			$upload->set('default_dir',ATTACH_ARTICLE);
			$upload->set('fprefix',$fprefix);
			$upload->upfile('fileupload');
		    $model_upload = Model('upload');
		    $file_name = $upload->file_name;
		    $insert_array = array();
		    $insert_array['file_name'] = $file_name;
		    $insert_array['file_size'] = $_FILES['fileupload']['size'];
		    $insert_array['upload_time'] = time();
		    $insert_array['item_id'] = intval($_GET['item_id']);
		    $insert_array['upload_type'] = '2';
		    $result = $model_upload->add($insert_array);
			if ($result) {
			    $data['file_id'] = $result;
			    $data['file_name'] = $file_name;
			}
		}
	    echo json_encode($data);exit;
	}

	/**
	 * 删除图片
	 */
	public function del_picOp() {
		$condition = array();
		$condition['upload_id'] = intval($_GET['file_id']);
	    $model_help = Model('help');
	    $state = $model_help->delHelpPic($condition);
		if ($state) {
		    echo 'true';exit;
		} else {
		    echo 'false';exit;
		}
	}
}
