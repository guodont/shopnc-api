<?php
/**
 * 此为PHP-SDK 2.0
 */
require_once(BASE_DATA_PATH.DS.'api'.DS.'snsapi'.DS.'qqweibo'.DS.'tencent.php' );
require_once(BASE_DATA_PATH.DS.'api'.DS.'snsapi'.DS.'qqweibo'.DS.'config.php' );
OAuth::init($client_id, $client_secret);
Tencent::$debug = $debug;

if ($_GET['code']) {//已获得code
	$code = $_GET['code'];
    $openid = $_GET['openid'];
    $openkey = $_GET['openkey'];
    //获取授权token
    $url = OAuth::getAccessToken($code, $callback);
    $r = Http::request($url);
    parse_str($r, $out);
    //存储授权数据
    if ($out['access_token']) {
        $_SESSION['qqweibo']['t_access_token'] = $out['access_token'];
        $_SESSION['qqweibo']['t_expire_in'] = $out['expires_in'];
        $_SESSION['qqweibo']['t_refresh_token'] = $out['refresh_token'];
        $_SESSION['qqweibo']['t_uname'] = $out['name'];
        $_SESSION['qqweibo']['t_code'] = $code;
        $_SESSION['qqweibo']['t_openid'] = $openid;//OpenID可以唯一标识一个用户。在同一个应用下，同一个QQ号码的OpenID是相同的；但在不同应用下，同一个QQ号码可能有不同的OpenID
        $_SESSION['qqweibo']['t_openkey'] = $openkey;//OpenKey是与OpenID对应的用户key(用户在第三方应用的腾讯登录态)，是验证OpenID身份的验证密钥，大多数API的访问，都需要同时具备OpenID和OpenKey的信息，其有效期为2小时
        //验证授权
        $r = OAuth::checkOAuthValid();
        if ($r) {//成功
            //header('Location: ' . $callback);//刷新页面
        } else {
            //exit('<h3>授权失败,请重试</h3>');
            echo "<script>alert('授权失败,请重试');</script>";
			echo "<script>window.close();</script>";
			exit;
        }
    } else {
        exit($r);
    }
} else {//获取授权code
	echo "<script>alert('授权失败,请重试');</script>";
	echo "<script>window.close();</script>";
	exit;
}
