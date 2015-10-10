<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 預存款功能公用
 */
$lang['admin_predeposit_no_record']	 		= '沒有符合條件的記錄';
$lang['admin_predeposit_unavailable']	 	= '系統未開啟預存款功能';
$lang['admin_predeposit_parameter_error']	= '參數錯誤';
$lang['admin_predeposit_record_error']		= '記錄信息錯誤';
$lang['admin_predeposit_userrecord_error']	= '會員信息錯誤';
$lang['admin_predeposit_membername']			= '會員名稱';
$lang['admin_predeposit_payment']				= '支付方式';
$lang['admin_predeposit_addtime']				= '創建時間';
$lang['admin_predeposit_addtime_to']			= '至';
$lang['admin_predeposit_screen']				= '篩選條件';
$lang['admin_predeposit_paystate']				= '支付狀態';
$lang['admin_predeposit_recordstate']			= '記錄狀態';
$lang['admin_predeposit_backlist']				= '返回列表';
$lang['admin_predeposit_adminname']				= '管理員名稱';
$lang['admin_predeposit_adminremark']			= '管理員備註';
$lang['admin_predeposit_memberremark']			= '會員備註';
$lang['admin_predeposit_remark']				= '備註';
$lang['admin_predeposit_shortprice_error']		= '預存款金額不足，請查看用戶預存款信息';
$lang['admin_predeposit_pricetype']				= '預存款類型';
$lang['admin_predeposit_pricetype_available']	= '可用金額';
$lang['admin_predeposit_pricetype_freeze']		= '凍結金額';
$lang['admin_predeposit_price']					= '金額';
$lang['admin_predeposit_sn']					= '編號';
$lang['admin_predeposit_payment_error'] 		= '支付方式錯誤';
/**
 * 充值功能公用
 */
$lang['admin_predeposit_rechargelist']				= '充值管理';
$lang['admin_predeposit_rechargewaitpaying']		= '等待支付';
$lang['admin_predeposit_rechargepaysuccess']		= '支付成功';
$lang['admin_predeposit_rechargestate_auditing']	= '審核中';
$lang['admin_predeposit_rechargestate_completed']	= '已完成';
$lang['admin_predeposit_rechargestate_closed']		= '已關閉';
$lang['admin_predeposit_recharge_onlinecode']		= '線上交易流水號';
$lang['admin_predeposit_recharge_price']			= '充值金額';
$lang['admin_predeposit_recharge_huikuanname']		= '匯款人姓名';
$lang['admin_predeposit_recharge_huikuanbank']		= '匯款銀行';
$lang['admin_predeposit_recharge_huikuandate']		= '匯款日期';
$lang['admin_predeposit_recharge_memberremark']		= '會員備註';
$lang['admin_predeposit_recharge_help1']			= '你可以點擊“編輯”選項進行預存款充值審核';
$lang['admin_predeposit_recharge_help2']			= '點擊“查看”選項可以查看存款充值的詳細信息';
$lang['admin_predeposit_recharge_searchtitle']			= '條件篩選';
/**
 * 充值信息編輯
 */
$lang['admin_predeposit_recharge_edit_logdesc']		= '會員充值支付狀態修改減少預存款';
$lang['admin_predeposit_recharge_edit_success']		= '充值信息修改成功';
$lang['admin_predeposit_recharge_edit_fail']		= '充值信息修改失敗';
$lang['admin_predeposit_recharge_notice']		= '僅管理員可見';
/**
 * 充值信息刪除
 */
$lang['admin_predeposit_recharge_del_success']		= '充值信息刪除成功';
$lang['admin_predeposit_recharge_del_fail']		= '充值信息刪除失敗';
/**
 * 提現功能公用
 */
