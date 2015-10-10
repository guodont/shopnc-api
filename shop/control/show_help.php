<?php
/**
 * 店铺帮助
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class show_helpControl extends BaseHomeControl {
    public function __construct() {
        parent::__construct();
        Tpl::output('show_sign','help');
    }
	/**
	 * 店铺帮助页
	 *
	 */
    public function indexOp() {
        $model_help = Model('help');
        $list = $model_help->getShowStoreHelpList();
		$type_id = intval($_GET['t_id']);//帮助类型编号
		if ($type_id < 1 || empty($list[$type_id])) {
			$type_array = current($list);
			$type_id = $type_array['type_id'];
		}
		Tpl::output('type_id',$type_id);
		$help_id = intval($_GET['help_id']);//帮助编号
		if ($help_id < 1 || empty($list[$type_id]['help_list'][$help_id])) {
			$help_array = current($list[$type_id]['help_list']);
			$help_id = $help_array['help_id'];
		}
		Tpl::output('help_id',$help_id);
		$help = $list[$type_id]['help_list'][$help_id];
        Tpl::output('list',$list);//左侧帮助类型及帮助
        Tpl::output('help',$help);//当前帮助
        Tpl::output('article_list','');//底部不显示首页的文章分类
        $phone_array = explode(',',C('site_phone'));
        Tpl::output('phone_array',$phone_array);
        Tpl::output('html_title',C('site_name').' - '.'商家帮助指南');
        Tpl::setLayout('store_joinin_layout');
        Tpl::showpage('store_help');
    }

}
