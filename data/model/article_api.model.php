<?php
/**
 * 文章管理
 *
 *
 *
 *

 */
defined('InShopNC') or exit('Access Invalid!');

class article_apiModel extends Model
{
    /**
     * article_apiModel constructor.
     */
    public function __construct()
    {
        parent::__construct('article');
    }


    /**
     * 获取文章列表
     * @param $condition
     * @param null $page
     * @param string $order
     * @param string $field
     * @param string $limit
     * @return mixed
     */
    public function listArticle($condition, $page=null, $order='article_time desc', $field='*', $limit=''){
        $result = $this->table('article')->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
        $this->cls();
        return $result;
    }

}