<?php
/**
 * cms资源模型
 *
 * 
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class resources_listModel extends Model{

    public function __construct(){
        parent::__construct('resources');
    }

    /**
     * 读取列表 
     * @param array $condition
     *
     */
    public function getList($condition, $page=null, $order='', $field='*', $limit=''){
        $result = $this->table('resources')->field($field)->where($condition)->page($page)->order($order)->limit($limit)->select();
        $this->cls();
        return $result;
    }
    
    /**
     * 资源数量
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
        $on = 'resources.resources_class_id = resources_class.gc_id';
        $result = $this->table('resources,resources_class')->field($field)->join('left')->on($on)->where($condition)->page($page)->order($order)->limit($limit)->select();
        $this->cls();
        return $result;
    }

    /**
     * 根据tag编号查询
     */
    public function getListByTagID($condition, $page=null, $order='', $field='*', $limit=''){
        $condition['relation_type'] = 1;
        $on = 'resources.resources_id = cms_tag_relation.relation_object_id';
        $result = $this->table('resources,cms_tag_relation')->field($field)->join('left')->on($on)->where($condition)->page($page)->order($order)->limit($limit)->select();
        $this->cls();
        return $result;
    }

    /**
     * 读取单条记录
     * @param array $condition
     *
     */
    public function getOne($condition,$order=''){
        $result = $this->table('resources')->where($condition)->order($order)->find();
        return $result;
    }

    /*
     *  判断是否存在 
     *  @param array $condition
     *
     */
    public function isExist($condition) {
        $result = $this->table('resources')->getOne($condition);
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
        return $this->table('resources')->insert($param);	
    }

    /*
     * 更新
     * @param array $update
     * @param array $condition
     * @return bool
     */
    public function modify($update, $condition){
        return $this->table('resources')->where($condition)->update($update);
    }

    /*
     * 删除
     * @param array $condition
     * @return bool
     */
    public function drop($condition){
        $this->drop_resources_image($condition);
        return $this->table('resources')->where($condition)->delete();
    }

    /**
     * 删除资源图片
     */
    private function drop_resources_image($condition) {
        $resources_list = self::getList($condition);
        if(!empty($resources_list) && is_array($resources_list)) {
            foreach ($resources_list as $resources) {
                if(!empty($resources['resources_image_all'])) {
                    $attachment_path = $resources['resources_attachment_path'];
                    $article_image_array = unserialize($resources['resources_image_all']);
                    if(!empty($article_image_array) && is_array($article_image_array)) {
                        foreach ($article_image_array as $key=>$value) {
                            list($base_name, $ext) = explode('.', $key);
                            $image = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'resources'.DS.$attachment_path.DS.$key;
                            $image_list = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'resources'.DS.$attachment_path.DS.$base_name.'_list.'.$ext;
                            $image_max = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'resources'.DS.$attachment_path.DS.$base_name.'_max.'.$ext;
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