<?php
/**
 * QQ互联登录
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class connectControl extends BaseHomeControl{
	public function __construct(){
		parent::__construct();
		Language::read("home_login_register,home_login_index,home_qqconnect");
		/**
		 * 判断qq互联功能是否开启
		 */
		if (C('qq_isuse') != 1){
			showMessage(Language::get('home_qqconnect_unavailable'),'index.php','html','error');//'系统未开启QQ互联功能'
		}
		/**
		 * 初始化测试数据
		 */
		if (!$_SESSION['openid']){
			showMessage(Language::get('home_qqconnect_error'),'index.php','html','error');//'系统错误'
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
			//qq绑定
			$this->bindqqOp();
		}else {
			$this->autologin();
			$this->registerOp();
		}
	}
	/**
	 * qq绑定新用户
	 */
	public function registerOp(){
		//实例化模型
		$model_member	= Model('member');
		if (chksubmit()){
			$update_info	= array();
			$update_info['member_passwd']= md5(trim($_POST["password"]));
			if(!empty($_POST["email"])) {
				$update_info['member_email']= $_POST["email"];
				$_SESSION['member_email']= $_POST["email"];
			}
			$model_member->editMember(array('member_id'=>$_SESSION['member_id']),$update_info);
			showMessage(Language::get('nc_common_save_succ'),SHOP_SITE_URL);
		}else {
			//检查登录状态
			$model_member->checkloginMember();
			//获取qq账号信息
			require_once (BASE_PATH.'/api/qq/user/get_user_info.php');
			$qquser_info = get_user_info($_SESSION["appid"], $_SESSION["appkey"], $_SESSION["token"], $_SESSION["secret"], $_SESSION["openid"]);
			Tpl::output('qquser_info',$qquser_info);

			//处理qq账号信息
			$qquser_info['nickname'] = trim($qquser_info['nickname']);
			$user_passwd = rand(100000, 999999);
			/**
			 * 会员添加
			 */
			$user_array	= array();
			$user_array['member_name']		= $qquser_info['nickname'];
			$user_array['member_passwd']	= $user_passwd;
			$user_array['member_email']		= '';
			$user_array['member_qqopenid']	= $_SESSION['openid'];//qq openid
			$user_array['member_qqinfo']	= serialize($qquser_info);//qq 信息
			$rand = rand(100, 899);
			if(strlen($user_array['member_name']) < 3) $user_array['member_name']		= $qquser_info['nickname'].$rand;
			$check_member_name	= $model_member->getMemberInfo(array('member_name'=>trim($user_array['member_name'])));
			$result	= 0;
			if(empty($check_member_name)) {
				$result	= $model_member->addMember($user_array);
			}else {
				$user_array['member_name'] = trim($qquser_info['nickname']).$rand;
				$check_member_name	= $model_member->getMemberInfo(array('member_name'=>trim($user_array['member_name'])));
				if(empty($check_member_name)) {
					$result	= $model_member->addMember($user_array);
				}else {
					for ($i	= 1;$i < 999999;$i++) {
						$rand = $rand+$i;
						$user_array['member_name'] = trim($qquser_info['nickname']).$rand;
						$check_member_name	= $model_member->getMemberInfo(array('member_name'=>trim($user_array['member_name'])));
						if(empty($check_member_name)) {
							$result	= $model_member->addMember($user_array);
							break;
						}
					}
				}
			}
			if($result) {
				Tpl::output('user_passwd',$user_passwd);
				$avatar	= @copy($qquser_info['figureurl_qq_2'],BASE_UPLOAD_PATH.'/'.ATTACH_AVATAR."/avatar_$result.jpg");
				$update_info	= array();
				if($avatar) {
				    $update_info['member_avatar'] 	= "avatar_$result.jpg";
    				$model_member->editMember(array('member_id'=>$result),$update_info);
    				$user_array['member_avatar'] 	= "avatar_$result.jpg";
				}
				$user_array['member_id']		= $result;
				$model_member->createSession($user_array);
				Tpl::showpage('connect_register');
			} else {
				showMessage(Language::get('login_usersave_regist_fail'),SHOP_SITE_URL.'/index.php?act=login&op=register','html','error');//"会员注册失败"
			}
		}
	}
	/**
	 * 已有用户绑定QQ
	 */
	public function bindqqOp(){
		$model_member	= Model('member');
		//验证QQ账号用户是否已经存在
		$array	= array();
		$array['member_qqopenid']	= $_SESSION['openid'];
		$member_info = $model_member->getMemberInfo($array);
		if (is_array($member_info) && count($member_info)>0){
			unset($_SESSION['openid']);
			showMessage(Language::get('home_qqconnect_binding_exist'),'index.php?act=member_connect&op=qqbind','html','error');//'该QQ账号已经绑定其他商城账号,请使用其他QQ账号与本账号绑定'
		}
		//获取qq账号信息
		require_once (BASE_PATH.'/api/qq/user/get_user_info.php');
		$qquser_info = get_user_info($_SESSION["appid"], $_SESSION["appkey"], $_SESSION["token"], $_SESSION["secret"], $_SESSION["openid"]);
		$edit_state		= $model_member->editMember(array('member_id'=>$_SESSION['member_id']), array('member_qqopenid'=>$_SESSION['openid'], 'member_qqinfo'=>serialize($qquser_info)));
		if ($edit_state){
			showMessage(Language::get('home_qqconnect_binding_success'),'index.php?act=member_connect&op=qqbind');
		}else {
			showMessage(Language::get('home_qqconnect_binding_fail'),'index.php?act=member_connect&op=qqbind','html','error');//'绑定QQ失败'
		}
	}
	/**
	 * 绑定qq后自动登录
	 */
	public function autologin(){
		//查询是否已经绑定该qq,已经绑定则直接跳转
		$model_member	= Model('member');
		$array	= array();
		$array['member_qqopenid']	= $_SESSION['openid'];
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
	 * 更换绑定QQ号码
	 */
	public function changeqqOp(){
		//如果用户已经登录，进入此链接则显示错误
		if($_SESSION['is_login'] == '1') {
			showMessage(Language::get('home_qqconnect_error'),'index.php','html','error');//'系统错误'
		}
		unset($_SESSION['openid']);
		@header('Location:'.SHOP_SITE_URL.'/api.php?act=toqq');
		exit;
	}
}
