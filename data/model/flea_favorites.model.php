<?php
/**
 * 买家收藏
 *by 3 3hao .com 
 */
defined('InShopNC') or exit('Access Invalid!');
class flea_favoritesModel{
	/**
	 * 收藏列表
	 *
	 * @param array $condition 检索条件
	 * @param obj $obj_page 分页对象
	 * @return array 数组类型的返回结果
	 */
	public function getFavoritesList($condition,$page = ''){
		$condition_str = $this->_condition($condition);
		$param = array(
					'table'=>'flea_favorites',
					'where'=>$condition_str,
					'order'=>$condition['order'] ? $condition['order'] : 'fav_time desc'
				);		
		$result = Db::select($param,$page);
		return $result;
	}
	
	/**
	 * 构造检索条件
	 *
	 * @param array $condition 检索条件
	 * @return string 字符串类型的返回结果
	 */
	public function _condition($condition){
		$condition_str = '';
		
		if ($condition['member_id'] != ''){
			$condition_str .= " and member_id = '{$condition['member_id']}'";
		}
		if ($condition['fav_type'] != ''){
			$condition_str .= " and fav_type = '{$condition['fav_type']}'";
		}
		
		return $condition_str;
	}
	
	/**
	 * 取单个收藏的内容
	 *
	 * @param int $fav_id 收藏ID
	 * @param string $fav_type 收藏类型
	 * @return array 数组类型的返回结果
	 */
	public function getOneFavorites($fav_id,$type,$member_id){
		if (intval($fav_id) > 0){
			$param = array();
			$param['table'] = 'flea_favorites';
			$param['field'] = array('fav_id','fav_type','member_id');
			$param['value'] = array(intval($fav_id),$type,$member_id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 新增收藏
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addFavorites($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('flea_favorites',$tmp);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 验证是否为当前用户收藏
	 *
	 * @param array $param 条件数据
	 * @return bool 布尔类型的返回结果
	 */
	public function checkFavorites($fav_id,$fav_type,$member_id){
		if (intval($fav_id) == 0 || empty($fav_type) || intval($member_id) == 0){
			return true;
		}
		$result = self::getOneFavorites($fav_id,$fav_type,$member_id);
		if ($result['member_id'] == $member_id){
			return true;
		}else {
			return false;
		}
	}
	
	/**
	 * 删除
	 *
	 * @param int $id 记录ID
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function delFavorites($id,$type){
		if (intval($id) > 0 && !empty($type) && self::checkFavorites($id,$type,$_SESSION['member_id'])){
			$where = ' `fav_id` = '. intval($id) ." and `fav_type` = '{$type}'";
			$result = Db::delete('flea_favorites',$where);
			return $result;
		}else {
			return false;
		}
	}
}