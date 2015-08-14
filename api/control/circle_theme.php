<?php
/**
 * 圈子话题api
 * Created by PhpStorm.
 * User: guodont
 * Date: 15-8-4
 * Time: 上午11:02
 */

defined('InShopNC') or exit('Access Invalid!');
class circle_themeControl extends apiBaseCircleThemeControl {

    public function __construct() {
        parent::__construct();
    }


    /**
     * GET 话题详细信息
     */
    public function ajax_themeinfoOp(){
        // 话题信息
        $this->themeInfo();

        $data = $this->theme_info;
        $model = Model();

        // 访问数增加
        $model->table('circle_theme')->update(array('theme_id'=>$this->t_id, 'theme_browsecount'=>array('exp', 'theme_browsecount+1')));

        $data['theme_content'] = ubb($data['theme_content']);
        if($data['theme_edittime'] != ''){
            $data['theme_edittime'] = @date('Y-m-d H:i', $data['theme_edittime']);
        }
        $data['member_avatar'] = getMemberAvatarForID($data['member_id']);
        // 是否赞过话题
        $data['theme_nolike'] = 1;
        if (!empty($this->member_info['member_id'])) {
            // 是否赞过话题
            $like_info = $model->table('circle_like')->where(array('theme_id'=>$this->t_id, 'member_id'=>$this->member_info['member_id']))->find();
            if(empty($like_info)){
                $data['theme_nolike'] = 1;
            }else{
                $data['theme_nolike'] = 0;
            }
        }
        if (strtoupper(CHARSET) == 'GBK'){
            $data = Language::getUTF8($data);
        }
        output_data(array('theme_info'=>$data));die;
    }

    /**
     * GET 回复相关信息 话题列表页使用
     */
    public function ajax_quickreplyOp(){
        // 话题信息
        $this->themeInfo();

        $data = array();
        $data['form_action'] = CIRCLE_SITE_URL.'/index.php?act=theme&op=save_reply&type=quick&c_id='.$this->c_id.'&t_id='.$this->t_id;
        $data['member_avatar'] = getMemberAvatarForID($this->member_info['member_id']); // 头像
        // 回复
        $reply_list = Model()->table('circle_threply')->where(array('theme_id'=>$this->t_id, 'circle_id'=>$this->c_id))->order('reply_id desc')->limit(5)->select();
        if(!empty($reply_list)){
            foreach($reply_list as $key=>$val){
                $reply_list[$key]['member_avatar'] = getMemberAvatarForID($val['member_id']);
                $reply_list[$key]['reply_addtime'] = date('Y-m-d H:i', $val['reply_addtime']);
                $reply_list[$key]['reply_content'] = removeUBBTag($val['reply_content']);
            }
        }
        $data['reply_list'] = $reply_list;
        $data['c_istalk']	= intval(C('circle_istalk'));
        $data['c_contentleast']	= intval(C('circle_contentleast'));
        if(intval(C('circle_contentleast')) > 0){
            $data['c_contentmsg']	= sprintf(L('nc_content_min_length'), intval(C('circle_contentleast')));
        }else{
            $data['c_contentmsg']	= L('nc_content_not_null');
        }

        if (strtoupper(CHARSET) == 'GBK'){
            $data = Language::getUTF8($data);
        }
        output_data(array('reply_info'=>$data));die;
    }

