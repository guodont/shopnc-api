<?php
/**
 * 商品分类管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class goods_classControl extends SystemControl{
	private $links = array(
		array('url'=>'act=goods_class&op=goods_class','lang'=>'nc_manage'),
		array('url'=>'act=goods_class&op=goods_class_add','lang'=>'nc_new'),
		array('url'=>'act=goods_class&op=goods_class_export','lang'=>'goods_class_index_export'),
		array('url'=>'act=goods_class&op=goods_class_import','lang'=>'goods_class_index_import'),
		array('url'=>'act=goods_class&op=tag','lang'=>'goods_class_index_tag'),
	);
	public function __construct(){
		parent::__construct();
		Language::read('goods_class');
	}

	/**
	 * 分类管理
	 */
	public function goods_classOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');
		if (chksubmit()){
			//删除
			if ($_POST['submit_type'] == 'del'){
			    $gcids = implode(',', $_POST['check_gc_id']);
				if (!empty($_POST['check_gc_id'])){
					if (!is_array($_POST['check_gc_id'])){
    					$this->log(L('nc_delete,goods_class_index_class').'[ID:'.$gcids.']',0);
    					showMessage($lang['nc_common_del_fail']);
					}
					$del_array = $model_class->delGoodsClassByGcIdString($gcids);
					$this->log(L('nc_delete,goods_class_index_class').'[ID:'.$gcids.']',1);
					showMessage($lang['nc_common_del_succ']);
				}else {
					$this->log(L('nc_delete,goods_class_index_class').'[ID:'.$gcids.']',0);
					showMessage($lang['nc_common_del_fail']);
				}
			}
		}

		//父ID
		$parent_id = $_GET['gc_parent_id']?intval($_GET['gc_parent_id']):0;

		//列表
		$tmp_list = $model_class->getTreeClassList(3);
		if (is_array($tmp_list)){
			foreach ($tmp_list as $k => $v){
				if ($v['gc_parent_id'] == $parent_id){
					//判断是否有子类
					if ($tmp_list[$k+1]['deep'] > $v['deep']){
						$v['have_child'] = 1;
					}
					$class_list[] = $v;
				}
			}
		}
		if ($_GET['ajax'] == '1'){
			//转码
			if (strtoupper(CHARSET) == 'GBK'){
				$class_list = Language::getUTF8($class_list);
			}
			$output = json_encode($class_list);
			print_r($output);
			exit;
		}else {
			Tpl::output('class_list',$class_list);
			Tpl::output('top_link',$this->sublink($this->links,'goods_class'));
			Tpl::showpage('goods_class.index');
		}
	}

	/**
	 * 商品分类添加
	 */
	public function goods_class_addOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');
		if (chksubmit()){
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
				$insert_array['gc_name']		= $_POST['gc_name'];
				$insert_array['type_id']		= intval($_POST['t_id']);
				$insert_array['type_name']		= trim($_POST['t_name']);
				$insert_array['gc_parent_id']	= intval($_POST['gc_parent_id']);
				$insert_array['commis_rate']    = intval($_POST['commis_rate']);
				$insert_array['gc_sort']		= intval($_POST['gc_sort']);
                $insert_array['gc_virtual']     = intval($_POST['gc_virtual']);
				$result = $model_class->addGoodsClass($insert_array);
				if ($result){
    				if ($insert_array['gc_parent_id'] == 0) {
            			if (!empty($_FILES['pic']['name'])) {//上传图片
            				$upload = new UploadFile();
                			$upload->set('default_dir',ATTACH_COMMON);
                			$upload->set('file_name','category-pic-'.$result.'.jpg');
            				$upload->upfile('pic');
            			}
    				}
					$url = array(
						array(
							'url'=>'index.php?act=goods_class&op=goods_class_add&gc_parent_id='.$_POST['gc_parent_id'],
							'msg'=>$lang['goods_class_add_again'],
						),
						array(
							'url'=>'index.php?act=goods_class&op=goods_class',
							'msg'=>$lang['goods_class_add_back_to_list'],
						)
					);
					$this->log(L('nc_add,goods_class_index_class').'['.$_POST['gc_name'].']',1);
					showMessage($lang['nc_common_save_succ'],$url);
				}else {
					$this->log(L('nc_add,goods_class_index_class').'['.$_POST['gc_name'].']',0);
					showMessage($lang['nc_common_save_fail']);
				}
			}
		}

		//父类列表，只取到第二级
		$parent_list = $model_class->getTreeClassList(2);
		$gc_list = array();
		if (is_array($parent_list)){
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['gc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['gc_name'];
				if($v['deep'] == 1) $gc_list[$k] = $v;
			}
		}
		Tpl::output('gc_list', $gc_list);
		//类型列表
		$model_type	= Model('type');
		$type_list	= $model_type->typeList(array('order'=>'type_sort asc'), '', 'type_id,type_name,class_id,class_name');
		$t_list = array();
		if(is_array($type_list) && !empty($type_list)){
			foreach($type_list as $k=>$val){
				$t_list[$val['class_id']]['type'][$k] = $val;
				$t_list[$val['class_id']]['name'] = $val['class_name']==''?L('nc_default'):$val['class_name'];
			}
		}
		ksort($t_list);

		Tpl::output('type_list',$t_list);
		Tpl::output('gc_parent_id',$_GET['gc_parent_id']);
		Tpl::output('parent_list',$parent_list);
		Tpl::output('top_link',$this->sublink($this->links,'goods_class_add'));
		Tpl::showpage('goods_class.add');
	}

	/**
	 * 编辑
	 */
	public function goods_class_editOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');

		if (chksubmit()){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["gc_name"], "require"=>"true", "message"=>$lang['goods_class_add_name_null']),
			    array("input"=>$_POST["commis_rate"], "require"=>"true", 'validator'=>'range','max'=>100,'min'=>0, "message"=>$lang['goods_class_add_commis_rate_error']),
				array("input"=>$_POST["gc_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['goods_class_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}

			// 更新分类信息
			$where = array('gc_id' => intval($_POST['gc_id']));
			$update_array = array();
			$update_array['gc_name'] 		= $_POST['gc_name'];
			$update_array['type_id']		= intval($_POST['t_id']);
			$update_array['type_name']		= trim($_POST['t_name']);
			$update_array['commis_rate']    = intval($_POST['commis_rate']);
			$update_array['gc_sort']		= intval($_POST['gc_sort']);
            $update_array['gc_virtual']     = intval($_POST['gc_virtual']);

			$result = $model_class->editGoodsClass($update_array, $where);
			if (!$result){
				$this->log(L('nc_edit,goods_class_index_class').'['.$_POST['gc_name'].']',0);
				showMessage($lang['goods_class_batch_edit_fail']);
			}

			if (!empty($_FILES['pic']['name'])) {//上传图片
				$upload = new UploadFile();
    			$upload->set('default_dir',ATTACH_COMMON);
    			$upload->set('file_name','category-pic-'.intval($_POST['gc_id']).'.jpg');
				$upload->upfile('pic');
			}

            // 检测是否需要关联自己操作，统一查询子分类
            if ($_POST['t_commis_rate'] == '1' || $_POST['t_associated'] == '1' || $_POST['t_gc_virtual'] == '1') {
                $gc_id_list = $model_class->getChildClass($_POST['gc_id']);
                $gc_ids = array();
                if (is_array($gc_id_list) && !empty($gc_id_list)) {
                    foreach ($gc_id_list as $val){
                        $gc_ids[] = $val['gc_id'];
                    }
                }
            }

			// 更新该分类下子分类的所有分佣比例
			if ($_POST['t_commis_rate'] == '1' && !empty($gc_ids)){
	            $model_class->editGoodsClass(array('commis_rate'=>$update_array['commis_rate']),array('gc_id'=>array('in',$gc_ids)));
			}

			// 更新该分类下子分类的所有类型
			if ($_POST['t_associated'] == '1' && !empty($gc_ids)){
			    $where = array();
			    $where['gc_id'] = array('in', $gc_ids);
			    $update = array();
			    $update['type_id'] = intval($_POST['t_id']);
			    $update['type_name'] = trim($_POST['t_name']);
			    $model_class->editGoodsClass($update, $where);
			}

            // 虚拟商品
            if ($_POST['t_gc_virtual'] == '1' && !empty($gc_ids)) {
                $model_class->editGoodsClass(array('gc_virtual'=>$update_array['gc_virtual']),array('gc_id'=>array('in',$gc_ids)));
            }

			$url = array(
				array(
					'url'=>'index.php?act=goods_class&op=goods_class_edit&gc_id='.intval($_POST['gc_id']),
					'msg'=>$lang['goods_class_batch_edit_again'],
				),
				array(
					'url'=>'index.php?act=goods_class&op=goods_class',
					'msg'=>$lang['goods_class_add_back_to_list'],
				)
			);
			$this->log(L('nc_edit,goods_class_index_class').'['.$_POST['gc_name'].']',1);
			showMessage($lang['goods_class_batch_edit_ok'],$url,'html','succ',1,5000);
		}

		$class_array = $model_class->getGoodsClassInfoById(intval($_GET['gc_id']));
		if (empty($class_array)){
			showMessage($lang['goods_class_batch_edit_paramerror']);
		}

		//类型列表
		$model_type	= Model('type');
		$type_list	= $model_type->typeList(array('order'=>'type_sort asc'), '', 'type_id,type_name,class_id,class_name');
		$t_list = array();
		if(is_array($type_list) && !empty($type_list)){
			foreach($type_list as $k=>$val){
				$t_list[$val['class_id']]['type'][$k] = $val;
				$t_list[$val['class_id']]['name'] = $val['class_name']==''?L('nc_default'):$val['class_name'];
			}
		}
		ksort($t_list);
		//父类列表，只取到第二级
		$parent_list = $model_class->getTreeClassList(2);
		if (is_array($parent_list)){
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['gc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['gc_name'];
			}
		}
		Tpl::output('parent_list',$parent_list);
		// 一级分类列表
		$gc_list = Model('goods_class')->getGoodsClassListByParentId(0);
		Tpl::output('gc_list', $gc_list);
	    $pic_name = BASE_UPLOAD_PATH.'/'.ATTACH_COMMON.'/category-pic-'.$class_array['gc_id'].'.jpg';
	    if (file_exists($pic_name)) {
	        $class_array['pic'] = UPLOAD_SITE_URL.'/'.ATTACH_COMMON.'/category-pic-'.$class_array['gc_id'].'.jpg';
	    }

		Tpl::output('type_list',$t_list);
		Tpl::output('class_array',$class_array);
		$this->links[] = array('url'=>'act=goods_class&op=goods_class_edit','lang'=>'nc_edit');
		Tpl::output('top_link',$this->sublink($this->links,'goods_class_edit'));
		Tpl::showpage('goods_class.edit');
	}

	/**
	 * 分类导入
	 */
	public function goods_class_importOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');
		//导入
		if (chksubmit()){
			//得到导入文件后缀名
			$csv_array = explode('.',$_FILES['csv']['name']);
			$file_type = end($csv_array);
			if (!empty($_FILES['csv']) && !empty($_FILES['csv']['name']) && $file_type == 'csv'){
				$fp = @fopen($_FILES['csv']['tmp_name'],'rb');
				// 父ID
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
						//逗号去除
						$tmp_array = array();
						$tmp_array = explode(',',$data);
						if($tmp_array[0] == 'sort_order')continue;
						//第一位是序号，后面的是内容，最后一位名称
						$tmp_deep = 'parent_id_'.(count($tmp_array)-1);

						$insert_array = array();
						$insert_array['gc_sort'] = $tmp_array[0];
						$insert_array['gc_parent_id'] = $$tmp_deep;
						$insert_array['gc_name'] = $tmp_array[count($tmp_array)-1];
						$gc_id = $model_class->addGoodsClass($insert_array);
						//赋值这个深度父ID
						$tmp = 'parent_id_'.count($tmp_array);
						$$tmp = $gc_id;
					}
				}
				$this->log(L('goods_class_index_import,goods_class_index_class'),1);
				showMessage($lang['nc_common_op_succ'],'index.php?act=goods_class&op=goods_class');
			}else {
				$this->log(L('goods_class_index_import,goods_class_index_class'),0);
				showMessage($lang['goods_class_import_csv_null']);
			}
		}
		Tpl::output('top_link',$this->sublink($this->links,'goods_class_import'));
		Tpl::showpage('goods_class.import');
	}

	/**
	 * 分类导出
	 */
	public function goods_class_exportOp(){
		if (chksubmit()){
			$model_class = Model('goods_class');
			$class_list = $model_class->getTreeClassList();

			@header("Content-type: application/unknown");
        	@header("Content-Disposition: attachment; filename=goods_class.csv");
			if (is_array($class_list)){
				foreach ($class_list as $k => $v){
					$tmp = array();
					//序号
					$tmp['gc_sort'] = $v['gc_sort'];
					//深度
					for ($i=1; $i<=($v['deep']-1); $i++){
						$tmp[] = '';
					}
					//分类名称
					$tmp['gc_name'] = $v['gc_name'];
					//转码 utf-gbk
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
			$this->log(L('goods_class_index_export,goods_class_index_class'),1);
			exit;
		}
		Tpl::output('top_link',$this->sublink($this->links,'goods_class_export'));
		Tpl::showpage('goods_class.export');
	}

	/**
	 * 删除分类
	 */
	public function goods_class_delOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');
		if (intval($_GET['gc_id']) > 0){
			//删除分类
			$model_class->delGoodsClassByGcIdString(intval($_GET['gc_id']));
			$this->log(L('nc_delete,goods_class_index_class') . '[ID:' . intval($_GET['gc_id']) . ']',1);
			showMessage($lang['nc_common_del_succ'],'index.php?act=goods_class&op=goods_class');
		}else {
			$this->log(L('nc_delete,goods_class_index_class') . '[ID:' . intval($_GET['gc_id']) . ']',0);
			showMessage($lang['nc_common_del_fail'],'index.php?act=goods_class&op=goods_class');
		}
	}

	/**
	 * tag列表
	 */
	public function tagOp(){
		$lang	= Language::getLangContent();

		/**
		 * 处理商品分类
		 */
		$choose_gcid = ($t = intval($_REQUEST['choose_gcid']))>0?$t:0;
		$gccache_arr = Model('goods_class')->getGoodsclassCache($choose_gcid,3);
		Tpl::output('gc_json',json_encode($gccache_arr['showclass']));
		Tpl::output('gc_choose_json',json_encode($gccache_arr['choose_gcid']));

		$model_class_tag = Model('goods_class_tag');

		if (chksubmit()){
			//删除
			if ($_POST['submit_type'] == 'del'){
				if (is_array($_POST['tag_id']) && !empty($_POST['tag_id'])){
					//删除TAG
					$model_class_tag->delTagByIds(implode(',',$_POST['tag_id']));
					$this->log(L('nc_delete').'tag[ID:'.implode(',',$_POST['tag_id']).']',1);
					showMessage($lang['nc_common_del_succ']);
				}else {
					$this->log(L('nc_delete').'tag',0);
					showMessage($lang['nc_common_del_fail']);
				}
			}
		}

		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$where = array();
		if ($choose_gcid > 0){
		    $where['gc_id_'.($gccache_arr['showclass'][$choose_gcid]['depth'])] = $choose_gcid;
		}
		$tag_list = $model_class_tag->getTagList($where, $page);
		Tpl::output('tag_list', $tag_list);
		Tpl::output('page',$page->show());
		Tpl::output('top_link',$this->sublink($this->links,'tag'));
		Tpl::showpage('goods_class_tag.index');
	}

	/**
	 * 重置TAG
	 */
	public function tag_resetOp(){
		$lang	= Language::getLangContent();
		//实例化模型
		$model_class = Model('goods_class');
		$model_class_tag = Model('goods_class_tag');

		//清空TAG
		$return = $model_class_tag->clearTag();
		if(!$return){
			showMessage($lang['goods_class_reset_tag_fail'], 'index.php?act=goods_class&op=tag');
		}

		//商品分类
		$goods_class		= $model_class->getTreeClassList(3);
		//格式化分类。组成三维数组
		if(is_array($goods_class) and !empty($goods_class)) {
			$goods_class_array = array();
			foreach ($goods_class as $val) {
				//一级分类
				if($val['gc_parent_id'] == 0) {
					$goods_class_array[$val['gc_id']]['gc_name']	= $val['gc_name'];
					$goods_class_array[$val['gc_id']]['gc_id']		= $val['gc_id'];
					$goods_class_array[$val['gc_id']]['type_id']	= $val['type_id'];
				}else {
					//二级分类
					if(isset($goods_class_array[$val['gc_parent_id']])){
						$goods_class_array[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_name']			= $val['gc_name'];
						$goods_class_array[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_id']			= $val['gc_id'];
						$goods_class_array[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_parent_id']	= $val['gc_parent_id'];
						$goods_class_array[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['type_id']			= $val['type_id'];
					}else{
						foreach ($goods_class_array as $v){
							//三级分类
							if(isset($v['sub_class'][$val['gc_parent_id']])){
								$goods_class_array[$v['sub_class'][$val['gc_parent_id']]['gc_parent_id']]['sub_class'][$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_name']	= $val['gc_name'];
								$goods_class_array[$v['sub_class'][$val['gc_parent_id']]['gc_parent_id']]['sub_class'][$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_id']	= $val['gc_id'];
								$goods_class_array[$v['sub_class'][$val['gc_parent_id']]['gc_parent_id']]['sub_class'][$val['gc_parent_id']]['sub_class'][$val['gc_id']]['type_id']	= $val['type_id'];
							}
						}
					}
				}
			}

			$return = $model_class_tag->tagAdd($goods_class_array);

			if($return){
				$this->log(L('nc_reset').'tag',1);
				showMessage($lang['nc_common_op_succ'], 'index.php?act=goods_class&op=tag');
			}else{
				$this->log(L('nc_reset').'tag',0);
				showMessage($lang['nc_common_op_fail'], 'index.php?act=goods_class&op=tag');
			}
		}else{
			$this->log(L('nc_reset').'tag',0);
			showMessage($lang['goods_class_reset_tag_fail_no_class'], 'index.php?act=goods_class&op=tag');
		}
	}

	/**
	 * 更新TAG名称
	 */
	public function tag_updateOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');
		$model_class_tag = Model('goods_class_tag');

		//需要更新的TAG列表
		$tag_list = $model_class_tag->getTagList(array(), '', 'gc_tag_id,gc_id_1,gc_id_2,gc_id_3');
		if(is_array($tag_list) && !empty($tag_list)){
			foreach ($tag_list as $val){
				//查询分类信息
				$in_gc_id = array();
				if($val['gc_id_1'] != '0'){
					$in_gc_id[] = $val['gc_id_1'];
				}
				if($val['gc_id_2'] != '0'){
					$in_gc_id[] = $val['gc_id_2'];
				}
				if($val['gc_id_3'] != '0'){
					$in_gc_id[] = $val['gc_id_3'];
				}
				$gc_list	= $model_class->getGoodsClassListByIds($in_gc_id);

				//更新TAG信息
				$update_tag					= array();
				if(isset($gc_list['0']['gc_id']) && $gc_list['0']['gc_id'] != '0'){
					$update_tag['gc_id_1']		= $gc_list['0']['gc_id'];
					$update_tag['gc_tag_name']	.= $gc_list['0']['gc_name'];
				}
				if(isset($gc_list['1']['gc_id']) && $gc_list['1']['gc_id'] != '0'){
					$update_tag['gc_id_2']		= $gc_list['1']['gc_id'];
					$update_tag['gc_tag_name']	.= "&nbsp;&gt;&nbsp;".$gc_list['1']['gc_name'];
				}
				if(isset($gc_list['2']['gc_id']) && $gc_list['2']['gc_id'] != '0'){
					$update_tag['gc_id_3']		= $gc_list['2']['gc_id'];
					$update_tag['gc_tag_name']	.= "&nbsp;&gt;&nbsp;".$gc_list['2']['gc_name'];
				}
				unset($gc_list);
				$update_tag['gc_tag_id']	= $val['gc_tag_id'];
				$return = $model_class_tag->updateTag($update_tag);
				if(!$return){
					$this->log(L('nc_update').'tag',0);
					showMessage($lang['nc_common_op_fail'], 'index.php?act=goods_class&op=tag');
				}
			}
			$this->log(L('nc_update').'tag',1);
			showMessage($lang['nc_common_op_succ'], 'index.php?act=goods_class&op=tag');
		}else{
			$this->log(L('nc_update').'tag',0);
			showMessage($lang['goods_class_update_tag_fail_no_class'], 'index.php?act=goods_class&op=tag');
		}

	}

	/**
	 * 删除TAG
	 */
	public function tag_delOp(){
		$id = intval($_GET['tag_id']);
		$lang	= Language::getLangContent();
		$model_class_tag = Model('goods_class_tag');
		if ($id > 0){
			/**
			 * 删除TAG
			 */
			$model_class_tag->delTagByIds($id);
			$this->log(L('nc_delete').'tag[ID:'.$id.']',1);
			showMessage($lang['nc_common_op_succ']);
		}else {
			$this->log(L('nc_delete').'tag[ID:'.$id.']',0);
			showMessage($lang['nc_common_op_fail']);
		}
	}

	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 更新分类
			 */
			case 'goods_class_name':
				$model_class = Model('goods_class');
				$class_array = $model_class->getGoodsClassInfoById(intval($_GET['id']));

				$condition['gc_name'] = trim($_GET['value']);
				$condition['gc_parent_id'] = $class_array['gc_parent_id'];
				$condition['gc_id'] = array('neq' => intval($_GET['id']));
				$class_list = $model_class->getGoodsClassList($condition);
				if (empty($class_list)){
				    $where = array('gc_id' => intval($_GET['id']));
					$update_array = array();
					$update_array['gc_name'] = trim($_GET['value']);
					$model_class->editGoodsClass($update_array, $where);
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
				$model_class = Model('goods_class');
			    $where = array('gc_id' => intval($_GET['id']));
				$update_array = array();
				$update_array[$_GET['column']] = $_GET['value'];
				$model_class->editGoodsClass($update_array, $where);
				echo 'true';exit;
				break;
			/**
			 * 添加、修改操作中 检测类别名称是否有重复
			 */
			case 'check_class_name':
				$model_class = Model('goods_class');
				$condition['gc_name'] = trim($_GET['gc_name']);
				$condition['gc_parent_id'] = intval($_GET['gc_parent_id']);
				$condition['gc_id'] = array('neq', intval($_GET['gc_id']));
				$class_list = $model_class->getGoodsClassList($condition);
				if (empty($class_list)){
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
			/**
			 * TAG值编辑
			 */
			case 'goods_class_tag_value':
				$model_class_tag = Model('goods_class_tag');
				$update_array = array();
				$update_array['gc_tag_id'] = intval($_GET['id']);
				/**
				 * 转码  防止GBK下用中文逗号截取不正确
				 */
				$comma = '，';
				if (strtoupper(CHARSET) == 'GBK'){
					$comma = Language::getGBK($comma);
				}
				$update_array[$_GET['column']] = trim(str_replace($comma,',',$_GET['value']));
				$model_class_tag->updateTag($update_array);
				echo 'true';exit;
				break;
		}
	}
}
