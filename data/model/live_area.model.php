<?php
/**
 * 线下抢购管理
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class live_areaModel extends Model {

    public function __construct(){
        parent::__construct('live_area');
    }
    
    /**
     * 线下抢购信息
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function live_areaInfo($condition, $field = '*') {
        return $this->table('live_area')->field($field)->where($condition)->find();
    }

    /**
     * 线下抢购列表
     * @param array $condition
     * @param string $field
     * @param number $page
     * @param string $order
	 * @param string $limit
     */
    public function getList($condition = array(), $field = '*', $page='15', $order = 'live_area_id desc') {
       return $this->table('live_area')->where($condition)->page($page)->order($order)->select();
    }

    
    /**
     * 添加线下抢购
     * @param array $data
     */	
	public function add($data){
		return $this->table('live_area')->insert($data);
	}

    /**
     * 编辑线下抢购
     * @param array $condition
     * @param array $data
     */
    public function edit($condition, $data) {
        return $this->table('live_area')->where($condition)->update($data);
    }
	

    /**
     * 删除线下分类
     * @param array $condition
     */
	public function del($condition){
		return $this->table('live_area')->where($condition)->delete();
	}


}
