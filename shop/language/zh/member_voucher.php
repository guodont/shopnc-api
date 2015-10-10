<?php
defined('InShopNC') or exit('Access Invalid!');
$lang['voucher_unavailable']    = '代金券功能尚未開啟';
$lang['voucher_applystate_new']    = '待審核';
$lang['voucher_applystate_verify']    = '已審核';
$lang['voucher_applystate_cancel']    = '已取消';
$lang['voucher_quotastate_activity']	= '正常';
$lang['voucher_quotastate_cancel']    = '取消';
$lang['voucher_quotastate_expire']    = '結束';
$lang['voucher_templatestate_usable']	= '有效';
$lang['voucher_templatestate_disabled']= '失效';
$lang['voucher_quotalist']= '套餐列表';
$lang['voucher_applyquota']= '申請套餐';
$lang['voucher_applyadd']= '購買套餐';
$lang['voucher_templateadd']= '新增代金券';
$lang['voucher_templateedit']= '編輯代金券';
$lang['voucher_templateinfo']= '代金券詳細';
/**
 * 套餐申請
 */
$lang['voucher_apply_num_error']= '數量不能為空，且必須為1-12之間的整數';
$lang['voucher_apply_goldnotenough']= "當前您擁有金幣數為%s，不足以支付此次交易，請先充值";
$lang['voucher_apply_fail']= '套餐申請失敗';
$lang['voucher_apply_succ']= '套餐申請成功，請等待審核';
$lang['voucher_apply_date']= '申請日期';
$lang['voucher_apply_num']    		= '申請數量';
$lang['voucher_apply_addnum']    		= '套餐購買數量';
$lang['voucher_apply_add_tip1']    		= '購買單位為月(30天)，一次最多購買12個月，您可以在所購買周期內以月為單位發佈代金券活動';
$lang['voucher_apply_add_tip2']    		= '每月您需要支付%s金幣';
$lang['voucher_apply_add_tip3']    		= '每月最多發佈活動%s次';
$lang['voucher_apply_add_tip4']    		= '套餐時間從審批後開始計算';
$lang['voucher_apply_add_confirm1']    	= '您總共需要支付';
$lang['voucher_apply_add_confirm2']    	= '金幣,確認購買嗎？';
$lang['voucher_apply_goldlog']    		= '購買代金券活動%s個月，單價%s金幣，總共花費%s金幣';
$lang['voucher_apply_buy_succ']			= '套餐購買成功';

/**
 * 套餐
 */
$lang['voucher_quota_startdate']    	= '開始時間';
$lang['voucher_quota_enddate']    		= '結束時間';
$lang['voucher_quota_timeslimit']    	= '活動次數限制';
$lang['voucher_quota_publishedtimes']   = '已發佈活動次數';
$lang['voucher_quota_residuetimes']    	= '剩餘活動次數';
/**
 * 代金券模板
 */
$lang['voucher_template_quotanull']			= '當前沒有可用的套餐，請先申請套餐';
$lang['voucher_template_noresidual']		= "當前套餐中活動已滿%s條活動信息，不可再發佈活動";
$lang['voucher_template_pricelisterror']	= '平台代金券面額設置出現問題，請聯繫客服幫助解決';
$lang['voucher_template_title_error'] 		= "模版名稱不能為空且不能大於50個字元";
$lang['voucher_template_total_error'] 		= "可發放數量不能為空且必須為整數";
$lang['voucher_template_price_error']		= "模版面額不能為空且必須為整數，且面額不能大於限額";
$lang['voucher_template_limit_error'] 		= "模版使用消費限額不能為空且必須是數字";
$lang['voucher_template_describe_error'] 	= "模版描述不能為空且不能大於255個字元";
$lang['voucher_template_title']			= '代金券名稱';
$lang['voucher_template_enddate']		= '有效期';
$lang['voucher_template_enddate_tip']		= '有效期應在套餐有效期內，正使用的套餐有效期為';
$lang['voucher_template_price']			= '面額';
$lang['voucher_template_total']			= '可發放總數';
$lang['voucher_template_eachlimit']		= '每人限領';
$lang['voucher_template_eachlimit_item']= '不限';
$lang['voucher_template_eachlimit_unit']= '張';
$lang['voucher_template_orderpricelimit']	= '消費金額';
$lang['voucher_template_describe']		= '代金券描述';
$lang['voucher_template_styleimg']		= '選擇代金券皮膚';
$lang['voucher_template_styleimg_text']	= '店舖優惠券';
$lang['voucher_template_image']			= '代金券圖片';
$lang['voucher_template_image_tip']		= '該圖片將在積分中心的代金券模組中顯示，建議尺寸為160*160px。';
$lang['voucher_template_list_tip1'] = "1、手工設置代金券失效後,用戶將不能領取該代金券,但是已經領取的代金券仍然可以使用";
$lang['voucher_template_list_tip2'] = "2、代金券模版和已發放的代金券過期後自動失效";
$lang['voucher_template_backlist'] 	= "返回列表";
$lang['voucher_template_giveoutnum']= '已領取';
$lang['voucher_template_usednum']	= '已使用';
/**
 * 代金券
 */
$lang['voucher_voucher_state'] = "狀態";
$lang['voucher_voucher_state_unused'] = "未使用";
$lang['voucher_voucher_state_used'] = "已使用";
$lang['voucher_voucher_state_expire'] = "已過期";
$lang['voucher_voucher_price'] = "金額";
$lang['voucher_voucher_storename'] = "適用店舖";
$lang['voucher_voucher_indate'] = "有效期";
$lang['voucher_voucher_usecondition'] = "使用條件";
$lang['voucher_voucher_usecondition_desc'] = "訂單滿";
$lang['voucher_voucher_vieworder'] = "查看訂單";
$lang['voucher_voucher_readytouse'] = "馬上使用";
$lang['voucher_voucher_code'] = "編碼";
?>