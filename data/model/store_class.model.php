<?php
/**
 * 店铺类别模型
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class store_classModel extends Model {

    public function __construct(){
        parent::__construct('store_class');
    }

    /**
     * 取店铺类别列表
     * @param unknown $condition
     * @param string $pagesize
     * @param string $order
     */
    public function getStoreClassList($condition = array(), $pagesize = '', $limit = '', $order = 'sc_sort asc,sc_id asc') {
        return $this->where($condition)->order($order)->page($pagesize)->limit($limit)->select();
    }

    /**
     * 取得单条信息
     * @param unknown $condition
     */
    public function getStoreClassInfo($condition = array()) {
        return $this->where($condition)->find();
    }

    /**
     * 删除类别
     * @param unknown $condition
     */
    public function delStoreClass($condition = array()) {
        return $this->where($condition)->delete();
    }

    /**
     * 增加店铺分类
     * @param unknown $data
     * @return boolean
     */
    public function addStoreClass($data) {
        return $this->insert($data);
    }

    /**
     * 更新分类
     * @param unknown $data
     * @param unknown $condition
     */
    public function editStoreClass($data = array(),$condition = array()) {
        return $this->where($condition)->update($data);
    }
}