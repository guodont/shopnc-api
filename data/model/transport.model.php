<?php
/**
 * 运费模板
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class transportModel extends Model {

	public function __construct(){
		parent::__construct();
	}

	/**
	 * 增加运费模板
	 *
	 * @param unknown_type $data
	 * @return unknown
	 */
	public function addTransport($data){
	    return $this->table('transport')->insert($data);
	}

	/**
	 * 增加各地区详细运费设置
	 *
	 * @param unknown_type $data
	 * @return unknown
	 */
	public function addExtend($data){
	    return $this->table('transport_extend')->insertAll($data);
	}

	/**
	 * 取得一条运费模板信息
	 *
	 * @return unknown
	 */
	public function getTransportInfo($condition){
	    return $this->table('transport')->where($condition)->find();
	}

	/**
	 * 取得一条运费模板扩展信息
	 *
	 * @return unknown
	 */
	public function getExtendInfo($condition){
	    return $this->table('transport_extend')->where($condition)->select();
	}

	/**
	 * 删除运费模板
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function delTansport($condition){
	    try {
            $this->beginTransaction();
            $delete = $this->table('transport')->where($condition)->delete();
            if ($delete) {
                $delete = $this->table('transport_extend')->where(array('transport_id'=>$condition['id']))->delete();
            }
            if (!$delete) throw new Exception();
            $this->commit();
        }catch (Exception $e){
            $model->rollback();
            return false;
        }
        return true;
	}

	/**
	 * 删除运费模板扩展信息
	 *
	 * @param unknown_type $transport_id
	 * @return unknown
	 */
	public function delExtend($transport_id){
		return $this->table('transport_extend')->where(array('transport_id'=>$transport_id))->delete();
	}

	/**
	 * 取得运费模板列表
	 *
	 * @param unknown_type $condition
	 * @param unknown_type $page
	 * @param unknown_type $order
	 * @return unknown
	 */
	public function getTransportList($condition=array(), $pagesize = '', $order = 'id desc'){
		return $this->table('transport')->where($condition)->order($order)->page($pagesize)->select();
	}

	/**
	 * 取得扩展信息列表
	 *
	 * @param unknown_type $condition
	 * @param unknown_type $order
	 * @return unknown
	 */
	public function getExtendList($condition=array(), $order='is_default'){
		return $this->table('transport_extend')->where($condition)->order($order)->select();
	}

	public function transUpdate($data){
	    return $this->table('transport')->where($condition)->update($data);
	}

	/**
	 * 检测运费模板是否正在被使用
	 *
	 */
	public function isUsing($id){
        if (!is_numeric($id)) return false;
        $goods_info = $this->table('goods')->where(array('transport_id'=>$id))->field('goods_id')->find();
        return $goods_info ? true : false;
	}
    
	/**
	 * 计算某地区某运费模板ID下的商品总运费，如果运费模板不存在或，按免运费处理
	 *
	 * @param int $transport_id
	 * @param int $buy_num
	 * @param int $area_id
	 * @return number/boolean
	 */
    public function calc_transport($transport_id, $buy_num, $area_id) {
		if (empty($transport_id) || empty($buy_num) || empty($area_id)) return 0;
		$extend_list = $this->getExtendList(array('transport_id'=>$transport_id));
		if (empty($extend_list)) {
		    return 0;
		} else {
		    return $this->calc_unit($area_id,$buy_num,$extend_list);
		}
    }

	/**
	 * 计算某个具单元的运费
	 *
	 * @param 配送地区 $area_id
	 * @param 购买数量 $num
	 * @param 运费模板内容 $extend
	 * @return number 总运费
	 */
	private function calc_unit($area_id, $num, $extend){
		if (!empty($extend) && is_array($extend)){
			foreach ($extend as $v) {
				if (strpos($v['area_id'],",".$area_id.",") !== false){
					if ($num <= $v['snum']){
						//在首件数量范围内
						$calc_total = $v['sprice'];
					}else{
						//超出首件数量范围，需要计算续件
						$calc_total = sprintf('%.2f',($v['sprice'] + ceil(($num-$v['snum'])/$v['xnum'])*$v['xprice']));
					}
				}
				if ($v['is_default']==1){
					if ($num <= $v['snum']){
						//在首件数量范围内
						$calc_default_total = $v['sprice'];
					}else{
						//超出首件数量范围，需要计算续件
						$calc_default_total = sprintf('%.2f',($v['sprice'] + ceil(($num-$v['snum'])/$v['xnum'])*$v['xprice']));
					}
				}
			}
			//如果运费模板中没有指定该地区，取默认运费
			if (!isset($calc_total) && isset($calc_default_total)){
				$calc_total = $calc_default_total;
			}
		}
		return $calc_total;
	}
}
?>
