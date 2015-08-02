<?php
/**
 * 好友动态
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class sns_tracelogModel{
	/**
	 * 新增动态
	 *
	 * @param $param 添加信息数组
	 * @return 返回结果
	 */
	public function tracelogAdd($param){
		if (empty($param)){
			return false;
		}
		//处理文本中@信息
		if ($param['trace_title']){
			preg_match_all("/@(.+?)([\s|:|：]|$)/is", $param['trace_title'], $matches);
			if (!empty($matches[1])){
				//查询会员信息
				$member_model = Model('member');
				$member_list = $member_model->getMemberList(array('member_name'=>array('in', $matches[1])));
				foreach ($member_list as $k=>$v){
					$param['trace_title'] = preg_replace("/@(".$v['member_name'].")([\s|:|：]|$)/is",'<a href=\"%siteurl%index.php?act=member_snshome&mid='.$v['member_id'].'\" target="_blank">@${1}</a>${2}',$param['trace_title']);
				}
			}
			unset($matches);
		}
		$result = Db::insert('sns_tracelog',$param);
		return $result;
	}
	/**
	 * 动态记录列表
	 *
	 * @param $condition 条件
	 * @param $page 分页
	 * @param $field 查询字段
	 * @return array 数组格式的返回结果
	 */
	public function getTracelogList($condition,$page='',$field='*'){
		$condition_str	= $this->getCondition($condition);
		$param	= array();
		$param['table']	= 'sns_tracelog';
		$param['where']	= $condition_str;
		$param['field'] = $field;
		$param['order'] = $condition['order'] ? $condition['order'] : 'sns_tracelog.trace_id desc';
		$param['limit'] = $condition['limit'];
		$param['group'] = $condition['group'];
		return Db::select($param,$page);
	}
	/**
	 * 获取动态详细
	 * 
	 * @param $condition 查询条件
	 * @param $field 查询字段
	 */
	public function getTracelogRow($condition,$field='*'){
		$param = array();
		$param['table'] = 'sns_tracelog';
		$param['field'] = array_keys($condition);
		$param['value'] = array_values($condition);
		return Db::getRow($param,$field);
	}
	/**
	 * 更新动态记录
	 * @param	array $param 修改信息数组
	 * @param	array $condition 条件数组
	 */
	public function tracelogEdit($param,$condition){
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$result	= Db::update('sns_tracelog',$param,$condition_str);
		return $result;
	}
	/**
	 * 删除动态
	 */
	public function delTracelog($condition){
		if (empty($condition)){
			return false;
		}
		$condition_str = '';	
		if ($condition['trace_id'] != ''){
			$condition_str .= " and trace_id='{$condition['trace_id']}' ";
		}
		if ($condition['trace_id_in'] !=''){
			$condition_str .= " and trace_id in('{$condition['trace_id_in']}') ";
		}
		if ($condition['trace_memberid'] != ''){
			$condition_str .= " and trace_memberid='{$condition['trace_memberid']}' ";
		}
		return Db::delete('sns_tracelog',$condition_str);
	}
	/**
	 * 动态总数
	 */
	public function countTrace($condition){
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$count = Db::getCount('sns_tracelog',$condition_str);
		return $count;
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
		if($condition_array['trace_id'] != '') {
			$condition_sql .= " and sns_tracelog.trace_id = '{$condition_array['trace_id']}' ";
		}
		//自增IDin
		if($condition_array['traceid_in'] != '') {
			$condition_sql .= " and sns_tracelog.trace_id in('{$condition_array['traceid_in']}') ";
		}
		//原帖ID
		if($condition_array['trace_originalid'] != '') {
			$condition_sql .= " and sns_tracelog.trace_originalid = '{$condition_array['trace_originalid']}' ";
		}
		//原帖IDin
		if($condition_array['trace_originalid_in'] != '') {
			$condition_sql .= " and sns_tracelog.trace_originalid in('{$condition_array['trace_originalid_in']}')";
		}
		//会员编号
		if($condition_array['trace_memberid'] != '') {
			$condition_sql .= " and sns_tracelog.trace_memberid = '{$condition_array['trace_memberid']}' ";
		}
		//会员名like
		if($condition_array['trace_membernamelike'] != '') {
			$condition_sql .= " and sns_tracelog.trace_membername like '%{$condition_array['trace_membernamelike']}%' ";
		}
		//查看状态
		if ($condition_array['trace_state'] != ''){
			$condition_sql .= " and sns_tracelog.trace_state = '{$condition_array['trace_state']}' ";
		}
		//允许查看的动态
		if($condition_array['allowshow'] != '') {
			$allowshowsql_arr = array();
			//自己的动态
			if ($condition_array['allowshow_memberid'] !=''){
				$allowshowsql_arr[0] = " (sns_tracelog.trace_memberid = '{$condition_array['allowshow_memberid']}')";
			}
			//查看我关注的人权限为所有人可见的动态
			if ($condition_array['allowshow_followerin'] !=''){
				$allowshowsql_arr[1] .= " (sns_tracelog.trace_privacy=0 and sns_tracelog.trace_memberid in('{$condition_array['allowshow_followerin']}'))";
			}
			//查看好友的权限为好友可见的动态
			if ($condition_array['allowshow_friendin'] !=''){
				$allowshowsql_arr[2] .= " (sns_tracelog.trace_privacy=1 and sns_tracelog.trace_memberid in('{$condition_array['allowshow_friendin']}'))";
			}
			$condition_sql .=" and (".implode(' or ',$allowshowsql_arr).")";
		}
		//隐私权限
		if ($condition_array['trace_privacyin'] !=''){
			$condition_sql	.= " and `sns_tracelog`.trace_privacy in('{$condition_array['trace_privacyin']}')";
		}
		//添加时间
		if ($condition_array['stime'] !=''){
			$condition_sql	.= " and `sns_tracelog`.trace_addtime >= {$condition_array['stime']}";
		}
		if ($condition_array['etime'] !=''){
			$condition_sql	.= " and `sns_tracelog`.trace_addtime <= {$condition_array['etime']}";
		}
		//内容或者标题
		if ($condition_array['trace_contentortitle'] !=''){
			$condition_sql	.= " and (`sns_tracelog`.trace_title like '%{$condition_array['trace_contentortitle']}%' or `sns_tracelog`.trace_content like '%{$condition_array['trace_contentortitle']}%') ";
		}
		return $condition_sql;
	}
}