<?php
defined('InShopNC') or exit('Access Invalid!');
/*
 * 配置文件
 */
$options = array();
$options['apikey'] = C('mobile_key'); //在www.yunpian.com获得的apikey
$options['signature'] =  C('mobile_signature'); //签名一定要满足3-8个中文字符不含英文字符才可用高级通道例 淘常州
return $options;
?>