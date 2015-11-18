<?php
/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15/11/18
 * Time: 下午3:35
 */

defined('InShopNC') or exit('Access Invalid!');

class rong_cloudControl extends apiMemberControl{

    private $member_id;

    public function __construct()
    {
        parent::__construct();
        $this->member_info();
        $this->member_id = $this->member_info['member_id'];
    }

    public function getToken()
    {
        $p = new ServerAPI('0vnjpoadnw2uz','hg0BUlbxV8a1');
        $r = $p->getToken($this->member_id,$this->member_info['member_name'],getMemberAvatarForID($this->member_id));
        print_r($r);
    }
}