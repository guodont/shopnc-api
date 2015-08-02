<?php
/**
 * 推荐展位管理
 ***/


defined('InShopNC') or exit('Access Invalid!');
class store_promotion_boothControl extends BaseSellerControl {
    public function __construct() {
        parent::__construct();
        //检查是否开启
        if (intval(C('promotion_allow')) !== 1) {
            showMessage(Language::get('promotion_unavailable'), urlShop('seller_center', 'index'),'','error');
        }
    }

    public function indexOp() {
        $this->booth_goods_listOp();
    }

    /**
     * 套餐商品列表
     */
    public function booth_goods_listOp() {
        $model_booth = Model('p_booth');
        // 更新套餐状态
        $where = array();
        $where['store_id'] = $_SESSION['store_id'];
        $where['booth_quota_endtime'] = array('lt', TIMESTAMP);
        $model_booth->editBoothClose($where);

        $hasList = false;
        if (checkPlatformStore()) {
            Tpl::output('isOwnShop', true);
            $hasList = true;
        } else {
            // 检查是否已购买套餐
            $where = array();
            $where['store_id'] = $_SESSION['store_id'];
            $booth_quota = $model_booth->getBoothQuotaInfo($where);
            Tpl::output('booth_quota', $booth_quota);
            if (!empty($booth_quota)) {
                $hasList = true;
            }
        }

        if ($hasList) {
            // 查询已选择商品
            $boothgoods_list = $model_booth->getBoothGoodsList(array('store_id' => $_SESSION['store_id']), 'goods_id');
            if (!empty($boothgoods_list)) {
                $goodsid_array = array();
                foreach ($boothgoods_list as $val) {
                    $goodsid_array[] = $val['goods_id'];
                }
                $goods_list = Model('goods')->getGoodsList(array('goods_id' => array('in', $goodsid_array)), 'goods_id,goods_name,goods_image,goods_price,store_id,gc_id');
                if (!empty($goods_list)) {
                    $gcid_array = array();  // 商品分类id
                    foreach ($goods_list as $key => $val) {
                        $gcid_array[] = $val['gc_id'];
                        $goods_list[$key]['goods_image'] = thumb($val);
                        $goods_list[$key]['url'] = urlShop('goods', 'index', array('goods_id' => $val['goods_id']));
                    }
                    $goodsclass_list = Model('goods_class')->getGoodsClassListByIds($gcid_array);
                    $goodsclass_list = array_under_reset($goodsclass_list, 'gc_id');
                    Tpl::output('goods_list', $goods_list);
                    Tpl::output('goodsclass_list', $goodsclass_list);
                }
            }
        }

        $this->profile_menu('booth_goods_list', 'booth_goods_list');
        Tpl::showpage('store_promotion_booth.goods_list');
    }

    /**
     * 选择商品
     */
    public function booth_select_goodsOp() {
        $model_goods = Model('goods');
        $condition = array();
        $condition['store_id'] = $_SESSION['store_id'];
        if ($_POST['goods_name'] != '') {
            $condition['goods_name'] = array('like', '%'.$_POST['goods_name'].'%');
        }
        $goods_list = $model_goods->getGoodsOnlineList($condition, '*', 10);

        Tpl::output('goods_list', $goods_list);
        Tpl::output('show_page', $model_goods->showpage());
        Tpl::showpage('store_promotion_booth.select_goods', 'null_layout');
    }

