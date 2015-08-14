<?php
/**
 * 微商城喜欢模型
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class micro_likeModel extends Model{

    public function __construct(){
        parent::__construct('micro_like');
    }

	/**
	 * 读取列表 
	 * @param array $condition
	 *
	 */
	public function getList($condition,$page=null,$order='',$field='*'){
        $result = $this->field($field)->where($condition)->page($page)->order($order)->select();
        return $result;
	}

    /**
     * 喜欢随心看列表
     */
    public function getGoodsList($condition,$page=null,$order='',$field='*') {
        $on = 'micro_goods.commend_id = micro_like.like_object_id,micro_goods.commend_member_id=member.member_id';
        $result = $this->table('micro_goods,micro_like,member')->field($field)->join('left')->on($on)->where($condition)->page($page)->order($order)->select();
        return $result;
    }

    /**
     * 喜欢个人秀列表
     */
    public function getPersonalList($condition,$page=null,$order='',$field='*') {
        $on = 'micro_personal.personal_id = micro_like.like_object_id,micro_personal.commend_member_id=member.member_id';
        $result = $this->table('micro_personal,micro_like,member')->field($field)->join('left')->on($on)->where($condition)->page($page)->order($order)->select();
        return $result;
    }

    /**
     * 喜欢店铺列表
     */
    public function getStoreList($condition,$page=null,$order='',$field='*') {
        $result = $this->table('micro_like')->field($field)->where($condition)->page($page)->order($order)->select();
        return $result;
    }

    /**
	 * 读取单条记录
	 * @param array $condition
	 *
	 */
    public function getOne($condition){
        $result = $this->where($condition)->find();
        return $result;
    }

	/*
	 *  判断是否存在 
	 *  @param array $condition
     *
	 */
	public function isExist($condition) {
        $result = $this->getOne($condition);
        if(empty($result)) {
            return FALSE;
        }
        else {
            return TRUE;
        }
	}

	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
    public function save($param){
        return $this->insert($param);	
    }
	
	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
    public function saveAll($param){
        return $this->insertAll($param);	
    }
	
	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function modify($update, $condition){
        return $this->where($condition)->update($update);
    }
	
	/*
	 * 删除
	 * @param array $condition
	 * @return bool
	 */
    public function drop($condition){
        return $this->where($condition)->delete();
    }
	
}
