<?php
/**
 * 消息通知
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class messageControl extends SystemControl{
	private $links = array(
		array('url'=>'act=message&op=email','lang'=>'email_set'),
		//zmr>>>
		array('url'=>'act=message&op=mobile','lang'=>'mobile_set'),
		//zmr<<<
	    array('url'=>'act=message&op=seller_tpl', 'lang'=>'seller_tpl'),
	    array('url'=>'act=message&op=member_tpl', 'lang'=>'member_tpl'),
	    array('url'=>'act=message&op=email_tpl','lang'=>'email_tpl')
	);
	public function __construct(){
		parent::__construct();
		Language::read('setting,message');
	}

	/**
	 * 邮件设置
	 */
	public function emailOp(){
		$model_setting = Model('setting');
		if (chksubmit()){
			$update_array = array();
			$update_array['email_host'] 	= $_POST['email_host'];
			$update_array['email_port'] 	= $_POST['email_port'];
			$update_array['email_addr'] 	= $_POST['email_addr'];
			$update_array['email_id'] 		= $_POST['email_id'];
			$update_array['email_pass'] 	= $_POST['email_pass'];

			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				$this->log(L('nc_edit,email_set'),1);
				showMessage(L('nc_common_save_succ'));
			}else {
				$this->log(L('nc_edit,email_set'),0);
				showMessage(L('nc_common_save_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);

		Tpl::output('top_link',$this->sublink($this->links,'email'));
		Tpl::showpage('message.email');
	}
	
	//zmr>>>
	/**
	 * 短信平台设置
	 */
	public function mobileOp(){
		$model_setting = Model('setting');
		if (chksubmit()){
			$update_array = array();
			$update_array['mobile_host_type'] 	= $_POST['mobile_host_type'];
			$update_array['mobile_host'] 	= $_POST['mobile_host'];
			$update_array['mobile_username'] 	= $_POST['mobile_username'];
			$update_array['mobile_pwd'] 	= $_POST['mobile_pwd'];
			$update_array['mobile_key'] 		= $_POST['mobile_key'];
			$update_array['mobile_signature'] 		= $_POST['mobile_signature'];
			$update_array['mobile_memo'] 	= $_POST['mobile_memo'];
			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				$this->log(L('nc_edit,mobile_set'),1);
				showMessage(L('nc_common_save_succ'));
			}else {
				$this->log(L('nc_edit,mobile_set'),0);
				showMessage(L('nc_common_save_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);

		Tpl::output('top_link',$this->sublink($this->links,'mobile'));
		Tpl::showpage('message.mobile');
	}

//zmr<<<

	/**
	 * 邮件模板列表
	 */
	public function email_tplOp(){
		$model_templates = Model('mail_templates');
		$templates_list = $model_templates->getTplList();
		Tpl::output('templates_list',$templates_list);
		Tpl::output('top_link',$this->sublink($this->links,'email_tpl'));
		Tpl::showpage('message.email_tpl');
	}

	/**
	 * 编辑邮件模板
	 */
	public function email_tpl_editOp(){
		$model_templates = Model('mail_templates');
		if (chksubmit()){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["code"], "require"=>"true", "message"=>L('mailtemplates_edit_no_null')),
				array("input"=>$_POST["title"], "require"=>"true", "message"=>L('mailtemplates_edit_title_null')),
				array("input"=>$_POST["content"], "require"=>"true", "message"=>L('mailtemplates_edit_content_null')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$update_array = array();
				$update_array['code'] = $_POST["code"];
				$update_array['title'] = $_POST["title"];
				$update_array['content'] = $_POST["content"];
				$result = $model_templates->editTpl($update_array,array('code'=>$_POST['code']));
				if ($result === true){
					$this->log(L('nc_edit,email_tpl'),1);
					showMessage(L('mailtemplates_edit_succ'),'index.php?act=message&op=email_tpl');
				}else {
					$this->log(L('nc_edit,email_tpl'),0);
					showMessage(L('mailtemplates_edit_fail'));
				}
			}
		}
		if (empty($_GET['code'])){
			showMessage(L('mailtemplates_edit_code_null'));
		}
		$templates_array = $model_templates->getTplInfo(array('code'=>$_GET['code']));
		Tpl::output('templates_array',$templates_array);
		Tpl::output('top_link',$this->sublink($this->links,'email_tpl'));
		Tpl::showpage('message.email_tpl.edit');
	}

	/**
	 * 测试邮件发送
	 *
	 * @param
	 * @return
	 */
	public function email_testingOp(){
		/**
		 * 读取语言包
		 */
		$lang	= Language::getLangContent();

		$email_host = trim($_POST['email_host']);
		$email_port = trim($_POST['email_port']);
		$email_addr = trim($_POST['email_addr']);
		$email_id = trim($_POST['email_id']);
		$email_pass = trim($_POST['email_pass']);

		$email_test = trim($_POST['email_test']);
		$subject	= $lang['test_email'];
		$site_url	= SHOP_SITE_URL;

        $site_title = C('site_name');
        $message = '<p>'.$lang['this_is_to']."<a href='".$site_url."' target='_blank'>".$site_title.'</a>'.$lang['test_email_send_ok'].'</p>';
// 		if ($email_type == '1'){
			$obj_email = new Email();
			$obj_email->set('email_server',$email_host);
			$obj_email->set('email_port',$email_port);
			$obj_email->set('email_user',$email_id);
			$obj_email->set('email_password',$email_pass);
			$obj_email->set('email_from',$email_addr);
            $obj_email->set('site_name',$site_title);
			$result = $obj_email->send($email_test,$subject,$message);
// 		}else {
// 			$result = @mail($email_test,$subject,$message);
// 		}
       if ($result === false){
            $message = $lang['test_email_send_fail'];
            if (strtoupper(CHARSET) == 'GBK'){
                $message = Language::getUTF8($message);
            }
            showMessage($message,'','json');
        }else {
            $message = $lang['test_email_send_ok'];
            if (strtoupper(CHARSET) == 'GBK'){
                $message = Language::getUTF8($message);
            }
            showMessage($message,'','json');
        }
    }

    /**
     * 商家消息模板
     */
    public function seller_tplOp() {
        $mstpl_list = Model('store_msg_tpl')->getStoreMsgTplList(array());
        Tpl::output('mstpl_list', $mstpl_list);
        Tpl::output('top_link',$this->sublink($this->links,'seller_tpl'));
        Tpl::showpage('message.seller_tpl');
    }

    /**
     * 商家消息模板编辑
     */
    public function seller_tpl_editOp() {
        if (chksubmit()) {
            $code = trim($_POST['code']);
            $type = trim($_POST['type']);
            if (empty($code) || empty($type)) {
                showMessage(L('param_error'));
            }
            switch ($type) {
                case 'message':
                    $this->seller_tpl_update_message();
                    break;
                case 'short':
                    $this->seller_tpl_update_short();
                    break;
                case 'mail':
                    $this->seller_tpl_update_mail();
                    break;
            }
        }
        $code = trim($_GET['code']);
        if (empty($code)) {
            showMessage(L('param_error'));
        }

        $where = array();
        $where['smt_code'] = $code;
        $smtpl_info = Model('store_msg_tpl')->getStoreMsgTplInfo($where);
        Tpl::output('smtpl_info', $smtpl_info);
        $this->links[] = array('url'=>'act=message&op=seller_tpl_edit','lang'=>'seller_tpl_edit');
        Tpl::output('top_link',$this->sublink($this->links,'seller_tpl_edit'));
        Tpl::showpage('message.seller_tpl.edit');
    }

    /**
     * 商家消息模板更新站内信
     */
    private function seller_tpl_update_message() {
        $message_content = trim($_POST['message_content']);
        if (empty($message_content)) {
            showMessage('请填写站内信模板内容。');
        }
        // 条件
        $where = array();
        $where['smt_code'] = trim($_POST['code']);
        // 数据
        $update = array();
        $update['smt_message_switch'] = intval($_POST['message_switch']);
        $update['smt_message_content'] = $message_content;
        $update['smt_message_forced'] = intval($_POST['message_forced']);
        $result = Model('store_msg_tpl')->editStoreMsgTpl($where, $update);
        $this->seller_tpl_update_showmessage($result);
    }

    /**
     * 商家消息模板更新短消息
     */
    private function seller_tpl_update_short() {
        $short_content = trim($_POST['short_content']);
        if (empty($short_content)) {
            showMessage('请填写短消息模板内容。');
        }
        // 条件
        $where = array();
        $where['smt_code'] = trim($_POST['code']);
        // 数据
        $update = array();
        $update['smt_short_switch'] = intval($_POST['short_switch']);
        $update['smt_short_content'] = $short_content;
        $update['smt_short_forced'] = intval($_POST['short_forced']);
        $result = Model('store_msg_tpl')->editStoreMsgTpl($where, $update);
        $this->seller_tpl_update_showmessage($result);
    }

    /**
     * 商家消息模板更新邮件
     */
    private function seller_tpl_update_mail() {
        $mail_subject = trim($_POST['mail_subject']);
        $mail_content = trim($_POST['mail_content']);
        if ((empty($mail_subject) || empty($mail_content))) {
            showMessage('请填写邮件模板内容。');
        }
        // 条件
        $where = array();
        $where['smt_code'] = trim($_POST['code']);
        // 数据
        $update = array();
        $update['smt_mail_switch'] = intval($_POST['mail_switch']);
        $update['smt_mail_subject'] = $mail_subject;
        $update['smt_mail_content'] = $mail_content;
        $update['smt_mail_forced'] = intval($_POST['mail_forced']);
        $result = Model('store_msg_tpl')->editStoreMsgTpl($where, $update);
        $this->seller_tpl_update_showmessage($result);
    }

    private function seller_tpl_update_showmessage($result) {
        if ($result) {
            showMessage(L('nc_common_op_succ'), urlAdmin('message', 'seller_tpl'));
        } else {
            showMessage(L('nc_common_op_fail'));
        }
    }

    /**
     * 用户消息模板
     */
    public function member_tplOp() {
        $mmtpl_list = Model('member_msg_tpl')->getMemberMsgTplList(array());
        Tpl::output('mmtpl_list', $mmtpl_list);
        Tpl::output('top_link',$this->sublink($this->links,'member_tpl'));
        Tpl::showpage('message.member_tpl');
    }

    /**
     * 用户消息模板编辑
     */
    public function member_tpl_editOp() {
        if (chksubmit()) {
            $code = trim($_POST['code']);
            $type = trim($_POST['type']);
            if (empty($code) || empty($type)) {
                showMessage(L('param_error'));
            }
            switch ($type) {
                case 'message':
                    $this->member_tpl_update_message();
                    break;
                case 'short':
                    $this->member_tpl_update_short();
                    break;
                case 'mail':
                    $this->member_tpl_update_mail();
                    break;
            }
        }
        $code = trim($_GET['code']);
        if (empty($code)) {
            showMessage(L('param_error'));
        }

        $where = array();
        $where['mmt_code'] = $code;
        $mmtpl_info = Model('member_msg_tpl')->getMemberMsgTplInfo($where);
        Tpl::output('mmtpl_info', $mmtpl_info);
        $this->links[] = array('url'=>'act=message&op=member_tpl_edit','lang'=>'member_tpl_edit');
        Tpl::output('top_link',$this->sublink($this->links,'member_tpl_edit'));
        Tpl::showpage('message.member_tpl.edit');
    }

    /**
     * 商家消息模板更新站内信
     */
    private function member_tpl_update_message() {
        $message_content = trim($_POST['message_content']);
        if (empty($message_content)) {
            showMessage('请填写站内信模板内容。');
        }
        // 条件
        $where = array();
        $where['mmt_code'] = trim($_POST['code']);
        // 数据
        $update = array();
        $update['mmt_message_switch'] = intval($_POST['message_switch']);
        $update['mmt_message_content'] = $message_content;
        $result = Model('member_msg_tpl')->editMemberMsgTpl($where, $update);
        $this->member_tpl_update_showmessage($result);
    }

    /**
     * 商家消息模板更新短消息
     */
    private function member_tpl_update_short() {
        $short_content = trim($_POST['short_content']);
        if (empty($short_content)) {
            showMessage('请填写短消息模板内容。');
        }
        // 条件
        $where = array();
        $where['mmt_code'] = trim($_POST['code']);
        // 数据
        $update = array();
        $update['mmt_short_switch'] = intval($_POST['short_switch']);
        $update['mmt_short_content'] = $short_content;
        $result = Model('member_msg_tpl')->editMemberMsgTpl($where, $update);
        $this->member_tpl_update_showmessage($result);
    }

    /**
     * 商家消息模板更新邮件
     */
    private function member_tpl_update_mail() {
        $mail_subject = trim($_POST['mail_subject']);
        $mail_content = trim($_POST['mail_content']);
        if ((empty($mail_subject) || empty($mail_content))) {
            showMessage('请填写邮件模板内容。');
        }
        // 条件
        $where = array();
        $where['mmt_code'] = trim($_POST['code']);
        // 数据
        $update = array();
        $update['mmt_mail_switch'] = intval($_POST['mail_switch']);
        $update['mmt_mail_subject'] = $mail_subject;
        $update['mmt_mail_content'] = $mail_content;
        $result = Model('member_msg_tpl')->editMemberMsgTpl($where, $update);
        $this->member_tpl_update_showmessage($result);
    }

    private function member_tpl_update_showmessage($result) {
        if ($result) {
            showMessage(L('nc_common_op_succ'), urlAdmin('message', 'member_tpl'));
        } else {
            showMessage(L('nc_common_op_fail'));
        }
    }
}
