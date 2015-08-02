<?php
/**
 * 水印类
 *
 * 可以生成文字水印和图片水印(图片文件类型:gif,jpg,png)
 *
 *
 *
 * @package    
 */
defined('InShopNC') or exit('Access Invalid!');
class GdImage{
	/**
	 * 输入图片的文件名(必须包含路径名)
	 */
	private $src_image_name = "";
	/**
	 * jpeg图片质量
	 */
	private $jpeg_quality = 90;
	/**
	 * 输出文件名
	 */
	private $save_file = '';
	/**
	 * 水印图片的文件名(必须包含路径名)
	 */
	private $wm_image_name = "";
	/**
	 * 水印图片放置的位置
	 * 0 = middle
	 * 1 = top left
	 * 2 = top right
	 * 3 = bottom right
	 * 4 = bottom left
	 * 5 = top middle
	 * 6 = middle right
	 * 7 = bottom middle
	 * 8 = middle left
	 */
	private $wm_image_pos = 1;
	/**
	 * 水印图片与原图片的融合度 (1=100)
	 */
	private $wm_image_transition = 20;
	/**
	 * 水印文字(支持中英文以及带有\r\n的跨行文字)
	 */
	private $wm_text = "";
	/**
	 * 水印文字大小(单位:像素px)
	 */
	private $wm_text_size = 20;
	/**
	 * 水印文字角度,这个值尽量不要更改
	 */
	private $wm_text_angle = 4;
	/**
	 * 水印文字放置位置
	 */
	private $wm_text_pos = 3;
	/**
	 * 水印文字的字体
	 */
	private $wm_text_font = "";
	/**
	 * 水印字体的颜色值
	 */
	private $wm_text_color = "#cccccc";
	/**
	 * 取指定下标的数组内容
	 *
	 * @param string $key 数组下标
	 * @return string 字符串形式的返回结果
	 */
	public function get($key){
		$result = $this->$key ? $this->$key : '';
		return $result;
	}
	/**
	 * 设置指定下标的数组内容
	 *
	 * @param string $key 数组下标
	 * @param string $value 值
	 * @return bool 字符串形式的返回结果
	 */
	public function set($key,$value){
		$this->$key = $value;
		return true;
	}
	/**
	 * 设置水印内容
	 *
	 */
	public function setWatermark($watermark){
		$this->set('jpeg_quality',$watermark['jpeg_quality']);
		if($watermark['wm_image_name'] != ''){
			$this->set('wm_image_name',BASE_UPLOAD_PATH.DS.ATTACH_WATERMARK.DS.$watermark['wm_image_name']);
		}
		$this->set('wm_image_pos',$watermark['wm_image_pos']);
		$this->set('wm_image_transition',$watermark['wm_image_transition']);
		$this->set('wm_text',$watermark['wm_text']);
		$this->set('wm_text_size',$watermark['wm_text_size']);
		$this->set('wm_text_angle',$watermark['wm_text_angle']);
		$this->set('wm_text_pos',$watermark['wm_text_pos']);
		$this->set('wm_text_font',BASE_DATA_PATH.DS.'resource'.DS.'font'.DS.$watermark['wm_text_font'].'.ttf');
		$this->set('jpeg_quality',$watermark['jpeg_quality']);
		$this->set('wm_text_color', $watermark['wm_text_color']);
		return true;
	}

