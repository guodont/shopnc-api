<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 交易管理 语言包
 */

//订单管理
$lang['order_manage']              = '订单管理';
$lang['order_help1']			   = '点击查看操作将显示订单（包括订单物品）的详细信息';
$lang['order_help2']			   = '点击取消操作可以取消订单（在线支付但未付款的订单和货到付款但未发货的订单）';
$lang['order_help3']			   = '如果平台已确认收到买家的付款，但系统支付状态并未变更，可以点击收到货款操作，并填写相关信息后更改订单支付状态';
$lang['manage']                    = '管理';
$lang['store_name']                = '店铺';
$lang['buyer_name']                = '买家';
$lang['payment']                   = '支付方式';
$lang['order_number']              = '订单号';
$lang['order_state']               = '订单状态';
$lang['order_state_new']           = '待付款';
$lang['order_state_pay']           = '待发货';
$lang['order_state_send']          = '待收货';
$lang['order_state_success']       = '已完成';
$lang['order_state_cancel']        = '已取消';
$lang['type']					   = '类型';
$lang['pended_payment']            = '已提交，待确认';//增加
$lang['order_time_from']           = '下单时间';
$lang['order_price_from']          = '订单金额';
$lang['cancel_search']             = '撤销检索';
$lang['order_time']                = '下单时间';
$lang['order_total_price']         = '订单总额';
$lang['order_total_transport']     = '运费';
$lang['miss_order_number']         = '缺少订单编号';

$lang['order_state_paid'] = '已付款';
$lang['order_admin_operator'] = '系统管理员';
$lang['order_state_null'] = '无';
$lang['order_handle_history']	= '操作历史';
$lang['order_admin_cancel'] = '未付款，系统管理员取消订单。';
$lang['order_admin_pay'] = '系统管理员确认收款完成。';
$lang['order_confirm_cancel']	= '您确实要取消该订单吗？';
$lang['order_confirm_received']	= '您确定已经收到货款了吗？';
$lang['order_change_cancel']	= '取消';
$lang['order_change_received']	= '收到货款';
$lang['order_log_cancel']	= '取消订单';

//订单详情
$lang['order_detail']              = '订单详情';
$lang['offer']                     = '优惠了';
$lang['order_info']                = '订单信息';
$lang['seller_name']               = '卖家';
$lang['pay_message']               = '支付留言';
$lang['payment_time']              = '支付时间';
$lang['ship_time']                 = '发货时间';
$lang['complate_time']             = '完成时间';
$lang['buyer_message']             = '买家附言';
$lang['consignee_ship_order_info'] = '收货人及发货信息';
$lang['consignee_name']            = '收货人姓名';
$lang['region']                    = '所在地区';
$lang['zip']                       = '邮政编码';
$lang['tel_phone']                 = '电话号码';
$lang['mob_phone']                 = '手机号码';
$lang['address']                   = '详细地址';
$lang['ship_method']               = '配送方式';
$lang['ship_code']                 = '发货单号';
$lang['product_info']              = '商品信息';
$lang['product_type']              = '促销';
$lang['product_price']             = '单价';
$lang['product_num']               = '数量';
$lang['product_shipping_mfee']     = '免运费';
$lang['nc_promotion']				= '促销活动';
$lang['nc_groupbuy_flag']			= '抢';
$lang['nc_groupbuy']				= '抢购活动';
$lang['nc_groupbuy_view']			= '查看';
$lang['nc_mansong_flag']			= '满';
$lang['nc_mansong']					= '满即送';
$lang['nc_xianshi_flag']			= '折';
$lang['nc_xianshi']					= '限时折扣';
$lang['nc_bundling_flag']			= '组';
$lang['nc_bundling']				= '优惠套装';


$lang['pay_bank_user']			= '汇款人姓名';
$lang['pay_bank_bank']			= '汇入银行';
$lang['pay_bank_account']		= '汇款入账号';
$lang['pay_bank_num']			= '汇款金额';
$lang['pay_bank_date']			= '汇款日期';
$lang['pay_bank_extend']		= '其它';
$lang['pay_bank_order']			= '汇款单号';

$lang['order_refund']			= '退款';
$lang['order_return']			= '退货';

$lang['order_show_system']				= '系统';
$lang['order_show_at']				= '于';
$lang['order_show_cur_state']			= '订单当前状态';
$lang['order_show_next_state']		= '下一状态';
$lang['order_show_reason']			= '原因';