<?php
/**
 * 商品推荐组合模型
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class goods_comboModel extends Model {
    public function __construct(){
        parent::__construct('goods_combo');
    }
    
    /**
     * 插入数据
     * 
     * @param unknown $insert
     * @return boolean
     */
    public function addGoodsComboAll($insert) {
        $result = $this->insertAll($insert);
        if ($result) {
            foreach ((array)$insert as $v) {
                if ($v['goods_id']) $this->_dGoodsComboCache($v['goods_id']);
            }
        }
        return $result;
    }
    
    /**
     * 查询组合商品列表
     * @param unknown $condition
     */
    public function getGoodsComboList($condition) {
        return $this->where($condition)->select();
    }
    
    /**
     * 删除推荐组合商品
     */
    public function delGoodsCombo($condition) {
        $list = $this->getGoodsComboList($condition, 'goods_id');
        if (empty($list)) {
            return true;
        }
        $result = $this->where($condition)->delete();
        if ($result) {
            foreach ($list as $v) {
                $this->_dGoodsComboCache($v['goods_id']);
            }
        }
        return $result;
    }
    
    public function getGoodsComboCacheByGoodsId($goods_id) {
        $array = $this->_rGoodsComboCache($goods_id);
        if (empty($array)) {
            $gcombo_list = array();
            $combo_list = $this->getGoodsComboList(array('goods_id' => $goods_id));
            if (!empty($combo_list)) {
                $comboid_array= array();
                foreach ($combo_list as $val) {
                    $comboid_array[] = $val['combo_goodsid'];
                }
                $gcombo_list = Model('goods')->getGeneralGoodsList(array('goods_id' => array('in', $comboid_array)));
            }
            $array = array('gcombo_list' => serialize($gcombo_list));
            $this->_wGoodsComboCache($goods_id, $array);
        }
        return $array;
    }

    /**
     * 读取商品推荐搭配缓存
     * @param int $goods_id
     * @return array
     */
    private function _rGoodsComboCache($goods_id) {
        return rcache($goods_id, 'goods_combo');
    }

    /**
     * 写入商品推荐搭配缓存
     * @param int $goods_id
     * @param array $array
     * @return boolean
     */
    private function _wGoodsComboCache($goods_id, $array) {
        return wcache($goods_id, $array, 'goods_combo', 60);
    }

    /**
     * 删除商品推荐搭配缓存
     * @param int $goods_id
     * @return boolean
     */
    private function _dGoodsComboCache($goods_id) {
        return dcache($goods_id, 'goods_combo');
    }
}
