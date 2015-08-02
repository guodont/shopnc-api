<?php
/**
 * cms文章模型
 *
 * 
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class cms_articleModel extends Model{

    public function __construct(){
        parent::__construct('cms_article');
    }

    /**
     * 读取列表 
     * @param array $condition
     *
     */
    public function getList($condition, $page=null, $order='', $field='*', $limit=''){
        $result = $this->table('cms_article')->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
        $this->cls();
        return $result;
    }
    
    /**
     * 文章数量
     * @param array $condition
     * @return int
     */
    public function getCmsArticleCount($condition) {
        return $this->where($condition)->count();
    }

    /**
     * 读取列表和分类名称
     *
     */
    public function getListWithClassName($condition, $page=null, $order='', $field='*', $limit=''){
        $on = 'cms_article.article_class_id = cms_article_class.class_id';
        $result = $this->table('cms_article,cms_article_class')->field($field)->join('left')->on($on)->where($condition)->page($page)->order($order)->limit($limit)->select();
        $this->cls();
        return $result;
    }

    /**
     * 根据tag编号查询
     */
    public function getListByTagID($condition, $page=null, $order='', $field='*', $limit=''){
        $condition['relation_type'] = 1;
        $on = 'cms_article.article_id = cms_tag_relation.relation_object_id';
        $result = $this->table('cms_article,cms_tag_relation')->field($field)->join('left')->on($on)->where($condition)->page($page)->order($order)->limit($limit)->select();
        $this->cls();
        return $result;
    }

    /**
     * 读取单条记录
     * @param array $condition
     *
     */
    public function getOne($condition,$order=''){
        $result = $this->table('cms_article')->where($condition)->order($order)->find();
        return $result;
    }

    /*
     *  判断是否存在 
     *  @param array $condition
     *
     */
    public function isExist($condition) {
        $result = $this->table('cms_article')->getOne($condition);
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
        return $this->table('cms_article')->insert($param);	
    }

    /*
     * 更新
     * @param array $update
     * @param array $condition
     * @return bool
     */
    public function modify($update, $condition){
        return $this->table('cms_article')->where($condition)->update($update);
    }

    /*
     * 删除
     * @param array $condition
     * @return bool
     */
    public function drop($condition){
        $this->drop_article_image($condition);
        return $this->table('cms_article')->where($condition)->delete();
    }

    /**
     * 删除文章图片
     */
    private function drop_article_image($condition) {
        $article_list = self::getList($condition);
        if(!empty($article_list) && is_array($article_list)) {
            foreach ($article_list as $article) {
                if(!empty($article['article_image_all'])) {
                    $attachment_path = $article['article_attachment_path'];
                    $article_image_array = unserialize($article['article_image_all']);
                    if(!empty($article_image_array) && is_array($article_image_array)) {
                        foreach ($article_image_array as $key=>$value) {
                            list($base_name, $ext) = explode('.', $key);
                            $image = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'article'.DS.$attachment_path.DS.$key;
                            $image_list = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'article'.DS.$attachment_path.DS.$base_name.'_list.'.$ext;
                            $image_max = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'article'.DS.$attachment_path.DS.$base_name.'_max.'.$ext;
                            if(is_file($image)) {
                                @unlink($image);
                            }
                            if(is_file($image_list)) {
                                @unlink($image_list);
                            }
                            if(is_file($image_max)) {
                                @unlink($image_max);
                            }
                        }
                    }
                }

            }
        }
    }

}

