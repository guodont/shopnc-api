<?php
/**
 * 前台闲置物品搜索页面
 * by abc.com
 */
defined('InShopNC') or exit('Access Invalid!');

class flea_classControl extends BaseHomeControl {
	/**
	 *	验证是否开启闲置功能
	 */
	public function __construct(){
		parent::__construct();
		Language::read('home_flea_index');
		if($GLOBALS['setting_config']['flea_isuse']!='1'){
			showMessage(Language::get('flea_index_unable'),'index.php','','error');
		}
	}
	/**
	 * 闲置物品搜索列表
	 */
	public function indexOp(){
		//加载模型
		$flea_model		= Model('flea');
		$member_model	= Model('member');
		$class_model	= Model('flea_class');
		$area_model		= Model('flea_area');
		/**
		 * 热门搜索
		 */
		// 转码  防止GBK下用中文逗号截取不正确
		$comma = '，';
		if (strtoupper(CHARSET) == 'GBK'){
			$comma = Language::getGBK($comma);
		}
		$flea_hot_search = explode(',',str_replace($comma,',',$GLOBALS['setting_config']['flea_hot_search']));
		Tpl::output('flea_hot_search',$flea_hot_search);
		/**
		 * 地区切换
		 */
		$area_array	= $area_model->area_show();
		Tpl::output('area_one_level', $area_array['area_one_level']);
		Tpl::output('area_two_level', $area_array['area_two_level']);
		/**
		 * 查询模块
		 */
		
		$condition		= array();
		$condition_out	= array();
		$area_id		= intval($_GET['area_input']);
		/*	如果有地区id传入	*/
		if($area_id	> 0){
			/* 	查询父级id为传入id的所有结果	*/
			$area_result	= $area_model->getListArea(array('flea_area_parent_id'=>$area_id));
			
			/*	增加当前选择地区的检索热度	*/
			$param['flea_area_hot']['value']	= 1;
			$param['flea_area_hot']['sign']		= 'increase';
			$param['flea_area_id']				= $area_id;
			$area_model->update($param);
			
			/*	组合查询地区id	*/
			$condition['areaid']			= "'".$area_id."'";

			/*	页面输出可选择地区列表	*/
			/* 传入的地区 */
			$area_current	= $area_model->getOneArea($area_id);
			if($area_result){
				/*	不是最后一级地区	*/
				foreach($area_result as $val){
					$condition['areaid']	.= ',\''.$val['flea_area_id'].'\'';
				}
				
				Tpl::output('out_area',$area_result);
				Tpl::output('area_main',$area_current);
			}else{
				$out_area	= $area_model->getListArea(array('flea_area_parent_id'=>$area_current['flea_area_parent_id']));
				$area_main	= $area_model->getOneArea($area_current['flea_area_parent_id']);
				Tpl::output('out_area',$out_area);
				Tpl::output('area_main',$area_main);
			}
			$condition_out['area_input']	= $area_id;
		}else{
			$list_area	= array();
			$list_area['flea_area_deep']	= 2;
			$list_area['area_hot']			= '1';
			$list_area['order']				= 'flea_area_hot desc';
			$list_area['limit']				= '0,8';
			$list_area['field']				= 'flea_area_name,flea_area_id';
			$result	= $area_model->getListArea($list_area);
			Tpl::output('out_area', $result);
		}
		
		$cate_input		= intval($_GET['cate_input']);
		if($cate_input > 0){
			$fc_result		= $class_model->getNextLevelGoodsClassById($cate_input);
			Tpl::output('out_class',$fc_result);
			/*	组合查询分类id	*/
			$condition_out['cate_input']	= $cate_input;
			
			/*	组合查询分类id	*/
			$gc_result		= $class_model->getChildClass($cate_input);
			$part	= '';
			foreach($gc_result as $v){
				$part 		.= '\''.$v['gc_id'].'\',';
			}
			$condition['gc_id_in'] = rtrim($part,',');
			
		}else{
			
			$class_list	=  array();
			$class_list['gc_parent_id']	= '0';
			$class_list['field']		= 'gc_name,gc_id';
			$fc_result	= $class_model->getClassList($class_list);
			Tpl::output('out_class', $fc_result);
			
		}
		$condition_out['start_input']	= $condition['start_input']	= intval($_GET['start_input']);
		$condition_out['end_input']		= $condition['end_input']	= intval($_GET['end_input']);
		$condition_out['price_input']	= $condition['price_input']	= intval($_GET['price_input']);
		if($condition_out['price_input'] > 0){
			switch($condition_out['price_input']){
				case "35":
					$condition['start_input']	= '20';
					$condition['end_input']		= '50';
					break;
				case "75":
					$condition['start_input']	= '50';
					$condition['end_input']		= '100';
					break;
				case "150":
					$condition['start_input']	= '100';
					$condition['end_input']		= '200';
					break;
				case "350":
					$condition['start_input']	= '200';
					$condition['end_input']		= '500';
					break;
				case "750":
					$condition['start_input']	= '500';
					$condition['end_input']		= '1000';
					break;
				case "1000":
					$condition['start_input']	= '1000';
					$condition['end_input']		= '';
					break;
			}
			
		}
		
		$condition_out['quality_input']	= $condition['quality_input']	= intval($_GET['quality_input']);
		$condition_out['key_input']		= $condition['key_input']		= $_GET['key_input'];
		$condition_out['seller_input']	= $condition['seller_input']	= intval($_GET['seller_input']);
		$condition_out['rank_input']	= $condition['rank_input']		= intval($_GET['rank_input']);
		if($condition['rank_input'] == 1){
			$condition['order']			= 'goods_store_price desc';
		}
		if($condition['rank_input'] == 2){
			$condition['order']			= 'goods_store_price asc';
		}
		$condition_out['pic_input']		= $condition['pic_input']		= $_GET['pic_input'];
		if(!$condition['pic_input']){
			$condition['pic_input']		=2;
		}

		
		/*	输出保留的前台查询条件	*/
		Tpl::output('condition_out', $condition_out);
		/**
		 * 闲置物品显示模块
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$listgoods	= $flea_model->listGoods($condition, $page);
		if($listgoods){
			foreach($listgoods as $replace_key => $replace_val){
				$listgoods[$replace_key]['member_info']		= $flea_model->statistic($replace_val['member_id']);
				if($listgoods[$replace_key]['member_info']['member_avatar']){
					$listgoods[$replace_key]['member_info']['avatar']	= ATTACH_AVATAR.'/'.$listgoods[$replace_key]['member_info']['member_avatar'];
				}else{
					$listgoods[$replace_key]['member_info']['avatar']	= TEMPLATES_PATH.'/images/default_user_portrait.gif';
				}
				if($replace_val['goods_image']){
					$listgoods[$replace_key]['image_url']	= UPLOAD_SITE_URL.DS.ATTACH_MALBUM.'/'.$_SESSION['member_id'].'/'.$replace_val['goods_image'];
				}else{
					$listgoods[$replace_key]['image_url']	= SHOP_TEMPLATES_URL.'/images/member/default_image.png';
				}
				$exge='/<[^>]*>|\s+/';
				$listgoods[$replace_key]['explain']	= preg_replace($exge,'',$replace_val['goods_body']);
				$listgoods[$replace_key]['time']	= $this->time_comb(intval($replace_val['goods_add_time']));
				switch($replace_val['flea_quality']){
					case 10:
						$quality	= Language::get('flea_index_new');
						break;
					case 9:
						$quality	= Language::get('flea_index_almost_new');
						break;
					case 8:
						$quality	= Language::get('flea_index_gently_used');
						break;
					default;
						$quality	= Language::get('flea_index_old');
						break;
				}
				$listgoods[$replace_key]['quality']	= $quality;
			}
		}
		Tpl::output('listgoods', $listgoods);
		Tpl::output('show_page', $page->show());
		/**
		 * 刚刚发布模块
		 */
		$pre_sale	= $flea_model->saleGoods(array('limit'=>'0,4'));
		Tpl::output('pre_sale', $pre_sale);
		/**
		 * 关注模块
		 */
		$attention	= $flea_model->listGoods(array('limit'=>'0,8','order'=>'flea_collect_num desc'));
		Tpl::output('attention',$attention);
		/**
		 * 导航模块
		 */
		$navigation=array(
			'index.php?act=flea_class'=>Language::get('flea_index_all')
		);
		/*	卖家优先 */
		if($condition['seller_input']){
			$seller_info	= $member_model->infoMember(array('member_id'=>$condition['seller_input']));
			$key			= 'index.php?act=flea_class&seller_input='.$condition['seller_input'];
			$navigation[$key]	= $seller_info['member_name'];
		}elseif($cate_input){
			$class_info = $class_model->getGoodsClassNow($cate_input);
			foreach($class_info	 as $val){
				$key	= 'index.php?act=flea_class&cate_input='.$val['gc_id'];
				$navigation[$key]	= $val['name'];
			}
			
		}
		/*	分类次之 */
		Tpl::output('navigation',$navigation);
		
		/*	页面显示所有商品总数	*/
		$all_num	= $flea_model->listGoods($condition);
		Tpl::output('all_num',$all_num);
		/**
		 * 页面输出
		 */
		Tpl::showpage('flea_class','flea_layout');
	}
	/**
	 * 查看成色的划分
	 */
	public function quality_innerOp(){
		Tpl::showpage('quality_inner','null_layout');
	}
	private function time_comb($goods_add_time){
		$now_time	= time();
		$last_time	= $now_time - $goods_add_time;
		if($last_time>2592000)	return intval($last_time/2592000).Language::get('flea_index_mouth');
		if($last_time>86400)	return intval($last_time/86400).Language::get('flea_index_day');
		if($last_time>3600)		return intval($last_time/3600).Language::get('flea_index_hour');
		if($last_time>60)		return intval($last_time/60).Language::get('flea_index_minute');
		return $last_time.Language::get('flea_index_seconds');
	}
}
