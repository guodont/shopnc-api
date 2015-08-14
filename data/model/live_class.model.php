<?php
/**
 * 线下分类管理
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class live_classModel extends Model {

    public function __construct(){
        parent::__construct('live_class');
    }
    
    /**
     * 线下分类信息
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function live_classInfo($condition, $field = '*') {
        return $this->table('live_class')->field($field)->where($condition)->find();
    }

    /**
     * 线下分类列表
     * @param array $condition
     * @param string $field
     * @param number $page
     * @param string $order
	 * @param string $limit
     */
    public function getList($condition = array(), $field = '*', $order = 'live_class_id desc',$limit='0,1000') {
       return $this->table('live_class')->where($condition)->order($order)->limit($limit)->select();
    }

    
    /**
     * 添加线下分类
     * @param array $data
     */	
	public function add($data){
		return $this->table('live_class')->insert($data);
	}

    /**
     * 编辑线下分类
     * @param array $condition
     * @param array $data
     */
    public function editLive_class($condition, $data) {
        return $this->table('live_class')->where($condition)->update($data);
    }
	

    /**
     * 删除线下分类
     * @param array $condition
     */
	public function delLive_class($condition){
		return $this->table('live_class')->where($condition)->delete();
	}


}
