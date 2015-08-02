<?php
/**
 * 闲置市场默认展示页面
 * by abc.com
 */
defined('InShopNC') or exit('Access Invalid!');
class fleaControl extends BaseHomeControl{
	/**
	 * 闲置市场首页
	 */
	public function __construct(){
		parent::__construct();
		Language::read('home_flea_index');
		if($GLOBALS['setting_config']['flea_isuse']!='1'){
			showMessage(Language::get('flea_index_unable'),'index.php','','error');
		}
	}
	public function indexOp(){
		/**
		 * 读取语言包
		 */
		Language::read('flea_index_index');
		/**
		 * 地区
		 */
		$area_model=Model('flea_area');
		$area_array	= $area_model->area_show();
		Tpl::output('area_one_level', $area_array['area_one_level']);
		Tpl::output('area_two_level', $area_array['area_two_level']);
		/**
		 * 分类
		 */
		$model_goods_class	= Model('flea_class');
		$goods_class		= $model_goods_class->getTreeClassList(3,array('gc_show'=>1,'order'=>'gc_parent_id asc,gc_sort asc,gc_id asc'));
		if(is_array($goods_class) and !empty($goods_class)) {
			$show_goods_class = array();
			$arr = array();
			foreach ($goods_class as $val) {
				if($val['gc_parent_id'] == 0) {
					$show_goods_class[$val['gc_id']]['class_name']		= $val['gc_name'];
					$show_goods_class[$val['gc_id']]['class_id']		= $val['gc_id'];
					$show_goods_class[$val['gc_id']]['gc_index_show']	= $val['gc_index_show'];
					
					$arr[$val['gc_id']]['class_name']	=  $val['gc_name'];
					$arr[$val['gc_id']]['class_id']		=  $val['gc_id'];
					$arr[$val['gc_id']]['gc_id_str'] 	.= ','.$val['gc_id'];
				} else {
					if(isset($show_goods_class[$val['gc_parent_id']])){
						$show_goods_class[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['class_name']	= $val['gc_name'];
						$show_goods_class[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['class_id']		= $val['gc_id'];
						$show_goods_class[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_parent_id']	= $val['gc_parent_id'];
						$show_goods_class[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_index_show']= $val['gc_index_show'];
						
						$arr[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['class_name']	= $val['gc_name'];
						$arr[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['class_id']		= $val['gc_id'];
						$arr[$val['gc_parent_id']]['gc_id_str'] .= ','.$val['gc_id'];
					}else{
						foreach ($show_goods_class as $v){
							if(isset($v['sub_class'][$val['gc_parent_id']])){
								$show_goods_class[$v['sub_class'][$val['gc_parent_id']]['gc_parent_id']]['sub_class'][$val['gc_parent_id']]['sub_class'][$val['gc_id']]['class_name'] = $val['gc_name'];
								$show_goods_class[$v['sub_class'][$val['gc_parent_id']]['gc_parent_id']]['sub_class'][$val['gc_parent_id']]['sub_class'][$val['gc_id']]['class_id'] = $val['gc_id'];
								
								$arr[$v['sub_class'][$val['gc_parent_id']]['gc_parent_id']]['gc_id_str'] .= ','.$v['gc_id'];
							}
						}
					}
				}
			}
		}
		
		$new_arr = array();
		$model_flea = Model('flea');
		if(is_array($arr) and !empty($arr)) {
		foreach ($arr as $key=>$value){
			if(is_array($new_arr[4])&&!empty($new_arr[4])) break;//只取前5条分类下有的商品
			$arr[$key]['goods'] = $model_flea->getGoodsByClass(array(
				'field'=>'goods_id,goods_name,goods_store_price,flea_quality,member_id,goods_image',
				'pic_input'=>'2',
				'gc_id_list'=>$value['gc_id_str'],
				'order'=>'goods_id desc',
				'limit'=>'14')
			);
			if(is_array($arr[$key]['goods'])&&!empty($arr[$key]['goods'])) $new_arr[]=$arr[$key];
		}
		}
		Tpl::output('show_flea_goods_class_list',$new_arr);
		/**
		 * js滑动参数
		 */
		$str = '';
		$str1 = '';
		for ( $j=1 ; $j<=count($new_arr) ; $j++){
			$str	.= '"m0'.$j.'"'.',';
			$str1	.= '"c0'.$j.'"'.',';
		}
		$str	= rtrim($str, ",");
		$str1	= rtrim($str1, ",");
		Tpl::output('mstr',$str);
		Tpl::output('cstr',$str1);
		/**
		 * 新鲜货
		 */
		$new_flea_goods = $model_flea->listGoods(array('limit'=>'1','order'=>'goods_id desc','pic_input'=>'2','body_input'=>'2'));
		Tpl::output('new_flea_goods',$new_flea_goods['0']);
		/**
		 * 收藏第一
		 */
		$col_flea_goods = $model_flea->listGoods(array('limit'=>'1','order'=>'flea_collect_num desc','pic_input'=>'2'));
		Tpl::output('col_flea_goods',$col_flea_goods['0']);
		/**
		 * 标题过滤
		 */
		$tstr =  $new_flea_goods[0]['goods_body'];
		$zz=array(
			'/(<p(.*?)>|<\/p>)/i',
			'/(<span(.*?)>|<\/p>)/i',
			'/(<img(.*?)>|<\/p>)/i',
			'/(<h1(.*?)>|<\/p>)/i',
			'/(<u(.*?)>|<\/p>)/i',
			'/(<strong(.*?)>|<\/p>)/i',
			'/\s*/'
			);
		$con=array(
			'',
			'',
			'',
			'',
			'',
			'',
			''
			);
		$tstr =  preg_replace($zz, $con,$tstr);
		Tpl::output('one_goods_title',$tstr);
		/**
		 * 热门搜
		 */
		$new_flea_goods2 = $model_flea->listGoods(array('limit'=>'0,14','order'=>'goods_click desc','pic_input'=>'2'));
		Tpl::output('new_flea_goods2',$new_flea_goods2);
		/**
		 * 闲置围观区
		 */
		$new_flea_goods3 = $model_flea->listGoods(array('limit'=>'0,14','order'=>'goods_id desc','pic_input'=>'2'));
		Tpl::output('new_flea_goods3',$new_flea_goods3);
		/**
		 * 导航标识
		 */
		Tpl::output('index_sign','flea');
				// 首页幻灯
		$loginpic = unserialize(C('flea_loginpic'));
		Tpl::output('loginpic', $loginpic);
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
		 * 获取设置信息
		 */
		$model_class		= Model('flea_class');
		$fc_index = $model_class->getFleaIndexClass(array());
		if(!empty($fc_index)&&is_array($fc_index)){
			foreach ($fc_index as $value){
				Tpl::output($value['fc_index_code'],$value);
			}
		}
		Tpl::showpage('flea_index','flea_layout');
	}
}

/**
 * 取得闲置物品的新旧程度
 */
function checkQuality($flea_quality){
	if($flea_quality==''){
		return false;
	}
	Language::read('common_flea');
	$lang	= Language::getLangContent();
	switch ($flea_quality){
		case '10':
			echo $lang['new_10'];
			break;
		case '9':
			echo $lang['new_9'];
			break;
		case '8':
			echo $lang['new_8'];
			break;
		case '7':
			echo $lang['new_7'];
			break;
	}
}