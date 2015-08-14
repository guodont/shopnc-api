<?php
/**
 * 商品类别模型
 *
 *
 *
 *
 * by abc 网店技术交流中心  www.abc.com 开发
 */

defined('InShopNC') or exit('Access Invalid!');

class goods_classModel extends Model
{
    /**
     * 缓存数据
     */
    protected $cachedData;

    /**
     * 缓存数据 原H('goods_class')形式
     */
    protected $gcForCacheModel;

    public function __construct() {
        parent::__construct('goods_class');
    }

    /**
     * 获取缓存数据
     *
     * @return array
     * array(
     *   'data' => array(
     *     // Id => 记录
     *   ),
     *   'parent' => array(
     *     // 子Id => 父Id
     *   ),
     *   'children' => array(
     *     // 父Id => 子Id数组
     *   ),
     *   'children2' => array(
     *     // 1级Id => 3级Id数组
     *   ),
     * )
     */
    public function getCache() {
        if ($this->cachedData) {
            return $this->cachedData;
        }
        $data = rkcache('gc_class');
        if (!$data) {
            $data = array();
            foreach ((array) $this->getGoodsClassList(array()) as $v) {
                $id = $v['gc_id'];
                $pid = $v['gc_parent_id'];
                $data['data'][$id] = $v;
                $data['parent'][$id] = $pid;
                $data['children'][$pid][] = $id;
            }
            foreach ((array) $data['children'][0] as $id) {
                foreach ((array) $data['children'][$id] as $cid) {
                    foreach ((array) $data['children'][$cid] as $ccid) {
                        $data['children2'][$id][] = $ccid;
                    }
                }
            }
            wkcache('gc_class', $data);
        }
        return $this->cachedData = $data;
    }

    /**
     * 删除缓存数据
     */
    public function dropCache() {
        $this->cachedData = null;
        $this->gcForCacheModel = null;

        dkcache('gc_class');
        dkcache('all_categories');
    }

    /**
     * 类别列表
     *
     * @param  array   $condition  检索条件
     * @return array   返回二位数组
     */
    public function getGoodsClassList($condition, $field = '*') {
        $result = $this->table('goods_class')->field($field)->where($condition)->order('gc_parent_id asc,gc_sort asc,gc_id asc')->limit(false)->select();
        return $result;
    }

    /**
     * 从缓存获取全部分类
     */
    public function getGoodsClassListAll() {
        $data = $this->getCache();
        return array_values((array) $data['data']);
    }

    /**
     * 从缓存获取全部分类 分类id作为数组的键
     */
    public function getGoodsClassIndexedListAll() {
        $data = $this->getCache();
        return (array) $data['data'];
    }

    /**
     * 从缓存获取分类 通过分类id数组
     *
     * @param array $ids 分类id数组
     */
    public function getGoodsClassListByIds($ids) {
        $data = $this->getCache();
        $ret = array();
        foreach ((array) $ids as $i) {
            if ($data['data'][$i]) {
                $ret[] = $data['data'][$i];
            }
        }
        return $ret;
    }

    /**
     * 从缓存获取分类 通过上级分类id
     *
     * @param int $pid 上级分类id 若传0则返回1级分类
     */
    public function getGoodsClassListByParentId($pid) {
        $data = $this->getCache();
        $ret = array();
        foreach ((array) $data['children'][$pid] as $i) {
            if ($data['data'][$i]) {
                $ret[] = $data['data'][$i];
            }
        }
        return $ret;
    }

    /**
     * 从缓存获取分类 通过分类id
     *
     * @param int $id 分类id
     */
    public function getGoodsClassInfoById($id) {
        $data = $this->getCache();
        return $data['data'][$id];
    }

    /**
     * 返回缓存数据 原H('goods_class')形式
     */
    public function getGoodsClassForCacheModel() {

        if ($this->gcForCacheModel)
            return $this->gcForCacheModel;

        $data = $this->getCache();

        $r = $data['data'];
        $p = $data['parent'];
        $c = $data['children'];
        $c2 = $data['children2'];

        $r = (array) $r;

        foreach ($r as $k => & $v) {
            if ((string) $p[$k] == '0') {
                $v['depth'] = 1;
                if ($data['children'][$k]) {
                    $v['child'] = implode(',', $c[$k]);
                }
                if ($data['children2'][$k]) {
                    $v['childchild'] = implode(',', $c2[$k]);
                }
            } else if ((string) $p[$p[$k]] == '0') {
                $v['depth'] = 2;
                if ($data['children'][$k]) {
                    $v['child'] = implode(',', $c[$k]);
                }
            } else if ((string) $p[$p[$p[$k]]] == '0') {
                $v['depth'] = 3;
            }
        }

        return $this->gcForCacheModel = $r;
    }

