<?php
/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15/11/9
 * Time: 下午3:52
 */
defined('InShopNC') or exit('Access Invalid!');

class securityControl extends apiControl
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 统一发送身份验证码
     */
    public function send_auth_codeOp()
    {
        if (!in_array($_GET['type'], array('email', 'mobile'))) exit();

        $model_member = Model('member');
        $member_info = $model_member->getMemberInfoByID($_SESSION['member_id'], 'member_email,member_mobile');

        $verify_code = rand(100, 999) . rand(100, 999);
        $data = array();
        $data['auth_code'] = $verify_code;
        $data['send_acode_time'] = TIMESTAMP;
        $update = $model_member->editMemberCommon($data, array('member_id' => $_SESSION['member_id']));
        if (!$update) {
            exit(json_encode(array('state' => 'false', 'msg' => '系统发生错误，如有疑问请与管理员联系')));
        }

        $model_tpl = Model('mail_templates');
        $tpl_info = $model_tpl->getTplInfo(array('code' => 'authenticate'));

        $param = array();
        $param['send_time'] = date('Y-m-d H:i', TIMESTAMP);
        $param['verify_code'] = $verify_code;
        $param['site_name'] = C('site_name');
        $subject = ncReplaceText($tpl_info['title'], $param);
        $message = ncReplaceText($tpl_info['content'], $param);
        if ($_GET['type'] == 'email') {
            $email = new Email();
            $result = $email->send_sys_email($member_info["member_email"], $subject, $message);
        } elseif ($_GET['type'] == 'mobile') {
            $sms = new Sms();
            $result = $sms->send($member_info["member_mobile"], $message);
        }
        if ($result) {
            exit(json_encode(array('state' => 'true', 'msg' => '验证码已发出，请注意查收')));
        } else {
            exit(json_encode(array('state' => 'false', 'msg' => '验证码发送失败')));
        }
    }

}