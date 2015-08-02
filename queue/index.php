<?php
/**
 * 队列
 *
 * 
 * by abc www.abc.com 二次开发修正版本
 */


define('APP_ID','queue');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));

if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/33hao.php')) exit('33hao.php isn\'t exists!');

if (empty($_SERVER['argv'][1]) || empty($_SERVER['argv'][2])) exit('parameter error');

$_GET['act'] = $_SERVER['argv'][1];
$_GET['op'] = $_SERVER['argv'][2];
if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');

Base::run();
?>