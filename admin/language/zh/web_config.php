<?php
defined('InShopNC') or exit('Access Invalid!');

/**
 * 模板頁
 */
$lang['index_index_store_goods_price']		= '商城價';

/**
 * 列表頁和編輯頁
 */
$lang['web_config_index']			= '首頁配置';
$lang['web_config_index_help1']			= '排序越小越靠前，可以控制板塊顯示先後。';
$lang['web_config_index_help2']			= '色彩風格和前台的樣式一致，在基本設置中選擇更換。';
$lang['web_config_index_help3']			= '色彩風格是css樣式中已經有的，如果需要修改名稱則相關程序也要同時改變才會有效果。';
$lang['web_config_update_time']	= '更新時間';
$lang['web_config_web_name']				= '板塊名稱';
$lang['web_config_style_name']				= '色彩風格';
$lang['web_config_web_edit']				= '基本設置';
$lang['web_config_code_edit']				= '板塊編輯';
$lang['web_config_web_name_tips']				= '板塊名稱只在後台首頁模板設置中作為板塊標識出現，在前台首頁不顯示。';
$lang['web_config_style_name_tips']				= '選擇板塊色彩風格將影響商城首頁模板該區域的邊框、背景色、字型色彩，但不會影響板塊的內容佈局。';
$lang['web_config_style_red']				= '紅色';
$lang['web_config_style_pink']				= '粉色';
$lang['web_config_style_orange']				= '橘色';
$lang['web_config_style_green']				= '綠色';
$lang['web_config_style_blue']				= '藍色';
$lang['web_config_style_purple']				= '紫色';
$lang['web_config_style_brown']				= '褐色';
$lang['web_config_style_default']				= '默认';
$lang['web_config_add_name_null']				= '板塊名稱不能為空';
$lang['web_config_sort_int']		= '排序僅可以為數字';
$lang['web_config_sort_tips']	= '數字範圍為0~255，數字越小越靠前';

/**
 * 板塊編輯頁
 */
$lang['web_config_save']			= '保存';
$lang['web_config_web_html']			= '更新板塊內容';
$lang['web_config_edit_help1']			= '所有相關設置完成，使用底部的“更新板塊內容”前台展示頁面才會變化，活動圖片、廣告圖片可以選擇調用廣告。';
$lang['web_config_edit_help2']			= '左側的“推薦分類”沒有個數限制，但是如果太多會不顯示(已選擇的子分類可以拖動進行排序，單擊選中，雙擊刪除)。';
$lang['web_config_edit_help3']			= '中部的“商品推薦模組”由於頁面寬度只能加3個，商品數為6個；右側的排行個數為7個；底部的品牌最多為8個(已選擇的可以拖動進行排序，單擊選中，雙擊刪除)。';
$lang['web_config_edit_html']			= '板塊內容設置';
$lang['web_config_picture_tit']			= '標題圖片';
$lang['web_config_edit_category']			= '推薦分類';
$lang['web_config_category_name']			= '分類名稱';
$lang['web_config_gc_name']			= '子分類';
$lang['web_config_picture_act']			= '活動圖片';
$lang['web_config_add_recommend']			= '新增商品推薦模組';
$lang['web_config_recommend_max']			= '(最多3個)';
$lang['web_config_goods_order']			= '商品排行';
$lang['web_config_goods_name']			= '排行榜商品名稱';
$lang['web_config_goods_price']			= '價格';
$lang['web_config_picture_adv']			= '廣告圖片';
$lang['web_config_brand_list']			= '品牌推薦';

$lang['web_config_upload_tit']			= '標題圖片上傳';
$lang['web_config_prompt_tit']			= '請按照操作註釋要求，上傳設置板塊區域左上角的標題圖片。';
$lang['web_config_upload_tit_tips']			= '建議上傳210*72像素GIF\JPG\PNG格式圖片，超出規定範圍的圖片部分將被自動隱藏。';
$lang['web_config_upload_url']			= '圖片跳轉連結';
$lang['web_config_upload_url_tips']			= '輸入點擊該圖片後所要跳轉的連結地址或留空。';
$lang['web_config_category_title']			= '添加推薦分類';
$lang['web_config_category_note']			= '從分類下拉菜單中選擇該板塊要推薦的分類，選擇父級分類將包含字分類。';
$lang['web_config_category_tips']			= '小提示：雙擊分類名稱可刪除不想顯示的分類';

