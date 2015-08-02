<?php
/**
 * 微商城评论模型
 *
 * 
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class micro_member_infoModel extends Model{

    public function __construct(){
        parent::__construct('micro_member_info');
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
	 * 读取列表和用户信息
	 *
	 */
	public function getListWithUserInfo($condition,$page=null,$order='',$field='*',$limit=''){
        $on = 'micro_member_info.member_id = member.member_id';
        $result = $this->table('micro_member_info,member')->field($field)->join('left')->on($on)->where($condition)->page($page)->order($order)->limit($limit)->select();
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

    /**
	 * 根据用户编号读取单条记录
	 * @param int $member_id
	 *
	 */
    public function getOneById($member_id){
        if(intval($member_id) > 0) {
            $result = $this->where(array('member_id'=>$member_id))->find();
            return $result;
        } else {
            return false;
        }
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
	 * 更新用户信息
	 */

    //更新个人中心访问计数
    public function updateMemberVisitCount($member_id, $type = '+', $step = 1){
        return $this->updateMemberInfo($member_id,'visit_count', $type, $step);
    }
    //更新个人秀发布数
    public function updateMemberPersonalCount($member_id, $type = '+', $step = 1){
        return $this->updateMemberInfo($member_id,'personal_count', $type, $step);
    }
    //更新个人秀发布数
    public function updateMemberGoodsCount($member_id, $type = '+', $step = 1){
        return $this->updateMemberInfo($member_id,'goods_count', $type, $step);
    }
    //更新用户信息
    private function updateMemberInfo($member_id, $column, $type, $step = 1){
        if(intval($member_id) <= 0) {
            return 0;
        }
        $param = array();
        $param['member_id'] = $member_id;
        $micro_member_info = self::getOne($param);
        $new_count = 0;
        if(empty($micro_member_info)) {
            //不存在时插入
            $new_count = 1;
            $param[$column] = $step;
            $this->save($param);
        } else {
            //存在时更新
            $update = array();
            if($type != '-') {
                $update[$column] = array('exp',$column.'+'.$step);
                $new_count = $micro_member_info[$column] + $step;
            } else {
                if($micro_member_info[$column] > $step) {
                    $update[$column] = array('exp',$column.'-'.$step);
                    $new_count = $micro_member_info[$column] - $step;
                } else {
                    $update[$column] = 0;
                    $new_count = 0; 
                }
            }
            $this->modify($update,$param);
        }
        return $new_count;
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
