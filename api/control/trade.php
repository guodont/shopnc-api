<?php
/**
 * 交易（闲置）api
 * Created by PhpStorm.
 * User: guodont
 * Date: 15-8-4
 * Time: 上午11:02
 */

defined('InShopNC') or exit('Access Invalid!');

class tradeControl extends apiHomeControl
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * GET 所有交易列表
     */
    public function all_trade_listOp()
    {

        $where = array('goods_show' => 1);
        $fields = "member_id,member_name,goods_id,goods_name,gc_name,goods_image,goods_tag,
        flea_quality,commentnum,goods_price,goods_store_price,
        goods_click,flea_collect_num,goods_add_time,goods_description,salenum,flea_area_name";
        $m_trade = Model('utrade');
        $listgoods = $m_trade->field($fields)->where($where)->order('goods_id desc')->page($this->page)->select();
        $pageCount = $m_trade->gettotalpage();
        if ($listgoods) {
            foreach ($listgoods as $replace_key => $replace_val) {

                $listgoods[$replace_key]['member_avatar'] = getMemberAvatarForID($listgoods[$replace_key]['member_id']);
            }
        } else {
            output_error("暂无交易");
        }
        output_data(array('trade_list' => $listgoods), mobile_page($pageCount));
    }

    /**
     * GET 某分类下的交易
     */
    public function class_trade_list(){
        if (!isset($_GET['cid'])) {
            output_error("缺少分类id参数");
            die;
        }
        $class_id = $_GET['cid'];
        $where = array('gc_id' => $class_id);
        $fields = "member_id,member_name,goods_id,goods_name,gc_name,goods_image,goods_tag,
        flea_quality,commentnum,goods_price,goods_store_price,
        goods_click,flea_collect_num,goods_add_time,goods_description,salenum,flea_area_name";
        $m_trade = Model('utrade');
        $trade_list = $m_trade->field($fields)->where($where)->order('goods_id desc')->page($this->page)->select();
        $pageCount = $m_trade->gettotalpage();
        if (is_array($trade_list) and !empty($trade_list)) {
            foreach ($trade_list as $key => $val) {
                $trade_list[$key]['goods_image'] = $this->trade_list[$key]['goods_image'] == '' ? '' : UPLOAD_SITE_URL . '/' . ATTACH_MALBUM . '/' . $member_id . '/' . str_replace('_1024', '_240', $val['goods_image']);
            }
        } else {
            output_error("没有交易信息");
            die;
        }
        output_data(array('trades' => $trade_list), mobile_page($pageCount));
    }


    /**
     * GET 交易详情
     */
    public function trade_infoOp()
    {
        if (!isset($_GET['tid'])) {
            output_error("缺少交易id参数");
            die;
        }
        $trade_id = $_GET['tid'];
        $where = array('goods_id' => $trade_id);
        $m_trade = Model('utrade');
        $trade_info = $m_trade->where($where)->order('goods_id desc')->page($this->page)->select();
        $pageCount = $m_trade->gettotalpage();
        if (!empty($trade_info)) {
            output_data(array('trade_info' => $trade_info), mobile_page($pageCount));
        } else {
            output_error("没有此交易");
        }
    }

    /**
     * GET 用户的交易
     */
    public function user_trade_listOp()
    {
        if (!isset($_GET['uid'])) {
            output_error("缺少用户id参数");
            die;
        }
        //TODO 查找uid是否存在，不存在则输出错误信息
        $member_id = $_GET['uid'];
        $where = array('member_id' => $member_id);
        $fields = "member_id,member_name,goods_id,goods_name,gc_name,goods_image,goods_tag,
        flea_quality,commentnum,goods_price,goods_store_price,
        goods_click,flea_collect_num,goods_add_time,goods_description,salenum,flea_area_name";
        $m_trade = Model('utrade');
        $trade_list = $m_trade->field($fields)->where($where)->order('goods_id desc')->page($this->page)->select();
        $pageCount = $m_trade->gettotalpage();
        if (is_array($trade_list) and !empty($trade_list)) {
            foreach ($trade_list as $key => $val) {
                $trade_list[$key]['goods_image'] = $this->trade_list[$key]['goods_image'] == '' ? '' : UPLOAD_SITE_URL . '/' . ATTACH_MALBUM . '/' . $member_id . '/' . str_replace('_1024', '_240', $val['goods_image']);
            }
        } else {
            output_error("没有交易信息");
            die;
        }
        output_data(array('trades' => $trade_list), mobile_page($pageCount));
    }

    /**
     * 时间处理方法
     * @param $goods_add_time
     * @return string
     */
    private function time_comb($goods_add_time)
    {
        $now_time = time();
        $last_time = $now_time - $goods_add_time;
        if ($last_time > 2592000) return intval($last_time / 2592000) . "个月前";
        if ($last_time > 86400) return intval($last_time / 86400) . "天前";
        if ($last_time > 3600) return intval($last_time / 3600) . "小时前";
        if ($last_time > 60) return intval($last_time / 60) . "分钟前";
        return $last_time . "秒前";
    }

}