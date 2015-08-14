<?php
/**
 * 店铺消息模板模型
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class store_msgModel extends Model{
    public function __construct() {
        parent::__construct('store_msg');
    }
    /**
     * 新增店铺消息
     * @param unknown $insert
     */
    public function addStoreMsg($insert) {
        $time = time();
        $insert['sm_addtime'] = $time;
        $sm_id = $this->insert($insert);
        if (C('node_chat')) {
            @file_get_contents(NODE_SITE_URL.'/store_msg/?id='.$sm_id.'&time='.$time);
        }
        return $sm_id;
    }

    /**
     * 更新店铺消息表
     * @param unknown $condition
     * @param unknown $update
     */
    public function editStoreMsg($condition, $update) {
        return $this->where($condition)->update($update);
    }

    /**
     * 查看店铺消息详细
     * @param unknown $condition
     * @param string $field
     */
    public function getStoreMsgInfo($condition, $field = '*') {
        return $this->field($field)->where($condition)->find();

    }

    /**
     * 店铺消息列表
     * @param unknown $condition
     * @param string $field
     * @param string $page
     * @param string $order
     */
    public function getStoreMsgList($condition, $field = '*', $page = '0', $order = 'sm_id desc') {
        return $this->field($field)->where($condition)->order($order)->page($page)->select();
    }

    /**
     * 计算消息数量
     * @param unknown $condition
     */
    public function getStoreMsgCount($condition) {
        return $this->where($condition)->count();
    }

    /**
     * 删除店铺消息
     * @param unknown $condition
     */
    public function delStoreMsg($condition) {
        $this->where($condition)->delete();
    }
}