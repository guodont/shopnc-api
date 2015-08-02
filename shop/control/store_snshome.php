<?php
/**
 * 店铺动态
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class store_snshomeControl extends BaseStoreSnsControl{
	public function __construct() {
	    parent::__construct();
	    Language::read('store_sns,member_sns');
	}

	/**
	 * 查看店铺动态
	 */
	public function indexOp(){
		//获得店铺ID
		$sid	= intval($_GET['sid']);
		$this->getStoreInfo($sid);

		// where 条件
		$where = array();
		$where['strace_state'] = 1;
		$where['strace_storeid'] = $sid;
		if($_GET['type'] != ''){
			switch (trim($_GET['type'])){
				case 'promotion':
					$where['strace_type'] = array('in', array(4,5,6,7,8));
					break;
				case 'new':
					$where['strace_type'] = 3;
					break;
				case 'hotsell':
					$where['strace_type'] = 10;
					break;
				case 'recommend':
					$where['strace_type'] = 9;
					break;
			}
		}
		$model_stracelog = Model('store_sns_tracelog');
		$strace_array = $model_stracelog->getStoreSnsTracelogList($where, '*', 'strace_id desc', 0, 40);
		// 整理
		if(!empty($strace_array) && is_array($strace_array)){
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
		Tpl::output('strace_array', $strace_array);

		//验证码
		Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
		//允许插入新记录的最大条数
		Tpl::output('max_recordnum',self::MAX_RECORDNUM);
		Tpl::output('show_page',$model_stracelog->showpage(2));

		// 最多收藏的会员
		$favorites = Model('favorites')->getStoreFavoritesList(array('fav_id' => $sid), '*', 0, 'fav_time desc', 8);
		if (!empty($favorites)) {
		    $memberid_array = array();
		    foreach ($favorites as $val) {
		        $memberid_array[] = $val['member_id'];
		    }
		    $favorites_list = Model('member')->getMemberList(array('member_id' => array('in', $memberid_array)), 'member_id,member_name,member_avatar');
		    Tpl::output('favorites_list', $favorites_list);
		}
		Tpl::showpage('store_snshome');
	}

	/**
	 * 评论前10条记录
	 */
	public function commenttopOp(){
		$stid = intval($_GET['id']);
		if($stid > 0){
			$model_storesnscomment = Model('store_sns_comment');
			//查询评论总数

			$where = array(
						'strace_id'=>$stid,
						'scomm_state'=>1
					);
			$countnum = $model_storesnscomment->getStoreSnsCommentCount($where);

			//动态列表
			$commentlist = $model_storesnscomment->getStoreSnsCommentList($where, '*', 'scomm_id desc', 10);

			// 更新评论数量
			Model('store_sns_tracelog')->editStoreSnsTracelog(array('strace_comment'=>$countnum), array('strace_id'=>$stid));
		}
		$showmore = '0';//是否展示更多的连接
		if ($countnum > count($commentlist)){
			$showmore = '1';
		}
		Tpl::output('countnum',$countnum);
		Tpl::output('showmore',$showmore);
		Tpl::output('showtype',1);//页面展示类型 0表示分页 1表示显示前几条
		Tpl::output('stid',$stid);

		//验证码
		Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));

		//允许插入新记录的最大条数
		Tpl::output('max_recordnum',self::MAX_RECORDNUM);

		Tpl::output('commentlist',$commentlist);
		Tpl::showpage('store_snscommentlist','null_layout');
	}
	/**
	 * 评论列表
	 */
	public function commentlistOp(){
		$stid = intval($_GET['id']);
		if($stid > 0){
			$model_storesnscomment = Model('store_sns_comment');
			//查询评论总数
			$where = array(
						'strace_id'=>$stid,
						'scomm_state'=>1
					);
			$countnum = $model_storesnscomment->getStoreSnsCommentCount($where);

			//评价列表
			$commentlist = $model_storesnscomment->getStoreSnsCommentList($where, '*', 'scomm_id desc', 0, 10);

			// 更新评论数量
			$commentlist = Model('store_sns_tracelog')->editStoreSnsTracelog(array('strace_comment'=>$countnum), array('strace_id'=>$stid));
		}

		Tpl::output('commentlist',$commentlist);
		Tpl::output('show_page',$model_storesnscomment->showpage(2));
		Tpl::output('countnum',$countnum);
		Tpl::output('stid',$stid);
		Tpl::output('showtype','0');//页面展示类型 0表示分页 1表示显示前几条

		//验证码
		Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));

		//允许插入新记录的最大条数
		Tpl::output('max_recordnum',self::MAX_RECORDNUM);
		Tpl::showpage('store_snscommentlist','null_layout');
	}
	/**
	 * 添加评论(访客登录后操作)
	 */
	public function addcommentOp(){
		// 验证用户是否登录
		$this->checkLoginStatus();

		$stid = intval($_POST['stid']);
		if($stid <= 0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		$obj_validate = new Validate();
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
// 		//查询会员信息
		$model = Model();
		$member_info = $model->table('member')->where(array('member_state'=>1))->find($_SESSION['member_id']);
		if (empty($member_info)){
			showDialog(Language::get('sns_member_error'),'','error');
		}
		$insert_arr = array();
		$insert_arr['strace_id'] 			= $stid;
		$insert_arr['scomm_content']		= $_POST['commentcontent'];
		$insert_arr['scomm_memberid']		= $member_info['member_id'];
		$insert_arr['scomm_membername']		= $member_info['member_name'];
		$insert_arr['scomm_memberavatar']	= $member_info['member_avatar'];
		$insert_arr['scomm_time']			= time();
		$result = Model('store_sns_comment')->saveStoreSnsComment($insert_arr);
		if ($result){
			// 原帖增加评论次数
			$where = array('strace_id'=>$stid);
			$update = array('strace_comment'=>array('exp','strace_comment+1'));
			$rs = Model('store_sns_tracelog')->editStoreSnsTracelog($update, $where);
			//建立cookie
			if (cookie('commentnum') != null && intval(cookie('commentnum')) >0){
				setNcCookie('commentnum',intval(cookie('commentnum'))+1,2*3600);//保存2小时
			}else{
				setNcCookie('commentnum',1,2*3600);//保存2小时
			}
			$js = "$('#content_comment".$stid."').html('');";
			if ($_POST['showtype'] == 1){
				$js .="$('#tracereply_".$stid."').load('index.php?act=store_snshome&op=commenttop&id=".$stid."');";
			}else {
				$js .="$('#tracereply_".$stid."').load('index.php?act=store_snshome&op=commentlist&id=".$stid."');";
			}
			showDialog(Language::get('sns_comment_succ'),'','succ',$js);
		}
	}
	/**
	 * 添加转发
	 */
	public function addforwardOp(){
		// 验证用户是否登录
		$this->checkLoginStatus();

		$obj_validate = new Validate();
		$stid = intval($_POST["stid"]);
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
		$model = Model();
		$member_info = $model->table('member')->where(array('member_state'=>1))->find($_SESSION['member_id']);
		if (empty($member_info)){
			showDialog(Language::get('sns_member_error'),'','error');
		}
		//查询原帖信息
		$model_stracelog = Model('store_sns_tracelog');
		$stracelog_info = $model_stracelog->getStoreSnsTracelogInfo(array('strace_id' => $stid));
		if (empty($stracelog_info)){
			showDialog(Language::get('sns_forward_fail'),'','error');
		}
		if($stracelog_info['strace_content'] == ''){
			$data = json_decode($stracelog_info['strace_goodsdata'],true);
			if( CHARSET == 'GBK') {
				foreach ((array)$data as $k=>$v){
					$data[$k] = Language::getUTF8($v);
				}
			}
			$stracelog_info['strace_content']	= $model_stracelog->spellingStyle($stracelog_info['strace_type'], $data);
		}

		$insert_arr = array();
		$insert_arr['trace_originalid']			= 0;
		$insert_arr['trace_originalmemberid']	= 0;
		$insert_arr['trace_originalstate']		= 0;
		$insert_arr['trace_memberid'] 			= $member_info['member_id'];
		$insert_arr['trace_membername']			= $member_info['member_name'];
		$insert_arr['trace_memberavatar']		= $member_info['member_avatar'];
		$insert_arr['trace_title']				= $_POST['forwardcontent']?$_POST['forwardcontent']:Language::get('sns_forward');
		$insert_arr['trace_content']			= "<dl class=\"fd-wrap\">
														<dt>
															<h3><a href=\"index.php?act=store_snshome&sid=".$stracelog_info['strace_storeid']."\" target=\"_blank\">".$stracelog_info['strace_storename']."</a>".Language::get('nc_colon')."
															".$stracelog_info['strace_title']."</h3>
										      			</dt>
														<dd>".$stracelog_info['strace_content']."</dd>
													<dl>";
		$insert_arr['trace_addtime']			= time();
		$insert_arr['trace_state']				= 0;
		$insert_arr['trace_privacy']			= 0;
		$insert_arr['trace_commentcount']		= 0;
		$insert_arr['trace_copycount']			= 0;
		$insert_arr['trace_orgcommentcount']	= 0;
		$insert_arr['trace_orgcopycount']		= 0;
		$insert_arr['trace_from']				= 2;
		$result = $model->table('sns_tracelog')->insert($insert_arr);
		if ($result){
			//更新动态转发次数
			$where = array('strace_id'=>$stid);
			$update	= array('strace_spread'=>array('exp', 'strace_spread+1'));
			Model('store_sns_tracelog')->editStoreSnsTracelog($update, $where);
			showDialog(Language::get('sns_forward_succ'),'','succ');
		}else {
			showDialog(Language::get('sns_forward_fail'),'','error');
		}
	}
	/**
	 * 删除动态
	 */
	public function deltraceOp(){
		// 验证用户是否登录
		$this->checkLoginStatus();

		$stid = intval($_GET['id']);
		if ($stid <= 0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		//删除动态
		$result = Model('store_sns_tracelog')->delStoreSnsTracelog(array('strace_id'=>$stid , 'strace_storeid'=>$_SESSION['store_id'] ));
		if ($result){
			//删除对应的评论
			Model('store_sns_comment')->delStoreSnsComment(array('strace_id' => $stid));
			$js = "$('[nc_type=\"tracerow_{$stid}\"]').remove();";
			showDialog(Language::get('nc_common_del_succ'),'','succ',$js);
		} else {
			showDialog(Language::get('nc_common_del_fail'),'','error');
		}
	}
	/**
	 * 删除评论(访客登录后操作)
	 */
	public function delcommentOp(){
		// 验证用户是否登录
		$this->checkLoginStatus();

		$scid = intval($_GET['scid']);$stid = intval($_GET['stid']);
		if ($scid <= 0 || $stid <= 0){
			showDialog(L('wrong_argument'),'','error');
		}
		// 查询评论相关信息
		$model_storesnscomment = Model('store_sns_comment');
		$where = array('strace_id'=>$stid, 'scomm_id' => $scid, 'scomm_memberid' => $_SESSION['member_id']);	// where条件
		$scomment_info	= $model_storesnscomment->getStoreSnsCommentInfo($where);
		if(empty($scomment_info)){
			showDialog(L('wrong_argument'),'','error');
		}

		// 删除评论
		$result = $model_storesnscomment->delStoreSnsComment($where);
		if ($result){
			// 更新动态统计信息
			$where = array('strace_id'=>$scomment_info['strace_id']);
			$update = array('strace_comment'=>array('exp','strace_comment-1'));
			Model('store_sns_tracelog')->editStoreSnsTracelog($update, $where);

			$js .="$('.comment-list [nc_type=\"commentrow_".$scid."\"]').remove();";
			showDialog(L('nc_common_del_succ'),'','succ',$js);
		}else {
			showDialog(L('nc_common_del_fail'),'','error');
		}
	}
	/**
	 * 一条SNS动态及其评论
	 */
	public function straceinfoOp(){
		$stid = intval($_GET['st_id']);
		if($stid <= 0){
			showMessage(Language::get('para_error'),'','','error');
		}
		$model_stracelog = Model('store_sns_tracelog');
		$strace_info = $model_stracelog->getStoreSnsTracelogInfo(array('strace_id' => $stid));
		if(!empty($strace_info)){
			if($strace_info['strace_content'] == ''){
				$content = $model_stracelog->spellingStyle($strace_info['strace_type'], json_decode($strace_info['strace_goodsdata'],true));
				$strace_info['strace_content'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $content);
			}
		}
		Tpl::output('strace_info', $strace_info);
		//验证码
		Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
		Tpl::showpage('store_snstraceinfo');
	}
	/**
	 * 验证用户是否登录
	 */
	private function checkLoginStatus(){
		if ($_SESSION['is_login'] != 1){
			@header("location: index.php?act=login&ref_url=".urlencode('index.php?act=member_snshome'));
		}

	}
}
