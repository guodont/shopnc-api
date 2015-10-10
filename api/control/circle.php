<?php
/**
 * 圈子api
 * Created by PhpStorm.
 * User: guodont
 * Date: 15-8-4
 * Time: 上午11:02
 */

defined('InShopNC') or exit('Access Invalid!');

class circleControl extends apiHomeControl
{


    public function __construct()
    {
        parent::__construct();
        /**
         * 验证圈子是否开启
         */
        if (C('circle_isuse') != '1') {
            @header('location: ' . SHOP_SITE_URL);
            die;
        }
    }

    /**
     * GET 所有圈子分类
     */
    public function classOp()
    {
        $model = Model();
        $class_list = $model->table('circle_class')->where(array('class_status' => 1, 'is_recommend' => 1))->order('class_sort asc')->select();
        output_data(array('circle_classes' => $class_list));
    }

    /**
     * GET 圈子搜索
     */
    public function groupOp()
    {
        $model = Model();
        $where = array();
        $where['circle_status'] = 1;
        if ($_GET['keyword'] != '') {
            $where['circle_name|circle_tag'] = array('like', '%' . $_GET['keyword'] . '%');
        }
        if (intval($_GET['class_id']) > 0) {
            $where['class_id'] = intval($_GET['class_id']);
        }
        $m_circle = $model->table('circle');

        $circle_list = $m_circle->where($where)->page($this->page)->select();
        $pageCount = $m_circle->gettotalpage();
        output_data(array('circles' => $circle_list), mobile_page($pageCount));
    }

    /**
     * GET 话题搜索
     */

    public function themeOp()
    {
        $model = Model();
        $where = array();
        if ($_GET['keyword'] != '') {
            $where['theme_name'] = array('like', '%' . $_GET['keyword'] . '%');
        }
        $m_theme = $model->table('circle_theme');
        $theme_list = $m_theme->where($where)->order('theme_addtime desc')->page($this->page)->select();
        $pageCount = $m_theme->gettotalpage();
        output_data(array('themes' => $theme_list), mobile_page($pageCount));
    }

    /**
     * GET 圈子详情
     */

    public function circleInfoOp()
    {
        $c_id = $_GET['circle_id'];
        if ($c_id != '' && $c_id > 0) {
            $circle_info = Model()->table('circle')->find($c_id);
            if (empty($circle_info)) {
                output_error("圈子不存在");
                die;
            }
            //圈主和管理员信息
            $prefix = 'circle_managelist';
            $manager_list = rcache($this->c_id, $prefix);
            if (empty($manager_list)) {
                $manager_list = Model()->table('circle_member')->where(array('circle_id' => $this->c_id, 'is_identity' => array('in', array(1, 2))))->page($this->page)->select();
                $manager_list = array_under_reset($manager_list, 'is_identity', 2);
                $manager_list[2] = array_under_reset($manager_list[2], 'member_id', 1);
                wcache($this->c_id, $manager_list, $prefix);
            }
            $circle_info['circle_masteravatar'] = getMemberAvatarForID($circle_info['circle_masterid']);
            output_data(array('circle_info' => $circle_info,
                'creator' => $manager_list[1][0],
                'manager_list' => $manager_list[2]
            ));
        } else {
            output_error("圈子id错误");
            die;
        }
    }


    /**
     * GET 圈子所有话题
     */
    public function circleThemesOp()
    {
        $c_id = $_GET['circle_id'];
        if ($c_id != '' && $c_id > 0) {
            $model = Model();
            // 话题列表
            $where = array();
            $where['circle_id'] = $c_id;
            $thc_id = intval($_GET['thc_id']);
            if ($thc_id > 0) {
                $where['thclass_id'] = $thc_id;
            }
            if (intval($_GET['cream']) == 1) {
                $where['is_digest'] = 1;
            }

            $where['is_stick'] = 0;
            $m_circle_theme = $model->table('circle_theme');

            $theme_list = $m_circle_theme->where($where)->order('lastspeak_time desc')->page($this->page)->select();
            $pageCount = $m_circle_theme->gettotalpage();
            if (!empty($theme_list)) {
                foreach ($theme_list as $key => $val) {
                    $theme_list[$key]['member_avatar'] = getMemberAvatarForID($theme_list[$key]['member_id']);
                }
            }
            output_data(array('themes' => $theme_list), mobile_page($pageCount));
        } else {
            output_error("圈子id错误");
            die;
        }
    }

    /**
     * GET 圈子置顶帖
     */
    public function circleStickThemesOp()
    {
        $c_id = $_GET['circle_id'];
        if ($c_id != '' && $c_id > 0) {
            $model = Model();
            // 话题列表
            $where = array();
            $where['circle_id'] = $c_id;
            $thc_id = intval($_GET['thc_id']);
            if ($thc_id > 0) {
                $where['thclass_id'] = $thc_id;
            }
            if (intval($_GET['cream']) == 1) {
                $where['is_digest'] = 1;
            }
            $where['is_stick'] = 1; //置顶帖
            $m_circle_theme = $model->table('circle_theme');
            $theme_list = $m_circle_theme->where($where)->order('is_stick desc,lastspeak_time desc')->page($this->page)->select();
            $pageCount = $m_circle_theme->gettotalpage();
            if (!empty($theme_list)) {
                foreach ($theme_list as $key => $val) {
                    $theme_list[$key]['member_avatar'] = getMemberAvatarForID($theme_list[$key]['member_id']);
                }
            }
            output_data(array('themes' => $theme_list), mobile_page($pageCount));
        } else {
            output_error("圈子id错误");
            die;
        }
    }


    /**
     * GET 推荐话题
     */
    public function get_theme_listOp()
    {
        $model = Model();
        $m_theme = $model->table('circle_theme');
        $theme_list = $m_theme->field('*, is_recommend*rand()*10000 + has_affix*rand() as rand')->where(array('circle_status' => 1, 'is_closed' => 0, 'has_affix' => 0))->page($this->page)->order('rand,theme_addtime desc')->select();
        $pageCount = $m_theme->gettotalpage();
        if (!empty($theme_list)) {
            $themeid_array = array_keys($theme_list);
            // 附件
            $affix_list = $model->table('circle_affix')->where(array('theme_id' => array('in', $themeid_array), 'affix_type' => 1))->group('theme_id')->select();
            if (!empty($affix_list)) $affix_list = array_under_reset($affix_list, 'theme_id');
            foreach ($theme_list as $key => $val) {
                if (isset($affix_list[$val['theme_id']])) $theme_list[$key]['affix'] = themeImageUrl($affix_list[$val['theme_id']]['affix_filethumb']);
                $theme_list[$key]['member_avatar'] = getMemberAvatarForID($theme_list[$key]['member_id']);
            }
        }

        output_data(array('themes' => $theme_list), mobile_page($pageCount));
    }

    /**
     * GET 人气话题
     */
    public function get_reply_themelistOp()
    {

        $model = Model();
        $m_theme = $model->table('circle_theme');

        $reply_themelist = $m_theme->where(array('is_closed' => 0))->order('theme_commentcount desc')->page($this->page)->select();
        $pageCount = $m_theme->gettotalpage();
        foreach ($reply_themelist as $key => $val) {
            $reply_themelist[$key]['member_avatar'] = getMemberAvatarForID($reply_themelist[$key]['member_id']);
        }

        output_data(array('themes' => $reply_themelist), mobile_page($pageCount));
    }


}