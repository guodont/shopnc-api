<?php
/**
 * SNS功能商品
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class sns_goodsModel extends Model{
    public function __construct(){
        parent::__construct('sns_goods');
    }
    /**
     * 查询SNS商品详细
     * 
     * @param array $condition
     * @param string $field
     * @return array
     */
    public function getSNSGoodsInfo($condition, $field = '*'){
        $result = $this->field($field)->where($condition)->find();
        return $result;
    }
	/**
	 * 新增SNS商品
	 *
	 * @param $param 添加信息数组
	 * @return 返回结果
	 */
	public function goodsAdd($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$result = Db::insert('sns_goods',$param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 查询SNS商品详细
	 * 
	 * @param $condition 查询条件
	 * @param $field 查询字段
	 */
	public function getGoodsInfo($condition,$field='*'){
		$param = array();
		$param['table'] = 'sns_goods';
		$param['field'] = array_keys($condition);
		$param['value'] = array_values($condition);
		return Db::getRow($param,$field);
	}
	/**
	 * 更新SNS商品信息
	 * @param $param 更新内容
	 * @param $condition 更新条件
	 */
	public function editGoods($param,$condition) {
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$result	= Db::update('sns_goods',$param,$condition_str);
		return $result;
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		//商品ID
		if ($condition_array['snsgoods_goodsid'] != '') {
			$condition_sql	.= " and `sns_goods`.snsgoods_goodsid = '{$condition_array['snsgoods_goodsid']}'";
		}
		return $condition_sql;
	}
}