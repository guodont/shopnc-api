<?php
/**
 * 商品规格管理
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class store_specControl extends BaseSellerControl {
    public function __construct() {
        parent::__construct();
    }

    /**
     * 选择分类
     */
    public function indexOp() {
        // 获取商品分类
        $model_goodsclass = Model('goods_class');
        $gc_list = $model_goodsclass->getGoodsClass($_SESSION['store_id']);
        Tpl::output('gc_list', $gc_list);

        $this->_profile_menu('spec', 'spec');
        Tpl::showpage('store_spec.index');
    }

    /**
     * 添加规格值
     */
    public function add_specOp(){
        $sp_id = intval($_GET['spid']);
        $gc_id = intval($_GET['gcid']);
        // 验证参数
        if ($sp_id <= 0) {
            showMessage(L('wrong_argument'));
        }
        // 分类信息
        $gc_info = Model('goods_class')->getGoodsClassInfoById($gc_id);
        Tpl::output('gc_info', $gc_info);
        // 规格信息
        $model_spec = Model('spec');
        $sp_info = $model_spec->getSpecInfo($sp_id, 'sp_id,sp_name');
        Tpl::output('sp_info', $sp_info);
        // 规格值信息
        $sp_value_list = $model_spec->getSpecValueList(array('store_id' => $_SESSION['store_id'], 'sp_id' => $sp_id, 'gc_id'=>$gc_id));
        Tpl::output('sp_value_list', $sp_value_list);

        $this->_profile_menu('spec_add', 'add');
        Tpl::showpage('store_spec.add', 'null_layout');
    }

    /**
     * 保存规格值
     */
    public function save_specOp(){
        $sp_id = intval($_POST['sp_id']);
        $gc_id = intval($_POST['gc_id']);
        if($sp_id <= 0 || $gc_id <=0 || !chksubmit()){
            showDialog(L('wrong_argument'));
        }

        $model_spec = Model('spec');
        // 更新原规格值
        if (is_array($_POST['sv']['old'])) {
            foreach ($_POST['sv']['old'] as $key=> $value) {
                if (empty($value['name'])) {
                    continue;
                }
                $where = array('sp_value_id' => $key);
                $update = array(
                        'sp_value_name' => $value['name'],
                        'sp_id' => $sp_id,
                        'gc_id' => $gc_id,
                        'store_id' => $_SESSION['store_id'],
                        'sp_value_color' => $value['color'],
                        'sp_value_sort' => intval($value['sort'])
                    );
                $model_spec->editSpecValue($update, $where);
            }
        }

        // 添加新规格值
        if (is_array($_POST['sv']['new'])) {
            $insert_array = array();
            foreach ($_POST['sv']['new'] as $value) {
                if (empty($value['name'])) {
                    continue;
                }
                $tmp_insert = array(
                        'sp_value_name' => $value['name'],
                        'sp_id' => $sp_id,
                        'gc_id' => $gc_id,
                        'store_id' => $_SESSION['store_id'],
                        'sp_value_color' => $value['color'],
                        'sp_value_sort' => intval($value['sort'])
                    );
                $insert_array[] = $tmp_insert;
            }
            $model_spec->addSpecValueALL($insert_array);
        }

        showDialog(L('nc_common_op_succ'), 'reload', 'succ');
    }

    /**
     * ajax删除规格值
     */
    public function ajax_delspecOp(){
        $sp_value_id = intval($_GET['id']);
        if ($sp_value_id <= 0) {
            echo 'false'; exit();
        }
        $rs = Model('spec')->delSpecValue(array('sp_value_id' => $sp_value_id, 'store_id' => $_SESSION['store_id']));
        if ($rs) {
            echo 'true'; exit();
        } else {
            echo 'false'; exit();
        }
    }

    /**
     * AJAX获取商品分类
     */
    public function ajax_classOp() {
        $id = intval($_GET['id']);
        $deep = intval($_GET['deep']);
        if ($id <= 0 || $deep <=0 || $deep >= 4) {
            echo 'false'; exit();
        }
        $deep += 1;
        $model_goodsclass = Model('goods_class');

        // 验证分类是否存在
        $gc_info = $model_goodsclass->getGoodsClassInfoById($id);
        if (empty($gc_info)) {
            echo 'false'; exit();
        }

        // 读取商品分类
        if ($deep != 4) {
            $gc_list = $model_goodsclass->getGoodsClass($_SESSION['store_id'], $id, $deep);
        }
        // 分类不为空输出分类信息
        if (!empty($gc_list)) {
            $data = array('type' => 'class', 'data' => $gc_list, 'deep' => $deep);
        } else {
            // 查询类型
            $model_type = Model('type');
            $spec_list = $model_type->getSpecByType(array('type_id' => $gc_info['type_id']), 'type_id, spec.*');

            $data = array('type' => 'spec', 'data' => $spec_list, 'gcid' => $id, 'deep' => $deep);
        }

        // 转码
        if (strtoupper(CHARSET) == 'GBK') {
            $data = Language::getUTF8($data);
        }
        echo json_encode($data);
        exit();
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string	$menu_type	导航类型
     * @param string 	$menu_key	当前导航的menu_key
     * @return
     */
    private function _profile_menu($menu_type, $menu_key) {
        $menu_array = array();
        switch ($menu_type) {
            case 'spec':
                $menu_array = array(
                    array('menu_key' => 'spec', 'menu_name' => L('nc_member_path_store_spec'), 'menu_url' => 'index.php?act=store_spec')
                );
            break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
