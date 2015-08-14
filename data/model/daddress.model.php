<?php
/**
 * 发货地址
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class daddressModel extends Model {
    public function __construct() {
        parent::__construct('daddress');        
    }

    /**
     * 新增
     * @param unknown $data
     * @return boolean, number
     */
    public function addAddress($data) {
        return $this->insert($data);
    }

    /**
     * 删除
     * @param unknown $condition
     */
    public function delAddress($condition) {
        return $this->where($condition)->delete();
    }

    public function editAddress($data, $condition) {
        return $this->where($condition)->update($data);
    }

    /**
     * 查询单条
     * @param unknown $condition
     * @param string $fields
     */
    public function getAddressInfo($condition, $fields = '*') {
        return $this->field($fields)->where($condition)->find();
    }

    /**
     * 查询多条
     * @param unknown $condition
     * @param string $pagesize
     * @param string $fields
     * @param string $order
     */
    public function getAddressList($condition, $fields = '*', $order = '', $limit = '') {
        return $this->field($fields)->where($condition)->order($order)->limit($limit)->select();
    }
}