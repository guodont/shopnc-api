<?php
/**
 * 统计概述
 ***/

defined('InShopNC') or exit('Access Invalid!');

class stat_generalControl extends SystemControl{
    private $links = array(
        array('url'=>'act=stat_general&op=general','lang'=>'stat_generalindex'),
        array('url'=>'act=stat_general&op=setting','lang'=>'stat_goodspricerange'),
        array('url'=>'act=stat_general&op=orderprange','lang'=>'stat_orderpricerange')
    );
    public function __construct(){
        parent::__construct();
        Language::read('stat');
        import('function.statistics');
    }
	/**
	 * 促销分析
	 */
	public function generalOp(){
	    $model = Model('stat');
	    //统计的日期0点
	    $stat_time = strtotime(date('Y-m-d',time())) - 86400;
	    /*
	     * 昨日最新情报
	     */
		$stime = $stat_time;
		$etime = $stat_time + 86400 - 1;

		$statnew_arr = array();

		//查询订单表下单量、下单金额、下单客户数、平均客单价
		$where = array();
		$where['order_isvalid'] = 1;//计入统计的有效订单
		$where['order_add_time'] = array('between',array($stime,$etime));
		$field = ' COUNT(*) as ordernum, SUM(order_amount) as orderamount, COUNT(DISTINCT buyer_id) as ordermembernum, AVG(order_amount) as orderavg ';
	    $stat_order = $model->getoneByStatorder($where, $field);
	    $statnew_arr['ordernum'] = ($t = $stat_order['ordernum'])?$t:0;
	    $statnew_arr['orderamount'] = ncPriceFormat(($t = $stat_order['orderamount'])?$t:(0));
	    $statnew_arr['ordermembernum'] = ($t = $stat_order['ordermembernum'])?$t:0;
	    $statnew_arr['orderavg'] = ncPriceFormat(($t = $stat_order['orderavg'])?$t:0);
	    unset($stat_order);

	    //查询订单商品表下单商品数
	    $where = array();
		$where['order_isvalid'] = 1;//计入统计的有效订单
		$where['order_add_time'] = array('between',array($stime,$etime));
		$field = ' SUM(goods_num) as ordergoodsnum,AVG(goods_pay_price/goods_num) as priceavg ';
	    $stat_ordergoods = $model->getoneByStatordergoods($where, $field);
	    $statnew_arr['ordergoodsnum'] = ($t = $stat_ordergoods['ordergoodsnum'])?$t:0;
	    $statnew_arr['priceavg'] = ncPriceFormat(($t = $stat_ordergoods['priceavg'])?$t:0);
	    unset($stat_ordergoods);

	    //新增会员数
	    $where = array();
	    $where['member_time'] = array('between',array($stime,$etime));
		$field = ' COUNT(*) as newmember ';
	    $stat_member = $model->getoneByMember($where, $field);
	    $statnew_arr['newmember'] = ($t = $stat_member['newmember'])?$t:0;
	    unset($stat_member);

	    //会员总数
	    $where = array();
		$field = ' COUNT(*) as membernum ';
	    $stat_member = $model->getoneByMember($where, $field);
	    $statnew_arr['membernum'] = ($t = $stat_member['membernum'])?$t:0;
	    unset($stat_member);

	    //新增店铺
	    $where = array();
	    $where['store_time'] = array('between',array($stime,$etime));
		$field = ' COUNT(*) as newstore ';
	    $stat_store = $model->getoneByStore($where, $field);
	    $statnew_arr['newstore'] = ($t = $stat_store['newstore'])?$t:0;
	    unset($stat_store);

	    //店铺总数
	    $where = array();
		$field = ' COUNT(*) as storenum ';
	    $stat_store = $model->getoneByStore($where, $field);
	    $statnew_arr['storenum'] = ($t = $stat_store['storenum'])?$t:0;
	    unset($stat_store);

	    //新增商品，商品总数
	    $goods_list = $model->statByGoods(array('is_virtual'=>0),"COUNT(*) as goodsnum, SUM(IF(goods_addtime>=$stime and goods_addtime<=$etime,1,0)) as newgoods");
	    $statnew_arr['goodsnum'] = ($t = $goods_list[0]['goodsnum'])>0?$t:0;
	    $statnew_arr['newgoods'] = ($t = $goods_list[0]['newgoods'])>0?$t:0;

	    /*
	     * 昨日销售走势
	     */
		//构造横轴数据
		for($i=0; $i<24; $i++){
			//统计图数据
			$curr_arr[$i] = 0;//今天
			$up_arr[$i] = 0;//昨天
			//横轴
			$stat_arr['xAxis']['categories'][] = "$i";
		}
		$stime = $stat_time - 86400;//昨天0点
		$etime = $stat_time + 86400 - 1;//今天24点
		$yesterday_day = @date('d', $stime);//昨天日期
		$today_day = @date('d', $etime);//今天日期
		$where = array();
		$where['order_isvalid'] = 1;//计入统计的有效订单
		$where['order_add_time'] = array('between',array($stime,$etime));
		$field = ' SUM(order_amount) as orderamount,DAY(FROM_UNIXTIME(order_add_time)) as dayval,HOUR(FROM_UNIXTIME(order_add_time)) as hourval ';
	    $stat_order = $model->statByStatorder($where, $field, 0, 0, '','dayval,hourval');
		if($stat_order){
			foreach($stat_order as $k => $v){
				if($today_day == $v['dayval']){
					$curr_arr[$v['hourval']] = intval($v['orderamount']);
				}
				if($yesterday_day == $v['dayval']){
					$up_arr[$v['hourval']] = intval($v['orderamount']);
				}
			}
		}
		$stat_arr['series'][0]['name'] = '昨天';
		$stat_arr['series'][0]['data'] = array_values($up_arr);
		$stat_arr['series'][1]['name'] = '今天';
		$stat_arr['series'][1]['data'] = array_values($curr_arr);
		//得到统计图数据
    	$stat_arr['title'] = date('Y-m-d',$stat_time).'销售走势';
        $stat_arr['yAxis'] = '销售额';
    	$stattoday_json = getStatData_LineLabels($stat_arr);
    	unset($stat_arr);

    	/*
    	 * 7日内店铺销售TOP30
    	 */
    	$stime = $stat_time - 86400*6;//7天前0点
		$etime = $stat_time + 86400 - 1;//今天24点
    	$where = array();
		$where['order_isvalid'] = 1;//计入统计的有效订单
		$where['order_add_time'] = array('between',array($stime,$etime));
		$field = ' SUM(order_amount) as orderamount, store_id, store_name ';
	    $storetop30_arr = $model->statByStatorder($where, $field, 0, 0, 'orderamount desc', 'store_id');

	    /*
    	 * 7日内商品销售TOP30
    	 */
    	$stime = $stat_time - 86400*6;//7天前0点
		$etime = $stat_time + 86400 - 1;//今天24点
    	$where = array();
		$where['order_isvalid'] = 1;//计入统计的有效订单
		$where['order_add_time'] = array('between',array($stime,$etime));
	    $field = ' sum(goods_num) as ordergoodsnum, goods_id, goods_name ';
	    $goodstop30_arr = $model->statByStatordergoods($where, $field, 0, 30,'ordergoodsnum desc', 'goods_id');
	    Tpl::output('goodstop30_arr',$goodstop30_arr);
    	Tpl::output('storetop30_arr',$storetop30_arr);
    	Tpl::output('stattoday_json',$stattoday_json);
	    Tpl::output('statnew_arr',$statnew_arr);
	    Tpl::output('stat_time',$stat_time);
	    Tpl::output('top_link',$this->sublink($this->links, 'general'));
    	Tpl::showpage('stat.general.index');
	}
	/**
	 * 统计设置
	 */
	public function settingOp(){
	    $model_setting = Model('setting');
		if (chksubmit()){
			$update_array = array();
			if ($_POST['pricerange']){
			    foreach ((array)$_POST['pricerange'] as $k=>$v){
			        $pricerange_arr[] = $v;
			    }
			    $update_array['stat_pricerange'] = serialize($pricerange_arr);
			} else {
			    $update_array['stat_pricerange'] = '';
			}
			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				$this->log(L('nc_edit,stat_setting'),1);
				showMessage(L('nc_common_save_succ'));
			}else {
				$this->log(L('nc_edit,stat_setting'),0);
				showMessage(L('nc_common_save_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		$list_setting['stat_pricerange'] = unserialize($list_setting['stat_pricerange']);
		Tpl::output('list_setting',$list_setting);
	    Tpl::output('top_link',$this->sublink($this->links, 'setting'));
	    Tpl::showpage('stat.setting');
	}
	/**
	 * 统计设置
	 */
	public function orderprangeOp(){
	    $model_setting = Model('setting');
		if (chksubmit()){
			$update_array = array();
			if ($_POST['pricerange']){
			    foreach ((array)$_POST['pricerange'] as $k=>$v){
			        $pricerange_arr[] = $v;
			    }
			    $update_array['stat_orderpricerange'] = serialize($pricerange_arr);
			} else {
			    $update_array['stat_orderpricerange'] = '';
			}
			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				$this->log(L('nc_edit,stat_setting'),1);
				showMessage(L('nc_common_save_succ'));
			} else {
				$this->log(L('nc_edit,stat_setting'),0);
				showMessage(L('nc_common_save_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		$list_setting['stat_orderpricerange'] = unserialize($list_setting['stat_orderpricerange']);
		Tpl::output('list_setting',$list_setting);
	    Tpl::output('top_link',$this->sublink($this->links, 'orderprange'));
	    Tpl::showpage('stat.setting.orderprange');
	}
}
