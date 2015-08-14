<?php
/**
 * 抢购搜索价格区间模型
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class groupbuy_price_rangeModel{

    //表名
    const TABLE_NAME = 'groupbuy_price_range';
    //主键
    const PK = 'range_id';

    /**
     * 构造检索条件
     *
     * @param array $condition 检索条件
     * @return string 
     */
    private function getCondition($condition){
        $condition_str = '';
        if (!empty($condition['range_id'])){
            $condition_str .= " AND range_id = '".$condition['range_id']."'";
        }
        if (!empty($condition['in_range_id'])){
            $condition_str .= " AND range_id in (". $condition['in_range_id'] .")";
        }
        return $condition_str;
    }

    /**
     * 读取列表 
     *
     */
    public function getList($condition = array(), $page = ''){

        $param = array() ;
        $param['table'] = self::TABLE_NAME ;
        $param['where'] = $this->getCondition($condition);
        $param['order'] = $condition['order'] ? $condition['order']: ' '.self::PK.' desc ';
        return Db::select($param,$page);
    }


    /**
     * 根据编号获取单个内容
     *
     * @param int 主键编号 
     * @return array 数组类型的返回结果
     */
    public function getOne($id){
        if (intval($id) > 0){
            $param = array();
            $param['table'] = self::TABLE_NAME;
            $param['field'] = self::PK;
            $param['value'] = intval($id);
            $result = Db::getRow($param);
            return $result;
        }else {
            return false;
        }
    }

    /*
     *  判断是否存在 
     *  @param array $condition
     *  @param obj $page 	//分页对象
     *  @return array
     */
    public function isExist($condition='') {

        $param = array() ;
        $param['table'] = self::TABLE_NAME ;
        $param['where'] = $this->getCondition($condition);
        $list = Db::select($param);
        if(empty($list)) {
            return false;
        }
        else {
            return true;
        }
    }

    /*
     * 增加 
     * @param array $param
     * @return bool
     */
    public function save($param){

        return Db::insert(self::TABLE_NAME,$param) ;

    }

    /*
     * 更新
     * @param array $update_array
     * @param array $where_array
     * @return bool
     */
    public function update($update_array, $where_array){

        $where = $this->getCondition($where_array) ;
        return Db::update(self::TABLE_NAME,$update_array,$where) ;

    }

    /*
     * 删除
     * @param array $param
     * @return bool
     */
    public function drop($param){

        $where = $this->getCondition($param) ;
        return Db::delete(self::TABLE_NAME, $where) ;
    }

}
