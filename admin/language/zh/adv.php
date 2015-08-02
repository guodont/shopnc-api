<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 導航及全局
 */
$lang['adv_index_manage']	= '廣告';
$lang['adv_manage']	= '廣告';
$lang['adv_add']	= '新增廣告';
$lang['ap_manage']	= '廣告位';
$lang['ap_add']	    = '新增廣告位';
$lang['adv_change']	= '修改廣告';
$lang['ap_change']	= '修改廣告位';
$lang['adv_pic']	= '圖片';
$lang['adv_word']	= '文字';
$lang['adv_slide']	= '幻燈';
$lang['adv_edit']	= '編輯';
$lang['adv_change']	= '修改';
$lang['adv_pix']	= '像素';
$lang['adv_edit_support'] = '系統支持的圖片格式為:';
$lang['adv_cache_refresh'] = '清理緩存';
$lang['adv_cache_refresh_done'] = '廣告緩存清理完畢';
/**
 * 廣告
 */
$lang['adv_name']	         = '廣告名稱';
$lang['adv_ap_id']	         = '所屬廣告位';
$lang['adv_class']	         = '類別';
$lang['adv_start_time']	     = '開始時間';
$lang['adv_end_time']	     = '結束時間';
$lang['adv_all']	         = '全部';
$lang['adv_overtime']	     = '已過期';
$lang['adv_not_overtime']	 = '未過期';
$lang['adv_img_upload']	     = '圖片上傳';
$lang['adv_url']	         = '連結地址';
$lang['adv_url_donotadd']	 = '連結地址請不要加http://';
$lang['adv_word_content']	 = '文字內容';
$lang['adv_max']	         = '最多';
$lang['adv_byte']	         = '個字';
$lang['adv_slide_upload']	 = '幻燈片圖片上傳';
$lang['adv_slide_sort']	     = '幻燈片排序';
$lang['adv_slide_sort_role'] = '數字越小排序越靠前';
$lang['adv_ap_select']       = '選擇廣告位';
$lang['adv_search_from']     = '發佈時間';
$lang['adv_search_to']	     = '到';
$lang['adv_click_num']	     = '點擊數ˇ';
$lang['adv_admin_add']	     = '管理員添加';
$lang['adv_owner']	         = '廣告主';
$lang['adv_wait_check']	     = '待審核廣告';
$lang['adv_flash_upload']	 = 'Flash檔案上傳';
$lang['adv_please_upload_swf_file']	 = '請上傳swf格式檔案';
$lang['adv_help1']			 = '添加廣告時，需要指定所屬廣告位';
$lang['adv_help2']			 = '將廣告位調用代碼放入前台頁面，將顯示該廣告位的廣告';
$lang['adv_help3']			 = '店主可使用金幣購買廣告';
$lang['adv_help4']			 = '審核店主購買的廣告';
$lang['adv_help5']			 = '點擊查看，在詳細頁可進行審核操作';

/**
 * 廣告位
 */
$lang['ap_name']	         = '名稱';
$lang['ap_intro']	         = '簡介';
$lang['ap_class']	         = '類別';
$lang['ap_show_style']	     = '展示方式';
$lang['ap_width']	         = '寬度/字數';
$lang['ap_height']	         = '高度';
$lang['ap_price']	         = '單價(金幣/月)';
$lang['ap_show_num']	     = '正在展示';
$lang['ap_publish_num']	     = '已發佈';
$lang['ap_is_use']	         = '是否啟用';
$lang['ap_slide_show']	     = '幻燈片輪播';
$lang['ap_mul_adv']	         = '多廣告展示';
$lang['ap_one_adv']	         = '單廣告展示';
$lang['ap_use']	             = '已啟用';
$lang['ap_not_use']	         = '未啟用';
$lang['ap_get_js']	         = '代碼調用';
$lang['ap_use_s']	         = '啟用';
$lang['ap_not_use_s']	     = '不啟用';
$lang['ap_price_name']	     = '單價';
$lang['ap_price_unit']	     = '枚金幣/月';
$lang['ap_allow_mul_adv']	 = '可以發佈多條廣告並隨機展示';
$lang['ap_allow_one_adv']	 = '只允許發佈並展示一條廣告';
$lang['ap_width_l']	         = '寬度';
$lang['ap_height_l']	     = '高度';
$lang['ap_word_num']	     = '字數';
$lang['ap_select_showstyle'] = '選擇此廣告位廣告的形式';
$lang['ap_click_num']	     = '點擊數';
$lang['ap_help1']			 = '廣告位添加完成後可以選擇是否啟用廣告位';
/**
 * 提示信息
 */
