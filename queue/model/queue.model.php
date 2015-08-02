<?php
/**
 * 队列模型
 * 
 * 方法名需要和 QueueClient::push中第一个参数一致，如：
 * QueueClient::push('addPoint',$queue_content);
 * public function addPoint($queue_content){...}
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class queueModel extends Model{

    /**
     * 添加会员积分
     * @param unknown $member_info
     */
    public function addPoint($member_info) {
        $points_model = Model('points');
        $points_model->savePointsLog('login',array('pl_memberid'=>$member_info['member_id'],'pl_membername'=>$member_info['member_name']),true);
        return true;
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
        $model_groupbuy->editGroupbuy($data,array('groupbuy_id'=>$groupbuy_info['groupbuy_id']));
        return true;
    }

    /**
     * 更新使用的代金券状态
     * @param $input_voucher_list
     * @throws Exception
     */
    public function editVoucherState($voucher_list) {
        $model_voucher = Model('voucher');
        foreach ($voucher_list as $store_id => $voucher_info) {
            $update = $model_voucher->editVoucher(array('voucher_state'=>2),array('voucher_id'=>$voucher_info['voucher_id']));
//             if (!$update) throw new Exception('代金券更新失败');

            // 发送用户店铺消息
            $send = new sendMemberMsg();
            $send->set('member_id', $voucher_info['voucher_owner_id']);
            $send->set('code', 'voucher_use');
            $param = array();
            $param['voucher_code'] = $voucher_info['voucher_code'];
            $param['voucher_url'] = urlShop('member_voucher', 'index');
            $send->send($param);
            unset($send);
        }
    }

    /**
     * 订单订单扩展表中收货人所在省份
     * @param unknown $order
     * @return void|boolean
     */
    public function editReciverProid($order) {
        if (!is_array($order['order_ids']) || empty($order['area_id'])) return ;
        $model_area = Model('area');
        $area_info = $model_area->getAreaInfo(array('area_id'=>$order['area_id']),'area_parent_id');

        $model_order = Model('order');
        $model_order->editOrderCommon(array('reciver_province_id'=>$area_info['area_parent_id']),array('order_id'=>array('in',$order['order_ids'])));
        return true;
    }

    /**
     * 删除购物车
     * @param unknown $cart
     */
//     public function delCart($cart) {
//         $model_cart = Model('cart');
//         if (!is_array($cart['cart_ids']) || empty($cart['buyer_id'])) return ;
//         $model_cart->delCart('db',array('buyer_id'=>$cart['buyer_id'],'cart_id'=>array('in',$cart['cart_ids'])));
//     }

    /**
     * 根据抢购id更新商品促销价格
     * @param array $groupbuy
     */
    public function updateGoodsPromotionPriceByGroupbuyId($groupbuy_id) {
        $groupbuy_info = Model('groupbuy')->getGroupbuyInfo(array('groupbuy_id' => $groupbuy_id, 'start_time' => array('lt', TIMESTAMP), 'end_time' => array('gt', TIMESTAMP)));
        if(!empty($groupbuy_info)) {
            // 没有促销使用原价
            Model('goods')->editGoods(array('goods_promotion_price' => $groupbuy_info['groupbuy_price'], 'goods_promotion_type' => 1), array('goods_commonid' => $groupbuy_info['goods_commonid']));
        }
        return true;
    }
    
    /**
     * 根据限时折扣id更新促销价格
     */
    public function updateGoodsPromotionPriceByXianshiId($xianshi_id) {
        $xianshigoods_array = Model('p_xianshi_goods')->getXianshiGoodsList(array('xianshi_id' => $xianshi_id, 'start_time' => array('lt', TIMESTAMP), 'end_time' => array('gt', TIMESTAMP)));
        if(!empty($xianshigoods_array)) {
            foreach ($xianshigoods_array as $val) {
                $goods_info = Model('goods')->getGoodsInfo(array('goods_id' => $val['goods_id']), 'goods_promotion_type');
                // 如果存在抢购促销 结束循环
                if ($goods_info['goods_promotion_type'] == 1) {
                    continue;
                }
                // 更新促销价格
                $this->editGoods(array('goods_promotion_price' => $val['xianshi_price'], 'goods_promotion_type' => 2), array('goods_id' => $val['goods_id']));
            }
        }
        return true;
    }
    
    /**
     * 根据商品id更新促销价格
     */
    public function updateGoodsPromotionPriceByGoodsId($goods_id) {
        Model('goods')->editGoodsPromotionPrice(array('goods_id' => $goods_id));
        return true;
    }
    
    /**
     * 根据商品公共id更新促销价格
     */
    public function updateGoodsPromotionPriceByGoodsCommonId($goods_commonid) {
        Model('goods')->editGoodsPromotionPrice(array('goods_commonid' => $goods_commonid));
        return true;
    }
    
    /**
     * 发送店铺消息
     */
    public function sendStoreMsg($param) {
        $send = new sendStoreMsg();
        $send->set('code', $param['code']);
        $send->set('store_id', $param['store_id']);
        $send->send($param['param']);
        return true;
    }
    
    /**
     * 发送会员消息
     */
    public function sendMemberMsg($param) {
        $send = new sendMemberMsg();
        $send->set('code', $param['code']);
        $send->set('member_id', $param['member_id']);
        $send->send($param['param']);
        return true;
    }
}