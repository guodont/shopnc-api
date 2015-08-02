<?php
/**
 * 积分礼品购物车操作
 ***/


defined('InShopNC') or exit('Access Invalid!');
class pointcartControl extends BasePointShopControl {
	public function __construct() {
		parent::__construct();
		//读取语言包
		Language::read('home_pointcart');

		//判断系统是否开启积分和积分兑换功能
		if (C('pointprod_isuse') != 1){
			showDialog(L('pointcart_unavailable'),'index.php','error');
		}
		//验证是否登录
		if ($_SESSION['is_login'] != '1'){
			showDialog(L('pointcart_unlogin_error'),'index.php?act=login','error');
		}
	}
	/**
	 * 积分礼品购物车首页
	 */
	public function indexOp() {
		$cart_goods	= array();
		$model_pointcart = Model('pointcart');
		$data = $model_pointcart->getPCartListAndAmount(array('pmember_id'=>$_SESSION['member_id']));
		Tpl::output('pgoods_pointall',$data['data']['cartgoods_pointall']);
		Tpl::output('cart_array',$data['data']['cartgoods_list']);
		Tpl::showpage('pointcart_list');
	}
	
	/**
	 * 购物车添加礼品
	 */
	public function addOp() {
		$pgid	= intval($_GET['pgid']);
		$quantity	= intval($_GET['quantity']);
		if($pgid <= 0 || $quantity <= 0) {
			echo json_encode(array('done'=>false,'msg'=>L('pointcart_cart_addcart_fail'))); die;
		}
		
		//验证积分礼品是否存在购物车中
		$model_pointcart = Model('pointcart');
		$check_cart	= $model_pointcart->getPointCartInfo(array('pgoods_id'=>$pgid,'pmember_id'=>$_SESSION['member_id']));
		if(!empty($check_cart)) {
			echo json_encode(array('done'=>true)); die;
		}
		//验证是否能兑换
		$data = $model_pointcart->checkExchange($pgid, $quantity, $_SESSION['member_id']);
		if (!$data['state']){
		    switch ($data['error']){
		        case 'ParameterError':
		            echo json_encode(array('done'=>false,'msg'=>$data['msg'],'url'=>'index.php?act=pointprod&op=plist')); die;
		            break;
		        default:
		            echo json_encode(array('done'=>false,'msg'=>$data['msg'])); die;
		    	    break;		    	
		    }
		}
		$prod_info = $data['data']['prod_info'];
		
		$insert_arr	= array();
		$insert_arr['pmember_id']		= $_SESSION['member_id'];
		$insert_arr['pgoods_id']		= $prod_info['pgoods_id'];
		$insert_arr['pgoods_name']		= $prod_info['pgoods_name'];
		$insert_arr['pgoods_points']	= $prod_info['pgoods_points'];
		$insert_arr['pgoods_choosenum']	= $prod_info['quantity'];
		$insert_arr['pgoods_image']		= $prod_info['pgoods_image_old'];
		$cart_state = $model_pointcart->addPointCart($insert_arr);
		echo json_encode(array('done'=>true)); die;
	}
	
	/**
	 * 积分礼品购物车更新礼品数量
	 */
	public function updateOp() {
		$pcart_id	= intval($_GET['pc_id']);
		$quantity	= intval($_GET['quantity']);
		//兑换失败提示
		$msg = L('pointcart_cart_modcart_fail');
		//转码
		if (strtoupper(CHARSET) == 'GBK'){
			$msg = Language::getUTF8($msg);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		}
		if($pcart_id <= 0 || $quantity <= 0) {
			echo json_encode(array('msg'=>$msg));
			die;
		}
		//验证礼品购物车信息是否存在
		$model_pointcart	= Model('pointcart');
		$cart_info	= $model_pointcart->getPointCartInfo(array('pcart_id'=>$pcart_id,'pmember_id'=>$_SESSION['member_id']));
		if (!$cart_info){
			echo json_encode(array('msg'=>$msg)); die;
		}
		
		//验证是否能兑换
		$data = $model_pointcart->checkExchange($cart_info['pgoods_id'], $quantity, $_SESSION['member_id']);
		if (!$data['state']){
		    echo json_encode(array('msg'=>$data['msg'])); die;
		}
		$prod_info = $data['data']['prod_info'];
		$quantity = $prod_info['quantity'];
		
		$cart_state = true;
		//如果数量发生变化则更新礼品购物车内单个礼品数量
		if ($cart_info['pgoods_choosenum'] != $quantity){
		    $cart_state = $model_pointcart->editPointCart(array('pcart_id'=>$pcart_id,'pmember_id'=>$_SESSION['member_id']),array('pgoods_choosenum'=>$quantity));
		}
		if ($cart_state) {
			//计算总金额
			$amount= $model_pointcart->getPointCartAmount($_SESSION['member_id']);
			echo json_encode(array('done'=>'true','subtotal'=>$prod_info['pointsamount'],'amount'=>$amount,'quantity'=>$quantity));
			die;
		}
	}
	
