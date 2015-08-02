<?php
/**
 * 活动
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class activityControl extends BaseHomeControl {
	/**
	 * 单个活动信息页
	 */
	public function indexOp(){
		//读取语言包
		Language::read('home_activity_index');
		//得到导航ID
		$nav_id = intval($_GET['nav_id']) ? intval($_GET['nav_id']) : 0 ;
		Tpl::output('index_sign',$nav_id);
		//查询活动信息
		$activity_id = intval($_GET['activity_id']);
		if($activity_id<=0){
			showMessage(Language::get('para_error'),'index.php','html','error');//'缺少参数:活动编号'
		}
		$activity	= Model('activity')->getOneById($activity_id);
		if(empty($activity) || $activity['activity_type'] != '1' || $activity['activity_state'] != 1 || $activity['activity_start_date']>time() || $activity['activity_end_date']<time()){
			showMessage(Language::get('activity_index_activity_not_exists'),'index.php','html','error');//'指定活动并不存在'
		}
		Tpl::output('activity',$activity);
		//查询活动内容信息
		$list	= array();
		$list	= Model('activity_detail')->getGoodsList(array('order'=>'activity_detail.activity_detail_sort asc','activity_id'=>"$activity_id",'goods_show'=>'1','activity_detail_state'=>'1'));

		Tpl::output('list',$list);
		Tpl::output('html_title',C('site_name').' - '.$activity['activity_title']);
		Tpl::showpage('activity_show');
	}
}
