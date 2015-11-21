<?php
/**
 * 资源库分类api
 *
 *
 */

defined('InShopNC') or exit('Access Invalid!');

class resource_classControl extends apiHomeControl
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexOp()
    {
        if (!empty($_GET['gc_id']) && intval($_GET['gc_id']) > 0) {
            $this->_get_class_list($_GET['gc_id']);
        } else {
            $this->_get_class_list(0);
        }
    }

    /**
     * 根据分类编号返回下级分类列表
     */
    private function _get_class_list($gc_id)
    {

        $trade_child_class = Model('resources_class')->getNextLevelGoodsClassById($gc_id);

        foreach ($trade_child_class as $child_class) {
            $class_item = array();
            $class_item['gc_id'] .= $child_class['gc_id'];
            $class_item['gc_name'] .= $child_class['gc_name'];
            $class_list[] = $class_item;
        }
        output_data(array('class_list' => $class_list));
    }

}
