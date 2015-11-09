<?php

/**
 * Created by PhpStorm.
 * User: guodont
 * Date: 15/11/9
 * Time: 下午3:30
 */
defined('InShopNC') or exit('Access Invalid!');

class new_advModel extends Model
{
    public function __construct()
    {
        parent::__construct('adv');
    }

    public function getList($condition=array(), $page='', $field, $limit='', $order='slide_sort, adv_id desc', $count = 0){
        return $this->table('adv')->field($field)->where($condition)->order($order)->limit($limit)->page($page, $count)->select();
    }

}