<?php
defined('InShopNC') or exit('Access Invalid!');

/**
 * model简体语言包
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

$lang['db_backup_mkdir_fail'] = '数据库备份创建文件目录失败';
$lang['db_backup_vi_file_fail'] = '数据库备份数据无法写入文件!';

$lang['order_state_submitted'] = '已提交';
$lang['order_state_pending_payment'] = '待付款';
$lang['order_state_canceled'] = '已取消';
$lang['order_state_paid'] = '已付款';
$lang['order_state_to_be_shipped'] = '待发货';
$lang['order_state_shipped'] = '已发货';
$lang['order_state_be_receiving'] = '待收货';
$lang['order_state_completed'] = '已完成';
$lang['order_state_to_be_evaluated'] = '待评价';
$lang['order_state_to_be_confirmed'] = '待确认';
$lang['order_state_confirmed'] = '已确认';
$lang['order_state_unknown'] = '未知';
$lang['order_state_null'] = '无';
$lang['order_state_operator'] = '系统';
$lang['order_admin_operator'] = '系统管理员';

$lang['order_sn']		= '订单';
$lang['order_max_day'] = '超过';
$lang['order_max_day_cancel'] = '天未付款，系统自动取消订单。';
$lang['order_max_day_confirm'] = '天未收货，系统自动完成订单。';
$lang['order_max_day_cod'] = '天未确认，系统自动取消订单。';
$lang['order_day_refund'] = '天未处理退款申请，按同意处理。';
$lang['order_max_day_refund'] = '天未处理退款，系统自动完成订单。';
$lang['order_admin_refund_yes'] = '管理员同意退款，系统自动收货完成订单。';
$lang['order_admin_refund_shipped'] = '管理员不同意退款，系统自动发货。';
$lang['order_admin_refund_completed'] = '管理员不同意退款，系统自动收货完成订单。';

$lang['order_refund_yes'] = '同意退款，系统自动发货。';
$lang['order_refund_freeze_predeposit'] = '退款减少预存款冻结金额';
$lang['order_refund_add_predeposit'] = '退款增加预存款可用金额';
$lang['order_refund_completed'] = '同意退款，系统自动收货完成订单。';
$lang['order_refund_complain'] = '卖家不同意退款';
$lang['order_completed_freeze_predeposit'] = '确认收货减少预存款冻结金额';
$lang['order_completed_add_predeposit'] = '确认收货增加预存款可用金额';

$lang['order_completed'] = '系统自动收货完成订单。';
$lang['order_refund_buyer_confirm'] = '退款已确认，系统自动收货完成订单。';

$lang['payment_api_file_not_found'] = '支付方式配置文件不存在，请手动创建';
$lang['payment_api_touch_file_and_go_on'] = '，再进行该操作';