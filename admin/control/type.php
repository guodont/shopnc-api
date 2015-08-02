<?php
/**
 * 类型管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class typeControl extends SystemControl {
	const EXPORT_SIZE = 5000;
	public function __construct(){
		parent::__construct();
		Language::read('type');
	}

	/**
	 * 类型管理
	 */
	public function typeOp(){
		$model_type = Model('type');

		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');

		$type_list	= $model_type->typeList(array('order'=>'type_sort asc'),$page);

		Tpl::output('type_list',$type_list);
		Tpl::output('page',$page->show());
		Tpl::showpage('type.index');
	}

	/**
	 * 添加类型
	 */
	public function type_addOp(){
		$lang	= Language::getLangContent();
		$model_type = Model('type');

		if (chksubmit()){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["t_mane"], "require"=>"true", "message"=>$lang['type_add_name_no_null']),
				array("input"=>$_POST["t_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['type_add_sort_no_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}

			$type_array = array();
			$type_array['type_name']	= trim($_POST['t_mane']);
			$type_array['type_sort']	= trim($_POST['t_sort']);
			$type_array['class_id']		= $_POST['class_id'];
			$type_array['class_name']	= $_POST['class_name'];
			$type_id = $model_type->typeAdd('type',$type_array);


			if(!$type_id){
				showMessage($lang['nc_common_save_fail']);
			}

			//添加类型与品牌对应
			if(!empty($_POST['brand_id'])){
				$brand_array	= $_POST['brand_id'];
				$return = $model_type->typeRelatedAdd('type_brand', $brand_array, $type_id);
				if(!$return){
					showMessage($lang['type_index_related_fail']);
				}
			}
			//添加类型与规格对应
			if(!empty($_POST['spec_id'])){
				$spec_array		= $_POST['spec_id'];
				$return = $model_type->typeRelatedAdd('type_spec', $spec_array, $type_id);
				if(!$return){
					showMessage($lang['type_index_related_fail']);
				}
			}
			//添加类型属性
			if(!empty($_POST['at_value'])){
				$attribute_array		= $_POST['at_value'];
				foreach ($attribute_array as $v){
					if($v['value'] != ''){
						// 转码  防止GBK下用中文逗号截取不正确
						$comma = '，';
						if (strtoupper(CHARSET) == 'GBK'){
							$comma = Language::getGBK($comma);
						}
						//属性值
						//添加属性
						$attr_array = array();
						$attr_array['attr_name']	= $v['name'];
						$attr_array['attr_value']	= $v['value'];
						$attr_array['type_id']		= $type_id;
						$attr_array['attr_sort']	= $v['sort'];
						$attr_array['attr_show']	= $v['show'];
						$attr_id	= $model_type->typeAdd('attribute',$attr_array);
						if(!$attr_id){
							showMessage($lang['type_index_related_fail']);
						}
                        //添加属性值
                        $attr_value = explode(',', $v['value']);
                        if (!empty($attr_value)) {
                            $attr_array = array();
                            foreach ($attr_value as $val) {
                                $tpl_array = array();
                                $tpl_array['attr_value_name'] = $val;
                                $tpl_array['attr_id'] = $attr_id;
                                $tpl_array['type_id'] = $type_id;
                                $tpl_array['attr_value_sort'] = 0;
                                $attr_array[] = $tpl_array;
                            }
                            $return = Model('attribute')->addAttributeValueAll($attr_array);
                            if(!$return){
                                showMessage($lang['type_index_related_fail']);
                            }
                        }
                    }
                }
            }
            $url = array(
                array(
                    'url'=>'index.php?act=type&op=type_add',
                    'msg'=>$lang['type_index_continue_to_dd']
                ),
                array(
                    'url'=>'index.php?act=type&op=type',
                    'msg'=>$lang['type_index_return_type_list']
                )
            );
            $this->log(L('nc_add,type_index_type_name').'['.$_POST['t_mane'].']',1);
            showMessage($lang['nc_common_save_succ'],$url);
		}

		// 品牌列表
		$model_brand	= Model('brand');
		$brand_list		= $model_brand->getBrandPassedList(array());
		$b_list = array();
		if(is_array($brand_list) && !empty($brand_list)){
			foreach($brand_list as $k=>$val){
				$b_list[$val['class_id']]['brand'][$k] = $val;
				$b_list[$val['class_id']]['name'] = $val['brand_class']==''?L('nc_default'):$val['brand_class'];
			}
		}
		ksort($b_list);
		//规格列表
		$model_spec		= Model('spec');
		$spec_list		= $model_spec->specList(array('order'=>'sp_sort asc'), '', 'sp_id,sp_name,class_id,class_name');
		$s_list = array();
		if(is_array($spec_list) && !empty($spec_list)){
			foreach($spec_list as $k=>$val){
				$s_list[$val['class_id']]['spec'][$k] = $val;
				$s_list[$val['class_id']]['name'] = $val['class_name']==''?L('nc_default'):$val['class_name'];
			}
		}
		ksort($s_list);
		// 一级分类列表
		$gc_list = Model('goods_class')->getGoodsClassListByParentId(0);
		Tpl::output('gc_list', $gc_list);

		Tpl::output('spec_list', $s_list);
		Tpl::output('brand_list', $b_list);
		Tpl::showpage('type.add');
	}

	/**
	 * 编辑类型
	 */
	public function type_editOp(){
		$lang	= Language::getLangContent();
		if(empty($_GET['t_id'])){
			showMessage($lang['param_error']);
		}

		//属性模型
		$model_type = Model('type');

		//编辑保存
		if (chksubmit()){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["t_mane"], "require"=>"true", "message"=>$lang['type_add_name_no_null']),
				array("input"=>$_POST["t_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['type_add_sort_no_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}

			//更新属性关联表信息
			$type_id = intval($_POST['t_id']);

			//品牌
			if($_POST['brand']['form_submit'] == 'ok'){
				$model_type->delType('type_brand', array('type_id'=>$type_id));

				if(!empty($_POST['brand_id'])){
					$brand_array	= $_POST['brand_id'];
					$return = $model_type->typeRelatedAdd('type_brand', $brand_array, $type_id);
					if(!$return){
						showMessage($lang['type_index_related_fail']);
					}
				}

			}

			//规格
			if($_POST['spec']['form_submit'] == 'ok'){
				$model_type->delType('type_spec', array('type_id'=>$type_id));

				if(!empty($_POST['spec_id'])){
					$spec_array		= $_POST['spec_id'];
					$return = $model_type->typeRelatedAdd('type_spec', $spec_array, $type_id);
					if(!$return){
						showMessage($lang['type_index_related_fail']);
					}
				}
			}

			//属性
			// 转码  防止GBK下用中文逗号截取不正确
			$comma = '，';
			if (strtoupper(CHARSET) == 'GBK'){
				$comma = Language::getGBK($comma);
			}

			if(is_array($_POST['at_value']) && !empty($_POST['at_value'])){
				$attribute_array		= $_POST['at_value'];
				foreach ($attribute_array as $v){

					// 要删除的属性id
					$del_array	= array();
					if(!empty($_POST['a_del'])){
						$del_array	= $_POST['a_del'];
					}

					$v['value'] = str_replace($comma,',',$v['value']);						//把属性值中的中文逗号替换成英文逗号

					if(isset($v['form_submit']) && $v['form_submit'] == 'ok' && !in_array($v['a_id'], $del_array)){				//原属性已修改
						/**
						 * 属性
						 */
						$attr_array = array();
						$attr_array['attr_name']	= $v['name'];
						$attr_array['type_id']		= $type_id;
						$attr_array['attr_sort']	= $v['sort'];
						$attr_array['attr_show']	= $v['show'];
						$return	= $model_type->typeUpdate($attr_array, array('type_id'=>$type_id, 'attr_id'=>intval($v['a_id'])), 'attribute');
						if(!$return){
							showMessage($lang['type_index_related_fail']);
						}
					}else if (!isset($v['form_submit'])){									//新增属性
						// 属性
						$attr_array = array();
						$attr_array['attr_name']	= $v['name'];
						$attr_array['attr_value']	= $v['value'];
						$attr_array['type_id']		= $type_id;
						$attr_array['attr_sort']	= $v['sort'];
						$attr_array['attr_show']	= $v['show'];
						$attr_id	= $model_type->typeAdd('attribute',$attr_array);
						if(!$attr_id){
							showMessage($lang['type_index_related_fail']);
						}

                        //添加属性值
                        $attr_value = explode(',', $v['value']);
                        if (!empty($attr_value)) {
                            $attr_array = array();
                            foreach ($attr_value as $val) {
                                $tpl_array = array();
                                $tpl_array['attr_value_name'] = $val;
                                $tpl_array['attr_id'] = $attr_id;
                                $tpl_array['type_id'] = $type_id;
                                $tpl_array['attr_value_sort'] = 0;
                                $attr_array[] = $tpl_array;
                            }
                            $return = Model('attribute')->addAttributeValueAll($attr_array);
                            if(!$return){
                                showMessage($lang['type_index_related_fail']);
                            }
                        }
					}
				}

				// 删除属性
				if(!empty($_POST['a_del'])){
					$del_id	= '"'.implode('","', $_POST['a_del']).'"';
					$model_type->delType('attribute_value', array('in_attr_id'=>$del_id));	//删除属性值
					$model_type->delType('attribute', array('in_attr_id'=>$del_id));	//删除属性
				}

			}

			//更新属性信息
			$type_array = array();
			$type_array['type_name']	= trim($_POST['t_mane']);
			$type_array['type_sort']	= trim($_POST['t_sort']);
			$type_array['class_id']		= $_POST['class_id'];
			$type_array['class_name']	= $_POST['class_name'];
			$return = $model_type->typeUpdate($type_array, array('type_id'=>$type_id), 'type');
			if($return){
				$url = array(
					array(
						'url'=>'index.php?act=type&op=type',
						'msg'=>$lang['type_index_return_type_list']
					)
				);
				$this->log(L('nc_edit,type_index_type_name').'['.$_POST['t_mane'].']',1);
				showMessage($lang['nc_common_save_succ'],$url);
			}else{
				$this->log(L('nc_edit,type_index_type_name').'['.$_POST['t_mane'].']',0);
				showMessage($lang['nc_common_save_fail']);
			}
		}

		//属性列表
		$type_info = $model_type->typeList(array('type_id'=>intval($_GET['t_id'])));
		if(!type_info){
			showMessage($lang['param_error']);
		}
		Tpl::output('type_info', $type_info['0']);

		//品牌
		$model_brand	= Model('brand');
		$brand_list		= $model_brand->getBrandPassedList(array());
		$b_list = array();
		if(is_array($brand_list) && !empty($brand_list)){
			foreach($brand_list as $k=>$val){
				$b_list[$val['class_id']]['brand'][$k] = $val;
				$b_list[$val['class_id']]['name'] = $val['brand_class']==''?L('nc_default'):$val['brand_class'];
			}
		}
		ksort($b_list);
		unset($brand_list);
		//类型与品牌关联列表
		$brand_related	= $model_type->typeRelatedList('type_brand', array('type_id'=>intval($_GET['t_id'])), 'brand_id');
		$b_related = array();
		if(is_array($brand_related) && !empty($brand_related)){
			foreach($brand_related as $val){
				$b_related[] = $val['brand_id'];
			}
		}
		unset($brand_related);
		Tpl::output('brang_related', $b_related);
		Tpl::output('brand_list', $b_list);

		//规格表
		$model_spec		= Model('spec');
		$spec_list		= $model_spec->specList(array('order'=>'sp_sort asc'), '', 'sp_id,sp_name,class_id,class_name');
		$s_list = array();
		if(is_array($spec_list) && !empty($spec_list)){
			foreach($spec_list as $k=>$val){
				$s_list[$val['class_id']]['spec'][$k] = $val;
				$s_list[$val['class_id']]['name'] = $val['class_name']==''?L('nc_default'):$val['class_name'];

			}
		}
		ksort($s_list);
		//规格关联列表
		$spec_related	= $model_type->typeRelatedList('type_spec', array('type_id'=>intval($_GET['t_id'])), 'sp_id');
		$sp_related = array();
		if(is_array($spec_related) && !empty($spec_related)){
			foreach($spec_related as $val){
				$sp_related[] = $val['sp_id'];
			}
		}
		unset($spec_related);
		Tpl::output('spec_related', $sp_related);
		Tpl::output('spec_list', $s_list);


		// 一级分类列表
		$gc_list = Model('goods_class')->getGoodsClassListByParentId(0);
		Tpl::output('gc_list', $gc_list);

		//属性
		$attr_list	= $model_type->typeRelatedList('attribute', array('type_id'=>intval($_GET['t_id']), 'order'=>'attr_sort asc'));
		Tpl::output('attr_list', $attr_list);

		Tpl::showpage('type.edit');
	}

	/**
	 * 编辑属性
	 */
	public function attr_editOp(){
		$lang		= Language::getLangContent();

		$model	= Model();

		if($_POST['form_submit']){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["attr_name"], "require"=>"true", "message"=>$lang['type_edit_type_attr_name_no_null']),
					array("input"=>$_POST["attr_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['type_edit_type_attr_sort_no_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				//更新属性值表
				$attr_value		= $_POST['attr_value'];
				$attr_array = array();

				// 要删除的规格值id
				$del_array	= array();
				if(!empty($_POST['attr_del'])){
					$del_array	= $_POST['attr_del'];
				}
                $model_attribute  = Model('attribute');
				if(!empty($attr_value) && is_array($attr_value)){
					foreach ($attr_value as $key=>$val){
						if(isset($val['form_submit']) && $val['form_submit'] == 'ok' && !in_array(intval($key), $del_array)){		// 属性已修改

							$where = array();
							$where['attr_value_id']	= intval($key);
							$update = array();
							$update['attr_value_name']= $val['name'];
							$update['attr_value_sort']= intval($val['sort']);

							$model_attribute->editAttributeValue($update, $where);

							$attr_array[] = $val['name'];
						}else if(isset($val['form_submit']) && $val['form_submit'] == '' && !in_array(intval($key), $del_array)){	// 属性未修改

							$attr_array[] = $val['name'];
						}else if(!isset($val['form_submit'])){

							$insert = array();
							$insert['attr_value_name'] = $val['name'];
							$insert['attr_id']         = intval($_POST['attr_id']);
							$insert['type_id']         = intval($_POST['type_id']);
							$insert['attr_value_sort'] = intval($val['sort']);

							$model_attribute->addAttributeValue($insert);

							$attr_array[] = $val['name'];
						}
					}

					// 删除属性
					$model->table('attribute_value')->delete(implode(',', $del_array));
				}

				/**
				 * 更新属性
				 */
				$data = array();
				$data['attr_id']	= intval($_POST['attr_id']);
				$data['attr_name']	= $_POST['attr_name'];
				$data['attr_value']	= implode(',', $attr_array);
				$data['attr_show']	= intval($_POST['attr_show']);
				$data['attr_sort']	= intval($_POST['attr_sort']);
				$return = $model->table('attribute')->update($data);

				if($return){
					$this->log(L('type_edit_type_attr_edit').'['.$_POST['attr_name'].']',1);
					showMessage($lang['type_edit_type_attr_edit_succ'],'index.php?act=type&op=type');
				}else{
					$this->log(L('type_edit_type_attr_edit').'['.$_POST['attr_name'].']',0);
					showMessage($lang['type_edit_type_attr_edit_fail'],'','','error');
				}
			}
		}

		$attr_id	= intval($_GET['attr_id']);
		if($attr_id == 0){
			showMessage($lang['param_error']);
		}
		$attr_info	= $model->table('attribute')->where('attr_id='.$attr_id)->find();
		Tpl::output('attr_info', $attr_info);

		$attr_value_list = $model->table('attribute_value')->where('attr_id='.$attr_id)->order('attr_value_sort asc, attr_value_id asc')->select();
		Tpl::output('attr_value_list', $attr_value_list);

		Tpl::showpage('type_attr.edit');
	}

	/**
	 * 删除类型
	 */
	public function type_delOp(){
		$lang	= Language::getLangContent();
		if(empty($_GET['del_id'])) {
			showMessage($lang['param_error']);
		}
		//属性模型
		$model_type = Model('type');

		if(is_array($_GET['del_id'])){
			$id = "'".implode("','", $_GET['del_id'])."'";
		}else{
			$id = intval($_GET['del_id']);
		}
		//属性列表
		$type_list	= $model_type->typeList(array('in_type_id'=>$id));

		if(is_array($type_list) && !empty($type_list)){

			//删除属性值表
			$attr_list	= $model_type->typeRelatedList('attribute', array('in_type_id'=>$id), 'attr_id');
			if(is_array($attr_list) && !empty($attr_list)){
				$attrs_id = '';
				foreach ($attr_list as $val){
					$attrs_id .= '"'.$val['attr_id'].'",';
				}
				$attrs_id = trim($attrs_id, ',');

				$return1 = $model_type->delType('attribute_value', array('in_attr_id'=>$attrs_id));	//删除属性值
				$return2 = $model_type->delType('attribute', array('in_attr_id'=>$attrs_id));		//删除属性
				if(!$return1 || !$return2){
					showMessage($lang['type_index_del_related_attr_fail']);
				}
			}

			//删除对应品牌
			$return = $model_type->delType('type_brand', array('in_type_id'=>$id));
			if(!$return){
				showMessage($lang['type_index_del_related_brand_fail']);
			}

			//删除对应规格
			$return = $model_type->delType('type_spec', array('in_type_id'=>$id));
			if(!$return){
				showMessage($lang['type_index_del_related_type_fail']);
			}

			//删除类型
			$return = $model_type->delType('type', array('in_type_id'=>$id));
			if(!$return){
				showMessage($lang['type_index_del_fail']);
			}

			$this->log(L('nc_delete,type_index_type_name').'[ID:'.$id.']',1);
			showMessage($lang['type_index_del_succ']);
		}else{
			$this->log(L('nc_delete,type_index_type_name').'[ID:'.$id.']',0);
			showMessage($lang['param_error']);
		}
	}

	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		$model_type = Model('type');

		switch ($_GET['branch']){
			case 'sort':
//			case 'name':
				$return = $model_type->typeUpdate(
					array($_GET['column']=>trim($_GET['value'])),
					array('type_id'=>intval($_GET['id'])),
					'type'
				);
				if($return){
					$this->log(L('type_index_type_name,nc_sort').'[ID:'.intval($_GET['id']).']',1);
					echo 'true';exit;
				}else{
					echo 'false';exit;
				}
				break;
		}
	}

	/**
	 * 类型导出
	 */
	public function export_step1Op(){
		$model_type = Model('type');
		$page	= new Page();
		$page->setEachNum(self::EXPORT_SIZE);
		$type_list	= $model_type->typeList(array('order'=>'type_sort asc'),$page);
		if (!is_numeric($_GET['curpage'])){
			$count = $page->getTotalNum();
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);
				Tpl::output('murl','index.php?act=type&op=type');
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$this->createExcel($type_list);
			}
		}else{	//下载
			$this->createExcel($type_list);
		}
	}

	/**
	 * 生成excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()){
		Language::read('export');
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_type_name'));

		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['type_name']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_type_name'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_type_name'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}
