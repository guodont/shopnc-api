<?php
/**
 * 店铺消息模板模型
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class store_msg_tplModel extends Model{
    public function __construct() {
        parent::__construct('store_msg_tpl');
    }

    /**
     * 店铺消息模板列表
     * @param array $condition
     * @param string $field
     * @param number $page
     * @param string $order
     */
    public function getStoreMsgTplList($condition, $field = '*', $page = 0, $order = 'smt_code asc') {
        return $this->field($field)->where($condition)->order($order)->page($page)->select();
    }

    /**
     * 店铺消息模板详细信息
     * @param array $condition
     * @param string $field
     */
    public function getStoreMsgTplInfo($condition, $field = '*') {
        return $this->field($field)->where($condition)->find();
    }

    /**
     * 编辑店铺消息模板
     * @param unknown $condition
     * @param unknown $update
     */
    public function editStoreMsgTpl($condition, $update) {
        return $this->where($condition)->update($update);
    }
}
