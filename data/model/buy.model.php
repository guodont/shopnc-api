<?php
/**
 * 下单业务模型
 *
 *  
 */
defined('InShopNC') or exit('Access Invalid!');
class buyModel {

    /**
     * 输出有货到付款时，在线支付和货到付款及每种支付下商品数量和详细列表
     * @param $buy_list 商品列表
     * @return 返回 以支付方式为下标分组的商品列表
     */
    public function getOfflineGoodsPay($buy_list) {
        //以支付方式为下标，存放购买商品
        $buy_goods_list = array();        
        $offline_pay = Model('payment')->getPaymentOpenInfo(array('payment_code'=>'offline'));
        if ($offline_pay) {
            //下单里包括平台自营商品并且平台已开户货到付款，则显示货到付款项及对应商品数量,取出支持货到付款的店铺ID组成的数组，目前就一个，DEFAULT_PLATFORM_STORE_ID
            $offline_store_id_array = array(DEFAULT_PLATFORM_STORE_ID);
            foreach ($buy_list as $value) {
                if (in_array($value['store_id'],$offline_store_id_array)) {
                    $buy_goods_list['offline'][] = $value;
                } else {
                    $buy_goods_list['online'][] = $value;
                }
            }
        }
        return $buy_goods_list;
    }

    /**
     * 计算每个店铺(所有店铺级优惠活动)总共优惠多少金额
     * @param array $store_goods_total 最初店铺商品总金额 
     * @param array $store_final_goods_total 去除各种店铺级促销后，最终店铺商品总金额(不含运费)
     * @return array
     */
    public function getStorePromotionTotal($store_goods_total, $store_final_goods_total) {
        if (!is_array($store_goods_total) || !is_array($store_final_goods_total)) return array();
        $store_promotion_total = array();
        foreach ($store_goods_total as $store_id => $goods_total) {
            $store_promotion_total[$store_id] = abs($goods_total - $store_final_goods_total[$store_id]);
        }
        return $store_promotion_total;
    }

    /**
     * 返回需要计算运费的店铺ID组成的数组 和 免运费店铺ID及免运费下限金额描述
     * @param array $store_goods_total 每个店铺的商品金额小计，以店铺ID为下标
     * @return array
     */
    public function getStoreFreightDescList($store_goods_total) {
        if (empty($store_goods_total) || !is_array($store_goods_total)) return array(array(),array());

        //定义返回数组
        $need_calc_sid_array = array();
        $cancel_calc_sid_array = array();

        //如果商品金额未达到免运费设置下线，则需要计算运费
        $condition = array('store_id' => array('in',array_keys($store_goods_total)));
        $store_list = Model('store')->getStoreOnlineList($condition,null,'','store_id,store_free_price');
        foreach ($store_list as $store_info) {
            $limit_price = floatval($store_info['store_free_price']);
            if ($limit_price == 0 || $limit_price > $store_goods_total[$store_info['store_id']]) {
                //需要计算运费
                $need_calc_sid_array[] = $store_info['store_id'];
            } else {
                //返回免运费金额下限
                $cancel_calc_sid_array[$store_info['store_id']]['free_price'] = $limit_price;
                $cancel_calc_sid_array[$store_info['store_id']]['desc'] = sprintf('满%s免运费',$limit_price);
            }
        }
        return array($need_calc_sid_array,$cancel_calc_sid_array);
    }

    /**
     * 取得店铺运费(使用运费模板的商品运费不会计算，但会返回模板信息)
     * 先将免运费的店铺运费置0，然后算出店铺里没使用运费模板的商品运费之和 ，存到iscalced下标中
     * 然后再计算使用运费模板的信息(array(店铺ID=>array(运费模板ID=>购买数量))，放到nocalced下标里
     * @param array $buy_list 购买商品列表
     * @param array $free_freight_sid_list 免运费的店铺ID数组
     */
    public function getStoreFreightList($buy_list = array(), $free_freight_sid_list) {
        //定义返回数组
        $return = array();
        //先将免运费的店铺运费置0(格式:店铺ID=>0)
        $freight_list = array();
        if (!empty($free_freight_sid_list) && is_array($free_freight_sid_list)) {
            foreach ($free_freight_sid_list as $store_id) {
                $freight_list[$store_id] = 0;
            }
        }

        //然后算出店铺里没使用运费模板(优惠套装商品除外)的商品运费之和(格式:店铺ID=>运费)
        //定义数组，存放店铺优惠套装商品运费总额 store_id=>运费
        $store_bl_goods_freight = array();
        foreach ($buy_list as $key => $goods_info) {
            //免运费店铺的商品不需要计算
            if (array_key_exists($goods_info['store_id'], $freight_list)) {
                unset($buy_list[$key]);
				continue;
            }
            //优惠套装商品运费另算
            if (intval($goods_info['bl_id'])) {
                unset($buy_list[$key]);
                $store_bl_goods_freight[$goods_info['store_id']] = $goods_info['bl_id'];
                continue;
            }
            if (!intval($goods_info['transport_id']) &&  !in_array($goods_info['store_id'],$free_freight_sid_list)) {
                $freight_list[$goods_info['store_id']] += $goods_info['goods_freight'];
                unset($buy_list[$key]);
            }
        }
        //计算优惠套装商品运费
        if (!empty($store_bl_goods_freight)) {
            $model_bl = Model('p_bundling');
            foreach (array_unique($store_bl_goods_freight) as $store_id => $bl_id) {
                $bl_info = $model_bl->getBundlingInfo(array('bl_id'=>$bl_id));
                if (!empty($bl_info)) {
                    $freight_list[$store_id] += $bl_info['bl_freight'];
                }
            }
        }

        $return['iscalced'] = $freight_list;

        //最后再计算使用运费模板的信息(店铺ID，运费模板ID，购买数量),使用使用相同运费模板的商品数量累加
        $freight_list = array();
        foreach ($buy_list as $goods_info) {
            $freight_list[$goods_info['store_id']][$goods_info['transport_id']] += $goods_info['goods_num'];
        }
        $return['nocalced'] = $freight_list;

        return $return;
    }

    /**
     * 根据地区选择计算出所有店铺最终运费
     * @param array $freight_list 运费信息(店铺ID，运费，运费模板ID，购买数量)
     * @param int $city_id 市级ID
     * @return array 返回店铺ID=>运费
     */
    public function calcStoreFreight($freight_list, $city_id) {
		if (!is_array($freight_list) || empty($freight_list) || empty($city_id)) return;

		//免费和固定运费计算结果
		$return_list = $freight_list['iscalced'];

		//使用运费模板的信息(array(店铺ID=>array(运费模板ID=>购买数量))
		$nocalced_list = $freight_list['nocalced'];

		//然后计算使用运费运费模板的在该$city_id时的运费值
		if (!empty($nocalced_list) && is_array($nocalced_list)) {
		    //如果有商品使用的运费模板，先计算这些商品的运费总金额
            $model_transport = Model('transport');
            foreach ($nocalced_list as $store_id => $value) {
                if (is_array($value)) {
                    foreach ($value as $transport_id => $buy_num) {
                        $freight_total = $model_transport->calc_transport($transport_id,$buy_num, $city_id);
                        if (empty($return_list[$store_id])) {
                            $return_list[$store_id] = $freight_total;
                        } else {
                            $return_list[$store_id] += $freight_total;
                        }
                    }
                }
            }
		}

		return $return_list;
    }

