<?php
/**
 * cms评论
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class cms_commentControl extends SystemControl{


	public function __construct(){
		parent::__construct();
		Language::read('cms');
	}

	public function indexOp() {
        $this->comment_manageOp();
	}


    /**
     * 评论管理
     */
	public function comment_manageOp() {
        $condition = array();
        if(!empty($_GET['comment_id'])) {
            $condition['comment_id'] = intval($_GET['comment_id']);
        }
        if(!empty($_GET['member_name'])) {
            $condition['member_name'] = array('like','%'.trim($_GET['member_name']).'%');
        }
        if(!empty($_GET['comment_type'])) {
            $condition['comment_type'] = intval($_GET['comment_type']);
        }
        if(!empty($_GET['comment_object_id'])) {
            $condition['comment_object_id'] = intval($_GET['comment_object_id']);
        }
        if(!empty($_GET['comment_message'])) {
            $condition['comment_message'] = array('like','%'.trim($_GET['comment_message']).'%');
        }
        $model_comment = Model("cms_comment");
        $comment_list = $model_comment->getListWithUserInfo($condition,10,'comment_time desc');
        Tpl::output('list',$comment_list);
        Tpl::output('show_page',$model_comment->showpage(2));
        $this->get_type_array();
        $this->show_menu('comment_manage');
        Tpl::showpage('cms_comment.manage');
    }

    /**
     * 获取类型数组
     */
    private function get_type_array() {
        $type_array = array();
        $type_array[1] = array('name'=>Language::get('cms_text_artcile'),'key'=>'article');
        $type_array[2] = array('name'=>Language::get('cms_text_picture'),'key'=>'picture');
        Tpl::output('type_array',$type_array);
    }


    /**
     * 评论删除
     */
    public function comment_dropOp() {
        $model = Model('cms_comment');
        $condition = array();
        $condition['comment_id'] = array('in',trim($_POST['comment_id']));
        $result = $model->drop($condition);
        if($result) {
            $this->log(Language::get('cms_log_comment_drop').$_POST['comment_id'], 1);
            showMessage(Language::get('nc_common_del_succ'),'');
        } else {
            $this->log(Language::get('cms_log_comment_drop').$_POST['comment_id'], 0);
            showMessage(Language::get('nc_common_del_fail'),'','','error');
        }
    }

    private function show_menu($menu_key) {
        $menu_array = array(
            "{$menu_key}"=>array('menu_type'=>'link','menu_name'=>Language::get('nc_manage'),'menu_url'=>'index.php?act=cms_comment&op='.$menu_key),
        );
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }


}
