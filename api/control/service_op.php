<?php
/**
 * 服务操作 api
 */
defined('InShopNC') or exit('Access Invalid!');

require_once('../core/framework/libraries/vendor/pingpp/init.php');

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
        $mod_order = Model('service_yuyue_api');
        $data = array();
        $data['yuyue_member_id'] = $this->member_id;
        $data['yuyue_service_id'] = trim($_POST['service_id']);
        $data['yuyue_company_id'] = trim($_POST['company_id']);
        $data['yuyue_company'] = $_POST['company'];
        $data['yuyue_member_name'] = $this->member_info['member_name'];
        $data['yuyue_content'] = $_POST['remark'];
        $data['yuyue_status'] = 0;
        $data['yuyue_pay_way'] = trim($_POST['pay_way']);
        $data['yuyue_start_time'] = trim($_POST['start_time']);
        $data['yuyue_end_time'] = trim($_POST['end_time']);
        $data['yuyue_time'] = time();
        //  生成订单号
        $data['yuyue_pay_number'] = $this->makePaySn($this->member_id);

        if ($mod_order->save($data)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /**
     * 生成支付单编号(两位随机 + 从2000-01-01 00:00:00 到现在的秒数+微秒+会员ID%1000)，该值会传给第三方支付接口
     * 长度 =2位 + 10位 + 3位 + 3位  = 18位
     * 1000个会员同一微秒提订单，重复机率为1/100
     * @return string
     */
    private function makePaySn($member_id)
    {
        return mt_rand(10, 99)
        . sprintf('%010d', time() - 946656000)
        . sprintf('%03d', (float)microtime() * 1000)
        . sprintf('%03d', (int)$member_id % 1000);
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
    public function cancelFavTradeOp()
    {

    }

    /**
     * GET 收藏状态
     *
     */
    public function isFavOp()
    {

    }

    public function myOrdersOp()
    {
        $model = new Model();
        $mod_order = $model->table('service_yuyue');
        $where = array();
        $where['service_yuyue.yuyue_member_id'] = $this->member_id;
        $orders = $model->table('service_yuyue,service')->join('right join')->on('service_yuyue.yuyue_service_id=service.service_id')->where($where)->page($this->page)->order('yuyue_time desc')->select();
        $pageCount = $mod_order->gettotalpage();
        output_data(array('yuyues' => $orders), mobile_page($pageCount));
    }

    public function updateOrderOp()
    {

    }

    /**
     * 支付订单1
     */
    public function payOrderStep1Op()
    {
        \Pingpp\Pingpp::setApiKey('sk_test_vP8WX9KKG4CSmfDGCSPm1WTO');
        $mod_order = Model('service_yuyue_api');
        $mod_service = Model('service');
        //获取appId
        $appId = $_POST['appId'];
        $yuyueId = $_GET['yuyue_id'];
        //根据服务预约id找出记录
        $where['yuyue_id'] = $yuyueId;
        $order = $mod_order->getOne($where);
        $serviceId = $order['yuyue_service_id'];
        $service = $mod_service->getOne(array('service_id' => $serviceId));
        //取出支付订单id
        $orderId = $order['yuyue_pay_number'];
        //取出订单金额
        $amount = $service['service_now_price'] * 100;
        //取出交易名称
        $orderName = "[科研助手]" . $service['service_name'];
        //交易描述
        $orderDesc = $service['service_name'];
        //获取请求ip
        $clientIp = "";
        //获取支付方式
        $channel = $_POST['channel'];
//        'app_u1yjzHbvvLeLybbT'
        $extra = array();
        try {
            $ch = \Pingpp\Charge::create(
                array(
                    'order_no' => $orderId,
                    'app' => array('id' => $appId),
                    'channel' => 'alipay',
                    'amount' => $amount,
                    'client_ip' => $clientIp,
                    'currency' => 'cny',
                    'subject' => $orderName,
                    'body' => $orderDesc,
                    'extra' => $extra
                )
            );
            echo $ch;
        } catch (\Pingpp\Error\Base $e) {
            header('Status: ' . $e->getHttpStatus());
            echo($e->getHttpBody());
        }
    }

    /**
     * 支付订单2
     */
    public function payOrderStep2Op()
    {
        //  调取Ping++ webholks
    }
}