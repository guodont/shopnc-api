<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * index
 */
$lang['db_index_min_size']		= '分卷大小至少为10K';
$lang['db_index_name_exists']	= '备份名已存在，请填写其他名称';
$lang['db_index_choose']		= '请选择要备份的数据库表';
$lang['db_index_backup_to_wait']	= '正在进行备份，请稍等';
$lang['db_index_back_to_db']	= '返回数据库备份';
$lang['db_index_backup_succ']	= '备份成功';
$lang['db_index_backuping']		= '正在备份';
$lang['db_index_backup_succ1']	= '分卷数据#';
$lang['db_index_backup_succ2']	= '成功创建，程序将自动继续';
$lang['db_index_db']			= '数据库';
$lang['db_index_backup']		= '备份';
$lang['db_index_restore']		= '恢复';
$lang['db_index_backup_method']	= '备份方式';
$lang['db_index_all_data']		= '备份全部数据';
$lang['db_index_spec_table']	= '备份选定的表';
$lang['db_index_table']			= '数据表';
$lang['db_index_size']			= '分卷大小';
$lang['db_index_name']			= '备份名';
$lang['db_index_name_tip']		= '备份名字由1到20位数字、字母或下划线组成';
$lang['db_index_backup_tip']	= '为保证数据完整性请确保您的站点处于关闭状态，您确定要马上执行当前操作吗';
$lang['db_index_help1']			= '数据备份功能根据你的选择备份全部数据或指定数据，导出的数据文件可用“数据恢复”功能或 phpMyAdmin 导入';
$lang['db_index_help2']			= '建议定期备份数据库';
/**
 * 恢复
 */
$lang['db_restore_file_not_exists']		= '删除的文件不存在';
$lang['db_restore_del_succ']			= '删除备份成功';
$lang['db_restore_choose_file_to_del']	= '请选择要删除的内容';
$lang['db_restore_backup_time']			= '备份时间';
$lang['db_restore_backup_size']			= '备份大小';
$lang['db_restore_volumn']				= '卷数';
$lang['db_restore_import']				= '导入';
/**
 * 导入
 */
$lang['db_import_back_to_list']			= '返回数据库备份';
$lang['db_import_succ']					= '导入成功';
$lang['db_import_going']				= '正在导入';
$lang['db_import_succ2']				= '成功导入，程序将自动继续';
$lang['db_import_fail']					= '数据导入失败';
$lang['db_import_file_not_exists']		= '导入的文件不存在';
$lang['db_import_help1']				= '点击导入选项进行数据库恢复';
/**
 * 删除
 */
$lang['db_del_succ']	= '删除备份成功';