    /**
     * POST 创建一个话题
     */
    public function create_themeOp(){
        if(isset($_POST)){
            // Reply function does close,throw error.
            if(!intval(C('circle_istalk'))){
                output_error(L('circle_theme_cannot_be_published'),array('code'=>501));
            }
            // checked cookie of SEC
            if(cookie(circle_intervaltime)){
                output_error(L('circle_operation_too_frequent'),array('code'=>501));
            }
            // 圈子信息

            $this->circleInfo();

            // 会员信息
            $this->memberInfo();


            // 不是圈子成员不能发帖
            if(!in_array($this->identity, array(1,2,3))){
                showDialog(L('circle_no_join_ban_release'));
                output_error(L('circle_no_join_ban_release'),array('code'=>502));
            }

            $model = Model();

            // 主题分类
            $thclass_id = intval($_POST['thtype']);
            $thclass_name = '';
            if($thclass_id > 0){
                $thclass_info = $model->table('circle_thclass')->find($thclass_id);
                $thclass_name = $thclass_info['thclass_name'];
            }
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $validate_arr[] = array("input"=>$_POST["name"], "require"=>"true","message"=>Language::get('nc_name_not_null'));
            $validate_arr[] = array("input"=>$_POST["name"], "validator"=>'Length',"min"=>4,"max"=>30,"message"=>Language::get('nc_name_min_max_length'));
            $validate_arr[] = array("input"=>$_POST["themecontent"], "require"=>"true","message"=>Language::get('nc_content_not_null'));
            if(intval(C('circle_contentleast')) > 0) $validate_arr[] = array("input"=>$_POST["themecontent"],"validator"=>'Length',"min"=>intval(C('circle_contentleast')),"message"=>Language::get('circle_contentleast'));
            $obj_validate -> validateparam = $validate_arr;
            $error = $obj_validate->validate();
            if ($error != ''){
                output_error("创建失败",$error);
            }
            $insert = array();
            $insert['theme_name']	= circleCenterCensor($_POST['name']);
            $insert['theme_content']= circleCenterCensor($_POST['themecontent']);
            $insert['circle_id']	= $this->c_id;
            $insert['circle_name']	= $this->circle_info['circle_name'];
            $insert['thclass_id']	= $thclass_id;
            $insert['thclass_name'] = $thclass_name;
            $insert['member_id']	= $this->member_info['member_id'];
            $insert['member_name']	= $this->member_info['member_name'];
            $insert['is_identity']	= $this->identity;
            $insert['theme_addtime']= time();
            $insert['lastspeak_time']= time();
            $insert['theme_readperm']= intval($_POST['readperm']);
            $insert['theme_special']= intval($_GET['sp']);
            $themeid = $model->table('circle_theme')->insert($insert);
            if($themeid){
                // 更新圈子表话题数
                $update = array(
                    'circle_id'=>$this->c_id,
                    'circle_thcount'=>array('exp', 'circle_thcount+1')
                );
                $model->table('circle')->update($update);

                // 更新用户相关信息
                $update = array(
                    'cm_thcount'=>array('exp', 'cm_thcount+1'),
                    'cm_lastspeaktime'=>time()
                );
                $model->table('circle_member')->where(array('member_id'=>$this->member_info['member_id'], 'circle_id'=>$this->c_id))->update($update);

                // set cookie of SEC
                if(intval(C('circle_intervaltime')) > 0){
                    setNcCookie('circle_intervaltime', true, intval(C('circle_intervaltime')));
                }

                // Experience
                $param = array();
                $param['member_id']		= $this->member_info['member_id'];
                $param['member_name']	= $this->member_info['member_name'];
                $param['circle_id']		= $this->c_id;
                $param['type']			= 'release';
                $param['itemid']		= $themeid;
                Model('circle_exp')->saveExp($param);

                $theme_url = CIRCLE_SITE_URL.'/index.php?act=theme&op=theme_detail&c_id='.$this->c_id.'&t_id='.$themeid;
                output_data(array('code'=>201,'success'=>'创建成功','url'=>$theme_url));
            }else{
                output_error(L('nc_release_op_fail'),array('code'=>500));
            }
        }
        output_error('request error');
    }



