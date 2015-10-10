<?php
/**
 * 微商城个人中心 
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class homeControl extends MircroShopControl{

    private $member_info = array();
	public function __construct() {
		parent::__construct();
        $member_info = array();
        $owner_flag = TRUE;
        $member_id = $_SESSION['member_id'];
        if(isset($_GET['member_id']) && intval($_GET['member_id']) > 0) {
            $member_id = $_GET['member_id'];
            if($_GET['member_id'] != $_SESSION['member_id']) {
                $owner_flag = FALSE;
            }
        }
        if(empty($member_id)) {
            header('Location: '.MICROSHOP_SITE_URL);die;
        }
        $model_member = Model('member');
        $member_info = $model_member->infoMember(array('member_id'=>$member_id));
        if(!empty($member_info)) {
            $this->member_info = $member_info;
            $member_info = self::get_member_detail_info($member_info);
            if(!$member_info) {
                header('location: '.MICROSHOP_SITE_URL);die;
            }
            Tpl::output('member_info',$member_info);
        } else {
            header('Location: '.MICROSHOP_SITE_URL);die;
        }

        //是否本人标志
        Tpl::output('owner_flag',$owner_flag);

        //访问计数
        $model_micro_member_info = Model('micro_member_info');
        $visit_count = $model_micro_member_info->updateMemberVisitCount($member_info['member_id']);
        Tpl::output('visit_count',$visit_count);

        //是否关注
        if(!empty($_SESSION['member_id']) && !$owner_flag) {
            $model = Model();
            $gz_array	= $model->table('sns_friend')->where(array('friend_frommid'=>$_SESSION['member_id'], 'friend_tomid'=>array('in', $member_info['member_id'])))->select();
            if(empty($gz_array)) {
                Tpl::output('follow_flag',TRUE);
            } else {
                Tpl::output('follow_flag',FALSE);
            }
        }
        Tpl::output('html_title',$member_info['member_name'].'-'.Language::get('nc_microshop').'-'.C('site_name'));
        Tpl::output('index_sign','');
    }

    //首页
    public function indexOp(){
        $this->goodsOp();
    }

    public function goodsOp(){

        self::get_goods_list(array('commend_member_id'=>$this->member_info['member_id']));
        Tpl::output('home_sign','goods');
        Tpl::showpage('home');
    }

    public function personalOp(){
        if(isset($_GET['publish'])) {
            self::check_login();
        }
        self::get_personal_class_list();
        self::get_personal_list(array('commend_member_id'=>$this->member_info['member_id']));
        self::get_share_app_list();
        Tpl::output('home_sign','personal');
        if($this->member_info['member_id'] == $_SESSION['member_id']) {
            Tpl::output('publish_flag',TRUE);
        }
        Tpl::showpage('home');
    }


    //专辑
    public function albumOp(){
        Tpl::output('home_sign','album');
        Tpl::showpage('home');
    }

    /**
     * 用户发布删除
     **/
    public function home_dropOp() {
        $data['result'] = 'false';
        $data['message'] = Language::get('nc_common_del_fail');
        if(empty($_SESSION['member_id'])) {
            self::return_json(Language::get('no_login'),'false');
        }
        $item_id = intval($_GET['item_id']);
        if($item_id > 0) {
            $result = FALSE;
            switch(strval($_GET['type'])) {
            case 'goods':
                $result = $this->publish_drop('commend_id');
                //计数
                $model_micro_member_info = Model('micro_member_info');
                $model_micro_member_info->updateMemberGoodsCount($_SESSION['member_id'],'-');
                break;
            case 'personal':
                $result = $this->publish_drop('personal_id');
                //计数
                $model_micro_member_info = Model('micro_member_info');
                $model_micro_member_info->updateMemberPersonalCount($_SESSION['member_id'],'-');
                break;
            }
            if($result) {
                $data['result'] = 'true';
                $data['message'] = Language::get('nc_common_del_succ');
            }
        }
        self::echo_json($data);
    }

    private function publish_drop($key) {
        $model = Model("micro_{$_GET['type']}");
        $info = $model->getOne(array($key=>$_GET['item_id']));
        $result = FALSE;
        if($info['commend_member_id'] == $_SESSION['member_id']) {
            $result = $model->drop(array($key=>$_GET['item_id']));
            //删除个人秀图片
            if($result && $_GET['type'] == 'personal') {
                self::drop_personal_image($info['commend_image']);
            }
        }
        return $result;
    }

    /*
     * 喜欢列表
     */
    public function like_listOp() {
        $type = 'goods';
        if(isset($_GET['type'])) {
            $type = $_GET['type'];
        }
        $model_like = Model('micro_like');
        $condition = array();
        $condition['like_member_id'] = $this->member_info['member_id'];
        $type_array = self::get_channel_type($type);
        $condition['like_type'] = $type_array['type_id'];
        switch ($type) {
        case 'personal':
            Tpl::output('list',$model_like->getPersonalList($condition,35));
            break;
        case 'album':
            Tpl::output('list',array());
            break;
        case 'store':
            $like_store_list = $model_like->getStoreList($condition,30);
            $store_list = array();
            if(!empty($like_store_list)) {
                $store_id = '';
                foreach ($like_store_list as $value) {
                    $store_id .= $value['like_object_id'].',';
                }
                $store_id = rtrim($store_id, ',');
                
                $model_microshop_store = Model('micro_store');
                $store_list = $model_microshop_store->getListWithStoreInfo(array('shop_store_id' => array('in' , $store_id)), null, 'microshop_sort asc');
            }
            $like_store_list = array_under_reset($like_store_list, 'like_object_id');
            Tpl::output('like_store_list', $like_store_list);
            Tpl::output('list',$store_list);
            break;
        default:
            Tpl::output('list',$model_like->getGoodsList($condition,35));
            break;
        }
        Tpl::output('show_page',$model_like->showpage(2));	
        Tpl::output('home_sign','like');
        Tpl::output('like_sign',$type);
        Tpl::showpage('home');
    }

    /**
     * 加关注
     */
    public function add_followOp() {
        $data = array();
        $member_id = intval($_GET['member_id']);
        if($member_id<=0){
            self::return_json(Language::get('wrong_argument'),'false');
        }
        if(empty($_SESSION['member_id'])) {
            self::return_json(Language::get('no_login'),'false');
        }

        //验证会员信息
        $member_model = Model('member');
        $condition_arr = array();
        $condition_arr['member_state'] = 1;
        $condition_arr['member_id'] = array('in', array($member_id,$_SESSION['member_id']));
        $member_list = $member_model->getMemberList($condition_arr);
        if(empty($member_list)){
            self::return_json(Language::get('nc_common_save_fail'),'false');
        }
        $self_info = array();
        $member_info = array();
        foreach($member_list as $k=>$v){
            if($v['member_id'] == $_SESSION['member_id']){
                $self_info = $v;
            }else{
                $member_info = $v;
            }
        }
        if(empty($self_info) || empty($member_info)){
            self::return_json(Language::get('nc_common_save_fail'),'false');
        }
        //验证是否已经存在好友记录
        $friend_model = Model('sns_friend');
        $friend_count = $friend_model->countFriend(array('friend_frommid'=>$_SESSION['member_id'],'friend_tomid'=>$member_id));
        if($friend_count >0 ){
            self::return_json('re','true');
        }
        //查询对方是否已经关注我，从而判断关注状态
        $friend_info = $friend_model->getFriendRow(array('friend_frommid'=>"{$member_id}",'friend_tomid'=>"{$_SESSION['member_id']}"));
        $insert_arr = array();	
        $insert_arr['friend_frommid'] = "{$self_info['member_id']}";
        $insert_arr['friend_frommname'] = "{$self_info['member_name']}";
        $insert_arr['friend_frommavatar'] = "{$self_info['member_avatar']}";
        $insert_arr['friend_tomid'] = "{$member_info['member_id']}";
        $insert_arr['friend_tomname'] = "{$member_info['member_name']}";
        $insert_arr['friend_tomavatar'] = "{$member_info['member_avatar']}";
        $insert_arr['friend_addtime'] = time();
        if(empty($friend_info)){
            $insert_arr['friend_followstate'] = '1';//单方关注
        }else{
            $insert_arr['friend_followstate'] = '2';//双方关注
        }
        $result = $friend_model->addFriend($insert_arr);
        if($result){
            //更新对方关注状态
            if(!empty($friend_info)){
                $friend_model->editFriend(array('friend_followstate'=>'2'),array('friend_id'=>"{$friend_info['friend_id']}"));
            }
            self::return_json(Language::get('nc_common_save_succ'),'true');
        }else{
            self::return_json(Language::get('nc_common_save_fail'),'false');
        }
    }

    /**
     * 取消关注 
     */
    public function del_followOp() {
        $member_id = intval($_GET['member_id']);
        if($member_id<=0){
            self::return_json(Language::get('wrong_argument'),'false');
        }
        if(empty($_SESSION['member_id'])) {
            self::return_json(Language::get('no_login'),'false');
        }
        $friend_model = Model('sns_friend');
        $result = $friend_model->delFriend(array('friend_frommid'=>$_SESSION['member_id'],'friend_tomid'=>$member_id));
        if($result){
            //更新对方的关注状态
            $friend_model->editFriend(array('friend_followstate'=>'1'),array('friend_frommid'=>"$member_id",'friend_tomid'=>"{$_SESSION['member_id']}"));
            self::return_json(Language::get('nc_common_save_succ'),'true');
        }else{
            self::return_json(Language::get('nc_common_save_fail'),'false');
        }
    }
}
