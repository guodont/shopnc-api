<?php
/**
 * 专题 api
 */
defined('InShopNC') or exit('Access Invalid!');

class specialControl extends apiHomeControl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * GET 专题列表
     */
    public function specialsOp()
    {

        $conition = array();
        $conition['special_state'] = 2;
        $model_special = Model('cms_special');
        $special_list = $model_special->getShopList($conition, $this->page , 'special_id desc');
        $pageCount = $model_special->gettotalpage();
        output_data(array('specials' => $special_list),mobile_page($pageCount));
    }

    /**
     * GET 专题详情
     */
    public function specialOp()
    {
        if (!isset($_GET['sid'])) {
            output_error("缺少专题id参数");
            die;
        }

        $special_id = $_GET['sid'];
        $m_special = Model('cms_special');
        $where = array('spacial_id' => $special_id);
        $special_info = $m_special->getOne($where);

        /**
         * 浏览次数更新
         */
        $m_special->modify(array('special_view' => ($special_info[0]['special_view'] + 1)), $special_id);

        if (!empty($special_info)) {
            output_data(array('special' => $special_info));
        } else {
            output_error("没有此专题");
        }
    }
}
