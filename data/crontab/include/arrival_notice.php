<?php
/**
 * 商品到货通知提醒
 * 
 * 建议每天触发一次
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class arrival_noticeControl {
    private $_num = 100; // 每次通知消息数量
    
    /**
     * 初始化对象
     */
    public function __construct(){
        register_shutdown_function(array($this,"shutdown"));
    }
    
    /**
     * 通知
     */
    public function indexOp() {
        $strat_time = strtotime("-30 day"); // 只通知最近30天的记录
        
        $model_arrtivalnotice = Model('arrival_notice');
        $count = $model_arrtivalnotice->getArrivalNoticeCount(array());
        $times = ceil($count/$this->_num);
        if ($times == 0) return false;
        for ($i = 0; $i <= $times; $i++) {
            // 删除30天之前的记录
            $model_arrtivalnotice->delArrivalNotice(array('an_addtime' => array('lt', $strat_time)));
            
            $notice_list = $model_arrtivalnotice->getArrivalNoticeList(array(), '*', $i.','.$this->_num);
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
                QueueClient::push('sendMemberMsg', $param);
            }
            
            // 清楚发送成功的数据
            $model_arrtivalnotice->delArrivalNotice(array('goods_id' => array('in', $goodsid_array)));
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