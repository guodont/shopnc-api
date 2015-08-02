<?php
/**
 * 文章
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class articleControl extends BaseHomeControl {
	/**
	 * 默认进入页面
	 */
	public function indexOp(){
		/**
		 * 读取语言包
		 */
		Language::read('home_article_index');
		if(!empty($_GET['article_id'])){
			$this->showOp();
			exit;
		}
		if(!empty($_GET['ac_id'])){
			$this->articleOp();
			exit;
		}
		showMessage(Language::get('article_article_not_found'),'','html','error');//'没有符合条件的文章'
	}
	/**
	 * 文章列表显示页面
	 */
	public function articleOp(){
		/**
		 * 读取语言包
		 */
		Language::read('home_article_index');
		$lang	= Language::getLangContent();
		if(empty($_GET['ac_id'])){
			showMessage($lang['para_error'],'','html','error');//'缺少参数:文章类别编号'
		}
		/**
		 * 得到导航ID
		 */
		$nav_id = intval($_GET['nav_id']) ? intval($_GET['nav_id']) : 0 ;
		Tpl::output('index_sign',$nav_id);
		/**
		 * 根据类别编号获取文章类别信息
		 */
		$article_class_model	= Model('article_class');
		$condition	= array();
		if(!empty($_GET['ac_id'])){
			$condition['ac_id']	= intval($_GET['ac_id']);
		}
		$article_class	= $article_class_model->getOneClass(intval($_GET['ac_id']));
		Tpl::output('class_name', $article_class['ac_name']);
		if(empty($article_class) || !is_array($article_class)){
			showMessage($lang['article_article_class_not_exists'],'','html','error');//'该文章分类并不存在'
		}
		$default_count	= 5;//定义最新文章列表显示文章的数量
		/**
		 * 分类导航
		 */
		$nav_link = array(
			array(
				'title'=>$lang['homepage'],
				'link'=>SHOP_SITE_URL
			),
			array(
				'title'=>$article_class['ac_name']
			)
		);
		Tpl::output('nav_link_list',$nav_link);

		/**
		 * 左侧分类导航
		 */
		$condition	= array();
		$condition['ac_parent_id']	= $article_class['ac_id'];
		$sub_class_list	= $article_class_model->getClassList($condition);
		if(empty($sub_class_list) || !is_array($sub_class_list)){
			$condition['ac_parent_id']	= $article_class['ac_parent_id'];
			$sub_class_list	= $article_class_model->getClassList($condition);
		}
		Tpl::output('sub_class_list',$sub_class_list);
		/**
		 * 文章列表
		 */
		$child_class_list	= $article_class_model->getChildClass(intval($_GET['ac_id']));
		$ac_ids	= array();
		if(!empty($child_class_list) && is_array($child_class_list)){
			foreach ($child_class_list as $v){
				$ac_ids[]	= $v['ac_id'];
			}
		}
		$ac_ids	= implode(',',$ac_ids);
		$article_model	= Model('article');
		$condition 	= array();
		$condition['ac_ids']	= $ac_ids;
		$condition['article_show']	= '1';
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$article_list	= $article_model->getArticleList($condition,$page);
		Tpl::output('article',$article_list);
		Tpl::output('show_page',$page->show());
		/**
		 * 最新文章列表
		 */
		$count	= count($article_list);
		$new_article_list	= array();
		if(!empty($article_list) && is_array($article_list)){
			for ($i=0;$i<($count>$default_count?$default_count:$count);$i++){
				$new_article_list[]	= $article_list[$i];
			}
		}
		Tpl::output('new_article_list',$new_article_list);
		Model('seo')->type('article')->param(array('article_class'=>$article_class['ac_name']))->show();
		Tpl::showpage('article_list');
	}
	/**
	 * 单篇文章显示页面
	 */
	public function showOp(){
		/**
		 * 读取语言包
		 */
		Language::read('home_article_index');
		$lang	= Language::getLangContent();
		if(empty($_GET['article_id'])){
			showMessage($lang['para_error'],'','html','error');//'缺少参数:文章编号'
		}
		/**
		 * 根据文章编号获取文章信息
		 */
		$article_model	= Model('article');
		$article	= $article_model->getOneArticle(intval($_GET['article_id']));
		if(empty($article) || !is_array($article) || $article['article_show']=='0'){
			showMessage($lang['article_show_not_exists'],'','html','error');//'该文章并不存在'
		}
		Tpl::output('article',$article);

		/**
		 * 根据类别编号获取文章类别信息
		 */
		$article_class_model	= Model('article_class');
		$condition	= array();
		$article_class	= $article_class_model->getOneClass($article['ac_id']);
		if(empty($article_class) || !is_array($article_class)){
			showMessage($lang['article_show_delete'],'','html','error');//'该文章已随所属类别被删除'
		}
		$default_count	= 5;//定义最新文章列表显示文章的数量
		/**
		 * 分类导航
		 */
		$nav_link = array(
			array(
				'title'=>$lang['homepage'],
				'link'=>SHOP_SITE_URL
			),
			array(
				'title'=>$article_class['ac_name'],
			    'link' => urlShop('article', 'article', array('ac_id' => $article_class['ac_id']))
			),
			array(
				'title'=>$lang['article_show_article_content']
			)
		);
		Tpl::output('nav_link_list',$nav_link);
		/**
		 * 左侧分类导航
		 */
		$condition	= array();
		$condition['ac_parent_id']	= $article_class['ac_id'];
		$sub_class_list	= $article_class_model->getClassList($condition);
		if(empty($sub_class_list) || !is_array($sub_class_list)){
			$condition['ac_parent_id']	= $article_class['ac_parent_id'];
			$sub_class_list	= $article_class_model->getClassList($condition);
		}
		Tpl::output('sub_class_list',$sub_class_list);
		/**
		 * 文章列表
		 */
		$child_class_list	= $article_class_model->getChildClass($article_class['ac_id']);
		$ac_ids	= array();
		if(!empty($child_class_list) && is_array($child_class_list)){
			foreach ($child_class_list as $v){
				$ac_ids[]	= $v['ac_id'];
			}
		}
		$ac_ids	= implode(',',$ac_ids);
		$article_model	= Model('article');
		$condition 	= array();
		$condition['ac_ids']	= $ac_ids;
		$condition['article_show']	= '1';
		$article_list	= $article_model->getArticleList($condition);
		/**
		 * 寻找上一篇与下一篇
		 */
		$pre_article	= $next_article	= array();
		if(!empty($article_list) && is_array($article_list)){
			$pos	= 0;
			foreach ($article_list as $k=>$v){
				if($v['article_id'] == $article['article_id']){
					$pos	= $k;
					break;
				}
			}
			if($pos>0 && is_array($article_list[$pos-1])){
				$pre_article	= $article_list[$pos-1];
			}
			if($pos<count($article_list)-1 and is_array($article_list[$pos+1])){
				$next_article	= $article_list[$pos+1];
			}
		}
		Tpl::output('pre_article',$pre_article);
		Tpl::output('next_article',$next_article);
		/**
		 * 最新文章列表
		 */
		$count	= count($article_list);
		$new_article_list	= array();
		if(!empty($article_list) && is_array($article_list)){
			for ($i=0;$i<($count>$default_count?$default_count:$count);$i++){
				$new_article_list[]	= $article_list[$i];
			}
		}
		Tpl::output('new_article_list',$new_article_list);

		$seo_param = array();
		$seo_param['name'] = $article['article_title'];
		$seo_param['article_class'] = $article_class['ac_name'];
		Model('seo')->type('article_content')->param($seo_param)->show();
		Tpl::showpage('article_show');
	}
}
?>
