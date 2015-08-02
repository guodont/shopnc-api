<?php
/**
 * cms调用接口
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class apiControl extends CMSHomeControl{

	public function __construct() {
		parent::__construct();
    }

    /**
     * 商品列表
     */
	public function goods_listOp() {
		$model_goods = Model('goods');
		$page	= new Page();
		$page->setEachNum(6);
		$page->setStyle('1');
		$condition = array();
        if($_GET['search_type'] == 'goods_url') {
            $condition['goods_id'] = intval($_GET['search_keyword']);
        } else {
            $condition['goods_name'] = trim($_GET['search_keyword']);
        }
		$condition['goods_show'] = '1';//上架:1是,0否
		$goods_list = $model_goods->getGoods($condition,$page,'goods.goods_id,goods.goods_name,goods.store_id,goods.goods_image,goods.goods_store_price','goods');
		Tpl::output('show_page',$page->show());
		Tpl::output('goods_list',$goods_list);
		Tpl::showpage('api_goods_list','null_layout');
	}

    /**
     * 文章列表
     */
	public function article_listOp() {
        //获取文章列表
		$condition = array();
        if($_GET['search_type'] == 'article_id') {
            $condition['article_id'] = intval($_GET['search_keyword']);
        } else {
            $condition['article_title'] = array('like','%'.trim($_GET['search_keyword']).'%');
        }
        $condition['article_state'] = self::ARTICLE_STATE_PUBLISHED;

        $model_article = Model('cms_article');
        $article_list = $model_article->getList($condition , 10, 'article_id desc');
        Tpl::output('show_page',$model_article->showpage(1));
        Tpl::output('article_list', $article_list);
		Tpl::showpage('api_article_list','null_layout');
	}

    /**
     * 图片商品添加
     */
    public function goods_info_by_urlOp() {
        $url = urldecode($_GET['url']);
        if(empty($url)) {
            self::return_json(Language::get('goods_not_exist'), 'false');
        }
        $model_goods_info = Model('goods_info_by_url');
        $result = $model_goods_info->get_goods_info_by_url($url);
        if($result) {
            self::echo_json($result);
        } else {
            self::return_json(Language::get('goods_not_exist'), 'false');
        }
    }

}
