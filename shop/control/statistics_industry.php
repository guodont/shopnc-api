<?php
/**
 * 行业分析
 ***/


defined('InShopNC') or exit('Access Invalid!');

class statistics_industryControl extends BaseSellerControl{
    private $search_arr;//处理后的参数
    private $gc_arr;//分类数组
    private $choose_gcid;//选择的分类ID

    public function __construct(){
        parent::__construct();
        Language::read('member_store_statistics');
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
        /**
         * 处理商品分类
         */
        $this->choose_gcid = ($t = intval($_REQUEST['choose_gcid']))>0?$t:0;
        $gccache_arr = Model('goods_class')->getGoodsclassCache($this->choose_gcid,3);
        $this->gc_arr = $gccache_arr['showclass'];
	    Tpl::output('gc_json',json_encode($gccache_arr['showclass']));
		Tpl::output('gc_choose_json',json_encode($gccache_arr['choose_gcid']));
    }
	/**
	 * 行业排行
	 */
	public function hotOp(){
	    $datanum = 30;
	    if(!$this->search_arr['search_type']){
			$this->search_arr['search_type'] = 'day';
		}
		$model = Model('stat');
		//获得搜索的开始时间和结束时间
		$searchtime_arr = $model->getStarttimeAndEndtime($this->search_arr);
		$where = array();
		$where['order_isvalid'] = 1;//计入统计的有效订单
		$where['order_add_time'] = array('between',$searchtime_arr);
		$where['store_id'] = array('neq',$_SESSION['store_id']);
		$gc_id_depth = $this->gc_arr[$this->choose_gcid]['depth'];
		if ($this->choose_gcid > 0){
		    $where['gc_parentid_'.$gc_id_depth] = $this->choose_gcid;
		}
		/**
		 * 商品排行
		 */
		$goods_stat_arr = array();
	    //构造横轴数据
		for($i=1; $i<=$datanum; $i++){
		    //数据
		    $goods_stat_arr['series'][0]['data'][] = array('name'=>'','y'=>0);
			//横轴
			$goods_stat_arr['xAxis']['categories'][] = "$i";
		}
        $field = 'goods_id,goods_name,SUM(goods_num) as goodsnum';
		$goods_list = $model->statByStatordergoods($where, $field, 0, $datanum, 'goodsnum desc,goods_id asc', 'goods_id');
		foreach ((array)$goods_list as $k=>$v){
		    $goods_stat_arr['series'][0]['data'][$k] = array('name'=>strval($v['goods_name']),'y'=>floatval($v['goodsnum']));
		}
		//得到统计图数据
		$goods_stat_arr['series'][0]['name'] = '下单商品数';
		$goods_stat_arr['title'] = "行业商品{$datanum}强";
		$goods_stat_arr['legend']['enabled'] = false;
        $goods_stat_arr['yAxis'] = '下单商品数';
		$goods_statjson = getStatData_Column2D($goods_stat_arr);

		Tpl::output('goods_statjson',$goods_statjson);
		Tpl::output('goods_list',$goods_list);
        self::profile_menu('hot');
        Tpl::showpage('stat.industry.hot');
	}
	/**
	 * 价格分布
	 */
	public function priceOp(){
	    if(!$this->search_arr['search_type']){
			$this->search_arr['search_type'] = 'day';
		}
		$model = Model('stat');
		//获得搜索的开始时间和结束时间
		$searchtime_arr = $model->getStarttimeAndEndtime($this->search_arr);
		$where = array();
		$where['order_isvalid'] = 1;//计入统计的有效订单
		$where['order_add_time'] = array('between',$searchtime_arr);
		$gc_id_depth = $this->gc_arr[$this->choose_gcid]['depth'];
		if ($this->choose_gcid > 0){
		    $where['gc_parentid_'.$gc_id_depth] = $this->choose_gcid;
		}
        $field = '1';
		$pricerange = Model('store_extend')->getfby_store_id($_SESSION['store_id'],'pricerange');
		$pricerange_arr = $pricerange?unserialize($pricerange):array();
		if ($pricerange_arr){
		    $stat_arr['series'][0]['name'] = '下单商品数';
		    //设置价格区间最后一项，最后一项只有开始值没有结束值
		    $pricerange_count = count($pricerange_arr);
		    if ($pricerange_arr[$pricerange_count-1]['e']){
		        $pricerange_arr[$pricerange_count]['s'] = $pricerange_arr[$pricerange_count-1]['e'] + 1;
		        $pricerange_arr[$pricerange_count]['e'] = '';
		    }
			foreach ((array)$pricerange_arr as $k=>$v){
			    $v['s'] = intval($v['s']);
			    $v['e'] = intval($v['e']);
			    //构造查询字段
			    if ($v['e']){
			        $field .= " ,SUM(IF(goods_pay_price/goods_num > {$v['s']} and goods_pay_price/goods_num <= {$v['e']},goods_num,0)) as goodsnum_{$k}";
			    } else {
			        $field .= " ,SUM(IF(goods_pay_price/goods_num > {$v['s']},goods_num,0)) as goodsnum_{$k}";
			    }
			}
			$ordergooods_list = $model->getoneByStatordergoods($where, $field);
			if($ordergooods_list){
			    foreach ((array)$pricerange_arr as $k=>$v){
			        //横轴
			        if ($v['e']){
			            $stat_arr['xAxis']['categories'][] = $v['s'].'-'.$v['e'];
			        } else {
			            $stat_arr['xAxis']['categories'][] = $v['s'].'以上';
			        }
			        //统计图数据
			        $stat_arr['series'][0]['data'][$k] = ($t = intval($ordergooods_list['goodsnum_'.$k]))?$t:0;
			    }
			}
			//得到统计图数据
			$stat_arr['legend']['enabled'] = false;
			$stat_arr['title'] = '行业价格下单商品数';
            $stat_arr['yAxis'] = '';
    		$stat_json = getStatData_LineLabels($stat_arr);
		} else {
		    $stat_json = '';
		}
		Tpl::output('stat_json',$stat_json);
        self::profile_menu('price');
        Tpl::showpage('stat.industry.price');
	}

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key=''){
        $menu_array	= array(
            1=>array('menu_key'=>'hot','menu_name'=>'同行热卖','menu_url'=>'index.php?act=statistics_industry&op=hot'),
            2=>array('menu_key'=>'price','menu_name'=>'行业价格分布','menu_url'=>'index.php?act=statistics_industry&op=price')
        );
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
