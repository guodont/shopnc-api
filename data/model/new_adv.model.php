<?php

/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15/11/9
 * Time: 下午3:30
 */
class new_adv extends Model
{

    /**
     * 缓存数据
     */
    protected $cachedData;

    public function __construct()
    {
        parent::__construct('adv');
    }

    public function getCache() {
        if ($this->cachedData) {
            return $this->cachedData;
        }
        $data = rkcache('adv');
        if (!$data) {
            $data = array();
            foreach ((array) $this->getList(array()) as $v) {
                $id = $v['adv_id'];
                $data['data'][$id] = $v;
            }
            wkcache('adv', $data);
        }
        return $this->cachedData = $data;
    }

    public function getList($condition=array(), $page='', $field, $limit='', $order='slide_sort, adv_id desc', $count = 0){
        return $this->table('adv')->field($field)->where($condition)->order($order)->limit($limit)->page($page, $count)->select();
    }


}