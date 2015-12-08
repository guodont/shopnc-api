<?php
/**
 * 闲置物品类别模型
 *by 3 3hao .com 
 */
defined('InShopNC') or exit('Access Invalid!');
class member_departModel{
	/**
	 * 类别列表
	 *
	 * @param array $condition 检索条件
	 * @return array 数组结构的返回结果
	 */
	public function getdepartList($condition){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'member_depart';
		$param['where'] = $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'depart_parent_id asc,depart_sort asc,depart_id asc';
		$result = Db::select($param);
		return $result;
	}
	/**
	 * 构造检索条件
	 *
	 * @param int $id 记录ID
	 * @return string 字符串类型的返回结果
	 */
	private function _condition($condition){
		$condition_str = '';

		if ($condition['depart_parent_id'] != ''){
			$condition_str .= " and depart_parent_id = '". intval($condition['depart_parent_id']) ."'";
		}
		if ($condition['no_gc_id'] != ''){
			$condition_str .= " and depart_id != '". intval($condition['no_gc_id']) ."'";
		}
		if ($condition['depart_id'] != ''){
			$condition_str .= " and depart_id = '". intval($condition['depart_id']) ."'";
		}
		if ($condition['depart_name'] != ''){
			$condition_str .= " and depart_name = '". $condition['depart_name'] ."'";
		}
		if ($condition['depart_show'] != '') {
			$condition_str .= " and depart_show=".$condition['depart_show'];
		}

		return $condition_str;
	}

	/**
	 * 取单个单位的内容
	 *
	 * @param int $id 单位ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneGoodsClass($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'member_depart';
			$param['field'] = 'depart_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 取指定单位ID的导航链接
	 *
	 * @param int $id 父类ID/子类ID
	 * @return array $nav_link 返回数组形式类别导航连接
	 */
	public function getGoodsClassNow($id = 0){
		/**
		 * 初始化链接数组
		 */
		if (intval($id) > 0){
			/**
			 * 取当前类别信息
			 */
			$class = self::getOneGoodsClass(intval($id));
			/**
			 * 是否是子类
			 */
			if ($class['depart_parent_id'] != 0){
				$parent_1 = self::getOneGoodsClass($class['depart_parent_id']);
				if ($parent_1['depart_parent_id'] != 0){
					$parent_2 = self::getOneGoodsClass($parent_1['depart_parent_id']);
					if ($parent_2['depart_parent_id'] != 0){
						$parent_3 = self::getOneGoodsClass($parent_2['depart_parent_id']);
						$nav_link[] = array('name'=>$parent_3['depart_name'],'depart_id'=>$parent_3['depart_id']);
					}
					$nav_link[] = array('name'=>$parent_2['depart_name'],'depart_id'=>$parent_2['depart_id']);
				}
				$nav_link[] = array('name'=>$parent_1['depart_name'],'depart_id'=>$parent_1['depart_id']);
			}
			$nav_link[] = array('name'=>$class['depart_name'],'depart_id'=>$id);
		}
		return $nav_link;
	}

	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function add($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('member_depart',$tmp);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function update($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$where = " depart_id = '". $param['depart_id'] ."'";
			$result = Db::update('member_depart',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 删除单位
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function del($id){
		if (intval($id) > 0){
			$where = " depart_id = '". intval($id) ."'";
			$result = Db::delete('member_depart',$where);
			return $result;
		}else {
			return false;
		}
	}


	/**
	 * 取单位列表，按照深度归类
	 *
	 * @param int $show_deep 显示深度 为空 则为不限制
	 * @return array 数组类型的返回结果
	 */
	public function getTreedepartList($show_deep='',$condition=array()){
		$depart_list = $this->getdepartList($condition);

		$result = $this->_getTreedepartList('0',$depart_list);
		if (is_array($result)){
			if (!empty($show_deep)){
				foreach ($result as $k => $v){
					if ($v['deep'] > $show_deep){
						unset($result[$k]);
					}
				}
			}

		}
		return $result;
	}

	/**
	 * 递归 整理单位
	 *
	 * @param int $parent_id 父ID
	 * @param array $depart_list 类别内容集合
	 * @param int $deep 深度
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	private function _getTreedepartList($parent_id,$depart_list, $deep=1){
		if (is_array($depart_list)){
			foreach ($depart_list as $k => $v){
				if ($v['depart_parent_id'] == $parent_id){
					$v['deep'] = $deep;
					$result[] = $v;
					$tmp = $this->_getTreedepartList($v['depart_id'], $depart_list,$deep+1);
					if (!empty($tmp)){
						$result = @array_merge($result,$tmp);
					}
					unset($tmp);
				}
			}
		}
		return $result;
	}

	/**
	 * 取指定单位ID下的所有子类
	 *
	 * @param int/array $parent_id 父ID 可以单一可以为数组
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function getChildClass($parent_id){
		$condition = array('order'=>'depart_parent_id asc,depart_sort asc,depart_id asc');
		$all_class = $this->getdepartList($condition);
		if (is_array($all_class)){
			if (!is_array($parent_id)){
				$parent_id = array($parent_id);
			}
			$result = array();
			foreach ($all_class as $k => $v){
				$depart_id	= $v['depart_id'];//返回的结果包括父类
				$depart_parent_id	= $v['depart_parent_id'];
				if (in_array($depart_id,$parent_id) || in_array($depart_parent_id,$parent_id)){
					$parent_id[] = $v['depart_id'];
					$result[] = $v;
				}
			}
			return $result;
		}else {
			return false;
		}
	}
    /**
     * 获取指定单位的所有下一级别单位
     */
    public function getNextLevelGoodsClassById($depart_id) {
        $param = array();
        $param['table'] = 'member_depart';
        $param['where'] = ' and depart_parent_id = '.$depart_id;
        return Db::select($param);
    }
}