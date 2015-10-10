<?php
/**
 * 卖家账号组管理
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class store_account_groupControl extends BaseSellerControl {
    public function __construct() {
        parent::__construct();
        Language::read('member_store_index');
    }

    public function group_listOp() {
        $model_seller_group = Model('seller_group');
        $seller_group_list = $model_seller_group->getSellerGroupList(array('store_id' => $_SESSION['store_id']));
        Tpl::output('seller_group_list', $seller_group_list);
        $this->profile_menu('group_list');
        Tpl::showpage('store_account_group.list');
    }

    public function group_addOp() {
        // 店铺消息模板列表
        $smt_list = Model('store_msg_tpl')->getStoreMsgTplList(array(), 'smt_code,smt_name');
        Tpl::output('smt_list', $smt_list);

        $this->profile_menu('group_add');
        Tpl::showpage('store_account_group.add');
    }

    public function group_editOp() {
        $group_id = intval($_GET['group_id']);
        if ($group_id <= 0) {
            showMessage('参数错误', '', '', 'error');
        }
        $model_seller_group = Model('seller_group');
        $seller_group_info = $model_seller_group->getSellerGroupInfo(array('group_id' => $group_id));
        if (empty($seller_group_info)) {
            showMessage('组不存在', '', '', 'error');
        }
        Tpl::output('group_info', $seller_group_info);
        Tpl::output('group_limits', explode(',', $seller_group_info['limits']));
        Tpl::output('smt_limits', explode(',', $seller_group_info['smt_limits']));

        // 店铺消息模板列表
        $smt_list = Model('store_msg_tpl')->getStoreMsgTplList(array(), 'smt_code,smt_name');
        Tpl::output('smt_list', $smt_list);

        $this->profile_menu('group_edit');
        Tpl::showpage('store_account_group.add');
    }

    public function group_saveOp() {
        $seller_info = array();
        $seller_info['group_name'] = $_POST['seller_group_name'];
        $seller_info['limits'] = implode(',', $_POST['limits']);
        $seller_info['smt_limits'] = empty($_POST['smt_limits']) ? '' : implode(',', $_POST['smt_limits']);
        $seller_info['store_id'] = $_SESSION['store_id'];
        $model_seller_group = Model('seller_group');
        if (empty($_POST['group_id'])) {
            $result = $model_seller_group->addSellerGroup($seller_info);
            $this->recordSellerLog('添加组成功，组编号'.$result);
            showDialog('添加成功', urlShop('store_account_group', 'group_list'),'succ');
        } else {
            $condition = array();
            $condition['group_id'] = intval($_POST['group_id']);
            $condition['store_id'] = $_SESSION['store_id'];
            $model_seller_group->editSellerGroup($seller_info, $condition);
            $this->recordSellerLog('编辑组成功，组编号'.$_POST['group_id']);
            showDialog('编辑成功', urlShop('store_account_group', 'group_list'),'succ');
        }
    }

    public function group_delOp() {
        $group_id = intval($_POST['group_id']);
        if($group_id > 0) {
            $condition = array();
            $condition['group_id'] = $group_id;
            $condition['store_id'] = $_SESSION['store_id'];
            $model_seller_group = Model('seller_group');
            $result = $model_seller_group->delSellerGroup($condition);
            if($result) {
                $this->recordSellerLog('删除组成功，组编号'.$group_id);
                showDialog(Language::get('nc_common_op_succ'),'reload','succ');
            } else {
                $this->recordSellerLog('删除组失败，组编号'.$group_id);
                showDialog(Language::get('nc_common_save_fail'),'reload','error');
            }
        } else {
            showDialog(Language::get('wrong_argument'),'reload','error');
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
    private function profile_menu($menu_key='') {
        $menu_array = array();
        $menu_array[] = array(
            'menu_key'=>'group_list',
            'menu_name' => '组列表',
            'menu_url' => urlShop('store_account_group', 'group_list')
        );
        if($menu_key === 'group_add') {
            $menu_array[] = array(
                'menu_key'=>'group_add',
                'menu_name' => '添加组',
                'menu_url' => urlShop('store_account_group', 'group_add')
            );
        }
        if($menu_key === 'group_edit') {
            $menu_array[] = array(
                'menu_key'=>'group_edit',
                'menu_name' => '编辑组',
                'menu_url' => urlShop('store_account_group', 'group_edit')
            );
        }
        Tpl::output('member_menu', $menu_array);
        Tpl::output('menu_key', $menu_key);
    }

}
