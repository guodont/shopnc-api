<?php
/**
 * 任务计划 - 统计数据缓存
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class statControl {

    public function __construct(){
        register_shutdown_function(array($this,"shutdown"));
    }
    /**
     * 统计数据缓存
     */
    public function indexOp(){
        //缓存订单及订单商品相关数据
        $this->cron_ordergoods();
        //会员相关数据缓存
        $this->memberstat();
        //店铺分类及店铺缓存
        //$this->storeclass();
        //更新商品表旧数据的分类ID
        $this->update_goodsgc();
    }
    
    /**
     * 更新商品表父级分类ID
     */
    public function update_goodsgc(){
        $gc_list = H('goods_class') ? H('goods_class') : H('goods_class', true);
        $goodscommon_list = Model()->table('goods_common')->field('goods_commonid,gc_id')->limit(false)->select();
        foreach ($goodscommon_list as $k=>$v){
            //处理分类信息，分类的一二级
            $gc_depth = $gc_list[$v['gc_id']]['depth'];
		    $parent_gcidarr = array();
		    $gc_id = $v['gc_id'];
		    for ($i=$gc_depth; $i>0; $i--){
		        $parent_gcidarr[$i] = $gc_id;
		        $gc_id = $gc_list[$gc_id]['gc_parent_id'];
		    }
		    $update = array();
		    $update['gc_id_1'] = $parent_gcidarr[1]?$parent_gcidarr[1]:0;
		    $update['gc_id_2'] = $parent_gcidarr[2]?$parent_gcidarr[2]:0;
		    $update['gc_id_3'] = $parent_gcidarr[3]?$parent_gcidarr[3]:0;
		    Model()->table('goods_common')->where(array('goods_commonid'=>$v['goods_commonid']))->update($update);
		    Model()->table('goods')->where(array('goods_commonid'=>$v['goods_commonid']))->update($update);
        }
    }

	/**
     * 缓存订单及订单商品相关数据
     */
    private function cron_ordergoods(){
        $model = Model('stat');
        //查询最后统计的记录
        $latest_record = Model()->table('stat_ordergoods')->order('stat_updatetime desc,rec_id desc')->find();
        $stime = 0;
        if ($latest_record){
            $start_time = strtotime(date('Y-m-d',$latest_record['stat_updatetime']));
        } else {
            $start_time = strtotime(date('Y-m-d',strtotime(C('setup_date'))));//从系统的安装时间开始统计
        }
        for ($stime = $start_time; $stime < time(); $stime = $stime+86400){
            $etime = $stime + 86400 - 1;
            //避免重复统计，开始时间必须大于最后一条记录的记录时间
            $search_stime = $latest_record['stat_updatetime'] > $stime?$latest_record['stat_updatetime']:$stime;
            //统计一天的数据，如果结束时间大于当前时间，则结束时间为当前时间，避免因为查询时间的延迟造成数据遗落
            $search_etime = ($t = ($stime + 86400 - 1)) > time() ? time() : ($stime + 86400 - 1);
            
            //查询时间段内新订单或者更新过的订单，在缓存表中需要将新订单和更新过的订单进行重新缓存
            $where = array();
            $where['log_time'] = array('between',array($search_stime,$search_etime));
            
            //查询记录总条数
            $countnum_arr = $model->table('order_log')->field('COUNT(DISTINCT order_id) as countnum')->where($where)->find();
            $countnum = intval($countnum_arr['countnum']);
            
            $field = 'DISTINCT order_id';
            for ($i=0; $i<$countnum; $i+=100){//每次查询100条
                $orderlog_list = array();
                $orderlog_list = Model()->table('order_log')->field($field)->where($where)->limit($i.',100')->select();
                if ($orderlog_list){
                    //店铺ID数组
                    $storeid_arr = array();
                    
                    //商品ID数组
                    $goodsid_arr = array();
                    
                    //商品公共表ID数组
                    $goods_commonid_arr = array();
                    
                    //订单ID数组
                    $orderid_arr = array();
                    
                    //整理需要缓存的订单ID
                    foreach ((array)$orderlog_list as $k=>$v){
                        $orderid_arr[] = $v['order_id'];
                    }
                    unset($orderlog_list);
                    
                    //查询订单数据
                    $field = 'order_id,order_sn,store_id,buyer_id,buyer_name,add_time,payment_code,order_amount,shipping_fee,evaluation_state,order_state,refund_state,refund_amount,order_from';
                    $order_list_tmp = Model()->table('order')->field($field)->where(array('order_id'=>array('in',$orderid_arr)))->select();
                    $order_list = array();
                    foreach ((array)$order_list_tmp as $k=>$v){
                        //判读订单是否计入统计（在线支付订单已支付或者经过退款的取消订单或者货到付款订单订单已成功）
                        $v['order_isvalid'] = 0;
		                if ($v['payment_code'] != 'offline' && $v['order_state'] != ORDER_STATE_NEW && $v['order_state'] != ORDER_STATE_CANCEL){//在线支付并且已支付并且未取消
		                    $v['order_isvalid'] = 1;
		                } elseif ($v['order_state'] == ORDER_STATE_CANCEL && $v['refund_state'] != 0) {//经过退款的取消订单
		                    $v['order_isvalid'] = 1;
		                } elseif ($v['payment_code'] == 'offline' && $v['order_state'] == ORDER_STATE_SUCCESS) {//货到付款订单，订单成功之后才计入统计
		                    $v['order_isvalid'] = 1;
		                }
                        $order_list[$v['order_id']] = $v;
                        $storeid_arr[] = $v['store_id'];
                    }
                    unset($order_list_tmp);
                    
                    //查询订单扩展数据
                    $field = 'order_id,reciver_province_id';
                    $order_common_list_tmp = Model()->table('order_common')->field($field)->where(array('order_id'=>array('in',$orderid_arr)))->select();
                    $order_common_list = array();
                    foreach ((array)$order_common_list_tmp as $k=>$v){
                        $order_common_list[$v['order_id']] = $v;
                    }
                    unset($order_common_list_tmp);
                    
                    //查询店铺信息
                    $field = 'store_id,store_name,grade_id,sc_id';
                    $store_list_tmp = Model()->table('store')->field($field)->where(array('store_id'=>array('in',$storeid_arr)))->select();
                    $store_list = array();
                    foreach ((array)$store_list_tmp as $k=>$v){
                        $store_list[$v['store_id']] = $v;
                    }
                    unset($store_list_tmp);
                    
                    //查询订单商品
                    $field = 'rec_id,order_id,goods_id,goods_name,goods_price,goods_num,goods_image,goods_pay_price,store_id,buyer_id,goods_type,promotions_id,commis_rate,gc_id';
                    $ordergoods_list = Model()->table('order_goods')->field($field)->where(array('order_id'=>array('in',$orderid_arr)))->select();
                    foreach ((array)$ordergoods_list as $k=>$v){
                        $goodsid_arr[] = $v['goods_id'];
                    }
                    
                    //查询商品信息
                    $field = 'goods_id,goods_commonid,goods_price,goods_serial,gc_id,goods_image';
                    $goods_list_tmp = Model()->table('goods')->field($field)->where(array('goods_id'=>array('in',$goodsid_arr)))->select();
                    foreach ((array)$goods_list_tmp as $k=>$v){
                        $goods_commonid_arr[] = $v['goods_commonid'];
                    }
                    
                    //查询商品公共信息
                    $field = 'goods_commonid,goods_name,brand_id,brand_name';
                    $goods_common_list_tmp = Model()->table('goods_common')->field($field)->where(array('goods_commonid'=>array('in',$goods_commonid_arr)))->select();
                    $goods_common_list = array();
                    foreach ((array)$goods_common_list_tmp as $k=>$v){
                        $goods_common_list[$v['goods_commonid']] = $v;
                    }
                    unset($goods_common_list_tmp);
                    
                    //处理商品数组
                    $goods_list = array();
                    $gc_list = H('goods_class') ? H('goods_class') : H('goods_class', true);
                    
                    foreach ((array)$goods_list_tmp as $k=>$v){
                        $v['goods_commonname'] = $goods_common_list[$v['goods_commonid']]['goods_name'];
                        $v['brand_id'] = $goods_common_list[$v['goods_commonid']]['brand_id'];
                        $v['brand_name'] = $goods_common_list[$v['goods_commonid']]['brand_name'];
                        //处理分类信息，分类的一二级
                        $gc_depth = $gc_list[$v['gc_id']]['depth'];
            		    $parent_gcidarr = array();
            		    $gc_id = $v['gc_id'];
            		    for ($i=$gc_depth; $i>0; $i--){
            		        $parent_gcidarr[$i] = $gc_id;
            		        $gc_id = $gc_list[$gc_id]['gc_parent_id'];
            		    }
            		    $v['gc_parentid_1'] = $parent_gcidarr[1]?$parent_gcidarr[1]:0;
            		    $v['gc_parentid_2'] = $parent_gcidarr[2]?$parent_gcidarr[2]:0;
            		    $v['gc_parentid_3'] = $parent_gcidarr[3]?$parent_gcidarr[3]:0;
                        $goods_list[$v['goods_id']] = $v;
                    }
                    unset($goods_list_tmp);
                    
                    //查询订单缓存是否存在，存在则删除
                    Model()->table('stat_ordergoods')->where(array('order_id'=>array('in',$orderid_arr)))->delete();
                    //查询订单缓存是否存在，存在则删除
                    Model()->table('stat_order')->where(array('order_id'=>array('in',$orderid_arr)))->delete();
                    
                    //整理新增数据
                    $ordergoods_insert_arr = array();
                    foreach ((array)$ordergoods_list as $k=>$v){
                        $tmp = array();
                        $tmp['rec_id'] = $v['rec_id'];
                        $tmp['stat_updatetime'] = $search_etime;
                        $tmp['order_id'] = $v['order_id'];
                        $tmp['order_sn'] = $order_list[$v['order_id']]['order_sn'];
                        $tmp['order_add_time'] = $order_list[$v['order_id']]['add_time'];
                        $tmp['payment_code'] = $order_list[$v['order_id']]['payment_code'];
                        $tmp['order_state'] = $order_list[$v['order_id']]['order_state'];
                        $tmp['refund_state'] = $order_list[$v['order_id']]['refund_state'];
                        $tmp['order_from'] = $order_list[$v['order_id']]['order_from'];
                        $tmp['order_isvalid'] = $order_list[$v['order_id']]['order_isvalid'];
                        $tmp['reciver_province_id'] = $order_common_list[$v['order_id']]['reciver_province_id'];
                        $tmp['store_id'] = $v['store_id'];
                        $tmp['store_name'] = $store_list[$v['store_id']]['store_name'];
                        $tmp['grade_id'] = $store_list[$v['store_id']]['grade_id'];
                        $tmp['sc_id'] = $store_list[$v['store_id']]['sc_id'];
                        $tmp['buyer_id'] = $order_list[$v['order_id']]['buyer_id'];
                        $tmp['buyer_name'] = $order_list[$v['order_id']]['buyer_name'];
                        $tmp['goods_id'] = $v['goods_id'];
                        $tmp['goods_name'] = $v['goods_name'];
                        $tmp['goods_commonid'] = $goods_list[$v['goods_id']]['goods_commonid'];
                        $tmp['goods_commonname'] = $goods_list[$v['goods_id']]['goods_commonname'];
                        $tmp['gc_id'] = $goods_list[$v['goods_id']]['gc_id'];
                        $tmp['gc_parentid_1'] = $goods_list[$v['goods_id']]['gc_parentid_1'];
                        $tmp['gc_parentid_2'] = $goods_list[$v['goods_id']]['gc_parentid_2'];
                        $tmp['brand_id'] = $goods_list[$v['goods_id']]['brand_id'];
                        $tmp['brand_name'] = $goods_list[$v['goods_id']]['brand_name'];
                        $tmp['goods_serial'] = $goods_list[$v['goods_id']]['goods_serial'];
                        $tmp['goods_price'] = $goods_list[$v['goods_id']]['goods_price'];
                        $tmp['goods_num'] = $v['goods_num'];
                        $tmp['goods_image'] = $goods_list[$v['goods_id']]['goods_image'];
                        $tmp['goods_pay_price'] = $v['goods_pay_price'];
                        $tmp['goods_type'] = $v['goods_type'];
                        $tmp['promotions_id'] = $v['promotions_id'];
                        $tmp['commis_rate'] = $v['commis_rate'];
                        $ordergoods_insert_arr[] = $tmp;
                    }
                    Model()->table('stat_ordergoods')->insertAll($ordergoods_insert_arr);
                    $order_insert_arr = array();
                    foreach ((array)$order_list as $k=>$v){
                        $tmp = array();
                        $tmp['order_id'] = $v['order_id'];
                        $tmp['order_sn'] = $v['order_sn'];
                        $tmp['order_add_time'] = $v['add_time'];
                        $tmp['payment_code'] = $v['payment_code'];
                        $tmp['order_amount'] = $v['order_amount'];
                        $tmp['shipping_fee'] = $v['shipping_fee'];
                        $tmp['evaluation_state'] = $v['evaluation_state'];
                        $tmp['order_state'] = $v['order_state'];
                        $tmp['refund_state'] = $v['refund_state'];
                        $tmp['refund_amount'] = $v['refund_amount'];
                        $tmp['order_from'] = $v['order_from'];
                        $tmp['order_isvalid'] = $v['order_isvalid'];
                        $tmp['reciver_province_id'] = $order_common_list[$v['order_id']]['reciver_province_id'];
                        $tmp['store_id'] = $v['store_id'];
                        $tmp['store_name'] = $store_list[$v['store_id']]['store_name'];
                        $tmp['grade_id'] = $store_list[$v['store_id']]['grade_id'];
                        $tmp['sc_id'] = $store_list[$v['store_id']]['sc_id'];
                        $tmp['buyer_id'] = $v['buyer_id'];
                        $tmp['buyer_name'] = $v['buyer_name'];
                        $order_insert_arr[] = $tmp;
                    }
                    Model()->table('stat_order')->insertAll($order_insert_arr);
                }
    		}
        }
    }
	/**
     * 会员相关数据统计
     */
    public function memberstat(){
        $model = Model('stat');
        //查询最后统计的记录
        $latest_record = $model->getOneStatmember(array(), '', 'statm_id desc');
        $stime = 0;
        if ($latest_record){
            $start_time = strtotime(date('Y-m-d',$latest_record['statm_updatetime']));
        } else {
            $start_time = strtotime(date('Y-m-d',strtotime(C('setup_date'))));//从系统的安装时间开始统计
        }
        $j = 1;
        for ($stime = $start_time; $stime < time(); $stime = $stime+86400){
            //数据库更新数据数组
            $insert_arr = array();
            $update_arr = array();
            
            $etime = $stime + 86400 - 1;
            //避免重复统计，开始时间必须大于最后一条记录的记录时间
            $search_stime = $latest_record['statm_updatetime'] > $stime?$latest_record['statm_updatetime']:$stime;
            //统计一天的数据，如果结束时间大于当前时间，则结束时间为当前时间，避免因为查询时间的延迟造成数据遗落
            $search_etime = ($t = ($stime + 86400 - 1)) > time() ? time() : ($stime + 86400 - 1);
            
            //统计订单下单量和下单金额
            $field = ' order.order_id,add_time,buyer_id,buyer_name,order_amount';
            $where = array();
            $where['order.order_state'] = array('neq',ORDER_STATE_NEW);//去除未支付订单
            $where['order.refund_state'] = array('exp',"!(order.order_state = '".ORDER_STATE_CANCEL."' and order.refund_state = 0)");//没有参与退款的取消订单，不记录到统计中
            $where['order_log.log_time'] = array('between',array($search_stime,$search_etime));//按照订单付款的操作时间统计
            //货到付款当交易成功进入统计，非货到付款当付款后进入统计
            $where['payment_code'] = array('exp',"(order.payment_code='offline' and order_log.log_orderstate = '".ORDER_STATE_SUCCESS."') or (order.payment_code<>'offline' and order_log.log_orderstate = '".ORDER_STATE_PAY."' )");
            $orderlist_tmp = $model->statByOrderLog($where, $field, 0, 0, 'order_id');//此处由于底层的限制，仅能查询1000条，如果日下单量大于1000，则需要limit的支持
            
            $order_list = array();
            $orderid_list = array();
            foreach ((array)$orderlist_tmp as $k=>$v){
                $addtime = strtotime(date('Y-m-d',$v['add_time']));
                if ($addtime != $stime){//订单如果隔天支付的话，需要进行统计数据更新
                    $update_arr[$addtime][$v['buyer_id']]['statm_membername'] = $v['buyer_name'];
                    $update_arr[$addtime][$v['buyer_id']]['statm_ordernum'] = intval($update_arr[$addtime][$v['buyer_id']]['statm_ordernum'])+1;
                    $update_arr[$addtime][$v['buyer_id']]['statm_orderamount'] = floatval($update_arr[$addtime][$v['buyer_id']]['statm_orderamount']) + (($t = floatval($v['order_amount'])) > 0?$t:0);
                } else {
                    $order_list[$v['buyer_id']]['buyer_name'] = $v['buyer_name'];
                    $order_list[$v['buyer_id']]['ordernum'] = intval($order_list[$v['buyer_id']]['ordernum']) + 1;
                    $order_list[$v['buyer_id']]['orderamount'] = floatval($order_list[$v['buyer_id']]['orderamount']) + (($t = floatval($v['order_amount'])) > 0?$t:0);
                }
                //记录订单ID数组
                $orderid_list[] = $v['order_id'];
            }
            
            //统计下单商品件数
            if ($orderid_list){
                $field = ' add_time,order.buyer_id,order.buyer_name,goods_num ';
                $where = array();
                $where['order.order_id'] = array('in',$orderid_list);
                $ordergoods_tmp = $model->statByOrderGoods($where, $field, 0, 0, 'order.order_id');
                $ordergoods_list = array();
                foreach ((array)$ordergoods_tmp as $k=>$v){
                    $addtime = strtotime(date('Y-m-d',$v['add_time']));
                    if ($addtime != $stime){//订单如果隔天支付的话，需要进行统计数据更新
                        $update_arr[$addtime][$v['buyer_id']]['statm_goodsnum'] = intval($update_arr[$addtime][$v['buyer_id']]['statm_goodsnum']) + (($t = floatval($v['goods_num'])) > 0?$t:0);
                    } else {
                        $ordergoods_list[$v['buyer_id']]['goodsnum'] = $ordergoods_list[$v['buyer_id']]['goodsnum'] + (($t = floatval($v['goods_num'])) > 0?$t:0);
                    }
                }
            }
            
            //统计的预存款记录
            $field = ' lg_member_id,lg_member_name,SUM(IF(lg_av_amount>=0,lg_av_amount,0)) as predincrease, SUM(IF(lg_av_amount<=0,lg_av_amount,0)) as predreduce ';
            $where = array();
            $where['lg_add_time'] = array('between',array($stime,$etime));
            $predeposit_tmp = $model->getPredepositInfo($where, $field, 0, 'lg_member_id', 0, 'lg_member_id');
            $predeposit_list = array();
            foreach ((array)$predeposit_tmp as $k=>$v){
                $predeposit_list[$v['lg_member_id']] = $v;
            }
            
            //统计的积分记录
            $field = ' pl_memberid,pl_membername,SUM(IF(pl_points>=0,pl_points,0)) as pointsincrease, SUM(IF(pl_points<=0,pl_points,0)) as pointsreduce ';
            $where = array();
            $where['pl_addtime'] = array('between',array($stime,$etime));
            $points_tmp = $model->statByPointslog($where, $field, 0, 0, '', 'pl_memberid');
            $points_list = array();
            foreach ((array)$points_tmp as $k=>$v){
                $points_list[$v['pl_memberid']] = $v;
            }
            
            //处理需要更新的数据
            foreach ((array)$update_arr as $k=>$v){
                foreach ($v as $m_k=>$m_v){
                    //查询记录是否存在
                    $statmember_info = $model->getOneStatmember(array('statm_time'=>$k,'statm_memberid'=>$m_k));
                    if ($statmember_info){
                        $m_v['statm_ordernum'] = intval($statmember_info['statm_ordernum']) + $m_v['statm_ordernum'];
                        $m_v['statm_orderamount'] = floatval($statmember_info['statm_ordernum']) + $m_v['statm_orderamount'];
                        $m_v['statm_updatetime'] = $search_etime;
                        $model->updateStatmember(array('statm_time'=>$k,'statm_memberid'=>$m_k),$m_v);
                    } else {
                        $tmp = array();
                        $tmp['statm_memberid'] = $m_k;
                        $tmp['statm_membername'] = $m_v['statm_membername'];
                        $tmp['statm_time'] = $k;
                        $tmp['statm_updatetime'] = $search_etime;
                        $tmp['statm_ordernum'] = ($t = intval($m_v['statm_ordernum'])) > 0?$t:0;
                        $tmp['statm_orderamount'] = ($t = floatval($m_v['statm_orderamount']))>0?$t:0;
                        $tmp['statm_goodsnum'] = ($t = intval($m_v['statm_goodsnum']))?$t:0;
                        $tmp['statm_predincrease'] = 0;
                        $tmp['statm_predreduce'] = 0;
                        $tmp['statm_pointsincrease'] = 0;
                        $tmp['statm_pointsreduce'] = 0;
                        $insert_arr[] = $tmp;
                    }
                    unset($statmember_info);
                }
            }
            
            //处理获得所有会员ID数组
            $memberidarr_order = $order_list?array_keys($order_list):array();
            $memberidarr_ordergoods = $ordergoods_list?array_keys($ordergoods_list):array();
            $memberidarr_predeposit = $predeposit_list?array_keys($predeposit_list):array();
            $memberidarr_points = $points_list?array_keys($points_list):array();
            $memberid_arr = array_merge($memberidarr_order,$memberidarr_ordergoods,$memberidarr_predeposit,$memberidarr_points);
            //查询会员信息
            $memberid_list = Model('member')->getMemberList(array('member_id'=>array('in',$memberid_arr)), '', 0);
            //查询记录是否存在
            $statmemberlist_tmp = $model->statByStatmember(array('statm_time'=>$stime));
            $statmemberlist = array();
            foreach ((array)$statmemberlist_tmp as $k=>$v){
                $statmemberlist[$v['statm_memberid']] = $v;
            }
            foreach ((array)$memberid_list as $k=>$v){
                $tmp = array();
                $tmp['statm_memberid'] = $v['member_id'];
                $tmp['statm_membername'] = $v['member_name'];
                $tmp['statm_time'] = $stime;
                $tmp['statm_updatetime'] = $search_etime;
                //因为记录可能已经存在，所以加上之前的统计记录
                $tmp['statm_ordernum'] = intval($statmemberlist[$tmp['statm_memberid']]['statm_ordernum']) + (($t = intval($order_list[$tmp['statm_memberid']]['ordernum'])) > 0?$t:0);
                $tmp['statm_orderamount'] = floatval($statmemberlist[$tmp['statm_memberid']]['statm_orderamount']) + (($t = floatval($order_list[$tmp['statm_memberid']]['orderamount']))>0?$t:0);
                $tmp['statm_goodsnum'] = intval($statmemberlist[$tmp['statm_memberid']]['statm_goodsnum']) + (($t = intval($ordergoods_list[$tmp['statm_memberid']]['goodsnum']))?$t:0);
                $tmp['statm_predincrease'] = (($t = floatval($predeposit_list[$tmp['statm_memberid']]['predincrease']))?$t:0);
                $tmp['statm_predreduce'] = (($t = floatval($predeposit_list[$tmp['statm_memberid']]['predreduce']))?$t:0);
                $tmp['statm_pointsincrease'] = (($t = intval($points_list[$tmp['statm_memberid']]['pointsincrease']))?$t:0);
                $tmp['statm_pointsreduce'] = (($t = intval($points_list[$tmp['statm_memberid']]['pointsreduce']))?$t:0);
                $insert_arr[] = $tmp;
            }
            //删除旧的统计数据
            $model->delByStatmember(array('statm_time'=>$stime));
            $model->table('stat_member')->insertAll($insert_arr);
        }
    }

    /**
     * 执行完成提示信息
     *
     */
    public function shutdown(){
        exit("success at ".date('Y-m-d H:i:s',TIMESTAMP)."\n");
    }
}