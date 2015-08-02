<?php
/**
 * 行业分析
 ***/

defined('InShopNC') or exit('Access Invalid!');

class stat_industryControl extends SystemControl{
    private $links = array(
        array('url'=>'act=stat_industry&op=scale','lang'=>'stat_industryscale'),
        array('url'=>'act=stat_industry&op=rank','lang'=>'stat_industryrank'),
        array('url'=>'act=stat_industry&op=price','lang'=>'stat_industryprice'),
        array('url'=>'act=stat_industry&op=general','lang'=>'stat_industrygeneral'),
    );
    private $search_arr;//处理后的参数
    private $gc_arr;//分类数组
    private $choose_gcid;//选择的分类ID

    public function __construct(){
        parent::__construct();
        Language::read('stat');
        import('function.statistics');
        import('function.datehelper');
        $model = Model('stat');
        //存储参数
		$this->search_arr = $_REQUEST;
		//处理搜索时间
		if (in_array($this->search_arr['op'],array('scale','rank','price'))){
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
		}
        Tpl::output('search_arr', $this->search_arr);
        /**
         * 处理商品分类
         */
        $show_depth = 3;//select需要展示的深度
		if (in_array($this->search_arr['op'],array('scale','general'))){//仅显示前两级分类
		    $show_depth = 2;
		}
        $this->choose_gcid = ($t = intval($_REQUEST['choose_gcid']))>0?$t:0;
        $gccache_arr = Model('goods_class')->getGoodsclassCache($this->choose_gcid,$show_depth);
        $this->gc_arr = $gccache_arr['showclass'];
	    Tpl::output('gc_json',json_encode($gccache_arr['showclass']));
		Tpl::output('gc_choose_json',json_encode($gccache_arr['choose_gcid']));
    }
	/**
	 * 行业规模
	 */
	public function scaleOp(){
		if(!$this->search_arr['search_type']){
			$this->search_arr['search_type'] = 'day';
		}
		$model = Model('stat');
		//获得搜索的开始时间和结束时间
		$searchtime_arr = $model->getStarttimeAndEndtime($this->search_arr);
		Tpl::output('searchtime',implode('|',$searchtime_arr));
        Tpl::output('top_link',$this->sublink($this->links, 'scale'));
        Tpl::showpage('stat.industry.scale');
	}
	/**
	 * 行业规模列表
	 */
	public function scale_listOp(){
	    //获得子分类ID
	    $gc_childid = $gc_childarr = array();
	    if ($this->choose_gcid > 0){//如果进行了分类搜索，则统计该分类下的子分类
	        $gc_childdepth = $this->gc_arr[$this->choose_gcid]['depth'] + 1;
	        $gc_childid = explode(',',$this->gc_arr[$this->choose_gcid]['child']);
	        if ($gc_childid){
    	        foreach ((array)$this->gc_arr as $k=>$v){
    	            if (in_array($v['gc_id'],$gc_childid)){
    	                $gc_childarr[$v['gc_id']] = $v;
    	            }
    	        }
	        }
	    } else {//如果没有搜索分类，则默认统计一级分类
	        $gc_childdepth = 1;
	        foreach ((array)$this->gc_arr as $k=>$v){
	            if ($v['depth'] == 1){
	                $gc_childarr[$v['gc_id']] = $v;
	            }
	        }
	    }
	    if($gc_childarr){
    	    $model = Model('stat');
    	    $stat_list = array();
	        //构造横轴数据
    		foreach($gc_childarr as $k=>$v){
    			$stat_list[$k]['gc_name'] = $v['gc_name'];
    			$stat_list[$k]['y'] = 0;
    		}
    		$where = array();
    		$where['order_isvalid'] = 1;//计入统计的有效订单
    	    $searchtime_arr_tmp = explode('|',$this->search_arr['t']);
    		foreach ((array)$searchtime_arr_tmp as $k=>$v){
    		    $searchtime_arr[] = intval($v);
    		}
    		$where['order_add_time'] = array('between',$searchtime_arr);
    		if ($this->choose_gcid > 0){
    		    $where['gc_parentid_'.($gc_childdepth-1)] = $this->choose_gcid;
    		}
	        $field = 'gc_parentid_'.$gc_childdepth.' as statgc_id';
    		switch ($_GET['stattype']){
    		   case 'ordernum':
    		       $caption = '下单量';
    		       $field .= ',COUNT(DISTINCT order_id) as ordernum';
    		       $orderby = 'ordernum desc';
    		       break;
    		   case 'goodsnum':
    		       $caption = '下单商品数';
    		       $field .= ',SUM(goods_num) as goodsnum';
    		       $orderby = 'goodsnum desc';
    		       break;
    		   default:
    		       $_GET['stattype'] = 'orderamount';
    		       $caption = '下单金额';
    		       $field .= ',SUM(goods_pay_price) as orderamount';
    		       $orderby = 'orderamount desc';
    		       break;
    		}
    		$orderby .= ',statgc_id asc';

    		$goods_list = $model->statByStatordergoods($where, $field, 0, 0, $orderby, 'statgc_id');
	        foreach ((array)$goods_list as $k=>$v){
	            $statgc_id = intval($v['statgc_id']);
	            if (in_array($statgc_id,array_keys($gc_childarr))){
	                $stat_list[$statgc_id]['gc_name'] = strval($gc_childarr[$v['statgc_id']]['gc_name']);
	            } else {
	                $stat_list[$statgc_id]['gc_name'] = '其他';
	            }
	            switch ($_GET['stattype']){
        		   case 'orderamount':
        		       $stat_list[$statgc_id]['y'] = floatval($v[$_GET['stattype']]);
        		       break;
        		   default:
        		       $stat_list[$statgc_id]['y'] = intval($v[$_GET['stattype']]);
        		       break;
        		}
    		}
	        //构造横轴数据
    		foreach($stat_list as $k=>$v){
    		    //数据
    		    $stat_arr['series'][0]['data'][] = array('name'=>strval($v['gc_name']),'y'=>$v['y']);
    			//横轴
    			$stat_arr['xAxis']['categories'][] = strval($v['gc_name']);
    		}
    		//得到统计图数据
    		$stat_arr['series'][0]['name'] = $caption;
    		$stat_arr['title'] = "行业{$caption}统计";
    		$stat_arr['legend']['enabled'] = false;
            $stat_arr['yAxis']['title']['text'] = $caption;
            $stat_arr['yAxis']['title']['align'] = 'high';
    		$statjson = getStatData_Basicbar($stat_arr);
			Tpl::output('stat_json',$statjson);
			Tpl::output('stattype',$_GET['stattype']);
			Tpl::showpage('stat.linelabels','null_layout');
	    }
	}
	/**
	 * 行业排行
	 */
	public function rankOp(){
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
		/**
		 * 商品排行
		 */
		$goods_stat_arr = array();
	    //构造横轴数据
		for($i=1; $i<=50; $i++){
		    //数据
		    $goods_stat_arr['series'][0]['data'][] = array('name'=>'','y'=>0);
			//横轴
			$goods_stat_arr['xAxis']['categories'][] = "$i";
		}
        $field = 'goods_id,goods_name,SUM(goods_num) as goodsnum';
		$goods_list = $model->statByStatordergoods($where, $field, 0, 50, 'goodsnum desc,goods_id asc', 'goods_id');
		foreach ((array)$goods_list as $k=>$v){
		    $goods_stat_arr['series'][0]['data'][$k] = array('name'=>strval($v['goods_name']),'y'=>floatval($v['goodsnum']));
		}
		//得到统计图数据
		$goods_stat_arr['series'][0]['name'] = '下单商品数';
		$goods_stat_arr['title'] = "行业商品50强";
		$goods_stat_arr['legend']['enabled'] = false;
        $goods_stat_arr['yAxis'] = '下单商品数';
		$goods_statjson = getStatData_Column2D($goods_stat_arr);
		/**
		 * 店铺排行
		 */
		$store_stat_arr = array();
	    //构造横轴数据
		for($i=1; $i<=30; $i++){
		    //数据
		    $store_stat_arr['series'][0]['data'][] = array('name'=>'','y'=>0);
			//横轴
			$store_stat_arr['xAxis']['categories'][] = "$i";
		}
		$field = 'store_id,store_name,COUNT(DISTINCT order_id) as ordernum';
		$store_list = $model->statByStatordergoods($where, $field, 0, 30, 'ordernum desc,store_id asc', 'store_id');
		foreach ((array)$store_list as $k=>$v){
		    $store_stat_arr['series'][0]['data'][$k] = array('name'=>strval($v['store_name']),'y'=>floatval($v['ordernum']));
		}
		//得到统计图数据
		$store_stat_arr['series'][0]['name'] = '下单量';
		$store_stat_arr['title'] = "行业店铺30强";
		$store_stat_arr['legend']['enabled'] = false;
        $store_stat_arr['yAxis'] = '下单量';
		$store_statjson = getStatData_Column2D($store_stat_arr);

		Tpl::output('goods_statjson',$goods_statjson);
		Tpl::output('goods_list',$goods_list);
		Tpl::output('store_statjson',$store_statjson);
		Tpl::output('store_list',$store_list);
        Tpl::output('top_link',$this->sublink($this->links, 'rank'));
        Tpl::showpage('stat.industry.rank');
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
		$pricerange_arr = ($t = trim(C('stat_pricerange')))?unserialize($t):'';
		if ($pricerange_arr){
		    $goodsnum_stat_arr['series'][0]['name'] = '下单商品数';
		    $orderamount_stat_arr['series'][0]['name'] = '下单金额';
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
			        $field .= " ,SUM(IF(goods_pay_price/goods_num > {$v['s']} and goods_pay_price/goods_num <= {$v['e']},goods_pay_price,0)) as orderamount_{$k}";
			    } else {//由于最后一个区间没有结束值，所以需要单独构造sql
			        $field .= " ,SUM(IF(goods_pay_price/goods_num > {$v['s']},goods_num,0)) as goodsnum_{$k}";
			        $field .= " ,SUM(IF(goods_pay_price/goods_num > {$v['s']},goods_pay_price,0)) as orderamount_{$k}";
			    }
			}

