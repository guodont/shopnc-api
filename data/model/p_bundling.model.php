<?php
/**
 * 优惠套装
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class p_bundlingModel extends Model {
    const STATE1 = 1;       // 开启
    const STATE0 = 0;       // 关闭
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 组合活动数量
     * 
     * @param array $condition
     * @return array
     */
    public function getBundlingCount($condition) {
        return $this->table('p_bundling')->where($condition)->count();
    }
    
    /**
     * 活动列表
     * 
     * @param array $condition
     * @param string $field
     * @param string $order
     * @param int $page
     * @param int $limit
     * @param int $count
     * @return array
     */
    public function getBundlingList($condition, $field = '*', $order = 'bl_id desc', $page = 10, $limit = 0, $count = 0) {
        return $this->table('p_bundling')->where($condition)->order($order)->limit($limit)->page($page, $count)->select();
    }
    
    /**
     * 开启的活动列表
     * @param array $condition
     * @param string $field
     * @param string $order
     * @param int $limit
     * @return array
     */
    public function getBundlingOpenList($condition, $field = '*', $order = 'bl_id desc', $limit = 0) {
        $condition['bl_state'] = self::STATE1;
        return $this->getBundlingList($condition, $field, $order, 0, $limit);
    }
    
    /**
     * 获得获得详细信息
     */
    public function getBundlingInfo($condition) {
        return $this->table('p_bundling')->where($condition)->find();
    }
    
    /**
     * 保存活动
     * 
     * @param array $insert
     * @param string $replace
     * @return boolean
     */
    public function addBundling($insert, $replace = false) {
        return $this->table('p_bundling')->insert($insert, $replace);
    }
    
    /**
     * 更新活动
     * 
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editBundling($update, $condition) {
        return $this->table('p_bundling')->where($condition)->update($update);
    }
    
    /**
     * 更新活动关闭
     * 
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editBundlingCloseByGoodsIds($condition) {
        $bundlinggoods_list = $this->getBundlingGoodsList($condition, 'bl_id');
        if (!empty($bundlinggoods_list)) {
            $blid_array = array();
            foreach ($bundlinggoods_list as $val) {
                $blid_array[] = $val['bl_id'];
            }
            $update = array('bl_state' => self::STATE0);
            return $this->table('p_bundling')->where(array('bl_id' => array('in', $blid_array)))->update($update);
        }
        return true;
    }
    
    /**
     * 删除套餐活动
     * @param array $blids
     * @param int $store_id
     * @return boolean
     */
    public function delBundling($blids, $store_id) {
        $blid_array = explode(',', $blids);
        foreach ($blid_array as $val) {
            if (!is_numeric($val)) {
                return false;
            }
        }
        $where = array();
        $where['bl_id'] = array('in', $blid_array);
        $where['store_id'] = $store_id;
        $bl_list = $this->getBundlingList($where, 'bl_id');
        $bl_list = array_under_reset($bl_list, 'bl_id');
        $blid_array = array_keys($bl_list);
        
        $where = array();
        $where['bl_id'] = array('in', $blid_array);
        $rs = $this->table('p_bundling')->where($where)->delete();
        if ($rs) {
            return $this->delBundlingGoods($where);
        } else {
            return false;
        }
    }
    
    /**
     * 删除套餐活动（平台后台使用）
     * @param array $condition
     * @return boolean
     */
    public function delBundlingForAdmin($condition) {
        $rs = $this->table('p_bundling')->where($condition)->delete();
        if ($rs) {
            return $this->delBundlingGoods($condition);
        } else {
            return false;
        }
    }
    
    /**
     * 单条组合套餐
     * 
     * @param array $condition
     * @return array
     */
    public function getBundlingQuotaInfo($condition) {
        return $this->table('p_bundling_quota')->where($condition)->find();
    }
    
    /**
     * 单条组合套餐
     * 
     * @param int $store_id
     * @return array
     */
    public function getBundlingQuotaInfoCurrent($store_id) {
        $condition['store_id'] = $_SESSION['store_id'];
        $condition['bl_quota_endtime'] = array('gt', TIMESTAMP);
        $condition['bl_state'] = 1;
        return $this->getBundlingQuotaInfo($condition);
    }
    
    /**
     * 组合套餐列表
     * 
     * @param array $condition
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getBundlingQuotaList($condition, $page = 10, $limit = 0) {
        return $this->table('p_bundling_quota')->where($condition)->order('bl_quota_id desc')->limit($limit)->page($page)->select();
    }
    
    /**
     * 开启的组合套餐列表
     * 
     * @param array $condition
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getBundlingQuotaOpenList($condition, $page = 10, $limit = 0) {
        $condition['bl_state'] = self::STATE1;
        return $this->getBundlingQuotaList($condition, $page, $limit);
    }
    
    /**
     * 保存组合套餐
     * 
     * @param array $insert
     * @return boolean
     */
    public function addBundlingQuota($insert) {
        return $this->table('p_bundling_quota')->insert($insert);
    }
    
    /**
     * 更新组合套餐
     * 
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editBundlingQuota($update, $condition) {
        return $this->table('p_bundling_quota')->where($condition)->update($update);
    }
    
    /**
     * 更新组合套餐
     * 
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editBundlingQuotaOpen($update, $condition) {
        $update['bl_state'] = self::STATE1;
        return $this->table('p_bundling_quota')->where($condition)->update($update);
    }
    
    /**
     * 更新套餐为关闭状态
     * @param array $condition
     * @return boolean
     */
    public function editBundlingQuotaClose($condition) {
        $quota_list = $this->getBundlingQuotaList($condition);
        if (empty($quota_list)) {
            return true;
        }
        $storeid_array = array();
        foreach ($quota_list as $val) {
            $storeid_array[] = $val['store_id'];
        }
        $where = array('store_id' => array('in', $storeid_array));
        $update = array('bl_state' => self::STATE0);
        $this->editBundlingQuota($update, $where);
        $this->editBundling($update, $where);
        return true;
    }
    
    /**
     * 更新超时的套餐为关闭状态
     * @param array $condition
     * @return boolean
     */
    public function editBundlingTimeout($condition) {
        $condition['bl_quota_endtime'] = array('lt', TIMESTAMP);
        $quota_list = $this->getBundlingQuotaList($condition);
        if (!empty($quota_list)) {
            $quotaid_array = array();
            foreach ($quota_list as $val) {
                $quotaid_array[] = $val['bl_quota_id'];
            }
            return $this->editBundlingQuotaClose(array('bl_quota_id' => array('in', $quotaid_array)));
        } else {
            return true;
        }
    }

    /**
     * 套餐商品列表
     * 
     * @param array $condition
     * @param string $field
     * @param string $order
     * @param string $group
     * @return array
     */
    public function getBundlingGoodsList($condition, $field = '*', $order = 'bl_goods_id asc', $group = '') {
        return $this->table('p_bundling_goods')->field($field)->where($condition)->group($group)->order($order)->select();
    }

    /**
     * 保存套餐商品
     * 
     * @param unknown $insert
     * @return boolean
     */
    public function addBundlingGoodsAll($insert) {
        $result = $this->table('p_bundling_goods')->insertAll($insert);
        if ($result) {
            foreach ((array)$insert as $v) {
                if (isset($v['goods_id'])) $this->_dGoodsBundlingCache($v['goods_id']);
            }
        }
        return $result;
    }
    
    /**
     * 删除套餐商品
     * 
     * @param array $condition
     * @return boolean
     */
    public function delBundlingGoods($condition) {
        $list = $this->getBundlingGoodsList($condition, 'goods_id');
        if (empty($list)) {
            return true;
        }
        $result = $this->table('p_bundling_goods')->where($condition)->delete();
        if ($result) {
            foreach ($list as $v) {
                $this->_dGoodsBundlingCache($v['goods_id']);
            }
        }
        return $result;
    }
    
    /**
     * 根据商品id查询套餐数据
     * @param unknown $goods_id
     */
    public function getBundlingCacheByGoodsId($goods_id) {
        $array = $this->_rGoodsBundlingCache($goods_id);
        if (empty($array)) {
            $bundling_array = array();
            $b_goods_array = array();
            // 根据商品id查询bl_id
            $b_g_list = $this->getBundlingGoodsList(array('goods_id' => $goods_id, 'bl_appoint' => 1), 'bl_id');
            if (!empty($b_g_list)) {
                $b_id_array = array();
                foreach ($b_g_list as $val) {
                    $b_id_array[] = $val['bl_id'];
                }
            
                // 查询套餐列表
                $bundling_list = $this->getBundlingOpenList(array('bl_id' => array('in', $b_id_array)));
                // 整理
                if (!empty($bundling_list)) {
                    foreach ($bundling_list as $val) {
                        $bundling_array[$val['bl_id']]['id'] = $val['bl_id'];
                        $bundling_array[$val['bl_id']]['name'] = $val['bl_name'];
                        $bundling_array[$val['bl_id']]['cost_price'] = 0;
                        $bundling_array[$val['bl_id']]['price'] = $val['bl_discount_price'];
                        $bundling_array[$val['bl_id']]['freight'] = $val['bl_freight'];
                    }
                    $blid_array = array_keys($bundling_array);
            
                    $b_goods_list = $this->getBundlingGoodsList(array('bl_id' => array('in', $blid_array)));
                    if (!empty($b_goods_list) && count($b_goods_list) > 1) {
                        $goodsid_array = array();
                        foreach ($b_goods_list as $val) {
                            $goodsid_array[] = $val['goods_id'];
                        }
                        $goods_list = Model('goods')->getGoodsList(array('goods_id' => array('in', $goodsid_array)), 'goods_id,goods_name,goods_price,goods_image');
                        $goods_list = array_under_reset($goods_list, 'goods_id');
                        foreach ( $b_goods_list as $val ) {
                            if (isset($goods_list[$val['goods_id']])) {
                                $k = (intval($val['goods_id']) == $goods_id) ? 0 : $val['goods_id'];    // 排序当前商品放到最前面
                                $b_goods_array[$val['bl_id']][$k]['id'] = $val['goods_id'];
                                $b_goods_array[$val['bl_id']][$k]['image'] = thumb($goods_list[$val['goods_id']], 240);
                                $b_goods_array[$val['bl_id']][$k]['name'] = $goods_list[$val['goods_id']]['goods_name'];
                                $b_goods_array[$val['bl_id']][$k]['shop_price'] = ncPriceFormat($goods_list[$val['goods_id']]['goods_price']);
                                $b_goods_array[$val['bl_id']][$k]['price'] = ncPriceFormat($val['bl_goods_price']);
                                $bundling_array[$val['bl_id']]['cost_price'] += $goods_list[$val['goods_id']]['goods_price'];
                            }
                        }
                    }
                }
            }
            $array = array('bundling_array' => serialize($bundling_array), 'b_goods_array' => serialize($b_goods_array));
            $this->_wGoodsBundlingCache($goods_id, $array);
        }
        return $array;
    }

    /**
     * 读取商品优惠套装缓存
     * @param int $goods_id
     * @return array
     */
    private function _rGoodsBundlingCache($goods_id) {
        return rcache($goods_id, 'goods_bundling');
    }

    /**
     * 写入商品优惠套装缓存
     * @param int $goods_id
     * @param array $array
     * @return boolean
     */
    private function _wGoodsBundlingCache($goods_id, $array) {
        return wcache($goods_id, $array, 'goods_bundling');
    }

    /**
     * 删除商品优惠套装缓存
     * @param int $goods_id
     * @return boolean
     */
    private function _dGoodsBundlingCache($goods_id) {
        return dcache($goods_id, 'goods_bundling');
    }
}