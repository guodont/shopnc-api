<?php
/**
 * 任务计划 - 分钟执行的任务
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class minutesControl extends BaseCronControl {

    /**
     * 默认方法
     */
    public function indexOp() {
        $this->_cron_common();
        $this->_web_index_update();
        $this->_cron_mail_send();
    }

    /**
     * 更新首页的商品价格信息
     */
    private function _web_index_update(){
         Model('web_config')->updateWebGoods();
    }

    /**
     * 发送邮件消息
     */
    private function _cron_mail_send() {
        //每次发送数量
        $_num = 50;
        $model_storemsgcron = Model('mail_cron');
        $cron_array = $model_storemsgcron->getMailCronList(array(), $_num);
        if (!empty($cron_array)) {
            $email = new Email();
            $mail_array = array();
            foreach ($cron_array as $val) {
                $return = $email->send_sys_email($val['mail'],$val['subject'],$val['contnet']);
                if ($return) {
                    // 记录需要删除的id
                    $mail_array[] = $val['mail_id'];
                }
            }
            // 删除已发送的记录
            $model_storemsgcron->delMailCron(array('mail_id' => array('in', $mail_array)));
        }
    }

    /**
     * 执行通用任务
     */
    private function _cron_common(){

        //查找待执行任务
        $model_cron = Model('cron');
        $cron = $model_cron->getCronList(array('exetime'=>array('elt',TIMESTAMP)));
        if (!is_array($cron)) return ;
        $cron_array = array(); $cronid = array();
        foreach ($cron as $v) {
            $cron_array[$v['type']][$v['exeid']] = $v;
        }
        foreach ($cron_array as $k=>$v) {
            // 如果方法不存是，直接删除id
            if (!method_exists($this,'_cron_'.$k)) {
                $tmp = current($v);
                $cronid[] = $tmp['id'];continue;
            }
            $result = call_user_func_array(array($this,'_cron_'.$k),array($v));
            if (is_array($result)){
                $cronid = array_merge($cronid,$result);
            }
        }
        //删除执行完成的cron信息
        if (!empty($cronid) && is_array($cronid)){
            $model_cron->delCron(array('id'=>array('in',$cronid)));
        }
    }

    /**
     * 上架
     *
     * @param array $cron
     */
    private function _cron_1($cron = array()){
        $condition = array('goods_commonid' => array('in',array_keys($cron)));
        $update = Model('goods')->editProducesOnline($condition);
        if ($update){
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        }else{
            return false;
        }
        return $cronid;
    }

    /**
     * 根据商品id更新商品促销价格
     *
     * @param array $cron
     */
    private function _cron_2($cron = array()){
        $condition = array('goods_id' => array('in',array_keys($cron)));
        $update = Model('goods')->editGoodsPromotionPrice($condition);
        if ($update){
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        }else{
            return false;
        }
        return $cronid;
    }

    /**
     * 优惠套装过期
     *
     * @param array $cron
     */
    private function _cron_3($cron = array()) {
        $condition = array('store_id' => array('in', array_keys($cron)));
        $update = Model('p_bundling')->editBundlingQuotaClose($condition);
        if ($update) {
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        } else {
            return false;
        }
        return $cronid;
    }

    /**
     * 推荐展位过期
     *
     * @param array $cron
     */
    private function _cron_4($cron = array()) {
        $condition = array('store_id' => array('in', array_keys($cron)));
        $update = Model('p_booth')->editBoothClose($condition);
        if ($update) {
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        } else {
            return false;
        }
        return $cronid;
    }

    /**
     * 抢购开始更新商品促销价格
     *
     * @param array $cron
     */
    private function _cron_5($cron = array()) {
        $condition = array();
        $condition['goods_commonid'] = array('in', array_keys($cron));
        $condition['start_time'] = array('lt', TIMESTAMP);
        $condition['end_time'] = array('gt', TIMESTAMP);
        $groupbuy = Model('groupbuy')->getGroupbuyList($condition);
        foreach ($groupbuy as $val) {
            Model('goods')->editGoods(array('goods_promotion_price' => $val['groupbuy_price'], 'goods_promotion_type' => 1), array('goods_commonid' => $val['goods_commonid']));
        }
        //返回执行成功的cronid
        $cronid = array();
        foreach ($cron as $v) {
            $cronid[] = $v['id'];
        }
        return $cronid;
    }

    /**
     * 抢购过期
     *
     * @param array $cron
     */
    private function _cron_6($cron = array()) {
        $condition = array('goods_commonid' => array('in', array_keys($cron)));
        //抢购活动过期
        $update = Model('groupbuy')->editExpireGroupbuy($condition);
        if ($update){
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        }else{
            return false;
        }
        return $cronid;
    }

    /**
     * 限时折扣过期
     *
     * @param array $cron
     */
    private function _cron_7($cron = array()) {
        $condition = array('xianshi_id' => array('in', array_keys($cron)));
        //限时折扣过期
        $update = Model('p_xianshi')->editExpireXianshi($condition);
        if ($update){
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        }else{
            return false;
        }
        return $cronid;
    }
}