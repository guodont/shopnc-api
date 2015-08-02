<?php

class seccode {

	public $code;
	public $width 	= 150;
	public $height 	= 60;
	public $background	= 1;
	public $adulterate	= 1;
	public $scatter	= 0;
	public $color 	= 1;
	public $size 	= 0;
	public $shadow 	= 1;
	public $animator 	= 0;
	public $fontpath	= '';
	public $datapath	= '';
	public $includepath= '';

	public $fontcolor;
	public $im;

	public function display() {
		if(function_exists('imagecreate') && function_exists('imagecolorset') && function_exists('imagecopyresized') &&
			function_exists('imagecolorallocate') && function_exists('imagechar') && function_exists('imagecolorsforindex') &&
			function_exists('imageline') && function_exists('imagecreatefromstring') && (function_exists('imagegif') || function_exists('imagepng') || function_exists('imagejpeg'))) {
			$this->image();
		} else {
			exit('gd extension error');
		}
	}

	function image() {
		$bgcontent = $this->background();
		$this->im = imagecreatefromstring($bgcontent);
		$this->adulterate && $this->adulterate();
		$this->giffont();
		$this->scatter && $this->scatter($this->im);
		if(function_exists('imagepng')) {
			header('Content-type: image/png');
			imagepng($this->im);
		} else {
			header('Content-type: image/jpeg');
			imagejpeg($this->im, '', 100);
		}
		imagedestroy($this->im);
	}

	function background() {
		$this->im = imagecreatetruecolor($this->width, $this->height);
		$backgrounds = $c = array();
		if(!$this->background || !$backgrounds) {
			for($i = 0;$i < 3;$i++) {
				$start[$i] = mt_rand(200, 255);$end[$i] = mt_rand(100, 150);$step[$i] = ($end[$i] - $start[$i]) / $this->width;$c[$i] = $start[$i];
			}
			for($i = 0;$i < $this->width;$i++) {
				$color = imagecolorallocate($this->im, $c[0], $c[1], $c[2]);
				imageline($this->im, $i, 0, $i, $this->height, $color);
				$c[0] += $step[0];$c[1] += $step[1];$c[2] += $step[2];
			}
			$c[0] -= 20;$c[1] -= 20;$c[2] -= 20;
		}
		ob_start();
		if(function_exists('imagepng')) {
			imagepng($this->im);
		} else {
			imagejpeg($this->im, '', 100);
		}
		imagedestroy($this->im);
		$bgcontent = ob_get_contents();
		ob_end_clean();
		$this->fontcolor = $c;
		return $bgcontent;
	}

