<?php
/**
 * PHP SDK for QQ登录 OpenAPI
 *
 * @version 1.2
 * @author connect@qq.com
 * @copyright © 2011, Tencent Corporation. All rights reserved.
 */

/**
 * @brief 本文件包含了OAuth认证过程中会用到的公用方法 
 */

require_once(BASE_PATH.DS.'api'.DS.'qq'.DS.'comm'.DS."config.php");

function do_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    curl_setopt($ch, CURLOPT_POST, TRUE); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
    curl_setopt($ch, CURLOPT_URL, $url);
    $ret = curl_exec($ch);

    curl_close($ch);
    return $ret;
}

function get_url_contents($url)
{
//    if (ini_get("allow_url_fopen") == "1")
//        return file_get_contents($url);
// by abc.com
		if (ini_get("allow_url_fopen") == "1")
           return file_get_contents($url);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result =  curl_exec($ch);
    curl_close($ch);

    return $result;
}

/**
 * 得到数组变量的GBK编码
 *
 * @param array $key 数组
 * @param string $charset 编码
 * @return array 数组类型的返回结果
 */
function getGBK($key,$charset){
	/**
	 * 转码
	 */
	if (strtoupper($charset) == 'GBK' && !empty($key)){
		if (is_array($key)){
			$result = var_export($key, true);//变为字符串
			$result = iconv('UTF-8','GBK',$result);
			eval("\$result = $result;");//转换回数组
		}else {
			$result = iconv('UTF-8','GBK',$key);
		}
	}else{
		$result = $key;
	}
	return $result;
}
?>
