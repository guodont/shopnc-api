<?php
/**
 * 文章 
 * 好商城V3 - 33HAO.COM
 * 
 **/

defined('InShopNC') or exit('Access Invalid!');
class article_classControl extends apiHomeControl{

	public function __construct() {
        parent::__construct();
    }
    
    public function indexOp() {
			$article_class_model	= Model('article_class');
			$article_model	= Model('article');
			$condition	= array();
			
			$article_class = $article_class_model->getClassList($condition);
			output_data(array('article_class' => $article_class));		
    }
}
