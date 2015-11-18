<?php
defined('InShopNC') or exit('Access Invalid!');
$lang['resources_isuse'] = '资源库开关';
$lang['cms_url'] = 'CMS地址';
$lang['cms_url_explain'] = '填写为CMS配置的二级域名，没有配置请留空。';
$lang['resources_submit_allow'] = '允许个人添加资源';
$lang['resources_submit_allow_explain'] = '开启后允许用户添加资源';
$lang['resource_submit_verify'] = '添加需要审核';
$lang['resources_submit_verify_explain'] = '开启后用户添加资源后需要管理员审核';
$lang['resources_comment_allow'] = '允许评论';
$lang['resources_comment_allow_explain'] = '评论全局开关';
$lang['resources_isuse_explain'] = '资源库开启后，方能打开资源库功能';

$lang['resources_text_title'] = '名称';
$lang['resources_text_titlefu'] = '小字副标题';
$lang['cms_text_class'] = '分类';
$lang['resources_text_publisher'] = '发布人';
$lang['resources_text_state'] = '状态';
$lang['cms_text_type'] = '类型';
$lang['cms_text_show'] = '显示';
$lang['cms_text_id'] = '编号';
$lang['cms_text_keyword'] = '关键字';
$lang['cms_text_search'] = '搜索';
$lang['resources_order_num'] = '预约数';
$lang['cms_text_content'] = '内容';
$lang['cms_text_artcile'] = '资源';
$lang['resources_commend'] = '推荐';
$lang['resources_show'] = '上架';
$lang['resources_order'] = '在线预约';
$lang['cms_text_comment'] = '评论';
$lang['resources_pay'] = '在线支付';
$lang['cms_text_picture'] = '画报';
$lang['cms_text_draft'] = '草稿箱';
$lang['cms_text_verify'] = '待审核';
$lang['cms_text_published'] = '已发布';
$lang['cms_text_recycle'] = '回收站';
$lang['cms_text_op_verify'] = '审核';
$lang['cms_text_op_callback'] = '收回';
$lang['cms_text_save'] = '保存';
$lang['cms_text_hint'] = '操作提示';
$lang['cms_text_add'] = '添加';
$lang['cms_text_see'] = '查看';
$lang['cms_text_view'] = '预览';
$lang['cms_text_title'] = '专题名称';
$lang['cms_text_image_upload'] = '图片上传';
$lang['cms_text_goods_add'] = '添加商品';

$lang['cms_title_not_null'] = '标题不能为空';
$lang['cms_title_max'] = '标题最多{0}个字';
$lang['cms_title_min'] = '标题最少{0}个字';

$lang['cms_article_type_member'] = '用户投稿';
$lang['cms_article_type_admin'] = '管理员发布';
$lang['resources_list_verify'] = '待审核';
$lang['resources_list_published'] = '已发布';

$lang['cms_special_title_explain'] = '标题不能超过24个字';
$lang['cms_special_image'] = '专题封面图';
$lang['cms_special_image_error'] = '专题封面图不能为空';
$lang['cms_special_image_explain'] = '请上传990像素x240像素的图片作为专题页面的封面图';
$lang['cms_special_build_fail'] = '静态文件更新失败';
$lang['cms_special_background'] = '专题页面背景设置';
$lang['cms_special_background_color'] = '背景色选择';
$lang['cms_special_background_color_explain'] = '背景色即专题页面CSS属性中"body{ background-color}"值，作为专业页面整体背景色使用，设置请使用十六进制形式(#XXXXXX)，默认留空为白色背景。';
$lang['cms_special_background_image'] = '背景图选择';
$lang['cms_special_background_image_explain'] = '背景图即专题页面CSS属性中"body{ background-image}"值，选择本地图片上传作为页面整体背景。';
$lang['cms_special_background_type'] = '背景图填充方式';
$lang['cms_special_background_type_norepeat'] = '不重复';
$lang['cms_special_background_type_repeat'] = '平铺';
$lang['cms_special_background_type_xrepeat'] = 'x轴平铺';
$lang['cms_special_background_type_yrepeat'] = 'y轴平铺';
$lang['cms_special_background_type_explain'] = '背景图填充方式即专题页面CSS属"body{ background-repeat}"值，选择不重复(no-repeat)|平铺(repeat)|x轴平铺(repeat-x)|y轴平铺(repeat-y)为背景图的填充方式。';
$lang['cms_special_content'] = '专题正文内容';
$lang['cms_special_content_top_margin'] = '内容块距顶部';
$lang['cms_special_content_explain'] = '内容块距顶部高度即专题主体部分距离页面顶部的边距(margin-top)值，如果您需要露出部分背景图作为页面头部，应相应调整距上边距；默认值为0。';
$lang['cms_special_image_and_goods'] = '选择插入图片或商品';
$lang['cms_special_image_explain1'] = '可选择本地图片上传，并添加链接后插入到主体内容的编辑器。链接形式可以为单图单链接，单图多重热点链接等模式。而商品则可通过输入商品网址形式直接插入到编辑器中。';
$lang['cms_special_image_list'] = '上传的图片';
$lang['cms_special_image_tips1'] = '以图片链接模式插入专题页';
$lang['cms_special_image_tips2'] = '以热点链接模式插入专题页';
$lang['cms_special_image_tips3'] = '删除该图片';
$lang['cms_special_draft'] = '保存草稿';
$lang['cms_special_publish'] = '发布专题';
$lang['cms_special_image_link_explain1'] = '点击确认后将以图片链接的形式插入到专题页面编辑器中，点击编辑器预览选项开查看生成后的效果';
$lang['cms_special_image_link_url'] = '添加该图片的链接地址';
$lang['cms_special_image_link_url_explain'] = '链接地址格式以"http://"开头';
$lang['cms_special_image_link_hot_explain1'] = '用鼠标选择区域并输入对应的url，保存后将以热点区域的方式添加到专题页面中';
$lang['cms_special_image_link_hot_select'] = '选择热点区域';
$lang['cms_special_image_link_hot_url'] = '添加热点链接地址';
$lang['cms_special_insert_editor'] = '插入编辑器';
$lang['cms_special_goods_explain1'] = '请输入准确的商品网址以确保正确添加商品';
$lang['cms_special_goods_url'] = '输入商品地址';
$lang['cms_special_list_tip1'] = '专题可以支持商品列表、图片链接、图片热点三种内置方式，也可以自行编写HTML代码';

