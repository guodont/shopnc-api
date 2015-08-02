<?php
/**
 * 线下抢购订单管理
 *
 * 
 *by abc.com 多用户商城 运营版
 */
defined('InShopNC') or exit('Access Invalid!');
class live_orderModel extends Model {

    public function __construct(){
        parent::__construct('live_order');
    }
    
    /**
     * 线下抢购订单
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function live_orderInfo($condition, $field = '*') {
        return $this->table('live_order')->field($field)->where($condition)->find();
    }

    /**
     * 线下抢购订单列表
     * @param array $condition
     * @param string $field
     * @param number $page
     * @param string $order
     */
    public function getList($condition = array(), $field = '*', $page='15', $order = 'order_id desc') {
		return $this->table('live_order')->where($condition)->page($page)->order($order)->select();
    }

    /**
     * 会员订单列表
     * @param array $condition
     * @param string $field
     * @param number $page
     * @param string $order
     */	
	public function getOrderGroupbuy($condition = array(), $field = '*', $page='15', $order = 'order_id desc'){
		return $this->table('live_order,live_groupbuy')->field($field)->join('left')->on('live_order.item_id = live_groupbuy.groupbuy_id')->where($condition)->page($page)->order($order)->select();
	}

    /**
     * 操作日志
     * @param array $condition
     * @param string $field
     * @param number $page
     * @param string $order
     */		
	public function getOrderVerifyLog($condition = array(), $field = '*', $page='15', $order = 'order_item_id desc'){
		return $this->table('live_order_pwd,live_order')->field($field)->join('left')->on('live_order_pwd.order_id=live_order.order_id')->where($condition)->page($page)->order($order)->select();
	}



    /**
     * 添加抢购订单
     * @param array $params
     */
	public function add($params){
		return $this->table('live_order')->insert($params);
	}

    /**
     * 更新订单
	 * @param array $condition
     * @param array $params
     */
	public function updateLiveOrder($condition,$params){
		return $this->table('live_order')->where($condition)->update($params);
	}

    /**
     * 删除线下抢购订
     * @param array $condition
     */
	public function del($condition){
		return $this->table('live_order')->where($condition)->delete();
	}


    /**
     * 获取订单抢购券
     * @param array $condition
     */
	public function getLiveOrderPwd($condition){
		return $this->table('live_order_pwd')->where($condition)->select();
	}

	
    /**
     * 添加抢购券
     * @param array $params
     */
	public function addLiveOrderPwd($params){
		return $this->table('live_order_pwd')->insert($params);
	}

}
