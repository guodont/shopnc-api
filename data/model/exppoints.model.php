<?php
/**
 * 经验值及经验值日志管理
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class exppointsModel extends Model{
	/**
	 * 操作经验值
	 * @author ShopNC Develop Team
	 * @param  string $stage 操作阶段 login(登录),comments(评论),order(下单)
	 * @param  array $insertarr 该数组可能包含信息 array('exp_memberid'=>'会员编号','exp_membername'=>'会员名称','exp_points'=>'经验值','exp_desc'=>'描述','orderprice'=>'订单金额','order_sn'=>'订单编号','order_id'=>'订单序号');
	 * @param  bool $if_repeat 是否可以重复记录的信息,true可以重复记录，false不可以重复记录，默认为true
	 * @return bool
	 */
	function saveExppointsLog($stage,$insertarr){
		if (!$insertarr['exp_memberid']){
			return false;
		}
		$exppoints_rule = C("exppoints_rule")?unserialize(C("exppoints_rule")):array();
		//记录原因文字
		switch ($stage){
			case 'login':
				if (!$insertarr['exp_desc']){
					$insertarr['exp_desc'] = '会员登录';
				}
				$insertarr['exp_points'] = 0;
				if (intval($exppoints_rule['exp_login']) > 0){
				    $insertarr['exp_points'] = intval($exppoints_rule['exp_login']);
				}
				break;
			case 'comments':
				if (!$insertarr['exp_desc']){
					$insertarr['exp_desc'] = '评论商品';
				}
				$insertarr['exp_points'] = 0;
				if (intval($exppoints_rule['exp_comments']) > 0){
				    $insertarr['exp_points'] = intval($exppoints_rule['exp_comments']);
				}
				break;
			case 'order':
				if (!$insertarr['exp_desc']){
					$insertarr['exp_desc'] = '订单'.$insertarr['order_sn'].'购物消费';
				}
				$insertarr['exp_points'] = 0;
				$exppoints_rule['exp_orderrate'] = floatval($exppoints_rule['exp_orderrate']);
				if ($insertarr['orderprice'] && $exppoints_rule['exp_orderrate'] > 0){
					$insertarr['exp_points'] = @intval($insertarr['orderprice']/$exppoints_rule['exp_orderrate']);
					$exp_ordermax = intval($exppoints_rule['exp_ordermax']);
					if ($exp_ordermax > 0 && $insertarr['exp_points'] > $exp_ordermax){
						$insertarr['exp_points'] = $exp_ordermax;
					}
				}
				break;
		}
		//新增日志
		$value_array = array();
		$value_array['exp_memberid'] = $insertarr['exp_memberid'];
		$value_array['exp_membername'] = $insertarr['exp_membername'];
		$value_array['exp_points'] = $insertarr['exp_points'];
		$value_array['exp_addtime'] = time();
		$value_array['exp_desc'] = $insertarr['exp_desc'];
		$value_array['exp_stage'] = $stage;
		$result = false;
		if($value_array['exp_points'] != '0'){
			$result = self::addExppointsLog($value_array);
		}
		if ($result){
			//更新member内容
			$obj_member = Model('member');
			$upmember_array = array();
			$upmember_array['member_exppoints'] = array('exp','member_exppoints + '.$insertarr['exp_points']);
			$obj_member->editMember(array('member_id'=>$insertarr['exp_memberid']),$upmember_array);
			return true;
		}else {
			return false;
		}
	}
	/**
	 * 添加经验值日志信息
	 *
	 * @param array $param 添加信息数组
	 */
	public function addExppointsLog($param) {
		if(empty($param)) {
			return false;
		}
		$result = $this->table('exppoints_log')->insert($param);
		return $result;
	}
	
	/**
	 * 经验值日志总条数
	 *
	 * @param array $where 条件数组
	 * @param array $field   查询字段
	 * @param array $group   分组
	 */
	public function getExppointsLogCount($where, $field = '*', $group = '') {
	    $count = $this->table('exppoints_log')->field($field)->where($where)->group($group)->count();
	    return $count;
	}
	
	/**
	 * 经验值日志列表
	 *
	 * @param array $where 条件数组
	 * @param mixed $page   分页
	 * @param string $field   查询字段
	 * @param int $limit   查询条数
	 * @param string $order   查询条数
	 */
	public function getExppointsLogList($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
	    if (is_array($page)){
	        if ($page[1] > 0){
	            return $this->table('exppoints_log')->field($field)->where($where)->page($page[0],$page[1])->order($order)->group($group)->select();
	        } else {
	            return $this->table('exppoints_log')->field($field)->where($where)->page($page[0])->order($order)->group($group)->select();
	        }
	    } else {
            return $this->table('exppoints_log')->field($field)->where($where)->page($page)->order($order)->group($group)->select();
        }
	}
	/**
	  * 获得阶段说明文字
	  */
	public function getStage(){
	    $stage_arr = array();
		$stage_arr['login'] = '会员登录';
		$stage_arr['comments'] = '商品评论';
		$stage_arr['order'] = '订单消费';
		return $stage_arr;
	}	
}
