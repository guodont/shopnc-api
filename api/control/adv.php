<?php
/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15/11/9
 * Time: 下午3:52
 */
defined('InShopNC') or exit('Access Invalid!');

class advControl extends apiControl
{
    public function __construct()
    {
        parent::__construct();
    }

    // utf-8
    private function mb_unserialize($serial_str) {
        $serial_str= preg_replace_callback('!s:(\d+):"(.*?)";!s', function($r) {
            return 's:'.strlen($r[2]).':"'.$r[2].'";';
        }, $serial_str );
        $serial_str= str_replace("\r", "", $serial_str);
        return unserialize($serial_str);
    }

    // ascii
    private function asc_unserialize($serial_str) {
        $serial_str = preg_replace('!s:(\d+):"(.*?)";!se', '"s:".strlen("$2").":\"$2\";"', $serial_str );
        $serial_str= str_replace("\r", "", $serial_str);
        return unserialize($serial_str);
    }

    /**
     * GET 获取app首页广告
     */
    public function getAppHomeAdvOp()
    {
        $m_adv = Model('new_adv');
        $where = array();
        $where['ap_id'] = 1048;
        $advs = $m_adv->getList($where, '', '*');
        foreach ($advs as $key => $val) {
            $val = $advs[$key]['adv_content'];
            $pic_content[$key] = $this->mb_unserialize($val);
            $pic = $pic_content[$key]['adv_pic'];
            $url = $pic_content[$key]['adv_pic_url'];
            $advs[$key]['img_url'] = $pic;
            $advs[$key]['adv_url'] = $url;
        }
        output_data($advs);
    }



}