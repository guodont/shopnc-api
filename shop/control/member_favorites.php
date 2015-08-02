<?php
/**
 * 会员中心--收藏功能
 ***/


defined('InShopNC') or exit('Access Invalid!');

class member_favoritesControl extends BaseMemberControl{
	public function __construct(){
        parent::__construct();
        Language::read('member_layout,member_member_favorites');
    }
	/**
	 * 增加商品收藏
	 */
	public function favoritesgoodsOp(){
		$fav_id = intval($_GET['fid']);
		if ($fav_id <= 0){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_collect_fail','UTF-8')));
			die;
		}
		$favorites_model = Model('favorites');
		//判断是否已经收藏
		$favorites_info = $favorites_model->getOneFavorites(array('fav_id'=>"$fav_id",'fav_type'=>'goods','member_id'=>"{$_SESSION['member_id']}"));
		if(!empty($favorites_info)){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_already_favorite_goods','UTF-8')));
			die;
		}
		//判断商品是否为当前会员所有
		$goods_model = Model('goods');
		$goods_info = $goods_model->getGoodsInfoByID($fav_id, 'store_id');
		if ($goods_info['store_id'] == $_SESSION['store_id']){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_no_my_product','UTF-8')));
			die;
		}
		//添加收藏
		$insert_arr = array();
		$insert_arr['member_id'] = $_SESSION['member_id'];
		$insert_arr['fav_id'] = $fav_id;
		$insert_arr['fav_type'] = 'goods';
		$insert_arr['fav_time'] = time();
		$result = $favorites_model->addFavorites($insert_arr);
		if ($result){
			//增加收藏数量
			$goods_model->editGoodsById(array('goods_collect' => array('exp', 'goods_collect + 1')), $fav_id);
			echo json_encode(array('done'=>true,'msg'=>Language::get('favorite_collect_success','UTF-8')));
			die;
		}else{
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_collect_fail','UTF-8')));
			die;
		}
	}
	/**
	 * 增加店铺收藏
	 */
	public function favoritesstoreOp(){
		$fav_id = intval($_GET['fid']);
		if ($fav_id <= 0){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_collect_fail','UTF-8')));
			die;
		}
		$favorites_model = Model('favorites');
		//判断是否已经收藏
		$favorites_info = $favorites_model->getOneFavorites(array('fav_id'=>"$fav_id",'fav_type'=>'store','member_id'=>"{$_SESSION['member_id']}"));
		if(!empty($favorites_info)){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_already_favorite_store','UTF-8')));
			die;
		}
		//判断店铺是否为当前会员所有
		if ($fav_id == $_SESSION['store_id']){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_no_my_store','UTF-8')));
			die;
		}
		//添加收藏
		$insert_arr = array();
		$insert_arr['member_id'] = $_SESSION['member_id'];
		$insert_arr['fav_id'] = $fav_id;
		$insert_arr['fav_type'] = 'store';
		$insert_arr['fav_time'] = time();
		$result = $favorites_model->addFavorites($insert_arr);
		if ($result){
			//增加收藏数量
			$store_model = Model('store');
            $store_model->editStore(array('store_collect'=>array('exp', 'store_collect+1')), array('store_id' => $fav_id));
			echo json_encode(array('done'=>true,'msg'=>Language::get('favorite_collect_success','UTF-8')));
			die;
		}else{
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_collect_fail','UTF-8')));
			die;
		}
	}

