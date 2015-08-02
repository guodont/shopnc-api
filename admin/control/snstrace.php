<?php
/**
 * SNS动态
 ***/

defined('InShopNC') or exit('Access Invalid!');
class snstraceControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('snstrace');
	}

	/**
	 * 动态列表
	 */
	public function tracelistOp(){
		$tracelog_model = Model('sns_tracelog');
		$condition = array();
		//会员名
		if($_GET['search_uname'] !=''){
			$condition['trace_membernamelike'] = trim($_GET['search_uname']);
		}
		//内容
		if($_GET['search_content'] !=''){
			$condition['trace_contentortitle'] = trim($_GET['search_content']);
		}
		//状态
		if($_GET['search_state'] != ''){
			$condition['trace_state'] = "{$_GET['search_state']}";
		}
		//发表时间
		if($_GET['search_stime'] !=''){
			$condition['stime'] = strtotime($_GET['search_stime']);
		}
		if($_GET['search_etime'] !=''){
			$condition['etime'] = strtotime($_GET['search_etime']);
		}
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$tracelist = $tracelog_model->getTracelogList($condition,$page);
		if (!empty($tracelist)){
			foreach ($tracelist as $k=>$v){
				if(!empty($v['trace_title'])){
					//替换标题中的siteurl
					$v['trace_title'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $v['trace_title']);
				}
				if(!empty($v['trace_content'])){
					//替换内容中的siteurl
					$v['trace_content'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $v['trace_content']);
					//将收藏商品和店铺连接剔除
					$v['trace_content'] = str_replace(Language::get('admin_snstrace_collectgoods'), "", $v['trace_content']);
					$v['trace_content'] = str_replace(Language::get('admin_snstrace_collectstore'), "", $v['trace_content']);
				}
				$tracelist[$k] = $v;
			}
		}
		Tpl::output('tracelist',$tracelist);
		Tpl::output('show_page',$page->show());
		Tpl::showpage('snstrace.index');
	}

	/**
	 * 删除动态
	 */
	public function tracedelOp(){
		$tid = $_POST['t_id'];
		if(empty($tid)){
			showMessage(Language::get('admin_snstrace_pleasechoose_del'),'index.php?act=snstrace&op=tracelist','','error');
		}
		$tid_str = implode("','",$tid);
		//删除动态
		$tracelog_model = Model('sns_tracelog');
		$result = $tracelog_model->delTracelog(array('trace_id_in'=>$tid_str));
		if($result){
			//判断是否完全删除
			$tracelog_list = $tracelog_model->getTracelogList(array('traceid_in'=>"$tid_str"));
			if(!empty($tracelog_list)){
				foreach($tracelog_list as $k=>$v){
					unset($tid[array_search($v['trace_id'],$tid)]);
				}
			}
			$tid_str = implode("','",$tid);
			//删除动态下的评论
			$comment_model = Model('sns_comment');
			$condition = array();
			$condition['comment_originalid_in'] = $tid_str;
			$condition['comment_originaltype'] = "0";
			$comment_model->delComment($condition);
			//更新转帖的原帖删除状态为已经删除
			$tracelog_model->tracelogEdit(array('trace_originalstate'=>'1'),array('trace_originalid_in'=>"$tid_str"));
			$this->log(L('nc_del,admin_snstrace_comment'),1);
			showMessage(Language::get('nc_common_del_succ'),'index.php?act=snstrace&op=tracelist','','succ');
		}else{
			showMessage(Language::get('nc_common_del_fail'),'index.php?act=snstrace&op=tracelist','','error');
		}
	}

	/**
	 * 编辑动态
	 */
	public function traceeditOp(){
		$tid = $_POST['t_id'];
		if(empty($tid)){
			showMessage(Language::get('admin_snstrace_pleasechoose_edit'),'index.php?act=snstrace&op=tracelist','','error');
		}
		$tid_str = implode("','",$tid);
		$type = $_GET['type'];
		//删除动态
		$tracelog_model = Model('sns_tracelog');
		$update_arr = array();
		if($type == 'hide'){
			$update_arr['trace_state'] = '1';
		}else{
			$update_arr['trace_state'] = '0';
		}
		$result = $tracelog_model->tracelogEdit($update_arr,array('traceid_in'=>"$tid_str"));
		unset($update_arr);
		if($result){
			//判断是否完全修改成功
			$condition = array();
			$condition['traceid_in'] = "$tid_str";
			if($type == 'hide'){
				$condition['trace_state'] = '1';
			}else{
				$condition['trace_state'] = '0';
			}
			$tracelog_list = $tracelog_model->getTracelogList($condition);
			unset($condition);
			$tid_new = array();
			if(!empty($tracelog_list)){
				foreach($tracelog_list as $k=>$v){
					$tid_new[] = $v['trace_id'];
				}
			}
			$tid_str = implode("','",$tid_new);
			//更新转帖的原帖删除状态为已经删除或者为显示
			$update_arr = array();
			if($type == 'hide'){
				$update_arr['trace_originalstate'] = '1';
			}else{
				$update_arr['trace_originalstate'] = '0';
			}
			$tracelog_model->tracelogEdit($update_arr,array('trace_originalid_in'=>"$tid_str"));
			$this->log(L('nc_edit,admin_snstrace_comment'),1);
			showMessage(Language::get('nc_common_op_succ'),'index.php?act=snstrace&op=tracelist','','succ');
		}else{
			showMessage(Language::get('nc_common_op_fail'),'index.php?act=snstrace&op=tracelist','','error');
		}
	}

	/**
	 * 评论列表
	 */
	public function commentlistOp(){
		$comment_model = Model('sns_comment');
		//查询评论总数
		$condition = array();
		//会员名
		if($_GET['search_uname'] !=''){
			$condition['comment_membername_like'] = trim($_GET['search_uname']);
		}
		//内容
		if($_GET['search_content'] !=''){
			$condition['comment_content_like'] = trim($_GET['search_content']);
		}
		//状态
		if($_GET['search_state'] != ''){
			$condition['comment_state'] = "{$_GET['search_state']}";
		}
		//发表时间
		if($_GET['search_stime'] !=''){
			$condition['stime'] = strtotime($_GET['search_stime']);
		}
		if($_GET['search_etime'] !=''){
			$condition['etime'] = strtotime($_GET['search_etime']);
		}
		if($_GET['tid'] !=''){
			$condition['comment_originalid'] = "{$_GET['tid']}";
			$condition['comment_originaltype'] = "0";//原帖类型 0表示动态信息 1表示分享商品
		}
		//评价列表
		$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('admin');
		$commentlist = $comment_model->getCommentList($condition,$page);
		Tpl::output('commentlist',$commentlist);
		Tpl::output('show_page',$page->show());
		Tpl::showpage('snscomment.index');
	}
	/**
	 * 删除评论
	 */
	public function commentdelOp(){
		$cid = $_POST['c_id'];
		if(empty($cid)){
			showMessage(Language::get('admin_snstrace_pleasechoose_del'),'index.php?act=snstrace&op=commentlist','','error');
		}
		$cid_str = implode("','",$cid);
		//删除评论
		$comment_model = Model('sns_comment');
		$result = $comment_model->delComment(array('comment_id_in'=>"$cid_str"));
		if($result){
			$this->log(L('nc_del,admin_snstrace_pl'),1);
			showMessage(Language::get('nc_common_del_succ'),'index.php?act=snstrace&op=commentlist','','succ');
		}else{
			showMessage(Language::get('nc_common_del_fail'),'index.php?act=snstrace&op=commentlist','','error');
		}
	}

	/**
	 * 编辑评论
	 */
	public function commenteditOp(){
		$cid = $_POST['c_id'];
		if(empty($cid)){
			showMessage(Language::get('admin_snstrace_pleasechoose_edit'),'index.php?act=snstrace&op=commentlist','','error');
		}
		$cid_str = implode("','",$cid);
		$type = $_GET['type'];
		//删除动态
		$comment_model = Model('sns_comment');
		$update_arr = array();
		if($type == 'hide'){
			$update_arr['comment_state'] = '1';
		}else{
			$update_arr['comment_state'] = '0';
		}
		$result = $comment_model->commentEdit($update_arr,array('comment_id_in'=>"$cid_str"));
		unset($update_arr);
		if($result){
			$this->log(L('nc_edit,admin_snstrace_pl'),1);
			showMessage(Language::get('nc_common_op_succ'),'index.php?act=snstrace&op=commentlist','','succ');
		}else{
			showMessage(Language::get('nc_common_op_fail'),'index.php?act=snstrace&op=commentlist','','error');
		}
	}
}
?>