$lang['cms_tag_name'] = '标签名称';
$lang['cms_tag_count'] = '标签计数';

$lang['cms_article_abstract'] = '资源摘要';

$lang['cms_navigation_name'] = '导航名称';
$lang['cms_navigation_url'] = '导航链接';
$lang['cms_navigation_open_type'] = '新窗口打开';

$lang['cms_comment_object_id'] = '对象编号';

$lang['class_name'] = '分类名称';
$lang['class_name_error'] = '分类名称不能为空且必须小于10个字';
$lang['class_name_required'] = '分类名称不能为空';
$lang['class_name_maxlength'] = '分类名称最多个{0}字符';
$lang['class_sort_explain'] = '数字范围为0~255，数字越小越靠前';
$lang['class_sort_error'] = '排序必须为0~055之间的数字';
$lang['class_sort_required'] = '排序不能为空';
$lang['class_sort_digits'] = '排序必须为数字';
$lang['class_sort_max'] = '排序最大为{0}';
$lang['class_sort_min'] = '排序最小为{0}';
$lang['class_add_success'] = '分类保存成功';
$lang['class_add_fail'] = '分类保存失败';
$lang['class_drop_success'] = '分类删除成功';
$lang['class_drop_fail'] = '分类删除失败';
$lang['resources_title_error'] = '资源标题不能为空且必须不能大于50个字';
$lang['navigation_title_error'] = '导航名称不能为空，最多20个字符';
$lang['navigation_link_error'] = '导航链接不能为空，必需为完整URL格式，最多255个字符';
$lang['navigation_add_success'] = '导航保存成功';
$lang['navigation_add_fail'] = '导航保存失败';
$lang['navigation_drop_success'] = '导航删除成功';
$lang['navigation_drop_fail'] = '导航删除失败';
$lang['tag_name_error'] = '标签名称不能为空，最多20个字符';
$lang['tag_add_success'] = '标签保存成功';
$lang['tag_add_fail'] = '标签保存失败';
$lang['tag_drop_success'] = '标签删除成功';
$lang['tag_drop_fail'] = '标签删除失败';


$lang['cms_ensure_verify'] = '您确认审核？';
$lang['resources_ensure_callback'] = '您确认收回？';

$lang['cms_article_class_list_tip1'] = '通过修改排序数字可以控制前台显示顺序，数字越小越靠前';
$lang['cms_article_class_list_tip2'] = '可以直接在列表中修改资源对应的浏览数，开启关闭在线预约和支付功能';
$lang['cms_picture_list_tip2'] = '可以直接在列表中修改资源对应的浏览数，开启关闭评论功能';
$lang['cms_comment_tip1'] = '对违规评论进行删除';


$lang['cms_log_article_drop'] = 'CMS资源删除，资源编号';
$lang['cms_log_article_class_save'] = 'CMS资源分类保存，分类编号';
$lang['cms_log_article_class_drop'] = 'CMS资源分类删除，分类编号';
$lang['cms_log_comment_drop'] = 'CMS评论删除，评论编号';
$lang['cms_log_index_edit'] = 'CMS首页模块编辑，模块编号';
$lang['cms_log_index_build'] = '首页静态文件更新';
$lang['resources_log_manage_save'] = '资源库管理保存';
$lang['cms_log_navigation_save'] = 'CMS导航保存，导航编号';
$lang['cms_log_navigation_drop'] = 'CMS导航删除，导航编号';
$lang['cms_log_picture_drop'] = 'CMS画报删除，画报编号';
$lang['cms_log_special_save'] = 'CMS专题保存，专题编号';
$lang['cms_log_special_drop'] = 'CMS专题删除，专题编号';
$lang['cms_log_tag_save'] = 'CMS标签保存，标签编号';
$lang['cms_log_tag_drop'] = 'CMS标签删除，标签编号';
$lang['cms_mobile_goods'] = '手机端商品';