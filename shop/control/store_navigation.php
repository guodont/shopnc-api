<?php
/**
 * 店铺导航
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class store_navigationControl extends BaseSellerControl {
    public function __construct() {
        parent::__construct();
        Language::read('member_store_index');
    }

    public function navigation_listOp() {
        $model_store_navigation = Model('store_navigation');
        $navigation_list = $model_store_navigation->getStoreNavigationList(array('sn_store_id' => $_SESSION['store_id']));
		Tpl::output('navigation_list', $navigation_list);
		self::profile_menu('store_navigation');
		Tpl::showpage('store_navigation.list');
    }

    public function navigation_addOp() {
        $this->profile_menu('navigation_add');
        Tpl::showpage('store_navigation.form');
    }

    public function navigation_editOp() {
        $sn_id = intval($_GET['sn_id']);
        if($sn_id <= 0) {
           showMessage(L('wrong_argument'), urlShop('store_navigation', 'navigation_list'), '', 'error');
        }
        $model_store_navigation = Model('store_navigation');
        $sn_info = $model_store_navigation->getStoreNavigationInfo(array('sn_id' => $sn_id));
        if(empty($sn_info) || intval($sn_info['sn_store_id']) !== intval($_SESSION['store_id'])) {
           showMessage(L('wrong_argument'), urlShop('store_navigation', 'navigation_list'), '', 'error');
        }
        Tpl::output('sn_info', $sn_info);
        $this->profile_menu('navigation_edit');
        Tpl::showpage('store_navigation.form');
    }

    public function navigation_saveOp() {
        $sn_info = array(
            'sn_title' => $_POST['sn_title'],
            'sn_content' => $_POST['sn_content'],
            'sn_sort' => empty($_POST['sn_sort'])?255:$_POST['sn_sort'],
            'sn_if_show' => $_POST['sn_if_show'],
            'sn_url' => $_POST['sn_url'],
            'sn_new_open' => $_POST['sn_new_open'],
            'sn_store_id' => $_SESSION['store_id'],
            'sn_add_time' => TIMESTAMP
        );
        $model_store_navigation = Model('store_navigation');
        if(!empty($_POST['sn_id']) && intval($_POST['sn_id']) > 0) {
            $this->recordSellerLog('编辑店铺导航，导航编号'.$_POST['sn_id']);
            $condition = array('sn_id' => $_POST['sn_id']);
            $result = $model_store_navigation->editStoreNavigation($sn_info, $condition);
        } else {
            $result = $model_store_navigation->addStoreNavigation($sn_info);
            $this->recordSellerLog('新增店铺导航，导航编号'.$result);
        }
        showDialog(L('nc_common_op_succ'), urlShop('store_navigation', 'navigation_list'), 'succ');
    }

    public function navigation_delOp() {
        $sn_id = intval($_POST['sn_id']);
        if($sn_id > 0) {
            $condition = array(
                'sn_id' => $sn_id,
                'sn_store_id' => $_SESSION['store_id']
            );
            $model_store_navigation = Model('store_navigation');
            $model_store_navigation->delStoreNavigation($condition);
            $this->recordSellerLog('删除店铺导航，导航编号'.$sn_id);
            showDialog(L('nc_common_op_succ'), urlShop('store_navigation', 'navigation_list'), 'succ');
        } else {
            showDialog(L('nc_common_op_fail'), urlShop('store_navigation', 'navigation_list'), 'error');
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string 	$menu_key	当前导航的menu_key
     * @return
     */
    private function profile_menu($menu_key = '') {
        $menu_array = array();
        $menu_array[] = array(
            'menu_key' => 'store_navigation',
            'menu_name' => '导航列表',
            'menu_url' => urlShop('store_navigation', 'navigation_list')
        );
        if($menu_key == 'navigation_add') {
            $menu_array[] = array(
                'menu_key' => 'navigation_add',
                'menu_name' => '添加导航',
                'menu_url' => urlShop('store_navigation', 'navigation_add')
            );
        }
        if($menu_key == 'navigation_edit') {
            $menu_array[] = array(
                'menu_key' => 'navigation_edit',
                'menu_name' => '编辑导航',
                'menu_url' => urlShop('store_navigation', 'navigation_edit')
            );
        }
        Tpl::output('member_menu', $menu_array);
        Tpl::output('menu_key', $menu_key);
    }

}

