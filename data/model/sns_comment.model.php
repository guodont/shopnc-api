<?php
/**
 * 好友动态
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class sns_commentModel{
	/**
	 * 新增评论
	 *
	 * @param $param 添加信息数组
	 * @return 返回结果
	 */
	public function commentAdd($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$result = Db::insert('sns_comment',$param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 评论记录列表
	 *
	 * @param $condition 条件
	 * @param $page 分页
	 * @param $field 查询字段
	 * @return array 数组格式的返回结果
	 */
	public function getCommentList($condition,$page='',$field='*'){
		$condition_str	= $this->getCondition($condition);
		$param	= array();
		$param['table']	= 'sns_comment';
		$param['where']	= $condition_str;
		$param['field'] = $field;
		$param['order'] = $condition['order'] ? $condition['order'] : 'sns_comment.comment_id desc';
		$param['limit'] = $condition['limit'];
		$param['group'] = $condition['group'];
		return Db::select($param,$page);
	}
	/**
	 * 评论总数
	 *
	 * @param $condition 条件
	 * @param $field 查询字段
	 * @return array 数组格式的返回结果
	 */
	public function getCommentCount($condition){
		$condition_str	= $this->getCondition($condition);
		return Db::getCount("sns_comment",$condition_str);
	}
	/**
	 * 获取评论详细
	 * 
	 * @param $condition 查询条件
	 * @param $field 查询字段
	 */
	public function getCommentRow($condition,$field='*'){
		$param = array();
		$param['table'] = 'sns_comment';
		$param['field'] = array_keys($condition);
		$param['value'] = array_values($condition);
		return Db::getRow($param,$field);
	}
	/**
	 * 删除评论
	 */
	public function delComment($condition){
		if (empty($condition)){
			return false;
		}
		$condition_str = '';
		if ($condition['comment_id'] != ''){
			$condition_str .= " and comment_id='{$condition['comment_id']}' ";
		}
		if($condition['comment_id_in'] != '') {
			$condition_str .= " and comment_id in('{$condition['comment_id_in']}')";
		}
		if ($condition['comment_originalid_in'] !=''){
			$condition_str .= " and comment_originalid in('{$condition['comment_originalid_in']}') ";
		}
		if ($condition['comment_originalid'] != ''){
			$condition_str .= " and comment_originalid='{$condition['comment_originalid']}' ";
		}
		if ($condition['comment_originaltype'] != ''){
			$condition_str .= " and comment_originaltype = '{$condition['comment_originaltype']}' ";
		}
		return Db::delete('sns_comment',$condition_str);
	}
	/**
	 * 更新评论记录
	 * @param	array $param 修改信息数组
	 * @param	array $condition 条件数组
	 */
	public function commentEdit($param,$condition){
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$result	= Db::update('sns_comment',$param,$condition_str);
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
		//ID in
		if($condition_array['comment_id_in'] != '') {
			$condition_sql .= " and sns_comment.comment_id in('{$condition_array['comment_id_in']}')";
		}
		//原帖ID
		if($condition_array['comment_originalid'] != '') {
			$condition_sql .= " and sns_comment.comment_originalid = '{$condition_array['comment_originalid']}'";
		}
		//原帖类型
		if($condition_array['comment_originaltype'] != '') {
			$condition_sql .= " and sns_comment.comment_originaltype = '{$condition_array['comment_originaltype']}'";
		}
		//会员名like
		if($condition_array['comment_membername_like'] != '') {
			$condition_sql .= " and sns_comment.comment_membername like '%{$condition_array['comment_membername_like']}%'";
		}
		//状态
		if($condition_array['comment_state'] != '') {
			$condition_sql .= " and sns_comment.comment_state = '{$condition_array['comment_state']}'";
		}
		//内容
		if($condition_array['comment_content_like'] != '') {
			$condition_sql .= " and sns_comment.comment_content like '%{$condition_array['comment_content_like']}%'";
		}
		//添加时间
		if ($condition_array['stime'] !=''){
			$condition_sql	.= " and `sns_comment`.comment_addtime >= {$condition_array['stime']}";
		}
		if ($condition_array['etime'] !=''){
			$condition_sql	.= " and `sns_comment`.comment_addtime <= {$condition_array['etime']}";
		}
		return $condition_sql;
	}
}