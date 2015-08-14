<?php
/**
 * 推荐展位管理
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class p_boothModel extends Model {
    const STATE1 = 1;       // 开启
    const STATE0 = 0;       // 关闭

    public function __construct() {
        parent::__construct();
    }

    /**
     * 展位套餐列表
     *
     * @param array $condition
     * @param string $field
     * @param int $page
     * @param string $order
     * @return array
     */
    public function getBoothQuotaList($condition, $field = '*', $page = 0, $order = 'booth_quota_id desc') {
        return $this->table('p_booth_quota')->field($field)->where($condition)->order($order)->page($page)->select();
    }

    /**
     * 展位套餐详细信息
     *
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getBoothQuotaInfo($condition, $field = '*') {
        return $this->table('p_booth_quota')->field($field)->where($condition)->find();
    }

    /**
     * 展位套餐详细信息
     *
     * @param int $store_id
     * @param string $field
     * @return array
     */
    public function getBoothQuotaInfoCurrent($store_id) {
        $condition['store_id'] = $store_id;
        $condition['booth_quota_endtime'] = array('gt', TIMESTAMP);
        $condition['booth_state'] = 1;
        return $this->getBoothQuotaInfo($condition);
    }

    /**
     * 保存推荐展位套餐
     *
     * @param array $insert
     * @param boolean $replace
     * @return boolean
     */
    public function addBoothQuota($insert, $replace = false) {
        return $this->table('p_booth_quota')->insert($insert, $replace);
    }

    /**
     * 表示推荐展位套餐
     * @param array $update
     * @param array $condition
     * @return array
     */
    public function editBoothQuota($update, $condition) {
        return $this->table('p_booth_quota')->where($condition)->update($update);
    }

    /**
     * 表示推荐展位套餐
     * @param array $update
     * @param array $condition
     * @return array
     */
    public function editBoothQuotaOpen($update, $condition) {
        $update['booth_state'] = self::STATE1;
        return $this->table('p_booth_quota')->where($condition)->update($update);
    }

    /**
     * 商品列表
     *
     * @param array $condition
     * @param string $field
     * @param int $page
     * @param int $limit
     * @param string $order
     * @return array
     */
    public function getBoothGoodsList($condition, $field = '*', $page = 0, $limit = 0, $order = 'booth_goods_id asc') {
        $condition = $this->_getRecursiveClass($condition);
        return $this->table('p_booth_goods')->field($field)->where($condition)->limit($limit)->order($order)->page($page)->select();
    }

    /**
     * 获取推荐展位商品详细信息
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getBoothGoodsInfo($condition, $field = '*') {
        return $this->table('p_booth_goods')->field($field)->find();
    }

    /**
     * 保存套餐商品信息
     * @param array $insert
     * @return boolean
     */
    public function addBoothGoods($insert) {
        return $this->table('p_booth_goods')->insert($insert);
    }

    /**
     * 编辑套餐商品信息
     *
     * @param array $update
     * @param array $condition
     */
    public function editBooth($update, $condition) {
        return $this->table('p_booth_goods')->where($condition)->update($update);
    }

    /**
     * 更新套餐为关闭状态
     * @param array $condition
     * @return boolean
     */
    public function editBoothClose($condition) {
        $quota_list = $this->getBoothQuotaList($condition);
        if (empty($quota_list)) {
            return true;
        }
        $storeid_array = array();
        foreach ($quota_list as $val) {
            $storeid_array[] = $val['store_id'];
        }
        $where = array('store_id' => array('in', $storeid_array));
        $update = array('booth_state' => self::STATE0);
        $this->editBoothQuota($update, $where);
        $this->editBooth($update, $where);
        return true;
    }

    /**
     * 删除套餐商品
     *
     * @param unknown $condition
     * @return boolean
     */
    public function delBoothGoods($condition) {
        return $this->table('p_booth_goods')->where($condition)->delete();
    }

     /**
      * 获得商品子分类的ID
      * @param array $condition
      * @return array
      */
    private function _getRecursiveClass($condition){
        if (isset($condition['gc_id']) && !is_array($condition['gc_id']) ) {
            $gc_list = Model('goods_class')->getGoodsClassForCacheModel();
            if (isset($gc_list[$condition['gc_id']])) {
                $gc_id[] = $condition['gc_id'];
                $gcchild_id = empty($gc_list[$condition['gc_id']]['child']) ? array() : explode(',', $gc_list[$condition['gc_id']]['child']);
                $gcchildchild_id = empty($gc_list[$condition['gc_id']]['childchild']) ? array() : explode(',', $gc_list[$condition['gc_id']]['childchild']);
                $gc_id = array_merge($gc_id, $gcchild_id, $gcchildchild_id);
                $condition['gc_id'] = array('in', $gc_id);
            }
        }
        return $condition;
    }
}
