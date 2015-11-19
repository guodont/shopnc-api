<?php
/**
 * 服务api model
 */
defined('InShopNC') or exit('Access Invalid!');

class serviceapiModel extends Model
{

    public function __construct()
    {
        parent::__construct('service');
    }


    /**
     *
     * 获取服务列表
     * @param $condition
     * @param string $field
     * @param string $order
     * @param int $limit
     * @param int $page
     * @return mixed
     */
    public function geServiceList($condition, $field = '*', $order = '', $page = 10)
    {
        return $this->table('service')->field($field)->where($condition)->order($order)->page($page)->select();
    }

    /**
     * 服务详情多图
     *
     * @param    array $param 列表条件
     * @param    array $field 显示字段
     */
    public function getListImageService($param, $field = '*')
    {
        if (empty($param)) {
            return false;
        }
        //得到条件语句
        $condition_str = $this->_condition($param);
        $array = array();
        $array['table'] = 'upload';
        $array['where'] = $condition_str;
        $array['field'] = $field;
        $list_image = Db::select($array);

        return $list_image;
    }

    /**
     * 构造检索条件
     *
     * @param int $id 记录ID
     * @return string 字符串类型的返回结果
     */
    private function _condition($condition)
    {
        $condition_str = '';

        if ($condition['upload_type'] != '') {
            $condition_str .= " and upload_type = '" . $condition['upload_type'] . "'";
        }
        if ($condition['item_id'] != '') {
            $condition_str .= " and item_id = '" . $condition['item_id'] . "'";
        }
        if ($condition['file_name'] != '') {
            $condition_str .= " and file_name = '" . $condition['file_name'] . "'";
        }
        if (isset($condition['upload_type_in'])) {
            if ($condition['upload_type_in'] == '') {
                $condition_str .= " and upload_type in('')";
            } else {
                $condition_str .= " and upload_type in({$condition['upload_type_in']})";
            }
        }
        if (isset($condition['item_id_in'])) {
            if ($condition['item_id_in'] == '') {
                $condition_str .= " and item_id in('')";
            } else {
                $condition_str .= " and item_id in({$condition['item_id_in']})";
            }
        }
        if (isset($condition['upload_id_in'])) {
            if ($condition['upload_id_in'] == '') {
                $condition_str .= " and upload_id in('')";
            } else {
                $condition_str .= " and upload_id in({$condition['upload_id_in']})";
            }
        }
        if ($condition['upload_time_lt'] != '') {
            $condition_str .= " and upload_time < '" . $condition['upload_time_lt'] . "'";
        }
        return $condition_str;
    }

    /**
     * 得到所有缩略图，带路径
     *
     * @param    array $goods 商品列表
     */
    public function getThumb($goods, $path)
    {
        if (is_array($goods)) {
            foreach ($goods as $k => $v) {
                $goods[$k]['thumb'] = $path . $v['file_name'];
                $goods[$k]['thumb_mid'] = $path . str_replace('_small', '_mid', $v['file_name']);
                $goods[$k]['thumb_max'] = $path . str_replace('_small', '_max', $v['file_name']);
            }
        }
    }

    /**
     * 服务信息更新
     *
     * @param    array $param 列表条件
     * @param    int $service_id 服务id
     */
    public function updateService($param, $service_id)
    {

        if (empty($param)) {
            return false;
        }

        $update = false;

        if (is_array($service_id)) $service_id = implode(',', $service_id);
        //得到条件语句
        $condition_str = "WHERE service_id in(" . $service_id . ")";

        $update = Db::update('service', $param, $condition_str);

        return $update;
    }
}
