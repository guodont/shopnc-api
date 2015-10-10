<?php
defined('InShopNC') or exit('Access Invalid!');

require_once(dirname(__FILE__) . DS . 'lib/HttpClient.class.php');
require_once(dirname(__FILE__) . DS . 'config.inc.php');

$GLOBALS['sms_options'] = $options;

/**
* 模板接口发短信
* apikey 为云片分配的apikey
* tpl_id 为模板id
* tpl_value 为模板值
* mobile 为接收短信的手机号
*/
function tpl_send_sms($tpl_id, $tpl_value, $mobile){
	$path = "/v1/sms/tpl_send.json";
	return Send::sendSms($path, $GLOBALS['sms_options']['apikey'], $mobile, $tpl_id, $tpl_value);
}

/**
* 普通接口发短信
* apikey 为云片分配的apikey
* text 为短信内容
* mobile 为接收短信的手机号
*/
function send_sms($content, $mobile){
	$path = "/v1/sms/send.json";
	return Send::sendSms($path, $GLOBALS['sms_options']['apikey'], str_replace(C('site_name'), $GLOBALS['sms_options']['signature'], $content), $mobile);
}

class Send {

	const HOST = 'yunpian.com';

	final private static function __replyResult($jsonStr) {
		//header("Content-type: text/html; charset=utf-8");
		$result = json_decode($jsonStr);
		if ($result->code == 0) {
			$data['state'] = 'true';
			return ture;
		} else {
			$data['state'] = 'false';
			$data['msg'] = $result->msg;
			return false;
		}
	}

	final public static function sendSms($path, $apikey, $encoded_text, $mobile, $tpl_id = '', $encoded_tpl_value = '') {
		$client = new HttpClient(self::HOST);
		$client->setDebug(false);
		if (!$client->post($path, array (
				'apikey' 		=> $apikey,
				'text' 			=> $encoded_text,
				'mobile' 		=> $mobile,
				'tpl_id' 		=> $tpl_id,
				'tpl_value' 	=> $encoded_tpl_value
		))) {
			return '-10000';
		} else {
			return self::__replyResult($client->getContent());
		}
	}
}

?>