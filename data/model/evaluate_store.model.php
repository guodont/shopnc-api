<?php
/**
 * 店铺评分模型
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class evaluate_storeModel extends Model {

    public function __construct(){
        parent::__construct('evaluate_store');
    }

	/**
	 * 查询店铺评分列表
     *
	 * @param array $condition 查询条件
	 * @param int $page 分页数
	 * @param string $order 排序
	 * @param string $field 字段
     * @return array
	 */
    public function getEvaluateStoreList($condition, $page=null, $order='seval_id desc', $field='*') {
        $list = $this->field($field)->where($condition)->page($page)->order($order)->select();
        return $list;
    }

    /**
     * 获取店铺评分信息
     */
    public function getEvaluateStoreInfo($condition, $field='*') {
        $list = $this->field($field)->where($condition)->find();
        return $list;
    }

    /**
     * 根据店铺编号获取店铺评分数据
     *
     * @param int @store_id 店铺编号
     * @param int @sc_id 分类编号，如果传入分类编号同时返回行业对比数据
     */
    public function getEvaluateStoreInfoByStoreID($store_id, $sc_id = 0) {
        $prefix = 'evaluate_store_info';
        $info = rcache($store_id, $prefix);
        if(empty($info)) {
            $info = array();
            $info['store_credit'] = $this->_getEvaluateStore(array('seval_storeid' => $store_id));
            $info['store_credit_average'] = round((($info['store_credit']['store_desccredit']['credit'] + $info['store_credit']['store_servicecredit']['credit'] + $info['store_credit']['store_deliverycredit']['credit']) / 3), 1);
            $info['store_credit_percent'] = intval($info['store_credit_average'] / 5 * 100);
            if($sc_id > 0) {
                $sc_info = $this->getEvaluateStoreInfoByScID($sc_id);
                foreach ($info['store_credit'] as $key => $value) {
                    if($sc_info[$key]['credit'] > 0) {
                        $info['store_credit'][$key]['percent'] = intval(($info['store_credit'][$key]['credit'] - $sc_info[$key]['credit']) / $sc_info[$key]['credit'] * 100);
                    } else {
                        $info['store_credit'][$key]['percent'] = 0;
                    } 
                    if($info['store_credit'][$key]['percent'] > 0) {
                        $info['store_credit'][$key]['percent_class'] = 'high';
                        $info['store_credit'][$key]['percent_text'] = '高于';
                        $info['store_credit'][$key]['percent'] .= '%';
                    } elseif ($info['store_credit'][$key]['percent'] == 0) {
                        $info['store_credit'][$key]['percent_class'] = 'equal';
                        $info['store_credit'][$key]['percent_text'] = '持平';
                        $info['store_credit'][$key]['percent'] = '----';
                    } else {
                        $info['store_credit'][$key]['percent_class'] = 'low';
                        $info['store_credit'][$key]['percent_text'] = '低于';
                        $info['store_credit'][$key]['percent'] = abs($info['store_credit'][$key]['percent']);
                        $info['store_credit'][$key]['percent'] .= '%';
                    }
                }
            }
            $cache = array();
            $cache['evaluate'] = serialize($info);
            wcache($store_id, $cache, $prefix, 60 * 24);
        } else {
            $info = unserialize($info['evaluate']);
        }
        return $info;
    }

    /**
     * 根据分类编号获取分类评分数据
     */
    public function getEvaluateStoreInfoByScID($sc_id) {
        $prefix = 'sc_evaluate_store_info';
        $info = rcache($sc_id, $prefix);
        if(empty($info)) {
            $model_store = Model('store');
            $store_id_string = $model_store->getStoreIDString(array('sc_id' => $sc_id));
            $info = $this->_getEvaluateStore(array('seval_storeid' => array('in', $store_id_string)));
            $cache = array();
            $cache['evaluate_store_info'] = serialize($info);
            wcache($sc_id, $cache, $prefix, 60 * 24);
        } else {
            $info = unserialize($info['evaluate_store_info']);
        }
        return $info;
    }

    /**
     * 获取店铺评分数据
     */
    private function _getEvaluateStore($condition) {
        $result = array();
        $field = 'AVG(seval_desccredit) as store_desccredit,';
        $field .= 'AVG(seval_servicecredit) as store_servicecredit,';
        $field .= 'AVG(seval_deliverycredit) as store_deliverycredit,';
        $field .= 'COUNT(seval_id) as count';
        $info = $this->getEvaluateStoreInfo($condition, $field);
        $result['store_desccredit']['text'] = '描述相符';
        $result['store_servicecredit']['text'] = '服务态度';
        $result['store_deliverycredit']['text'] = '发货速度';
        if(intval($info['count']) > 0) {
            $result['store_desccredit']['credit'] = round($info['store_desccredit'], 1);
            $result['store_servicecredit']['credit'] = round($info['store_servicecredit'], 1);
            $result['store_deliverycredit']['credit'] = round($info['store_deliverycredit'], 1);
        } else {
            $result['store_desccredit']['credit'] = round(5, 1);
            $result['store_servicecredit']['credit'] = round(5, 1);
            $result['store_deliverycredit']['credit'] = round(5, 1);
        }
        return $result;
    }


    /**
     * 添加店铺评分
     */
    public function addEvaluateStore($param) {
        return $this->insert($param);	
    }

    /**
     * 删除店铺评分
     */
    public function delEvaluateStore($condition) {
        return $this->where($condition)->delete();
    }
}