    /**
     * GET 话题回复信息
     */
    public function theme_detailOp(){

        // 会员信息
        $this->memberInfo();

        // 话题信息
        $this->themeInfo();

        // 验证阅读权限
        $this->readPermissions($this->cm_info);
        if($this->m_readperm < $this->theme_info['theme_readperm']){
            //没有权限->code 500
            output_error(L('circle_Insufficient_permissions'),array('code'=>500));
        }

        $model = Model();
        // 话题被浏览数增加
        $model->table('circle_theme')->update(array('theme_id'=>$this->t_id, 'theme_browsecount'=>array('exp', 'theme_browsecount+1')));

        // 回复列表
        $where = array();
        $where['theme_id'] = $this->t_id;
        if($_GET['only_id'] != ''){
            $where['member_id'] = intval($_GET['only_id']);
        }
        $m_reply = $model->table('circle_threply');

        $reply_info = $m_reply ->where($where)->page($this->page) ->order('reply_id asc')->select();
        $pageCount = $m_reply->gettotalpage();
        $replyid_array = array();
        $memberid_array = array();
        if(!empty($reply_info)){
            foreach($reply_info as $val){
                $replyid_array[]	= $val['reply_id'];
                $memberid_array[]	= $val['member_id'];
            }
            foreach($reply_info as $key=>$val){
                $reply_info[$key]['member_avatar'] = getMemberAvatarForID($reply_info[$key]['member_id']);
            }
        }

        $replyid_array[]	= 0;
        ksort($replyid_array);
        $memberid_array[]	= $this->theme_info['member_id'];
        $memberid_array		= array_unique($memberid_array);
        ksort($memberid_array);

        $where = array();
        $where['theme_id']	= $this->t_id;
        $where['reply_id']	= array('in', $replyid_array);


        // member
        $member_list = $model->table('circle_member')->field('member_id,cm_level,cm_levelname')->where(array('circle_id'=>$this->c_id, 'member_id'=>array('in', $memberid_array)))->select();
        $member_list = array_under_reset($member_list, 'member_id');

        // 是否赞过话题
        $theme_nolike = 1;
        if (!empty($this->member_info['member_id'])) {
            // 是否赞过话题
            $like_info = $model->table('circle_like')->where(array('theme_id'=>$this->t_id, 'member_id'=>$this->member_info['member_id']))->find();
            if(empty($like_info)){
                $theme_nolike = 1;
            }else{
                $theme_nolike = 0;
            }
        }
        output_data(array('replys'=>$reply_info,'member_list'=>$member_list,'theme_nolike'=>$theme_nolike),mobile_page($pageCount));
    }


    /**
     * 赞
     */
    public function ajax_likeyesOp(){
        // 话题信息
        $this->themeInfo();

        $like_info = Model()->table('circle_like')->where(array('theme_id'=>$this->t_id, 'member_id'=>$this->member_info['member_id']))->find();
        if(empty($like_info)){
            // 插入话题赞表
            Model()->table('circle_like')->insert(array('theme_id'=>$this->t_id, 'member_id'=>$this->member_info['member_id'], 'circle_id'=>$this->c_id));
            // 更新赞数量
            Model()->table('circle_theme')->update(array('theme_id'=>$this->t_id, 'theme_likecount'=>array('exp', 'theme_likecount+1')));
            echo 'true';
        }else{
            echo 'false';
        }
        exit;
    }
    /**
     * 取消赞
     */
    public function ajax_likenoOp(){
        // 话题信息
        $this->themeInfo();

        $like_info = Model()->table('circle_like')->where(array('theme_id'=>$this->t_id, 'member_id'=>$this->member_info['member_id']))->find();
        if(empty($like_info)){
            echo 'false';
        }else{
            // 删除话题赞表信息
            Model()->table('circle_like')->where(array('theme_id'=>$this->t_id, 'member_id'=>$this->member_info['member_id']))->delete();
            // 更新赞数量
            Model()->table('circle_theme')->update(array('theme_id'=>$this->t_id, 'theme_likecount'=>array('exp', 'theme_likecount-1')));
            echo 'true';
        }
        exit;
    }

