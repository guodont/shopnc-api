<?php
/**
 * 圈子模型
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class circleModel extends Model {
    public function __construct(){
        parent::__construct('circle');
    }
    
    /**
     * 获取圈子数量
     * @param array $condition
     * @return int
     */
    public function getCircleCount($condition) {
        return $this->where($condition)->count();
    }
    
    /**
     * 未审核的圈子数量
     * @param array $condition
     * @return int
     */
    public function getCircleUnverifiedCount($condition = array()) {
        $condition['circle_status'] = 2;
        return $this->getCircleCount($condition);
    }
}
