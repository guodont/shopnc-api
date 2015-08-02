<?php
/**
 * 队列
 *
 * 方法名需要和 QueueClient::push中第一个参数一致，如：
 * QueueClient::push('editGroupbuySaleCount',$groupbuy_info);
 * public function editGroupbuySaleCount($groupbuy_info){...}
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class queueLogic {

    /**
     * 添加会员积分
     * @param unknown $member_info
     */
    public function addPoint($member_info) {
        $points_model = Model('points');
        $points_model->savePointsLog('login',array('pl_memberid'=>$member_info['member_id'],'pl_membername'=>$member_info['member_name']),true);
        return callback(true);
    }
    /**
     * 添加会员经验值
     * @param unknown $member_info
     */
    public function addExppoint($member_info) {
        $exppoints_model = Model('exppoints');
        $exppoints_model->saveExppointsLog('login',array('exp_memberid'=>$member_info['member_id'],'exp_membername'=>$member_info['member_name']),true);
        return callback(true);
    }

    /**
     * 更新抢购信息
     * @param unknown $groupbuy_info
     * @throws Exception
     */
    public function editGroupbuySaleCount($groupbuy_info) {
        $model_groupbuy = Model('groupbuy');
        $data = array();
        $data['buyer_count'] = array('exp','buyer_count+1');
        $data['buy_quantity'] = array('exp','buy_quantity+'.$groupbuy_info['quantity']);
        $update = $model_groupbuy->editGroupbuy($data,array('groupbuy_id'=>$groupbuy_info['groupbuy_id']));
        if (!$update) {
            return callback(false,'更新抢购信息失败groupbuy_id:'.$groupbuy_info['groupbuy_id']);
        } else {
            return callback(true);
        }
    }

    /**
     * 更新使用的代金券状态
     * @param $input_voucher_list
     * @throws Exception
     */
    public function editVoucherState($voucher_list) {
        $model_voucher = Model('voucher');
        $send = new sendMemberMsg();
        foreach ($voucher_list as $store_id => $voucher_info) {
            $update = $model_voucher->editVoucher(array('voucher_state'=>2),array('voucher_id'=>$voucher_info['voucher_id']),$voucher_info['voucher_owner_id']);
            if ($update) {
                // 发送用户店铺消息
                $send->set('member_id', $voucher_info['voucher_owner_id']);
                $send->set('code', 'voucher_use');
                $param = array();
                $param['voucher_code'] = $voucher_info['voucher_code'];
                $param['voucher_url'] = urlShop('member_voucher', 'index');
                $send->send($param);
            } else {
                return callback(false,'更新代金券状态失败vcode:'.$voucher_info['voucher_code']);
            }
        }
        return callback(true);
    }

    /**
     * 下单变更库存销量
     * @param unknown $goods_buy_quantity
     */
    public function createOrderUpdateStorage($goods_buy_quantity) {
        $model_goods = Model('goods');
        foreach ($goods_buy_quantity as $goods_id => $quantity) {
            $data = array();
            $data['goods_storage'] = array('exp','goods_storage-'.$quantity);
            $data['goods_salenum'] = array('exp','goods_salenum+'.$quantity);
            $result = $model_goods->editGoodsById($data, $goods_id);
        }
        if (!$result) {
            return callback(false,'变更商品库存与销量失败');
        } else {
            return callback(true);
        }
    }

    /**
     * 取消订单变更库存销量
     * @param unknown $goods_buy_quantity
     */
    public function cancelOrderUpdateStorage($goods_buy_quantity) {
        $model_goods = Model('goods');
        foreach ($goods_buy_quantity as $goods_id => $quantity) {
            $data = array();
            $data['goods_storage'] = array('exp','goods_storage+'.$quantity);
            $data['goods_salenum'] = array('exp','goods_salenum-'.$quantity);
            $result = $model_goods->editGoodsById($data, $goods_id);
        }
        if (!$result) {
            return callback(false,'变更商品库存与销量失败');
        } else {
            return callback(true);
        }
    }

    /**
     * 更新F码为使用状态
     * @param int $fc_id
     */
    public function updateGoodsFCode($fc_id) {
        $update = Model('goods_fcode')->editGoodsFCode(array('fc_state' => 1),array('fc_id' => $fc_id));
        if (!$update) {
            return callback(false,'更新F码使用状态失败fc_id:'.$fc_id);
        } else {
            return callback(true);
        }
    }

    /**
     * 删除购物车
     * @param unknown $cart
     */
    public function delCart($cart) {
        if (!is_array($cart['cart_ids']) || empty($cart['buyer_id'])) return callback(true);
        $del = Model('cart')->delCart('db',array('buyer_id'=>$cart['buyer_id'],'cart_id'=>array('in',$cart['cart_ids'])));
        if (!$del) {
            return callback(false,'删除购物车数据失败');
        } else {
            return callback(true);
        }
    }

    /**
     * 根据商品id更新促销价格
     * 
     * @param int/array $goods_commonid
     * @return boolean
     */
    public function updateGoodsPromotionPriceByGoodsId($goods_id) {
        $update = Model('goods')->editGoodsPromotionPrice(array('goods_id' => array('in', $goods_id)));
        if (!$update) {
            return callback(false,'根据商品ID更新促销价格失败');
        } else {
            return callback(true);
        }
    }

    /**
     * 根据商品公共id更新促销价格
     *
     * @param int/array $goods_commonid
     * @return boolean
     */
    public function updateGoodsPromotionPriceByGoodsCommonId($goods_commonid) {
        $update = Model('goods')->editGoodsPromotionPrice(array('goods_commonid' => array('in', $goods_commonid)));
        if (!$update) {
            return callback(false,'根据商品公共id更新促销价格失败');
        } else {
            return callback(true);
        }
    }

    /**
     * 发送店铺消息
     */
    public function sendStoreMsg($param) {
        $send = new sendStoreMsg();
        $send->set('code', $param['code']);
        $send->set('store_id', $param['store_id']);
        $send->send($param['param']);
        return callback(true);
    }

    /**
     * 发送会员消息
     */
    public function sendMemberMsg($param) {
        $send = new sendMemberMsg();
        $send->set('code', $param['code']);
        $send->set('member_id', $param['member_id']);
        if (!empty($param['number']['mobile'])) $send->set('mobile', $param['number']['mobile']);
        if (!empty($param['number']['email'])) $send->set('email', $param['number']['email']);
        $send->send($param['param']);
        return callback(true);
    }

    /**
     * 生成商品F码
     */
    public function createGoodsFCode($param) {
        $insert = array();
        for ($i = 0; $i < $param['fc_count']; $i++) {
            $array = array();
            $array['goods_commonid'] = $param['goods_commonid'];
            $array['fc_code'] = strtoupper($param['fc_prefix']).mt_rand(100000,999999);
            $insert[$array['fc_code']] = $array;
        }
        if (!empty($insert)) {
            $insert = array_values($insert);
            $insert = Model('goods_fcode')->addGoodsFCodeAll($insert);
            if (!$insert) {
                return callback(false,'生成商品F码失败goods_commonid:'.$param['goods_commonid']);
            }
        }
        return callback(true);
    }

    /**
     * 生成商品二维码
     */
    public function createGoodsQRCode($param) {
        if (empty($param['goodsid_array'])) {
            return callback(true);
        }

        // 生成商品二维码
        require_once(BASE_RESOURCE_PATH.DS.'phpqrcode'.DS.'index.php');
        $PhpQRCode = new PhpQRCode();
        $PhpQRCode->set('pngTempDir',BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$param['store_id'].DS);
        foreach ($param['goodsid_array'] as $goods_id) {
            // 生成商品二维码
            $PhpQRCode->set('date',urlShop('goods', 'index', array('goods_id'=>$goods_id)));
            $PhpQRCode->set('pngTempName', $goods_id . '.png');
            $PhpQRCode->init();
        }
        return callback(true);
    }

    /**
     * 清理特殊商品促销信息
     */
    public function clearSpecialGoodsPromotion($param) {
        // 抢购
        Model('groupbuy')->delGroupbuy(array('goods_commonid' => $param['goods_commonid']));
        // 显示折扣
        Model('p_xianshi_goods')->delXianshiGoods(array('goods_id' => array('in', $param['goodsid_array'])));
        // 优惠套装
        Model('p_bundling')->delBundlingGoods(array('goods_id' => array('in', $param['goodsid_array'])));
        // 更新促销价格
        Model('goods')->editGoods(array('goods_promotion_price' => array('exp', 'goods_price'), 'goods_promotion_type' => 0), array('goods_commonid' => $param['goods_commonid']));
        return callback(true);
    }

    /**
     * 删除(买/卖家)订单全部数量缓存
     * @param array $data 订单信息
     * @return boolean
     */
    public function delOrderCountCache($order_info){
        if (empty($order_info)) return callback(true);
        $model_order = Model('order');
        if ($order_info['order_id']) {
            $order_info = $model_order->getOrderInfo(array('order_id'=>$order_info['order_id']),array(),'buyer_id,store_id');
        }
        $model_order->delOrderCountCache('buyer',$order_info['buyer_id']);
        $model_order->delOrderCountCache('store',$order_info['store_id']);
        return callback(true);
    }

    /**
     * 发送兑换码
     * @param unknown $param
     * @return boolean
     */
    public function sendVrCode($param) {
        if (empty($param) && !is_array($param)) return callback(true);
        $condition = array();
        $condition['order_id'] = $param['order_id'];
        $condition['buyer_id'] = $param['buyer_id'];
        $condition['vr_state'] = 0;
        $condition['refund_lock'] = 0;
        $code_list = Model('vr_order')->getOrderCodeList($condition,'vr_code,vr_indate');
        if (empty($code_list)) return callback(true);

        $content = '';
        foreach ($code_list as $v) {
            $content .= $v['vr_code'].',';
        }

        $tpl_info = Model('mail_templates')->getTplInfo(array('code'=>'send_vr_code'));
        $data = array();
        $data['site_name']	= C('site_name');
        $data['vr_code'] = rtrim($content,',');
        $message	= ncReplaceText($tpl_info['content'],$data);
        $sms = new Sms();
        $result = $sms->send($param["buyer_phone"],$message);
        if (!$result) {
            return callback(false,'兑换码发送失败order_id:'.$param['order_id']);
        } else {
            return callback(true);
        }
    }

    /**
     * 添加订单自提表内容
     */
    public function saveDeliveryOrder($param) {
        if (!is_array($param['order_sn_list'])) return callback(true);
        $data = array();
        $model_delivery_order = Model('delivery_order');
        foreach ($param['order_sn_list'] as $order_id => $v) {
            $data['order_id'] = $order_id;
            $data['order_sn'] = $v['order_sn'];
            $data['addtime'] = $v['add_time'];
            $data['dlyp_id'] = $param['dlyp_id'];
            $data['reciver_name'] = $param['reciver_name'];
            $data['reciver_telphone'] = $param['tel_phone'];
            $data['reciver_mobphone'] = $param['mob_phone'];
            $insert = $model_delivery_order->addDeliveryOrder($data);
            if (!$insert) {
                return callback(false,'保存自提站订单信息失败order_sn:'.$v['order_sn']);
            }
        }
        return callback(true);
    }

    /**
     * 发送提货码短信消息
     */
    public function sendPickupcode($param) {
        $dorder_info = Model('delivery_order')->getDeliveryOrderInfo(array('order_id' => $param['order_id']), 'reciver_mobphone');
        $tpl_info = Model('mail_templates')->getTplInfo(array('code'=>'send_pickup_code'));
        $data = array();
        $data['site_name'] = C('site_name');
        $data['pickup_code'] = $param['pickup_code'];
        $message = ncReplaceText($tpl_info['content'],$data);
        $sms = new Sms();
        $result = $sms->send($dorder_info['reciver_mobphone'],$message);
        if (!$result) {
            return callback(false,'发送提货码短信消息失败order_id:'.$param['order_id']);
        } else {
            return callback(true);
        }
    }

    /**
     * 刷新搜索索引
     */
    public function flushIndexer() {
        require_once(BASE_DATA_PATH.'/api/xs/lib/XS.php');
        $obj_doc = new XSDocument();
        $obj_xs = new XS(C('fullindexer.appname'));
        $obj_xs->index->flushIndex();
    }
}