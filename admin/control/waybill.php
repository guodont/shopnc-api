<?php
/**
 * 运单模板
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class waybillControl extends SystemControl{

    private $url_waybill_list;

    public function __construct(){
        parent::__construct();
        $this->url_waybill_list = urlAdmin('waybill', 'waybill_list');
    }

    public function indexOp() {
        $this->waybill_listOp();
    }

    /**
     * 运单模板列表
     */
    public function waybill_listOp() {
        $model_waybill = Model('waybill');

        $waybill_list = $model_waybill->getWaybillAdminList(10);
        Tpl::output('list', $waybill_list);
        Tpl::output('page', $model_waybill->showpage(2));

        $this->show_menu('waybill_list');
        Tpl::showpage('waybill.list');
    }

    /**
     * 添加运单模板
     */
    public function waybill_addOp() {
        $model_express = Model('express');

        Tpl::output('express_list', $model_express->getExpressList());
        $this->show_menu('waybill_add');
        Tpl::showpage('waybill.add');
    }

    /**
     * 保存运单模板
     */
    public function waybill_saveOp() {
        $model_waybill = Model('waybill');
        $result = $model_waybill->saveWaybill($_POST);

        if(!isset($result['error'])) {
            $this->log('保存运单模板' . '[ID:' . $result. ']', 1);
            showMessage(L('nc_common_save_succ'), $this->url_waybill_list);
        } else {
            $this->log('保存运单模板' . '[ID:' . $result. ']', 0);
            showMessage(L('nc_common_save_fail'), $this->url_waybill_list);
        }
    }

    /**
     * 编辑运单模板
     */
    public function waybill_editOp() {
        $model_express = Model('express');
        $model_waybill = Model('waybill');

        $waybill_info = $model_waybill->getWaybillInfoByID($_GET['waybill_id']);
        if(!$waybill_info) {
            showMessage('运单模板不存在');
        }
        Tpl::output('waybill_info', $waybill_info);

        $express_list = $model_express->getExpressList();
        foreach ($express_list as $key => $value) {
            if($value['id'] == $waybill_info['express_id']) {
                $express_list[$key]['selected'] = true;
            }
        }
        Tpl::output('express_list', $express_list);

        $this->show_menu('waybill_edit');
        Tpl::showpage('waybill.add');
    }

    /**
     * 设计运单模板
     */
    public function waybill_designOp() {
        $model_waybill = Model('waybill');

        $result = $model_waybill->getWaybillDesignInfo($_GET['waybill_id']);
        if(isset($result['error'])) {
            showMessage($result['error'], '', '', 'error');
        }

        Tpl::output('waybill_info', $result['waybill_info']);
        Tpl::output('waybill_info_data', $result['waybill_info_data']);
        Tpl::output('waybill_item_list', $result['waybill_item_list']);
        $this->show_menu('waybill_design');
        Tpl::showpage('waybill.design');
    }

    /**
     * 设计运单模板保存
     */
    public function waybill_design_saveOp() {
        $model_waybill = Model('waybill');

        $result = $model_waybill->editWaybillDataByID($_POST['waybill_data'], $_POST['waybill_id']);

        if($result) {
            $this->log('保存运单模板设计' . '[ID:' . $_POST['waybill_id'] . ']', 1);
            showMessage(L('nc_common_save_succ'), $this->url_waybill_list);
        } else {
            $this->log('保存运单模板设计' . '[ID:' . $_POST['waybill_id'] . ']', 0);
            showMessage(L('nc_common_save_fail'), $this->url_waybill_list);
        }
    }

    /**
     * 删除运单模板
     */
    public function waybill_delOp() {
        $waybill_id = intval($_POST['waybill_id']);
        if($waybill_id <= 0) {
            showMessage(L('param_error'));
        }

        $model_waybill = Model('waybill');

        $result = $model_waybill->delWaybill(array('waybill_id' => $waybill_id));
        if($result) {
            $this->log('删除运单模板' . '[ID:' . $waybill_id . ']', 1);
            showMessage(L('nc_common_del_succ'));
        } else {
            $this->log('删除运单模板' . '[ID:' . $waybill_id . ']', 0);
            showMessage(L('nc_common_del_fail'));
        }
    }

    /**
     * 打印测试
     */
    public function waybill_testOp() {
        $model_waybill = Model('waybill');

        $waybill_info = $model_waybill->getWaybillInfoByID($_GET['waybill_id']);
        if(!$waybill_info) {
            showMessage('运单模板不存在');
        }
        Tpl::output('waybill_info', $waybill_info);
        Tpl::showpage('waybill.test', 'null_layout');
    }

	/**
	 * ajax操作
	 */
	public function ajaxOp() {
        switch ($_GET['branch']) {
        case 'usable':
            $model_waybill = Model('waybill');
            $where = array('waybill_id' => intval($_GET['id']));
            $update = array('waybill_usable' => intval($_GET['value']));
            $model_waybill->editWaybill($update, $where);
            echo 'true';exit;
            break;
        }
    }

    /**
     * 页面内导航菜单
     * @param string 	$menu_key	当前导航的menu_key
     * @param array 	$array		附加菜单
     * @return
     */
    private function show_menu($menu_key='') {
        $menu_array = array(
            1=>array('menu_key'=>'waybill_list','menu_name'=>'列表', 'menu_url'=>urlAdmin('waybill', 'waybill_list')),
            2=>array('menu_key'=>'waybill_add','menu_name'=>'添加',	'menu_url'=>urlAdmin('waybill', 'waybill_add')),
        );
        if($menu_key == 'waybill_edit') {
            $menu_array[] = array('menu_key'=>'waybill_edit', 'menu_name'=>'编辑', 'menu_url'=>'javascript:;');
        }
        if($menu_key == 'waybill_design') {
            $menu_array[] = array('menu_key'=>'waybill_design', 'menu_name'=>'设计', 'menu_url'=>'javascript:;');
        }
        Tpl::output('menu', $menu_array);
        Tpl::output('menu_key', $menu_key);
    }

}
