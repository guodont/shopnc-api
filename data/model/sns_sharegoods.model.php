<?php
/**
 * 分享和喜欢商品
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class sns_sharegoodsModel{
	/**
	 * 新增分享商品
	 *
	 * @param $param 添加信息数组
	 * @return 返回结果
	 */
	public function sharegoodsAdd($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$result = Db::insert('sns_sharegoods',$param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 查询分享商品详细
	 * 
	 * @param $condition 查询条件
	 * @param $field 查询字段
	 */
	public function getSharegoodsInfo($condition,$field='*'){
		$param = array();
		$param['table'] = 'sns_sharegoods';
		$param['field'] = array_keys($condition);
		$param['value'] = array_values($condition);
		return Db::getRow($param,$field);
	}
	/**
	 * 更新分享商品信息
	 * @param $param 更新内容
	 * @param $condition 更新条件
	 */
	public function editSharegoods($param,$condition) {
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$result	= Db::update('sns_sharegoods',$param,$condition_str);
		return $result;
	}
	/**
	 * 分享商品记录列表
	 *
	 * @param $condition 条件
	 * @param $page 分页
	 * @param $field 查询字段
	 * @return array 数组格式的返回结果
	 */
	public function getSharegoodsList($condition,$page='',$field='*',$type = 'simple') {
		$condition_str	= $this->getCondition($condition);
		$param	= array();
		switch ($type){
            case 'detail':
				$param['table'] = 'sns_sharegoods,sns_goods';
				$param['join_type'] = empty($condition['join_type'])?'LEFT JOIN':$condition['join_type'];
				$param['join_on'] = array(
					'sns_sharegoods.share_goodsid=sns_goods.snsgoods_goodsid'
				);
				break;
			default:
				$param['table'] = 'sns_sharegoods';
		}
		$param['where']	= $condition_str;
		$param['field'] = $field;
		$param['order'] = $condition['order'] ? $condition['order'] : 'sns_sharegoods.share_addtime desc';
		$param['limit'] = $condition['limit'];
		$param['group'] = $condition['group'];
		return Db::select($param,$page);
	}
	/**
	 * 删除分享商品
	 */
	public function delSharegoods($condition){
		if (empty($condition)){
			return false;
		}
		$condition_str = '';
		if ($condition['share_id'] != ''){
			$condition_str .= " and share_id='{$condition['share_id']}' ";
		}
		if ($condition['share_memberid'] != ''){
			$condition_str .= " and share_memberid='{$condition['share_memberid']}' ";
		}
		return Db::delete('sns_sharegoods',$condition_str);
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		//自增ID
		if ($condition_array['share_id'] != '') {
			$condition_sql	.= " and `sns_sharegoods`.share_id = '{$condition_array['share_id']}'";
		}
		//大于添加时间
		if ($condition_array['share_addtime_gt'] != '') {
			$condition_sql	.= " and `sns_sharegoods`.share_addtime > '{$condition_array['share_addtime_gt']}'";
		}
		//小于添加时间
		if ($condition_array['share_addtime_lt'] != '') {
			$condition_sql	.= " and `sns_sharegoods`.share_addtime < '{$condition_array['share_addtime_lt']}'";
		}
		//大于喜欢添加时间
		if ($condition_array['share_likeaddtime_gt'] != '') {
			$condition_sql	.= " and `sns_sharegoods`.share_likeaddtime > '{$condition_array['share_likeaddtime_gt']}'";
		}
		//小于喜欢添加时间
		if ($condition_array['share_likeaddtime_lt'] != '') {
			$condition_sql	.= " and `sns_sharegoods`.share_likeaddtime < '{$condition_array['share_likeaddtime_lt']}'";
		}
		//会员ID
		if ($condition_array['share_memberid'] != '') {
			$condition_sql	.= " and `sns_sharegoods`.share_memberid = '{$condition_array['share_memberid']}'";
		}
		//隐私权限
		if ($condition_array['share_privacyin'] !=''){
			$condition_sql	.= " and `sns_sharegoods`.share_privacy in('{$condition_array['share_privacyin']}')";
		}		
		//分享
		if ($condition_array['share_isshare'] != '') {
			$condition_sql	.= " and `sns_sharegoods`.share_isshare = '{$condition_array['share_isshare']}'";
		}
		//喜欢
		if ($condition_array['share_islike'] != '') {
			$condition_sql	.= " and `sns_sharegoods`.share_islike = '{$condition_array['share_islike']}'";
		}
		return $condition_sql;
	}
}