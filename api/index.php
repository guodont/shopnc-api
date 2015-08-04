<?php
/**
 * API接口初始化文件
 *
 *
 * @author guodont
 */

define('APP_ID','api');
define('IGNORE_EXCEPTION', true);
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));

if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/33hao.php')) exit('33hao.php isn\'t exists!');

if (!@include(BASE_PATH.'/config/config.ini.php')){
    exit('config.ini.php isn\'t exists!');
}

//框架扩展
require(BASE_PATH.'/framework/function/function.php');
if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');

Base::run();
