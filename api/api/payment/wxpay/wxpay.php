<?php
/**
 * 微信支付接口类
 *
 * 
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class wxpay{
    private $code = 'wxpay';
    private $snsapi_base_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?';
    private $appid = '';
    private $redirect_uri = '/mobile/api/payment/wxpay/redirect_uri.php';
    private $openid_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?';
    private $pay_url = "https://api.mch.weixin.qq.com/pay/unifiedorder?showwxpaytitle=1";
    private $curl_timeout = 30;
    private $notify_url = '';
    private $response = '';
    private $result ='';
    private $secret = '';
    private $key = '';
    private $mch_id ='';
    private $sslcert_path ='';
    private $sslkey_path = '';
    private $prepay_id ='';
    public  $data;//接收到的数据，类型为关联数组
    var $returnParameters;//返回参数，类型为关联数组


    var $parameters;//请求参数，类型为关联数组

    public function __construct() {

        $condition = array();
        $condition['payment_code'] = $this->code;
        $model_mb_payment = Model('mb_payment');
        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);
        if(!$mb_payment_info) {
            output_error('系统不支持选定的支付方式');
        }else{
            $this->payment = $mb_payment_info;
        }

        $this->appid = $this->payment['payment_config']['wxpay_appid'];
        $this->mch_id = $this->payment['payment_config']['wxpay_mch_id'];
        $this->secret = $this->payment['payment_config']['wxpay_appsecret'];
        $this->key = $this->payment['payment_config']['wxpay_key'];
        $this->redirect_uri = 'http://'.$_SERVER['SERVER_NAME'].$this->redirect_uri;
        $this->notify_url = 'http://'.$_SERVER['SERVER_NAME'].'/mobile/api/payment/wxpay/notify_url.php';
        $this->sslcert_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_cert.pem';
        $this->sslkey_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_key.pem';

    }

    public function submit($orderparam = ''){
        //print_r($orderparam);die;
        
        //       '&'.$this->redirect_uri.
        //       '&'.'response_type=code';
        if(isset($_GET['code'])&&$_GET['code']){
            $this->getopenid($orderparam);
        }

        $param = array(
                'appid' => $this->appid,
                'redirect_uri'  => $this->redirect_uri,
                'response_type'  => 'code',
                'scope'  => 'snsapi_base',
                'state'  => $orderparam['order_type'].$orderparam['order_sn']
            );
        $url = $this->snsapi_base_url.http_build_query($param).'#wechat_redirect';
        $html_form = $this->create_html ( $url);
        echo $html_form;die;
       
    }

    public function getopenid(){

        $code = isset($_GET['code']) ? $_GET['code'] : '';//获取code
        if(!$code){
            output_error('取支付授权1失败');die;
        }
        //var_dump($code);die;
        $param = array(
                'appid' => $this->appid,
                'secret'  => $this->secret,
                'code'  => $code,
                'grant_type'  => 'authorization_code'
            );

        $url = $this->openid_url.http_build_query($param);

        $weixin =  file_get_contents($url);//通过code换取网页授权access_token
    
        $array = json_decode($weixin, 1); //对JSON格式的字符串进行编码
        //$array = get_object_vars($jsondecode);//转换成数组
        
        $openid = isset($array['openid'])? $array['openid'] : 0;//输出openid
        $order_sn = isset($_GET['state'])? trim($_GET['state']) : '';
        if(!$openid || !$order_sn){
            output_error('取支付授权失败');
            die;
        }else{
            $this->dowxpay($openid, $order_sn);
        }
        
        
        
    }

    private function dowxpay($openid, $order_sn){
         
        $order_type = substr($order_sn,0, 1);
        $pay_sn = substr($order_sn, 1);

        $model_mb_payment = Model('mb_payment');
        $logic_payment = Logic('payment');
    
        $condition = array();
        $condition['payment_code'] = $this->payment_code;
        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);

        


        if($order_type == 'r'){
            $result = $logic_payment->getRealOrderInfo($pay_sn);
        }else{
            $result = $logic_payment->getVrOrderInfo($pay_sn);
        }
        $total_fee = $result['data']['api_pay_amount'];




        $this->parameters['appid']=$this->appid;
        $this->parameters['mch_id']=$this->mch_id;
        $this->parameters['nonce_str']=$this->createNoncestr(32);
        //$this->parameters['sign']='';
        $this->parameters['body']=$order_sn;
        $this->parameters['attach']=$order_type.'|'.$pay_sn;
        $this->parameters['out_trade_no']=$pay_sn;
        $this->parameters['fee_type']='CNY';
        $this->parameters['total_fee']=$total_fee*100;
        $this->parameters['spbill_create_ip']=$_SERVER["REMOTE_ADDR"]; 
        $this->parameters['notify_url']=$this->notify_url;
        $this->parameters['trade_type']='JSAPI';        
        $this->parameters['openid']=$openid;

        $prepay_id = $this->getPrepayId();

        $this->setPrepayId($prepay_id);
        $jsApiParameters = $this->getParameters();
        //return $jsApiParameters;

         $html = $this->showpay($jsApiParameters);
        //file_put_contents('html',$html);
        echo $html;
    }

    private function showpay($jsApiParameters)
    {

        $html = <<<eot
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>微信安全支付</title>

    <script type="text/javascript">

        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                {$jsApiParameters},
                function(res){
                    //WeixinJSBridge.log(res.err_msg);
                    //alert(res.err_code+res.err_desc+res.err_msg);
                    
                    window.location.href="/wap/tmpl/member/order_list.html"; 
                }
            );
        }

        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>
</head>
<body onload='javascript:callpay();'>
    </br></br></br></br>
    <div align="center">
        <button style="width:210px; height:30px; background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
    </div>
</body>
</html>
eot;


        return $html;
    }

    /**
     * 	作用：设置jsapi的参数
     */
    public function getParameters()
    {
        $jsApiObj["appId"] = $this->appid;
        $timeStamp = time();
        $jsApiObj["timeStamp"] = "$timeStamp";
        $jsApiObj["nonceStr"] = $this->createNoncestr();
        $jsApiObj["package"] = "prepay_id=$this->prepay_id";
        $jsApiObj["signType"] = "MD5";
        $jsApiObj["paySign"] = $this->getSign($jsApiObj);
        $this->parameters = json_encode($jsApiObj);

        return $this->parameters;
    }

    /**
     *  作用：设置prepay_id
     */
    function setPrepayId($prepayId)
    {
        $this->prepay_id = $prepayId;
    }

    /**
     *  作用：格式化参数，签名过程需要使用
     */
    function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v)
        {
            if($urlencode)
            {
               $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = '';
        if (strlen($buff) > 0) 
        {
            $reqPar = substr($buff, 0, strlen($buff)-1);
        }
        return $reqPar;
    }

    /**
     *  作用：生成签名
     */
    public function getSign($Obj)
    {
        foreach ($Obj as $k => $v)
        {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //echo '【string1】'.$String.'</br>';
        //签名步骤二：在string后加入KEY
        $String = $String."&key=".$this->key;
        //echo "【string2】".$String."</br>";
        //签名步骤三：MD5加密
        $String = md5($String);
        //echo "【string3】 ".$String."</br>";
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        //echo "【result】 ".$result_."</br>";
        return $result_;
    }

    /**
     * 获取prepay_id
     */
    function getPrepayId()
    {
        $this->postXml();
        $this->result = $this->xmlToArray($this->response);
        $prepay_id = $this->result["prepay_id"];
        return $prepay_id;
    }

    /**
     *  作用：将xml转为array
     */
    public function xmlToArray($xml)
    {       
        //将XML转为array        
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);      
        return $array_data;
    }


    /**
     *  作用：post请求xml
     */
    function postXml()
    {
        $xml = $this->createXml();
        $this->response = $this->postXmlCurl($xml,$this->pay_url,$this->curl_timeout);
        return $this->response;
    }

    /**
     *  作用：设置标配的请求参数，生成签名，生成接口参数xml
     */
    function createXml()
    {
        
        $this->parameters["sign"] = $this->getSign($this->parameters);//签名

        return  $this->arrayToXml($this->parameters);
    }

    /**
     * 	作用：array转xml
     */
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val))
            {
                $xml=$xml."<".$key.">".$val."</".$key.">";

            }
            else
                $xml=$xml."<".$key."><![CDATA[".$val."]]></".$key.">";
        }
        $xml=$xml."</xml>";
        return $xml;
    }



    /**
     *  作用：以post方式提交xml到对应的接口url
     */
    public function postXmlCurl($xml,$url,$second=30)
    {       //echo $xml,'-',$url,'-',$second;die;
        //初始化curl        

        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        curl_close($ch);
        //返回结果
        
        if($data)
        {   //var_dump($data);die('||');
            //curl_close($ch);
            return $data;
        }
        else 
        { 
            //$error = curl_errno($ch);
            //echo "curl出错，错误码:$error"."<br>"; 
            //echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            //curl_close($ch);
            //var_dump($error);die;
            return false;
        }
    }

    /**
     *  作用：使用证书，以post方式提交xml到对应的接口url
     */
    function postXmlSSLCurl($xml,$url,$second=30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch,CURLOPT_HEADER,FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT, WxPayConf_pub::SSLCERT_PATH);
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY, WxPayConf_pub::SSLKEY_PATH);
        //post提交方式
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        }
        else { 
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>"; 
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);
            return false;
        }
    }



  /**
     *  作用：产生随机字符串，不长于32位
     */
     function createNoncestr( $length = 32 ) 
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {  
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
        }  
        return $str;
    }



    /**
     * 构造自动提交表单
     *
     * @param unknown_type $params
     * @param unknown_type $action
     * @return string
     */
    function create_html($url) {//<body  > 
        $encodeType = isset ( $params ['encoding'] ) ? $params ['encoding'] : 'UTF-8';
        $html = <<<eot
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset={$encodeType}" />
</head>
<body onload="javascript:window.location.href='{$url}';" >

</body>
</html>
eot;
        return $html;
    }

    /**
     * 将xml数据返回微信
     */
    function returnXml()
    {
        //$returnXml = $this->createXml();
        //return $returnXml;

        $arr = $this->returnParameters;

        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val))
            {
                $xml.="<".$key.">".$val."</".$key.">";

            }
            else
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
        }
        $xml.="</xml>";
        return $xml;

    }

    /**
     * 获取notify信息
     */
    public function getNotifyInfo($payment_config) {
        $xml = file_get_contents("php://input");
        //$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        //var_dump($xml);
        //echo $xml;
        //die;
        $this->saveData($xml);
        $verify = false;
        //var_dump($this->data);
        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if($this->checkSign() == FALSE){
            $this->setReturnParameter("return_code","FAIL");//返回状态码
            $this->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $verify = true;
            $this->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $this->returnXml();
        //var_dump($returnXml);
        //print_r($this->returnParameters);

        if($verify) {
            return array(
                //商户订单号
                //'out_trade_no' => $_GET['out_trade_no'],
                'out_trade_no' => substr($this->data['attach'],2),
                //支付宝交易号
                'trade_no' => $this->data['transaction_id'],
                'returnXml'=>$returnXml
            );
        }

        return false;
    }

    /**
     * 设置返回微信的xml数据
     */
    function setReturnParameter($parameter, $parameterValue)
    {
        $this->returnParameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
    }

    function checkSign()
    {
        $tmpData = $this->data;
        unset($tmpData['sign']);
        $sign = $this->getSign($tmpData);//本地签名
        if ($this->data['sign'] == $sign) {
            return TRUE;
        }
        return FALSE;
    }





    /**
     * 将微信的请求xml转换成关联数组，以方便数据处理
     */
    function saveData($xml)
    {
        $this->data = $this->xmlToArray($xml);
    }



    /**
     * 验证返回信息
     */
    private function _verify($payment_config) {
        if(empty($payment_config)) {
            return false;
        }

        //将系统的控制参数置空，防止因为加密验证出错
        unset($_GET['act']);
        unset($_GET['op']);
        unset($_GET['payment_code']);   

        ksort($_GET);
        $hash_temp = '';
        foreach ($_GET as $key => $value) {
            if($key != 'sign') {
                $hash_temp .= $key . '=' . $value . '&';
            }
        }
        $s = '';
        $s .= 'key' . '=' . $payment_config['wxpay_key'];

        $hash = strtoupper(md5($s));

        return $hash == $_GET['sign'];
    }

    /**
     *  作用：设置请求参数
     */
    private function setParameter($parameter, $parameterValue)
    {
        $this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
    }

    private function trimString($value)
    {
        $ret = null;
        if (null != $value) 
        {
            $ret = $value;
            if (strlen($ret) == 0) 
            {
                $ret = null;
            }
        }
        return $ret;
    }


}