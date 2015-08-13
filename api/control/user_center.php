<?php
/**
 * 用户中心接口
 * @author guodont
 *
 */

defined('InShopNC') or exit('Access Invalid!');
class user_centerControl extends apiHomeControl {

    private $member_id;

    public function __construct() {
        parent::__construct();

        if(!isset($_GET['uid'])||$_GET['uid']<=0){
            output_error("缺少用户id参数");die;
        }

        //TODO 查找uid是否存在，不存在则输出错误信息
        $this->member_id = $_GET['uid'];

    }

    /**
     * 性别处理方法
     * @param $sextype
     * @return string
     */
    private function m_sex($sextype){
        switch ($sextype){
            case 1:
                return 'male';
                break;
            case 2:
                return 'female';
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * GET 用户信息及等级信息，含用户积分，粉丝数，关注数
     */
    public function user_infoOp() {
        $member_info = array();
        $member = array();
        //会员详情及会员级别处理
        $model_member = Model('member');
        $friend_model = Model('sns_friend');
        $member_info = $model_member->getMemberInfoByID($this->member_id);
        //关注数及粉丝数
        $following_count = $friend_model->countFriend(array('friend_frommid'=>"$this->member_id"));
        $follower_count = $friend_model->countFriend(array('friend_tomid'=>"$this->member_id"));
        if ($member_info){
            $member['member_id'] = $member_info['member_id'];
            $member['member_name'] = $member_info['member_name'];
            $member['member_avatar'] = $member_info['member_avatar'];
            $member['member_sex'] = $this->m_sex($member_info['member_sex']);
            $member['member_email'] = $member_info['member_email'];
            $member['member_birthday'] = $member_info['member_birthday'];
            $member['member_mobile'] = $member_info['member_mobile'];
            $member['member_cityid'] = $member_info['member_cityid'];
            $member['member_provinceid'] = $member_info['member_provinceid'];
            $member['level'] = $member_info['level'];
            $member['level_name'] = $member_info['level_name'];
            $member['member_points'] = $member_info['member_points'];
            $member['member_exppoints'] = $member_info['member_exppoints'];
            $member['following_count'] = $following_count;
            $member['follower_count'] = $follower_count;
        }else{
            output_error("用户不存在");
        }
        output_data(array('user_info'=>$member));
    }

    /**
     * GET 用户所有粉丝
     */
    public function followersOp() {
        $friend_model = Model('sns_friend');
        //粉丝列表
        //设置每页数量和总数！！！
        $page = new Page();
        pagecmd('setEachNum',$this->page);
//        pagecmd('setTotalNum',$friend_model->count());
        $field = 'member_id,member_name,member_avatar,member_sex';
        $fan_list = $friend_model->listFriend(array('friend_tomid'=>$this->member_id),$field,$page,'fromdetail');
        if (!empty($fan_list)){
            foreach ($fan_list as $k=>$v){
                $v['member_sex'] = $this->m_sex($v['member_sex']);
                $fan_list[$k] = $v;
            }
        }
        $pageCount = pagecmd('gettotalpage',$this->page);
        output_data(array('followers'=>$fan_list),mobile_page($pageCount));
    }

    /**
     * GET 用户所有关注人
     */
    public function followingOp() {
        $friend_model = Model('sns_friend');
        //关注列表
        $page = new Page();
        pagecmd('setEachNum',$this->page);
        $field = 'member_id,member_name,member_avatar,member_sex';
        $follow_list = $friend_model->listFriend(array('friend_frommid'=>$this->member_id),$field,$page,'detail');
        if (!empty($follow_list)){
            foreach ($follow_list as $k=>$v){
                $v['sex_class'] = $this->m_sex($v['member_sex']);
                $follow_list[$k] = $v;
            }
        }
        $pageCount = pagecmd('gettotalpage',$this->page);
        output_data(array('followings'=>$follow_list),mobile_page($pageCount));
    }

    /**
     * GET 商品收藏列表
     */
    public function goods_favorites_listOp() {
        $model_favorites = Model('favorites');

        $favorites_list = $model_favorites->getGoodsFavoritesList(array('member_id'=>$this->member_id), '*', $this->page);
        $page_count = $model_favorites->gettotalpage();
        $favorites_id = '';
        foreach ($favorites_list as $value){
            $favorites_id .= $value['fav_id'] . ',';
        }
        $favorites_id = rtrim($favorites_id, ',');

        $model_goods = Model('goods');
        $field = 'goods_id,goods_name,goods_price,goods_image,store_id';
        $goods_list = $model_goods->getGoodsList(array('goods_id' => array('in', $favorites_id)), $field);
        foreach ($goods_list as $key=>$value) {
            $goods_list[$key]['fav_id'] = $value['goods_id'];
            $goods_list[$key]['goods_image_url'] = cthumb($value['goods_image'], 240, $value['store_id']);
        }

        output_data(array('goods_favorites_list' => $goods_list), mobile_page($page_count));
    }



    /**
     * GET 用户的圈子
     */
    public function user_circlesOp(){
        $model = Model();
        $cm_list = $model->table('circle_member')->where(array('member_id'=>$this->member_id))->order('cm_jointime desc')->select();
        if(!empty($cm_list)){
            $cm_list = array_under_reset($cm_list, 'circle_id'); $circleid_array = array_keys($cm_list);
            $circle_list = $model->table('circle')->where(array('circle_id'=>array('in', $circleid_array)))->select();
        }else{
            output_error("没有加入的圈子");die;
        }
        output_data(array('circle_list'=>$circle_list));
    }

    /**
     * GET 用户的话题
     */
    public function user_themesOp(){
        $model = Model();
        $m_theme = $model->table('circle_theme')->where(array('member_id'=>$this->member_id));
        //设置每页数量和总数！！！
        pagecmd('setEachNum',$this->page);
        pagecmd('setTotalNum',$m_theme->count());
        $pageCount = $m_theme->gettotalpage();
        $theme_list = $m_theme->page($this->page)->order('theme_id desc')->select();
        if(empty($theme_list)){
            output_error("当前用户没有发布任何话题");die;
        }
        output_data(array('themes'=>$theme_list),mobile_page($pageCount));
    }
}