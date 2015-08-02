<?php
/**
 * 商品评价
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class evaluateControl extends SystemControl{
	public function __construct() {
		parent::__construct();
		Language::read('evaluate');
	}

	public function indexOp() {
		$this->evalgoods_listOp();
	}

	/**
	 * 商品来自买家的评价列表
	 */
	public function evalgoods_listOp() {
		$model_evaluate_goods = Model('evaluate_goods');

		$condition = array();
		//商品名称
		if (!empty($_GET['goods_name'])) {
			$condition['geval_goodsname'] = array('like', '%'.$_GET['goods_name'].'%');
		}
		//店铺名称
		if (!empty($_GET['store_name'])) {
			$condition['geval_storename'] = array('like', '%'.$_GET['store_name'].'%');
		}
        $condition['geval_addtime'] = array('time', array(strtotime($_GET['stime']), strtotime($_GET['etime'])));
		$evalgoods_list	= $model_evaluate_goods->getEvaluateGoodsList($condition, 10);

		Tpl::output('show_page',$model_evaluate_goods->showpage());
		Tpl::output('evalgoods_list',$evalgoods_list);
		Tpl::showpage('evalgoods.index');
	}

	/**
	 * 删除商品评价
	 */
	public function evalgoods_delOp() {
		$geval_id = intval($_POST['geval_id']);
		if ($geval_id <= 0) {
			showMessage(Language::get('param_error'),'','','error');
		}

		$model_evaluate_goods = Model('evaluate_goods');

		$result = $model_evaluate_goods->delEvaluateGoods(array('geval_id'=>$geval_id));

		if ($result) {
            $this->log('删除商品评价，评价编号'.$geval_id);
			showMessage(Language::get('nc_common_del_succ'),'','','error');
		} else {
			showMessage(Language::get('nc_common_del_fail'),'','','error');
		}
	}

	/**
	 * 店铺动态评价列表
	 */
	public function evalstore_listOp() {
        $model_evaluate_store = Model('evaluate_store');

		$condition = array();
		//评价人
		if (!empty($_GET['from_name'])) {
			$condition['seval_membername'] = array('like', '%'.$_GET['from_name'].'%');
		}
		//店铺名称
		if (!empty($_GET['store_name'])) {
			$condition['seval_storename'] = array('like', '%'.$_GET['store_name'].'%');
		}
        $condition['seval_addtime_gt'] = array('time', array(strtotime($_GET['stime']), strtotime($_GET['etime'])));

		$evalstore_list	= $model_evaluate_store->getEvaluateStoreList($condition, 10);
		Tpl::output('show_page',$model_evaluate_store->showpage());
		Tpl::output('evalstore_list',$evalstore_list);
		Tpl::showpage('evalstore.index');
	}

	/**
	 * 删除店铺评价
	 */
	public function evalstore_delOp() {
		$seval_id = intval($_POST['seval_id']);
		if ($seval_id <= 0) {
			showMessage(Language::get('param_error'),'','','error');
		}

		$model_evaluate_store = Model('evaluate_store');

		$result = $model_evaluate_store->delEvaluateStore(array('seval_id'=>$seval_id));

		if ($result) {
            $this->log('删除店铺评价，评价编号'.$geval_id);
			showMessage(Language::get('nc_common_del_succ'),'','','error');
		} else {
			showMessage(Language::get('nc_common_del_fail'),'','','error');
		}
	}
}
