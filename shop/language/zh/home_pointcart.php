<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 積分禮品兌換功能公用
 */
$lang['pointcart_unavailable']	 		= '系統未開啟積分或者積分兌換功能';
$lang['pointcart_parameter_error']		= '參數錯誤';
$lang['pointcart_record_error']			= '記錄信息錯誤';
$lang['pointcart_unlogin_error']		= '請您先進行登錄';
$lang['pointcart_goodsname']			= '禮品名稱';
$lang['pointcart_exchangepoint']		= '兌換積分';
$lang['pointcart_exchangenum']			= '兌換數量';
$lang['pointcart_pointoneall']			= '積分小計';
$lang['pointcart_ensure_order']			= '確認兌換清單';
$lang['pointcart_ensure_info']			= '確認收貨人資料';
$lang['pointcart_exchange_finish']		= '兌換完成';
$lang['pointcart_cart_allpoints']		= '所需總積分';
$lang['pointcart_shipfee']				= '運費';
$lang['pointcart_step2_prder_trans_to']	= '寄送至';
$lang['pointcart_step2_prder_trans_receive']	= '收貨人';
$lang['pointcart_buyer_error']			= '買家信息錯誤';
/**
 * 購物車
 */
$lang['pointcart_cart_addcart_fail']		= '兌換失敗';
$lang['pointcart_cart_addcart_willbe']		= '積分禮品兌換活動即將開始';
$lang['pointcart_cart_addcart_end']			= '積分禮品兌換活動已經結束';
$lang['pointcart_cart_addcart_pointshort']	= '積分不足,請選擇其他禮品';
$lang['pointcart_cart_addcart_prodexists']	= '您已經兌換過該禮品';
$lang['pointcart_cart_modcart_fail']		= '修改失敗';
$lang['pointcart_cart_chooseprod_title']	= '已選擇的兌換禮品';
$lang['pointcart_cart_handle']				= '操作';
$lang['pointcart_cart_reduse']				= '減少';
$lang['pointcart_cart_increase']			= '增加';
$lang['pointcart_cart_del']					= '刪除';
$lang['pointcart_cart_submit']				= '填寫並確認兌換';
$lang['pointcart_cart_continue']			= '繼續兌換';
$lang['pointcart_cart_null']				= '您還沒有選擇兌換禮品';
$lang['pointcart_cart_exchangenow']			= '馬上去兌換';
$lang['pointcart_cart_exchanged_list']		= '查看已兌換信息';
/**
 * step1
 */
$lang['pointcart_step1_receiver_address']	= '收貨人地址';
$lang['pointcart_step1_manage_receiver_address']	= '管理收貨人地址';
$lang['pointcart_step1_receiver_name']		= '收貨人姓名';
$lang['pointcart_step1_phone']				= '電話';
$lang['pointcart_step1_new_address']		= '使用新的收貨地址';
$lang['pointcart_step1_input_true_name']	= '請填寫真實姓名';
$lang['pointcart_step1_area']				= '所在地區';
$lang['pointcart_step1_edit']				= '編輯';
$lang['pointcart_step1_please_choose']		= '請選擇';
$lang['pointcart_step1_choose_area']		= '請選擇所在地區';
$lang['pointcart_step1_whole_address']		= '詳細地址';
$lang['pointcart_step1_true_address']		= '請填寫真實地址，不需要重複填寫所在地區';
$lang['pointcart_step1_zipcode']			= '郵政編碼';
$lang['pointcart_step1_zipcode_tip']		= '請填寫郵政編碼';
$lang['pointcart_step1_zipcode_error']		= '郵政編碼由6位數字構成';
$lang['pointcart_step1_phone_num']			= '電話號碼';
$lang['pointcart_step1_telphone']			= '電話號碼和手機號碼請至少填寫一個';
$lang['pointcart_step1_mobile_num']			= '手機號碼';
$lang['pointcart_step1_auto_save']			= '自動保存收貨地址';
$lang['pointcart_step1_auto_saved']			= '選擇後該地址將會保存到您的收貨地址列表';
$lang['pointcart_step1_message']			= '我要留言';
$lang['pointcart_step1_message_advice']		= '選填，可以寫下您對禮品的需求';
$lang['pointcart_step1_submit']				= '兌換完成';
$lang['pointcart_step1_chooseprod']			= '已選禮品';
$lang['pointcart_step1_order_wrong1']		= '很抱歉，您填寫的訂單信息中有';
$lang['pointcart_step1_order_wrong2']		= '個錯誤(如紅色斜體部分所示)，請檢查並修正後再提交！';
$lang['pointcart_step1_input_address']		= '請如實填寫收貨人詳細地址';
$lang['pointcart_step1_input_receiver']		= '請如實填寫您的收貨人姓名';
$lang['pointcart_step1_phone_format']		= '電話號碼由數字、加號、減號、空格、括號組成,並不能少於6位';
$lang['pointcart_step1_wrong_mobile']		= '手機號碼只能是數字,並且不能少於6位';

$lang['pointcart_step1_goods_info']					= '兌換商品信息';
$lang['pointcart_step1_goods_point']				= '兌換所需積分';
$lang['pointcart_step1_goods_num']					= '兌換數量';
$lang['pointcart_step1_return_list']				= '返回兌換列表';
/**
 * step2
 */
$lang['pointcart_step2_fail']				= '兌換操作失敗';
$lang['pointcart_step2_exchange_success']	= '兌換成功！';
$lang['pointcart_step2_order_created']		= '您的兌換訂單已成功生成';
$lang['pointcart_step2_order_sn']			= '兌換單號';
$lang['pointcart_step2_order_allpoints']	= '兌換積分';
$lang['pointcart_step2_view_order']			= '查看詳單';
$lang['pointcart_step2_choose_method_to_pay']= '選擇支付方式';
$lang['pointcart_step2_paymessage']			= '支付留言';
$lang['pointcart_step2_choose_pay_method']	= '請選擇支付方式';
$lang['pointcart_step2_ensure_pay']			= '確認支付';
$lang['pointcart_step2_orderinfo_title']	= '兌換訂單信息如下';
$lang['pointcart_step2_pay_online']			= '線上支付';
$lang['pointcart_step2_pay_offline']		= '綫下支付';

$lang['pointcart_step2_paymentnull']		= '抱歉，暫時沒有符合條件的支付方式，請聯繫客服進行後續購買流程';


$lang['pointcart_step2_paymessage_nullerror']	= '請填寫匯款信息';
$lang['pay_bank_user']			= '匯款人姓名';
$lang['pay_bank_bank']			= '匯入銀行';
$lang['pay_bank_account']		= '匯款入賬號';
$lang['pay_bank_num']			= '匯款金額';
$lang['pay_bank_date']			= '匯款日期';
$lang['pay_bank_extend']		= '其它';
$lang['pay_bank_order']			= '匯款單號';

/**
 * step3
 */
$lang['pointcart_step3_paymenterror']	= '支付方式錯誤';
$lang['pointcart_step3_choosepayment']	= '請選擇支付方式';
$lang['pointcart_step3_paysuccess']		= '兌換信息支付成功';
$lang['pointcart_step3_payfail']		= '兌換信息支付失敗';
$lang['pointcart_step3_predepositreduce_logdesc']= '積分兌換減少預存款可用金額';