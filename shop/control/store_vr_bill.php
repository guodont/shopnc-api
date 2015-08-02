<?php
/**
 * 虚拟订单结算
 ***/


defined('InShopNC') or exit('Access Invalid!');
class store_vr_billControl extends BaseSellerControl {
    /**
     * 每次导出多少条记录
     * @var unknown
     */
    const EXPORT_SIZE = 1000;

    public function __construct() {
    	parent::__construct() ;
    }

	/**
	 * 结算列表
	 *
	 */
    public function indexOp() {
        $model_bill = Model('vr_bill');
        $condition = array();
        $condition['ob_store_id'] = $_SESSION['store_id'];
        if (preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
            $condition['ob_no'] = $_GET['ob_no'];
        }
        if (is_numeric($_GET['bill_state'])) {
            $condition['ob_state'] = intval($_GET['bill_state']);
        }
        $bill_list = $model_bill->getOrderBillList($condition,'*',12,'ob_state asc,ob_no asc');
        Tpl::output('bill_list',$bill_list);
        Tpl::output('show_page',$model_bill->showpage());

        $this->profile_menu('list','list');
        Tpl::showpage('store_vr_bill.index');
    }

	/**
	 * 查看结算单详细
	 *
	 */
	public function show_billOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
			showMessage('参数错误','','html','error');
		}
		if (substr($_GET['ob_no'],6) != $_SESSION['store_id']){
			showMessage('参数错误','','html','error');
		}
        $model_bill = Model('vr_bill');
        $model_order = Model('vr_order');
		$bill_info = $model_bill->getOrderBillInfo(array('ob_no'=>$_GET['ob_no']));
		if (!$bill_info){
			showMessage('参数错误','','html','error');
		}

		$condition = array();
		$condition['store_id'] = $bill_info['ob_store_id'];
		if (preg_match('/^\d{8,20}$/',$_GET['query_order_no'])) {
		    //取order_id
		    $order_info = $model_order->getOrderInfo(array('order_sn'=>$_GET['query_order_no']),'order_id');
		    $condition['order_id'] = $order_info['order_id'];
		}

		$if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
		$if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
		$start_unixtime = $if_start_date ? strtotime($_GET['query_start_date']) : null;
		$end_unixtime = $if_end_date ? strtotime($_GET['query_end_date']) : null;
		if ($if_start_date || $if_end_date) {
		    $condition_time = array('time',array($start_unixtime,$end_unixtime));
		} else {
		    $condition_time = array('between',"{$bill_info['ob_start_date']},{$bill_info['ob_end_date']}");
		}
		if ($_GET['type'] =='timeout'){
		    //计算未使用已过期不可退兑换码列表
		    $condition['vr_state'] = 0;
		    $condition['vr_invalid_refund'] = 0;
		    $condition['vr_indate'] = $condition_time;

		} else {
		    //计算已使用兑换码列表
		    $condition['vr_state'] = 1;
		    $condition['vr_usetime'] = $condition_time;
		}
		$code_list = $model_order->getCodeList($condition, '*', 20, 'rec_id desc');

		//然后取订单编号
		$order_id_array = array();
		if (is_array($code_list)) {
		    foreach ($code_list as $code_info) {
		        $order_id_array[] = $code_info['order_id'];
		    }
		}
		$condition = array();
		$condition['order_id'] = array('in',$order_id_array);
		$order_list = $model_order->getOrderList($condition);
		$order_new_list = array();
		if (!empty($order_list)) {
		    foreach ($order_list as $v) {
		        $order_new_list[$v['order_id']]['order_sn'] = $v['order_sn'];
		        $order_new_list[$v['order_id']]['buyer_name'] = $v['buyer_name'];
		    }
		}
		Tpl::output('order_list',$order_new_list);
		Tpl::output('code_list',$code_list);
		Tpl::output('show_page',$model_order->showpage());
		$sub_tpl_name = 'vr_bill.show.code_list';

		Tpl::output('sub_tpl_name','store_vr_bill.show.code_list');
		Tpl::output('bill_info',$bill_info);
		$this->profile_menu('show',$_GET['type']);
		Tpl::showpage('store_vr_bill.show');
	}

	/**
	 * 打印结算单
	 *
	 */
	public function bill_printOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
			showMessage('参数错误','','html','error');
		}
		if (substr($_GET['ob_no'],6) != $_SESSION['store_id']){
			showMessage('参数错误','','html','error');
		}
		$model_bill = Model('vr_bill');
		$condition = array();
		$condition['ob_no'] = $_GET['ob_no'];
		$condition['ob_state'] = BILL_STATE_SUCCESS;
		$bill_info = $model_bill->getOrderBillInfo($condition);
		if (!$bill_info){
			showMessage('参数错误','','html','error');
		}

		Tpl::output('bill_info',$bill_info);
		Tpl::showpage('store_vr_bill.print','null_layout');
	}

	/**
	 * 店铺确认出账单
	 *
	 */
	public function confirm_billOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
			showDialog('参数错误','','error');
		}
		$model_bill = Model('vr_bill');
		$condition = array();
		$condition['ob_no'] = $_GET['ob_no'];
		$condition['ob_store_id'] = $_SESSION['store_id'];
		$condition['ob_state'] = BILL_STATE_CREATE;
		$update = $model_bill->editOrderBill(array('ob_state'=>BILL_STATE_STORE_COFIRM),$condition);
		if ($update){
			showDialog('确认成功，请等待系统审核','','succ');
		}else{
			showDialog(L('nc_common_op_fail'),'reload','error');
		}
	}

	/**
	 * 导出结算订单明细CSV
	 *
	 */
	public function export_orderOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
			showMessage('参数错误','','html','error');
		}
		if (substr($_GET['ob_no'],6) != $_SESSION['store_id']){
		    showMessage('参数错误','','html','error');
		}

		$model_bill = Model('vr_bill');
		$bill_info = $model_bill->getOrderBillInfo(array('ob_no'=>$_GET['ob_no']));
		if (!$bill_info){
			showMessage('参数错误','','html','error');
		}

		$model_order = Model('vr_order');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		if (preg_match('/^\d{8,20}$/',$_GET['query_order_no'])) {
		    //取order_id
		    $order_info = $model_order->getOrderInfo(array('order_sn'=>$_GET['query_order_no']),'order_id');
		    $condition['order_id'] = $order_info['order_id'];
		}
		$if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
		$if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
		$start_unixtime = $if_start_date ? strtotime($_GET['query_start_date']) : null;
		$end_unixtime = $if_end_date ? strtotime($_GET['query_end_date']) : null;
		if ($if_start_date || $if_end_date) {
		    $condition_time = array('time',array($start_unixtime,$end_unixtime));
		} else {
		    $condition_time = array('between',"{$bill_info['ob_start_date']},{$bill_info['ob_end_date']}");
		}
		if ($_GET['type'] =='timeout'){
		    //计算未使用已过期不可退兑换码列表
		    $condition['vr_state'] = 0;
		    $condition['vr_invalid_refund'] = 0;
		    $condition['vr_indate'] = $condition_time;
		
		} else {
		    //计算已使用兑换码列表
		    $condition['vr_state'] = 1;
		    $condition['vr_usetime'] = $condition_time;
		}
		if (!is_numeric($_GET['curpage'])){
		    $count = $model_order->getOrderCodeCount($condition);
    		$array = array();
    		if ($count > self::EXPORT_SIZE ){
    		    //显示下载链接
    		    $page = ceil($count/self::EXPORT_SIZE);
    		    for ($i=1;$i<=$page;$i++){
    		        $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
    		        $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
    		        $array[$i] = $limit1.' ~ '.$limit2 ;
    		    }
    		    Tpl::output('list',$array);
    		    Tpl::output('murl','index.php?act=store_vr_bill&op=show_bill&ob_no='.$_GET['ob_no']);
    		    Tpl::showpage('store_export.excel');
    		    exit();
    		}else{
    		    //如果数量小，直接下载
    		    $data = $model_order->getCodeList($condition,'*','','rec_id desc',self::EXPORT_SIZE);
    		}
		}else{
		    //下载
		    $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
		    $limit2 = self::EXPORT_SIZE;
		    $data = $model_order->getCodeList($condition,'*','','rec_id desc',"{$limit1},{$limit2}");
		}

		//然后取订单编号
		$order_id_array = array();
		if (is_array($data)) {
		    foreach ($data as $code_info) {
		        $order_id_array[] = $code_info['order_id'];
		    }
		}
		$condition = array();
		$condition['order_id'] = array('in',$order_id_array);
		$order_list = $model_order->getOrderList($condition);
		$order_new_list = array();
		if (!empty($order_list)) {
		    foreach ($order_list as $v) {
		        $order_new_list[$v['order_id']]['order_sn'] = $v['order_sn'];
		        $order_new_list[$v['order_id']]['buyer_name'] = $v['buyer_name'];
		        $order_new_list[$v['order_id']]['buyer_id'] = $v['buyer_id'];
		        $order_new_list[$v['order_id']]['store_name'] = $v['store_name'];
		        $order_new_list[$v['order_id']]['store_id'] = $v['store_id'];
		        $order_new_list[$v['order_id']]['goods_name'] = $v['goods_name'];
		    }
		}

		$export_data = array();
		$export_data[0] = array('兑换码','消费时间','订单号','消费金额','佣金金额','买家','买家编号','商品');
		if ($_GET['type'] == 'timeout') {
		    $export_data[0][1] = '过期时间';
		}
		$pay_totals = 0;
		$commis_totals = 0;
		$k = 0;
		foreach ($data as $v) {
		    //该订单算佣金
		    $export_data[$k+1][] = $v['vr_code'];
		    if ($_GET['type'] == 'timeout') {
		        $export_data[$k+1][] = date('Y-m-d H:i:s',$v['vr_indate']);
		    } else {
		        $export_data[$k+1][] = date('Y-m-d H:i:s',$v['vr_usetime']);
		    }
		    $export_data[$k+1][] = 'NC'.$order_new_list[$v['order_id']]['order_sn'];
		    $pay_totals += $export_data[$k+1][] = floatval($v['pay_price']);
		    $commis_totals += $export_data[$k+1][] = floatval($v['pay_price'] * $v['commis_rate']/100);
		    $export_data[$k+1][] = $order_new_list[$v['order_id']]['buyer_name'];
		    $export_data[$k+1][] = $order_new_list[$v['order_id']]['buyer_id'];
		    $export_data[$k+1][] = $order_new_list[$v['order_id']]['goods_name'];
		    $k++;
		}
		$count = count($export_data);
		$export_data[$count][] = '合计';
		$export_data[$count][] =  '';
		$export_data[$count][] = '';
		$export_data[$count][] = $pay_totals;
		$export_data[$count][] = $commis_totals;
		$csv = new Csv();
		$export_data = $csv->charset($export_data,CHARSET,'gbk');
		$file_name = $_GET['type'] == 'timeout' ? '过期兑换码列表' : '已消费兑换码列表';
		$csv->filename = $csv->charset($file_name.'-',CHARSET).$_GET['ob_no'];
		$csv->export($export_data);
	}

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array	= array();
		switch ($menu_type) {
			case 'list':
				$menu_array = array(
				1=>array('menu_key'=>'list','menu_name'=>'虚拟订单结算', 'menu_url'=>'index.php?act=bill&op=list'),
				);
				break;
			case 'show':
				$menu_array = array(
				array('menu_key'=>'','menu_name'=>'已使用', 'menu_url'=>'index.php?act=store_vr_bill&op=show_bill&ob_no='.$_GET['ob_no']),
				array('menu_key'=>'timeout','menu_name'=>'已过期',	'menu_url'=>'index.php?act=store_vr_bill&op=show_bill&type=timeout&ob_no='.$_GET['ob_no'])
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
