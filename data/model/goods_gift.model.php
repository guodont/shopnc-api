<?php
/**
 * 商品赠品模型
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class goods_giftModel extends Model {
    public function __construct(){
        parent::__construct('goods_gift');
    }
    
    /**
     * 插入数据
     * 
     * @param unknown $insert
     * @return boolean
     */
    public function addGoodsGiftAll($insert) {
        return $this->insertAll($insert);
    }
    
    /**
     * 查询赠品列表
     * @param unknown $condition
     */
    public function getGoodsGiftList($condition) {
        return $this->where($condition)->select();
    }
    
    public function getGoodsGiftListByGoodsId($goods_id) {
        $condition['goods_id'] = $goods_id;
        $list = $this->_rGoodsGiftCache($goods_id);
        if (empty($list)) {
            $gift_list = $this->getGoodsGiftList($condition);
            $list['gift'] = serialize($gift_list);
            $this->_wGoodsGiftCache($goods_id, $list);
        }
        $gift_list = unserialize($list['gift']);
        return $gift_list;
    }
    
    /**
     * 删除赠品
     */
    public function delGoodsGift($condition) {
        $gift_list = $this->getGoodsGiftList($condition);
        if (empty($gift_list)) {
            return true;
        }
        $result = $this->where($condition)->delete();
        if ($result) {
            foreach ($gift_list as $val) {
                $this->_dGoodsGiftCache($val['goods_id']);
            }
        }
        return $result;
    }
    
    /**
     * 读取商品公共缓存
     * @param int $goods_id
     * @return array
     */
    private function _rGoodsGiftCache($goods_id) {
        return rcache($goods_id, 'goods_gift');
    }
    
    /**
     * 写入商品公共缓存
     * @param int $goods_id
     * @param array $list
     * @return boolean
     */
    private function _wGoodsGiftCache($goods_id, $list) {
        return wcache($goods_id, $list, 'goods_gift');
    }
    
    /**
     * 删除商品公共缓存
     * @param int $goods_id
     * @return boolean
     */
    private function _dGoodsGiftCache($goods_id) {
        return dcache($goods_id, 'goods_gift');
    }
}
