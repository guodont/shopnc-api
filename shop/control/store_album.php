<?php
/**
 * 图片空间操作
 ***/


defined('InShopNC') or exit('Access Invalid!');
class store_albumControl extends BaseSellerControl {
	public function indexOp(){
		$this->album_cateOp();
		exit;
	}
	public function __construct() {
		parent::__construct();
		Language::read('member_store_album');
	}

	/**
	 * 相册分类列表
	 *
	 */
	public function album_cateOp(){
		$model_album = Model('album');

		/**
		 * 验证是否存在默认相册
		 */
		$return = $model_album->checkAlbum(array('album_aclass.store_id'=>$_SESSION['store_id'],'is_default'=>'1'));
		if(!$return){
			$album_arr = array();
			$album_arr['aclass_name'] = Language::get('album_default_album');
			$album_arr['store_id'] = $_SESSION['store_id'];
			$album_arr['aclass_des'] = '';
			$album_arr['aclass_sort'] = '255';
			$album_arr['aclass_cover'] = '';
			$album_arr['upload_time'] = time();
			$album_arr['is_default'] = '1';
			$model_album->addClass($album_arr);
		}

		/**
		 * 相册分类
		 */
		$param = array();
		$param['album_aclass.store_id']	= $_SESSION['store_id'];
		$param['order']					= 'aclass_sort desc';
		if($_GET['sort'] != ''){
			switch ($_GET['sort']){
				case '0':
					$param['order']		= 'upload_time desc';
					break;
				case '1':
					$param['order']		= 'upload_time asc';
					break;
				case '2':
					$param['order']		= 'aclass_name desc';
					break;
				case '3':
					$param['order']		= 'aclass_name asc';
					break;
				case '4':
					$param['order']		= 'aclass_sort desc';
					break;
				case '5':
					$param['order']		= 'aclass_sort asc';
					break;
			}
		}
		$aclass_info = $model_album->getClassList($param,$page);
		Tpl::output('aclass_info',$aclass_info);
//		Tpl::output('show_page',$page->show());

		Tpl::output('PHPSESSID',session_id());
		self::profile_menu('album','album');
		Tpl::showpage('store_album.list');
	}
	/**
	 * 相册分类添加
	 *
	 */
	public function album_addOp(){
		/**
		 * 实例化相册模型
		 */
		$model_album = Model('album');
		$class_count = $model_album->countClass($_SESSION['store_id']);
		Tpl::output('class_count',$class_count['count']);
		Tpl::showpage('store_album.class_add','null_layout');
	}
	/**
	 * 相册保存
	 *
	 */
	public function album_add_saveOp(){
		if (chksubmit()){
			/**
			 * 实例化相册模型
			 */
			$model_album = Model('album');
			$class_count = $model_album->countClass($_SESSION['store_id']);
			if($class_count['count'] >= 20){
				showDialog(Language::get('album_class_save_max_20'),'index.php?act=store_album','error',empty($_GET['inajax'])?'':'CUR_DIALOG.close();');
			}
			/**
			 * 实例化相册模型
			 */
			$param = array();
			$param['aclass_name']	= $_POST['name'];
			$param['store_id']		= $_SESSION['store_id'];
			$param['aclass_des']	= $_POST['description'];
			$param['aclass_sort']	= $_POST['sort'];
			$param['upload_time']	= time();

			$return = $model_album->addClass($param);
			if($return){
				showDialog(Language::get('album_class_save_succeed'),'index.php?act=store_album','succ',empty($_GET['inajax'])?'':'CUR_DIALOG.close();');
			}
		}
		showDialog(Language::get('album_class_save_lose'));
	}
	/**
	 * 相册分类编辑
	 */
	public function album_editOp(){
		if(empty($_GET['id'])){
			echo Language::get('album_parameter_error');exit;
		}
		/**
		 * 实例化相册模型
		 */
		$model_album = Model('album');
		$param = array();
		$param['field']		= array('aclass_id','store_id');
		$param['value']		= array(intval($_GET['id']),$_SESSION['store_id']);
		$class_info = $model_album->getOneClass($param);
		Tpl::output('class_info',$class_info);

		Tpl::showpage('store_album.class_edit','null_layout');
	}
	/**
	 * 相册分类编辑保存
	 */
	public function album_edit_saveOp(){
		$param = array();
		$param['aclass_name']	= $_POST['name'];
		$param['aclass_des']	= $_POST['description'];
		$param['aclass_sort']	= $_POST['sort'];


		/**
		 * 实例化相册模型
		 */
		$model_album = Model('album');
		/**
		 * 验证
		 */
		$return	= $model_album->checkAlbum(array('album_aclass.store_id'=>$_SESSION['store_id'],'album_aclass.aclass_id'=>intval($_POST['id'])));
		if($return){
			/**
			 * 更新
			 */
			$re = $model_album->updateClass($param,intval($_POST['id']));
			if($re){
				showDialog(Language::get('album_class_edit_succeed'),'index.php?act=store_album','succ',empty($_GET['inajax'])?'':'CUR_DIALOG.close();');
			}
		}else{
			showDialog(Language::get('album_class_edit_lose'));
		}
	}
	/**
	 * 相册删除
	 */
	public function album_delOp(){
		if(empty($_GET['id'])){
			showMessage(Language::get('album_parameter_error'),'','html','error');
		}
		/**
		 * 实例化相册模型
		 */
		$model_album = Model('album');

		/**
		 * 验证
		 */
		$return = $model_album->checkAlbum(array('album_aclass.store_id'=>$_SESSION['store_id'],'album_aclass.aclass_id'=>intval($_GET['id']),'is_default'=>'0'));
		if(!$return){
			showDialog(Language::get('album_class_file_del_lose'));
		}
		/**
		 * 删除分类
		 */
		$return = $model_album->delClass(intval($_GET['id']));
		if(!$return){
			showDialog(Language::get('album_class_file_del_lose'));
		}
		/**
		 * 更新图片分类
		 */
		$param = array();
		$param['field']		= array('is_default','store_id');
		$param['value']		= array('1',$_SESSION['store_id']);
		$class_info = $model_album->getOneClass($param);
		$param = array();
		$param['aclass_id'] = $class_info['aclass_id'];
		$return = $model_album->updatePic($param,array('aclass_id'=>intval($_GET['id'])));
		if($return){
			showDialog(Language::get('album_class_file_del_succeed'),'index.php?act=store_album','succ');
		}else{
			showDialog(Language::get('album_class_file_del_lose'));
		}
	}
	/**
	 * 图片列表
	 */
	public function album_pic_listOp(){
		if(empty($_GET['id'])) {
			showMessage(Language::get('album_parameter_error'),'','html','error');
		}

		/**
		 * 分页类
		 */
		$page	= new Page();
		$page->setEachNum(15);
		$page->setStyle('admin');

		/**
		 * 实例化相册类
		 */
		$model_album = Model('album');

		$param = array();
		$param['aclass_id']	= intval($_GET['id']);
		$param['album_pic.store_id']	= $_SESSION['store_id'];
		if($_GET['sort'] != ''){
			switch ($_GET['sort']){
				case '0':
					$param['order']		= 'upload_time desc';
					break;
				case '1':
					$param['order']		= 'upload_time asc';
					break;
				case '2':
					$param['order']		= 'apic_size desc';
					break;
				case '3':
					$param['order']		= 'apic_size asc';
					break;
				case '4':
					$param['order']		= 'apic_name desc';
					break;
				case '5':
					$param['order']		= 'apic_name asc';
					break;
			}
		}
		$pic_list = $model_album->getPicList($param,$page);
		Tpl::output('pic_list',$pic_list);
		Tpl::output('show_page',$page->show());

		/**
		 * 相册列表，移动
		 */
		$param = array();
		$param['album_class.un_aclass_id']	= intval($_GET['id']);
		$param['album_aclass.store_id']	= $_SESSION['store_id'];
		$class_list = $model_album->getClassList($param);
		Tpl::output('class_list',$class_list);
		/**
		 * 相册信息
		 */
		$param = array();
		$param['field']		= array('aclass_id','store_id');
		$param['value']		= array(intval($_GET['id']),$_SESSION['store_id']);
		$class_info			= $model_album->getOneClass($param);
		Tpl::output('class_info',$class_info);

		Tpl::output('PHPSESSID',session_id());
		self::profile_menu('album_pic','pic_list');
		Tpl::showpage('store_album.pic_list');
	}
	/**
	 * 图片列表，外部调用
	 */
	public function pic_listOp(){

		/**
		 * 分页类
		 */
		$page	= new Page();
        if(in_array($_GET['item'] , array('goods_image'))) {
            $page->setEachNum(12);
        } else {
            $page->setEachNum(14);
        }
		$page->setStyle('admin');

		/**
		 * 实例化相册类
		 */
		$model_album = Model('album');
		/**
		 * 图片列表
		 */
		$param = array();
		$param['album_pic.store_id']	= $_SESSION['store_id'];
		if(!empty($_GET) && $_GET['id'] != '0'){
			$param['aclass_id']	= intval($_GET['id']);
			/**
			 * 分类列表
			 */
			$cparam = array();
			$cparam['field']		= array('aclass_id','store_id');
			$cparam['value']		= array(intval($_GET['id']),$_SESSION['store_id']);
			$cinfo			= $model_album->getOneClass($cparam);
			Tpl::output('class_name',$cinfo['aclass_name']);
		}
		$pic_list = $model_album->getPicList($param,$page);
		Tpl::output('pic_list',$pic_list);
		Tpl::output('show_page',$page->show());
		/**
		 * 分类列表
		 */
		$param = array();
		$param['album_aclass.store_id']	= $_SESSION['store_id'];
		$class_info			= $model_album->getClassList($param);
		Tpl::output('class_list',$class_info);

        switch($_GET['item']) {
        case 'goods':
            Tpl::showpage('store_goods_add.step2_master_image','null_layout');
            break;
        case 'des':
            Tpl::showpage('store_goods_add.step2_desc_image','null_layout');
            break;
        case 'groupbuy':
            Tpl::showpage('store_groupbuy.album','null_layout');
            break;
        case 'store_sns_normal':
            Tpl::showpage('store_sns_add.album', 'null_layout');
            break;
        case 'goods_image':
            Tpl::output('color_id', $_GET['color_id']);
            Tpl::showpage('store_goods_add.step3_goods_image', 'null_layout');
            break;
        case 'mobile':
            Tpl::output('type', $_GET['type']);
            Tpl::showpage('store_goods_add.step2_mobile_image', 'null_layout');
            break;
        }
    }
	/**
	 * 修改相册封面
	 */
	public function change_album_coverOp(){
		if(empty($_GET['id'])) {
			showDialog(Language::get('nc_common_op_fail'));
		}
		/**
		 * 实例化相册类
		 */
		$model_album = Model('album');
		/**
		 * 图片信息
		 */
		$param = array();
		$param['field']		= array('apic_id','store_id');
		$param['value']		= array(intval($_GET['id']),$_SESSION['store_id']);
		$pic_info			= $model_album->getOnePicById($param);
		$return = $model_album->checkAlbum(array('album_aclass.store_id'=>$_SESSION['store_id'],'album_aclass.aclass_id'=>$pic_info['aclass_id']));
		if($return){
			$re = $model_album->updateClass(array('aclass_cover'=>$pic_info['apic_cover']),$pic_info['aclass_id']);
			if($re){
				showDialog(Language::get('nc_common_op_succ'),'reload','succ');
			}
		}else{
			showDialog(Language::get('nc_common_op_fail'));
		}
	}
	/**
	 * ajax修改图名称
	 */
	public function change_pic_nameOp(){
		if(empty($_POST['id']) && empty($_POST['name'])){
			echo 'false';
		}
		/**
		 * 实例化相册类
		 */
		$model_album = Model('album');

		/**
		 * 更新图片名称
		 */
		if(strtoupper(CHARSET) == 'GBK'){
			$_POST['name'] = Language::getGBK($_POST['name']);
		}
		$return = $model_album->updatePic(array('apic_name'=>$_POST['name']),array('apic_id'=>intval($_POST['id'])));
		if($return){
			echo 'true';
		}else{
			echo 'false';
		}
	}
	/**
	 * 图片详细页
	 */
	public function album_pic_infoOp(){
		if(empty($_GET['class_id']) && empty($_GET['id'])){
			showMessage(Language::get('album_parameter_error'),'','html','error');
		}
		/**
		 * 实例化相册类
		 */
		$model_album = Model('album');

		/**
		 * 验证
		 */
		$return = $model_album->checkAlbum(array('album_pic.store_id'=>$_SESSION['store_id'],'album_pic.apic_id'=>intval($_GET['id'])));
		if(!$return){
			showMessage(Language::get('album_parameter_error'),'','html','error');
		}

		/**
		 * 图片列表
		 */
		$param = array();
		$param['aclass_id']			= intval($_GET['class_id']);
		$param['store_id']			= $_SESSION['store_id'];
		$page	= new Page();
		$each_num = 9;
		$page->setEachNum($each_num);
		$pic_list					= $model_album->getPicList($param,$page);
		Tpl::output('pic_list',$pic_list);

		$curpage = intval($_GET['curpage']);
		if (empty($curpage)) $curpage = 1;
		$total_page = (ceil($page->get('total_num')/$each_num));

		Tpl::output('total_page',$total_page);
		Tpl::output('curpage',$curpage);

		$curpage = intval($_GET['curpage']);
		if (empty($curpage)) $curpage = 1;
		$tatal_page = (ceil($page->get('total_num')/$each_num));
		Tpl::output('tatal_page',$tatal_page);
		Tpl::output('curpage',$curpage);


		/**
		 * 相册信息
		 */
		$param = array();
		$param['field']		= array('aclass_id','store_id');
		$param['value']		= array(intval($_GET['class_id']),$_SESSION['store_id']);
		$class_info			= $model_album->getOneClass($param);
		Tpl::output('class_info',$class_info);

		/**
		 * 图片信息
		 */
		$param = array();
		$param['field']		= array('apic_id','store_id');
		$param['value']		= array(intval($_GET['id']),$_SESSION['store_id']);
		$pic_info			= $model_album->getOnePicById($param);
		$pic_info['apic_size'] = sprintf('%.2f',intval($pic_info['apic_size'])/1024);
		Tpl::output('pic_info',$pic_info);

		self::profile_menu('album_pic_info','pic_info');
		Tpl::showpage('store_album.pic_info');
	}

