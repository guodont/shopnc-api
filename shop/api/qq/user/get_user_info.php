<?php
require_once(BASE_PATH.DS.'api'.DS.'qq'.DS.'comm'.DS."config.php");
require_once(BASE_PATH.DS.'api'.DS.'qq'.DS.'comm'.DS."utils.php");

function get_user_info()
{
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $_SESSION['access_token']
        . "&oauth_consumer_key=" . $_SESSION["appid"]
        . "&openid=" . $_SESSION["openid"]
        . "&format=json";

    $info = get_url_contents($get_user_info);
    $arr = json_decode($info, true);
    $arr = getGBK($arr,CHARSET);

    return $arr;
}

?>
