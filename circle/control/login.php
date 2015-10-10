<?php
/**
 * 前台登录 退出操作
 *
 *
 *
 *********************************/

defined('InShopNC') or exit('Access Invalid!');

class loginControl extends BaseCircleControl {

	public function __construct(){
		parent::__construct();
		Language::read("login_index");
	}

	/**
	 * 登录操作
	 *
	 */
	public function indexOp(){
		$lang	= Language::getLangContent();
		$model_member	= Model('member');
		//检查登录状态
		$model_member->checkloginMember();
		$script="document.getElementsByName('codeimage')[0].src='".APP_SITE_URL."/index.php?act=seccode&op=makecode&nchash='+NC_HASH+'&t=' + Math.random();";
		$result = chksubmit(true,true,'num');
		if ($result){
			if ($result === -11){
				showDialog(L('login_index_login_again'),'','error',$script,2);
			}elseif ($result === -12){
				showDialog(L('login_index_wrong_checkcode'),'','error',$script,2);
			}
			if (process::islock('login')) {
				showDialog(L('login_index_op_repeat'),APP_SITE_URL);
			}
			$array	= array();
			$array['member_name']	= $_POST['user_name'];
			$array['member_passwd']	= md5($_POST['password']);
			$member_info = $model_member->infoMember($array);
			if(is_array($member_info) and !empty($member_info)) {
			    if(!$member_info['member_state']){
			        showDialog($lang['login_index_account_disabled']);
			    }
			} else {
			    process::addprocess('login');
			    showDialog($lang['login_index_login_fail'],'','error',$script,2);
			}
			$model_member->createSession($member_info);
			process::clear('login');

			// cookie中的cart存入数据库
			Model('cart')->mergecart($member_info,$_SESSION['store_id']);

			// cookie中的浏览记录存入数据库
			Model('goods_browse')->mergebrowse($_SESSION['member_id'],$_SESSION['store_id']);

			//添加会员积分
			$model_member->addPoint($member_info);

			showDialog('','reload','js');
		}

		if(empty($_GET['ref_url'])) $_GET['ref_url'] = getReferer();
		Tpl::output('html_title',C('site_name').' - '.$lang['login_index_login']);
		Tpl::output('nchash',getNchash());
		if ($_GET['inajax'] == 1){
			Tpl::showpage('login_inajax','null_layout');
		}else{
			return false;
		}

	}

	public function loginoutOp(){
	    session_unset();
	    session_destroy();
	    setNcCookie('goodsnum','',-3600);
		showDialog(L('login_logout_success'),'','succ','',2);
	}

}
