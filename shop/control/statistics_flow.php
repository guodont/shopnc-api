<?php
/**
 * 行业分析
 ***/


defined('InShopNC') or exit('Access Invalid!');

class statistics_flowControl extends BaseSellerControl{
    private $search_arr;//处理后的参数

    public function __construct(){
        parent::__construct();
        Language::read('stat');
        import('function.statistics');
        import('function.datehelper');
        $model = Model('stat');
        //存储参数
		$this->search_arr = $_REQUEST;
		//处理搜索时间
	    $this->search_arr = $model->dealwithSearchTime($this->search_arr);
		//获得系统年份
		$year_arr = getSystemYearArr();
		//获得系统月份
		$month_arr = getSystemMonthArr();
		//获得本月的周时间段
		$week_arr = getMonthWeekArr($this->search_arr['week']['current_year'], $this->search_arr['week']['current_month']);
		Tpl::output('year_arr', $year_arr);
		Tpl::output('month_arr', $month_arr);
		Tpl::output('week_arr', $week_arr);
        Tpl::output('search_arr', $this->search_arr);
    }

	/**
	 * 店铺流量统计
	 */
    public function storeflowOp() {
        $store_id = intval($_SESSION['store_id']);
        //确定统计分表名称
		$last_num = $store_id % 10; //获取店铺ID的末位数字
		$tablenum = ($t = intval(C('flowstat_tablenum'))) > 1 ? $t : 1; //处理流量统计记录表数量
		$flow_tablename = ($t = ($last_num % $tablenum)) > 0 ? "flowstat_$t" : 'flowstat';
		if(!$this->search_arr['search_type']){
			$this->search_arr['search_type'] = 'week';
		}
        $model = Model('stat');
        //获得搜索的开始时间和结束时间
		$searchtime_arr = $model->getStarttimeAndEndtime($this->search_arr);
		$where = array();
		$where['store_id'] = $store_id;
		$where['stattime'] = array('between',$searchtime_arr);
		$where['type'] = 'sum';

		$field = ' SUM(clicknum) as amount';
	    if($this->search_arr['search_type'] == 'week'){
			//构造横轴数据
	        for($i=1; $i<=7; $i++){
	            $tmp_weekarr = getSystemWeekArr();
				//横轴
				$stat_arr['xAxis']['categories'][] = $tmp_weekarr[$i];
				unset($tmp_weekarr);
				$statlist[$i] = 0;
			}
			$field .= ' ,WEEKDAY(FROM_UNIXTIME(stattime))+1 as timeval ';
		}
	    if($this->search_arr['search_type'] == 'month'){
			//计算横轴的最大量（由于每个月的天数不同）
			$dayofmonth = date('t',$searchtime_arr[0]);
		    //构造横轴数据
			for($i=1; $i<=$dayofmonth; $i++){
				//横轴
				$stat_arr['xAxis']['categories'][] = $i;
				$statlist[$i] = 0;
			}
			$field .= ' ,day(FROM_UNIXTIME(stattime)) as timeval ';
		}
		$statlist_tmp = $model->statByFlowstat($flow_tablename, $where, $field, 0, 0, 'timeval asc', 'timeval');
		if ($statlist_tmp){
    	    foreach((array)$statlist_tmp as $k=>$v){
    	        $statlist[$v['timeval']] = floatval($v['amount']);
    		}
		}
        //得到统计图数据
		$stat_arr['legend']['enabled'] = false;
		$stat_arr['series'][0]['name'] = '访问量';
		$stat_arr['series'][0]['data'] = array_values($statlist);
		$stat_arr['title'] = '店铺访问量统计';
        $stat_arr['yAxis'] = '访问次数';
		$stat_json = getStatData_LineLabels($stat_arr);
        Tpl::output('stat_json',$stat_json);
		self::profile_menu('storeflow');
		Tpl::showpage('stat.flow.store');
	}

	/**
	 * 商品流量统计
	 */
    public function goodsflowOp() {
        $store_id = intval($_SESSION['store_id']);
        //确定统计分表名称
		$last_num = $store_id % 10; //获取店铺ID的末位数字
		$tablenum = ($t = intval(C('flowstat_tablenum'))) > 1 ? $t : 1; //处理流量统计记录表数量
		$flow_tablename = ($t = ($last_num % $tablenum)) > 0 ? "flowstat_$t" : 'flowstat';
		if(!$this->search_arr['search_type']){
			$this->search_arr['search_type'] = 'week';
		}
        $model = Model('stat');
        //获得搜索的开始时间和结束时间
		$searchtime_arr = $model->getStarttimeAndEndtime($this->search_arr);
		$where = array();
		$where['store_id'] = $store_id;
		$where['stattime'] = array('between',$searchtime_arr);
		$where['type'] = 'goods';

		$field = ' goods_id,SUM(clicknum) as amount';
		$stat_arr = array();
        //构造横轴数据
        for($i=1; $i<=30; $i++){
			//横轴
			$stat_arr['xAxis']['categories'][] = $i;
			$stat_arr['series'][0]['data'][] = array('name'=>'','y'=>0);
		}
		$statlist_tmp = $model->statByFlowstat($flow_tablename, $where, $field, 0, 30, 'amount desc,goods_id asc', 'goods_id');
		if ($statlist_tmp){
		    $goodsid_arr = array();
    	    foreach((array)$statlist_tmp as $k=>$v){
    	        $goodsid_arr[] = $v['goods_id'];
    		}
    		//查询相应商品
		    $goods_list_tmp = $model->statByGoods(array('goods_id'=>array('in',$goodsid_arr)), $field = 'goods_name,goods_id');
		    foreach ((array)$goods_list_tmp as $k=>$v){
		        $goods_list[$v['goods_id']] = $v;
		    }
		    foreach((array)$statlist_tmp as $k=>$v){
		        $v['goods_name'] = $goods_list[$v['goods_id']];
		        $v['amount'] = floatval($v['amount']);
		        $statlist[] = $v;
		        $stat_arr['series'][0]['data'][$k] = array('name'=>strval($goods_list[$v['goods_id']]['goods_name']),'y'=>floatval($v['amount']));
		    }
		}
        //得到统计图数据
		$stat_arr['legend']['enabled'] = false;
		$stat_arr['series'][0]['name'] = '访问量';
		$stat_arr['title'] = '商品访问量TOP30';
        $stat_arr['yAxis'] = '访问次数';
		$stat_json = getStatData_Column2D($stat_arr);
        Tpl::output('stat_json',$stat_json);
		self::profile_menu('goodsflow');
		Tpl::showpage('stat.flow.goods');
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key='') {
        $menu_array	= array(
            1=>array('menu_key'=>'storeflow','menu_name'=>'店铺总流量','menu_url'=>'index.php?act=statistics_flow&op=storeflow'),
            2=>array('menu_key'=>'goodsflow','menu_name'=>'商品流量排名','menu_url'=>'index.php?act=statistics_flow&op=goodsflow')
        );
        Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
