<?php
/**
 * Demand Op api
 */
defined('InShopNC') or exit('Access Invalid!');

class demand_opControl extends apiMemberControl
{

    private $member_id;

    public function __construct()
    {
        parent::__construct();
        $this->member_id = $this->member_info['member_id'];
    }

    /**
     * POST 收藏需求
     */
    public function favDemandOp()
    {
        /**
         * 读取语言包
         */
        if (intval($_GET['fav_id']) > 0) {
            /**
             * 实例化模型
             */
            $favorites_class = Model('flea_favorites');
            //判断商品,店铺是否为当前会员
            $model_flea = Model('demand');
            $flea_info = $model_flea->listGoods(array(
                'demand_id' => intval($_GET['fav_id'])
            ));
            if ($flea_info[0]['member_id'] == $this->member_id) {
                output_error("不能收藏自己的交易");
                die;
            }

            //闲置物品收藏次数增加1
            $check_rss = $favorites_class->checkFavorites(intval($_GET['fav_id']), 'demand', $this->member_id);
            if (!$check_rss) {
                $condition['flea_collect_num']['value'] = 1;
                $condition['flea_collect_num']['sign'] = 'increase';
                $flea_info = $model_flea->updateDemand($condition, $_GET['fav_id']);
                $add_rs = $favorites_class->addFavorites(array('member_id' => $this->member_id, 'fav_id' => intval($_GET['fav_id']), 'fav_type' => 'demand', 'fav_time' => time()));
                if (!$add_rs) {
                    output_error("收藏失败");
                }
            }
            output_data(array("ok" => "收藏成功"));
        } else {
            output_error("收藏失败");
        }
    }

    /**
     * POST 取消收藏
     */
    public function cancelFavDemandOp()
    {
        if (intval($_GET['fav_id']) > 0) {
            $favorites_class = Model('flea_favorites');
            if (!$favorites_class->delFavorites2(intval($_GET['fav_id']), 'demand', $this->member_id)) {
                output_error("操作失败");
                die;
            }
        }
        output_data("操作成功");
    }

    /**
     * GET 收藏状态
     * fav_id
     */
    public function isFavOp()
    {
        if (intval($_GET['fav_id']) > 0) {
            $mTrade = Model('flea_favorites');
            $status = $mTrade->checkFavorites($_GET['fav_id'], 'demand', $this->member_id);
            if ($status) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
}