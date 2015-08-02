<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 导航及全局
 */
$lang['adv_index_manage']	= '广告管理';
$lang['adv_manage']	= '广告';
$lang['adv_add']	= '新增广告';
$lang['ap_manage']	= '广告位';
$lang['ap_add']	    = '新增广告位';
$lang['adv_change']	= '修改广告';
$lang['ap_change']	= '修改广告位';
$lang['adv_pic']	= '图片';
$lang['adv_word']	= '文字';
$lang['adv_slide']	= '幻灯';
$lang['adv_edit']	= '编辑';
$lang['adv_change']	= '修改';
$lang['adv_pix']	= '像素';
$lang['adv_edit_support'] = '系统支持的图片格式为:';
$lang['adv_cache_refresh'] = '清理缓存';
$lang['adv_cache_refresh_done'] = '广告缓存清理完毕';
/**
 * 广告
 */
$lang['adv_name']	         = '广告名称';
$lang['adv_ap_id']	         = '所属广告位';
$lang['adv_class']	         = '类别';
$lang['adv_start_time']	     = '开始时间';
$lang['adv_end_time']	     = '结束时间';
$lang['adv_all']	         = '全部';
$lang['adv_overtime']	     = '已过期';
$lang['adv_not_overtime']	 = '未过期';
$lang['adv_img_upload']	     = '图片上传';
$lang['adv_url']	         = '链接地址';
$lang['adv_url_donotadd']	 = '链接地址请不要加http://';
$lang['adv_word_content']	 = '文字内容';
$lang['adv_max']	         = '最多';
$lang['adv_byte']	         = '个字';
$lang['adv_slide_upload']	 = '幻灯片图片上传';
$lang['adv_slide_sort']	     = '幻灯片排序';
$lang['adv_slide_sort_role'] = '数字越小排序越靠前';
$lang['adv_ap_select']       = '选择广告位';
$lang['adv_search_from']     = '发布时间';
$lang['adv_search_to']	     = '到';
$lang['adv_click_num']	     = '点击数ˇ';
$lang['adv_admin_add']	     = '管理员添加';
$lang['adv_owner']	         = '广告主';
$lang['adv_wait_check']	     = '待审核广告';
$lang['adv_flash_upload']	 = 'Flash文件上传';
$lang['adv_please_upload_swf_file']	 = '请上传swf格式文件';
$lang['adv_help1']			 = '添加广告时，需要指定所属广告位';
$lang['adv_help2']			 = '将广告位调用代码放入前台页面，将显示该广告位的广告';
$lang['adv_help3']			 = '店主可使用金币购买广告';
$lang['adv_help4']			 = '审核店主购买的广告';
$lang['adv_help5']			 = '点击查看，在详细页可进行审核操作';

/**
 * 广告位
 */
$lang['ap_name']	         = '名称';
$lang['ap_intro']	         = '简介';
$lang['ap_class']	         = '类别';
$lang['ap_show_style']	     = '展示方式';
$lang['ap_width']	         = '宽度/字数';
$lang['ap_height']	         = '高度';
$lang['ap_price']	         = '单价(金币/月)';
$lang['ap_show_num']	     = '正在展示';
$lang['ap_publish_num']	     = '已发布';
$lang['ap_is_use']	         = '是否启用';
$lang['ap_slide_show']	     = '幻灯片轮播';
$lang['ap_mul_adv']	         = '多广告展示';
$lang['ap_one_adv']	         = '单广告展示';
$lang['ap_use']	             = '已启用';
$lang['ap_not_use']	         = '未启用';
$lang['ap_get_js']	         = '代码调用';
$lang['ap_use_s']	         = '启用';
$lang['ap_not_use_s']	     = '不启用';
$lang['ap_price_name']	     = '单价';
$lang['ap_price_unit']	     = '枚金币/月';
$lang['ap_allow_mul_adv']	 = '可以发布多条广告并随机展示';
$lang['ap_allow_one_adv']	 = '只允许发布并展示一条广告';
$lang['ap_width_l']	         = '宽度';
$lang['ap_height_l']	     = '高度';
$lang['ap_word_num']	     = '字数';
$lang['ap_select_showstyle'] = '选择此广告位广告的形式';
$lang['ap_click_num']	     = '点击数';
$lang['ap_help1']			 = '广告位添加完成后可以选择是否启用广告位';
/**
 * 提示信息
 */
