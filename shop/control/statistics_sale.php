<?php
/**
 * 用户中心店铺统计
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class statistics_saleControl extends BaseSellerControl {
    private $search_arr;//处理后的参数
    private $gc_arr;//分类数组
    private $choose_gcid;//选择的分类ID

	public function __construct() {
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
	}

	/**
	 * 销售统计
	 */
	public function saleOp(){
	    $model = Model('stat');
        //默认统计当前数据
		if(!$this->search_arr['search_type']){
			$this->search_arr['search_type'] = 'day';
		}
		//计算昨天和今天时间
    	if($this->search_arr['search_type'] == 'day'){
    	    $stime = $this->search_arr['day']['search_time'] - 86400;//昨天0点
    	    $etime = $this->search_arr['day']['search_time'] + 86400 - 1;//今天24点
    	    $curr_stime = $this->search_arr['day']['search_time'];//今天0点
    	} elseif ($this->search_arr['search_type'] == 'week'){
			$current_weekarr = explode('|', $this->search_arr['week']['current_week']);
			$stime = strtotime($current_weekarr[0])-86400*7;
			$etime = strtotime($current_weekarr[1])+86400-1;
			$curr_stime = strtotime($current_weekarr[0]);//本周0点
    	} elseif ($this->search_arr['search_type'] == 'month'){
			$stime = strtotime($this->search_arr['month']['current_year'].'-'.$this->search_arr['month']['current_month']."-01 -1 month");
			$etime = getMonthLastDay($this->search_arr['month']['current_year'],$this->search_arr['month']['current_month'])+86400-1;
			$curr_stime = strtotime($this->search_arr['month']['current_year'].'-'.$this->search_arr['month']['current_month']."-01");;//本月0点
    	}

        $where = array();
        $where['store_id'] = $_SESSION['store_id'];
        $where['order_add_time'] = array('between',array($stime,$etime));
		if(trim($_GET['order_type']) != ''){
    		$where['order_state'] = trim($_GET['order_type']);
    	}
	    //走势图
	    $field = ' COUNT(*) as ordernum,SUM(order_amount) as orderamount ';
	    $stat_arr = array();
    	//$searchtime_arr = array($stime,$etime);
		if($this->search_arr['search_type'] == 'day'){
			//构造横轴数据
			for($i=0; $i<24; $i++){
				//统计图数据
				$curr_arr['orderamount'][$i] = 0;//今天
				$up_arr['orderamount'][$i] = 0;//昨天
				$curr_arr['ordernum'][$i] = 0;//今天
				$up_arr['ordernum'][$i] = 0;//昨天

				//统计表数据
				$currlist_arr[$i]['timetext'] = $i;

				$uplist_arr[$i]['val'] = 0;
				$currlist_arr[$i]['val'] = 0;
				//横轴
				$stat_arr['orderamount']['xAxis']['categories'][] = "$i";
				$stat_arr['ordernum']['xAxis']['categories'][] = "$i";
			}

			$today_day = @date('d', $etime);//今天日期
			$yesterday_day = @date('d', $stime);//昨天日期

			$field .= ' ,DAY(FROM_UNIXTIME(order_add_time)) as dayval,HOUR(FROM_UNIXTIME(order_add_time)) as hourval ';
			$orderlist = $model->statByStatorder($where, $field, 0, 0, '', 'dayval,hourval');
			foreach((array)$orderlist as $k => $v){
				if($today_day == $v['dayval']){
					$curr_arr['ordernum'][$v['hourval']] = intval($v['ordernum']);
					$curr_arr['orderamount'][$v['hourval']] = floatval($v['orderamount']);

					$currlist_arr[$v['hourval']]['val'] = $v[$search_type];
				}
				if($yesterday_day == $v['dayval']){
					$up_arr['ordernum'][$v['hourval']] = intval($v['ordernum']);
					$up_arr['orderamount'][$v['hourval']] = floatval($v['orderamount']);

					$uplist_arr[$v['hourval']]['val'] = $v[$search_type];
				}
			}
			$stat_arr['ordernum']['series'][0]['name'] = '昨天';
			$stat_arr['ordernum']['series'][0]['data'] = array_values($up_arr['ordernum']);
			$stat_arr['ordernum']['series'][1]['name'] = '今天';
			$stat_arr['ordernum']['series'][1]['data'] = array_values($curr_arr['ordernum']);

			$stat_arr['orderamount']['series'][0]['name'] = '昨天';
			$stat_arr['orderamount']['series'][0]['data'] = array_values($up_arr['orderamount']);
			$stat_arr['orderamount']['series'][1]['name'] = '今天';
			$stat_arr['orderamount']['series'][1]['data'] = array_values($curr_arr['orderamount']);
		}

		if($this->search_arr['search_type'] == 'week'){
			$up_week = @date('W', $stime);//上周
			$curr_week = @date('W', $etime);//本周
			//构造横轴数据
			for($i=1; $i<=7; $i++){
			    $tmp_weekarr = getSystemWeekArr();
				//统计图数据
				$up_arr['ordernum'][$i] = 0;
				$curr_arr['ordernum'][$i] = 0;

				$up_arr['orderamount'][$i] = 0;
				$curr_arr['orderamount'][$i] = 0;

				//横轴
				$stat_arr['ordernum']['xAxis']['categories'][] = $tmp_weekarr[$i];
				$stat_arr['orderamount']['xAxis']['categories'][] = $tmp_weekarr[$i];

				//统计表数据
				$uplist_arr[$i]['timetext'] = $tmp_weekarr[$i];
				$currlist_arr[$i]['timetext'] = $tmp_weekarr[$i];
				$uplist_arr[$i]['val'] = 0;
				$currlist_arr[$i]['val'] = 0;
				unset($tmp_weekarr);
			}
			$field .= ',WEEKOFYEAR(FROM_UNIXTIME(order_add_time)) as weekval,WEEKDAY(FROM_UNIXTIME(order_add_time))+1 as dayofweekval ';
			$orderlist = $model->statByStatorder($where, $field, 0, 0, '', 'weekval,dayofweekval');
			foreach((array)$orderlist as $k=>$v){
				if ($up_week == $v['weekval']){
					$up_arr['ordernum'][$v['dayofweekval']] = intval($v['ordernum']);
					$up_arr['orderamount'][$v['dayofweekval']] = intval($v['orderamount']);

					$uplist_arr[$v['dayofweekval']]['val'] = intval($v[$search_type]);
				}
				if ($curr_week == $v['weekval']){
					$curr_arr['ordernum'][$v['dayofweekval']] = intval($v['ordernum']);
					$curr_arr['orderamount'][$v['dayofweekval']] = intval($v['orderamount']);

					$currlist_arr[$v['dayofweekval']]['val'] = intval($v[$search_type]);
				}
			}
			$stat_arr['ordernum']['series'][0]['name'] = '上周';
			$stat_arr['ordernum']['series'][0]['data'] = array_values($up_arr['ordernum']);
			$stat_arr['ordernum']['series'][1]['name'] = '本周';
			$stat_arr['ordernum']['series'][1]['data'] = array_values($curr_arr['ordernum']);

			$stat_arr['orderamount']['series'][0]['name'] = '上周';
			$stat_arr['orderamount']['series'][0]['data'] = array_values($up_arr['orderamount']);
			$stat_arr['orderamount']['series'][1]['name'] = '本周';
			$stat_arr['orderamount']['series'][1]['data'] = array_values($curr_arr['orderamount']);
		}

		if($this->search_arr['search_type'] == 'month'){
			$up_month = date('m',$stime);
			$curr_month = date('m',$etime);
			//计算横轴的最大量（由于每个月的天数不同）
			$up_dayofmonth = date('t',$stime);
			$curr_dayofmonth = date('t',$etime);
			$x_max = $up_dayofmonth > $curr_dayofmonth ? $up_dayofmonth : $curr_dayofmonth;

		    //构造横轴数据
			for($i=1; $i<=$x_max; $i++){
				//统计图数据
				$up_arr['ordernum'][$i] = 0;
				$curr_arr['ordernum'][$i] = 0;

				$up_arr['orderamount'][$i] = 0;
				$curr_arr['orderamount'][$i] = 0;

				//横轴
				$stat_arr['ordernum']['xAxis']['categories'][] = $i;
				$stat_arr['orderamount']['xAxis']['categories'][] = $i;

				//统计表数据
				$currlist_arr[$i]['timetext'] = $i;
				$uplist_arr[$i]['val'] = 0;
				$currlist_arr[$i]['val'] = 0;
			}
			$field .= ',MONTH(FROM_UNIXTIME(order_add_time)) as monthval,day(FROM_UNIXTIME(order_add_time)) as dayval ';
			$orderlist = $model->statByStatorder($where, $field, 0, 0, '', 'monthval,dayval');
			foreach($orderlist as $k=>$v){
				if ($up_month == $v['monthval']){
					$up_arr['ordernum'][$v['dayval']] = intval($v['ordernum']);
					$up_arr['orderamount'][$v['dayval']] = floatval($v['orderamount']);

					$uplist_arr[$v['dayval']]['val'] = intval($v[$search_type]);
				}
				if ($curr_month == $v['monthval']){
					$curr_arr['ordernum'][$v['dayval']] = intval($v['ordernum']);
					$curr_arr['orderamount'][$v['dayval']] = intval($v['orderamount']);

					$currlist_arr[$v['dayval']]['val'] = intval($v[$search_type]);
				}
			}
			$stat_arr['ordernum']['series'][0]['name'] = '上月';
			$stat_arr['ordernum']['series'][0]['data'] = array_values($up_arr['ordernum']);
			$stat_arr['ordernum']['series'][1]['name'] = '本月';
			$stat_arr['ordernum']['series'][1]['data'] = array_values($curr_arr['ordernum']);

			$stat_arr['orderamount']['series'][0]['name'] = '上月';
			$stat_arr['orderamount']['series'][0]['data'] = array_values($up_arr['orderamount']);
			$stat_arr['orderamount']['series'][1]['name'] = '本月';
			$stat_arr['orderamount']['series'][1]['data'] = array_values($curr_arr['orderamount']);
		}

		$stat_arr['ordernum']['title'] = '订单量统计';
    	$stat_arr['ordernum']['yAxis'] = '订单量';

		$stat_arr['orderamount']['title'] = '下单金额统计';
    	$stat_arr['orderamount']['yAxis'] = '下单金额';

    	$stat_json['ordernum'] = getStatData_LineLabels($stat_arr['ordernum']);
		$stat_json['orderamount'] = getStatData_LineLabels($stat_arr['orderamount']);
		Tpl::output('stat_json',$stat_json);
		Tpl::output('stattype',$search_type);
		//总数统计
		$where['order_add_time'] = array('between',array($curr_stime,$etime));
		$statcount_arr = $model->getoneByStatorder($where,' COUNT(*) as ordernum, SUM(order_amount) as orderamount');
		$statcount_arr['ordernum'] = ($t = intval($statcount_arr['ordernum'])) > 0?$t:0;
		$statcount_arr['orderamount'] = ncPriceFormat(($t = floatval($statcount_arr['orderamount'])) > 0?$t:0);
		Tpl::output('statcount_arr',$statcount_arr);
		Tpl::output('searchtime',implode('|',array($curr_stime,$etime)));
		Tpl::output('show_page',$model->showpage(2));
		self::profile_menu('sale');
		Tpl::showpage('stat.sale.index');
	}

	/**
	 * 订单列表
	 */
	public function salelistOp(){
	    $model = Model('stat');
	    $searchtime_arr_tmp = explode('|',$this->search_arr['t']);
		foreach ((array)$searchtime_arr_tmp as $k=>$v){
		    $searchtime_arr[] = intval($v);
		}
	    $where = array();
	    $where['store_id'] = $_SESSION['store_id'];
        $where['order_add_time'] = array('between',$searchtime_arr);
		if(trim($_GET['order_type']) != ''){
    		$where['order_state'] = trim($_GET['order_type']);
    	}
		if ($_GET['exporttype'] == 'excel'){
		    $order_list = $model->statByStatorder($where, '', 0, 0,'order_id desc');
		} else {
		    $order_list = $model->statByStatorder($where, '', 10, 0,'order_id desc');
		}
		//统计数据标题
		$statlist = array();
		$statheader = array();
        $statheader[] = array('text'=>'订单编号','key'=>'order_sn');
        $statheader[] = array('text'=>'买家','key'=>'buyer_name');
        $statheader[] = array('text'=>'下单时间','key'=>'order_add_time');
        $statheader[] = array('text'=>'订单总额','key'=>'order_amount');
        $statheader[] = array('text'=>'订单状态','key'=>'order_statetext');
		foreach ((array)$order_list as $k=>$v){
		    $v['order_add_time'] = @date('Y-m-d H:i:s',$v['order_add_time']);
		    switch ($v['order_state']){
	        	case ORDER_STATE_CANCEL:
	        		$v['order_statetext'] = '已取消';
	        		break;
	        	case ORDER_STATE_NEW:
	        		$v['order_statetext'] = '待付款';
	        		break;
	        	case ORDER_STATE_PAY:
	        		$v['order_statetext'] = '待发货';
	        		break;
	        	case ORDER_STATE_SEND:
	        		$v['order_statetext'] = '待收货';
	        		break;
	        	case ORDER_STATE_SUCCESS:
	        		$v['order_statetext'] = '交易完成';
	        		break;
	        }
		    $statlist[$k]= $v;
		}

	    //导出Excel
        if ($this->search_arr['exporttype'] == 'excel'){
            //导出Excel
			import('libraries.excel');
		    $excel_obj = new Excel();
		    $excel_data = array();
		    //设置样式
		    $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
			//header
			foreach ($statheader as $k=>$v){
			    $excel_data[0][] = array('styleid'=>'s_title','data'=>$v['text']);
			}
			//data
			foreach ($statlist as $k=>$v){
    			foreach ($statheader as $h_k=>$h_v){
    			    $excel_data[$k+1][] = array('data'=>$v[$h_v['key']]);
    			}
			}
			$excel_data = $excel_obj->charset($excel_data,CHARSET);
			$excel_obj->addArray($excel_data);
		    $excel_obj->addWorksheet($excel_obj->charset('订单记录',CHARSET));
		    $excel_obj->generateXML($excel_obj->charset('订单记录',CHARSET).date('Y-m-d-H',time()));
			exit();
        }
		Tpl::output('statheader',$statheader);
		Tpl::output('statlist',$statlist);
		Tpl::output('show_page',$model->showpage(2));
		Tpl::output('actionurl',"index.php?act={$this->search_arr['act']}&op={$this->search_arr['op']}&order_type={$this->search_arr['order_type']}&t={$this->search_arr['t']}");
		Tpl::showpage('stat.listandorder','null_layout');
	}

	/**
	 * 地区分布
	 */
	public function areaOp(){
	    if(!$this->search_arr['search_type']){
			$this->search_arr['search_type'] = 'day';
		}
		$model = Model('stat');
		//获得搜索的开始时间和结束时间
		$searchtime_arr = $model->getStarttimeAndEndtime($this->search_arr);
		$where = array();
		$where['store_id'] = $_SESSION['store_id'];
		$where['order_isvalid'] = 1;//计入统计的有效订单
		$where['order_add_time'] = array('between',$searchtime_arr);
		$memberlist = array();
		//查询统计数据
		$field = ' reciver_province_id,SUM(order_amount) as orderamount,COUNT(*) as ordernum,COUNT(DISTINCT buyer_id) as membernum ';
		$orderby = 'reciver_province_id';
		$statlist = $model->statByStatorder($where, $field, 10, 0, $orderby, 'reciver_province_id');
		$datatype = array('orderamount'=>'下单金额','ordernum'=>'下单量','membernum'=>'下单会员数');
		//处理数组，将数组按照$datatype分组排序
		$statlist_tmp = array();
		foreach ((array)$statlist as $k=>$v){
		    foreach ((array)$datatype as $t_k=>$t_v){
		        $statlist_tmp[$t_k][$k] = $v[$t_k];
		    }
		}
		foreach ((array)$statlist_tmp as $t_k=>$t_v){
		    arsort($statlist_tmp[$t_k]);
		}
		$statlist_tmp2 = $statlist_tmp;
		$statlist_tmp = array();
		foreach ((array)$statlist_tmp2 as $t_k=>$t_v){
		    foreach ($t_v as $k=>$v){
		        $statlist[$k]['orderamount'] = floatval($statlist[$k]['orderamount']);
		        $statlist[$k]['ordernum'] = intval($statlist[$k]['ordernum']);
		        $statlist[$k]['membernum'] = intval($statlist[$k]['membernum']);
		        $statlist_tmp[$t_k][] = $statlist[$k];
		    }
		}
		// 地区
        $province_array = Model('area')->getTopLevelAreas();
        //地图显示等级数组
        $level_arr = array(array(1,2,3),array(4,5,6),array(7,8,9),array(10,11,12));
        $statlist = array();
        $stat_arr_bar = array();
		foreach ((array)$statlist_tmp as $t_k=>$t_v){
		    foreach ((array)$t_v as $k=>$v){
    		    $v['level'] = 4;//排名
    		    foreach ($level_arr as $lk=>$lv){
    		        if (in_array($k+1,$lv)){
    		            $v['level'] = $lk;//排名
    		        }
    		    }
    		    $province_id = intval($v['reciver_province_id']);
    		    $statlist[$t_k][$province_id] = $v;
		        if ($province_id){
		            //数据
        		    $stat_arr_bar[$t_k]['series'][0]['data'][] = array('name'=>strval($province_array[$province_id]),'y'=>$v[$t_k]);
            		//横轴
            		$stat_arr_bar[$t_k]['xAxis']['categories'][] = strval($province_array[$province_id]);
		        } else {
		            //数据
        		    $stat_arr_bar[$t_k]['series'][0]['data'][] = array('name'=>'未知','y'=>$v[$t_k]);
            		//横轴
            		$stat_arr_bar[$t_k]['xAxis']['categories'][] = '未知';
		        }
		    }
		}
		$stat_arr_map = array();
	    foreach ((array)$province_array as $k=>$v){
		    foreach ($datatype as $t_k=>$t_v){
		        if ($statlist[$t_k][$k][$t_k]){
		            $des = "，{$t_v}：{$statlist[$t_k][$k][$t_k]}";
		            $stat_arr_map[$t_k][] = array('cha'=>$k,'name'=>$v,'des'=>$des,'level'=>$statlist[$t_k][$k]['level']);
		        } else {
		            $des = "，无订单数据";
	                $stat_arr_map[$t_k][] = array('cha'=>$k,'name'=>$v,'des'=>$des,'level'=>4);
		        }
		    }
		}
		$stat_json_map = array();
		$stat_json_bar = array();
		if ($statlist){
    		foreach ($datatype as $t_k=>$t_v){
    		    //得到地图数据
    		    $stat_json_map[$t_k] = getStatData_Map($stat_arr_map[$t_k]);
    		    //得到统计图数据
    		    $stat_arr_bar[$t_k]['series'][0]['name'] = $t_v;
        		$stat_arr_bar[$t_k]['title'] = "地区排行";
        		$stat_arr_bar[$t_k]['legend']['enabled'] = false;
                $stat_arr_bar[$t_k]['yAxis']['title']['text'] = $t_v;
                $stat_arr_bar[$t_k]['yAxis']['title']['align'] = 'high';
        		$stat_json_bar[$t_k] = getStatData_Basicbar($stat_arr_bar[$t_k]);
    		}
		}
		Tpl::output('stat_json_map',$stat_json_map);
		Tpl::output('stat_json_bar',$stat_json_bar);
		self::profile_menu('area');
		Tpl::showpage('stat.sale.area');
	}
	/**
	 * 购买分析
	 */
	public function buyingOp(){
	    if(!$this->search_arr['search_type']){
			$this->search_arr['search_type'] = 'day';
		}
		$model = Model('stat');
		//获得搜索的开始时间和结束时间
		$searchtime_arr = $model->getStarttimeAndEndtime($this->search_arr);
		/*
		 * 客单价分布
		 */
		$where = array();
		$where['store_id'] = $_SESSION['store_id'];
		$where['order_isvalid'] = 1;//计入统计的有效订单
		$where['order_add_time'] = array('between',$searchtime_arr);
		$field = '1';
		$pricerange = Model('store_extend')->getfby_store_id($_SESSION['store_id'],'orderpricerange');
		$pricerange_arr = $pricerange?unserialize($pricerange):array();
		if ($pricerange_arr){
		    $stat_arr['series'][0]['name'] = '下单量';
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
			        $field .= " ,SUM(IF(order_amount > {$v['s']} and order_amount <= {$v['e']},1,0)) as ordernum_{$k}";
			    } else {
			        $field .= " ,SUM(IF(order_amount > {$v['s']},1,0)) as ordernum_{$k}";
			    }
			}
			$orderlist = $model->getoneByStatorder($where, $field);
			if($orderlist){
			    foreach ((array)$pricerange_arr as $k=>$v){
			        //横轴
			        if ($v['e']){
			            $stat_arr['xAxis']['categories'][] = $v['s'].'-'.$v['e'];
			        } else {
			            $stat_arr['xAxis']['categories'][] = $v['s'].'以上';
			        }
			        //统计图数据
			        if ($orderlist['ordernum_'.$k]){
			            $stat_arr['series'][0]['data'][] = intval($orderlist['ordernum_'.$k]);
			        } else {
			            $stat_arr['series'][0]['data'][] = 0;
			        }
			    }
			}
			//得到统计图数据
    		$stat_arr['title'] = '客单价分布';
    		$stat_arr['legend']['enabled'] = false;
            $stat_arr['yAxis'] = '下单量';
    		$guestprice_statjson = getStatData_LineLabels($stat_arr);
		} else {
		    $guestprice_statjson = '';
		}
		unset($stat_arr);

		//购买时段分布
		$where = array();
		$where['store_id'] = $_SESSION['store_id'];
		$where['order_isvalid'] = 1;//计入统计的有效订单
		$where['order_add_time'] = array('between',$searchtime_arr);
		$field = ' HOUR(FROM_UNIXTIME(order_add_time)) as hourval,COUNT(*) as ordernum ';
		$orderlist = $model->statByStatorder($where, $field, 0, 0, 'hourval asc', 'hourval');
		$stat_arr = array();
		$stat_arr['series'][0]['name'] = '下单量';
		//构造横轴坐标
		for ($i=0; $i<24; $i++){
		    //横轴
		    $stat_arr['xAxis']['categories'][] = $i;
		    $stat_arr['series'][0]['data'][$i] = 0;
		}
	    foreach ((array)$orderlist as $k=>$v){
	        //统计图数据
	        $stat_arr['series'][0]['data'][$v['hourval']] = intval($v['ordernum']);
	    }
		//得到统计图数据
		$stat_arr['title'] = '购买时段分布';
		$stat_arr['legend']['enabled'] = false;
        $stat_arr['yAxis'] = '下单量';
		$hour_statjson = getStatData_LineLabels($stat_arr);
		Tpl::output('hour_statjson',$hour_statjson);
		Tpl::output('guestprice_statjson',$guestprice_statjson);
		self::profile_menu('buying');
		Tpl::showpage('stat.sale.buying');
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
            1=>array('menu_key'=>'sale','menu_name'=>'销售统计','menu_url'=>'index.php?act=statistics_sale&op=sale'),
            2=>array('menu_key'=>'area','menu_name'=>'区域分布','menu_url'=>'index.php?act=statistics_sale&op=area'),
            3=>array('menu_key'=>'buying','menu_name'=>'购买分析','menu_url'=>'index.php?act=statistics_sale&op=buying'),
        );
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
