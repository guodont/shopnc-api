<?php
/**
 * mobile父类
 *
 *
 * by 33hao.com 好商城V3 运营版
 */


defined('InShopNC') or exit('Access Invalid!');

/********************************** 前台control父类 **********************************************/

class mobileControl{

    //客户端类型
    protected $client_type_array = array('android', 'wap', 'wechat', 'ios');
    //列表默认分页数
    protected $page = 5;


	public function __construct() {
        Language::read('mobile');

        //分页数处理
        $page = intval($_GET['page']);
        if($page > 0) {
            $this->page = $page;
        }
    }
}

class mobileHomeControl extends mobileControl{
	public function __construct() {
        parent::__construct();
    }
}

class mobileMemberControl extends mobileControl{

    protected $member_info = array();

	public function __construct() {
        parent::__construct();

        $model_mb_user_token = Model('mb_user_token');
        $key = $_POST['key'];
        if(empty($key)) {
            $key = $_GET['key'];
        }
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if(empty($mb_user_token_info)) {
            output_error('请登录', array('login' => '0'));
        }

        $model_member = Model('member');
        $this->member_info = $model_member->getMemberInfoByID($mb_user_token_info['member_id']);
        $this->member_info['client_type'] = $mb_user_token_info['client_type'];
        if(empty($this->member_info)) {
            output_error('请登录', array('login' => '0'));
        } else {
            //读取卖家信息
            $seller_info = Model('seller')->getSellerInfo(array('member_id'=>$this->member_info['member_id']));
            $this->member_info['store_id'] = $seller_info['store_id'];
        }
    }
}
