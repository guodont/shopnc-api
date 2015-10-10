<?php
/**
 * 积分礼品
 ***/


defined('InShopNC') or exit('Access Invalid!');
class pointprodControl extends BasePointShopControl{
	public function __construct() {
		parent::__construct();
		//读取语言包
		Language::read('home_pointprod');
		//判断系统是否开启积分兑换功能
		if (C('pointprod_isuse') != 1){
			showDialog(L('pointprod_unavailable'),'index.php','error');
		}
		Tpl::output('index_sign','pointshop');
	}
	public function indexOp(){
	    $this->plistOp();
	}
	/**
	 * 积分商品列表
	 */
	public function plistOp(){
	    //查询会员及其附属信息
	    $result = parent::pointshopMInfo(true);
	    $member_info = $result['member_info'];
	    unset($result);
	    
	    $model_pointprod = Model('pointprod');
	    
	    //展示状态
	    $pgoodsshowstate_arr = $model_pointprod->getPgoodsShowState();
	    //开启状态
	    $pgoodsopenstate_arr = $model_pointprod->getPgoodsOpenState();
	    
	    $model_member = Model('member');
	    //查询会员等级
	    $membergrade_arr = $model_member->getMemberGradeArr();
	    Tpl::output('membergrade_arr', $membergrade_arr);
	    
	    //查询兑换商品列表
	    $where = array();
	    $where['pgoods_show'] = $pgoodsshowstate_arr['show'][0];
	    $where['pgoods_state'] = $pgoodsopenstate_arr['open'][0];
	    //会员级别
	    $level_filter = array();
	    if (isset($_GET['level'])){
	        $level_filter['search'] = intval($_GET['level']);
	    }
	    if (intval($_GET['isable']) == 1){
	        $level_filter['isable'] = intval($member_info['level']);
	    }
	    if (count($level_filter) > 0){
	        if (isset($level_filter['search']) && isset($level_filter['isable'])){
	            $where['pgoods_limitmgrade'] = array(array('eq',$level_filter['search']),array('elt',$level_filter['isable']),'and');
	        } elseif (isset($level_filter['search'])){
	            $where['pgoods_limitmgrade'] = $level_filter['search'];
	        } elseif (isset($level_filter['isable'])){
	            $where['pgoods_limitmgrade'] = array('elt',$level_filter['isable']);
	        } 
	    }
	    
	    
	    //查询仅我能兑换和所需积分
	    $points_filter = array();
	    if (intval($_GET['isable']) == 1){
	        $points_filter['isable'] = $member_info['member_points'];
	    }
	    if (intval($_GET['points_min']) > 0){
	        $points_filter['min'] = intval($_GET['points_min']);
	    }
	    if (intval($_GET['points_max']) > 0){
	        $points_filter['max'] = intval($_GET['points_max']);
	    }
	    if (count($points_filter) > 0){
	        asort($points_filter);
	        if (count($points_filter) > 1){
	            $points_filter = array_values($points_filter);
	            $where['pgoods_points'] = array('between',array($points_filter[0],$points_filter[1]));
	        } else {
	            if ($points_filter['min']){
	                $where['pgoods_points'] = array('egt',$points_filter['min']);
	            } elseif ($points_filter['max']) {
	                $where['pgoods_points'] = array('elt',$points_filter['max']);
	            } elseif ($points_filter['isable']) {
	                $where['pgoods_points'] = array('elt',$points_filter['isable']);
	            }
	        }
	    }
	    //排序
	    switch ($_GET['orderby']){
	    	case 'stimedesc':
	    	    $orderby = 'pgoods_starttime desc,';
	    	    break;
	    	case 'stimeasc':
	    	    $orderby = 'pgoods_starttime asc,';
	    	    break;
	    	case 'pointsdesc':
	    	    $orderby = 'pgoods_points desc,';
	    	    break;
	    	case 'pointsasc':
	    	    $orderby = 'pgoods_points asc,';
	    	    break;
	    }
	    $orderby .= 'pgoods_sort asc,pgoods_id desc';
	    
		$pointprod_list = $model_pointprod->getPointProdList($where, '*', $orderby,'',20);
		Tpl::output('pointprod_list',$pointprod_list);
		Tpl::output('show_page', $model_pointprod->showpage(2));
		
		//分类导航
		$nav_link = array(
		        0=>array('title'=>L('homepage'),'link'=>SHOP_SITE_URL),
		        1=>array('title'=>'积分中心','link'=>urlShop('pointshop','index')),
		        2=>array('title'=>'兑换礼品列表')
		);
		Tpl::output('nav_link_list', $nav_link);
		Tpl::showpage('pointprod_list');
	}
	/**
	 * 积分礼品详细
	 */
	public function pinfoOp() {
		$pid = intval($_GET['id']);
		if (!$pid){
			showDialog(L('pointprod_parameter_error'),urlShop('pointshop','index'),'error');
		}
		$model_pointprod = Model('pointprod');
		//查询兑换礼品详细
		$prodinfo = $model_pointprod->getOnlinePointProdInfo(array('pgoods_id'=>$pid));
		if (empty($prodinfo)){
			showDialog(L('pointprod_record_error'),urlShop('pointprod','plist'),'error');
		}		
		Tpl::output('prodinfo',$prodinfo);
		
		//更新礼品浏览次数
		$tm_tm_visite_pgoods = cookie('tm_visite_pgoods');
		$tm_tm_visite_pgoods = $tm_tm_visite_pgoods?explode(',', $tm_tm_visite_pgoods):array();
		if (!in_array($pid, $tm_tm_visite_pgoods)){//如果已经浏览过该商品则不重复累计浏览次数 
		    $result = $model_pointprod->editPointProdViewnum($pid);
 		    if ($result['state'] == true){//累加成功则cookie中增加该商品ID
		        $tm_tm_visite_pgoods[] = $pid;
		        setNcCookie('tm_visite_pgoods',implode(',', $tm_tm_visite_pgoods));
		    }
		}

		//查询兑换信息
		$model_pointorder = Model('pointorder');
		$pointorderstate_arr = $model_pointorder->getPointOrderStateBySign();
		$where = array();
		$where['point_orderstate'] = array('neq',$pointorderstate_arr['canceled'][0]);
		$where['point_goodsid'] = $pid;
		$orderprod_list = $model_pointorder->getPointOrderAndGoodsList($where, '*', 0, 4,'points_ordergoods.point_recid desc');
		if ($orderprod_list){
		    $buyerid_arr = array();
			foreach ($orderprod_list as $k=>$v){
			    $buyerid_arr[] = $v['point_buyerid'];
			}
			$memberlist_tmp = Model('member')->getMemberList(array('member_id'=>array('in',$buyerid_arr)),'member_id,member_avatar');
			$memberlist = array();
			if ($memberlist_tmp){
				foreach ($memberlist_tmp as $v){
				    $memberlist[$v['member_id']] = $v;
				}
			}
			foreach ($orderprod_list as $k=>$v){
				$v['member_avatar'] = ($t = $memberlist[$v['point_buyerid']]['member_avatar'])?UPLOAD_SITE_URL.DS.ATTACH_AVATAR.DS.$t : UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.C('default_user_portrait');
				$orderprod_list[$k] = $v;
			}
		}
		Tpl::output('orderprod_list',$orderprod_list);
		
		//热门积分兑换商品
		$recommend_pointsprod = $model_pointprod->getRecommendPointProd(5);
		Tpl::output('recommend_pointsprod',$recommend_pointsprod);
		
		$seo_param = array();
		$seo_param['name'] = $prodinfo['pgoods_name'];
		$seo_param['key'] = $prodinfo['pgoods_keywords'];
		$seo_param['description'] = $prodinfo['pgoods_description'];
		Model('seo')->type('point_content')->param($seo_param)->show();
		//分类导航
		$nav_link = array(
		        0=>array('title'=>L('homepage'),'link'=>SHOP_SITE_URL),
		        1=>array('title'=>'积分中心','link'=>urlShop('pointshop','index')),
		        2=>array('title'=>'兑换礼品详情')
		);
		Tpl::output('nav_link_list', $nav_link);
		Tpl::showpage('pointprod_info');
	}
}
