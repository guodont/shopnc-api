<?php
/**
 * 手机专题
 *
 *
 *
 *
 */



defined('InShopNC') or exit('Access Invalid!');
class mb_specialControl extends SystemControl{
	public function __construct(){
		parent::__construct();
	}

    /**
     * 专题列表
     */
    public function special_listOp() {
        $model_mb_special = Model('mb_special');

        $mb_special_list = $model_mb_special->getMbSpecialList($array, 10);

        Tpl::output('list', $mb_special_list);
        Tpl::output('page', $model_mb_special->showpage(2));

        $this->show_menu('special_list');
        Tpl::showpage('mb_special.list');
    }

    /**
     * 保存专题
     */
    public function special_saveOp() {
        $model_mb_special = Model('mb_special');

        $param = array();
        $param['special_desc'] = $_POST['special_desc'];
        $result = $model_mb_special->addMbSpecial($param);

        if($result) {
            $this->log('添加手机专题' . '[ID:' . $result. ']', 1);
            showMessage(L('nc_common_save_succ'), urlAdmin('mb_special', 'special_list'));
        } else {
            $this->log('添加手机专题' . '[ID:' . $result. ']', 0);
            showMessage(L('nc_common_save_fail'), urlAdmin('mb_special', 'special_list'));
        }
    }

    /**
     * 编辑专题描述 
     */
    public function update_special_descOp() {
        $model_mb_special = Model('mb_special');

        $param = array();
        $param['special_desc'] = $_GET['value'];
        $result = $model_mb_special->editMbSpecial($param, $_GET['id']);

        $data = array();
        if($result) {
            $this->log('保存手机专题' . '[ID:' . $result. ']', 1);
            $data['result'] = true;
        } else {
            $this->log('保存手机专题' . '[ID:' . $result. ']', 0);
            $data['result'] = false;
            $data['message'] = '保存失败';
        }
        echo json_encode($data);die;
    }

    /**
     * 删除专题
     */
    public function special_delOp() {
        $model_mb_special = Model('mb_special');

        $result = $model_mb_special->delMbSpecialByID($_POST['special_id']);

        if($result) {
            $this->log('删除手机专题' . '[ID:' . $_POST['special_id'] . ']', 1);
            showMessage(L('nc_common_del_succ'), urlAdmin('mb_special', 'special_list'));
        } else {
            $this->log('删除手机专题' . '[ID:' . $_POST['special_id'] . ']', 0);
            showMessage(L('nc_common_del_fail'), urlAdmin('mb_special', 'special_list'));
        }
    }

    /**
     * 编辑首页
     */
    public function index_editOp() {
        $model_mb_special = Model('mb_special');

        $special_item_list = $model_mb_special->getMbSpecialItemListByID($model_mb_special::INDEX_SPECIAL_ID);
        Tpl::output('list', $special_item_list);
        Tpl::output('page', $model_mb_special->showpage(2));

        Tpl::output('module_list', $model_mb_special->getMbSpecialModuleList());
        Tpl::output('special_id', $model_mb_special::INDEX_SPECIAL_ID);

        $this->show_menu('index_edit');
        Tpl::showpage('mb_special_item.list');
    }

    /**
     * 编辑专题
     */
    public function special_editOp() {
        $model_mb_special = Model('mb_special');

        $special_item_list = $model_mb_special->getMbSpecialItemListByID($_GET['special_id']);
        Tpl::output('list', $special_item_list);
        Tpl::output('page', $model_mb_special->showpage(2));

        Tpl::output('module_list', $model_mb_special->getMbSpecialModuleList());
        Tpl::output('special_id', $_GET['special_id']);

        $this->show_menu('special_item_list');
        Tpl::showpage('mb_special_item.list');
    }

    /**
     * 专题项目添加
     */
    public function special_item_addOp() {
        $model_mb_special = Model('mb_special');

        $param = array();
        $param['special_id'] = $_POST['special_id'];
        $param['item_type'] = $_POST['item_type'];

        //广告只能添加一个
        if($param['item_type'] == 'adv_list') {
            $result = $model_mb_special->isMbSpecialItemExist($param);
            if($result) {
                echo json_encode(array('error' => '广告条板块只能添加一个'));die;
            }
        }

        $item_info = $model_mb_special->addMbSpecialItem($param);
        if($item_info) {
            echo json_encode($item_info);die;
        } else {
            echo json_encode(array('error' => '添加失败'));die;
        }
    }

    /**
     * 专题项目删除
     */
    public function special_item_delOp() {
        $model_mb_special = Model('mb_special');

        $condition = array();
        $condition['item_id'] = $_POST['item_id'];

        $result = $model_mb_special->delMbSpecialItem($condition, $_POST['special_id']);
        if($result) {
            echo json_encode(array('message' => '删除成功'));die;
        } else {
            echo json_encode(array('error' => '删除失败'));die;
        }
    }

