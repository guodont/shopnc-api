<?php
/**
 * 安全防范
 * 进行sql注入过滤，xss过滤和csrf过滤
 * 
 * 令牌调用方式
 * 输出：直接在模板上调用getToken
 * 验证：在验证位置调用checkToken
 *
 * @package    
 */
defined('InShopNC') or exit('Access Invalid!');

class Security{
	/**
	 * 取得令牌内容
	 * 自动输出html 隐藏域
	 *
	 * @param 
	 * @return void 字符串形式的返回结果
	 */
	public static function getToken(){
		$token = encrypt(TIMESTAMP,md5(MD5_KEY));
		echo "<input type='hidden' name='formhash' value='". $token ."' />";
	}
	public static function getTokenValue(){
        return encrypt(TIMESTAMP,md5(MD5_KEY));
	}

	/**
	 * 判断令牌是否正确
	 * 
	 * @param 
	 * @return bool 布尔类型的返回结果
	 */
	public static function checkToken(){
		$data = decrypt($_POST['formhash'],md5(MD5_KEY));
		return $data && (TIMESTAMP - $data < 5400);
	}

	/**
	 * 将字符 & " < > 替换
	 *
	 * @param unknown_type $string
	 * @return unknown
	 */
	public static function fliterHtmlSpecialChars($string) {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
				str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
		return $string;
	}

	/**
	 * 参数过滤
	 *
	 * @param array 参数内容
	 * @param array $ignore 被忽略过滤的元素
	 * @return array 数组形式的返回结果
	 * 
	 */
	public static function getAddslashesForInput($array,$ignore=array()){
        if (!function_exists('htmlawed')) require(BASE_CORE_PATH.'/framework/function/htmlawed.php');
		if (!empty($array)){
			while (list($k,$v) = each($array)) {
				if (is_string($v)) {
                    if (get_magic_quotes_gpc()) {
                        $v = stripslashes($v);
                    }		
					if($k != 'statistics_code') {
						if (!in_array($k,$ignore)){
							//如果不是编辑器，则转义< > & "
                            $v = self::fliterHtmlSpecialChars($v);
                        } else {
                            $v = htmlawed($v,array('safe'=>1));
                        }
                        if($k == 'ref_url') {
                            $v = str_replace('&amp;','&',$v);
                        }
					}
					$array[$k] = addslashes(trim($v));
				} else if (is_array($v))  {
					if($k == 'statistics_code') {
						$array[$k] = $v;
					} else {
						$array[$k] = self::getAddslashesForInput($v);
					}
				}
			}
			return $array;
		}else {
			return false;
		}
	}
	public static function getAddSlashes($array){
		if (!empty($array)){
			while (list($k,$v) = each($array)) {
				if (is_string($v)) {
					if (!get_magic_quotes_gpc()) {
						$v = addslashes($v);
					}
				} else if (is_array($v))  {
					$array[$k] = self::getAddSlashes($v);
				}
			}
			return $array;
		}else {
			return false;
		}
	}
}
