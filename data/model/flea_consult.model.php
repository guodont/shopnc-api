<?php
/**
 * 闲置物品咨询管理
 *by 3 3hao .com 
 */
defined('InShopNC') or exit('Access Invalid!');
class flea_consultModel {
	/**
	 * 添加咨询
	 * 
	 * @param unknown_type $input
	 */
	public function addConsult($input){
		if(empty($input)) {
			return false;
		}
		$consult	= array();
		$consult['seller_id']		= $input['seller_id'];
		$consult['member_id']		= $input['member_id'];
		$consult['goods_id']		= $input['goods_id'];
		$consult['email']			= trim($input['email']);
		$consult['consult_content']	= trim($input['consult_content']);
		$consult['consult_addtime']	= time();
		$consult['type']			= $input['type'];
		$result	= Db::insert('flea_consult',$consult);
		if($result) {
			return $result;
		} else {
			return false;
		}
	}
	/**
	 * 根据编号查询咨询
	 * 
	 * @param unknown_type $id
	 */
	public function getOneById($id){
		$param	= array();
		$param['table']	= 'flea_consult';
		$param['field']	= 'consult_id';
		$param['value']	= $id;
		$result	= Db::getRow($param);
		return $result;
	}
	/**
	 * 查询咨询
	 * 
	 * @param unknown_type $condition 查询条件数组
	 * @param unknown_type $obj_page 分页对象
	 * @param unknown_type $type 查询范围
	 * @param unknown_type $ctype 咨询类型
	 */
	public function getConsultList($condition,$obj_page='',$type="simple",$ctype='goods'){
		$condition_str = $this->getCondition($condition);
		$param = array();
		$param['where'] = $condition_str;
		switch($type){
			case 'seller':
				$param['field']		= 'flea_consult.*,member.member_name,flea.goods_name';
				$param['table'] 	= 'flea_consult,member,flea';
				$param['join_type']	= 'LEFT JOIN';
				$param['join_on']	= array('flea_consult.member_id = member.member_id','flea_consult.goods_id = flea.goods_id');
				break;
		}
		$param['order'] = $condition['order'];
		$consult_list = Db::select($param,$obj_page);
		return $consult_list;
	}
	/**
	 * 删除咨询
	 * 
	 * @param unknown_type $id
	 */
	public function dropConsult($id){
		return Db::delete('flea_consult',"where consult_id in ({$id})");
	}
	/**
	 * 回复咨询
	 * 
	 * @param unknown_type $input
	 */
	public function replyConsult($input){
		$input['consult_reply_time']	= time();
		return Db::update('flea_consult',$input,'consult_id='.$input['consult_id']);
	}
	/**
	 * 构造查询条件
	 * 
	 * @param unknown_type $condition_array
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		if($condition_array['member_id'] != '') {
			$condition_sql	.= " and flea_consult.member_id=".$condition_array['member_id'];
		}
		if($condition_array['seller_id'] != '') {
			$condition_sql	.= " and flea_consult.seller_id=".$condition_array['seller_id'];
		}
		if($condition_array['goods_id'] != '') {
			$condition_sql	.= " and flea_consult.goods_id=".$condition_array['goods_id'];
		}
		if($condition_array['type'] != ''){
			if($condition_array['type'] == 'to_reply'){
				$condition_sql	.= " and flea_consult.consult_reply IS NULL";
			}
			if($condition_array['type'] == 'replied'){
				$condition_sql	.= " and flea_consult.consult_reply IS NOT NULL";
			}
		}
		if($condition_array['type_name']!=''){
			$condition_sql	.= " and flea_consult.type ='".$condition_array['type_name']."'";
		}
		if($condition_array['consult_id'] != '') {
			$condition_sql	.= " and flea_consult.consult_id=".$condition_array['consult_id'];
		}
		if($condition_array['member_name'] != ''){
			$condition_sql	.= " and member.member_name like '".$condition_array['member_name']."'";
		}
		if($condition_array['consult_content'] != ''){
			$condition_sql	.= " and flea_consult.consult_content like '".$condition_array['consult_content']."'";
		}
		return $condition_sql;
	}
}