    /**
     * 取得店铺下商品分类佣金比例
     * @param array $goods_list
     * @return array 店铺ID=>array(分类ID=>佣金比例)
     */
    public function getStoreGcidCommisRateList($goods_list) {
        if (empty($goods_list) || !is_array($goods_list)) return array();
        
        //定义返回数组
        $store_gc_id_commis_rate = array();

        //取得每个店铺下有哪些商品分类
        $store_gc_id_list = array();
        foreach ($goods_list as $goods) {
            if (!intval($goods['gc_id'])) continue;
            if (!in_array($goods['gc_id'],(array)$store_gc_id_list[$goods['store_id']])) {
                if (in_array($goods['store_id'],array(DEFAULT_PLATFORM_STORE_ID))) {
                    //平台店铺佣金为0
                    //$store_gc_id_commis_rate[$goods['store_id']][$goods['gc_id']] = 0;
                } else {
                    //$store_gc_id_list[$goods['store_id']][] = $goods['gc_id'];
                }
				//zmrcui>>>>>
				$store_gc_id_list[$goods['store_id']][] = $goods['gc_id'];
				//zmrcui<<<<<
            }
        }

        if (empty($store_gc_id_list)) return array();

        $model_bind_class = Model('store_bind_class');
	    //商品分类
        $goods_class = Model('goods_class')->getGoodsClassForCacheModel();
        foreach ($store_gc_id_list as $store_id => $gc_id_list) {
            $condition = array();
            $condition['store_id'] = $store_id;
            foreach($gc_id_list as $gc_id)
            {
                $class_2 = $goods_class[$gc_id]['gc_parent_id'];
                $class_1 = $goods_class[$class_2]['gc_parent_id'];
                $condition['class_1'] =  $class_1;
                $condition['class_2'] =  $class_2;
                $condition['class_3'] =  $gc_id;
                $bind_info = $model_bind_class->getStoreBindClassInfo($condition);
                if (!empty($bind_info))
                {
                    $store_gc_id_commis_rate[$store_id][$gc_id] = $bind_info['commis_rate'];
                }
                else
                {
                    $condition['class_3'] =  0;
                    $bind_info = $model_bind_class->getStoreBindClassInfo($condition);
                    if (!empty($bind_info))
                    {
                        $store_gc_id_commis_rate[$store_id][$gc_id] = $bind_info['commis_rate'];
                    }
                    else
                    {
                        $condition['class_2'] =  0;
                        $condition['class_3'] =  0;
                        $bind_info = $model_bind_class->getStoreBindClassInfo($condition);
                        if (!empty($bind_info))
                        {
                            $store_gc_id_commis_rate[$store_id][$gc_id] = $bind_info['commis_rate'];
                        }
                        else
                        {
                            $condition['class_1'] =  0;
                            $condition['class_2'] =  0;
                            $condition['class_3'] =  0;
                            $bind_info = $model_bind_class->getStoreBindClassInfo($condition);
                            if (!empty($bind_info))
                            {
                                $store_gc_id_commis_rate[$store_id][$gc_id] = $bind_info['commis_rate'];
                            }
                        }
                    }
                }
            }
        }
        return $store_gc_id_commis_rate;

    }

    /**
     * 追加赠品到下单列表,并更新购买数量
     * @param array $store_cart_list 购买列表
     * @param array $store_premiums_list 赠品列表
     * @param array $store_mansong_rule_list 满即送规则
     */
    public function appendPremiumsToCartList($store_cart_list, $store_premiums_list = array(), $store_mansong_rule_list = array(), $member_id) {
        if (empty($store_cart_list)) return array();

        //取得每种商品的库存
        $goods_storage_quantity = $this->_getEachGoodsStorageQuantity($store_cart_list,$store_premiums_list);

        //取得每种商品的购买量
        $goods_buy_quantity = $this->_getEachGoodsBuyQuantity($store_cart_list);

        //本次购买后，余库存为0的，则后面不再送赠品
        $last_storage = array();
        foreach ($goods_buy_quantity as $goods_id => $quantity) {
            $goods_storage_quantity[$goods_id] -= $quantity;
            if ($goods_storage_quantity[$goods_id] < 0) {
                return array('error' => '抱歉，您购买的商品库存不足，请重购买'); 
            }
        }
        //将赠品追加到购买列表
        if(is_array($store_premiums_list)) {
            foreach ($store_premiums_list as $store_id => $goods_list) {
                foreach ($goods_list as $goods_info) {
                    //如果没有库存了，则不再送赠品
                    if (!intval($goods_storage_quantity[$goods_id])) {
                        $store_mansong_rule_list[$store_id]['desc'] .= ' ( 抱歉，库存不足，系统未送赠品 )';
                        continue;
                    }
                    $new_data = array();
                    $new_data['buyer_id'] = $member_id;
                    $new_data['store_id'] = $store_id;
                    $new_data['store_name'] = $store_cart_list[$store_id][0]['store_name'];
                    $new_data['goods_id'] = $goods_info['goods_id'];
                    $new_data['goods_name'] = $goods_info['goods_name'];
                    $new_data['goods_num'] = 1;
                    $new_data['goods_price'] = 0;
                    $new_data['goods_image'] = $goods_info['goods_image'];
                    $new_data['bl_id'] = 0;
                    $new_data['state'] = true;
                    $new_data['storage_state'] = true;
                    $new_data['gc_id'] = 0;
                    $new_data['transport_id'] = 0;
                    $new_data['goods_freight'] = 0;
                    $new_data['goods_vat'] = 0;
                    $new_data['goods_total'] = 0;
                    $new_data['ifzengpin'] = true;
                    $store_cart_list[$store_id][] = $new_data;
                    $goods_buy_quantity[$goods_info['goods_id']] += 1;
                }
            }
        }
        return array($store_cart_list,$goods_buy_quantity,$store_mansong_rule_list);
    }