    /**
     * 更新信息
     * @param unknown $data
     * @param unknown $condition
     */
    public function editGoodsClass($data = array(), $condition = array()) {
        // 删除缓存
        $this->dropCache();
        return $this->where($condition)->update($data);
    }

    /**
     * 取得店铺绑定的分类
     *
     * @param   number  $store_id   店铺id
     * @param   number  $pid        父级分类id
     * @param   number  $deep       深度
     * @return  array   二维数组
     */
    public function getGoodsClass($store_id, $pid = 0, $deep = 1) {
        // 读取商品分类 by 33 hao .com 批量添加分类修改
        $gc_list_o = $gc_list = $this->getGoodsClassListByParentId($pid);
        // 如果不是自营店铺或者自营店铺未绑定全部商品类目，读取绑定分类
        if (!checkPlatformStoreBindingAllGoodsClass()) {
            $gc_list = array_under_reset($gc_list, 'gc_id');
            $model_storebindclass = Model('store_bind_class');
            $gcid_array = $model_storebindclass->getStoreBindClassList(array(
                'store_id' => $store_id,
                'state' => array('in', array(1, 2)),
            ), '', "class_{$deep} asc", "distinct class_{$deep}");

            if (!empty($gcid_array)) {
                $tmp_gc_list = array();
                foreach ($gcid_array as $value) {
                    if($value["class_{$deep}"] == 0)
                    return $gc_list_o;
                    if (isset($gc_list[$value["class_{$deep}"]])) {
                        $tmp_gc_list[] = $gc_list[$value["class_{$deep}"]];
                    }
                }
                $gc_list = $tmp_gc_list;
            } else {
                return array();
            }
        }
        return $gc_list;
    }

    /**
     * 删除商品分类
     * @param unknown $condition
     * @return boolean
     */
    public function delGoodsClass($condition) {
        // 删除缓存
        $this->dropCache();
        return $this->where($condition)->delete();
    }

    /**
     * 删除商品分类
     *
     * @param array $gcids
     * @return boolean
     */
    public function delGoodsClassByGcIdString($gcids) {
        $gcids = explode(',', $gcids);
        if (empty($gcids)) {
            return false;
        }
        $goods_class = $this->getGoodsClassForCacheModel();
        $gcid_array = array();
        foreach ($gcids as $gc_id) {
            $child = (!empty($goods_class[$gc_id]['child'])) ? explode(',', $goods_class[$gc_id]['child']) : array();
            $childchild = (!empty($goods_class[$gc_id]['childchild'])) ? explode(',', $goods_class[$gc_id]['childchild']) : array();
            $gcid_array = array_merge($gcid_array, array($gc_id), $child, $childchild);
        }
        // 删除商品分类
        $this->delGoodsClass(array('gc_id' => array('in', $gcid_array)));
        // 删除常用商品分类
        Model('goods_class_staple')->delStaple(array('gc_id_1|gc_id_2|gc_id_3' => array('in', $gcid_array)));
        // 删除分类tag表
        Model('goods_class_tag')->delGoodsClassTag(array('gc_id_1|gc_id_2|gc_id_3' => array('in', $gcid_array)));
        // 删除店铺绑定分类
        Model('store_bind_class')->delStoreBindClass(array('class_1|class_2|class_3' => array('in', $gcid_array)));
        // 商品下架
        Model('goods')->editProducesLockUp(array('goods_stateremark' => '商品分类被删除，需要重新选择分类'), array('gc_id' => array('in', $gcid_array)));
        return true;
    }

