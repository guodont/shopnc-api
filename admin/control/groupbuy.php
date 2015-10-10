<?php
/**
 * 抢购管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class groupbuyControl extends SystemControl{

    public function __construct(){
        parent::__construct();
        Language::read('groupbuy');

		//如果是执行开启抢购操作，直接返回
		if ($_GET['groupbuy_open'] == 1) return true;

        //检查抢购功能是否开启
        if (C('groupbuy_allow') != 1){
 			$url = array(
 				array(
					'url'=>'index.php?act=dashboard&op=welcome',
					'msg'=>Language::get('close'),
				),
				array(
					'url'=>'index.php?act=groupbuy&op=groupbuy_template_list&groupbuy_open=1',
					'msg'=>Language::get('open'),
				),
			);
			showMessage(Language::get('admin_groupbuy_unavailable'),$url,'html','succ',1,6000);
        }
    }

    public function indexOp() {
        $this->groupbuy_listOp();
    }

    /**
     * 进行中抢购列表，只可推荐
     *
     */
    public function groupbuy_listOp(){
        $model_groupbuy = Model('groupbuy');

        $condition = array();
        if(!empty($_GET['groupbuy_name'])) {
            $condition['groupbuy_name'] = array('like', '%'.$_GET['groupbuy_name'].'%');
        }
        if(!empty($_GET['store_name'])) {
            $condition['store_name'] = array('like', '%'.$_GET['store_name'].'%');
        }
        if(!empty($_GET['groupbuy_state'])) {
            $condition['state'] = $_GET['groupbuy_state'];
        }
        $groupbuy_list = $model_groupbuy->getGroupbuyExtendList($condition, 10);
        Tpl::output('groupbuy_list',$groupbuy_list);
        Tpl::output('show_page',$model_groupbuy->showpage());
        Tpl::output('groupbuy_state_array', $model_groupbuy->getGroupbuyStateArray());

        $this->show_menu('groupbuy_list');

        // 输出自营店铺IDS
        Tpl::output('flippedOwnShopIds', array_flip(model('store')->getOwnShopIds()));
        Tpl::showpage('groupbuy.list');
    }

    /**
     * 审核通过
     */
    public function groupbuy_review_passOp(){
        $groupbuy_id = intval($_POST['groupbuy_id']);

        $model_groupbuy = Model('groupbuy');
        $result = $model_groupbuy->reviewPassGroupbuy($groupbuy_id);
        if($result) {
        	$this->log('通过抢购活动申请，抢购编号'.$groupbuy_id,null);
            // 添加队列
            $groupbuy_info = $model_groupbuy->getGroupbuyInfo(array('groupbuy_id' => $groupbuy_id));
            $this->addcron(array('exetime' => $groupbuy_info['start_time'], 'exeid' => $groupbuy_info['goods_commonid'], 'type' => 5));
            $this->addcron(array('exetime' => $groupbuy_info['end_time'], 'exeid' => $groupbuy_info['goods_commonid'], 'type' => 6));
            showMessage(L('nc_common_op_succ'), '');
        } else {
            showMessage(L('nc_common_op_fail'), '');
        }
    }

    /**
     * 审核失败
     */
    public function groupbuy_review_failOp(){
        $groupbuy_id = intval($_POST['groupbuy_id']);

        $model_groupbuy = Model('groupbuy');
        $result = $model_groupbuy->reviewFailGroupbuy($groupbuy_id);
        if($result) {
        	$this->log('拒绝抢购活动申请，抢购编号'.$groupbuy_id,null);
            showMessage(L('nc_common_op_succ'), '');
        } else {
            showMessage(L('nc_common_op_fail'), '');
        }
    }

    /**
     * 取消
     */
    public function groupbuy_cancelOp() {
        $groupbuy_id = intval($_POST['groupbuy_id']);

        $model_groupbuy = Model('groupbuy');
        $result = $model_groupbuy->cancelGroupbuy($groupbuy_id);
        if($result) {
        	$this->log('取消抢购活动，抢购编号'.$groupbuy_id,null);
            showMessage(L('nc_common_op_succ'), '');
        } else {
            showMessage(L('nc_common_op_fail'), '');
        }
    }

    /**
     * 删除
     */
    public function groupbuy_delOp(){
        $groupbuy_id = intval($_POST['groupbuy_id']);

        $model_groupbuy = Model('groupbuy');
        $result = $model_groupbuy->delGroupbuy(array('groupbuy_id' => $groupbuy_id));
        if($result) {
        	$this->log('删除抢购活动，抢购编号'.$groupbuy_id,null);
            showMessage(L('nc_common_op_succ'), '');
        } else {
            showMessage(L('nc_common_op_fail'), '');
        }
    }

    /**
     * ajax修改抢购信息
     */
    public function ajaxOp(){

        $result = true;
        $update_array = array();
        $where_array = array();

        switch ($_GET['branch']){
        case 'class_sort':
            $model= Model('groupbuy_class');
            $update_array['sort'] = $_GET['value'];
            $where_array['class_id'] = $_GET['id'];
            $result = $model->update($update_array,$where_array);
            // 删除抢购分类缓存
            Model('groupbuy')->dropCachedData('groupbuy_classes');
            break;
        case 'class_name':
            $model= Model('groupbuy_class');
            $update_array['class_name'] = $_GET['value'];
            $where_array['class_id'] = $_GET['id'];
            $result = $model->update($update_array,$where_array);
            // 删除抢购分类缓存
            Model('groupbuy')->dropCachedData('groupbuy_classes');
            $this->log(L('groupbuy_class_edit_success').'[ID:'.$_GET['id'].']', null);
            break;
         case 'recommended':
            $model= Model('groupbuy');
            $update_array['recommended'] = $_GET['value'];
            $where_array['groupbuy_id'] = $_GET['id'];
            $result = $model->editGroupbuy($update_array, $where_array);
            break;
        }
        if($result) {
            echo 'true';exit;
        }
        else {
            echo 'false';exit;
        }

    }

    /**
     * 套餐管理
     **/
    public function groupbuy_quotaOp() {
        $model_groupbuy_quota = Model('groupbuy_quota');

        $condition = array();
        $condition['store_name'] = array('like', '%'.$_GET['store_name'].'%');
        $list = $model_groupbuy_quota->getGroupbuyQuotaList($condition, 10, 'end_time desc');
        Tpl::output('list',$list);
        Tpl::output('show_page',$model_groupbuy_quota->showpage());

        $this->show_menu('groupbuy_quota');
        Tpl::showpage('groupbuy_quota.list');
    }

    /**
     * 抢购类别列表
     */
    public function class_listOp() {

        $model_groupbuy_class = Model('groupbuy_class');
        $param = array();
        $param['order'] = 'sort asc';
        $groupbuy_class_list = $model_groupbuy_class->getTreeList($param);

        $this->show_menu('class_list');
        Tpl::output('list',$groupbuy_class_list);
        Tpl::showpage('groupbuy_class.list');
    }

    /**
     * 添加抢购分类页面
     */
    public function class_addOp() {

        $model_groupbuy_class = Model('groupbuy_class');
        $param = array();
        $param['order'] = 'sort asc';
        $param['class_parent_id'] = 0;
        $groupbuy_class_list = $model_groupbuy_class->getList($param);
        Tpl::output('list',$groupbuy_class_list);

        $this->show_menu('class_add');
        Tpl::output('parent_id',$_GET['parent_id']);
        Tpl::showpage('groupbuy_class.add');

    }

    /**
     * 保存添加的抢购类别
     */
    public function class_saveOp() {

        $class_id = intval($_POST['class_id']);
        $param = array();
        $param['class_name'] = trim($_POST['input_class_name']);
        if(empty($param['class_name'])) {
            showMessage(Language::get('class_name_error'),'');
        }
        $param['sort'] = intval($_POST['input_sort']);
        $param['class_parent_id'] = intval($_POST['input_parent_id']);

        $model_groupbuy_class = Model('groupbuy_class');

        // 删除抢购分类缓存
        Model('groupbuy')->dropCachedData('groupbuy_classes');

        if(empty($class_id)) {
            //新增
            if($model_groupbuy_class->save($param)) {
            	$this->log(L('groupbuy_class_add_success').'[ID:'.$class_id.']', null);
                showMessage(Language::get('groupbuy_class_add_success'),'index.php?act=groupbuy&op=class_list');
            }
            else {
                showMessage(Language::get('groupbuy_class_add_fail'),'index.php?act=groupbuy&op=class_list');
            }
        }
        else {
            //编辑
            if($model_groupbuy_class->update($param,array('class_id'=>$class_id))) {
            	$this->log(L('groupbuy_class_edit_success').'[ID:'.$class_id.']', null);
                showMessage(Language::get('groupbuy_class_edit_success'),'index.php?act=groupbuy&op=class_list');
            }
            else {
                showMessage(Language::get('groupbuy_class_edit_fail'),'index.php?act=groupbuy&op=class_list');
            }
        }

    }

    /**
     * 删除抢购类别
     */
    public function class_dropOp() {

        $class_id = trim($_POST['class_id']);
        if(empty($class_id)) {
            showMessage(Language::get('param_error'),'');
        }

        $model_groupbuy_class = Model('groupbuy_class');
        //获得所有下级类别编号
        $all_class_id = $model_groupbuy_class->getAllClassId(explode(',',$class_id));
        $param = array();
        $param['in_class_id'] = implode(',',$all_class_id);
        if($model_groupbuy_class->drop($param)) {
            // 删除抢购分类缓存
            Model('groupbuy')->dropCachedData('groupbuy_classes');

        	$this->log(L('groupbuy_class_drop_success').'[ID:'.$param['in_class_id'].']',null);
            showMessage(Language::get('groupbuy_class_drop_success'),'');
        }
        else {
            showMessage(Language::get('groupbuy_class_drop_fail'),'');
        }

    }

    /**
     * 抢购价格区间列表
     */
    public function price_listOp() {

        $model= Model('groupbuy_price_range');
        $groupbuy_price_list = $model->getList();
        Tpl::output('list',$groupbuy_price_list);

        $this->show_menu('price_list');
        Tpl::showpage('groupbuy_price.list');
    }

    /**
     * 添加抢购价格区间页面
     */
    public function price_addOp() {

        $this->show_menu('price_add');
        Tpl::showpage('groupbuy_price.add');

    }

    /**
     * 编辑抢购价格区间页面
     */
    public function price_editOp() {

        $range_id = intval($_GET['range_id']);
        if(empty($range_id)) {
            showMessage(Language::get('param_error'),'');
        }

        $model = Model('groupbuy_price_range');

        $price_info = $model->getOne($range_id);
        if(empty($price_info)) {
            showMessage(Language::get('param_error'),'');
        }
        Tpl::output('price_info',$price_info);

        $this->show_menu('price_edit');
        Tpl::showpage('groupbuy_price.add');

    }

    /**
     * 保存添加的抢购价格区间
     */
    public function price_saveOp() {

        $range_id = intval($_POST['range_id']);
        $param = array();
        $param['range_name'] = trim($_POST['range_name']);
        if(empty($param['range_name'])) {
            showMessage(Language::get('range_name_error'),'');
        }
        $param['range_start'] = intval($_POST['range_start']);
        $param['range_end'] = intval($_POST['range_end']);

        $model = Model('groupbuy_price_range');

        if(empty($range_id)) {
            //新增
            if($model->save($param)) {
            	dkcache('groupbuy_price');
            	$this->log(L('groupbuy_price_range_add_success').'['.$_POST['range_name'].']',null);
                showMessage(Language::get('groupbuy_price_range_add_success'),'index.php?act=groupbuy&op=price_list');
            }
            else {
                showMessage(Language::get('groupbuy_price_range_add_fail'),'index.php?act=groupbuy&op=price_list');
            }
        }
        else {
            //编辑
            if($model->update($param,array('range_id'=>$range_id))) {
            	dkcache('groupbuy_price');
            	$this->log(L('groupbuy_price_range_edit_success').'['.$_POST['range_name'].']',null);
                showMessage(Language::get('groupbuy_price_range_edit_success'),'index.php?act=groupbuy&op=price_list');
            }
            else {
                showMessage(Language::get('groupbuy_price_range_edit_fail'),'index.php?act=groupbuy&op=price_list');
            }
        }

    }

    /**
     * 删除抢购价格区间
     */
    public function price_dropOp() {

        $range_id = trim($_POST['range_id']);
        if(empty($range_id)) {
            showMessage(Language::get('param_error'),'');
        }

        $model = Model('groupbuy_price_range');
        $param = array();
        $param['in_range_id'] = "'".implode("','", explode(',', $range_id))."'";
        if($model->drop($param)) {
        	dkcache('groupbuy_price');
        	$this->log(L('groupbuy_price_range_drop_success').'[ID:'.$range_id.']',null);
            showMessage(Language::get('groupbuy_price_range_drop_success'),'');
        }
        else {
            showMessage(Language::get('groupbuy_price_range_drop_fail'),'');
        }
    }

    /**
     * 设置
     **/
    public function groupbuy_settingOp() {

        $model_setting = Model('setting');
        $setting = $model_setting->GetListSetting();
        Tpl::output('setting',$setting);

        $this->show_menu('groupbuy_setting');
        Tpl::showpage('groupbuy.setting');
    }

    public function groupbuy_setting_saveOp() {
        $groupbuy_price = intval($_POST['groupbuy_price']);
        if($groupbuy_price < 0) {
            $groupbuy_price = 0;
        }

        $groupbuy_review_day = intval($_POST['groupbuy_review_day']);
        if($groupbuy_review_day< 0) {
            $groupbuy_review_day = 0;
        }

        $model_setting = Model('setting');
        $update_array = array();
        $update_array['groupbuy_price'] = $groupbuy_price;
        $update_array['groupbuy_review_day'] = $groupbuy_review_day;
        $result = $model_setting->updateSetting($update_array);
        if ($result){
            $this->log('修改抢购套餐价格为'.$groupbuy_price.'元');
            showMessage(Language::get('nc_common_op_succ'),'');
        }else {
            showMessage(Language::get('nc_common_op_fail'),'');
        }
    }

    /**
     * 幻灯片设置
     */
    public function sliderOp()
    {
        $model_setting = Model('setting');
        if (chksubmit()) {
            $update = array();
            if (!empty($_FILES['live_pic1']['name'])) {
                $upload = new UploadFile();
                $upload->set('default_dir',ATTACH_LIVE);
                $result = $upload->upfile('live_pic1');
                if ($result) {
                    $update['live_pic1'] = $upload->file_name;
                }else {
                    showMessage($upload->error, '', '', 'error');
                }
            }

            if (!empty($_POST['live_link1'])) {
                $update['live_link1'] = $_POST['live_link1'];
            }

            if (!empty($_FILES['live_pic2']['name'])) {
                $upload = new UploadFile();
                $upload->set('default_dir',ATTACH_LIVE);
                $result = $upload->upfile('live_pic2');
                if ($result) {
                    $update['live_pic2'] = $upload->file_name;
                } else {
                    showMessage($upload->error, '', '', 'error');
                }
            }

            if (!empty($_POST['live_link2'])) {
                $update['live_link2'] = $_POST['live_link2'];
            }

            if (!empty($_FILES['live_pic3']['name'])) {
                $upload = new UploadFile();
                $upload->set('default_dir',ATTACH_LIVE);
                $result = $upload->upfile('live_pic3');
                if ($result) {
                    $update['live_pic3'] = $upload->file_name;
                } else {
                    showMessage($upload->error, '', '', 'error');
                }
            }

            if (!empty($_POST['live_link3'])) {
                $update['live_link3'] = $_POST['live_link3'];
            }

            if (!empty($_FILES['live_pic4']['name'])) {
                $upload = new UploadFile();
                $upload->set('default_dir',ATTACH_LIVE);
                $result = $upload->upfile('live_pic4');
                if ($result) {
                    $update['live_pic4'] = $upload->file_name;
                } else {
                    showMessage($upload->error, '', '', 'error');
                }
            }

            if (!empty($_POST['live_link4'])) {
                $update['live_link4'] = $_POST['live_link4'];
            }

            $list_setting = $model_setting->getListSetting();
            $result = $model_setting->updateSetting($update);
            if ($result) {
                if($list_setting['live_pic1'] != '' && isset($update['live_pic1'])){
                    @unlink(BASE_UPLOAD_PATH.DS.ATTACH_LIVE.DS.$list_setting['live_pic1']);
                }

                if($list_setting['live_pic2'] != '' && isset($update['live_pic2'])){
                    @unlink(BASE_UPLOAD_PATH.DS.ATTACH_LIVE.DS.$list_setting['live_pic2']);
                }

                if($list_setting['live_pic3'] != '' && isset($update['live_pic3'])){
                    @unlink(BASE_UPLOAD_PATH.DS.ATTACH_LIVE.DS.$list_setting['live_pic3']);
                }

                if($list_setting['live_pic4'] != '' && isset($update['live_pic4'])){
                    @unlink(BASE_UPLOAD_PATH.DS.ATTACH_LIVE.DS.$list_setting['live_pic4']);
                }

                dkcache('setting');
                $this->log('修改抢购幻灯片设置', 1);
                showMessage('编辑成功', '', '', 'succ');
            } else {
                showMessage('编辑失败', '', '', 'error');
            }
        }

        $list_setting = $model_setting->getListSetting();
        Tpl::output('list_setting', $list_setting);

        $this->show_menu('slider');
        Tpl::showpage('groupbuy.slider');
    }

    /**
     * 幻灯片清空
     */
    public function slider_clearOp()
    {
        $model_setting = Model('setting');
        $update = array();
        $update['live_pic1'] = '';
        $update['live_link1'] = '';
        $update['live_pic2'] = '';
        $update['live_link2'] = '';
        $update['live_pic3'] = '';
        $update['live_link3'] = '';
        $update['live_pic4'] = '';
        $update['live_link4'] = '';
        $res = $model_setting->updateSetting($update);
        if ($res) {
            dkcache('setting');
            $this->log('清空抢购幻灯片设置', 1);
            echo json_encode(array('result'=>'true'));
        } else {
            echo json_encode(array('result'=>'false'));
        }
        exit;
    }

    /**
     * 页面内导航菜单
     *
     * @param string 	$menu_key	当前导航的menu_key
     * @param array 	$array		附加菜单
     * @return
     */
    private function show_menu($menu_key) {
        $menu_array = array(
            'groupbuy_list'=>array('menu_type'=>'link','menu_name'=>'抢购活动','menu_url'=>'index.php?act=groupbuy&op=groupbuy_list'),
            'groupbuy_quota'=>array('menu_type'=>'link','menu_name'=>'套餐管理','menu_url'=>'index.php?act=groupbuy&op=groupbuy_quota'),
            'class_list'=>array('menu_type'=>'link','menu_name'=>Language::get('groupbuy_class_list'),'menu_url'=>'index.php?act=groupbuy&op=class_list'),
            'class_add'=>array('menu_type'=>'link','menu_name'=>Language::get('groupbuy_class_add'),'menu_url'=>'index.php?act=groupbuy&op=class_add'),
            'price_list'=>array('menu_type'=>'link','menu_name'=>Language::get('groupbuy_price_list'),'menu_url'=>'index.php?act=groupbuy&op=price_list'),
            'price_add'=>array('menu_type'=>'link','menu_name'=>Language::get('groupbuy_price_add'),'menu_url'=>'index.php?act=groupbuy&op=price_add'),
            'price_edit'=>array('menu_type'=>'link','menu_name'=>Language::get('groupbuy_price_edit'),'menu_url'=>'index.php?act=groupbuy&op=price_edit'),
            'groupbuy_setting'=>array('menu_type'=>'link','menu_name'=>'设置','menu_url'=>urlAdmin('groupbuy', 'groupbuy_setting')),
            'slider'=>array('menu_type'=>'link','menu_name'=>'幻灯片管理','menu_url'=>urlAdmin('groupbuy', 'slider')),
        );
        switch ($menu_key) {
            case 'class_add':
                unset($menu_array['price_add']);
                unset($menu_array['price_edit']);
                break;
            case 'price_add':
                unset($menu_array['class_add']);
                unset($menu_array['price_edit']);
                break;
            case 'price_edit':
                unset($menu_array['class_add']);
                unset($menu_array['price_add']);
                break;
            default:
                unset($menu_array['class_add']);
                unset($menu_array['price_add']);
                unset($menu_array['price_edit']);
                break;
        }
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }
}
