<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 共有語言
 */

/**
 * index
 */
$lang['store_goods_index_store_close']	 		= '您的店舖已關閉';
$lang['store_goods_index_taobao_import']		= '淘寶助理導入';
$lang['store_goods_index_new_goods']			= '新增商品';
$lang['store_goods_index_add_goods']			= '發佈新商品';
$lang['store_goods_index_add_time']				= '發佈時間';
$lang['store_goods_index_store_goods_class']	= '本店分類';
$lang['store_goods_index_state']	 			= '狀態';
$lang['store_goods_index_show']	 				= '上架';
$lang['store_goods_index_unshow']	 			= '下架';
$lang['store_goods_index_recommend']	 		= '推薦';
$lang['store_goods_index_lock']	 				= '禁售';
$lang['store_goods_index_unlock']	 			= '否';
$lang['store_goods_index_close_reason']			= '違規禁售原因';
$lang['store_goods_close_reason_des']			= '分類或規格信息不符';
$lang['store_goods_index_sort']					= '排序';
$lang['store_goods_index_goods_name']	 		= '商品名稱';
$lang['store_goods_index_goods_name_help']	 	= '商品標題名稱長度至少3個字元，最長50個漢字';
$lang['store_goods_index_goods_class']	 		= '商品分類';
$lang['store_goods_index_brand']	 			= '品牌';
$lang['store_goods_index_price']	 			= '價格';
$lang['store_goods_index_stock']				= '庫存';
$lang['store_goods_index_goods_limit']			= '您已經達到了添加商品的上限';
$lang['store_goods_index_goods_limit1']			= '個，如果您想繼續增加商品，請到“店舖設置”升級店舖等級';
$lang['store_goods_index_pic_limit']			= '您已經達到了圖片空間的上限';
$lang['store_goods_index_pic_limit1']			= 'M，如果您想繼續增加商品，請到“店舖設置”升級店舖等級';
$lang['store_goods_index_time_limit']			= '您已經達到店舖使用期限，如果您想繼續增加商品，請到“店舖設置”升級店舖等級';
$lang['store_goods_index_no_pay_type']			= '平台還未設置支付方式，請及時與平台聯繫';
$lang['store_goods_index_color']				= '顏色';
$lang['store_goods_index_size']					= '尺碼';
$lang['store_goods_index_left']					= '排序向前';
$lang['store_goods_index_right']				= '排序向後';
$lang['store_goods_index_face']					= '設為封面';
$lang['store_goods_index_insert_editor']		= '插入編輯器';
$lang['store_goods_index_goods_class_null']		= '商品分類不能為空';
$lang['store_goods_index_goods_class_error']	= '選擇商品分類（必須選到最後一級）';
$lang['store_goods_index_goods_name_null']		= '商品名稱不能為空';
$lang['store_goods_index_store_price_null']		= '商品價格不能為空';
$lang['store_goods_index_store_price_error']	= '商品價格只能是數字';
$lang['store_goods_index_store_price_interval']	= '商品價格必須是0.01~9999999之間的數字';
$lang['store_goods_index_goods_stock_null']		= '商品庫存不能為空';
$lang['store_goods_index_goods_stock_error']	= '庫存只能填寫數字';
$lang['store_goods_index_edit_goods_spec']		= '編輯商品規格';
$lang['store_goods_index_goods_spec_tip']		= '您最多可以添加兩種規格（如：顏色和尺碼）規格名稱可以自定義<br/>兩種規格必須填寫完整';
$lang['store_goods_index_no']					= '貨號';
$lang['store_goods_index_new_goods_spec']		= '添加新的規格屬性';
$lang['store_goods_index_save_spec']			= '保存規格';
$lang['store_goods_index_new_class']			= '新增分類';
$lang['store_goods_index_belong_multiple_store_class']	= '商品可以從屬於店舖的多個分類之下，店舖分類可以由 "商家中心 -> 店舖 -> 店舖分類" 中自定義';
$lang['store_goods_index_goods_base_info']		= '商品基本信息';
$lang['store_goods_index_goods_detail_info']	= '商品詳情描述';
$lang['store_goods_index_goods_transport']		= '商品物流信息';
$lang['store_goods_index_goods_szd']			= '所在地';
$lang['store_goods_index_use_tpl']				= '使用運費模板';
$lang['store_goods_index_select_tpl']			= '選擇運費模板';
$lang['store_goods_index_goods_other_info']		= '其他信息';
$lang['store_goods_index_upload_goods_pic']		= '上傳商品圖片';
$lang['store_goods_index_remote_url']			= '遠程地址';
$lang['store_goods_index_remote_tip']			= '支持JPEG和靜態的GIF格式圖片，不支持GIF動畫圖片，上傳圖片大小不能超過2M.瀏覽檔案時可以按住ctrl或shift鍵多選';
$lang['store_goods_index_goods_brand']			= '商品品牌';
$lang['store_goods_index_multiple_tag']			= '多個Tag標籤請用半形逗號 "," 隔開';
$lang['store_goods_index_store_price']			= '商品價格';
$lang['store_goods_index_store_price_help']		= '商品價格必須是0.01~9999999之間的數字<br/>若啟用了庫存配置，請在下方商品庫存區域進行管理<br/>商品規格庫存表中如有價格差異，店舖價格顯示為價格區間形式';
$lang['store_goods_index_goods_stock']			= '商品庫存';
$lang['store_goods_index_goods_stock_checking']	= '商舖庫存數量必須為0~999999999之間的整數';
$lang['store_goods_index_goods_stock_help']		= '商舖庫存數量必須為0~999999999之間的整數<br/>若啟用了庫存配置，則系統自動計算商品的總數，此處無需賣家填寫';
$lang['store_goods_index_goods_pyprice_null']	= '缺少平郵價格';
$lang['store_goods_index_goods_kdprice_null']	= '缺少快遞價格';
$lang['store_goods_index_goods_emsprice_error']	= 'EMS價格格式錯誤';
$lang['store_goods_index_goods_select_tpl']		= '請選擇要使用的運費模板';
$lang['store_goods_index_goods_weight_tag']     = '單位：千克(Kg)';
$lang['store_goods_index_goods_transfee_charge']= '運費';
$lang['store_goods_index_goods_transfee_charge_seller']= '賣家承擔運費';
$lang['store_goods_index_goods_transfee_charge_buyer']= '買家承擔運費';
$lang['store_goods_index_goods_no']				= '商品貨號';
$lang['store_goods_index_goods_no_help']		= '商品貨號是指商家管理商品的編號，買家不可見<br/>最多可輸入20個字元，支持輸入中文、字母、數字、_、/、-和小數點';
$lang['srore_goods_index_goods_stock_set']		= '庫存配置';
$lang['store_goods_index_goods_spec']			= '商品規格';
$lang['store_goods_index_open_spec']			= '開啟規格';
$lang['store_goods_index_spec_tip']				= '您最多可以添加兩種商品規格（如：顏色，尺碼）如商品沒有規格則不用添加';
$lang['store_goods_index_edit_spec']			= '編輯規格';
$lang['store_goods_index_close_spec']			= '關閉規格';
$lang['store_goods_index_goods_attr']			= '商品屬性';
$lang['store_goods_index_goods_show']			= '商品發佈';
$lang['store_goods_index_immediately_sales']	= '立即發佈';
$lang['store_goods_index_in_warehouse']			= '放入倉庫';
$lang['store_goods_index_goods_recommend']		= '商品推薦';
$lang['store_goods_index_recommend_tip']		= '被推薦的商品會顯示在店舖首頁';
$lang['store_goods_index_goods_desc']			= '商品描述';
$lang['store_goods_index_upload_pic']			= '上傳圖片';
$lang['store_goods_index_spec']					= '規格';
$lang['store_goods_index_edit_goods']			= '編輯商品';
$lang['store_goods_index_add_sclasserror']		= '該分類已經選擇,請選擇其他分類';
$lang['store_goods_index_goods_add_success']	= '商品添加成功';
$lang['store_goods_index_goods_add_fail']		= '商品添加失敗';
$lang['store_goods_index_goods_edit_success']	= '商品編輯成功';
$lang['store_goods_index_goods_edit_fail']		= '商品編輯失敗';
$lang['store_goods_index_goods_del_success']	= '商品刪除成功';
$lang['store_goods_index_goods_del_fail']		= '商品刪除失敗';
$lang['store_goods_index_goods_unshow_success']	= '商品下架成功';
$lang['store_goods_index_goods_unshow_fail']	= '商品下架失敗';
$lang['store_goods_index_goods_show_success']	= '商品上架成功';
$lang['store_goods_index_goods_show_fail']		= '商品上架失敗';
$lang['store_goods_index_goods_seo_keywords']		    = 'SEO關鍵字<br/>(keywords)';
$lang['store_goods_index_goods_seo_description']		= 'SEO描述<br/>(description)';
$lang['store_goods_index_goods_seo_keywords_help']		= 'SEO關鍵字 (keywords) 出現在商品詳細頁面頭部的 Meta 標籤中，<br/>用於記錄本頁面商品的關鍵字，多個關鍵字間請用半形逗號 "," 隔開';
$lang['store_goods_index_goods_seo_description_help']   = 'SEO描述 (description) 出現在商品詳細頁面頭部的 Meta 標籤中，<br/>用於記錄本頁面商品內容的概要與描述，建議120字以內';
$lang['store_goods_index_goods_del_confirm']			= '您確實要刪除該圖片嗎?';
$lang['store_goods_index_goods_not_add']				= '不能再添加圖片';
$lang['store_goods_index_goods_the_same']				= '不能再重複圖片';
$lang['store_goods_index_default_album']				= '預設相冊';
$lang['store_goods_index_flow_chart_step1']				= '選擇商品所在分類';
$lang['store_goods_index_flow_chart_step2']				= '填寫商品詳細信息';
$lang['store_goods_index_flow_chart_step3']				= '商品發佈成功';
$lang['store_goods_index_again_choose_category1']		= '您選擇的分類不存在，或沒有選擇到最後一級，請重新選擇分類。';
$lang['store_goods_add_next']							= '下一步';
$lang['store_goods_step2_image']						= '圖片（無圖片可不填）';
$lang['store_goods_step2_start_time']					= '發佈時間';
$lang['store_goods_step2_hour']							= '時';
$lang['store_goods_step2_minute']						= '分';
$lang['store_goods_step2_goods_form']					= '商品類型';
$lang['store_goods_step2_brand_new']					= '全新';
$lang['store_goods_step2_second_hand']					= '二手';
$lang['store_goods_step2_exist_image']					= '已有圖片';
$lang['store_goods_step2_exist_image_null']				= '當前無圖片';
$lang['store_goods_step2_spec_img_help']				= '支持jpg、jpeg、gif、png格式圖片。<br />建議上傳尺寸310x310、大小%.2fM內的圖片。<br />商品詳細頁選中顏色圖片後，顏色圖片將會在商品展示圖區域展示。';
$lang['store_goods_step2_description_one']				= '最多可發佈5張商品圖片。';
$lang['store_goods_step2_description_two']				= '支持圖片上傳、從用戶空間添加兩種方式發佈。支持jpg、jpeg、gif、png格式圖片，建議上傳尺寸300x300以上、大小%.2fM內的圖片，上傳圖片將會自動保存在用戶圖片空間的預設分類中。';
$lang['store_goods_step2_description_three']			= '圖片可以通過兩側的箭頭調整顯示順序。';
$lang['store_goods_album_climit']						= '您上傳圖片數達到上限，請升級您的店舖或跟管理員聯繫';
/**
 * 商品發佈第一步
 */
