<?php
/**


^^^^^^^^^^^^^^^^^^^^^^^^^^^^

 */
defined('InShopNC') or exit('Access Invalid!');
class resources_classcontrol extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('resources_class');
		if($GLOBALS['setting_config']['flea_isuse']!='1'){
			showMessage(Language::get('flea_isuse_off_tips'),'index.php?act=dashboard&op=welcome');
		}
	}
	public function indexOp(){
		$this->resources_classOp();
	}

	/**
	 * 分类管理
	 */
	public function resources_classOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('resources_class');
		/**
		 * 删除,编辑
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 删除
			 */
			if ($_POST['submit_type'] == 'del'){
				if (!empty($_POST['check_gc_id'])){
					if (is_array($_POST['check_gc_id'])){
						$del_array = $model_class->getChildClass($_POST['check_gc_id']);
						if (is_array($del_array)){
							foreach ($del_array as $k => $v){
								$model_class->del($v['gc_id']);
							}
						}
					}
					showMessage($lang['resources_class_index_del_succ']);
				}else {
					showMessage($lang['resources_class_index_choose_del']);
				}
			}
			/**
			 * 编辑
			 */
			if ($_POST['submit_type'] == 'brach_edit'){
				if (!empty($_POST['check_gc_id'])){
					Tpl::output('id',implode(',',$_POST['check_gc_id']));
					Tpl::showpage('resources_class.brach_edit');
				}else {
					showMessage($lang['resources_class_index_choose_edit']);
				}
			}
		}
		/**
		 * 父ID
		 */
		$parent_id = $_GET['gc_parent_id']?$_GET['gc_parent_id']:0;
		/**
		 * 列表
		 */
		$tmp_list = $model_class->getTreeClassList(4);
		if (is_array($tmp_list)){
			foreach ($tmp_list as $k => $v){
				if ($v['gc_parent_id'] == $parent_id){
					/**
					 * 判断是否有子类
					 */
					if ($tmp_list[$k+1]['deep'] > $v['deep']){
						$v['have_child'] = 1;
					}
					$class_list[] = $v;
				}
			}
		}
		if ($_GET['ajax'] == '1'){
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$class_list = Language::getUTF8($class_list);
			}
			$output = json_encode($class_list);
			print_r($output);
			exit;
		}else {
			Tpl::output('class_list',$class_list);
			Tpl::showpage('resources_class.index');
		}
	}
	
	/**
	 * 保存批量修改分类
	 */
	public function brach_edit_saveOp(){
		$lang	= Language::getLangContent();
		if ($_POST['gc_show'] == '-1'){
			showMessage($lang['resources_class_batch_edit_succ'],'index.php?act=resources_class&op=resources_class');
		}
		if ($_POST['form_submit'] == 'ok'){
			$model_class = Model('resources_class');
			
			$array = explode(',',$_POST['id']);
			if (is_array($array)){
				foreach ($array as $k => $v){
					$update_array = array();
					$update_array['gc_id'] = $v;
					$update_array['gc_show'] = $_POST['gc_show'];
					
					$model_class->update($update_array);
				}
				showMessage($lang['resources_class_batch_edit_succ']);
			}else {
				showMessage($lang['resources_class_batch_edit_wrong_content']);
			}
		}else {
			showMessage($lang['resources_class_batch_edit_wrong_content']);
		}
	}
	/**
	 * 分类添加
	 */
	public function resources_class_addOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('resources_class');
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["gc_name"], "require"=>"true", "message"=>$lang['resources_class_add_name_null']),
				array("input"=>$_POST["gc_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['resources_class_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				
				$insert_array = array();
				$insert_array['gc_name'] = $_POST['gc_name'];
				$insert_array['gc_parent_id'] = $_POST['gc_parent_id'];
				$insert_array['gc_sort'] = $_POST['gc_sort'];
				$insert_array['gc_show'] = $_POST['gc_show'];		
				$result = $model_class->add($insert_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=resources_class&op=resources_class_add&gc_parent_id='.$_POST['gc_parent_id'],
							'msg'=>$lang['resources_class_add_again'],
						),
						array(
							'url'=>'index.php?act=resources_class&op=resources_class',
							'msg'=>$lang['resources_class_add_back_to_list'],
						)
					);
					showMessage($lang['resources_class_add_succ'],$url);
				}else {
					showMessage($lang['resources_class_add_fail']);
				}
			}
		}
		/**
		 * 父类列表，只取到第三级
		 */
		$parent_list = $model_class->getTreeClassList(3);
		if (is_array($parent_list)){
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['gc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['gc_name'];
			}
		}
		
		Tpl::output('gc_parent_id',$_GET['gc_parent_id']);
		Tpl::output('parent_list',$parent_list);
		Tpl::showpage('resources_class.add');
	}
	
	/**
	 * 编辑
	 */
	public function resources_class_editOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('resources_class');
		
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["gc_name"], "require"=>"true", "message"=>$lang['resources_class_add_name_null']),
				array("input"=>$_POST["gc_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['resources_class_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				
				$update_array = array();
				$update_array['gc_id'] = $_POST['gc_id'];
				$update_array['gc_name'] = $_POST['gc_name'];
				$update_array['gc_parent_id'] = $_POST['gc_parent_id'];
				$update_array['gc_sort'] = $_POST['gc_sort'];
				$update_array['gc_show'] = $_POST['gc_show'];				
				$result = $model_class->update($update_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=resources_class&op=resources_class_edit&gc_id='.$_POST['gc_id'],
							'msg'=>$lang['resources_class_batch_edit_again'],
						),
						array(
							'url'=>'index.php?act=resources_class&op=resources_class',
							'msg'=>$lang['resources_class_add_back_to_list'],
						)
					);
					showMessage($lang['resources_class_batch_edit_ok'],$url);
				}else {
					showMessage($lang['resources_class_batch_edit_fail']);
				}
			}
		}
				
		$class_array = $model_class->getOneGoodsClass($_GET['gc_id']);
		if (empty($class_array)){
			showMessage($lang['resources_class_batch_edit_paramerror']);
		}

		/**
		 * 父类列表，只取到第三级
		 */
		$parent_list = $model_class->getTreeClassList(3);
		if (is_array($parent_list)){
			$unset_sign = false;
			foreach ($parent_list as $k => $v){
				if ($v['gc_id'] == $class_array['gc_id']){
					$deep = $v['deep'];
					$unset_sign = true;
				}
				if ($unset_sign == true){
					if ($v['deep'] == $deep && $v['gc_id'] != $class_array['gc_id']){
						$unset_sign = false;
					}
					if ($v['deep'] > $deep || $v['gc_id'] == $class_array['gc_id']){
						unset($parent_list[$k]);
					}
				}else {
					$parent_list[$k]['gc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['gc_name'];
				}
			}
		}
		
		Tpl::output('parent_list',$parent_list);
		Tpl::output('class_array',$class_array);
		Tpl::showpage('resources_class.edit');
	}
	
	
	/**
	 * 删除分类
	 */
	public function resources_class_delOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('resources_class');
		if (intval($_GET['gc_id']) > 0){
			/**
			 * 删除分类
			 */
			$model_class->del($_GET['gc_id']);
			showMessage($lang['resources_class_index_del_succ'],'index.php?act=resources_class&op=resources_class');
		}else {
			showMessage($lang['resources_class_index_choose_del'],'index.php?act=resources_class&op=resources_class');
		}
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 验证是否有重复的名称
			 */
			case 'resources_class_name':
				$model_class = Model('resources_class');
				$class_array = $model_class->getOneGoodsClass($_GET['id']);
				
				$condition['gc_name'] = $_GET['value'];
				$condition['gc_parent_id'] = $class_array['gc_parent_id'];
				$condition['no_gc_id'] = $_GET['id'];
				$class_list = $model_class->getClassList($condition);
				if (empty($class_list)){
					$update_array = array();
					$update_array['gc_id'] = $_GET['id'];
					$update_array['gc_name'] = $_GET['value'];
					$model_class->update($update_array);
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
			/**
			 * 分类 排序 显示 设置
			 */
			case 'resources_class_sort':
			case 'resources_class_show':
			case 'resources_class_index_show':
				$model_class = Model('resources_class');
				$update_array = array();
				$update_array['gc_id'] = $_GET['id'];
				$update_array[$_GET['column']] = $_GET['value'];
				$model_class->update($update_array);
				echo 'true';exit;
				break;
			/**
			 * 添加、修改操作中 检测类别名称是否有重复
			 */
			case 'check_class_name':
				$model_class = Model('resources_class');
				$condition['gc_name'] = $_GET['gc_name'];
				$condition['gc_parent_id'] = $_GET['gc_parent_id'];
				$condition['no_gc_id'] = $_GET['gc_id'];
				$class_list = $model_class->getClassList($condition);
				if (empty($class_list)){
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
		}
	}
	
}