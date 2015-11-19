<?php
/**
 * 服务 api
 */
defined('InShopNC') or exit('Access Invalid!');

//Base::autoload('vendor/autoload');

require_once('../core/framework/libraries/vendor/pingpp/init.php');

class serviceControl extends apiHomeControl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * GET 服务列表
     */
    public function servicesOp()
    {

        $model_service = Model('serviceapi');

        //  排序
        $condition = array();
        $condition['gc_id'] = intval($_GET['cate_id']);
        $condition['service_show'] = 1;
        $service_list = $model_service->geServiceList($condition, '*', 'service_sort asc', $this->page);

        $pageCount = $model_service->gettotalpage();

        output_data(array('services' => $service_list), mobile_page($pageCount));

    }

    /**
     * GET 服务详情
     */
    public function serviceOp()
    {
        if (!isset($_GET['sid'])) {
            output_error("缺少服务id参数");
            die;
        }
        $service_id = $_GET['sid'];
        $m_service = Model('serviceapi');

        $where = array('service_id' => $service_id);
        $service_info = $m_service->where($where)->order('service_id desc')->select();

        // TODO 服务收藏
//        if (intval($_GET['fav_id']) > 0) {
//            $favorites_class = Model('flea_favorites');
//            if (!$favorites_class->checkFavorites(intval($_GET['fav_id']), 'flea', intval($_GET['user_id']))) {
//                $service_info[0][is_favorite] = false;
//            }
//        }

        $goods_image_path = UPLOAD_SITE_URL . DS . ATTACH_ARTICLE . '/';    //店铺商品图片目录地址

        $desc_image = $m_service->getListImageService(array('item_id' => $service_id, 'upload_type' => 8));

//        $m_service->getThumb($desc_image, $goods_image_path);

//        $image_key = 0;
//
//        if (!empty($desc_image) && is_array($desc_image)) {//将封面图放到第一位显示
//            $goods_image_1 = $service_info[0]['goods_image'];//封面图
//            foreach ($desc_image as $key => $val) {
//                if ($goods_image_1 == $val['thumb_small']) {
//                    $image_key = $key;
//                    break;
//                }
//            }
//            if ($image_key > 0) {//将封面图放到第一位显示
//                $desc_image_0 = $desc_image[0];
//                $desc_image[0] = $desc_image[$image_key];
//                $desc_image[$image_key] = $desc_image_0;
//            }
//        }

        $service_info[0]['service_image'] = $desc_image;

        /**
         * 浏览次数更新
         */
        $m_service->updateService(array('service_click' => ($service_info[0]['service_click'] + 1)), $service_id);

        if (!empty($service_info)) {
            output_data(array('service_info' => $service_info));
        } else {
            output_error("没有此交易");
        }
    }


    /**
     * GET 属于某服务的所有单位
     */
    public function companiesOp()
    {
        $model_company = Model('company');
        $condition['ac_id'] = intval($_GET['service_id']);
        $condition['like_title'] = trim($_GET['search_title']);
        $company_list = $model_company->getcompanyList($condition);
        output_data(array('companies' => $company_list));
    }


    public function payTestOp()
    {
        \Pingpp\Pingpp::setApiKey('sk_test_vP8WX9KKG4CSmfDGCSPm1WTO');

        $extra = array();
        try {
            $ch = \Pingpp\Charge::create(
                array(
                    'order_no' => '123456789233',
                    'app' => array('id' => 'app_u1yjzHbvvLeLybbT'),
                    'channel' => 'alipay',
                    'amount' => 100,
                    'client_ip' => '127.0.0.1',
                    'currency' => 'cny',
                    'subject' => 'Your Subject',
                    'body' => 'Your Body',
                    'extra' => $extra
                )
            );
            echo $ch;
        } catch (\Pingpp\Error\Base $e) {
            header('Status: ' . $e->getHttpStatus());
            echo($e->getHttpBody());
        }
    }

}
