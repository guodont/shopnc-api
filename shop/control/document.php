<?php
/**
 * 系统文章
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class documentControl extends BaseHomeControl {
	public function indexOp(){
		$lang	= Language::getLangContent();
		if($_GET['code'] == ''){
			showMessage($lang['para_error'],'','html','error');//'缺少参数:文章标识'
		}
		$model_doc	= Model('document');
		$doc	= $model_doc->getOneByCode($_GET['code']);
		Tpl::output('doc',$doc);
		/**
		 * 分类导航
		 */
		$nav_link = array(
			array(
				'title'=>$lang['homepage'],
				'link'=>SHOP_SITE_URL
			),
			array(
				'title'=>$doc['doc_title']
			)
		);
		Tpl::output('nav_link_list',$nav_link);
		Tpl::showpage('document.index');
	}
}
