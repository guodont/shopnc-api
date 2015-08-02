<?php
/**
 * 卖家账号组模型
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class seller_groupModel extends Model{

    public function __construct(){
        parent::__construct('seller_group');
    }

	/**
	 * 读取列表 
	 * @param array $condition
	 *
	 */
	public function getSellerGroupList($condition, $page='', $order='', $field='*') {
        $result = $this->field($field)->where($condition)->page($page)->order($order)->select();
        return $result;
	}

    /**
	 * 读取单条记录
	 * @param array $condition
	 *
	 */
    public function getSellerGroupInfo($condition) {
        $result = $this->where($condition)->find();
        return $result;
    }

	/*
	 *  判断是否存在 
	 *  @param array $condition
     *
	 */
	public function isSellerGroupExist($condition) {
        $result = $this->getOne($condition);
        if(empty($result)) {
            return FALSE;
        } else {
            return TRUE;
        }
	}

	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
    public function addSellerGroup($param){
        return $this->insert($param);	
    }
	
	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function editSellerGroup($update, $condition){
        return $this->where($condition)->update($update);
    }
	
	/*
	 * 删除
	 * @param array $condition
	 * @return bool
	 */
    public function delSellerGroup($condition){
        return $this->where($condition)->delete();
    }
	
}
