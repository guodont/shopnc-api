<?php
/**
 * 限时折扣活动商品模型 
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class p_xianshi_goodsModel extends Model{

    const XIANSHI_GOODS_STATE_CANCEL = 0;
    const XIANSHI_GOODS_STATE_NORMAL = 1;

    public function __construct(){
        parent::__construct('p_xianshi_goods');
    }

	/**
	 * 读取限时折扣商品列表
	 * @param array $condition 查询条件
	 * @param int $page 分页数
	 * @param string $order 排序
	 * @param string $field 所需字段
     * @param int $limit 个数限制
     * @return array 限时折扣商品列表
	 *
	 */
	public function getXianshiGoodsList($condition, $page=null, $order='', $field='*', $limit = 0) {
        return $xianshi_goods_list = $this->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
	}

	/**
	 * 读取限时折扣商品列表
	 * @param array $condition 查询条件
	 * @param int $page 分页数
	 * @param string $order 排序
	 * @param string $field 所需字段
     * @param int $limit 个数限制
     * @return array 限时折扣商品列表
	 *
	 */
	public function getXianshiGoodsExtendList($condition, $page=null, $order='', $field='*', $limit = 0) {
        $xianshi_goods_list = $this->getXianshiGoodsList($condition, $page, $order, $field, $limit);
        if(!empty($xianshi_goods_list)) {
            for($i=0, $j=count($xianshi_goods_list); $i < $j; $i++) {
                $xianshi_goods_list[$i] = $this->getXianshiGoodsExtendInfo($xianshi_goods_list[$i]);
            }
        }
        return $xianshi_goods_list;
	}

    /**
	 * 根据条件读取限制折扣商品信息
	 * @param array $condition 查询条件
     * @return array 限时折扣商品信息
	 *
	 */
    public function getXianshiGoodsInfo($condition) {
        $result = $this->where($condition)->find();
        return $result;
    }

    /**
	 * 根据限时折扣商品编号读取限制折扣商品信息
	 * @param int $xianshi_goods_id
     * @return array 限时折扣商品信息
	 *
	 */
    public function getXianshiGoodsInfoByID($xianshi_goods_id, $store_id = 0) {
        if(intval($xianshi_goods_id) <= 0) {
            return null;
        }

        $condition = array();
        $condition['xianshi_goods_id'] = $xianshi_goods_id;
        $xianshi_goods_info = $this->getXianshiGoodsInfo($condition);

        if($store_id > 0 && $xianshi_goods_info['store_id'] != $store_id) {
            return null;
        } else {
            return $xianshi_goods_info;
        }
    }

    /**
     * 增加限时折扣商品 
     * @param array $xianshi_goods_info
     * @return bool
     *
     */
    public function addXianshiGoods($xianshi_goods_info){
        $xianshi_goods_info['state'] = self::XIANSHI_GOODS_STATE_NORMAL;
        $xianshi_goods_id = $this->insert($xianshi_goods_info);
        
        // 删除商品限时折扣缓存
        $this->_dGoodsXianshiCache($xianshi_goods_info['goods_id']);
        
        $xianshi_goods_info['xianshi_goods_id'] = $xianshi_goods_id;
        $xianshi_goods_info = $this->getXianshiGoodsExtendInfo($xianshi_goods_info);
        return $xianshi_goods_info;
    }

    /**
     * 更新
     * @param array $update
     * @param array $condition
     * @return bool
     *
     */
    public function editXianshiGoods($update, $condition){
        $result = $this->where($condition)->update($update);
        if ($result) {
            $xianshi_goods_list = $this->getXianshiGoodsList($condition, null, '', 'goods_id');
            if (!empty($xianshi_goods_list)) {
                foreach ($xianshi_goods_list as $val) {
                    // 删除商品限时折扣缓存
                    $this->_dGoodsXianshiCache($val['goods_id']);
                    // 插入对列 更新促销价格
                    QueueClient::push('updateGoodsPromotionPriceByGoodsId', $val['goods_id']);
                }
            }
        }
        return $result;
    }

    /**
     * 删除
     * @param array $condition
     * @return bool
     *
     */
    public function delXianshiGoods($condition){
        $xianshi_goods_list = $this->getXianshiGoodsList($condition, null, '', 'goods_id');
        $result = $this->where($condition)->delete();
        if ($result) {
            if (!empty($xianshi_goods_list)) {
                foreach ($xianshi_goods_list as $val) {
                    // 删除商品限时折扣缓存
                    $this->_dGoodsXianshiCache($val['goods_id']);
                    // 插入对列 更新促销价格
                    QueueClient::push('updateGoodsPromotionPriceByGoodsId', $val['goods_id']);
                }
            }
        }
        return $result;
    }

    /**
     * 获取限时折扣商品扩展信息
     * @param array $xianshi_info
     * @return array 扩展限时折扣信息
     *
     */
    public function getXianshiGoodsExtendInfo($xianshi_info) {
        $xianshi_info['goods_url'] = urlShop('goods', 'index', array('goods_id' => $xianshi_info['goods_id']));
        $xianshi_info['image_url'] = cthumb($xianshi_info['goods_image'], 60, $xianshi_info['store_id']);
        $xianshi_info['xianshi_price'] = ncPriceFormat($xianshi_info['xianshi_price']);
        $xianshi_info['xianshi_discount'] = number_format($xianshi_info['xianshi_price'] / $xianshi_info['goods_price'] * 10, 1).'折';
        return $xianshi_info;
    }

    /**
     * 获取推荐限时折扣商品
     * @param int $count 推荐数量
     * @return array 推荐限时活动列表
     *
     */
    public function getXianshiGoodsCommendList($count = 4) {
        $condition = array();
        $condition['state'] = self::XIANSHI_GOODS_STATE_NORMAL;
        $condition['start_time'] = array('lt', TIMESTAMP);
        $condition['end_time'] = array('gt', TIMESTAMP);
        $xianshi_list = $this->getXianshiGoodsExtendList($condition, null, 'xianshi_recommend desc', '*', $count);
        return $xianshi_list;
    }

    /**
     * 根据商品编号查询是否有可用限时折扣活动，如果有返回限时折扣活动，没有返回null
     * @param int $goods_id
     * @return array $xianshi_info
     *
     */
    public function getXianshiGoodsInfoByGoodsID($goods_id) {
        $info = $this->_rGoodsXianshiCache($goods_id);
        if(empty($info)) {
            $condition['state'] = self::XIANSHI_GOODS_STATE_NORMAL;
            $condition['end_time'] = array('gt', TIMESTAMP);
            $condition['goods_id'] = $goods_id;
            $xianshi_goods_list = $this->getXianshiGoodsExtendList($condition, null, 'start_time asc', '*', 1);
            $info['info'] = serialize($xianshi_goods_list[0]);
            $this->_wGoodsXianshiCache($goods_id, $info);
        }
        $xianshi_goods_info = unserialize($info['info']);
        if (!empty($xianshi_goods_info) && ($xianshi_goods_info['start_time'] > TIMESTAMP || $xianshi_goods_info['end_time'] < TIMESTAMP)) {
            $xianshi_goods_info = array();
        }
        return $xianshi_goods_info;
    }

    /**
     * 根据商品编号查询是否有可用限时折扣活动，如果有返回限时折扣活动，没有返回null
     * @param string $goods_string 商品编号字符串，例：'1,22,33'
     * @return array $xianshi_goods_list
     *
     */
    public function getXianshiGoodsListByGoodsString($goods_string) {
        $xianshi_goods_list = $this->_getXianshiGoodsListByGoods($goods_string);
        $xianshi_goods_list = array_under_reset($xianshi_goods_list, 'goods_id');
        return $xianshi_goods_list;
    }

    /**
     * 根据商品编号查询是否有可用限时折扣活动，如果有返回限时折扣活动，没有返回null
     * @param string $goods_id_string
     * @return array $xianshi_info
     *
     */
    private function _getXianshiGoodsListByGoods($goods_id_string) {
        $condition = array();
        $condition['state'] = self::XIANSHI_GOODS_STATE_NORMAL;
        $condition['start_time'] = array('lt', TIMESTAMP);
        $condition['end_time'] = array('gt', TIMESTAMP);
        $condition['goods_id'] = array('in', $goods_id_string);
        $xianshi_goods_list = $this->getXianshiGoodsExtendList($condition, null, 'xianshi_goods_id desc', '*');
        return $xianshi_goods_list;
    }
    
    /**
     * 读取商品限时折扣缓存
     * @param int $goods_id
     * @return array/bool
     */
    private function _rGoodsXianshiCache($goods_id) {
        return rcache($goods_id, 'goods_xianshi');
    }
    
    /**
     * 写入商品限时折扣缓存
     * @param int $goods_id
     * @param array $info
     * @return boolean
     */
    private function _wGoodsXianshiCache($goods_id, $info) {
        return wcache($goods_id, $info, 'goods_xianshi');
    }
    
    /**
     * 删除商品限时折扣缓存
     * @param int $goods_id
     * @return boolean
     */
    private function _dGoodsXianshiCache($goods_id) {
        return dcache($goods_id, 'goods_xianshi');
    }
}
