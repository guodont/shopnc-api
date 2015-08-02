<?php
/**
 * 合作伙伴
 *
 * 
 *
 *
 * by abc.com
 */

defined('InShopNC') or exit('Access Invalid!');

class linkModel{
	/**
	 * 列表
	 *
	 * @param array $condition 检索条件
	 * @param obj $page 分页
	 * @return array 数组结构的返回结果
	 */
	public function getLinkList($condition,$page=''){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'link';
		$param['where'] = $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'link_id';
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
		
		if ($condition['like_link_title'] != ''){
			$condition_str .= " and link_title like '%". $condition['like_link_title'] ."%'";
		}
	    if ($condition['link_pic'] == 'yes'){
			$condition_str .= " and link_pic != ''";
		}
	    if ($condition['link_pic'] == 'no'){
			$condition_str .= " and LENGTH(link_pic)=0";
		}
		return $condition_str;
	}
	
	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneLink($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'link';
			$param['field'] = 'link_id';
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
			$result = Db::insert('link',$tmp);
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
			$where = " link_id = '". $param['link_id'] ."'";
			$result = Db::update('link',$tmp,$where);
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
			$where = " link_id = '". intval($id) ."'";
			$result = Db::delete('link',$where);
			return $result;
		}else {
			return false;
		}
	}	
}