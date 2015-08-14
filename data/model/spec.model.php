<?php
/**
 * 规格管理
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class specModel extends Model {
    public function __construct() {
        parent::__construct('spec');
    }
	/**
	 * 规格列表
	 * @param	array	$param 规格资料
	 * @param	object	$page
	 * @param	string	$field
	 */
	public function specList($param, $page = '', $field = '*') {
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['table']		= 'spec';
		$array['where']		= $condition_str;
		$array['field']		= $field;
		$array['order']		= $param['order'];
		$list_spec		= Db::select($array, $page);
		return $list_spec;
	}
    /**
     * 单条规格信息
     * 
     * @param   int     $id     规格id
     * @param   string  $field  字段
     * @return  array   一维数组
     */
    public function getSpecInfo($id, $field = '*') {
        return $this->field($field)->find($id);
    }
    
    /**
     * 规格值列表
     * 
     * @param array     $where  添加
     * @param string    $field  字段
     * @param string    $order  排序
     */
    public function getSpecValueList($where, $field = '*', $order = 'sp_value_sort asc,sp_value_id asc') {
        $result = $this->table('spec_value')->field($field)->where($where)->order($order)->select();
        return empty($result) ? array() : $result;
    }
    
    /**
     * 更新规格值
     * 
     * @param array $update 更新数据
     * @param array $where  条件
     * @return boolean
     */
    public function editSpecValue($update, $where) {
        $result = $this->table('spec_value')->where($where)->update($update);
        return $result;
    }
    
    /**
     * 添加数据 
     * 
     * @param array $insert 添加数据
     * @return boolean
     */
    public function addSpecValue($insert) {
        $result = $this->table('spec_value')->insert($insert);
        return $result;
    }
    
    /**
     * 添加数据 多条
     * 
     * @param array $insert 添加数据
     * @return boolean
     */
    public function addSpecValueALL($insert) {
        $result = $this->table('spec_value')->insertAll($insert);
        return $result;
    }
    
    /**
     * 删除规格值
     * 
     * @param array $where 条件
     * @return boolean
     */
    public function delSpecValue($where) {
        $result = $this->table('spec_value')->where($where)->delete();
        return $result;
    }
	/**
	 * 更新规格信息
	 * @param	array $update 更新数据
	 * @param	array $param 条件
	 * @param	string $table 表名
	 * @return	bool
	 */
	public function specUpdate($update, $param, $table){
		$condition_str = $this->getCondition($param);
		if (empty($update)){
			return false;
		}
		if (is_array($update)){
			$tmp = array();
			foreach ($update as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::update($table,$tmp,$condition_str);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 添加规格信息
	 * @param	array	$param	一维数组
	 * @return bool
	 */
	public function addSpec($param) {
		// 规格表插入数据
		$sp_id = $this->insert($param);

        if (!$sp_id) {
        return false;
        } else {
            return true;
		}
	}
	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function specValueAdd($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('spec_value',$tmp);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 规格值列表
	 * @param	array	$param 商品资料
	 * @param	object	$page
	 * @param	string	$field
	 * @return	array
	 */
	public function specValueList($param, $page = '', $field = '*') {
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['table']		= 'spec_value';
		$array['where']		= $condition_str;
		$array['field']		= $field;
		$array['order']		= $param['order'];
		$list_spec		= Db::select($array, $page);
		return $list_spec;
	}
	/**
	 * 规格值
	 * @param	array	$param 商品资料
	 * @param	array	$field
	 * @return   一维数组
	 */
	public function specValueOne($param, $field = '*') {
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['table']		= 'spec_value';
		$array['where']		= $condition_str;
		$array['field']		= $field;
		$list_spec		= Db::select($array);
		return $list_spec['0'];
	}
	/**
	 * 删除规格
	 * 
	 * @param 表名 spec,spec_value
	 * @param 一维数组
	 * @return bool
	 */
	public function delSpec($table,$param){
		$condition_str = $this->getCondition($param);
		return Db::delete($table, $condition_str);
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array) {
		$condition_str = '';
		if($condition_array['sp_id'] != ''){
			$condition_str .= ' and sp_id = "'.$condition_array['sp_id'].'"';
		}
		if($condition_array['in_sp_id'] != ''){
			$condition_str .= ' and sp_id in ('.$condition_array['in_sp_id'].')';
		}
		if($condition_array['sp_value_id'] != ''){
			$condition_str .= ' and sp_value_id = "'.$condition_array['sp_value_id'].'"';
		}
		if($condition_array['in_sp_value_id'] != ''){
			$condition_str .= ' and sp_value_id in ('.$condition_array['in_sp_value_id'].')';
		}
		return $condition_str;
	}
}