<?php
/**
 * 商品
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */
defined('InShopNC') or exit('Access Invalid!');
class storeControl extends apiHomeControl{

	public function __construct() {
        parent::__construct();
    }

    /**
     * 商品列表
     */
    public function goods_listOp() {
        $model_goods = Model('goods');

        //查询条件
        $condition = array();
        if(!empty($_GET['store_id']) && intval($_GET['store_id']) > 0) {
            $condition['store_id'] = $_GET['store_id'];
        } elseif (!empty($_GET['keyword'])) { 
            $condition['goods_name|goods_jingle'] = array('like', '%' . $_GET['keyword'] . '%');
        }

        //所需字段
        $fieldstr = "goods_id,goods_commonid,store_id,goods_name,goods_price,goods_marketprice,goods_image,goods_salenum,evaluation_good_star,evaluation_count";

        //排序方式
        $order = $this->_goods_list_order($_GET['key'], $_GET['order']);

        $goods_list = $model_goods->getGoodsListByColorDistinct($condition, $fieldstr, $order, $this->page);
        $page_count = $model_goods->gettotalpage();

        //处理商品列表(团购、限时折扣、商品图片)
        $goods_list = $this->_goods_list_extend($goods_list);

        output_data(array('goods_list' => $goods_list), mobile_page($page_count));
    }

    /**
     * 商品列表排序方式
     */
    private function _goods_list_order($key, $order) {
        $result = 'goods_id desc';
        if (!empty($key)) {

            $sequence = 'desc';
            if($order == 1) {
                $sequence = 'asc';
            }

            switch ($key) {
                //销量
                case '1' :
                    $result = 'goods_salenum' . ' ' . $sequence;
                    break;
                //浏览量
                case '2' : 
                    $result = 'goods_click' . ' ' . $sequence;
                    break;
                //价格
                case '3' :
                    $result = 'goods_price' . ' ' . $sequence;
                    break;
            }
        }
        return $result;
    }

    /**
     * 处理商品列表(团购、限时折扣、商品图片)
     */
    private function _goods_list_extend($goods_list) {
        //获取商品列表编号数组
        $commonid_array = array();
        $goodsid_array = array();
        foreach($goods_list as $key => $value) {
            $commonid_array[] = $value['goods_commonid'];
            $goodsid_array[] = $value['goods_id'];
        }

        //促销
        $groupbuy_list = Model('groupbuy')->getGroupbuyListByGoodsCommonIDString(implode(',', $commonid_array));
        $xianshi_list = Model('p_xianshi_goods')->getXianshiGoodsListByGoodsString(implode(',', $goodsid_array));
        foreach ($goods_list as $key => $value) {
            //团购
            if (isset($groupbuy_list[$value['goods_commonid']])) {
                $goods_list[$key]['goods_price'] = $groupbuy_list[$value['goods_commonid']]['groupbuy_price'];
                $goods_list[$key]['group_flag'] = true;
            } else {
                $goods_list[$key]['group_flag'] = false;
            }

            //限时折扣
            if (isset($xianshi_list[$value['goods_id']]) && !$goods_list[$key]['group_flag']) {
                $goods_list[$key]['goods_price'] = $xianshi_list[$value['goods_id']]['xianshi_price'];
                $goods_list[$key]['xianshi_flag'] = true;
            } else {
                $goods_list[$key]['xianshi_flag'] = false;
            }

            //商品图片url
            $goods_list[$key]['goods_image_url'] = cthumb($value['goods_image'], 360, $value['store_id']); 

            unset($goods_list[$key]['store_id']);
            unset($goods_list[$key]['goods_commonid']);
            unset($goods_list[$key]['nc_distinct']);
        }

        return $goods_list;
    }

    /**
     * 商品详细页
     */
    public function store_detailOp() {
        $store_id = intval($_GET ['store_id']);
        // 商品详细信息
        $model_store = Model('store');
        $store_info = $model_store->getStoreOnlineInfoByID($store_id);
        if (empty($store_info)) {
            output_error('店铺不存在');
        }
        $store_detail['store_pf'] = $store_info['store_credit'];
        $store_detail['store_info'] = $store_info;
        // //店铺导航
        // $model_store_navigation = Model('store_navigation');
        // $store_navigation_list = $model_store_navigation->getStoreNavigationList(array('sn_store_id' => $store_id));
        // $store_detail['store_navigation_list'] = $store_navigation_list;
        // //幻灯片图片
        // if($this->store_info['store_slide'] != '' && $this->store_info['store_slide'] != ',,,,'){
        //     $store_detail['store_slide'] = explode(',', $this->store_info['store_slide']);
        //     $store_detail['store_slide_url'] = explode(',', $this->store_info['store_slide_url']);
        // }

        //店铺详细信息处理
        // $store_detail = $this->_store_detail_extend($store_info);
        output_data($store_detail);
    }

    /**
     * 店铺详细信息处理
     */
    private function _store_detail_extend($store_detail) {
        //整理数据
        unset($store_detail['store_info']['goods_commonid']);
        unset($store_detail['store_info']['gc_id']);
        unset($store_detail['store_info']['gc_name']);
        // unset($goods_detail['goods_info']['store_id']);
        // unset($goods_detail['goods_info']['store_name']);
        unset($store_detail['store_info']['brand_id']);
        unset($store_detail['store_info']['brand_name']);
        unset($store_detail['store_info']['type_id']);
        unset($store_detail['store_info']['goods_image']);
        unset($store_detail['store_info']['goods_body']);
        unset($store_detail['store_info']['goods_state']);
        unset($store_detail['store_info']['goods_stateremark']);
        unset($store_detail['store_info']['goods_verify']);
        unset($store_detail['store_info']['goods_verifyremark']);
        unset($store_detail['store_info']['goods_lock']);
        unset($store_detail['store_info']['goods_addtime']);
        unset($store_detail['store_info']['goods_edittime']);
        unset($store_detail['store_info']['goods_selltime']);
        unset($store_detail['store_info']['goods_show']);
        unset($store_detail['store_info']['goods_commend']);

        return $store_detail;
    }

    // /**
    //  * 商品详细页
    //  */
    // public function goods_bodyOp() {
    //     $store_id = intval($_GET ['store_id']);

    //     $model_goods = Model('goods');

    //     $goods_info = $model_goods->getGoodsInfo(array('goods_id' => $goods_id));
    //     $goods_common_info = $model_goods->getGoodeCommonInfo(array('goods_commonid' => $goods_info['goods_commonid']));

    //     Tpl::output('goods_common_info', $goods_common_info);
    //     Tpl::showpage('goods_body');
    // }
}