	/**
	 * 积分礼品购物车删除单个礼品
	 */
	public function dropOp() {
		$pcart_id	= intval($_GET['pc_id']);
		if($pcart_id <= 0) {
		    echo json_encode(array('done'=>false,'msg'=>'删除失败')); die;
		}
		$model_pointcart = Model('pointcart');
		$drop_state	= $model_pointcart->delPointCartById($pcart_id,$_SESSION['member_id']);
		if ($drop_state){
		    echo json_encode(array('done'=>true)); die;
		} else {
		    echo json_encode(array('done'=>false,'msg'=>'删除失败')); die;
		}
	}
	
	/**
	 * 兑换订单流程第一步
	 */
	public function step1Op(){
		//获取符合条件的兑换礼品和总积分
		$data = Model('pointcart')->getCartGoodsList($_SESSION['member_id']);
		if (!$data['state']){
		    showDialog($data['msg'],'index.php?act=pointprod','error');
		}
		Tpl::output('pointprod_arr',$data['data']);

		//实例化收货地址模型（不显示自提点地址）
		$address_list = Model('address')->getAddressList(array('member_id'=>$_SESSION['member_id'],'dlyp_id'=>0), 'is_default desc,address_id desc');
		Tpl::output('address_list',$address_list);

		Tpl::showpage('pointcart_step1');
	}
	/**
	 * 兑换订单流程第二步
	 */
	public function step2Op() {
	    $model_pointcart = Model('pointcart');
		//获取符合条件的兑换礼品和总积分
		$data = $model_pointcart->getCartGoodsList($_SESSION['member_id']);
		if (!$data['state']){
		    showDialog($data['msg'],'index.php?act=pointcart','error');
		}
		$pointprod_arr = $data['data'];
		unset($data);
		
		//验证积分数是否足够
		$data = $model_pointcart->checkPointEnough($pointprod_arr['pgoods_pointall'], $_SESSION['member_id']);
		if (!$data['state']){
		    showDialog($data['msg'],'index.php?act=pointcart','error');
		}
		unset($data);
		
		//创建兑换订单
		$data = Model('pointorder')->createOrder($_POST, $pointprod_arr, array('member_id'=>$_SESSION['member_id'],'member_name'=>$_SESSION['member_name'],'member_email'=>$_SESSION['member_email']));
		if (!$data['state']){
		    showDialog($data['msg'],'index.php?act=pointcart&op=step1','error');
		}
		$order_id = $data['data']['order_id'];
		@header("Location:index.php?act=pointcart&op=step3&order_id=".$order_id);
	}
	/**
	 * 流程第三步
	 */
	public function step3Op($order_arr=array()) {
		$order_id = intval($_GET['order_id']);
		if ($order_id <= 0){
			showDialog(L('pointcart_record_error'),'index.php','error');
		}
		$where = array();
		$where['point_orderid'] = $order_id;
		$where['point_buyerid'] = $_SESSION['member_id'];
		$order_info = Model('pointorder')->getPointOrderInfo($where);
		if (!$order_info){
		    showDialog(L('pointcart_record_error'),'index.php','error');
		}
		Tpl::output('order_info',$order_info);
		Tpl::showpage('pointcart_step2');
	}
}