    /**
     * 取得每种商品的库存
     * @param array $store_cart_list 购买列表
     * @param array $store_premiums_list 赠品列表
     * @return array 商品ID=>库存
     */
    private function _getEachGoodsStorageQuantity($store_cart_list, $store_premiums_list = array()) {
        if(empty($store_cart_list) || !is_array($store_cart_list)) return array();
        $goods_storage_quangity = array();
        foreach ($store_cart_list as $store_cart) {
            foreach ($store_cart as $cart_info) {
                if (!intval($cart_info['bl_id'])) {
                    //正常商品
                    $goods_storage_quangity[$cart_info['goods_id']] = $cart_info['goods_storage'];
                } elseif (!empty($cart_info['bl_goods_list']) && is_array($cart_info['bl_goods_list'])) {
                    //优惠套装
                    foreach ($cart_info['bl_goods_list'] as $goods_info) {
                        $goods_storage_quangity[$goods_info['goods_id']] = $goods_info['goods_storage'];
                    }
                }
            }
        }
        //取得赠品商品的库存
        if (is_array($store_premiums_list)) {
            foreach ($store_premiums_list as $store_id => $goods_list) {
                foreach($goods_list as $goods_info) {
                    if (!isset($goods_storage_quangity[$goods_info['goods_id']])) {
                        $goods_storage_quangity[$goods_info['goods_id']] = $goods_info['goods_storage'];
                    }
                }
            }
        }
        return $goods_storage_quangity;
    }

    /**
     * 取得每种商品的购买量
     * @param array $store_cart_list 购买列表
     * @return array 商品ID=>购买数量
     */
    private function _getEachGoodsBuyQuantity($store_cart_list) {
        if(empty($store_cart_list) || !is_array($store_cart_list)) return array();
        $goods_buy_quangity = array();
        foreach ($store_cart_list as $store_cart) {
            foreach ($store_cart as $cart_info) {
                if (!intval($cart_info['bl_id'])) {
                    //正常商品
                    $goods_buy_quangity[$cart_info['goods_id']] += $cart_info['goods_num'];
                } elseif (!empty($cart_info['bl_goods_list']) && is_array($cart_info['bl_goods_list'])) {
                    //优惠套装
                    foreach ($cart_info['bl_goods_list'] as $goods_info) {
                        $goods_buy_quangity[$goods_info['goods_id']] += $cart_info['goods_num'];
                    }
                }   
            }
        }
        return $goods_buy_quangity;
    }

    /**
     * 生成订单
     * @param array $input
     * @throws Exception
     * @return array array(支付单sn,订单列表)
     */
    public function createOrder($input, $member_id, $member_name, $member_email) {

        extract($input);
        $model_order = Model('order');
        //存储生成的订单,函数会返回该数组
        $order_list = array();

        //每个店铺订单是货到付款还是线上支付,店铺ID=>付款方式[在线支付/货到付款]
        $store_pay_type_list    = $this->_getStorePayTypeList(array_keys($store_cart_list), $if_offpay, $pay_name);

        $pay_sn = $this->makePaySn($member_id);
        $order_pay = array();
        $order_pay['pay_sn'] = $pay_sn;
        $order_pay['buyer_id'] = $member_id;
        $order_pay_id = $model_order->addOrderPay($order_pay);
        if (!$order_pay_id) {
            throw new Exception('订单保存失败');
        }

        //收货人信息
        $reciver_info = array();
        $reciver_info['address'] = $address_info['area_info'].'&nbsp;'.$address_info['address'];
        $reciver_info['phone'] = $address_info['mob_phone'].($address_info['tel_phone'] ? ','.$address_info['tel_phone'] : null);
        $reciver_info = serialize($reciver_info);
        $reciver_name = $address_info['true_name'];

        foreach ($store_cart_list as $store_id => $goods_list) {

            //取得本店优惠额度(后面用来计算每件商品实际支付金额，结算需要)
            $promotion_total = !empty($store_promotion_total[$store_id]) ? $store_promotion_total[$store_id] : 0; 
            //本店总的优惠比例,保留3位小数
            $should_goods_total = $store_final_order_total[$store_id]-$store_freight_total[$store_id]+$promotion_total;
            $promotion_rate = abs(number_format($promotion_total/$should_goods_total,5));
            if ($promotion_rate <= 1) {
                $promotion_rate = floatval(substr($promotion_rate,0,5));
            } else {
                $promotion_rate = 0;
            }

            //每种商品的优惠金额累加保存入 $promotion_sum
            $promotion_sum = 0;

            $order = array();
            $order_common = array();
            $order_goods = array();

            $order['order_sn'] = $this->makeOrderSn($order_pay_id);
            $order['pay_sn'] = $pay_sn;
            $order['store_id'] = $store_id;
            $order['store_name'] = $goods_list[0]['store_name'];
            $order['buyer_id'] = $member_id;
            $order['buyer_name'] = $member_name;
            $order['buyer_email'] = $member_email;
            $order['add_time'] = TIMESTAMP;
            $order['payment_code'] = $store_pay_type_list[$store_id];
            $order['order_state'] = $store_pay_type_list[$store_id] == 'online' ? ORDER_STATE_NEW : ORDER_STATE_PAY;
            $order['order_amount'] = $store_final_order_total[$store_id];
            $order['shipping_fee'] = $store_freight_total[$store_id];
            $order['goods_amount'] = $order['order_amount'] - $order['shipping_fee'];
            $order['order_from'] = 1;
            $order_id = $model_order->addOrder($order);
            if (!$order_id) {
                throw new Exception('订单保存失败');
            }
            $order['order_id'] = $order_id;
            $order_list[$order_id] = $order;

            $order_common['order_id'] = $order_id;
            $order_common['store_id'] = $store_id;
            $order_common['order_message'] = $pay_message[$store_id];

            //代金券
            if (isset($voucher_list[$store_id])){
                $order_common['voucher_price'] = $voucher_list[$store_id]['voucher_price'];
                $order_common['voucher_code'] = $voucher_list[$store_id]['voucher_code'];
            }

            $order_common['reciver_info']= $reciver_info;
            $order_common['reciver_name'] = $reciver_name;

            //发票信息
            $order_common['invoice_info'] = $this->_createInvoiceData($invoice_info);

            //保存促销信息
            if(is_array($store_mansong_rule_list[$store_id])) {
                $order_common['promotion_info'] = addslashes($store_mansong_rule_list[$store_id]['desc']);
            }

            //取得省ID b y 3 3 h a o .com 货到付款
            require_once(BASE_DATA_PATH.'/area/area.php');
            $order_common['reciver_province_id'] = intval($area_array[$input_city_id]['area_parent_id']);
            $order_id = $model_order->addOrderCommon($order_common);
            if (!$order_id) {
                throw new Exception('订单保存失败');
            }

            //生成order_goods订单商品数据
            $i = 0;
            foreach ($goods_list as $goods_info) {
                if (!$goods_info['state'] || !$goods_info['storage_state']) {
                    throw new Exception('部分商品已经下架或库存不足，请重新选择');
                }
                if (!intval($goods_info['bl_id'])) {
                    //如果不是优惠套装
                    $order_goods[$i]['order_id'] = $order_id;
                    $order_goods[$i]['goods_id'] = $goods_info['goods_id'];
                    $order_goods[$i]['store_id'] = $store_id;
                    $order_goods[$i]['goods_name'] = $goods_info['goods_name'];
                    $order_goods[$i]['goods_price'] = $goods_info['goods_price'];
                    $order_goods[$i]['goods_num'] = $goods_info['goods_num'];
                    $order_goods[$i]['goods_image'] = $goods_info['goods_image'];
                    $order_goods[$i]['buyer_id'] = $member_id;
                    if ($goods_info['ifgroupbuy']) {
                        $order_goods[$i]['goods_type'] = 2;
                    }elseif ($goods_info['ifxianshi']) {
                        $order_goods[$i]['goods_type'] = 3;
                    }elseif ($goods_info['ifzengpin']) {
                        $order_goods[$i]['goods_type'] = 5;
                    }else {
                        $order_goods[$i]['goods_type'] = 1;
                    }
                    $order_goods[$i]['promotions_id'] = $goods_info['promotions_id'] ? $goods_info['promotions_id'] : 0;
                    $order_goods[$i]['commis_rate'] = floatval($store_gc_id_commis_rate_list[$store_id][$goods_info['gc_id']]);
					
					
					
                    $order_goods[$i]['gc_id'] = $goods_info['gc_id'];
                    //计算商品金额
                    $goods_total = $goods_info['goods_price'] * $goods_info['goods_num'];
                    //计算本件商品优惠金额
                    $promotion_value = floor($goods_total*($promotion_rate));
                    $order_goods[$i]['goods_pay_price'] = $goods_total - $promotion_value;
                    $promotion_sum += $promotion_value;
                    $i++;
                    // 验证库存发送库存报警
                    if ($goods_info['goods_storage_alarm'] >= ($goods_info['goods_storage'] - $goods_info['goods_num'])) {
                        $param = array();
                        $param['common_id'] = $goods_info['goods_commonid'];
                        $param['sku_id'] = $goods_info['goods_id'];
                        $this->sendStoreMsg('goods_storage_alarm', $goods_info['store_id'], $param);
                    }

                } elseif (!empty($goods_info['bl_goods_list']) && is_array($goods_info['bl_goods_list'])) {

                    //优惠套装
                    foreach ($goods_info['bl_goods_list'] as $bl_goods_info) {
                        $order_goods[$i]['order_id'] = $order_id;
                        $order_goods[$i]['goods_id'] = $bl_goods_info['goods_id'];
                        $order_goods[$i]['store_id'] = $store_id;
                        $order_goods[$i]['goods_name'] = $bl_goods_info['goods_name'];
                        $order_goods[$i]['goods_price'] = $bl_goods_info['bl_goods_price'];
                        $order_goods[$i]['goods_num'] = $goods_info['goods_num'];
                        $order_goods[$i]['goods_image'] = $bl_goods_info['goods_image'];
                        $order_goods[$i]['buyer_id'] = $member_id;
                        $order_goods[$i]['goods_type'] = 4;
                        $order_goods[$i]['promotions_id'] = $bl_goods_info['bl_id'];
                        $order_goods[$i]['commis_rate'] = floatval($store_gc_id_commis_rate_list[$store_id][$goods_info['gc_id']]);
                        $order_goods[$i]['gc_id'] = $bl_goods_info['gc_id'];

                        //计算商品实际支付金额(goods_price减去分摊优惠金额后的值)
                        $goods_total = $bl_goods_info['bl_goods_price'] * $goods_info['goods_num'];
                        //计算本件商品优惠金额
                        $promotion_value = floor($goods_total*($promotion_rate));
                        $order_goods[$i]['goods_pay_price'] = $goods_total - $promotion_value;
                        $promotion_sum += $promotion_value;
                        $i++;

                        // 验证库存发送库存报警
                        if ($bl_goods_info['goods_storage_alarm'] >= ($bl_goods_info['goods_storage'] - $goods_info['goods_num'])) {
                            $param = array();
                            $param['common_id'] = $bl_goods_info['goods_commonid'];
                            $param['sku_id'] = $bl_goods_info['goods_id'];
                            $this->sendStoreMsg('goods_storage_alarm', $bl_goods_info['store_id'], $param);
                        }
                    }
                }
            }

            //将因舍出小数部分出现的差值补到最后一个商品的实际成交价中(商品goods_price=0时不给补，可能是赠品)
            if ($promotion_total > $promotion_sum) {
                $i--;
                for($i;$i>=0;$i--) {
                    if (floatval($order_goods[$i]['goods_price']) > 0) {
                        $order_goods[$i]['goods_pay_price'] -= $promotion_total - $promotion_sum;
                        break;
                    }
                }
            }
            $insert = $model_order->addOrderGoods($order_goods);
            if (!$insert) {
                throw new Exception('订单保存失败');
            }
            
            // 货到付款订单发送商家提醒
            if ($store_pay_type_list[$store_id] == 'offline') {
                $param = array();
                $param['order_sn'] = $order['order_sn'];
                $this->sendStoreMsg('new_order', $order['store_id'], $param);
            }
        }
        return array($pay_sn,$order_list);
    }
    
