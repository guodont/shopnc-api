<?php
/**
 * 手机专题模型
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class mb_specialModel extends Model{

    //专题项目不可用状态
    const SPECIAL_ITEM_UNUSABLE = 0;
    //专题项目可用状态
    const SPECIAL_ITEM_USABLE = 1;
    //首页特殊专题编号
    const INDEX_SPECIAL_ID = 0;

    public function __construct() {
        parent::__construct('mb_special');
    }

	/**
	 * 读取专题列表
	 * @param array $condition
	 *
	 */
	public function getMbSpecialList($condition, $page='', $order='special_id desc', $field='*') {
        $list = $this->table('mb_special')->field($field)->where($condition)->page($page)->order($order)->select();
        return $list;
	}

	/*
	 * 增加专题
	 * @param array $param
	 * @return bool
     *
	 */
    public function addMbSpecial($param){
        return $this->table('mb_special')->insert($param);
    }

	/*
	 * 更新专题
	 * @param array $update
	 * @param array $condition
	 * @return bool
     *
	 */
    public function editMbSpecial($update, $special_id) {
        $special_id = intval($special_id);
        if($special_id <= 0) {
            return false;
        }

        $condition = array();
        $condition['special_id'] = $special_id;
        $result = $this->table('mb_special')->where($condition)->update($update);
        if($result) {
            //删除缓存
            $this->_delMbSpecialCache($special_id);
            return $special_id;
        } else {
            return false;
        }
    }

	/*
	 * 删除专题
	 * @param int $special_id
	 * @return bool
     *
	 */
    public function delMbSpecialByID($special_id) {
        $special_id = intval($special_id);
        if($special_id <= 0) {
            return false;
        }

        $condition = array();
        $condition['special_id'] = $special_id;

        $this->delMbSpecialItem($condition, $special_id);

        return $this->table('mb_special')->where($condition)->delete();
    }

    /**
     * 专题项目列表（用于后台编辑显示所有项目）
	 * @param int $special_id
     *
     */
    public function getMbSpecialItemListByID($special_id) {
        $condition = array();
        $condition['special_id'] = $special_id;

        return $this->_getMbSpecialItemList($condition);
    }

    /**
     * 专题可用项目列表（用于前台显示仅显示可用项目）
	 * @param int $special_id
     *
     */
    public function getMbSpecialItemUsableListByID($special_id) {
        $prefix = 'mb_special';

        $item_list = rcache($special_id, $prefix);
        //缓存有效
        if(!empty($item_list)) {
            return unserialize($item_list['special']);
        }

        //缓存无效查库并缓存
        $condition = array();
        $condition['special_id'] = $special_id;
        $condition['item_usable'] = self::SPECIAL_ITEM_USABLE;
        $item_list = $this->_getMbSpecialItemList($condition);
        if(!empty($item_list)) {
            $new_item_list = array();
            foreach ($item_list as $value) {
                //处理图片
                $item_data = $this->_formatMbSpecialData($value['item_data'], $value['item_type']);
                $new_item_list[] = array($value['item_type'] => $item_data);
            }
            $item_list = $new_item_list;
        }
        $cache = array('special' => serialize($item_list));
        wcache($special_id, $cache, $prefix);
        return $item_list;
    }

    /**
     * 首页专题
     */
    public function getMbSpecialIndex() {
        return $this->getMbSpecialItemUsableListByID(self::INDEX_SPECIAL_ID);
    }

    /**
     * 处理专题数据，拼接图片URL
     */
    private function _formatMbSpecialData($item_data, $item_type) {
        switch ($item_type) {
            case 'home1':
                $item_data['image'] = getMbSpecialImageUrl($item_data['image']);
                break;
            case 'home2':
            case 'home4':
                $item_data['square_image'] = getMbSpecialImageUrl($item_data['square_image']);
                $item_data['rectangle1_image'] = getMbSpecialImageUrl($item_data['rectangle1_image']);
                $item_data['rectangle2_image'] = getMbSpecialImageUrl($item_data['rectangle2_image']);
            break;
            case 'goods':
                $new_item = array();
                foreach ((array) $item_data['item'] as $value) {
                    $value['goods_image'] = cthumb($value['goods_image']);
                    $new_item[] = $value;
                }
                $item_data['item'] = $new_item;
                break;
            default:
                $new_item = array();
                foreach ((array) $item_data['item'] as $key => $value) {
                    $value['image'] = getMbSpecialImageUrl($value['image']);
                    $new_item[] = $value;
                }
                $item_data['item'] = $new_item;
        }
        return $item_data;
    }

    /**
     * 查询专题项目列表
     */
    private function _getMbSpecialItemList($condition, $order = 'item_sort asc') {
        $item_list = $this->table('mb_special_item')->where($condition)->order($order)->select();
        foreach ($item_list as $key => $value) {
            $item_list[$key]['item_data'] = $this->_initMbSpecialItemData($value['item_data'], $value['item_type']);
            if($value['item_usable'] == self::SPECIAL_ITEM_USABLE) {
                $item_list[$key]['usable_class'] = 'usable';
                $item_list[$key]['usable_text'] = '禁用';
            } else {
                $item_list[$key]['usable_class'] = 'unusable';
                $item_list[$key]['usable_text'] = '启用';
            }
        }
        return $item_list;
    }

    /**
     * 检查专题项目是否存在
	 * @param array $condition
     *
     */
    public function isMbSpecialItemExist($condition) {
        $item_list = $this->table('mb_special_item')->where($condition)->select();
        if($item_list) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取项目详细信息
     * @param int $item_id
     *
     */
    public function getMbSpecialItemInfoByID($item_id) {
        $item_id = intval($item_id);
        if($item_id <= 0) {
            return false;
        }

        $condition = array();
        $condition['item_id'] = $item_id;
        $item_info = $this->table('mb_special_item')->where($condition)->find();
        $item_info['item_data'] = $this->_initMbSpecialItemData($item_info['item_data'], $item_info['item_type']);

        return $item_info;
    }

    /**
     * 整理项目内容
     *
     */
    private function _initMbSpecialItemData($item_data, $item_type) {
        if(!empty($item_data)) {
            $item_data = unserialize($item_data);
            if($item_type == 'goods') {
                $item_data = $this->_initMbSpecialItemGoodsData($item_data, $item_type);
            }
        } else {
            $item_data = $this->_initMbSpecialItemNullData($item_type);
        }
        return $item_data;

    }

    /**
     * 处理goods类型内容
     */
    private function _initMbSpecialItemGoodsData($item_data, $item_type) {
        $goods_id_string = '';
        if(!empty($item_data['item'])) {
            foreach ($item_data['item'] as $value) {
                $goods_id_string .= $value . ',';
            }
            $goods_id_string = rtrim($goods_id_string, ',');

            //查询商品信息
            $condition['goods_id'] = array('in', $goods_id_string);
            $model_goods = Model('goods');
            $goods_list = $model_goods->getGoodsList($condition, 'goods_id,goods_name,goods_promotion_price,goods_image');
            $goods_list = array_under_reset($goods_list, 'goods_id');

            //整理商品数据
            $new_goods_list = array();
            foreach ($item_data['item'] as $value) {
                if(!empty($goods_list[$value])) {
                    $new_goods_list[] = $goods_list[$value];
                }
            }
            $item_data['item'] = $new_goods_list;
        }
        return $item_data;
    }

    /**
     * 初始化空项目内容
     */
    private function _initMbSpecialItemNullData($item_type) {
        $item_data = array();
        switch ($item_type) {
        case 'home1':
            $item_data = array(
                'title' => '',
                'image' => '',
                'type' => '',
                'data' => '',
            );
            break;
        case 'home2':
        case 'home4':
            $item_data= array(
                'title' => '',
                'square_image' => '',
                'square_type' => '',
                'square_data' => '',
                'rectangle1_image' => '',
                'rectangle1_type' => '',
                'rectangle1_data' => '',
                'rectangle2_image' => '',
                'rectangle2_type' => '',
                'rectangle2_data' => '',
            );
            break;
        default:
        }
        return $item_data;
    }

    /*
     * 增加专题项目
     * @param array $param
     * @return array $item_info
     *
     */
    public function addMbSpecialItem($param) {
        $param['item_usable'] = self::SPECIAL_ITEM_UNUSABLE;
        $param['item_sort'] = 255;
        $result = $this->table('mb_special_item')->insert($param);
        //删除缓存
        if($result) {
            //删除缓存
            $this->_delMbSpecialCache($param['special_id']);
            $param['item_id'] = $result;
            return $param;
        } else {
            return false;
        }
    }

    /**
     * 编辑专题项目
     * @param array $update
     * @param int $item_id
     * @param int $special_id
     * @return bool
     *
     */
    public function editMbSpecialItemByID($update, $item_id, $special_id) {
        if(isset($update['item_data'])) {
            $update['item_data'] = serialize($update['item_data']);
        }
        $condition = array();
        $condition['item_id'] = $item_id;

        //删除缓存
        $this->_delMbSpecialCache($special_id);

        return $this->table('mb_special_item')->where($condition)->update($update);
    }

    /**
     * 编辑专题项目启用状态
     * @param string usable-启用/unsable-不启用
     * @param int $item_id
     * @param int $special_id
     *
     */
    public function editMbSpecialItemUsableByID($usable, $item_id, $special_id) {
        $update = array();
        if($usable == 'usable') {
            $update['item_usable'] = self::SPECIAL_ITEM_USABLE;
        } else {
            $update['item_usable'] = self::SPECIAL_ITEM_UNUSABLE;
        }
        return $this->editMbSpecialItemByID($update, $item_id, $special_id);
    }

	/*
	 * 删除
	 * @param array $condition
	 * @return bool
     *
	 */
    public function delMbSpecialItem($condition, $special_id) {
        //删除缓存
        $this->_delMbSpecialCache($special_id);

        return $this->table('mb_special_item')->where($condition)->delete();
    }

    /**
     * 获取专题URL地址
	 * @param int $special_id
     *
     */
    public function getMbSpecialHtmlUrl($special_id) {
        return UPLOAD_SITE_URL . DS . ATTACH_MOBILE . DS . 'special_html' . DS . md5('special' . $special_id) . '.html';
    }

    /**
     * 获取专题静态文件路径
	 * @param int $special_id
     *
     */
    public function getMbSpecialHtmlPath($special_id) {
        return BASE_UPLOAD_PATH . DS . ATTACH_MOBILE . DS . 'special_html' . DS . md5('special' . $special_id) . '.html';
    }

    /**
     * 获取专题模块类型列表
     * @return array
     *
     */
    public function getMbSpecialModuleList() {
        $module_list = array();
        $module_list['adv_list'] = array('name' => 'adv_list' , 'desc' => '广告条版块');
        $module_list['home1'] = array('name' => 'home1' , 'desc' => '模型版块布局A');
        $module_list['home2'] = array('name' => 'home2' , 'desc' => '模型版块布局B');
        $module_list['home3'] = array('name' => 'home3' , 'desc' => '模型版块布局C');
        $module_list['home4'] = array('name' => 'home4' , 'desc' => '模型版块布局D');
        $module_list['goods'] = array('name' => 'goods' , 'desc' => '商品版块');
        return $module_list;
    }

    /**
     * 清理缓存
     */
    private function _delMbSpecialCache($special_id) {
        //清理缓存
        dcache($special_id, 'mb_special');

        //删除静态文件
        $html_path = $this->getMbSpecialHtmlPath($special_id);
        if(is_file($html_path)) {
            @unlink($html_path);
        }
    }
}
