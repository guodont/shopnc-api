<?php
/**
 * 订单打印
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_order_printControl extends BaseSellerControl {
	public function __construct() {
		parent::__construct();
		Language::read('member_printorder');
	}

	/**
	 * 查看订单
	 */
	public function indexOp() {
		$order_id	= intval($_GET['order_id']);
		if ($order_id <= 0){
			showMessage(Language::get('wrong_argument'),'','html','error');
		}
		$order_model = Model('order');
		$condition['order_id'] = $order_id;
		$condition['store_id'] = $_SESSION['store_id'];
		$order_info = $order_model->getOrderInfo($condition,array('order_common','order_goods'));
		if (empty($order_info)){
			showMessage(Language::get('member_printorder_ordererror'),'','html','error');
		}
		Tpl::output('order_info',$order_info);

		//卖家信息
		$model_store	= Model('store');
		$store_info		= $model_store->getStoreInfoByID($order_info['store_id']);
		if (!empty($store_info['store_label'])){
			if (file_exists(BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$store_info['store_label'])){
				$store_info['store_label'] = UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.$store_info['store_label'];
			}else {
				$store_info['store_label'] = '';
			}
		}
		if (!empty($store_info['store_stamp'])){
			if (file_exists(BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$store_info['store_stamp'])){
				$store_info['store_stamp'] = UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.$store_info['store_stamp'];
			}else {
				$store_info['store_stamp'] = '';
			}
		}
		Tpl::output('store_info',$store_info);

		//订单商品
		$model_order = Model('order');
		$condition = array();
		$condition['order_id'] = $order_id;
		$condition['store_id'] = $_SESSION['store_id'];
		$goods_new_list = array();
		$goods_all_num = 0;
		$goods_total_price = 0;
		if (!empty($order_info['extend_order_goods'])){
			$goods_count = count($order_goods_list);
			$i = 1;
			foreach ($order_info['extend_order_goods'] as $k => $v){
				$v['goods_name'] = str_cut($v['goods_name'],100);
				$goods_all_num += $v['goods_num'];
				$v['goods_all_price'] = ncPriceFormat($v['goods_num'] * $v['goods_price']);
				$goods_total_price += $v['goods_all_price'];
				$goods_new_list[ceil($i/15)][$i] = $v;
				$i++;
			}
		}
		//优惠金额
		$promotion_amount = $goods_total_price - $order_info['goods_amount'];
		//运费
		$order_info['shipping_fee'] = $order_info['shipping_fee'];
		Tpl::output('promotion_amount',$promotion_amount);
		Tpl::output('goods_all_num',$goods_all_num);
		Tpl::output('goods_total_price',ncPriceFormat($goods_total_price));
		Tpl::output('goods_list',$goods_new_list);
		Tpl::showpage('store_order.print',"null_layout");
	}
}
