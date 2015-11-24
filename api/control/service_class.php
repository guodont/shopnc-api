<?php
/**
 * 服务分类 api
 */
defined('InShopNC') or exit('Access Invalid!');

class service_classControl extends apiHomeControl
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexOp()
    {
        /**
         * 此处读取micro_personal_class表中的分类
         */
        $model_service_class = Model('company_class');
        //取分类
        $condition = array();

        $condition['where'] = array('class_show' => 1);

        $service_class_list = $model_service_class->getClassList($condition);

        output_data(array('service_class' => $service_class_list));
    }
}