			$ordergooods_list = $model->getoneByStatordergoods($where, $field);
			if($ordergooods_list){
			    foreach ((array)$pricerange_arr as $k=>$v){
			        //横轴
			        if($v['e']){
			            $goodsnum_stat_arr['xAxis']['categories'][] = $v['s'].'-'.$v['e'];
			            $orderamount_stat_arr['xAxis']['categories'][] = $v['s'].'-'.$v['e'];
			        } else {
			            $goodsnum_stat_arr['xAxis']['categories'][] = $v['s'].'以上';
			            $orderamount_stat_arr['xAxis']['categories'][] = $v['s'].'以上';
			        }
			        //统计图数据
			        $goodsnum_stat_arr['series'][0]['data'][$k] = 0;
			        $orderamount_stat_arr['series'][0]['data'][$k] = 0;
			        if ($ordergooods_list['goodsnum_'.$k]){
			            $goodsnum_stat_arr['series'][0]['data'][$k] = intval($ordergooods_list['goodsnum_'.$k]);
			        }
			        if ($ordergooods_list['orderamount_'.$k]){
			            $orderamount_stat_arr['series'][0]['data'][$k] = intval($ordergooods_list['orderamount_'.$k]);
			        }
			    }
			}
			//得到统计图数据
			$goodsnum_stat_arr['legend']['enabled'] = false;
			$goodsnum_stat_arr['title'] = '行业价格下单商品数';
            $goodsnum_stat_arr['yAxis'] = '';

