<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 團購狀態 
 */
$lang['groupbuy_state_all'] = '全部團購';
$lang['groupbuy_state_verify'] = '未審核';
$lang['groupbuy_state_cancel'] = '已取消';
$lang['groupbuy_state_progress'] = '已通過';
$lang['groupbuy_state_fail'] = '審核失敗';
$lang['groupbuy_state_close'] = '已結束';

/**
 * index
 */
$lang['groupbuy_index_manage']		= '團購管理';
$lang['groupbuy_verify']    		= '待審核';
$lang['groupbuy_cancel']    		= '已取消';
$lang['groupbuy_progress']  		= '已審核';
$lang['groupbuy_close']     		= '已結束';
$lang['groupbuy_back']     		= '返回列表';

$lang['groupbuy_recommend_goods']	= '推薦商品';
$lang['groupbuy_template_list']		= '團購活動';
$lang['groupbuy_template_add']		= '添加活動';
$lang['groupbuy_template_name']		= '活動名稱';
$lang['groupbuy_class_list']		= '團購分類';
$lang['groupbuy_class_add']		    = '添加分類';
$lang['groupbuy_class_edit']	    = '編輯分類';
$lang['groupbuy_class_name']	    = '分類名稱';
$lang['groupbuy_parent_class']	    = '父級分類';
$lang['groupbuy_root_class']	    = '一級分類';
$lang['groupbuy_area_list'] 		= '團購地區';
$lang['groupbuy_area_add']		    = '添加地區';
$lang['groupbuy_area_edit'] 	    = '編輯地區';
$lang['groupbuy_area_name'] 	    = '地區名稱';
$lang['groupbuy_parent_area']	    = '父級地區';
$lang['groupbuy_root_area'] 	    = '一級地區';
$lang['groupbuy_price_list']		= '團購價格區間';
$lang['groupbuy_price_add']		    = '添加價格區間';
$lang['groupbuy_price_edit']	    = '編輯價格區間';
$lang['groupbuy_price_name']	    = '價格區間名稱';
$lang['groupbuy_price_range_start']	    = '價格區間上限';
$lang['groupbuy_price_range_end']	    = '價格區間下限';
$lang['groupbuy_detail'] = '團購信息詳情';
$lang['range_name']	    = '價格區間名稱';
$lang['range_start']	    = '價格區間下限';
$lang['range_end']	    = '價格區間上限';
$lang['groupbuy_index_name']		= '團購名稱';
$lang['groupbuy_index_goods_name']	= '商品名稱';
$lang['groupbuy_index_store_name']	= '店舖名稱';
$lang['start_time']             	= '開始時間';
$lang['end_time']               	= '結束時間';
$lang['join_end_time']             	= '報名截止時間';
$lang['groupbuy_index_start_time']	= '開始時間';
$lang['groupbuy_index_end_time']	= '結束時間';
$lang['day']						= '日';
$lang['hour']						= '時';
$lang['groupbuy_index_state']		= '團購狀態';
$lang['groupbuy_index_pub_state']	= '發佈狀態';
$lang['groupbuy_index_click']		= '瀏覽數';
$lang['groupbuy_index_long_group']	= '長期活動';
$lang['groupbuy_index_un_pub']		= '未發佈';
$lang['groupbuy_index_canceled']	= '已取消';
$lang['groupbuy_index_going']		= '進行中';
$lang['groupbuy_index_finished']	= '已完成';
$lang['groupbuy_index_ended']		= '已結束';
$lang['groupbuy_index_published']	= '已發佈';
$lang['group_template'] = '團購活動';
$lang['group_name'] = '團購名稱';
$lang['store_name'] = '店舖名稱';
$lang['goods_name'] = '商品名稱';
$lang['group_help'] = '團購說明';
$lang['start_time'] = '開始時間';
$lang['end_time'] = '結束時間';
$lang['goods_price'] = '商品原價';
$lang['store_price'] = '商城價';
$lang['groupbuy_price'] = '團購價格';
$lang['limit_type'] = '限制類型';
$lang['virtual_quantity'] = '虛擬數量';
$lang['min_quantity'] = '成團數量';
$lang['sale_quantity'] = '限購數量';
$lang['max_num'] = '商品總數';
$lang['group_intro'] = '本團介紹';
$lang['group_pic'] = '團購圖片';
$lang['buyer_count'] = '已購買人數';
$lang['def_quantity'] = '已購商品數量';
$lang['base_info'] = '基本信息';


/**
 * 頁面說明
 **/
