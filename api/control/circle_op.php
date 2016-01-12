<?php
/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15-8-25
 * Time: 下午12:18
 */


defined('InShopNC') or exit('Access Invalid!');

class circle_opControl extends apiBaseCircleControl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * GET 验证会员身份
     */
    public function identifyCircleMemberOp()
    {
        // 身份	0游客 1圈主 2管理 3成员 4申请中 5申请失败 6禁言
        $this->memberInfo();
        echo $this->identity;
    }



    /**
     * POST 创建一个话题
     */
    public function create_themeOp()
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
            // 会员信息
            $this->memberInfo();

            // 不是圈子成员不能发帖
            if (!in_array($this->identity, array(1, 2, 3))) {
                output_error(L('circle_no_join_ban_release'), array('code' => 502));
            }

            $model = Model();

            // 主题分类 默认为0
            $thclass_id = intval($_POST['thtype']);
            $thclass_name = '';
            if ($thclass_id > 0) {
                $thclass_info = $model->table('circle_thclass')->find($thclass_id);
                $thclass_name = $thclass_info['thclass_name'];
            }
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["name"], "require" => "true", "message" => '话题名称不能为空'),
                array("input" => $_POST["name"], "validator" => 'Length', "min" => 4, "max" => 45, "message" => '名称长度不符合要求'),
                array("input" => $_POST["themecontent"], "require" => "true", "message" => '话题内容不能为空'),
                array("input" => $_POST["themecontent"], "validator" => 'Length', "min" => 4, "max" => 2500, "message" => '内容长度不符合要求'),
            );
            $error = $obj_validate->validate();
            if ($error != '') {
                output_error($error);
                die;
            }
            $insert = array();
            $insert['theme_name'] = circleCenterCensor($_POST['name']);
            $insert['theme_content'] = circleCenterCensor($_POST['themecontent']);
            $insert['circle_id'] = $this->c_id;
            $insert['circle_name'] = $this->circle_info['circle_name'];
            $insert['thclass_id'] = $thclass_id;
            $insert['thclass_name'] = $thclass_name;
            $insert['member_id'] = $this->member_info['member_id'];
            $insert['member_name'] = $this->member_info['member_name'];
            $insert['is_identity'] = $this->identity;
            $insert['theme_addtime'] = time();
            $insert['lastspeak_time'] = time();
            $insert['theme_readperm'] = intval($_POST['readperm']);
            $insert['theme_special'] = intval($_GET['sp']);
            $themeid = $model->table('circle_theme')->insert($insert);
            if ($themeid) {
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
                $param['exp_memberid'] = $this->member_info['member_id'];
                $param['exp_membername'] = $this->member_info['member_name'];
                Model('exppoints')->saveExppointsLog('release', $param, true);

                $data['id'] = $themeid;
                $data['url'] = $theme_url = CIRCLE_SITE_URL . '/index.php?act=theme&op=theme_detail&c_id=' . $this->c_id . '&t_id=' . $themeid;
                output_data(array('ok' => $data));
            } else {
                output_error("创建失败");
            }
        }
        output_error('request error');
    }


    /**
     * 申请加入
     */
    public function applyOp()
    {
        // 会员信息
        $this->memberInfo();
        // 圈子信息
        $this->circleInfo();

        if (in_array($this->identity, array(1, 2, 3, 4))) {
            output_error("您没有权限");
        }
        if (isset($_POST)) {
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["apply_content"], "require" => "true", "message" => "申请原因不能为空"),
                array("input" => $_POST["intro"], "require" => "true", "message" => "未填写个人介绍"),
            );
            $error = $obj_validate->validate();
            if ($error != '') {
                output_error($error);
            } else {
                // Membership level information
                $data = rkcache('circle_level') ? rkcache('circle_level') : rkcache('circle_level', true);

                $model = Model();
                $insert = array();
                $insert['cm_applycontent'] = $_POST['apply_content'];
                $insert['cm_intro'] = $_POST['intro'];
                $insert['member_id'] = $this->member_info['member_id'];
                $insert['circle_id'] = $this->c_id;
                $insert['circle_name'] = $this->circle_info['circle_name'];
                $insert['member_name'] = $this->member_info['member_name'];
                $insert['cm_applytime'] = $insert['cm_jointime'] = time();
                $insert['cm_level'] = $data[1]['mld_id'];
                $insert['cm_levelname'] = $data[1]['mld_name'];
                $insert['cm_exp'] = 1;
                $insert['cm_nextexp'] = $data[2]['mld_exp'];
                $insert['cm_state'] = intval($this->circle_info['circle_joinaudit']) == 0 ? 1 : 0;
                if (intval($this->circle_info['circle_joinaudit']) == 0) {
                    // Update the number of members
                    $insert['is_identity'] = 4;
                    $model->table('circle_member')->insert($insert, true);
                    $update = array(
                        'circle_id' => $this->c_id,
                        'circle_mcount' => array('exp', 'circle_mcount+1')
                    );
                    $model->table('circle')->update($update);
                    output_data(array('ok' => "已提交申请,等待圈主审核"));
                } else {
                    $insert['is_identity'] = 3;
                    $model->table('circle_member')->insert($insert, true);
                    // Update is applying for membership
                    $update = array(
                        'circle_id' => $this->c_id,
                        'new_verifycount' => array('exp', 'new_verifycount+1')
                    );
                    $model->table('circle')->update($update);
                    output_data(array('ok' => "加入圈子成功"));
                }
            }
        }
    }

    /**
     * 退出圈子
     */
    public function quitOp()
    {
        // 圈子信息
        $this->circleInfo();
        // 会员信息
        $this->memberInfo();
        if (in_array($this->identity, array(2, 3))) {
            // 删除会员
            Model()->table('circle_member')->where(array('circle_id' => $this->c_id, 'member_id' => $this->member_info['member_id']))->delete();

            $update = array();
            $update['circle_id'] = $this->c_id;
            $update['circle_mcount'] = array('exp', 'circle_mcount-1');

            // Whether to apply for management
            $rs = Model()->table('circle_mapply')->where(array('circle_id' => $this->c_id, 'member_id' => $this->member_info['member_id']))->find();
            if ($rs) {
                Model()->table('circle_mapply')->where(array('circle_id' => $this->c_id, 'member_id' => $this->member_info['member_id']))->delete();
                $update['new_mapplycount'] = array('exp', 'new_mapplycount-1');
            }

            // 更新圈子成员数
            Model()->table('circle')->update($update);
        }
        output_data(array('ok' => "成功退出圈子"));
    }
}
