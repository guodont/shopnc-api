<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 共有語言
 */

/**
 * 收貨人信息
 */
$lang['member_address_receiver_name']	= '收貨人';
$lang['member_address_location']		= '所在地區';
$lang['member_address_address']			= '街道地址';
$lang['member_address_zipcode']			= '郵編';
$lang['member_address_phone']			= '電話';
$lang['member_address_mobile']			= '手機';
$lang['member_address_edit_address']	= '編輯地址';
$lang['member_address_no_address']		= '您沒有添加收貨地址';
$lang['member_address_input_name']		= '請填寫您的真實姓名';
$lang['member_address_please_choose']	= '請選擇';
$lang['member_address_not_repeat']		= '不必重複填寫地區';
$lang['member_address_phone_num']		= '電話號碼';
$lang['member_address_area_num']		= '區號';
$lang['member_address_sub_phone']		= '分機';
$lang['member_address_mobile_num']		= '手機號碼';
$lang['member_address_input_receiver']	= '請填寫收貨人姓名';
$lang['member_address_choose_location']	= '請選擇所在地區';
$lang['member_address_input_address']	= '請填寫詳細地址';
$lang['member_address_zip_code']		= '郵政編碼由6位數字構成';
$lang['member_address_phone_and_mobile']	= '固定電話和手機請至少填寫一項.';
$lang['member_address_phone_rule']		= '電話號碼由數字、加號、減號、空格、括號組成,並不能少於6位. ';
$lang['member_address_wrong_mobile']	= '錯誤的手機號碼';

/**
 * 設置發貨地址
 */
$lang['store_daddress_wrong_argument']	= '參數不正確';
$lang['store_daddress_receiver_null']	= '發貨人不能為空';
$lang['store_daddress_wrong_area']		= '所在地區選擇不正確';
$lang['store_daddress_area_null']		= '所在地區信息不能為空';
$lang['store_daddress_address_null']	= '詳細地址不能為空';
$lang['store_daddress_modify_fail']		= '修改地址失敗';
$lang['store_daddress_add_fail']		= '新增地址失敗';
$lang['store_daddress_del_fail']		= '刪除地址失敗';
$lang['store_daddress_del_succ']		= '刪除成功';
$lang['store_daddress_new_address']		= '新增地址';
$lang['store_daddress_deliver_address']	= '發貨地址';
$lang['store_daddress_default']			= '預設';
$lang['store_daddress_receiver_name']	= '聯繫人';
$lang['store_daddress_location']		= '所在地區';
$lang['store_daddress_address']			= '街道地址';
$lang['store_daddress_zipcode']			= '郵編';
$lang['store_daddress_phone']			= '電話';
$lang['store_daddress_mobile']			= '手機';
$lang['store_daddress_company']			= '公司';
$lang['store_daddress_content']			= '備註';
$lang['store_daddress_edit_address']	= '編輯地址';
$lang['store_daddress_no_address']		= '您沒有添加發貨地址';
$lang['store_daddress_input_name']		= '請填寫您的真實姓名';
$lang['store_daddress_please_choose']	= '請選擇';
$lang['store_daddress_not_repeat']		= '不必重複填寫地區';
$lang['store_daddress_phone_num']		= '電話號碼';
$lang['store_daddress_area_num']		= '區號';
$lang['store_daddress_sub_phone']		= '分機';
$lang['store_daddress_mobile_num']		= '手機號碼';
$lang['store_daddress_input_receiver']	= '請填寫聯繫人姓名';
$lang['store_daddress_choose_location']	= '請選擇所在地區';
$lang['store_daddress_input_address']	= '請填寫街道地址';
$lang['store_daddress_zip_code']		= '郵政編碼由6位數字構成';
$lang['store_daddress_phone_and_mobile']	= '固定電話和手機請至少填寫一項.';
$lang['store_daddress_phone_rule']		= '電話號碼由數字、加號、減號、空格、括號組成,並不能少於6位. ';
$lang['store_daddress_wrong_mobile']	= '錯誤的手機號碼';

/**
 * 設置物流公司
 */
$lang['store_deliver_express_title']	= '物流公司';

/**
 * 發貨
 */
$lang['store_deliver_order_state_send']		= '已發貨';
$lang['store_deliver_order_state_receive']	= '待收貨';
$lang['store_deliver_modfiy_address']		= '修改收貨信息';
$lang['store_deliver_select_daddress']		= '選擇發貨地址';
$lang['store_deliver_select_ather_daddress']= '選擇其它發貨地址';
$lang['store_deliver_daddress_list']		= '地址庫';
$lang['store_deliver_default_express']		= '預設物流公司';
$lang['store_deliver_buyer_name']			= '買家';
$lang['store_deliver_buyer_address']		= '收貨信息';
$lang['store_deliver_shipping_sel']			= '運輸選擇';
$lang['store_deliver_modify_info']			= '編輯發貨信息';
$lang['store_deliver_first_step']			= '第一步';
$lang['store_deliver_second_step']			= '第二步';
$lang['store_deliver_third_step']			= '第三步';
$lang['store_deliver_confirm_trade']		= '確認收貨信息及交易詳情';
$lang['store_deliver_forget']				= '發貨備忘';
$lang['store_deliver_forget_tips']			= '您可以輸入一些發貨備忘信息（僅賣家自己可見）';
$lang['store_deliver_buyer_adress']			= '買家收貨信息';
$lang['store_deliver_confirm_daddress']		= '確認發貨信息';
$lang['store_deliver_my_daddress']			= '我的發貨信息';
$lang['store_deliver_none_set']				= '還未設置';
$lang['store_deliver_add_daddress']			= '添加發貨地址';
$lang['store_deliver_express_select']		= '選擇物流服務';
$lang['store_deliver_express_note']			= '您可以通過"發貨設置-><a href="index.php?act=store_deliver&op=express" target="_parent" >預設物流公司</a>"添加或修改常用貨運物流。免運或自提商品可切換下方<span class="red">[無需物流運輸服務]</span>選項卡並操作。';
$lang['store_deliver_express_zx']			= '自行聯繫物流公司';
$lang['store_deliver_express_wx']			= '無需物流運輸服務';
$lang['store_deliver_company_name']			= '公司名稱';
$lang['store_deliver_shipping_code']		= '物流單號';
$lang['store_deliver_bforget']				= '備忘';
$lang['store_deliver_shipping_code_tips']	= '正確填寫物流單號，確保快遞跟蹤查詢信息正確';
$lang['store_deliver_no_deliver_tips']		= '如果訂單中的商品無需物流運送(如綫下交易或虛擬物品)，您可以直接確認提交';
$lang['store_deliver_shipping_code_pl']		= '請填寫物流單號';

/**
 * 選擇發貨地址
 */
$lang['store_deliver_man']			= '發貨人';
$lang['store_deliver_daddress']		= '發貨地址';
$lang['store_deliver_post']			= '郵編';
$lang['store_deliver_telphone']		= '座機';
$lang['store_deliver_mobphone']		= '手機';

/**
 * 搜索動態物流
 */
$lang['member_show_expre_my_fdback']		= '我的留言';
$lang['member_show_expre_type']				= '發貨方式：自行聯繫';
$lang['member_show_expre_company']			= '物流公司';
$lang['member_show_receive_info']			= '收貨信息';
$lang['member_show_deliver_info']			= '發貨信息';