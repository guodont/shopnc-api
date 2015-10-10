<?php
/**
 * Created by PhpStorm.
 * 首页动态api
 * User: guodont
 * Date: 15/9/8
 * Time: 上午9:50
 */

defined('InShopNC') or exit('Access Invalid!');

class trendControl extends apiMemberControl
{

    private $member_id;

    public function __construct()
    {
        parent::__construct();
        $this->member_id = $this->member_info['member_id'];
    }

    /**
     * 获取用户关注用户id
     * return array
     */
    public function getFollowingsIds()
    {
        $ids = array();
        $friend_model = Model('sns_friend');
        $field = 'member_id';
        $ids = $friend_model->listFriend(array('friend_frommid' => $this->member_id), $field, '', 'detail');
        return $ids;
    }

    /**
     * 获取好友动态
     */
    public function trendsOp()
    {
        $id_array = $this->getFollowingsIds();
        $ids = array();
        foreach ($id_array as $val) {
            $ids[] = $val['member_id'];
        }
        $model = Model();
        $m_theme = $model->table('circle_theme');
        //从话题表中查找出关注人的话题，按发布时间排序
        $fields = "theme_id,theme_name,theme_content,circle_id,circle_name,thclass_id,thclass_name,member_id,member_name,theme_addtime";
        $theme_list = $m_theme->where(array('member_id' => array('in', $ids)))->field($fields)->page($this->page)->order('theme_addtime desc')->select();
        foreach ($theme_list as $key => $val) {
            $theme_list[$key]['member_avatar'] = getMemberAvatarForID($theme_list[$key]['member_id']);
        }
        $pageCount = $m_theme->gettotalpage();
        if (empty($theme_list)) {
            output_error("没有任何动态");
            die;
        }
        output_data(array('trends' => $theme_list), mobile_page($pageCount));
    }
}