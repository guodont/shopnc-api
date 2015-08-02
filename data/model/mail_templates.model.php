<?php
/**
 * 通知模板表
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class mail_templatesModel extends Model {

    public function __construct(){
        parent::__construct('mail_msg_temlates');
    }

    /**
     * 取单条信息
     * @param unknown $condition
     * @param string $fields
     */
    public function getTplInfo($condition = array(), $fields = '*') {
        return $this->where($condition)->field($fields)->find();  
    }

	/**
	 * 模板列表
	 *
	 * @param array $condition 检索条件
	 * @return array 数组形式的返回结果
	 */
	public function getTplList($condition = array()){
	    return $this->where($condition)->select();
	}

	public function editTpl($data = array(), $condition = array()) {
	    return $this->where($condition)->update($data);
	}

}