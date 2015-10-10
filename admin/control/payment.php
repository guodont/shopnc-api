<?php
/**
 * 支付方式
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class paymentControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('payment');
	}

	/**
	 * 支付方式
	 */
	public function indexOp(){
		$model_payment = Model('payment');
		$payment_list = $model_payment->getPaymentList(array('payment_code'=>array('neq','predeposit')));
		Tpl::output('payment_list',$payment_list);
		Tpl::showpage('payment.list');
	}

	/**
	 * 编辑
	 */
	public function editOp(){

		$model_payment = Model('payment');
		if (chksubmit()){
			$payment_id = intval($_POST["payment_id"]);
			$data = array();
			$data['payment_state'] = intval($_POST["payment_state"]);

			$payment_config	= '';
			$config_array = explode(',',$_POST["config_name"]);//配置参数
			if(is_array($config_array) && !empty($config_array)) {
				$config_info = array();
				foreach ($config_array as $k) {
					$config_info[$k] = trim($_POST[$k]);
				}
				$payment_config	= serialize($config_info);
			}
			$data['payment_config'] = $payment_config;//支付接口配置信息
			$model_payment->editPayment($data,array('payment_id'=>$payment_id));
			showMessage(Language::get('nc_common_save_succ'),'index.php?act=payment&op=index');
		}

		$payment_id = intval($_GET["payment_id"]);
		$payment = $model_payment->getPaymentInfo(array('payment_id'=>$payment_id));
		if ($payment['payment_config'] != ''){
			Tpl::output('config_array',unserialize($payment['payment_config']));
		}
		Tpl::output('payment',$payment);
		Tpl::showpage('payment.edit');
	}
}
