<?php
/**
 * 分享绑定
 ***/


defined('InShopNC') or exit('Access Invalid!');

class member_sharemanageControl extends BaseMemberControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_sharemanage');
		//判断系统是否开启站外分享功能
		if (C('share_isuse') != 1){
			showMessage(Language::get('sharebind_unused'),'index.php?act=member_information&op=member','html','error');
		}
	}
	/**
	 * 分享绑定列表
	 */
	public function indexOp(){
		$model = Model('sns_binding');
		$app_arr = $model->getUsableApp($_SESSION['member_id']);
		//信息输出
		Tpl::output('app_arr',$app_arr);
		self::profile_menu('sns_binding');
		Tpl::showpage('member_sharebind');
	}
	/**
	 * 解除绑定
	 */
	public function unbindOp(){
		$type = $_GET['type'];
		if (empty($type)){
			showDialog(Language::get('wrong_argument'),'index.php?act=member_sharemanage','error');
		}
		$model = Model('sns_binding');
		$app_arr = $model->getApps();
		$appkey_arr = array_keys($app_arr);
		if (empty($appkey_arr) || !in_array($type,$appkey_arr)){
			showDialog(Language::get('wrong_argument'),'index.php?act=member_sharemanage','error');
		}
		//删除绑定信息
		$where_arr = array();
		$where_arr['snsbind_memberid'] = $_SESSION['member_id'];
		$where_arr['snsbind_appsign'] = $type;
		$result = $model->table('sns_binding')->where($where_arr)->delete();
		if ($result){
			$js = "location.reload();";
			showDialog(Language::get('sharebind_unbind_succ'),'','succ',$js);
		}else {
			showDialog(Language::get('sharebind_unbind_fail'),'','succ');
		}
	}
	/**
	 * 验证某接口是否已经绑定
	 */
	public function checkbindOp(){
		$app_key = $_GET['k'];
        $result = '';
        if (empty($app_key)){
            $result = json_encode(array('done'=>false,'msg'=>Language::get('sharebind_bind_fail')));
        } else {
            $model = Model('sns_binding');
            $bind_info = $model->getUsableOneApp($_SESSION['member_id'],$app_key);
            if (empty($bind_info)){
                $result = json_encode(array('done'=>false,'msg'=>Language::get('sharebind_bind_fail')));
            }else {
                $result = json_encode(array('done'=>true));
            }
        }
        if (isset($_GET['callback']))
        {
            $result = $_GET['callback']=='?' ? '('.$result.')' : $_GET['callback']."($result);";
        }
        echo $result;
        exit;
    }
	/**
	 * 分享绑定qqzone
	 */
	public function share_qqzoneOp(){
		//判断系统是否开启站外分享功能
		if (C('share_qqzone_isuse') != 1){
			showMessage(Language::get('sharebind_unused'),'index.php?act=member_sharemanage','html','error');
		}
		include_once BASE_DATA_PATH.'/api/snsapi/qqzone/oauth/qq_callback.php';
		if (!$_SESSION['qqzone']){
			echo "<script>alert('".Language::get('sharebind_bind_fail')."');</script>";
			echo "<script>window.close();</script>";
			exit;
		}
		$update_arr = array();
		$update_arr['snsbind_memberid'] = $_SESSION['member_id'];
		$update_arr['snsbind_membername'] = $_SESSION['member_name'];
		$update_arr['snsbind_appsign'] = 'qqzone';
		$update_arr['snsbind_updatetime'] = time();
		$update_arr['snsbind_accesstoken'] = $_SESSION['qqzone']['access_token'];
		$update_arr['snsbind_expiresin'] = $_SESSION['qqzone']['expires_in'];
		$update_arr['snsbind_openid'] = $_SESSION['qqzone']['openid'];
		//获取qq账号信息
		require_once (BASE_DATA_PATH.DS.'api'.DS.'snsapi'.DS.'qqzone'.DS.'user'.DS.'get_user_info.php');
		$qquser_info = get_user_info();
		$update_arr['snsbind_openinfo'] = $qquser_info['nickname'];

		$model = Model();
		$where_arr = array();
		$where_arr['snsbind_memberid'] = $_SESSION['member_id'];
		$where_arr['snsbind_appsign'] = 'qqzone';
		//查询该用户是否已经绑定qqzone
		$bind_info = $model->table('sns_binding')->where($where_arr)->find();
		if (empty($bind_info)){
			$result = $model->table('sns_binding')->insert($update_arr);
		}else {
			$result = $model->table('sns_binding')->where($where_arr)->update($update_arr);
		}
		if (!$result){
			echo "<script>alert('".Language::get('sharebind_bind_fail')."');</script>";
		}
		echo "<script>window.close();</script>";
		exit;
	}
	/**
	 * 分享绑定sinaweibo
	 */
	public function share_sinaweiboOp(){
		//判断系统是否开启站外分享功能
		if (C('share_sinaweibo_isuse') != 1){
			showMessage(Language::get('sharebind_unused'),'index.php?act=member_sharemanage','html','error');
		}
		include_once BASE_DATA_PATH.'/api/snsapi/sinaweibo/callback.php';
		if (!$_SESSION['slast_key']){
			echo "<script>alert('".Language::get('sharebind_bind_fail')."');</script>";
			echo "<script>window.close();</script>";
			exit;
		}
		$update_arr = array();
		$update_arr['snsbind_memberid'] = $_SESSION['member_id'];
		$update_arr['snsbind_membername'] = $_SESSION['member_name'];
		$update_arr['snsbind_appsign'] = 'sinaweibo';
		$update_arr['snsbind_updatetime'] = time();
		$update_arr['snsbind_accesstoken'] = $_SESSION['slast_key']['access_token'];
		$update_arr['snsbind_expiresin'] = $_SESSION['slast_key']['expires_in'];
		$update_arr['snsbind_openid'] = $_SESSION['slast_key']['uid'];
		//获取新浪微博账号信息
		require_once (BASE_DATA_PATH.DS.'api'.DS.'snsapi'.DS.'sinaweibo'.DS.'saetv2.ex.class.php');
		$c = new SaeTClientV2( C('sina_wb_akey'), C('sina_wb_skey') , $_SESSION['slast_key']['access_token']);
		$sinauser_info = $c->show_user_by_id($_SESSION['slast_key']['uid']);//根据ID获取用户等基本信息
		$update_arr['snsbind_openinfo'] = $sinauser_info['name'];

		$model = Model();
		$where_arr = array();
		$where_arr['snsbind_memberid'] = $_SESSION['member_id'];
		$where_arr['snsbind_appsign'] = 'sinaweibo';
		//查询该用户是否已经绑定sinaweibo
		$bind_info = $model->table('sns_binding')->where($where_arr)->find();
		if (empty($bind_info)){
			$result = $model->table('sns_binding')->insert($update_arr);
		}else {
			$result = $model->table('sns_binding')->where($where_arr)->update($update_arr);
		}
		if (!$result){
			echo "<script>alert('".Language::get('sharebind_bind_fail')."');</script>";
		}
		echo "<script>window.close();</script>";
		exit;
	}
	/**
	 * 分享绑定腾讯微博
	 */
	public function share_qqweiboOp(){
		//判断系统是否开启站外分享功能
		if (C('share_qqweibo_isuse') != 1){
			showMessage(Language::get('sharebind_unused'),'index.php?act=member_sharemanage','html','error');
		}
		include_once BASE_DATA_PATH.'/api/snsapi/qqweibo/callback.php';
		if (!$_SESSION['qqweibo']){
			echo "<script>alert('".Language::get('sharebind_bind_fail')."');</script>";
			echo "<script>window.close();</script>";
			exit;
		}
		//添加qqweibo绑定记录
		$update_arr = array();
		$update_arr['snsbind_memberid'] = $_SESSION['member_id'];
		$update_arr['snsbind_membername'] = $_SESSION['member_name'];
		$update_arr['snsbind_appsign'] = 'qqweibo';
		$update_arr['snsbind_updatetime'] = time();
		$update_arr['snsbind_accesstoken'] = $_SESSION['qqweibo']['t_access_token'];
		$update_arr['snsbind_expiresin'] = $_SESSION['qqweibo']['t_expire_in'];
		$update_arr['snsbind_refreshtoken'] = $_SESSION['qqweibo']['t_refresh_token'];
		//$update_arr['snsbind_openid'] = $_SESSION['t_openid'].'|'.$_SESSION['t_openkey'];
		$update_arr['snsbind_openid'] = $_SESSION['qqweibo']['t_openid'];
		$update_arr['snsbind_openinfo'] = $_SESSION['qqweibo']['t_uname'];

		$model = Model();
		$where_arr = array();
		$where_arr['snsbind_memberid'] = $_SESSION['member_id'];
		$where_arr['snsbind_appsign'] = 'qqweibo';
		//查询该用户是否已经绑定qqweibo
		$bind_info = $model->table('sns_binding')->where($where_arr)->find();
		if (empty($bind_info)){
			$result = $model->table('sns_binding')->insert($update_arr);
		}else {
			$result = $model->table('sns_binding')->where($where_arr)->update($update_arr);
		}
		if (!$result){
			echo "<script>alert('".Language::get('sharebind_bind_fail')."');</script>";
		}
		echo "<script>window.close();</script>";
		exit;
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @param array 	$array		附加菜单
	 * @return
	 */
	private function profile_menu($menu_key='',$array=array()) {
		$menu_array		= array();
		$menu_array = array(
			1=>array('menu_key'=>'sns_binding',	'menu_name'=>'分享绑定',	'menu_url'=> urlShop('member_sharemanage', 'index')),
		);
		if(!empty($array)) {
			$menu_array[] = $array;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
