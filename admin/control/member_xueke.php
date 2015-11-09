<?php
/**


^^^^^^^^^^^^^^^^^^^^^^^^^^^^

 */
defined('InShopNC') or exit('Access Invalid!');
class member_xuekeControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('member_xueke');
		if($GLOBALS['setting_config']['flea_isuse']!='1'){
			showMessage(Language::get('flea_isuse_off_tips'),'index.php?act=dashboard&op=welcome');
		}
	}
	public function indexOp(){
		$this->member_xuekeOp();
	}
	public function goods_classOp(){
		$this->member_xuekeOp();
	}
	/**
	 * 学科管理
	 */
	public function member_xuekeOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('member_xueke');
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
					showMessage($lang['goods_class_index_del_succ']);
				}else {
					showMessage($lang['goods_class_index_choose_del']);
				}
			}
			/**
			 * 编辑
			 */
			if ($_POST['submit_type'] == 'brach_edit'){
				if (!empty($_POST['check_gc_id'])){
					Tpl::output('id',implode(',',$_POST['check_gc_id']));
					Tpl::showpage('flea_class.brach_edit');
				}else {
					showMessage($lang['goods_class_index_choose_edit']);
				}
			}
			/**
			 * 手机端显示
			 */
			if($_POST['submit_type'] == 'index_show' or $_POST['submit_type'] == 'index_hide'){
				if (!empty($_POST['check_gc_id'])){
					if (is_array($_POST['check_gc_id'])){
						$param	= array();
						$param['gc_index_show']	= $_POST['submit_type'] == 'index_show'?'1':'0';
						foreach ($_POST['check_gc_id'] as $k=>$v){
							$param['gc_id']	= $v;
							$model_class->update($param);
						}
					}
					showMessage($lang['goods_class_index_in_homepage'].($_POST['submit_type'] == 'index_show'?$lang['goods_class_index_display']:$lang['goods_class_index_hide']).$lang['goods_class_index_succ']);
				}else {
					showMessage($lang['goods_class_index_choose_in_homepage'].($_POST['submit_type'] == 'index_show'?$lang['goods_class_index_display']:$lang['goods_class_index_hide']).$lang['goods_class_index_content']);
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
			Tpl::showpage('member_xueke.index');
		}
	}
	
	/**
	 * 保存批量修改学科
	 */
	public function brach_edit_saveOp(){
		$lang	= Language::getLangContent();
		if ($_POST['gc_show'] == '-1'){
			showMessage($lang['goods_class_batch_edit_succ'],'index.php?act=member_xueke&op=member_xueke');
		}
		if ($_POST['form_submit'] == 'ok'){
			$model_class = Model('member_xueke');
			
			$array = explode(',',$_POST['id']);
			if (is_array($array)){
				foreach ($array as $k => $v){
					$update_array = array();
					$update_array['gc_id'] = $v;
					$update_array['gc_show'] = $_POST['gc_show'];
					
					$model_class->update($update_array);
				}
				showMessage($lang['goods_class_batch_edit_succ']);
			}else {
				showMessage($lang['goods_class_batch_edit_wrong_content']);
			}
		}else {
			showMessage($lang['goods_class_batch_edit_wrong_content']);
		}
	}
	/**
	 * 商品学科添加
	 */
	public function member_xueke_addOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('member_xueke');
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["gc_name"], "require"=>"true", "message"=>$lang['goods_class_add_name_null']),
				array("input"=>$_POST["gc_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['goods_class_add_sort_int']),
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
				$insert_array['gc_index_show'] = $_POST['gc_index_show'];
				
				$result = $model_class->add($insert_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=member_xueke&op=member_xueke_add&gc_parent_id='.$_POST['gc_parent_id'],
							'msg'=>$lang['goods_class_add_again'],
						),
						array(
							'url'=>'index.php?act=member_xueke&op=member_xueke',
							'msg'=>$lang['goods_class_add_back_to_list'],
						)
					);
					showMessage($lang['goods_class_add_succ'],$url);
				}else {
					showMessage($lang['goods_class_add_fail']);
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
		Tpl::showpage('member_xueke.add');
	}
	
	/**
	 * 编辑
	 */
	public function member_class_editOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('member_xueke');
		
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["gc_name"], "require"=>"true", "message"=>$lang['goods_class_add_name_null']),
				array("input"=>$_POST["gc_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['goods_class_add_sort_int']),
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
				$update_array['gc_index_show'] = $_POST['gc_index_show'];
				
				$result = $model_class->update($update_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=member_xueke&op=member_class_edit&gc_id='.$_POST['gc_id'],
							'msg'=>$lang['goods_class_batch_edit_again'],
						),
						array(
							'url'=>'index.php?act=member_xueke&op=member_xueke',
							'msg'=>$lang['goods_class_add_back_to_list'],
						)
					);
					showMessage($lang['goods_class_batch_edit_ok'],$url);
				}else {
					showMessage($lang['goods_class_batch_edit_fail']);
				}
			}
		}
				
		$class_array = $model_class->getOneGoodsClass($_GET['gc_id']);
		if (empty($class_array)){
			showMessage($lang['goods_class_batch_edit_paramerror']);
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
		Tpl::showpage('member_xueke.edit');
	}

	
	/**
	 * 删除学科
	 */
	public function member_xueke_delOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('member_xueke');
		if (intval($_GET['gc_id']) > 0){
			/**
			 * 删除学科
			 */
			$model_class->del($_GET['gc_id']);
			showMessage($lang['goods_class_index_del_succ'],'index.php?act=member_xueke&op=member_xueke');
		}else {
			showMessage($lang['goods_class_index_choose_del'],'index.php?act=member_xueke&op=member_xueke');
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
			case 'goods_class_name':
				$model_class = Model('member_xueke');
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
			 * 学科 排序 显示 设置
			 */
			case 'goods_class_sort':
			case 'goods_class_show':
			case 'goods_class_index_show':
				$model_class = Model('member_xueke');
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
				$model_class = Model('member_xueke');
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