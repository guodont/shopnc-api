<?php
/**
 * 虚拟订单退款
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class vr_refundControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('refund');
		$model_vr_refund = Model('vr_refund');
		$model_vr_refund->getRefundStateArray();
	}

	/**
	 * 待处理列表
	 */
	public function refund_manageOp() {
		$model_vr_refund = Model('vr_refund');
		$condition = array();
		$condition['admin_state'] = '1';//状态:1为待审核,2为同意,3为不同意

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
		$refund_list = $model_vr_refund->getRefundList($condition,10);

		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$model_vr_refund->showpage());
		Tpl::showpage('vr_refund_manage.list');
	}

	/**
	 * 所有记录
	 */
	public function refund_allOp() {
		$model_vr_refund = Model('vr_refund');
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
		$refund_list = $model_vr_refund->getRefundList($condition,10);
		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$model_vr_refund->showpage());
		Tpl::showpage('vr_refund_all.list');
	}

	/**
	 * 审核页
	 *
	 */
	public function editOp() {
		$model_vr_refund = Model('vr_refund');
		$condition = array();
		$condition['refund_id'] = intval($_GET['refund_id']);
		$refund_list = $model_vr_refund->getRefundList($condition);
		$refund = $refund_list[0];
		if (chksubmit()) {
			if ($refund['admin_state'] != '1') {//检查状态,防止页面刷新不及时造成数据错误
				showMessage(Language::get('nc_common_save_fail'));
			}
			$refund['admin_time'] = time();
			$refund['admin_state'] = '2';
			if ($_POST['admin_state'] == '3') {
				$refund['admin_state'] = '3';
			}
			$refund['admin_message'] = $_POST['admin_message'];
			$state = $model_vr_refund->editOrderRefund($refund);
			if ($state) {

    			// 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $refund['buyer_id'];
                $param['param'] = array(
                    'refund_url' => urlShop('member_vr_refund', 'view', array('refund_id' => $refund['refund_id'])),
                    'refund_sn' => $refund['refund_sn']
                );
                QueueClient::push('sendMemberMsg', $param);

			    $this->log('虚拟订单退款审核，退款编号'.$refund['refund_sn']);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=vr_refund&op=refund_manage');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::output('refund',$refund);
		$code_array = explode(',', $refund['code_sn']);
		Tpl::output('code_array',$code_array);
		Tpl::showpage('vr_refund.edit');
	}

	/**
	 * 查看页
	 *
	 */
	public function viewOp() {
		$model_vr_refund = Model('vr_refund');
		$condition = array();
		$condition['refund_id'] = intval($_GET['refund_id']);
		$refund_list = $model_vr_refund->getRefundList($condition);
		$refund = $refund_list[0];
		Tpl::output('refund',$refund);
		$code_array = explode(',', $refund['code_sn']);
		Tpl::output('code_array',$code_array);
		Tpl::showpage('vr_refund.view');
	}
}