	/**
	 * 画干扰线
	 *
	 */
	function adulterate() {
		$linenums = $this->height / 20;
		for($i = 0; $i <= $linenums;$i++) {
			$color = $this->color ? imagecolorallocate($this->im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)) : imagecolorallocate($this->im, $this->fontcolor[0], $this->fontcolor[1], $this->fontcolor[2]);
			$x = mt_rand(0, $this->width);
			$y = mt_rand(0, $this->height);
			if(mt_rand(0, 0)) {
				$w = mt_rand(0, $this->width);
				$h = mt_rand(0, $this->height);
				$s = mt_rand(0, 360);
				$e = mt_rand(0, 360);
				for($j = 0;$j < 3;$j++) {
					imagearc($this->im, $x + $j, $y, $w, $h, $s, $e, $color);
				}
			} else {
				$xe = mt_rand(0, $this->width);
				$ye = mt_rand(0, $this->height);
				imageline($this->im, $x, $y, $xe, $ye, $color);
				for($j = 0;$j < 3;$j++) {
					imageline($this->im, $x + $j, $y, $xe, $ye, $color);
				}
			}
		}
	}

	function scatter(&$obj, $level = 0) {
		$rgb = array();
		$this->scatter = $level ? $level : $this->scatter;
		$width = imagesx($obj);
		$height = imagesy($obj);
		for($j = 0;$j < $height;$j++) {
			for($i = 0;$i < $width;$i++) {
				$rgb[$i] = imagecolorat($obj, $i , $j);
			}
			for($i = 0;$i < $width;$i++) {
				$r = rand(-$this->scatter, $this->scatter);
				imagesetpixel($obj, $i + $r , $j , $rgb[$i]);
			}
		}
	}

	function giffont() {
		$seccode = $this->code;
		$seccodedir = array();
		if(function_exists('imagecreatefromgif')) {
			$seccoderoot = $this->datapath.'gif/';
			$dirs = opendir($seccoderoot);
			while($dir = readdir($dirs)) {
				if($dir != '.' && $dir != '..' && file_exists($seccoderoot.$dir.'/9.gif')) {
					$seccodedir[] = $dir;
				}
			}
		}
		$widthtotal = 0;
		for($i = 0; $i <= 3; $i++) {
			$this->imcodefile = $seccodedir ? $seccoderoot.$seccodedir[array_rand($seccodedir)].'/'.strtolower($seccode[$i]).'.gif' : '';
			if(!empty($this->imcodefile) && file_exists($this->imcodefile)) {
				$font[$i]['file'] = $this->imcodefile;
				$font[$i]['data'] = getimagesize($this->imcodefile);
				$font[$i]['width'] = $font[$i]['data'][0] + mt_rand(0, 6) - 4;
				$font[$i]['height'] = $font[$i]['data'][1] + mt_rand(0, 6) - 4;
				if (($this->width / 5 - $font[$i]['width'])>0){
					$tt = mt_rand(0, $this->width / 5 - $font[$i]['width']);
				}else{
					$tt = mt_rand($this->width / 5 - $font[$i]['width'],0);
				}
				$font[$i]['width'] += $tt;
				$widthtotal += $font[$i]['width'];
			} else {
				$font[$i]['file'] = '';
				$font[$i]['width'] = 8 + mt_rand(0, $this->width / 5 - 5);
				$widthtotal += $font[$i]['width'];
			}
		}
		$x = mt_rand(1, $this->width - $widthtotal);
		for($i = 0; $i <= 3; $i++) {
			$this->color && $this->fontcolor = array(mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			if($font[$i]['file']) {
				$this->imcode = imagecreatefromgif($font[$i]['file']);
				if($this->size) {
					$font[$i]['width'] = mt_rand($font[$i]['width'] - $this->width / 20, $font[$i]['width'] + $this->width / 20);
					$font[$i]['height'] = mt_rand($font[$i]['height'] - $this->width / 20, $font[$i]['height'] + $this->width / 20);
				}
				if ($this->height - $font[$i]['height']>0){
					$y = mt_rand(0, $this->height - $font[$i]['height']);
				}else{
					$y = mt_rand($this->height - $font[$i]['height'],0);
				}

				if($this->shadow) {
					$this->imcodeshadow = $this->imcode;
					imagecolorset($this->imcodeshadow, 0, 0, 0, 0);
					imagecopyresized($this->im, $this->imcodeshadow, $x + 1, $y + 1, 0, 0, $font[$i]['width'], $font[$i]['height'], $font[$i]['data'][0], $font[$i]['data'][1]);
				}
				imagecolorset($this->imcode, 0 , $this->fontcolor[0], $this->fontcolor[1], $this->fontcolor[2]);
				imagecopyresized($this->im, $this->imcode, $x, $y, 0, 0, $font[$i]['width'], $font[$i]['height'], $font[$i]['data'][0], $font[$i]['data'][1]);
			} else {
				$y = mt_rand(0, $this->height - 20);
				if($this->shadow) {
					$text_shadowcolor = imagecolorallocate($this->im, 0, 0, 0);
					imagechar($this->im, 5, $x + 1, $y + 1, $seccode[$i], $text_shadowcolor);
				}
				$text_color = imagecolorallocate($this->im, $this->fontcolor[0], $this->fontcolor[1], $this->fontcolor[2]);
				imagechar($this->im, 5, $x, $y, $seccode[$i], $text_color);
			}
			$x += $font[$i]['width'];
		}
	}
}

?>