$lang['admin_predeposit_cashmanage']			= '提現管理';
$lang['admin_predeposit_cashwaitpaying']		= '等待支付';
$lang['admin_predeposit_cashpaysuccess']		= '支付成功';
$lang['admin_predeposit_cashstate_auditing']	= '審核中';
$lang['admin_predeposit_cashstate_completed']	= '已完成';
$lang['admin_predeposit_cashstate_closed']		= '已關閉';
$lang['admin_predeposit_cash_price']			= '提現金額';
$lang['admin_predeposit_cash_shoukuanname']			= '收款人姓名';
$lang['admin_predeposit_cash_shoukuanbank']			= '收款銀行';
$lang['admin_predeposit_cash_shoukuanaccount']		= '收款賬號';
$lang['admin_predeposit_cash_remark_tip1']			= '僅管理員可見';
$lang['admin_predeposit_cash_remark_tip2']			= '備註信息將在預存款明細相關頁顯示，會員和管理員都可見';
$lang['admin_predeposit_cash_help1']			= '你可以點擊編輯選項進行提現審核';
$lang['admin_predeposit_cash_help2']			= '點擊查看選項可以查看提現的詳細信息';
/**
 * 提現信息刪除
 */
$lang['admin_predeposit_cash_del_success']	= '提現信息刪除成功';
$lang['admin_predeposit_cash_del_fail']		= '提現信息刪除失敗';
$lang['admin_predeposit_cash_del_reducefreezelogdesc']		= '會員提現記錄刪除成功減少凍結預存款金額';
$lang['admin_predeposit_cash_del_adddesc']	= '會員提現記錄刪除成功增加預存款金額';
/**
 * 提現信息編輯
 */
$lang['admin_predeposit_cash_edit_reducefreezelogdesc']	= '會員提現記錄狀態修改為支付成功減少凍結預存款金額';
$lang['admin_predeposit_cash_edit_success']		= '提現信息修改成功';
$lang['admin_predeposit_cash_edit_fail']		= '提現信息修改失敗';
/**
 * 手動修改
 */
$lang['admin_predeposit_artificial'] 	= '手動修改';
$lang['admin_predeposit_artificial_membername_error'] 	= '會員信息錯誤，請重新填寫會員名';
$lang['admin_predeposit_artificial_membernamenull_error'] 	= '請輸入會員名稱';
$lang['admin_predeposit_artificial_pricenull_error'] 		= '請添加金額';
$lang['admin_predeposit_artificial_pricemin_error'] 		= '金額必須大於0';
$lang['admin_predeposit_artificial_shortprice_error']		= '金額不足,會員當前可用金額為';
$lang['admin_predeposit_artificial_shortfreezeprice_error']	= '金額不足,會員當前凍結金額為';
$lang['admin_predeposit_artificial_success']				= '修改會員預存款成功';
$lang['admin_predeposit_artificial_fail']					= '修改會員預存款失敗';
$lang['admin_predeposit_artificial_operatetype']			= '增減類型';
$lang['admin_predeposit_artificial_operatetype_add']		= '增加';
$lang['admin_predeposit_artificial_operatetype_reduce']		= '減少';
$lang['admin_predeposit_artificial_member_tip_1']			= '會員';
$lang['admin_predeposit_artificial_member_tip_2']			= ', 當前可用預存款為';
$lang['admin_predeposit_artificial_member_tip_3']			= ',  凍結預存款為';
$lang['admin_predeposit_artificial_notice']					= '你可以選擇修改可用金額或凍結金額';
/**
 * 出入明細 
 */
$lang['admin_predeposit_log_stage'] 	= '類型';
$lang['admin_predeposit_log_stage_recharge']	= '充值';
$lang['admin_predeposit_log_stage_cash']		= '提現';
$lang['admin_predeposit_log_stage_order']		= '消費';
$lang['admin_predeposit_log_stage_artificial']	= '手動修改';
$lang['admin_predeposit_log_stage_system']		= '系統';
$lang['admin_predeposit_log_desc']		= '描述';
$lang['admin_predeposit_log_help1']		= '預存款明細，展示了被操作人員（會員）、操作人員（管理員）、操作金額（“-”表示減少，無符號表示增加）、操作時間（添加時間）等信息';
?>