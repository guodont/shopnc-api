<?php
/**
 * CMS评论
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class commentControl extends CMSHomeControl{

    public function __construct() {
        parent::__construct();
        //是否关闭投稿功能
        if(intval(C('cms_comment_flag')) !== 1) {
            showMessage(Language::get('comment_closed'),'','','error');
        }
    }

    /**
     * 评论保存
     **/
    public function comment_saveOp() {

        $data = array();
        $data['result'] = 'true';
        $comment_object_id = intval($_POST['comment_object_id']);
        $comment_type = $_POST['comment_type'];
        $model_name = '';
        $count_field = '';
        switch ($comment_type) {
        case 'article':
            $comment_type = self::ARTICLE;
            $model_name = 'cms_article';
            $count_field = 'article_comment_count';
            $comment_object_key = 'article_id';
            break;
        case 'picture':
            $comment_type = self::PICTURE;
            $model_name = 'cms_picture';
            $count_field = 'picture_comment_count';
            $comment_object_key = 'picture_id';
            break;
        default:
            $comment_type = 0;
            break;
        }

        if($comment_object_id <= 0 || empty($comment_type) || empty($_POST['comment_message'])) {
            $data['result'] = 'false';
            $data['message'] = Language::get('wrong_argument');
            self::echo_json($data);
        }

        if(!empty($_SESSION['member_id'])) {

            $param = array();
            $param['comment_type'] = $comment_type;
            $param["comment_object_id"] = $comment_object_id;
            if (strtoupper(CHARSET) == 'GBK'){
                $param['comment_message'] = Language::getGBK(trim($_POST['comment_message']));
            } else {
                $param['comment_message'] = trim($_POST['comment_message']);
            }
            $param['comment_member_id'] = $_SESSION['member_id'];
            $param['comment_time'] = time();

            $model_comment = Model('cms_comment');

            if(!empty($_POST['comment_id'])) {
                $comment_detail = $model_comment->getOne(array('comment_id'=>$_POST['comment_id']));
                if(empty($comment_detail['comment_quote'])) {
                    $param['comment_quote'] = $_POST['comment_id'];
                } else {
                    $param['comment_quote'] = $comment_detail['comment_quote'].','.$_POST['comment_id'];
                }
            } else {
                $param['comment_quote'] = '';
            }

            $result = $model_comment->save($param);
            if($result) {

                //评论计数加1
                $model = Model($model_name);
                $update = array();
                $update[$count_field] = array('exp',$count_field.'+1');
                $condition = array();
                $condition[$comment_object_key] = $comment_object_id;
                $model->modify($update, $condition);

                //返回信息
                $data['result'] = 'true';
                $data['message'] = Language::get('nc_common_save_succ');
                $data['member_name'] = $_SESSION['member_name'].Language::get('nc_colon');
                $data['member_avatar'] = getMemberAvatar($_SESSION['member_avatar']);
                $data['member_link'] = SITEURL.DS.'index.php?act=member_snshome&mid='.$_SESSION['member_id'];
                $data['comment_message'] = parsesmiles(stripslashes($param['comment_message']));
                $data['comment_time'] = date('Y-m-d H:i:s',$param['comment_time']);
                $data['comment_id'] = $result;

            } else {
                $data['result'] = 'false';
                $data['message'] = Language::get('nc_common_save_fail');
            }
        } else {
            $data['result'] = 'false';
            $data['message'] = Language::get('no_login');
        }
        self::echo_json($data);
    }

    /**
     * 评论列表
     **/
    public function comment_listOp() {
        $page_count = 5;
        $order = 'comment_id desc';
        if($_GET['comment_all'] === 'all') {
            $page_count = 10;
            $order = 'comment_up desc, comment_id desc';
        }
        $comment_object_id = intval($_GET['comment_object_id']);
        $comment_type = 0;
        switch ($_GET['type']) {
        case 'article':
            $comment_type = self::ARTICLE;
            break;
        case 'picture':
            $comment_type = self::PICTURE;
            break;
        }

        if($comment_object_id > 0 && $comment_type > 0) {
            $condition = array();
            $condition["comment_object_id"] = $comment_object_id;
            $condition["comment_type"] = $comment_type;
            $model_cms_comment = Model('cms_comment');
            $comment_list = $model_cms_comment->getListWithUserInfo($condition, $page_count, $order);
            Tpl::output('comment_list', $comment_list);
            if($_GET['comment_all'] === 'all') {
                Tpl::output('show_page', $model_cms_comment->showpage(2));
            }

            $comment_quote_id = '';
            $comment_quote_list = array();
            if(!empty($comment_list)) {
                foreach ($comment_list as $value) {
                    if(!empty($value['comment_quote'])) {
                        $comment_quote_id .= $value['comment_quote'].',';
                    }
                }
            }
            if(!empty($comment_quote_id)) {
                $comment_quote_list = $model_cms_comment->getListWithUserInfo(array('comment_id'=>array('in', $comment_quote_id)));
            }
            if(!empty($comment_quote_list)) {
                $comment_quote_list = array_under_reset($comment_quote_list, 'comment_id');
            }
            Tpl::output('comment_quote_list', $comment_quote_list);
            Tpl::showpage('comment_list','null_layout');
        }
    }

    /**
     * 评论删除
     **/
    public function comment_dropOp() {
        $data['result'] = 'false';
        $data['message'] = Language::get('nc_common_del_fail');
        $comment_id = intval($_POST['comment_id']);
        if($comment_id > 0) {
            $model_comment = Model('cms_comment');
            $comment_info = $model_comment->getOne(array('comment_id'=>$comment_id));
            if($comment_info['comment_member_id'] == $_SESSION['member_id']) {
                $result = $model_comment->drop(array('comment_id'=>$comment_id));
                if($result) {

                    $comment_type = $_GET['type'];
                    switch ($comment_type) {
                    case 'article':
                        $comment_type = self::ARTICLE;
                        $model_name = 'cms_article';
                        $count_field = 'article_comment_count';
                        $comment_object_key = 'article_id';
                        break;
                    case 'picture':
                        $comment_type = self::PICTURE;
                        $model_name = 'cms_picture';
                        $count_field = 'picture_comment_count';
                        $comment_object_key = 'picture_id';
                        break;
                    default:
                        $comment_type = 0;
                        break;
                    }

                    //评论计数减1
                    $model = Model($model_name);
                    $update = array();
                    $update[$count_field] = array('exp',$count_field.'-1');
                    $condition = array();
                    $condition[$comment_object_key] = $comment_object_id;
                    $model->modify($update, $condition);

                    $data['result'] = 'true';
                    $data['message'] = Language::get('nc_common_del_succ');
                }
            }
        }
        self::echo_json($data);
    }

    /**
     * 评论顶
     **/
    public function comment_upOp() {

        $data = array();
        $data['result'] = 'true';

        $comment_id = intval($_POST['comment_id']);
        if($comment_id > 0) {
            $model_comment_up = Model('cms_comment_up');
            $param = array();
            $param['comment_id'] = $comment_id;
            $param['up_member_id'] = $_SESSION['member_id'];
            $is_exist = $model_comment_up->isExist($param);
            if(!$is_exist) {
                $param['up_time'] = time();
                $model_comment_up->save($param);

                $model_comment = Model('cms_comment');
                $model_comment->modify(array('comment_up'=>array('exp', 'comment_up+1')), array('comment_id'=>$comment_id));
            } else {
                $data['result'] = 'false';
                $data['message'] = '顶过了';
            }
        } else {
            $data['result'] = 'false';
            $data['message'] = Language::get('wrong_argument');
        }
        self::echo_json($data);
    }

}
