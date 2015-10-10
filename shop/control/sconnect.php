<?php
/**
 * 新浪微博登录
 ***/


defined('InShopNC') or exit('Access Invalid!');

class sconnectControl extends BaseHomeControl{
	public function __construct(){
		parent::__construct();
		Language::read("home_login_register,home_login_index,home_sconnect");
		/**
		 * 判断新浪微博登录功能是否开启
		 */
		if (C('sina_isuse') != 1){
			showMessage(Language::get('home_sconnect_unavailable'),'index.php','html','error');
		}
		if (!$_SESSION['slast_key']){
			showMessage(Language::get('home_sconnect_error'),'index.php','html','error');
		}
		Tpl::output('hidden_nctoolbar', 1);
	}
	/**
	 * 首页
	 */
	public function indexOp(){
		/**
		 * 检查登录状态
		 */
		if($_SESSION['is_login'] == '1') {
			$this->bindsinaOp();
		}else {
			$this->autologin();
			$this->registerOp();
		}
	}
	/**
	 * 新浪微博账号绑定新用户
	 */
	public function registerOp(){
		//实例化模型
		$model_member	= Model('member');
		//检查登录状态
		$model_member->checkloginMember();
		$result = chksubmit(false,C('captcha_status_register'),'num');
		if ($result !== false){
			if ($result === -11){
				showDialog(Language::get('login_usersave_code_isnull'));
			}elseif ($result === -12){
				showDialog(Language::get('login_usersave_wrong_code'));
			}
		}else{
			//获取新浪微博账号信息
			require_once (BASE_PATH.DS.'api'.DS.'sina'.DS.'saetv2.ex.class.php');
			$c = new SaeTClientV2( C('sina_wb_akey'), C('sina_wb_skey') , $_SESSION['slast_key']['access_token']);
			$sinauser_info = $c->show_user_by_id($_SESSION['slast_key']['uid']);//根据ID获取用户等基本信息
			Tpl::output('sinauser_info',$sinauser_info);
			Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
			Tpl::showpage('sconnect_register');exit;
		}

		//注册验证
		$obj_validate = new Validate();
		$obj_validate->validateparam = array(
		array("input"=>$_POST["user_name"],		"require"=>"true",		"message"=>Language::get('login_usersave_username_isnull')),
		array("input"=>$_POST["password"],		"require"=>"true",		"message"=>Language::get('login_usersave_password_isnull')),
		array("input"=>$_POST["password_confirm"],"require"=>"true",	"validator"=>"Compare","operator"=>"==","to"=>$_POST["password"],"message"=>Language::get('login_usersave_password_not_the_same')),
		array("input"=>$_POST["email"],			"require"=>"true",		"validator"=>"email", "message"=>Language::get('login_usersave_wrong_format_email')),
		array("input"=>$_POST["agree"],			"require"=>"true", 		"message"=>Language::get('login_usersave_you_must_agree'))
		);
		$error = $obj_validate->validate();
		if ($error != ''){
			showMessage(Language::get('error').$error,'','html','error');
		}
		$check_member_name	= $model_member->getMemberInfo(array('member_name'=>$_POST['user_name']));
		if(is_array($check_member_name) and count($check_member_name)>0) {
			showMessage(Language::get('login_usersave_your_username_exists'),'','html','error');
		}
		$check_member_email	= $model_member->getMemberInfo(array('member_email'=>$_POST['email']));
		if(is_array($check_member_email) and count($check_member_email)>0) {
			showMessage(Language::get('login_usersave_your_email_exists'),'','html','error');
		}
		$user_array	= array();
		/**
		 * 会员添加
		 */
		$user_array['member_name']		= $_POST['user_name'];
		$user_array['member_passwd']	= $_POST['password'];
		$user_array['member_email']		= $_POST['email'];
		$user_array['member_sinaopenid']	= $_SESSION['slast_key']['uid'];//sina openid
		//处理sina账号信息
		$sina_arr = array();
		if (trim($_POST['regsname'])){
			$sina_arr['name'] = trim($_POST['regsname']);
		}
		$sina_str = '';
		if (is_array($sina_arr) && count($sina_arr)>0){
			$sina_str = serialize($sina_arr);
		}
		$user_array['member_sinainfo']	= $sina_str;//sina 信息
		$result	= $model_member->addMember($user_array);
		if($result) {
			$member_info = $model_member->getMemberInfo(array('member_name'=>$user_array['member_name']));
			$model_member->createSession($member_info);
			$success_message = Language::get('login_usersave_regist_success');
			showMessage($success_message,SHOP_SITE_URL);
		} else {
			showMessage(Language::get('login_usersave_regist_fail'),SHOP_SITE_URL.'/index.php?act=login&op=register','html','error');
		}
	}
	/**
	 * 新浪微博账号绑定已有用户
	 */
	public function loginOp(){
		//实例化模型
		$model_member	= Model('member');
		//检查登录状态
		$model_member->checkloginMember();
		$_POST['captcha'] = $_POST['captcha_login'];
		$result = chksubmit(false,C('captcha_status_login'),'num');
		if ($result !== false){
			if ($result === -11){
				showDialog(Language::get('login_index_login_illegal'));
			}elseif ($result === -12){
				showDialog(Language::get('login_usersave_wrong_code'));
			}
		}else{
			//获取新浪微博账号信息
			require_once (BASE_PATH.'/api/sina/get_user_info.php');
			$sinauser_info = get_user_info(C('sina_wb_akey'), C('sina_wb_skey'), $_SESSION['slast_key']['oauth_token'], $_SESSION['slast_key']['oauth_token_secret'],$_SESSION['slast_key']['user_id']);
			Tpl::output('sinauser_info',$sinauser_info);
			Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
			Tpl::showpage('sconnect_register');exit;
		}

		//登录验证
		$obj_validate = new Validate();
		$obj_validate->validateparam = array(
			array("input"=>$_POST["user_name"],		"require"=>"true", "message"=>Language::get('login_index_username_isnull')),
			array("input"=>$_POST["password"],		"require"=>"true", "message"=>Language::get('login_index_password_isnull'))
		);
		$error = $obj_validate->validate();
		if ($error != ''){
			showMessage(Language::get('error').$error,'','html','error');
		}
		$array	= array();
		$array['member_name']	= $_POST['user_name'];
		$array['member_passwd']	= md5($_POST['password']);
		$member_info = $model_member->getMemberInfo($array);
		if(is_array($member_info) and !empty($member_info)) {
			if(!$member_info['member_state']){//1为启用 0 为禁用
				showMessage(Language::get('nc_notallowed_login'),'','html','error');
			}
			/**
			 * 登录时间更新
			 */
			$update_info	= array(
			'member_sinaopenid'=>$_SESSION['slast_key']['uid']); //sina openid
			//处理sina账号信息
			$sina_arr = array();
			if (trim($_POST['loginsname'])){
				$sina_arr['name'] = trim($_POST['loginsname']);
			}
			$sina_str = '';
			if (is_array($sina_arr) && count($sina_arr)>0){
				$sina_str = serialize($sina_arr);
			}
			$update_info['member_sinainfo']	= $sina_str;//sina 信息

			$model_member->editMember(array('member_id'=>$member_info['member_id']), $update_info);
			$member_info['member_sinainfo']	= $sina_str;
			$model_member->createSession($member_info);
			$success_message = Language::get('login_index_login_success');
			showMessage($success_message,SHOP_SITE_URL);
		} else {
			showMessage(Language::get('login_index_login_again'),'','html','error');
		}
	}
	/**
	 * 绑定新浪微博账号后自动登录
	 */
	public function autologin(){
		//查询是否已经绑定该新浪微博账号,已经绑定则直接跳转
		$model_member	= Model('member');
		$array	= array();
		$array['member_sinaopenid']	= $_SESSION['slast_key']['uid'];
		$member_info = $model_member->getMemberInfo($array);
		if (is_array($member_info) && count($member_info)>0){
			if(!$member_info['member_state']){//1为启用 0 为禁用
				showMessage(Language::get('nc_notallowed_login'),'','html','error');
			}
			$model_member->createSession($member_info);
			$success_message = Language::get('login_index_login_success');
			showMessage($success_message,SHOP_SITE_URL);
		}
	}
	/**
	 * 已有用户绑定新浪微博账号
	 */
	public function bindsinaOp(){
		$model_member	= Model('member');
		//验证新浪账号用户是否已经存在
		$array	= array();
		$array['member_sinaopenid']	= $_SESSION['slast_key']['uid'];
		$member_info = $model_member->getMemberInfo($array);
		if (is_array($member_info) && count($member_info)>0){
			unset($_SESSION['slast_key']['uid']);
			showMessage(Language::get('home_sconnect_binding_exist'),'index.php?act=member_connect&op=sinabind','html','error');
		}
		//处理sina账号信息
		require_once (BASE_PATH.DS.'api'.DS.'sina'.DS.'saetv2.ex.class.php');
		$c = new SaeTClientV2( C('sina_wb_akey'), C('sina_wb_skey') , $_SESSION['slast_key']['access_token']);
		$sinauser_info = $c->show_user_by_id($_SESSION['slast_key']['uid']);//根据ID获取用户等基本信息
		$sina_arr = array();
		$sina_arr['name'] = $sinauser_info['name'];
		$sina_str = '';
	    $sina_str = serialize($sina_arr);
		$edit_state		= $model_member->editMember(array('member_id'=>$_SESSION['member_id']),array('member_sinaopenid'=>$_SESSION['slast_key']['uid'], 'member_sinainfo'=>$sina_str));
		if ($edit_state){
			showMessage(Language::get('home_sconnect_binding_success'),'index.php?act=member_connect&op=sinabind');
		}else {
			showMessage(Language::get('home_sconnect_binding_fail'),'index.php?act=member_connect&op=sinabind','html','error');
		}
	}
	/**
	 * 更换绑定新浪微博账号
	 */
	public function changesinaOp(){
		//如果用户已经登录，进入此链接则显示错误
		if($_SESSION['is_login'] == '1') {
			showMessage(Language::get('home_sconnect_error'),'index.php','html','error');
		}
		unset($_SESSION['slast_key']);
		header('Location:'.SHOP_SITE_URL.'/api.php?act=tosina');
		exit;
	}
}
