<?php
/**
 * SEO
 *
 *
 *
 *
 
 */


defined('InShopNC') or exit('Access Invalid!');
class seoModel extends Model{
	/**
	 * 存放SEO信息
	 *
	 * @var obj
	 */
	private $seo;

	public function __construct(){
		parent::__construct('seo');
	}

	/**
	 * 取得SEO信息
	 *
	 * @param array/string $type
	 * @return obj
	 */
	public function type($type){
		if (is_array($type)){	//商品分类
			$this->seo['title'] = $type[1];
			$this->seo['keywords'] = $type[2];
			$this->seo['description'] = $type[3];
		}else{
			$this->seo = $this->getSeo($type);
		}
		if (!is_array($this->seo)) return $this;
		foreach ($this->seo as $key=>$value) {
			$this->seo[$key] = str_replace(array('{sitename}'),array(C('site_name')),$value);
		}
		return $this;
	}

	/**
	 * 生成SEO缓存并返回
	 *
	 * @param string $type
	 * @return array
	 */
	private function getSeo($type){
		$list = rkcache('seo',true);
		return $list[$type];
	}

	/**
	 * 传入参数替换SEO中的标签
	 *
	 * @param array $array
	 * @return obj
	 */
	public function param($array = null){
		if (!is_array($this->seo)) return $this;
		if (is_array($array)){
			$array_key = array_keys($array);
			array_walk($array_key,array(self,'addTag'));
			foreach ($this->seo as $key=>$value) {
				$this->seo[$key] = str_replace($array_key,array_values($array),$value);
			}
		}
		return $this;
	}

	/**
	 * 抛出SEO信息到模板
	 *
	 */
	public function show(){
		$this->seo['title'] = preg_replace("/{.*}/siU",'',$this->seo['title']);
		$this->seo['keywords'] = preg_replace("/{.*}/siU",'',$this->seo['keywords']);
		$this->seo['description'] = preg_replace("/{.*}/siU",'',$this->seo['description']);

		Tpl::output('html_title',$this->seo['title'] ? $this->seo['title'] : C('site_name'));
		Tpl::output('seo_keywords',$this->seo['keywords'] ? $this->seo['keywords'] : C('site_name'));
		Tpl::output('seo_description',$this->seo['description'] ? $this->seo['description'] : C('site_name'));
	}

    private function addTag(&$key){
       $key ='{'.$key.'}';
    }
}