$lang['adv_can_not_null']	    = '名稱不能為空';
$lang['must_select_ap']	        = '必須選擇一個廣告位';
$lang['must_select_start_time'] = '必須選擇開始時間';
$lang['must_select_end_time']	= '必須選擇結束時間';
$lang['must_select_ap_id']		= '請選擇廣告位';
$lang['textadv_null_error']		= '請添加文字內容';
$lang['slideadv_null_error']	= '請上傳幻燈片圖片';
$lang['slideadv_sortnull_error']	= '請添加幻燈片排序';
$lang['flashadv_null_error']	= '請上傳FLASH檔案';
$lang['picadv_null_error']		= '請上傳圖片';
$lang['wordadv_toolong']	    = '廣告的文字信息過長';
$lang['goback_adv_manage']	    = '返回廣告管理';
$lang['resume_adv_add']	        = '繼續添加廣告';
$lang['resume_ap_add']	        = '繼續添加廣告位';
$lang['adv_add_succ']	        = '添加成功';
$lang['adv_add_fail']	        = '添加失敗';
$lang['ap_add_succ']	        = '添加成功';
$lang['ap_add_fail']	        = '廣告位添加失敗';
$lang['goback_ap_manage']	    = '返回廣告位管理';
$lang['ap_stat_edit_fail']	    = '廣告位狀態修改失敗';
$lang['ap_del_fail']	        = '刪除廣告位失敗';
$lang['ap_del_succ']	        = '廣告位成功刪除，請即時處理相關模板的廣告位js調用';
$lang['adv_del_fail']	        = '刪除廣告失敗';
$lang['adv_del_succ']	        = '廣告成功刪除';
$lang['ap_can_not_null']	    = '廣告位名稱不能為空';
$lang['adv_url_can_not_null']	    = '廣告連結地址不能為空';
$lang['ap_price_can_not_null']	= '廣告位價格不能為空';
$lang['ap_input_digits_pixel']		= '請輸入像素值(正整數)';
$lang['ap_input_digits_words']		= '請輸入文字個數(正整數)';
$lang['ap_default_word_can_not_null'] = '預設文字不能為空';
$lang['adv_start_time_can_not_null']	= '廣告開始時間不能為空';
$lang['adv_end_time_can_not_null']	= '廣告結束時間不能為空';
$lang['ap_w&h_can_not_null']	= '廣告位寬度和高度不能為空';
$lang['ap_display_can_not_null']	= '廣告位展示方式必須選擇';
$lang['ap_wordnum_can_not_null']	= '廣告位字數不能為空';
$lang['ap_price_must_num']	    = '廣告位價格只能為數字形式';
$lang['ap_width_must_num']	    = '廣告位寬度只能為數字形式';
$lang['ap_wordwidth_must_num']	= '廣告位字數只能為數字形式';
$lang['ap_height_must_num']	    = '廣告位高度只能為數字形式';
$lang['ap_change_succ']	        = '廣告位信息修改成功';
$lang['ap_change_fail']	        = '廣告位信息修改失敗';
$lang['adv_change_succ']	    = '廣告信息修改成功';
$lang['adv_change_fail']	    = '廣告信息修改失敗';
$lang['adv_del_sure']	        = '您確定要刪除所選廣告的所有信息嗎';
$lang['ap_del_sure']	        = '您確定要刪除所選廣告位的所有信息嗎';
$lang['default_word_can_not_null'] = '廣告位預設文字不能位空';
$lang['default_pic_can_not_null']  = '廣告位預設圖片必須上傳';
$lang['must_input_all']  = '(請務必填寫所有的內容後再提交!)';
$lang['adv_index_copy_to_clip']	= '請將JavaScript或PHP代碼複製並粘貼到對應模板檔案中！';

$lang['check_adv_submit']  = '審核廣告申請';
$lang['check_adv_yes']     = '審核通過';
$lang['check_adv_no']      = '不通過';
$lang['check_adv_no2']     = '未通過';
$lang['check_adv_type']    = '類型';
$lang['check_adv_buy']     = '購買';
$lang['check_adv_order']   = '預訂';
$lang['check_adv_change']  = '修改內容';
$lang['check_adv_view']    = '查看';
$lang['check_adv_nothing'] = '目前沒有待審核的廣告';
$lang['check_adv_chart']   = '廣告點擊率統計圖';
$lang['adv_chart_searchyear_input']  = ' 輸入查詢年份:';
$lang['adv_chart_year']    = '年';
$lang['adv_chart_years_chart']    = '年的廣告點擊率統計圖';
$lang['ap_default_pic']    = '廣告位預設圖片:';
$lang['ap_default_pic_upload']    = '廣告位預設圖片上傳:';
$lang['ap_default_word']   = '廣告位預設文字';
$lang['ap_show_defaultpic_when_nothing']    = '當沒有廣告可供展示時使用的預設圖片';
$lang['ap_show_defaultword_when_nothing']    = '當沒有廣告可供展示時使用的預設文字';

$lang['goback_to_adv_check']    = '返回待審核廣告列表頁面';
$lang['adv_check_ok']      = '廣告審核成功';
$lang['adv_check_failed']    = '廣告審核失敗';
$lang['return_goldpay']    = '返還購買廣告的金幣';
$lang['adv_chart_nothing_left']    = '此廣告沒有';
$lang['adv_chart_nothing_right']    = '年的點擊率信息';
