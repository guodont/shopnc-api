<?php
/**
 * 前台control父类
 *
 */

defined('InShopNC') or exit('Access Invalid!');

/********************************** 前台control父类 **********************************************/

class BaseControl {
	public function __construct(){
		Language::read('common');
	}
}
