<?php
header('Content-Type: text/html; charset=UTF-8');
//打开session
session_start();
error_reporting(0);

//包含配置信息
//$data = rkcache("setting", true);
$data = require(BASE_DATA_PATH.DS.'cache'.DS.'setting.php'); // by abc.com

//判读站外分析是否开启
if($data['share_isuse'] != 1 || $data['share_qqweibo_isuse'] != 1){
	echo "<script>alert('系统未开启该功能');</script>";
	echo "<script>window.close();</script>";
	exit;
}
//填写自己的appid
$client_id = trim($data['share_qqweibo_appid']);
//填写自己的appkey
$client_secret = trim($data['share_qqweibo_appkey']);
//登录成功后跳转的地址,请确保地址真实可用，否则会导致登录失败
$callback = SHOP_SITE_URL."/index.php?act=member_sharemanage&op=share_qqweibo";
//调试模式
$debug = false;