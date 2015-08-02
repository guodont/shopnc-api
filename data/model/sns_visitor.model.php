<?php
/**
 * SNS访客
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class sns_visitorModel{
	/**
	 * 新增访客
	 *
	 * @param $param 添加信息数组
	 * @return 返回结果
	 */
	public function visitorAdd($param){
		if (empty($param)){
			return false;
		}
		$result = Db::insert('sns_visitor',$param);
		return $result;
	}
	/**
	 * 访客列表
	 *
	 * @param $condition 条件
	 * @param $page 分页
	 * @param $field 查询字段
	 * @return array 数组格式的返回结果
	 */
	public function getVisitorList($condition,$page='',$field='*'){
		$condition_str	= $this->getCondition($condition);
		$param	= array();
		$param['table']	= 'sns_visitor';
		$param['where']	= $condition_str;
		$param['field'] = $field;
		$param['order'] = $condition['order'] ? $condition['order'] : 'sns_visitor.v_addtime desc';
		$param['limit'] = $condition['limit'];
		$param['group'] = $condition['group'];
		return Db::select($param,$page);
	}
	/**
	 * 获取访客记录详细
	 * 
	 * @param $condition 查询条件
	 * @param $field 查询字段
	 */
	public function getVisitorRow($condition,$field='*'){
		$param = array();
		$param['table'] = 'sns_visitor';
		$param['field'] = array_keys($condition);
		$param['value'] = array_values($condition);
		return Db::getRow($param,$field);
	}
	/**
	 * 更新访客记录
	 * @param	array $param 修改信息数组
	 * @param	array $condition 条件数组
	 */
	public function visitorEdit($param,$condition){
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$result	= Db::update('sns_visitor',$param,$condition_str);
		return $result;
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		//自增编号
		if($condition_array['v_id'] != '') {
			$condition_sql .= " and sns_visitor.v_id = '{$condition_array['v_id']}' ";
		}
		//访问会员编号
		if($condition_array['v_mid'] != '') {
			$condition_sql .= " and sns_visitor.v_mid = '{$condition_array['v_mid']}' ";
		}
		//主人会员编号
		if($condition_array['v_ownermid'] != '') {
			$condition_sql .= " and sns_visitor.v_ownermid = '{$condition_array['v_ownermid']}' ";
		}
		return $condition_sql;
	}
}