<?php
/**
 * PHP SDK for QQ登录 OpenAPI
 *
 * @version 1.2
 * @author connect@qq.com
 * @copyright © 2011, Tencent Corporation. All rights reserved.
 */

/**
 * @brief 本文件作为demo的配置文件。
 */

/**
 * 正式运营环境请关闭错误信息
 * ini_set("error_reporting", E_ALL);
 * ini_set("display_errors", TRUE);
 * QQDEBUG = true  开启错误提示
 * QQDEBUG = false 禁止错误提示
 * 默认禁止错误信息
 */
define("QQDEBUG", false);
if (defined("QQDEBUG") && QQDEBUG)
{
    @ini_set("error_reporting", E_ALL);
    @ini_set("display_errors", TRUE);
}

/**
 * session
 */
require_once(BASE_PATH.DS.'api'.DS.'qq'.DS.'comm'.DS."session.php");

//包含配置信息
//$data = rkcache("setting", true);
$data = require(BASE_DATA_PATH.DS.'cache'.DS.'setting.php');// by abc.com
//qq互联是否开启
if($data['qq_isuse'] != 1){
	@header('location: index.php');
	exit;
}

//申请到的appid
//$_SESSION["appid"]    = yourappid; 
$_SESSION["appid"]    = trim($data['qq_appid']);

//申请到的appkey
//$_SESSION["appkey"]   = "yourappkey"; 
$_SESSION["appkey"]   = trim($data['qq_appkey']);

//QQ登录成功后跳转的地址,请确保地址真实可用，否则会导致登录失败。
//$_SESSION["callback"] = "http://your domain/oauth/get_access_token.php"; 
$_SESSION["callback"] = SHOP_SITE_URL."/api.php?act=toqq&op=g";

//QQ授权api接口.按需调用
$_SESSION["scope"] = "get_user_info";

//print_r ($_SESSION);
?>
