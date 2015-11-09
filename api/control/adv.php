<?php
/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15/11/9
 * Time: 下午3:52
 */

class advControl extends apiControl
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * GET 获取app首页广告
     */
    public function getAppHomeAdvOp()
    {
        $m_adv = new Model('new_adv');
        $advs = array();
        $where = array();
        $where['ap_id'] = 1048;
        $advs = $m_adv ->getList($where);
        foreach($advs as $key => $val )
        {
            $pic_content[$key] = unserialize($val['adv_content']);
            $advs[$key]['img_url'] = $pic_content[$key]['adv_pic'];
            $advs[$key]['adv_url'] = $pic_content[$key]['adv_pic_url'];
        }
        output_data($advs);
    }
}