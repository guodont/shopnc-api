<?php
/**
 * 微商城评论
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class commentControl extends MircroShopControl{

	public function __construct() {
        parent::__construct();
    }

    /**
     * 评论保存
     **/
    public function comment_saveOp() {

        $data = array();
        $data['result'] = 'true';
        $comment_id = intval($_POST['comment_id']);
        $comment_type = self::get_channel_type($_GET['type']);
        if($comment_id <= 0 || empty($comment_type) || empty($_POST['comment_message']) || mb_strlen($_POST['comment_message']) > 140) {
            $data['result'] = 'false';
            $data['message'] = Language::get('wrong_argument');
            self::echo_json($data);
        }

        if(!empty($_SESSION['member_id'])) {
            $param = array();
            $param['comment_type'] = $comment_type['type_id']; 
            $param["comment_object_id"] = $comment_id;
            if (strtoupper(CHARSET) == 'GBK'){
                $param['comment_message'] = Language::getGBK(trim($_POST['comment_message']));
            } else {
                $param['comment_message'] = trim($_POST['comment_message']);
            }
            $param['comment_member_id'] = $_SESSION['member_id'];
            $param['comment_time'] = time();
            $model_comment = Model('micro_comment');
            $result = $model_comment->save($param);
            if($result) {

                //评论计数加1
                $model = Model("micro_{$_GET['type']}");
                $update = array();
                $update['comment_count'] = array('exp','comment_count+1');
                $condition = array();
                $condition[$comment_type['type_key']] = $comment_id;
                $model->table("micro_{$_GET['type']}")->where($condition)->update($update);

                //返回信息
                $data['result'] = 'true';
                $data['message'] = Language::get('nc_common_save_succ');
                $data['member_name'] = $_SESSION['member_name'].Language::get('nc_colon');
                $data['member_avatar'] = getMemberAvatar($_SESSION['member_avatar']);
                $data['member_link'] = MICROSHOP_SITE_URL.'/index.php?act=home&member_id='.$_SESSION['member_id'];
                $data['comment_message'] = parsesmiles(stripslashes($param['comment_message']));
                $data['comment_time'] = date('Y-m-d H:i:s',$param['comment_time']);
                $data['comment_id'] = $result; 

                //分享内容
                if(isset($_POST['share_app_items'])) {
                    $condition = array();
                    $condition[$comment_type['type_key']] = $_POST['comment_id'];
                    if($_GET['type'] == 'store') {
                        $info = $model->getOneWithStoreInfo($condition);
                    } else {
                        $info = $model->getOne($condition);
                    }
                    $info['commend_message'] = $param['comment_message'];
                    $info['type'] = $_GET['type'];
                    $info['url'] = MICROSHOP_SITE_URL.DS."index.php?act={$_GET['type']}&op=detail&{$_GET['type']}_id=".$_POST['comment_id'].'#widgetcommenttitle';
                    self::share_app_publish('comment',$info);
                }
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
        $comment_id = intval($_GET['comment_id']);
        if($comment_id > 0) {
            $condition = array();
            $condition["comment_object_id"] = $comment_id;
            $comment_type = self::get_channel_type($_GET['type']);
            if(!empty($comment_type)) {
                $condition["comment_type"] = $comment_type['type_id']; 
                $model_comment = Model("micro_comment");
                $comment_list = $model_comment->getListWithUserInfo($condition,5,'comment_time desc');
                Tpl::output('list',$comment_list);
                Tpl::output('show_page',$model_comment->showpage(2));	
            }
        }
        Tpl::showpage('widget_comment_list','null_layout');
    }

    /**
     * 评论删除
     **/
    public function comment_dropOp() {
        $data['result'] = 'false';
        $data['message'] = Language::get('nc_common_del_fail');
        $comment_id = intval($_GET['comment_id']);
        if($comment_id > 0) {
            $model_comment = Model('micro_comment');
            $comment_info = $model_comment->getOne(array('comment_id'=>$comment_id));
            if($comment_info['comment_member_id'] == $_SESSION['member_id']) {
                $result = $model_comment->drop(array('comment_id'=>$comment_id));
                if($result) {

                    //评论计数减1
                    $comment_type = self::get_channel_type($_GET['type']);
                    if(!empty($comment_type)) {
                        $model = Model();
                        $update = array();
                        $update['comment_count'] = array('exp','comment_count-1');
                        $condition = array();
                        $condition[$comment_type['type_key']] = $comment_info['comment_object_id'];
                        $model->table("micro_{$_GET['type']}")->where($condition)->update($update);
                    }

                    $data['result'] = 'true';
                    $data['message'] = Language::get('nc_common_del_succ');
                }
            }
        }
        self::echo_json($data);
    }

}
