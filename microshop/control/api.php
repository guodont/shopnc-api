<?php
/**
 * 微商城api
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class apiControl extends MircroShopControl{

    private $data_type = 'html';

	public function __construct() {
		parent::__construct();
        if(!empty($_GET['data_type']) && $_GET['data_type'] === 'json') {
            $this->data_type = 'json';
        }
    }

    /**
     * 获取微商城名称
     */
    public function get_micro_nameOp() {
        $result = '';
        $micro_name = Language::get('nc_microshop');
        if($this->data_type === 'json') {
            $result = json_encode($micro_name);
        } else {
            $result = $micro_name;
        }

        $this->return_result($result);
    }

    /**
     * 推荐个人秀
     */
	public function get_personal_commendOp(){
        $result = '';
        $data_count = intval($_GET['data_count']);
        if($data_count <= 0) {
            $data_count = 8;
        }
        $condition_personal = array();
        $condition_personal['microshop_commend'] = 1;
        $model_micro_personal = Model('micro_personal');
        $personal_list = $model_micro_personal->getListWithUserInfo($condition_personal, null, '', '*', $data_count);
        if($this->data_type === 'json') {
            $result = json_encode($personal_list);
        } else {
            Tpl::output('personal_list',$personal_list);
            ob_start();
            Tpl::showpage('api_personal_list', 'null_layout');
            $result = ob_get_clean();
        }

        $this->return_result($result);
    }

    /**
     * 个人秀分类
     */
	public function get_personal_classOp(){
        $result = '';
        $model_class = Model('micro_personal_class');
        $class_list = $model_class->getList(TRUE, NULL, 'class_sort asc');
        if($this->data_type === 'json') {
            $result = json_encode($class_list);
        } else {
            Tpl::output('class_list',$class_list);
            ob_start();
            Tpl::showpage('api_personal_class', 'null_layout');
            $result = ob_get_clean();
        }

        $this->return_result($result);
    }

    /**
     * 推荐店铺
     */
	public function get_store_commendOp(){
        $result = '';
        $data_count = intval($_GET['data_count']);
        if($data_count <= 0) {
            $data_count = 10;
        }
        $condition_store = array();
        $condition_store['microshop_commend'] = 1;
        $model_micro_store = Model('micro_store');
        $model_store = Model('store');
        $store_list = $model_micro_store->getListWithStoreInfo($condition_personal, null, 'like_count desc,click_count desc', '*', $data_count);
        if($this->data_type === 'json') {
            $result = json_encode($store_list);
        } else {
            Tpl::output('store_list',$store_list);
            ob_start();
            Tpl::showpage('api_store_list', 'null_layout');
            $result = ob_get_clean();
        }

        $this->return_result($result);
	}

    private function return_result($result) {
        $result = str_replace("\n", "", $result);
        $result = str_replace("\r", "", $result);
        echo empty($_GET['callback']) ? $result : $_GET['callback']."('".$result."')";
    }
}