    /**
     * 发送店铺消息
     * @param string $code
     * @param int $store_id
     * @param array $param
     */
    private function sendStoreMsg($code, $store_id, $param) {
        QueueClient::push('sendStoreMsg', array('code' => $code, 'store_id' => $store_id, 'param' => $param));
    }

    /**
     * 记录订单日志
     * @param array $order_list
     */
    public function addOrderLog($order_list = array()) {
        if (empty($order_list) || !is_array($order_list)) return;
        $model_order = Model('order');
        foreach ($order_list as $order_id => $order) {
            $data = array();
            $data['order_id'] = $order_id;
            $data['log_role'] = 'buyer';
            $data['log_msg'] = L('order_log_new');
            $data['log_orderstate'] = $order['payment_code'] == 'offline' ? ORDER_STATE_PAY : ORDER_STATE_NEW;
            $model_order->addOrderLog($data);
        }
    }

    /**
     * 店铺购买列表
     * @param array $goods_buy_quantity 商品ID与购买数量数组
     * @throws Exception
     */
    public function updateGoodsStorageNum($goods_buy_quantity) {
        if (empty($goods_buy_quantity) || !is_array($goods_buy_quantity)) return;
        $model_goods = Model('goods');
        foreach ($goods_buy_quantity as $goods_id => $quantity) {
            $goods_info = $cart_info;
            $data = array();
            $data['goods_storage'] = array('exp','goods_storage-'.$quantity);
            $data['goods_salenum'] = array('exp','goods_salenum+'.$quantity);
            $result = $model_goods->editGoods($data,array('goods_id'=>$goods_id));
            if (!$result) throw new Exception('更新库存失败');
        }
    }

