<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * index
 */
$lang['goods_class_index_choose_edit']		= '請選擇要編輯的內容';
$lang['goods_class_index_in_homepage']		= '首頁內';
$lang['goods_class_index_display']			= '顯示';
$lang['goods_class_index_hide']				= '隱藏';
$lang['goods_class_index_succ']				= '成功';
$lang['goods_class_index_choose_in_homepage']	= '請選擇首頁內要';
$lang['goods_class_index_content']				= '的內容!';
$lang['goods_class_index_class']				= '商品分類';
$lang['goods_class_index_export']				= '導出';
$lang['goods_class_index_import']				= '導入';
$lang['goods_class_index_tag']					= 'TAG管理';
$lang['goods_class_index_name']					= '分類名稱';
//$lang['goods_class_index_display_in_homepage']	= '首頁顯示';
$lang['goods_class_index_recommended']			= '推薦';
$lang['goods_class_index_ensure_del']			= '刪除該分類將會同時刪除該分類的所有下級分類，您確定要刪除嗎';
$lang['goods_class_index_display_tip']			= '首頁預設只顯示到二級分類';
$lang['goods_class_index_help1']				= '當店主添加商品時可選擇商品分類，用戶可根據分類查詢商品列表';
$lang['goods_class_index_help2']				= '點擊分類名前“+”符號，顯示當前分類的下級分類';
$lang['goods_class_index_help3'] 				= '<a>對分類作任何更改後，都需要到 設置 -> 清理緩存 清理商品分類，新的設置才會生效</a>';
/**
 * 批量編輯
 */
$lang['goods_class_batch_edit_succ']			= '批量編輯成功';
$lang['goods_class_batch_edit_wrong_content']	= '批量修改內容不正確';
$lang['goods_class_batch_edit_batch']	= '批量編輯';
$lang['goods_class_batch_edit_keep']	= '保持不變';
$lang['goods_class_batch_edit_again']	= '重新編輯該分類';
$lang['goods_class_batch_edit_ok']	= '編輯分類成功。';
$lang['goods_class_batch_edit_fail']	= '編輯分類失敗。';
$lang['goods_class_batch_edit_paramerror']	= '參數非法';
$lang['goods_class_batch_order_empty_tip']	= '，留空則保持不變';
/**
 * 添加分類
 */
$lang['goods_class_add_name_null']		= '分類名稱不能為空';
$lang['goods_class_add_sort_int']		= '分類排序僅能為數字';
$lang['goods_class_add_back_to_list']	= '返回分類列表';
$lang['goods_class_add_again']			= '繼續新增分類';
$lang['goods_class_add_name_exists']	= '該分類名稱已經存在了，請您換一個';
$lang['goods_class_add_sup_class']		= '上級分類';
$lang['goods_class_add_sup_class_notice']	= '如果選擇上級分類，那麼新增的分類則為被選擇上級分類的子分類';
$lang['goods_class_add_update_sort']	= '數字範圍為0~255，數字越小越靠前';
$lang['goods_class_add_display_tip']	= '分類名稱是否顯示';
$lang['goods_class_add_type']			= '類型';
$lang['goods_class_add_type_desc_one']	= '如果當前下拉選項中沒有適合的類型，可以去';
$lang['goods_class_add_type_desc_two']	= '功能中添加新的類型';
$lang['goods_class_edit_prompts_one']	= '"類型"關係到商品發佈時商品規格的添加，沒有類型的商品分類的將不能添加規格。';
$lang['goods_class_edit_prompts_two']	= '預設勾選"關聯到子分類"將商品類型附加到子分類，如子分類不同於上級分類的類型，可以取消勾選並單獨對子分類的特定類型進行編輯選擇。';
$lang['goods_class_edit_related_to_subclass']	= '關聯到子分類';
/**
 * 分類導入
 */
$lang['goods_class_import_csv_null']	= '導入的csv檔案不能為空';
$lang['goods_class_import_data']		= '導入數據';
$lang['goods_class_import_choose_file']	= '請選擇檔案';
$lang['goods_class_import_file_tip']	= '如果導入速度較慢，建議您把檔案拆分為幾個小檔案，然後分別導入';
$lang['goods_class_import_choose_code']	= '請選擇檔案編碼';
$lang['goods_class_import_code_tip']	= '如果檔案較大，建議您先把檔案轉換為 utf-8 編碼，這樣可以避免轉換編碼時耗費時間';
$lang['goods_class_import_file_type']	= '檔案格式';
$lang['goods_class_import_first_class']	= '一級分類';
$lang['goods_class_import_second_class']		= '二級分類';
$lang['goods_class_import_third_class']			= '三級分類';
$lang['goods_class_import_example_download']	= '例子檔案下載';
$lang['goods_class_import_example_tip']			= '點擊下載導入例子檔案';
$lang['goods_class_import_import']				= '導入';
/**
 * 分類導出
 */
$lang['goods_class_export_data']		= '導出數據';
$lang['goods_class_export_if_trans']	= '導出您的商品分類數據';
$lang['goods_class_export_trans_tip']	= '';
$lang['goods_class_export_export']		= '導出';
$lang['goods_class_export_help1']		= '導出內容為商品分類信息的.csv檔案';
/**
 * TAG index
 */
$lang['goods_class_tag_name']			= 'TAG名稱';
$lang['goods_class_tag_value']			= 'TAG值';
$lang['goods_class_tag_update']			= '更新TAG名稱';
$lang['goods_class_tag_update_prompt']	= '更新TAG名稱需要話費較長的時間，請耐心等待。';
$lang['goods_class_tag_reset']			= '導入/重置TAG';
$lang['goods_class_tag_reset_confirm']	= '您確定要重新導入TAG嗎？重新導入將會重置所有TAG值信息。';
$lang['goods_class_tag_prompts_two']	= 'TAG值是分類搜索的關鍵字，請精確的填寫TAG值。TAG值可以填寫多個，每個值之間需要用逗號隔開。';
$lang['goods_class_tag_prompts_three']	= '導入/重置TAG功能可以根據商品分類重新更新TAG，TAG值預設為各級商品分類值。';
$lang['goods_class_tag_choose_data']	= '請選擇要操作的數據項。';
/**
 * 重置TAG
 */
$lang['goods_class_reset_tag_fail_no_class']	= '重置TAG失敗，沒查找到任何分類信息。';
/**
 * 更新TAG名稱
 */
$lang['goods_class_update_tag_fail_no_class']	= 'TAG名稱更新失敗，沒查找到任何分類信息。';
/**
 * 刪除TAG
 */
$lang['goods_class_tag_del_confirm']= '你確定要刪除商品分類TAG嗎?';