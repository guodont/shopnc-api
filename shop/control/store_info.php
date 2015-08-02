<?php
/**
 * 店铺信息
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_infoControl extends BaseSellerControl {
	public function __construct() {
		parent::__construct();
		Language::read('member_store_index');
	}

	/**
	 * 店铺信息
	 */
	public function indexOp(){
        $model_store = Model('store');
        $model_store_bind_class = Model('store_bind_class');
        $model_store_class = Model('store_class');
        $model_store_grade = Model('store_grade');

        // 店铺信息
        $store_info = $model_store->getStoreInfoByID($_SESSION['store_id']);
        Tpl::output('store_info', $store_info);

        // 店铺分类信息
        $store_class_info = $model_store_class->getStoreClassInfo(array('sc_id'=>$store_info['sc_id']));
        Tpl::output('store_class_name', $store_class_info['sc_name']);

        // 店铺等级信息
        $store_grade_info = $model_store_grade->getOneGrade($store_info['grade_id']);
        Tpl::output('store_grade_name', $store_grade_info['sg_name']);

        $model_store_joinin = Model('store_joinin');
        $joinin_detail = $model_store_joinin->getOne(array('member_id'=>$store_info['member_id']));
        Tpl::output('joinin_detail', $joinin_detail);

        $store_bind_class_list = $model_store_bind_class->getStoreBindClassList(array('store_id'=>$_SESSION['store_id'],'state'=>array('in',array(1,2))), null);
        $goods_class = Model('goods_class')->getGoodsClassIndexedListAll();
        for($i = 0, $j = count($store_bind_class_list); $i < $j; $i++) {
            $store_bind_class_list[$i]['class_1_name'] = $goods_class[$store_bind_class_list[$i]['class_1']]['gc_name'];
            $store_bind_class_list[$i]['class_2_name'] = $goods_class[$store_bind_class_list[$i]['class_2']]['gc_name'];
            $store_bind_class_list[$i]['class_3_name'] = $goods_class[$store_bind_class_list[$i]['class_3']]['gc_name'];
        }
        Tpl::output('store_bind_class_list', $store_bind_class_list);

        self::profile_menu('index','index');

        Tpl::showpage('store_info');
	}

	/**
	 * 经营类目列表
	 */
	public function bind_classOp() {

	    $model_store_bind_class = Model('store_bind_class');

	    $store_bind_class_list = $model_store_bind_class->getStoreBindClassList(array('store_id'=>$_SESSION['store_id']), null);
	    $goods_class = Model('goods_class')->getGoodsClassIndexedListAll();
	    for($i = 0, $j = count($store_bind_class_list); $i < $j; $i++) {
	        $store_bind_class_list[$i]['class_1_name'] = $goods_class[$store_bind_class_list[$i]['class_1']]['gc_name'];
	        $store_bind_class_list[$i]['class_2_name'] = $goods_class[$store_bind_class_list[$i]['class_2']]['gc_name'];
	        $store_bind_class_list[$i]['class_3_name'] = $goods_class[$store_bind_class_list[$i]['class_3']]['gc_name'];
	    }
	    Tpl::output('bind_list', $store_bind_class_list);

	    self::profile_menu('index','bind_class');

	    Tpl::showpage('store_bind_class.index');
	}

	/**
	 * 申请新的经营类目
	 */
	public function bind_class_addOp() {
	    $model_goods_class = Model('goods_class');
	    $gc_list = $model_goods_class->getGoodsClassListByParentId(0);
	    Tpl::output('gc_list',$gc_list);

	    self::profile_menu('index','bind_class');
	    Tpl::showpage('store_bind_class.add','null_layout');
	}

	/**
	 * 申请新经营类目保存
	 */
	public function bind_class_saveOp() {
	    if (!chksubmit()) exit();
	    if (preg_match('/^[\d,]+$/',$_POST['goods_class'])) {
	        list($class_1, $class_2, $class_3) = explode(',', trim($_POST['goods_class'],','));
	    } else {
	        showDialog($lang['nc_common_save_fail']);
	    }

	    $model_store_bind_class = Model('store_bind_class');

	    $param = array();
	    $param['store_id'] = $_SESSION['store_id'];
	    $param['state'] = 0;
	    $param['class_1'] = $class_1;
	    $last_gc_id = $class_1;
	    if(!empty($class_2)) {
	        $param['class_2'] = $class_2;
	        $last_gc_id = $class_2;
	    }
	    if(!empty($class_3)) {
	        $param['class_3'] = $class_3;
	        $last_gc_id = $class_3;
	    }

	    // 检查类目是否已经存在
	    $store_bind_class_info = $model_store_bind_class->getStoreBindClassInfo($param);
	    if(!empty($store_bind_class_info)) {
	        showDialog('该类目已经存在');
	    }

	    //取分佣比例
	    $goods_class_info = Model('goods_class')->getGoodsClassInfoById($last_gc_id);
	    $param['commis_rate'] = $goods_class_info['commis_rate'];
	    $result = $model_store_bind_class->addStoreBindClass($param);

	    if($result) {
	        showDialog('申请成功，请等待系统审核','index.php?act=store_info&op=bind_class','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
	    }else {
	        showDialog($lang['nc_common_save_fail']);
	    }
	}

	/**
	 * 删除申请的经营类目
	 */
	public function bind_class_delOp() {
	    $model_brand	= Model('store_bind_class');
	    $condition = array();
	    $condition['bid'] = intval($_GET['bid']);
	    $condition['store_id'] = $_SESSION['store_id'];
	    $condition['state'] = 0;
	    $del = Model('store_bind_class')->delStoreBindClass($condition);
	    if ($del) {
	        showDialog(Language::get('nc_common_del_succ'),'reload','succ');
	    }else {
	        showDialog(Language::get('nc_common_del_fail'));
	    }
	}

	/**
	 * 店铺续签
	 */
	public function reopenOp(){

	    $model_store_reopen = Model('store_reopen');
	    $reopen_list = $model_store_reopen->getStoreReopenList(array('re_store_id'=>$_SESSION['store_id']));
	    Tpl::output('reopen_list',$reopen_list);

	    $store_info = $this->store_info;
	    if(intval($store_info['store_end_time']) > 0) {
	        $store_info['store_end_time_text']	= date('Y-m-d', $store_info['store_end_time']);
	        $reopen_time = $store_info['store_end_time'] -3600*24 + 1  - TIMESTAMP;
	        if (!checkPlatformStore() && $store_info['store_end_time'] - TIMESTAMP >= 0 && $reopen_time < 2592000) {
	            //(<30天)
	            $store_info['reopen'] = true;
	        }
	        $store_info['allow_applay_date'] = $store_info['store_end_time'] - 2592000;
	    }

	    if (!empty($reopen_list)) {
	        $last = reset($reopen_list);
	        $re_end_time = $last['re_end_time'];
	        if (!checkPlatformStore() && $re_end_time - TIMESTAMP < 2592000 && $re_end_time - TIMESTAMP >= 0) {
	            //(<30天)
	            $store_info['reopen'] = true;
	        } else {
	            $store_info['reopen'] = false;
	        }
	    }
	    Tpl::output('store_info',$store_info);

	    //店铺等级
	    $grade_list = rkcache('store_grade',true);
	    Tpl::output('grade_list',$grade_list);

	    //默认选中当前级别
	    Tpl::output('current_grade_id',$_SESSION['grade_id']);

	    //如果存在有未上传凭证或审核中的信息，则不能再申请续签
	    $condition = array();
	    $condition['re_state'] = array('in',array(0,1));
	    $condition['re_store_id'] = $_SESSION['store_id'];
	    $reopen_info = $model_store_reopen->getStoreReopenInfo($condition);
	    if ($reopen_info) {
	        if ($reopen_info['re_state'] == '0') {
	            Tpl::output('upload_cert',true);
	            Tpl::output('reopen_info',$reopen_info);
	        }
	    } else {
	        Tpl::output('applay_reopen',$store_info['reopen'] ? true : false);
	    }

	    self::profile_menu('index','reopen');

	    Tpl::showpage('store_reopen.index');
	}

	/**
	 * 申请续签
	 */
	public function reopen_addOp() {
	    if (!chksubmit()) exit();
	    if (intval($_POST['re_grade_id']) <= 0 || intval($_POST['re_year']) <= 0) exit();

	    // 店铺信息
	    $model_store = Model('store');
	    $store_info = $this->store_info;
	    if (empty($store_info['store_end_time'])) {
	        showDialog('您的店铺使用期限无限制，无须续签');
	    }

	    $model_store_reopen = Model('store_reopen');

	    //如果存在有未上传凭证或审核中的信息，则不能再申请续签
	    $condition = array();
	    $condition['re_state'] = array('in',array(0,1));
	    $condition['re_store_id'] = $_SESSION['store_id'];
	    if ($model_store_reopen->getStoreReopenCount($condition)) {
	        showDialog('目前尚存在申请中的续签信息，不能重复申请');
	    }

	    $data = array();
	    //取店铺等级信息
	    $grade_list = rkcache('store_grade',true);
	    if (empty($grade_list[$_POST['re_grade_id']])) exit();

	    //取得店铺信息

        $data['re_grade_id'] = $_POST['re_grade_id'];
        $data['re_grade_name'] = $grade_list[$_POST['re_grade_id']]['sg_name'];
        $data['re_grade_price'] = $grade_list[$_POST['re_grade_id']]['sg_price'];

	    $data['re_store_id'] = $_SESSION['store_id'];
	    $data['re_store_name'] = $_SESSION['store_name'];
	    $data['re_year'] = intval($_POST['re_year']);
        $data['re_pay_amount'] = $data['re_grade_price'] * $data['re_year'];
        $data['re_create_time'] = TIMESTAMP;
        if ($data['re_pay_amount'] == 0) {
//             $data['re_start_time'] = strtotime(date('Y-m-d 0:0:0',$store_info['store_end_time']))+24*3600;
//             $data['re_end_time'] = strtotime(date('Y-m-d 23:59:59', $data['re_start_time'])." +".intval($data['re_year'])." year");
            $data['re_state'] = 1;
        }
	    $insert = $model_store_reopen->addStoreReopen($data);
	    if ($insert) {
	        if ($data['re_pay_amount'] == 0) {
// 	            $model_store->editStore(array('store_end_time'=>$data['re_end_time']),array('store_id'=>$_SESSION['store_id']));
	            showDialog('您的申请已经提交，请等待管理员审核','reload','succ','',5);
	        } else {
	            showDialog(Language::get('nc_common_save_succ').'，需付款金额'.ncPriceFormat($data['re_pay_amount']).'元，请尽快完成付款，付款完成后请上传付款凭证','reload','succ','',5);
	        }
	    } else {
	        showDialog(Language::get('nc_common_del_fail'));
	    }
	}

	//上传付款凭证
	public function reopen_uploadOp() {
	    if (!chksubmit()) exit();
	    $upload = new UploadFile();
	    $uploaddir = ATTACH_PATH.DS.'store_joinin'.DS;
	    $upload->set('default_dir',$uploaddir);
	    $upload->set('allow_type',array('jpg','jpeg','gif','png'));
	    if (!empty($_FILES['re_pay_cert']['tmp_name'])){
	        $result = $upload->upfile('re_pay_cert');
	        if ($result){
	            $pic_name = $upload->file_name;
	        }
	    }
	    $data = array();
	    $data['re_pay_cert'] = $pic_name;
	    $data['re_pay_cert_explain'] = $_POST['re_pay_cert_explain'];
	    $data['re_state'] = 1;
	    $model_store_reopen = Model('store_reopen');
	    $update = $model_store_reopen->editStoreReopen($data,array('re_id'=>$_POST['re_id'],'re_state'=>0));
	    if ($update) {
	        showDialog('上传成功，请等待系统审核','reload','succ');
	    }else {
	        showDialog(Language::get('nc_common_del_fail'));
	    }
	}

	/**
	 * 删除未上传付款凭证的续签信息
	 */
	public function reopen_delOp() {
	    $model_store_reopen	= Model('store_reopen');
	    $condition = array();
	    $condition['re_id'] = intval($_GET['re_id']);
	    $condition['re_state'] = 0;
	    $condition['re_store_id'] = $_SESSION['store_id'];
	    $del = $model_store_reopen->delStoreReopen($condition);
	    if ($del) {
	        showDialog(Language::get('nc_common_del_succ'),'reload','succ');
	    }else {
	        showDialog(Language::get('nc_common_del_fail'));
	    }
	}

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @param array 	$array		附加菜单
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='',$array=array()) {
	    Language::read('member_layout');
	    $lang	= Language::getLangContent();
	    $menu_array		= array();
	    switch ($menu_type) {
	        case 'index':
                $menu_array[] = array('menu_key'=>'bind_class', 'menu_name'=>$lang['nc_member_path_bind_class'], 'menu_url'=>'index.php?act=store_info&op=bind_class');
                if (!checkPlatformStore()) {
                    $menu_array[] = array('menu_key'=>'index', 'menu_name'=>$lang['nc_member_path_store_info'], 'menu_url'=>'index.php?act=store_info&op=index');
                    $menu_array[] = array('menu_key'=>'reopen', 'menu_name'=>$lang['nc_member_path_store_reopen'], 'menu_url'=>'index.php?act=store_info&op=reopen');
                }
	            break;
	    	case 'bind_class':
	    	    $menu_array = array(
	    	    array('menu_key'=>'index', 'menu_name'=>$lang['nc_member_path_bind_class'], 'menu_url'=>'index.php?act=store_bind_class&op=index'),
	    	    );
	    	    break;
	    	case 'add':
	    	    $menu_array = array(
	    	    array('menu_key'=>'index', 'menu_name'=>$lang['nc_member_path_bind_class'], 'menu_url'=>'index.php?act=store_bind_class&op=index'),
	    	    array('menu_key'=>'add', 'menu_name'=>$lang['nc_member_path_bind_class_add'], 'menu_url'=>'index.php?act=store_bind_class&op=add')
	    	    );
	    	    break;
	    }
	    if(!empty($array)) {
	        $menu_array[] = $array;
	    }
	    Tpl::output('member_menu',$menu_array);
	    Tpl::output('menu_key',$menu_key);
	}
}
