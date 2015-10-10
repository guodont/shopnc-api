<?php
/**
 * 兑换礼品管理
 ***/

defined('InShopNC') or exit('Access Invalid!');
class pointprodControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('pointprod');
	}

	/**
	 * 积分礼品列表
	 */
	public function pointprodOp(){
	    $pointprod_model = Model('pointprod');
	    
	    //获得兑换商品的上下架状态
	    $pgoodsshowstate_arr = $pointprod_model->getPgoodsShowState();
	    //获得兑换商品的推荐状态
	    $pgoodsrecommendstate_arr = $pointprod_model->getPgoodsRecommendState();
	    
	    //条件
	    $where = array();
	    $pgoods_name = trim($_GET['pg_name']);
	    if ($pgoods_name){
	        $where['pgoods_name'] = array('like',"%{$pgoods_name}%");
	    }
	    switch (trim($_GET['pg_state'])){
	    	case 'show':
	    	    $where['pgoods_show'] = $pgoodsshowstate_arr['show'][0];
	    	    break;
    	    case 'nshow':
    	        $where['pgoods_show'] = $pgoodsshowstate_arr['unshow'][0];
    	        break;
	        case 'commend':
	            $where['pgoods_commend'] = $pgoodsrecommendstate_arr['commend'][0];
	            break;
	    }
	    $prod_list = $pointprod_model->getPointProdList($where, '*', 'pgoods_sort asc,pgoods_id desc', 0, 10);
	    //信息输出
	    Tpl::output('prod_list',$prod_list);
	    Tpl::output('show_page',$pointprod_model->showpage());
	    Tpl::showpage('pointprod.list');
	}

	/**
	 * 积分礼品添加
	 */
	public function prod_addOp(){
		$hourarr = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
		$upload_model = Model('upload');
		if (chksubmit()){
			//验证表单
			$obj_validate = new Validate();
			$validate_arr[] = array("input"=>$_POST["goodsname"],"require"=>"true","message"=>L('admin_pointprod_add_goodsname_error'));
			$validate_arr[] = array("input"=>$_POST["goodsprice"],"require"=>"true","validator"=>"DoublePositive","message"=>L('admin_pointprod_add_goodsprice_number_error'));
			$validate_arr[] = array('input'=>$_POST['goodspoints'],'require'=>'true','validator'=>'IntegerPositive','message'=>L('admin_pointprod_add_goodspoint_number_error'));
			$validate_arr[] = array('input'=>$_POST['goodsserial'],'require'=>'true','message'=>L('admin_pointprod_add_goodsserial_null_error'));
			$validate_arr[] = array('input'=>$_POST['goodsstorage'],'require'=>'true','validator'=>'IntegerPositive','message'=>L('admin_pointprod_add_storage_number_error'));
			$validate_arr[] = array('input'=>$_POST['sort'],'require'=>'true','validator'=>'IntegerPositive','message'=>L('admin_pointprod_add_sort_number_error'));
			if ($_POST['islimit'] == 1){
				$validate_arr[] = array('input'=>$_POST['limitnum'],'validator'=>'IntegerPositive','message'=>L('admin_pointprod_add_limitnum_digits_error'));
			}
			if ($_POST['islimittime']){
				$validate_arr[] = array('input'=>$_POST['starttime'],'require'=>'true','message'=>L('admin_pointprod_add_limittime_null_error'));
				$validate_arr[] = array('input'=>$_POST['endtime'],'require'=>'true','message'=>L('admin_pointprod_add_limittime_null_error'));
			}
			$obj_validate->validateparam = $validate_arr;
			$error = $obj_validate->validate();
			if ($error != ''){
				showDialog(L('error').$error,'','error');
			}
			
			$model_pointprod = Model('pointprod');
			$goods_array = array();
			$goods_array['pgoods_name']		= trim($_POST['goodsname']);
			$goods_array['pgoods_tag']		= trim($_POST['goodstag']);
			$goods_array['pgoods_price']	= trim($_POST['goodsprice']);

			$goods_array['pgoods_points']	= trim($_POST['goodspoints']);
			$goods_array['pgoods_serial']	= trim($_POST['goodsserial']);
			$goods_array['pgoods_storage']	= intval($_POST['goodsstorage']);


            $goods_array['pgoods_islimit'] = intval($_POST['islimit']);
            if ($goods_array['pgoods_islimit'] == 1){
            	$goods_array['pgoods_limitnum'] = intval($_POST['limitnum']);
            }else {
            	$goods_array['pgoods_limitnum'] = 0;
            }
            $goods_array['pgoods_islimittime'] = intval($_POST['islimittime']);
            if ($goods_array['pgoods_islimittime'] == 1){
             	//如果添加了开始时间
	            if (trim($_POST['starttime'])){
	            	$starttime = trim($_POST['starttime']);
	            	$sdatearr = explode('-',$starttime);
	            	$starttime = mktime(intval($_POST['starthour']),0,0,$sdatearr[1],$sdatearr[2],$sdatearr[0]);
	            	unset($sdatearr);
	            }
				if (trim($_POST['endtime'])){
	            	$endtime = trim($_POST['endtime']);
	            	$edatearr = explode('-',$endtime);
	            	$endtime = mktime(intval($_POST['endhour']),0,0,$edatearr[1],$edatearr[2],$edatearr[0]);
	            }
	            $goods_array['pgoods_starttime'] = $starttime;
            	$goods_array['pgoods_endtime'] = $endtime;
            }else {
            	$goods_array['pgoods_starttime'] = '';
            	$goods_array['pgoods_endtime'] = '';
            }
			$goods_array['pgoods_show']		= trim($_POST['showstate']);
			$goods_array['pgoods_commend']	= trim($_POST['commendstate']);
			$goods_array['pgoods_add_time']	= time();
			$goods_array['pgoods_state']		= trim($_POST['forbidstate']);
			$goods_array['pgoods_close_reason']		= trim($_POST['forbidreason']);
			$goods_array['pgoods_keywords']		= trim($_POST['keywords']);
			$goods_array['pgoods_description']   = trim($_POST['description']);
			$goods_array['pgoods_body']   = trim($_POST['pgoods_body']);
			$goods_array['pgoods_sort']   = intval($_POST['sort']);
			$goods_array['pgoods_limitmgrade']   = intval($_POST['limitgrade']);
			
			//添加礼品代表图片
			$indeximg_succ = false;
			if (!empty($_FILES['goods_image']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_POINTPROD);
				$upload->set('thumb_width',	'60,240');
				$upload->set('thumb_height','60,240');
				$upload->set('thumb_ext',	'_small,_mid');
				$result = $upload->upfile('goods_image');
				if ($result){
					$indeximg_succ = true;
					$goods_array['pgoods_image'] = $upload->file_name;
				}else {
					showDialog($upload->error,'','error');
				}
			}
			$state = $model_pointprod->addPointGoods($goods_array);
			if($state){
				//礼品代表图片数据入库
				if ($indeximg_succ){
					$insert_array = array();
					$insert_array['file_name'] = $upload->file_name;
					$insert_array['file_thumb'] = $upload->thumb_image;
					$insert_array['upload_type'] = 5;
					$insert_array['file_size'] = filesize(BASE_UPLOAD_PATH.DS.ATTACH_POINTPROD.DS.$upload->file_name);
					$insert_array['item_id'] = $state;
					$insert_array['upload_time'] = time();
					$upload_model->add($insert_array);
				}
				//更新积分礼品描述图片
				$file_idstr = '';
				if (is_array($_POST['file_id']) && count($_POST['file_id'])>0){
					$file_idstr = "'".implode("','",$_POST['file_id'])."'";
				}
				$upload_model->updatebywhere(array('item_id'=>$state),array('upload_type'=>6,'item_id'=>'0','upload_id_in'=>"{$file_idstr}"));
				$this->log(L('admin_pointprod_add_title').'['.$_POST['goodsname'].']');
				showDialog(L('admin_pointprod_add_success'),'index.php?act=pointprod&op=pointprod','succ');
			}
		}
		//模型实例化
		$where = array();
		$where['upload_type'] = '6';
		$where['item_id'] = '0';
		$file_upload = $upload_model->getUploadList($where);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.DS.ATTACH_POINTPROD.DS.$file_upload[$k]['file_name'];
			}
		}
		Tpl::output('file_upload',$file_upload);
		Tpl::output('PHPSESSID',session_id());
		$hourarr = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
		Tpl::output('hourarr',$hourarr);
		//会员级别
		$member_grade = Model('member')->getMemberGradeArr();
		Tpl::output('member_grade',$member_grade);
		Tpl::showpage('pointprod.add');
	}

	/**
	 * 积分礼品编辑
	 */
	public function prod_editOp(){
		$hourarr = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
		$upload_model = Model('upload');
		$pg_id = intval($_GET['pg_id']);
		if (!$pg_id){
			showDialog(L('admin_pointprod_parameter_error'),'index.php?act=pointprod&op=pointprod','error');
		}
		$model_pointprod = Model('pointprod');
		//查询礼品记录是否存在
		$prod_info = $model_pointprod->getPointProdInfo(array('pgoods_id'=>$pg_id));
		if (!$prod_info){
			showDialog(L('admin_pointprod_record_error'),'index.php?act=pointprod&op=pointprod','error');
		}
		if (chksubmit()){
			//验证表单
			$obj_validate = new Validate();
			$validate_arr[] = array("input"=>$_POST["goodsname"],"require"=>"true","message"=>L('admin_pointprod_add_goodsname_error'));
			$validate_arr[] = array("input"=>$_POST["goodsprice"],"require"=>"true","validator"=>"DoublePositive","message"=>L('admin_pointprod_add_goodsprice_number_error'));
			$validate_arr[] = array('input'=>$_POST['goodspoints'],'require'=>'true','validator'=>'IntegerPositive','message'=>L('admin_pointprod_add_goodspoint_number_error'));
			$validate_arr[] = array('input'=>$_POST['goodsserial'],'require'=>'true','message'=>L('admin_pointprod_add_goodsserial_null_error'));
			$validate_arr[] = array('input'=>$_POST['goodsstorage'],'require'=>'true','validator'=>'IntegerPositive','message'=>L('admin_pointprod_add_storage_number_error'));
			$validate_arr[] = array('input'=>$_POST['sort'],'require'=>'true','validator'=>'IntegerPositive','message'=>L('admin_pointprod_add_sort_number_error'));
			if ($_POST['islimit'] == 1){
				$validate_arr[] = array('input'=>$_POST['limitnum'],'validator'=>'IntegerPositive','message'=>L('admin_pointprod_add_limitnum_digits_error'));
			}
			if ($_POST['islimittime']){
				$validate_arr[] = array('input'=>$_POST['starttime'],'require'=>'true','message'=>L('admin_pointprod_add_limittime_null_error'));
				$validate_arr[] = array('input'=>$_POST['endtime'],'require'=>'true','message'=>L('admin_pointprod_add_limittime_null_error'));
			}
			$obj_validate->validateparam = $validate_arr;
			$error = $obj_validate->validate();
			if ($error != ''){
				showDialog(L('error').$error,'','error');
			}
			//实例化店铺商品模型
			$model_pointprod	= Model('pointprod');

			$goods_array			= array();
			$goods_array['pgoods_name']		= trim($_POST['goodsname']);
			$goods_array['pgoods_tag']		= trim($_POST['goodstag']);
			$goods_array['pgoods_price']	= trim($_POST['goodsprice']);

			$goods_array['pgoods_points']	= trim($_POST['goodspoints']);
			$goods_array['pgoods_serial']	= trim($_POST['goodsserial']);
			$goods_array['pgoods_storage']	= intval($_POST['goodsstorage']);
            $goods_array['pgoods_islimit'] = intval($_POST['islimit']);
            if ($goods_array['pgoods_islimit'] == 1){
            	$goods_array['pgoods_limitnum'] = intval($_POST['limitnum']);
            }else {
            	$goods_array['pgoods_limitnum'] = 0;
            }
            $goods_array['pgoods_islimittime'] = intval($_POST['islimittime']);
            if ($goods_array['pgoods_islimittime'] == 1){
             	//如果添加了开始时间
	            if (trim($_POST['starttime'])){
	            	$starttime = trim($_POST['starttime']);
	            	$sdatearr = explode('-',$starttime);
	            	$starttime = mktime(intval($_POST['starthour']),0,0,$sdatearr[1],$sdatearr[2],$sdatearr[0]);
	            	unset($sdatearr);
	            }
				if (trim($_POST['endtime'])){
	            	$endtime = trim($_POST['endtime']);
	            	$edatearr = explode('-',$endtime);
	            	$endtime = mktime(intval($_POST['endhour']),0,0,$edatearr[1],$edatearr[2],$edatearr[0]);
	            }
	            $goods_array['pgoods_starttime'] = $starttime;
            	$goods_array['pgoods_endtime'] = $endtime;
            }else {
            	$goods_array['pgoods_starttime'] = '';
            	$goods_array['pgoods_endtime'] = '';
            }
			$goods_array['pgoods_show']		= trim($_POST['showstate']);
			$goods_array['pgoods_commend']	= trim($_POST['commendstate']);
			$goods_array['pgoods_state']		= trim($_POST['forbidstate']);
			$goods_array['pgoods_close_reason']		= trim($_POST['forbidreason']);
			$goods_array['pgoods_keywords']		= trim($_POST['keywords']);
			$goods_array['pgoods_description']   = trim($_POST['description']);
			$goods_array['pgoods_body']   = trim($_POST['pgoods_body']);
			$goods_array['pgoods_sort']   = intval($_POST['sort']);
			$goods_array['pgoods_limitmgrade']   = intval($_POST['limitgrade']);
			//添加礼品代表图片
			$indeximg_succ = false;
			if (!empty($_FILES['goods_image']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_POINTPROD);
				$upload->set('thumb_width',	'60,240');
				$upload->set('thumb_height','60,240');
				$upload->set('thumb_ext',	'_small,_mid');
				$result = $upload->upfile('goods_image');
				if ($result){
					$indeximg_succ = true;
					$goods_array['pgoods_image'] = $upload->file_name;
				}else {
					showDialog($upload->error,'','error');
				}
			}
			$state = $model_pointprod->editPointProd($goods_array,array('pgoods_id'=>$prod_info['pgoods_id']));
			if($state){
				//礼品代表图片数据入库
				if ($indeximg_succ){
					//删除原有图片
					$upload_list = $upload_model->getUploadList(array('upload_type'=>5,'item_id'=>$prod_info['pgoods_id']));

					if (is_array($upload_list) && count($upload_list)>0){
						$upload_idarr = array();
						foreach ($upload_list as $v){
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_POINTPROD.DS.$v['file_name']);
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_POINTPROD.DS.$v['file_thumb']);
							$upload_idarr[] = $v['upload_id'];
						}
						//删除图片
						$upload_model->dropUploadById($upload_idarr);
					}
					$insert_array = array();
					$insert_array['file_name'] = $upload->file_name;
					$insert_array['file_thumb'] = $upload->thumb_image;
					$insert_array['upload_type'] = 5;
					$insert_array['file_size'] = filesize(BASE_UPLOAD_PATH.DS.DS.ATTACH_POINTPROD.DS.$upload->file_name);
					$insert_array['item_id'] = $prod_info['pgoods_id'];
					$insert_array['upload_time'] = time();
					$upload_model->add($insert_array);
				}
				//更新积分礼品描述图片
				$file_idstr = '';
				if (is_array($_POST['file_id']) && count($_POST['file_id'])>0){
				    $file_idstr = "'".implode("','",$_POST['file_id'])."'";
				}
				$upload_model->updatebywhere(array('item_id'=>$prod_info['pgoods_id']),array('upload_type'=>6,'item_id'=>'0','upload_id_in'=>"{$file_idstr}"));
				
				$this->log(L('nc_edit,admin_pointprodp').'['.$_POST['goodsname'].']');
				showDialog(L('admin_pointprod_edit_success'),'index.php?act=pointprod&op=pointprod','succ');
			}
		}else {
		    $where = array();
			$where['upload_type'] = '6';
			$where['item_id'] = $prod_info['pgoods_id'];
			$file_upload = $upload_model->getUploadList($where);
			if (is_array($file_upload)){
				foreach ($file_upload as $k => $v){
					$file_upload[$k]['upload_path'] = UPLOAD_SITE_URL.DS.ATTACH_POINTPROD.DS.$file_upload[$k]['file_name'];
				}
			}
    		//会员级别
    		$member_grade = Model('member')->getMemberGradeArr();
    		Tpl::output('member_grade',$member_grade);
			Tpl::output('file_upload',$file_upload);
			Tpl::output('PHPSESSID',session_id());
			Tpl::output('hourarr',$hourarr);
			Tpl::output('prod_info',$prod_info);
			Tpl::showpage('pointprod.edit');
		}
	}

	/**
	 * 删除积分礼品
	 */
	public function prod_dropOp(){
		$pg_id = intval($_GET['pg_id']);
		if (!$pg_id){
			showDialog(L('admin_pointprod_parameter_error'),'index.php?act=pointprod&op=pointprod','error');
		}
		$model_pointprod = Model('pointprod');
		//查询礼品是否存在
		$prod_info = $model_pointprod->getPointProdInfo(array('pgoods_id'=>$pg_id));
		if (!is_array($prod_info) || count($prod_info)<=0){
			showDialog(L('admin_pointprod_record_error'),'index.php?act=pointprod&op=pointprod','error');
		}
		//查询积分礼品的下属信息（比如兑换信息）
		//删除操作
		$result = $model_pointprod->delPointProdById($pg_id);
		if($result) {
			$this->log(L('nc_del,admin_pointprodp').'[ID:'.$pg_id.']');
			showDialog(L('admin_pointprod_del_success'),'index.php?act=pointprod&op=pointprod','succ');
		} else {
			showDialog(L('admin_pointprod_del_fail'),'index.php?act=pointprod&op=pointprod','error');
		}
	}

	/**
	 * 批量删除积分礼品
	 */
	public function prod_dropallOp(){
		$pg_id = $_POST['pg_id'];
		if (!$pg_id){
			showDialog(L('admin_pointprod_parameter_error'),'index.php?act=pointprod&op=pointprod','','error');
		}
		$result = Model('pointprod')->delPointProdById($pg_id);
		if($result) {
			$this->log(L('nc_del,admin_pointprodp').'[ID:'.implode(',',$pg_id).']');
			showDialog(L('admin_pointprod_del_success'),'index.php?act=pointprod&op=pointprod','succ');
		} else {
			showDialog(L('admin_pointprod_del_fail'),'index.php?act=pointprod&op=pointprod','','error');
		}
	}

	/**
	 * 积分礼品异步状态修改
	 */
	public function ajaxOp(){
		//礼品上架,礼品推荐,礼品禁售
		$id = intval($_GET['id']);
		if ($id <= 0){
			echo 'false'; exit;
		}
		$model_pointprod = Model('pointprod');
		$update_array = array();
		$update_array[$_GET['column']] = trim($_GET['value']);
		$model_pointprod->editPointProd($update_array,array('pgoods_id'=>$id));
		echo 'true';exit;
	}
	/**
	 * 积分礼品上传
	 */
	public function pointprod_pic_uploadOp(){
	    /**
	     * 上传图片
	     */
	    $upload = new UploadFile();
	    $upload->set('default_dir',ATTACH_POINTPROD);

	    $result = $upload->upfile('fileupload');
	    if ($result){
	        $_POST['pic'] = $upload->file_name;
	    }else {
	        echo 'error';exit;
	    }
	    /**
	     * 模型实例化
	     */
	    $model_upload = Model('upload');
	    /**
	     * 图片数据入库
	    */
	    $insert_array = array();
	    $insert_array['file_name'] = $_POST['pic'];
	    $insert_array['upload_type'] = '6';
	    $insert_array['file_size'] = $_FILES['Filedata']['size'];
	    $insert_array['upload_time'] = time();
	    $insert_array['item_id'] = intval($_POST['item_id']);
	    $result = $model_upload->add($insert_array);
	    if ($result){
	        $data = array();
	        $data['file_id'] = $result;
	        $data['file_name'] = $_POST['pic'];
	        $data['file_path'] = $_POST['pic'];
	        /**
	         * 整理为json格式
	         */
	        $output = json_encode($data);
	        echo $output;
	    }
	}
	/**
	 * ajax操作删除已上传图片
	 */
	public function ajaxdeluploadOp(){
		//删除文章图片
		if (intval($_GET['file_id']) > 0){
			$model_upload = Model('upload');
			/**
			 * 删除图片
			 */
			$file_array = $model_upload->getOneUpload(intval($_GET['file_id']));
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_POINTPROD.DS.$file_array['file_name']);
			/**
			 * 删除信息
			 */
			$model_upload->del(intval($_GET['file_id']));
			echo 'true';exit;
		}else {
			echo 'false';exit;
		}
	}
}
