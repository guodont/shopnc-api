<?php
defined('InShopNC') or exit('Access Invalid!');
$lang['microshop_not_install'] = '您沒有安裝微商城模組';

$lang['microshop_member'] = '用戶';
$lang['microshop_channel'] = '頻道';
$lang['microshop_commend'] = '推薦';
$lang['microshop_text_id'] = '編號';

$lang['microshop_class_name'] = '分類名稱';
$lang['microshop_parent_class'] = '上級分類';
$lang['microshop_class_image'] = '分類圖片';
$lang['microshop_class_keyword'] = '分類關鍵字';

$lang['microshop_goods_class_binding'] = '綁定分類';
$lang['microshop_goods_class_binding_select'] = '選擇分類';
$lang['microshop_goods_class_binded'] = '已綁定分類';
$lang['goods_relation_save_success'] = '綁定分類保存成功';
$lang['goods_relation_save_fail'] = '綁定分類保存失敗';
$lang['microshop_goods_class_default'] = '設為預設';

//分類表單
$lang['class_parent_id_error'] = '分類上級編號錯誤';
$lang['class_name_error'] = '分類名稱名稱不能為空且必須小於10個字元';
$lang['class_name_required'] = '分類名稱不能為空';
$lang['class_name_maxlength'] = '分類名稱最多個{0}字元';
$lang['class_keyword_maxlength'] = '分類關鍵字最多個{0}字元';
$lang['class_keyword_explain'] = '分類關鍵字用英文逗號分隔，如果需要高亮顯示在關鍵字前加"*"，例："褲子,*鞋子"';
$lang['class_sort_explain'] = '數字範圍為0~255，數字越小越靠前';
$lang['class_sort_error'] = '分類排序必須為0~055之間的數字';
$lang['class_sort_required'] = '排序不能為空';
$lang['class_sort_digits'] = '排序必須為數字';
$lang['class_sort_max'] = '排序最大為{0}';
$lang['class_sort_min'] = '排序最小為{0}';
$lang['class_add_success'] = '分類保存成功';
$lang['class_add_fail'] = '分類保存失敗';
$lang['class_drop_success'] = '分類刪除成功';
$lang['class_drop_fail'] = '分類刪除失敗';
$lang['microshop_sort_error'] = '排序必須為0~055之間的數字';

//微商城管理
$lang['microshop_isuse'] = '微商城開關';
$lang['microshop_isuse_explain'] = '關閉後微商城前台將無法訪問';
$lang['microshop_url'] = '微商城地址';
$lang['microshop_url_explain'] = '如果微商城配置了二級域名，在此填寫後商城中的微商城連結使用二級域名，如果留空使用預設地址';
$lang['microshop_style'] = '微商城主題';
$lang['microshop_style_explain'] = '設置微商城主題，預設為default';
$lang['microshop_header_image'] = '微商城頭部圖片';
$lang['microshop_personal_limit'] = '個人秀數量限制';
$lang['microshop_personal_limit_explain'] = '會員發佈個人秀的數量限制，0為不限制';
$lang['taobao_api_isuse'] = '淘寶介面開關';
$lang['taobao_api_isuse_explain'] = '開啟並填寫正確的介面參數後，發佈個人秀時購買連結支持淘寶和天貓';
$lang['taobao_app_key'] = '淘寶應用標識';
$lang['taobao_app_key_explain'] = '立即在綫申請';
$lang['taobao_secret_key'] = '淘寶應用密鑰';
$lang['microshop_seo_keywords'] = '微商城SEO關鍵字';
$lang['microshop_seo_description'] = '微商城SEO描述';

//隨心看
$lang['microshop_goods_name'] = '商品名稱';
$lang['microshop_goods_image'] = '商品圖片';
$lang['microshop_commend_time'] = '推薦時間';
$lang['microshop_commend_message'] = '推薦說明';
$lang['microshop_goods_tip1'] = '通過修改排序數字可以控制前台隨心看的顯示順序，數字越小越靠前';
$lang['microshop_goods_tip2'] = '點亮推薦列的符號，該商品將推薦到微商城首頁';
$lang['microshop_goods_class_tip1'] = '通過修改排序數字可以控制前台隨心看分類的顯示順序，數字越小越靠前';
$lang['microshop_goods_class_tip2'] = '點亮推薦列的符號，該分類將推薦到微商城首頁';
$lang['microshop_goods_class_tip3'] = '點擊行首的"+"號，可以展開下級分類';
$lang['microshop_goods_class_tip4'] = '點擊二級分類後的"綁定分類"按鈕可以綁定微商城和商城系統的分類，綁定後推薦的隨心看商品將自動匹配分類';
$lang['microshop_goods_class_tip5'] = '點擊二級分類後的"設為預設"按鈕可以設定微商城的預設分類，隨心看發佈的商城中未綁定分類都將使用預設分類';
$lang['microshop_goods_class_binding_tip1'] = '選擇下方的商城分類後單擊完成綁定，綁定後推薦的隨心看商品將自動匹配分類';
$lang['microshop_goods_class_binding_tip2'] = '滑鼠移到已綁定的分類上，點擊右上角的"x"可以刪除綁定';

$lang['microshop_personal_tip1'] = '通過修改排序數字可以控制前台隨心看的顯示順序，數字越小越靠前';
$lang['microshop_personal_tip2'] = '點亮推薦列的符號，該商品將推薦到微商城首頁';

//店舖
$lang['microshop_store_add_confirm'] = '確認添加該店舖到店舖街?';
$lang['microshop_store_goods_count'] = '商品數';
$lang['microshop_store_credit'] = '賣家信用';
$lang['microshop_store_praise_rate'] = '好評率';
$lang['microshop_store_add'] = '已添加';
$lang['microshop_store_tip1'] = '通過修改排序數字可以控制前台店舖街的顯示順序，數字越小越靠前';
$lang['microshop_store_tip2'] = '點亮推薦列的符號，該店舖將推薦到微商城首頁，首頁最多顯示15個推薦店舖';
$lang['microshop_store_add_tip1'] = '點擊"添加"按鈕將商城店舖添加到微商城的店舖街';

//評論
$lang['microshop_comment_id'] = '評論編號';
$lang['microshop_comment_object_id'] = '對象編號';
$lang['microshop_comment_message'] = '評論內容';
$lang['microshop_comment_tip1'] = '點擊"刪除"按鈕將刪除對應的評論';

//廣告
$lang['microshop_adv_type'] = '廣告類型';
$lang['microshop_adv_name'] = '廣告名稱';
$lang['microshop_adv_image'] = '廣告圖片';
$lang['microshop_adv_url'] = '廣告連結';
$lang['microshop_adv_type_index'] = '首頁幻燈';
$lang['microshop_adv_type_store_list'] = '店舖列表頁幻燈';
$lang['microshop_adv_image_error'] = '廣告圖片不能為空';
$lang['microshop_adv_tip1'] = '通過修改排序數字可以控制前台廣告的顯示順序，數字越小越靠前';
$lang['microshop_adv_type_explain'] = '選擇對應的廣告位置';
$lang['microshop_adv_image_explain'] = '首頁廣告圖片推薦尺寸700px*280px，店舖列表頁廣告圖片推薦尺寸1000px*250px';
$lang['microshop_adv_url_explain'] = '廣告對應的連結地址';


