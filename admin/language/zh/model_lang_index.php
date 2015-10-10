<?php
defined('InShopNC') or exit('Access Invalid!');

/**
 * model簡體語言包
 */
$lang['month_jan'] = '一月';
$lang['month_feb'] = '二月';
$lang['month_mar'] = '三月';
$lang['month_apr'] = '四月';
$lang['month_may'] = '五月';
$lang['month_jun'] = '六月';
$lang['month_jul'] = '七月';
$lang['month_aug'] = '八月';
$lang['month_sep'] = '九月';
$lang['month_oct'] = '十月';
$lang['month_nov'] = '十一月';
$lang['month_dec'] = '十二月';

$lang['db_backup_mkdir_fail'] = '資料庫備份創建檔案目錄失敗';
$lang['db_backup_vi_file_fail'] = '資料庫備份數據無法寫入檔案!';

$lang['order_state_submitted'] = '已提交';
$lang['order_state_pending_payment'] = '待付款';
$lang['order_state_canceled'] = '已取消';
$lang['order_state_paid'] = '已付款';
$lang['order_state_to_be_shipped'] = '待發貨';
$lang['order_state_shipped'] = '已發貨';
$lang['order_state_be_receiving'] = '待收貨';
$lang['order_state_completed'] = '已完成';
$lang['order_state_to_be_evaluated'] = '待評價';
$lang['order_state_to_be_confirmed'] = '待確認';
$lang['order_state_confirmed'] = '已確認';
$lang['order_state_unknown'] = '未知';
$lang['order_state_null'] = '無';
$lang['order_state_operator'] = '系統';
$lang['order_admin_operator'] = '系統管理員';

$lang['order_sn']		= '訂單';
$lang['order_max_day'] = '超過';
$lang['order_max_day_cancel'] = '天未付款，系統自動取消訂單。';
$lang['order_max_day_confirm'] = '天未收貨，系統自動完成訂單。';
$lang['order_max_day_cod'] = '天未確認，系統自動取消訂單。';
$lang['order_day_refund'] = '天未處理退款申請，按同意處理。';
$lang['order_max_day_refund'] = '天未處理退款，系統自動完成訂單。';
$lang['order_admin_refund'] = '管理員同意退款，系統自動收貨完成訂單。';
$lang['order_admin_refund_shipped'] = '管理員不同意退款，系統自動發貨。';
$lang['order_admin_refund_completed'] = '管理員不同意退款，系統自動收貨完成訂單。';

$lang['order_refund_yes'] = '同意退款，系統自動發貨。';
$lang['order_refund_freeze_predeposit'] = '退款減少預存款凍結金額';
$lang['order_refund_add_predeposit'] = '退款增加預存款可用金額';
$lang['order_refund_completed'] = '同意退款，系統自動收貨完成訂單。';
$lang['order_refund_complain'] = '賣家不同意退款';
$lang['order_completed_freeze_predeposit'] = '確認收貨減少預存款凍結金額';
$lang['order_completed_add_predeposit'] = '確認收貨增加預存款可用金額';

$lang['order_completed'] = '系統自動收貨完成訂單。';
$lang['order_refund_buyer_confirm'] = '退款已確認，系統自動收貨完成訂單。';

$lang['payment_api_file_not_found'] = '支付方式配置檔案不存在，請手動創建';
$lang['payment_api_touch_file_and_go_on'] = '，再進行該操作';