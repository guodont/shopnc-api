<?php
/**
 * 圈子成员模型
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class circle_memberModel extends Model {
    public function __construct(){
        parent::__construct('circle_member');
    }

    /**
     * 圈子成员列表
     * @param array $condition
     * @param string $field
     * @param number $page
     * @param string $order
     * @return array
     */
    public function getCircleMemberList($condition, $field = '*', $page = 0, $order = 'member_id desc') {
        return $this->where($condition)->field($field)->order($order)->page($page)->select();
    }

    /**
     * 超级管理员列表
     * @param unknown $condition
     * @param string $field
     * @param number $page
     * @param string $order
     * @return array
     */
    public function getSuperList($condition, $field = '*', $page = 0, $order = 'member_id desc') {
        $condition['circle_id'] = 0;
        return $this->getCircleMemberList($condition, $field, $page, $order);
    }
    
    /**
     * 获得圈子成员信息
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getCircleMenberInfo($condition, $field = '*') {
        return $this->field($field)->where($condition)->find();
    }
    
    /**
     * 获取超级管理员信息
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getSuperInfo($condition, $field = '*') {
        $condition['circle_id'] = 0;
        return $this->getCircleMenberInfo($condition, $field);
    }
    
    /**
     * 添加管理员
     * @param unknown $insert
     * @return boolean
     */
    public function addCircleMember($insert) {
        $insert['cm_jointime'] = TIMESTAMP;
        $result = $this->insert($insert);
        if ($result) {
            dcache($insert['circle_id'], 'circle_managelist');
        }
        return $result;
    }
    
    /**
     * 添加超级管理员
     * @param unknown $insert
     * @return boolean
     */
    public function addSuper($insert) {
        $insert['circle_id'] = 0;
        return $this->addCircleMember($insert);
    }
    
    /**
     * 删除管理员
     * @param unknown $condition
     */
    public function delCircleMember($condition) {
        $result = $this->where($condition)->delete();
        if ($result) {
            dcache($condition['circle_id'], 'circle_managelist');
        }
        return $result;
    }
    
    /**
     * 删除超级管理员
     * @param unknown $condition
     */
    public function delSuper($condition) {
        $condition['circle_id'] = 0;
        return $this->delCircleMember($condition);
    }
}
