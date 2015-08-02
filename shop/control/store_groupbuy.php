<?php
/**
 * 商家中心抢购管理
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_groupbuyControl extends BaseSellerControl {

    public function __construct() {
        parent::__construct();

        //读取语言包
        Language::read('member_groupbuy');
        //检查抢购功能是否开启
        if (intval(C('groupbuy_allow')) !== 1){
            showMessage(Language::get('groupbuy_unavailable'),'index.php?act=seller_center','','error');
        }
    }
    /**
     * 默认显示抢购列表
     **/
    public function indexOp() {
        $this->groupbuy_listOp();
    }

    /**
     * 抢购套餐购买
     **/
    public function groupbuy_quota_addOp() {
        //输出导航
        self::profile_menu('groupbuy_quota_add');
        Tpl::showpage('store_groupbuy_quota.add');
    }

    /**
     * 抢购套餐购买保存
     **/
    public function groupbuy_quota_add_saveOp() {
        $groupbuy_quota_quantity = intval($_POST['groupbuy_quota_quantity']);
        if($groupbuy_quota_quantity <= 0) {
            showDialog('购买数量不能为空');
        }

        $model_groupbuy_quota = Model('groupbuy_quota');

        //获取当前价格
        $current_price = intval(C('groupbuy_price'));

        //获取该用户已有套餐
        $current_groupbuy_quota= $model_groupbuy_quota->getGroupbuyQuotaCurrent($_SESSION['store_id']);
        $add_time = 86400 * 30 * $groupbuy_quota_quantity;
        if(empty($current_groupbuy_quota)) {
            //生成套餐
            $param = array();
            $param['member_id'] = $_SESSION['member_id'];
            $param['member_name'] = $_SESSION['member_name'];
            $param['store_id'] = $_SESSION['store_id'];
            $param['store_name'] = $_SESSION['store_name'];
            $param['start_time'] = TIMESTAMP;
            $param['end_time'] = TIMESTAMP + $add_time;
            $model_groupbuy_quota->addGroupbuyQuota($param);
        } else {
            $param = array();
            $param['end_time'] = array('exp', 'end_time + ' . $add_time);
            $model_groupbuy_quota->editGroupbuyQuota($param, array('quota_id' => $current_groupbuy_quota['quota_id']));
        }

        //记录店铺费用
        $this->recordStoreCost($current_price * $groupbuy_quota_quantity, '购买抢购');

        $this->recordSellerLog('购买'.$groupbuy_quota_quantity.'份抢购套餐，单价'.$current_price.L('nc_yuan'));

        showDialog(Language::get('groupbuy_quota_add_success'), urlShop('store_groupbuy', 'groupbuy_list'), 'succ');
    }

    /**
     * 抢购列表
     **/
    public function groupbuy_listOp() {
        $model_groupbuy = Model('groupbuy');
        $model_groupbuy_quota = Model('groupbuy_quota');

        if (checkPlatformStore()) {
            Tpl::output('isOwnShop', true);
        } else {
            $current_groupbuy_quota = $model_groupbuy_quota->getGroupbuyQuotaCurrent($_SESSION['store_id']);
            Tpl::output('current_groupbuy_quota', $current_groupbuy_quota);
        }

        $condition = array();
        $condition['store_id'] = $_SESSION['store_id'];
        if(!empty($_GET['groupbuy_state'])) {
            $condition['state'] = $_GET['groupbuy_state'];
        }
        $condition['groupbuy_name'] = array('like', '%'.$_GET['groupbuy_name'].'%');

        if (strlen($groupbuy_vr = trim($_GET['groupbuy_vr']))) {
            $condition['is_vr'] = $groupbuy_vr ? 1 : 0;
            Tpl::output('groupbuy_vr', $groupbuy_vr);
        }
        $groupbuy_list = $model_groupbuy->getGroupbuyExtendList($condition, 10);
        Tpl::output('group',$groupbuy_list);
        Tpl::output('show_page',$model_groupbuy->showpage());
        Tpl::output('groupbuy_state_array', $model_groupbuy->getGroupbuyStateArray());

        self::profile_menu('groupbuy_list');
        Tpl::showpage('store_groupbuy.list');
    }

    /**
     * 添加抢购页面
     **/
    public function groupbuy_addOp() {
        $model_groupbuy_quota = Model('groupbuy_quota');

        if (checkPlatformStore()) {
            Tpl::output('isOwnShop', true);
        } else {
            $current_groupbuy_quota = $model_groupbuy_quota->getGroupbuyQuotaCurrent($_SESSION['store_id']);
            if(empty($current_groupbuy_quota)) {
                showMessage('当前没有可用套餐，请先购买套餐',urlShop('store_groupbuy', 'groupbuy_quota_add'),'','error');
            }
            Tpl::output('current_groupbuy_quota', $current_groupbuy_quota);
        }

        // 根据后台设置的审核期重新设置抢购开始时间
        Tpl::output('groupbuy_start_time', TIMESTAMP + intval(C('groupbuy_review_day')) * 86400);

        Tpl::output('groupbuy_classes', Model('groupbuy')->getGroupbuyClasses());

        self::profile_menu('groupbuy_add');
        Tpl::showpage('store_groupbuy.add');

    }

    /**
     * 抢购保存
     **/
    public function groupbuy_saveOp() {
        //获取提交的数据
        $goods_id = intval($_POST['groupbuy_goods_id']);
        if(empty($goods_id)) {
            showDialog(Language::get('param_error'));
        }

        $model_groupbuy = Model('groupbuy');
        $model_goods = Model('goods');
        $model_groupbuy_quota = Model('groupbuy_quota');

        if (!checkPlatformStore()) {
            // 检查套餐
            $current_groupbuy_quota = $model_groupbuy_quota->getGroupbuyQuotaCurrent($_SESSION['store_id']);
            if(empty($current_groupbuy_quota)) {
                showDialog('当前没有可用套餐，请先购买套餐',urlShop('store_groupbuy', 'groupbuy_quota_add'),'error');
            }
        }

        $goods_info = $model_goods->getGoodsInfoByID($goods_id, 'goods_id,goods_commonid,goods_name,goods_price,store_id,virtual_limit');
        if(empty($goods_info) || $goods_info['store_id'] != $_SESSION['store_id']) {
            showDialog(Language::get('param_error'));
        }

        $param = array();
        $param['groupbuy_name'] = $_POST['groupbuy_name'];
        $param['remark'] = $_POST['remark'];
        $param['start_time'] = strtotime($_POST['start_time']);
        $param['end_time'] = strtotime($_POST['end_time']);
        $param['groupbuy_price'] = floatval($_POST['groupbuy_price']);
        $param['groupbuy_rebate'] = ncPriceFormat(floatval($_POST['groupbuy_price'])/floatval($goods_info['goods_price'])*10);
        $param['groupbuy_image'] = $_POST['groupbuy_image'];
        $param['groupbuy_image1'] = $_POST['groupbuy_image1'];
        $param['virtual_quantity'] = intval($_POST['virtual_quantity']);
        $param['upper_limit'] = intval($_POST['upper_limit']);
        $param['groupbuy_intro'] = $_POST['groupbuy_intro'];
        $param['class_id'] = intval($_POST['class_id']);
        $param['goods_id'] = $goods_info['goods_id'];
        $param['goods_commonid'] = $goods_info['goods_commonid'];
        $param['goods_name'] = $goods_info['goods_name'];
        $param['goods_price'] = $goods_info['goods_price'];
        $param['store_id'] = $_SESSION['store_id'];
        $param['store_name'] = $_SESSION['store_name'];

        // 虚拟抢购
        if ($_GET['vr']) {
            if ($param['upper_limit'] > 0 && $goods_info['virtual_limit'] > 0
                && $param['upper_limit'] > $goods_info['virtual_limit']) {
                showDialog(sprintf('虚拟抢购活动的限购数量(%d)不能大于虚拟商品本身的限购数量(%d)',
                    $param['upper_limit'], $goods_info['virtual_limit']
                    ), 'index.php?act=store_groupbuy');
            }

            $param += array(
                'is_vr' => 1,
                'vr_class_id' => (int) $_POST['class'],
                'vr_s_class_id' => (int) $_POST['s_class'],
                'vr_city_id' => (int) $_POST['city'],
                'vr_area_id' => (int) $_POST['area'],
                'vr_mall_id' => (int) $_POST['mall'],
            );
        }

        //保存
        $result = $model_groupbuy->addGroupbuy($param);
        if($result) {
            // 自动发布动态
            // group_id,group_name,goods_id,goods_price,groupbuy_price,group_pic,rebate,start_time,end_time
            $data_array = array();
            $data_array['group_id']			= $result;
            $data_array['group_name']		= $param['group_name'];
            $data_array['goods_id']			= $param['goods_id'];
            $data_array['goods_price']		= $param['goods_price'];
            $data_array['groupbuy_price']	= $param['groupbuy_price'];
            $data_array['group_pic']		= $param['groupbuy_image1'];
            $data_array['rebate']			= $param['groupbuy_rebate'];
            $data_array['start_time']		= $param['start_time'];
            $data_array['end_time']			= $param['end_time'];
            $this->storeAutoShare($data_array, 'groupbuy');

            $this->recordSellerLog('发布抢购活动，抢购名称：'.$param['groupbuy_name'].'，商品名称：'.$param['goods_name']);
            showDialog(Language::get('groupbuy_add_success'),'index.php?act=store_groupbuy','succ');
        }else {
            showDialog(Language::get('groupbuy_add_fail'),'index.php?act=store_groupbuy');
        }
    }

    public function groupbuy_goods_infoOp() {
        $goods_commonid = intval($_GET['goods_commonid']);

        $data = array();
        $data['result'] = true;

        $model_goods = Model('goods');

        $condition = array();
        $condition['goods_commonid'] = $goods_commonid;
        $goods_list = $model_goods->getGoodsOnlineList($condition);

        if(empty($goods_list)) {
            $data['result'] = false;
            $data['message'] = L('param_error');
            echo json_encode($data);die;
        }

        $goods_info = $goods_list[0];
        $data['goods_id'] = $goods_info['goods_id'];
        $data['goods_name'] = $goods_info['goods_name'];
        $data['goods_price'] = $goods_info['goods_price'];
        $data['goods_image'] = thumb($goods_info, 240);
        $data['goods_href'] = urlShop('goods', 'index', array('goods_id' => $goods_info['goods_id']));

        if ($goods_info['is_virtual']) {
            $data['is_virtual'] = 1;
            $data['virtual_indate'] = $goods_info['virtual_indate'];
            $data['virtual_indate_str'] = date('Y-m-d H:i', $goods_info['virtual_indate']);
            $data['virtual_limit'] = $goods_info['virtual_limit'];
        }

        echo json_encode($data);die;
    }

    public function check_groupbuy_goodsOp() {
        $start_time = strtotime($_GET['start_time']);
        $goods_id = $_GET['goods_id'];

        $model_groupbuy = Model('groupbuy');

        $data = array();
        $data['result'] = true;

        //检查商品是否已经参加同时段活动
        $condition = array();
        $condition['end_time'] = array('gt', $start_time);
        $condition['goods_id'] = $goods_id;
        $groupbuy_list = $model_groupbuy->getGroupbuyAvailableList($condition);
        if(!empty($groupbuy_list)) {
            $data['result'] = false;
            echo json_encode($data);die;
        }

        echo json_encode($data);die;
    }

    /**
     * 上传图片
     **/
    public function image_uploadOp() {
        if(!empty($_POST['old_groupbuy_image'])) {
            $this->_image_del($_POST['old_groupbuy_image']);
        }
        $this->_image_upload('groupbuy_image');
    }

    private function _image_upload($file) {
        $data = array();
        $data['result'] = true;
        if(!empty($_FILES[$file]['name'])) {
            $upload	= new UploadFile();
            $uploaddir = ATTACH_PATH.DS.'groupbuy'.DS.$_SESSION['store_id'].DS;
            $upload->set('default_dir', $uploaddir);
            $upload->set('thumb_width',	'480,296,168');
            $upload->set('thumb_height', '480,296,168');
            $upload->set('thumb_ext', '_max,_mid,_small');
            $upload->set('fprefix', $_SESSION['store_id']);
            $result = $upload->upfile($file);
            if($result) {
                $data['file_name'] = $upload->file_name;
                $data['origin_file_name'] = $_FILES[$file]['name'];
                $data['file_url'] = gthumb($upload->file_name, 'mid');
            } else {
                $data['result'] = false;
                $data['message'] = $upload->error;
            }
        } else {
            $data['result'] = false;
        }
        echo json_encode($data);die;
    }

    /**
     * 图片删除
     */
    private function _image_del($image_name) {
        list($base_name, $ext) = explode(".", $image_name);
        $base_name = str_replace('/', '', $base_name);
        $base_name = str_replace('.', '', $base_name);
        list($store_id) = explode('_', $base_name);
        $image_path = BASE_UPLOAD_PATH.DS.ATTACH_GROUPBUY.DS.$store_id.DS;
        $image = $image_path.$base_name.'.'.$ext;
        $image_small = $image_path.$base_name.'_small.'.$ext;
        $image_mid = $image_path.$base_name.'_mid.'.$ext;
        $image_max = $image_path.$base_name.'_max.'.$ext;
        @unlink($image);
        @unlink($image_small);
        @unlink($image_mid);
        @unlink($image_max);
    }

    /**
     * 选择活动商品
     **/
    public function search_goodsOp() {
        $model_goods = Model('goods');
        $condition = array();
        $condition['store_id'] = $_SESSION['store_id'];
        $condition['goods_name'] = array('like', '%'.$_GET['goods_name'].'%');
        $goods_list = $model_goods->getGoodsCommonListForPromotion($condition, '*', 8, 'groupbuy');

        Tpl::output('goods_list', $goods_list);
        Tpl::output('show_page', $model_goods->showpage());
        Tpl::showpage('store_groupbuy.goods', 'null_layout');
    }

    /**
     * 添加虚拟抢购页面
     */
    public function groupbuy_add_vrOp()
    {
        $model_groupbuy_quota = Model('groupbuy_quota');

        if (checkPlatformStore()) {
            Tpl::output('isOwnShop', true);
        } else {
            $current_groupbuy_quota = $model_groupbuy_quota->getGroupbuyQuotaCurrent($_SESSION['store_id']);
            if(empty($current_groupbuy_quota)) {
                showMessage('当前没有可用套餐，请先购买套餐', urlShop('store_groupbuy', 'groupbuy_quota_add'), '', 'error');
            }
            Tpl::output('current_groupbuy_quota', $current_groupbuy_quota);
        }

        // 根据后台设置的审核期重新设置抢购开始时间
        Tpl::output('groupbuy_start_time', TIMESTAMP + intval(C('groupbuy_review_day')) * 86400);

        // 虚拟抢购分类
        // Tpl::output('groupbuy_vr_classes', Model('groupbuy')->getGroupbuyVrClasses());
        $model_vr_groupbuy_class = Model('vr_groupbuy_class');
        $classlist = $model_vr_groupbuy_class->getVrGroupbuyClassList(array('parent_class_id'=>0));
        Tpl::output('classlist', $classlist);

        // 虚拟区域分类
        // Tpl::output('groupbuy_vr_cities', Model('groupbuy')->getGroupbuyVrCities());
        $model_vr_groupbuy_area = Model('vr_groupbuy_area');
        $arealist = $model_vr_groupbuy_area->getVrGroupbuyAreaList(array('parent_area_id'=>0,'hot_city'=>1),'','100');
        Tpl::output('arealist', $arealist);

        self::profile_menu('groupbuy_add_vr');
        Tpl::showpage('store_groupbuy.add_vr');
    }

    public function ajax_vr_classOp()
    {
        $class_id = intval($_GET['class_id']);
        if (empty($class_id)) {
            exit('false');
        }

        $condition = array();
        $condition['parent_class_id'] = $class_id;

        $model_vr_groupbuy_class = Model('vr_groupbuy_class');
        $class_list = $model_vr_groupbuy_class->getVrGroupbuyClassList($condition);

        if (!empty($class_list)) {
            echo json_encode($class_list);
        } else {
            echo 'false';
        }

        exit;
    }

    public function ajax_vr_areaOp()
    {
        $area_id = intval($_GET['area_id']);
        if (empty($area_id)) {
            exit('false');
        }

        $condition = array();
        $condition['parent_area_id'] = $area_id;

        $model_vr_groupbuy_area = Model('vr_groupbuy_area');
        $area_list = $model_vr_groupbuy_area->getVrGroupbuyAreaList($condition);

        if (!empty($area_list)) {
            echo json_encode($area_list);
        } else {
            echo 'false';
        }

        exit;
    }

    /**
     * 选择活动虚拟商品
     */
    public function search_vr_goodsOp()
    {
        $model_goods = Model('goods');
        $condition = array();
        $condition['store_id'] = $_SESSION['store_id'];
        $condition['goods_name'] = array('like', '%'.$_GET['goods_name'].'%');
        $goods_list = $model_goods->getGoodsCommonListForVrPromotion($condition, '*', 8);

        Tpl::output('goods_list', $goods_list);
        Tpl::output('show_page', $model_goods->showpage());
        Tpl::showpage('store_groupbuy.goods', 'null_layout');
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string 	$menu_key	当前导航的menu_key
     * @param array 	$array		附加菜单
     * @return
     */
    private function profile_menu($menu_key='') {
        $menu_array	= array(
            1=>array('menu_key'=>'groupbuy_list','menu_name'=>L('nc_member_path_group_list'),'menu_url'=>urlShop('store_groupbuy', 'groupbuy_list'))
        );
        switch ($menu_key){
        case 'groupbuy_add':
            $menu_array[] = array('menu_key'=>'groupbuy_add','menu_name'=>L('nc_member_path_new_group'),'menu_url'=>'index.php?act=store_groupbuy&op=groupbuy_add');
            break;
        case 'groupbuy_add_vr':
            $menu_array[] = array('menu_key'=>'groupbuy_add_vr','menu_name'=>'新增虚拟抢购','menu_url'=>'index.php?act=store_groupbuy&op=groupbuy_add_vr');
            break;
        case 'groupbuy_quota_add':
            $menu_array[] = array('menu_key'=>'groupbuy_quota_add','menu_name'=>'购买套餐','menu_url'=>urlShop('store_groupbuy', 'groupbuy_quota_add'));
            break;
        case 'groupbuy_edit':
            $menu_array[] = array('menu_key'=>'groupbuy_edit','menu_name'=>L('nc_member_path_edit_group'),'menu_url'=>'index.php?act=store_groupbuy');
            break;
        case 'cancel':
            $menu_array[] = array('menu_key'=>'groupbuy_cancel','menu_name'=>L('nc_member_path_cancel_group'));
            break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
