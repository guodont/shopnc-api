<?php
/**
 * 任务计划 - 全文搜索
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class xsControl {
    private $_doc;
    private $_xs;
    private $_index;
    private $_search;

    /**
     * 初始化对象
     */
    public function __construct(){
        register_shutdown_function(array($this,"shutdown"));
        if (!C('fullindexer.open')) exit();
        require(BASE_DATA_PATH.'/api/xs/lib/XS.php');
        $this->_doc = new XSDocument();
        $this->_xs = new XS(C('fullindexer.appname'));
        $this->_index = $this->_xs->index;
        $this->_search = $this->_xs->search;
        $this->_search->setCharset(CHARSET);
    }

    /**
     * 全量创建索引
     */
    public function createOp() {
        //每次批量更新商品数
        $step_num = 100;
        $model_goods = Model('goods');
        $count = $model_goods->getGoodsOnlineCount(array(),"distinct CONCAT(goods_commonid,',',color_id)");
        $fields = "*,CONCAT(goods_commonid,',',color_id) as nc_distinct";
        for ($i = 0; $i <= $count; $i = $i + $step_num){
            $goods_list = $model_goods->getGoodsOnlineList(array(), $fields, 0, '', "{$i},{$step_num}", 'nc_distinct');
            $this->_build_goods($goods_list);
        }
    }

    /**
     * 更新增量索引
     */
    public function updateOp() {
        //更新多长时间内的新增(编辑)商品信息，该时间一般与定时任务触发间隔时间一致,单位是秒,默认3600
        $step_time = 3600;
        //每次批量更新商品数
        $step_num = 100;

        $model_goods = Model('goods');
        $condition = array();
        $condition['goods_edittime'] = array('egt',TIMESTAMP-$step_time);
        $count = $model_goods->getGoodsOnlineCount($condition,"distinct CONCAT(goods_commonid,',',color_id)");
        $fields = "*,CONCAT(goods_commonid,',',color_id) as nc_distinct";
        for ($i = 0; $i <= $count; $i = $i + $step_num){
            $goods_list = $model_goods->getGoodsOnlineList($condition, $fields, 0, '', "{$i},{$step_num}", 'nc_distinct');
            $this->_build_goods($goods_list);
        }
    }

    /**
     * 索引商品数据
     * @param array $goods_list
     */
    private function _build_goods($goods_list = array()) {
        if (!empty($goods_list) && !is_array($goods_list)) return;
        $goods_class = H('goods_class') ? H('goods_class') : H('goods_class', true);

        $goods_commonid_array = array();
        $goods_id_array = array();
        foreach ($goods_list as $k => $v) {
            $goods_commonid_array[] = $v['goods_commonid'];
            $goods_id_array[] = $v['goods_id'];
        }
        
        //取common表内容
        $model_goods = Model('goods');
        $condition_common = array();
        $condition_common['goods_commonid'] = array('in',$goods_commonid_array);
        $goods_common_list = $model_goods->getGoodsCommonOnlineList($condition_common,'*',0);
        $goods_common_new_list = array();
        foreach($goods_common_list as $k => $v) {
            $goods_common_new_list[$v['goods_commonid']] = $v;
        }

        //取属性表值
        $model_type = Model('type');
        $attr_list = $model_type->getGoodsAttrIndexList(array('goods_id'=>array('in',$goods_id_array)),0,'goods_id,attr_value_id');
        if (is_array($attr_list) && !empty($attr_list)) {
            $attr_value_list = array();
            foreach ($attr_list as $val) {
                $attr_value_list[$val['goods_id']][] = $val['attr_value_id'];
            }
        }
        //整理需要索引的数据
        foreach ($goods_list as $k => $v) {
            $gc_id = $v['gc_id'];
            $depth = $goods_class[$gc_id]['depth'];
            if ($depth == 3) {
                $cate_3 = $gc_id; $gc_id = $goods_class[$gc_id]['gc_parent_id']; $depth--;
            }
            if ($depth == 2) {
                $cate_2 = $gc_id; $gc_id = $goods_class[$gc_id]['gc_parent_id']; $depth--;
            }
            if ($depth == 1) {
                $cate_1 = $gc_id; $gc_id = $goods_class[$gc_id]['gc_parent_id'];
            }
            $index_data = array();
            $index_data['pk'] = $v['goods_id'];
            $index_data['goods_id'] = $v['goods_id'];
            $index_data['goods_name'] = $v['goods_name'].$v['goods_jingle'];
            $index_data['brand_id'] = $v['brand_id'];
            $index_data['goods_price'] = $v['goods_promotion_price'];
            $index_data['goods_click'] = $v['goods_click'];
            $index_data['goods_salenum'] = $v['goods_salenum'];
            $index_data['store_id'] = $v['store_id'] == DEFAULT_PLATFORM_STORE_ID ? 1 : 2;
            $index_data['area_id'] = $v['areaid_1'];
            $index_data['gc_id'] = $v['gc_id'];
            $index_data['gc_name'] = str_replace('&gt;','',$goods_common_new_list[$v['goods_commonid']]['gc_name']);
            $index_data['brand_name'] = $goods_common_new_list[$v['goods_commonid']]['brand_name'];
            if (!empty($attr_value_list[$v['goods_id']])) {
                $index_data['attr_id'] = implode('_',$attr_value_list[$v['goods_id']]);
            }
            if (!empty($cate_1)) {
                $index_data['cate_1'] = $cate_1;
            }
            if (!empty($cate_2)) {
                $index_data['cate_2'] = $cate_2;
            }
            if (!empty($cate_3)) {
                $index_data['cate_3'] = $cate_3;
            }
            //添加到索引库
            $this->_doc->setFields($index_data);
            $this->_index->update($this->_doc);
        }
    }

    public function clearOp(){
        try {
            $this->_index->clean();
        } catch (XSException $e) {
            print_R($e->getMessage());exit;
        }
    }

    /**
     * 执行完成提示信息
     *
     */
    public function shutdown(){
        exit("success at ".date('Y-m-d H:i:s',TIMESTAMP)."\n");
    }
}