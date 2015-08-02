<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 共有语言
 */

/**
 * 收货人信息
 */
$lang['member_address_receiver_name']	= '收货人';
$lang['member_address_location']		= '所在地区';
$lang['member_address_address']			= '街道地址';
$lang['member_address_zipcode']			= '邮编';
$lang['member_address_phone']			= '电话';
$lang['member_address_mobile']			= '手机';
$lang['member_address_edit_address']	= '编辑地址';
$lang['member_address_no_address']		= '您没有添加收货地址';
$lang['member_address_input_name']		= '请填写您的真实姓名';
$lang['member_address_please_choose']	= '请选择';
$lang['member_address_not_repeat']		= '不必重复填写地区';
$lang['member_address_phone_num']		= '电话号码';
$lang['member_address_area_num']		= '区号';
$lang['member_address_sub_phone']		= '分机';
$lang['member_address_phone']		    = '电话';
$lang['member_address_input_receiver']	= '请填写收货人姓名';
$lang['member_address_choose_location']	= '请选择所在地区';
$lang['member_address_input_address']	= '请填写详细地址';
$lang['member_address_zip_code']		= '邮政编码由6位数字构成';
$lang['member_address_phone_and_mobile']= '固定电话和手机请至少填写一项.';
$lang['member_address_phone_rule']		= '电话号码由数字、加号、减号、空格、括号组成,并不能少于6位. ';
$lang['member_address_wrong_mobile']	= '错误的手机号码';

/**
 * 设置发货地址
 */
$lang['store_daddress_wrong_argument']	= '参数不正确';
$lang['store_daddress_receiver_null']	= '发货人不能为空';
$lang['store_daddress_wrong_area']		= '所在地区选择不正确';
$lang['store_daddress_area_null']		= '所在地区信息不能为空';
$lang['store_daddress_address_null']	= '详细地址不能为空';
$lang['store_daddress_modify_fail']		= '修改地址失败';
$lang['store_daddress_add_fail']		= '新增地址失败';
$lang['store_daddress_del_fail']		= '删除地址失败';
$lang['store_daddress_del_succ']		= '删除成功';
$lang['store_daddress_new_address']		= '新增地址';
$lang['store_daddress_deliver_address']	= '发货地址';
$lang['store_daddress_default']			= '默认';
$lang['store_daddress_receiver_name']	= '联系人';
$lang['store_daddress_location']		= '所在地区';
$lang['store_daddress_address']			= '街道地址';
$lang['store_daddress_zipcode']			= '邮编';
$lang['store_daddress_phone']			= '电话';
$lang['store_daddress_mobile']			= '手机';
$lang['store_daddress_company']			= '公司';
$lang['store_daddress_content']			= '备注';
$lang['store_daddress_edit_address']	= '编辑地址';
$lang['store_daddress_no_address']		= '您没有添加发货地址';
$lang['store_daddress_input_name']		= '请填写您的真实姓名';
$lang['store_daddress_please_choose']	= '请选择';
$lang['store_daddress_not_repeat']		= '不必重复填写地区';
$lang['store_daddress_phone_num']		= '电话';
$lang['store_daddress_area_num']		= '区号';
$lang['store_daddress_sub_phone']		= '分机';
$lang['store_daddress_mobile_num']		= '手机号码';
$lang['store_daddress_input_receiver']	= '请填写联系人姓名';
$lang['store_daddress_choose_location']	= '请选择所在地区';
$lang['store_daddress_input_address']	= '请填写街道地址';
$lang['store_daddress_zip_code']		= '邮政编码由6位数字构成';
$lang['store_daddress_phone']	        = '电话';
$lang['store_daddress_phone_rule']		= '电话号码由数字、加号、减号、空格、括号组成,并不能少于6位. ';
$lang['store_daddress_wrong_mobile']	= '错误的手机号码';

/**
 * 设置物流公司
 */
$lang['store_deliver_express_title']	= '物流公司';

/**
 * 发货
 */
$lang['store_deliver_order_state_send']		= '已发货';
$lang['store_deliver_order_state_receive']	= '待收货';
// $lang['store_deliver_modfiy_address']		= '修改收货信息';
$lang['store_deliver_select_daddress']		= '选择发货地址';
$lang['store_deliver_select_ather_daddress']= '选择其它发货地址';
$lang['store_deliver_daddress_list']		= '地址库';
$lang['store_deliver_default_express']		= '默认物流公司';
$lang['store_deliver_buyer_name']			= '买家';
$lang['store_deliver_buyer_address']		= '收货地址';
$lang['store_deliver_shipping_amount']		= '运费';
$lang['store_deliver_modify_info']			= '编辑发货';
$lang['store_deliver_first_step']			= '第一步';
$lang['store_deliver_second_step']			= '第二步';
$lang['store_deliver_third_step']			= '第三步';
$lang['store_deliver_confirm_trade']		= '确认收货信息及交易详情';
$lang['store_deliver_forget']				= '发货备忘';
$lang['store_deliver_forget_tips']			= '您可以输入一些发货备忘信息（仅卖家自己可见）';
$lang['store_deliver_buyer_adress']			= '收货人信息';
$lang['store_deliver_confirm_daddress']		= '确认发货信息';
$lang['store_deliver_my_daddress']			= '我的发货信息';
$lang['store_deliver_none_set']				= '还未设置发货地址，请进入发货设置 > 地址库中添加';
$lang['store_deliver_add_daddress']			= '添加发货地址';
$lang['store_deliver_express_select']		= '选择物流服务';
$lang['store_deliver_express_note']			= '您可以通过"发货设置-><a href="index.php?act=store_deliver_set&op=express" target="_parent" >默认物流公司</a>"添加或修改常用货运物流。免运或自提商品可切换下方<span class="red">[无需物流运输服务]</span>选项卡并操作。';
$lang['store_deliver_express_zx']			= '自行联系物流公司';
$lang['store_deliver_express_wx']			= '无需物流运输服务';
$lang['store_deliver_company_name']			= '公司名称';
$lang['store_deliver_shipping_code']		= '物流单号';
$lang['store_deliver_bforget']				= '备忘';
$lang['store_deliver_shipping_code_tips']	= '正确填写物流单号，确保快递跟踪查询信息正确';
$lang['store_deliver_no_deliver_tips']		= '如果订单中的商品无需物流运送，您可以直接点击确认';
$lang['store_deliver_shipping_code_pl']		= '请填写物流单号';

/**
 * 选择发货地址
 */
$lang['store_deliver_man']			= '发货人';
$lang['store_deliver_daddress']		= '发货地址';
$lang['store_deliver_telphone']		= '电话';

/**
 * 搜索动态物流
 */
$lang['member_show_expre_my_fdback']		= '我的留言';
$lang['member_show_expre_type']				= '发货方式：自行联系';
$lang['member_show_expre_company']			= '物流公司';
$lang['member_show_receive_info']			= '收货信息';
$lang['member_show_deliver_info']			= '发货信息';