<?php
/**
 * 会员通知管理
 ***/

defined('InShopNC') or exit('Access Invalid!');
class noticeControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('notice');
	}
	/**
	 * 会员通知
	 */
	public function noticeOp(){
		//提交
		if (chksubmit()){
			$content = trim($_POST['content1']);//信息内容
			$send_type = intval($_POST['send_type']);
			//验证
			$obj_validate = new Validate();
			switch ($send_type){
				//指定会员
				case 1:
					$obj_validate->setValidate(array("input"=>$_POST["user_name"], "require"=>"true", "message"=>Language::get('notice_index_member_list_null')));
					break;
				//全部会员
				case 2:
					break;
			}
			$obj_validate->setValidate(array("input"=>$content, "require"=>"true", "message"=>Language::get('notice_index_content_null')));
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				//发送会员ID 数组
				$memberid_list = array();
				//整理发送列表
				//指定会员
				if ($send_type == 1){
					$model_member = Model('member');
					$tmp = explode("\n",$_POST['user_name']);
					if (!empty($tmp)){
						foreach ($tmp as $k=>$v){
							$tmp[$k] = trim($v);
						}
						//查询会员列表
						$member_list = $model_member->getMemberList(array('member_name'=>array('in', $tmp)));
						unset($membername_str);
						if (!empty($member_list)){
							foreach ($member_list as $k => $v){
								$memberid_list[] = $v['member_id'];
							}
						}
						unset($member_list);
					}
					unset($tmp);
				}
				if (empty($memberid_list) && $send_type != 2){
					showMessage(Language::get('notice_index_member_error'),'','html','error');
				}
				//接收内容
				$array = array();
				$array['send_mode'] = 1;
				$array['user_name'] = $memberid_list;
				$array['content'] = $content;
				//添加短消息
				$model_message = Model('message');
				$insert_arr = array();
				$insert_arr['from_member_id'] = 0;
				if ($send_type == 2){
					$insert_arr['member_id'] = 'all';
				} else {
					$insert_arr['member_id'] = ",".implode(',',$memberid_list).",";
				}
				$insert_arr['msg_content'] = $content;
				$insert_arr['message_type'] = 1;
				$insert_arr['message_ismore'] = 1;
				$model_message->saveMessage($insert_arr);
				//跳转
				$this->log(L('notice_index_send'),1);
				showMessage(Language::get('notice_index_send_succ'),'index.php?act=notice&op=notice');
			}
		}
		Tpl::showpage('notice.add');
	}
}
