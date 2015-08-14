<?php
/**
 * 店铺扩展模型
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class store_extendModel extends Model {
    public function __construct(){
        parent::__construct('store_extend');
    }

    /**
	 * 查询店铺扩展信息
     *
	 * @param int $store_id 店铺编号
	 * @param string $field 查询字段
     * @return array
	 */
    public function getStoreExtendInfo($condition, $field = '*') {
        return $this->field($field)->where($condition)->find();
    }

	/*
	 * 编辑店铺扩展信息
     *
	 * @param array $update 更新信息
	 * @param array $condition 条件
	 * @return bool
	 */
    public function editStoreExtend($update, $condition){
        return $this->where($condition)->update($update);
    }

    /*
     * 删除店铺扩展信息
     */
    public function delStoreExtend($condition)
    {
        return $this->where($condition)->delete();
    }
}
