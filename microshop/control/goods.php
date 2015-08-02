<?php
/**
 * 推荐商品(随心看)
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class goodsControl extends MircroShopControl{

	public function __construct() {
        parent::__construct();
        Tpl::output('index_sign','goods');
    }

	public function indexOp() {
        $this->listOp();
	}

	public function listOp() {

        $model_goods_class = Model('micro_goods_class');
        $goods_class_list = $model_goods_class->getList(TRUE,NULL,'class_sort asc');

        $goods_class_root = array();
        $goods_class_menu = array();
        if(!empty($goods_class_list)) {
            foreach($goods_class_list as $val) {
                if($val['class_parent_id'] == 0) {
                    $goods_class_root[] = $val;
                } else {
                    $goods_class_menu[$val['class_parent_id']][] = $val;
                }
            }
        }

        //处理一级菜单选中
        $goods_class_root_id = $goods_class_root[0]['class_id'];
        if(isset($_GET['goods_class_root_id'])) {
            if(intval($_GET['goods_class_root_id']) > 0) {
                $goods_class_root_id = $_GET['goods_class_root_id'];
            }
        }
        Tpl::output('goods_class_root',$goods_class_root);
        Tpl::output('goods_class_root_id',$goods_class_root_id);

        //处理二级菜单选中
        $goods_class_menu_id = 0;
        if(isset($_GET['goods_class_menu_id'])) {
            if(intval($_GET['goods_class_menu_id']) > 0) {
                $goods_class_menu_id = $_GET['goods_class_menu_id'];
            }
        }
        Tpl::output('goods_class_menu',$goods_class_menu[$goods_class_root_id]);
        Tpl::output('goods_class_menu_id',$goods_class_menu_id);

        /**
         * 查询条件处理
         **/
        $condition = array();
        if(isset($_GET['keyword'])) {
            $condition['commend_goods_name'] = array('like','%'.$_GET['keyword'].'%'); 
        }
        //分类条件 
        if($goods_class_menu_id > 0) {
            //选中二级菜单
            $condition['class_id'] = $goods_class_menu_id; 
        } else {
            //只选中一级菜单
            $class_array = $goods_class_menu[$goods_class_root_id];
            $class_id_string = '';
            if(!empty($class_array)) {
                foreach ($class_array as $val) {
                    $class_id_string .= $val['class_id'].',';
                }
            }
            $class_id_string = rtrim($class_id_string,',');
            if(!empty($class_id_string)) {
                $condition['class_id'] = array('in',$class_id_string);
            }
        }

        $order = 'microshop_sort asc,commend_time desc';
        if($_GET['order'] == 'hot') {
            $order = 'microshop_sort asc,click_count desc';
        }
        self::get_goods_list($condition,$order);

        Tpl::output('html_title',Language::get('nc_microshop_goods').'-'.Language::get('nc_microshop').'-'.C('site_name'));
		Tpl::showpage('goods_list');

	}

    public function detailOp() {

        $goods_id = intval($_GET['goods_id']);
        if($goods_id <= 0) {
            header('location: '.MICROSHOP_SITE_URL);die;
        }
        $model_microshop_goods = Model('micro_goods');
        $condition = array();
        $condition['commend_id'] = $goods_id;
        $detail = $model_microshop_goods->getOneWithUserInfo($condition);
        if(empty($detail)) {
            header('location: '.MICROSHOP_SITE_URL);die;
        }
        Tpl::output('detail',$detail);

        //商品多图
        $model_goods = Model('goods');
        $goods_image_list = $model_goods->getGoodsImageList(array('goods_commonid' => $detail['commend_goods_commonid']));
        Tpl::output('goods_image_list', $goods_image_list);


        //点击数加1
        $update = array();
        $update['click_count'] = array('exp','click_count+1');
        $model_microshop_goods->modify($update,$condition);

        //侧栏
        self::get_sidebar_list($detail['commend_member_id']);

        //店铺信息
		$model_store = Model('store');
        $store_info = $model_store->getStoreInfoByID($detail['commend_goods_store_id']);
        $store_info['hot_sales_list'] = $model_store->getHotSalesList($detail['commend_goods_store_id'], 5);
        Tpl::output('store_info',$store_info);

        //获得分享app列表
        self::get_share_app_list();
        Tpl::output('comment_id',$detail['commend_id']);
        Tpl::output('comment_type','goods');
        Tpl::output('html_title',$detail['commend_goods_name'].'-'.Language::get('nc_microshop_goods').'-'.Language::get('nc_microshop').'-'.C('site_name'));
		Tpl::showpage('goods_detail');

    }
}
