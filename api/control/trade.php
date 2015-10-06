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

    private $where;

    private $fields = "member_id,member_name,goods_id,goods_name,gc_name,goods_image,goods_tag,
        flea_quality,commentnum,goods_price,goods_store_price,
        goods_click,flea_collect_num,goods_add_time,goods_description,salenum,flea_area_name,
        flea_pname,flea_pphone,goods_status,goods_leixing";

    public function __construct()
    {
        parent::__construct();

        $type = $_GET['type'];
        if ($type == "0") {
            //  转让     交易需通过审核
            $this->where = array('goods_show' => 1, 'goods_status' => 1, 'goods_leixing' => 0);
        } elseif ($type == "1") {
            //  需求
            $this->where = array('goods_show' => 1, 'goods_status' => 1, 'goods_leixing' => 1);
        } else {
            //  默认获取全部
            $this->where = array('goods_show' => 1, 'goods_status' => 1);
        }
    }


    /**
     * GET 所有交易列表
     */
    public function all_trade_listOp()
    {
        $m_trade = Model('utrade');
        $listgoods = $m_trade->field($this->fields)->where($this->where)->order('goods_id desc')->page($this->page)->select();
        $pageCount = $m_trade->gettotalpage();

        if ($listgoods) {
            foreach ($listgoods as $replace_key => $replace_val) {

                $listgoods[$replace_key]['member_avatar'] = getMemberAvatarForID($listgoods[$replace_key]['member_id']);
                $listgoods[$replace_key]['goods_image'] = $listgoods[$replace_key]['goods_image'] == '' ? '' : UPLOAD_SITE_URL . '/' . ATTACH_MALBUM . '/' . $listgoods[$replace_key]['member_id'] . '/' . str_replace('_1024', '_240', $replace_val['goods_image']);

            }
        }
        output_data(array('trade_list' => $listgoods), mobile_page($pageCount));
    }

    /**
     * GET 某分类下的交易
     */
    public function class_trade_listOp()
    {
        
        if ($_GET['cid']!= "") {
            $class_id = $_GET['cid'];
            $where2 = $this->where + array('gc_id' => $class_id);
        }else {
            $where2 = $this->where;
        }
        
        $m_trade = Model('utrade');
        $trade_list = $m_trade->field($this->fields)->where($where2)->order('goods_id desc')->page($this->page)->select();
        $pageCount = $m_trade->gettotalpage();
        if (is_array($trade_list) and !empty($trade_list)) {
            foreach ($trade_list as $key => $val) {
                $trade_list[$key]['member_avatar'] = getMemberAvatarForID($trade_list[$key]['member_id']);
                $trade_list[$key]['goods_image'] = $this->trade_list[$key]['goods_image'] == '' ? '' : UPLOAD_SITE_URL . '/' . ATTACH_MALBUM . '/' . $trade_list[$key]['member_id'] . '/' . str_replace('_1024', '_240', $val['goods_image']);
            }
        } else {
            output_error("没有交易信息");
            die;
        }
        output_data(array('trade_list' => $trade_list), mobile_page($pageCount));
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
        $trade_info = $m_trade->where($where)->order('goods_id desc')->select();
//        $trade_info['goods_image'] = $trade_info['goods_image'] == '' ? '' : UPLOAD_SITE_URL . '/' . ATTACH_MALBUM . '/' . $trade_info['member_id'] . '/' . str_replace('_1024', '_240', $trade_info['goods_image']);
        $trade_info[0]['member_avatar'] = getMemberAvatarForID($trade_info['member_id']);
        $goods_image_path = UPLOAD_SITE_URL.DS.ATTACH_MALBUM.'/'.$trade_info[0]['member_id'].'/';;	//店铺商品图片目录地址
        $desc_image	= $m_trade->getListImageGoods(array('image_store_id'=>$trade_info[0]['member_id'],'item_id'=>$trade_info[0]['goods_id'],'image_type'=>12));
        $m_trade->getThumb($desc_image,$goods_image_path);

        $image_key = 0;
        if(!empty($desc_image) && is_array($desc_image)) {//将封面图放到第一位显示
            $goods_image_1	= $trade_info[0]['goods_image'];//封面图
            foreach ($desc_image as $key => $val) {
                if($goods_image_1 == $val['thumb_small']){
                    $image_key = $key;break;
                }
            }
            if($image_key > 0) {//将封面图放到第一位显示
                $desc_image_0	= $desc_image[0];
                $desc_image[0]	= $desc_image[$image_key];
                $desc_image[$image_key]	= $desc_image_0;
            }
        }

        $trade_info[0]['goods_image'] = $desc_image;

        if (!empty($trade_info)) {
            output_data(array('trade_info' => $trade_info));
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
        $where2 = $this->where + array('member_id' => $member_id);
        $m_trade = Model('utrade');
        $trade_list = $m_trade->field($this->fields)->where($where2)->order('goods_id desc')->page($this->page)->select();
        $pageCount = $m_trade->gettotalpage();
        if (is_array($trade_list) and !empty($trade_list)) {
            foreach ($trade_list as $key => $val) {
                $trade_list[$key]['member_avatar'] = getMemberAvatarForID($trade_list[$key]['member_id']);
                $trade_list[$key]['goods_image'] = $this->trade_list[$key]['goods_image'] == '' ? '' : UPLOAD_SITE_URL . '/' . ATTACH_MALBUM . '/' . $member_id . '/' . str_replace('_1024', '_240', $val['goods_image']);
            }
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