$lang['store_goods_step1_search_category']				= '分類搜索：';
$lang['store_goods_step1_search_input_text']			= '請輸入商品名稱或分類屬性名稱';
$lang['store_goods_step1_search']						= '搜索';
$lang['store_goods_step1_return_choose_category']		= '返回商品分類選擇';
$lang['store_goods_step1_search_null']					= '沒有找到相關的商品分類。';
$lang['store_goods_step1_searching']					= '搜索中...';
$lang['store_goods_step1_loading']						= '加載中...';
$lang['store_goods_step1_choose_common_category']		= '您常用的商品分類：';
$lang['store_goods_step1_please_select']				= '請選擇';
$lang['store_goods_step1_no_common_category']			= '您還沒有添加過常用的分類';
$lang['store_goods_step1_please_choose_category']		= '請選擇商品類別';
$lang['store_goods_step1_current_choose_category']		= '您當前選擇的商品類別是';
$lang['store_goods_step1_add_common_category']			= '[添加到常用分類]';
$lang['store_goods_step1_max_20']						= '只能添加20個常用分類，請清理不常用或重複的分類。';
$lang['store_goods_step1_ajax_add_class']				= '添加常用分類成功';

/**
 * 商品發佈第三步
 */
$lang['store_goods_step3_goods_release_success']		= '恭喜您，商品發佈成功！';
$lang['store_goods_step3_viewed_product']				= '去店舖查看商品詳情';
$lang['store_goods_step3_edit_product']					= '重新編輯剛發佈的商品';
$lang['store_goods_step3_more_actions']					= '您還可以:';
$lang['store_goods_step3_continue']						= '繼續';
$lang['store_goods_step3_release_new_goods']			= '發佈新商品';
$lang['store_goods_step3_access']						= '進入';
$lang['store_goods_step3_manage']						= '管理';
$lang['store_goods_step3_choose_product_add']			= '選擇商品添加申請';
$lang['store_goods_step3_participation']				= '參與商城的';
$lang['store_goods_step3_special_activities']			= '專題活動';

