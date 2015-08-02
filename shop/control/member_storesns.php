<?php
/**
 * 店铺动态
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class member_storesnsControl extends BaseMemberControl{
	const MAX_RECORDNUM = 20;	// 允许插入新记录的最大次数，sns页面该常量是一样的。
	public function __construct(){
		parent::__construct();
		Language::read('store_sns,member_sns');
		Tpl::output('max_recordnum', self::MAX_RECORDNUM);
	}
	/**
	 * 买家中心店铺动态
	 */
	public function stracelistOp(){

		//查询收藏的店铺
		$model_favorites = Model('favorites');
		//条件
		$where = array('member_id' => $_SESSION['member_id']);
		$fav_store_id = $model_favorites->getStoreFavoritesList($where, 'fav_id');
		// 整理
		if(!empty($fav_store_id) && is_array($fav_store_id)){
			$storeid_array = '';
			foreach($fav_store_id as $val){
				$storeid_array[] = $val['fav_id'];
			}
			$where = array(
						'strace_storeid'=>array('in',$storeid_array),
						'strace_state'=>1
					);
			$model_stracelog = Model('store_sns_tracelog');
			$count = $model_stracelog->getStoreSnsTracelogCount($where);
			//分页
			$page	= new Page();
			$page->setEachNum(30);
			$page->setStyle('admin');
			$page->setTotalNum($count);
			$delaypage = intval($_GET['delaypage'])>0?intval($_GET['delaypage']):1;//本页延时加载的当前页数
			$lazy_arr = lazypage(10,$delaypage,$count,true,$page->getNowPage(),$page->getEachNum(),$page->getLimitStart());
			//动态列表
			$limit = $lazy_arr['limitstart'].",".$lazy_arr['delay_eachnum'];
			$strace_array = $count = $model_stracelog->getStoreSnsTracelogList($where, '*', 'strace_id desc', $limit);
			if (!empty($strace_array)){
				foreach ($strace_array as $key=>$val){
					if($val['strace_content'] == ''){
						$val['strace_goodsdata'] = json_decode($val['strace_goodsdata'],true);
						if( CHARSET == 'GBK') {
							foreach ((array)$val['strace_goodsdata'] as $k=>$v){
								$val['strace_goodsdata'][$k] = Language::getGBK($v);
							}
						}
						$content = $model_stracelog->spellingStyle($val['strace_type'], $val['strace_goodsdata']);
						$strace_array[$key]['strace_content'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $content);
					}
				}
			}
			Tpl::output('show_page',$page->show());
		}
		Tpl::output('hasmore',$lazy_arr['hasmore']);
		Tpl::output('strace_array',$strace_array);
		Tpl::output('type','index');
		Tpl::showpage('member_storesns.tracelist','null_layout');
	}
}
