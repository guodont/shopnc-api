<?php
/**
 * 闲置物品类别模型
 *by 3 3hao .com 
 */
defined('InShopNC') or exit('Access Invalid!');
class member_disciplineModel{
	/**
	 * 类别列表
	 *
	 * @param array $condition 检索条件
	 * @return array 数组结构的返回结果
	 */
	public function getClassList($condition){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'member_discipline';
		$param['where'] = $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'discipline_parent_id asc,discipline_sort asc,discipline_id asc';
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

		if ($condition['discipline_parent_id'] != ''){
			$condition_str .= " and discipline_parent_id = '". intval($condition['discipline_parent_id']) ."'";
		}
		if ($condition['no_discipline_id'] != ''){
			$condition_str .= " and discipline_id != '". intval($condition['no_discipline_id']) ."'";
		}
		if ($condition['discipline_id'] != ''){
			$condition_str .= " and discipline_id = '". intval($condition['discipline_id']) ."'";
		}
		if ($condition['discipline_name'] != ''){
			$condition_str .= " and discipline_name = '". $condition['discipline_name'] ."'";
		}
		if ($condition['discipline_show'] != '') {
			$condition_str .= " and discipline_show=".$condition['discipline_show'];
		}

		return $condition_str;
	}

	/**
	 * 取单个学科的内容
	 *
	 * @param int $id 学科ID
	 * @return array 数组类型的返回结果
	 */
	public function getOnedisciplineClass($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'member_discipline';
			$param['field'] = 'discipline_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 取指定学科ID的导航链接
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
			$class = self::getOnedisciplineClass(intval($id));
			/**
			 * 是否是子类
			 */
			if ($class['discipline_parent_id'] != 0){
				$parent_1 = self::getOnedisciplineClass($class['discipline_parent_id']);
				if ($parent_1['discipline_parent_id'] != 0){
					$parent_2 = self::getOnedisciplineClass($parent_1['discipline_parent_id']);
					if ($parent_2['discipline_parent_id'] != 0){
						$parent_3 = self::getOnedisciplineClass($parent_2['discipline_parent_id']);
						$nav_link[] = array('name'=>$parent_3['discipline_name'],'discipline_id'=>$parent_3['discipline_id']);
					}
					$nav_link[] = array('name'=>$parent_2['discipline_name'],'discipline_id'=>$parent_2['discipline_id']);
				}
				$nav_link[] = array('name'=>$parent_1['discipline_name'],'discipline_id'=>$parent_1['discipline_id']);
			}
			$nav_link[] = array('name'=>$class['discipline_name'],'discipline_id'=>$id);
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
			$result = Db::insert('member_discipline',$tmp);
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
			$where = " discipline_id = '". $param['discipline_id'] ."'";
			$result = Db::update('member_discipline',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 删除学科
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function del($id){
		if (intval($id) > 0){
			$where = " discipline_id = '". intval($id) ."'";
			$result = Db::delete('member_discipline',$where);
			return $result;
		}else {
			return false;
		}
	}


	/**
	 * 取学科列表，按照深度归类
	 *
	 * @param int $show_deep 显示深度 为空 则为不限制
	 * @return array 数组类型的返回结果
	 */
	public function getTreedisciplineList($show_deep='',$condition=array()){
		$discipline_list = $this->getClassList($condition);

		$result = $this->_getTreedisciplineList('0',$discipline_list);
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
	 * 递归 整理学科
	 *
	 * @param int $parent_id 父ID
	 * @param array $discipline_list 类别内容集合
	 * @param int $deep 深度
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	private function _getTreedisciplineList($parent_id,$discipline_list, $deep=1){
		if (is_array($discipline_list)){
			foreach ($discipline_list as $k => $v){
				if ($v['discipline_parent_id'] == $parent_id){
					$v['deep'] = $deep;
					$result[] = $v;
					$tmp = $this->_getTreedisciplineList($v['discipline_id'], $discipline_list,$deep+1);
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
	 * 取指定学科ID下的所有子类
	 *
	 * @param int/array $parent_id 父ID 可以单一可以为数组
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function getChildClass($parent_id){
		$condition = array('order'=>'discipline_parent_id asc,discipline_sort asc,discipline_id asc');
		$all_class = $this->getClassList($condition);
		if (is_array($all_class)){
			if (!is_array($parent_id)){
				$parent_id = array($parent_id);
			}
			$result = array();
			foreach ($all_class as $k => $v){
				$discipline_id	= $v['discipline_id'];//返回的结果包括父类
				$discipline_parent_id	= $v['discipline_parent_id'];
				if (in_array($discipline_id,$parent_id) || in_array($discipline_parent_id,$parent_id)){
					$parent_id[] = $v['discipline_id'];
					$result[] = $v;
				}
			}
			return $result;
		}else {
			return false;
		}
	}
    /**
     * 获取指定学科的所有下一级别学科
     */
    public function getNextLevelGoodsClassById($discipline_id) {
        $param = array();
        $param['table'] = 'member_discipline';
        $param['where'] = ' and discipline_parent_id = '.$discipline_id;
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
			$result = Db::update('member_discipline_index',$tmp,$where);
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
		$param['table'] = 'member_discipline_index';
		$param['where'] = $condition_str;
		$result = Db::select($param);
		return $result;			
	}
}