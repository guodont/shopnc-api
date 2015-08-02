<?php
/**
 * SNS动态
 ***/

defined('InShopNC') or exit('Access Invalid!');
class sns_straceControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('snstrace,sns_strace');
	}

	/**
	 * 动态列表
	 */
	public function stracelistOp(){
		// where条件
		$where = array();
		if($_GET['search_sname'] != ''){
			$where['strace_storename']	= array('like','%'.trim($_GET['search_sname']).'%');
		}
		if($_GET['search_scontent'] != ''){
			$where['search_scontent']	= array('like','%'.trim($_GET['search_scontent']).'%');
		}
		if($_GET['search_type'] != ''){
			$where['strace_type']		= trim($_GET['search_type']);
		}
		if($_GET['search_stime'] != '' || $_GET['search_etime'] != ''){
		    $s_time = $_GET['search_stime'] != '' ? strtotime($_GET['search_stime']) : null;
		    $e_time = $_GET['search_etime'] != '' ? strtotime($_GET['search_etime']) : null;
			$where['strace_time']		= array('time',array($s_time, $e_time));
		}
		// 实例化模型
		$model_stracelog = Model('store_sns_tracelog');
		$strace_list = Model('store_sns_tracelog')->getStoreSnsTracelogList($where, '*', 'strace_id desc', 0, 10);
		if(!empty($strace_list) && is_array($strace_list)){
			foreach ($strace_list as $key=>$val){
				if($val['strace_content'] == ''){
					$data = json_decode($val['strace_goodsdata'],true);
					if( CHARSET == 'GBK') {
						foreach ((array)$data as $k=>$v){
							$data[$k] = Language::getGBK($v);
						}
					}
					$content = $model_stracelog->spellingStyle($val['strace_type'], $data);
					$strace_list[$key]['strace_content'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $content);
				}
			}
		}
		Tpl::output('show_page', $model_stracelog->showpage(2));
		Tpl::output('strace_list', $strace_list);
		Tpl::showpage('sns_strace.index');
	}

	/**
	 * 删除动态
	 */
	public function strace_delOp(){
		// 验证参数
		if(empty($_POST['st_id']) && !is_array($_POST['st_id'])){
			showMessage(Language::get('param_error'), '', '', 'error');
		}
		$st_id = $_POST['st_id'];
		// 实例化模型
		$model = Model();
		// 删除动态
		$rs = Model('store_sns_tracelog')->delStoreSnsTracelog(array('strace_id'=>array('in',$st_id)));
		if($rs){
			// 删除评论
			Model('store_sns_comment')->delStoreSnsComment(array('strace_id'=>array('in',$st_id)));
			$this->log(L('nc_del,admin_snstrace_comment'),1);
			showMessage(Language::get('nc_common_del_succ'));
		}else{
			showMessage(Language::get('nc_common_del_fail'),'','','error');
		}
	}

	/**
	 * 编辑动态
	 */
	public function strace_editOp(){
		// 验证参数
		if(empty($_POST['st_id']) && !is_array($_POST['st_id'])){
			showMessage(Language::get('param_error'), '', '', 'error');
		}
		// where条件
		$where = array();
		$where['strace_id']	= array('in', $_POST['st_id']);
		// update条件
		$update = array();
		$update['strace_state']	= 1;
		if($_GET['type'] == 'hide'){
			$update['strace_state'] = 0;
		}
		// 实例化模型
		$rs = Model('store_sns_comment')->editStoreSnsTracelog($update, $where);
		if($rs){
			$this->log(L('nc_edit,admin_snstrace_comment'),1);
			showMessage(Language::get('nc_common_op_succ'));
		}else{
			showMessage(Language::get('nc_common_op_fail'),'','','error');
		}
	}

	/**
	 * 评论列表
	 */
	public function scomm_listOp(){
		// where 条件
		$where = array();
		$st_id = intval($_GET['st_id']);
		if($st_id > 0){
			$where['strace_id'] = $st_id;
		}
		if($_GET['search_uname'] != ''){
			$where['scomm_membername']	= array('like','%'.trim($_GET['search_uname']).'%');
		}
		if($_GET['search_content'] != ''){
			$where['scomm_content']		= array('like','%'.trim($_GET['search_content']).'%');
		}
		if($_GET['search_state'] != ''){
			$where['scomm_state']		= intval($_GET['search_state']);
		}
		if($_GET['search_stime'] != '' || $_GET['search_etime'] != ''){
		    $s_time = $_GET['search_stime'] != '' ? strtotime($_GET['search_stime']) : null;
		    $e_time = $_GET['search_etime'] != '' ? strtotime($_GET['search_etime']) : null;
			$where['scomm_time']		= array('time',array($s_time, $e_time));
		}
		$model_storesnscomment = Model('store_sns_comment');
		$scomm_list = $model_storesnscomment->getStoreSnsCommentList($where, '*', 'scomm_id desc', 0, 20);
		Tpl::output('show_page', $model_storesnscomment->showpage(2));
		Tpl::output('scomm_list', $scomm_list);
		Tpl::showpage('sns_scomment.index');
	}
	/**
	 * 删除评论
	 */
	public function scomm_delOp(){
		if(isset($_GET['sc_id'])){
			$sc_id = $_GET['sc_id'];
		}
		if(isset($_POST['sc_id']) && is_array($_POST['sc_id'])){
			$sc_id = $_POST['sc_id'];
		}
		if(!isset($sc_id)){
			showMessage(Language::get('param_error'), '', '', 'error');
		}

		// 实例化模型
		$rs = Model('store_sns_comment')->delStoreSnsComment(array('scomm_id'=>array('in',$sc_id)));
		if($rs){
			$this->log(L('nc_del,admin_snstrace_pl'),1);
			showMessage(Language::get('nc_common_op_succ'));
		}else{
			showMessage(Language::get('nc_common_del_fail'),'','','error');
		}
	}

	/**
	 * 评论编辑
	 */
	public function scomm_editOp(){
		if(isset($_POST['sc_id']) && is_array($_POST['sc_id'])){
			$sc_id = $_POST['sc_id'];
		}else{
			showMessage(Language::get('param_error'));
		}

		$scomm_state	= 1;
		if($_GET['type'] == 'hide'){
			$scomm_state = 0;
		}
		// 实例化模型
		$rs = Model('store_sns_comment')->editStoreSnsComment(array('scomm_state'=>$scomm_state), array('scomm_id'=>array('in',$sc_id)));
		if($rs){
			$this->log(L('nc_edit,admin_snstrace_pl'),1);
			showMessage(Language::get('nc_common_op_succ'));
		}else{
			showMessage(Language::get('nc_common_del_fail'),'','','error');
		}
	}
}
?>
