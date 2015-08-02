<?php
/**
 * 虚拟抢购分类管理
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class vr_groupbuy_classModel extends Model
{
    public function __construct()
    {
        parent::__construct('vr_groupbuy_class');
    }

    /**
     * 线下分类信息
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getVrGroupbuyClassInfo($condition, $field = '*')
    {
        return $this->table('vr_groupbuy_class')->field($field)->where($condition)->find();
    }

    /**
     * 线下分类列表
     * @param array $condition
     * @param string $field
     * @param number $page
     * @param string $order
     * @param string $limit
     */
    public function getVrGroupbuyClassList($condition = array(), $field = '*', $order = 'class_sort', $limit='0,1000')
    {
        return $this->table('vr_groupbuy_class')->where($condition)->order($order)->limit($limit)->select();
    }

    /**
     * 添加线下分类
     * @param array $data
     */
    public function addVrGroupbuyClass($data)
    {
        return $this->table('vr_groupbuy_class')->insert($data);
    }

    /**
     * 编辑线下分类
     * @param array $condition
     * @param array $data
     */
    public function editVrGroupbuyClass($condition, $data)
    {
        return $this->table('vr_groupbuy_class')->where($condition)->update($data);
    }

    /**
     * 删除线下分类
     * @param array $condition
     */
    public function delVrGroupbuyClass($condition)
    {
        return $this->table('vr_groupbuy_class')->where($condition)->delete();
    }
}
