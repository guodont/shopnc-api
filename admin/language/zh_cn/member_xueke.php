<?php
defined('InShopNC') or exit('Access Invalid!');
	
$lang['flea_class']							   = '学科门类';
$lang['flea_class_help1']					   = '当用户添加闲置闲置信息时选择闲置学科，用户可根据学科查询闲置列表';
$lang['flea_class_help2']					   = '点击学科名前“+”符号，显示当前学科的下级学科';
$lang['flea_class_index_tips']                 = '手机端学科名称可修改为"显示为XXX"，若不填则显示原学科名称';
$lang['flea_isuse_off_tips']                   = '系统未开启闲置市场功能';

$lang['flea_class_setting_ok']                 = '设置成功'; 
$lang['flea_class_setting_error']              = '设置失败'; 
$lang['flea_index_class_setting']              = '手机端学科设置';
$lang['flea_index_class_setting_info']         = '设置信息';
$lang['flea_index_class_setting_digital']      = '数码';
$lang['flea_index_class_setting_beauty']       = '装扮';
$lang['flea_index_class_setting_home']         = '居家';
$lang['flea_index_class_setting_interest']     = '兴趣';
$lang['flea_index_class_setting_baby']         = '母婴';
$lang['flea_index_class_setting_as']           = '显示为';
/**
* index
*/
$lang['goods_class_index_del_succ']            = '删除学科成功';
$lang['goods_class_index_choose_del']          = '请选择要删除的内容';
$lang['goods_class_index_choose_edit']         = '请选择要编辑的内容';
$lang['goods_class_index_in_homepage']         = '手机端内';
$lang['goods_class_index_display']             = '显示';
$lang['goods_class_index_hide']                = '隐藏';
$lang['goods_class_index_succ']                = '成功';
$lang['goods_class_index_choose_in_homepage']  = '请选择手机端内要';
$lang['goods_class_index_content']             = '的内容!';
$lang['goods_class_index_class']               = '商品学科';
$lang['goods_class_index_export']              = '导出';
$lang['goods_class_index_import']              = '导入';
$lang['goods_class_index_name']                = '学科名称';
$lang['goods_class_index_display_in_homepage'] = '手机端显示';
$lang['goods_class_index_ensure_del']          = '删除该学科将会同时删除该学科的所有下级学科，您确定要删除吗';
$lang['goods_class_index_display_tip']         = '手机端默认只显示到二级学科';
/**
* 批量编辑
*/
$lang['goods_class_batch_edit_succ']           = '批量编辑成功';
$lang['goods_class_batch_edit_wrong_content']  = '批量修改内容不正确';
$lang['goods_class_batch_edit_batch']          = '批量编辑';
$lang['goods_class_batch_edit_keep']           = '保持不变';
$lang['goods_class_batch_edit_again']          = '重新编辑该学科';
$lang['goods_class_batch_edit_ok']             = '编辑学科成功。';
$lang['goods_class_batch_edit_fail']           = '编辑学科失败。';
$lang['goods_class_batch_edit_paramerror']     = '参数非法';
/**
* 添加学科
*/
$lang['goods_class_add_name_null']             = '学科名称不能为空';
$lang['goods_class_add_sort_int']              = '学科排序仅能为数字';
$lang['goods_class_add_back_to_list']          = '返回学科列表';
$lang['goods_class_add_again']                 = '继续新增学科';
$lang['goods_class_add_succ']                  = '新增学科成功';
$lang['goods_class_add_fail']                  = '新增学科失败';
$lang['goods_class_add_name_exists']           = '该学科名称已经存在了，请您换一个';
$lang['goods_class_add_sup_class']             = '上级学科';
$lang['goods_class_add_sup_class_notice']	= '如果选择上级学科，那么新增的学科则为被选择上级学科的子学科';
$lang['goods_class_add_update_sort']           = '更新排序';
$lang['goods_class_add_display_tip']           = '新增的学科名称是否显示';
/**
* 学科导入
*/
$lang['goods_class_import_succ']               = '导入成功';
$lang['goods_class_import_csv_null']           = '导入的csv文件不能为空';
$lang['goods_class_import_data']               = '导入数据';
$lang['goods_class_import_choose_file']        = '请选择文件';
$lang['goods_class_import_file_tip']           = '如果导入速度较慢，建议您把文件拆分为几个小文件，然后分别导入';
$lang['goods_class_import_choose_code']        = '请选择文件编码';
$lang['goods_class_import_code_tip']           = '如果文件较大，建议您先把文件转换为 utf-8 编码，这样可以避免转换编码时耗费时间';
$lang['goods_class_import_file_type']          = '文件格式';
$lang['goods_class_import_first_class']        = '一级学科';
$lang['goods_class_import_second_class']       = '二级学科';
$lang['goods_class_import_third_class']        = '三级学科';
$lang['goods_class_import_example_download']   = '例子文件下载';
$lang['goods_class_import_example_tip']        = '点击下载导入例子文件';
$lang['goods_class_import_import']             = '导入';
/**
* 学科导出
*/
$lang['goods_class_export_data']               = '导出数据';
$lang['goods_class_export_if_trans']           = '导出您的商品学科数据';
$lang['goods_class_export_trans_tip']          = '';
$lang['goods_class_export_export']             = '导出';
$lang['goods_class_export_help1']				= '导出内容为商品学科信息的.csv文件';