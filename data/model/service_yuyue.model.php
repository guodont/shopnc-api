<?php
/**
 * 服务管理
 *by 3 3hao .com 
 */
defined('InShopNC') or exit('Access Invalid!');

class service_yuyueModel {
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
			$result = Db::insert('service_yuyue',$tmp);
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
			$where = " yuyue_id = '". $param['yuyue_id'] ."'";
			$result = Db::update('service_yuyue',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 服务列表
	 */ 	
	public function listGoods($param,$page = '',$field='*') {
		$condition_str = $this->getCondition($param);
		$array	= array();
		$array['table']	= 'service_yuyue';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$array['order'] = $param['order'] ? $param['order'] : 'yuyue_id desc';
		$array['limit'] = $param['limit'];
		$list_goods		= Db::select($array,$page);
		return $list_goods;
	}	
	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneyuyue($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'service_yuyue';
			$param['field'] = 'yuyue_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 商品信息更新
	 *
	 * @param	array $param 列表条件
	 * @param	int $yuyue_id 商品id
	 */ 	
	public function updateGoods($param,$yuyue_id) {
		if(empty($param)) {
			return false;
		}
		$update		= false;
		if(is_array($yuyue_id))$yuyue_id	= implode(',',$yuyue_id);
		//得到条件语句
		$condition_str	= "WHERE yuyue_id in(".$yuyue_id.")";
		$update		= Db::update('service_yuyue',$param,$condition_str);
		return $update;
	}
	/**
	 * 服务数量
	 *
	 * @param	array $param 服务资料
	 */
	public function countGoods($param,$type = ''){
		if (empty($param)) {
			return false;
		}		
		$condition_str = $this->getCondition($param);
		$array	= array();
		$array['table'] = 'service_yuyue';
		$array['where'] = $condition_str;
		$array['field'] = 'count(*)';
		$goods_array	= Db::select($array);
		return $goods_array[0][0];
	}
	/**
	 * 服务删除
	 *
	 * @param	array $param 列表条件
	 * @param	int $yuyue_id 商品id
	 */ 
	public function dropGoods($yuyue_id) {
		if(empty($yuyue_id)) {
			return false;
		}
		$del_state		= Db::delete('service_yuyue', 'where yuyue_id in ('.$yuyue_id.')');
		if($del_state) {
			$image_more	= Db::select(array('table'=>'flea_upload','field'=>'file_name','where'=>' where item_id in ('.$yuyue_id.') and upload_type in ("12","13")'));
			if(is_array($image_more) && !empty($image_more)){
				foreach ($image_more as $v){
					@unlink(UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$_SESSION['member_id'].DS.$v['file_name']);
				}
			}
			Db::delete('flea_upload','where item_id in ('.$yuyue_id.') and upload_type in ("12","13")');
		}
		return true;
	}
	
	/**
	 * 按服务查找预约信息  
	 */
	public function getGoodsByClass($param){
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['table'] = 'service_yuyue,flea_class';
		$array['field'] = $param['field']?$param['field']:'*';
		$array['where'] = $condition_str;
		$array['join_type'] = 'left join';
		$array['join_on'] = array('flea.gc_id=flea_class.gc_id');
		$array['order'] = $param['order'];
		$array['limit'] = $param['limit'];
		$goods_array	= Db::select($array);
		return $goods_array;		
	}
	/**
	 * 查询服务信息id
	 */
	public function getFleaID(){
		$flea_ids = Db::select(array('table'=>'service_yuyue','field'=>'yuyue_id','limit'=>'27'));
		return $flea_ids;
	}	
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		if ($condition_array['member_id'] != '') {
			$condition_sql	.= " and member_id = ".$condition_array['member_id'];
		}
		if($condition_array['image_store_id'] != '') {
			$condition_sql	.= " and store_id=".$condition_array['image_store_id']." and item_id=".$condition_array['item_id']." and upload_type='".$condition_array['image_type']."'";
		}
		
		return $condition_sql;
	}
	 /*
	  * 递归得到商品分类的ID
	  * @param array $class_list
	  * @return string $class_string 逗号分割的分类ID及其子ID的字符串
	  */
	private function _getRecursiveClass($class_id){
		
		static $class_list='' ;
		
		$id = implode(',', $class_id) ;
		$class_list .= ','.$id ;		
		$temp_list = Db::select(array('table'=>'flea_class','where'=>'gc_parent_id in ('.$id.')','field'=>'gc_id')) ;
		
		if(!empty($temp_list)){
			
			$_tmp = array() ;	//取得ID组成的一维数组
			
			foreach($temp_list as $key=>$val){
				
				$_tmp[] = $val['gc_id'] ;
			
			}
			unset($temp_list);
			$temp_list = $_tmp ;
			
			$id = $this->_getRecursiveClass($temp_list) ;

		}

		return trim($class_list,',') ;
	
	}
}
