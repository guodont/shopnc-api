<?php
/**
 * 会员中心——我是卖家//zmr>v30
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_settingControl extends BaseSellerControl {
	public function __construct() {
		parent::__construct();
		Language::read('member_store_index');
	}

	/**
	 * 卖家店铺设置
	 *
	 * @param string
	 * @param string
	 * @return
	 */
	public function store_settingOp(){
		/**
		 * 实例化模型
		 */
		$model_class = Model('store');
		/**
		 * 获取设置
		 */
		// $setting_config = $GLOBALS['setting_config'];
		$config_subdomain_edit = C('subdomain_edit');
		$config_subdomain_times = C('subdomain_times');
		$config_subdomain_length = C('subdomain_length');
		$config_subdomain_reserved = C('subdomain_reserved');
		$config_enabled_subdomain = C('enabled_subdomain');

		$store_id = $_SESSION['store_id'];//当前店铺ID
		/**
		 * 获取店铺信息
		 */
		$store_info = $model_class->getStoreInfoByID($store_id);
		$subdomain_edit = intval($config_subdomain_edit);//二级域名是否可修改
		$subdomain_times = intval($config_subdomain_times);//系统设置二级域名可修改次数
		$store_domain_times = intval($store_info['store_domain_times']);//店铺已修改次数
		$subdomain_length = explode('-',$config_subdomain_length);
		$subdomain_length[0] = intval($subdomain_length[0]);
		$subdomain_length[1] = intval($subdomain_length[1]);
		if ($subdomain_length[0] < 1 || $subdomain_length[0] >= $subdomain_length[1]){//域名长度
			$subdomain_length[0] = 3;
			$subdomain_length[1] = 12;
		}
		Tpl::output('subdomain_length',$subdomain_length);
		/**
		 * 保存店铺设置
		 */
		if (chksubmit()){
			$_POST['store_domain'] = trim($_POST['store_domain']);
			$store_domain = strtolower($_POST['store_domain']);
			//判断是否设置二级域名
			if (!empty($store_domain) && $store_domain != $store_info['store_domain']){
				$store_domain_count = strlen($store_domain);
				if ($store_domain_count < $subdomain_length[0] || $store_domain_count > $subdomain_length[1]){
					showDialog(Language::get('store_setting_wrong_uri').': '.$config_subdomain_length,'reload','error');
				}
				if (!preg_match('/^[\w-]+$/i',$store_domain)){//判断域名是否正确
					showDialog(Language::get('store_setting_lack_uri'));
				}
				$store = $model_class->getStoreInfo(array(
					'store_domain'=>$store_domain
				));
				//二级域名存在,则提示错误
				if (!empty($store) && ($store_id != $store['store_id'])){
					showDialog(Language::get('store_setting_exists_uri'),'reload','error');
				}
				//判断二级域名是否为系统禁止
				$subdomain_reserved = @explode(',',$config_subdomain_reserved);
				if(!empty($subdomain_reserved) && is_array($subdomain_reserved)){
						if (in_array($store_domain,$subdomain_reserved)){
							showDialog(Language::get('store_setting_invalid_uri'));
						}
				}
				if($subdomain_times > $store_domain_times){//可继续修改
					$param = array();
					$param['store_domain'] = $store_domain;
					if (!empty($store_info['store_domain'])) $param['store_domain_times'] = $store_domain_times+1;//第一次保存不计数
                    $model_class->editStore($param, array('store_id' => $store_id));
				}
				$_POST['store_domain'] = '';//避免重复更新
			}
			$upload = new UploadFile();
			/**
			 * 上传店铺图片
			 */
			if (!empty($_FILES['store_banner']['name'])){
				$upload->set('default_dir',	ATTACH_STORE);
				$upload->set('thumb_ext',	'');
				$upload->set('file_name','');
				$upload->set('ifremove',false);
				$result = $upload->upfile('store_banner');
				if ($result){
					$_POST['store_banner'] = $upload->file_name;
				}else {
					showDialog($upload->error);
				}
			}

			//删除旧店铺图片
			if (!empty($_POST['store_banner']) && !empty($store_info['store_banner'])){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$store_info['store_banner']);
			}

			/**
			 * 上传店铺图片
			 */
			if (!empty($_FILES['store_label']['name'])){
				$upload->set('default_dir',	ATTACH_STORE);
				$upload->set('thumb_ext',	'');
				$upload->set('file_name','');
				$upload->set('ifremove',false);
				$result = $upload->upfile('store_label');
				if ($result){
					$_POST['store_label'] = $upload->file_name;
				}else {
					showDialog($upload->error);
				}
			}

			//删除旧店铺图片
			if (!empty($_POST['store_label']) && !empty($store_info['store_label'])){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$store_info['store_label']);
			}

			//删除旧店铺图片
			if (!empty($_POST['store_logo']) && !empty($store_info['store_logo'])){
			    @unlink(BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$store_info['store_logo']);
			}
			/**
			 * 更新入库
			 */
            $param = array(
                'store_label' => empty($_POST['store_label']) ? $store_info['store_label'] : $_POST['store_label'],
                'store_banner' => empty($_POST['store_banner']) ? $store_info['store_banner'] : $_POST['store_banner'],
                'store_avatar' => empty($_POST['store_avatar']) ? $store_info['store_avatar'] : $_POST['store_avatar'],
                'store_qq' => $_POST['store_qq'],
                'store_ww' => $_POST['store_ww'],
                'store_phone' => $_POST['store_phone'],
                'store_zy' => $_POST['store_zy'],
                'store_keywords' => $_POST['seo_keywords'],
                'store_description' => $_POST['seo_description']
            );
            if (!empty($_POST['store_theme'])){
                $param['store_theme'] = $_POST['store_theme'];
            }
			
			
			//修改店铺名称
			$store_name=$_POST['store_name'];
			if (!empty($_POST['store_name'])){
			    $store = $model_class->getStoreInfo(array(
					'store_name'=>$store_name
				));
				//店铺名存在,则提示错误
				if (!empty($store) && ($store_id != $store['store_id'])){
					showDialog('此店铺名称已被其它人使用，请换其它名称。','reload','error');
					return;
				}
                $param['store_name'] = $_POST['store_name'];
            }
			//如果店铺名称修改了zmr>v60
			if($store_name!=$store_info['store_name']&&!empty($_POST['store_name']))
			{
				$where=array();
				$where['store_id']=$store_id;
				$update=array();
				$update['store_name']=$store_name;
				$bllGoods=Model()->table('goods_common')->where($where)->update($update);
				$bllGoods=Model()->table('goods')->where($where)->update($update);
			}
			//zmr<v60
			
			
			
			
			
			//zmr>>>
			//生成店铺二维码
			require_once(BASE_RESOURCE_PATH.DS.'phpqrcode'.DS.'index.php');
			$PhpQRCode = new PhpQRCode();
			$PhpQRCode->set('pngTempDir',BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$store_id.DS);
			$PhpQRCode->set('date',WAP_SITE_URL . '/tmpl/go_store.html?store_id='.$store_id);
            $PhpQRCode->set('pngTempName', $store_id . '_store.png');
            $PhpQRCode->init();
			//zmr<<<

            $model_class->editStore($param, array('store_id' => $store_id));
            showDialog(Language::get('nc_common_save_succ'),'index.php?act=store_setting&op=store_setting','succ');
        }
        /**
         * 实例化店铺等级模型
         */
        // $model_store_grade	= Model('store_grade');
        // $store_grade		= $model_store_grade->getOneGrade($store_info['grade_id']);

        // 从基类中读取店铺等级信息
        $store_grade = $this->store_grade;

		//编辑器多媒体功能
		$editor_multimedia = false;
		$sg_fun = @explode('|',$store_grade['sg_function']);
		if(!empty($sg_fun) && is_array($sg_fun)){
			foreach($sg_fun as $fun){
				if ($fun == 'editor_multimedia'){
					$editor_multimedia = true;
				}
			}
		}
		Tpl::output('editor_multimedia',$editor_multimedia);
		if($subdomain_edit == 1 && ($subdomain_times > $store_domain_times)){//可继续修改二级域名
			Tpl::output('subdomain_edit',$subdomain_edit);
		}
		/**
		 * 输出店铺信息
		 */
		self::profile_menu('store_setting');
		Tpl::output('store_info',$store_info);
		Tpl::output('store_grade',$store_grade);
		Tpl::output('subdomain',$config_enabled_subdomain);
		Tpl::output('subdomain_times',$config_subdomain_times);
		/**
		 * 页面输出
		 */
		Tpl::showpage('store_setting_form');
	}

	/**
	 * 店铺幻灯片
	 */
	public function store_slideOp() {
		/**
		 * 模型实例化
		 */
		$model_store = Model('store');
		$model_upload = Model('upload');
		/**
		 * 保存店铺信息
		 */
		if ($_POST['form_submit'] == 'ok'){
			// 更新店铺信息
			$update	= array();
			$update['store_slide']		= implode(',', $_POST['image_path']);
			$update['store_slide_url']	= implode(',', $_POST['image_url']);
            $model_store->editStore($update, array('store_id' => $_SESSION['store_id']));

			// 删除upload表中数据
			$model_upload->delByWhere(array('upload_type'=>3,'item_id'=>$_SESSION['store_id']));
			showDialog(Language::get('nc_common_save_succ'),'index.php?act=store_setting&op=store_slide','succ');
		}

		// 删除upload中的无用数据
		$upload_info = $model_upload->getUploadList(array('upload_type'=>3,'item_id'=>$_SESSION['store_id']),'file_name');
		if(is_array($upload_info) && !empty($upload_info)){
			foreach ($upload_info as $val){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_SLIDE.DS.$val['file_name']);
			}
		}
		$model_upload->delByWhere(array('upload_type'=>3,'item_id'=>$_SESSION['store_id']));


        $store_info = $model_store->getStoreInfoByID($_SESSION['store_id']);
		if($store_info['store_slide'] != '' && $store_info['store_slide'] != ',,,,'){
			Tpl::output('store_slide', explode(',', $store_info['store_slide']));
			Tpl::output('store_slide_url', explode(',', $store_info['store_slide_url']));
		}
		self::profile_menu('store_slide');
		/**
		 * 页面输出
		 */
		Tpl::showpage('store_slide_form');
	}
	/**
	 * 店铺幻灯片ajax上传
	 */
	public function silde_image_uploadOp(){
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_SLIDE);
		$upload->set('max_size',C('image_max_filesize'));

		$result = $upload->upfile($_POST['id']);


		$output	= array();
		if(!$result){
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$upload->error = Language::getUTF8($upload->error);
			}
			$output['error']	= $upload->error;
			echo json_encode($output);die;
		}

		$img_path = $upload->file_name;

		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');

		if(intval($_POST['file_id']) > 0){
			$file_info = $model_upload->getOneUpload($_POST['file_id']);
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_SLIDE.DS.$file_info['file_name']);

			$update_array	= array();
			$update_array['upload_id']	= intval($_POST['file_id']);
			$update_array['file_name']	= $img_path;
			$update_array['file_size']	= $_FILES[$_POST['id']]['size'];
			$model_upload->update($update_array);

			$output['file_id']	= intval($_POST['file_id']);
			$output['id']		= $_POST['id'];
			$output['file_name']	= $img_path;
			echo json_encode($output);die;
		}else{
			/**
			 * 图片数据入库
			 */
			$insert_array = array();
			$insert_array['file_name']		= $img_path;
			$insert_array['upload_type']	= '3';
			$insert_array['file_size']		= $_FILES[$_POST['id']]['size'];
			$insert_array['item_id']		= $_SESSION['store_id'];
			$insert_array['upload_time']	= time();

			$result = $model_upload->add($insert_array);

			if(!$result){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_SLIDE.DS.$img_path);
				$output['error']	= Language::get('store_slide_upload_fail','UTF-8');
				echo json_encode($output);die;
			}

			$output['file_id']	= $result;
			$output['id']		= $_POST['id'];
			$output['file_name']	= $img_path;
			echo json_encode($output);die;
		}
	}

	/**
	 * ajax删除幻灯片图片
	 */
	public function dorp_imgOp(){
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$file_info = $model_upload->getOneUpload(intval($_GET['file_id']));
		if(!$file_info){
		}else{
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_SLIDE.DS.$file_info['file_name']);
			$model_upload->del(intval($_GET['file_id']));
		}
		echo json_encode(array('succeed'=>Language::get('nc_common_save_succ','UTF-8')));die;
	}

	/**
	 * 卖家店铺主题设置
	 *
	 * @param string
	 * @param string
	 * @return
	 */
	public function themeOp(){
		/**
		 * 店铺信息
		 */
		$store_class = Model('store');
		$store_info = $store_class->getStoreInfoByID($_SESSION['store_id']);
		/**
		 * 主题配置信息
		 */
		$style_data = array();
		$style_configurl = BASE_ROOT_PATH.DS.DIR_SHOP.'/templates/'.TPL_SHOP_NAME.DS.'store'.DS.'style'.DS."styleconfig.php";
		if (file_exists($style_configurl)){
			include_once($style_configurl);
		}
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$style_data = Language::getGBK($style_data);
		}
		/**
		 * 当前店铺主题
		 */
		$curr_store_theme = !empty($store_info['store_theme'])?$store_info['store_theme']:'default';
		/**
		 * 当前店铺预览图片
		 */
		$curr_image = SHOP_TEMPLATES_URL.'/store/style/'.$curr_store_theme.'/images/preview.jpg';
		$curr_theme = array(
		'curr_name'=>$curr_store_theme,
		'curr_truename'=>$style_data[$curr_store_theme]['truename'],
		'curr_image'=>$curr_image
		);

        // 自营店全部可用
        if (checkPlatformStore()) {
            $themes = array_keys($style_data);
        } else {
            /**
             * 店铺等级
             */
            $grade_class = Model('store_grade');
            $grade = $grade_class->getOneGrade($store_info['grade_id']);
            /**
             * 可用主题
             */
            $themes = explode('|',$grade['sg_template']);
        }

		/**
		 * 可用主题预览图片
		 */
		foreach ($style_data as $key => $val){
			if (in_array($key,$themes)){
				$theme_list[$key] = array(
				'name'=>$key,
				'truename'=>$val['truename'],
				'image'=>SHOP_TEMPLATES_URL.'/store/style/'.$key.'/images/preview.jpg'
				);
			}
		}
		/**
		 * 页面输出
		 */
		self::profile_menu('store_theme','store_theme');
		Tpl::output('store_info',$store_info);
		Tpl::output('curr_theme',$curr_theme);
		Tpl::output('theme_list',$theme_list);
		Tpl::showpage('store_theme');
	}
	/**
	 * 卖家店铺主题设置
	 *
	 * @param string
	 * @param string
	 * @return
	 */
	public function set_themeOp(){
		//读取语言包
		$lang	= Language::getLangContent();
		$style = isset($_GET['style_name']) ? trim($_GET['style_name']) : null;

		if (!empty($style) && file_exists(BASE_TPL_PATH.DS.'/store/style/'.$style.'/images/preview.jpg')){
			$store_class = Model('store');
            $rs = $store_class->editStore(array('store_theme'=>$style), array('store_id' => $_SESSION['store_id']));
			showDialog($lang['store_theme_congfig_success'],'reload','succ');
		}else{
			showDialog($lang['store_theme_congfig_fail'],'','succ');
		}
	}

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key='') {
		Language::read('member_layout');
        $menu_array = array(
            1=>array('menu_key'=>'store_setting','menu_name'=>Language::get('nc_member_path_store_config'),'menu_url'=>'index.php?act=store_setting&op=store_setting'),
            4=>array('menu_key'=>'store_slide','menu_name'=>Language::get('nc_member_path_store_slide'),'menu_url'=>'index.php?act=store_setting&op=store_slide'),
            5=>array('menu_key'=>'store_theme','menu_name'=>'店铺主题','menu_url'=>'index.php?act=store_setting&op=theme'),
        );
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }

}
