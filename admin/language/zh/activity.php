<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 公用
 */
$lang['activity_openstate']		= '狀態';
$lang['activity_openstate_open']		= '開啟';
$lang['activity_openstate_close']		= '關閉';
/**
 * 活動列表
 */
$lang['activity_index']				= '活動';
$lang['activity_index_content']		= '活動內容';
$lang['activity_index_manage']		= '活動管理';
$lang['activity_index_title']		= '活動標題';
$lang['activity_index_type']		= '活動類型';
$lang['activity_index_banner']		= '橫幅圖片';
$lang['activity_index_style']		= '使用樣式';
$lang['activity_index_start']		= '開始時間';
$lang['activity_index_end']			= '結束時間';
$lang['activity_index_goods']		= '商品';
$lang['activity_index_group']		= '團購';
$lang['activity_index_default']		= '預設風格';
$lang['activity_index_long_time']	= '長期活動';
$lang['activity_index_deal_apply']	= '處理申請';
$lang['activity_index_help1']		= '當平台發起活動時，店舖可申請參與活動';
$lang['activity_index_help2']		= '在“頁面導航”模組處可選擇添加活動導航';
$lang['activity_index_help3']		= '只有關閉或者過期的活動才能刪除';
$lang['activity_index_help4']		= '活動列表排序越小越靠前顯示';
$lang['activity_index_periodofvalidity']= '有效期';
/**
 * 添加活動
 */
$lang['activity_new_title_null']	= '活動標題不能為空';
$lang['activity_new_style_null']	= '必須選擇頁面風格';
$lang['activity_new_type_null']		= '必須選擇活動類別';
$lang['activity_new_sort_tip']		= '排序必須是數字，範圍0~255';
$lang['activity_new_end_date_too_early']	= '截止時間必須晚于開始時間';
$lang['activity_new_title_tip']		= '請為您的活動填寫一個簡明扼要的主題';
$lang['activity_new_type_tip']		= '請為您的活動選擇一個類別';
$lang['activity_new_start_tip']		= '留空預設為活動立即開始';
$lang['activity_new_end_tip']		= '留空預設為活動永久進行';
$lang['activity_new_banner_tip']	= '支持jpg、jpeg、gif、png格式';
$lang['activity_new_style']			= '頁面風格';
$lang['activity_new_style_tip']		= '請選擇該活動所在頁面的風格樣式';
$lang['activity_new_desc']			= '活動說明';
$lang['activity_new_sort_tip1']		= '數字範圍為0~255，數字越小越靠前';
$lang['activity_new_sort_null']		= '排序不能為空';
$lang['activity_new_sort_minerror']	= '數字範圍為0~255';
$lang['activity_new_sort_maxerror']	= '數字範圍為0~255';
$lang['activity_new_sort_error']	= '排序為0~255的數字';
$lang['activity_new_banner_null']   = '橫幅圖片不能為空';
$lang['activity_new_ing_wrong']     = '圖片限于png,gif,jpeg,jpg格式';
$lang['activity_new_startdate_null']   = '開始時間不能為空';
$lang['activity_new_enddate_null']     = '結束時間不能為空';

/**
 * 刪除活動
 */
$lang['activity_del_choose_activity']	= '請選擇活動';
/**
 * 活動內容
 */
$lang['activity_detail_index_goods_name']	= '商品名稱';
$lang['activity_detail_index_store']		= '所屬店舖';
$lang['activity_detail_index_auditstate']	= '審核狀態';
$lang['activity_detail_index_to_audit']		= '待審核';
$lang['activity_detail_index_passed']		= '已通過';
$lang['activity_detail_index_unpassed']		= '已拒絶';
$lang['activity_detail_index_apply_again']	= '再次申請';
$lang['activity_detail_index_pass']			= '通過';
$lang['activity_detail_index_refuse']		= '拒絶';
$lang['activity_detail_index_pass_all']		= '您確定要通過已選信息嗎?';
$lang['activity_detail_index_refuse_all']	= '您確定要拒絶已選信息嗎?';
$lang['activity_detail_index_tip1']	= '申請商品在沒有審核或者審核失敗的時候可以刪除';
$lang['activity_detail_index_tip2']	= '本頁申請商品的顯示規則是未審核先顯示，排序越小越靠前顯示';
$lang['activity_detail_index_tip3']	= '下架、違規下架商品或者所屬店舖已經關閉的商品將不會在活動頁面顯示，請慎重審核';

/**
 * 活動內容刪除
 */
$lang['activity_detail_del_choose_detail']	= '請選擇活動內容(比如商品或團購等)';