	/**
	 * 图片 ajax
	 */
	public function album_ad_ajaxOp(){
		if(empty($_GET['class_id']) && empty($_GET['id'])){
			exit();
		}

		$model_album = Model('album');

		$return = $model_album->checkAlbum(array('album_pic.store_id'=>$_SESSION['store_id'],'album_pic.apic_id'=>intval($_GET['id'])));
		if(!$return){
			exit();
		}

		/**
		 * 图片列表
		 */
		$param = array();
		$param['aclass_id']			= intval($_GET['class_id']);
		$param['store_id']			= $_SESSION['store_id'];
		$page	= new Page();
		$each_num = 9;
		$page->setEachNum($each_num);
		$pic_list					= $model_album->getPicList($param,$page);
		Tpl::output('pic_list',$pic_list);

		Tpl::showpage('store_album.pic_scroll_ajax','null_layout');
	}

	/**
	 * 图片删除
	 */
	public function album_pic_delOp(){
		if (empty($_POST)) $_POST = $_GET;
		if(empty($_POST['id'])) {
			showDialog(Language::get('album_parameter_error'));
		}
		$model_album = Model('album');
		if(!empty($_POST['id']) && is_array($_POST['id'])){
			$id = "'".implode("','", $_POST['id'])."'";
		}else{
			$id = "'".intval($_POST['id'])."'";
		}

		$return = $model_album->checkAlbum(array('album_pic.store_id'=>$_SESSION['store_id'],'in_apic_id'=>$id));
		if(!$return){
			showDialog(Language::get('album_class_pic_del_lose'));
		}

		//删除图片
		$return = $model_album->delPic($id, $_SESSION['store_id']);
		if($return){
			showDialog(Language::get('album_class_pic_del_succeed'),'reload','succ');
		}else{
			showDialog(Language::get('album_class_pic_del_lose'));
		}
	}

