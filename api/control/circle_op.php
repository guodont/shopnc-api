<?php
/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15-8-25
 * Time: 下午12:18
 */


defined('InShopNC') or exit('Access Invalid!');

class circle_opControl extends apiBaseCircleControl {

    public function __construct() {
        parent::__construct();
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



}