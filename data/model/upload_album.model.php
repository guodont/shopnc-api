<?php
/**
 * 上传文件模型
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class upload_albumModel{
	/**
	 * 列表
	 *
	 * @param array $condition 检索条件
	 * @return array 数组结构的返回结果
	 */
	public function getUploadList($condition){
		
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'album_pic';
		$param['where'] = $condition_str;
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

		if($condition['apic_name'] != '') {
			$condition_str .= " and apic_name='{$condition['pic_name']}'";
		}
		if($condition['apic_tag'] != '') {
			$condition_str .= " and apic_tag='{$condition['apic_tag']}'";
		}
		if($condition['aclass_id'] != '') {
			$condition_str .= " and aclass_id='{$condition['aclass_id']}'";
		}
		if($condition['apic_cover'] != '') {
			$condition_str .= " and apic_cover='{$condition['apic_cover']}'";
		}
		if($condition['apic_size'] != '') {
			$condition_str .= " and apic_size='{$condition['apic_size']}'";
		}
		if($condition['store_id'] != '') {
			$condition_str .= " and store_id='{$condition['store_id']}'";
		}
		if($condition['upload_time'] != '') {
			$condition_str .= " and upload_time='{$condition['upload_time']}'";
		}
		return $condition_str;
	}

	/**
	 * 取单个内容
	 *
	 * @param int $id 分类ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneUpload($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'album_pic';
			$param['field'] = 'apic_id';
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
			$result = Db::insert('album_pic',$param);
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
			$where = " apic_id = '{$param['apic_id']}'";
			$result = Db::update('album_pic',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @param array $conditionarr 条件数组 
	 * @return bool 布尔类型的返回结果
	 */
	public function updatebywhere($param,$conditionarr){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			//条件
			$condition_str = $this->_condition($conditionarr);
			//更新信息
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::update('album_pic',$tmp,$condition_str);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 删除分类
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function del($id){
		if (intval($id) > 0){
			$where = " apic_id = '". intval($id) ."'";
			$result = Db::delete('album_pic',$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 删除上传图片信息
	 * @param	mixed $id 删除上传图片记录编号
	 */
	public function dropUploadById($id){
		if(empty($id)) {
			return false;
		}
		$condition_str = ' 1=1 ';
		if (is_array($id) && count($id)>0){
			$idStr = implode(',',$id);
			$condition_str .= " and apic_id in({$idStr}) ";
		}else {
			$condition_str .= " and apic_id = {$id} ";
		}
		$result = Db::delete('album_pic',$condition_str);
		return $result;
	}
	//
	//
	//	/**
	//	 * 等级对应的店铺列表
	//	 *
	//	 * @param array $condition 检索条件
	//	 * @param obj $page 分页
	//	 * @return array 数组结构的返回结果
	//	 */
	//	public function getGradeShopList($condition,$page){
	//		$condition_str = $this->_conditionShop($condition);
	//		$param = array(
	//					'table'=>'store_grade,store',
	//					'field'=>'store_grade.*,store.*',
	//					'where'=>$condition_str,
	//					'join_type'=>'left join',
	//					'join_on'=>array(
	//						'store_grade.sg_id = store.grade_id',
	//					)
	//				);
	//		$result = Db::select($param,$page);
	//		return $result;
	//	}
	//
	//	/**
	//	 * 构造 店铺列表 检索条件
	//	 *
	//	 * @param array $condition 检索条件
	//	 * @return string 字符串类型的返回结果
	//	 */
	//	private function _conditionShop($condition){
	//		$condition_str = '';
	//
	//		if ($condition['sg_id'] != ''){
	//			$condition_str .= " and store_grade.sg_id = '". $condition['sg_id'] ."'";
	//		}
	//
	//		return $condition_str;
	//	}



}