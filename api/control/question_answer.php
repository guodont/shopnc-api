<?php
/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15-9-1
 * Time: 下午3:25
 */
defined('InShopNC') or exit('Access Invalid!');

class question_answerControl extends apiMemberControl
{
    protected $c_id = 0;        // 圈子id
    protected $q_id = 0;        // 问题id
    protected $r_id = 0;        // 回复id
    protected $question_info = array();
    protected $circle_info = array();

    public function __construct()
    {
        parent::__construct();

        if (!isset($_POST['c_id'])) {
            $this->c_id = 0;
        } else {
            $this->c_id = intval($_POST['c_id']);
        }

        if (isset($_POST['q_id'])) {
            $this->q_id = intval($_POST['q_id']);
        }

        if (!isset($_GET['r_id'])) {
            $this->r_id = intval($_POST['r_id']);
        } else {
            $this->r_id = intval($_GET['r_id']);
        }
    }

    protected function questionInfo()
    {
        $this->question_info = Model()->table('circle_theme')->where(array('theme_id' => $this->q_id))->find();
        if (empty($this->question_info)) {
            output_error("问题不存在");
            die;
        }
    }

    /**
     * 圈子信息
     */
    protected function circleInfo()
    {
        // 圈子信息
        $this->circle_info = Model()->table('circle')->find($this->c_id);
    }

