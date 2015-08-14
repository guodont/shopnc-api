<?php
/**
 * 地区管理
 *by 3 3hao .com 
 */
defined('InShopNC') or exit('Access Invalid!');
class flea_areaModel{	
	/**
	 * 读取系统设置列表
	 *
	 * @param array $condition 检索条件
         * @param string $order 排序条件
	 * @return array 数组格式的返回结果
	 */
	public function getListArea($condition, $order=''){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'flea_area';
		$param['field'] = $condition['field']?$condition['field']:'*';
		$param['limit'] = $condition['limit']?$condition['limit']:'';
		$param['order'] = $condition['order']?$condition['order']:'';
		$param['where'] = $condition_str;
                if( !empty($order) )
                {
                    $param['order'] = $order;
                }
		$result = Db::select($param);
		return $result;
	}
	
	/**
	 * 构造检索条件
	 *
	 * @param array $condition 检索条件
	 * @return string 数组形式的返回结果
	 */
	private function _condition($condition){
		$condition_str = '';
		
		if ($condition['flea_area_parent_id'] != ''){
			$condition_str .= " and flea_area_parent_id = '". intval($condition['flea_area_parent_id']) ."'";
		}
		if ($condition['flea_area_deep'] != ''){
			$condition_str .= " and flea_area_deep = '". intval($condition['flea_area_deep']) ."'";
		}
		if ($condition['area_hot'] != ''){
			$condition_str .= " and flea_area_hot > 0";
		}
		if ($condition['area_deep'] != ''){
			$condition_str .= " and flea_area_deep <= 2";//一级和二级地区
		}
		return $condition_str;
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
			$result = Db::insert('flea_area',$tmp);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 取单个地区的内容
	 *
	 * @param int $area_id 地区ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneArea($area_id){
		if (intval($area_id) > 0){
			$param = array();
			$param['table'] = 'flea_area';
			$param['field'] = 'flea_area_id';
			$param['value'] = intval($area_id);
			$result = Db::getRow($param);
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
			$where = " flea_area_id = '". $param['flea_area_id'] ."'";
			$result = Db::update('flea_area',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 删除地区
	 *
	 * @param int/array $id 删除ID
	 * @param int $deep 删除深度,默认为1
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function del($id,$deep=1){
		if (!empty($id)){
			if (!is_array($id)){
				$id = array($id);
			}
			
			/**
			 * 取得地区缓存内容
			 */
			$child_deep = $deep+1;
			for ($i=$child_deep; $i<=4; $i++){
				$cache_file = BASE_DATA_PATH.DS.'cache'.DS.'flea_area'.DS.'flea_area_'.$i.'.php';
				if (file_exists($cache_file)){
					require_once($cache_file);
					$tmp = 'cache_data_'.$i;
					$$tmp = $data;
					unset($tmp,$data);
				}
			}
			foreach ($id as $k => $v){
				if (intval($v) > 0){
					$del_tmp[] = "flea_area_id = '". $v ."'";
					/**
					 * 判断子类中是否还有内容
					 */
					if ($child_deep <= 4){
						$del_parent_id = array($v);
						for ($i=$child_deep; $i<=4; $i++){
							$tmp = 'cache_data_'.$i;
							$$tmp;
							if (is_array($$tmp) && !empty($del_parent_id)){
								foreach ($del_parent_id as $k_parent => $v_parent){
									foreach ($$tmp as $k_2 => $v_2){
										if ($v_2['flea_area_parent_id'] == $v_parent){
											$del_tmp[] = "flea_area_id = '". $v_2['flea_area_id'] ."'";
											$next_parent_id[] = $v_2['flea_area_id'];
										}
									}
								}
								/**
								 * 再下一级的父ID
								 */
								$del_parent_id = $next_parent_id;
							}
						}
					}
				}
			}
			$where = implode(' or ',$del_tmp);
			$result = Db::delete('flea_area',$where);
			return $result;
		}else {
			return false;
		}
	}
	
	public function area_show(){

		$area_one_level = array();
		$area_two_level = array();
		$condition = array();
		$condition['area_parent_id']='1';
		$condition['field']='flea_area_id,flea_area_name,flea_area_parent_id';
		$condition['order']='flea_area_parent_id asc,flea_area_sort asc,flea_area_id asc';
		$area_list=$this->getListArea($condition);
		if(is_array($area_list) && !empty($area_list)) {
			foreach ($area_list as $val) {
				if($val['flea_area_parent_id'] == 0) {
					$flea_area_id	= $val['flea_area_id'];
					$area_one_level[] = $val;
					$area_two_level[$flea_area_id]['id']=$flea_area_id;
				} else {
					$flea_area_parent_id	= $val['flea_area_parent_id'];
					if(isset($area_two_level[$flea_area_parent_id])) {
						$area_two_level[$flea_area_parent_id]['children'][] = $val;
						$area_children = $area_two_level[$flea_area_parent_id]['children'];
						if (strtoupper(CHARSET) == 'GBK'){
							$area_children = Language::getUTF8($area_children);
						}
						$area_two_level[$flea_area_parent_id]['content'] = json_encode($area_children);
					}
				}
			}
		}
		return(array('area_one_level'=>$area_one_level, 'area_two_level'=>$area_two_level));
	}
}