<?php
defined('InShopNC') or exit('Access Invalid!');

/**
 * 導航菜單
 */
$lang['complain_manage_title'] = '投訴管理';
$lang['complain_accuser_title'] = '我的投訴';
$lang['complain_accused_title'] = '被投訴';
$lang['complain_submit'] = '投訴處理';
 
$lang['complain_state_new'] = '新投訴';
$lang['complain_state_handle'] = '待仲裁';
$lang['complain_state_appeal'] = '待申訴';
$lang['complain_state_talk'] = '對話中';
$lang['complain_state_finish'] = '已關閉';
$lang['complain_subject_list'] = '投訴主題';

$lang['complain_pic'] = '圖片';
$lang['complain_pic_view'] = '查看圖片';
$lang['complain_pic_none'] = '暫無圖片';
$lang['complain_detail'] = '投訴詳情';
$lang['complain_message'] = '投訴信息';
$lang['complain_evidence'] = '投訴證據';
$lang['complain_evidence_upload'] = '上傳投訴證據';
$lang['complain_content'] = '投訴內容';
$lang['complain_accuser'] = '投訴人';
$lang['complain_accused'] = '被投訴人';
$lang['complain_admin'] = '管理員';
$lang['complain_unknow'] = '未知';
$lang['complain_datetime'] = '投訴時間';
$lang['complain_goods'] = '投訴的商品';
$lang['complain_goods_name'] = '商品名稱';
$lang['complain_goods_message'] = '商品信息';
$lang['complain_type'] = '投訴類別';
$lang['complain_type_buyer'] = '買家投訴';
$lang['complain_type_seller'] = '賣家投訴';
$lang['complain_state'] = '投訴狀態';
$lang['complain_progress'] = '投訴進程';
$lang['complain_subject_content'] = '投訴主題';
$lang['complain_subject_select'] = '選擇投訴主題';
$lang['complain_subject_desc'] = '投訴主題描述';
$lang['complain_subject_type'] = '投訴主題類別';
$lang['complain_subject_add'] = '添加主題';
$lang['complain_appeal_detail'] = '申訴詳情';
$lang['complain_appeal_message'] = '申訴信息';
$lang['complain_appeal_content'] = '申訴內容';
$lang['complain_appeal_datetime'] = '申訴時間';
$lang['complain_appeal_evidence'] = '申訴證據';
$lang['complain_appeal_evidence_upload'] = '上傳申訴證據';
$lang['complain_state_inprogress'] = '進行中';
$lang['complain_state_finish'] = '已完成';
$lang['complain_state_all'] = '選擇狀態';
$lang['final_handle_detail'] = '處理詳情';
$lang['final_handle_message'] = '處理結果';
$lang['final_handle_datetime'] = '處理時間';
$lang['order_detail'] = '訂單詳情';
$lang['order_message'] = '訂單信息';
$lang['order_state'] = '訂單狀態';
$lang['order_sn'] = '訂單號';
$lang['order_datetime'] = '下單時間';
$lang['order_price'] = '訂單總額';
$lang['order_discount'] = '優惠打折';
$lang['order_voucher_price'] = '使用的代金券面額';
$lang['order_voucher_sn'] = '代金券編碼';
$lang['order_buyer_message'] = '買家信息';
$lang['order_seller_message'] = '賣家信息';
$lang['order_shop_name'] = '賣家名稱';
$lang['order_buyer_name'] = '買家名稱';
$lang['order_state_cancel'] = '已取消';
$lang['order_state_unpay'] = '未付款';
$lang['order_state_payed'] = '已付款';
$lang['order_state_send'] = '已發貨';
$lang['order_state_receive'] = '已收貨';
$lang['order_state_commit'] = '已提交';
$lang['order_state_verify'] = '已確認';

$lang['complain_add_pic'] = '補充證據';

/**
 * 提示信息 
 */
$lang['confirm_delete'] = '確認刪除?';
$lang['complain_content_error'] = '投訴內容不能為空且必須小於100個字元';
$lang['appeal_message_error'] = '投訴內容不能為空且必須小於100個字元';
$lang['complain_pic_error'] = '圖片必須是jpg/jpeg/gif/png格式';
$lang['complain_subject_content_error'] = '投訴主題不能為空且必須小於50個字元';
$lang['complain_subject_desc_error'] = '投訴主題描述不能為空且必須小於100個字元';
$lang['complain_subject_type_error'] = '未知投訴主題類型';
$lang['complain_subject_error'] = '投訴主題不存在請聯繫管理員';
$lang['complain_subject_add_success'] = '投訴主題添加成功';
$lang['complain_subject_add_fail'] = '投訴主題添加失敗';
$lang['complain_subject_delete_success'] = '投訴主題刪除成功';
$lang['complain_subject_delete_fail'] = '投訴主題刪除失敗';
$lang['complain_goods_select'] = '選擇要投訴的商品';
$lang['complain_submit_success'] = '投訴提交成功,請等待系統審核';
$lang['appeal_submit_success'] = '申訴提交成功';
$lang['handle_submit_success'] = '您成功申請仲裁,請等待管理員裁決';
$lang['talk_detail'] = '對話詳情';
$lang['talk_null'] = '對話不能為空';
$lang['talk_none'] = '目前沒有對話';
$lang['talk_list'] = '對話記錄';
$lang['talk_send'] = '發佈對話';
$lang['talk_refresh'] = '刷新對話';
$lang['talk_send_success'] = '對話發送成功';
$lang['talk_send_fail'] = '對話發送失敗';
$lang['talk_forbit_message'] =  '<該對話被管理員屏蔽>';
$lang['handle_confirm_message'] = '確認提交仲裁,提交後管理員將做出裁決';
$lang['handle_submit'] = '提交仲裁';
$lang['complain_repeat'] = '您已經投訴了該訂單請等待處理';
$lang['complain_time_limit'] = '您的訂單已經超出投訴時限';
$lang['complain_cancel_confirm'] = '確認取消該投訴?';
$lang['complain_cancel_success'] = '投訴取消成功';
$lang['complain_cancel_fail'] = '投訴取消失敗';
$lang['max_fifty_chars'] = '最多50個字元';


/**
 * 文本
 */
$lang['complain_text_select'] = '請選擇...';
$lang['complain_text_buyer'] = '買家';
$lang['complain_text_seller'] = '賣家';
$lang['complain_text_handle'] = '操作';
$lang['complain_text_detail'] = '投訴詳細';
$lang['complain_text_submit'] = '提交';
$lang['complain_text_pic'] = '圖片';
$lang['complain_text_num'] = '數量';
$lang['complain_text_price'] = '價格';
$lang['complain_text_problem'] = '問題描述';
$lang['complain_text_say'] = '說';
$lang['click_to_see'] = '點擊查看';
$lang['send_appeal_message'] = '被投訴人回覆了您的投訴';

?>