    /**
     * 前台头部的商品分类
     *
     * @param   number  $update_all   更新
     * @return  array   数组
     */
    public function get_all_category($update_all = 0) {

        // 不存在时更新或者强制更新时执行
        if ($update_all == 1 || !($gc_list = rkcache('all_categories'))) {
            $class_list = $this->getGoodsClassListAll();
            $gc_list = array();
            $class1_deep = array();//第1级关联第3级数组
            $class2_ids = array();//第2级关联第1级ID数组
            $type_ids = array();//第2级分类关联类型
            if (is_array($class_list) && !empty($class_list)) {
                foreach ($class_list as $key => $value) {
                    $p_id = $value['gc_parent_id'];//父级ID
                    $gc_id = $value['gc_id'];
                    $sort = $value['gc_sort'];
                    if ($p_id == 0) {//第1级分类
                        $gc_list[$gc_id] = $value;
                    } elseif (array_key_exists($p_id,$gc_list)) {//第2级
                        $class2_ids[$gc_id] = $p_id;
                        $type_ids[] = $value['type_id'];
                        $gc_list[$p_id]['class2'][$gc_id] = $value;
                    } elseif (array_key_exists($p_id,$class2_ids)) {//第3级
                        $parent_id = $class2_ids[$p_id];//取第1级ID
                        $gc_list[$parent_id]['class2'][$p_id]['class3'][$gc_id] = $value;
                        $class1_deep[$parent_id][$sort][] = $value;
                    }
                }
                $type_brands = $this->get_type_brands($type_ids);//类型关联品牌
                foreach ($gc_list as $key => $value) {
                    $gc_id = $value['gc_id'];
                    $pic_name = BASE_UPLOAD_PATH.'/'.ATTACH_COMMON.'/category-pic-'.$gc_id.'.jpg';
                    if (file_exists($pic_name)) {
                        $gc_list[$gc_id]['pic'] = UPLOAD_SITE_URL.'/'.ATTACH_COMMON.'/category-pic-'.$gc_id.'.jpg';
                    }
                    $class3s = $class1_deep[$gc_id];

                    if (is_array($class3s) && !empty($class3s)) {//取关联的第3级
                        $class3_n = 0;//已经找到的第3级分类个数
                        ksort($class3s);//排序取到分类
                        foreach ($class3s as $k3 => $v3) {
                            if ($class3_n >= 5) {//最多取5个
                                break;
                            }
                            foreach ($v3 as $k => $v) {
                                if ($class3_n >= 5) {
                                    break;
                                }
                                if (is_array($v) && !empty($v)) {
                                    $p_id = $v['gc_parent_id'];
                                    $gc_id = $v['gc_id'];
                                    $parent_id = $class2_ids[$p_id];//取第1级ID
                                    $gc_list[$parent_id]['class3'][$gc_id] = $v;
                                    $class3_n += 1;
                                }
                            }
                        }
                    }
                    $class2s = $value['class2'];
                    if (is_array($class2s) && !empty($class2s)) {//第2级关联品牌
                        foreach ($class2s as $k2 => $v2) {
                            $p_id = $v2['gc_parent_id'];
                            $gc_id = $v2['gc_id'];
                            $type_id = $v2['type_id'];
                            $gc_list[$p_id]['class2'][$gc_id]['brands'] = $type_brands[$type_id];
                        }
                    }
                }
            }

            wkcache('all_categories', $gc_list);
        }

        return $gc_list;
    }

    /**
     * 类型关联品牌
     *
     * @param   array  $type_ids   类型
     * @return  array   数组
     */
    public function get_type_brands($type_ids = array()) {
        $brands = array();//品牌
        $type_brands = array();//类型关联品牌
        if (is_array($type_ids) && !empty($type_ids)) {
            $type_ids = array_unique($type_ids);
            $type_list = $this->table('type_brand')->where(array('type_id'=>array('in',$type_ids)))->limit(10000)->select();
            if (is_array($type_list) && !empty($type_list)) {
                $brand_list = $this->table('brand')->field('brand_id,brand_name,brand_pic')->where(array('brand_apply'=>1))->limit(10000)->select();
                if (is_array($brand_list) && !empty($brand_list)) {
                    foreach ($brand_list as $key => $value) {
                        $brand_id = $value['brand_id'];
                        $brands[$brand_id] = $value;
                    }
                    foreach ($type_list as $key => $value) {
                        $type_id = $value['type_id'];
                        $brand_id = $value['brand_id'];
                        $brand = $brands[$brand_id];
                        if (is_array($brand) && !empty($brand)) {
                            $type_brands[$type_id][$brand_id] = $brand;
                        }
                    }
                }
            }

        }
        return $type_brands;
    }

    /**
     * 新增商品分类
     * @param array $insert
     * @return boolean
     */
    public function addGoodsClass($insert) {
        // 删除缓存
        $this->dropCache();
        return $this->insert($insert);
    }

    /**
     * 取分类列表，最多为三级
     *
     * @param int $show_deep 显示深度
     * @param array $condition 检索条件
     * @return array 数组类型的返回结果
     */
    public function getTreeClassList($show_deep='3',$condition=array()){
        $class_list = $this->getGoodsClassList($condition);
        $goods_class = array();//分类数组
        if(is_array($class_list) && !empty($class_list)) {
            $show_deep = intval($show_deep);
            if ($show_deep == 1){//只显示第一级时用循环给分类加上深度deep号码
                foreach ($class_list as $val) {
                    if($val['gc_parent_id'] == 0) {
                        $val['deep'] = 1;
                        $goods_class[] = $val;
                    } else {
                        break;//父类编号不为0时退出循环
                    }
                }
            } else {//显示第二和三级时用递归
                $goods_class = $this->_getTreeClassList($show_deep,$class_list);
            }
        }
        return $goods_class;
    }

