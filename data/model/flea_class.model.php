<?php
/**
 * 闲置物品类别模型
 *by 3 3hao .com 
 */
defined('InShopNC') or exit('Access Invalid!');
class flea_classModel{
	/**
	 * 类别列表
	 *
	 * @param array $condition 检索条件
	 * @return array 数组结构的返回结果
	 */
	public function getClassList($condition){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'flea_class';
		$param['where'] = $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'gc_parent_id asc,gc_sort asc,gc_id asc';
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

		if ($condition['gc_parent_id'] != ''){
			$condition_str .= " and gc_parent_id = '". intval($condition['gc_parent_id']) ."'";
		}
		if ($condition['no_gc_id'] != ''){
			$condition_str .= " and gc_id != '". intval($condition['no_gc_id']) ."'";
		}
		if ($condition['gc_id'] != ''){
			$condition_str .= " and gc_id = '". intval($condition['gc_id']) ."'";
		}
		if ($condition['gc_name'] != ''){
			$condition_str .= " and gc_name = '". $condition['gc_name'] ."'";
		}
		if ($condition['gc_show'] != '') {
			$condition_str .= " and gc_show=".$condition['gc_show'];
		}

		return $condition_str;
	}

	/**
	 * 取单个分类的内容
	 *
	 * @param int $id 分类ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneGoodsClass($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'flea_class';
			$param['field'] = 'gc_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 取指定分类ID的导航链接
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
			if ($class['gc_parent_id'] != 0){
				$parent_1 = self::getOneGoodsClass($class['gc_parent_id']);
				if ($parent_1['gc_parent_id'] != 0){
					$parent_2 = self::getOneGoodsClass($parent_1['gc_parent_id']);
					if ($parent_2['gc_parent_id'] != 0){
						$parent_3 = self::getOneGoodsClass($parent_2['gc_parent_id']);
						$nav_link[] = array('name'=>$parent_3['gc_name'],'gc_id'=>$parent_3['gc_id']);
					}
					$nav_link[] = array('name'=>$parent_2['gc_name'],'gc_id'=>$parent_2['gc_id']);
				}
				$nav_link[] = array('name'=>$parent_1['gc_name'],'gc_id'=>$parent_1['gc_id']);
			}
			$nav_link[] = array('name'=>$class['gc_name'],'gc_id'=>$id);
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
			$result = Db::insert('flea_class',$tmp);
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
			$where = " gc_id = '". $param['gc_id'] ."'";
			$result = Db::update('flea_class',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 删除分类
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function del($id){
		if (intval($id) > 0){
			$where = " gc_id = '". intval($id) ."'";
			$result = Db::delete('flea_class',$where);
			return $result;
		}else {
			return false;
		}
	}


	/**
	 * 取分类列表，按照深度归类
	 *
	 * @param int $show_deep 显示深度 为空 则为不限制
	 * @return array 数组类型的返回结果
	 */
	public function getTreeClassList($show_deep='',$condition=array()){
		$class_list = $this->getClassList($condition);

		$result = $this->_getTreeClassList('0',$class_list);
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
	 * 递归 整理分类
	 *
	 * @param int $parent_id 父ID
	 * @param array $class_list 类别内容集合
	 * @param int $deep 深度
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	private function _getTreeClassList($parent_id,$class_list, $deep=1){
		if (is_array($class_list)){
			foreach ($class_list as $k => $v){
				if ($v['gc_parent_id'] == $parent_id){
					$v['deep'] = $deep;
					$result[] = $v;
					$tmp = $this->_getTreeClassList($v['gc_id'], $class_list,$deep+1);
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
	 * 取指定分类ID下的所有子类
	 *
	 * @param int/array $parent_id 父ID 可以单一可以为数组
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function getChildClass($parent_id){
		$condition = array('order'=>'gc_parent_id asc,gc_sort asc,gc_id asc');
		$all_class = $this->getClassList($condition);
		if (is_array($all_class)){
			if (!is_array($parent_id)){
				$parent_id = array($parent_id);
			}
			$result = array();
			foreach ($all_class as $k => $v){
				$gc_id	= $v['gc_id'];//返回的结果包括父类
				$gc_parent_id	= $v['gc_parent_id'];
				if (in_array($gc_id,$parent_id) || in_array($gc_parent_id,$parent_id)){
					$parent_id[] = $v['gc_id'];
					$result[] = $v;
				}
			}
			return $result;
		}else {
			return false;
		}
	}
    /**
     * 获取指定分类的所有下一级别分类
     */
    public function getNextLevelGoodsClassById($gc_id) {
        $param = array();
        $param['table'] = 'flea_class';
        $param['where'] = ' and gc_parent_id = '.$gc_id;
        return Db::select($param);
    }
	/**
	 * 更新闲置主页显示
	 */
	public function setFleaIndexClass($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			if($param['fc_index_id1']!=''){$tmp['fc_index_id1'] = $param['fc_index_id1'];}
			if($param['fc_index_id2']!=''){$tmp['fc_index_id2'] = $param['fc_index_id2'];}
			if($param['fc_index_id3']!=''){$tmp['fc_index_id3'] = $param['fc_index_id3'];}
			if($param['fc_index_id4']!=''){$tmp['fc_index_id4'] = $param['fc_index_id4'];}
			if($param['fc_index_name1']!=''){$tmp['fc_index_name1'] = $param['fc_index_name1'];}
			if($param['fc_index_name2']!=''){$tmp['fc_index_name2'] = $param['fc_index_name2'];}
			if($param['fc_index_name3']!=''){$tmp['fc_index_name3'] = $param['fc_index_name3'];}
			if($param['fc_index_name4']!=''){$tmp['fc_index_name4'] = $param['fc_index_name4'];}
			$where = " fc_index_code = '". $param['fc_index_code'] ."'";
			$result = Db::update('flea_class_index',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 查询闲置主页显示设置
	 */
	public function getFleaIndexClass($condition,$field='*'){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'flea_class_index';
		$param['where'] = $condition_str;
		$result = Db::select($param);
		return $result;			
	}
}