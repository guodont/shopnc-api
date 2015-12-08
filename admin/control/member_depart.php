<?php
/**


^^^^^^^^^^^^^^^^^^^^^^^^^^^^

 */
defined('InShopNC') or exit('Access Invalid!');
class member_departControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('member_depart');

	}
	public function indexOp(){
		$this->member_departOp();
	}

	/**
	 * 单位管理
	 */
	public function member_departOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('member_depart');
		/**
		 * 删除,编辑
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 删除
			 */
			if ($_POST['submit_type'] == 'del'){
				if (!empty($_POST['check_depart_id'])){
					if (is_array($_POST['check_depart_id'])){
						$del_array = $model_class->getChildClass($_POST['check_depart_id']);
						if (is_array($del_array)){
							foreach ($del_array as $k => $v){
								$model_class->del($v['depart_id']);
							}
						}
					}
					showMessage($lang['member_depart_index_del_succ']);
				}else {
					showMessage($lang['member_depart_index_choose_del']);
				}
			}
			/**
			 * 编辑
			 */
			if ($_POST['submit_type'] == 'brach_edit'){
				if (!empty($_POST['check_depart_id'])){
					Tpl::output('id',implode(',',$_POST['check_depart_id']));
					Tpl::showpage('member_depart.brach_edit');
				}else {
					showMessage($lang['member_depart_index_choose_edit']);
				}
			}
			/**
			 * 开放管理
			 */
			if($_POST['submit_type'] == 'index_show' or $_POST['submit_type'] == 'index_hide'){
				if (!empty($_POST['check_depart_id'])){
					if (is_array($_POST['check_depart_id'])){
						$param	= array();
						$param['depart_manage']	= $_POST['submit_type'] == 'index_show'?'1':'0';
						foreach ($_POST['check_depart_id'] as $k=>$v){
							$param['depart_id']	= $v;
							$model_class->update($param);
						}
					}
					showMessage($lang['member_depart_index_in_homepage'].($_POST['submit_type'] == 'index_show'?$lang['member_depart_index_display']:$lang['member_depart_index_hide']).$lang['member_depart_index_succ']);
				}else {
					showMessage($lang['member_depart_index_choose_in_homepage'].($_POST['submit_type'] == 'index_show'?$lang['member_depart_index_display']:$lang['member_depart_index_hide']).$lang['member_depart_index_content']);
				}
			}
		}
		/**
		 * 父ID
		 */
		$parent_id = $_GET['depart_parent_id']?$_GET['depart_parent_id']:0;
		/**
		 * 列表
		 */
		$tmp_list = $model_class->getTreedepartList(4);
		if (is_array($tmp_list)){
			foreach ($tmp_list as $k => $v){
				if ($v['depart_parent_id'] == $parent_id){
					/**
					 * 判断是否有子类
					 */
					if ($tmp_list[$k+1]['deep'] > $v['deep']){
						$v['have_child'] = 1;
					}
					$depart_list[] = $v;
				}
			}
		}
		if ($_GET['ajax'] == '1'){
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$depart_list = Language::getUTF8($depart_list);
			}
			$output = json_encode($depart_list);
			print_r($output);
			exit;
		}else {
			Tpl::output('depart_list',$depart_list);
			Tpl::showpage('member_depart.index');
		}
	}
	
	/**
	 * 保存批量修改单位
	 */
	public function brach_edit_saveOp(){
		$lang	= Language::getLangContent();
		if ($_POST['depart_show'] == '-1'){
			showMessage($lang['member_depart_batch_edit_succ'],'index.php?act=member_depart&op=member_depart');
		}
		if ($_POST['form_submit'] == 'ok'){
			$model_class = Model('member_depart');
			
			$array = explode(',',$_POST['id']);
			if (is_array($array)){
				foreach ($array as $k => $v){
					$update_array = array();
					$update_array['depart_id'] = $v;
					$update_array['depart_show'] = $_POST['depart_show'];
					
					$model_class->update($update_array);
				}
				showMessage($lang['member_depart_batch_edit_succ']);
			}else {
				showMessage($lang['member_depart_batch_edit_wrong_content']);
			}
		}else {
			showMessage($lang['member_depart_batch_edit_wrong_content']);
		}
	}
	/**
	 * 商品单位添加
	 */
	public function member_depart_addOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('member_depart');
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["depart_name"], "require"=>"true", "message"=>$lang['member_depart_add_name_null']),
				array("input"=>$_POST["depart_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['member_depart_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				
				$insert_array = array();
				$insert_array['depart_name'] = $_POST['depart_name'];
				$insert_array['depart_parent_id'] = $_POST['depart_parent_id'];
				$insert_array['depart_sort'] = $_POST['depart_sort'];
				$insert_array['depart_show'] = $_POST['depart_show'];
				$insert_array['depart_manage'] = $_POST['depart_manage'];
				
				$result = $model_class->add($insert_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=member_depart&op=member_depart_add&depart_parent_id='.$_POST['depart_parent_id'],
							'msg'=>$lang['member_depart_add_again'],
						),
						array(
							'url'=>'index.php?act=member_depart&op=member_depart',
							'msg'=>$lang['member_depart_add_back_to_list'],
						)
					);
					showMessage($lang['member_depart_add_succ'],$url);
				}else {
					showMessage($lang['member_depart_add_fail']);
				}
			}
		}
		/**
		 * 父类列表，只取到第三级
		 */
		$parent_list = $model_class->getTreedepartList(3);
		if (is_array($parent_list)){
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['depart_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['depart_name'];
			}
		}
		
		Tpl::output('depart_parent_id',$_GET['depart_parent_id']);
		Tpl::output('parent_list',$parent_list);
		Tpl::showpage('member_depart.add');
	}
	
	/**
	 * 编辑
	 */
	public function member_class_editOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('member_depart');
		
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["depart_name"], "require"=>"true", "message"=>$lang['member_depart_add_name_null']),
				array("input"=>$_POST["depart_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['member_depart_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				
				$update_array = array();
				$update_array['depart_id'] = $_POST['depart_id'];
				$update_array['depart_name'] = $_POST['depart_name'];
				$update_array['depart_parent_id'] = $_POST['depart_parent_id'];
				$update_array['depart_sort'] = $_POST['depart_sort'];
				$update_array['depart_show'] = $_POST['depart_show'];
				$update_array['depart_manage'] = $_POST['depart_manage'];
				
				$result = $model_class->update($update_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=member_depart&op=member_class_edit&depart_id='.$_POST['depart_id'],
							'msg'=>$lang['member_depart_batch_edit_again'],
						),
						array(
							'url'=>'index.php?act=member_depart&op=member_depart',
							'msg'=>$lang['member_depart_add_back_to_list'],
						)
					);
					showMessage($lang['member_depart_batch_edit_ok'],$url);
				}else {
					showMessage($lang['member_depart_batch_edit_fail']);
				}
			}
		}
				
		$class_array = $model_class->getOneGoodsClass($_GET['depart_id']);
		if (empty($class_array)){
			showMessage($lang['member_depart_batch_edit_paramerror']);
		}

		/**
		 * 父类列表，只取到第三级
		 */
		$parent_list = $model_class->getTreedepartList(3);
		if (is_array($parent_list)){
			$unset_sign = false;
			foreach ($parent_list as $k => $v){
				if ($v['depart_id'] == $class_array['depart_id']){
					$deep = $v['deep'];
					$unset_sign = true;
				}
				if ($unset_sign == true){
					if ($v['deep'] == $deep && $v['depart_id'] != $class_array['depart_id']){
						$unset_sign = false;
					}
					if ($v['deep'] > $deep || $v['depart_id'] == $class_array['depart_id']){
						unset($parent_list[$k]);
					}
				}else {
					$parent_list[$k]['depart_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['depart_name'];
				}
			}
		}
		
		Tpl::output('parent_list',$parent_list);
		Tpl::output('class_array',$class_array);
		Tpl::showpage('member_depart.edit');
	}

	
	/**
	 * 删除单位
	 */
	public function member_depart_delOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('member_depart');
		if (intval($_GET['depart_id']) > 0){
			/**
			 * 删除单位
			 */
			$model_class->del($_GET['depart_id']);
			showMessage($lang['member_depart_index_del_succ'],'index.php?act=member_depart&op=member_depart');
		}else {
			showMessage($lang['member_depart_index_choose_del'],'index.php?act=member_depart&op=member_depart');
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
			case 'member_depart_name':
				$model_class = Model('member_depart');
				$class_array = $model_class->getOneGoodsClass($_GET['id']);
				
				$condition['depart_name'] = $_GET['value'];
				$condition['depart_parent_id'] = $class_array['depart_parent_id'];
				$condition['no_gc_id'] = $_GET['id'];
				$depart_list = $model_class->getdepartList($condition);
				if (empty($depart_list)){
					$update_array = array();
					$update_array['depart_id'] = $_GET['id'];
					$update_array['depart_name'] = $_GET['value'];
					$model_class->update($update_array);
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
			/**
			 * 单位 排序 显示 设置
			 */
			case 'member_depart_sort':
			case 'depart_show':
			case 'depart_manage':
				$model_class = Model('member_depart');
				$update_array = array();
				$update_array['depart_id'] = $_GET['id'];
				$update_array[$_GET['column']] = $_GET['value'];
				$model_class->update($update_array);
				echo 'true';exit;
				break;
			/**
			 * 添加、修改操作中 检测类别名称是否有重复
			 */
			case 'check_class_name':
				$model_class = Model('member_depart');
				$condition['depart_name'] = $_GET['depart_name'];
				$condition['depart_parent_id'] = $_GET['depart_parent_id'];
				$condition['no_gc_id'] = $_GET['depart_id'];
				$depart_list = $model_class->getdepartList($condition);
				if (empty($depart_list)){
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
		}
	}
	
}