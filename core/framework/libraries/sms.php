<?php
/**
 * 手机短信类
 */
defined('InShopNC') or exit('Access Invalid!');

class Sms {
    /*
     * 发送手机短信
     * @param unknown $mobile 手机号
     * @param unknown $content 短信内容
    */
    public function send($mobile,$content) {
		$mobile_host_type=C('mobile_host_type');
		if($mobile_host_type==1)
		{
			return $this->mysend_smsbao($mobile,$content);
		}
		if($mobile_host_type==2)
		{
			return $this->mysend_yunpian($mobile,$content);
		}
      
		
    }
	/*
	您于{$send_time}绑定手机号，验证码是：{$verify_code}。【{$site_name}】
	0  提交成功
	30：密码错误
	40：账号不存在
	41：余额不足
	42：帐号过期
	43：IP地址限制
	50：内容含有敏感词
	51：手机号码不正确
	http://api.smsbao.com/sms?u=USERNAME&p=PASSWORD&m=PHONE&c=CONTENT
	*/
    private function mysend_smsbao($mobile,$content){
     
	   $user_id = urlencode(C('mobile_username')); // 这里填写用户名
 	   $pass = urlencode(C('mobile_pwd')); // 这里填登陆密码
 	   if(!$mobile || !$content || !$user_id || !$pass) return false;
	   if(is_array($mobile)) $mobile = implode(",",$mobile);
       $mobile=urlencode($mobile);
       //$content=$content."【我的网站】";
       $content=urlencode($content);
	   $pass =md5($pass);//MD5加密
	   $url="http://api.smsbao.com/sms?u=".$user_id."&p=".$pass."&m=".$mobile."&c=".$content."";
 	   $res = file_get_contents($url);
 	   //return $res;
 	   $ok=$res=="0";
 	   if($ok)
 	   {
 	     return true;
 	   }
 	   return false;

    }
	 /**
	 * http://www.yunpian.com/
     * 发送手机短信
     * @param unknown $mobile 手机号
     * @param unknown $content 短信内容
	  0 	OK 	调用成功，该值为null 	无需处理
	  1 	请求参数缺失 	补充必须传入的参数 	开发者
	  2 	请求参数格式错误 	按提示修改参数值的格式 	开发者
	  3 	账户余额不足 	账户需要充值，请充值后重试 	开发者
	  4 	关键词屏蔽 	关键词屏蔽，修改关键词后重试 	开发者
	  5 	未找到对应id的模板 	模板id不存在或者已经删除 	开发者
	  6 	添加模板失败 	模板有一定的规范，按失败提示修改 	开发者
	  7 	模板不可用 	审核状态的模板和审核未通过的模板不可用 	开发者
	  8 	同一手机号30秒内重复提交相同的内容 	请检查是否同一手机号在30秒内重复提交相同的内容 	开发者
	  9 	同一手机号5分钟内重复提交相同的内容超过3次 	为避免重复发送骚扰用户，同一手机号5分钟内相同内容最多允许发3次 	开发者
	  10 	手机号黑名单过滤 	手机号在黑名单列表中（你可以把不想发送的手机号添加到黑名单列表） 	开发者
	  11 	接口不支持GET方式调用 	接口不支持GET方式调用，请按提示或者文档说明的方法调用，一般为POST 	开发者
	  12 	接口不支持POST方式调用 	接口不支持POST方式调用，请按提示或者文档说明的方法调用，一般为GET 	开发者
	  13 	营销短信暂停发送 	由于运营商管制，营销短信暂时不能发送 	开发者
	  14 	解码失败 	请确认内容编码是否设置正确 	开发者
	  15 	签名不匹配 	短信签名与预设的固定签名不匹配 	开发者
	  16 	签名格式不正确 	短信内容不能包含多个签名【 】符号 	开发者
	  17 	24小时内同一手机号发送次数超过限制 	请检查程序是否有异常或者系统是否被恶意攻击 	开发者
	  -1 	非法的apikey 	apikey不正确或没有授权 	开发者
	  -2 	API没有权限 	用户没有对应的API权限 	开发者
	  -3 	IP没有权限 	访问IP不在白名单之内，可在后台"账户设置->IP白名单设置"里添加该IP 	开发者
	  -4 	访问次数超限 	调整访问频率或者申请更高的调用量 	开发者
	  -5 	访问频率超限 	短期内访问过于频繁，请降低访问频率 	开发者
	  -50 未知异常 	系统出现未知的异常情况 	技术支持
	  -51 系统繁忙 	系统繁忙，请稍后重试 	技术支持
	  -52 充值失败 	充值时系统出错 	技术支持
	  -53 提交短信失败 	提交短信时系统出错 	技术支持
	  -54 记录已存在 	常见于插入键值已存在的记录 	技术支持
	  -55 记录不存在 	没有找到预期中的数据 	技术支持
	  -57 用户开通过固定签名功能，但签名未设置 	联系客服或技术支持设置固定签名 	技术支持
     */
    private function mysend_yunpian($mobile,$content) {
		$yunpian='yunpian';
		$plugin = str_replace('\\', '', str_replace('/', '', str_replace('.', '',$yunpian)));
        if (!empty($plugin)) {
            define('PLUGIN_ROOT', BASE_DATA_PATH . DS .'api/smsapi');
            require_once(PLUGIN_ROOT . DS . $plugin . DS . 'Send.php');
            return send_sms($content, $mobile);
        }
		else
		{
			return false;
		}
    }
	
   
}
