<?php
/**
 * 店铺动态
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class store_snsControl extends BaseSellerControl{
    public function __construct() {
        parent::__construct ();
        Language::read('store_sns,member_sns');
    }
    public function indexOp() {
        $this->addOp();
    }

    /**
     * 发布动态
     */
    public function addOp() {
        $model_goods = Model('goods');
        // 热销商品

        // where条件
        $where = array('store_id' => $_SESSION['store_id']);
        $field = 'goods_id,goods_name,goods_image,goods_price,goods_salenum,store_id';
        $order = 'goods_salenum desc';
        $hotsell_list = $model_goods->getGoodsOnlineList($where, $field, 0, $order, 8);
        Tpl::output('hotsell_list', $hotsell_list);

        // 新品

        // where条件
        $where = array('store_id' => $_SESSION['store_id']);
        $field = 'goods_id,goods_name,goods_image,goods_price,goods_salenum,store_id';
        $order = 'goods_id desc';
        $new_list = $model_goods->getGoodsOnlineList($where, $field, 0, $order, 8);
        Tpl::output('new_list', $new_list);

        $this->profile_menu ( 'store_sns_add' );
        Tpl::showpage ( 'store_sns_add' );
    }


    /**
     * 上传图片
     */
    public function image_uploadOp() {
        // 判断图片数量是否超限
        $model_album = Model('album');
        $album_limit = $this->store_grade['sg_album_limit'];
        if ($album_limit > 0) {
            $album_count = $model_album->getCount(array('store_id' => $_SESSION['store_id']));
            if ($album_count >= $album_limit) {
                $error = L('store_goods_album_climit');
                if (strtoupper(CHARSET) == 'GBK') {
                    $error = Language::getUTF8($error);
                }
                exit(json_encode(array('error' => $error)));
            }
        }

        $class_info = $model_album->getOne(array('store_id' => $_SESSION['store_id'], 'is_default' => 1), 'album_class');
        // 上传图片
        $upload = new UploadFile();
        $upload->set('default_dir', ATTACH_GOODS . DS . $_SESSION ['store_id'] . DS . $upload->getSysSetPath());
        $upload->set('max_size', C('image_max_filesize'));

        $upload->set('thumb_width', GOODS_IMAGES_WIDTH);
        $upload->set('thumb_height', GOODS_IMAGES_HEIGHT);
        $upload->set('thumb_ext', GOODS_IMAGES_EXT);
        $upload->set('fprefix', $_SESSION['store_id']);
        $upload->set('allow_type', array('gif', 'jpg', 'jpeg', 'png'));
        $result = $upload->upfile($_POST['id']);
        if (!$result) {
            if (strtoupper(CHARSET) == 'GBK') {
                $upload->error = Language::getUTF8($upload->error);
            }
            $output = array();
            $output['error'] = $upload->error;
            $output = json_encode($output);
            exit($output);
        }

        $img_path = $upload->getSysSetPath() . $upload->file_name;
        $thumb_page = $upload->getSysSetPath() . $upload->thumb_image;

        // 取得图像大小
        list($width, $height, $type, $attr) = getimagesize(UPLOAD_SITE_URL . '/' . ATTACH_GOODS . '/' . $_SESSION ['store_id'] . DS . $img_path);

        // 存入相册
        $image = explode('.', $_FILES[$_POST['id']]["name"]);
        $insert_array = array();
        $insert_array['apic_name'] = $image['0'];
        $insert_array['apic_tag'] = '';
        $insert_array['aclass_id'] = $class_info['aclass_id'];
        $insert_array['apic_cover'] = $img_path;
        $insert_array['apic_size'] = intval($_FILES[$_POST['id']]['size']);
        $insert_array['apic_spec'] = $width . 'x' . $height;
        $insert_array['upload_time'] = TIMESTAMP;
        $insert_array['store_id'] = $_SESSION['store_id'];
        $model_album->addPic($insert_array);

        $data = array ();
        $data ['image'] = cthumb($img_path, 240, $_SESSION['store_id']);

        // 整理为json格式
        $output = json_encode($data);
        echo $output;
        exit();
    }
	/**
	 * 保存动态
	 */
	public function store_sns_saveOp(){
		/**
		 * 验证表单
		 */
		$obj_validate = new Validate();
		$obj_validate->validateparam = array(
				array("input"=>$_POST["content"],"require"=>"true","validator"=>"Length","max"=>140,"min"=>1,"message"=>Language::get('store_sns_center_error')),
				array("input"=>$_POST["goods_url"],"require"=>"false","validator"=>"url","message"=>Language::get('store_goods_index_goods_price_null')),
		);
		$error = $obj_validate->validate();
		if ($error != ''){
			showDialog($error);
		}
		// 实例化模型
		$model = Model();


		$goodsdata	= '';
		$content	= '';
		$_POST['type'] = intval($_POST['type']);
		switch ($_POST['type']){
			case '2':
				$sns_image	= trim($_POST['sns_image']);
				if($sns_image != '') $content	= '<div class="fd-media">
									<div class="thumb-image"><a href="javascript:void(0);" nc_type="thumb-image"><img src="'.$sns_image.'" /><i></i></a></div>
									<div class="origin-image"><a href="javascript:void(0);" nc_type="origin-image"></a></div>
								</div>';
				break;
			case '9':
				$data = $this->getGoodsByUrl(html_entity_decode($_POST['goods_url']));
				if( CHARSET == 'GBK') {
					foreach ((array)$data as $k=>$v){
						$data[$k] = Language::getUTF8($v);
					}
				}
				$goodsdata	= addslashes(json_encode($data));
				break;
			case '10':
				if(is_array($_POST['goods_id'])){
					$goods_id_array = $_POST['goods_id'];
				}else{
					showDialog(Language::get('store_sns_choose_goods'));
				}
				$field = 'goods_id,store_id,goods_name,goods_image,goods_price,goods_freight';
				$where = array('store_id'=>$_SESSION['store_id'],'goods_id'=>array('in',$goods_id_array));
				$goods_array = Model('goods')->getGoodsList($where, $field);
				if(!empty($goods_array) && is_array($goods_array)){
					$goodsdata	= array();
					foreach ($goods_array as $val){
						if( CHARSET == 'GBK') {
							foreach ((array)$val as $k=>$v){
								$val[$k] = Language::getUTF8($v);
							}
						}
						$goodsdata[]	= addslashes(json_encode($val));
					}
				}
				break;
			case '3':
				if(is_array($_POST['goods_id'])){
					$goods_id_array = $_POST['goods_id'];
				}else{
					showDialog(Language::get('store_sns_choose_goods'));
				}
				$field = 'goods_id,store_id,goods_name,goods_image,goods_price,goods_freight';
				$where = array('store_id'=>$_SESSION['store_id'],'goods_id'=>array('in',$goods_id_array));
				$goods_array = Model('goods')->getGoodsList($where, $field);
				if(!empty($goods_array) && is_array($goods_array)){
					$goodsdata	= array();
					foreach($goods_array as $val){
						if( CHARSET == 'GBK') {
							foreach ((array)$val as $k=>$v){
								$val[$k] = Language::getUTF8($v);
							}
						}
						$goodsdata[]	= addslashes(json_encode($val));
					}
				}
				break;
			default:
				showDialog(Language::get('para_error'));
		}

		$model_stracelog = Model('store_sns_tracelog');
		// 插入数据
		$stracelog_array = array();
		$stracelog_array['strace_storeid']	= $this->store_info['store_id'];
		$stracelog_array['strace_storename']= $this->store_info['store_name'];
		$stracelog_array['strace_storelogo']= empty($this->store_info['store_avatar'])?'':$this->store_info['store_avatar'];
		$stracelog_array['strace_title']	= $_POST['content'];
		$stracelog_array['strace_content']	= $content;
		$stracelog_array['strace_time']		= time();
		$stracelog_array['strace_type']		= $_POST['type'];
		if(isset($goodsdata) && is_array($goodsdata)){
			$stracelog	= array();
			foreach($goodsdata as $val){
				$stracelog_array['strace_goodsdata']	= $val;
				$stracelog[]	= $stracelog_array;
			}
			$rs	= $model_stracelog->saveStoreSnsTracelogAll($stracelog);
		}else{
			$stracelog_array['strace_goodsdata']	= $goodsdata;
			$rs	= $model_stracelog->saveStoreSnsTracelog($stracelog_array);
		}
		if($rs){
			showDialog(Language::get('nc_common_op_succ'), 'index.php?act=store_sns', 'succ');
		}else{
			showDialog(Language::get('nc_common_op_fail'));
		}
	}

	/**
	 * 动态设置
	 */
	public function settingOp(){
		// 实例化模型
		$model_storesnssetting = Model('store_sns_setting');
		if(chksubmit()){
			$update = array();
			$update['sauto_storeid']		= $_SESSION['store_id'];
			$update['sauto_new']			= isset($_POST['new'])?1:0;
			$update['sauto_newtitle']		= trim($_POST['new_title']);
			$update['sauto_coupon']			= isset($_POST['coupon'])?1:0;
			$update['sauto_coupontitle']	= trim($_POST['coupon_title']);
			$update['sauto_xianshi']		= isset($_POST['xianshi'])?1:0;
			$update['sauto_xianshititle']	= trim($_POST['xianshi_title']);
			$update['sauto_mansong']		= isset($_POST['mansong'])?1:0;
			$update['sauto_mansongtitle']	= trim($_POST['mansong_title']);
			$update['sauto_bundling']		= isset($_POST['bundling'])?1:0;
			$update['sauto_bundlingtitle']	= trim($_POST['bundling_title']);
			$update['sauto_groupbuy']		= isset($_POST['groupbuy'])?1:0;
			$updata['sauto_groupbuytitle']	= trim($_POST['groupbuy_title']);
			$result = $model_storesnssetting->saveStoreSnsSetting($update,true);
			showDialog(Language::get('nc_common_save_succ'), '', 'succ');
		}
		$sauto_info	= $model_storesnssetting->getStoreSnsSettingInfo(array('sauto_storeid' => $_SESSION['store_id']));
		Tpl::output('sauto_info', $sauto_info);
		$this->profile_menu('store_sns_setting');
		Tpl::showpage('store_sns_setting');
	}

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key) {
		$menu_array	= array(
				1=>array('menu_key'=>'store_sns_add', 'menu_name'=>Language::get('store_sns_add'), 'menu_url'=>'index.php?act=store_sns&op=add'),
				2=>array('menu_key'=>'store_sns_setting', 'menu_name'=>Language::get('store_sns_setting'), 'menu_url'=>'index.php?act=store_sns&op=setting'),
				3=>array('menu_key'=>'store_sns_brower', 'menu_name'=>Language::get('store_sns_browse'), 'menu_url'=>urlShop('store_snshome', 'index', array('sid' => $_SESSION['store_id'])), 'target'=>'_blank')
		);
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}

	/**
	 * 根据url取得商品信息
	 */
	private function getGoodsByUrl($url){
		$array = parse_url($url);
		if(isset($array['query'])){
			// 未开启伪静态
			parse_str($array['query'],$arr);
			$id = $arr['goods_id'];
		}else{
			// 开启伪静态
			$item = explode('/', $array['path']);
			$item = end($item);
			$id = preg_replace('/item-(\d+)\.html/i', '$1', $item);
		}
		if(intval($id) > 0){
			// 查询商品信息
			$field = 'goods_id,store_id,goods_name,goods_image,goods_price,goods_freight';
			$result = Model('goods')->getGoodsInfoByID($id, $field);
			if(!empty($result) && is_array($result)){
				return $result;
			}else{
				showDialog(Language::get('store_sns_goods_url_error'));
			}
		}else{
			showDialog(Language::get('store_sns_goods_url_error'));
		}

	}
}
