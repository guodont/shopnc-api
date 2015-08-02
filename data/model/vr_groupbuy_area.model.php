<?php
/**
 * 虚拟抢购区域管理
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class vr_groupbuy_areaModel extends Model
{
    public function __construct()
    {
        parent::__construct('vr_groupbuy_area');
    }

    /**
     * 线下抢购信息
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getVrGroupbuyAreaInfo($condition, $field = '*')
    {
        return $this->table('vr_groupbuy_area')->field($field)->where($condition)->find();
    }

    /**
     * 线下抢购列表
     * @param array $condition
     * @param string $field
     * @param number $page
     * @param string $order
     * @param string $limit
     */
    public function getVrGroupbuyAreaList($condition = array(), $field = '*', $page='15', $order = 'hot_city desc, area_id')
    {
       return $this->table('vr_groupbuy_area')->where($condition)->page($page)->order($order)->select();
    }

    /**
     * 添加线下抢购
     * @param array $data
     */
    public function addVrGroupbuyArea($data)
    {
        return $this->table('vr_groupbuy_area')->insert($data);
    }

    /**
     * 编辑线下抢购
     * @param array $condition
     * @param array $data
     */
    public function editVrGroupbuyArea($condition, $data)
    {
        return $this->table('vr_groupbuy_area')->where($condition)->update($data);
    }

    /**
     * 删除线下分类
     * @param array $condition
     */
    public function delVrGroupbuyArea($condition)
    {
        return $this->table('vr_groupbuy_area')->where($condition)->delete();
    }
}
