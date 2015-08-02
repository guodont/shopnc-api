<?php
defined('InShopNC') or exit('Access Invalid!');
$lang['admin_voucher_unavailable']    = '請確認代金券、積分、金幣均以開啟';
$lang['admin_voucher_applystate_new']    = '待審核';
$lang['admin_voucher_applystate_verify']    = '已審核';
$lang['admin_voucher_applystate_cancel']    = '已取消';
$lang['admin_voucher_quotastate_activity']	= '正常';
$lang['admin_voucher_quotastate_cancel']    = '取消';
$lang['admin_voucher_quotastate_expire']    = '結束';
$lang['admin_voucher_templatestate_usable']	= '有效';
$lang['admin_voucher_templatestate_disabled']= '失效';
$lang['admin_voucher_storename']			= '店舖名稱';
$lang['admin_voucher_cancel_confirm']    	= '您確認進行取消操作嗎？';
$lang['admin_voucher_verify_confirm']    	= '您確認進行審核操作嗎？';
//菜單
$lang['admin_voucher_apply_manage']= '套餐申請管理';
$lang['admin_voucher_quota_manage']= '套餐管理';
$lang['admin_voucher_template_manage']= '店舖代金券';
$lang['admin_voucher_template_edit']= '編輯代金券';
$lang['admin_voucher_setting']		= '設置';
$lang['admin_voucher_pricemanage']		= '面額設置';
$lang['admin_voucher_priceadd']		= '添加面額';
$lang['admin_voucher_priceedit']		= '面額編輯';
$lang['admin_voucher_styletemplate']	= '樣式模板';
/**
 * 設置
 */
$lang['admin_voucher_setting_price_error']		= '購買單價應為大於0的整數';
$lang['admin_voucher_setting_storetimes_error']	= '每月活動數量應為大於0的整數';
$lang['admin_voucher_setting_buyertimes_error']	= '最大領取數量應為大於0的整數';
$lang['admin_voucher_setting_price']			= '購買單價（金幣/月）';
$lang['admin_voucher_setting_price_tip']		= '購買代金劵活動所需的金幣數，購買後賣家可以在所購買周期內發佈代金劵促銷活動';
$lang['admin_voucher_setting_storetimes']		= '每月活動數量';
$lang['admin_voucher_setting_storetimes_tip']	= '每月最多可以發佈的代金劵促銷活動數量';
$lang['admin_voucher_setting_buyertimes']		= '買家最大領取數量';
$lang['admin_voucher_setting_buyertimes_tip']	= '買家最多只能擁有同一個店舖尚未消費抵用的店舖代金券最大數量';
//$lang['admin_voucher_setting_default_styleimg']	= '代金券預設樣式模板';
/**
 * 代金券面額
 */
$lang['admin_voucher_price_error']   		= '代金券面額應為大於0的整數';
$lang['admin_voucher_price_describe_error'] = '描述不能為空';
$lang['admin_voucher_price_describe_lengtherror'] = '代金券描述不能為空且不能大於255個字元';
$lang['admin_voucher_price_points_error']   = '預設兌換積分數應為大於0的整數';
$lang['admin_voucher_price_exist']    		= '該代金券面額已經存在';
$lang['admin_voucher_price_title']    		= '代金券面額';
$lang['admin_voucher_price_describe']    	= '描述';
$lang['admin_voucher_price_points']    		= '預設兌換積分數';
$lang['admin_voucher_price_points_tip']    	= '當賣家發佈代金券活動時，代金券活動預設消耗的積分數';
$lang['admin_voucher_price_tip1']    	= '管理員規定代金券面額，店舖發放代金券時面額從規定的面額中選擇';
/**
 * 代金券套餐申請
 */
$lang['admin_voucher_apply_goldnotenough']	= '該會員金幣不夠，操作失敗';
$lang['admin_voucher_apply_goldlog']    	= '購買代金券活動%s個月，單價%s金幣，總共花費%s金幣';
$lang['admin_voucher_apply_message']    	= '您成功購買代金券活動%s個月，單價%s金幣，總共花費%s金幣，時間從審核後開始計算';
$lang['admin_voucher_apply_verifysucc']    	= '申請審核成功，活動套餐已經發放';
$lang['admin_voucher_apply_verifyfail']    	= '申請審核失敗';
$lang['admin_voucher_apply_cancelsucc']    	= '申請取消成功';
$lang['admin_voucher_apply_cancelfail']    	= '申請取消失敗';
$lang['admin_voucher_apply_list_tip1']    	= '對賣家的套餐申請進行審核，審核後系統會使用站內信通知賣家';
$lang['admin_voucher_apply_list_tip2']    	= '當賣家金幣不足時審核會失敗，賣家發佈成功的代金券會出現在積分中心，買家可憑積分進行兌換';
$lang['admin_voucher_apply_num']    		= '申請數量';
$lang['admin_voucher_apply_date']    		= '申請日期';
/**
 * 代金券套餐
 */
$lang['admin_voucher_quota_cancelsucc']    	= '套餐取消成功';
$lang['admin_voucher_quota_cancelfail']    	= '套餐取消失敗';
$lang['admin_voucher_quota_tip1']    	= '取消操作後不可恢復，請慎重操作';

$lang['admin_voucher_quota_startdate']    	= '開始時間';
$lang['admin_voucher_quota_enddate']    	= '結束時間';
$lang['admin_voucher_quota_timeslimit']    	= '活動次數限制';
$lang['admin_voucher_quota_publishedtimes']    	= '已發佈活動次數';
$lang['admin_voucher_quota_residuetimes']    	= '剩餘活動次數';
/**
 * 代金券
 */
$lang['admin_voucher_template_points_error']	= '兌換所需積分數應為大於0的整數';
$lang['admin_voucher_template_title']			= '代金券名稱';
$lang['admin_voucher_template_enddate']			= '有效期';
$lang['admin_voucher_template_price']			= '面額';
$lang['admin_voucher_template_total']			= '可發放總數';
$lang['admin_voucher_template_eachlimit']		= '每人限領';
$lang['admin_voucher_template_orderpricelimit']	= '消費金額';
$lang['admin_voucher_template_describe']		= '代金券描述';
$lang['admin_voucher_template_styleimg']		= '選擇代金券皮膚';
$lang['admin_voucher_template_image']			= '代金券圖片';
$lang['admin_voucher_template_points']			= '兌換所需積分數';
$lang['admin_voucher_template_adddate']			= '添加時間';
$lang['admin_voucher_template_list_tip']		= '手工設置代金券失效後,用戶將不能領取該代金券,但是已經領取的代金券仍然可以使用';
$lang['admin_voucher_template_giveoutnum']		= '已領取';
$lang['admin_voucher_template_usednum']			= '已使用';
?>