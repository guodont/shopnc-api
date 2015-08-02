<?php
defined('InShopNC') or exit('Access Invalid!');

/**
 * 模板页
 */
$lang['index_index_store_goods_price']		= '商城价';

/**
 * 列表页和编辑页
 */
$lang['web_config_index']			= '首页管理';
$lang['web_config_index_help1']			= '排序越小越靠前，可以控制板块显示先后。';
$lang['web_config_index_help2']			= '色彩风格和前台的样式一致，在基本设置中选择更换。';
$lang['web_config_index_help3']			= '色彩风格是css样式中已经有的，如果需要修改名称则相关程序也要同时改变才会有效果。';
$lang['web_config_update_time']	= '更新时间';
$lang['web_config_web_name']				= '板块名称';
$lang['web_config_style_name']				= '色彩风格';
$lang['web_config_web_edit']				= '基本设置';
$lang['web_config_code_edit']				= '板块编辑';
$lang['web_config_web_name_tips']				= '板块名称只在后台首页模板设置中作为板块标识出现，在前台首页不显示。';
$lang['web_config_style_name_tips']				= '选择板块色彩风格将影响商城首页模板该区域的边框、背景色、字体色彩，但不会影响板块的内容布局。';
$lang['web_config_style_red']				= '红色';
$lang['web_config_style_pink']				= '粉色';
$lang['web_config_style_orange']				= '橘色';
$lang['web_config_style_green']				= '绿色';
$lang['web_config_style_blue']				= '蓝色';
$lang['web_config_style_purple']				= '紫色';
$lang['web_config_style_brown']				= '褐色';
$lang['web_config_style_default']				= '默认';
$lang['web_config_add_name_null']				= '板块名称不能为空';
$lang['web_config_sort_int']		= '排序仅可以为数字';
$lang['web_config_sort_tips']	= '数字范围为0~255，数字越小越靠前';

/**
 * 板块编辑页
 */
$lang['web_config_save']			= '保存';
$lang['web_config_web_html']			= '更新板块内容';
$lang['web_config_edit_help1']			= '所有相关设置完成，使用底部的“更新板块内容”前台展示页面才会变化。';
$lang['web_config_edit_help2']			= '左侧的“推荐分类”没有个数限制，但是如果太多会不显示(已选择的子分类可以拖动进行排序，单击选中，双击删除)。';
$lang['web_config_edit_help3']			= '中部的“商品推荐模块”由于页面宽度只能加4个，商品数为8个；右侧的品牌最多为12个(已选择的可以拖动进行排序，单击选中，双击删除)。';
$lang['web_config_edit_html']			= '板块内容设置';
$lang['web_config_picture_tit']			= '标题图片';
$lang['web_config_edit_category']			= '推荐分类';
$lang['web_config_category_name']			= '分类名称';
$lang['web_config_gc_name']			= '子分类';
$lang['web_config_picture_act']			= '活动图片';
$lang['web_config_add_recommend']			= '新增商品推荐模块';
$lang['web_config_recommend_max']			= '(最多4个)';
$lang['web_config_goods_order']			= '商品排行';
$lang['web_config_goods_name']			= '排行榜商品名称';
$lang['web_config_goods_price']			= '价格';
$lang['web_config_picture_adv']			= '广告图片';
$lang['web_config_brand_list']			= '品牌推荐';

$lang['web_config_upload_tit']			= '标题图片上传';
$lang['web_config_prompt_tit']			= '请按照操作注释要求，上传设置板块区域左上角的标题图片。';
$lang['web_config_upload_tit_tips']			= '建议上传宽210*高40像素GIF\JPG\PNG格式图片，超出规定范围的图片部分将被自动隐藏。';
$lang['web_config_upload_url']			= '图片跳转链接';
$lang['web_config_upload_url_tips']			= '输入点击该图片后所要跳转的链接地址或留空。';
$lang['web_config_category_title']			= '添加推荐分类';
$lang['web_config_category_note']			= '从分类下拉菜单中选择该板块要推荐的分类，选择父级分类将包含字分类。';
$lang['web_config_category_tips']			= '小提示：双击分类名称可删除不想显示的分类';

$lang['web_config_upload_act']			= '活动图片上传';
$lang['web_config_prompt_act']			= '请按照操作注释要求，上传设置板块区域左侧的活动图片。';
$lang['web_config_upload_type']			= '选择类型';
$lang['web_config_upload_pic']			= '图片上传';
$lang['web_config_upload_adv']			= '广告调用';
$lang['web_config_upload_act_tips']			= '建议上传宽212*高280像素GIF\JPG\PNG格式图片，超出规定范围的图片部分将被自动隐藏。';
$lang['web_config_upload_act_url']			= '输入点击该图片后所要跳转的链接地址。';

$lang['web_config_recommend_goods']			= '推荐商品';
$lang['web_config_recommend_title']			= '商品推荐模块标题名称';
$lang['web_config_recommend_tips']			= '修改该区域中部推荐商品模块选项卡名称，控制名称字符在4-8字左右，超出范围自动隐藏';
$lang['web_config_recommend_goods_tips']			= '小提示：单击查询出的商品选中，双击已选择的可以删除，最多8个，保存后生效。';
$lang['web_config_recommend_add_goods']			= '选择要展示的推荐商品';
$lang['web_config_recommend_gcategory']			= '选择分类';
$lang['web_config_recommend_goods_name']			= '商品名称';

$lang['web_config_goods_order']			= '商品排行';
$lang['web_config_goods_order_title']			= '商品排行模块标题名称';
$lang['web_config_goods_order_tips']			= '修改该区域中部推荐商品模块选项卡名称，控制名称字符在4-8字左右，超出范围自动隐藏';
$lang['web_config_goods_list']			= '排行商品';
$lang['web_config_goods_list_tips']			= '小提示：单击查询出的商品选中，双击已选择的可以删除，最多5个，保存后生效。';
$lang['web_config_goods_order_add']			= '选择要展示的排行商品';
$lang['web_config_goods_order_gcategory']			= '选择分类';
$lang['web_config_goods_order_type']			= '排序方式';
$lang['web_config_goods_order_sale']			= '出售数量';
$lang['web_config_goods_order_click']			= '浏览数量';
$lang['web_config_goods_order_comment']			= '评论数量';
$lang['web_config_goods_order_collect']			= '收藏数量';
$lang['web_config_goods_order_name']			= '商品名称';

$lang['web_config_brand_title']			= '推荐品牌';
$lang['web_config_brand_tips']			= '小提示：单击候选品牌选中，双击已选择的可以删除，最多12个，保存后生效。';
$lang['web_config_brand_list']			= '候选推荐品牌列表';

$lang['web_config_upload_adv_tips']			= '请按照操作注释要求，上传设置板块区域右下角的广告图片。';
$lang['web_config_upload_adv_pic']			= '广告图片上传';
$lang['web_config_upload_pic_tips']			= '建议上传宽212*高241像素GIF\JPG\PNG格式图片，超出规定范围的图片部分将被自动隐藏。';
$lang['web_config_upload_adv_url']			= '广告跳转链接';
$lang['web_config_upload_pic_url_tips']			= '输入点击该图片后所要跳转的链接地址';