            $orderamount_stat_arr['legend']['enabled'] = false;
            $orderamount_stat_arr['title'] = '行业价格下单金额';
            $orderamount_stat_arr['yAxis'] = '';
    		$goodsnum_stat_json = getStatData_LineLabels($goodsnum_stat_arr);
    		$orderamount_stat_json = getStatData_LineLabels($orderamount_stat_arr);
		} else {
		    $goodsnum_stat_json = '';
    		$orderamount_stat_json = '';
		}
		Tpl::output('goodsnum_stat_json',$goodsnum_stat_json);
		Tpl::output('orderamount_stat_json',$orderamount_stat_json);
        Tpl::output('top_link',$this->sublink($this->links, 'price'));
        Tpl::showpage('stat.industry.price');
	}

	/**
	 * 销售统计
	 */
	public function generalOp(){
	    Tpl::output('top_link',$this->sublink($this->links, 'general'));
        Tpl::showpage('stat.industry.general');
	}

	/**
	 * 概况总览
	 */
	public function general_listOp(){
	    //获得子分类ID
	    $gc_childid = $gc_childarr = array();
	    if ($this->choose_gcid > 0){//如果进行了分类搜索，则统计该分类下的子分类
	        $gc_childdepth = $this->gc_arr[$this->choose_gcid]['depth'] + 1;
	        $gc_childid = explode(',',$this->gc_arr[$this->choose_gcid]['child']);
	        if ($gc_childid){
    	        foreach ((array)$this->gc_arr as $k=>$v){
    	            if (in_array($v['gc_id'],$gc_childid)){
    	                $gc_childarr[$v['gc_id']] = $v;
    	            }
    	        }
	        }
	    } else {//如果没有搜索分类，则默认统计一级分类
	        $gc_childdepth = 1;
	        foreach ((array)$this->gc_arr as $k=>$v){
	            if ($v['depth'] == 1){
	                $gc_childarr[$v['gc_id']] = $v;
	            }
	        }
	    }

        $statlist = array();

	    if ($gc_childarr){
    	    $model = Model('stat');
    		//查询订单商品信息
    		$where = array();
    		$where['order_isvalid'] = 1;//计入统计的有效订单
    		//计算开始时间和结束时间
    		$searchtime_arr[1] = strtotime(date('Y-m-d',time())) - 1;//昨天23:59点
    		$searchtime_arr[0] = $searchtime_arr[1] - (86400 * 30) + 1; //从昨天开始30天前
    		$where['order_add_time'] = array('between',$searchtime_arr);
	        if ($this->choose_gcid > 0){
    		    $where['gc_parentid_'.($gc_childdepth-1)] = $this->choose_gcid;
    		}
            $field = 'gc_parentid_'.$gc_childdepth.' as statgc_id,COUNT(DISTINCT goods_id) as ordergcount,SUM(goods_num) as ordergnum,SUM(goods_pay_price) as orderamount';
    		$ordergoods_list_tmp = $model->statByStatordergoods($where, $field, 0, 0, '', 'statgc_id');
    		foreach ((array)$ordergoods_list_tmp as $k=>$v){
    		    $ordergoods_list[$v['statgc_id']] = $v;
    		}

    		//查询商品信息
    		$field = 'gc_id_'.$gc_childdepth.' as statgc_id,COUNT(*) as goodscount,AVG(goods_price) as priceavg';
    		$goods_list_tmp = $model->statByGoods(array('is_virtual'=>0), $field, 0, 0, '', 'statgc_id');

    		foreach ((array)$goods_list_tmp as $k=>$v){
    		    $goods_list[$v['statgc_id']] = $v;
    		}
    		//将订单和商品数组合并
    		$statlist_tmp = array();
    		foreach ($gc_childarr as $k=>$v){
    		    $tmp = array();
    		    $tmp['statgc_id'] = $v['gc_id'];
    		    $tmp['gc_name'] = $v['gc_name'];
    		    $tmp['ordergcount'] = ($t = $ordergoods_list[$v['gc_id']]['ordergcount'])?$t:0;
    		    $tmp['ordergnum'] = ($t = $ordergoods_list[$v['gc_id']]['ordergnum'])?$t:0;
    		    $tmp['orderamount'] = ($t = $ordergoods_list[$v['gc_id']]['orderamount'])?$t:0;
    		    $tmp['goodscount'] = ($t = $goods_list[$v['gc_id']]['goodscount'])?$t:0;
    		    $tmp['priceavg'] = ncPriceFormat(($t = $goods_list[$v['gc_id']]['priceavg'])?$t:0);
    		    $tmp['unordergcount'] = intval($goods_list[$v['gc_id']]['goodscount']) - intval($ordergoods_list[$v['gc_id']]['ordergcount']);//计算无销量商品数
    		    $statlist_tmp[]= $tmp;
    		}
    		$statlist = array();
    		//整理排序
    		$orderby = trim($this->search_arr['orderby']);
    		if (!$orderby){
    		    $orderby = 'orderamount desc';
    		}
    		$orderkeys = explode(' ',$orderby);
    		$keysvalue = $new_array = array();
        	foreach ($statlist_tmp as $k=>$v){
        		$keysvalue[$k] = $v[$orderkeys[0]];
        	}
        	if($orderkeys[1] == 'asc'){
        		asort($keysvalue);
        	}else{
        		arsort($keysvalue);
        	}
        	reset($keysvalue);
        	foreach ($keysvalue as $k=>$v){
        		$statlist[$k] = $statlist_tmp[$k];
        	}
    	    //导出Excel
            if ($this->search_arr['exporttype'] == 'excel'){
                //列表header
        		$statheader = array();
                $statheader[] = array('text'=>'类目名称','key'=>'gc_name');
                $statheader[] = array('text'=>'平均价格（元）','key'=>'priceavg','isorder'=>1);
                $statheader[] = array('text'=>'有销量商品数','key'=>'ordergcount','isorder'=>1);
                $statheader[] = array('text'=>'销量','key'=>'ordergnum','isorder'=>1);
                $statheader[] = array('text'=>'销售额（元）','key'=>'orderamount','isorder'=>1);
                $statheader[] = array('text'=>'商品总数','key'=>'goodscount','isorder'=>1);
                $statheader[] = array('text'=>'无销量商品数','key'=>'unordergcount','isorder'=>1);
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
    		    $excel_obj->addWorksheet($excel_obj->charset('行业概况总览',CHARSET));
    		    $excel_obj->generateXML($excel_obj->charset('行业概况总览',CHARSET).date('Y-m-d-H',time()));
    			exit();
            }
	    }
         //列表header
		$statheader = array();
        $statheader[] = array('text'=>'类目名称','key'=>'gc_name');
        $statheader[] = array('text'=>'<span title="类目下所有商品的平均单价" class="tip icon-question-sign"></span>&nbsp;平均价格（元）','key'=>'priceavg','isorder'=>1);
        $statheader[] = array('text'=>'<span title="类目下从昨天开始最近30天有效订单中有销量的商品总数" class="tip icon-question-sign"></span>&nbsp;有销量商品数','key'=>'ordergcount','isorder'=>1);
        $statheader[] = array('text'=>'<span title="类目下从昨天开始最近30天有效订单中商品总售出件数" class="tip icon-question-sign"></span>&nbsp;销量','key'=>'ordergnum','isorder'=>1);
        $statheader[] = array('text'=>'<span title="类目下从昨天开始最近30天有效订单中商品总销售额" class="tip icon-question-sign"></span>&nbsp;销售额（元）','key'=>'orderamount','isorder'=>1);
        $statheader[] = array('text'=>'<span title="类目下所有商品的数量" class="tip icon-question-sign"></span>&nbsp;商品总数','key'=>'goodscount','isorder'=>1);
        $statheader[] = array('text'=>'<span title="类目下从昨天开始最近30天无销量的商品总数" class="tip icon-question-sign"></span>&nbsp;无销量商品数','key'=>'unordergcount','isorder'=>1);
        Tpl::output('statheader',$statheader);
    	Tpl::output('statlist',$statlist);
    	Tpl::output('orderby',$orderby);
    	Tpl::output('actionurl',"index.php?act={$this->search_arr['act']}&op={$this->search_arr['op']}&choose_gcid=".$this->choose_gcid);
        Tpl::showpage('stat.listandorder','null_layout');
	}
}
