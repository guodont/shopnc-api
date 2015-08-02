<?php
/**
 * 订单管理
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
// 提货订单状态
define('DELIVERY_ORDER_DEFAULT', 10);   // 未到站
define('DELIVERY_ORDER_ARRIVE', 20);   // 已到站
define('DELIVERY_ORDER_PICKUP', 30);   // 已提取
class delivery_orderModel extends Model {
    private $order_state = array(
        DELIVERY_ORDER_DEFAULT => '未到站',
        DELIVERY_ORDER_ARRIVE => '已到站',
        DELIVERY_ORDER_PICKUP => '已提取'
    );
    public function __construct(){
        parent::__construct('delivery_order');
    }

    /**
     * 取单条订单信息
     * @param unknown $condition
     * @param string $fields
     */
    public function getDeliveryOrderInfo($condition = array(), $fields = '*') {
        return $this->field($fields)->where($condition)->find();
    }

    /**
     * 插入订单支付表信息
     * @param array $data
     * @return int 返回 insert_id
     */
    public function addDeliveryOrder($data) {
        return $this->insert($data);
    }

    /**
     * 更改信息
     *
     * @param unknown_type $data
     * @param unknown_type $condition
     */
    public function editDeliveryOrder($data,$condition) {
        return $this->where($condition)->update($data);
    }
    /**
     * 更改信息(包裹到达物流自提服务站)
     *
     * @param unknown_type $data
     * @param unknown_type $condition
     */
    public function editDeliveryOrderArrive($data, $condition) {
        $data['dlyo_state'] = DELIVERY_ORDER_ARRIVE;
        return $this->editDeliveryOrder($data, $condition);
    }
    /**
     * 更改信息（买家从物流自提服务张取走包裹）
     *
     * @param unknown_type $data
     * @param unknown_type $condition
     */
    public function editDeliveryOrderPickup($data, $condition) {
        $data['dlyo_state'] = DELIVERY_ORDER_PICKUP;
        return $this->editDeliveryOrder($data, $condition);
    }

    /**
     * 取订单列表信息
     * 
     * @param unknown $condition
     * @param string $fields
     * @param number $page
     * @param string $order
     * @param string $limit
     */
    public function getDeliveryOrderList($condition = array(), $fields = '*', $page = 0, $order = 'order_id desc', $limit = '') {
        return $this->field($fields)->where($condition)->order($order)->limit($limit)->page($page)->select(array('cache'=>false));
    }

    /**
     * 取未到站订单列表
     * 
     * @param unknown $condition
     * @param string $fields
     * @param number $page
     * @param string $order
     * @param string $limit
     */
    public function getDeliveryOrderDefaultList($condition = array(), $fields = '*', $page = 0, $order = 'order_id desc', $limit = '') {
        $condition['dlyo_state'] = DELIVERY_ORDER_DEFAULT;
        return $this->getDeliveryOrderList($condition,$fields,$page,$order,$limit);
    }

    /**
     * 取未到站/已到站订单列表
     * 
     * @param unknown $condition
     * @param string $fields
     * @param number $page
     * @param string $order
     * @param string $limit
     */
    public function getDeliveryOrderDefaultAndArriveList($condition = array(), $fields = '*', $page = 0, $order = 'order_id desc', $limit = '') {
        $condition['dlyo_state'] = array('neq', DELIVERY_ORDER_PICKUP);
        return $this->getDeliveryOrderList($condition,$fields,$page,$order,$limit);
    }

    /**
     * 取订单状态
     * @return multitype:string
     */
    public function getDeliveryOrderState() {
        return $this->order_state;
    }

    /**
     * 删除
     *
     * @param unknown_type $condition
     */
    public function delDeliveryOrder($condition) {
        return $this->where($condition)->delete();
    }
}
