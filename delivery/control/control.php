<?php
/**
 * 物流自提服务站父类
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');

class BaseDeliveryControl{
    /**
     * 构造函数
     */
    public function __construct(){
        /**
         * 读取通用、布局的语言包
         */
        Language::read('common');
        /**
         * 设置布局文件内容
         */
        Tpl::setLayout('delivery_layout');
        /**
         * SEO
         */
        $this->SEO();
        /**
         * 获取导航
         */
        Tpl::output('nav_list', rkcache('nav',true));
    }
    /**
     * SEO
     */
    protected function SEO() {
        Tpl::output('html_title','物流自提服务站      ' . C('site_name') . '');
        Tpl::output('seo_keywords','');
        Tpl::output('seo_description','');
    }
}
/**
 * 操作中心
 * @author Administrator
 *
 */
class BaseDeliveryCenterControl extends BaseDeliveryControl{
    public function __construct() {
        parent::__construct();
        if ($_SESSION['delivery_login'] != 1) {
            @header('location: index.php?act=login');die;
        }
    }
}
/**
 * 操作中心
 * @author Administrator
 *
 */
class BaseAccountCenterControl extends BaseDeliveryControl{
    public function __construct() {
        parent::__construct();

        Tpl::setLayout('login_layout');
    }
}