    /**
     * 购买套餐
     */
    public function booth_quota_addOp() {
        if (chksubmit()) {
            $quantity = intval($_POST['booth_quota_quantity']); // 购买数量（月）
            $price_quantity = $quantity * intval(C('promotion_booth_price')); // 扣款数
            if ($quantity <= 0 || $quantity > 12) {
                showDialog('参数错误，购买失败。', urlShop('store_promotion_booth', 'booth_quota_add'), '', 'error' );
            }
            // 实例化模型
            $model_booth = Model('p_booth');

            $data = array();
            $data['store_id']               = $_SESSION['store_id'];
            $data['store_name']             = $_SESSION['store_name'];
            $data['booth_quota_starttime']  = TIMESTAMP;
            $data['booth_quota_endtime']    = TIMESTAMP + 60 * 60 * 24 * 30 * $quantity;
            $data['booth_state']            = 1;

            $return = $model_booth->addBoothQuota($data);
            if ($return) {
                // 添加店铺费用记录
                $this->recordStoreCost($price_quantity, '购买推荐展位');

                // 添加任务队列
                $end_time = TIMESTAMP + 60 * 60 * 24 * 30 * $quantity;
                $this->addcron(array('exetime' => $end_time, 'exeid' => $_SESSION['store_id'], 'type' => 4), true);
                $this->recordSellerLog('购买'.$quantity.'套推荐展位，单位元');
                showDialog('购买成功', urlShop('store_promotion_booth', 'booth_goods_list'), 'succ');
            } else {
                showDialog('购买失败', urlShop('store_promotion_booth', 'booth_quota_add'));
            }
        }
        // 输出导航
        self::profile_menu('booth_quota_add', 'booth_quota_add');
        Tpl::showpage('store_promotion_booth.quota_add');
    }

    /**
     * 套餐续费
     */
    public function booth_renewOp() {
        if (chksubmit()) {
            $model_booth = Model('p_booth');
            $quantity = intval($_POST['booth_quota_quantity']); // 购买数量（月）
            $price_quantity = $quantity * intval(C('promotion_booth_price')); // 扣款数
            if ($quantity <= 0 || $quantity > 12) {
                showDialog('参数错误，购买失败。', urlShop('store_promotion_booth', 'booth_quota_add'), '', 'error' );
            }
            $where = array();
            $where['store_id'] = $_SESSION ['store_id'];
            $booth_quota = $model_booth->getBoothQuotaInfo($where);
            if ($booth_quota['booth_quota_endtime'] > TIMESTAMP) {
                // 套餐未超时(结束时间+购买时间)
                $update['booth_quota_endtime']   = intval($booth_quota['booth_quota_endtime']) + 60 * 60 * 24 * 30 * $quantity;
            } else {
                // 套餐已超时(当前时间+购买时间)
                $update['booth_quota_endtime']   = TIMESTAMP + 60 * 60 * 24 * 30 * $quantity;
            }
            $return = $model_booth->editBoothQuotaOpen($update, $where);

            if ($return) {
                // 添加店铺费用记录
                $this->recordStoreCost($price_quantity, '购买推荐展位');

                // 添加任务队列
                $end_time = TIMESTAMP + 60 * 60 * 24 * 30 * $quantity;
                $this->addcron(array('exetime' => $end_time, 'exeid' => $_SESSION['store_id'], 'type' => 4), true);
                $this->recordSellerLog('续费'.$quantity.'套推荐展位，单位元');
                showDialog('购买成功', urlShop('store_promotion_booth', 'booth_list'), 'succ');
            } else {
                showDialog('购买失败', urlShop('store_promotion_booth', 'booth_quota_add'));
            }
        }

        self::profile_menu('booth_renew', 'booth_renew');
        Tpl::showpage('store_promotion_booth.quota_add');
    }

