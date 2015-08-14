<?php
/**
 * 统计管理
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class statModel extends Model{
    /**
     * 查询新增会员统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @param boolean $lock 是否锁定
     * @return array
     */
    public function statByMember($where, $field = '*', $page = 0, $order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('member')->field($field)->where($where)->page($page[0],$page[1])->order($order)->group($group)->select();
            } else {
                return $this->table('member')->field($field)->where($where)->page($page[0])->order($order)->group($group)->select();
            }
        } else {
            return $this->table('member')->field($field)->where($where)->page($page)->order($order)->group($group)->select();
        }  
    }
	/**
     * 查询单条会员统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @return array
     */
    public function getoneByMember($where, $field = '*', $order = '', $group = '') {
        return $this->table('member')->field($field)->where($where)->order($order)->group($group)->find();
    }
	/**
     * 查询单条店铺统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @return array
     */
    public function getoneByStore($where, $field = '*', $order = '', $group = '') {
        return $this->table('store')->field($field)->where($where)->order($order)->group($group)->find();
    }
	/**
     * 查询店铺统计
     */
    public function statByStore($where, $field = '*', $page = 0, $limit = 0, $order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('store')->field($field)->where($where)->page($page[0],$page[1])->limit($limit)->group($group)->order($order)->select();
            } else {
                return $this->table('store')->field($field)->where($where)->page($page[0])->limit($limit)->group($group)->order($order)->select();
            }
        } else {
            return $this->table('store')->field($field)->where($where)->page($page)->limit($limit)->group($group)->order($order)->select();
        }
    }
    /**
     * 查询新增店铺统计
     */
	public function getNewStoreStatList($condition, $field = '*', $page = 0, $order = 'store_id desc', $limit = 0, $group = '') {
        return $this->table('store')->field($field)->where($condition)->page($page)->limit($limit)->group($group)->order($order)->select();
    }
    
    /**
     * 查询会员列表
     */
    public function getMemberList($where, $field = '*', $page = 0, $order = 'member_id desc', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('member')->field($field)->where($where)->page($page[0],$page[1])->group($group)->order($order)->select();
            } else {
                return $this->table('member')->field($field)->where($where)->page($page[0])->group($group)->order($order)->select();
            }
        } else {
            return $this->table('member')->field($field)->where($where)->page($page)->group($group)->order($order)->select();
        }
    }
    
    /**
     * 调取店铺等级信息
     */
    public function getStoreDegree(){
    	$tmp = $this->table('store_grade')->field('sg_id,sg_name')->where(true)->select();
    	$sd_list = array();
    	if(!empty($tmp)){
	    	foreach ($tmp as $k=>$v){
	    		$sd_list[$v['sg_id']] = $v['sg_name'];
	    	}
    	}
    	return $sd_list;
    }
    
    /**
     * 查询会员统计数据记录
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByStatmember($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('stat_member')->field($field)->where($where)->page($page[0],$page[1])->limit($limit)->order($order)->group($group)->select();
            } else {
                return $this->table('stat_member')->field($field)->where($where)->page($page[0])->limit($limit)->order($order)->group($group)->select();
            }
        } else {
            return $this->table('stat_member')->field($field)->where($where)->page($page)->limit($limit)->order($order)->group($group)->select();
        }
    }
    
    /**
     * 查询商品数量
     */
    public function getGoodsNum($where){
    	$rs = $this->field('count(*) as allnum')->table('goods_common')->where($where)->select();
    	return $rs[0]['allnum'];
    }
    /**
     * 获取预存款数据
     */
    public function getPredepositInfo($condition, $field = '*', $page = 0, $order = 'lg_add_time desc', $limit = 0, $group = ''){
    	return $this->table('pd_log')->field($field)->where($condition)->page($page)->limit($limit)->group($group)->order($order)->select();
    }
    /**
     * 获取结算数据
     */
    public function getBillList($condition,$type,$have_page=true){
    	switch ($type){
    		case 'os'://平台
    			return $this->field('sum(os_order_totals) as oot,sum(os_order_return_totals) as oort,sum(os_commis_totals-os_commis_return_totals) as oct,sum(os_store_cost_totals) as osct,sum(os_result_totals) as ort')->table('order_statis')->where($condition)->select();
    			break;
    		case 'ob'://店铺
    			$page = $have_page?15:'';
    			return $this->field('order_bill.*,store.member_name')->table('order_bill,store')->join('left join')->on('order_bill.ob_store_id=store.store_id')->where($condition)->page($page)->order('ob_no desc')->select();
    			break;
    	}
    }
	/**
     * 查询订单及订单商品的统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByOrderGoods($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('order_goods,order')->field($field)->join('left')->on('order_goods.order_id=order.order_id')->where($where)->group($group)->page($page[0],$page[1])->limit($limit)->order($order)->select();
            } else {
                return $this->table('order_goods,order')->field($field)->join('left')->on('order_goods.order_id=order.order_id')->where($where)->group($group)->page($page[0])->limit($limit)->order($order)->select();
            }  
        } else {
            return $this->table('order_goods,order')->field($field)->join('left')->on('order_goods.order_id=order.order_id')->where($where)->group($group)->page($page)->limit($limit)->order($order)->select();
        }
    }
	/**
     * 查询订单及订单商品的统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByOrderLog($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('order_log,order')->field($field)->join('left')->on('order_log.order_id = order.order_id')->where($where)->group($group)->page($page[0],$page[1])->limit($limit)->order($order)->select();
            } else {
                return $this->table('order_log,order')->field($field)->join('left')->on('order_log.order_id = order.order_id')->where($where)->group($group)->page($page[0])->limit($limit)->order($order)->select();
            }  
        } else {
            return $this->table('order_log,order')->field($field)->join('left')->on('order_log.order_id = order.order_id')->where($where)->group($group)->page($page)->limit($limit)->order($order)->select();
        }
    }
	/**
     * 查询退款退货统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByRefundreturn($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('refund_return')->field($field)->where($where)->group($group)->page($page[0],$page[1])->limit($limit)->order($order)->select();
            } else {
                return $this->table('refund_return')->field($field)->where($where)->group($group)->page($page[0])->limit($limit)->order($order)->select();
            }
        } else {
            return $this->table('refund_return')->field($field)->where($where)->group($group)->page($page)->limit($limit)->order($order)->select();
        }
    }
	/**
     * 查询店铺动态评分统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByStoreAndEvaluatestore($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = ''){
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('evaluate_store,store')->field($field)->join('left')->on('evaluate_store.seval_storeid=store.store_id')->where($where)->group($group)->page($page[0],$page[1])->limit($limit)->order($order)->select();
            } else {
                return $this->table('evaluate_store,store')->field($field)->join('left')->on('evaluate_store.seval_storeid=store.store_id')->where($where)->group($group)->page($page[0])->limit($limit)->order($order)->select();
            }
        } else {
            return $this->table('evaluate_store,store')->field($field)->join('left')->on('evaluate_store.seval_storeid=store.store_id')->where($where)->group($group)->page($page)->limit($limit)->order($order)->select();
        }
    }
    /**
	 * 处理搜索时间
	 */
    public function dealwithSearchTime($search_arr){
	    //初始化时间
		//天
		if(!$search_arr['search_time']){
		    $search_arr['search_time'] = date('Y-m-d', time()- 86400);
		}
		$search_arr['day']['search_time'] = strtotime($search_arr['search_time']);//搜索的时间
		
		//周
		if(!$search_arr['searchweek_year']){
			$search_arr['searchweek_year'] = date('Y', time());
		}
		if(!$search_arr['searchweek_month']){
			$search_arr['searchweek_month'] = date('m', time());
		}
		if(!$search_arr['searchweek_week']){
			$search_arr['searchweek_week'] =  implode('|', getWeek_SdateAndEdate(time()));
		}
		$weekcurrent_year = $search_arr['searchweek_year'];
		$weekcurrent_month = $search_arr['searchweek_month'];
		$weekcurrent_week = $search_arr['searchweek_week'];
		$search_arr['week']['current_year'] = $weekcurrent_year;
		$search_arr['week']['current_month'] = $weekcurrent_month;
		$search_arr['week']['current_week'] = $weekcurrent_week;
		
		//月
		if(!$search_arr['searchmonth_year']){
			$search_arr['searchmonth_year'] = date('Y', time());
		}
		if(!$search_arr['searchmonth_month']){
			$search_arr['searchmonth_month'] = date('m', time());
		}
		$monthcurrent_year = $search_arr['searchmonth_year'];
		$monthcurrent_month = $search_arr['searchmonth_month'];
		$search_arr['month']['current_year'] = $monthcurrent_year;
		$search_arr['month']['current_month'] = $monthcurrent_month;
		return $search_arr;
	}
	/**
	 * 获得查询的开始和结束时间
	 */
	public function getStarttimeAndEndtime($search_arr){
	    if($search_arr['search_type'] == 'day'){
			$stime = $search_arr['day']['search_time'];//今天0点
			$etime = $search_arr['day']['search_time'] + 86400 - 1;//今天24点
		}
	    if($search_arr['search_type'] == 'week'){
	        $current_weekarr = explode('|', $search_arr['week']['current_week']);
			$stime = strtotime($current_weekarr[0]);
			$etime = strtotime($current_weekarr[1])+86400-1;
		}
	    if($search_arr['search_type'] == 'month'){
	        $stime = strtotime($search_arr['month']['current_year'].'-'.$search_arr['month']['current_month']."-01 0 month");
			$etime = getMonthLastDay($search_arr['month']['current_year'],$search_arr['month']['current_month'])+86400-1;
		}
		return array($stime,$etime);
	}
	/**
     * 查询会员统计数据单条记录
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @return array
     */
    public function getOneStatmember($where, $field = '*', $order = '', $group = ''){
        return $this->table('stat_member')->field($field)->where($where)->group($group)->order($order)->find();
    }
	/**
     * 更新会员统计数据单条记录
     * 
     * @param array $condition 条件
     * @param array $update_arr 更新数组
     * @return array
     */
    public function updateStatmember($where,$update_arr){
        return $this->table('stat_member')->where($where)->update($update_arr);
    }
	/**
     * 查询订单的统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByOrder($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('order')->field($field)->where($where)->group($group)->page($page[0],$page[1])->limit($limit)->order($order)->select();
            } else {
                return $this->table('order')->field($field)->where($where)->group($group)->page($page[0])->limit($limit)->order($order)->select();
            }   
        } else {
            return $this->table('order')->field($field)->where($where)->group($group)->page($page)->limit($limit)->order($order)->select();
        }
    }
	/**
     * 查询积分的统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByPointslog($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('points_log')->field($field)->where($where)->group($group)->page($page[0],$page[1])->limit($limit)->order($order)->select();
            } else {
                return $this->table('points_log')->field($field)->where($where)->group($group)->page($page[0])->limit($limit)->order($order)->select();
            }
        } else {
            return $this->table('points_log')->field($field)->where($where)->group($group)->page($page)->limit($limit)->order($order)->select();
        }
    }
	/**
     * 删除会员统计数据记录
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function delByStatmember($where = array()) {
        $this->table('stat_member')->where($where)->delete();   
    }
    /**
     * 查询订单商品缓存的统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @return array
     */
    public function getoneByStatordergoods($where, $field = '*', $order = '', $group = '') {
        return $this->table('stat_ordergoods')->field($field)->where($where)->group($group)->order($order)->find();
    }
	/**
     * 查询订单商品缓存的统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByStatordergoods($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('stat_ordergoods')->field($field)->where($where)->group($group)->page($page[0],$page[1])->limit($limit)->order($order)->select();
            } else {
                return $this->table('stat_ordergoods')->field($field)->where($where)->group($group)->page($page[0])->limit($limit)->order($order)->select();
            }   
        } else {
            return $this->table('stat_ordergoods')->field($field)->where($where)->group($group)->page($page)->limit($limit)->order($order)->select();
        }
    }
	/**
     * 查询订单缓存的统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @return array
     */
    public function getoneByStatorder($where, $field = '*', $order = '', $group = '') {
        return $this->table('stat_order')->field($field)->where($where)->group($group)->order($order)->find();
    }
	/**
     * 查询订单缓存的统计
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByStatorder($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('stat_order')->field($field)->where($where)->group($group)->page($page[0],$page[1])->limit($limit)->order($order)->select();
            } else {
                return $this->table('stat_order')->field($field)->where($where)->group($group)->page($page[0])->limit($limit)->order($order)->select();
            }   
        } else {
            return $this->table('stat_order')->field($field)->where($where)->group($group)->page($page)->limit($limit)->order($order)->select();
        }
    }
	/**
     * 查询商品列表
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByGoods($where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table('goods')->field($field)->where($where)->group($group)->page($page[0],$page[1])->limit($limit)->order($order)->select();
            } else {
                return $this->table('goods')->field($field)->where($where)->group($group)->page($page[0])->limit($limit)->order($order)->select();
            }   
        } else {
            return $this->table('goods')->field($field)->where($where)->group($group)->page($page)->limit($limit)->order($order)->select();
        }
    }
    
    /**
     * 查询流量统计单条记录
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @return array
     */
    public function getoneByFlowstat($tablename = 'flowstat', $where, $field = '*', $order = '', $group = '') {
        return $this->table($tablename)->field($field)->where($where)->group($group)->order($order)->find();
    }
	/**
     * 查询流量统计记录
     * 
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @return array
     */
    public function statByFlowstat($tablename = 'flowstat', $where, $field = '*', $page = 0, $limit = 0,$order = '', $group = '') {
        if (is_array($page)){
            if ($page[1] > 0){
                return $this->table($tablename)->field($field)->where($where)->group($group)->page($page[0],$page[1])->limit($limit)->order($order)->select();
            } else {
                return $this->table($tablename)->field($field)->where($where)->group($group)->page($page[0])->limit($limit)->order($order)->select();
            }   
        } else {
            return $this->table($tablename)->field($field)->where($where)->group($group)->page($page)->limit($limit)->order($order)->select();
        }
    }
}