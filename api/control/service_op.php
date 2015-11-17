<?php
/**
 * 服务操作 api
 */
defined('InShopNC') or exit('Access Invalid!');

class service_opControl extends apiMemberControl
{

    private $member_id;

    public function __construct()
    {
        parent::__construct();
        $this->member_id = $this->member_info['member_id'];
    }

    /**
     * 预约
     */
    public function createOrderOp()
    {
        $mod_order = Model('service_yuyue');
        $data = array();
        $data['yuyue_member_id'] = $this->member_id;
        $data['yuyue_service_id'] = trim($_POST['service_id']);
        $data['yuyue_company_id'] = trim($_POST['company_id']);
        $data['yuyue_content'] = $_POST['remark'];
        $data['yuyue_Auditing_status'] = 0;
        $data['yuyue_Complete_status'] = 1;
        $data['yuyue_pay_way'] = trim($_POST['pay_way']);
        $data['yuyue_start_time'] = trim($_POST['start_time']);
        $data['yuyue_end_time'] = trim($_POST['end_time']);
        $data['yuyue_time'] = time();
        //  生成订单号
        $data['yuyue_pay_number'] = $this->makePaySn($this->member_id);

        if($mod_order->save($data)) {
            echo 1;
        }else{
            echo 0;
        }
    }

    /**
     * 生成支付单编号(两位随机 + 从2000-01-01 00:00:00 到现在的秒数+微秒+会员ID%1000)，该值会传给第三方支付接口
     * 长度 =2位 + 10位 + 3位 + 3位  = 18位
     * 1000个会员同一微秒提订单，重复机率为1/100
     * @return string
     */
    private function makePaySn($member_id) {
        return mt_rand(10,99)
        . sprintf('%010d',time() - 946656000)
        . sprintf('%03d', (float) microtime() * 1000)
        . sprintf('%03d', (int) $member_id % 1000);
    }

    /**
     * POST 收藏服务
     */
    public function favServiceOp()
    {

    }

    /**
     * POST 取消收藏
     */
    public function canelFavTradeOp()
    {

    }

    /**
     * GET 收藏状态
     *
     */
    public function isFavOp()
    {

    }
}