<?php
/**
 * 店铺分类分佣比例
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class store_bind_classModel extends Model{

    public function __construct(){
        parent::__construct('store_bind_class');
    }

	/**
	 * 读取列表 
	 * @param array $condition
	 *
	 */
	public function getStoreBindClassList($condition,$page='',$order='',$field='*'){
        $result = $this->table('store_bind_class')->field($field)->where($condition)->page($page)->order($order)->select();
        return $result;
	}

    /**
	 * 读取单条记录
	 * @param array $condition
	 *
	 */
    public function getStoreBindClassInfo($condition){
        $result = $this->where($condition)->find();
        return $result;
    }

	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
    public function addStoreBindClass($param){
        return $this->insert($param);	
    }
	
	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
    public function addStoreBindClassAll($param){
        return $this->insertAll($param);	
    }
	
	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function editStoreBindClass($update, $condition){
        return $this->where($condition)->update($update);
    }
	
	/*
	 * 删除
	 * @param array $condition
	 * @return bool
	 */
    public function delStoreBindClass($condition){
        return $this->where($condition)->delete();
    }

    /**
     * 总数量
     * @param unknown $condition
     */
    public function getStoreBindClassCount($condition = array()) {
        return $this->where($condition)->count();
    }

    /**
     * 取得店铺下商品分类佣金比例
     * @param array $goods_list
     * @return array 店铺ID=>array(分类ID=>佣金比例)
     */
    public function getStoreGcidCommisRateList($goods_list) {
        if (empty($goods_list) || !is_array($goods_list)) return array();
    
        // 获取绑定所有类目的自营店
        $own_shop_ids = Model('store')->getOwnShopIds(true);

        //定义返回数组
        $store_gc_id_commis_rate = array();

        //取得每个店铺下有哪些商品分类
        $store_gc_id_list = array();
        foreach ($goods_list as $goods) {
            if (!intval($goods['gc_id'])) continue;
            if (!in_array($goods['gc_id'],(array)$store_gc_id_list[$goods['store_id']])) {
                if (in_array($goods['store_id'], $own_shop_ids)) {
                    //平台店铺佣金为0
                    //$store_gc_id_commis_rate[$goods['store_id']][$goods['gc_id']] = 0;
                } else {
                    //$store_gc_id_list[$goods['store_id']][] = $goods['gc_id'];
                }
				//zmrcui>>>>>
				$store_gc_id_list[$goods['store_id']][] = $goods['gc_id'];
				//zmrcui<<<<<
            }
        }

        if (empty($store_gc_id_list)) return $store_gc_id_commis_rate;
        $condition = array();
        foreach ($store_gc_id_list as $store_id => $gc_id_list) {
            $condition['store_id'] = $store_id;
            $condition['class_1|class_2|class_3'] = array('in',$gc_id_list);
            $bind_list = $this->getStoreBindClassList($condition);
			//zmr>>>
			$is_all=false;
			if(!$bind_list)
			{
				$condition = array();
				$condition['store_id'] = $store_id;
				$condition['class_1'] = 0;
				$condition['class_2'] = 0;
				$condition['class_3'] = 0;
                $bind_list = $this->getStoreBindClassList($condition);
				$is_all=true;
			}
			
			//zmr<<<
            if (!empty($bind_list) && is_array($bind_list)) {
                foreach ($bind_list as $bind_info) {
                    if ($bind_info['store_id'] != $store_id) continue;
                    //如果class_1,2,3有一个字段值匹配，就有效
                    $bind_class = array($bind_info['class_3'],$bind_info['class_2'],$bind_info['class_1']);
					if($is_all)
					{
						$bind_class =$gc_id_list;
					}
                    foreach ($gc_id_list as $gc_id) {
                        if (in_array($gc_id,$bind_class)) {
                            $store_gc_id_commis_rate[$store_id][$gc_id] = $bind_info['commis_rate'];
                        }
                    }
                }
            }
        }
        return $store_gc_id_commis_rate;
    }
}