/**
 * 品牌
 */
$lang['store_goods_brand_apply']				= '品牌申請';
$lang['store_goods_brand_name']					= '品牌名稱';
$lang['store_goods_brand_my_applied']			= '我申請的';
$lang['store_goods_brand_icon']					= '品牌表徵圖';
$lang['store_goods_brand_belong_class']			= '所屬類別';
$lang['store_goods_brand_no_record']			= '沒有符合條件的品牌';
$lang['store_goods_brand_input_name']			= '請輸入品牌名稱';
$lang['store_goods_brand_name_error']			= '品牌名稱不能超過100個字元';
$lang['store_goods_brand_icon_null']			= '請上傳品牌表徵圖';
$lang['store_goods_brand_edit']					= '編輯品牌';
$lang['store_goods_brand_class']				= '品牌類別';
$lang['store_goods_brand_pic_upload']			= '圖片上傳';
$lang['store_goods_brand_upload_tip']			= '建議上傳大小為88x44的品牌圖片。<br />申請品牌的目的是方便買家通過品牌索引頁查找商品，申請時請填寫品牌所屬的類別，方便站長歸類。在站長審核前，您可以編輯或撤銷申請。';
$lang['store_goods_brand_name_null']			= '品牌名稱不能為空';
$lang['store_goods_brand_apply_success']		= '保存成功，請等待系統審核';
$lang['store_goods_brand_choose_del_brand']		= '請選擇要刪除的內容!';
$lang['store_goods_brand_browse']				= '瀏覽...';
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
 * 相冊
 */
$lang['store_goods_album_goods_pic']			= '商品圖片';
$lang['store_goods_album_select_from_album']	= '從用戶相冊選擇';
$lang['store_goods_album_users']				= '用戶相冊';
$lang['store_goods_album_all_photo']			= '全部圖片';
$lang['store_goods_album_insert_users_photo']	= '插入相冊圖片';
/**
 * ajax
 */
$lang['store_goods_ajax_find_none_spec']		= '未找到商品規格';
$lang['store_goods_ajax_update_fail']			= '更新資料庫失敗';
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
