<?php
/**
 * 抢购管理
 *
 *
 *
 *
 * */

defined('InShopNC') or exit('Access Invalid!');
class live_groupbuyControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('live');
	}

	public function indexOp(){
		$this->live_groupbuyOp();
	}

	/*
	 * 抢购列表
	 */
	public function live_groupbuyOp(){
		$condition	=	array();
		if(isset($_POST) && !empty($_POST)){
			//抢购状态
			if(intval($_POST['groupbuy_state']) == 1){
				$condition['start_time']	=	array('gt',time());
			}elseif(intval($_POST['groupbuy_state']) == 2){
				$condition['start_time']	=	array('lt',time());
				$condition['end_time']	=	array('gt',time());
			}elseif(intval($_POST['groupbuy_state']) == 3){
				$condition['end_time']	=	array('lt',time());
			}

			//审核状态
			if(isset($_POST['audit']) && !empty($_POST['audit'])){
				$condition['is_audit']	=	intval($_POST['audit']);
			}

			Tpl::output('groupbuy_state',intval($_POST['groupbuy_state']));
			Tpl::output('is_audit',intval($_POST['audit']));
		}


		$model_live_groupbuy = Model('live_groupbuy');
		$list = $model_live_groupbuy->getList($condition);

		Tpl::output('list',$list);
		Tpl::output('show_page',$model_live_groupbuy->showpage());
		Tpl::showpage('livegroupbuy.list');
	}

	/*
	 * 删除抢购
	 */
	public function del_groupbuyOp(){
		if(isset($_POST)&&!empty($_POST)){
			$condition = array();
			$condition['groupbuy_id'] = array('in',$_POST['groupbuy_id']);

			$model_live_groupbuy = Model('live_groupbuy');
			$res = $model_live_groupbuy->del($condition);

			if($res){
				showMessage('删除抢购成功','index.php?act=live_groupbuy','','succ');
			}else{
				showMessage('删除抢购失败','index.php?act=live_groupbuy','','error');
			}
		}
	}

	/*
	 * 审核
	 */
	public function auditOp(){
		$model_live_groupbuy = Model('live_groupbuy');
		$res = $model_live_groupbuy->edit(array('groupbuy_id'=>intval($_GET['groupbuy_id'])),array('is_audit'=>intval($_GET['is_audit'])));

		if($res){
			$this->log('审核抢购成功[ID:'.intval($_GET['groupbuy_id']).']',1);
			showMessage('审核成功','index.php?act=live_groupbuy','','succ');
		}else{
			showMessage('审核失败','index.php?act=live_groupbuy','','error');
		}
	}

	/*
	 * 取消抢购
	 */
	public function cancelOp(){
		$model_live_groupbuy = Model('live_groupbuy');
		$res = $model_live_groupbuy->edit(array('groupbuy_id'=>intval($_GET['groupbuy_id'])),array('is_open'=>2));//取消抢购

		if($res){
			$this->log('取消抢购[ID:'.intval($_GET['groupbuy_id']).']',1);
			showMessage('操作成功','index.php?act=live_groupbuy','','succ');
		}else{
			showMessage('操作失败','index.php?act=live_groupbuy','','error');
		}

	}

	/*
	 * 推荐管理
	 */
	public function ajaxOp(){
		$model_live_groupbuy = Model('live_groupbuy');
		$res = $model_live_groupbuy->edit(array('groupbuy_id'=>intval($_GET['id'])),array('is_hot'=>intval($_GET['value'])));

		if($res){
			echo 'true';exit;
		}else{
			echo 'false';exit;
		}
	}


	/*
	 * 查看抢购券
	 */
	public function groupbuyvoucherOp(){
		$groupbuy_id	= intval($_GET['groupbuy_id']);
		$model 		= Model();

		//抢购
		$groupbuy = $model->table('live_groupbuy')->where(array('groupbuy_id'=>$groupbuy_id))->find();
		if(empty($groupbuy)){
			showMessage('抢购不存在','index.php?act=live_groupbuy','','error');
		}

		$condition					=	array();//查询条件
		$condition['live_order.item_id']	=	$groupbuy_id;

		//获得数据
		$field  = 'live_order.order_sn,live_order.store_name,live_order.item_name,live_order.member_name,live_order_pwd.state,live_order_pwd.use_time,live_order_pwd.order_pwd';
		$on		= 'live_order_pwd.order_id = live_order.order_id';
		$model->table('live_order_pwd,live_order')->field($field);
		$list = $model->join('left')->on($on)->where($condition)->page(20)->order('order_item_id desc')->select();
		Tpl::output('list',$list);

		Tpl::output('show_page',$model->showpage());
		Tpl::showpage('livevoucher.list');
	}
}
