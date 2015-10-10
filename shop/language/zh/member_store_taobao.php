<?php
defined('InShopNC') or exit('Access Invalid!');

$lang['store_goods_index_goods_limit']			= '您已經達到了添加商品的上限';
$lang['store_goods_index_goods_limit1']			= '個，如果您想繼續增加商品，請到“店舖設置”升級店舖等級';
$lang['store_goods_index_pic_limit']			= '您已經達到了圖片空間的上限';
$lang['store_goods_index_pic_limit1']			= 'M，如果您想繼續增加商品，請到“店舖設置”升級店舖等級';
$lang['store_goods_index_time_limit']			= '您已經達到店舖使用期限，如果您想繼續增加商品，請到“店舖設置”升級店舖等級';
$lang['store_goods_index_no_pay_type']			= '平台還未設置支付方式，請及時與平台聯繫';
/**
 * 圖片上傳
 */
$lang['store_goods_upload_pic_limit']			= '您已經達到了圖片空間的上限';
$lang['store_goods_upload_pic_limit1']			= 'M，如果您想繼續增加商品，請到“店舖設置”升級店舖等級';
$lang['store_goods_upload_fail']				= '上傳失敗';
$lang['store_goods_upload_upload']				= '上傳';
$lang['store_goods_upload_normal']				= '普通上傳';
$lang['store_goods_upload_del_fail']			= '刪除圖片失敗';
$lang['store_goods_img_upload']					= '圖片上傳';

/**
 * 淘寶導入
 */
$lang['store_goods_import_choose_file']		= '請選擇要上傳csv的檔案';
$lang['store_goods_import_unknown_file']	= '檔案來源不明';
$lang['store_goods_import_wrong_type']		= '檔案類型必須為csv,您所上傳的檔案類型為:';
$lang['store_goods_import_size_limit']		= '檔案大小必須為'.ini_get('upload_max_filesize').'以內';
$lang['store_goods_import_wrong_class']		= '請選擇商品分類（必須選到最後一級）';
$lang['store_goods_import_wrong_class1']	= '該商品分類不可用，請重新選擇商品分類（必須選到最後一級）';
$lang['store_goods_import_wrong_class2']	= '必須選到最後一級';
$lang['store_goods_import_wrong_column']	= '檔案內欄位與系統要求的欄位不符,請詳細閲讀導入說明';
$lang['store_goods_import_choose']			= '請選擇...';
$lang['store_goods_import_step1']			= '第一步：導入CSV檔案';
$lang['store_goods_import_choose_csv']		= '請選擇檔案：';
$lang['store_goods_import_title_csv']		= '導入程序預設從第二行執行導入，請保留CSV檔案第一行的標題行，最大'.ini_get('upload_max_filesize');
$lang['store_goods_import_goods_class']		= '商品分類：';
$lang['store_goods_import_store_goods_class']	= '本店分類：';
$lang['store_goods_import_new_class']			= '新增分類';
$lang['store_goods_import_belong_multiple_store_class']	= '可以從屬於多個本店分類';
$lang['store_goods_import_unicode']			= '字元編碼：';
$lang['store_goods_import_file_type']		= '檔案格式：';
$lang['store_goods_import_file_csv']		= 'csv檔案';
$lang['store_goods_import_desc']			= '導入說明：';
$lang['store_goods_import_csv_desc']		= '1.如果修改CSV檔案請務必使用微軟excel軟件，且必須保證第一行表頭名稱含有如下項目: 
寶貝名稱、寶貝類目、新舊程度、寶貝價格、寶貝數量、有效期、運費承擔、平郵、EMS、快遞、櫥窗推薦、寶貝描述、新圖片。<br/>
2.如果因為淘寶助理版本差異表頭名稱有出入，請先修改成上述的名稱方可導入，不區分全新、二手、閒置等新舊程度，導入後商品類型都是全新。<br/>
3.如果CSV檔案超過'.ini_get('upload_max_filesize').'請通過excel軟件編輯拆成多個檔案進行導入。<br/>
4.每個商品最多支持導入5張圖片。';
$lang['store_goods_import_submit']			= '導入';
$lang['store_goods_import_step2']			= '第二步：上傳商品圖片';
$lang['store_goods_import_tbi_desc']		= '請上傳與csv檔案同級的images目錄(或與csv檔案同名的目錄)內的tbi檔案';
$lang['store_goods_import_upload_complete'] = "上傳完畢";
$lang['store_goods_import_doing'] 			= "正在導入...";
$lang['store_goods_import_step3']			= '第三步：整理數據';
$lang['store_goods_import_remind']			= '前兩步完成後才可進行數據整理，確認整理數據嗎';
$lang['store_goods_import_remind2']			= '（如果圖片分多次上傳，請在所有圖片上傳完成後整理）';
$lang['store_goods_import_pack']			= '整理數據';
$lang['store_goods_pack_wrong1']			= '請先導入CSV檔案';
$lang['store_goods_pack_wrong2']			= '請導入正確的CSV檔案';
$lang['store_goods_pack_success']			= '數據整理成功';
$lang['store_goods_import_end']				= '，最後';
$lang['store_goods_import_products_no_import']	= '件商品沒有導入';
$lang['store_goods_import_area']			= '所在地：';

/*淘寶檔案導入*/
$lang['store_goods_import_upload_album'] = '導入相冊選擇';
$lang['store_goods_index_batch_upload']	 = '批量上傳';

/**
 * ajax修改商品標題
 */
$lang['store_goods_title_change_tip']		= '單擊修改商品標題名稱，長度<br/>至少3個字元，最長50個漢字';

/**
 * ajax修改商品庫存
 */
$lang['store_goods_stock_change_stock']		= '修改庫存';
$lang['store_goods_stock_change_tip']		= '單擊修改庫存';
$lang['store_goods_stock_stock_sum']		= '庫存總數';
$lang['store_goods_stock_change_more_stock']= '修改更多的庫存信息';
$lang['store_goods_stock_input_error']		= '請填寫不小於零的數字!';

/**
 * ajax修改商品庫存
 */
$lang['store_goods_price_change_price']		= '修改價格';
$lang['store_goods_price_change_tip']		= '單擊修改價格';
$lang['store_goods_price_change_more_price']= '修改更多價格信息';
$lang['store_goods_price_input_error']		= '請填寫正確的價格！';

/**
 * ajax修改商品推薦
 */
$lang['store_goods_commend_change_tip']		= '選擇是否作為店舖推薦商品';

?>
