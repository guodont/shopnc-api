<?php
/**
 * 积分中心展示，非个人API
 *
 **/

defined('InShopNC') or exit('Access Invalid!');

class point_shopControl extends apiHomeControl
{

    public function __construct()
    {
        parent::__construct();
    }

    public function recommend_prodOp()
    {
        //开启积分兑换功能后查询推荐的热门兑换商品列表
        if (C('pointprod_isuse') == 1){
            //热门积分兑换商品
            $recommend_pointsprod = Model('pointprod')->getRecommendPointProd(10);
            output_data(array('gifts' => $recommend_pointsprod));
        }else {
            output_error("并没有开启积分兑换");
            die;
        }
    }

    public function recommend_voucherOp()
    {
        //开启代金券功能后查询推荐的热门代金券列表
        if (C('voucher_allow') == 1){
            $recommend_voucher = Model('voucher')->getRecommendTemplate(6);
            output_data(array('vouchers' => $recommend_voucher));
        } else {
            output_error("并没有开启代金券功能");
            die;
        }
    }

}
