<?php
/**
 * 聊天记录查询
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_imControl extends BaseSellerControl {
	public function __construct() {
		parent::__construct();
		$add_time_to = date("Y-m-d");
		$time_from = array();
		$time_from['7'] = strtotime($add_time_to)-60*60*24*7;
		$time_from['60'] = strtotime($add_time_to)-60*60*24*60;
		$add_time_from = date("Y-m-d",$time_from['60']);
		Tpl::output('minDate', $add_time_from);//只能查看2个月内数据
		Tpl::output('maxDate', $add_time_to);
		if (empty($_GET['add_time_from']) || $_GET['add_time_from'] < $add_time_from) {//默认显示7天内数据
			$_GET['add_time_from'] = date("Y-m-d",$time_from['7']);
		}
		if (empty($_GET['add_time_to']) || $_GET['add_time_to'] > $add_time_to) {
			$_GET['add_time_to'] = $add_time_to;
		}
	}
	/**
	 * 查询页
	 *
	 */
	public function indexOp() {
        $model_seller = Model('seller');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
        $seller_list = $model_seller->getSellerList($condition, '', 'seller_id asc');//账号列表
        Tpl::output('seller_list', $seller_list);

		$seller_id = $_SESSION['seller_id'];
        Tpl::output('seller_id', $seller_id);
		self::profile_menu('im','index');
		Tpl::showpage('store_chat.index');
	}
	/**
	 * 聊天记录查看页
	 *
	 */
	public function get_chat_logOp() {
        $model_seller = Model('seller');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['seller_id'] = $_GET['seller_id'];
        $seller = $model_seller->getSellerInfo($condition);//账号
		Tpl::output('seller', $seller);
		if ($seller['member_id'] > 0) {//验证商家账号
		    $model_chat	= Model('web_chat');
			$condition['add_time_from'] = trim($_GET['add_time_from']);
			$condition['add_time_to'] = trim($_GET['add_time_to']);
			$condition['f_id'] = intval($seller['member_id']);
			$condition['t_id'] = intval($_GET['t_id']);
			$condition['t_msg'] = trim($_GET['msg_key']);
			$list = $model_chat->getLogFromList($condition,15);
			$list = array_reverse($list);
			Tpl::output('list', $list);
			Tpl::output('show_page',$model_chat->showpage());
		}
		Tpl::showpage('store_chat_log','null_layout');
	}
	/**
	 * 最近联系人
	 *
	 */
	public function get_user_listOp() {
        $model_seller = Model('seller');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['seller_id'] = $_GET['seller_id'];
        $seller = $model_seller->getSellerInfo($condition);//账号
		$member_list = array();
		if ($seller['member_id'] > 0) {//验证商家账号
		    $model_chat	= Model('web_chat');
		    $add_time_to = date("Y-m-d");
			$add_time_from = strtotime($add_time_to)-60*60*24*60;
			$add_time_to = strtotime($add_time_to);
			$condition = array();
			$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
		    $condition['f_id'] = $seller['member_id'];
		    $member_list = $model_chat->getRecentList($condition,100,$member_list);
			$condition = array();
			$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
		    $condition['t_id'] = $seller['member_id'];
		    $member_list = $model_chat->getRecentFromList($condition,100,$member_list);
			Tpl::output('list', $member_list);
		}
		Tpl::showpage('store_chat_user','null_layout');
	}
	/**
	 * 小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array = array();
		switch ($menu_type) {
			case 'im':
				$menu_array = array(
					array('menu_key'=>'index','menu_name'=>'聊天记录查询',	'menu_url'=>'index.php?act=store_im&op=index')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
