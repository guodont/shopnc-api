<?php
session_start();
//判断是否已经登录
if(isset($_SESSION['slast_key'])) 
{
	@header("Location:".SHOP_SITE_URL."/index.php");
	exit;
}
include_once(BASE_PATH.DS.'api'.DS.'sina'.DS.'config.php' );
include_once(BASE_PATH.DS.'api'.DS.'sina'.DS.'saetv2.ex.class.php' );
$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
@header("location:$code_url");
exit;
?>