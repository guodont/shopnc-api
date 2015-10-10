<?php
/**
 * 商城板块初始化文件
 *
 * 商城板块初始化文件，引用框架初始化文件
 *
 *
 
 */
define('APP_ID','microshop');
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/33hao.php')) exit('33hao.php isn\'t exists!');

if (!@include(BASE_PATH.'/config/config.ini.php')){
	@header("Location: install/index.php");die;
}

define('APP_SITE_URL',MICROSHOP_SITE_URL);
define('MICROSHOP_IMG_URL',UPLOAD_SITE_URL.DS.ATTACH_MICROSHOP);
define('TPL_NAME',TPL_MICROSHOP_NAME);
define('MICROSHOP_RESOURCE_SITE_URL',MICROSHOP_SITE_URL.'/resource');
define('MICROSHOP_TEMPLATES_URL',MICROSHOP_SITE_URL.'/templates/'.TPL_NAME);
define('MICROSHOP_BASE_TPL_PATH',dirname(__FILE__).'/templates/'.TPL_NAME);
define('MICROSHOP_SEO_KEYWORD',$config['seo_keywords']);
define('MICROSHOP_SEO_DESCRIPTION',$config['seo_description']);
//微商城框架扩展
require(BASE_PATH.'/framework/function/function.php');
//引入control父类
require(BASE_PATH.'/control/control.php');
Base::run();