    /**
     * 专题项目编辑
     */
    public function special_item_editOp() {
        $model_mb_special = Model('mb_special');

        $item_info = $model_mb_special->getMbSpecialItemInfoByID($_GET['item_id']);
        Tpl::output('item_info', $item_info);

        if($item_info['special_id'] == 0) {
            $this->show_menu('index_edit');
        } else {
            $this->show_menu('special_item_list');
        }
        Tpl::showpage('mb_special_item.edit');
    }

    /**
     * 专题项目保存
     */
    public function special_item_saveOp() {
        $model_mb_special = Model('mb_special');

        $result = $model_mb_special->editMbSpecialItemByID(array('item_data' => $_POST['item_data']), $_POST['item_id'], $_POST['special_id']); 

        if($result) {
            if($_POST['special_id'] == $model_mb_special::INDEX_SPECIAL_ID) {
                showMessage(L('nc_common_save_succ'), urlAdmin('mb_special', 'index_edit'));
            } else {
                showMessage(L('nc_common_save_succ'), urlAdmin('mb_special', 'special_edit', array('special_id' => $_POST['special_id'])));
            }
        } else {
            showMessage(L('nc_common_save_succ'), '');
        }
    }

    /**
     * 图片上传
     */
    public function special_image_uploadOp() {
        $data = array();
        if(!empty($_FILES['special_image']['name'])) {
            $prefix = 's' . $_POST['special_id'];
            $upload	= new UploadFile();
            $upload->set('default_dir', ATTACH_MOBILE . DS . 'special' . DS . $prefix);
            $upload->set('fprefix', $prefix);
            $upload->set('allow_type', array('gif', 'jpg', 'jpeg', 'png'));

            $result = $upload->upfile('special_image');
            if(!$result) {
                $data['error'] = $upload->error;
            }
            $data['image_name'] = $upload->file_name;
            $data['image_url'] = getMbSpecialImageUrl($data['image_name']);
        }
        echo json_encode($data);
    }

    /**
     * 商品列表
     */
    public function goods_listOp() {
        $model_goods = Model('goods');

        $condition = array();
        $condition['goods_name'] = array('like', '%' . $_POST['keyword'] . '%');
        $goods_list = $model_goods->getGoodsOnlineList($condition, 'goods_id,goods_name,goods_promotion_price,goods_image', 10);
        Tpl::output('goods_list', $goods_list);
        Tpl::output('show_page', $model_goods->showpage());
        Tpl::showpage('mb_special_widget.goods', 'null_layout');
    }

    /**
     * 更新项目排序
     */
    public function update_item_sortOp() {
        $item_id_string = $_POST['item_id_string'];
        $special_id = $_POST['special_id'];
        if(!empty($item_id_string)) {
            $model_mb_special = Model('mb_special');
            $item_id_array = explode(',', $item_id_string);
            $index = 0;
            foreach ($item_id_array as $item_id) {
                $result = $model_mb_special->editMbSpecialItemByID(array('item_sort' => $index), $item_id, $special_id);
                $index++;
            }
        }
        $data = array();
        $data['message'] = '操作成功';
        echo json_encode($data);
    }

    /**
     * 更新项目启用状态
     */
    public function update_item_usableOp() {
        $model_mb_special = Model('mb_special');
        $result = $model_mb_special->editMbSpecialItemUsableByID($_POST['usable'], $_POST['item_id'], $_POST['special_id']);
        $data = array();
        if($result) {
            $data['message'] = '操作成功';
        } else {
            $data['error'] = '操作失败';
        }
        echo json_encode($data);
    }

    /**
     * 页面内导航菜单
     * @param string 	$menu_key	当前导航的menu_key
     * @param array 	$array		附加菜单
     * @return
     */
    private function show_menu($menu_key='') {
        $menu_array = array();
        if($menu_key == 'index_edit') {
            $menu_array[] = array('menu_key'=>'index_edit', 'menu_name'=>'编辑', 'menu_url'=>'javascript:;');
        } else {
            $menu_array[] = array('menu_key'=>'special_list','menu_name'=>'列表', 'menu_url'=>urlAdmin('mb_special', 'special_list'));
        }
        if($menu_key == 'special_item_list') {
            $menu_array[] = array('menu_key'=>'special_item_list', 'menu_name'=>'编辑专题', 'menu_url'=>'javascript:;');
        }
        if($menu_key == 'index_edit') {
            tpl::output('item_title', '首页编辑');
        } else {
            tpl::output('item_title', '专题设置');
        }
        Tpl::output('menu', $menu_array);
        Tpl::output('menu_key', $menu_key);
    }
}

