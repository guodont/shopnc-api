<?php
/**
 * cms文章
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class pictureControl extends CMSHomeControl{

	public function __construct() {
		parent::__construct();
        Tpl::output('index_sign', 'picture');
    }

    public function indexOp() {
        $this->picture_listOp();
    }

    /**
     * 文章列表
     */
	public function picture_listOp() {
        //画报列表
        $conition = array();
        if(!empty($_GET['class_id'])) {
            $conition['picture_class_id'] = intval($_GET['class_id']);
        }
        $conition['picture_state'] = self::ARTICLE_STATE_PUBLISHED;
        $model_picture = Model('cms_picture');
        $picture_list = $model_picture->getList($conition, 12, 'picture_sort asc, picture_id desc');
        Tpl::output('show_page', $model_picture->showpage(2));
        Tpl::output('total_num', $model_picture->gettotalnum());
        Tpl::output('picture_list', $picture_list);

        //推荐画报
        $this->get_hot_picture_list();

        Tpl::showpage('picture_list');
	}

    /**
     * 推荐画报
     */
    private function get_hot_picture_list() {
        $model_picture = Model('cms_picture');
        $condition = array();
        $condition['picture_state'] = self::ARTICLE_STATE_PUBLISHED;
        $condition['picture_commend_flag'] = self::COMMEND_FLAG_TRUE;
        $hot_picture_list = $model_picture->getList($condition, NULL, 'picture_click desc', '*', 5);
        Tpl::output('hot_picture_list', $hot_picture_list);
    }

    /**
     * 画报详细页
     */
	public function picture_detailOp() {
        $picture_id = intval($_GET['picture_id']);
        if($picture_id <= 0) {
            showMessage(Language::get('wrong_argument'),'','','error');
        }

        $model_picture = Model('cms_picture');
        $picture_detail = $model_picture->getOne(array('picture_id'=>$picture_id));
        if(empty($picture_detail)) {
            showMessage(Language::get('picture_not_exist'), CMS_SITE_URL, '', 'error');
        }

        if(intval($picture_detail['picture_state']) !== self::ARTICLE_STATE_PUBLISHED) {
            if($this->publisher_type !== self::ARTICLE_TYPE_ADMIN) {
                if(empty($_SESSION['member_id']) || $_SESSION['member_id'] != $this->publisher_id) {
                    showMessage(Language::get('picture_not_exist'), CMS_SITE_URL, '', 'error');
                }
            }
        }

        $model_picture_image = Model('cms_picture_image');
        $picture_image_list = $model_picture_image->getList(array('image_picture_id'=>$picture_id),NULL);
        Tpl::output('picture_image_list', $picture_image_list);

        $conition = array();
        $conition['picture_state'] = self::ARTICLE_STATE_PUBLISHED;
        $conition['picture_id'] = array('lt', $picture_id);
        $pre_picture = $model_picture->getList($conition, null, 'picture_id desc', '*', 1);
        Tpl::output('pre_picture', $pre_picture[0]);
        $conition['picture_id'] = array('gt', $picture_id);
        $next_picture = $model_picture->getList($conition, null, 'picture_id asc', '*', 1);
        Tpl::output('next_picture', $next_picture[0]);

        //计数加1
        $model_picture->modify(array('picture_click'=>array('exp','picture_click+1')),array('picture_id'=>$picture_id));

        //标签
        $model_tag = Model('cms_tag');
        $cms_tag_list = $model_tag->getList(TRUE, null, 'tag_sort asc', '', 10);
        $cms_tag_list = array_under_reset($cms_tag_list, 'tag_id');
        Tpl::output('cms_tag_list', $cms_tag_list);

        //分享
        $this->get_share_app_list();

        //seo
        Tpl::output('seo_title', $picture_detail['picture_title']);

        Tpl::output('picture_detail', $picture_detail);
        Tpl::output('detail_object_id', $picture_id);
        Tpl::showpage('picture_detail');
    }

    /**
     * 画报评论
     */
    public function picture_comment_detailOp() {
        $picture_id = intval($_GET['picture_id']);
        if($picture_id <= 0) {
            showMessage(Language::get('wrong_argument'),'','','error');
        }

        $model_picture = Model('cms_picture');
        $picture_detail = $model_picture->getOne(array('picture_id'=>$picture_id));
        if(empty($picture_detail)) {
            showMessage(Language::get('picture_not_exist'), CMS_SITE_URL, '', 'error');
        }

        if(intval($picture_detail['picture_state']) !== self::ARTICLE_STATE_PUBLISHED) {
            if($this->publisher_type !== self::ARTICLE_TYPE_ADMIN) {
                if(empty($_SESSION['member_id']) || $_SESSION['member_id'] != $this->publisher_id) {
                    showMessage(Language::get('picture_not_exist'), CMS_SITE_URL, '', 'error');
                }
            }
        }

        $picture_hot_comment = $model_picture->getList(array('picture_state'=>self::ARTICLE_STATE_PUBLISHED), null, 'picture_comment_count desc', '*', 10);
        Tpl::output('hot_comment', $picture_hot_comment);

        Tpl::output('picture_detail', $picture_detail);
        Tpl::output('detail_object_id', $picture_id);
        Tpl::output('comment_all', 'all');

        //推荐文章
        $this->get_article_comment();

        Tpl::showpage('comment_detail');
    }


    /**
     * 画报详细页(图片列表)
     */
	public function picture_detail_imageOp() {
        $picture_id = intval($_GET['picture_id']);
        if($picture_id <= 0) {
            showMessage(Language::get('wrong_argument'),'','','error');
        }

        $model_picture = Model('cms_picture');
        $picture_detail = $model_picture->getOne(array('picture_id'=>$picture_id));
        if(empty($picture_detail)) {
            showMessage(Language::get('picture_not_exist'), CMS_SITE_URL, '', 'error');
        }

        if(intval($picture_detail['picture_state']) !== self::ARTICLE_STATE_PUBLISHED) {
            if($this->publisher_type !== self::ARTICLE_TYPE_ADMIN) {
                if(empty($_SESSION['member_id']) || $_SESSION['member_id'] != $this->publisher_id) {
                    showMessage(Language::get('picture_not_exist'), CMS_SITE_URL, '', 'error');
                }
            }
        }

        $model_picture_image = Model('cms_picture_image');
        $picture_image_list = $model_picture_image->getList(array('image_picture_id'=>$picture_id), 25);
        Tpl::output('show_page', $model_picture_image->showpage(2));
        Tpl::output('picture_image_list', $picture_image_list);

        //计数加1
        $model_picture->modify(array('picture_click'=>array('exp','picture_click+1')),array('picture_id'=>$picture_id));

        //推荐画报
        $hot_picture_list = $model_picture->getList(TRUE, NULL, 'picture_click desc', '*', 5);
        Tpl::output('hot_picture_list', $hot_picture_list);

        Tpl::output('picture_detail', $picture_detail);
        Tpl::output('comment_object_id', $picture_id);
        Tpl::showpage('picture_detail.image');
    }


    /**
     * 画报搜索
     */
	public function picture_searchOp() {
        $condition = array();
        $condition['picture_title'] = array("like",'%'.trim($_GET['keyword']).'%');
        $condition['picture_state'] = self::ARTICLE_STATE_PUBLISHED;
        $model_picture = Model('cms_picture');
        $picture_list = $model_picture->getList($condition, 20, 'picture_sort asc, picture_id desc');
        Tpl::output('show_page', $model_picture->showpage(2));
        Tpl::output('total_num', $model_picture->gettotalnum());
        Tpl::output('picture_list', $picture_list);

        //推荐画报
        $this->get_hot_picture_list();

        Tpl::showpage('picture_list');
	}

    /**
     * 根据标签搜索
     */
	public function picture_tag_searchOp() {
        $picture_list = array();
        if(intval($_GET['tag_id']) > 0) {
            $model_picture = Model('cms_picture');

            $condition = array();
            $condition['relation_tag_id'] = $_GET['tag_id'];
            $condition['picture_state'] = self::ARTICLE_STATE_PUBLISHED;
            $picture_list = $model_picture->getListByTagID($condition, 20, 'picture_sort asc, picture_id desc');

            Tpl::output('show_page', $model_picture->showpage(2));
            Tpl::output('total_num', $model_picture->gettotalnum());
        }

        Tpl::output('picture_list', $picture_list);

        //推荐画报
        $this->get_hot_picture_list();

        Tpl::showpage('picture_list');
    }


}
