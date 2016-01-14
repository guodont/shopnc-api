<?php
/**
 * 科研联盟－单位 api
 */
defined('InShopNC') or exit('Access Invalid!');

class departControl extends apiHomeControl
{

    private $where;

    private $fields = "depart_id,depart_name,depart_parent_id,depart_deep,depart_content,depart_logo,depart_type,experts_num,service_num,results_num,labs_num";

    private $order = "depart_sort desc";

    public function __construct()
    {
        parent::__construct();

        $type = isset($_GET['type']) ? intval($_GET['type']) : 0;
        $depart_parent_id = isset($_GET['pid']) ? intval($_GET['pid']) : 0;

        if ($_GET['pid'] == "") {
            $this->where = array('depart_show' => 1, 'depart_deep' => 2, 'depart_type' => $type);
        } else {
            $this->where = array('depart_show' => 1, 'depart_deep' => 2, 'depart_type' => $type, 'depart_parent_id' => $depart_parent_id);
        }

        if ($_GET['keyword'] != '') {
            $this->where = array('depart_show' => 1, 'depart_deep' => 2, 'depart_type' => $type,
                'depart_name|depart_content' => array('like', '%' . $_GET['keyword'] . '%'));
        }

    }

    /**
     * GET 获取所有工作单位
     */
    public function departsOp()
    {

        $model_depart = Model('depart');

        $data = $model_depart->getDepartList($this->where, $this->fields, $this->order);

        $pageCount = $model_depart->gettotalpage();

        output_data(array('departs' => $data), mobile_page($pageCount));

    }

    /**
     * GET 获取所有省份
     */
    public function provincesOp()
    {

        $m_where = array('depart_show' => 1, 'depart_deep' => 1);

        $model_depart = Model('depart');
        $data = $model_depart->getDepartList($m_where, $this->fields, $this->order);

        output_data(array('departs' => $data));

    }

    /**
     * GET 科研联盟详情
     */
    public function depart_infoOp()
    {
        if (!isset($_GET['did'])) {
            output_error("缺少id参数");
            die;
        }

        //  条件
        $depart_id = intval($_GET['did']);
        $m_where = array('depart_id' => $depart_id);
        $m_fields = 'dlyp_id,depart_id,depart_name,dlyp_truename,dlyp_mobile,dlyp_telephony,dlyp_address_name,dlyp_area_2,dlyp_area_3,dlyp_area_info,dlyp_address,dlyp_addtime';

        //  查询科研服务站信息
        $model_dp = Model('delivery_point');
        $delivery_info = $model_dp->getDeliveryPointInfo($m_where, $m_fields);

        //  查询单位详情
        $m_depart = Model('depart');
        $depart_info = $m_depart->getAreaInfo($m_where, $this->fields);

        //  输出
        output_data(array('depart_info' => $depart_info, 'delivery_info' => $delivery_info));
    }
}