	/**
	 * 生成增加水印的图片
	 *
	 * <code>
	 * //使用示例
	 * <?php
	 * 		$img = new GDImage();
	 * 		//文字水印
	 * 		$img->wm_text = "www.abc.com";
	 * 		$img->wm_text_font = "./STXINWEI.TTF";
	 * 		//图片水印
	 * 		$img->wm_image_name="水印图片名";
	 * 		$img->create("生成图片文件名(包括路径)");
	 * ?>
	 * </code>
	 *
	 * @param string $filename 需要增加水印的图片文件名
	 * @return bool 布尔类型的返回结果
	 */
	public function create($filename="")
	{
		@ini_set('memory_limit', '-1');
		if ($filename){
			$this->src_image_name = strtolower(trim($filename));
			$this->save_file = $this->src_image_name;
		}

		$src_image_type = $this->get_type($this->src_image_name);
		$src_image = $this->createImage($src_image_type,$this->src_image_name);
		if (!$src_image) {
			return false;
		}
		$src_image_w=ImageSX($src_image);
		$src_image_h=ImageSY($src_image);

		if ($this->wm_image_name){
			$this->wm_image_name = strtolower(trim($this->wm_image_name));
			$wm_image_type = $this->get_type($this->wm_image_name);
			$wm_image = $this->createImage($wm_image_type,$this->wm_image_name);
			$wm_image_w=ImageSX($wm_image);
			$wm_image_h=ImageSY($wm_image);
			$temp_wm_image = $this->getPos($src_image_w,$src_image_h,$this->wm_image_pos,$wm_image);
			$wm_image_x = $temp_wm_image["dest_x"];
			$wm_image_y = $temp_wm_image["dest_y"];
			imageCopyMerge($src_image, $wm_image,$wm_image_x,$wm_image_y,0,0,$wm_image_w,$wm_image_h,$this->wm_image_transition);
		}

		if ($this->wm_text){
			$temp_wm_text = $this->getPos($src_image_w,$src_image_h,$this->wm_text_pos);
			$wm_text_x = $temp_wm_text["dest_x"];
			$wm_text_y = $temp_wm_text["dest_y"];
			if(preg_match("/([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i", $this->wm_text_color, $color))			{
				$red = hexdec($color[1]);
				$green = hexdec($color[2]);
				$blue = hexdec($color[3]);
				$wm_text_color = imagecolorallocate($src_image, $red,$green,$blue);
			}else{
				$wm_text_color = imagecolorallocate($src_image, 255,255,255);
			}
			imagettftext($src_image, $this->wm_text_size, $this->wm_angle, $wm_text_x, $wm_text_y, $wm_text_color,$this->wm_text_font,  $this->wm_text);
		}

		if ($this->save_file)
		{
			switch ($this->get_type($this->save_file)){
				case 'gif':$src_img=imagegif($src_image, $this->save_file); break;
				case 'jpeg':$src_img=ImageJPEG($src_image, $this->save_file, $this->jpeg_quality); break;
				case 'jpg':$src_img=ImageJPEG($src_image, $this->save_file, $this->jpeg_quality); break;
				case 'png':$src_img=ImagePNG($src_image, $this->save_file); break;
				default:$src_img=ImageJPEG($src_image, $this->save_file, $this->jpeg_quality); break;
			}
		}
		else
		{
			if ($src_image_type == "jpg") $src_image_type="jpeg";
			@header("Content-type: image/{$src_image_type}");
			switch ($src_image_type){
				case 'gif':$src_img=imagegif($src_image); break;
				case 'jpg':$src_img=ImageJPEG($src_image, "", $this->jpeg_quality);break;
				case 'jpeg':$src_img=ImageJPEG($src_image, "", $this->jpeg_quality);break;
				case 'png':$src_img=ImagePNG($src_image);break;
				default:$src_img=ImageJPEG($src_image, "", $this->jpeg_quality);break;
			}
		}
		imagedestroy($src_image);
		return true;
	}
	/**
	 *  根据文件名和类型创建图片
	 *
	 * @param string $type 图片的类型，包括gif,jpg,png
	 * @param string $img_name 图片文件名，包括路径名，例如 " ./mouse.jpg"
	 * @return string 字符串类型的返回结果
	 */
	private function createImage($type, $img_name){
		if (!$type){
			$type = $this->get_type($img_name);
		}

		switch ($type){
			case 'gif':
				if (function_exists('imagecreatefromgif'))
				$tmp_img=@ImageCreateFromGIF($img_name);
				break;
			case 'jpg':
				$tmp_img=ImageCreateFromJPEG($img_name);
				break;
			case 'jpeg':
				$tmp_img=ImageCreateFromJPEG($img_name);
				break;
			case 'png':
				$tmp_img=ImageCreateFromPNG($img_name);
				break;
			default:
				$tmp_img=ImageCreateFromString($img_name);
				break;
		}
		return $tmp_img;
	}
	/**
	 * 根据源图像的长、宽，位置代码，水印图片id来生成把水印放置到源图像中的位置
	 *
	 * @param int $sourcefile_width 源图像的宽
	 * @param int $sourcefile_height 源图像的高
	 * @param  int $pos 位置代码
	 * @param string $wm_image 水印图片 如果为空 则默认为文字水印
	 * @return array 数组形式的返回结果
	 */
	private function getPos($sourcefile_width, $sourcefile_height, $pos, $wm_image=''){
		if  ($wm_image){
			$insertfile_width = ImageSx($wm_image);
			$insertfile_height = ImageSy($wm_image);
		}else {
			$lineCount = explode("\r\n",$this->wm_text);
			$fontSize = imagettfbbox($this->wm_text_size,$this->wm_text_angle,$this->wm_text_font,$this->wm_text);
			$insertfile_width = $fontSize[2] - $fontSize[0];
			$insertfile_height = count($lineCount)*($fontSize[1] - $fontSize[3]);
		}

		switch ($pos){
			case 0:
				$dest_x = ( $sourcefile_width / 2 ) - ( $insertfile_width / 2 );
				$dest_y = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
				break;

			case 1:
				$dest_x = 0;
				if ($this->wm_text){
					$dest_y = $insertfile_height;
				}else{
					$dest_y = 0;
				}
				break;

			case 2:
				$dest_x = $sourcefile_width - $insertfile_width;
				if ($this->wm_text){
					$dest_y = $insertfile_height;
				}else{
					$dest_y = 0;
				}
				break;

			case 3:
				$dest_x = $sourcefile_width - $insertfile_width;
		        if ($this->wm_text){
					$dest_y = $insertfile_height;
				}else{
					$dest_y = 0;
				}
				break;

			case 4:
				$dest_x = 0;
				$dest_y = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
				break;

			case 5:
				$dest_x = ( ( $sourcefile_width - $insertfile_width ) / 2 );
				$dest_y = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
				break;

			case 6:
				$dest_x = $sourcefile_width - $insertfile_width;
				$dest_y = ( $sourcefile_height / 2 ) - ( $insertfile_height / 2 );
				break;

			case 7:
				$dest_x = 0;
				$dest_y = $sourcefile_height - $insertfile_height;
				break;

			case 8:
				$dest_x = ( ( $sourcefile_width - $insertfile_width ) / 2 );
				$dest_y = $sourcefile_height - $insertfile_height;
				break;

			default:
				$dest_x = $sourcefile_width - $insertfile_width;
				$dest_y = $sourcefile_height - $insertfile_height;
				break;
		}
		return array("dest_x"=>$dest_x,"dest_y"=>$dest_y);
	}
	/**
	 * 指定的文字转换为UTF-8格式，包括中英文混合
	 *
	 * @param string $gb gbk字符串
	 * @return string 字符串形式的返回结果
	 */
	private function gb2utf8($gb)
	{
		if(!trim($gb))
		return $gb;
		$filename="./gb2312.txt";
		$tmp=file($filename);
		$codetable=array();
		while(list($key,$value)=each($tmp))
		$codetable[hexdec(substr($value,0,6))]=substr($value,7,6);

		$utf8="";
		while($gb)
		{
			if (ord(substr($gb,0,1))>127)
			{
				$tthis=substr($gb,0,2);
				$gb=substr($gb,2,strlen($gb)-2);
				$utf8.=$this->u2utf8(hexdec($codetable[hexdec(bin2hex($tthis))-0x8080]));
			}
			else
			{
				$tthis=substr($gb,0,1);
				$gb=substr($gb,1,strlen($gb)-1);
				$utf8.=$this->u2utf8($tthis);
			}
		}

		return $utf8;
	}

