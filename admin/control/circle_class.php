<?php
/**
 * 圈子分类管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class circle_classControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('circle');
	}
	/**
	 * 圈子分类列表
	 */
	public function class_listOp(){
		$model = Model();
		if(chksubmit()){
			// 批量删除
			if($_POST['submit_type'] == 'batchdel'){
				$id_array	=$_POST['check_class_id'];
				if(empty($id_array) && !is_array($id_array)){
					showMessage(L('circle_please_choose_class'));
				}
				$where = array('class_id'=>array('in',$id_array));
				$model->table('circle_class')->where($where)->delete();
				showMessage(L('nc_common_op_succ'));
			}
		}
		$where = array();
		if(trim($_GET['searchname']) != ''){
			$where['class_name']		= array('like', '%'.trim($_GET['searchname']).'%');
		}
		if(trim($_GET['searchstatus']) != ''){
			$where['class_status']		= intval($_GET['searchstatus']);
		}
		$class_list = $model->table('circle_class')->where($where)->order('class_sort asc')->select();
		Tpl::output('class_list', $class_list);
		Tpl::showpage('circle_class.list');
	}
	/**
	 * 圈子分类添加
	 */
	public function class_addOp(){
		$model = Model();
		if(chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["class_name"], "require"=>"true", "message"=>L('circle_class_name_not_null')),
					array("input"=>$_POST["class_sort"], "require"=>"true", 'validator'=>'Number', "message"=>L('circle_class_sort_is_number')),
			);
			$error = $obj_validate->validate();
			if($error != ''){
				showMessage($error);
			}else{
				$insert = array();
				$insert['class_name']		= trim($_POST['class_name']);
				$insert['class_sort']		= intval($_POST['class_sort']);
				$insert['class_status']		= intval($_POST['status']);
				$insert['is_recommend']		= intval($_POST['recommend']);
				$insert['class_addtime']	= time();
				$result = $model->table('circle_class')->insert($insert);
				if($result){
					$url = array(
						array(
							'url'=>'index.php?act=circle_class&op=class_add',
							'msg'=>L('circle_continue_add'),
						),
						array(
							'url'=>'index.php?act=circle_class&op=class_list',
							'msg'=>L('circle_return_list'),
						)
					);
					showMessage(L('nc_common_op_succ'),$url);
				}else{
					showMessage(L('nc_common_op_fail'));
				}
			}
		}
		// 商品分类
		$gc_list = Model('goods_class')->getGoodsClassListByParentId(0);
		Tpl::output('gc_list', $gc_list);

		Tpl::showpage('circle_class.add');
	}
	/**
	 * 圈子分类编辑
	 */
	public function class_editOp(){
		$model = Model();
		if(chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["class_name"], "require"=>"true", "message"=>L('circle_class_name_not_null')),
					array("input"=>$_POST["class_sort"], "require"=>"true", 'validator'=>'Number', "message"=>L(’circle_class_sort_is_number)),
			);
			$error = $obj_validate->validate();
			if($error != ''){
				showMessage($error);
			}else{
				$update = array();
				$update['class_id']		= intval($_POST['class_id']);
				$update['class_name']	= trim($_POST['class_name']);
				$update['class_sort']	= intval($_POST['class_sort']);
				$update['class_status']	= intval($_POST['status']);
				$update['is_recommend']	= intval($_POST['recommend']);
				$result = $model->table('circle_class')->update($update);
				if($result){
					showMessage(L('nc_common_op_succ'),'index.php?act=circle_class&op=class_list');
				}else{
					showMessage(L('nc_common_op_fail'));
				}
			}
		}
		$id = intval($_GET['classid']);
		if($id <= 0){
			showMessage(L('param_error'));
		}
		$class_info = $model->table('circle_class')->find($id);

		Tpl::output('class_info', $class_info);
		// 商品分类
		$gc_list = Model('goods_class')->getGoodsClassListByParentId(0);
		Tpl::output('gc_list', $gc_list);

		Tpl::showpage('circle_class.edit');
	}
	/**
	 * 删除分类
	 */
	public function class_delOp(){
		$id = intval($_GET['classid']);
		if($id <= 0){
			showMessage(L('param_error'));
		}
		$model = Model();
		$model->table('circle_class')->delete($id);
		showMessage(L('nc_common_op_succ'));
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			case 'recommend':
			case 'status':
			case 'sort':
			case 'name':
				$update = array(
					'class_id'=>intval($_GET['id']),
					$_GET['column']=>$_GET['value']
				);
				Model()->table('circle_class')->update($update);
				echo 'true';
				break;
		}
	}
}
