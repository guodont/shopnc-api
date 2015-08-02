<?php
/**
 * 站外分享绑定
 *
 
 */


defined('InShopNC') or exit('Access Invalid!');
class sns_bindingModel extends Model{
	public function __construct(){
		parent::__construct('member');
	}
	/**
	 * 获得可显示的绑定接口数组
	 */
	public function getUsableApp($member_id){
		if (empty($member_id)){
			return false;
		}
		$app_arr = $this->getApps();
		$app_arrnew = array();
		//判断系统是否开启站外分享功能
		foreach ($app_arr as $k=>$v){
			if (C('share_'.$k.'_isuse') == 1){
				$v['isbind'] = false;
				$app_arrnew[$k] = $v;
			}
		}
		if(empty($app_arrnew)) return false;
		//查询该用户的绑定信息
		$bind_list = $this->table('sns_binding')->where(array('snsbind_memberid'=>$member_id))->select();
		if (!empty($bind_list)){
			foreach ($bind_list as $k=>$v){
				if (intval($v['snsbind_updatetime'])+intval($v['snsbind_expiresin']) > time()){
					$app_arrnew[$v['snsbind_appsign']] = array_merge($app_arrnew[$v['snsbind_appsign']],$v);
					$app_arrnew[$v['snsbind_appsign']]['isbind'] = true;
				}
			}
		}
		return $app_arrnew;
	}
	/**
	 * 获得某用户已经绑定某接口详细信息
	 */
	public function getUsableOneApp($member_id,$appkey){
		$bind_info = array();
		if (empty($member_id) || empty($appkey)){
			return $bind_info;
		}
		$app_arr = $this->getApps();
		$appkey_arr = array_keys($app_arr);
		if (!in_array($appkey,$appkey_arr)){
			return $bind_info;
		}
		//查询该用户是否已经绑定
		$where_arr = array();
		$where_arr['snsbind_memberid'] = $member_id;
		$where_arr['snsbind_appsign'] = $appkey;
		$bind_info = $this->table('sns_binding')->where($where_arr)->find();

		if (intval($bind_info['snsbind_updatetime'])+intval($bind_info['snsbind_expiresin']) <= time()){
			$bind_info = array();
		}
		return $bind_info;
	}
	/**
	 * 分享接口数组
	 */
	public function getApps(){
		$app_arr = array();
		$app_arr['qqweibo'] = array('name'=>Language::get('nc_shareset_qqweibo'),'url'=>"http://t.qq.com",'applyurl'=>'http://dev.t.qq.com');
		$app_arr['sinaweibo'] = array('name'=>Language::get('nc_shareset_sinaweibo'),'url'=>"http://www.weibo.com",'applyurl'=>'http://open.weibo.com/developers');
		return $app_arr;
	}
	/**
	 * qqweibo用图片URL发表带图片的微博
	 */
	public function addQQWeiboPic($bindinfo,$params){
		$_SESSION['qqweibo']['t_access_token'] = $bindinfo['snsbind_accesstoken'];
		$_SESSION['qqweibo']['t_openid'] = $bindinfo['snsbind_openid'];
		include_once(BASE_DATA_PATH.DS.'api'.DS.'snsapi'.DS.'qqweibo'.DS.'tencent.php');
	    $params_qqweibo['content'] = $params['title'].$params['comment'].$params['url'];
	    $params_qqweibo['pic_url'] = $params['images'];
	    Tencent::api('t/add_pic_url', $params_qqweibo, 'POST');
	}
	/**
	 * sinaweibo上传图片并发布一条新微博
	 */
	public function addSinaWeiboUpload($bindinfo,$params){
		include_once(BASE_DATA_PATH.DS.'api'.DS.'snsapi'.DS.'sinaweibo'.DS.'config.php');
		include_once(BASE_DATA_PATH.DS.'api'.DS.'snsapi'.DS.'sinaweibo'.DS.'saetv2.ex.class.php');
		$c = new SaeTClientV2( C('share_sinaweibo_appid') , C('share_sinaweibo_appkey') , $bindinfo['snsbind_accesstoken']);
        if($params['images']) {
            $c->upload($params['title'].$params['comment'].$params['url'],$params['images']);
        } else {
            $c->update($params['title'].$params['comment'].$params['url']);
        }
	}
}