	/**
	 * 移动相册
	 */
	public function album_pic_moveOp(){
		/**
		 * 实例化相册类
		 */
		$model_album = Model('album');
		if(chksubmit()){
			if(empty($_REQUEST['id'])){
				showDialog(Language::get('album_parameter_error'));
			}
			if(!empty($_REQUEST['id']) && is_array($_REQUEST['id'])){
				$_REQUEST['id'] = trim(implode("','", $_REQUEST['id']),',');
			}

				/**
				 * 验证封面图片
				 */
				$param = array();
				$param['in_apic_id'] = "'".$_REQUEST['id']."'";
				$list_pic = $model_album->getClassList($param);
				$class_cover = $list_pic['0']['aclass_cover'];
				$class_id	 = $list_pic['0']['aclass_id'];
				unset($list_pic);
				if($class_cover != ''){
					$list_pic = $model_album->getPicList($param);
					foreach ($list_pic as $val){
						if(str_ireplace('.', '_small.', $val['apic_cover']) == $class_cover){
							$model_album->updateClass(array('aclass_cover'=>''),$class_id);
							break;
						}
					}
				}

			$param = array();
			$param['aclass_id'] = $_REQUEST['cid'];
			$return = $model_album->updatePic($param,array('in_apic_id'=>"'".$_REQUEST['id']."'"));
			if($return){
				showDialog(Language::get('album_class_pic_move_succeed'),'reload','succ');
			}else{
				showDialog(Language::get('album_class_pic_move_lose'));
			}
		}
		$param = array();
		$param['album_class.un_aclass_id']	= $_GET['cid'];
		$param['album_aclass.store_id']	= $_SESSION['store_id'];
		$class_list = $model_album->getClassList($param);

		if(isset($_GET['id']) && !empty($_GET['id'])){
			Tpl::output('id',$_GET['id']);
		}
		Tpl::output('class_list',$class_list);
		Tpl::showpage('store_album.move','null_layout');
	}

