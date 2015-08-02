<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 兌換訂單功能公用
 */
$lang['admin_pointorder_unavailable']	 		= '系統未開啟積分或者積分兌換功能';
$lang['admin_pointorder_parameter_error']		= '參數錯誤';
$lang['admin_pointorderd_record_error']			= '記錄信息錯誤';
$lang['admin_pointorder_userrecord_error']		= '用戶信息錯誤';
$lang['admin_pointorder_goodsrecord_error']		= '禮品信息錯誤';
$lang['admin_pointprod_list_title']				= '禮品列表';
$lang['admin_pointprod_add_title']				= '新增禮品';
$lang['admin_pointorder_list_title']			= '兌換列表';
$lang['admin_pointorder_ordersn']				= '兌換單號';
$lang['admin_pointorder_membername']			= '會員名稱';
$lang['admin_pointorder_payment']				= '支付方式';
$lang['admin_pointorder_orderstate']			= '狀態';
$lang['admin_pointorder_exchangepoints']		= '兌換積分';
$lang['admin_pointorder_shippingfee']			= '運費';
$lang['admin_pointorder_addtime']				= '兌換時間';
$lang['admin_pointorder_shipping_code']			= '物流單號';
$lang['admin_pointorder_shipping_time']			= '發貨時間';
$lang['admin_pointorder_gobacklist']			= '返回列表';
/**
 * 兌換信息狀態
 */
$lang['admin_pointorder_state_submit']			= '已提交';
$lang['admin_pointorder_state_waitpay']			= '待付款';
$lang['admin_pointorder_state_canceled']		= '已取消';
//$lang['admin_pointorder_state_waitfinish']	= '待完成';
$lang['admin_pointorder_state_paid']			= '已付款';
$lang['admin_pointorder_state_confirmpay']		= '待確認';
$lang['admin_pointorder_state_confirmpaid']		= '確認收款';
$lang['admin_pointorder_state_waitship']		= '待發貨';
$lang['admin_pointorder_state_shipped']			= '已發貨';
$lang['admin_pointorder_state_waitreceiving']	= '待收貨';
$lang['admin_pointorder_state_finished']		= '已完成';
$lang['admin_pointorder_state_unknown']			= '未知';
/**
 * 兌換信息列表
 */
$lang['admin_pointorder_changefee']					= '調整運費';
$lang['admin_pointorder_changefee_success']			= '調整運費成功';
$lang['admin_pointorder_changefee_freightpricenull']= '請添加運費';
$lang['admin_pointorder_changefee_freightprice_error']= '運費價格必須為數字且大於等於0';
$lang['admin_pointorder_cancel_tip1']				= '取消兌換禮品信息';
$lang['admin_pointorder_cancel_tip2']				= '增加積分';
$lang['admin_pointorder_cancel_title']				= '取消兌換';
$lang['admin_pointorder_cancel_confirmtip']			= '確認取消兌換信息?';
$lang['admin_pointorder_cancel_success']			= '取消成功';
$lang['admin_pointorder_cancel_fail']				= '取消失敗';
$lang['admin_pointorder_confirmpaid']				= '確認收款';
$lang['admin_pointorder_confirmpaid_confirmtip']	= '是否確認兌換信息款項已經收到?';
$lang['admin_pointorder_confirmpaid_success']		= '確認成功';
$lang['admin_pointorder_confirmpaid_fail']			= '確認失敗';
$lang['admin_pointorder_ship_title']				= '發貨';
$lang['admin_pointorder_ship_modtip']				= '修改物流';
$lang['admin_pointorder_ship_code_nullerror']		= '請添加物流單號';
$lang['admin_pointorder_ship_success']				= '信息操作成功';
$lang['admin_pointorder_ship_fail']					= '信息操作失敗';
$lang['admin_pointorder_shipping_timetip']			= '註：預設為當前時間';
$lang['admin_pointorder_shipping_description']		= '描述';
/**
 * 兌換信息刪除
 */
$lang['admin_pointorder_del_success']		= '刪除成功';
$lang['admin_pointorder_del_fail']			= '刪除失敗';
/**
 * 兌換信息詳細
 */
$lang['admin_pointorder_info_title']			= '兌換信息詳細';
$lang['admin_pointorder_info_ordersimple']		= '兌換信息';
$lang['admin_pointorder_info_orderdetail']		= '兌換詳情';
$lang['admin_pointorder_info_memberinfo']		= '會員信息';
$lang['admin_pointorder_info_memberemail']		= '會員Email';
$lang['admin_pointorder_info_ordermessage']		= '留言';
$lang['admin_pointorder_info_paymentinfo']		= '支付信息';
$lang['admin_pointorder_info_paymenttime']		= '支付時間';
$lang['admin_pointorder_info_paymentmessage']	= '支付留言';
$lang['admin_pointorder_info_shipinfo']			= '收貨人及發貨信息';
$lang['admin_pointorder_info_shipinfo_truename']= '收貨人';
$lang['admin_pointorder_info_shipinfo_areainfo']= '所在地區';
$lang['admin_pointorder_info_shipinfo_zipcode']= '郵政編碼';
$lang['admin_pointorder_info_shipinfo_telphone']= '電話號碼';
$lang['admin_pointorder_info_shipinfo_mobphone']= '手機號碼';
$lang['admin_pointorder_info_shipinfo_address']= '詳細地址';
$lang['admin_pointorder_info_shipinfo_description']	= '發貨描述';
$lang['admin_pointorder_info_prodinfo']				= '禮品信息';
$lang['admin_pointorder_info_prodinfo_exnum']		= '兌換數量';

$lang['pay_bank_user']			= '匯款人姓名';
$lang['pay_bank_bank']			= '匯入銀行';
$lang['pay_bank_account']		= '匯款入賬號';
$lang['pay_bank_num']			= '匯款金額';
$lang['pay_bank_date']			= '匯款日期';
$lang['pay_bank_extend']		= '其它';
$lang['pay_bank_order']			= '匯款單號';
$lang['pay_bank_bank_tips']		= '（需要填寫詳細的支行名稱，如中國銀行天津分行十一經路支行）';