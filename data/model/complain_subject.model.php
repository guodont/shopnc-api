<?php
/**
 * 投诉主题模型
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class complain_subjectModel{

	/*
	 * 构造条件
	 */
	private function getCondition($condition){
		$condition_str = '' ;
        if(!empty($condition['complain_subject_state'])) {
            $condition_str .= " and complain_subject_state = '{$condition['complain_subject_state']}'";
        }
        if(!empty($condition['in_complain_subject_id'])) {
            $condition_str .= " and complain_subject_id in (".$condition['in_complain_subject_id'].')';
        }
        return $condition_str;
    }

	/*
	 * 增加
	 * @param array $param
	 * @return bool
	 */
	public function saveComplainSubject($param){

		return Db::insert('complain_subject',$param) ;

	}

	/*
	 * 更新
	 * @param array $update_array
	 * @param array $where_array
	 * @return bool
	 */
	public function updateComplainSubject($update_array, $where_array){

		$where = $this->getCondition($where_array) ;
		return Db::update('complain_subject',$update_array,$where) ;

    }

	/*
	 * 删除
	 * @param array $param
	 * @return bool
	 */
	public function dropComplainSubject($param){

		$where = $this->getCondition($param) ;
		return Db::delete('complain_subject', $where) ;

	}

	/*
	 *  获得投诉主题列表
	 *  @param array $condition
	 *  @param obj $page 	//分页对象
	 *  @return array
	 */
	public function getComplainSubject($condition='',$page=''){

        $param = array() ;
        $param['table'] = 'complain_subject' ;
        $param['where'] = $this->getCondition($condition);
        $param['order'] = $condition['order'] ? $condition['order']: ' complain_subject_id desc ';
        return Db::select($param,$page) ;

	}

	/*
	 *  获得有效投诉主题列表
	 *  @param array $condition
	 *  @param obj $page 	//分页对象
	 *  @return array
	 */
	public function getActiveComplainSubject($condition='',$page='') {

        //搜索条件
        $condition['complain_subject_state'] = 1;
        $param['table'] = 'complain_subject' ;
        $param['where'] = $this->getCondition($condition);
        $param['order'] = $condition['order'] ? $condition['order']: ' complain_subject_id desc ';
        return Db::select($param,$page) ;

	}


}