$lang['groupbuy_template_help1'] = '點擊活動的管理按鈕查看活動詳細信息，對團購申請進行審批管理';
$lang['groupbuy_template_help2'] = '未開始的活動可以直接刪除，刪除後該活動下的所有團購信息將被同時刪除';
$lang['groupbuy_template_help3'] = '活動開始後可以點擊關閉按鈕手動關閉該活動';
$lang['groupbuy_template_help4'] = '推薦團購商品到首頁，請到團購活動管理頁面點亮推薦列下的對勾';
$lang['groupbuy_template_add_help1'] = '活動時間不能重疊，新活動的開始時間必須大於已有活動的結束時間';
$lang['groupbuy_template_add_help2'] = '報名截止時間必須小於活動開始時間';
$lang['groupbuy_start_time_explain'] = '團購活動開始時間不能早于';
$lang['groupbuy_class_help1'] = '團購分類後台為2級分類，前台預設顯示1級，如需擴展需要二次開發';
$lang['groupbuy_area_help1'] = '團購地區後台為3級分類，前台預設顯示1級，如需擴展需要二次開發';
$lang['groupbuy_price_range_help1'] = '前台團購按價格篩選的區間，各個區間段的金額不要發生重疊';
$lang['groupbuy_index_help1']		= "點擊導航菜單中的'返回列表'連結返回活動列表頁";
$lang['groupbuy_index_help2']		= '團購信息審核後才會出現在前台頁面';
$lang['groupbuy_parent_class_add_tip'] = '請選擇父級分類，預設為一級分類';
$lang['groupbuy_parent_area_add_tip'] = '請選擇父級地區，預設為一級地區';
$lang['sort_tip'] = '排序數值從0到255，數字0優先順序最高';
$lang['price_range_tip'] = "區間名稱應該明確，比如'1000元以下'和'2000元-3000元'";
$lang['price_range_price_tip'] = '價格必須為正整數';

$lang['groupbuy_recommend_help1'] = '此頁面顯示的是已經通過審核的正在團購中的商品，只能進行推薦操作';

$lang['state_text_notstarted'] = '未開始';
$lang['state_text_in_progress'] = '進行中';
$lang['state_text_closed'] = '已關閉';

/**
 * 團購刪除
 */
$lang['groupbuy_del_choose']		= '請選擇要刪除的內容';
$lang['groupbuy_del_succ']			= '刪除成功';
$lang['groupbuy_del_fail']			= '刪除失敗';
/**
 * 團購推薦
 */
$lang['groupbuy_recommend_choose']	= '請選擇要推薦的內容';
$lang['groupbuy_recommend_succ']	= '推薦成功';
$lang['groupbuy_recommend_fail']	= '推薦失敗';


/**
 * 提示信息
 */
$lang['class_name_error'] = '分類名稱不能為空';
$lang['sort_error'] = '排序必須是數字';
$lang['area_name_error'] = '地區名稱不能為空';
$lang['verify_success'] = '審核通過';
$lang['verify_fail'] = '審核失敗';
$lang['ensure_verify_success'] = '確認審核通過該團購活動?';
$lang['ensure_verify_fail'] = '確認審核失敗該團購活動?';
$lang['op_close'] = '結束';
$lang['ensure_close'] = '確認結束該團購活動?';
$lang['template_name_error'] = '活動名稱不能為空';
$lang['start_time_error'] = '開始時間不能為空';
$lang['end_time_error'] = '結束時間不能為空，且必須大於開始時間';
$lang['join_end_time_error'] = '報名截止時間不能為空';
$lang['range_name_error'] = '價格區間名稱不能為空';
$lang['range_start_error'] = '價格區間上限不能為空且必須位數字';
$lang['range_end_error'] = '價格區間下限不能為空且必須位數字';
$lang['start_time_overlap'] = '團購活動時間有重疊請您重新選擇團購開始時間';
/**
 * 提示信息
 */

$lang['admin_groupbuy_unavailable'] = '團購功能尚未開啟，是否自動開啟';
$lang['groupbuy_template_add_success'] = '團購活動添加成功';
$lang['groupbuy_template_add_fail'] = '團購活動添加失敗';
$lang['groupbuy_tempalte_drop_success'] = '團購活動刪除成功';
$lang['groupbuy_template_drop_fail'] = '團購活動刪除失敗';
$lang['groupbuy_tempalte_close_success'] = '團購活動關閉成功';
$lang['groupbuy_template_close_fail'] = '團購活動關閉失敗';
$lang['groupbuy_verify_success'] = '團購審核操作成功';
$lang['groupbuy_verify_fail'] = '團購審核操作失敗';
$lang['groupbuy_close_success'] = '團購結束成功';
$lang['groupbuy_close_fail'] = '團購結束失敗';
$lang['groupbuy_class_add_success'] = '團購分類添加成功';
$lang['groupbuy_class_add_fail'] = '團購分類添加失敗';
$lang['groupbuy_class_edit_success'] = '團購分類編輯成功';
$lang['groupbuy_class_edit_fail'] = '團購分類編輯失敗';
$lang['groupbuy_class_drop_success'] = '團購分類刪除成功';
$lang['groupbuy_class_drop_fail'] = '團購分類刪除失敗';
$lang['groupbuy_area_add_success'] = '團購地區添加成功';
$lang['groupbuy_area_add_fail'] = '團購地區添加失敗';
$lang['groupbuy_area_edit_success'] = '團購地區編輯成功';
$lang['groupbuy_area_edit_fail'] = '團購地區編輯失敗';
$lang['groupbuy_area_drop_success'] = '團購地區刪除成功';
$lang['groupbuy_area_drop_fail'] = '團購地區刪除失敗';
$lang['groupbuy_price_range_add_success'] = '團購價格區間添加成功';
$lang['groupbuy_price_range_add_fail'] = '團購價格區間添加失敗';
$lang['groupbuy_price_range_edit_success'] = '團購價格區間編輯成功';
$lang['groupbuy_price_range_edit_fail'] = '團購價格區間編輯失敗';
$lang['groupbuy_price_range_drop_success'] = '團購價格區間刪除成功';
$lang['groupbuy_price_range_drop_fail'] = '團購價格區間刪除失敗';

$lang['groupbuy_close_confirm'] = '確認關閉團購活動？關閉後無法再次開啟。';
