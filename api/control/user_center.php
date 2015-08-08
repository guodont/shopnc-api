<?php
/**
 * 用户中心接口
 * @author guodont
 *
 */

defined('InShopNC') or exit('Access Invalid!');
class circleControl extends apiHomeControl {

    private $member_id;



    public function __construct() {
        parent::__construct();

        if(!isset($_GET['uid'])){
            output_error("缺少用户id参数");
        }

        //TODO 查找uid是否存在，不存在则输出错误信息
        $this->member_id = $_GET['uid'];

    }

    /**
     * GET 用户信息及等级信息，含用户积分
     */

    public function gradeOp() {
        $member_info = array();
        //会员详情及会员级别处理
        $model_member = Model('member');
        $member_info = $model_member->getMemberInfoByID($_SESSION['member_id']);
        if ($member_info){
            $member_gradeinfo = $model_member->getOneMemberGrade(intval($member_info['member_exppoints']));
            $member_info = array_merge($member_info,$member_gradeinfo);
        }else{
            output_error("用户不存在");
        }
        output_data(array('user_info'=>$member_info));
    }

    /**
     * GET 用户所有粉丝
     */
    public function followersOp() {
        $friend_model = Model('sns_friend');
        //粉丝列表
        //设置每页数量和总数！！！
        pagecmd('setEachNum',$this->page);
//        pagecmd('setTotalNum',$friend_model->count());
        $fan_list = $friend_model->listFriend(array('friend_tomid'=>$this->member_id),'*',$this->page,'fromdetail');
        if (!empty($fan_list)){
            foreach ($fan_list as $k=>$v){
                $v['sex_class'] = $this->m_sex($v['member_sex']);
                $fan_list[$k] = $v;
            }
        }
        $pageCount = pagecmd('gettotalpage',$this->page);
        output_data(array('followers'=>$fan_list),mobile_page($pageCount));
    }

    /**
     * GET 用户所有关注人
     */
    public function followOp() {
        $friend_model = Model('sns_friend');
        //关注列表
        pagecmd('setEachNum',$this->page);
        $follow_list = $friend_model->listFriend(array('friend_frommid'=>$this->member_id),'*',$this->page,'detail');
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
     * GET 用户积分数
     */





}