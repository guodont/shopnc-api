<?php
/**
 * 压缩框架
 
 */
defined('InShopNC') or exit('Access Invalid!');
/**
 * 压缩框架文件
 *
 */
function build(){
	$args = func_get_args();
	extract($args[0]);
	$compile = '';
	$list = array(
		BASE_PATH.'/framework/core/runtime.php',
		BASE_PATH.'/framework/core/base.php',
		BASE_PATH.'/framework/core/model.php',
		BASE_PATH.'/framework/cache/cache.php',
		BASE_PATH.'/framework/cache/cache.file.php',
		BASE_PATH.'/framework/db/'.strtolower($dbdriver).'.php',
		BASE_PATH.'/framework/function/goods.php',
		BASE_PATH.'/framework/libraries/email.php',
		BASE_PATH.'/framework/libraries/language.php',
		BASE_PATH.'/framework/libraries/log.php',
		BASE_PATH.'/framework/libraries/page.php',
		BASE_PATH.'/framework/libraries/security.php',
		BASE_PATH.'/framework/libraries/validate.php',
		BASE_PATH.'/framework/libraries/upload.php',
		BASE_PATH.'/framework/function/core.php',
		BASE_PATH.'/framework/tpl/nc.php',
		BASE_PATH.'/control/control.php',
		BASE_PATH.'/language/'.$lang_type.'/core_lang_index.php',
		BASE_PATH.'/classes/process.class.php'
	);

	if (!empty($cache_type) && strtolower($cache_type) != 'file'){
		$list[] = BASE_PATH.'/framework/cache/cache.'.strtolower($cache_type).'.php';
	}

	foreach ($list as $file) {
		if (file_exists($file))	{
			$compile .= compile($file);
		}else{
			exit(str_replace(BASE_PATH,'',$file)." isn't exists!");
		}
	}

	//加载核心语言包
//	$lang_file = BASE_PATH.'/language/'.$lang_type.'/core_lang_index.php';
//	if (!file_exists($lang_file)){
//		exit(str_replace(BASE_PATH,'',$lang_file)." isn't exists!");
//	}
	$compile .= compile($lang_file);
	$compile .= "\nLanguage::appendLanguage(\$lang);";

	$compile .= "\nBase::run();";
	file_put_contents(RUNCOREPATH,compress_code("<?php defined('InShopNC') or exit('Access Invalid!');".$compile));
}

/**
 * 过滤掉不需要压缩的内容
 *
 * @param string $filename 待压缩文件
 * @return string
 */
function compile($filename) {
    $content = file_get_contents($filename);
    //过滤不需要编译的内容
    $content = preg_replace('/\/\/\[NC_SKIPBUILD\](.*?)\/\/\[\/NC_SKIPBUILD\]/s', '', $content);
    $content = str_ireplace("defined('InShopNC') or exit('Access Invalid!')", '', $content);
    $content = substr(trim($content), 5);
    if ('?>' == substr($content, -2))
        $content = substr($content, 0, -2);
    return $content;
}

/**
 * 压缩PHP代码
 *
 * @param string $content 压缩内容
 * @return string
 */
function compress_code($content) {
    $strip_str = '';
    //分析php源码
    $tokens = token_get_all($content);
    $last_space = false;
    for ($i = 0, $j = count($tokens); $i < $j; $i++) {
        if (is_string($tokens[$i])) {
            $last_space = false;
            $strip_str .= $tokens[$i];
        } else {
            switch ($tokens[$i][0]) {
                //过滤各种PHP注释
                case T_COMMENT:
                case T_DOC_COMMENT:
                    break;
                //过滤空格
                case T_WHITESPACE:
                    if (!$last_space) {
                        $strip_str .= ' ';
                        $last_space = true;
                    }
                    break;
                default:
                    $last_space = false;
                    $strip_str .= $tokens[$i][1];
            }
        }
    }
    return $strip_str;
}
?>
