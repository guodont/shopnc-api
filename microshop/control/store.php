<?php
/**
 * 微商城店铺街
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class storeControl extends MircroShopControl{

	public function __construct() {
		parent::__construct();
        Tpl::output('index_sign','store');
    }

	public function indexOp(){
        $this->store_listOp();
	}

    /**
     * 店铺列表
     */
    public function store_listOp() {
		$model_store = Model('store');
		$model_microshop_store = Model('micro_store');
        $condition = array();
        if(!empty($_GET['keyword'])) {
            $condition['store_name'] = array('like','%'.trim($_GET['keyword']).'%');
        }
		$store_list = $model_microshop_store->getListWithStoreInfo($condition,30,'microshop_sort asc');
		Tpl::output('list',$store_list);
        Tpl::output('show_page',$model_store->showpage(2));	
        //广告位
        self::get_microshop_adv('store_list');
        Tpl::output('html_title',Language::get('nc_microshop_store').'-'.Language::get('nc_microshop').'-'.C('site_name'));
		Tpl::showpage('store_list');
    }

    /**
     * 店铺详细页
     */
    public function detailOp() {
        $store_id = intval($_GET['store_id']);
        if($store_id <= 0) {
            header('location: '.MICROSHOP_SITE_URL);die;
        }
		$model_store = Model('store');
		$model_goods = Model('goods');
		$model_microshop_store = Model('micro_store');

        $store_info = $model_microshop_store->getOneWithStoreInfo(array('microshop_store_id'=>$store_id));
        if(empty($store_info)) {
            header('location: '.MICROSHOP_SITE_URL);
        }

        //点击数加1
        $update = array();
        $update['click_count'] = array('exp','click_count+1');
        $model_microshop_store->modify($update,array('microshop_store_id'=>$store_id));

        Tpl::output('detail',$store_info);

        $condition = array();
        $condition['store_id'] = $store_info['shop_store_id'];
        $goods_list = $model_goods->getGoodsListByColorDistinct($condition, 'goods_id,store_id,goods_name,goods_image,goods_price,goods_salenum', 'goods_id asc', 39);
        Tpl::output('comment_type','store');
        Tpl::output('comment_id',$store_id);
		Tpl::output('list',$goods_list);
        Tpl::output('show_page',$model_goods->showpage());	
        //获得分享app列表
        self::get_share_app_list();
        Tpl::output('html_title',$store_info['store_name'].'-'.Language::get('nc_microshop_store').'-'.Language::get('nc_microshop').'-'.C('site_name'));
		Tpl::showpage('store_detail');
    }

}