    /**
     * POST 话题回复
     */
    public function create_replyOp(){

//        var_dump($this->cm_info);
        // Reply function does close,throw error.
        if(!intval(C('circle_istalk'))){
            output_error(L('circle_has_been_closed_reply'));
        }
        // checked cookie of SEC
        if(cookie(circle_intervaltime)){
            output_error(L('circle_operation_too_frequent'));
        }
        //圈子信息
        $this->circleInfo();

        // 会员信息
        $this->memberInfo();

//        var_dump($this->cm_info);

        // 不是圈子成员不能发帖
        if(!in_array($this->identity, array(1,2,3))){
            output_error(L('circle_no_join_ban_reply'),array('code'=>501));
        }
        // 话题信息
        $this->themeInfo();

        if(isset($_POST)){
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["replycontent"], "require"=>"true", "message"=>L('circle_reply_not_null')),
            );
            $error = $obj_validate->validate();
            if($error != ''){
                output_error("回复失败",$error);
            }else{
                $model = Model();
                $insert = array();
                $insert['theme_id']		= $this->t_id;
                $insert['circle_id']	= $this->c_id;
                $insert['member_id']	= $this->member_info['member_id'];
                $insert['member_name']	= $this->member_info['member_name'];
                $insert['reply_content']= circleCenterCensor($_POST['replycontent']);
                $insert['reply_addtime']= time();
                $insert['is_closed']	= 0;

                // 回复楼层验证
                if($_POST['answer_id'] != ''){
                    $reply_info = Model()->table('circle_threply')->where(array('theme_id'=>$this->t_id, 'reply_id'=>intval($_POST['answer_id'])))->find();
                    if(!empty($reply_info)) {
                        $insert['reply_replyid']	= $reply_info['reply_id'];
                        $insert['reply_replyname']	= $reply_info['member_name'];
                    }
                }
                $reply_id = $model->table('circle_threply')->insert($insert);
                if($reply_id){

                    // 话题被回复数增加 最后发言人发言时间
                    $update = array();
                    $update['theme_id']				= $this->t_id;
                    $update['theme_commentcount']	= array('exp', 'theme_commentcount+1');
                    $update['lastspeak_id']			= $this->member_info['member_id'];
                    $update['lastspeak_name']		= $this->member_info['member_name'];
                    $update['lastspeak_time']		= time();
                    $model->table('circle_theme')->update($update);

                    // 成员回复数增加 最后回复时间
                    $model->table('circle_member')->where(array('member_id'=>$this->member_info['member_id'], 'circle_id'=>$this->c_id))->update(array('cm_comcount'=>array('exp', 'cm_comcount+1'), 'cm_lastspeaktime'=>time()));
                    // set cookie of SEC
                    if(intval(C('circle_intervaltime')) > 0){
                        setNcCookie('circle_intervaltime', true, intval(C('circle_intervaltime')));
                    }

                    if($this->theme_info['member_id'] != $this->member_info['member_id']){
                        // Experience for replyer
                        $param = array();
                        $param['member_id']		= $this->member_info['member_id'];
                        $param['member_name']	= $this->member_info['member_name'];
                        $param['circle_id']		= $this->c_id;
                        $param['theme_id']		= $this->t_id;
                        $param['type']			= 'reply';
                        $param['itemid']		= $this->t_id.','.$reply_id;
                        Model('circle_exp')->saveExp($param);
                        // Experience for releaser
                        $param = array();
                        $param['member_id']		= $this->theme_info['member_id'];
                        $param['member_name']	= $this->theme_info['member_name'];
                        $param['theme_id']		= $this->t_id;
                        $param['circle_id']		= $this->c_id;
                        $param['type']			= 'replied';
                        $param['itemid']		= $this->t_id;
                        Model('circle_exp')->saveExp($param);
                    }
                    output_data(array('code'=>201,'success'=>'回复成功'));
                } else{
                    output_error('回复失败');
                }
            }
        }
    }
    /**
     * POST 删除回复
     */
    public function del_replyOp(){
        // 验证回复
        $this->checkReplySelf();
        $model = Model();
        // The recycle bin add delete records
        $param = array();
        $param['theme_id']	= $this->t_id;
        $param['reply_id']	= $this->r_id;
        $param['op_id']		= $this->member_info['member_id'];
        $param['op_name']	= $this->member_info['member_name'];
        $param['type']		= 'reply';
        Model('circle_recycle')->saveRecycle($param);

        // 删除回复
        $model->table('circle_threply')->where(array('theme_id'=>$this->t_id, 'reply_id'=>$this->r_id, 'member_id'=>$this->member_info['member_id']))->delete();

        // Experience
        if(intval($this->reply_info['reply_exp']) > 0){
            $param = array();
            $param['member_id']		= $this->member_info['member_id'];
            $param['member_name']	= $this->member_info['member_name'];
            $param['circle_id']		= $this->c_id;
            $param['itemid']		= $this->t_id.','.$this->r_id;
            $param['type']			= 'delReplied';
            $param['exp']			= $this->reply_info['reply_exp'];
            Model('circle_exp')->saveExp($param);
        }
        output_data(array('code'=>202,'success'=>L('nc_common_op_succ')));
    }
}