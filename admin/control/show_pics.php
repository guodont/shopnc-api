<?php
/**
 * 显示图片
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');

class show_picsControl extends SystemControl {

	public function __construct() {
        parent::__construct();
    }

	public function indexOp(){

        $type = trim($_GET['type']);
        if(empty($_GET['pics'])) {
            $this->goto_index();
        }
        $pics = explode('|',trim($_GET['pics']));
        $pic_path = '';
        switch ($type) {
            case 'inform':
                $pic_path = UPLOAD_SITE_URL.'/shop/inform/';
                break;
            case 'complain':
                $pic_path = UPLOAD_SITE_URL.'/shop/complain/';
                break;
            default:
                $this->goto_index();
                break;
        }

        Tpl::output('pic_path',$pic_path);
		Tpl::output('pics',$pics);
		//输出页面
		Tpl::showpage('show_pics','blank_layout');
	}

    private function goto_index() {
	    @header("Location: index.php");
		exit;
    }
}