    /**
     * 递归 整理分类
     *
     * @param int $show_deep 显示深度
     * @param array $class_list 类别内容集合
     * @param int $deep 深度
     * @param int $parent_id 父类编号
     * @param int $i 上次循环编号
     * @return array $show_class 返回数组形式的查询结果
     */
    private function _getTreeClassList($show_deep,$class_list,$deep=1,$parent_id=0,$i=0){
        static $show_class = array();//树状的平行数组
        if(is_array($class_list) && !empty($class_list)) {
            $size = count($class_list);
            if($i == 0) $show_class = array();//从0开始时清空数组，防止多次调用后出现重复
            for ($i;$i < $size;$i++) {//$i为上次循环到的分类编号，避免重新从第一条开始
                $val = $class_list[$i];
                $gc_id = $val['gc_id'];
                $gc_parent_id	= $val['gc_parent_id'];
                if($gc_parent_id == $parent_id) {
                    $val['deep'] = $deep;
                    $show_class[] = $val;
                    if($deep < $show_deep && $deep < 3) {//本次深度小于显示深度时执行，避免取出的数据无用
                        $this->_getTreeClassList($show_deep,$class_list,$deep+1,$gc_id,$i+1);
                    }
                }
                if($gc_parent_id > $parent_id) break;//当前分类的父编号大于本次递归的时退出循环
            }
        }
        return $show_class;
    }

    /**
     * 取指定分类ID下的所有子类
     *
     * @param int/array $parent_id 父ID 可以单一可以为数组
     * @return array $rs_row 返回数组形式的查询结果
     */
    public function getChildClass($parent_id){
        static $_cache;
        if ($_cache !== null) return $_cache;
        $all_class = $this->getGoodsClassListAll();
        if (is_array($all_class)){
            if (!is_array($parent_id)){
                $parent_id = array($parent_id);
            }
            $result = array();
            foreach ($all_class as $k => $v){
                $gc_id	= $v['gc_id'];//返回的结果包括父类
                $gc_parent_id	= $v['gc_parent_id'];
                if (in_array($gc_id,$parent_id) || in_array($gc_parent_id,$parent_id)){
                    $parent_id[] = $v['gc_id'];
                    $result[] = $v;
                }
            }
            $return = $result;
        }else {
            $return = false;
        }
        return $_cache = $return;
    }

    /**
     * 取指定分类ID的导航链接
     *
     * @param int $id 父类ID/子类ID
     * @param int $sign 1、0 1为最后一级不加超链接，0为加超链接
     * @return array $nav_link 返回数组形式类别导航连接
     */
    public function getGoodsClassNav($id = 0, $sign = 1) {
        if (intval ( $id ) > 0) {
            $data = $this->getGoodsClassIndexedListAll();

            // 当前分类不加超链接
            if ($sign == 1) {
                $nav_link [] = array(
                        'title' => $data[$id]['gc_name']
                );
            } else {
                $nav_link [] = array(
                        'title' => $data[$id]['gc_name'],
                        'link' => urlShop('search', 'index', array('cate_id' => $data[$id]['gc_id']))
                );
            }

            // 最多循环4层
            for($i = 1; $i < 5; $i ++) {
                if ($data[$id]['gc_parent_id'] == '0') {
                    break;
                }
                $id = $data[$id]['gc_parent_id'];
                $nav_link[] = array(
                        'title' => $data[$id]['gc_name'],
                        'link' => urlShop('search', 'index', array('cate_id' => $data[$id]['gc_id']))
                );
            }
        } else {
            // 加上 首页 商品分类导航
            $nav_link[] = array('title' => Language::get('goods_class_index_search_results'));
        }
        // 首页导航
        $nav_link[] = array('title' => Language::get('homepage'), 'link' => SHOP_SITE_URL);

        krsort ( $nav_link );
        return $nav_link;
    }