    /**
     * 预存款支付,依次循环每个订单
     * 如果预存款足够就单独支付了该订单，如果不足就暂时冻结，等API支付成功了再彻底扣除
     */
    public function pdPay($order_list, $input, $member_id, $member_name) {
        if (empty($input['pd_pay']) || empty($input['password'])) return;

        $model_payment = Model('payment');
        $pd_payment_info = $model_payment->getPaymentOpenInfo(array('payment_code'=>'predeposit'));
        if (empty($pd_payment_info)) return;

        $buyer_info	= Model('member')->getMemberInfo(array('member_id' => $member_id),'available_predeposit,member_paypwd');
        if ($buyer_info['member_paypwd'] == '' || $buyer_info['member_paypwd'] != md5($input['password'])) return ;
        $available_pd_amount = floatval($buyer_info['available_predeposit']);
        if ($available_pd_amount <= 0) return;

        $model_order = Model('order');
        $model_pd = Model('predeposit');
        foreach ($order_list as $order_info) {

            //货到付款的订单跳过
            if ($order_info['payment_code'] == 'offline') continue;

            $order_amount = floatval($order_info['order_amount']);
            $data_pd = array();
            $data_pd['member_id'] = $member_id;
            $data_pd['member_name'] = $member_name;
            $data_pd['amount'] = $order_info['order_amount'];
            $data_pd['order_sn'] = $order_info['order_sn'];

            if ($available_pd_amount >= $order_amount) {
                //预存款立即支付，订单支付完成
                $model_pd->changePd('order_pay',$data_pd);
                $available_pd_amount -= $order_amount;

                //记录订单日志(已付款)
                $data = array();
                $data['order_id'] = $order_info['order_id'];
                $data['log_role'] = 'buyer';
                $data['log_msg'] = L('order_log_pay');
                $data['log_orderstate'] = ORDER_STATE_PAY;
                $insert = $model_order->addOrderLog($data);
                if (!$insert) {
                    throw new Exception('记录订单日志出现错误');
                }

                //订单状态 置为已支付
                $data_order = array();
                $data_order['order_state'] = ORDER_STATE_PAY;
                $data_order['payment_time'] = TIMESTAMP;
                $data_order['payment_code'] = 'predeposit';
                $data_order['pd_amount'] = $order_amount;
                $result = $model_order->editOrder($data_order,array('order_id'=>$order_info['order_id']));
                if (!$result) {
                    throw new Exception('订单更新失败');
                }
                // 发送商家提醒
                $param = array();
                $param['code'] = 'new_order';
                $param['store_id'] = $order_info['store_id'];
                $param['param'] = array(
                        'order_sn' => $order_info['order_sn']
                );
                QueueClient::push('sendStoreMsg', $param);
            } else {
                //暂冻结预存款,后面还需要 API彻底完成支付
                if ($available_pd_amount > 0) {
                    $data_pd['amount'] = $available_pd_amount;
                    $model_pd->changePd('order_freeze',$data_pd);
                    //预存款支付金额保存到订单
                    $data_order = array();
                    $data_order['pd_amount'] = $available_pd_amount;
                    $result = $model_order->editOrder($data_order,array('order_id'=>$order_info['order_id']));
                    $available_pd_amount = 0;
                    if (!$result) {
                        throw new Exception('订单更新失败');
                    }
                }
            }
        }
    }

    /**
     * 整理发票信息
     * @param array $invoice_info 发票信息数组
     * @return string
     */
    private function _createInvoiceData($invoice_info){
        //发票信息
        $inv = array();
        if ($invoice_info['inv_state'] == 1) {
            $inv['类型'] = '普通发票 ';
            $inv['抬头'] = $invoice_info['inv_title_select'] == 'person' ? '个人' : $invoice_info['inv_title'];
            $inv['内容'] = $invoice_info['inv_content'];
        } elseif (!empty($invoice_info)) {
            $inv['单位名称'] = $invoice_info['inv_company'];
            $inv['纳税人识别号'] = $invoice_info['inv_code'];
            $inv['注册地址'] = $invoice_info['inv_reg_addr'];
            $inv['注册电话'] = $invoice_info['inv_reg_phone'];
            $inv['开户银行'] = $invoice_info['inv_reg_bname'];
            $inv['银行帐户'] = $invoice_info['inv_reg_baccount'];
            $inv['收票人姓名'] = $invoice_info['inv_rec_name'];
            $inv['收票人手机号'] = $invoice_info['inv_rec_mobphone'];
            $inv['收票人省份'] = $invoice_info['inv_rec_province'];
            $inv['送票地址'] = $invoice_info['inv_goto_addr'];
        }
        return !empty($inv) ? serialize($inv) : serialize(array());        
    }

    /**
     * 计算本次下单中每个店铺订单是货到付款还是线上支付,店铺ID=>付款方式[online在线支付offline货到付款]
     * @param array $store_id_array 店铺ID数组
     * @param boolean $if_offpay 是否支持货到付款 true/false
     * @param string $pay_name 付款方式 online/offline
     * @return array
     */
    private function _getStorePayTypeList($store_id_array, $if_offpay, $pay_name) {
        $store_pay_type_list = array();
        if ($_POST['pay_name'] == 'online') {
            foreach ($store_id_array as $store_id) {
                $store_pay_type_list[$store_id] = 'online';
            }
        } else {
            $offline_pay = Model('payment')->getPaymentOpenInfo(array('payment_code'=>'offline'));
            if ($offline_pay) {
                //下单里包括平台自营商品并且平台已开启货到付款
                $offline_store_id_array = array(DEFAULT_PLATFORM_STORE_ID);
                foreach ($store_id_array as $store_id) {
                    if (in_array($store_id,$offline_store_id_array)) {
                        $store_pay_type_list[$store_id] = 'offline';
                    } else {
                        $store_pay_type_list[$store_id] = 'online';
                    }
                }
            }
        }
        return $store_pay_type_list;
    }

	/**
	 * 生成支付单编号(两位随机 + 从2000-01-01 00:00:00 到现在的秒数+微秒+会员ID%1000)，该值会传给第三方支付接口
	 * 长度 =2位 + 10位 + 3位 + 3位  = 18位
	 * 1000个会员同一微秒提订单，重复机率为1/100
	 * @return string
	 */
	public function makePaySn($member_id) {
		return mt_rand(10,99)
		      . sprintf('%010d',time() - 946656000)
		      . sprintf('%03d', (float) microtime() * 1000)
		      . sprintf('%03d', (int) $member_id % 1000);
	}

	/**
	 * 订单编号生成规则，n(n>=1)个订单表对应一个支付表，
	 * 生成订单编号(年取1位 + $pay_id取13位 + 第N个子订单取2位)
	 * 1000个会员同一微秒提订单，重复机率为1/100
	 * @param $pay_id 支付表自增ID
	 * @return string
	 */
	public function makeOrderSn($pay_id) {
	    //记录生成子订单的个数，如果生成多个子订单，该值会累加
	    static $num;
	    if (empty($num)) {
	        $num = 1;
	    } else {
	        $num ++;
	    }
		return (date('y',time()) % 9+1) . sprintf('%013d', $pay_id) . sprintf('%02d', $num);
	}

