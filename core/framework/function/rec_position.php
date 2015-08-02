<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 调用推荐位
 *
 * @param unknown_type $rec_id
 * @return string
 */
function rec_position($rec_id = null){
	if (!is_numeric($rec_id)) return null;
	$string = '';

    if (C('cache_open')) {
        $info = rkcache("rec_position/{$rec_id}", function($rec_id) {
            $rec_id = substr($rec_id, strlen('rec_position/'));
            return Model('rec_position')->find($rec_id);
        });
    } else {
        $file = BASE_DATA_PATH.'/cache/rec_position/'.$rec_id.'.php';
        if (file_exists($file)) {
            $info = require($file);
        } else {
            $info = Model('rec_position')->find($rec_id);
            write_file($file,$info);
        }
    }

	$info['content'] = unserialize($info['content']);
	if ($info['content']['target'] == 2) $target = 'target="_blank"';else $target = '';
	if ($info['pic_type'] == 0){//文字
		foreach ((array)$info['content']['body'] as $v) {
			$href = '';
			if ($v['url'] != '') $href = "href=\"{$v['url']}\"";
			$string .= "<li><a {$target} {$href}>{$v['title']}</a></li>";
		}
		$string = "<ul>{$string}</ul>";
	}else{//图片
		$width = $height = '';
		if (is_numeric($info['content']['width'])) $width = "width=\"{$info['content']['width']}\"";
		if (is_numeric($info['content']['height'])) $height = "height=\"{$info['content']['height']}\"";
		if (is_array($info['content']['body'])) {
		    if (count($info['content']['body']) > 1) {
		        foreach ($info['content']['body'] as $v) {
		            if ($info['pic_type'] == 1) $v['title'] = UPLOAD_SITE_URL.'/'.$v['title'];
		            $href = '';
		            if ($v['url'] != '') $href = "href=\"{$v['url']}\"";
		            $string .= "<li><a {$target} {$href}><img {$width} {$height} src=\"{$v['title']}\"></a></li>";
		        }
		        $string = "<ul>{$string}</ul>";
		    } else {
		        $v = $info['content']['body'][0];
	            if ($info['pic_type'] == 1) $v['title'] = UPLOAD_SITE_URL.'/'.$v['title'];
	            $href = '';
	            if ($v['url'] != '') $href = "href=\"{$v['url']}\"";
	            $string .= "<a {$target} {$href}><img {$width} {$height} src=\"{$v['title']}\"></a>";
		    }
		}
	}
	return $string;
}
