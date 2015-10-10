<?php
/**
 * 网银在线接口类
 *
 * 
 
 */
defined('InShopNC') or exit('Access Invalid!');

class chinabank{
	/**
	 * 网银在线网关
	 *
	 * @var string
	 */
	private $gateway   = 'https://Pay3.chinabank.com.cn/PayGate';
	/**
	 * 支付接口标识
	 *
	 * @var string
	 */
    private $code      = 'chinabank';
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
	 * 发送至网银在线的参数
	 *
	 * @var array
	 */
    private $parameter;
    /**
     * 支付状态
     * @var unknown
     */
    private $pay_result;
    
    public function __construct($payment_info,$order_info){
    	$this->chinabank($payment_info,$order_info);
    }
    public function chinabank($payment_info = array(),$order_info = array()){
    	if(!empty($payment_info) and !empty($order_info)){
    		$this->payment	= $payment_info;
    		$this->order	= $order_info;
    	}
    }
	/**
	 * 支付表单
	 *
	 */
	public function submit(){
		
		$v_oid = $this->order['pay_sn'];															//订单号
		$v_amount = $this->order['api_pay_amount'];                  			//支付金额                 
        $v_moneytype = "CNY";                                           //币种
		$v_mid = $this->payment['payment_config']['chinabank_account'];	// 商户号，这里为测试商户号1001，替换为自己的商户号(老版商户号为4位或5位,新版为8位)即可
		$v_url = SHOP_SITE_URL."/api/payment/chinabank/return_url.php";	// 请填写返回url,地址应为绝对路径,带有http协议
		$key   = $this->payment['payment_config']['chinabank_key'];			// 如果您还没有设置MD5密钥请登陆我们为您提供商户后台，地址：https://merchant3.chinabank.com.cn/

		$text = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;       //md5加密拼凑串,注意顺序不能变
    $v_md5info = strtoupper(md5($text));                            //md5函数加密并转化成大写字母

		/* 交易参数 */
		$parameter = array(
		'v_oid'         => $v_oid,                    			     				// 订单号    
		'v_amount'      => $v_amount,                            				// 支付金额    
		'v_moneytype'   => $v_moneytype,                                // 币种
		'v_mid'         => $v_mid,                  										// 商户号
		'v_url'         => $v_url,                       		     				// 返回url
		'key'    				=> $key,        																// MD5密钥
		'v_md5info'     => $v_md5info,                 		       				// md5
		'remark1'    	  => $this->order['order_type'],                          								// 备注字段1
		'remark2'    	  => ''                          									// 备注字段2
		);

		$html = '<html><head></head><body>';
		$html .= '<form method="post" name="E_FORM" action="https://pay3.chinabank.com.cn/PayGate">';
		foreach ($parameter as $key => $val){
			$html .= "<input type='hidden' name='$key' value='$val' />";
		}
		$html .= '</form><script type="text/javascript">document.E_FORM.submit();</script>';
		$html .= '</body></html>';
		echo $html;
		exit;
	}

	/**
	 * 返回地址验证(同步)
	 *
	 * @param 
	 * @return boolean
	 */
	public function return_verify(){
		
		$key   = $this->payment['payment_config']['chinabank_key'];		
			
		$v_oid     =trim($_POST['v_oid']);       // 商户发送的v_oid定单编号   
		$v_pmode   =trim($_POST['v_pmode']);    // 支付方式（字符串）   
		$v_pstatus =trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）
		$v_pstring =trim($_POST['v_pstring']);   // 支付结果信息 ： 支付完成（当v_pstatus=20时）；失败原因（当v_pstatus=30时,字符串）； 
		$v_amount  =trim($_POST['v_amount']);     // 订单实际支付金额
		$v_moneytype  =trim($_POST['v_moneytype']); //订单实际支付币种    
		$remark1   =trim($_POST['remark1']);      //备注字段1
		$remark2   =trim($_POST['remark2']);     //备注字段2
		$v_md5str  =trim($_POST['v_md5str']);   //拼凑后的MD5校验值  

		/**
		 * 重新计算md5的值
		 */                   
		$md5string=strtoupper(md5($v_oid.$v_pstatus.$v_amount.$v_moneytype.$key));
		
		/**
		 * 判断返回信息，如果支付成功，并且支付结果可信，则做进一步的处理
		 */
		if ($v_md5str==$md5string){
		    
			if($v_pstatus=="20"){
			    $this->pay_result = true;
				//支付成功，可进行逻辑处理！
				return true;
			}else{
				return false;//echo "支付失败";
			}
		}else{
			return false;//echo "<br>校验失败,数据可疑";
		}
	}
	
	/**
	 * 返回地址验证(异步)
	 * @return boolean
	 */
	public function notify_verify() {
	   return $this->return_verify();    
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
