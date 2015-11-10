<?php
/**
 * 单位管理
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class companyModel{
	/**
	 * 列表
	 *
	 * @param array $condition 检索条件
	 * @param obj $page 分页
	 * @return array 数组结构的返回结果
	 */
	public function getcompanyList($condition,$page=''){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'company';
		$param['where'] = $condition_str;
		$param['limit'] = $condition['limit'];
		$param['order']	= (empty($condition['order'])?'company_sort asc,company_time desc':$condition['order']);
		$result = Db::select($param,$page);
		return $result;
	}

	/**
	 * 连接查询列表
	 *
	 * @param array $condition 检索条件
	 * @param obj $page 分页
	 * @return array 数组结构的返回结果
	 */
	public function getJoinList($condition,$page=''){
		$result	= array();
		$condition_str	= $this->_condition($condition);
		$param	= array();
		$param['table'] = 'company,company_class';
		$param['field']	= empty($condition['field'])?'*':$condition['field'];;
		$param['join_type']	= empty($condition['join_type'])?'left join':$condition['join_type'];
		$param['join_on']	= array('company.ac_id=company_class.class_id');
		$param['where'] = $condition_str;
		$param['limit'] = $condition['limit'];
		$param['order']	= empty($condition['order'])?'company.company_sort':$condition['order'];
		$result = Db::select($param,$page);
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

		if ($condition['company_show'] != ''){
			$condition_str .= " and company.company_show = '". $condition['company_show'] ."'";
		}
		if ($condition['ac_id'] != ''){
			$condition_str .= " and company.ac_id = '". $condition['ac_id'] ."'";
		}
		if ($condition['ac_ids'] != ''){
			//if(is_array($condition['ac_ids']))$condition['ac_ids']	= implode(',',$condition['ac_ids']);
			$condition_str .= " and company.ac_id in(". $condition['ac_ids'] .")";
		}
		if ($condition['like_title'] != ''){
			$condition_str .= " and company.company_title like '%". $condition['like_title'] ."%'";
		}

		return $condition_str;
	}

	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneCompany($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'company';
			$param['field'] = 'company_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function add($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('company',$tmp);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function update($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$where = " company_id = '". $param['company_id'] ."'";
			$result = Db::update('company',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 删除
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function del($id){
		if (intval($id) > 0){
			$where = " company_id = '". intval($id) ."'";
			$result = Db::delete('company',$where);
			return $result;
		}else {
			return false;
		}
	}
}