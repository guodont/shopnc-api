<?php
/**
 * 商品
 *
 * by 33hao.com 好商城V3
 *
 *
 */
//by 33hao.com
//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class goodsControl extends apiHomeControl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 商品列表
     */
    public function goods_listOp()
    {
        $model_goods = Model('goods');
        $model_search = Model('search');

        //查询条件
        $condition = array();
        if (!empty($_GET['gc_id']) && intval($_GET['gc_id']) > 0) {
            $condition['gc_id'] = $_GET['gc_id'];
        } elseif (!empty($_GET['keyword'])) {
            $condition['goods_name|goods_jingle'] = array('like', '%' . $_GET['keyword'] . '%');
        }

        //所需字段
        $fieldstr = "goods_id,goods_commonid,store_id,goods_name,goods_price,goods_marketprice,goods_image,goods_salenum,evaluation_good_star,evaluation_count";

        // 添加3个状态字段
        $fieldstr .= ',is_virtual,is_presell,is_fcode,have_gift';

        //排序方式
        $order = $this->_goods_list_order($_GET['key'], $_GET['order']);

        //优先从全文索引库里查找
        list($indexer_ids, $indexer_count) = $model_search->indexerSearch($_GET, $this->page);
        if (is_array($indexer_ids)) {
            //商品主键搜索
            $goods_list = $model_goods->getGoodsOnlineList(array('goods_id' => array('in', $indexer_ids)), $fieldstr, 0, $order, $this->page, null, false);

            //如果有商品下架等情况，则删除下架商品的搜索索引信息
            if (count($goods_list) != count($indexer_ids)) {
                $model_search->delInvalidGoods($goods_list, $indexer_ids);
            }
            pagecmd('setEachNum', $this->page);
            pagecmd('setTotalNum', $indexer_count);
        } else {
            $goods_list = $model_goods->getGoodsListByColorDistinct($condition, $fieldstr, $order, $this->page);
        }
        $page_count = $model_goods->gettotalpage();
        //处理商品列表(抢购、限时折扣、商品图片)
        $goods_list = $this->_goods_list_extend($goods_list);

        output_data(array('goods_list' => $goods_list), mobile_page($page_count));
    }

    /**
     * 扫条码商品列表
     */
    public function goods_list_by_scanOp()
    {
        $model_goods = Model('goods');
        $model_search = Model('search');

        //查询条件
        $condition = array();
        if (!empty($_GET['gc_id']) && intval($_GET['gc_id']) > 0) {
            $condition['gc_id'] = $_GET['gc_id'];
        } elseif (!empty($_GET['keyword'])) {
            $condition['goods_name|goods_cas|goods_jingle'] = array('like', '%' . $_GET['keyword'] . '%');
        } elseif (!empty($_GET['code'])) {
            $condition['goods_serial|goods_jingle'] = array('like', '%' . $_GET['code'] . '%');
        }

        //所需字段
        $fieldstr = "goods_id,goods_commonid,store_id,goods_name,goods_price,goods_marketprice,goods_image,goods_salenum,evaluation_good_star,evaluation_count";

        // 添加3个状态字段
        $fieldstr .= ',is_virtual,is_presell,is_fcode,have_gift';

        //排序方式
        $order = $this->_goods_list_order($_GET['key'], $_GET['order']);

        //优先从全文索引库里查找
        list($indexer_ids, $indexer_count) = $model_search->indexerSearch($_GET, $this->page);
        if (is_array($indexer_ids)) {
            //商品主键搜索
            $goods_list = $model_goods->getGoodsOnlineList(array('goods_id' => array('in', $indexer_ids)), $fieldstr, 0, $order, $this->page, null, false);

            //如果有商品下架等情况，则删除下架商品的搜索索引信息
            if (count($goods_list) != count($indexer_ids)) {
                $model_search->delInvalidGoods($goods_list, $indexer_ids);
            }
            pagecmd('setEachNum', $this->page);
            pagecmd('setTotalNum', $indexer_count);
        } else {
            $goods_list = $model_goods->getGoodsListByColorDistinct($condition, $fieldstr, $order, $this->page);
        }
        $page_count = $model_goods->gettotalpage();
        //处理商品列表(抢购、限时折扣、商品图片)
        $goods_list = $this->_goods_list_extend($goods_list);

        output_data(array('goods_list' => $goods_list), mobile_page($page_count));
    }

    /**
     * GET 专题商品
     */
    public function special_goodsOp()
    {
        $model_goods = Model('goods');

        //所需字段
        $fieldstr = "goods_id,goods_commonid,store_id,goods_name,goods_price,goods_marketprice,goods_image,goods_salenum,evaluation_good_star,evaluation_count";

        // 添加3个状态字段
        $fieldstr .= ',is_virtual,is_presell,is_fcode,have_gift';

        $indexer_ids = explode(",", $_GET['ids']);

        $goods_list = $model_goods->getGoodsOnlineList(array('goods_id' => array('in', $indexer_ids)), $fieldstr, 0, '', $this->page, null, false);

        $page_count = $model_goods->gettotalpage();

        $goods_list = $this->_goods_list_extend($goods_list);

        output_data(array('goods_list' => $goods_list), mobile_page($page_count));
    }

    /**
     * 商品列表排序方式
     */
    private function _goods_list_order($key, $order)
    {
        $result = 'is_own_shop desc,goods_id desc';
        if (!empty($key)) {

            $sequence = 'desc';
            if ($order == 1) {
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
     * 处理商品列表(抢购、限时折扣、商品图片)
     */
    private function _goods_list_extend($goods_list)
    {
        //获取商品列表编号数组
        $commonid_array = array();
        $goodsid_array = array();
        foreach ($goods_list as $key => $value) {
            $commonid_array[] = $value['goods_commonid'];
            $goodsid_array[] = $value['goods_id'];
        }

        //促销
        $groupbuy_list = Model('groupbuy')->getGroupbuyListByGoodsCommonIDString(implode(',', $commonid_array));
        $xianshi_list = Model('p_xianshi_goods')->getXianshiGoodsListByGoodsString(implode(',', $goodsid_array));
        foreach ($goods_list as $key => $value) {
            //抢购
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
    public function goods_detailOp()
    {
        $goods_id = intval($_GET ['goods_id']);

        // 商品详细信息
        $model_goods = Model('goods');
        $goods_detail = $model_goods->getGoodsDetail($goods_id);
        if (empty($goods_detail)) {
            output_error('商品不存在');
        }

        //推荐商品
        $model_store = Model('store');
        $hot_sales = $model_store->getHotSalesList($goods_detail['goods_info']['store_id'], 6);
        $goods_commend_list = array();
        foreach ($hot_sales as $value) {
            $goods_commend = array();
            $goods_commend['goods_id'] = $value['goods_id'];
            $goods_commend['goods_name'] = $value['goods_name'];
            $goods_commend['goods_price'] = $value['goods_price'];
            $goods_commend['goods_image_url'] = cthumb($value['goods_image'], 240);
            $goods_commend_list[] = $goods_commend;
        }
        $goods_detail['goods_commend_list'] = $goods_commend_list;
        $store_info = $model_store->getStoreInfoByID($goods_detail['goods_info']['store_id']);
        $goods_detail['store_info']['store_id'] = $store_info['store_id'];
        $goods_detail['store_info']['store_name'] = $store_info['store_name'];
        $goods_detail['store_info']['member_id'] = $store_info['member_id'];
        //显示QQ及旺旺 好商城V3
        $goods_detail['store_info']['store_qq'] = $store_info['store_qq'];
        $goods_detail['store_info']['store_ww'] = $store_info['store_ww'];
        $goods_detail['store_info']['store_phone'] = $store_info['store_phone'];
        $goods_detail['store_info']['member_name'] = $store_info['member_name'];
        $goods_detail['store_info']['avatar'] = getMemberAvatarForID($store_info['member_id']);

        //商品详细信息处理
        $goods_detail = $this->_goods_detail_extend($goods_detail);


        //v3-b11 抢购商品是否开始
        $goods_info = $goods_detail['goods_info'];
        //print_r($goods_info);
        $IsHaveBuy = 0;
        if (!empty($_COOKIE['username'])) {
            $model_member = Model('member');
            $member_info = $model_member->getMemberInfo(array('member_name' => $_COOKIE['username']));
            $buyer_id = $member_info['member_id'];

            $promotion_type = $goods_info["promotion_type"];

            if ($promotion_type == 'groupbuy') {
                //检测是否限购数量
                $upper_limit = $goods_info["upper_limit"];
                if ($upper_limit > 0) {
                    //查询些会员的订单中，是否已买过了
                    $model_order = Model('order');
                    //取商品列表
                    $order_goods_list = $model_order->getOrderGoodsList(array('goods_id' => $goods_id, 'buyer_id' => $buyer_id, 'goods_type' => 2));
                    if ($order_goods_list) {
                        //取得上次购买的活动编号(防一个商品参加多次团购活动的问题)
                        $promotions_id = $order_goods_list[0]["promotions_id"];
                        //用此编号取数据，检测是否这次活动的订单商品。
                        $model_groupbuy = Model('groupbuy');
                        $groupbuy_info = $model_groupbuy->getGroupbuyInfo(array('groupbuy_id' => $promotions_id));
                        if ($groupbuy_info) {
                            $IsHaveBuy = 1;
                        } else {
                            $IsHaveBuy = 0;
                        }
                    }
                }
            }
        }
        $goods_detail['IsHaveBuy'] = $IsHaveBuy;
        //v3-b11 end


        output_data($goods_detail);
    }

    /**
     * 商品详细信息处理
     */
    private function _goods_detail_extend($goods_detail)
    {
        //整理商品规格
        unset($goods_detail['spec_list']);
        $goods_detail['spec_list'] = $goods_detail['spec_list_mobile'];
        unset($goods_detail['spec_list_mobile']);

        //整理商品图片
        unset($goods_detail['goods_image']);
        $goods_detail['goods_image'] = implode(',', $goods_detail['goods_image_mobile']);
        unset($goods_detail['goods_image_mobile']);

        //商品链接
        $goods_detail['goods_info']['goods_url'] = urlShop('goods', 'index', array('goods_id' => $goods_detail['goods_info']['goods_id']));

        //整理数据
        unset($goods_detail['goods_info']['goods_commonid']);
        unset($goods_detail['goods_info']['gc_id']);
        unset($goods_detail['goods_info']['gc_name']);
        unset($goods_detail['goods_info']['store_name']);
        unset($goods_detail['goods_info']['brand_id']);
        unset($goods_detail['goods_info']['brand_name']);
        unset($goods_detail['goods_info']['type_id']);
        unset($goods_detail['goods_info']['goods_image']);
        unset($goods_detail['goods_info']['goods_body']);
        unset($goods_detail['goods_info']['goods_state']);
        unset($goods_detail['goods_info']['goods_stateremark']);
        unset($goods_detail['goods_info']['goods_verify']);
        unset($goods_detail['goods_info']['goods_verifyremark']);
        unset($goods_detail['goods_info']['goods_lock']);
        unset($goods_detail['goods_info']['goods_addtime']);
        unset($goods_detail['goods_info']['goods_edittime']);
        unset($goods_detail['goods_info']['goods_selltime']);
        unset($goods_detail['goods_info']['goods_show']);
        unset($goods_detail['goods_info']['goods_commend']);
        unset($goods_detail['goods_info']['explain']);
        unset($goods_detail['goods_info']['cart']);
        unset($goods_detail['goods_info']['buynow_text']);
        unset($goods_detail['groupbuy_info']);
        unset($goods_detail['xianshi_info']);

        return $goods_detail;
    }

    /**
     * 商品详细页
     */
    public function goods_bodyOp()
    {
        $goods_id = intval($_GET ['goods_id']);

        $model_goods = Model('goods');

        $goods_info = $model_goods->getGoodsInfoByID($goods_id, 'goods_commonid');
        $goods_common_info = $model_goods->getGoodeCommonInfoByID($goods_info['goods_commonid']);

        Tpl::output('goods_common_info', $goods_common_info);
        Tpl::showpage('goods_body');
    }

    /**
     * 手机商品详细页
     */
    public function wap_goods_bodyOp()
    {
        $goods_id = intval($_GET ['goods_id']);

        $model_goods = Model('goods');

        $goods_info = $model_goods->getGoodsInfoByID($goods_id, 'goods_id');
        $goods_common_info = $model_goods->getMobileBodyByCommonID($goods_info['goods_commonid']);
        Tpl:
        output('goods_common_info', $goods_common_info);
        Tpl::showpage('goods_body');
    }
}
