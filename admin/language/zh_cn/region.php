<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * index
 */
$lang['region_index_modify_succ']	= '修改地区数据成功';
$lang['region_index_config']		= '查看地区';
$lang['region_index_export']		= '导出';
$lang['region_index_import']		= '导入';
$lang['region_index_import_tip']	= '导入将清空现有的所有地区数据\n导入前建议先备份数据库地区数据！\n确定要导入吗';
$lang['region_index_import_region']	= '导入全国地区数据【三级】';
$lang['region_index_choose_region']	= '查看下一级地区';
$lang['region_index_province']		= '省份';
$lang['region_index_city']			= '城市';
$lang['region_index_county']		= '州县';
$lang['region_index_name']			= '地区名称';
$lang['region_index_help2']			= '添加，编辑或删除操作后需要点击"提交"按钮才生效';
$lang['region_index_del_tip']		= '删除内容会同时删除下级内容，确认提交吗';
$lang['region_index_add']			= '添加新地区';
/**
 * 导入
 */
$lang['region_import_succ']				= '导入成功';
$lang['region_import_csv_null']			= '导入的文件不存在或者已经损坏';
$lang['region_import_choose_file']		= '请选择文件';
$lang['region_import_file_tip']			= '如果导入速度较慢，建议您把文件拆分为几个小文件，然后分别导入';
$lang['region_import_choose_code']		= '请选择文件编码';

$lang['region_import_file_format']		= '文件格式';
$lang['region_import_first']			= '一级地区';
$lang['region_import_second']			= '二级地区';
$lang['region_import_third']			= '三级地区';
$lang['region_import_example_download']	= '例子文件下载';
$lang['region_import_download_tip']		= '点击下载导入例子文件';
$lang['region_import_help3']			= '如果文件较大，建议您事先把文件转换为 utf-8 编码，这样可以避免转换编码时耗费时间';
/**
 * 导出
 */
$lang['region_export_trans']			= '导出您的地区分类数据？';
$lang['region_export_trans_tip']		= '导出内容为地区分类信息的.csv文件';