<?php
/**
 * 虚拟订单结算管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class vr_billControl extends SystemControl{
    /**
     * 每次导出订单数量
     * @var int
     */
    const EXPORT_SIZE = 1000;

    private $links = array(
    	array('url'=>'act=vr_bill&op=index','lang'=>'nc_manage'),
    );

    public function __construct(){
    	parent::__construct();
    }

    /**
     * 所有月份销量账单
     *
     */
    public function indexOp(){

        $condition = array();
    	if (preg_match('/^\d{4}$/',$_GET['query_year'],$match)) {
	        $condition['os_year'] = $_GET['query_year'];
	    }
        $model_bill = Model('vr_bill');
        $bill_list = $model_bill->getOrderStatisList($condition,'*',12,'os_month desc');
        Tpl::output('bill_list',$bill_list);
        Tpl::output('show_page',$model_bill->showpage());

        //输出子菜单
        Tpl::output('top_link',$this->sublink($this->links,'index'));

        Tpl::showpage('vr_bill_order_statis.index');
    }

	/**
	 * 某月所有店铺销量账单
	 *
	 */
	public function show_statisOp(){
	    if (!empty($_GET['os_month']) && !preg_match('/^20\d{4}$/',$_GET['os_month'],$match)) {
	        showMessage('参数错误','','html','error');
	    }
	    $model_bill = Model('vr_bill');
		$condtion = array();
		if (!empty($_GET['os_month'])) {
		    $condition['os_month'] = intval($_GET['os_month']);
		}
		if (is_numeric($_GET['bill_state'])) {
		    $condition['ob_state'] = intval($_GET['bill_state']);
		}
		if (preg_match('/^\d{1,8}$/',$_GET['query_store'])) {
			$condition['ob_store_id'] = $_GET['query_store'];
		}elseif ($_GET['query_store'] != ''){
			$condition['ob_store_name'] = $_GET['query_store'];
		}
		$bill_list = $model_bill->getOrderBillList($condition,'*',30,'ob_no desc');
		Tpl::output('bill_list',$bill_list);
		Tpl::output('show_page',$model_bill->showpage());

		//输出子菜单
		Tpl::output('top_link',$this->sublink($this->links,'index'));

		Tpl::showpage('vr_bill_order_statis.show');
	}

	/**
	 * 某店铺某月订单列表
	 *
	 */
	public function show_billOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'],$match)) {
			showMessage('参数错误','','html','error');
		}
		$model_bill = Model('vr_bill');
		$bill_info = $model_bill->getOrderBillInfo(array('ob_no'=>$_GET['ob_no']));
		if (!$bill_info){
			showMessage('参数错误','','html','error');
		}
		$model_order = Model('vr_order');
		$condition = array();
		$condition['store_id'] = $bill_info['ob_store_id'];
		if ($_GET['query_type'] == 'timeout') {
		    //计算未使用已过期不可退兑换码列表
		    $condition['vr_state'] = 0;
		    $condition['vr_invalid_refund'] = 0;
		    $condition['vr_indate'] = array('between',"{$bill_info['ob_start_date']},{$bill_info['ob_end_date']}");
		} else {
		    //计算已使用兑换码列表
		    $condition['vr_state'] = 1;
		    $condition['vr_usetime'] = array('between',"{$bill_info['ob_start_date']},{$bill_info['ob_end_date']}");
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
	            $order_new_list[$v['order_id']]['store_name'] = $v['store_name'];
	            $order_new_list[$v['order_id']]['store_id'] = $v['store_id'];
	        }
	    }
	    Tpl::output('order_list',$order_new_list);
	    Tpl::output('code_list',$code_list);
	    Tpl::output('show_page',$model_order->showpage());
	    $sub_tpl_name = 'vr_bill.show.code_list';

        Tpl::output('tpl_name',$sub_tpl_name);
		Tpl::output('bill_info',$bill_info);
		Tpl::showpage('vr_bill_order_bill.show');
	}

	public function bill_checkOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
			showMessage('参数错误','','html','error');
		}
		$model_bill = Model('vr_bill');
		$condition = array();
		$condition['ob_no'] = $_GET['ob_no'];
		$condition['ob_state'] = BILL_STATE_STORE_COFIRM;
		$update = $model_bill->editOrderBill(array('ob_state'=>BILL_STATE_SYSTEM_CHECK),$condition);
		if ($update){
		    $this->log('审核账单,账单号：'.$_GET['ob_no'],1);
			showMessage('审核成功，账单进入付款环节');
		}else{
		    $this->log('审核账单，账单号：'.$_GET['ob_no'],0);
			showMessage('审核失败','','html','error');
		}
	}

	/**
	 * 账单付款
	 *
	 */
	public function bill_payOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
			showMessage('参数错误','','html','error');
		}
		$model_bill = Model('vr_bill');
		$condition = array();
		$condition['ob_no'] = $_GET['ob_no'];
		$condition['ob_state'] = BILL_STATE_SYSTEM_CHECK;
		$bill_info = $model_bill->getOrderBillInfo($condition);
		if (!$bill_info){
			showMessage('参数错误','','html','error');
		}
		if (chksubmit()){
			if (!preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_POST['pay_date'])) {
				showMessage('参数错误','','html','error');
			}
			$input = array();
			$input['ob_pay_content'] = $_POST['pay_content'];
			$input['ob_pay_date'] = strtotime($_POST['pay_date']);
			$input['ob_state'] = BILL_STATE_SUCCESS;
			$update = $model_bill->editOrderBill($input,$condition);
			if ($update){
			    // 发送店铺消息
                $param = array();
                $param['code'] = 'store_bill_gathering';
                $param['store_id'] = $bill_info['ob_store_id'];
                $param['param'] = array(
                    'bill_no' => $bill_info['ob_no']
                );
			    QueueClient::push('sendStoreMsg', $param);

			    $this->log('账单付款,账单号：'.$_GET['ob_no'],1);
				showMessage('保存成功','index.php?act=vr_bill&op=show_statis&os_month='.$bill_info['os_month']);
			}else{
			    $this->log('账单付款,账单号：'.$_GET['ob_no'],1);
				showMessage('保存失败','','html','error');
			}
		}else{
			Tpl::showpage('vr_bill.pay');
		}
	}

	/**
	 * 打印结算单
	 *
	 */
	public function bill_printOp(){
		if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'])) {
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

		Tpl::showpage('vr_bill.print','null_layout');
	}


	/**
	 * 导出平台月出账单表
	 *
	 */
	public function export_billOp(){
	    if (!empty($_GET['os_month']) && !preg_match('/^20\d{4}$/',$_GET['os_month'],$match)) {
	        showMessage('参数错误','','html','error');
	    }
	    $model_bill = Model('vr_bill');
		$condition = array();
		if (!empty($_GET['os_month'])) {
		    $condition['os_month'] = intval($_GET['os_month']);
		}
		if (is_numeric($_GET['bill_state'])) {
		    $condition['ob_state'] = intval($_GET['bill_state']);
		}
		if (preg_match('/^\d{1,8}$/',$_GET['query_store'])) {
			$condition['ob_store_id'] = $_GET['query_store'];
		}elseif ($_GET['query_store'] != ''){
			$condition['ob_store_name'] = $_GET['query_store'];
		}
		if (!is_numeric($_GET['curpage'])){
		    $count = $model_bill->getOrderBillCount($condition);
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
    		    Tpl::output('murl','index.php?act=vr_bill&op=index');
    		    Tpl::showpage('export.excel');
    		    exit();
    		}else{
    		    //如果数量小，直接下载
    		    $data = $model_bill->getOrderBillList($condition,'*','','ob_no desc',self::EXPORT_SIZE);
    		}
		}else{
		    //下载
		    $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
		    $limit2 = self::EXPORT_SIZE;
		    $data = $model_bill->getOrderBillList($condition,'*','','ob_no desc',"{$limit1},{$limit2}");
		}

		$export_data = array();
		$export_data[0] = array('账单编号','开始日期','结束日期','消费金额','佣金金额','本期应结','出账日期','账单状态','店铺','店铺ID');
		$ob_order_totals = 0;
		$ob_commis_totals = 0;
		$ob_result_totals = 0;
		foreach ($data as $k => $v) {
		    $export_data[$k+1][] = $v['ob_no'];
		    $export_data[$k+1][] = date('Y-m-d',$v['ob_start_date']);
		    $export_data[$k+1][] = date('Y-m-d',$v['ob_end_date']);
		    $ob_order_totals += $export_data[$k+1][] = $v['ob_order_totals'];
		    $ob_commis_totals += $export_data[$k+1][] = $v['ob_commis_totals'];
		    $ob_result_totals += $export_data[$k+1][] = $v['ob_result_totals'];
		    $export_data[$k+1][] = date('Y-m-d',$v['ob_create_date']);
		    $export_data[$k+1][] = billState($v['ob_state']);
		    $export_data[$k+1][] = $v['ob_store_name'];
		    $export_data[$k+1][] = $v['ob_store_id'];
		}
		$count = count($export_data);
		$export_data[$count][] = '';
		$export_data[$count][] = '';
		$export_data[$count][] = '合计';
		$export_data[$count][] = $ob_order_totals;
		$export_data[$count][] = $ob_commis_totals;
		$export_data[$count][] = $ob_result_totals;
		$csv = new Csv();
		$export_data = $csv->charset($export_data,CHARSET,'gbk');
		$csv->filename = $csv->charset('账单-',CHARSET).$_GET['os_month'];
		$csv->export($export_data);
	}

	/**
	 * 导出兑换码明细CSV
	 *
	 */
	public function export_orderOp(){
	    if (!preg_match('/^20\d{5,12}$/',$_GET['ob_no'],$match)) {
	        showMessage('参数错误','','html','error');
	    }
	    $model_bill = Model('vr_bill');
	    $bill_info = $model_bill->getOrderBillInfo(array('ob_no'=>$_GET['ob_no']));
	    if (!$bill_info){
	        showMessage('参数错误','','html','error');
	    }
	    $model_order = Model('vr_order');
	    $condition = array();
	    $condition['store_id'] = $bill_info['ob_store_id'];
	    if ($_GET['query_type'] == 'timeout') {
	        //计算未使用已过期不可退兑换码列表
	        $condition['vr_state'] = 0;
	        $condition['vr_invalid_refund'] = 0;
	        $condition['vr_indate'] = array('between',"{$bill_info['ob_start_date']},{$bill_info['ob_end_date']}");
	    } else {
	        //计算已使用兑换码列表
	        $condition['vr_state'] = 1;
	        $condition['vr_usetime'] = array('between',"{$bill_info['ob_start_date']},{$bill_info['ob_end_date']}");
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
    		    Tpl::output('murl','index.php?act=vr_bill&op=show_bill&ob_no='.$_GET['ob_no']);
    		    Tpl::showpage('export.excel');
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
		$export_data[0] = array('兑换码','消费时间','订单号','消费金额','佣金金额','商家','商家编号','买家','买家编号','商品');
		if ($_GET['query_type'] == 'timeout') {
		    $export_data[0][1] = '过期时间';
		}
		
		$pay_totals = 0;
		$commis_totals = 0;
		$k = 0;
		foreach ($data as $v) {
		    //该订单算佣金
		    $export_data[$k+1][] = $v['vr_code'];
		    if ($_GET['query_type'] == 'timeout') {
		        $export_data[$k+1][] = date('Y-m-d H:i:s',$v['vr_indate']);
		    } else {
		        $export_data[$k+1][] = date('Y-m-d H:i:s',$v['vr_usetime']);
		    }
		    $export_data[$k+1][] = 'NC'.$order_new_list[$v['order_id']]['order_sn'];
		    $pay_totals += $export_data[$k+1][] = floatval($v['pay_price']);
		    $commis_totals += $export_data[$k+1][] = floatval($v['pay_price'] * $v['commis_rate']/100);
		    $export_data[$k+1][] = $order_new_list[$v['order_id']]['store_name'];
		    $export_data[$k+1][] = $order_new_list[$v['order_id']]['store_id'];
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
		$file_name = $_GET['query_type'] == 'timeout' ? '过期兑换码列表' : '已消费兑换码列表';
		$csv->filename = $csv->charset($file_name.'-',CHARSET).$_GET['ob_no'];
		$csv->export($export_data);
	}

}
