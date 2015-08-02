<?php
/**


^^^^^^^^^^^^^^^^^^^^^^^^^^^^

 */
defined('InShopNC') or exit('Access Invalid!');
final class flea_Cache {
	
    public static function getCache($type, $param = "") {
        Language::read("core_lang_index");
        $lang = Language::getlangcontent();
        $type = strtoupper($type[0]) . strtolower(substr($type, 1));
        $function = "get" . $type . "Cache";
        try {
            do {
                if (method_exists(flea_Cache, $function)) {
                    break;
                } else {
                    $error = $lang['please_check_your_cache_type'];
                    throw new Exception($error);
                }
            } while (0);
        }
        catch(Exception $e) {
            showmessage($e->getMessage() , "", "exception");
        }
        $result = self::$function($param);
        return $result;
    }
	
    private static function getFlea_areaCache($param) {
        Language::read("core_lang_index");
        $lang = Language::getlangcontent();
        $deep = $param['deep'];
        $cache_file = BASE_DATA_PATH . DS . "cache" . DS . "flea_area" . DS . "flea_area_" . $deep . ".php";
        if (file_exists($cache_file) && time() - SESSION_EXPIRE <= filemtime($cache_file) && empty($param['new'])) {
            require ($cache_file);
            return $data;
        }
        $param = array();
        $param['table'] = "flea_area";
        $param['where'] = "flea_area_deep = '" . $deep . "'";
        $param['order'] = "flea_area_sort asc";
        $result = Db::select($param);
        $tmp.= "<?php \r\n";
        $tmp.= "defined('InShopNC') or exit('Access Invalid!'); \r\n";
        $tmp.= "\$data = array(\r\n";
        if (is_array($result)) {
            foreach ($result as $k => $v) {
                $tmp.= "\tarray(\r\n";
                $tmp.= "\t\t'flea_area_id'=>'" . $v['flea_area_id'] . "',\r\n";
                $tmp.= "\t\t'flea_area_name'=>'" . htmlspecialchars($v['flea_area_name']) . "',\r\n";
                $tmp.= "\t\t'flea_area_parent_id'=>'" . $v['flea_area_parent_id'] . "',\r\n";
                $tmp.= "\t\t'flea_area_sort'=>'" . $v['flea_area_sort'] . "',\r\n";
                $tmp.= "\t\t'flea_area_deep'=>'" . $v['flea_area_deep'] . "',\r\n";
                $tmp.= "\t),\r\n";
            }
        }
        $tmp.= ");";
        try {
            $fp = @fopen($cache_file, "wb+");
            if (fwrite($fp, $tmp) === FALSE) {
                $error = $lang['please_check_your_system_chmod_area'];
                throw new Exception();
            }
            @fclose($fp);
            require ($cache_file);
            return $data;
        }
        catch(Exception $e) {
            showmessage($e->getMessage() , "", "exception");
        }
    }
	
    public static function makeallcache($type) {
        Language::read("core_lang_index");
        $lang = Language::getlangcontent();
        $time = time();
        switch ($type) {
            case "area":
                $file_list = readfilelist(BASE_DATA_PATH . DS . "cache" . DS . "flea_area");
                if (is_array($file_list)) {
                    foreach ($file_list as $v) {
                        @unlink(BASE_DATA_PATH . DS . "cache" . DS . "flea_area" . DS . $v);
                    }
                }
                $maxdeep = 1;
            default:
                $param = array();
                $param['table'] = "flea_area";
                $param['where'] = "flea_area_deep = '" . $maxdeep . "'";
                $param['order'] = "flea_area_sort asc";
                $result = Db::select($param);
                if (!empty($result)) {
                    $cache_file_area = BASE_DATA_PATH . DS . "cache" . DS . "area" . DS . "flea_area_" . $maxdeep . ".php";
                    $tmp.= "<?php \r\n";
                    $tmp.= "defined('InShopNC') or exit('Access Invalid!'); \r\n";
                    $tmp.= "\$data = array(\r\n";
                    if (is_array($result)) {
                        foreach ($result as $k => $v) {
                            $tmp.= "\tarray(\r\n";
                            $tmp.= "\t\t'flea_area_id'=>'" . $v['flea_area_id'] . "',\r\n";
                            $tmp.= "\t\t'flea_area_name'=>'" . htmlspecialchars($v['flea_area_name']) . "',\r\n";
                            $tmp.= "\t\t'flea_area_parent_id'=>'" . $v['flea_area_parent_id'] . "',\r\n";
                            $tmp.= "\t\t'flea_area_sort'=>'" . $v['flea_area_sort'] . "',\r\n";
                            $tmp.= "\t\t'flea_area_deep'=>'" . $v['flea_area_deep'] . "',\r\n";
                            $tmp.= "\t),\r\n";
                        }
                    }
                    $tmp.= ");";
                    try {
                        $fp = @fopen($cache_file_area, "wb+");
                        if (fwrite($fp, $tmp) === FALSE) {
                            $error = $lang['please_check_your_system_chmod_area'];
                            throw new Exception();
                        }
                        unset($tmp);
                        @fclose($fp);
                    }
                    catch(Exception $e) {
                        showmessage($e->getMessage() , "", "exception");
                    }
                }
                ++$maxdeep;
        }
    }
}
?>