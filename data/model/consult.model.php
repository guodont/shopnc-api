<?php
/**
 * 咨询管理
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class consultModel extends Model{
    public function __construct() {
        parent::__construct('consult');
    }
    
    /**
     * 咨询数量
     * 
     * @param array $condition
     * @return int
     */
    public function getConsultCount($condition) {
        return $this->where($condition)->count();
    }
    
    /**
     * 添加咨询
     * @param array $insert
     * @return int
     */
    public function addConsult($insert){
        return $this->insert($insert);
    }
    
    /**
     * 商品咨询列表
     * @param unknown $condition
     * @param string $field
     * @param number $limit
     * @param number $page
     * @param string $order
     * @return array
     */
    public function getConsultList($condition, $field = '*', $limit = 0, $page = 0, $order = 'consult_id desc') {
        return $this->where($condition)->field($field)->order($order)->limit($limit)->page($page)->select();
    }
    
    public function getConsultInfo($condition) {
        return $this->where($condition)->find();
    }
    
    /**
     * 删除咨询
     * 
     * @param unknown_type $id
     */
    public function delConsult($condition){
        return $this->where($condition)->delete();
    }
    /**
     * 回复咨询
     * 
     * @param unknown_type $input
     */
    public function editConsult($condition, $update){
        $update['consult_reply_time'] = TIMESTAMP;
        return $this->where($condition)->update($update);
    }
}