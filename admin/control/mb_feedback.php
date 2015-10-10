<?php
/**
 * 合作伙伴管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class mb_feedbackControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('mobile');
	}
	/**
	 * 意见反馈
	 */
	public function flistOp(){
		$model_mb_feedback = Model('mb_feedback');
		$list = $model_mb_feedback->getMbFeedbackList(array(), 10);

		Tpl::output('list', $list);
		Tpl::output('page', $model_mb_feedback->showpage());
		Tpl::showpage('mb_feedback.index');
	}

	/**
	 * 删除
	 */
	public function delOp(){
        $model_mb_feedback = Model('mb_feedback');
        $result = $model_mb_feedback->delMbFeedback($_POST['feedback_id']);
		if ($result){
			showMessage(L('nc_common_op_succ'));
		}else {
			showMessage(L('nc_common_op_fail'));
		}
	}
}
