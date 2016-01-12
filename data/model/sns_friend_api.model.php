<?php
/**
 * SNS好友管理
 *

 */
defined('InShopNC') or exit('Access Invalid!');

class sns_friend_apiModel extends Model
{

    public function __construct()
    {
        parent::__construct('sns_friend');
    }

    /**
     * 获取用户粉丝列表
     * @param int $friend_tomid
     * @param string $field
     * @param int $page
     */
    public function listFollowers($friend_tomid = 0,$field = '*', $page = 0)
    {
        $where['friend_tomid'] = $friend_tomid;

        $followers = $this->table('sns_friend,member')->join('INNER JOIN')->on('sns_friend.friend_frommid=member.member_id')->field($field)->where($where)->page($page)->order('sns_friend.friend_id desc')->select();

        return $followers;
    }


    /**
     * 获取用户关注列表
     * @param int $friend_frommid
     * @param string $field
     * @param int $page
     * @return mixed
     */
    public function listFollowings($friend_frommid = 0,$field = '*', $page = 0)
    {
        $where['friend_frommid'] = $friend_frommid;

        $followers = $this->table('sns_friend,member')->join('INNER JOIN')->on('sns_friend.friend_tomid=member.member_id')->field($field)->where($where)->page($page)->order('sns_friend.friend_id desc')->select();

        return $followers;
    }

}