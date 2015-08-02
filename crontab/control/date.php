<?php
/**
 * 任务计划 - 天执行的任务
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class dateControl extends BaseCronControl {

    /**
     * 该文件中所有任务执行频率，默认1天，单位：秒
     * @var int
     */
    const EXE_TIMES = 86400;
    
    /**
     * 优惠券即将到期提醒时间，单位：天
     * @var int
     */
    const VOUCHER_INTERVAL = 5;
    /**
     * 兑换码即将到期提醒时间，单位：天
     * @var int
     */
    const VR_CODE_INTERVAL = 5;
    /**
     * 订单结束后可评论时间，15天，60*60*24*15
     * @var int
     */
    const ORDER_EVALUATE_TIME = 1296000;

    /**
     * 每次到货通知消息数量
     * @var int
     */
    const ARRIVAL_NOTICE_NUM = 100;

    /**
     * 默认方法
     */
    public function indexOp() {

        //更新订单商品佣金值
        $this->_order_commis_rate_update();

        //订单超期后不允许评价
        $this->_order_eval_expire_update();

        //未付款订单超期自动关闭
        $this->_order_timeout_cancel();

         //增加会员积分和经验值
//         $this->_add_points();

        //订单自动完成
        $this->_order_auto_complete();

        //自提点中，已经关闭的订单删除
        $this->_order_delivery_cancel_del();

        //更新订单扩展表收货人所在省份ID
        $this->_order_reciver_provinceid_update();

        //更新退款申请超时处理
        Model('trade')->editRefundConfirm();

        //代金券即将过期提醒
        $this->_voucher_will_expire();

        //虚拟兑换码即将过期提醒
        $this->_vr_code_will_expire();

        //更新商品访问量
        $this->_goods_click_update();

        //更新商品促销到期状态
        $this->_goods_promotion_state_update();

        //商品到货通知提醒
        $this->_arrival_notice();

        //更新浏览量
        $this->_goods_browse_update();

        //缓存订单及订单商品相关数据
        $this->_order_goods_cache();

        //会员相关数据统计
        $this->_member_stat();
    }

    /**
     * 未付款订单超期自动关闭
     */
    private function _order_timeout_cancel() {

        //实物订单超期未支付系统自动关闭
        $_break = false;
        $model_order = Model('order');
        $logic_order = Logic('order');
        $condition = array();
        $condition['order_state'] = ORDER_STATE_NEW;
        $condition['add_time'] = array('lt',TIMESTAMP - ORDER_AUTO_CANCEL_DAY * self::EXE_TIMES);
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++){
            if ($_break) {
                break;
            }
            $order_list = $model_order->getOrderList($condition, '', '*', '', 100);
            if (empty($order_list)) break;
            foreach ($order_list as $order_info) {
                $result = $logic_order->changeOrderStateCancel($order_info,'system','系统','超期未支付系统自动关闭订单',true,false);
                if (!$result['state']) {
                    $this->log('实物订单超期未支付关闭失败SN:'.$order_info['order_sn']); $_break = true; break;
                }
            }
        }

        //虚拟订单超期未支付系统自动关闭
        $_break = false;
        $model_vr_order = Model('vr_order');
        $logic_vr_order = Logic('vr_order');
        $condition = array();
        $condition['order_state'] = ORDER_STATE_NEW;
        $condition['add_time'] = array('lt',TIMESTAMP - ORDER_AUTO_CANCEL_DAY * self::EXE_TIMES);

        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++){
            if ($_break) {
                break;
            }
            $order_list = $model_vr_order->getOrderList($condition, '', '*', '',100);
            if (empty($order_list)) break;
            foreach ($order_list as $order_info) {
                $result = $logic_vr_order->changeOrderStateCancel($order_info,'system','超期未支付系统自动关闭订单',false);
            }
            if (!$result['state']) {
                $this->log('虚拟订单超期未支付关闭失败SN:'.$order_info['order_sn']); $_break = true; break;
            }
        }
    }
    
    /**
     * 订单自动完成
     */
    private function _order_auto_complete() {

        //虚拟订单过使用期自动完成
        $_break = false;
        $model_order = Model('vr_order');
        $logic_order = Logic('vr_order');
        $condition = array();
        $condition['order_state'] = ORDER_STATE_PAY;
        $condition['vr_indate'] = array('lt',TIMESTAMP);
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++){
            if ($_break) {
                break;
            }
            $order_list = $model_order->getOrderList($condition, '', 'order_id,order_sn', 'vr_indate asc', 100);
            if (empty($order_list)) break;
            foreach ($order_list as $order_info) {
                $result = $logic_order->changeOrderStateSuccess($order_info['order_id']);
                if (!$result['state']) {
                    $this->log('虚拟订单过使用期自动完成失败SN:'.$order_info['order_sn']); $_break = true; break;
                }
            }
        }

        //实物订单发货后，超期自动收货完成
        $_break = false;
        $model_order = Model('order');
        $logic_order = Logic('order');
        $condition = array();
        $condition['order_state'] = ORDER_STATE_SEND;
        $condition['lock_state'] = 0;
        $condition['delay_time'] = array('lt',TIMESTAMP - ORDER_AUTO_RECEIVE_DAY * 86400);
        //分批，每批处理100个订单，最多处理5W个订单
        for ($i = 0; $i < 500; $i++){
            if ($_break) {
                break;
            }
            $order_list = $model_order->getOrderList($condition, '', '*', 'delay_time asc', 100);
            if (empty($order_list)) break;
            foreach ($order_list as $order_info) {
                $result = $logic_order->changeOrderStateReceive($order_info,'system','系统','超期未收货系统自动完成订单');
                if (!$result['state']) {
                    $this->log('实物订单超期未收货自动完成订单失败SN:'.$order_info['order_sn']); $_break = true; break;
                }
            }
        }
    }

    /**
     * 自提订单中，已经关闭订单的，删除
     */
    private function _order_delivery_cancel_del() {
        $model_delivery = Model('delivery_order');
        $model_order = Model('order');

        for($i = 0; $i < 10; $i++) {
            $delivery_list = $model_delivery->getDeliveryOrderDefaultList(array(), '*', 0, 'order_id asc', 100);
            if (!empty($delivery_list)) {
                $order_ids = array();
                foreach ($delivery_list as $k => $v) {
                    $order_ids[] = $v['order_id'];
                }
                $condition = array();
                $condition['order_state'] = ORDER_STATE_CANCEL;
                $condition['order_id'] = array('in',$order_ids);
                $order_list = $model_order->getOrderList($condition,'','order_id');
                if (!empty($order_list)) {
                    $order_ids = array();
                    foreach ($order_list as $k => $v) {
                        $order_ids[] = $v['order_id'];
                    }
                    $del = $model_delivery->delDeliveryOrder(array('order_id'=>array('in',$order_ids)));
                    if (!del) {
                        $this->log('删除自提点订单失败');
                    }
                } else {
                    break;
                }
            } else {
                break;
            }
        }
    }
    
    /**
     * 更新订单扩展表中收货人所在省份ID
     */
    private function _order_reciver_provinceid_update() {
        $model_order = Model('order');
        $model_area = Model('area');

        //每次最多处理5W个订单
        $condition = array();
        $condition['reciver_province_id'] = 0;
        $condition['reciver_city_id'] = array('neq',0);
        for($i = 0; $i < 500; $i++) {
            $order_list = $model_order->getOrderCommonList($condition, 'reciver_city_id','order_id desc', 100);
            if (!empty($order_list)) {
                $city_ids = array();
                foreach ($order_list as $v) {
                    if (!in_array($v['reciver_city_id'],$city_ids)) {
                        $city_ids[] = $v['reciver_city_id'];
                    }
                }
                $area_list = $model_area->getAreaList(array('area_id'=>array('in',$city_ids)),'area_parent_id,area_id');
                if (!empty($area_list)) {
                    foreach ($area_list as $v) {
                        $update = $model_order->editOrderCommon(array('reciver_province_id'=>$v['area_parent_id']),array('reciver_city_id'=>$v['area_id']));
                        if (!$update) {
                            $this->log('更新订单扩展表中收货人所在省份ID失败');break;
                        }
                    }
                }
            } else {
                break;
            }
        }
    }

    /**
     * 增加会员积分和经验值
     */
    private function _add_points() {
        return;
        $model_points = Model('points');
        $model_exppoints = Model('exppoints');

        //24小时之内登录的会员送积分和经验值,每次最多处理5W个会员
        $model_member = Model('member');
        $condition = array();
        $condition['member_login_time'] = array('gt',TIMESTAMP - self::EXE_TIMES);
        for($i = 0; $i < 50000; $i=$i+100) {
            $member_list = $model_member->getMemberList($condition, 'member_name,member_id',0,'', "{$i},100");
            if (!empty($member_list)) {
                foreach ($member_list as $member_info) {
                    if (C('points_isuse')) {
                        $model_points->savePointsLog('login',array('pl_memberid'=>$member_info['member_id'],'pl_membername'=>$member_info['member_name']),true);
                    }
                    $model_exppoints->saveExppointsLog('login',array('exp_memberid'=>$member_info['member_id'],'exp_membername'=>$member_info['member_name']),true);
                    
                }
            } else {
                break;
            }
        }

       //24小时之内注册的会员送积分,每次最多处理5W个会员
       if (C('points_isuse')) {
           $condition = array();
           $condition['member_time'] = array('gt',TIMESTAMP - self::EXE_TIMES);
           for($i = 0; $i < 50000; $i=$i+100) {
               $member_list = $model_member->getMemberList($condition, 'member_name,member_id',0,'member_id desc', "{$i},100");
               if (!empty($member_list)) {
                   foreach ($member_list as $member_info) {
                       $model_points->savePointsLog('regist',array('pl_memberid'=>$member_info['member_id'],'pl_membername'=>$member_info['member_name']),true);
                   }
               } else {
                   break;
               }
           }
       }

        //24小时之内完成了实物订单送积分和经验值,每次最多处理5W个订单
        $model_order = Model('order');
        $condition = array();
        $condition['finnshed_time'] = array('gt',TIMESTAMP - self::EXE_TIMES);
        for($i = 0; $i < 50000; $i=$i+100) {
            $order_list = $model_order->getOrderList($condition,'','buyer_name,buyer_id,order_amount,order_sn,order_id','', "{$i},100");
            if (!empty($order_list)) {
                foreach ($order_list as $order_info) {
                    if (C('points_isuse')) {
                        $model_points->savePointsLog('order',array('pl_memberid'=>$order_info['buyer_id'],'pl_membername'=>$order_info['buyer_name'],'orderprice'=>$order_info['order_amount'],'order_sn'=>$order_info['order_sn'],'order_id'=>$order_info['order_id']),true);
                    }
                    $model_exppoints->saveExppointsLog('order',array('exp_memberid'=>$order_info['buyer_id'],'exp_membername'=>$order_info['buyer_name'],'orderprice'=>$order_info['order_amount'],'order_sn'=>$order_info['order_sn'],'order_id'=>$order_info['order_id']),true);
                }
            } else {
                break;
            }
        }

        //24小时之内完成了实物订单送积分和经验值,每次最多处理5W个订单
        $model_order = Model('vr_order');
        $condition = array();
        $condition['finnshed_time'] = array('gt',TIMESTAMP - self::EXE_TIMES);
        for($i = 0; $i < 50000; $i=$i+100) {
            $order_list = $model_order->getOrderList($condition,'','buyer_name,buyer_id,order_amount,order_sn,order_id','', "{$i},100");
            if (!empty($order_list)) {
                foreach ($order_list as $order_info) {
                    if (C('points_isuse')) {
                        $model_points->savePointsLog('order',array('pl_memberid'=>$order_info['buyer_id'],'pl_membername'=>$order_info['buyer_name'],'orderprice'=>$order_info['order_amount'],'order_sn'=>$order_info['order_sn'],'order_id'=>$order_info['order_id']),true);
                    }
                    $model_exppoints->saveExppointsLog('order',array('exp_memberid'=>$order_info['buyer_id'],'exp_membername'=>$order_info['buyer_name'],'orderprice'=>$order_info['order_amount'],'order_sn'=>$order_info['order_sn'],'order_id'=>$order_info['order_id']),true);
                }
            } else {
                break;
            }
        }
    }
    
    /**
     * 代金券即将过期提醒
     */
    private function _voucher_will_expire() {
        $time_start = mktime(0, 0, 0, date("m")  , date("d")+self::VOUCHER_INTERVAL, date("Y"));
        $time_stop = $time_start + self::EXE_TIMES - 1;
        $where = array();
        $where['voucher_end_date'] = array(array('egt', $time_start), array('elt', $time_stop), 'and');
        $list = Model('voucher')->getVoucherUnusedList($where);
        if (!empty($list)) {
            foreach ($list as $val) {
                $param = array();
                $param['code'] = 'voucher_will_expire';
                $param['member_id'] = $val['voucher_owner_id'];
                $param['param'] = array(
                    'indate' => date('Y-m-d H:i:s', $val['voucher_end_date']),
                    'voucher_url' => urlShop('member_voucher', 'index')
                );
                QueueClient::push('sendMemberMsg', $param);
            }
        }
    }
    
    /**
     * 虚拟兑换码即将过期提醒
     */
    private function _vr_code_will_expire() {
        $time_start = mktime(0, 0, 0, date("m")  , date("d")+self::VR_CODE_INTERVAL, date("Y"));
        $time_stop = $time_start + self::EXE_TIMES - 1;
        $where = array();
        $where['vr_indate'] = array(array('egt', $time_start), array('elt', $time_stop), 'and');
        $list = Model('vr_order')->getCodeUnusedList($where);
        if (!empty($list)) {
            foreach ($list as $val) {
                $param = array();
                $param['code'] = 'vr_code_will_expire';
                $param['member_id'] = $val['buyer_id'];
                $param['param'] = array(
                    'indate' => date('Y-m-d H:i:s', $val['vr_indate']),
                    'vr_order_url' => urlShop('member_vr_order', 'index')
                );
                QueueClient::push('sendMemberMsg', $param);
            }
        }
    }

    /**
     * 订单超期后不允许评价
     */
    private function _order_eval_expire_update() {

        //实物订单超期未评价自动更新状态，每次最多更新1000个订单
        $model_order = Model('order');
        $condition = array();
        $condition['order_state'] = ORDER_STATE_SUCCESS;
        $condition['evaluation_state'] = 0;
        $condition['finnshed_time'] = array('lt',TIMESTAMP - self::ORDER_EVALUATE_TIME);
        $update = array();
        $update['evaluation_state'] = 2;
        $update = $model_order->editOrder($update,$condition,1000);
        if (!$update) {
            $this->log('更新实物订单超期不能评价失败');break;
        }

        //虚拟订单超期未评价自动更新状态，每次最多更新1000个订单
        $model_order = Model('vr_order');
        $condition = array();
        $condition['order_state'] = ORDER_STATE_SUCCESS;
        $condition['evaluation_state'] = 0;
        $condition['use_state'] = 1;
        $condition['finnshed_time'] = array('lt',TIMESTAMP - self::ORDER_EVALUATE_TIME);
        $update = array();
        $update['evaluation_state'] = 2;
        $update = $model_order->editOrder($update,$condition,1000);
        if (!$update) {
            $this->log('更新虚拟订单超期不能评价失败');break;
        }
    }

    /**
     * 更新商品访问量(redis)
     */
    private function _goods_click_update() {
        $data = rcache('updateRedisDate', 'goodsClick');
        foreach ($data as $key => $val) {
            Model('goods')->editGoodsById(array('goods_click' => array('exp', 'goods_click +'.$val)), $key);
        }
        dcache('updateRedisDate', 'goodsClick');
    }

    /**
     * 更新商品促销到期状态(目前只有满即送)
     */
    private function _goods_promotion_state_update() {
        //满即送过期
        Model('p_mansong')->editExpireMansong();
    }

    /**
     * 商品到货通知提醒
     */
    private function _arrival_notice() {
        $strat_time = strtotime("-30 day"); // 只通知最近30天的记录
    
        $model_arrtivalnotice = Model('arrival_notice');
        // 删除30天之前的记录
        $model_arrtivalnotice->delArrivalNotice(array('an_addtime' => array('lt', $strat_time), 'an_type' => 1));
    
        $count = $model_arrtivalnotice->getArrivalNoticeCount(array());
        $times = ceil($count/self::ARRIVAL_NOTICE_NUM);
        if ($times == 0) return false;
        for ($i = 0; $i <= $times; $i++) {
    
            $notice_list = $model_arrtivalnotice->getArrivalNoticeList(array(), '*', $i.','.self::ARRIVAL_NOTICE_NUM);
            if (empty($notice_list)) continue;
    
            // 查询商品是否已经上架
            $goodsid_array = array();
            foreach ($notice_list as $val) {
                $goodsid_array[] = $val['goods_id'];
            }
            $goodsid_array = array_unique($goodsid_array);
            $goods_list = Model('goods')->getGoodsOnlineList(array('goods_id' => array('in', $goodsid_array), 'goods_storage' => array('gt', 0)), 'goods_id');
            if (empty($goods_list)) continue;
    
            // 需要通知到货的商品
            $goodsid_array = array();
            foreach ($goods_list as $val) {
                $goodsid_array[] = $val['goods_id'];
            }
    
            // 根据商品id重新查询需要通知的列表
            $notice_list = $model_arrtivalnotice->getArrivalNoticeList(array('goods_id' => array('in', $goodsid_array)), '*');
            if (empty($notice_list)) continue;
    
            foreach ($notice_list as $val) {
                $param = array();
                $param['code'] = 'arrival_notice';
                $param['member_id'] = $val['member_id'];
                $param['param'] = array(
                        'goods_name' => $val['goods_name'],
                        'goods_url' => urlShop('goods', 'index', array('goods_id' => $val['goods_id']))
                );
                $param['number'] = array('mobile' => $val['an_mobile'], 'email' => $val['an_email']);
                QueueClient::push('sendMemberMsg', $param);
            }
    
            // 清楚发送成功的数据
            $model_arrtivalnotice->delArrivalNotice(array('goods_id' => array('in', $goodsid_array)));
        }
    }

    /**
     * 将缓存中的浏览记录存入数据库中，并删除30天前的浏览历史
     */
    private function _goods_browse_update(){
        $model = Model('goods_browse');
        //将cache中的记录存入数据库
        if (C('cache_open')){//如果浏览记录已经存入了缓存中，则将其整理到数据库中
            //上次更新缓存的时间
            $latest_record = $model->getGoodsbrowseOne(array(),'','browsetime desc');
            $starttime = ($t = intval($latest_record['browsetime']))?$t:0;
            $monthago = strtotime(date('Y-m-d',time())) - 86400*30;
            $model_member = Model('member');
    
            //查询会员信息总条数
            $countnum = $model_member->getMemberCount(array());
            $eachnum = 100;
            for ($i=0; $i<$countnum; $i+=$eachnum){//每次查询100条
                $member_list = $model_member->getMemberList(array(), '*', 0, 'member_id asc', "$i,$eachnum");
                foreach ((array)$member_list as $k=>$v){
                    $insert_arr = array();
                    $goodsid_arr = array();
                    //生成缓存的键值
                    $hash_key = $v['member_id'];
                    $browse_goodsid = rcache($hash_key,'goodsbrowse','goodsid');
    
                    if ($browse_goodsid) {
                        //删除缓存中多余的浏览历史记录，仅保留最近的30条浏览历史，先取出最近30条浏览历史的商品ID
                        $cachegoodsid_arr = $browse_goodsid['goodsid']?unserialize($browse_goodsid['goodsid']):array();
                        unset($browse_goodsid['goodsid']);
    
                        if ($cachegoodsid_arr){
                            $cachegoodsid_arr = array_slice($cachegoodsid_arr,-30,30,true);
                        }
                        //处理存入数据库的浏览历史缓存信息
                        $_cache = rcache($hash_key, 'goodsbrowse');
                        foreach((array)$_cache as $c_k=>$c_v){
                            $c_v = unserialize($c_v);
                            if ($c_v['browsetime'] >= $starttime){//如果 缓存中的数据未更新到数据库中（即添加时间大于上次更新到数据库中的数据时间）则将数据更新到数据库中
                                $tmp_arr = array();
                                $tmp_arr['goods_id'] = $c_v['goods_id'];
                                $tmp_arr['member_id'] = $v['member_id'];
                                $tmp_arr['browsetime'] = $c_v['browsetime'];
                                $tmp_arr['gc_id'] = $c_v['gc_id'];
                                $tmp_arr['gc_id_1'] = $c_v['gc_id_1'];
                                $tmp_arr['gc_id_2'] = $c_v['gc_id_2'];
                                $tmp_arr['gc_id_3'] = $c_v['gc_id_3'];
                                $insert_arr[] = $tmp_arr;
                                $goodsid_arr[] = $c_v['goods_id'];
                            }
                            //除了最近的30条浏览历史之外多余的浏览历史记录或者30天之前的浏览历史从缓存中删除
                            if (!in_array($c_v['goods_id'], $cachegoodsid_arr) || $c_v['browsetime'] < $monthago){
                                unset($_cache[$c_k]);
                            }
                        }
                        //删除已经存在的该商品浏览记录
                        if ($goodsid_arr){
                            $model->delGoodsbrowse(array('member_id'=>$v['member_id'],'goods_id'=>array('in',$goodsid_arr)));
                        }
                        //将缓存中的浏览历史存入数据库
                        if ($insert_arr){
                            $model->addGoodsbrowseAll($insert_arr);
                        }
                        //重新赋值浏览历史缓存
                        dcache($hash_key, 'goodsbrowse');
                        $_cache['goodsid'] = serialize($cachegoodsid_arr);
                        wcache($hash_key,$_cache,'goodsbrowse');
                    }
                }
            }
        }
        //删除30天前的浏览历史
        $model->delGoodsbrowse(array('browsetime'=>array('lt',$monthago)));
    }

    /**
     * 缓存订单及订单商品相关数据
     */
    private function _order_goods_cache(){
        $model = Model('stat');
        //查询最后统计的记录
        $latest_record = $model->table('stat_ordergoods')->order('stat_updatetime desc,rec_id desc')->find();
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

            for ($i=0; $i<$countnum; $i+=100){//每次查询100条
                $orderlog_list = array();
                $orderlog_list = $model->table('order_log')->field('DISTINCT order_id')->where($where)->limit($i.',100')->select();
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
                    $order_list_tmp = $model->table('order')->field($field)->where(array('order_id'=>array('in',$orderid_arr)))->select();
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
                    $order_common_list_tmp = $model->table('order_common')->field($field)->where(array('order_id'=>array('in',$orderid_arr)))->select();
                    $order_common_list = array();
                    foreach ((array)$order_common_list_tmp as $k=>$v){
                        $order_common_list[$v['order_id']] = $v;
                    }
                    unset($order_common_list_tmp);
    
                    //查询店铺信息
                    $field = 'store_id,store_name,grade_id,sc_id';
                    $store_list_tmp = $model->table('store')->field($field)->where(array('store_id'=>array('in',$storeid_arr)))->select();
                    $store_list = array();
                    foreach ((array)$store_list_tmp as $k=>$v){
                        $store_list[$v['store_id']] = $v;
                    }
                    unset($store_list_tmp);
    
                    //查询订单商品
                    $field = 'rec_id,order_id,goods_id,goods_name,goods_price,goods_num,goods_image,goods_pay_price,store_id,buyer_id,goods_type,promotions_id,commis_rate,gc_id';
                    $ordergoods_list = $model->table('order_goods')->field($field)->where(array('order_id'=>array('in',$orderid_arr)))->select();
                    foreach ((array)$ordergoods_list as $k=>$v){
                        $goodsid_arr[] = $v['goods_id'];
                    }
    
                    //查询商品信息
                    $field = 'goods_id,goods_commonid,goods_price,goods_serial,gc_id,gc_id_1,gc_id_2,gc_id_3,goods_image';
                    $goods_list_tmp = $model->table('goods')->field($field)->where(array('goods_id'=>array('in',$goodsid_arr)))->select();
                    foreach ((array)$goods_list_tmp as $k=>$v){
                        $goods_commonid_arr[] = $v['goods_commonid'];
                    }
    
                    //查询商品公共信息
                    $field = 'goods_commonid,goods_name,brand_id,brand_name';
                    $goods_common_list_tmp = $model->table('goods_common')->field($field)->where(array('goods_commonid'=>array('in',$goods_commonid_arr)))->select();
                    $goods_common_list = array();
                    foreach ((array)$goods_common_list_tmp as $k=>$v){
                        $goods_common_list[$v['goods_commonid']] = $v;
                    }
                    unset($goods_common_list_tmp);
    
                    //处理商品数组
                    $goods_list = array();
    
                    foreach ((array)$goods_list_tmp as $k=>$v){
                        $v['goods_commonname'] = $goods_common_list[$v['goods_commonid']]['goods_name'];
                        $v['brand_id'] = $goods_common_list[$v['goods_commonid']]['brand_id'];
                        $v['brand_name'] = $goods_common_list[$v['goods_commonid']]['brand_name'];
                        $goods_list[$v['goods_id']] = $v;
                    }
                    unset($goods_list_tmp);
    
                    //查询订单缓存是否存在，存在则删除
                    $model->table('stat_ordergoods')->where(array('order_id'=>array('in',$orderid_arr)))->delete();
                    //查询订单缓存是否存在，存在则删除
                    $model->table('stat_order')->where(array('order_id'=>array('in',$orderid_arr)))->delete();
    
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
                        $tmp['order_amount'] = $order_list[$v['order_id']]['order_amount'];
                        $tmp['shipping_fee'] = $order_list[$v['order_id']]['shipping_fee'];
                        $tmp['evaluation_state'] = $order_list[$v['order_id']]['evaluation_state'];
                        $tmp['order_state'] = $order_list[$v['order_id']]['order_state'];
                        $tmp['refund_state'] = $order_list[$v['order_id']]['refund_state'];
                        $tmp['refund_amount'] = $order_list[$v['order_id']]['refund_amount'];
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
                        $tmp['goods_commonid'] = intval($goods_list[$v['goods_id']]['goods_commonid']);
                        $tmp['goods_commonname'] = ($t = $goods_list[$v['goods_id']]['goods_commonname'])?$t:'';
                        $tmp['gc_id'] = intval($goods_list[$v['goods_id']]['gc_id']);
                        $tmp['gc_parentid_1'] = intval($goods_list[$v['goods_id']]['gc_id_1']);
                        $tmp['gc_parentid_2'] = intval($goods_list[$v['goods_id']]['gc_id_2']);
                        $tmp['gc_parentid_3'] = intval($goods_list[$v['goods_id']]['gc_id_3']);
                        $tmp['brand_id'] = intval($goods_list[$v['goods_id']]['brand_id']);
                        $tmp['brand_name'] = ($t = $goods_list[$v['goods_id']]['brand_name'])?$t:'';
                        $tmp['goods_serial'] = ($t = $goods_list[$v['goods_id']]['goods_serial'])?$t:'';
                        $tmp['goods_price'] = $v['goods_price'];
                        $tmp['goods_num'] = $v['goods_num'];
                        $tmp['goods_image'] = $goods_list[$v['goods_id']]['goods_image'];
                        $tmp['goods_pay_price'] = $v['goods_pay_price'];
                        $tmp['goods_type'] = $v['goods_type'];
                        $tmp['promotions_id'] = $v['promotions_id'];
                        $tmp['commis_rate'] = $v['commis_rate'];
                        $ordergoods_insert_arr[] = $tmp;
                    }
                    $model->table('stat_ordergoods')->insertAll($ordergoods_insert_arr);
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
                    $model->table('stat_order')->insertAll($order_insert_arr);
                }
            }
        }
    }
    
    /**
     * 会员相关数据统计
     */
    private function _member_stat(){
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
}