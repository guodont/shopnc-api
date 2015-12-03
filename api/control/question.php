<?php
/**
 * Created by PhpStorm.
 * 问答api
 * User: guodont
 * Date: 15-9-1
 * Time: 下午1:49
 */
defined('InShopNC') or exit('Access Invalid!');

class questionControl extends apiHomeControl
{
    protected $question_info = array();

    public function __construct()
    {
        parent::__construct();
    }

    protected function questionInfo($question_id)
    {
        $this->question_info = Model()->table('circle_theme')->where(array('theme_id' => $question_id))->find();
        if (empty($this->question_info)) {
            output_error("问题不存在");
            die;
        }
    }

    /**
     * GET 所有问答类型
     */
    public function allQuestionTypeOp()
    {
        $circle_id = 0; //问答类型从circle_id 为0 的分类数据中读取
        $where = array();
        $where['circle_id'] = $circle_id;
        $model = Model();
        $m_question_class = $model->table('circle_thclass');
        $question_class_list = $m_question_class->where($where)->select();
        output_data(array('questionClasses' => $question_class_list));
    }

    /**
     * GET 所有问答话题列表
     * type: 5 问专家 6 问达人
     * c_id: 圈子id 不传时默认为0
     */
    public function allQuestionsOp()
    {
        $type = intval($_GET['type']);
        $c_id = intval($_GET['c_id']);
        if ($type > 0) {
            $where = array();
            if ($c_id > 0) {
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
     * GET 问题详情
     */
    public function questionOp()
    {
        // 问题信息
        $question_id = intval($_GET['q_id']);
        if ($question_id > 0) {
            $this->questionInfo($question_id);
            $data = $this->question_info;
            $model = Model();
            // 访问数增加
            $model->table('circle_theme')->update(array('theme_id' => $question_id, 'theme_browsecount' => array('exp', 'theme_browsecount+1')));

            $data['theme_content'] = ubb($data['theme_content']);
            if ($data['theme_edittime'] != '') {
                $data['theme_edittime'] = @date('Y-m-d H:i', $data['theme_edittime']);
            }
            $data['member_avatar'] = getMemberAvatarForID($data['member_id']);

            if (strtoupper(CHARSET) == 'GBK') {
                $data = Language::getUTF8($data);
            }
            output_data(array('questionInfo' => $data));
            die;
        } else {
            output_error("问题id错误");
            die;
        }

    }


    /**
     * GET 问题回复信息（回答）
     */
    public function answersOp()
    {
        $question_id = intval($_GET['q_id']);
        if ($question_id > 0) {
            // 问题信息
            $this->questionInfo($question_id);

            $model = Model();
            // 问题被浏览数增加
            $model->table('circle_theme')->update(array('theme_id' => $question_id, 'theme_browsecount' => array('exp', 'theme_browsecount+1')));

            // 回复列表
            $where = array();
            $where['theme_id'] = $question_id;
            if ($_GET['only_id'] != '') {
                $where['member_id'] = intval($_GET['only_id']);
            }
            $m_reply = $model->table('circle_threply');

            $reply_info = $m_reply->where($where)->page($this->page)->order('reply_id asc')->select();
            $pageCount = $m_reply->gettotalpage();
            $replyid_array = array();
            $memberid_array = array();
            if (!empty($reply_info)) {
                foreach ($reply_info as $val) {
                    $replyid_array[] = $val['reply_id'];
                    $memberid_array[] = $val['member_id'];
                }
                foreach ($reply_info as $key => $val) {
                    $reply_info[$key]['member_avatar'] = getMemberAvatarForID($reply_info[$key]['member_id']);
                }
            }

            $replyid_array[] = 0;
            ksort($replyid_array);
            $memberid_array[] = $this->questionInfo['member_id'];
            $memberid_array = array_unique($memberid_array);
            ksort($memberid_array);

            $where = array();
            $where['theme_id'] = $this->t_id;
            $where['reply_id'] = array('in', $replyid_array);

            // member
            $member_list = $model->table('circle_member')->field('member_id,cm_level,cm_levelname')->where(array('circle_id' => $this->c_id, 'member_id' => array('in', $memberid_array)))->select();
            $member_list = array_under_reset($member_list, 'member_id');

            output_data(array('answers' => $reply_info, 'member_list' => $member_list), mobile_page($pageCount));
        } else {
            output_error("问题id错误");
        }
    }

    /**
     * 用户的问题
     */
    public function userQuestionsOp()
    {
        $types = array(5, 6);
        $u_id = intval($_GET['u_id']);
        $where = array();
        if ($u_id >= 0) {
            $where['member_id'] = $u_id;
        }
        $where['thclass_id'] = array('in',$types);
        $model = Model();
        if (intval($_GET['cream']) == 1) {
            $where['is_digest'] = 1;
        }
        $m_circle_theme = $model->table('circle_theme');
        $question_list = $m_circle_theme->where($where)->order('theme_addtime desc')->page($this->page)->select();
        $pageCount = $m_circle_theme->gettotalpage();
        if (!empty($question_list)) {
            foreach ($question_list as $key => $val) {
                $question_list[$key]['member_avatar'] = getMemberAvatarForID($question_list[$key]['member_id']);
            }
        }
        output_data(array('questions' => $question_list), mobile_page($pageCount));

    }

    /**
     * 用户的回答
     */
    public function userAnswersOp()
    {
        // 回复列表
        $where = array();
        $types = array(5, 6);
        $model = new Model();
        $m_reply = $model->table('circle_threply');
        $where['circle_threply.member_id'] = $_GET['u_id'];
        $where['circle_theme.thclass_id'] = array('in',$types);
        $reply_info = $model->table('circle_threply,circle_theme')->join('right join')->on('circle_threply.theme_id=circle_theme.theme_id')->where($where)->page($this->page)->order('reply_addtime desc')->select();
        $pageCount = $m_reply->gettotalpage();
        if (!empty($reply_info)) {
            foreach ($reply_info as $key => $val) {
                $reply_info[$key]['member_avatar'] = getMemberAvatarForID($reply_info[$key]['member_id']);
            }
        }
        output_data(array('answers' => $reply_info), mobile_page($pageCount));

    }
} 