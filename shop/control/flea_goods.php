<?php
/**
 * 前台闲置物品展示
 * by abc.com
 */
defined('InShopNC') or exit('Access Invalid!');
class flea_goodsControl extends BaseHomeControl {
	/**
	 *	验证是否开启闲置功能
	 */
	public function __construct(){
		parent::__construct();
		Language::read('home_flea_index');
		if($GLOBALS['setting_config']['flea_isuse']!='1'){
			showMessage(Language::get('flea_index_unable'),'index.php');
		}
	}
	/**
	 * 单个闲置物品信息页
	 */
	public function indexOp() {
		/**
		 * 加载语言包 
		 */
		Language::read('home_layout,home_flea_goods_index');
		$lang	= Language::getLangContent();
		/**
		 * 地区输出
		 */
		$area_model	= Model('flea_area');
		$area_array	= $area_model->area_show();
		Tpl::output('area_one_level', $area_array['area_one_level']);
		Tpl::output('area_two_level', $area_array['area_two_level']);
		/**
		 * 验证goods_id
		 */
		if(empty($_GET['goods_id']))showMessage($lang['miss_argument'],'','html','error');//"缺少参数:商品编号"
		$goods_id	= intval($_GET['goods_id']);
		//留言成功调转到留言
		if(!empty($_GET['succ'])){
			if($_GET['succ']=='succ'){
				$succ_link = 'location:index.php?act=flea_goods&goods_id='.$_GET['goods_id']."#flea_message";
				@header($succ_link);
			}
		}
		/**
		 * 实例化店铺商品模型
		 */
		$model_store_goods	= Model('flea');
		$goods_array		= $model_store_goods->listGoods(array('goods_id'=>intval($_GET['goods_id']),'goods_show'=>'1'),'','flea.*');
		
		if(empty($goods_array))showMessage($lang['goods_index_no_goods'],'','html','error');//'商品不存在'
		/**
		 * 图片路径
		 */
		
		$goods_image_path = UPLOAD_SITE_URL.DS.ATTACH_MALBUM.'/'.$goods_array[0]['member_id'].'/';;	//店铺商品图片目录地址
		$goods_array[0]['goods_image']	= $goods_array[0]['goods_image']!='' ? $goods_image_path.$goods_array[0]['goods_image'] :SHOP_TEMPLATES_URL.'/images/member/default_image.png';
		$goods_array[0]['goods_tag']	= explode(',',str_replace('，',',',$goods_array[0]['goods_tag']));
		
		/**
		 * 页面title
		 */
		Tpl::output('goods_title',$goods_array[0]['goods_name']);
		Tpl::output('seo_keywords',$goods_array[0]['seo_keywords']);
		Tpl::output('seo_description',$goods_array[0]['seo_description']);
		/**
		 * 商品多图
		 */
		$desc_image	= $model_store_goods->getListImageGoods(array('image_store_id'=>$goods_array[0]['member_id'],'item_id'=>$goods_array[0]['goods_id'],'image_type'=>12));
		$model_store_goods->getThumb($desc_image,$goods_image_path);
		
		$image_key = 0;
		if(!empty($desc_image) && is_array($desc_image)) {//将封面图放到第一位显示
			$goods_image_1	= $goods_array[0]['goods_image'];//封面图
			foreach ($desc_image as $key => $val) {
				if($goods_image_1 == $val['thumb_small']){
					$image_key = $key;break;
				}
			}
			if($image_key > 0) {//将封面图放到第一位显示
				$desc_image_0	= $desc_image[0];
				$desc_image[0]	= $desc_image[$image_key];
				$desc_image[$image_key]	= $desc_image_0;
			}
		}

		Tpl::output('goods',$goods_array[0]);
		Tpl::output('goods_image',$desc_image[0]);
		Tpl::output('desc_image',$desc_image);
		Tpl::output('goods_image_path',$goods_image_path);
		/**
		 * 获取用户信息 
		 */
		$model_member = Model('member');
		$member_info = $model_member->infoMember(array('member_id'=>$goods_array[0]['member_id']));
		Tpl::output('flea_member_info',$member_info);
		/**
		 * 闲置物品发布者的其他闲置物品
		 */
		$other_flea_info = $model_store_goods->listGoods(array('goods_id_diff'=>intval($_GET['goods_id']),'goods_show'=>'1','limit'=>'2'),'','flea.*');
		$other_flea_info2 = $model_store_goods->listGoods(array('member_id'=>$goods_array[0]['member_id'],'goods_show'=>'1'),'','flea.*');
		Tpl::output('goods_commend2',$other_flea_info);
		Tpl::output('goods_commend3',$other_flea_info2);
		/**
		 * 得到商品的seo信息
		 */
		$seo_keywords    = $goods_array[0]['goods_keywords'];
		$seo_description = $goods_array[0]['goods_description'];
		Tpl::output('seo_keywords',$seo_keywords);
		Tpl::output('seo_description',$seo_description);
		/**
		 * 得到商品咨询信息
		 */
		$consult		= Model('flea_consult');
		$consult_list	= $consult->getConsultList(array('goods_id'=>$goods_id,'order'=>'consult_id desc'),'','seller');
		Tpl::output('consult_list',$consult_list);
		/**
		 * 浏览次数更新
		 */
		$model_store_goods->updateGoods(array('goods_click'=>($goods_array[0]['goods_click']+1)),$goods_id);
		/**
		 * 推荐
		 */
		$goods_list = $model_store_goods->listGoods(array('limit'=>'27','pic_input'=>'2'));
		list($goods_commend_list, $goods_commend_list4, $goods_commend_list5)	= @array_chunk($goods_list, 9);
		Tpl::output('goods_commend',$goods_commend_list);
		Tpl::output('goods_commend4',$goods_commend_list4);
		Tpl::output('goods_commend5',$goods_commend_list5);
		Tpl::showpage('flea_goods','flea_layout');
	}
	/**
	 * 闲置物品咨询添加
	 */
	public function save_consultOp(){
		//判断是否登录
		if(empty($_SESSION['member_id'])){
			showMessage(Language::get('flea_consult_notice'),'','','error');
		}
		Language::read('home_flea_goods_index');
		$lang	= Language::getLangContent();
		/**
		 * 判断商品编号的存在性和合法性
		 */
		$goods	= Model('flea');
		$condition	= array();
		$goods_info	= array();
		if($_POST['type_name']==''){
			$condition['goods_id']	= $_POST['goods_id'];
			$goods_info	= $goods->listGoods($condition);
		}
		if(empty($goods_info)){
			if($_POST['type_name']==''){
				showMessage($lang['goods_index_goods_not_exists'],'','html','error');
			}
		}
		/**
		 * 咨询内容的非空验证
		 */
		if(trim($_POST['content'])===""){
			showMessage($lang['goods_index_input_consult'],'','html','error');//'请输入咨询内容'
		}
		$model_member = Model('member');
		$member_info = $model_member->infoMember(array('member_id'=>$_GET['goods_id']));
		/**
		 * 接收数据并保存
		 */
		$input	= array();
		$input['seller_id']			= $member_info['member_id'];
		$input['member_id']			= $_POST['hide_name']?0:(empty($_SESSION['member_id'])?0:$_SESSION['member_id']);
		$input['goods_id']			= $_POST['goods_id'];
		$input['email']				= $_POST['email'];
		$input['consult_content']	= $_POST['content'];
		if($_POST['type_name']==''){
			$input['type']			= 'flea';
		}else{
			$input['type']			= $_POST['type_name'];
		}
		$consult	= Model('flea_consult');
		if($consult->addConsult($input)){
			/*	闲置物品表增加评论次数	*/
			$condition['commentnum']['value']='1';
			$condition['commentnum']['sign']='increase';
			$goods->updateGoods($condition,intval($_POST['goods_id']));
			$succ_link = 'index.php?act=flea_goods&goods_id='.intval($_POST['goods_id']).'&succ=succ';
			showMessage($lang['goods_index_consult_success'],$succ_link);//'咨询发布成功'
		}else{
			showMessage($lang['goods_index_consult_fail'],'','html','error');//'咨询发布超时'
		}
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

/**
 * 取得的时间间隔 
 */
function checkTime($time){
	if($time==''){
		return false;
	}
	Language::read('common_flea');
	$lang	= Language::getLangContent();
	$catch_time = (time() - $time);
	if($catch_time < 60){
		echo $catch_time.$lang['second'];
	}elseif ($catch_time < 60*60){
		echo intval($catch_time/60).$lang['minute'];
	}elseif ($catch_time < 60*60*24){
		echo intval($catch_time/60/60).$lang['hour'];
	}elseif ($catch_time < 60*60*24*365){
		echo intval($catch_time/60/60/24).$lang['day'];
	}elseif ($catch_time < 60*60*24*365*999){
		echo intval($catch_time/60/60/24/365).$lang['year'];
	}
}
