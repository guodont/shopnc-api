<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * index
 */
$lang['region_index_modify_succ']	= '修改地區數據成功';
$lang['region_index_config']		= '查看地區';
$lang['region_index_export']		= '導出';
$lang['region_index_import']		= '導入';
$lang['region_index_import_tip']	= '導入將清空現有的所有地區數據\n導入前建議先備份資料庫地區數據！\n確定要導入嗎';
$lang['region_index_import_region']	= '導入全國地區數據【三級】';
$lang['region_index_choose_region']	= '查看下一級地區';
$lang['region_index_province']		= '省份';
$lang['region_index_city']			= '城市';
$lang['region_index_county']		= '州縣';
$lang['region_index_name']			= '地區名稱';
$lang['region_index_help2']			= '添加，編輯或刪除操作後需要點擊"提交"按鈕才生效';
$lang['region_index_del_tip']		= '刪除內容會同時刪除下級內容，確認提交嗎';
$lang['region_index_add']			= '添加新地區';
/**
 * 導入
 */
$lang['region_import_succ']				= '導入成功';
$lang['region_import_csv_null']			= '導入的檔案不存在或者已經損壞';
$lang['region_import_choose_file']		= '請選擇檔案';
$lang['region_import_file_tip']			= '如果導入速度較慢，建議您把檔案拆分為幾個小檔案，然後分別導入';
$lang['region_import_choose_code']		= '請選擇檔案編碼';

$lang['region_import_file_format']		= '檔案格式';
$lang['region_import_first']			= '一級地區';
$lang['region_import_second']			= '二級地區';
$lang['region_import_third']			= '三級地區';
$lang['region_import_example_download']	= '例子檔案下載';
$lang['region_import_download_tip']		= '點擊下載導入例子檔案';
$lang['region_import_help3']			= '如果檔案較大，建議您事先把檔案轉換為 utf-8 編碼，這樣可以避免轉換編碼時耗費時間';
/**
 * 導出
 */
$lang['region_export_trans']			= '導出您的地區分類數據？';
$lang['region_export_trans_tip']		= '導出內容為地區分類信息的.csv檔案';