    /**
     * 替换图片
     */
    public function replace_image_uploadOp() {
        $file = $_GET['id'];
        $tpl_array = explode('_', $file);
        $id = intval(end($tpl_array));
        $model_album = Model('album');
        $param = array();
        $param['field'] = array('apic_id', 'store_id');
        $param['value'] = array($id, $_SESSION['store_id']);
        $apic_info = $model_album->getOnePicById($param);
        if (substr(strrchr($apic_info['apic_cover'], "."), 1) != substr(strrchr($_FILES[$file]["name"], "."), 1)) {
            // 后缀名必须相同
            $error = L('album_replace_same_type');
            if (strtoupper(CHARSET) == 'GBK') {
                $error = Language::getUTF8($error);
            }
            echo json_encode( array('state' => 'false', 'message' => $error) );
            exit();
        }
        $pic_cover = implode(DS, explode(DS, $apic_info['apic_cover'], -1)); // 文件路径
        $tmpvar = explode(DS, $apic_info['apic_cover']);
        $pic_name = end($tmpvar); // 文件名称
        /**
         * 上传图片
         */
        $upload = new UploadFile();
        $upload->set('default_dir', ATTACH_GOODS . DS . $_SESSION['store_id'] . DS . $pic_cover);
        $upload->set('max_size', C('image_max_filesize'));
        $upload->set('thumb_width', GOODS_IMAGES_WIDTH);
        $upload->set('thumb_height', GOODS_IMAGES_HEIGHT);
        $upload->set('thumb_ext', GOODS_IMAGES_EXT);
        $upload->set('file_name', $pic_name);
        $return = $upload->upfile($file);
        if (!$return) {
            // 后缀名必须相同、
            if (strtoupper(CHARSET) == 'GBK') {
                $error = Language::getUTF8($upload->error);
            }
            echo json_encode( array('state' => 'false', 'message' => $upload->error) );
            exit();
        }
        /**
         * 取得图像大小
         */
        list($width, $height, $type, $attr) = getimagesize(BASE_UPLOAD_PATH . DS . ATTACH_GOODS . DS . $_SESSION['store_id'] . DS . $apic_info['apic_cover']);
        /**
         * 更新图片分类
         */
        $param = array();
        $param['apic_size'] = intval($_FILES[$file]['size']);
        $param['apic_spec'] = $width . 'x' . $height;
        $return = $model_album->updatePic($param, array('apic_id' => $id));

        echo json_encode( array('state' => 'true', 'id' => $id) );
        exit();
    }
	/**
	 * 添加水印
	 */
	public function album_pic_watermarkOp(){
		if(empty($_POST['id']) && !is_array($_POST['id'])) {
			showDialog(Language::get('album_parameter_error'));
		}

		$id = trim(implode(',', $_POST['id']),',');

		/**
		 * 实例化图片模型
		 */
		$model_album = Model('album');
		$param['in_apic_id']	= $id;
		$param['store_id']		= $_SESSION['store_id'];
		$wm_list = $model_album->getPicList($param);
		$model_store_wm = Model('store_watermark');
		$store_wm_info = $model_store_wm->getOneStoreWMByStoreId($_SESSION['store_id']);
		if ($store_wm_info['wm_image_name'] == '' && $store_wm_info['wm_text'] == ''){
			showDialog(Language::get('album_class_setting_wm'),"index.php?act=store_album&op=store_watermark",'error','CUR_DIALOG.close();');//"请先设置水印"
		}
		import('libraries.gdimage');
		$gd_image = new GdImage();
		$gd_image->setWatermark($store_wm_info);

		foreach ($wm_list as $v) {
			$gd_image->create(BASE_UPLOAD_PATH.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].DS.str_ireplace('.', '_1280.', $v['apic_cover']));//生成有水印的大图
		}
		showDialog(Language::get('album_pic_plus_wm_succeed'),'reload','succ');
	}
	/**
	 * 水印管理
	 */
	public function store_watermarkOp(){
		/**
		 * 读取语言包
		 */
		Language::read('member_store_index');
		$model_store_wm = Model('store_watermark');
		/**
		 * 获取会员水印设置
		 */
		$store_wm_info = $model_store_wm->getOneStoreWMByStoreId($_SESSION['store_id']);
		/**
		 * 保存水印配置信息
		 */
		if (chksubmit()){
			$param = array();
			$param['wm_image_pos'] 			= $_POST['image_pos'];
			$param['wm_image_transition'] 	= $_POST['image_transition'];
			$param['wm_text']		 		= $_POST['wm_text'];
			$param['wm_text_size'] 			= $_POST['wm_text_size'];
			$param['wm_text_angle'] 		= $_POST['wm_text_angle'];
			$param['wm_text_font'] 			= $_POST['wm_text_font'];
			$param['wm_text_pos'] 			= $_POST['wm_text_pos'];
			$param['wm_text_color'] 		= $_POST['wm_text_color'];
			$param['jpeg_quality'] 			= $_POST['image_quality'];
			if (!empty($_FILES['image']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_WATERMARK);
				$result = $upload->upfile('image');
				if ($result){
					$param['wm_image_name'] = $upload->file_name;
					/**
					 * 删除旧水印
					 */
					if (!empty($store_wm_info['wm_image_name'])){
						@unlink(BASE_UPLOAD_PATH.DS.ATTACH_WATERMARK.DS.$store_wm_info['wm_image_name']);
					}
				}else {
					showDialog($upload->error);
				}
			}elseif ($_POST['is_del_image'] == 'ok'){
				/**
				 * 删除水印
				 */
				if (!empty($store_wm_info['wm_image_name'])){
					$param['wm_image_name'] = '';
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_WATERMARK.DS.$store_wm_info['wm_image_name']);
				}
			}
			$param['wm_id'] = $store_wm_info['wm_id'];
			$result = $model_store_wm->updateStoreWM($param);
			if ($result){
				showDialog(Language::get('store_watermark_congfig_success'),'reload','succ');
			}else {
				showDialog(Language::get('store_watermark_congfig_fail'));
			}
		}
		/**
		 * 获取水印字体
		 */
		$dir_list = array();
		readFileList(BASE_RESOURCE_PATH.DS.'font',$dir_list);
		if (!empty($dir_list) && is_array($dir_list)){
			$fontInfo = array();
			include BASE_RESOURCE_PATH.DS.'font'.DS.'font.info.php';
			foreach ($dir_list as $value){
				$d_array = explode('.',$value);
				if (strtolower(end($d_array)) == 'ttf' && file_exists($value)){
					$dir_array = explode('/', $value);
					$value = array_pop($dir_array);
					$tmp = explode('.',$value);
					$file_list[$tmp[0]] = $fontInfo[$tmp[0]];
				}
			}
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$file_list = Language::getGBK($file_list);
			}
			Tpl::output('file_list',$file_list);
		}
		if (empty($store_wm_info)){
			/**
			 * 新建店铺水印设置信息
			 */
			$model_store_wm->addStoreWM(array(
				'wm_text_font'=>'default',
				'store_id'=>$_SESSION['store_id']
			));
			$store_wm_info = $model_store_wm->getOneStoreWMByStoreId($_SESSION['store_id']);
		}
		self::profile_menu('album','watermark');
		Tpl::output('store_wm_info',$store_wm_info);
		Tpl::showpage('store_watermark.form');
	}    /**
     * 上传图片
     *
     */
    public function image_uploadOp() {
        $store_id = $_SESSION ['store_id'];
        if (! empty ( $_POST ['category_id'] )) {
            $category_id = intval ( $_POST ['category_id'] );
        } else {
            $error = '上传 图片失败';
            if (strtoupper ( CHARSET ) == 'GBK') {
                $error = Language::getUTF8($error);
            }
            $data['state'] = 'false';
            $data['message'] = $error;
            $data['origin_file_name'] = $_FILES["file"]["name"];
            echo json_encode($data);
            exit();
        }
        // 判断图片数量是否超限
        $album_limit = $this->store_grade['sg_album_limit'];
        if ($album_limit > 0) {
	        $album_count = Model('album')->getCount(array('store_id' => $store_id));
	        if ($album_count >= $album_limit) {
	            // 目前并不出该提示，而是提示上传0张图片
	            $error = L('store_goods_album_climit');
	            if (strtoupper ( CHARSET ) == 'GBK') {
	                $error = Language::getUTF8($error);
	            }
	            $data['state'] = 'false';
	            $data['message'] = $error;
	            $data['origin_file_name'] = $_FILES["file"]["name"];
	            $data['state'] = 'true';
	            echo json_encode($data);
	            exit();
	        }
        }

        /**
         * 上传图片
         */
        $upload = new UploadFile();
        $upload->set('default_dir', ATTACH_GOODS . DS . $store_id . DS . $upload->getSysSetPath());
        $upload->set('max_size', C('image_max_filesize'));
        $upload->set('thumb_width', GOODS_IMAGES_WIDTH);
        $upload->set('thumb_height', GOODS_IMAGES_HEIGHT);
        $upload->set('thumb_ext', GOODS_IMAGES_EXT);
        $upload->set('fprefix', $store_id);
        $result = $upload->upfile('file');
        if ($result) {
            $pic = $upload->getSysSetPath() . $upload->file_name;
            $pic_thumb = $upload->getSysSetPath() . $upload->thumb_image;
        } else {
            // 目前并不出该提示
            $error = $upload->error;
            if (strtoupper(CHARSET) == 'GBK') {
                $error = Language::getUTF8($error);
            }
            $data['state'] = 'false';
            $data['message'] = $error;
            $data['origin_file_name'] = $_FILES["file"]["name"];
            echo json_encode($data);
            exit();
        }

        list($width, $height, $type, $attr) = getimagesize(BASE_UPLOAD_PATH . DS . ATTACH_GOODS . DS . $store_id . DS . $pic);

        $image = explode('.', $_FILES["file"]["name"]);
        if (strtoupper(CHARSET) == 'GBK') {
            $image['0'] = Language::getGBK($image['0']);
        }
        $insert_array = array();
        $insert_array['apic_name'] = $image['0'];
        $insert_array['apic_tag'] = '';
        $insert_array['aclass_id'] = $category_id;
        $insert_array['apic_cover'] = $pic;
        $insert_array['apic_size'] = intval($_FILES['file']['size']);
        $insert_array['apic_spec'] = $width . 'x' . $height;
        $insert_array['upload_time'] = time();
        $insert_array['store_id'] = $store_id;
        $result = Model('upload_album')->add($insert_array);

        $data = array ();
        $data['file_id'] = $result;
        $data['file_name'] = $pic;
        $data['origin_file_name'] = $_FILES["file"]["name"];
        $data['file_path'] = $pic;
        $data['instance'] = $_GET['instance'];
        $data['state'] = 'true';
        /**
         * 整理为json格式
         */
        $output = json_encode ( $data );
        echo $output;
    }


	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key=''){
		$menu_array	= array();
		switch ($menu_type) {
			case 'album':
				$menu_array	= array(
				1=>array('menu_key'=>'album','menu_name'=>Language::get('nc_member_path_my_album'),'menu_url'=>'index.php?act=store_album'),
				2=>array('menu_key'=>'watermark','menu_name'=>Language::get('nc_member_path_watermark'),'menu_url'=>'index.php?act=store_album&op=store_watermark')
				);
				break;
			case 'album_pic':
				$menu_array	= array(
				1=>array('menu_key'=>'album','menu_name'=>Language::get('nc_member_path_my_album'),'menu_url'=>'index.php?act=store_album'),
				2=>array('menu_key'=>'pic_list','menu_name'=>Language::get('nc_member_path_album_pic_list'),'menu_url'=>'index.php?act=store_album&op=album_pic_list&id='.intval($_GET['id'])),
				3=>array('menu_key'=>'watermark','menu_name'=>Language::get('nc_member_path_watermark'),'menu_url'=>'index.php?act=store_album&op=store_watermark')
				);
				break;
			case 'album_pic_info':
				$menu_array	= array(
				1=>array('menu_key'=>'album','menu_name'=>Language::get('nc_member_path_my_album'),'menu_url'=>'index.php?act=store_album'),
				2=>array('menu_key'=>'pic_info','menu_name'=>Language::get('nc_member_path_album_pic_info'),'menu_url'=>'index.php?act=store_album&op=album_pic_info&id='.intval($_GET['id']).'&class_id='.intval($_GET['class_id'])),
				3=>array('menu_key'=>'watermark','menu_name'=>Language::get('nc_member_path_watermark'),'menu_url'=>'index.php?act=store_album&op=store_watermark')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
	/**
	 * ajax返回图片信息
	 */
	public function ajax_change_imgmessageOp(){
		$str_array = explode('/', $_GET['url']);
		$str = array_pop($str_array);
		$str = explode('.', $str);
		/**
		 * 实例化图片模型
		 */
		$model_album = Model('album');
		$param = array();
		$search = explode(',', GOODS_IMAGES_EXT);
		$param['like_cover']	= str_ireplace($search, '', $str['0']);
		$pic_info = $model_album->getPicList($param);

		/**
		 * 小图尺寸
		 */
		list($width, $height, $type, $attr) = getimagesize(BASE_UPLOAD_PATH.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].DS.$pic_info['0']['apic_cover']);
		if(strtoupper(CHARSET) == 'GBK'){
			$pic_info['0']['apic_name'] = Language::getUTF8($pic_info['0']['apic_name']);
		}
		echo json_encode(array(
				'img_name'=>$pic_info['0']['apic_name'],
				'default_size'=>sprintf('%.2f',intval($pic_info['0']['apic_size'])/1024),
				'default_spec'=>$pic_info['0']['apic_spec'],
				'upload_time'=>date('Y-m-d',$pic_info['0']['upload_time']),
				'small_spec'=>$width.'x'.$height
			));
	}
	/**
	 * ajax验证名称时候重复
	 */
	public function ajax_check_class_nameOp(){
		$ac_name	= trim($_GET['ac_name']);
		if($ac_name == ''){
			echo 'true';die;
		}
		$model_album	= Model('album');
		$param = array();
		$param['field']		= array('aclass_name','store_id');
		$param['value']		= array($ac_name,$_SESSION['store_id']);
		$class_info = $model_album->getOneClass($param);
		if(!empty($class_info)){
			echo 'false';die;
		}else{
			echo 'true';die;
		}
	}
}
?>
