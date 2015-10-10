<?php
/**
 * 聊天记录查询
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class chat_logControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		$add_time_to = date("Y-m-d");
		$time_from = array();
		$time_from['7'] = strtotime($add_time_to)-60*60*24*7;
		$time_from['90'] = strtotime($add_time_to)-60*60*24*90;
		$add_time_from = date("Y-m-d",$time_from['90']);
		Tpl::output('minDate', $add_time_from);//只能查看3个月内数据
		Tpl::output('maxDate', $add_time_to);
		if (empty($_GET['add_time_from']) || $_GET['add_time_from'] < $add_time_from) {//默认显示7天内数据
			$_GET['add_time_from'] = date("Y-m-d",$time_from['7']);
		}
		if (empty($_GET['add_time_to']) || $_GET['add_time_to'] > $add_time_to) {
			$_GET['add_time_to'] = $add_time_to;
		}
	}

	/**
	 * 聊天记录查询
	 */
	public function chat_logOp() {
		$model_chat	= Model('web_chat');
		$f_member = array();//发消息人
		$t_member = array();//收消息人
		$f_name = trim($_GET['f_name']);
		if (!empty($f_name)) {
    		$condition = array();
    		$condition['member_name'] = $f_name;
            $f_member = $model_chat->getMemberInfo($condition);
    		Tpl::output('f_member', $f_member);
		}
		$t_name = trim($_GET['t_name']);
		if (!empty($t_name)) {
    		$condition = array();
    		$condition['member_name'] = $t_name;
            $t_member = $model_chat->getMemberInfo($condition);
    		Tpl::output('t_member', $t_member);
		}
		if ($f_member['member_id'] > 0 && $t_member['member_id'] > 0) {//验证账号
		    $condition = array();
			$condition['add_time_from'] = trim($_GET['add_time_from']);
			$condition['add_time_to'] = trim($_GET['add_time_to']);
			$condition['f_id'] = intval($f_member['member_id']);
			$condition['t_id'] = intval($t_member['member_id']);
			$log_list = $model_chat->getLogFromList($condition,15);
			$log_list = array_reverse($log_list);
			Tpl::output('log_list',$log_list);
			Tpl::output('show_page',$model_chat->showpage());
		}
		Tpl::showpage('chat_log.list');
	}

	/**
	 * 聊天内容查询
	 */
	public function msg_logOp() {
		if (!empty($_GET['msg'])) {
		    $model_chat	= Model('web_chat');
		    $condition = array();
			$add_time_from = strtotime($_GET['add_time_from']);
			$add_time_to = strtotime($_GET['add_time_to']);
			$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
			$condition['t_msg'] = array('like','%'.trim($_GET['msg']).'%');
			$log_list = $model_chat->getLogList($condition,15);
			$log_list = array_reverse($log_list);
			Tpl::output('log_list',$log_list);
			Tpl::output('show_page',$model_chat->showpage());
		}
		Tpl::showpage('chat_msg_log.list');
	}
}
