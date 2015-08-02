<?php
/**
 * 手机端下载地址
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class mb_appControl extends BaseHomeControl {
    public function __construct() {
        parent::__construct();
    }
	/**
	 * 下载地址
	 *
	 */
    public function indexOp() {
		$mobilebrowser_list ='iphone|ipad';
		if(preg_match("/$mobilebrowser_list/i", $_SERVER['HTTP_USER_AGENT'])) {
		    @header('Location: '.C('mobile_ios'));exit;
        } else {
            @header('Location: '.C('mobile_apk'));exit;
        }
    }
}
