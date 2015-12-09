<?php
/**
 * 我的代金券
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */


defined('InShopNC') or exit('Access Invalid!');

class member_voucherControl extends apiMemberControl
{

    public function __construct()
    {
        parent::__construct();
    }


    public function voucher_listOp()
    {
        $model_voucher = Model('voucher');
        $voucher_list = $model_voucher->getMemberVoucherList($this->member_info['member_id'], trim($_GET['voucher_state']), $this->page);
        $page_count = $model_voucher->gettotalpage();
        output_data(array('myVouchers' => $voucher_list), mobile_page($page_count));
    }
}
