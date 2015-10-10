<?php
/**
 * 下线抢购分类
 *
 *
 *
 *
 * */

defined('InShopNC') or exit('Access Invalid!');
class live_classControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('live');
	}

	public function indexOp(){
		$this->live_classOp();
	}

	/*
	 * 线下抢分类
	 */
	public function live_classOp(){
		$model_live_class = Model('live_class');
		$list = $model_live_class->getList();
		Tpl::output('list',$list);
		Tpl::showpage('live.groupbuyclass');
	}

	/*
	 * 添加分类
	 */
	public function add_classOp(){
		if(chksubmit()){//添加线下抢购分类
			//数据验证
			$obj_validate = new Validate();
			$validate_array = array(
				array('input'=>$_POST['live_class_name'],'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"10",'message'=>Language::get('live_groupbuy_class_name_is_not_null')),
				array('input'=>$_POST['live_class_name'],'require'=>'true','validator'=>'Range','min'=>0,'max'=>255,'message'=>Language::get('live_groupbuy_class_sort_is_not_null')),
			);
			$obj_validate->validateparam = $validate_array;
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage(Language::get('error').$error,'','','error');
			}

			$params = array();
			$params['live_class_name'] = trim($_POST['live_class_name']);
			$params['live_class_sort'] = intval($_POST['live_class_sort']);
			if(isset($_POST['parent_class_id']) && intval($_POST['parent_class_id']) > 0){
				$params['parent_class_id'] = $_POST['parent_class_id'];
			}else{
				$params['parent_class_id'] = 0;
			}

			$model_live_class = Model('live_class');
			$res = $model_live_class->add($params);//添加分类
			if($res){
				H('live_class',null);//清除缓存
				delCacheFile('live_class');
				$this->log('添加抢购分类[ID:'.$res.']',1);
				showMessage('添加成功','index.php?act=live_class','','succ');
			}else{
				showMessage('添加失败','index.php?act=live_class','','error');
			}
		}
		$model_live_class = Model('live_class');//一级分类
		$list = $model_live_class->getList(array('parent_class_id'=>0));
		Tpl::output('list',$list);

		Tpl::output('parent_class_id',isset($_GET['parent_class_id'])?intval($_GET['parent_class_id']):0);
		Tpl::showpage('live.groupbuyclass.add');
	}

	/*
	 * 编辑分类
	 */
	public function edit_classOp(){
		if(chksubmit()){
			//数据验证
			$obj_validate = new Validate();
			$validate_array = array(
					array('input'=>$_POST['live_class_name'],'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"10",'message'=>Language::get('live_groupbuy_class_name_is_not_null')),
					array('input'=>$_POST['live_class_sort'],'require'=>'true','validator'=>'Range','min'=>0,'max'=>255,'message'=>Language::get('live_groupbuy_class_sort_is_not_null')),
			);
			$obj_validate->validateparam = $validate_array;
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage(Language::get('error').$error,'','','error');
			}

			$params = array();
			$params['live_class_name'] = trim($_POST['live_class_name']);
			$params['live_class_sort'] = intval($_POST['live_class_sort']);
			if(isset($_POST['parent_class_id']) && intval($_POST['parent_class_id']) > 0){
				$params['parent_class_id'] = $_POST['parent_class_id'];
			}else{
				$params['parent_class_id'] = 0;
			}

			$condition 		= array();//条件
			$condition['live_class_id'] = intval($_POST['live_class_id']);

			$model_live_class = Model('live_class');
			$res = $model_live_class->editLive_class($condition,$params);

			if($res){
				H('live_class',null);//清除缓存
				delCacheFile('live_class');
				$this->log('编辑抢购分类[ID:'.intval($_POST['live_class_id']).']',1);
				showMessage('编辑成功','index.php?act=live_class','','succ');
			}else{
				showMessage('编辑失败','index.php?act=live_class','','error');
			}
		}

		$model_live_class = Model('live_class');//分类信息
		$live_class = $model_live_class->live_classInfo(array('live_class_id'=>intval($_GET['live_class_id'])));
		if(empty($live_class)){
			showMessage('该分类不存在','','','error');
		}
		Tpl::output('live_class',$live_class);


		$list = $model_live_class->getList(array('parent_class_id'=>0));
		Tpl::output('list',$list);

		Tpl::showpage('live.groupbuyclass.edit');
	}

	/*
	 * 删除分类
	 */
	public function del_classOp(){
		if(chksubmit()){
			$classidArr = explode(",",$_POST['live_class_id']);
			if(!empty($classidArr)){
				$model = Model();
				foreach($classidArr as $val){
					$class = $model->table('live_class')->where(array('live_class_id'=>$val))->find();
					if($class['parent_class_id'] == 0){
						$model->table('live_class')->where(array('parent_class_id'=>$class['live_class_id']))->delete();
					}
					$model->table('live_class')->where(array('live_class_id'=>$val))->delete();
				}
			}
		}
		H('live_class',null);//清除缓存
		delCacheFile('live_class');
		$this->log('删除抢购分类[ID:'.$_POST['live_class_id'].']',1);
		showMessage('删除成功','index.php?act=live_class','','succ');
	}


	public function ajaxOp(){
		if($_GET['column']=='lc_name'){
			$this->updateinfo('live_class_name',$_GET['id'],$_GET['value']);
		}elseif($_GET['column']=='lc_sort'){
			$this->updateinfo('live_class_sort',$_GET['id'],$_GET['value']);
		}
	}


	private function updateinfo($field,$id,$value){
		$model_live_class = Model('live_class');
		$res = $model_live_class->editLive_class(array('live_class_id'=>$id),array($field=>$value));
		if($res){
			H('live_class',null);//清除缓存
			delCacheFile('live_class');
			$this->log('编辑抢购分类[ID:'.$id.']',1);
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}
}
