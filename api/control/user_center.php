<?php
/**
 * 用户中心接口
 * @author guodont
 *
 */

defined('InShopNC') or exit('Access Invalid!');

class user_centerControl extends apiHomeControl
{

    private $member_id;

    public function __construct()
    {
        parent::__construct();

        if (!isset($_GET['uid']) || $_GET['uid'] <= 0) {
            output_error("缺少用户id参数");
            die;
        }

        //TODO 查找uid是否存在，不存在则输出错误信息
        $this->member_id = $_GET['uid'];

    }

    /**
     * 性别处理方法
     * @param $sextype
     * @return string
     */
    private function m_sex($sextype)
    {
        switch ($sextype) {
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
    public function user_infoOp()
    {
        $member_info = array();
        $member = array();
        //会员详情及会员级别处理
        $model_member = Model('member');
        $friend_model = Model('sns_friend');
        $member_info = $model_member->getMemberInfoByID($this->member_id);
        //关注数及粉丝数
        $following_count = $friend_model->countFriend(array('friend_frommid' => "$this->member_id"));
        $follower_count = $friend_model->countFriend(array('friend_tomid' => "$this->member_id"));
        if ($member_info) {
            $member['member_id'] = $member_info['member_id'];
            $member['member_name'] = $member_info['member_name'];
            $member['member_truename'] = $member_info['member_truename'];
            $member['member_avatar'] = getMemberAvatar($member_info['member_avatar']);
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
            $member['member_shenfen'] = $member_info['member_shenfen'];
            $member['member_yjfx'] = $member_info['member_yjfx'];
            $member['member_zhuanye'] = $member_info['member_zhuanye'];
            $member['member_xueke'] = $member_info['member_xueke'];
            $member['member_areainfo'] = $member_info['member_areainfo'];
            $member['following_count'] = $following_count;
            $member['follower_count'] = $follower_count;
        } else {
            output_error("用户不存在");
        }
        output_data(array('user_info' => $member));
    }

    /**
     * GET 用户所有粉丝
     */
    public function followersOp()
    {
        $friend_model = Model('sns_friend');
        //粉丝列表
        //设置每页数量和总数！！！
        $page = new Page();
        pagecmd('setEachNum', $this->page);
//        pagecmd('setTotalNum',$friend_model->count());
        $field = 'member_id,member_name,member_avatar,member_sex,friend_followstate';
        $fan_list = $friend_model->listFriend(array('friend_tomid' => $this->member_id), $field, $page, 'fromdetail');
        if (!empty($fan_list)) {
            foreach ($fan_list as $k => $v) {
                $v['member_avatar'] = getMemberAvatar($v['member_avatar']);
                $v['member_sex'] = $this->m_sex($v['member_sex']);
                $fan_list[$k] = $v;
            }
        }
        $pageCount = pagecmd('gettotalpage', $this->page);
        output_data(array('followers' => $fan_list), mobile_page($pageCount));
    }

    /**
     * GET 用户所有关注人
     */
    public function followingOp()
    {
        $friend_model = Model('sns_friend');
        //关注列表
        $page = new Page();
        pagecmd('setEachNum', $this->page);
        $field = 'member_id,member_name,member_avatar,member_sex,friend_followstate';
        $follow_list = $friend_model->listFriend(array('friend_frommid' => $this->member_id), $field, $page, 'detail');
        if (!empty($follow_list)) {
            foreach ($follow_list as $k => $v) {
                $v['member_avatar'] = getMemberAvatar($v['member_avatar']);
                $v['sex_class'] = $this->m_sex($v['member_sex']);
                $follow_list[$k] = $v;
            }
        }
        $pageCount = pagecmd('gettotalpage', $this->page);
        output_data(array('followings' => $follow_list), mobile_page($pageCount));
    }


    /**
     * GET 用户的圈子
     */
    public function user_circlesOp()
    {
        $model = Model();
        $cm_list = $model->table('circle_member')->where(array('member_id' => $this->member_id, 'cm_state' => array('not in',array(0,2))))->order('cm_jointime desc')->select();
        if (!empty($cm_list)) {
            $cm_list = array_under_reset($cm_list, 'circle_id');
            $circleid_array = array_keys($cm_list);
            $circle_list = $model->table('circle')->where(array('circle_id' => array('in', $circleid_array)))->select();
        }
        output_data(array('circle_list' => $circle_list));
    }

    /**
     * GET 用户的话题
     */
    public function user_themesOp()
    {
        $model = Model();
        $m_theme = $model->table('circle_theme');
        $types = array(5, 6);
        $where['thclass_id'] = array('not in',$types);
        $where['member_id'] = $this->member_id;
        $theme_list = $m_theme->where($where)->page($this->page)->order('theme_addtime desc')->select();
        $pageCount = $m_theme->gettotalpage();
        if (!empty($theme_list)) {
            foreach ($theme_list as $key => $val) {
                $theme_list[$key]['member_avatar'] = getMemberAvatarForID($theme_list[$key]['member_id']);
            }
        }
        output_data(array('themes' => $theme_list), mobile_page($pageCount));
    }

    /**
     * 用户的回帖
     */
    public function userAnswersOp()
    {
        // 回复列表
        $where = array();
        $types = array(5, 6);
        $model = new Model();
        $m_reply = $model->table('circle_threply');
        $where['circle_threply.member_id'] = $this->member_id;
        $where['circle_theme.thclass_id'] = array('not in',$types);
        $reply_info = $model->table('circle_threply,circle_theme')->join('right join')->on('circle_threply.theme_id=circle_theme.theme_id')->where($where)->page($this->page)->order('reply_addtime desc')->select();
        $pageCount = $m_reply->gettotalpage();
        if (!empty($reply_info)) {
            foreach ($reply_info as $key => $val) {
                $reply_info[$key]['member_avatar'] = getMemberAvatarForID($reply_info[$key]['member_id']);
            }
        }
        output_data(array('answers' => $reply_info), mobile_page($pageCount));

    }

    /**
     * 获取所有工作单位
     */
    public function departsOp()
    {

        $model_depart = Model('depart');

        $condition = array();

        $counties = $model_depart->getDepartList($condition, 'depart_id,depart_name,depart_parent_id,depart_deep');

        $departs = $this->treeArray1($counties);

        echo json_encode($departs);
    }

    /**
     * 获取所有学科类型
     */
    public function disciplinesOp()
    {

        $model_depart = Model('discipline');

        $condition = array();

        $counties = $model_depart->getDepartList($condition, 'discipline_id,discipline_name,discipline_parent_id,discipline_deep');

        $departs = $this->treeArray2($counties);

        echo json_encode($departs);
    }


    /**
     * 生成树数组
     * @param  $data 从数据库出来select出来的数数组
     * @return  [{"id":1,"name":"Folder1", "children":[{"id":1,"name":"File1"}] }]
     * */
    function treeArray1($data)
    {
        $result = array();
        //定义索引数组，用于记录节点在目标数组的位置，类似指针
        $p = array();

        foreach($data as $val)
        {
            if($val['depart_parent_id'] == 0)
            {
                $i = count($result);
                $result[$i] = isset($p[$val['depart_id']])? array_merge($val,$p[$val['depart_id']]) : $val;
                $p[$val['depart_id']] = & $result[$i];
            } else {
                if($val['depart_deep'] == 2) {
                    $i = count($p[$val['depart_parent_id']]['cities']);
                    $p[$val['depart_parent_id']]['cities'][$i] = $val;
                    $p[$val['depart_id']] = & $p[$val['depart_parent_id']]['cities'][$i];
                } elseif ($val['depart_deep'] == 3) {
                    $i = count($p[$val['depart_parent_id']]['counties']);
                    $p[$val['depart_parent_id']]['counties'][$i] = $val;
                    $p[$val['depart_id']] = & $p[$val['depart_parent_id']]['counties'][$i];
                }
            }
        }
        return $result;
    }
    function treeArray2($data)
    {
        $result = array();
        //定义索引数组，用于记录节点在目标数组的位置，类似指针
        $p = array();

        foreach($data as $val)
        {
            if($val['discipline_parent_id'] == 0)
            {
                $i = count($result);
                $result[$i] = isset($p[$val['discipline_id']])? array_merge($val,$p[$val['discipline_id']]) : $val;
                $p[$val['discipline_id']] = & $result[$i];
            } else {
                if($val['discipline_deep'] == 2) {
                    $i = count($p[$val['discipline_parent_id']]['cities']);
                    $p[$val['discipline_parent_id']]['cities'][$i] = $val;
                    $p[$val['discipline_id']] = & $p[$val['discipline_parent_id']]['cities'][$i];
                } elseif ($val['discipline_deep'] == 3) {
                    $i = count($p[$val['discipline_parent_id']]['counties']);
                    $p[$val['discipline_parent_id']]['counties'][$i] = $val;
                    $p[$val['discipline_id']] = & $p[$val['discipline_parent_id']]['counties'][$i];
                }
            }
        }

        return $result;
    }


}