	/**
	 * 更新库存与销量
	 *
	 * @param array $buy_items 商品ID => 购买数量
	 */
	public function editGoodsNum($buy_items) {
        $model = Model()->table('goods');
        foreach ($buy_items as $goods_id => $buy_num) {
        	$data = array('goods_storage'=>array('exp','goods_storage-'.$buy_num),'goods_salenum'=>array('exp','goods_salenum+'.$buy_num));
        	$result = $model->where(array('goods_id'=>$goods_id))->update($data);
        	if (!$result) throw new Exception(L('cart_step2_submit_fail'));
        }
	}

    /**
     * 购买第一步
     *
	 * @param array $cart_id 购物车
	 * @param int $ifcart 是否为购物车
     * @param int $invalid_cart
     * @param int $member_id 会员编号
     * @param int $store_id 店铺编号
     */
    public function buyStep1($cart_id, $ifcart, $invalid_cart, $member_id, $store_id) {
        $model_cart = Model('cart');

        $result = array();

        //取得POST ID和购买数量
        $buy_items = $this->_parseItems($cart_id);

        if (count($buy_items) > 50) {
            return array('error' => '一次最多只可购买50种商品');
        }

        if ($ifcart) {

            //来源于购物车

            //取购物车列表
            $condition = array('cart_id'=>array('in',array_keys($buy_items)), 'buyer_id'=>$member_id);
            $cart_list	= $model_cart->listCart('db', $condition);

            //取商品最新的在售信息
            $cart_list = $model_cart->getOnlineCartList($cart_list);

            //得到限时折扣信息
            $cart_list = $model_cart->getXianshiCartList($cart_list);

            //得到优惠套装状态,并取得组合套装商品列表
            $cart_list = $model_cart->getBundlingCartList($cart_list);

            //到得商品列表
            $goods_list = $model_cart->getGoodsList($cart_list);

            //购物车列表以店铺ID分组显示
            $store_cart_list = $model_cart->getStoreCartList($cart_list);

            //标识来源于购物车
            $result['ifcart'] = 1;

        } else {

            //来源于直接购买
            $goods_id = key($buy_items);
            $quantity = current($buy_items);

            //取得商品最新在售信息
            $goods_info = $model_cart->getGoodsOnlineInfo($goods_id,intval($quantity));
            if(empty($goods_info)) {
                return array('error' => '商品不存在');
            }

            //不能购买自己店铺的商品
            if ($goods_info['store_id'] == $store_id) {
                return array('error' => '不能购买自己店铺的商品' );
            }

            //判断是不是正在抢购中，如果是则按抢购价格计算，购买数量若超过抢购规定的上限，则按抢购上限计算
            $goods_info = $model_cart->getGroupbuyInfo($goods_info);

            //如果未进行抢购，则再判断是否限时折扣中
            if (!$goods_info['ifgroupbuy']) {
                $goods_info = $model_cart->getXianshiInfo($goods_info,$quantity);
            }

            //转成多维数组，方便纺一使用购物车方法与模板
            $store_cart_list = array();
            $goods_list = array();
            $goods_list[0] = $store_cart_list[$goods_info['store_id']][0] = $goods_info;
        }

        //商品金额计算(分别对每个商品/优惠套装小计、每个店铺小计)
        list($store_cart_list,$store_goods_total) = $model_cart->calcCartList($store_cart_list);
        $result['store_cart_list'] = $store_cart_list;
        $result['store_goods_total'] = $store_goods_total;

        //取得店铺优惠 - 满即送(赠品列表，店铺满送规则列表)
        list($store_premiums_list,$store_mansong_rule_list) = $model_cart->getMansongRuleCartListByTotal($store_goods_total);
        $result['store_premiums_list'] = $store_premiums_list;
        $result['store_mansong_rule_list'] = $store_mansong_rule_list;

        //重新计算优惠后(满即送)的店铺实际商品总金额
        $store_goods_total = $model_cart->reCalcGoodsTotal($store_goods_total,$store_mansong_rule_list,'mansong');

        //返回店铺可用的代金券
        $store_voucher_list = $model_cart->getStoreAvailableVoucherList($store_goods_total, $member_id);
        $result['store_voucher_list'] = $store_voucher_list;

        //返回需要计算运费的店铺ID数组 和 不需要计算运费(满免运费活动的)店铺ID及描述
        list($need_calc_sid_list,$cancel_calc_sid_list) = $this->getStoreFreightDescList($store_goods_total);
        $result['need_calc_sid_list'] = $need_calc_sid_list;
        $result['cancel_calc_sid_list'] = $cancel_calc_sid_list;

        //将商品ID、数量、运费模板、运费序列化，加密，输出到模板，选择地区AJAX计算运费时作为参数使用
        $freight_list = $this->getStoreFreightList($goods_list,array_keys($cancel_calc_sid_list));
        $result['freight_list'] = $this->buyEncrypt($freight_list, $member_id);

        //输出用户默认收货地址
        $result['address_info'] = Model('address')->getDefaultAddressInfo(array('member_id'=>$member_id));

        //输出有货到付款时，在线支付和货到付款及每种支付下商品数量和详细列表
        $pay_goods_list = $this->getOfflineGoodsPay($goods_list);
        if (!empty($pay_goods_list['offline'])) {
            $result['pay_goods_list'] = $pay_goods_list;
            $result['ifshow_offpay'] = true;
        } else {
            //如果所购商品只支持线上支付，支付方式不允许修改
            $result['deny_edit_payment'] = true;
        }

        //发票 :只有所有商品都支持增值税发票才提供增值税发票
        foreach ($goods_list as $goods) {
        	if (!intval($goods['goods_vat'])) {
        	    $vat_deny = true;break;
        	}
        }
        //不提供增值税发票时抛出true(模板使用)
        $result['vat_deny'] = $vat_deny;
        $result['vat_hash'] = $this->buyEncrypt($result['vat_deny'] ? 'deny_vat' : 'allow_vat', $member_id);

        //输出默认使用的发票信息
        $inv_info = Model('invoice')->getDefaultInvInfo(array('member_id'=>$member_id));
        if ($inv_info['inv_state'] == '2' && !$vat_deny) {
            $inv_info['content'] = '增值税发票 '.$inv_info['inv_company'].' '.$inv_info['inv_code'].' '.$inv_info['inv_reg_addr'];
        } elseif ($inv_info['inv_state'] == '2' && $vat_deny) {
            $inv_info = array();
            $inv_info['content'] = '不需要发票';
        } elseif (!empty($inv_info)) {
            $inv_info['content'] = '普通发票 '.$inv_info['inv_title'].' '.$inv_info['inv_content'];
        } else {
            $inv_info = array();
            $inv_info['content'] = '不需要发票';
        }
        $result['inv_info'] = $inv_info;

        //删除购物车中无效商品
        if ($ifcart) {
            if (is_array($invalid_cart)) {
                $cart_id_str = implode(',',$invalid_cart);
                if (preg_match_all('/^[\d,]+$/',$cart_id_str,$matches)) {
                    $model_cart->delCart('db',array('buyer_id'=>$member_id,'cart_id'=>array('in',$cart_id_str)));
                }
            }
        }

        //显示使用预存款支付及会员预存款
        $model_payment = Model('payment');
        $pd_payment_info = $model_payment->getPaymentOpenInfo(array('payment_code'=>'predeposit'));
        if (!empty($pd_payment_info)) {
            $buyer_info	= Model('member')->getMemberInfo(array('member_id' => $member_id),'available_predeposit,member_paypwd');
            if (floatval($buyer_info['available_predeposit']) > 0) {
                $result['available_predeposit'] = $buyer_info['available_predeposit'];
                $result['member_paypwd'] = $buyer_info['member_paypwd'] ? true : false;
            }
        }

        return $result;
    }

