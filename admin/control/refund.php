<?php
/**
 * 退款管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class refundControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		$model_refund = Model('refund_return');
		$model_refund->getRefundStateArray();
	}

	/**
	 * 待处理列表
	 */
	public function refund_manageOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['refund_state'] = '2';//状态:1为处理中,2为待管理员处理,3为已完成

		$keyword_type = array('order_sn','refund_sn','store_name','buyer_name','goods_name');
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != '') {
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false) {
				$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
			}
		}
		$refund_list = $model_refund->getRefundList($condition,10);

		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$model_refund->showpage());
		Tpl::showpage('refund_manage.list');
	}

	/**
	 * 所有记录
	 */
	public function refund_allOp() {
		$model_refund = Model('refund_return');
		$condition = array();

		$keyword_type = array('order_sn','refund_sn','store_name','buyer_name','goods_name');
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != '') {
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false) {
				$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
			}
		}
		$refund_list = $model_refund->getRefundList($condition,10);
		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$model_refund->showpage());
		Tpl::showpage('refund_all.list');
	}

	/**
	 * 退款处理页
	 *
	 */
	public function editOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['refund_id'] = intval($_GET['refund_id']);
		$refund_list = $model_refund->getRefundList($condition);
		$refund = $refund_list[0];
		if (chksubmit()) {
			if ($refund['refund_state'] != '2') {//检查状态,防止页面刷新不及时造成数据错误
				showMessage(Language::get('nc_common_save_fail'));
			}
			$order_id = $refund['order_id'];
			$refund_array = array();
			$refund_array['admin_time'] = time();
			$refund_array['refund_state'] = '3';//状态:1为处理中,2为待管理员处理,3为已完成
			$refund_array['admin_message'] = $_POST['admin_message'];
			$state = $model_refund->editOrderRefund($refund);
			if ($state) {
			    $model_refund->editRefundReturn($condition, $refund_array);

    			// 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $refund['buyer_id'];
                $param['param'] = array(
                    'refund_url' => urlShop('member_refund', 'view', array('refund_id' => $refund['refund_id'])),
                    'refund_sn' => $refund['refund_sn']
                );
                QueueClient::push('sendMemberMsg', $param);

			    $this->log('退款确认，退款编号'.$refund['refund_sn']);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=refund&op=refund_manage');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::output('refund',$refund);
		$info['buyer'] = array();
	    if(!empty($refund['pic_info'])) {
	        $info = unserialize($refund['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		Tpl::showpage('refund.edit');
	}

	/**
	 * 退款记录查看页
	 *
	 */
	public function viewOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['refund_id'] = intval($_GET['refund_id']);
		$refund_list = $model_refund->getRefundList($condition);
		$refund = $refund_list[0];
		Tpl::output('refund',$refund);
		$info['buyer'] = array();
	    if(!empty($refund['pic_info'])) {
	        $info = unserialize($refund['pic_info']);
	    }
		Tpl::output('pic_list',$info['buyer']);
		Tpl::showpage('refund.view');
	}

	/**
	 * 退款退货原因
	 */
	public function reasonOp() {
		$model_refund = Model('refund_return');
		$condition = array();

		$reason_list = $model_refund->getReasonList($condition,10);
		Tpl::output('reason_list',$reason_list);
		Tpl::output('show_page',$model_refund->showpage());

		Tpl::showpage('refund_reason.list');
	}

	/**
	 * 新增退款退货原因
	 *
	 */
	public function add_reasonOp() {
		$model_refund = Model('refund_return');
		if (chksubmit()) {
		    $reason_array = array();
		    $reason_array['reason_info'] = $_POST['reason_info'];
		    $reason_array['sort'] = intval($_POST['sort']);
		    $reason_array['update_time'] = time();

		    $state = $model_refund->addReason($reason_array);
			if ($state) {
			    $this->log('新增退款退货原因，编号'.$state);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=refund&op=reason');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::showpage('refund_reason.add');
	}

	/**
	 * 编辑退款退货原因
	 *
	 */
	public function edit_reasonOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['reason_id'] = intval($_GET['reason_id']);
		$reason_list = $model_refund->getReasonList($condition);
		$reason = $reason_list[$condition['reason_id']];
		if (chksubmit()) {
		    $reason_array = array();
		    $reason_array['reason_info'] = $_POST['reason_info'];
		    $reason_array['sort'] = intval($_POST['sort']);
		    $reason_array['update_time'] = time();
			$state = $model_refund->editReason($condition, $reason_array);
			if ($state) {
			    $this->log('编辑退款退货原因，编号'.$condition['reason_id']);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=refund&op=reason');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::output('reason',$reason);
		Tpl::showpage('refund_reason.edit');
	}

	/**
	 * 删除退款退货原因
	 *
	 */
	public function del_reasonOp() {
		$model_refund = Model('refund_return');
		$condition = array();
		$condition['reason_id'] = intval($_GET['reason_id']);
		$state = $model_refund->delReason($condition);
		if ($state) {
		    $this->log('删除退款退货原因，编号'.$condition['reason_id']);
		    showMessage(Language::get('nc_common_del_succ'),'index.php?act=refund&op=reason');
		} else {
		    showMessage(Language::get('nc_common_del_fail'));
		}
	}
}
