<?php
/**
 * 财付通接口类
 *
 * 
 
 */
defined('InShopNC') or exit('Access Invalid!');

class tenpay{
	/**
	 * 支付接口网关
	 *
	 * @var string
	 */
	private $gateway   = 'https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi';
	/**
	 * 支付接口标识
	 *
	 * @var string
	 */
    private $code      = 'tenpay';
    /**
	 * 支付接口配置信息
	 *
	 * @var array
	 */
    private $payment;
     /**
	 * 订单信息
	 *
	 * @var array
	 */
    private $order;
    /**
	 * 发送至财付通的参数
	 *
	 * @var array
	 */
    private $parameter;
    /**
     * 支付结果
     * @var unknown
     */
    private $pay_result;

    public function __construct($payment_info,$order_info){
    	$this->tenpay($payment_info,$order_info);
    }
    public function tenpay($payment_info = array(),$order_info = array()){
    	if(!empty($payment_info) and !empty($order_info)){
    		$this->payment	= $payment_info;
    		$this->order	= $order_info;
    	}
    }
	/**
	 * 获取支付表单
	 *
	 * @param 
	 * @return array
	 */
	public function get_payurl(){
		
		require_once ("classes/PayRequestHandler.class.php");
		
		/* 商户号 */
		$bargainor_id = $this->payment['payment_config']['tenpay_account'];//"1900000109";
		
		/* 密钥 */
		$key = $this->payment['payment_config']['tenpay_key'];//"8934e7d15453e97507ef794cf7b0519d";
		
		/* 返回处理地址 */
		$return_url = SHOP_SITE_URL."/api/payment/tenpay/return_url.php";
		//date_default_timezone_set(PRC);
		$strDate = date("Ymd");
		$strTime = date("His");
		
		//4位随机数
		$randNum = rand(1000, 9999);
		
		//10位序列号,可以自行调整。
		$strReq = $strTime . $randNum;
		
		/* 商家订单号,长度若超过32位，取前32位。财付通只记录商家订单号，不保证唯一。 */
		$sp_billno = $this->order['pay_sn'];
		
		/* 财付通交易单号，规则为：10位商户号+8位时间（YYYYmmdd)+10位流水号 */
		$transaction_id = $bargainor_id . $strDate . $strReq;
		
		/* 商品价格（包含运费），以分为单位 */
		$total_fee = floatval($this->order['api_pay_amount'])*100;
		
		/* 创建支付请求对象 */
		$reqHandler = new PayRequestHandler();
		$reqHandler->init();
		$reqHandler->setKey($key);
		
		//----------------------------------------
		//设置支付参数
		//----------------------------------------
		$reqHandler->setParameter("bargainor_id", $bargainor_id);			//商户号
		$reqHandler->setParameter("sp_billno", $sp_billno);					//商户订单号
		$reqHandler->setParameter("transaction_id", $transaction_id);		//财付通交易单号
		$reqHandler->setParameter("total_fee", $total_fee);					//商品总金额,以分为单位
		$reqHandler->setParameter("return_url", $return_url);				//返回处理地址
		$reqHandler->setParameter("desc", $this->order['subject']);	        //商品名称
        $reqHandler->setParameter("attach", $this->order['order_type']);	//自定义参数
        $reqHandler->setParameter("cs", CHARSET);
		//用户ip,测试环境时不要加这个ip参数，正式环境再加此参数
		$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);

		//请求的URL
		$reqUrl = $reqHandler->getRequestURL();

		return $reqUrl;
		
		//debug信息
		//$debugInfo = $reqHandler->getDebugInfo();
		
		//echo "<br/>" . $reqUrl . "<br/>";
		//echo "<br/>" . $debugInfo . "<br/>";
		
		//重定向到财付通支付
		//$reqHandler->doSend();
				
	}
	/**
	 * 返回地址验证
	 *
	 * @param 
	 * @return array
	 */
	public function return_verify(){
		
		require_once ("./classes/PayResponseHandler.class.php");
		
		/* 密钥 */
		$key = $this->payment['payment_config']['tenpay_key'];
		
		/* 创建支付应答对象 */
		$resHandler = new PayResponseHandler();
		$resHandler->setKey($key);
		
		//判断签名
		if($resHandler->isTenpaySign()) {
			
			//交易单号
			$transaction_id = $resHandler->getParameter("transaction_id");
			
			//金额,以分为单位
			$total_fee = $resHandler->getParameter("total_fee");
			
			//支付结果
			$pay_result = $resHandler->getParameter("pay_result");
			
			$attach = $resHandler->getParameter('attach');
			$sp_billno = $resHandler->getParameter('sp_billno');
			if( "0" == $pay_result ) {
				//判断返回金额
				$order_amount = $total_fee / 100;
				if (!empty($this->order['pdr_amount'])){
				    $this->order['api_pay_amount'] = $this->order['pdr_amount'];
				}
				if ($this->order['api_pay_amount'] != $order_amount){
					return false;
				}
				$this->pay_result = true;
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
	
	/**
	 * 取得订单支付状态，成功或失败
	 *
	 * @param array $param
	 * @return array
	 */
	public function getPayResult($param){
	   return $this->pay_result;
	}

	public function __get($name){
	    return $this->$name;
	}
}
