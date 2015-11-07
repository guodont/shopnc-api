<?php
/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15/9/14
 * Time: 上午9:28
 */

defined('InShopNC') or exit('Access Invalid!');

class circle_manageControl extends apiMemberControl
{

    /**
     * circle_manageControl constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 创建圈子
     */
    public function createCircleOp()
    {
        if (!intval(C('circle_iscreate'))) {
            output_error("创建圈子功能已关闭");
        }
        $model = Model();
        // 在验证
        // 允许创建圈子验证
        $where = array();
        $where['circle_masterid'] = $this->member_info['member_id'];
        $create_count = $model->table('circle')->where($where)->count();
        if (intval($create_count) >= C('circle_createsum'))

            output_error("您创建圈子数量已达上限！");

        // 允许加入圈子验证
        $where = array();
        $where['member_id'] = $this->member_info['member_id'];
        $join_count = $model->table('circle_member')->where($where)->count();
        if (intval($join_count) >= C('circle_joinsum'))
            output_error("不允许加入圈子");

        if (isset($_POST)) {
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["c_name"], "require" => "true", "message" => "请输入圈子名称")
            );
            $error = $obj_validate->validate();
            if ($error != '') {
                output_error($error);
            } else {
                $insert = array();
                $insert['circle_name'] = $_POST['c_name'];
                $insert['circle_masterid'] = $this->member_info['member_id'];
                $insert['circle_mastername'] = $this->member_info['member_name'];
                $insert['circle_desc'] = $_POST['c_desc'];
                $insert['circle_tag'] = $_POST['c_tag'];
                $insert['circle_pursuereason'] = $_POST['c_pursuereason'];
                $insert['circle_status'] = 2;
                $insert['is_recommend'] = 0;
                $insert['class_id'] = intval($_POST['class_id']);
                $insert['circle_addtime'] = time();
                $insert['circle_mcount'] = 1;
                $result = $model->table('circle')->insert($insert);
                if ($result) {
                    // Membership level information
                    $data = rkcache('circle_level') ? rkcache('circle_level') : rkcache('circle_level', true);

                    // 把圈主信息加入圈子会员表
                    $insert = array();
                    $insert['member_id'] = $this->member_info['member_id'];
                    $insert['circle_id'] = $result;
                    $insert['circle_name'] = $_POST['c_name'];
                    $insert['member_name'] = $this->member_info['member_name'];
                    $insert['cm_applytime'] = $insert['cm_jointime'] = time();
                    $insert['cm_state'] = 1;
                    $insert['cm_level'] = $data[1]['mld_id'];
                    $insert['cm_levelname'] = $data[1]['mld_name'];
                    $insert['cm_exp'] = 1;
                    $insert['cm_nextexp'] = $data[2]['mld_exp'];
                    $insert['is_identity'] = 1;
                    $insert['cm_lastspeaktime'] = '';
                    $model->table('circle_member')->insert($insert);

                    output_data(array("ok" => "圈子创建申请成功，等待管理员审核"));
                } else {
                    output_error("圈子创建申请失败！");
                }
            }
        } else {
            output_error("请求错误");
        }
    }
}