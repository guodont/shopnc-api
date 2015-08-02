<?php
/**
 * Circle Level
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class circle_recycleModel extends Model {
 	public function __construct(){
		parent::__construct();
	}
	/**
	 * Saved to the recycle bin
	 * 
	 * @param array $param
	 */
	public function saveRecycle($param, $data = array()){
		switch($param['type']){
			case 'theme':
				return $this->saveRecycleTheme($param);
				break;
			case 'reply':
				return $this->saveRecycleReply($param);
				break;
			case 'admintheme':
				return $this->saveRecycleThemeAdmin($param, $data);
				break;
			case 'adminreply':
				return $this->saveRecycleReplyAdmin($param, $data);
				break;
			default:
				return false;
				break;
		}
	}
	/**
	 * Keep the theme to the recycle bin
	 * 
	 * @param array $param
	 */
	private function saveRecycleTheme($param){
		$theme_info = $this->themeInfo($param);
		if(empty($theme_info)) return false;
		$insert = array();
		$insert['member_id']		= $theme_info['member_id'];
		$insert['member_name']		= $theme_info['member_name'];
		$insert['circle_id']		= $theme_info['circle_id'];
		$insert['circle_name']		= $theme_info['circle_name'];
		$insert['theme_name']		= $theme_info['theme_name'];
		$insert['recycle_content']	= $theme_info['theme_content'];
		$insert['recycle_opid']		= $param['op_id'];
		$insert['recycle_opname']	= $param['op_name'];
		$insert['recycle_type']		= 1;
		$insert['recycle_time']		= time();
		return $this->add($insert);
	}
	/**
	 * Keep the theme to the recycle bin
	 * 
	 * @param array $param
	 */
	private function saveRecycleThemeAdmin($param, $theme_info){
		$insert = array();
		$insert['member_id']		= $theme_info['member_id'];
		$insert['member_name']		= $theme_info['member_name'];
		$insert['circle_id']		= $theme_info['circle_id'];
		$insert['circle_name']		= $theme_info['circle_name'];
		$insert['theme_name']		= $theme_info['theme_name'];
		$insert['recycle_content']	= $theme_info['theme_content'];
		$insert['recycle_opid']		= $param['op_id'];
		$insert['recycle_opname']	= $param['op_name'];
		$insert['recycle_type']		= 1;
		$insert['recycle_time']		= time();
		return $this->add($insert);
	}
	/**
	 * Keep the reply to the recycle bin
	 * 
	 * @param array $param
	 */
	private function saveRecycleReply($param){
		$theme_info = $this->themeInfo($param);
		if(empty($theme_info)) return false;
		$reply_info = $this->replyInfo($param);
		if(empty($reply_info)) return false;
		$insert = array();
		$insert['member_id']		= $reply_info['member_id'];
		$insert['member_name']		= $reply_info['member_name'];
		$insert['circle_id']		= $theme_info['circle_id'];
		$insert['circle_name']		= $theme_info['circle_name'];
		$insert['theme_name']		= $theme_info['theme_name'];
		$insert['recycle_content']	= $reply_info['reply_content'];
		$insert['recycle_opid']		= $param['op_id'];
		$insert['recycle_opname']	= $param['op_name'];
		$insert['recycle_type']		= 2;
		$insert['recycle_time']		= time();
		return $this->add($insert);
	}
	/**
	 * Keep the reply to the recycle bin for admin
	 * 
	 * @param array $param
	 */
	private function saveRecycleReplyAdmin($param, $reply_info){
		$theme_info = $this->themeInfo($param);
		if(empty($theme_info)) return false;
		$insert = array();
		$insert['member_id']		= $reply_info['member_id'];
		$insert['member_name']		= $reply_info['member_name'];
		$insert['circle_id']		= $theme_info['circle_id'];
		$insert['circle_name']		= $theme_info['circle_name'];
		$insert['theme_name']		= $theme_info['theme_name'];
		$insert['recycle_content']	= $reply_info['reply_content'];
		$insert['recycle_opid']		= $param['op_id'];
		$insert['recycle_opname']	= $param['op_name'];
		$insert['recycle_type']		= 2;
		$insert['recycle_time']		= time();
		return $this->add($insert);
	}
	/**
	 * save data
	 * 
	 * @param array $param
	 */
	private function add($param){
		return $this->table('circle_recycle')->insert($param);
	}
	/**
	 * theme information
	 * 
	 * @param array $param
	 * @return array 
	 */
	private function themeInfo($param){
		return $this->table('circle_theme')->where(array('theme_id'=>$param['theme_id']))->find();
	}
	/**
	 * theme information
	 * 
	 * @param array $param
	 * @return array 
	 */
	private function replyInfo($param){
		return $this->table('circle_threply')->where(array('theme_id'=>$param['theme_id'], 'reply_id'=>$param['reply_id']))->find();
	}
}
