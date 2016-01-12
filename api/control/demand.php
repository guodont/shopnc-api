<?php
/**
 * 成果转化 需求 api
 * Created by PhpStorm.
 * User: guodont
 * Date: 16-1-12
 * Time: 上午11:02
 */

defined('InShopNC') or exit('Access Invalid!');

class demandControl extends apiHomeControl
{

    private $where;

    private $fields = "member_id,member_name,demand_id,demand_name,demand_content,demand_budget,demand_click,demand_collect_num,demand_depart_name,demand_add_time,gc_name,gc_id,
        demand_pname,demand_pphone,demand_status,demand_type";

    public function __construct()
    {
        parent::__construct();

        $type = $_GET['type'];
        if ($type == "0") {
            //  转让     需求需通过审核
            $this->where = array('demand_status' => 1, 'demand_type' => 0);
        } elseif ($type == "1") {
            //  需求
            $this->where = array('demand_status' => 1, 'demand_type' => 1);
        } else {
            //  默认获取全部
            $this->where = array('demand_status' => 1);
        }
    }

    /**
     * GET 某分类下的需求
     */
    public function demandsOp()
    {
        if ($_GET['cid'] != "") {
            $class_id = $_GET['cid'];
            $where2 = $this->where + array('gc_id' => $class_id);
        } else {
            $where2 = $this->where;
        }

        $m_demand = Model('demand');
        $demand_list = $m_demand->field($this->fields)->where($where2)->order('demand_id desc,demand_commend desc')->page($this->page)->select();
        $pageCount = $m_demand->gettotalpage();

        $mdemand = Model('flea_favorites');

        if (is_array($demand_list) and !empty($demand_list)) {
            foreach ($demand_list as $key => $val) {

                // 获取收藏状态
                if (isset($_GET['uid'])) {
                    $demand_list[$key]['fav_status'] = $mdemand->checkFavorites($demand_list[$key]['demand_id'], 'demand', $_GET['uid']) ? 1 : 0;
                }
                $demand_list[$key]['member_avatar'] = getMemberAvatarForID($demand_list[$key]['member_id']);
            }
        }
        output_data(array('demands' => $demand_list), mobile_page($pageCount));
    }

    /**
     * 搜索需求
     */
    public function search_demandOp()
    {

        $where2 = $this->where;
        if ($_GET['keyword'] != '') {
            $where2['demand_name|demand_content'] = array('like', '%' . $_GET['keyword'] . '%');
        }
        $m_demand = Model('demand');
        $demand_list = $m_demand->field($this->fields)->where($where2)->order('demand_id desc,demand_commend desc')->page($this->page)->select();
        $pageCount = $m_demand->gettotalpage();

        $mdemand = Model('flea_favorites');

        if (is_array($demand_list) and !empty($demand_list)) {
            foreach ($demand_list as $key => $val) {
                // 获取收藏状态
                if (isset($_GET['uid'])) {
                    $demand_list[$key]['fav_status'] = $mdemand->checkFavorites($demand_list[$key]['demand_id'], 'demand', $_GET['uid']) ? 1 : 0;
                }
                $demand_list[$key]['member_avatar'] = getMemberAvatarForID($demand_list[$key]['member_id']);
            }
        }
        output_data(array('demands' => $demand_list), mobile_page($pageCount));
    }


    /**
     * GET 需求详情
     */
    public function demand_infoOp()
    {
        if (!isset($_GET['tid'])) {
            output_error("缺少id参数");
            die;
        }
        $demand_id = $_GET['tid'];
        $where = array('demand_id' => $demand_id);
        $m_demand = Model('demand');

        $demand_info = $m_demand->where($where)->order('demand_id desc')->select();

        if (intval($_GET['fav_id']) > 0) {
            $favorites_class = Model('flea_favorites');
            if (!$favorites_class->checkFavorites(intval($_GET['fav_id']), 'demand', intval($_GET['user_id']))) {
                $demand_info[0][is_favorite] = false;
            }
        }
        $demand_info[0]['member_avatar'] = getMemberAvatarForID($demand_info['member_id']);
        /**
         * 浏览次数更新
         */
        $m_demand->updateDemand(array('demand_click' => ($demand_info[0]['demand_click'] + 1)), $demand_id);

        output_data(array('demand_info' => $demand_info));
    }

    /**
     * GET 某用户的需求
     */
    public function user_demand_listOp()
    {
        if (!isset($_GET['uid'])) {
            output_error("缺少用户id参数");
            die;
        }
        $member_id = $_GET['uid'];
        $where2 = $this->where + array('member_id' => $member_id);
        $m_demand = Model('demand');
        $demand_list = $m_demand->field($this->fields)->where($where2)->order('demand_id desc')->page($this->page)->select();
        $pageCount = $m_demand->gettotalpage();
        if (is_array($demand_list) and !empty($demand_list)) {
            foreach ($demand_list as $key => $val) {
                $demand_list[$key]['member_avatar'] = getMemberAvatarForID($demand_list[$key]['member_id']);
                $demand_list[$key]['fav_status'] = 0;
            }
        }
        output_data(array('demands' => $demand_list), mobile_page($pageCount));
    }

}
