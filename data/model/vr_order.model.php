<?php
/**
 * 虚拟订单模型
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class vr_orderModel extends Model {

    /**
     * 取单条订单信息
     *
     * @param array $condition
     * @return unknown
     */
    public function getOrderInfo($condition = array(), $fields = '*', $master = false) {
        $order_info = $this->table('vr_order')->field($fields)->where($condition)->master($master)->find();
        if (empty($order_info)) {
            return array();
        }
        if (isset($order_info['order_state'])) {
            $order_info['state_desc'] = $this->_orderState($order_info['order_state']);
            $order_info['state_desc'] = $order_info['state_desc'][0];
        }
        if (isset($order_info['payment_code'])) {
            $order_info['payment_name'] = orderPaymentName($order_info['payment_code']);
        }
        return $order_info;
    }

    /**
     * 新增订单
     * @param array $data
     * @return int 返回 insert_id
     */
    public function addOrder($data) {
        $insert = $this->table('vr_order')->insert($data);
        return $insert;
    }

    /**
     * 生成兑换码
     * @param array $order_info
     * @return int 返回 insert_id
     */
    public function addOrderCode($order_info) {
	// 好商 城提供二次开发
	$vrc_num=Model()->table('vr_order_code')->where(array('order_id'=>$order_info['order_id']))->count();
	if (!empty($vrc_num)&&intval($vrc_num)>=intval($order_info['goods_num']))
	return false;
  
        if (empty($order_info)) return false;

        //均摊后每个兑换码支付金额
        $each_pay_price = number_format($order_info['order_amount']/$order_info['goods_num'],2);

        //取得店铺兑换码前缀
        $store_info = Model('store')->getStoreInfoByID($order_info['store_id']);
        $virtual_code_perfix = $store_info['store_vrcode_prefix'] ? $store_info['store_vrcode_prefix'] : rand(100,999);

        //生成兑换码
        $code_list = $this->_makeVrCode($virtual_code_perfix, $order_info['store_id'], $order_info['buyer_id'], $order_info['goods_num']);

        for ($i=0; $i < $order_info['goods_num']; $i++) {
            $order_code[$i]['order_id'] = $order_info['order_id'];
            $order_code[$i]['store_id'] = $order_info['store_id'];
            $order_code[$i]['buyer_id'] = $order_info['buyer_id'];
            $order_code[$i]['vr_code'] = $code_list[$i];
            $order_code[$i]['pay_price'] = $each_pay_price;
            $order_code[$i]['vr_indate'] = $order_info['vr_indate'];
            $order_code[$i]['vr_invalid_refund'] = $order_info['vr_invalid_refund'];
        }

        //将因舍出小数部分出现的差值补到最后一个商品的实际成交价中
//         $diff_amount = $order_info['order_amount'] - $each_pay_price * $order_info['goods_num'];
//         $order_code[$i-1]['pay_price'] += $diff_amount;

        return $this->table('vr_order_code')->insertAll($order_code);
    }

    /**
     * 更改订单信息
     *
     * @param array $data
     * @param array $condition
     */
    public function editOrder($data, $condition, $limit = '') {
        return $this->table('vr_order')->where($condition)->limit($limit)->update($data);
    }

    /**
     * 更新兑换码
     * @param unknown $data
     * @param unknown $condition
     */
    public function editOrderCode($data, $condition) {
        return $this->table('vr_order_code')->where($condition)->update($data);
    }

    /**
     * 兑换码列表
     * @param unknown $condition
     * @param string $fields
     */
    public function getCodeList($condition = array(), $fields = '*', $pagesize = '',$order = 'rec_id desc',$limit = '', $group = '') {
        return $this->table('vr_order_code')->field($fields)->where($condition)->page($pagesize)->order($order)->limit($limit)->group($group)->select();
    }

    /**
     * 兑换码列表
     * @param unknown $condition
     * @param string $fields
     */
    public function getCodeUnusedList($condition = array(), $fields = '*', $pagesize = '',$order = 'rec_id desc',$limit = '') {
        $condition['vr_state'] = 0;
        $condition['refund_lock'] = 0;
        return $this->getCodeList($condition, $fields, $pagesize, $order, $limit, 'order_id');
    }

	/**
	 * 根据虚拟订单取没有使用的兑换码列表
	 *
	 * @param
	 * @return array
	 */
	public function getCodeRefundList($order_list = array()) {
	    if (!empty($order_list) && is_array($order_list)) {
	        $order_ids = array();//订单编号数组
    	    foreach ($order_list as $key => $value) {
    	        $order_id = $value['order_id'];
    	        $order_ids[$order_id] = $key;
    	    }
    	    $condition = array();
    	    $condition['order_id'] = array('in', array_keys($order_ids));
    	    $condition['refund_lock'] = '0';//退款锁定状态:0为正常(能退款),1为锁定(待审核),2为同意
    	    $code_list = $this->getCodeList($condition);
    	    if (!empty($code_list) && is_array($code_list)) {
        	    foreach ($code_list as $key => $value) {
        	        $order_id = $value['order_id'];//虚拟订单编号
        	        $rec_id = $value['rec_id'];//兑换码表编号
        	        if ($value['vr_state'] != '1') {//使用状态 0:未使用1:已使用2:已过期
        	            $order_key = $order_ids[$order_id];
        	            $order_list[$order_key]['code_list'][$rec_id] = $value;
        	        }
        	    }
    	    }
	    }
		return $order_list;
    }

    /**
     * 取得兑换码列表
     * @param unknown $condition
     * @param string $fields
     */
    public function getOrderCodeList($condition = array(), $fields = '*') {
        $code_list = $this->getCodeList($condition);
        //进一步处理
        if (!empty($code_list)) {
            $i = 0;
            foreach ($code_list as $k => $v) {
                if ($v['vr_state'] == '1') {
                    $content = '已使用，使用时间 '.date('Y-m-d',$v['vr_usetime']);
                } else if ($v['vr_state'] == '0') {
                    if ($v['vr_indate'] < TIMESTAMP) {
                        $content = '已过期，过期时间 '.date('Y-m-d',$v['vr_indate']);
                    } else {
                        $content = '未使用，有效期至 '.date('Y-m-d',$v['vr_indate']);
                    }
                }
                if ($v['refund_lock'] == '1') {
                    $content = '退款审核中';
                } else if ($v['refund_lock'] == '2') {
                    $content = '退款已完成';
                }
                $code_list[$k]['vr_code_desc'] = $content;
                if ($v['vr_state'] == '0') $i++;
            }
            $code_list[0]['vr_code_valid_count'] = $i;
        }
        return $code_list;
    }

    /**
     * 取得兑换码信息
     * @param unknown $condition
     * @param string $fields
     */
    public function getOrderCodeInfo($condition = array(), $fields = '*',$master = false) {
        return $this->table('vr_order_code')->field($fields)->where($condition)->master($master)->find();
    }

    /**
     * 取得兑换码数量
     * @param unknown $condition
     */
    public function getOrderCodeCount($condition) {
        return $this->table('vr_order_code')->where($condition)->count();
    }

    /**
     * 生成兑换码
     * 长度 =3位 + 4位 + 2位 + 3位  + 1位 + 5位随机  = 18位
     * @param string $perfix 前缀
     * @param int $store_id
     * @param int $member_id
     * @param unknown $num
     * @return multitype:string
     */
    private function _makeVrCode($perfix, $store_id, $member_id, $num) {
        $perfix .= sprintf('%04d', (int) $store_id * $member_id % 10000)
        . sprintf('%02d', (int) $member_id % 100)
        . sprintf('%03d', (float) microtime() * 1000);

        $code_list = array();
        for ($i = 0; $i < $num; $i++) {
            $code_list[$i] = $perfix. sprintf('%01d', (int) $i % 10) . random(5,1);
        }
        return $code_list;
    }

    /**
     * 取得订单列表(所有)
     * @param unknown $condition
     * @param string $pagesize
     * @param string $field
     * @param string $order
     * @return array
     */
    public function getOrderList($condition, $pagesize = '', $field = '*', $order = 'order_id desc', $limit = ''){
        $list = $this->table('vr_order')->field($field)->where($condition)->page($pagesize)->order($order)->limit($limit)->select();
        if (empty($list)) return array();
        foreach ($list as $key => $order) {
            if (isset($order['order_state'])) {
                 list($list[$key]['state_desc'], $list[$key]['order_state_text']) = $this->_orderState($order['order_state']);
            }
            if (isset($order['payment_code'])) {
                 $list[$key]['payment_name'] = orderPaymentName($order['payment_code']);
            }
        }

        return $list;
    }

    /**
     * 取得订单状态文字输出形式
     *
     * @param array $order_info 订单数组
     * @return string $order_state 描述输出
     */
    private function _orderState($order_state) {
        switch ($order_state) {
        	case ORDER_STATE_CANCEL:
        	    $order_state = '<span style="color:#999">已取消</span>';
                $order_state_text = '已取消';
        	    break;
        	case ORDER_STATE_NEW:
        	    $order_state = '<span style="color:#36C">待付款</span>';
                $order_state_text = '待付款';
        	    break;
        	case ORDER_STATE_PAY:
        	    $order_state = '<span style="color:#999">已支付</span>';
                $order_state_text = '已支付';
        	    break;
        	case ORDER_STATE_SUCCESS:
        	    $order_state = '<span style="color:#999">已完成</span>';
                $order_state_text = '已完成';
        	    break;
        }
        return array($order_state, $order_state_text);;
    }



    /**
     * 返回是否允许某些操作
     * @param string $operate
     * @param array $order_info
     */
    public function getOrderOperateState($operate, $order_info){

        if (!is_array($order_info) || empty($order_info)) return false;

        switch ($operate) {

                //买家取消订单
        	case 'buyer_cancel':
        	    $state = $order_info['order_state'] == ORDER_STATE_NEW;
        	    break;

        	    //商家取消订单
        	case 'store_cancel':
        	    $state = $order_info['order_state'] == ORDER_STATE_NEW;
        	    break;

        	    //平台取消订单
        	case 'system_cancel':
        	    $state = $order_info['order_state'] == ORDER_STATE_NEW;
        	    break;

        	    //平台收款
        	case 'system_receive_pay':
        	    $state = $order_info['order_state'] == ORDER_STATE_NEW;
        	    break;

                //支付
        	case 'payment':
        	    $state = $order_info['order_state'] == ORDER_STATE_NEW;
        	    break;

    	       //评价
    	    case 'evaluation':
    	        $state = !$order_info['lock_state'] && $order_info['evaluation_state'] == '0' && $order_info['use_state'];
    	        break;

            	//买家退款
        	case 'refund':
        	    $state = false;
        	    $code_list = $order_info['code_list'];//没有使用的兑换码列表
        	    if (!empty($code_list) && is_array($code_list)) {
        	        if ($order_info['vr_indate'] > TIMESTAMP) {//有效期内的能退款
        	            $state = true;
        	        }
        	        if ($order_info['vr_invalid_refund'] == 1 && ($order_info['vr_indate'] + 60*60*24*CODE_INVALID_REFUND) > TIMESTAMP) {//兑换码过期后可退款
        	            $state = true;
        	        }
        	    }
        	    break;

        	    //分享
    	    case 'share':
    	        $state = true;
    	        break;
        }
        return $state;
    }

    /**
     * 订单详情页显示进行步骤
     * @param array $order_info
     */
    public function getOrderStep($order_info){
        if (!is_array($order_info) || empty($order_info)) return array();
        $step_list = array();
        // 第一步 下单完成
	    $step_list['step1'] = true;
	    //第二步 付款完成
	    $step_list['step2'] = !empty($order_info['payment_time']);
	    //第三步 兑换码使用中
	    $step_list['step3'] = !empty($order_info['payment_time']);
	    //第四步 使用完成或到期结束
	    $step_list['step4'] = $order_info['order_state'] == ORDER_STATE_SUCCESS;
        return $step_list;
    }

    /**
     * 取得订单数量
     * @param unknown $condition
     */
    public function getOrderCount($condition) {
        return $this->table('vr_order')->where($condition)->count();
    }
    
    /**
     * 订单销售记录 订单状态为20、30、40时
     * @param unknown $condition
     * @param string $field
     * @param number $page
     * @param string $order
     */
    public function getOrderAndOrderGoodsSalesRecordList($condition, $field="*", $page = 0, $order = 'order_id desc') {
        $condition['order_state'] = array('in', array(ORDER_STATE_PAY, ORDER_STATE_SUCCESS));
        return $this->getOrderList($condition, $field, $page, $order);
    }
}
