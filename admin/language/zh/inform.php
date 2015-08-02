<?php
defined('InShopNC') or exit('Access Invalid!');

/**
 * 頁面需要的語言
 */
$lang['inform_page_title'] = '舉報商品';
$lang['inform_manage_title'] = '舉報管理';
$lang['inform'] 			= '舉報';

$lang['inform_state_all'] = '所有舉報';
$lang['inform_state_handled'] = '已處理';
$lang['inform_state_unhandle'] = '未處理';
$lang['inform_goods_name'] = '商品名稱';
$lang['inform_member_name'] = '舉報人';
$lang['inform_subject'] = '舉報主題';
$lang['inform_type'] = '舉報類型';
$lang['inform_type_desc'] = '舉報類型描述';
$lang['inform_pic'] = '圖片';
$lang['inform_pic_view'] = '查看圖片';
$lang['inform_pic_none'] = '暫無圖片';
$lang['inform_datetime'] = '舉報時間';
$lang['inform_state'] = '狀態';
$lang['inform_content'] = '舉報內容';
$lang['inform_handle_message'] = '處理信息';
$lang['inform_handle_type'] = '處理結果';
$lang['inform_handle_type_unuse'] = '無效舉報';
$lang['inform_handle_type_venom'] = '惡意舉報';
$lang['inform_handle_type_valid'] = '有效舉報';
$lang['inform_handle_type_unuse_message'] = '無效舉報--商品會正常銷售';
$lang['inform_handle_type_venom_message'] = '惡意舉報--該用戶的所有未處理舉報將被取消，用戶將被禁止舉報';
$lang['inform_handle_type_valid_message'] = '有效舉報--商品將被違規下架';
$lang['inform_subject_add'] = '添加主題';
$lang['inform_type_add'] = '添加類型';

$lang['inform_text_none'] = '無';
$lang['inform_text_handle'] = '處理';
$lang['inform_text_select'] = '請選擇...';

/**
 * 提示信息
 */
$lang['inform_content_null'] = '舉報內容不能為空且不能大於100個字元';
$lang['inform_subject_add_null'] = '舉報主題不能為空且不能大於100個字元';
$lang['inform_handle_message_null'] = '處理信息不能為空且不能大於100個字元';
$lang['inform_type_null'] = '舉報類型不能為空且不能大於50個字元';
$lang['inform_type_desc_null'] = '舉報類型描述不能為空且不能大於100個字元';
$lang['inform_handle_confirm'] = '確認處理該舉報?';
$lang['inform_type_delete_confirm'] = '確認刪除舉報分類，該分類下的主題也將被刪除?';
$lang['confirm_delete'] = '確認刪除?';
$lang['inform_pic_error'] = '圖片只能是jpg格式';
$lang['inform_handling'] = '該商品已經被舉報請等待處理';
$lang['inform_type_error'] = '舉報類型不存在請聯繫平台管理員添加類型';
$lang['inform_subject_null'] = '舉報主題不存在請聯繫平台管理員';
$lang['inform_success'] = '舉報成功請等待處理';
$lang['inform_fail'] = '舉報失敗請聯繫管理員';
$lang['goods_null'] = '商品不存在';
$lang['deny_inform'] = '您已經被禁止舉報商品，如有疑問請聯繫平台管理員'; 
$lang['inform_help1']='舉報類型和舉報主題由管理員在後台設置，在商品信息頁會員可根據舉報主題舉報違規商品';
$lang['inform_help2']='點擊詳細，查看舉報內容';
$lang['inform_help3']='查看已處理舉報內容';
$lang['inform_help4']='可在同一舉報類型下添加多個舉報主題';
$lang['inform_help5']='會員可根據舉報主題，舉報違規商品';

?>
