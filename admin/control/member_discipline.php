<?php
/**


^^^^^^^^^^^^^^^^^^^^^^^^^^^^

 */
defined('InShopNC') or exit('Access Invalid!');
class member_disciplineControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('member_discipline');
		if($GLOBALS['setting_config']['flea_isuse']!='1'){
			showMessage(Language::get('flea_isuse_off_tips'),'index.php?act=dashboard&op=welcome');
		}
	}
	public function indexOp(){
		$this->member_disciplineOp();
	}
	public function goods_classOp(){
		$this->member_disciplineOp();
	}
	/**
	 * 学科管理
	 */
	public function member_disciplineOp(){
		$lang	= Language::getLangContent();
		$model_discipline = Model('member_discipline');
		/**
		 * 删除,编辑
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 删除
			 */
			if ($_POST['submit_type'] == 'del'){
				if (!empty($_POST['check_discipline_id'])){
					if (is_array($_POST['check_discipline_id'])){
						$del_array = $model_discipline->getChildClass($_POST['check_discipline_id']);
						if (is_array($del_array)){
							foreach ($del_array as $k => $v){
								$model_discipline->del($v['discipline_id']);
							}
						}
					}
					showMessage($lang['discipline_index_del_succ']);
				}else {
					showMessage($lang['discipline_index_choose_del']);
				}
			}
			/**
			 * 编辑
			 */
			if ($_POST['submit_type'] == 'brach_edit'){
				if (!empty($_POST['check_discipline_id'])){
					Tpl::output('id',implode(',',$_POST['check_discipline_id']));
					Tpl::showpage('flea_class.brach_edit');
				}else {
					showMessage($lang['discipline_index_choose_edit']);
				}
			}
		}
		/**
		 * 父ID
		 */
		$parent_id = $_GET['discipline_parent_id']?$_GET['discipline_parent_id']:0;
		/**
		 * 列表
		 */
		$tmp_list = $model_discipline->getTreedisciplineList(4);
		if (is_array($tmp_list)){
			foreach ($tmp_list as $k => $v){
				if ($v['discipline_parent_id'] == $parent_id){
					/**
					 * 判断是否有子类
					 */
					if ($tmp_list[$k+1]['deep'] > $v['deep']){
						$v['have_child'] = 1;
					}
					$discipline_list[] = $v;
				}
			}
		}
		if ($_GET['ajax'] == '1'){
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$discipline_list = Language::getUTF8($discipline_list);
			}
			$output = json_encode($discipline_list);
			print_r($output);
			exit;
		}else {
			Tpl::output('discipline_list',$discipline_list);
			Tpl::showpage('member_discipline.index');
		}
	}
	
	/**
	 * 商品学科添加
	 */
	public function member_discipline_addOp(){
		$lang	= Language::getLangContent();
		$model_discipline = Model('member_discipline');
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["discipline_name"], "require"=>"true", "message"=>$lang['discipline_add_name_null']),
				array("input"=>$_POST["discipline_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['discipline_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				
				$insert_array = array();
				$insert_array['discipline_name'] = $_POST['discipline_name'];
				$insert_array['discipline_parent_id'] = $_POST['discipline_parent_id'];
				$insert_array['discipline_sort'] = $_POST['discipline_sort'];
				$insert_array['discipline_show'] = $_POST['discipline_show'];
				
				$result = $model_discipline->add($insert_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=member_discipline&op=member_discipline_add&discipline_parent_id='.$_POST['discipline_parent_id'],
							'msg'=>$lang['discipline_add_again'],
						),
						array(
							'url'=>'index.php?act=member_discipline&op=member_discipline',
							'msg'=>$lang['discipline_add_back_to_list'],
						)
					);
					showMessage($lang['discipline_add_succ'],$url);
				}else {
					showMessage($lang['discipline_add_fail']);
				}
			}
		}
		/**
		 * 父类列表，只取到第三级
		 */
		$parent_list = $model_discipline->getTreedisciplineList(3);
		if (is_array($parent_list)){
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['discipline_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['discipline_name'];
			}
		}
		
		Tpl::output('discipline_parent_id',$_GET['discipline_parent_id']);
		Tpl::output('parent_list',$parent_list);
		Tpl::showpage('member_discipline.add');
	}
	
	/**
	 * 编辑
	 */
	public function member_discipline_editOp(){
		$lang	= Language::getLangContent();
		$model_discipline = Model('member_discipline');
		
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["discipline_name"], "require"=>"true", "message"=>$lang['discipline_add_name_null']),
				array("input"=>$_POST["discipline_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['discipline_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				
				$update_array = array();
				$update_array['discipline_id'] = $_POST['discipline_id'];
				$update_array['discipline_name'] = $_POST['discipline_name'];
				$update_array['discipline_parent_id'] = $_POST['discipline_parent_id'];
				$update_array['discipline_sort'] = $_POST['discipline_sort'];
				$update_array['discipline_show'] = $_POST['discipline_show'];
				
				$result = $model_discipline->update($update_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=member_discipline&op=member_discipline_edit&discipline_id='.$_POST['discipline_id'],
							'msg'=>$lang['discipline_batch_edit_again'],
						),
						array(
							'url'=>'index.php?act=member_discipline&op=member_discipline',
							'msg'=>$lang['discipline_add_back_to_list'],
						)
					);
					showMessage($lang['discipline_batch_edit_ok'],$url);
				}else {
					showMessage($lang['discipline_batch_edit_fail']);
				}
			}
		}
				
		$discipline_array = $model_discipline->getOnedisciplineClass($_GET['discipline_id']);
		if (empty($discipline_array)){
			showMessage($lang['discipline_batch_edit_paramerror']);
		}

		/**
		 * 父类列表，只取到第三级
		 */
		$parent_list = $model_discipline->getTreedisciplineList(3);
		if (is_array($parent_list)){
			$unset_sign = false;
			foreach ($parent_list as $k => $v){
				if ($v['discipline_id'] == $discipline_array['discipline_id']){
					$deep = $v['deep'];
					$unset_sign = true;
				}
				if ($unset_sign == true){
					if ($v['deep'] == $deep && $v['discipline_id'] != $discipline_array['discipline_id']){
						$unset_sign = false;
					}
					if ($v['deep'] > $deep || $v['discipline_id'] == $discipline_array['discipline_id']){
						unset($parent_list[$k]);
					}
				}else {
					$parent_list[$k]['discipline_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['discipline_name'];
				}
			}
		}
		
		Tpl::output('parent_list',$parent_list);
		Tpl::output('discipline_array',$discipline_array);
		Tpl::showpage('member_discipline.edit');
	}

	
	/**
	 * 删除学科
	 */
	public function member_discipline_delOp(){
		$lang	= Language::getLangContent();
		$model_discipline = Model('member_discipline');
		if (intval($_GET['discipline_id']) > 0){
			/**
			 * 删除学科
			 */
			$model_discipline->del($_GET['discipline_id']);
			showMessage($lang['discipline_index_del_succ'],'index.php?act=member_discipline&op=member_discipline');
		}else {
			showMessage($lang['discipline_index_choose_del'],'index.php?act=member_discipline&op=member_discipline');
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
			case 'discipline_name':
				$model_discipline = Model('member_discipline');
				$discipline_array = $model_discipline->getOnedisciplineClass($_GET['id']);
				
				$condition['discipline_name'] = $_GET['value'];
				$condition['discipline_parent_id'] = $discipline_array['discipline_parent_id'];
				$condition['no_discipline_id'] = $_GET['id'];
				$discipline_list = $model_discipline->getClassList($condition);
				if (empty($discipline_list)){
					$update_array = array();
					$update_array['discipline_id'] = $_GET['id'];
					$update_array['discipline_name'] = $_GET['value'];
					$model_discipline->update($update_array);
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
			/**
			 * 学科 排序 显示 设置
			 */
			case 'discipline_sort':
			case 'discipline_show':
				$model_discipline = Model('member_discipline');
				$update_array = array();
				$update_array['discipline_id'] = $_GET['id'];
				$update_array[$_GET['column']] = $_GET['value'];
				$model_discipline->update($update_array);
				echo 'true';exit;
				break;
			/**
			 * 添加、修改操作中 检测类别名称是否有重复
			 */
			case 'check_discipline_name':
				$model_discipline = Model('member_discipline');
				$condition['discipline_name'] = $_GET['discipline_name'];
				$condition['discipline_parent_id'] = $_GET['discipline_parent_id'];
				$condition['no_discipline_id'] = $_GET['discipline_id'];
				$discipline_list = $model_discipline->getClassList($condition);
				if (empty($discipline_list)){
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
		}
	}
	
}