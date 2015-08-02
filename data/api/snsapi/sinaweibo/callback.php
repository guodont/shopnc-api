<?php
include_once(BASE_DATA_PATH.DS.'api'.DS.'snsapi'.DS.'sinaweibo'.DS.'config.php');
include_once(BASE_DATA_PATH.DS.'api'.DS.'snsapi'.DS.'sinaweibo'.DS.'saetv2.ex.class.php' );
$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY);
///////////code需要传递////////////
if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}
if ($token) {
	$_SESSION['slast_key'] = $token;
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
} else {
	echo "<script>alert('授权失败。');</script>";
	echo "<script>window.close();</script>";
	exit;
}
