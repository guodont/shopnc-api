<?php
/**
 * SNS好友管理
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class sns_friendModel{
	/**
	 * 好友添加
	 *
	 * @param	array $param 添加信息数组
	 */
	public function addFriend($param) {
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$result = Db::insert('sns_friend',$param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 好友列表
	 *
	 * @param	array $condition	条件数组
	 * @param	string $field 	显示字段
	 * @param	obj $obj_page 	分页
	 * @param	string $type 	查询类型
	 */
	public function listFriend($condition,$field='*',$obj_page='',$type='simple') {
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$param	= array();
		switch ($type){
			case 'simple':
				$param['table']		= 'sns_friend';
				break;
			case 'detail':
				$param['table']		= 'sns_friend,member';
				$param['join_type']	= 'INNER JOIN';
				$param['join_on']	= array('sns_friend.friend_tomid=member.member_id');
				break;
			case 'fromdetail':
				$param['table']		= 'sns_friend,member';
				$param['join_type']	= 'INNER JOIN';
				$param['join_on']	= array('sns_friend.friend_frommid=member.member_id');
				break;
		}
		$param['where']	= $condition_str;
		$param['field']	= $field;
		$param['order'] = $condition['order'] ? $condition['order'] : 'sns_friend.friend_id desc';
		$param['limit'] = $condition['limit'];
		$param['group'] = $condition['group'];
		$friend_list	= Db::select($param,$obj_page);
		return $friend_list;
	}
	/**
	 * 获取好友详细
	 * 
	 * @param $condition 查询条件
	 * @param $field 查询字段
	 */
	public function getFriendRow($condition,$field='*'){
		$param = array();
		$param['table'] = 'sns_friend';
		$param['field'] = array_keys($condition);
		$param['value'] = array_values($condition);
		return Db::getRow($param,$field);
	}
	/**
	 * 好友总数
	 */
	public function countFriend($condition){
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$count = Db::getCount('sns_friend',$condition_str);
		return $count;
	}
	/**
	 * 更新好友信息
	 * @param $param 更新内容
	 * @param $condition 更新条件
	 */
	public function editFriend($param,$condition) {
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$result	= Db::update('sns_friend',$param,$condition_str);
		return $result;
	}
	/**
	 * 删除关注
	 */
	public function delFriend($condition){
		if (empty($condition)){
			return false;
		}
		if ($condition['friend_frommid'] != ''){
			$condition_str .= " and friend_frommid='{$condition['friend_frommid']}' ";
		}
		if ($condition['friend_tomid'] != ''){
			$condition_str .= " and friend_tomid='{$condition['friend_tomid']}' ";
		}
		return Db::delete('sns_friend',$condition_str);
	}
	
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $conditon_array
	 * @return	string
	 */
	private function getCondition($conditon_array){
		$condition_sql = '';
		//自增编号
		if($conditon_array['friend_id'] != '') {
			$condition_sql	.= " and sns_friend.friend_id= '{$conditon_array['friend_id']}'";
		}
		//会员编号
		if($conditon_array['friend_frommid'] != '') {
			$condition_sql	.= " and sns_friend.friend_frommid= '{$conditon_array['friend_frommid']}'";
		}
		//朋友编号
		if($conditon_array['friend_tomid'] != '') {
			$condition_sql	.= " and sns_friend.friend_tomid = '{$conditon_array['friend_tomid']}'";
		}
		//关注状态
		if($conditon_array['friend_followstate'] != '') {
			$condition_sql	.= " and sns_friend.friend_followstate = '{$conditon_array['friend_followstate']}'";
		}
		return $condition_sql;
	}
}