<?php
/**
 * 收货地址
 ***/


defined('InShopNC') or exit('Access Invalid!');

class member_messageControl extends BaseMemberControl {
    public function __construct() {
        parent::__construct();
		//读取语言包
		Language::read('member_home_message');
    }
	/**
	 * 收到(普通)站内信列表
	 *
	 * @param
	 * @return
	 */
	public function messageOp() {
		$model_message	= Model('message');
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$message_array	= $model_message->listMessage(array('message_type'=>'2','to_member_id_common'=>$_SESSION['member_id'],'no_message_state'=>'2'),$page);
		Tpl::output('show_page',$page->show());
		Tpl::output('message_array',$message_array);

		// 新消息数量
		$this->showReceivedNewNum();

		Tpl::output('drop_type','msg_list');
		$this->profile_menu('message');

		Tpl::showpage('member_message.box');
	}
	/**
	 * 收到(私信)站内信列表
	 *
	 * @param
	 * @return
	 */
	public function personalmsgOp() {
		$model_message	= Model('message');
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$message_array	= $model_message->listMessage(array('message_type'=>'0','to_member_id_common'=>$_SESSION['member_id'],'no_message_state'=>'2'),$page);
		Tpl::output('show_page',$page->show());
		Tpl::output('message_array',$message_array);

		// 新消息数量
		$this->showReceivedNewNum();

		Tpl::output('drop_type','msg_list');
		$this->profile_menu('close');
		Tpl::showpage('member_message.box');
	}
	/**
	 * 查询会员是否允许发送站内信
	 *
	 * @return bool
	 */
	private function allowSendMessage($member_id){
        $member_info = Model('member')->getMemberInfoByID($member_id,'is_allowtalk');
        if ($member_info['is_allowtalk'] == '1'){
        	return true;
        }else{
        	return false;
        }
	}
	/**
	 * 私人站内信列表
	 *
	 * @param
	 * @return
	 */
	public function privatemsgOp(){
		$model_message	= Model('message');
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$message_array	= $model_message->listMessage(array('message_type_in'=>'0,2','from_member_id'=>"{$_SESSION['member_id']}",'no_message_state'=>'1'),$page);
		Tpl::output('show_page',$page->show());
		Tpl::output('message_array',$message_array);

		// 新消息数量
		$this->showReceivedNewNum();

		Tpl::output('drop_type','msg_private');
		$this->profile_menu('private');
		Tpl::showpage('member_message.sendlist');
	}
	/**
	 * 系统站内信列表
	 *
	 * @param
	 * @return
	 */
	public function systemmsgOp(){
		$model_message	= Model('message');
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$message_array	= $model_message->listMessage(array('from_member_id'=>'0','message_type'=>'1','to_member_id'=>$_SESSION['member_id'],'no_del_member_id'=>$_SESSION['member_id']),$page);
		if (!empty($message_array) && is_array($message_array)){
			foreach ($message_array as $k=>$v){
				$v['message_open'] = '0';
				if (!empty($v['read_member_id'])){
					$tmp_readid_arr = explode(',',$v['read_member_id']);
					if (in_array($_SESSION['member_id'],$tmp_readid_arr)){
						$v['message_open'] = '1';
					}
				}
				$v['from_member_name'] = Language::get('home_message_system_message');
				$message_array[$k]	= $v;
			}
		}
		Tpl::output('show_page',$page->show());
		Tpl::output('message_array',$message_array);

		// 新消息数量
		$this->showReceivedNewNum();

		Tpl::output('drop_type','msg_system');
		$this->profile_menu('system');
		Tpl::showpage('member_message.box');
	}
	/**
	 * 发送站内信页面
	 *
	 * @param
	 * @return
	 */
	public function sendmsgOp(){
		$referer_url = getReferer();
		//查询会员是否允许发送站内信
		$isallowsend = $this->allowSendMessage($_SESSION['member_id']);
		if (!$isallowsend){
			showMessage(Language::get('home_message_noallowsend'),$referer_url,'html','error');
		}
		$model_member	= Model('member');
		$member_name_string	= '';
		$member_id = intval($_GET['member_id']);
		if($member_id > 0) {
			//连接发放站内信页面
			$member_info	= $model_member->getMemberInfoByID($member_id);
			if (empty($member_info)){
				showMessage(Language::get('wrong_argument'),$referer_url,'html','error');
			}
			$member_name_string	= $member_info['member_name'];
			Tpl::output('member_name',$member_name_string);
		}
		//批量给好友发放站内信页面
		$friend_model = Model('sns_friend');
		$friend_list = $friend_model->listFriend(array('friend_frommid'=>"{$_SESSION['member_id']}"));
		Tpl::output('friend_list',$friend_list);

		// 新消息数量
		$this->showReceivedNewNum();

		$this->profile_menu('sendmsg');
		Tpl::showpage('member_message.send');
	}
	/**
	 * 站内信保存操作
	 *
	 * @param
	 * @return
	 */
	public function savemsgOp() {
		//查询会员是否允许发送站内信
		$isallowsend = $this->allowSendMessage($_SESSION['member_id']);
		if (!$isallowsend){
			showDialog(Language::get('home_message_noallowsend'));
		}
		if (chksubmit()) {
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["to_member_name"],"require"=>"true","message"=>Language::get('home_message_receiver_null')),
				array("input"=>$_POST["msg_content"],"require"=>"true","message"=>Language::get('home_message_content_null')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showDialog($error);
			}
			$msg_content = trim($_POST['msg_content']);
			$membername_arr = explode(',',$_POST['to_member_name']);
			if (empty($membername_arr)){
				showDialog(Language::get('home_message_receiver_null'));
			}
			if (in_array("{$_SESSION['member_name']}",$membername_arr)){
				unset($membername_arr[array_search("{$_SESSION['member_name']}",$membername_arr)]);
			}
			//查询有效会员
			$member_model = Model('member');
			$member_list = $member_model->getMemberList(array('member_name'=>array('in', $membername_arr)));
			if (!empty($member_list)){
				$model_message	= Model('message');
				foreach ($member_list as $k=>$v){
					$insert_arr = array();
					$insert_arr['from_member_id'] = $_SESSION['member_id'];
					$insert_arr['from_member_name'] = $_SESSION['member_name'];
					$insert_arr['member_id'] = $v['member_id'];
					$insert_arr['to_member_name'] = $v['member_name'];
					$insert_arr['msg_content'] = $msg_content;
					$insert_arr['message_type'] = intval($_POST['msg_type']);
					$return = $model_message->saveMessage($insert_arr);
				}
			}else {
				showDialog(Language::get('home_message_receiver_null'));
			}
			if($_GET['type'] == 'sns_board'){
				$insert_arr['msg_id']		= $return;
				$insert_arr['msg_content']	= parsesmiles($insert_arr['msg_content']);
				if (strtoupper(CHARSET) == 'GBK') {
					$insert_arr['msg_content'] = Language::getUTF8($insert_arr['msg_content']);
				}
				$data = json_encode($insert_arr);
				$js = "leaveMsgSuccess(".$data.")";
				showDialog(Language::get('home_message_send_success'),'','succ',$js);
			}else{
				showDialog(Language::get('home_message_send_success'),'index.php?act=member_message&op=privatemsg','succ');
			}
		}
	}
	/**
	 * 普通站内信查看操作
	 *
	 * @param
	 * @return
	 */
	public function showmsgcommonOp() {
		$model_message	= Model('message');
		$message_id =  intval($_GET['message_id']);
		$drop_type = trim($_GET['drop_type']);
		$referer_url = getReferer();
		if(!in_array($drop_type,array('msg_list')) || $message_id<=0){
			showMessage(Language::get('wrong_argument'),$referer_url,'html','error');
		}
		//查询站内信
		$param = array();
		$param['message_id'] = "$message_id";
		$param['to_member_id_common'] = "{$_SESSION['member_id']}";
		$param['no_message_state'] = "2";
		$message_info = $model_message->getRowMessage($param);
		if (empty($message_info)){
			showMessage(Language::get('home_message_no_record'),$referer_url,'html','error');
		}
		unset($param);
		if ($message_info['message_parent_id'] >0){
			//查询该站内信的父站内信
			$parent_array	= $model_message->getRowMessage(array('message_id'=>"{$message_info['message_parent_id']}",'message_type'=>'0','no_message_state'=>'2'));
			//查询该站内信的回复站内信
			$reply_array	= $model_message->listMessage(array('message_parent_id'=>"{$message_info['message_parent_id']}",'message_type'=>'0','no_message_state'=>'2'));
		}else {//此信息为父站内信
			$parent_array = $message_info;
			//查询回复站内信
			$reply_array	= $model_message->listMessage(array('message_parent_id'=>"$message_id",'message_type'=>'0','no_message_state'=>'2'));
		}
		//处理获取站内信数组
		$message_list = array();
		if (!empty($reply_array)){
			foreach ($reply_array as $k=>$v){
				$message_list[$v['message_id']] = $v;
			}
		}
		if (!empty($parent_array)){
			$message_list[$parent_array['message_id']] = $parent_array;
		}
		unset($parent_array);
		unset($reply_array);
		//更新已读状态
		$messageid_arr = array_keys($message_list);
		if (!empty($messageid_arr)){
			$messageid_str = "'".implode("','",$messageid_arr)."'";
			$model_message->updateCommonMessage(array('message_open'=>'1'),array('message_id_in'=>"$messageid_str"));
		}
		//更新未读站内信数量cookie值
		$cookie_name = 'msgnewnum'.$_SESSION['member_id'];
		$countnum = $model_message->countNewMessage($_SESSION['member_id']);
		setNcCookie($cookie_name,$countnum,2*3600);//保存2小时
		Tpl::output('message_num',$countnum);
		Tpl::output('message_id',$message_id);//点击的该条站内信编号
		Tpl::output('message_list',$message_list);//站内信列表

		// 新消息数量
		$this->showReceivedNewNum();

    	$this->profile_menu('showmsg');
		Tpl::showpage('member_message.view');
	}
	/**
	 * 系统站内信查看操作
	 *
	 * @param
	 * @return
	 */
	public function showmsgbatchOp() {
		$model_message	= Model('message');
		$message_id =  intval($_GET['message_id']);
		$drop_type = trim($_GET['drop_type']);
		$referer_url = getReferer();
		if(!in_array($drop_type,array('msg_system','msg_seller')) || $message_id<=0){
			showMessage(Language::get('wrong_argument'),$referer_url,'html','error');
		}
		//查询站内信
		$param = array();
		$param['message_id'] = "$message_id";
		$param['to_member_id'] = "{$_SESSION['member_id']}";
		$param['no_del_member_id'] = "{$_SESSION['member_id']}";
		$message_info = $model_message->getRowMessage($param);
		if (empty($message_info)){
			showMessage(Language::get('home_message_no_record'),$referer_url,'html','error');
		}
		if ($drop_type == 'msg_system'){
			$message_info['from_member_name'] =  Language::get('home_message_system_message');
		}
		if ($drop_type == 'msg_seller'){
			//查询店铺信息
			$model_store = Model('store');
			$store_info = $model_store->getStoreInfo(array('member_id'=>"{$message_info['from_member_id']}"));
			$message_info['from_member_name'] =  $store_info['store_name'];
			$message_info['store_id'] =  $store_info['store_id'];
		}
		$message_list[0] = $message_info;
		Tpl::output('message_list',$message_list);//站内信列表
		//更新为已读信息
		$tmp_readid_str = '';
		if (!empty($message_info['read_member_id'])){
			$tmp_readid_arr = explode(',',$message_info['read_member_id']);
			if (!in_array($_SESSION['member_id'],$tmp_readid_arr)){
				$tmp_readid_arr[] = $_SESSION['member_id'];
			}
			foreach ($tmp_readid_arr as $readid_k=>$readid_v){
				if ($readid_v == ''){
					unset($tmp_readid_arr[$readid_k]);
				}
			}
			$tmp_readid_arr = array_unique ($tmp_readid_arr);//去除相同
			sort($tmp_readid_arr);//排序
			$tmp_readid_str = ",".implode(',',$tmp_readid_arr).",";
		}else {
			$tmp_readid_str = ",{$_SESSION['member_id']},";
		}
		$model_message->updateCommonMessage(array('read_member_id'=>$tmp_readid_str),array('message_id'=>"{$message_id}"));
		//更新未读站内信数量cookie值
		$cookie_name = 'msgnewnum'.$_SESSION['member_id'];
		$countnum = $model_message->countNewMessage($_SESSION['member_id']);
		setNcCookie($cookie_name,$countnum,2*3600);//保存2小时
		Tpl::output('message_num',$countnum);

		// 新消息数量
		$this->showReceivedNewNum();

		Tpl::output('drop_type',$drop_type);
    	$this->profile_menu('showmsg');
		Tpl::showpage('member_message.view');
	}
	/**
	 * 短消息回复保存
	 *
	 * @param
	 * @return
	 */
	public function savereplyOp() {
		//查询会员是否允许发送站内信
		$isallowsend = $this->allowSendMessage($_SESSION['member_id']);
		if (!$isallowsend){
			if($_GET['inajax'] == 1){
				showDialog(Language::get('home_message_noallowsend'));
			}else{
				showMessage(Language::get('home_message_noallowsend'),'index.php?act=member_message&op=message','html','error');
			}
		}
		if ($_POST['form_submit'] == 'ok') {
			$message_id = intval($_POST["message_id"]);
			if ($message_id <=0){
				showMessage(Language::get('wrong_argument'),'index.php?act=member_message&op=message','html','error');
			}
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["msg_content"],"require"=>"true","message"=>Language::get('home_message_reply_content_null'))
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				if($_GET['inajax'] == 1){
					showDialog(Language::get('error'));
				}else{
					showMessage(Language::get('error').$error,'','html','error');
				}
			}
			$model_message	= Model('message');
			//查询站内信
			$param = array();
			$param['message_id'] = "$message_id";
			$param['no_message_state'] = "2";//未删除
			$message_info = $model_message->getRowMessage($param);
			if (empty($message_info)){
				if($_GET['inajax'] == 1){
					showDialog(Language::get('home_message_no_record'));
				}else{
					showMessage(Language::get('home_message_no_record').$error,'','html','error');
				}
			}
			//不能回复自己的站内信
			if ($message_info['from_member_id'] == $_SESSION['member_id']){
				showMessage(Language::get('home_message_no_record'),'','html','error');
			}
			$insert_arr = array();
			if ($message_info['message_parent_id'] > 0){
				$insert_arr['message_parent_id'] = $message_info['message_parent_id'];
			}else {
				$insert_arr['message_parent_id'] = $message_info['message_id'];
			}
			$insert_arr['from_member_id'] = $_SESSION['member_id'];
			$insert_arr['from_member_name'] = $_SESSION['member_name'];
			$insert_arr['member_id'] = $message_info['from_member_id'];
			$insert_arr['to_member_name'] = $message_info['from_member_name'];
			$insert_arr['msg_content'] = $_POST['msg_content'];
			$insert_state = $model_message->saveMessage($insert_arr);
			if ($insert_state){
				//更新父类站内信更新时间
				$update_arr = array();
				$update_arr['message_update_time'] = time();
				$update_arr['message_open'] = 1;
				$model_message->updateCommonMessage($update_arr,array('message_id'=>"{$insert_arr['message_parent_id']}"));
			}
			if($_GET['inajax'] == 1){
				$insert_arr['msg_id']		= $insert_state;
				if(strtoupper(CHARSET) == 'GBK'){
					$insert_arr['msg_content'] = Language::getUTF8($insert_arr['msg_content']);
				}
				$insert_arr['msg_content']	= parsesmiles($insert_arr['msg_content']);
				$data = json_encode($insert_arr);
				$js = "replyMsgSuccess(".$data.")";
				showDialog(Language::get('home_message_send_success'),'','succ',$js);
			}else{
				showMessage(Language::get('home_message_send_success'),'index.php?act=member_message&op=privatemsg');
			}
		}else {
			if($_GET['inajax'] == 1){
				showDialog(Language::get('home_message_reply_command_wrong'));
			}else{
				showMessage(Language::get('home_message_reply_command_wrong'),'','html','error');
			}
		}
	}
	/**
	 * 删除普通信
	 */
	public function dropcommonmsgOp() {
		$message_id = trim($_GET['message_id']);
		$drop_type = trim($_GET['drop_type']);
		if(!in_array($drop_type,array('msg_private','msg_list','sns_msg')) || empty($message_id)) {
			showMessage(Language::get('wrong_argument'),'','html','error');
		}
		$messageid_arr = explode(',',$message_id);
		$messageid_str = '';
		if (!empty($messageid_arr)){
			$messageid_str = "'".implode("','",$messageid_arr)."'";
		}
		$model_message	= Model('message');
		$param	= array('message_id_in'=>$messageid_str);
		if($drop_type == 'msg_private'){
			$param['from_member_id'] = "{$_SESSION['member_id']}";
		}elseif($drop_type == 'msg_list'){
			$param['to_member_id_common']	= "{$_SESSION['member_id']}";
		}elseif($drop_type == 'sns_msg'){
			$param['from_to_member_id']	= $_SESSION['member_id'];
		}
		$drop_state	= $model_message->dropCommonMessage($param,$drop_type);
		if ($drop_state){
			//更新未读站内信数量cookie值
			$cookie_name = 'msgnewnum'.$_SESSION['member_id'];
			$countnum = $model_message->countNewMessage($_SESSION['member_id']);
			setNcCookie($cookie_name,$countnum,2*3600);//保存2小时
			showDialog(Language::get('home_message_delete_success'),'reload','succ');
		}else {
			showDialog(Language::get('home_message_delete_fail'),'','error');
		}
	}
	/**
	 * 删除批量站内信
	 */
	public function dropbatchmsgOp() {
		$message_id = trim($_GET['message_id']);
		$drop_type = trim($_GET['drop_type']);
		if(!in_array($drop_type,array('msg_system','msg_seller')) || empty($message_id)){
			showDialog(Language::get('home_message_delete_request_wrong'));
		}
		$messageid_arr = explode(',',$message_id);
		$messageid_str = '';
		if (!empty($messageid_arr)){
			$messageid_str = "'".implode("','",$messageid_arr)."'";
		}
		$model_message	= Model('message');
		$param	= array('message_id_in'=>$messageid_str);
		if($drop_type == 'msg_system'){
			$param['message_type'] = '1';
			$param['from_member_id'] = '0';
		}
		if($drop_type == 'msg_seller'){
			$param['message_type'] = '2';
		}
		$drop_state	= $model_message->dropBatchMessage($param,$_SESSION['member_id']);
		if ($drop_state){
			//更新未读站内信数量cookie值
			$cookie_name = 'msgnewnum'.$_SESSION['member_id'];
			$countnum = $model_message->countNewMessage($_SESSION['member_id']);
			setNcCookie($cookie_name,$countnum,2*3600);//保存2小时
			showDialog(Language::get('home_message_delete_success'),'reload','succ');
		}else {
			showDialog(Language::get('home_message_delete_fail'),'','error');
		}
	}

    /**
     * 消息接收设置
     *
     * 注意：由于用户消息模板不是循环输出，所以每增加一种消息模板，
     *     都需要在模板（member_message.setting）中需要手工添加该消息模板的选项卡，
     *     在control部分也要添加相关的验证，否则默认开启无法关闭。
     */
    public function settingOp() {
        $model_membermsgsetting = Model('member_msg_setting');
        if (chksubmit()) {
            $insert = array(
                // 付款成功提醒
                array( 'mmt_code' => 'order_payment_success', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['order_payment_success']) ),
                // 商品出库提醒
                array( 'mmt_code' => 'order_deliver_success', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['order_deliver_success']) ),
                // 余额变动提醒
                array( 'mmt_code' => 'predeposit_change', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['predeposit_change']) ),
                // 充值卡余额变动提醒
                array( 'mmt_code' => 'recharge_card_balance_change', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['recharge_card_balance_change']) ),
                // 代金券使用提醒
                array( 'mmt_code' => 'voucher_use', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['voucher_use']) ),
                // 退款退货提醒
                array( 'mmt_code' => 'refund_return_notice', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['refund_return_notice']) ),
                // 到货通知提醒
                array( 'mmt_code' => 'arrival_notice', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['arrival_notice']) ),
                // 商品咨询回复提醒
                array( 'mmt_code' => 'consult_goods_reply', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['consult_goods_reply']) ),
                // 平台客服回复提醒
                array( 'mmt_code' => 'consult_mall_reply', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['consult_mall_reply']) ),
                // 代金券即将到期
                array( 'mmt_code' => 'voucher_will_expire', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['voucher_will_expire'])),
                // 兑换码即将到期提醒
                array( 'mmt_code' => 'vr_code_will_expire', 'member_id' => $_SESSION['member_id'], 'is_receive' => intval($_POST['vr_code_will_expire'])),
            );
            $result = $model_membermsgsetting->addMemberMsgSettingAll($insert);
            if ($result) {
                showDialog(L('nc_common_save_succ'), '', 'succ');
            } else {
                showDialog(L('nc_common_save_fail'));
            }
        }
    	// 新消息数量
    	$this->showReceivedNewNum();

        $setting_list = $model_membermsgsetting->getMemberMsgSettingList(array('member_id' => $_SESSION['member_id']));
        $setting_array = array();
        if (!empty($setting_list)) {
            foreach ($setting_list as $val) {
                $setting_array[$val['mmt_code']] = intval($val['is_receive']);
            }
        }
        Tpl::output('setting_array', $setting_array);

        $this->profile_menu('setting');
        Tpl::showpage('member_message.setting');
    }
	/**
	 * 统计未读消息
	 */
	private function showReceivedNewNum() {
	    //查询新接收到普通的消息
	    $newcommon = $this->receivedCommonNewNum();
	    Tpl::output('newcommon',$newcommon);
	    //查询新接收到系统的消息
	    $newsystem = $this->receivedSystemNewNum();
	    Tpl::output('newsystem',$newsystem);
	    //查询新接收到卖家的消息
	    $newpersonal = $this->receivedPersonalNewNum();
	    Tpl::output('newpersonal',$newpersonal);
	    //查询会员是否允许发送站内信
	    $isallowsend = $this->allowSendMessage($_SESSION['member_id']);
	    Tpl::output('isallowsend',$isallowsend);
	}
	/**
	 * 统计收到站内信未读条数
	 *
	 * @return int
	 */
	private function receivedCommonNewNum(){
	    $model_message	= Model('message');
	    $countnum = $model_message->countMessage(array('message_type'=>'2','to_member_id_common'=>$_SESSION['member_id'],'no_message_state'=>'2','message_open_common'=>'0'));
	    return $countnum;
	}
	/**
	 * 统计系统站内信未读条数
	 *
	 * @return int
	 */
	private function receivedSystemNewNum(){
	    $message_model = Model('message');
	    $condition_arr = array();
	    $condition_arr['message_type'] = '1';//系统消息
	    $condition_arr['to_member_id'] = $_SESSION['member_id'];
	    $condition_arr['no_del_member_id'] = $_SESSION['member_id'];
	    $condition_arr['no_read_member_id'] = $_SESSION['member_id'];
	    $countnum = $message_model->countMessage($condition_arr);
	    return $countnum;
	}
	/**
	 * 统计私信未读条数
	 *
	 * @return int
	 */
	private function receivedPersonalNewNum(){
	    $model_message = Model('message');
	    $countnum = $model_message->countMessage(array('message_type'=>'0','to_member_id_common'=>$_SESSION['member_id'],'no_message_state'=>'2','message_open_common'=>'0'));
	    return $countnum;
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key='') {
		$menu_array	= array(
    		1=>array('menu_key'=>'message',	'menu_name'=>Language::get('home_message_received_message'),'menu_url'=>'index.php?act=member_message&op=message'),
    		2=>array('menu_key'=>'private',	'menu_name'=>Language::get('home_message_private_message'),	'menu_url'=>'index.php?act=member_message&op=privatemsg'),
    		3=>array('menu_key'=>'system',	'menu_name'=>Language::get('home_message_system_message'),	'menu_url'=>'index.php?act=member_message&op=systemmsg'),
    		4=>array('menu_key'=>'close',	'menu_name'=>Language::get('home_message_close'),	'menu_url'=>'index.php?act=member_message&op=personalmsg'),
		    5=>array('menu_key'=>'setting', 'menu_name'=>'接收设置', 'menu_url'=>urlShop('member_message', 'setting'))
		);
		if($menu_key == 'sendmsg') {
			$menu_array[] = array('menu_key'=>'sendmsg','menu_name'=>Language::get('home_message_send_message'),'menu_url'=>'index.php?act=member_message&op=sendmsg');
		}elseif($menu_key == 'showmsg') {
			$menu_array[] = array('menu_key'=>'showmsg','menu_name'=>Language::get('home_message_view_message'),'menu_url'=>'#');
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