    /**
     * POST 创建一个问题
     * type: 5 问达人 6 问专家
     */
    public function createQuestionOp()
    {
        if (isset($_POST)) {
            // Reply function does close,throw error.
            if (!intval(C('circle_istalk'))) {
                output_error(L('circle_theme_cannot_be_published'), array('code' => 501));
            }
            // checked cookie of SEC
            if (cookie(circle_intervaltime)) {
                output_error(L('circle_operation_too_frequent'), array('code' => 501));
            }
            // 圈子信息
            $this->circleInfo();

            $model = Model();

            // 问题分类
            $thclass_id = intval($_POST['type']);
            $thclass_name = '';
            if ($thclass_id > 0) {
                $thclass_info = $model->table('circle_thclass')->find($thclass_id);
                $thclass_name = $thclass_info['thclass_name'];
            } else {
                output_error("未设置问题类型");
                die;
            }
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["name"], "require" => "true", "message" => '问题名称不能为空'),
                array("input" => $_POST["name"], "validator" => 'Length', "min" => 4, "max" => 30, "message" => '名称长度不符合要求'),
                array("input" => $_POST["content"], "require" => "true", "message" => '问题描述不能为空'),
                array("input" => $_POST["content"], "validator" => 'Length', "min" => 4, "max" => 2500, "message" => '问题描述长度不符合要求'),
            );
            $error = $obj_validate->validate();
            if ($error != '') {
                output_error($error);
                die;
            }
            $insert = array();
            $insert['theme_name'] = circleCenterCensor($_POST['name']);
            $insert['theme_content'] = circleCenterCensor($_POST['content']);
            $insert['circle_id'] = $this->c_id;
            $insert['circle_name'] = empty($this->circle_info) ? "大学圈圈首页" : $this->circle_info['circle_name'];
            $insert['thclass_id'] = $thclass_id;
            $insert['thclass_name'] = $thclass_name;
            $insert['member_id'] = $this->member_info['member_id'];
            $insert['member_name'] = $this->member_info['member_name'];
            $insert['is_identity'] = 3; //默认都为成员发布的
            $insert['theme_addtime'] = time();
            $insert['lastspeak_time'] = time();
            $insert['theme_readperm'] = intval($_POST['readperm']);
            $questionid = $model->table('circle_theme')->insert($insert);
            if ($questionid) {
                // 更新圈子表话题数
                $update = array(
                    'circle_id' => $this->c_id,
                    'circle_thcount' => array('exp', 'circle_thcount+1')
                );
                $model->table('circle')->update($update);

                // 更新用户相关信息
                $update = array(
                    'cm_thcount' => array('exp', 'cm_thcount+1'),
                    'cm_lastspeaktime' => time()
                );
                $model->table('circle_member')->where(array('member_id' => $this->member_info['member_id'], 'circle_id' => $this->c_id))->update($update);

                // set cookie of SEC
                if (intval(C('circle_intervaltime')) > 0) {
                    setNcCookie('circle_intervaltime', true, intval(C('circle_intervaltime')));
                }

                // Experience
                $param = array();
                $param['member_id'] = $this->member_info['member_id'];
                $param['member_name'] = $this->member_info['member_name'];
                $param['circle_id'] = $this->c_id;
                $param['type'] = 'release';
                $param['itemid'] = $questionid;
                Model('circle_exp')->saveExp($param);
                $data['id'] = $questionid;
                output_data(array('ok' => $data));
            } else {
                output_error("创建失败");
            }
        }
        output_error('request error');
    }


    /**
     * POST 问题回复（回答）
     */
    public function create_answerOp()
    {

        // Reply function does close,throw error.
        if (!intval(C('circle_istalk'))) {
            output_error(L('circle_has_been_closed_reply'));
        }
        // checked cookie of SEC
        if (cookie(circle_intervaltime)) {
            output_error(L('circle_operation_too_frequent'));
        }

        // 问题信息
        $this->questionInfo();

        if (isset($_POST)) {
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["content"], "require" => "true", "message" => '回复不能为空'),
            );
            $error = $obj_validate->validate();
            if ($error != '') {
                output_error($error);
            } else {
                $model = Model();
                $insert = array();
                $insert['theme_id'] = $this->q_id;
                $insert['circle_id'] = $this->c_id;
                $insert['member_id'] = $this->member_info['member_id'];
                $insert['member_name'] = $this->member_info['member_name'];
                $insert['reply_content'] = circleCenterCensor($_POST['content']);
                $insert['reply_addtime'] = time();
                $insert['is_closed'] = 0;

                // 回复楼层验证
                if ($this->r_id != '') {
                    $reply_info = Model()->table('circle_threply')->where(array('theme_id' => $this->q_id, 'reply_id' => $this->r_id))->find();
                    if (!empty($reply_info)) {
                        $insert['reply_replyid'] = $reply_info['reply_id'];
                        $insert['reply_replyname'] = $reply_info['member_name'];
                    }
                }

                $reply_id = $model->table('circle_threply')->insert($insert);
                if ($reply_id) {

                    // 话题被回复数增加 最后发言人发言时间
                    $update = array();
                    $update['theme_id'] = $this->q_id;
                    $update['theme_commentcount'] = array('exp', 'theme_commentcount+1');
                    $update['lastspeak_id'] = $this->member_info['member_id'];
                    $update['lastspeak_name'] = $this->member_info['member_name'];
                    $update['lastspeak_time'] = time();
                    $model->table('circle_theme')->update($update);

                    // 成员回复数增加 最后回复时间
                    $model->table('circle_member')->where(array('member_id' => $this->member_info['member_id'], 'circle_id' => $this->c_id))->update(array('cm_comcount' => array('exp', 'cm_comcount+1'), 'cm_lastspeaktime' => time()));
                    // set cookie of SEC
                    if (intval(C('circle_intervaltime')) > 0) {
                        setNcCookie('circle_intervaltime', true, intval(C('circle_intervaltime')));
                    }

                    if ($this->question_info['member_id'] != $this->member_info['member_id']) {
                        // Experience for replyer
                        $param = array();
                        $param['member_id'] = $this->member_info['member_id'];
                        $param['member_name'] = $this->member_info['member_name'];
                        $param['circle_id'] = $this->c_id;
                        $param['theme_id'] = $this->q_id;
                        $param['type'] = 'reply';
                        $param['itemid'] = $this->q_id . ',' . $reply_id;
                        Model('circle_exp')->saveExp($param);
                        // Experience for releaser
                        $param = array();
                        $param['member_id'] = $this->question_info['member_id'];
                        $param['member_name'] = $this->question_info['member_name'];
                        $param['theme_id'] = $this->q_id;
                        $param['circle_id'] = $this->c_id;
                        $param['type'] = 'replied';
                        $param['itemid'] = $this->q_id;
                        Model('circle_exp')->saveExp($param);
                    }
                    output_data(array('code' => 201, 'success' => '回复成功'));
                } else {
                    output_error('回复失败');
                }
            }
        }
    }

    /**
     * 我的问题
     */
    public function myQuestionsOp()
    {
        $type = intval($_GET['type']);
        $c_id = intval($_GET['c_id']);
        if ($type > 0) {
            $where = array();
            if ($c_id >= 0) {
                $where['circle_id'] = $c_id;
            }
            $where['thclass_id'] = $type;
            $model = Model();
            if (intval($_GET['cream']) == 1) {
                $where['is_digest'] = 1;
            }
            $m_circle_theme = $model->table('circle_theme');
            $question_list = $m_circle_theme->where($where)->order('is_stick desc,lastspeak_time desc')->page($this->page)->select();
            $pageCount = $m_circle_theme->gettotalpage();
            if (!empty($question_list)) {
                foreach ($question_list as $key => $val) {
                    $question_list[$key]['member_avatar'] = getMemberAvatarForID($question_list[$key]['member_id']);
                }
            }
            output_data(array('questions' => $question_list), mobile_page($pageCount));
        } else {
            output_error("问题类型id错误");
            die;
        }
    }

    /**
     * 我的回答
     */
    public function myAnswersOp() {

    }


}