    /**
     * 购物车、直接购买第二步:保存订单入库，产生订单号，开始选择支付方式
     *
     */
    public function buyStep2($post, $member_id, $member_name, $member_email) {
        $model_cart = Model('cart');
        //取得商品ID和购买数量
        $input_buy_items = $this->_parseItems($post['cart_id']);

        //验证收货地址
        $input_address_id = intval($post['address_id']);
        if ($input_address_id <= 0) {
            return array('error' => '请选择收货地址');
        } else {
            $input_address_info = Model('address')->getAddressInfo(array('address_id'=>$input_address_id));
            if ($input_address_info['member_id'] != $member_id) {
                return array('error' => '请选择收货地址');
            }
        }
        //收货地址城市编号
        $input_city_id = intval($input_address_info['city_id']);

        //是否开增值税发票
        $input_if_vat = $this->buyDecrypt($post['vat_hash'], $member_id);
        if (!in_array($input_if_vat,array('allow_vat','deny_vat'))) {
            return array('error' => '订单保存出现异常，请重试');
        }
        $input_if_vat = ($input_if_vat == 'allow_vat') ? true : false;

        //是否支持货到付款
        $input_if_offpay = $this->buyDecrypt($post['offpay_hash'], $member_id);
        if (!in_array($input_if_offpay,array('allow_offpay','deny_offpay'))) {
            return array('error' => '订单保存出现异常，请重试');
        }
        $input_if_offpay = ($input_if_offpay == 'allow_offpay') ? true : false;

        //付款方式:在线支付/货到付款(online/offline)
        if (!in_array($post['pay_name'],array('online','offline'))) {
            return array('error' => '付款方式错误，请重新选择');
        }
        $input_pay_name = $post['pay_name'];

        //验证发票信息
        if (!empty($post['invoice_id'])) {
            $input_invoice_id = intval($post['invoice_id']);
            if ($input_invoice_id > 0) {
                $input_invoice_info = Model('invoice')->getinvInfo(array('inv_id'=>$input_invoice_id));
                if ($input_invoice_info['member_id'] != $member_id) {
                    return array('error' => '请正确填写发票信息');
                }
            }
        }

        //验证代金券
        $input_voucher_list = array();
        if (is_array($post['voucher'])) {
            foreach ($post['voucher'] as $store_id => $voucher) {
                if (preg_match_all('/^(\d+)\|(\d+)\|([\d.]+)$/',$voucher,$matchs)) {
                    if (floatval($matchs[3][0]) > 0) {
                        $input_voucher_list[$store_id]['voucher_t_id'] = $matchs[1][0];
                        $input_voucher_list[$store_id]['voucher_price'] = $matchs[3][0];                        
                    }
                }
            }
        }

        if ($post['ifcart']) {

            //取购物车列表
            $condition = array('cart_id'=>array('in',array_keys($input_buy_items)),'buyer_id'=>$member_id);
            $cart_list	= $model_cart->listCart('db',$condition);

            //取商品最新的在售信息
            $cart_list = $model_cart->getOnlineCartList($cart_list);

            //得到限时折扣信息
            $cart_list = $model_cart->getXianshiCartList($cart_list);

            //得到优惠套装状态,并取得组合套装商品列表
            $cart_list = $model_cart->getBundlingCartList($cart_list);

            //到得商品列表
            $goods_list = $model_cart->getGoodsList($cart_list);

            //购物车列表以店铺ID分组显示
            $store_cart_list = $model_cart->getStoreCartList($cart_list);
        } else {
            //来源于直接购买
            //取得购买的商品ID和购买数量,只有有一个下标 ，只会循环一次
            foreach ($input_buy_items as $goods_id => $quantity) {break;}

            //取得商品最新在售信息
            $goods_info = $model_cart->getGoodsOnlineInfo($goods_id,$quantity);
            if(empty($goods_info)) {
                return array('error' => '商品不存在');
            }

            //判断是不是正在抢购中，如果是则按抢购价格计算，购买数量若超过抢购规定的上限，则按抢购上限计算
            $goods_info = $model_cart->getGroupbuyInfo($goods_info);

            //如果未进行抢购，则再判断是否限时折扣中
            if (!$goods_info['ifgroupbuy']) {
                $goods_info = $model_cart->getXianshiInfo($goods_info,$quantity);
            } else {
                //这里记录一下抢购数量，订单完成后需要更新一下抢购表信息
                $groupbuy_info = array();
                $groupbuy_info['groupbuy_id'] = $goods_info['groupbuy_id'];
                $groupbuy_info['quantity'] = $quantity;
            }

            //转成多维数组，方便统一使用购物车方法与模板
            $store_cart_list = array();
            $goods_list = array();
            $goods_list[0] = $store_cart_list[$goods_info['store_id']][0] = $goods_info;
        }

        //商品金额计算(分别对每个商品/优惠套装小计、每个店铺小计)
        list($store_cart_list,$store_goods_total) = $model_cart->calcCartList($store_cart_list);

        //取得店铺优惠 - 满即送(赠品列表，店铺满送规则列表)
        list($store_premiums_list,$store_mansong_rule_list) = $model_cart->getMansongRuleCartListByTotal($store_goods_total);

        //重新计算店铺扣除满即送后商品实际支付金额
        $store_final_goods_total = $model_cart->reCalcGoodsTotal($store_goods_total,$store_mansong_rule_list,'mansong');

        //得到有效的代金券
        $input_voucher_list = $model_cart->reParseVoucherList($input_voucher_list,$store_goods_total,$member_id);

        //重新计算店铺扣除优惠券送商品实际支付金额
        $store_final_goods_total = $model_cart->reCalcGoodsTotal($store_final_goods_total,$input_voucher_list,'voucher');

        //计算每个店铺(所有店铺级优惠活动)总共优惠多少
        $store_promotion_total = $this->getStorePromotionTotal($store_goods_total, $store_final_goods_total);

        //计算每个店铺运费
        list($need_calc_sid_list,$cancel_calc_sid_list) = $this->getStoreFreightDescList($store_final_goods_total);
        $freight_list = $this->getStoreFreightList($goods_list,array_keys($cancel_calc_sid_list));
        $store_freight_total = $this->calcStoreFreight($freight_list,$input_city_id);

        //计算店铺最终订单实际支付金额(加上运费)
        $store_final_order_total = $model_cart->reCalcGoodsTotal($store_final_goods_total,$store_freight_total,'freight');

        //计算店铺分类佣金
        $store_gc_id_commis_rate_list = $this->getStoreGcidCommisRateList($goods_list);

        //将赠品追加到购买列表(如果库存不足，则不送赠品)
        $append_premiums_to_cart_list = $this->appendPremiumsToCartList($store_cart_list,$store_premiums_list,$store_mansong_rule_list,$member_id);
        if(!empty($append_premiums_to_cart_list['error'])) {
            return array('error' => $append_premiums_to_cart_list['error']);
        } else {
            list($store_cart_list,$goods_buy_quantity,$store_mansong_rule_list) = $append_premiums_to_cart_list;
        }

        //整理已经得出的固定数据，准备下单
        $input = array();
        $input['pay_name'] = $input_pay_name;
        $input['if_offpay'] = $input_if_offpay;
        $input['if_vat'] = $input_if_vat;
        $input['pay_message'] = $post['pay_message'];
        $input['address_info'] = $input_address_info;
        $input['invoice_info'] = $input_invoice_info;
        $input['voucher_list'] = $input_voucher_list;
        $input['store_goods_total'] = $store_goods_total;
        $input['store_final_order_total'] = $store_final_order_total;
        $input['store_freight_total'] = $store_freight_total;
        $input['store_promotion_total'] = $store_promotion_total;
        $input['store_gc_id_commis_rate_list'] = $store_gc_id_commis_rate_list;
        $input['store_mansong_rule_list'] = $store_mansong_rule_list;
        $input['store_cart_list'] = $store_cart_list;
	$input['input_city_id'] = $input_city_id;//货到付款 by 3 3 hao.com

        try {

            //开始事务
            $model_cart->beginTransaction();

            //生成订单
            list($pay_sn,$order_list) = $this->createOrder($input, $member_id, $member_name, $member_email);

            //记录订单日志
            $this->addOrderLog($order_list);

            //变更库存和销量
            $this->updateGoodsStorageNum($goods_buy_quantity);

            //使用预存款支付
            $this->pdPay($order_list, $post, $member_id, $member_name);

            //提交事务
            $model_cart->commit();

        }catch (Exception $e){

            //回滚事务
            $model_cart->rollback();
            return array('error' => $e->getMessage());
        }

        //更新使用的代金券状态
        if (!empty($input_voucher_list) && is_array($input_voucher_list)) {
            QueueClient::push('editVoucherState', $input_voucher_list);
        }

        //更新抢购购买人数和数量
        if (!empty($groupbuy_info) && is_array($groupbuy_info)) {
            QueueClient::push('editGroupbuySaleCount', $groupbuy_info);
        }

        //更新收货人所在省份
        QueueClient::push('editReciverProid', array('order_ids'=>array_keys($order_list),'area_id'=>$input_city_id));
 
        //删除购物车中的商品
        if ($post['ifcart']) {
            $model_cart->delCart('db',array('buyer_id'=>$member_id,'cart_id'=>array('in',array_keys($input_buy_items))));
//             QueueClient::push('delCart', array('buyer_id'=>$member_id,'cart_ids'=>array_keys($input_buy_items)));
        }

        return array('pay_sn' => $pay_sn);
    }