$lang['adv_can_not_null']	    = '名称不能为空';
$lang['must_select_ap']	        = '必须选择一个广告位';
$lang['must_select_start_time'] = '必须选择开始时间';
$lang['must_select_end_time']	= '必须选择结束时间';
$lang['must_select_ap_id']		= '请选择广告位';
$lang['textadv_null_error']		= '请添加文字内容';
$lang['slideadv_null_error']	= '请上传幻灯片图片';
$lang['slideadv_sortnull_error']	= '请添加幻灯片排序';
$lang['flashadv_null_error']	= '请上传FLASH文件';
$lang['picadv_null_error']		= '请上传图片';
$lang['wordadv_toolong']	    = '广告的文字信息过长';
$lang['goback_adv_manage']	    = '返回广告管理';
$lang['resume_adv_add']	        = '继续添加广告';
$lang['resume_ap_add']	        = '继续添加广告位';
$lang['adv_add_succ']	        = '添加成功';
$lang['adv_add_fail']	        = '添加失败';
$lang['ap_add_succ']	        = '添加成功';
$lang['ap_add_fail']	        = '广告位添加失败';
$lang['goback_ap_manage']	    = '返回广告位管理';
$lang['ap_stat_edit_fail']	    = '广告位状态修改失败';
$lang['ap_del_fail']	        = '删除广告位失败';
$lang['ap_del_succ']	        = '广告位成功删除，请即时处理相关模板的广告位js调用';
$lang['adv_del_fail']	        = '删除广告失败';
$lang['adv_del_succ']	        = '广告成功删除';
$lang['ap_can_not_null']	    = '广告位名称不能为空';
$lang['adv_url_can_not_null']	    = '广告链接地址不能为空';
$lang['ap_price_can_not_null']	= '广告位价格不能为空';
$lang['ap_input_digits_pixel']		= '请输入像素值(正整数)';
$lang['ap_input_digits_words']		= '请输入文字个数(正整数)';
$lang['ap_default_word_can_not_null'] = '默认文字不能为空';
$lang['adv_start_time_can_not_null']	= '广告开始时间不能为空';
$lang['adv_end_time_can_not_null']	= '广告结束时间不能为空';
$lang['ap_w&h_can_not_null']	= '广告位宽度和高度不能为空';
$lang['ap_display_can_not_null']	= '广告位展示方式必须选择';
$lang['ap_wordnum_can_not_null']	= '广告位字数不能为空';
$lang['ap_price_must_num']	    = '广告位价格只能为数字形式';
$lang['ap_width_must_num']	    = '广告位宽度只能为数字形式';
$lang['ap_wordwidth_must_num']	= '广告位字数只能为数字形式';
$lang['ap_height_must_num']	    = '广告位高度只能为数字形式';
$lang['ap_change_succ']	        = '广告位信息修改成功';
$lang['ap_change_fail']	        = '广告位信息修改失败';
$lang['adv_change_succ']	    = '广告信息修改成功';
$lang['adv_change_fail']	    = '广告信息修改失败';
$lang['adv_del_sure']	        = '您确定要删除所选广告的所有信息吗';
$lang['ap_del_sure']	        = '您确定要删除所选广告位的所有信息吗';
$lang['default_word_can_not_null'] = '广告位默认文字不能位空';
$lang['default_pic_can_not_null']  = '广告位默认图片必须上传';
$lang['must_input_all']  = '(请务必填写所有的内容后再提交!)';
$lang['adv_index_copy_to_clip']	= '请将JavaScript或PHP代码复制并粘贴到对应模板文件中！';

$lang['check_adv_submit']  = '审核广告申请';
$lang['check_adv_yes']     = '审核通过';
$lang['check_adv_no']      = '不通过';
$lang['check_adv_no2']     = '未通过';
$lang['check_adv_type']    = '类型';
$lang['check_adv_buy']     = '购买';
$lang['check_adv_order']   = '预订';
$lang['check_adv_change']  = '修改内容';
$lang['check_adv_view']    = '查看';
$lang['check_adv_nothing'] = '目前没有待审核的广告';
$lang['check_adv_chart']   = '广告点击率统计图';
$lang['adv_chart_searchyear_input']  = ' 输入查询年份:';
$lang['adv_chart_year']    = '年';
$lang['adv_chart_years_chart']    = '年的广告点击率统计图';
$lang['ap_default_pic']    = '广告位默认图片:';
$lang['ap_default_pic_upload']    = '广告位默认图片上传:';
$lang['ap_default_word']   = '广告位默认文字';
$lang['ap_show_defaultpic_when_nothing']    = '当没有广告可供展示时使用的默认图片';
$lang['ap_show_defaultword_when_nothing']    = '当没有广告可供展示时使用的默认文字';

$lang['goback_to_adv_check']    = '返回待审核广告列表页面';
$lang['adv_check_ok']      = '广告审核成功';
$lang['adv_check_failed']    = '广告审核失败';
$lang['return_goldpay']    = '返还购买广告的金币';
$lang['adv_chart_nothing_left']    = '此广告没有';
$lang['adv_chart_nothing_right']    = '年的点击率信息';
