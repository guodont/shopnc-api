<?php
/**
 * 意见反馈
 *
 * 
 *
 *
 */

defined('InShopNC') or exit('Access Invalid!');

class mb_feedbackModel extends Model{
    public function __construct(){
        parent::__construct('mb_feedback');
    }

	/**
	 * 列表
	 *
	 * @param array $condition 查询条件
	 * @param int $page 分页数
	 * @param string $order 排序
     * @return array
	 */
	public function getMbFeedbackList($condition, $page = null, $order = 'id desc'){
        $list = $this->where($condition)->page($page)->order($order)->select();
		return $list;
	}

	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addMbFeedback($param){
        return $this->insert($param);	
	}
	
	/**
	 * 删除
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function delMbFeedback($id){
        $condition = array('id' => array('in', $id));
        return $this->where($condition)->delete();
	}	
}