    /**
     * 选择商品
     */
    public function choosed_goodsOp() {
        $gid = $_GET['gid'];
        if ($gid <= 0) {
            $data = array('result' => 'false', 'msg' => '参数错误');
            $this->_echoJson($data);
        }

        // 验证商品是否存在
        $goods_info = Model('goods')->getGoodsInfoByID($gid, 'goods_id,goods_name,goods_image,goods_price,store_id,gc_id');
        if (empty($goods_info) || $goods_info['store_id'] != $_SESSION['store_id']) {
            $data = array('result' => 'false', 'msg' => '参数错误');
            $this->_echoJson($data);
        }

        $model_booth = Model('p_booth');

        if (!checkPlatformStore()) {
            // 验证套餐时候过期
            $booth_info = $model_booth->getBoothQuotaInfo(array('store_id' => $_SESSION['store_id'], 'booth_quota_endtime' => array('gt', TIMESTAMP)), 'booth_quota_id');
            if (empty($booth_info)) {
                $data = array('result' => 'false', 'msg' => '套餐过期请重新购买套餐');
                $this->_echoJson($data);
            }
        }

        // 验证已添加商品数量，及选择商品是否已经被添加过
        $bootgoods_info = $model_booth->getBoothGoodsList(array('store_id' => $_SESSION['store_id']), 'goods_id');
        // 已添加商品总数
        if (count($bootgoods_info) >= C('promotion_booth_goods_sum')) {
            $data = array('result' => 'false', 'msg' => '只能添加'.C('promotion_booth_goods_sum').'个商品');
            $this->_echoJson($data);
        }
        // 商品是否已经被添加
        $bootgoods_info = array_under_reset($bootgoods_info, 'goods_id');
        if (isset($bootgoods_info[$gid])) {
            $data = array('result' => 'false', 'msg' => '商品已经添加，请选择其他商品');
            $this->_echoJson($data);
        }

        // 保存到推荐展位商品表
        $insert = array();
        $insert['store_id'] = $_SESSION['store_id'];
        $insert['goods_id'] = $goods_info['goods_id'];
        $insert['gc_id'] = $goods_info['gc_id'];
        $model_booth->addBoothGoods($insert);

        $this->recordSellerLog('添加推荐展位商品，商品id：'.$goods_info['goods_id']);

        // 输出商品信息
        $goods_info['goods_image'] = thumb($goods_info);
        $goods_info['url'] = urlShop('goods', 'index', array('goods_id' => $goods_info['goods_id']));
        $goods_class = Model('goods_class')->getGoodsClassInfoById($goods_info['gc_id']);
        $goods_info['gc_name'] = $goods_class['gc_name'];
        $goods_info['result'] = 'true';
        $this->_echoJson($goods_info);
    }

    /**
     * 删除选择商品
     */
    public function del_choosed_goodsOp() {
        $gid = $_GET['gid'];
        if ($gid <= 0) {
            $data = array('result' => 'false', 'msg' => '参数错误');
            $this->_echoJson($data);
        }

        $result = Model('p_booth')->delBoothGoods(array('goods_id' => $gid, 'store_id' => $_SESSION['store_id']));
        if ($result) {
            $this->recordSellerLog('删除推荐展位商品，商品id：'.$gid);
            $data = array('result' => 'true');
        } else {
            $data = array('result' => 'false', 'msg' => '删除失败');
        }
        $this->_echoJson($data);
    }

    /**
     * 输出JSON
     * @param array $data
     */
    private function _echoJson($data) {
        if (strtoupper(CHARSET) == 'GBK'){
            $data = Language::getUTF8($data);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
        }
        echo json_encode($data);exit();
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string	$menu_type	导航类型
     * @param string 	$menu_key	当前导航的menu_key
     * @return
     */
    private function profile_menu($menu_type,$menu_key='') {
        $menu_array	= array();
        switch ($menu_type) {
            case 'booth_goods_list':
                $menu_array	= array(
                    1=>array('menu_key'=>'booth_goods_list', 'menu_name'=>'商品列表', 'menu_url'=>urlShop('store_promotion_booth', 'booth_goods_list'))
                );
                break;
            case 'booth_quota_add':
                $menu_array = array(
                    1=>array('menu_key'=>'booth_goods_list', 'menu_name'=>'商品列表', 'menu_url'=>urlShop('store_promotion_booth', 'booth_goods_list')),
                    2=>array('menu_key'=>'booth_quota_add', 'menu_name'=>'购买套餐', 'menu_url'=>urlShop('store_promotion_booth', 'booth_quota_add'))
                );
                break;
            case 'booth_renew':
                $menu_array = array(
                    1=>array('menu_key'=>'booth_goods_list', 'menu_name'=>'商品列表', 'menu_url'=>urlShop('store_promotion_booth', 'booth_goods_list')),
                    2=>array('menu_key'=>'booth_renew', 'menu_name'=>'套餐续费', 'menu_url'=>urlShop('store_promotion_booth', 'booth_renew'))
                );
                break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
