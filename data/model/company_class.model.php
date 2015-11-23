<?php
/**
 * 单位分类
 */
defined('InShopNC') or exit('Access Invalid!');

class company_classModel{
	/**
	 * 类别列表
	 *
	 * @param array $condition 检索条件
	 * @return array 数组结构的返回结果
	 */
	public function getClassList($condition){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'company_class';
		$param['where'] = $condition_str;
		$param['order']	= empty($condition['order'])?'class_sort asc':$condition['order'];
		$result = Db::select($param);
		return $result;
	}
	
	/**
	 * 构造检索条件
	 *
	 * @param int $id 记录ID
	 * @return string 字符串类型的返回结果
	 */
	private function _condition($condition){
		$condition_str = '';
		
		if ($condition['no_ac_id'] != ''){
			$condition_str .= " and ac_id != '". intval($condition['no_ac_id']) ."'";
		}
		if ($condition['ac_name'] != ''){
			$condition_str .= " and ac_name = '". $condition['ac_name'] ."'";
		}
		return $condition_str;
	}
	
	/**
	 * 取单个分类的内容
	 *
	 * @param int $id 分类ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneClass($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'company_class';
			$param['field'] = 'class_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}
	
	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
    public function save($param){

        return $this->insert($param);	

    }
	
	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function modify($update, $condition){

        return $this->where($condition)->update($update);

    }
	
	/*
	 * 删除
	 * @param array $condition
	 * @return bool
	 */
    public function drop($condition){

        return $this->where($condition)->delete();

    }
}