	/**
	 * 商品收藏列表
	 *
	 * @param
	 * @return
	 */
	public function fglistOp(){
		$favorites_model = Model('favorites');
		$show_type = 'favorites_goods_picshowlist';//默认为图片横向显示
		$show = $_GET['show'];
		$store_array = array('list'=>'favorites_goods_index','pic'=>'favorites_goods_picshowlist','store'=>'favorites_goods_shoplist');
		if (array_key_exists($show,$store_array)) $show_type = $store_array[$show];

		$favorites_list = $favorites_model->getGoodsFavoritesList(array('member_id'=>$_SESSION['member_id']), '*', 20);
		Tpl::output('show_page',$favorites_model->showpage(2));
		if (!empty($favorites_list) && is_array($favorites_list)){
			$favorites_id = array();//收藏的商品编号
			foreach ($favorites_list as $key=>$favorites){
				$fav_id = $favorites['fav_id'];
				$favorites_id[] = $favorites['fav_id'];
				$favorites_key[$fav_id] = $key;
			}
			$goods_model = Model('goods');
			$field = 'goods.goods_id,goods.goods_name,goods.store_id,goods.goods_image,goods.goods_price,goods.evaluation_count,goods.goods_salenum,goods.goods_collect,store.store_name,store.member_id,store.member_name,store.store_qq,store.store_ww,store.store_domain';
			$goods_list = $goods_model->getGoodsStoreList(array('goods_id' => array('in', $favorites_id)), $field);
			$store_array = array();//店铺编号
			if (!empty($goods_list) && is_array($goods_list)){
				$store_goods_list = array();//店铺为分组的商品
				foreach ($goods_list as $key=>$fav){
					$fav_id = $fav['goods_id'];
					$fav['goods_member_id'] = $fav['member_id'];
					$key = $favorites_key[$fav_id];
					$favorites_list[$key]['goods'] = $fav;
					$store_id = $fav['store_id'];
					if (!in_array($store_id,$store_array)) $store_array[] = $store_id;
					$store_goods_list[$store_id][] = $favorites_list[$key];
				}
			}
			$store_favorites = array();//店铺收藏信息
			if (!empty($store_array) && is_array($store_array)){
				$store_list = $favorites_model->getStoreFavoritesList(array('member_id'=>$_SESSION['member_id'], 'fav_id'=> array('in', $store_array)));
				if (!empty($store_list) && is_array($store_list)){
					foreach ($store_list as $key=>$val){
						$store_id = $val['fav_id'];
						$store_favorites[] = $store_id;
					}
				}
			}
		}
		self::profile_menu('favorites','favorites');
		Tpl::output('menu_key',"fav_goods");
		Tpl::output('favorites_list',$favorites_list);
		Tpl::output('store_favorites',$store_favorites);
		Tpl::output('store_goods_list',$store_goods_list);
		Tpl::showpage($show_type);
	}
	/**
	 * 店铺收藏列表
	 *
	 * @param
	 * @return
	 */
	public function fslistOp(){
		$favorites_model = Model('favorites');
		$favorites_list = $favorites_model->getStoreFavoritesList(array('member_id'=>$_SESSION['member_id']), '*', 10);
		if (!empty($favorites_list) && is_array($favorites_list)){
			$favorites_id = array();//收藏的店铺编号
			foreach ($favorites_list as $key=>$favorites){
				$fav_id = $favorites['fav_id'];
				$favorites_id[] = $favorites['fav_id'];
				$favorites_key[$fav_id] = $key;
			}
			$store_model = Model('store');
			$store_list = $store_model->getStoreList(array('store_id'=>array('in', $favorites_id)));
			if (!empty($store_list) && is_array($store_list)){
				foreach ($store_list as $key=>$fav){
					$fav_id = $fav['store_id'];
					$key = $favorites_key[$fav_id];
					$favorites_list[$key]['store'] = $fav;
				}
			}
		}
		self::profile_menu('favorites','favorites');
		Tpl::output('menu_key',"fav_store");
		Tpl::output('favorites_list',$favorites_list);
		Tpl::output('show_page',$favorites_model->showpage(2));
		Tpl::showpage("favorites_store_index");
	}
	/**
	 * 删除收藏
	 *
	 * @param
	 * @return
	 */
	public function delfavoritesOp(){
		if (!$_GET['fav_id'] || !$_GET['type']){
			showDialog(Language::get('member_favorite_del_fail'),'','error');
		}
		if (!preg_match_all('/^[0-9,]+$/',$_GET['fav_id'], $matches)) {
		    showDialog(Language::get('wrong_argument'),'','error');
		}
		$fav_id = trim($_GET['fav_id'],',');
		if (!in_array($_GET['type'], array('goods', 'store'))) {
		  showDialog(Language::get('wrong_argument'),'','error');
		}
		$type = $_GET['type'];
		$favorites_model = Model('favorites');
		$fav_arr = explode(',',$fav_id);
		if (!empty($fav_arr) && is_array($fav_arr)){
			//批量删除
			$fav_str = "'".implode("','",$fav_arr)."'";
			$result = $favorites_model->delFavorites(array('fav_id_in'=>"$fav_str",'fav_type'=>"$type",'member_id'=>"{$_SESSION['member_id']}"));
			if ($result){
				//剔除删除失败的记录
				$favorites_list = $favorites_model->getFavoritesList(array('fav_id'=>array('in', $fav_arr),'fav_type'=>"$type",'member_id'=>$_SESSION['member_id']));
				if (!empty($favorites_list)){
					foreach ($favorites_list as $k=>$v){
						unset($fav_arr[array_search($v['fav_id'],$fav_arr)]);
					}
				}
				if (!empty($fav_arr)){
					if ($type=='goods'){
						//更新收藏数量
						$goods_model = Model('goods');
						$goods_model->editGoodsById(array('goods_collect'=>array('exp', 'goods_collect - 1')), $fav_arr);
						showDialog(Language::get('favorite_del_success'),'index.php?act=member_favorites&op=fglist&show='.$_GET['show'],'succ');
					}else {
						$fav_str = "'".implode("','",$fav_arr)."'";
						//更新收藏数量
						$store_model = Model('store');
						$store_model->editStore(array('store_collect'=>array('exp', 'store_collect - 1')),array('store_id'=>array('in', $fav_str)));
						showDialog(Language::get('favorite_del_success'),'index.php?act=member_favorites&op=fslist','succ');
					}
				}
			}else {
				showDialog(Language::get('favorite_del_fail'),'','error');
			}

		}else {
			showDialog(Language::get('member_favorite_del_fail'),'','error');
		}
	}
	/**
	 * 店铺新上架的商品列表
	 *
	 * @param
	 * @return
	 */
	public function store_goodsOp(){
		$store_id = intval($_GET["store_id"]);
		if($store_id > 0) {
			$condition = array();
			$add_time_from = TIMESTAMP-60*60*24*30;//30天
			$condition['store_id'] = $store_id;
			$condition['goods_addtime']	= array('between', $add_time_from.','.TIMESTAMP);
			$goods_model = Model('goods');
			$goods_list = $goods_model->getGoodsOnlineList($condition,'goods_id,goods_name,store_id,goods_image,goods_price', 0, 'goods_id desc', 50);
			Tpl::output('goods_list',$goods_list);
			Tpl::showpage('favorites_store_goods','null_layout');
		}
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array = array(
			1=>array('menu_key'=>'fav_goods','menu_name'=>Language::get('nc_member_path_collect_list'),	'menu_url'=>'index.php?act=member_favorites&op=fglist'),
			2=>array('menu_key'=>'fav_store','menu_name'=>Language::get('nc_member_path_collect_store'), 'menu_url'=>'index.php?act=member_favorites&op=fslist')
		);
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
