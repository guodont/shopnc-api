<?php
/**
 * 店铺运单模板模型
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class store_waybillModel extends Model{

    const STORE_WAYBILL_DEFAULT = 1;
    const STORE_WAYBILL_UNDEFAULT = 0;

    public function __construct(){
        parent::__construct('store_waybill');
    }

	/**
	 * 读取列表 
	 * @param array $condition
	 *
	 */
	public function getStoreWaybillList($condition, $order = '') {
        $model_waybill = Model('waybill');

        $store_waybill_list = $this->where($condition)->order($order)->select();
        foreach ($store_waybill_list as $key => $value) {
            $store_waybill_list[$key]['is_default_text'] = $value['is_default'] ? '是' : '否';
            $store_waybill_list[$key]['waybill_pixel_top'] = $value['store_waybill_top'] * $model_waybill::WAYBILL_PIXEL_CONSTANT;
            $store_waybill_list[$key]['waybill_pixel_left'] = $value['store_waybill_left'] * $model_waybill::WAYBILL_PIXEL_CONSTANT;
        }
        return $store_waybill_list;
	}

	/**
	 * 读取列表包含模板信息 
	 *
	 */
	public function getStoreWaybillListWithWaybillInfo($store_id, $store_express) {
        $condition = array();
        $condition['store_waybill.store_id'] = $store_id;
        $condition['store_waybill.express_id'] = array('in', $store_express);
        $field = 'store_waybill.*,waybill.waybill_image,waybill.waybill_width,waybill.waybill_height';
        return $this->table('store_waybill,waybill')->join('inner')->on('store_waybill.waybill_id=waybill.waybill_id')->where($condition)->field($field)->order($order)->select();
    }

    /**
	 * 读取单条记录
	 * @param array $condition
	 *
	 */
    public function getStoreWaybillInfo($condition) {
        $store_waybill_info = $this->where($condition)->find();
        if(!empty($store_waybill_info)) {
            $store_waybill_info['store_waybill_data'] = unserialize($store_waybill_info['store_waybill_data']);
        }
        return $store_waybill_info;
    }

	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
    public function addStoreWaybill($store_waybill_info){
        $model_waybill = Model('waybill');
        $item_list = $model_waybill->getWaybillItemList();
        foreach ($item_list as $key => $value) {
            $item_list[$key]['show'] = true;
        }
        $store_waybill_info['store_waybill_data'] = serialize($item_list);
        return $this->insert($store_waybill_info);	
    }
	
	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function editStoreWaybill($update, $condition, $data = array()) {
        if(!empty($data)) {
            $update['store_waybill_data'] = $this->_getStoreWaybillData($data);
        }
        return $this->where($condition)->update($update);
    }

    /**
     * 获取处理后的自定义数据内容
	 * @param array $data
	 * @param array $condition
	 * @return bool
     */
    private function _getStoreWaybillData($data) {
        $model_waybill = Model('waybill');

        $item_list = $model_waybill->getWaybillItemList();
        foreach ($item_list as $key => $value) {
            if($data[$key]) {
                $item_list[$key]['show'] = true;
            } else {
                $item_list[$key]['show'] = false;
            }
        }
        return serialize($item_list);
    }

    /**
     * 设置默认打印模板
	 * @param int $store_waybill_id
	 * @param int $store_id
	 * @return bool
     */
    public function editStoreWaybillDefault($store_waybill_id, $store_id) {
        $store_waybill_id = intval($store_waybill_id);
        if($store_waybill_id <= 0) {
            return false;
        }

        //解除原默认设置
        $this->editStoreWaybill(array('is_default' => self::STORE_WAYBILL_UNDEFAULT), array('store_id' => $store_id));

        $condition = array();
        $condition['store_waybill_id'] = $store_waybill_id;
        $condition['store_id'] = $store_id;
        return $this->editStoreWaybill(array('is_default' => self::STORE_WAYBILL_DEFAULT), $condition);
    }

	/*
	 * 删除
	 * @param array $condition
	 * @return bool
	 */
    public function delStoreWaybill($condition) {
        return $this->where($condition)->delete();
    }
}