$lang['web_config_upload_act']			= '活動圖片上傳';
$lang['web_config_prompt_act']			= '請按照操作註釋要求，上傳設置板塊區域左下角的活動圖片。';
$lang['web_config_upload_type']			= '選擇類型';
$lang['web_config_upload_pic']			= '圖片上傳';
$lang['web_config_upload_adv']			= '廣告調用';
$lang['web_config_upload_act_tips']			= '建議上傳208*128像素GIF\JPG\PNG格式圖片，超出規定範圍的圖片部分將被自動隱藏。';
$lang['web_config_upload_act_url']			= '輸入點擊該圖片後所要跳轉的連結地址。';
$lang['web_config_upload_act_adv']			= '調用條件為：已啟用、寬度208像素、高度128像素、圖片類廣告。';

$lang['web_config_recommend_goods']			= '推薦商品';
$lang['web_config_recommend_title']			= '商品推薦模組標題名稱';
$lang['web_config_recommend_tips']			= '修改該區域中部推薦商品模組選項卡名稱，控制名稱字元在4-8字左右，超出範圍自動隱藏';
$lang['web_config_recommend_goods_tips']			= '小提示：單擊查詢出的商品選中，雙擊已選擇的可以刪除，最多6個，保存後生效。';
$lang['web_config_recommend_add_goods']			= '選擇要展示的推薦商品';
$lang['web_config_recommend_gcategory']			= '選擇分類';
$lang['web_config_recommend_goods_name']			= '商品名稱';

$lang['web_config_goods_order']			= '商品排行';
$lang['web_config_goods_order_title']			= '商品排行模組標題名稱';
$lang['web_config_goods_order_tips']			= '修改該區域中部推薦商品模組選項卡名稱，控制名稱字元在4-8字左右，超出範圍自動隱藏';
$lang['web_config_goods_list']			= '排行商品';
$lang['web_config_goods_list_tips']			= '小提示：單擊查詢出的商品選中，雙擊已選擇的可以刪除，最多7個，保存後生效。';
$lang['web_config_goods_order_add']			= '選擇要展示的排行商品';
$lang['web_config_goods_order_gcategory']			= '選擇分類';
$lang['web_config_goods_order_type']			= '排序方式';
$lang['web_config_goods_order_sale']			= '出售數量';
$lang['web_config_goods_order_click']			= '瀏覽數量';
$lang['web_config_goods_order_comment']			= '評論數量';
$lang['web_config_goods_order_collect']			= '收藏數量';
$lang['web_config_goods_order_name']			= '商品名稱';

$lang['web_config_brand_title']			= '推薦品牌';
$lang['web_config_brand_tips']			= '小提示：單擊候選品牌選中，雙擊已選擇的可以刪除，最多8個，保存後生效。';
$lang['web_config_brand_list']			= '候選推薦品牌列表';

$lang['web_config_upload_adv_tips']			= '請按照操作註釋要求，上傳設置板塊區域右下角的廣告圖片。';
$lang['web_config_upload_adv_pic']			= '廣告圖片上傳';
$lang['web_config_upload_pic_tips']			= '建議上傳210*100像素GIF\JPG\PNG格式圖片，超出規定範圍的圖片部分將被自動隱藏。';
$lang['web_config_upload_adv_url']			= '廣告跳轉連結';
$lang['web_config_upload_pic_url_tips']			= '輸入點擊該圖片後所要跳轉的連結地址';
$lang['web_config_adv_url_tips']			= '調用條件為：已啟用、寬度210像素、高度100像素、圖片類廣告。';