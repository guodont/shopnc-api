<?php
/**
 * 即时到帐请求类
 * ============================================================================
 * api说明：
 * init(),初始化函数，默认给一些参数赋值，如cmdno,date等。
 * getGateURL()/setGateURL(),获取/设置入口地址,不包含参数值
 * getKey()/setKey(),获取/设置密钥
 * getParameter()/setParameter(),获取/设置参数值
 * getAllParameters(),获取所有参数
 * getRequestURL(),获取带参数的请求URL
 * doSend(),重定向到财付通支付
 * getDebugInfo(),获取debug信息
 * 
 * ============================================================================
 *
 */

require ("RequestHandler.class.php");
class PayRequestHandler extends RequestHandler {
	
	function __construct() {
		$this->PayRequestHandler();
	}
	
	function PayRequestHandler() {
		//默认支付网关地址
		$this->setGateURL("https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi");	
	}
	
	/**
	*@Override
	*初始化函数，默认给一些参数赋值，如cmdno,date等。
	*/
	function init() {
		//任务代码
		$this->setParameter("cmdno", "1");
		
		//日期
		$this->setParameter("date",  date("Ymd"));
		
		//商户号
		$this->setParameter("bargainor_id", "");
		
		//财付通交易单号
		$this->setParameter("transaction_id", "");
		
		//商家订单号
		$this->setParameter("sp_billno", "");
		
		//商品价格，以分为单位
		$this->setParameter("total_fee", "");
		
		//货币类型
		$this->setParameter("fee_type",  "1");
		
		//返回url
		$this->setParameter("return_url",  "");
		
		//自定义参数
		$this->setParameter("attach",  "");
		
		//用户ip
		$this->setParameter("spbill_create_ip",  "");
		
		//商品名称
		$this->setParameter("desc",  "");
		
		//银行编码
		$this->setParameter("bank_type",  "0");
		
		//字符集编码
		$this->setParameter("cs",  "gbk");
		
		//摘要
		$this->setParameter("sign",  "");
		
	}
	
	/**
	*@Override
	*创建签名
	*/
	function createSign() {
		$cmdno = $this->getParameter("cmdno");
		$date = $this->getParameter("date");
		$bargainor_id = $this->getParameter("bargainor_id");
		$transaction_id = $this->getParameter("transaction_id");
		$sp_billno = $this->getParameter("sp_billno");
		$total_fee = $this->getParameter("total_fee");
		$fee_type = $this->getParameter("fee_type");
		$return_url = $this->getParameter("return_url");
		$attach = $this->getParameter("attach");
		$spbill_create_ip = $this->getParameter("spbill_create_ip");
		$key = $this->getKey();
		
		$signPars = "cmdno=" . $cmdno . "&" .
				"date=" . $date . "&" .
				"bargainor_id=" . $bargainor_id . "&" .
				"transaction_id=" . $transaction_id . "&" .
				"sp_billno=" . $sp_billno . "&" .
				"total_fee=" . $total_fee . "&" .
				"fee_type=" . $fee_type . "&" .
				"return_url=" . $return_url . "&" .
				"attach=" . $attach . "&";
		
		if($spbill_create_ip != "") {
			$signPars .= "spbill_create_ip=" . $spbill_create_ip . "&";
		}
		
		$signPars .= "key=" . $key;
		
		$sign = strtolower(md5($signPars));
		
		$this->setParameter("sign", $sign);
		
		//debug信息
		$this->_setDebugInfo($signPars . " => sign:" . $sign);
		
	}

}

?>