<?php
/**


^^^^^^^^^^^^^^^^^^^^^^^^^^^^

 */
defined('InShopNC') or exit('Access Invalid!');
class flea_classControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('flea_class');
		if($GLOBALS['setting_config']['flea_isuse']!='1'){
			showMessage(Language::get('flea_isuse_off_tips'),'index.php?act=dashboard&op=welcome');
		}
	}
	public function indexOp(){
		$this->flea_classOp();
	}
	public function goods_classOp(){
		$this->flea_classOp();
	}
	/**
	 * 分类管理
	 */
	public function flea_classOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('flea_class');
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
			 * 首页显示
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
			Tpl::showpage('flea_class.index');
		}
	}
	
	/**
	 * 保存批量修改分类
	 */
	public function brach_edit_saveOp(){
		$lang	= Language::getLangContent();
		if ($_POST['gc_show'] == '-1'){
			showMessage($lang['goods_class_batch_edit_succ'],'index.php?act=flea_class&op=flea_class');
		}
		if ($_POST['form_submit'] == 'ok'){
			$model_class = Model('flea_class');
			
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
	 * 商品分类添加
	 */
	public function goods_class_addOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('flea_class');
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
							'url'=>'index.php?act=flea_class&op=goods_class_add&gc_parent_id='.$_POST['gc_parent_id'],
							'msg'=>$lang['goods_class_add_again'],
						),
						array(
							'url'=>'index.php?act=flea_class&op=flea_class',
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
		Tpl::showpage('flea_class.add');
	}
	
	/**
	 * 编辑
	 */
	public function goods_class_editOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('flea_class');
		
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
							'url'=>'index.php?act=flea_class&op=goods_class_edit&gc_id='.$_POST['gc_id'],
							'msg'=>$lang['goods_class_batch_edit_again'],
						),
						array(
							'url'=>'index.php?act=flea_class&op=flea_class',
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
		Tpl::showpage('flea_class.edit');
	}
	
	/**
	 * 分类导入
	 */
	public function goods_class_importOp(){
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_class = Model('flea_class');
		/**
		 * 导入
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 得到导入文件后缀名
			 */
			$file_type = end(explode('.',$_FILES['csv']['name']));
			if (!empty($_FILES['csv']) && !empty($_FILES['csv']['name']) && $file_type == 'csv'){
				$fp = @fopen($_FILES['csv']['tmp_name'],'rb');
				/**
				 * 父ID
				 */
				$parent_id_1 = 0;
				
				while (!feof($fp)) {
					$data = fgets($fp, 4096);
					switch (strtoupper($_POST['charset'])){
						case 'UTF-8':
							if (strtoupper(CHARSET) !== 'UTF-8'){
								$data = iconv('UTF-8',strtoupper(CHARSET),$data);
							}
							break;
						case 'GBK':
							if (strtoupper(CHARSET) !== 'GBK'){
								$data = iconv('GBK',strtoupper(CHARSET),$data);
							}
							break;
					}
					
					if (!empty($data)){
						$data	= str_replace('"','',$data);
						/**
						 * 逗号去除
						 */
						$tmp_array = array();
						$tmp_array = explode(',',$data);
						if($tmp_array[0] == 'sort_order')continue;
						/**
						 * 第一位是序号，后面的是内容，最后一位名称
						 */
						$tmp_deep = 'parent_id_'.(count($tmp_array)-1);
						
						$insert_array = array();
						$insert_array['gc_sort'] = $tmp_array[0];
						$insert_array['gc_parent_id'] = $$tmp_deep;
						$insert_array['gc_name'] = $tmp_array[count($tmp_array)-1];
						$gc_id = $model_class->add($insert_array);
						/**
						 * 赋值这个深度父ID
						 */
						$tmp = 'parent_id_'.count($tmp_array);
						$$tmp = $gc_id;
					}
				}
				/**
				 * 重新生成缓存
				 */
				showMessage($lang['goods_class_import_succ'],'index.php?act=flea_class&op=flea_class');
			}else {
				showMessage($lang['goods_class_import_csv_null']);
			}
		}
		Tpl::showpage('flea_class.import');
	}
	
	/**
	 * 分类导出
	 */
	public function goods_class_exportOp(){
		/**
		 * 导出
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 实例化模型
			 */
			$model_class = Model('flea_class');
			/**
			 * 分类信息
			 */
			$class_list = $model_class->getTreeClassList();
			
			@header("Content-type: application/unknown");
        	@header("Content-Disposition: attachment; filename=flea_class.csv");
			if (is_array($class_list)){
				foreach ($class_list as $k => $v){
					$tmp = array();
					/**
					 * 序号
					 */
					$tmp['gc_sort'] = $v['gc_sort'];
					/**
					 * 深度
					 */
					for ($i=1; $i<=($v['deep']-1); $i++){
						$tmp[] = '';
					}
					/**
					 * 分类名称
					 */
					$tmp['gc_name'] = $v['gc_name'];
					/**
					 * 转码 utf-gbk
					 */
					if (strtoupper(CHARSET) == 'UTF-8'){
						switch ($_POST['if_convert']){
							case '1':
								$tmp_line = iconv('UTF-8','GB2312//IGNORE',join(',',$tmp));
								break;
							case '0':
								$tmp_line = join(',',$tmp);
								break;
						}
					}else {
						$tmp_line = join(',',$tmp);
					}
					$tmp_line = str_replace("\r\n",'',$tmp_line);
					echo $tmp_line."\r\n";
				}
			}
			exit;
		}
		Tpl::showpage('flea_class.export');
	}
	
	/**
	 * 删除分类
	 */
	public function goods_class_delOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('flea_class');
		if (intval($_GET['gc_id']) > 0){
			/**
			 * 删除分类
			 */
			$model_class->del($_GET['gc_id']);
			showMessage($lang['goods_class_index_del_succ'],'index.php?act=flea_class&op=flea_class');
		}else {
			showMessage($lang['goods_class_index_choose_del'],'index.php?act=flea_class&op=flea_class');
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
				$model_class = Model('flea_class');
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
			case 'goods_class_sort':
			case 'goods_class_show':
			case 'goods_class_index_show':
				$model_class = Model('flea_class');
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
				$model_class = Model('flea_class');
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