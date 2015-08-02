<?php
/**
 * SNS首页
 ***/


defined('InShopNC') or exit('Access Invalid!');

class member_snsindexControl extends BaseMemberControl {
	const MAX_RECORDNUM = 20;//允许插入新记录的最大条数(注意在sns中该常量是一样的，注意与member_snshome中的该常量一致)
	public function __construct(){
		parent::__construct();
		Tpl::output('relation','3');//为了跟home页面保持一致所以输出此变量
		Language::read('member_sns');
		//允许插入新记录的最大条数
		Tpl::output('max_recordnum',self::MAX_RECORDNUM);
	}

	/**
	 * SNS首页
	 */
	public function indexOp(){
		//查询谁来看过我
		$visitor_model = Model('sns_visitor');
		$visitme_list = $visitor_model->getVisitorList(array('v_ownermid'=>"{$_SESSION['member_id']}",'limit'=>9));
		if (!empty($visitme_list)){
			foreach ($visitme_list as $k=>$v){
				$v['adddate_text'] = $this->formatDate($v['v_addtime']);
				$v['addtime_text'] = @date('H:i',$v['v_addtime']);
				$visitme_list[$k] = $v;
			}
		}
		//查询我访问过的人
		$visitother_list = $visitor_model->getVisitorList(array('v_mid'=>"{$_SESSION['member_id']}",'limit'=>9));
		if (!empty($visitother_list)){
			foreach ($visitother_list as $k=>$v){
				$v['adddate_text'] = $this->formatDate($v['v_addtime']);
				$visitother_list[$k] = $v;
			}
		}
		Tpl::output('visitme_list',$visitme_list);
		Tpl::output('visitother_list',$visitother_list);
		//信息输出
		Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
		Tpl::showpage('member_snsindex');
	}
	private function formatDate($time){
		$handle_date = @date('Y-m-d',$time);//需要格式化的时间
		$reference_date = @date('Y-m-d',time());//参照时间
		$handle_date_time = strtotime($handle_date);//需要格式化的时间戳
		$reference_date_time = strtotime($reference_date);//参照时间戳
		if ($reference_date_time == $handle_date_time){
			$timetext = @date('H:i',$time);//今天访问的显示具体的时间点
		}elseif (($reference_date_time-$handle_date_time)==60*60*24){
			$timetext = Language::get('sns_yesterday');
		}elseif ($reference_date_time-$handle_date_time==60*60*48){
			$timetext = Language::get('sns_beforeyesterday');
		}else {
			$month_text = Language::get('nc_month');
			$day_text = Language::get('nc_day');
			$timetext = @date("m{$month_text}d{$day_text}",$time);
		}
		return $timetext;
	}
	/**
	 * 添加SNS分享心情
	 */
	public function addtraceOp(){
		$obj_validate = new Validate();
		$validate_arr[] = array("input"=>$_POST["content"], "require"=>"true","message"=>Language::get('sns_sharemood_content_null'));
		$validate_arr[] = array("input"=>$_POST["content"], "validator"=>'Length',"min"=>0,"max"=>140,"message"=>Language::get('sns_content_beyond'));
		//发帖数超过最大次数出现验证码
		if(intval(cookie('weibonum'))>=self::MAX_RECORDNUM){
			$validate_arr[] = array("input"=>$_POST["captcha"], "require"=>"true","message"=>Language::get('wrong_null'));
		}
		$obj_validate -> validateparam = $validate_arr;
		$error = $obj_validate->validate();
		if ($error != ''){
			showDialog($error,'','error');
		}
		//发帖数超过最大次数出现验证码
		if(intval(cookie('weibonum'))>=self::MAX_RECORDNUM){
			if (!checkSeccode($_POST['nchash'],$_POST['captcha'])){
				showDialog(Language::get('wrong_checkcode'),'','error');
			}
		}
		//查询会员信息
		$member_model = Model('member');
		$member_info = $member_model->getMemberInfo(array('member_id'=>$_SESSION['member_id'],'member_state'=>1));
		if (empty($member_info)){
			showDialog(Language::get('sns_member_error'),'','error');
		}
		$tracelog_model = Model('sns_tracelog');
		$insert_arr = array();
		$insert_arr['trace_originalid'] = '0';
		$insert_arr['trace_originalmemberid'] = '0';
		$insert_arr['trace_memberid'] = $_SESSION['member_id'];
		$insert_arr['trace_membername'] = $_SESSION['member_name'];
		$insert_arr['trace_memberavatar'] = $member_info['member_avatar'];
		$insert_arr['trace_title'] = $_POST['content'];
		$insert_arr['trace_content'] = '';
		$insert_arr['trace_addtime'] = time();
		$insert_arr['trace_state'] = '0';
		$insert_arr['trace_privacy'] = intval($_POST["privacy"])>0?intval($_POST["privacy"]):0;
		$insert_arr['trace_commentcount'] = 0;
		$insert_arr['trace_copycount'] = 0;
		$result = $tracelog_model->tracelogAdd($insert_arr);
		if ($result){
			//建立cookie
			if (cookie('weibonum') != null && intval(cookie('weibonum')) >0){
				setNcCookie('weibonum',intval(cookie('weibonum'))+1,2*3600);//保存2小时
			}else{
				setNcCookie('weibonum',1,2*3600);//保存2小时
			}
			$js = "var obj = $(\"#weiboform\").find(\"[nc_type='formprivacytab']\");$(obj).find('span').removeClass('selected');$(obj).find('ul li:nth-child(1)').find('span').addClass('selected');";
			$js .= "$(\"#content_weibo\").val('');$(\"#privacy\").val('0');$('#friendtrace').lazyshow({url:\"index.php?act=member_snshome&op=tracelist&curpage=1\",'iIntervalId':true});";
			showDialog(Language::get('sns_share_succ'),'','succ',$js);
		}else {
			showDialog(Language::get('sns_share_fail'),'','error');
		}
	}
	/**
	 * 添加分享已买到的宝贝
	 */
	public function sharegoodsOp(){
		Language::read('member_sharemanage');
		if ($_POST['form_submit'] == 'ok'){
			$obj_validate = new Validate();
			$validate_arr[] = array("input"=>$_POST["choosegoodsid"], "require"=>"true","message"=>Language::get('sns_sharegoods_choose'));
			$validate_arr[] = array("input"=>$_POST["comment"], "validator"=>'Length',"min"=>0,"max"=>140,"message"=>Language::get('sns_content_beyond'));
			//发帖数超过最大次数出现验证码
			if(intval(cookie('weibonum'))>=self::MAX_RECORDNUM){
				$validate_arr[] = array("input"=>$_POST["captcha"], "require"=>"true","message"=>Language::get('wrong_null'));
			}
			$obj_validate -> validateparam = $validate_arr;
			$error = $obj_validate->validate();
			if (intval($_POST["choosegoodsid"]) <= 0){
				$error .= Language::get('sns_sharegoods_goodserror');
			}
			if ($error != ''){
				showDialog($error,'','error');
			}
			//发帖数超过最大次数出现验证码
			if(intval(cookie('weibonum'))>=self::MAX_RECORDNUM){
				if (!checkSeccode($_POST['nchash'],$_POST['captcha'])){
					showDialog(Language::get('wrong_checkcode'),'','error');
				}
			}
			//查询会员信息
			$member_model = Model('member');
			$member_info = $member_model->getMemberInfo(array('member_id'=>$_SESSION['member_id'],'member_state'=>1));
			if (empty($member_info)){
				showDialog(Language::get('sns_member_error'),'','error');
			}
			//查询商品信息
			$goods_model = Model('goods');
			$goods_info = $goods_model->getGoodsOnlineInfoForShare(intval($_POST['choosegoodsid']));
			if (empty($goods_info)){
				showDialog(Language::get('sns_sharegoods_goodserror'),'','error');
			}
			$sharegoods_model = Model('sns_sharegoods');
			//判断该商品是否已经存在分享或者喜欢记录
			$sharegoods_info = $sharegoods_model->getSharegoodsInfo(array('share_memberid'=>"{$_SESSION['member_id']}",'share_goodsid'=>"{$goods_info['goods_id']}"));
			$result = false;
			if (empty($sharegoods_info)){
				//添加分享商品信息
				$insert_arr = array();
				$insert_arr['share_goodsid'] = $goods_info['goods_id'];
				$insert_arr['share_memberid'] = $_SESSION['member_id'];
				$insert_arr['share_membername'] = $_SESSION['member_name'];
				$insert_arr['share_content'] = $_POST['comment']?$_POST['comment']:Language::get('sns_sharegoods_title');
				$insert_arr['share_addtime'] = time();
				$insert_arr['share_privacy'] = intval($_POST["gprivacy"])>0?intval($_POST["gprivacy"]):0;
				$insert_arr['share_commentcount'] = 0;
				$insert_arr['share_isshare'] = 1;
				$result = $sharegoods_model->sharegoodsAdd($insert_arr);
				unset($insert_arr);
			}else {
				//更新分享商品信息
				$update_arr = array();
				$update_arr['share_content'] = $_POST['comment']?$_POST['comment']:Language::get('sns_sharegoods_title');
				$update_arr['share_addtime'] = time();
				$update_arr['share_privacy'] = intval($_POST["gprivacy"])>0?intval($_POST["gprivacy"]):0;
				$update_arr['share_isshare'] = 1;
				$result = $sharegoods_model->editSharegoods($update_arr,array('share_id'=>"{$sharegoods_info['share_id']}"));
				unset($update_arr);
			}
			if ($result){
				//商品缓存数据更新
				//生成缓存的键值
				$hash_key = $goods_info['goods_id'];
				//先查找$hash_key缓存
				if ($_cache = rcache($hash_key,'product')){
					$_cache['sharenum'] = intval($_cache['sharenum'])+1;
					//缓存商品信息
					wcache($hash_key,$_cache,'product');
				}
				//更新SNS商品表信息
				$snsgoods_model = Model('sns_goods');
				$snsgoods_info = $snsgoods_model->getGoodsInfo(array('snsgoods_goodsid'=>"{$goods_info['goods_id']}"));
				if (empty($snsgoods_info)){
					//添加SNS商品
					$insert_arr = array();
					$insert_arr['snsgoods_goodsid'] = $goods_info['goods_id'];
					$insert_arr['snsgoods_goodsname'] = $goods_info['goods_name'];
					$insert_arr['snsgoods_goodsimage'] = $goods_info['goods_image'];
					$insert_arr['snsgoods_goodsprice'] = $goods_info['goods_price'];
					$insert_arr['snsgoods_storeid'] = $goods_info['store_id'];
					$insert_arr['snsgoods_storename'] = $goods_info['store_name'];
					$insert_arr['snsgoods_addtime'] = time();
					$insert_arr['snsgoods_likenum'] = 0;
					$insert_arr['snsgoods_sharenum'] = 1;
					$snsgoods_model->goodsAdd($insert_arr);
					unset($insert_arr);
				}else {
					//更新SNS商品
					$update_arr = array();
					$update_arr['snsgoods_sharenum'] = intval($snsgoods_info['snsgoods_sharenum'])+1;
					$snsgoods_model->editGoods($update_arr,array('snsgoods_goodsid'=>"{$goods_info['goods_id']}"));
				}
				//添加分享动态
				$tracelog_model = Model('sns_tracelog');
				$insert_arr = array();
				$insert_arr['trace_originalid'] = '0';
				$insert_arr['trace_originalmemberid'] = '0';
				$insert_arr['trace_memberid'] = $_SESSION['member_id'];
				$insert_arr['trace_membername'] = $_SESSION['member_name'];
				$insert_arr['trace_memberavatar'] = $member_info['member_avatar'];
				$insert_arr['trace_title'] = $_POST['comment']?$_POST['comment']:Language::get('sns_sharegoods_title');
				$content_str = '';
				$content_str .= "<div class=\"fd-media\">
					<div class=\"goodsimg\"><a target=\"_blank\" href=\"".urlShop('goods', 'index', array('goods_id'=>$goods_info['goods_id']))."\"><img src=\"".thumb($goods_info, 240)."\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$goods_info['goods_name']}\"></a></div>
					<div class=\"goodsinfo\">
						<dl>
							<dt><a target=\"_blank\" href=\"".urlShop('goods', 'index', array('goods_id'=>$goods_info['goods_id']))."\">".$goods_info['goods_name']."</a></dt>
							<dd>".Language::get('sns_sharegoods_price').Language::get('nc_colon').Language::get('currency').$goods_info['goods_price']."</dd>
							<dd>".Language::get('sns_sharegoods_freight').Language::get('nc_colon').Language::get('currency').$goods_info['goods_freight']."</dd>
	                  		<dd nctype=\"collectbtn_{$goods_info['goods_id']}\"><a href=\"javascript:void(0);\" onclick=\"javascript:collect_goods(\'{$goods_info['goods_id']}\',\'succ\',\'collectbtn_{$goods_info['goods_id']}\');\">".Language::get('sns_sharegoods_collect')."</a></dd>
	                  	</dl>
	                  </div>
	             </div>";
				$insert_arr['trace_content'] = $content_str;
				$insert_arr['trace_addtime'] = time();
				$insert_arr['trace_state'] = '0';
				$insert_arr['trace_privacy'] = intval($_POST["gprivacy"])>0?intval($_POST["gprivacy"]):0;
				$insert_arr['trace_commentcount'] = 0;
				$insert_arr['trace_copycount'] = 0;
				$result = $tracelog_model->tracelogAdd($insert_arr);
				//建立cookie
				if (cookie('weibonum') != null && intval(cookie('weibonum')) >0){
					setNcCookie('weibonum',intval(cookie('weibonum'))+1,2*3600);//保存2小时
				}else{
					setNcCookie('weibonum',1,2*3600);//保存2小时
				}
				//站外分享功能
				if (C('share_isuse') == 1){
					$model = Model('sns_binding');
					//查询该用户的绑定信息
					$bind_list = $model->getUsableApp($_SESSION['member_id']);
					//分享内容数组
					$params = array();
					$params['title'] = Language::get('sns_sharegoods_title');
					$params['url'] = urlShop('goods' , 'index', array('goods_id'=>$goods_info['goods_id']));
					$params['comment'] = $goods_info['goods_name'].$_POST['comment'];
					$params['images'] = thumb($goods_info, 240);
					//分享之qqweibo
					if (isset($_POST['checkapp_qqweibo']) && !empty($_POST['checkapp_qqweibo']) && $bind_list['qqweibo']['isbind'] == true){
						$model->addQQWeiboPic($bind_list['qqweibo'],$params);
					}
					//分享之sinaweibo
					if (isset($_POST['checkapp_sinaweibo']) && !empty($_POST['checkapp_sinaweibo']) && $bind_list['sinaweibo']['isbind'] == true){
						$model->addSinaWeiboUpload($bind_list['sinaweibo'],$params);
					}
				}
				//输出js
				$js = "DialogManager.close('sharegoods');var countobj=$('[nc_type=\'sharecount_{$goods_info['goods_id']}\']');$(countobj).html(parseInt($(countobj).text())+1);";
				$url = '';
				if ($_GET['irefresh']){
					$js .= "$('#friendtrace').lazyshow({url:\"index.php?act=member_snsindex&op=tracelist&curpage=1\",'iIntervalId':true});";
				}else{
					$url = 'reload';
				}
				showDialog(Language::get('sns_share_succ'),$url,'succ',$js);
			}else {
				showDialog(Language::get('sns_share_fail'),$url,'error');
			}
		} else {
			//查询已购买商品信息
			$order_model = Model('order');
			$condition = array();
			$condition['buyer_id'] = $_SESSION['member_id'];
			$ordergoods_list = $order_model->getOrderGoodsList($condition);
			unset($condition);
			$order_goodsid = array();
			if (!empty($ordergoods_list)){
				foreach ($ordergoods_list as $v){
					$order_goodsid[] = $v['goods_id'];
				}
			}

			// 查询收藏商品
			$favorites_list = Model()->table('favorites')->field('fav_id')->where(array('member_id'=>$_SESSION['member_id'], 'fav_type'=>'goods'))->select();
			$favorites_goodsid = array();
			if(!empty($favorites_list)){
				foreach ($favorites_list as $v){
					$favorites_goodsid[] = $v['fav_id'];
				}
			}

			$goods_id = array_merge($order_goodsid, $favorites_goodsid);
			//查询商品信息
			$goods_model = Model('goods');
			$condition = array();
			$condition['goods_id'] = array('in', $goods_id);
			$goods_list = $goods_model->getGoodsOnlineList($condition,'goods_id,goods_name,goods_image,store_id');
			if(!empty($goods_list)){
				foreach ($goods_list as $k=>$v){
					if(in_array($v['goods_id'], $order_goodsid)){
						$goods_list[$k]['order'] = true;
					}
					if(in_array($v['goods_id'], $favorites_goodsid)){
						$goods_list[$k]['favorites'] = true;
					}
				}
			}
			if (C('share_isuse') == 1){
			    $model = Model('sns_binding');
			    $app_arr = $model->getUsableApp($_SESSION['member_id']);
			    Tpl::output('app_arr',$app_arr);
			}
			//验证码
			Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
			Tpl::output('goods_list',$goods_list);
			Tpl::showpage('member_snssharegoods','null_layout');
		}
	}
	/**
	 * 分享店铺
	 */
	public function sharestoreOp(){
		Language::read('member_sharemanage');
		if ($_POST['form_submit'] == 'ok'){
			$obj_validate = new Validate();
			$validate_arr[] = array("input"=>$_POST["choosestoreid"], "require"=>"true","message"=>Language::get('sns_sharestore_choose'));
			$validate_arr[] = array("input"=>$_POST["comment"], "validator"=>'Length',"min"=>0,"max"=>140,"message"=>Language::get('sns_content_beyond'));
			//发帖数超过最大次数出现验证码
			if(intval(cookie('weibonum'))>=self::MAX_RECORDNUM){
				$validate_arr[] = array("input"=>$_POST["captcha"], "require"=>"true","message"=>Language::get('wrong_null'));
			}
			$obj_validate -> validateparam = $validate_arr;
			$error = $obj_validate->validate();
			if ($error != ''){
				showDialog($error,'','error');
			}
			//发帖数超过最大次数出现验证码
			if(intval(cookie('weibonum'))>=self::MAX_RECORDNUM){
				if (!checkSeccode($_POST['nchash'],$_POST['captcha'])){
					showDialog(Language::get('wrong_checkcode'),'','error');
				}
			}
			//查询会员信息
			$member_model = Model('member');
			$member_info = $member_model->getMemberInfo(array('member_id'=>$_SESSION['member_id'],'member_state'=>1));
			if (empty($member_info)){
				showDialog(Language::get('sns_member_error'),'','error');
			}
			//查询店铺信息
			$store_model = Model('store');
			$store_info = $store_model->getStoreInfoByID($_POST['choosestoreid']);
			if (empty($store_info)){
				showDialog(Language::get('sns_store_error'),'','error');
			}
			$sharestore_model = Model('sns_sharestore');
			//判断该商品是否已经分享过
			$sharestore_info = $sharestore_model->getSharestoreInfo(array('share_memberid'=>"{$_SESSION['member_id']}",'share_storeid'=>"{$store_info['store_id']}"));
			$result = false;
			if (empty($sharestore_info)){
				//添加分享商品信息
				$insert_arr = array();
				$insert_arr['share_storeid'] = $store_info['store_id'];
				$insert_arr['share_storename'] = $store_info['store_name'];
				$insert_arr['share_memberid'] = $_SESSION['member_id'];
				$insert_arr['share_membername'] = $_SESSION['member_name'];
				$insert_arr['share_content'] = $_POST['comment'];
				$insert_arr['share_addtime'] = time();
				$insert_arr['share_privacy'] = intval($_POST["sprivacy"])>0?intval($_POST["sprivacy"]):0;
				$result = $sharestore_model->sharestoreAdd($insert_arr);
				unset($insert_arr);
			}else {
				//更新分享商品信息
				$update_arr = array();
				$update_arr['share_content'] = $_POST['comment'];
				$update_arr['share_addtime'] = time();
				$update_arr['share_privacy'] = intval($_POST["sprivacy"])>0?intval($_POST["sprivacy"]):0;
				$result = $sharestore_model->editSharestore($update_arr,array('share_id'=>"{$sharestore_info['share_id']}"));
				unset($update_arr);
			}
			if ($result){
				//添加分享动态
				$tracelog_model = Model('sns_tracelog');
				$insert_arr = array();
				$insert_arr['trace_originalid'] = '0';
				$insert_arr['trace_originalmemberid'] = '0';
				$insert_arr['trace_memberid'] = $_SESSION['member_id'];
				$insert_arr['trace_membername'] = $_SESSION['member_name'];
				$insert_arr['trace_memberavatar'] = $member_info['member_avatar'];
				$insert_arr['trace_title'] = $_POST['comment']?$_POST['comment']:Language::get('sns_sharestore_title');
				$content_str = '';
				$store_info['store_avatar'] = empty($store_info['store_avatar']) ? UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.C('default_store_avatar') : UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.$store_info['store_avatar'];
				$store_info['store_url'] = urlShop('show_store', 'index', array('store_id'=>$store_info['store_id']));
				$content_str .= "<div class=\"fd-media\">
					<div class=\"goodsimg\"><a target=\"_blank\" href=\"{$store_info['store_url']}\"><img src=\"{$store_info['store_avatar']}\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$store_info['store_name']}\"></a></div>
					<div class=\"goodsinfo\">
						<dl>
							<dt><a target=\"_blank\" href=\"{$store_info['store_url']}\">".$store_info['store_name']."</a></dt>
	                  		<dd nctype=\"storecollectbtn_{$store_info['store_id']}\"><a href=\"javascript:void(0);\" onclick=\"javascript:collect_store(\'{$store_info['store_id']}\',\'succ\',\'storecollectbtn_{$store_info['store_id']}\');\">".Language::get('sns_sharestore_collect')."</a></dd>
	                  	</dl>
	                  </div>
	             </div>";
				$insert_arr['trace_content'] = $content_str;
				$insert_arr['trace_addtime'] = time();
				$insert_arr['trace_state'] = '0';
				$insert_arr['trace_privacy'] = intval($_POST["sprivacy"])>0?intval($_POST["sprivacy"]):0;
				$insert_arr['trace_commentcount'] = 0;
				$insert_arr['trace_copycount'] = 0;
				$result = $tracelog_model->tracelogAdd($insert_arr);
				//建立cookie
				if (cookie('weibonum') != null && intval(cookie('weibonum')) >0){
					setNcCookie('weibonum',intval(cookie('weibonum'))+1,2*3600);//保存2小时
				}else{
					setNcCookie('weibonum',1,2*3600);//保存2小时
				}
				//站外分享功能
				if (C('share_isuse') == 1){
				    $model = Model('sns_binding');
				    //查询该用户的绑定信息
				    $bind_list = $model->getUsableApp($_SESSION['member_id']);
				    //分享内容数组
				    $params = array();
				    $params['title'] = Language::get('sns_sharestore_title');
				    $params['url'] = urlShop('show_store' , 'index', array('store_id'=>$store_info['store_id']));
				    $params['comment'] = $store_info['store_name'].$_POST['comment'];
				    $params['images'] = empty($store_info['store_avatar']) ? UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.C('default_store_avatar') : UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.$store_info['store_avatar'];
				    //分享之qqweibo
				    if (isset($_POST['checkapp_qqweibo']) && !empty($_POST['checkapp_qqweibo']) && $bind_list['qqweibo']['isbind'] == true){
				        $model->addQQWeiboPic($bind_list['qqweibo'],$params);
				    }
				    //分享之sinaweibo
				    if (isset($_POST['checkapp_sinaweibo']) && !empty($_POST['checkapp_sinaweibo']) && $bind_list['sinaweibo']['isbind'] == true){
				        $model->addSinaWeiboUpload($bind_list['sinaweibo'],$params);
				    }
				}
				//输出js
				$js = "DialogManager.close('sharestore');";
				$url = '';
				if ($_GET['irefresh']){
					$js.="$('#friendtrace').lazyshow({url:\"index.php?act=member_snsindex&op=tracelist&curpage=1\",'iIntervalId':true});";
				}else{
					$url = 'reload';
				}
				showDialog(Language::get('sns_share_succ'),$url,'succ',$js);
			}else {
				showDialog(Language::get('sns_share_fail'),$url,'error');
			}
		} else {
			//查询收藏店铺信息
			$favorites_model = Model('favorites');
			$condition = array();
			$condition['member_id'] = $_SESSION['member_id'];
			$favorites_list = $favorites_model->getStoreFavoritesList($condition);
			unset($condition);
			$store_list = array();
			if (!empty($favorites_list)){
				$store_id = array();
				foreach ($favorites_list as $v){
					$store_id[] = $v['fav_id'];
				}
				//查询商品信息
				$store_model = Model('store');
				$condition = array();
				$condition['store_id'] = array('in', $store_id);
				$store_list = $store_model->getStoreOnlineList($condition);
			}

			if (C('share_isuse') == 1){
			    $model = Model('sns_binding');
			    $app_arr = $model->getUsableApp($_SESSION['member_id']);
			    Tpl::output('app_arr',$app_arr);
			}
			//验证码
			Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
			Tpl::output('store_list',$store_list);
			Tpl::showpage('member_snssharestore','null_layout');
		}
	}
	/**
	 * 删除动态
	 */
	public function deltraceOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		$tracelog_model = Model('sns_tracelog');
		//删除动态
		$condition = array();
		$condition['trace_id'] = "$id";
		$condition['trace_memberid'] = "{$_SESSION['member_id']}";
		$result = $tracelog_model->delTracelog($condition);
		if ($result){
			//修改该动态的转帖信息
			$tracelog_model->tracelogEdit(array('trace_originalstate'=>'1'),array('trace_originalid'=>"$id"));
			//删除对应的评论
			$comment_model = Model('sns_comment');
			$condition = array();
			$condition['comment_originalid'] = "$id";
			$condition['comment_originaltype'] = "0";
			$comment_model->delComment($condition);
			if ($_GET['type'] == 'href'){
				showDialog(Language::get('nc_common_del_succ'),'index.php?act=member_snshome&op=trace&mid='.$_SESSION['member_id'],'succ');
			}else {
				$js = "location.reload();";
				showDialog(Language::get('nc_common_del_succ'),'','succ',$js);
			}
		} else {
			showDialog(Language::get('nc_common_del_fail'),'','error');
		}
	}
	/**
	 * SNS动态列表
	 */
	public function tracelistOp(){
		//查询关注以及好友列表
		$friend_model = Model('sns_friend');
		$friend_list = $friend_model->listFriend(array('friend_frommid'=>"{$_SESSION['member_id']}"),'*','','simple');
		$mutualfollowid_arr = array();
		$followid_arr = array();
		if (!empty($friend_list)){
			foreach ($friend_list as $k=>$v){
				$followid_arr[] = $v['friend_tomid'];
				if ($v['friend_followstate'] == 2){
					$mutualfollowid_arr[] = $v['friend_tomid'];
				}
			}
		}
		$tracelog_model = Model('sns_tracelog');
		//条件
		$condition = array();
		$condition['allowshow'] = '1';
		$condition['allowshow_memberid'] = "{$_SESSION['member_id']}";
		$condition['allowshow_followerin'] = "";
		if (!empty($followid_arr)){
			$condition['allowshow_followerin'] = implode("','",$followid_arr);
		}
		$condition['allowshow_friendin'] = "";
		if (!empty($mutualfollowid_arr)){
			$condition['allowshow_friendin'] = implode("','",$mutualfollowid_arr);
		}
		$condition['trace_state'] = "0";
		$count = $tracelog_model->countTrace($condition);
		//分页
		$page	= new Page();
		$page->setEachNum(30);
		$page->setStyle('admin');
		$page->setTotalNum($count);
		$delaypage = intval($_GET['delaypage'])>0?intval($_GET['delaypage']):1;//本页延时加载的当前页数
		$lazy_arr = lazypage(10,$delaypage,$count,true,$page->getNowPage(),$page->getEachNum(),$page->getLimitStart());
		//动态列表
		$condition['limit'] = $lazy_arr['limitstart'].",".$lazy_arr['delay_eachnum'];
		$tracelist = $tracelog_model->getTracelogList($condition);
		if (!empty($tracelist)){
			foreach ($tracelist as $k=>$v){
				if ($v['trace_title']){
					$v['trace_title'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $v['trace_title']);
					$v['trace_title_forward'] = '|| @'.$v['trace_membername'].Language::get('nc_colon').preg_replace("/<a(.*?)href=\"(.*?)\"(.*?)>@(.*?)<\/a>([\s|:|：]|$)/is",'@${4}${5}',$v['trace_title']);
				}
				if(!empty($v['trace_content'])){
					//替换内容中的siteurl
					$v['trace_content'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $v['trace_content']);
				}
				$tracelist[$k] = $v;
			}
		}
		Tpl::output('hasmore',$lazy_arr['hasmore']);
		Tpl::output('tracelist',$tracelist);
		Tpl::output('show_page',$page->show());
		Tpl::output('type','index');
		Tpl::showpage('member_snstracelist','null_layout');
	}
	/**
	 * 编辑分享商品的可见权限(主人登录后操作)
	 */
	public function editprivacyOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		$sharegoods_model = Model("sns_sharegoods");
		$condition = array();
		$condition['share_id'] = "$id";
		$condition['share_memberid'] = "{$_SESSION['member_id']}";
		$privacy = in_array($_GET['privacy'],array(0,1,2))?$_GET['privacy']:0;
		$result = $sharegoods_model->editSharegoods(array('share_privacy'=>"$privacy"),$condition);
		if ($result){
			$privacy_item = $privacy+1;
			$js = "var obj = $(\"#recordone_{$id}\").find(\"[nc_type='privacytab']\"); $(obj).find('span').removeClass('selected');$(obj).find('li:nth-child(".$privacy_item.")').find('span').addClass('selected');";
			showDialog(Language::get('sns_setting_succ'),'','succ',$js);
		}else {
			showDialog(Language::get('sns_setting_fail'),'','error');
		}
	}
	/**
	 * 删除分享和喜欢商品
	 */
	public function delgoodsOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		$sharegoods_model = Model("sns_sharegoods");
		//查询分享和喜欢商品信息
		$condition = array();
		$condition['share_id'] = "$id";
		$condition['share_memberid'] = "{$_SESSION['member_id']}";
		if ($_GET['type'] == 'like'){//删除喜欢
			$condition['share_islike'] = "1";
		}elseif ($_GET['type'] == 'share'){
			$condition['share_isshare'] = "1";
		}
		$sharegoods_info = $sharegoods_model->getSharegoodsInfo($condition);
		if (empty($sharegoods_info)){
			showDialog(Language::get('nc_common_del_fail'),'','error');
		}
		unset($condition);
		$update_arr = array();
		if ($_GET['type'] == 'like'){//删除喜欢
			$update_arr['share_islike'] = "0";
		}elseif ($_GET['type'] == 'share'){
			$update_arr['share_isshare'] = "0";
		}
		$result = $sharegoods_model->editSharegoods($update_arr,array('share_id'=>"{$sharegoods_info['share_id']}"));
		if ($result){
			//更新SNS商品喜欢次数
			if ($_GET['type'] == 'like'){
				$snsgoods_model = Model('sns_goods');
				$snsgoods_info = $snsgoods_model->getGoodsInfo(array('snsgoods_goodsid'=>"{$sharegoods_info['share_goodsid']}"));
				if (!empty($snsgoods_info)){
					$update_arr = array();
					$update_arr['snsgoods_likenum'] = (intval($snsgoods_info['snsgoods_likenum'])-1)>0?(intval($snsgoods_info['snsgoods_likenum'])-1):0;
					$likemember_arr = array();
					if (!empty($snsgoods_info['snsgoods_likemember'])){
						$likemember_arr = explode(',',$snsgoods_info['snsgoods_likemember']);
						unset($likemember_arr[array_search($_SESSION['member_id'],$likemember_arr)]);
					}
					$update_arr['snsgoods_likemember'] = implode(',',$likemember_arr);
					$snsgoods_model->editGoods($update_arr,array('snsgoods_goodsid'=>"{$snsgoods_info['snsgoods_goodsid']}"));
				}
			}
			$js = "location.reload();";
			showDialog(Language::get('nc_common_del_succ'),'','succ',$js);
		}else {
			showDialog(Language::get('nc_common_del_fail'),'','error');
		}
	}
	/**
	 * 删除分享店铺
	 */
	public function delstoreOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		$sharestore_model = Model("sns_sharestore");
		//删除分享店铺信息
		$condition = array();
		$condition['share_id'] = "$id";
		$condition['share_memberid'] = "{$_SESSION['member_id']}";
		$result = $sharestore_model->delSharestore($condition);
		if ($result){
			$js = "location.reload();";
			showDialog(Language::get('nc_common_del_succ'),'','succ',$js);
		}else {
			showDialog(Language::get('nc_common_del_fail'),'','error');
		}
	}
	/**
	 * 编辑分享店铺的可见权限(主人登录后操作)
	 */
	public function storeprivacyOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		$sharestore_model = Model("sns_sharestore");
		$condition = array();
		$condition['share_id'] = "$id";
		$condition['share_memberid'] = "{$_SESSION['member_id']}";
		$privacy = in_array($_GET['privacy'],array(0,1,2))?$_GET['privacy']:0;
		$result = $sharestore_model->editSharestore(array('share_privacy'=>"$privacy"),$condition);
		if ($result){
			$privacy_item = $privacy+1;
			$js = "var obj = $(\"#recordone_{$id}\").find(\"[nc_type='privacytab']\"); $(obj).find('span').removeClass('selected');$(obj).find('li:nth-child(".$privacy_item.")').find('span').addClass('selected');";
			showDialog(Language::get('sns_setting_succ'),'','succ',$js);
		}else {
			showDialog(Language::get('sns_setting_fail'),'','error');
		}
	}
	/**
	 * 添加评论(访客登录后操作)
	 */
	public function addcommentOp(){
		$originalid = intval($_POST["originalid"]);
		if($originalid <= 0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		$obj_validate = new Validate();
		$originaltype = intval($_POST['originaltype'])>0?intval($_POST['originaltype']):0;
		$validate_arr[] = array("input"=>$_POST["commentcontent"], "require"=>"true","message"=>Language::get('sns_comment_null'));
		$validate_arr[] = array("input"=>$_POST["commentcontent"], "validator"=>'Length',"min"=>0,"max"=>140,"message"=>Language::get('sns_content_beyond'));
		//评论数超过最大次数出现验证码
		if(intval(cookie('commentnum'))>=self::MAX_RECORDNUM){
			$validate_arr[] = array("input"=>$_POST["captcha"], "require"=>"true","message"=>Language::get('wrong_null'));
		}
		$obj_validate -> validateparam = $validate_arr;
		$error = $obj_validate->validate();
		if ($error != ''){
			showDialog($error,'','error');
		}
		//发帖数超过最大次数出现验证码
		if(intval(cookie('commentnum'))>=self::MAX_RECORDNUM){
			if (!checkSeccode($_POST['nchash'],$_POST['captcha'])){
				showDialog(Language::get('wrong_checkcode'),'','error');
			}
		}
		//查询会员信息
		$member_model = Model('member');
		$member_info = $member_model->getMemberInfo(array('member_id'=>$_SESSION['member_id'],'member_state'=>1));
		if (empty($member_info)){
			showDialog(Language::get('sns_member_error'),'','error');
		}
		$owner_id = 0;
		if ($originaltype == 1){
			//查询分享和喜欢商品信息
			$sharegoods_model = Model('sns_sharegoods');
			$sharegoods_info = $sharegoods_model->getSharegoodsInfo(array('share_id'=>"{$originalid}"));
			if (empty($sharegoods_info)){
				showDialog(Language::get('sns_comment_fail'),'','error');
			}
			$owner_id = $sharegoods_info['share_memberid'];
		}else {
			//查询原帖信息
			$tracelog_model = Model('sns_tracelog');
			$tracelog_info = $tracelog_model->getTracelogRow(array('trace_id'=>"{$originalid}",'trace_state'=>'0'));
			if (empty($tracelog_info)){
				showDialog(Language::get('sns_comment_fail'),'','error');
			}
			$owner_id = $tracelog_info['trace_memberid'];
		}
		$comment_model = Model('sns_comment');
		$insert_arr = array();
		$insert_arr['comment_memberid'] = $_SESSION['member_id'];
		$insert_arr['comment_membername'] = $_SESSION['member_name'];
		$insert_arr['comment_memberavatar'] = $member_info['member_avatar'];
		$insert_arr['comment_originalid'] = $originalid;
		$insert_arr['comment_originaltype'] = $originaltype;
		$insert_arr['comment_content'] = $_POST['commentcontent'];
		$insert_arr['comment_addtime'] = time();
		$insert_arr['comment_ip'] = getIp();
		$insert_arr['comment_state'] = '0';//正常
		$result = $comment_model->commentAdd($insert_arr);
		if ($result){
			if ($originaltype == 1){
				//更新商品的评论数
				$update_arr = array();
				$update_arr['share_commentcount'] = array('sign'=>'increase','value'=>'1');
				$sharegoods_model->editSharegoods($update_arr,array('share_id'=>"{$originalid}"));
			}else {
				//更新动态统计信息
				$update_arr = array();
				$update_arr['trace_commentcount'] = array('sign'=>'increase','value'=>'1');
				if (intval($tracelog_info['trace_originalid'])== 0){
					$update_arr['trace_orgcommentcount'] = array('sign'=>'increase','value'=>'1');
				}
				$tracelog_model->tracelogEdit($update_arr,array('trace_id'=>"$originalid"));
				unset($update_arr);
				//更新所有转帖的原帖评论次数
				if (intval($tracelog_info['trace_originalid'])== 0){
					$tracelog_model->tracelogEdit(array('trace_orgcommentcount'=>$tracelog_info['trace_orgcommentcount']+1),array('trace_originalid'=>"$originalid"));
				}
			}
			//建立cookie
			if (cookie('commentnum') != null && intval(cookie('commentnum')) >0){
				setNcCookie('commentnum',intval(cookie('commentnum'))+1,2*3600);//保存2小时
			}else{
				setNcCookie('commentnum',1,2*3600);//保存2小时
			}
			$js = "$(\"#content_comment{$originalid}\").val('');";
			if ($_POST['showtype'] == 1){
				$js .="$(\"#tracereply_{$originalid}\").load('index.php?act=member_snshome&op=commenttop&mid={$owner_id}&id={$originalid}&type={$originaltype}');";
			}else {
				$js .="$(\"#tracereply_{$originalid}\").load('index.php?act=member_snshome&op=commentlist&mid={$owner_id}&id={$originalid}&type={$originaltype}');";
			}
			showDialog(Language::get('sns_comment_succ'),'','succ',$js);
		}
	}
	/**
	 * 删除评论(访客登录后操作)
	 */
	public function delcommentOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		$comment_model = Model('sns_comment');
		//查询评论信息
		$comment_info = $comment_model->getCommentRow(array('comment_id'=>"$id",'comment_memberid'=>"{$_SESSION['member_id']}"));
		if (empty($comment_info)){
			showDialog(Language::get('sns_comment_recorderror'),'','error');
		}
		//删除评论
		$condition = array();
		$condition['comment_id'] = "$id";
		$result = $comment_model->delComment($condition);
		if ($result){
			if ($comment_info['comment_originaltype'] == 1){
				//更新商品评论数
				$sharegoods_model = Model('sns_sharegoods');
				$update_arr = array();
				$update_arr['share_commentcount'] = array('sign'=>'decrease','value'=>'1');
				$sharegoods_model->editSharegoods($update_arr,array('share_id'=>"{$comment_info['comment_originalid']}"));
			}else {
				//更新动态统计信息
				$tracelog_model = Model('sns_tracelog');
				$update_arr = array();
				$update_arr['trace_commentcount'] = array('sign'=>'decrease','value'=>'1');
				$tracelog_model->tracelogEdit($update_arr,array('trace_id'=>"{$comment_info['comment_originalid']}"));
			}
			$js .="$('.comment-list [nc_type=\"commentrow_{$id}\"]').remove();";
			showDialog(Language::get('nc_common_del_succ'),'','succ',$js);
		}else {
			showDialog(Language::get('nc_common_del_fail'),'','error');
		}
	}
	/**
	 * 喜欢商品(访客登录后操作)
	 */
	public function editlikeOp(){
		$obj_validate = new Validate();
		$validate_arr[] = array("input"=>$_GET["id"], "require"=>"true","message"=>Language::get('sns_likegoods_choose'));
		$obj_validate -> validateparam = $validate_arr;
		$error = $obj_validate->validate();
		if ($error != ''){
			showDialog($error,'','error');
		}
		//查询会员信息
		$member_model = Model('member');
		$member_info = $member_model->getMemberInfo(array('member_id'=>$_SESSION['member_id'],'member_state'=>1));
		if (empty($member_info)){
			showDialog(Language::get('sns_member_error'),'','error');
		}
		//查询商品信息
		$goods_model = Model('goods');
		$goods_info = $goods_model->getGoodsOnlineInfoForShare(intval($_GET["id"]));
		if (empty($goods_info)){
			showDialog(Language::get('sns_goods_error'),'','error');
		}
		$sharegoods_model = Model('sns_sharegoods');
		//判断该商品是否已经存在分享记录
		$sharegoods_info = $sharegoods_model->getSharegoodsInfo(array('share_memberid'=>"{$_SESSION['member_id']}",'share_goodsid'=>"{$goods_info['goods_id']}"));
		if (!empty($sharegoods_info) && $sharegoods_info['share_islike'] == 1){
			showDialog(Language::get('sns_likegoods_exist'),'','error');
		}
		if (empty($sharegoods_info)){
			//添加分享商品信息
			$insert_arr = array();
			$insert_arr['share_goodsid'] = $goods_info['goods_id'];
			$insert_arr['share_memberid'] = $_SESSION['member_id'];
			$insert_arr['share_membername'] = $_SESSION['member_name'];
			$insert_arr['share_content'] = '';
			$insert_arr['share_likeaddtime'] = time();
			$insert_arr['share_privacy'] = 0;
			$insert_arr['share_commentcount'] = 0;
			$insert_arr['share_islike'] = 1;
			$result = $sharegoods_model->sharegoodsAdd($insert_arr);
			unset($insert_arr);
		}else {
			//更新分享商品信息
			$update_arr = array();
			$update_arr['share_likeaddtime'] = time();
			$update_arr['share_islike'] = 1;
			$result = $sharegoods_model->editSharegoods($update_arr,array('share_id'=>"{$sharegoods_info['share_id']}"));
			unset($update_arr);
		}
		if ($result){
			//商品缓存数据更新
			//生成缓存的键值
			$hash_key = $goods_info['goods_id'];
			//先查找$hash_key缓存
			if ($_cache = rcache($hash_key,'product')){
				$_cache['likenum'] = intval($_cache['likenum'])+1;
				//缓存商品信息
				wcache($hash_key,$_cache,'product');
			}
			//更新SNS商品表信息
			$snsgoods_model = Model('sns_goods');
			$snsgoods_info = $snsgoods_model->getGoodsInfo(array('snsgoods_goodsid'=>"{$goods_info['goods_id']}"));
			if (empty($snsgoods_info)){
				//添加SNS商品
				$insert_arr = array();
				$insert_arr['snsgoods_goodsid'] = $goods_info['goods_id'];
				$insert_arr['snsgoods_goodsname'] = $goods_info['goods_name'];
				$insert_arr['snsgoods_goodsimage'] = $goods_info['goods_image'];
				$insert_arr['snsgoods_goodsprice'] = $goods_info['goods_price'];
				$insert_arr['snsgoods_storeid'] = $goods_info['store_id'];
				$insert_arr['snsgoods_storename'] = $goods_info['store_name'];
				$insert_arr['snsgoods_addtime'] = time();
				$insert_arr['snsgoods_likenum'] = 1;
				$insert_arr['snsgoods_likemember'] = "{$_SESSION['member_id']}";
				$insert_arr['snsgoods_sharenum'] = 0;
				$snsgoods_model->goodsAdd($insert_arr);
				unset($insert_arr);
			}else {
				//更新SNS商品
				$update_arr = array();
				$update_arr['snsgoods_likenum'] = intval($snsgoods_info['snsgoods_likenum'])+1;
				$likemember_arr = array();
				if (!empty($snsgoods_info['snsgoods_likemember'])){
					$likemember_arr = explode(',',$snsgoods_info['snsgoods_likemember']);
				}
				$likemember_arr[] = $_SESSION['member_id'];
				$update_arr['snsgoods_likemember'] = implode(',',$likemember_arr);
				$snsgoods_model->editGoods($update_arr,array('snsgoods_goodsid'=>"{$goods_info['goods_id']}"));
			}
			//添加喜欢动态
			$tracelog_model = Model('sns_tracelog');
			$insert_arr = array();
			$insert_arr['trace_originalid'] = '0';
			$insert_arr['trace_originalmemberid'] = '0';
			$insert_arr['trace_memberid'] = $_SESSION['member_id'];
			$insert_arr['trace_membername'] = $_SESSION['member_name'];
			$insert_arr['trace_memberavatar'] = $member_info['member_avatar'];
			$insert_arr['trace_title'] = Language::get('sns_likegoods_title');
			$content_str = '';
			$content_str .= "<div class=\"fd-media\">
				<div class=\"goodsimg\"><a target=\"_blank\" href=\"".urlShop('goods', 'index', array('goods_id'=>$goods_info['goods_id']))."\"><img src=\"".thumb($goods_info, 240)."\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$goods_info['goods_name']}\"></a></div>
				<div class=\"goodsinfo\">
					<dl>
						<dt><a target=\"_blank\" href=\"".urlShop('goods', 'index', array('goods_id'=>$goods_info['goods_id']))."\">".$goods_info['goods_name']."</a></dt>
						<dd>".Language::get('sns_sharegoods_price').Language::get('nc_colon').Language::get('currency').$goods_info['goods_price']."</dd>
						<dd>".Language::get('sns_sharegoods_freight').Language::get('nc_colon').Language::get('currency').$goods_info['goods_freight']."</dd>
                  		<dd nctype=\"collectbtn_{$goods_info['goods_id']}\"><a href=\"javascript:void(0);\" onclick=\"javascript:collect_goods(\'{$goods_info['goods_id']}\',\'succ\',\'collectbtn_{$goods_info['goods_id']}\');\">".Language::get('sns_sharegoods_collect')."</a>&nbsp;&nbsp;(".$goods_info['goods_collect'].Language::get('sns_collecttip').")</dd>
                  	</dl>
                  </div>
             </div>";
			$insert_arr['trace_content'] = $content_str;
			$insert_arr['trace_addtime'] = time();
			$insert_arr['trace_state'] = '0';
			$insert_arr['trace_privacy'] = 0;
			$insert_arr['trace_commentcount'] = 0;
			$insert_arr['trace_copycount'] = 0;
			$result = $tracelog_model->tracelogAdd($insert_arr);
			$js = "var obj = $(\"#likestat_{$goods_info['goods_id']}\"); $(\"#likestat_{$goods_info['goods_id']}\").find('i').addClass('noaction');$(obj).find('a').addClass('noaction'); var countobj=$('[nc_type=\'likecount_{$goods_info['goods_id']}\']');$(countobj).html(parseInt($(countobj).text())+1);";
			showDialog(Language::get('nc_common_op_succ'),'','succ',$js);
		}else {
			showDialog(Language::get('nc_common_op_fail'),'','error');
		}
	}
	/**
	 * 添加转发
	 */
	public function addforwardOp(){
		$obj_validate = new Validate();
		$originalid = intval($_POST["originalid"]);
		$validate_arr[] = array("input"=>$originalid, "require"=>"true",'validator'=>'Compare',"operator"=>' > ','to'=>0,"message"=>Language::get('sns_forward_fail'));
		$validate_arr[] = array("input"=>$_POST["forwardcontent"], "validator"=>'Length',"min"=>0,"max"=>140,"message"=>Language::get('sns_content_beyond'));
		//发帖数超过最大次数出现验证码
		if(intval(cookie('forwardnum'))>=self::MAX_RECORDNUM){
			$validate_arr[] = array("input"=>$_POST["captcha"], "require"=>"true","message"=>Language::get('wrong_null'));
		}
		$obj_validate -> validateparam = $validate_arr;
		$error = $obj_validate->validate();
		if ($error != ''){
			showDialog($error,'','error');
		}
		//发帖数超过最大次数出现验证码
		if(intval(cookie('forwardnum'))>=self::MAX_RECORDNUM){
			if (!checkSeccode($_POST['nchash'],$_POST['captcha'])){
				showDialog(Language::get('wrong_checkcode'),'','error');
			}
		}
		//查询会员信息
		$member_model = Model('member');
		$member_info = $member_model->getMemberInfo(array('member_id'=>$_SESSION['member_id'],'member_state'=>1));
		if (empty($member_info)){
			showDialog(Language::get('sns_member_error'),'','error');
		}
		//查询原帖信息
		$tracelog_model = Model('sns_tracelog');
		$tracelog_info = $tracelog_model->getTracelogRow(array('trace_id'=>"{$originalid}",'trace_state'=>"0"));
		if (empty($tracelog_info)){
			showDialog(Language::get('sns_forward_fail'),'','error');
		}
		$insert_arr = array();
		$insert_arr['trace_originalid'] = $tracelog_info['trace_originalid']>0?$tracelog_info['trace_originalid']:$originalid;//如果被转发的帖子为原帖的话，那么为原帖ID；如果被转发的帖子为转帖的话，那么为该转帖的原帖ID（即最初始帖子ID）
		$insert_arr['trace_originalmemberid'] = $tracelog_info['trace_originalid']>0?$tracelog_info['trace_originalmemberid']:$tracelog_info['trace_memberid'];
		$insert_arr['trace_memberid'] = $_SESSION['member_id'];
		$insert_arr['trace_membername'] = $_SESSION['member_name'];
		$insert_arr['trace_memberavatar'] = $member_info['member_avatar'];
		$insert_arr['trace_title'] = $_POST['forwardcontent']?$_POST['forwardcontent']:Language::get('sns_forward');
		if ($tracelog_info['trace_originalid'] > 0 || $tracelog_info['trace_from'] != 1){
			$insert_arr['trace_content'] = addslashes($tracelog_info['trace_content']);
		}else {
			$content_str ="<div class=\"title\"><a href=\"%siteurl%index.php?act=member_snshome&mid={$tracelog_info['trace_memberid']}\" target=\"_blank\" class=\"uname\">{$tracelog_info['trace_membername']}</a>";
			$content_str .= Language::get('nc_colon')."{$tracelog_info['trace_title']}</div>";
			$content_str .=addslashes($tracelog_info['trace_content']);
			$insert_arr['trace_content'] = $content_str;
		}
		$insert_arr['trace_addtime'] = time();
		$insert_arr['trace_state'] = '0';
		if ($tracelog_info['trace_privacy'] >0){
			$insert_arr['trace_privacy'] = 2;//因为动态可见权限跟转帖功能，本身就是矛盾的，为了防止可见度无法控制，所以如果原帖不为所有人可见，那么转帖的动态权限就为仅自己可见，否则为所有人可见
		}else {
			$insert_arr['trace_privacy'] = 0;
		}
		$insert_arr['trace_commentcount'] = 0;
		$insert_arr['trace_copycount'] = 0;
		$insert_arr['trace_orgcommentcount'] = $tracelog_info['trace_orgcommentcount'];
		$insert_arr['trace_orgcopycount'] = $tracelog_info['trace_orgcopycount'];
		$result = $tracelog_model->tracelogAdd($insert_arr);
		if ($result){
			//更新动态转发次数
			$tracelog_model = Model('sns_tracelog');
			$update_arr = array();
			$update_arr['trace_copycount'] = array('sign'=>'increase','value'=>'1');
			$update_arr['trace_orgcopycount'] = array('sign'=>'increase','value'=>'1');
			$condition = array();
			//原始贴和被转帖都增加转帖次数
			if ($tracelog_info['trace_originalid'] > 0){
				$condition['traceid_in'] = "{$tracelog_info['trace_originalid']}','{$originalid}";
			}else {
				$condition['trace_id'] = "$originalid";
			}
			$tracelog_model->tracelogEdit($update_arr,$condition);
			unset($condition);
			//更新所有转帖的原帖转发次数
			$condition = array();
			//原始贴和被转帖都增加转帖次数
			if ($tracelog_info['trace_originalid'] > 0){
				$condition['trace_originalid'] = "{$tracelog_info['trace_originalid']}";
			}else {
				$condition['trace_originalid'] = "$originalid";
			}
			$tracelog_model->tracelogEdit(array('trace_orgcopycount'=>$tracelog_info['trace_orgcopycount']+1),$condition);
			if ($_GET['irefresh']){
				//建立cookie
				if (cookie('forwardnum') != null && intval(cookie('forwardnum')) >0){
					setNcCookie('forwardnum',intval(cookie('forwardnum'))+1,2*3600);//保存2小时
				}else{
					setNcCookie('forwardnum',1,2*3600);//保存2小时
				}
				if ($_GET['type']=='home'){
					$js = "$('#friendtrace').lazyshow({url:\"index.php?act=member_snshome&op=tracelist&mid={$tracelog_info['trace_memberid']}&curpage=1\",'iIntervalId':true});";
				}else if ($_GET['type']=='snshome'){
					$js = "$('#forward_".$originalid."').hide();$('#friendtrace').lazyshow({url:\"index.php?act=member_snshome&op=tracelist&mid={$tracelog_info['trace_memberid']}&curpage=1\",'iIntervalId':true});";
				}else {
					$js = "$('#friendtrace').lazyshow({url:\"index.php?act=member_snsindex&op=tracelist&curpage=1\",'iIntervalId':true});";
				}
				showDialog(Language::get('sns_forward_succ'),'','succ',$js);
			}else {
				showDialog(Language::get('sns_forward_succ'),'','succ');
			}
		}else {
			showDialog(Language::get('sns_forward_fail'),'','error');
		}
	}
	/**
	 * 商品收藏页面和商品详细页面分享商品
	 */
	public function sharegoods_oneOp(){
		Language::read('member_sharemanage');
		$gid = intval($_GET['gid']);
		if ($gid<=0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		if ($_GET['dialog']){
			$js = "CUR_DIALOG = ajax_form('sharegoods', '".Language::get('sns_sharegoods_tofriend')."', 'index.php?act=member_snsindex&op=sharegoods_one&gid={$gid}', 480);";
			showDialog('','','js',$js);
		}
		//查询商品信息
		$goods_info = Model('goods')->getGoodsOnlineInfoForShare($gid);
		
		//判断系统是否开启站外分享功能
		if (C('share_isuse') == 1){
			//站外分享接口
			$model = Model('sns_binding');
			$app_arr = $model->getUsableApp($_SESSION['member_id']);
			Tpl::output('app_arr',$app_arr);
		}
		//信息输出
		Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
		Tpl::output('goods_info',$goods_info);
		Tpl::showpage('member_snssharegoods_one','null_layout');
	}
	/**
	 * 店铺收藏页面分享店铺
	 */
	public function sharestore_oneOp(){
		Language::read('member_sharemanage');
		$sid = intval($_GET['sid']);
		if ($sid<=0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		if ($_GET['dialog']){
			$js = "ajax_form('sharestore', '".Language::get('sns_sharestore')."', 'index.php?act=member_snsindex&op=sharestore_one&sid={$sid}', 480);";
			showDialog('','','js',$js);
		}
		//查询店铺信息
		$store_model = Model('store');
        $store_info = $store_model->getStoreInfoByID($sid);
		if (empty($store_info) || $store_info['store_state'] == 0){
			showDialog(Language::get('sns_sharestore_storeerror'),'','error');
		}
		$store_info['store_url'] = urlShop('show_store', 'index', array('store_id'=>$store_info['store_id']));
		//判断系统是否开启站外分享功能
		if (C('share_isuse') == 1){
		    //站外分享接口
		    $model = Model('sns_binding');
		    $app_arr = $model->getUsableApp($_SESSION['member_id']);
		    Tpl::output('app_arr',$app_arr);
		}
		//信息输出
		Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
		Tpl::output('store_info',$store_info);
		Tpl::showpage('member_snssharestore_one','null_layout');
	}

}
