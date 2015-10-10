<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 淘宝导入
 */

$lang['taobao_import_online_skey_tip1']	 		= 'SessionKey是关联卖家店铺的一个标识，通过淘宝开放平台分配给用户。';
$lang['taobao_import_online_skey_tip2']	 		= '点击这里登录获取授权';
$lang['taobao_import_online_skey_tip3']	 		= '得到授权的SessionKey后，请将SessionKey粘贴到该输入框中，商城并不保存该值，请自己妥善保管<br/>SessionKey的生存周期大概是一天左右，如果该值过期，您还需要再次登录获取授权。';
$lang['taobao_import_online_pageno']	 		= '抓取第几页';
$lang['taobao_import_online_pagesize']	 		= '每页抓取商品数';
$lang['taobao_import_online_tip4']	 			= '默认为1。使用场景：我的店铺在售商品总数为260，导入过程为：<br/>第一步： 抓取第几页填入“1”，输入其它项后提交，等待全部导入完毕。<br/>第二步： 至此，共导入了100条，刷新本页面，准备第二次导入。<br/>第三步： 抓取第几页填入“2”，输入其它项后提交，等待全部导入完毕。<br/>第四步： 至此，共导入了200条，刷新本页面，准备第三次导入。<br/>第五步： 抓取第几页填入“3”，输入其它项后提交，等待全部导入完毕。<br/>至此，共导入了260条。导入完毕。';
//$lang['taobao_import_online_begintime']	 		= '开始时间';
//$lang['taobao_import_online_endtime']	 		= '结束时间';
$lang['taobao_import_online_spec_key']	 		= '规格名称';
$lang['taobao_import_online_tip5']	 			= '规格名称以英文逗号隔开，<a href="%s" target="_blank">不确定什么是规格名称，点击这里</a>，当商城无法区分淘宝数据来源的商品属性中哪些为规格时，含有以上名称的属性会作为规格保存，其它作为属性保存，若不填写，系统会自动区分规格与属性，但准确性会降低。';
$lang['taobao_import_online_spec_key_value']	= '颜色,颜色分类,尺码';
$lang['taobao_import_online_tip6']	 			= '商品导入完毕，重要提示：<br/>商品导入完成后，请务必检查导入后每个商品的详细信息是否正确，如导入后的信息与淘宝信息不符，请手动自行更改，商品所在分类被放置到名为“taobao”的顶级分类下，如需要调整分类，请与系统管理员联系，如果出现个别导入失败的商品，请自行手动导入。';
$lang['taobao_import_online_allow_import']	 	= '目前系统平台不支持淘宝商品导入\r\n淘宝商品导入需系统平台：\r\n 1. 设置淘宝taobao_app_key和taobao_secret_key\r\n 2. 同步淘宝商品类目\r\n如果疑问请与管理员联系';
$lang['taobao_import_online_importing']	 		= '正在导入...';
$lang['taobao_import_online_input_sessionkey']	= 'SessionKey为必填项';
$lang['taobao_import_online_type_error']	 	= '格式不正确';
$lang['taobao_import_online_import_success']	= '导入成功';
$lang['taobao_import_online_import_fail']	 	= '导入失败';
$lang['taobao_import_online_import_ok']	 		= '全部导入完毕';
$lang['taobao_import_online_goods_limit']		= '您发布的商品已满，请到“店铺设置”升级店铺等级获得更多发布权限';
$lang['taobao_import_online_time_limit']		= '您已经达到店铺使用期限，如果您想继续增加商品，请到“店铺设置”升级店铺等级';
$lang['taobao_import_online_goods_none']		= '未找到商品';
?>