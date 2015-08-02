<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * index
 */
$lang['db_index_min_size']		= '分卷大小至少為10K';
$lang['db_index_name_exists']	= '備份名已存在，請填寫其他名稱';
$lang['db_index_choose']		= '請選擇要備份的資料庫表';
$lang['db_index_backup_to_wait']	= '正在進行備份，請稍等';
$lang['db_index_back_to_db']	= '返回資料庫備份';
$lang['db_index_backup_succ']	= '備份成功';
$lang['db_index_backuping']		= '正在備份';
$lang['db_index_backup_succ1']	= '分卷數據#';
$lang['db_index_backup_succ2']	= '成功創建，程序將自動繼續';
$lang['db_index_db']			= '資料庫';
$lang['db_index_backup']		= '備份';
$lang['db_index_restore']		= '恢復';
$lang['db_index_backup_method']	= '備份方式';
$lang['db_index_all_data']		= '備份全部數據';
$lang['db_index_spec_table']	= '備份選定的表';
$lang['db_index_table']			= '數據表';
$lang['db_index_size']			= '分卷大小';
$lang['db_index_name']			= '備份名';
$lang['db_index_name_tip']		= '備份名字由1到20位數字、字母或下劃線組成';
$lang['db_index_backup_tip']	= '為保證數據完整性請確保您的站點處于關閉狀態，您確定要馬上執行當前操作嗎';
$lang['db_index_help1']			= '數據備份功能根據你的選擇備份全部數據或指定數據，導出的數據檔案可用“數據恢復”功能或 phpMyAdmin 導入';
$lang['db_index_help2']			= '建議定期備份資料庫';
/**
 * 恢復
 */
$lang['db_restore_file_not_exists']		= '刪除的檔案不存在';
$lang['db_restore_del_succ']			= '刪除備份成功';
$lang['db_restore_choose_file_to_del']	= '請選擇要刪除的內容';
$lang['db_restore_backup_time']			= '備份時間';
$lang['db_restore_backup_size']			= '備份大小';
$lang['db_restore_volumn']				= '卷數';
$lang['db_restore_import']				= '導入';
/**
 * 導入
 */
$lang['db_import_back_to_list']			= '返回資料庫備份';
$lang['db_import_succ']					= '導入成功';
$lang['db_import_going']				= '正在導入';
$lang['db_import_succ2']				= '成功導入，程序將自動繼續';
$lang['db_import_fail']					= '數據導入失敗';
$lang['db_import_file_not_exists']		= '導入的檔案不存在';
$lang['db_import_help1']				= '點擊導入選項進行資料庫恢復';
/**
 * 刪除
 */
$lang['db_del_succ']	= '刪除備份成功';