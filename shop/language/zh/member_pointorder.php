<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 積分禮品功能公用
 */
$lang['member_pointorder_unavailable']	 		= '系統未開啟積分或者積分兌換功能';
$lang['member_pointorder_parameter_error']		= '參數錯誤';
$lang['member_pointorder_record_error']			= '記錄信息錯誤';
$lang['member_pointorder_list_title']			= '兌換記錄';
$lang['member_pointorder_info_title']			= '兌換詳細';
$lang['member_pointorder_ordersn']				= '兌換單號';
$lang['member_pointorder_payment']				= '支付方式';
$lang['member_pointorder_orderstate']			= '狀態';
$lang['member_pointorder_exchangepoints']		= '兌換積分';
$lang['member_pointorder_shippingfee']			= '運費';
$lang['member_pointorder_exchangepoints_shippingfee'] = '積分及運費';
$lang['member_pointorder_orderstate_handle']	= '狀態與操作';
$lang['member_pointorder_addtime']				= '兌換時間';
$lang['member_pointorder_shipping_code']		= '物流單號';
$lang['member_pointorder_shipping_time']		= '發貨時間';
$lang['member_pointorder_exnum']				= '兌換數量';
$lang['member_pointorder_gobacklist']			= '返回列表';
/**
 * 兌換信息狀態
 */
$lang['member_pointorder_state_submit']				= '已提交';
$lang['member_pointorder_state_waitpay']			= '待付款';
$lang['member_pointorder_state_canceled']			= '已取消';
$lang['member_pointorder_state_paid']				= '已付款';
$lang['member_pointorder_state_confirmpay']			= '待確認';
$lang['member_pointorder_state_confirmpaid']		= '確認收款';
$lang['member_pointorder_state_waitship']			= '待發貨';
$lang['member_pointorder_state_shipped']			= '已發貨';
$lang['member_pointorder_state_waitreceiving']		= '待收貨';
$lang['member_pointorder_state_finished']			= '已完成';
$lang['member_pointorder_state_unknown']			= '未知';
/**
 * 兌換信息列表
 */
$lang['member_pointorder_cancel_tip1']				= '取消兌換禮品信息';
$lang['member_pointorder_cancel_tip2']				= '增加積分';
$lang['member_pointorder_cancel_success']			= '取消兌換成功';
$lang['member_pointorder_cancel_fail']				= '取消兌換失敗';
$lang['member_pointorder_confirmreceiving_success']	= '確認收貨成功';
$lang['member_pointorder_confirmreceiving_fail']	= '確認收貨失敗';
$lang['member_pointorder_pay']						= '付款';
$lang['member_pointorder_confirmreceiving']			= '確認收貨';
$lang['member_pointorder_confirmreceivingtip']		= '確認已經收到兌換禮品嗎?';
$lang['member_pointorder_cancel_title']				= '取消兌換';
$lang['member_pointorder_cancel_confirmtip']		= '確認取消兌換信息?';
$lang['member_pointorder_viewinfo']					= '查看詳細';
/**
 * 兌換信息詳細
 */
$lang['member_pointorder_info_ordersimple']		= '兌換信息';
$lang['member_pointorder_info_memberinfo']		= '會員信息';
$lang['member_pointorder_info_membername']		= '會員名稱';
$lang['member_pointorder_info_memberemail']		= 'Email';
$lang['member_pointorder_info_ordermessage']	= '留言';
$lang['member_pointorder_info_paymentinfo']		= '支付信息';
$lang['member_pointorder_info_paymenttime']		= '支付時間';
$lang['member_pointorder_info_paymentmessage']	= '支付留言';
$lang['member_pointorder_info_shipinfo']		= '收貨人及發貨信息';
$lang['member_pointorder_info_shipinfo_truename']= '收貨人';
$lang['member_pointorder_info_shipinfo_areainfo']= '所在地區';
$lang['member_pointorder_info_shipinfo_zipcode']= '郵政編碼';
$lang['member_pointorder_info_shipinfo_telphone']= '電話號碼';
$lang['member_pointorder_info_shipinfo_mobphone']= '手機號碼';
$lang['member_pointorder_info_shipinfo_address']= '詳細地址';
$lang['member_pointorder_info_shipinfo_description']= '發貨描述';
$lang['member_pointorder_info_prodinfo']			= '禮品信息';
$lang['member_pointorder_info_prodinfo_exnum']		= '兌換數量';

$lang['pay_bank_user']			= '匯款人姓名';
$lang['pay_bank_bank']			= '匯入銀行';
$lang['pay_bank_account']		= '匯款入賬號';
$lang['pay_bank_num']			= '匯款金額';
$lang['pay_bank_date']			= '匯款日期';
$lang['pay_bank_extend']		= '其它';
$lang['pay_bank_order']			= '匯款單號';
$lang['pay_bank_bank_tips']		= '（需要填寫詳細的支行名稱，如中國銀行天津分行十一經路支行）';

/**
 * 應用積分兌換
 */
$lang['member_pointorder_exchange_unavailable']	= '系統沒有整合Ucenter，如有需要請與管理員聯繫';
$lang['member_pointorder_exchange_phpwind']	    = '系統整合phpwind UC，不支持在綫兌換，如有需要請與管理員聯繫';
$lang['member_pointorder_exchange_discuz']	    = '系統暫不支持積分兌換到其它應用，如有需要請與管理員聯繫';
$lang['member_pointorder_exchange_scheme_error']= '系統目前的兌換積分方案有錯，不能進行兌換，請與管理員聯繫';
$lang['member_pointorder_exchange_credit_error']= '您要轉賬或兌換的積分數量輸入有誤，請返回修改';
$lang['member_pointorder_exchange_password_error']= '您的登錄密碼錯誤';
$lang['member_pointorder_exchange_credit_insufficient']= '對不起，您的積分餘額不足，兌換失敗';
$lang['member_pointorder_exchange_fail']        = '兌換失敗，請與管理員聯繫';
$lang['member_pointorder_exchange_succeed']     = '兌換成功';
/**
 * 應用積分兌換詳細
 */
$lang['member_pointorder_exchange_info']		= '系統已開啟同步積分功能!';
$lang['member_pointorder_exchange_my_credit']	= '您擁有積分';
$lang['member_pointorder_exchange_app']		    = '您可以將自己的積分兌換到本站其他的應用（比如論壇）裡面!';
$lang['member_pointorder_exchange_my_password']	= '登錄密碼';
$lang['member_pointorder_exchange_my_password_info']	= '正確輸入您的登錄密碼才能兌換';
$lang['member_pointorder_exchange_pay_credit']	= '支出積分';
$lang['member_pointorder_exchange_exchange_credit']	= '兌換成';
$lang['member_pointorder_exchange_exchange_ratio']	= '兌換比率';
$lang['member_pointorder_exchange_exchange']	= '兌換';
$lang['member_pointorder_exchange_credit']	    = '積分';
