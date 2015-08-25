<?php
/**
 * api父类
 *
 *
 * by 33hao.com 好商城V3 运营版
 */


defined('InShopNC') or exit('Access Invalid!');

/********************************** 前台control父类 **********************************************/

class apiControl{

    //客户端类型
    protected $client_type_array = array('android', 'wap', 'wechat', 'ios');
    //列表默认分页数
    protected $page = 5;


	public function __construct() {
        Language::read('api');

        //分页数处理
        $page = intval($_GET['page']);
        if($page > 0) {
            $this->page = $page;
        }
    }
}

class apiHomeControl extends apiControl{
	public function __construct() {
        parent::__construct();
    }
}

class apiMemberControl extends apiControl{

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

/**
 * Class apiBaseCircleControl
 * 圈子API父类
 */
class apiBaseCircleControl extends apiMemberControl{
    protected $identity = 0;	// 身份	0游客 1圈主 2管理 3成员 4申请中 5申请失败 6禁言
    protected $c_id = 0;		// 圈子id
    protected $cm_info = array();	// Members of the information
    protected $m_readperm = 0;	// Members read permissions
    protected $super = 0;

    public function __construct(){

        parent::__construct();

        if(!isset($_GET['c_id']))
        {
            $this->c_id = intval($_POST['c_id']);
        }else{
            $this->c_id = intval($_GET['c_id']);
        }
        if($this->c_id <= 0){
            output_error("圈子id错误",array('code'=>403));
        }

        $this->checkSuper();

    }

    /**
     * 是否超管
     */
    private function checkSuper() {
        if(!empty($this->member_info)){
            $super = Model('circle_member')->getSuperInfo(array('member_id' => $this->member_info['member_id']));
            $this->super = empty($super) ? 0 : 1;
        }
    }



    /**
     * 会员信息
     */
    protected function memberInfo(){
        if (!empty($this->member_info)) {
            $this->cm_info = Model()->table('circle_member')->where(array('circle_id' => $this->c_id, 'member_id' => $this->member_info['member_id']))->find();
//            var_dump($this->cm_info);
//            var_dump(!empty($this->cm_info));
            if (!empty($this->cm_info)) {
                switch (intval($this->cm_info['cm_state'])) {
                    case 1:
                        $this->identity = intval($this->cm_info['is_identity']);
                        break;
                    case 0:
                        $this->identity = 4;
                        break;
                    case 2:
                        $this->identity = 5;
                        break;
                }
                // 禁言
                if ($this->cm_info['is_allowspeak'] == 0) {
                    $this->identity = 6;
                }
            }
//            Tpl::output('cm_info', $this->cm_info);
        }else{
            output_error('请登录', array('login' => '0'));
        }
    }

    /**
     * 阅读权限
     */
    protected function readPermissions($cm_info){
        $data = rkcache('circle_level') ? rkcache('circle_level') : rkcache('circle_level', true);
        $rs = array();
        $rs[0] = 0;
        $rs[0] = L('circle_no_limit');
        foreach ($data as $v){
            $rs[$v['mld_id']]	= $v['mld_name'];
        }
        switch ($cm_info['is_identity']){
            case 1:
            case 2:
                $rs['255'] = L('circle_administrator');
                $this->m_readperm = 255;
                return $rs;
                break;
            case 3:
                $rs = array_slice($rs, 0, intval($cm_info['cm_level'])+1, true);
                $this->m_readperm = $cm_info['cm_level'];
                return $rs;
                break;
        }
    }

    /**
     * 圈子信息
     */
    protected function circleInfo(){
        // 圈子信息
        $this->circle_info = Model()->table('circle')->find($this->c_id);
        if(empty($this->circle_info))
            output_error('未获取到圈子信息');
    }
}

/**
 * Class apiBaseCircleThemeControl
 * 圈子话题API父类
 */
class apiBaseCircleThemeControl extends apiMemberControl{
    protected $circle_info = array();	// 圈子详细信息
    protected $t_id = 0;		// 话题id
    protected $theme_info = array();	// 话题详细信息
    protected $r_id = 0;		// 回复id
    protected $reply_info = array();	// reply info
    protected $cm_info = array();		// Members of the information

    public function __construct(){
        parent::__construct();
        if(!isset($_GET['r_id']))
        {
            $this->r_id = intval($_POST['r_id']);
        }else{
            $this->r_id = intval($_GET['r_id']);
        }

        if(!isset($_GET['t_id'])){
            $this->t_id = $_POST['t_id'];
        }else{
            $this->t_id = intval($_GET['t_id']);
        }

        if($this->t_id <= 0){
            output_error("话题id错误",array('code'=>403));
        }

    }
    /**
     * 话题信息
     */
    protected function themeInfo(){

        $this->theme_info = Model()->table('circle_theme')->where(array('theme_id'=>$this->t_id))->find();
        if(empty($this->theme_info)){
            output_error("话题不存在",array('code'=>404));
        }
    }
    /**
     * 验证回复
     */
    protected function checkReplySelf(){
        if($this->t_id <= 0){
            output_error(L('wrong_argument'),array('code'=>503));
        }
        if($this->r_id <= 0){
            output_error(L('wrong_argument'),array('code'=>503));
        }
        $this->reply_info = Model()->table('circle_threply')->where(array('theme_id'=>$this->t_id, 'reply_id'=>$this->r_id, 'member_id'=>$_SESSION['member_id']))->find();
        if(empty($this->reply_info)){
            output_error(L('wrong_argument'),array('code'=>503));
        }
    }
    /**
     * 验证话题
     */
    protected function checkThemeSelf(){
        $this->t_id = intval($_GET['t_id']);
        if($this->t_id <= 0){
            output_error(L('wrong_argument'),array('code'=>503));
        }
        $this->theme_info = Model()->table('circle_theme')->where(array('theme_id'=>$this->t_id, 'member_id'=>$_SESSION['member_id']))->find();
        if(empty($this->theme_info)){
            output_error(L('wrong_argument'),array('code'=>503));
        }
    }

    /**
     * 圈子信息
     */
    protected function circleInfo(){
        // 圈子信息
        $this->circle_info = Model()->table('circle')->find($this->c_id);
        if(empty($this->circle_info))
            output_error('未获取到圈子信息');
    }
}