    /**
     * 取指定分类ID的所有父级分类
     *
     * @param int $id 父类ID/子类ID
     * @return array $nav_link 返回数组形式类别导航连接
     */
    public function getGoodsClassLineForTag($id = 0) {
        if (intval($id)> 0) {
            $gc_line = array();
            /**
             * 取当前类别信息
             */
            $class = $this->getGoodsClassInfoById(intval($id));
            $gc_line['gc_id'] = $class['gc_id'];
            $gc_line['type_id'] = $class['type_id'];
            $gc_line['gc_virtual'] = $class['gc_virtual'];
            /**
             * 是否是子类
             */
            if ($class['gc_parent_id'] != 0) {
                $parent_1 = $this->getGoodsClassInfoById($class['gc_parent_id']);
                if ($parent_1['gc_parent_id'] != 0) {
                    $parent_2 = $this->getGoodsClassInfoById($parent_1['gc_parent_id']);
                    $gc_line['gc_id_1'] = $parent_2['gc_id'];
                    $gc_line['gc_tag_name'] = trim($parent_2['gc_name']) . ' >';
                    $gc_line['gc_tag_value'] = trim($parent_2['gc_name']) . ',';
                }
                if (!isset($gc_line['gc_id_1'])) {
                    $gc_line['gc_id_1'] = $parent_1['gc_id'];
                } else {
                    $gc_line['gc_id_2'] = $parent_1['gc_id'];
                }
                $gc_line['gc_tag_name'] .= trim($parent_1['gc_name']) . ' >';
                $gc_line['gc_tag_value'] .= trim($parent_1['gc_name']) . ',';
            }
            if (!isset($gc_line['gc_id_1'])) {
                $gc_line['gc_id_1'] = $class['gc_id'];
            } else if (!isset($gc_line['gc_id_2'])) {
                $gc_line['gc_id_2'] = $class['gc_id'];
            } else {
                $gc_line['gc_id_3'] = $class['gc_id'];
            }
            $gc_line['gc_tag_name'] .= trim($class['gc_name']) . ' >';
            $gc_line['gc_tag_value'] .= trim($class['gc_name']) . ',';
        }
        $gc_line['gc_tag_name'] = trim($gc_line['gc_tag_name'], ' >');
        $gc_line['gc_tag_value'] = trim($gc_line['gc_tag_value'], ',');
        return $gc_line;
    }

    /**
     * 取得分类关键词，方便SEO
     */
    public function getKeyWords($gc_id = null){
        if (empty($gc_id)) return false;
        $keywrods = rkcache('goods_class_seo',true);
        $seo_title = $keywrods[$gc_id]['title'];
        $seo_key = '';
        $seo_desc = '';
        if ($gc_id > 0){
            if (isset($keywrods[$gc_id])){
                $seo_key .= $keywrods[$gc_id]['key'].',';
                $seo_desc .= $keywrods[$gc_id]['desc'].',';
            }
            $goods_class = Model('goods_class')->getGoodsClassIndexedListAll();
            if(($gc_id = $goods_class[$gc_id]['gc_parent_id']) > 0){
                if (isset($keywrods[$gc_id])){
                    $seo_key .= $keywrods[$gc_id]['key'].',';
                    $seo_desc .= $keywrods[$gc_id]['desc'].',';
                }
            }
            if(($gc_id = $goods_class[$gc_id]['gc_parent_id']) > 0){
                if (isset($keywrods[$gc_id])){
                    $seo_key .= $keywrods[$gc_id]['key'].',';
                    $seo_desc .= $keywrods[$gc_id]['desc'].',';
                }
            }
        }
        return array(1=>$seo_title,2=>trim($seo_key,','),3=>trim($seo_desc,','));
    }
    /**
     * 获得商品分类缓存
     * @param int $choose_gcid 选择分类ID
     * @param int $show_depth 需要展示分类深度
     * @return array 返回分类数组和选择分类id数组
     */
    public function getGoodsclassCache($choose_gcid, $show_depth=3){
        $gc_list = $this->getGoodsClassForCacheModel();
        //获取需要展示的分类数组
        $show_gc_list = array();
        foreach ((array)$gc_list as $k=>$v){
            if ($v['depth'] < $show_depth){
                $show_gc_list[$v['gc_id']] = $v;
            } elseif ($v['depth'] == $show_depth) {
                unset($v['child'],$v['childchild']);
                $show_gc_list[$v['gc_id']] = $v;
            }
        }
        if ($choose_gcid > 0){
            //遍历出选择商品分类的上下级ID
            $gc_depth = $gc_list[$choose_gcid]['depth'];
            $choose_gcidarr = array();
            $parentid = $choose_gcid;
            for ($i=$gc_depth-1; $i>=0; $i--){
                $choose_gcidarr[$i] = $parentid;
                $parentid = $gc_list[$parentid]['gc_parent_id'];
            }
        }
        return array('showclass'=>$show_gc_list,'choose_gcid'=>$choose_gcidarr);
    }
}
