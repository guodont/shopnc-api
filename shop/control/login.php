<?php
/**
 * 前台登录 退出操作
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class loginControl extends BaseHomeControl
{

    public function __construct()
    {
        parent::__construct();
        Tpl::output('hidden_nctoolbar', 1);
    }

    /**
     * 登录操作
     *
     */
    public function indexOp()
    {
        //zmr>v30
        $zmr = intval($_GET['zmr']);
        if ($zmr > 0) {
            $_COOKIES['zmr'] = $zmr;
        }

        Language::read("home_login_index");
        $lang = Language::getLangContent();
        $model_member = Model('member');
        //检查登录状态
        $model_member->checkloginMember();
        if ($_GET['inajax'] == 1 && C('captcha_status_login') == '1') {
            $script = "document.getElementById('codeimage').src='" . APP_SITE_URL . "/index.php?act=seccode&op=makecode&nchash=" . getNchash() . "&t=' + Math.random();";
        }
        $result = chksubmit(true, C('captcha_status_login'), 'num');
        if ($result !== false) {
            if ($result === -11) {
                showDialog($lang['login_index_login_illegal'], '', 'error', $script);
            } elseif ($result === -12) {
                showDialog($lang['login_index_wrong_checkcode'], '', 'error', $script);
            }
            if (process::islock('login')) {
                showDialog($lang['nc_common_op_repeat'], SHOP_SITE_URL, '', 'error', $script);
            }
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["user_name"], "require" => "true", "message" => $lang['login_index_username_isnull']),
                array("input" => $_POST["password"], "require" => "true", "message" => $lang['login_index_password_isnull']),
            );
            $error = $obj_validate->validate();
            if ($error != '') {
                showDialog($error, SHOP_SITE_URL, 'error', $script);
            }
            $array = array();
            $array['member_name'] = $_POST['user_name'];
            $array['member_passwd'] = md5($_POST['password']);
            $member_info = $model_member->getMemberInfo($array);
            if (empty($member_info)) {
                $array = array();
                $array['member_mobile'] = $_POST['user_name'];
                $array['member_passwd'] = md5($_POST['password']);
                $array['member_mobile_bind'] = 1;
                $member_info = $model_member->getMemberInfo($array);
            }
            if (is_array($member_info) and !empty($member_info)) {
                if (!$member_info['member_state']) {
                    showDialog($lang['login_index_account_stop'], '' . 'error', $script);
                }
            } else {
                process::addprocess('login');
                showDialog($lang['login_index_login_fail'], '', 'error', $script);
            }
            $model_member->createSession($member_info);
            process::clear('login');

            // cookie中的cart存入数据库
            Model('cart')->mergecart($member_info, $_SESSION['store_id']);

            // cookie中的浏览记录存入数据库
            Model('goods_browse')->mergebrowse($_SESSION['member_id'], $_SESSION['store_id']);

            if ($_GET['inajax'] == 1) {
                showDialog('', $_POST['ref_url'] == '' ? 'reload' : $_POST['ref_url'], 'js');
            } else {
                redirect($_POST['ref_url']);
            }
        } else {

            //登录表单页面
            $_pic = @unserialize(C('login_pic'));
            if ($_pic[0] != '') {
                Tpl::output('lpic', UPLOAD_SITE_URL . '/' . ATTACH_LOGIN . '/' . $_pic[array_rand($_pic)]);
            } else {
                Tpl::output('lpic', UPLOAD_SITE_URL . '/' . ATTACH_LOGIN . '/' . rand(1, 4) . '.jpg');
            }

            if (empty($_GET['ref_url'])) {
                $ref_url = getReferer();
                if (!preg_match('/act=login&op=logout/', $ref_url)) {
                    $_GET['ref_url'] = $ref_url;
                }
            }
            Tpl::output('html_title', C('site_name') . ' - ' . $lang['login_index_login']);
            if ($_GET['inajax'] == 1) {
                Tpl::showpage('login_inajax', 'null_layout');
            } else {
                Tpl::showpage('login');
            }
        }
    }

    /**
     * 退出操作
     *
     * @param int $id 记录ID
     * @return array $rs_row 返回数组形式的查询结果
     */
    public function logoutOp()
    {
        Language::read("home_login_index");
        $lang = Language::getLangContent();
        // 清理消息COOKIE
        setNcCookie('msgnewnum' . $_SESSION['member_id'], '', -3600);
        session_unset();
        session_destroy();
        setNcCookie('cart_goods_num', '', -3600);
        if (empty($_GET['ref_url'])) {
            $ref_url = getReferer();
        } else {
            $ref_url = $_GET['ref_url'];
        }
        redirect('index.php?act=login&ref_url=' . urlencode($ref_url));
    }

    /**
     * 会员注册页面
     *
     * @param
     * @return
     */
    public function registerOp()
    {
        Language::read("home_login_register");
        $lang = Language::getLangContent();
        $model_member = Model('member');
        $model_member->checkloginMember();
        Tpl::output('html_title', C('site_name') . ' - ' . $lang['login_register_join_us']);
        Tpl::showpage('register');
    }

    /**
     * 会员添加操作
     *
     * @param
     * @return
     */
    public function usersaveOp()
    {
        //重复注册验证
        if (process::islock('reg')) {
            showDialog(Language::get('nc_common_op_repeat'));
        }
        Language::read("home_login_register");
        $lang = Language::getLangContent();
        $model_member = Model('member');
        $model_member->checkloginMember();
        $result = chksubmit(true, C('captcha_status_register'), 'num');
        if ($result) {
            if ($result === -11) {
                showDialog($lang['invalid_request'], '', 'error');
            } elseif ($result === -12) {
                showDialog($lang['login_usersave_wrong_code'], '', 'error');
            }
        } else {
            showDialog($lang['invalid_request'], '', 'error');
        }
        //zmr>>>
        if (!$_SESSION['mobile_auth_code']) {
            showDialog('手机验证码未获取到', '', 'error');
        }
        $new_code = $_SESSION['mobile_auth_code'];
        $mobile_code = $_POST['mobile_code'];
        if ($mobile_code == '') {
            showDialog('手机验证码不能为空', '', 'error');
        }
        if ($new_code != $mobile_code) {
            showDialog('手机验证码不正确', '', 'error');
        }
        $_SESSION['mobile_auth_code'] = '';
        if ($_SESSION['reg_mobile_code'] != trim($_POST['mobile'])) {
            showDialog('手机号码已变动过，请重新填写。', '', 'error');
        }
        $_SESSION['reg_mobile_code'] = '';
        //zmr<<<

        $register_info = array();
        $register_info['username'] = $_POST['user_name'];
        $register_info['password'] = $_POST['password'];
        $register_info['password_confirm'] = $_POST['password_confirm'];
        $register_info['mobile'] = $_POST['mobile'];
        $register_info['member_mobile_bind'] = 1;//已绑定
        //添加奖励积分ID BY abc.COM V3
        //$register_info['inviter_id'] = intval($_COOKIE['uid'])/1;

        //添加奖励积分zmr>v30
        $zmr = intval($_COOKIES['zmr']);
        if ($zmr > 0) {
            $pinfo = $model_member->getMemberInfoByID($zmr, 'member_id');
            if (empty($pinfo)) {
                $zmr = 0;
            }
        }
        $register_info['inviter_id'] = $zmr;
        $member_info = $model_member->register_bymobile($register_info);
        if (!isset($member_info['error'])) {
            $model_member->createSession($member_info, true);
            process::addprocess('reg');

            // cookie中的cart存入数据库
            Model('cart')->mergecart($member_info, $_SESSION['store_id']);

            // cookie中的浏览记录存入数据库
            Model('goods_browse')->mergebrowse($_SESSION['member_id'], $_SESSION['store_id']);

            $_POST['ref_url'] = (strstr($_POST['ref_url'], 'logout') === false && !empty($_POST['ref_url']) ? $_POST['ref_url'] : 'index.php?act=member_information&op=member');
            redirect($_POST['ref_url']);
        } else {
            showDialog($member_info['error']);
        }
    }

    /**
     * 会员名称检测
     *
     * @param
     * @return
     */
    public function check_memberOp()
    {
        /**
         * 实例化模型
         */
        $model_member = Model('member');

        $check_member_name = $model_member->getMemberInfo(array('member_name' => $_GET['user_name']));
        if (is_array($check_member_name) and count($check_member_name) > 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /**
     * 电子邮箱检测
     *
     * @param
     * @return
     */
    public function check_emailOp()
    {
        $model_member = Model('member');
        $check_member_email = $model_member->getMemberInfo(array('member_email' => $_GET['email']));
        if (is_array($check_member_email) and count($check_member_email) > 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function check_mobileOp()
    {
        $model_member = Model('member');
        $check_member_email = $model_member->getMemberInfo(array('member_mobile' => $_GET['mobile']));
        if (is_array($check_member_email) and count($check_member_email) > 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /**
     * 忘记密码页面
     */
    public function forget_passwordOp()
    {
        //zmr>>>直接用手机找回吧
        redirect('index.php?act=login&op=forget_password_mobile');
        return;
        //zmr<<<
        /**
         * 读取语言包
         */
        Language::read('home_login_register');
        $_pic = @unserialize(C('login_pic'));
        if ($_pic[0] != '') {
            Tpl::output('lpic', UPLOAD_SITE_URL . '/' . ATTACH_LOGIN . '/' . $_pic[array_rand($_pic)]);
        } else {
            Tpl::output('lpic', UPLOAD_SITE_URL . '/' . ATTACH_LOGIN . '/' . rand(1, 4) . '.jpg');
        }
        Tpl::output('html_title', C('site_name') . ' - ' . Language::get('login_index_find_password'));
        Tpl::showpage('find_password');
    }

    /**
     * 忘记密码页面
     */
    public function forget_password_mobileOp()
    {

        /**
         * 读取语言包
         */
        Language::read('home_login_register');
        $_pic = @unserialize(C('login_pic'));
        if ($_pic[0] != '') {
            Tpl::output('lpic', UPLOAD_SITE_URL . '/' . ATTACH_LOGIN . '/' . $_pic[array_rand($_pic)]);
        } else {
            Tpl::output('lpic', UPLOAD_SITE_URL . '/' . ATTACH_LOGIN . '/' . rand(1, 4) . '.jpg');
        }
        Tpl::output('html_title', C('site_name') . ' - ' . Language::get('login_index_find_password'));
        Tpl::showpage('find_password_bymobile');
    }

    /**
     * 找回密码的发邮件处理
     */
    public function find_passwordOp()
    {
        Language::read('home_login_register');
        $lang = Language::getLangContent();

        $result = chksubmit(true, true, 'num');
        if ($result !== false) {
            if ($result === -11) {
                showDialog('非法提交');
            } elseif ($result === -12) {
                showDialog('验证码错误');
            }
        }

        if (empty($_POST['username'])) {
            showDialog($lang['login_password_input_username']);
        }

        if (process::islock('forget')) {
            showDialog($lang['nc_common_op_repeat'], 'reload');
        }

        $member_model = Model('member');
        $member = $member_model->getMemberInfo(array('member_name' => $_POST['username']));
        if (empty($member) or !is_array($member)) {
            process::addprocess('forget');
            showDialog($lang['login_password_username_not_exists'], 'reload');
        }

        if (empty($_POST['email'])) {
            showDialog($lang['login_password_input_email'], 'reload');
        }

        if (strtoupper($_POST['email']) != strtoupper($member['member_email'])) {
            process::addprocess('forget');
            showDialog($lang['login_password_email_not_exists'], 'reload');
        }
        process::clear('forget');
        //产生密码
        $new_password = random(15);
        if (!($member_model->editMember(array('member_id' => $member['member_id']), array('member_passwd' => md5($new_password))))) {
            showDialog($lang['login_password_email_fail'], 'reload');
        }

        $model_tpl = Model('mail_templates');
        $tpl_info = $model_tpl->getTplInfo(array('code' => 'reset_pwd'));
        $param = array();
        $param['site_name'] = C('site_name');
        $param['user_name'] = $_POST['username'];
        $param['new_password'] = $new_password;
        $param['site_url'] = SHOP_SITE_URL;
        $subject = ncReplaceText($tpl_info['title'], $param);
        $message = ncReplaceText($tpl_info['content'], $param);

        $email = new Email();
        $result = $email->send_sys_email($_POST["email"], $subject, $message);
        showDialog('新密码已经发送至您的邮箱，请尽快登录并更改密码！', '', 'succ', '', 5);
    }


    /**
     * 找回密码的(手机处理)
     */
    public function find_password_mobileOp()
    {
        Language::read('home_login_register');
        $lang = Language::getLangContent();

        $result = chksubmit(true, true, 'num');
        if ($result !== false) {
            if ($result === -11) {
                showDialog('非法提交');
            } elseif ($result === -12) {
                showDialog('验证码错误');
            }
        }

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $member_mobile = trim($_POST['mobile']);
        $mobile_code = trim($_POST['mobile_code']);

        if (empty($username)) {
            showDialog($lang['login_password_input_username']);
        }

        if (process::islock('forget')) {
            showDialog($lang['nc_common_op_repeat'], 'reload');
        }

        //zmr>>>
        if (!$_SESSION['mobile_auth_code']) {
            showDialog('手机验证码未获取到', '', 'error');
        }
        $new_code = $_SESSION['mobile_auth_code'];
        if ($mobile_code == '') {
            showDialog('手机验证码不能为空', '', 'error');
        }
        if ($new_code != $mobile_code) {
            showDialog('手机验证码不正确', '', 'error');
        }
        $_SESSION['mobile_auth_code'] = '';
        //zmr<<<


        $member_model = Model('member');
        $member = $member_model->getMemberInfo(array('member_name' => $username));
        if (empty($member) or !is_array($member)) {
            process::addprocess('forget');
            showDialog($lang['login_password_username_not_exists'], 'reload');
        }
        if (empty($member_mobile)) {
            showDialog('请输入手机号码', 'reload');
        }

        if (strtoupper($member_mobile) != strtoupper($member['member_mobile'])) {
            process::addprocess('forget');
            showDialog('此用户名绑定的手机号码不是' . $member_mobile, 'reload');
        }
        process::clear('forget');
        //产生密码
        $new_password = $password;
        if (!($member_model->editMember(array('member_id' => $member['member_id']), array('member_passwd' => md5($new_password))))) {
            showDialog('更新会员密码时出错', 'reload');
        }
        showDialog('更新密码成功', 'index.php?act=member&op=home', 'succ');
    }

    /**
     * 邮箱绑定验证
     */
    public function bind_emailOp()
    {
        $model_member = Model('member');
        $uid = @base64_decode($_GET['uid']);
        $uid = decrypt($uid, '');
        list($member_id, $member_email) = explode(' ', $uid);

        if (!is_numeric($member_id)) {
            showMessage('验证失败', SHOP_SITE_URL, 'html', 'error');
        }

        $member_info = $model_member->getMemberInfo(array('member_id' => $member_id), 'member_email');
        if ($member_info['member_email'] != $member_email) {
            showMessage('验证失败', SHOP_SITE_URL, 'html', 'error');
        }

        $member_common_info = $model_member->getMemberCommonInfo(array('member_id' => $member_id));
        if (empty($member_common_info) || !is_array($member_common_info)) {
            showMessage('验证失败', SHOP_SITE_URL, 'html', 'error');
        }
        if (md5($member_common_info['auth_code']) != $_GET['hash'] || TIMESTAMP - $member_common_info['send_acode_time'] > 24 * 3600) {
            showMessage('验证失败', SHOP_SITE_URL, 'html', 'error');
        }

        $update = $model_member->editMember(array('member_id' => $member_id), array('member_email_bind' => 1));
        if (!$update) {
            showMessage('系统发生错误，如有疑问请与管理员联系', SHOP_SITE_URL, 'html', 'error');
        }

        $data = array();
        $data['auth_code'] = '';
        $data['send_acode_time'] = 0;
        $update = $model_member->editMemberCommon($data, array('member_id' => $_SESSION['member_id']));
        if (!$update) {
            showDialog('系统发生错误，如有疑问请与管理员联系');
        }
        showMessage('邮箱设置成功', 'index.php?act=member_security&op=index');

    }

    //发送手机验证码
    public function sendmbcodeOp()
    {
        if (empty($_GET['mobile'])) {
            exit(json_encode(array('state' => 'false', 'msg' => '请输入手机号码')));
        }
        $member_mobile = trim($_GET['mobile']);
        $member_model = Model('member');
        $member = $member_model->getMemberInfo(array('member_mobile' => $member_mobile));
        if (!empty($member) && $member["member_id"] > 0) {
            exit(json_encode(array('state' => 'false', 'msg' => '该手机号已被使用，请更换其它手机号')));
        }

        $verify_code = rand(1, 9) . rand(100, 999);
        $model_tpl = Model('mail_templates');
        $tpl_info = $model_tpl->getTplInfo(array('code' => 'authenticate'));
        $param = array();
        $param['site_name'] = C('site_name');
        $param['send_time'] = date('Y-m-d H:i', TIMESTAMP);
        $param['verify_code'] = $verify_code;
        $message = ncReplaceText($tpl_info['content'], $param);
        $sms = new Sms();
        $result = $sms->send($_GET["mobile"], $message);
        if ($result) {
            $_SESSION['mobile_auth_code'] = $verify_code;
            $_SESSION['reg_mobile_code'] = $member_mobile;
            exit(json_encode(array('state' => 'true', 'msg' => '发送成功')));
        } else {
            $_SESSION['mobile_auth_code'] = '';
            $_SESSION['reg_mobile_code'] = '';
            exit(json_encode(array('state' => 'false', 'msg' => '发送失败')));
        }
    }

    //发送手机验证码(找回密码)
    public function sendmbcodepwdOp()
    {
        if (empty($_GET['mobile'])) {
            exit(json_encode(array('state' => 'false', 'msg' => '请输入手机号码')));
        }
        $member_name = trim($_GET['username']);
        $member_mobile = trim($_GET['mobile']);
        $member_model = Model('member');
        $member = $member_model->infoMember(array('member_name' => $member_name));
        if (empty($member)) {
            exit(json_encode(array('state' => 'false', 'msg' => '此用户名不存在系统')));
        }
        if ($member['member_mobile'] != $member_mobile) {
            exit(json_encode(array('state' => 'false', 'msg' => '此用户名绑定的手机号码不是' . $member_mobile)));
        }
        $verify_code = rand(1, 9) . rand(100, 999);
        $model_tpl = Model('mail_templates');
        $tpl_info = $model_tpl->getTplInfo(array('code' => 'authenticate'));
        $param = array();
        $param['site_name'] = C('site_name');
        $param['send_time'] = date('Y-m-d H:i', TIMESTAMP);
        $param['verify_code'] = $verify_code;
        $message = ncReplaceText($tpl_info['content'], $param);
        $sms = new Sms();
        $result = $sms->send($_GET["mobile"], $message);
        if ($result) {
            $_SESSION['mobile_auth_code'] = $verify_code;
            $_SESSION['reg_mobile_code'] = $member_mobile;
            exit(json_encode(array('state' => 'true', 'msg' => '发送成功')));
        } else {
            $_SESSION['mobile_auth_code'] = '';
            $_SESSION['reg_mobile_code'] = '';
            exit(json_encode(array('state' => 'false', 'msg' => '发送失败')));
        }
    }

    public function check_mobile_codeOp()
    {
        $new_code = $_SESSION['mobile_auth_code'];
        $mobile_code = trim($_GET['mobile_code']);
        if ($_SESSION['reg_mobile_code'] != trim($_GET['mobile'])) {
            //手机号码已变动过，请重新填写。
            echo 'false';
            return;
        }
        if ($mobile_code == '') {
            echo 'false';
            return;
        }
        if ($new_code != $mobile_code) {
            echo 'false';
            return;
        } else {
            echo 'true';
            return;
        }
    }
}