    /**
     * 加密
     * @param array/string $string
     * @param int $member_id
     * @return mixed arrray/string
     */
    public function buyEncrypt($string, $member_id) {
        $buy_key = sha1(md5($member_id.'&'.MD5_KEY));
	    if (is_array($string)) {
	       $string = serialize($string);
	    } else {
	        $string = strval($string);
	    }
	    return encrypt(base64_encode($string), $buy_key);
    }

	/**
	 * 解密
	 * @param string $string
     * @param int $member_id
	 * @param number $ttl
     */
    public function buyDecrypt($string, $member_id, $ttl = 0) {
        $buy_key = sha1(md5($member_id.'&'.MD5_KEY));
	    if (empty($string)) return;
	    $string = base64_decode(decrypt(strval($string), $buy_key, $ttl));
	    return ($tmp = @unserialize($string)) ? $tmp : $string;
    }

    /**
     * 得到所购买的id和数量
     *
     */
    private function _parseItems($cart_id) {
        //存放所购商品ID和数量组成的键值对
        $buy_items = array();
        if (is_array($cart_id)) {
            foreach ($cart_id as $value) {
                if (preg_match_all('/^(\d{1,10})\|(\d{1,6})$/', $value, $match)) {
                    $buy_items[$match[1][0]] = $match[2][0];
                }
            }
        }
        return $buy_items;
    }

    /**
     * 选择不同地区时，异步处理并返回每个店铺总运费以及本地区是否能使用货到付款
     * 如果店铺统一设置了满免运费规则，则运费模板无效
     * 如果店铺未设置满免规则，且使用运费模板，按运费模板计算，如果其中有商品使用相同的运费模板，则两种商品数量相加后再应用该运费模板计算（即作为一种商品算运费）
     * 如果未找到运费模板，按免运费处理
     * 如果没有使用运费模板，商品运费按快递价格计算，运费不随购买数量增加
     */
    public function changeAddr($freight_hash, $city_id, $area_id, $member_id) {
    	//$city_id计算运费模板,$area_id计算货到付款
        $city_id = intval($city_id);
        $area_id = intval($area_id);
        if ($city_id <= 0 || $area_id <= 0) return null;

    	//将hash解密，得到运费信息(店铺ID，运费,运费模板ID,购买数量),hash内容有效期为1小时
    	$freight_list = $this->buyDecrypt($freight_hash, $member_id);

    	//算运费
    	$store_freight_list = $this->calcStoreFreight($freight_list, $city_id);
    	$data = array();
    	$data['state'] = empty($store_freight_list) ? 'fail' : 'success';
    	$data['content'] = $store_freight_list;

    	//是否能使用货到付款(只有包含平台店铺的商品才会判断)
    	$if_include_platform_store = array_key_exists(DEFAULT_PLATFORM_STORE_ID,$freight_list['iscalced']) || array_key_exists(DEFAULT_PLATFORM_STORE_ID,$freight_list['nocalced']);
    	if ($if_include_platform_store) {
    	    $allow_offpay = Model('offpay_area')->checkSupportOffpay($area_id,DEFAULT_PLATFORM_STORE_ID);
    	}
    	//JS验证使用
    	$data['allow_offpay'] = $allow_offpay ? '1' : '0';
        //PHP验证使用
        $data['offpay_hash'] = $this->buyEncrypt($allow_offpay ? 'allow_offpay' : 'deny_offpay', $member_id);

        return $data;
    }

}
