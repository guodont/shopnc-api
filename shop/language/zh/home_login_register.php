<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 *  登錄-公共語言	
 */

/**
 * 登錄-註冊
 */
$lang['login_register_input_username']		= "用戶名不能為空";
$lang['login_register_username_range']		= "用戶名必須在3-15個字元之間";
$lang['login_register_username_lettersonly']= "用戶名不能包含敏感字元";
$lang['login_register_username_exists']		= "該用戶名已經存在";
$lang['login_register_input_password']		= "密碼不能為空";
$lang['login_register_password_range']		= "密碼長度應在6-20個字元之間";
$lang['login_register_input_password_again']= "您必須再次確認您的密碼";
$lang['login_register_password_not_same']	= "兩次輸入的密碼不一致";
$lang['login_register_input_email']			= "電子郵箱不能為空";
$lang['login_register_invalid_email']		= "這不是一個有效的電子郵箱";
$lang['login_register_email_exists']		= "該電子郵箱已經存在";
$lang['login_register_input_text_in_image']	= "請輸入驗證碼";
$lang['login_register_code_wrong']			= "驗證碼不正確";
$lang['login_register_must_agree']			= "請閲讀並同意該協議";
$lang['login_register_join_us']				= "用戶註冊";
$lang['login_register_input_info']			= "填寫用戶註冊信息";
$lang['login_register_username']			= "用戶名";
$lang['login_register_username_to_login']	= "3-20位字元，可由中文、英文、數字及“_”、“-”組成";
$lang['login_register_pwd']					= "設置密碼";
$lang['login_register_password_to_login']	= "您的登錄密碼";
$lang['login_register_password_to_login']	= "6-20位字元，可由英文、數字及標點符號組成";
$lang['login_register_ensure_password']		= "確認密碼";
$lang['login_register_input_password_again']= "請再次輸入您的密碼";
$lang['login_register_email']				= "郵箱";
$lang['login_register_input_valid_email']	= "請輸入常用的郵箱，將用來找回密碼、接受訂單通知等";
$lang['login_register_code']				= "驗證碼";
$lang['login_register_click_to_change_code']= "看不清，換一張";
$lang['login_register_input_code']			= "請輸入驗證碼，不區分大小寫";
$lang['login_register_agreed']				= "閲讀並同意";
$lang['login_register_agreement']			= "服務協議";
$lang['login_register_regist_now']			= "立即註冊";
$lang['login_register_enter_now']			= "確認提交";
$lang['login_register_connect_now']			= "綁定帳號";
$lang['login_register_after_regist']		= "註冊之後您可以";
$lang['login_register_buy_info']			= "購買商品支付訂單";
$lang['login_register_collect_info']		= "收藏商品關注店舖";
$lang['login_register_honest_info']			= "安全交易誠信無憂";
$lang['login_register_openstore_info']		= "申請開店銷售商品";
$lang['login_register_sns_info']			= "空間好友推送分享";
$lang['login_register_talk_info']			= "商品諮詢服務評價";

$lang['login_register_already_have_account']= "如果您是本站用戶";
$lang['login_register_login_now_1']			= "我已經註冊過帳號，立即";
$lang['login_register_login_now_2']			= "登錄";
$lang['login_register_login_now_3']			= "或是";
$lang['login_register_login_forget']		= "找回密碼？";
/**
 * 登錄-用戶保存
 */
$lang['login_usersave_login_usersave_username_isnull']	= "用戶名不能為空";
$lang['login_usersave_password_isnull']			= "密碼不能為空";
$lang['login_usersave_password_not_the_same']	= "密碼與確認密碼不相同，請從重新輸入";
$lang['login_usersave_wrong_format_email']		= "電子郵件格式不正確，請重新填寫";
$lang['login_usersave_code_isnull']				= "驗證碼不能為空";
$lang['login_usersave_wrong_code']				= "驗證碼錯誤";
$lang['login_usersave_you_must_agree']			= "您必須同意服務條款才能註冊";
$lang['login_usersave_your_username_exists']	= "您填寫的用戶名稱已經存在，請您選擇其他用戶名填寫";
$lang['login_usersave_your_email_exists']		= "您填寫的郵箱已經存在，請您選擇其他郵箱填寫";
$lang['login_usersave_regist_success']			= "註冊成功";
$lang['login_usersave_regist_success_ajax'] 	= '歡迎來到site_name建議您儘快完善資料，祝您購物愉快！';
$lang['login_usersave_regist_fail']				= "註冊失敗";
/**
 * 密碼找回
 */
$lang['login_index_find_password']				    = '忘記密碼';
$lang['login_password_you_account']	= '登錄賬號';
$lang['login_password_you_email']	= '電子郵箱';
$lang['login_password_change_code']	= '看不清，換一張';
$lang['login_password_submit']		= '提交找回';
$lang['login_password_input_email']	= '電子郵箱不能為空';
$lang['login_password_wrong_email']	= '電子郵箱填寫錯誤';
/**
 * 找回處理
 */
$lang['login_password_enter_find']			= '即將進入找回密碼頁面……';
$lang['login_password_input_username']		= '請輸入登錄名稱';
$lang['login_password_username_not_exists']	= '登錄名稱不存在';
$lang['login_password_input_email']			= '請輸入郵箱地址';
$lang['login_password_email_not_exists']	= '郵箱地址錯誤';
$lang['login_password_email_fail']			= '郵件發送超時，請重新申請';
$lang['login_password_email_success']		= '郵件已經發出，請查收';
?>