	function u2utf8($c)
	{
		$str="";
		if ($c < 0x80)
		{
			$str.=$c;
		}
		else if ($c < 0x800)
		{
			$str.=chr(0xC0 | $c>>6);
			$str.=chr(0x80 | $c & 0x3F);
		}
		else if ($c < 0x10000)
		{
			$str.=chr(0xE0 | $c>>12);
			$str.=chr(0x80 | $c>>6 & 0x3F);
			$str.=chr(0x80 | $c & 0x3F);
		}
		else if ($c < 0x200000)
		{
			$str.=chr(0xF0 | $c>>18);
			$str.=chr(0x80 | $c>>12 & 0x3F);
			$str.=chr(0x80 | $c>>6 & 0x3F);
			$str.=chr(0x80 | $c & 0x3F);
		}
		return $str;
	}
	/**
	 * 获得图片的格式，包括jpg,png,gif
	 *
	 * @param string $img_name 图片文件名，包括路径名
	 * @return string 字符串形式的返回结果
	 */
	private function get_type($img_name)
	{
		$name_array = explode(".",$img_name);
		if (preg_match("/\.(jpg|jpeg|gif|png)$/", $img_name, $matches))
		{
			$type = strtolower($matches[1]);
		}
		else
		{
			$type = "string";
		}
		return $type;
	}
}