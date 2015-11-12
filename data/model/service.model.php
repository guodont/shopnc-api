<?php
/**
 * 闲置管理
 *by 3 3hao .com 
 */
defined('InShopNC') or exit('Access Invalid!');

class serviceModel {
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
			$result = Db::insert('service',$tmp);
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
			$where = " service_id = '". $param['service_id'] ."'";
			$result = Db::update('service',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 商品列表
	 */ 	
	public function listGoods($param,$page = '',$field='*') {
		$condition_str = $this->getCondition($param);
		$array	= array();
		$array['table']	= 'service';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$array['order'] = $param['order'] ? $param['order'] : 'service_id desc';
		$array['limit'] = $param['limit'];
		$list_goods		= Db::select($array,$page);
		return $list_goods;
	}	
	/**
	 * 他们正在卖的
	 */
	public function saleGoods($param,$page = '',$field='*') {
		$condition_str = $this->getCondition($param);
		$array	= array();
		$array['table']	= 'service,member';
		$array['join_type']='left join';
		$array['field'] = $field;
		$array['join_on']= array('service.member_id=member.member_id');
		$array['order'] = 'service_id desc';
		$array['limit'] = $param['limit'];
		$list_goods		= Db::select($array,$page);
		return $list_goods;
	}

	/**
	 * 闲置物品多图
	 *
	 * @param	array $param 列表条件
	 * @param	array $field 显示字段
	 */ 	
	public function getListImageGoods($param,$field='*') {
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($param);
		$array	= array();
		$array['table']		= 'flea_upload';
		$array['where']		= $condition_str;
		$array['field']		= $field;
		$list_image			= Db::select($array);
		return $list_image;
	}
	/**
	 * 得到商品所有缩略图，带商品路径
	 *
	 * @param	array $goods 商品列表
	 */ 
	public function getThumb(&$goods,$path){
		if (is_array($goods)){
			foreach ($goods as $k=>$v) {
				$goods[$k]['thumb_small'] 	= $path.$v['file_thumb'];
				$goods[$k]['thumb_mid'] 	= $path.str_replace('_small','_mid',$v['file_thumb']);
				$goods[$k]['thumb_max'] 	= $path.str_replace('_small','_max',$v['file_thumb']);
			}
		}
	}	
	/**
	 * 商品信息更新
	 *
	 * @param	array $param 列表条件
	 * @param	int $service_id 商品id
	 */ 	
	public function updateGoods($param,$service_id) {
		if(empty($param)) {
			return false;
		}
		$update		= false;
		if(is_array($service_id))$service_id	= implode(',',$service_id);
		//得到条件语句
		$condition_str	= "WHERE service_id in(".$service_id.")";
		$update		= Db::update('service',$param,$condition_str);
		return $update;
	}
	/**
	 * 闲置物品数量
	 *
	 * @param	array $param 闲置物品资料
	 */
	public function countGoods($param,$type = ''){
		if (empty($param)) {
			return false;
		}		
		$condition_str = $this->getCondition($param);
		$array	= array();
		$array['table'] = 'service';
		$array['where'] = $condition_str;
		$array['field'] = 'count(*)';
		$goods_array	= Db::select($array);
		return $goods_array[0][0];
	}
	/**
	 * 闲置物品删除
	 *
	 * @param	array $param 列表条件
	 * @param	int $service_id 商品id
	 */ 
	public function dropGoods($service_id) {
		if(empty($service_id)) {
			return false;
		}
		$del_state		= Db::delete('service', 'where service_id in ('.$service_id.')');
		if($del_state) {
			$image_more	= Db::select(array('table'=>'flea_upload','field'=>'file_name','where'=>' where item_id in ('.$service_id.') and upload_type in ("12","13")'));
			if(is_array($image_more) && !empty($image_more)){
				foreach ($image_more as $v){
					@unlink(UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$_SESSION['member_id'].DS.$v['file_name']);
				}
			}
			Db::delete('flea_upload','where item_id in ('.$service_id.') and upload_type in ("12","13")');
		}
		return true;
	}
	/**
	 * 闲置物品多图删除
	 *
	 * @param	array $param 删除条件
	 */ 
	public function dropImageGoods($param) {
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($param);
		$image_more		= Db::select(array('table'=>'flea_upload','where'=>$condition_str,'field'=>'file_name'));
		if(is_array($image_more) && !empty($image_more)){
			foreach ($image_more as $v){
				@unlink(UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$_SESSION['member_id'].DS.$v['file_name']);
			}
		}
		$state = Db::delete('flea_upload',$condition_str);
		return $state;
	}

	/**
	 * 按所属分类查找闲置物品 
	 */
	public function getGoodsByClass($param){
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['table'] = 'service,flea_class';
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
	 * 查询闲置信息id
	 */
	public function getFleaID(){
		$flea_ids = Db::select(array('table'=>'service','field'=>'service_id','limit'=>'27'));
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
		//添加不等于某商品的条件
		if($condition_array['service_id_diff'] != 0) {
			$condition_sql  .= " and service_id<>".$condition_array['service_id_diff'];
		}
		if($condition_array['gc_id_list'] != '') {
			$condition_sql	.= " and `service`.gc_id IN (".ltrim($condition_array['gc_id_list'],',').")";
		}		
		if($condition_array['service_id'] != 0) {
			$condition_sql  .= " and service_id = ".$condition_array['service_id'];
		}
		if($condition_array['keyword'] != '') {
			$condition_sql  .= " and service_name LIKE '%".$condition_array['keyword']."%'";
		}
		if ($condition_array['upload_id'] != '') {
			$condition_sql	.= " and upload_id=".$condition_array['upload_id'];
		}
		if(isset($condition_array['service_id_in'])) {
			if ($condition_array['service_id_in'] == ''){
				$condition_sql	.= " and `service`.service_id in ('') ";
			}else {
				$condition_sql	.= " and `service`.service_id in({$condition_array['service_id_in']})";
			}
		}
		if($condition_array['gc_id'] != '') {
			$condition_sql	.= " and gc_id IN (".$this->_getRecursiveClass(array($condition_array['gc_id'])).")";
			//$condition_sql	.= " and `goods`.gc_id IN ({$condition_array['gc_id']})";
		}
		if(isset($condition_array['gc_id_in'])) {
			if ($condition_array['gc_id_in'] == ''){
				$condition_sql	.= " and `service`.gc_id in ('') ";
			}else {
				$condition_sql	.= " and `service`.gc_id in({$condition_array['gc_id_in']})";
			}
		}
		if($condition_array['key_input'] != '') {
			$condition_sql	.= " and (service_name LIKE '%{$condition_array['key_input']}%' or service_tag like '%{$condition_array['key_input']}%')";
		}
		/*	检索	*/
		if($condition_array['pic_input'] ==2) {
			$condition_sql	.= " and service_image <> ''";
		}
		if($condition_array['body_input'] ==2) {
			$condition_sql	.= " and service_body <> ''";
		}
		if($condition_array['seller_input'] != '') {
			$condition_sql	.= " and member_id = ".$condition_array['seller_input'];
		}
		if($condition_array['quality_input'] != '') {
			if($condition_array['quality_input']==7){
				$condition_sql	.= " and flea_quality <= 7";
			}else{
				$condition_sql	.= " and flea_quality >= ".$condition_array['quality_input'];
			}
		}
		if($condition_array['start_input'] != '') {
			$condition_sql	.= " and service_now_price >= ".$condition_array['start_input'];
		}
		if($condition_array['end_input'] != '') {
			$condition_sql	.= " and service_now_price <= ".$condition_array['end_input'];
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
