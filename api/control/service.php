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
        $model_upload = Model('upload');
        $model = new Model();

        $condition = array();
        $condition['gc_id'] = intval($_GET['cate_id']);
        $condition['service_show'] = 1;

        $service_list = $model_service->geServiceList($condition, '*', 'service_sort asc', $this->page);
        $m_fav = Model('favorites');

        foreach ($service_list as $key => $val) {
            // 获取收藏状态
            if (isset($_GET['uid'])) {
                $service_list[$key]['fav_status'] = $m_fav->checkFavorites($service_list[$key]['service_id'], 'service', $_GET['uid']) ? 1 : 0;
            }
            $imgs = $model_upload->getUploadList(array('item_id' => $val['service_id']));
            $service_list[$key]['service_image'] = $imgs[0]['file_name'];
        }

        $pageCount = $model_service->gettotalpage();
        output_data(array('services' => $service_list), mobile_page($pageCount));

    }

    /**
     * GET 搜索服务
     */
    public function search_serviceOp()
    {

        $model_service = Model('serviceapi');
        $model_upload = Model('upload');
        $model = new Model();

        $condition = array();

        if ($_GET['keyword'] != '') {
            $condition['service_name|service_tag'] = array('like', '%' . $_GET['keyword'] . '%');
        }

        $condition['service_show'] = 1;
        $service_list = $model_service->geServiceList($condition, '*', 'service_sort asc', $this->page);
        $m_fav = Model('favorites');

        foreach ($service_list as $key => $val) {
            // 获取收藏状态
            if (isset($_GET['uid'])) {
                $service_list[$key]['fav_status'] = $m_fav->checkFavorites($service_list[$key]['service_id'], 'service', $_GET['uid']) ? 1 : 0;
            }
            $imgs = $model_upload->getUploadList(array('item_id' => $val['service_id']));
            $service_list[$key]['service_image'] = $imgs[0]['file_name'];
        }

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

        $goods_image_path = UPLOAD_SITE_URL . DS . ATTACH_SERVICE . '/';    //店铺商品图片目录地址

        $desc_image = $m_service->getListImageService(array('item_id' => $service_id, 'upload_type' => 8));

        $m_service->getThumb($desc_image, $goods_image_path);

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
