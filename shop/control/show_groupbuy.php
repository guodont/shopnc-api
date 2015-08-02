<?php
/**
 * 前台抢购
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class show_groupbuyControl extends BaseHomeControl {

    public function __construct() {
        parent::__construct();

        //读取语言包
        Language::read('member_groupbuy,home_cart_index');

        //检查抢购功能是否开启
        if (intval(C('groupbuy_allow')) !== 1){
            showMessage(Language::get('groupbuy_unavailable'),urlShop(),'','error');
        }

        //分类导航
        $nav_link = array(
            0=>array(
                'title'=>Language::get('homepage'),
                'link'=>SHOP_SITE_URL,
            ),
            1=>array(
                'title'=>Language::get('nc_groupbuy')
            )
        );
        Tpl::output('nav_link_list',$nav_link);

        Tpl::setLayout('home_groupbuy_layout');

        Tpl::output('index_sign', 'groupbuy');

        if ($_GET['op'] != 'groupbuy_detail') {
            // 抢购价格区间
            $this->groupbuy_price = rkcache('groupbuy_price', true);
            Tpl::output('price_list', $this->groupbuy_price);

            $model_groupbuy = Model('groupbuy');

            // 线上抢购分类
            $this->groupbuy_classes = $model_groupbuy->getGroupbuyClasses();
            Tpl::output('groupbuy_classes', $this->groupbuy_classes);

            // 虚拟抢购分类
            $this->groupbuy_vr_classes = $model_groupbuy->getGroupbuyVrClasses();
            Tpl::output('groupbuy_vr_classes', $this->groupbuy_vr_classes);

            // 虚拟抢购城市
            $this->groupbuy_vr_cities = $model_groupbuy->getGroupbuyVrCities();
            Tpl::output('groupbuy_vr_cities', $this->groupbuy_vr_cities);

            Tpl::output('city_name', $this->groupbuy_vr_cities['name'][cookie('city_id')]);
        }
    }

    protected $groupbuy_vr_cities;

    /*
     * 选择城市
     */
    public function select_cityOp()
    {
        $city_id = intval($_GET['city_id']);

        if ($city_id != 0 && (!isset($this->groupbuy_vr_cities['name'][$city_id])
            || !isset($this->groupbuy_vr_cities['parent'][$city_id])
            || $this->groupbuy_vr_cities['parent'][$city_id] != 0)) {
            showMessage('该城市不存在，请选择其他城市');
        }

        setNcCookie('city_id', $city_id);

        redirect(urlShop('show_groupbuy', $_GET['back_op']));
    }

    /**
     * 抢购聚合页
     */
    public function indexOp()
    {
        $model_groupbuy = Model('groupbuy');

        // 线上抢购
        $groupbuy = $model_groupbuy->getGroupbuyOnlineList(array(
            'recommended' => 1,
            'is_vr' => 0,
        ), 9);
        Tpl::output('groupbuy', $groupbuy);

        // 虚拟抢购
        $vr_groupbuy = $model_groupbuy->getGroupbuyOnlineList(array(
            'recommended' => 1,
            'is_vr' => 1,
        ), 9);

        Tpl::output('vr_groupbuy', $vr_groupbuy);

        // 轮播图片
        $picArr = array();

        foreach (range(1, 4) as $i) {
            $a = C('live_pic' . $i);
            if ($a) {
                $picArr[] = array($a, C('live_link'. $i));
            }
        }

        Tpl::output('picArr', $picArr);

        Tpl::output('current', 'online');
        Tpl::showpage('groupbuy.index');
    }

    /**
     * 进行中的虚拟抢购
     */
    public function vr_groupbuy_listOp()
    {
        Tpl::output('current', 'online');
        Tpl::output('buy_button', L('groupbuy_buy'));
        $this->_show_vr_groupbuy_list('getGroupbuyOnlineList');
    }

    /**
     * 即将开始的虚拟抢购
     */
    public function vr_groupbuy_soonOp()
    {
        Tpl::output('current', 'soon');
        Tpl::output('buy_button', '未开始');
        $this->_show_vr_groupbuy_list('getGroupbuySoonList');
    }

    /**
     * 往期虚拟抢购
     */
    public function vr_groupbuy_historyOp()
    {
        Tpl::output('current', 'history');
        Tpl::output('buy_button', '已结束');
        $this->_show_vr_groupbuy_list('getGroupbuyHistoryList');
    }

    /**
     * 获取抢购列表
     */
    private function _show_vr_groupbuy_list($function_name)
    {
        $model_groupbuy = Model('groupbuy');

        $condition = array(
            'is_vr' => 1,
        );

        $order = '';

        // 分类筛选条件
        if (($vr_class_id = (int) $_GET['vr_class']) > 0) {
            $condition['vr_class_id'] = $vr_class_id;

            if (($vr_s_class_id = (int) $_GET['vr_s_class']) > 0)
                $condition['vr_s_class_id'] = $vr_s_class_id;
        }

        // 区域筛选条件
        if (($vr_city_id = (int) cookie('city_id')) > 0) {
            $condition['vr_city_id'] = $vr_city_id;
            Tpl::output('vr_city_id', $vr_city_id);

            if (($vr_area_id = intval($_GET['vr_area'])) > 0) {
                $condition['vr_area_id'] = $vr_area_id;
                Tpl::output('vr_area_id', $vr_area_id);

                if (($vr_mall_id = (int) $_GET['vr_mall']) > 0) {
                    $condition['vr_mall_id'] = $vr_mall_id;
                    Tpl::output('vr_mall_id', $vr_mall_id);
                }
            }
        }

        // 价格区间筛选条件
        if (($price_id = intval($_GET['groupbuy_price'])) > 0
            && isset($this->groupbuy_price[$price_id])) {
            $p = $this->groupbuy_price[$price_id];
            $condition['groupbuy_price'] = array('between', array($p['range_start'], $p['range_end']));
        }

        // 排序
        $groupbuy_order_key = trim($_GET['groupbuy_order_key']);
        $groupbuy_order = $_GET['groupbuy_order'] == '2' ? 'desc' : 'asc';
        if (!empty($groupbuy_order_key)) {
            switch ($groupbuy_order_key) {
                case '1':
                    $order = 'groupbuy_price ' . $groupbuy_order;
                    break;
                case '2':
                    $order = 'groupbuy_rebate ' . $groupbuy_order;
                    break;
                case '3':
                    $order = 'buyer_count ' . $groupbuy_order;
                    break;
            }
        }

        $groupbuy_list = $model_groupbuy->$function_name($condition, 20, $order);
        Tpl::output('groupbuy_list', $groupbuy_list);
        Tpl::output('show_page', $model_groupbuy->showpage(5));

        Tpl::output('html_title', Language::get('text_groupbuy_list'));

        Model('seo')->type('group')->show();

        loadfunc('search');

        Tpl::output('groupbuyMenuIsVr', 1);
        Tpl::showpage('groupbuy_vr_list');
    }

    /**
     * 进行中的抢购抢购
     **/
    public function groupbuy_listOp() {
        Tpl::output('current', 'online');
        Tpl::output('buy_button', L('groupbuy_buy'));
        $this->_show_groupbuy_list('getGroupbuyOnlineList');
    }

    /**
     * 即将开始的抢购
     **/
    public function groupbuy_soonOp() {
        Tpl::output('current', 'soon');
        Tpl::output('buy_button', '未开始');
        $this->_show_groupbuy_list('getGroupbuySoonList');
    }

    /**
     * 往期抢购
     **/
    public function groupbuy_historyOp() {
        Tpl::output('current', 'history');
        Tpl::output('buy_button', '已结束');
        $this->_show_groupbuy_list('getGroupbuyHistoryList');
    }

    /**
     * 获取抢购列表
     **/
    private function _show_groupbuy_list($function_name) {
        $model_groupbuy = Model('groupbuy');

        $condition = array(
            'is_vr' => 0,
        );
        $order = '';

        // 分类筛选条件
        if (($class_id = (int) $_GET['class']) > 0) {
            $condition['class_id'] = $class_id;

            if (($s_class_id = (int) $_GET['s_class']) > 0)
                $condition['s_class_id'] = $s_class_id;
        }

        // 价格区间筛选条件
        if (($price_id = intval($_GET['groupbuy_price'])) > 0
            && isset($this->groupbuy_price[$price_id])) {
            $p = $this->groupbuy_price[$price_id];
            $condition['groupbuy_price'] = array('between', array($p['range_start'], $p['range_end']));
        }

        // 排序
        $groupbuy_order_key = trim($_GET['groupbuy_order_key']);
        $groupbuy_order = $_GET['groupbuy_order'] == '2'?'desc':'asc';
        if(!empty($groupbuy_order_key)) {
            switch ($groupbuy_order_key) {
                case '1':
                    $order = 'groupbuy_price '.$groupbuy_order;
                    break;
                case '2':
                    $order = 'groupbuy_rebate '.$groupbuy_order;
                    break;
                case '3':
                    $order = 'buyer_count '.$groupbuy_order;
                    break;
            }
        }

        $groupbuy_list = $model_groupbuy->$function_name($condition, 20, $order);
        Tpl::output('groupbuy_list', $groupbuy_list);
        Tpl::output('show_page', $model_groupbuy->showpage(5));

        Tpl::output('html_title', Language::get('text_groupbuy_list'));

        Model('seo')->type('group')->show();

        loadfunc('search');

        Tpl::output('groupbuyMenuIsVr', 0);
        Tpl::showpage('groupbuy_list');
    }

    /**
     * 抢购详细信息
     **/
    public function groupbuy_detailOp() {
        $group_id = intval($_GET['group_id']);

        $model_groupbuy = Model('groupbuy');
        $model_store = Model('store');

        //获取抢购详细信息
        $groupbuy_info = $model_groupbuy->getGroupbuyInfoByID($group_id);
        if(empty($groupbuy_info)) {
            showMessage(Language::get('param_error'),urlShop('show_groupbuy', 'index'),'','error');
        }
        Tpl::output('groupbuy_info',$groupbuy_info);

        Tpl::output('groupbuyMenuIsVr', (bool) $groupbuy_info['is_vr']);

        if ($groupbuy_info['is_vr']) {
            $goods_info = Model('goods')->getGoodsInfoByID($groupbuy_info['goods_id']);
            $buy_limit = max(0, (int) $goods_info['virtual_limit']);
            $upper_limit = max(0, (int) $groupbuy_info['upper_limit']);
            if ($buy_limit < 1 || ($buy_limit > 0 && $upper_limit > 0 && $buy_limit > $upper_limit)) {
                $buy_limit = $upper_limit;
            }

            Tpl::output('goods_info', $goods_info);
            Tpl::output('buy_limit', $buy_limit);
        } else {
            Tpl::output('buy_limit', $groupbuy_info['upper_limit']);
        }

        // 输出店铺信息
        $store_info = $model_store->getStoreInfoByID($groupbuy_info['store_id']);
        Tpl::output('store_info', $store_info);

        // 浏览数加1
        $update_array = array();
        $update_array['views'] = array('exp', 'views+1');
        $model_groupbuy->editGroupbuy($update_array, array('groupbuy_id'=>$group_id));


        //获取店铺推荐商品
        $commended_groupbuy_list = $model_groupbuy->getGroupbuyCommendedList(8);
        Tpl::output('commended_groupbuy_list', $commended_groupbuy_list);

        // 好评率
        $model_evaluate = Model('evaluate_goods');
        $evaluate_info = $model_evaluate->getEvaluateGoodsInfoByCommonidID($groupbuy_info['goods_commonid']);
        Tpl::output('evaluate_info', $evaluate_info);

        Model('seo')->type('group_content')->param(array('name'=>$groupbuy_info['groupbuy_name']))->show();

        loadfunc('search');
        Tpl::showpage('groupbuy_detail');
    }

    /**
     * 购买记录
     */
    public function groupbuy_orderOp() {
        $group_id = intval($_GET['group_id']);
        if ($group_id > 0) {
            if (!$_GET['is_vr']) {
                //获取购买记录
                $model_order = Model('order');
                $condition = array();
                $condition['goods_type'] = 2;
                $condition['promotions_id'] = $group_id;
                $order_goods_list = $model_order->getOrderGoodsList($condition, '*', 0 , 10);
                Tpl::output('order_goods_list', $order_goods_list);
                Tpl::output('show_page', $model_order->showpage());
                if (!empty($order_goods_list)) {
                    $orderid_array = array();
                    foreach ($order_goods_list as $value) {
                        $orderid_array[] = $value['order_id'];
                    }
                    $order_list = $model_order->getNormalOrderList(array('order_id' => array('in', $orderid_array)), '', 'order_id,buyer_name,add_time');
                    $order_list = array_under_reset($order_list, 'order_id');
                    Tpl::output('order_list', $order_list);
                }
            } else {
                $model_order = Model('vr_order');
                $condition = array();
                $condition['order_promotion_type'] = 1;
                $condition['promotions_id'] = $group_id;
                $order_goods_list = $model_order->getOrderAndOrderGoodsSalesRecordList($condition, '*', 10);
                Tpl::output('order_goods_list', $order_goods_list);
                Tpl::output('show_page', $model_order->showpage());
            }
        }
        Tpl::showpage('groupbuy_order', 'null_layout');
    }

    /**
     * 商品评价
     */
    public function groupbuy_evaluateOp() {
        $goods_commonid = intval($_GET['commonid']);
        if ($goods_commonid > 0) {
            $condition = array();
            $condition['goods_commonid'] = $goods_commonid;
            $goods_list = Model('goods')->getGoodsList($condition, 'goods_id');
            if (!empty($goods_list)) {
                $goodsid_array = array();
                foreach ($goods_list as $value) {
                    $goodsid_array[] = $value['goods_id'];
                }
                $model_evaluate = Model('evaluate_goods');
                $where = array();
                $where['geval_goodsid'] = array('in', $goodsid_array);
                $evaluate_list = $model_evaluate->getEvaluateGoodsList($where, 10);
                Tpl::output('goodsevallist',$evaluate_list);
                Tpl::output('show_page',$model_evaluate->showpage());
            }
        }
        Tpl::showpage('groupbuy_evaluate', 'null_layout');
    }
}
