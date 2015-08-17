<?php
/**
 * 交易分类api
 *
 *
 */

defined('InShopNC') or exit('Access Invalid!');

class trade_classControl extends apiHomeControl
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

        $trade_child_class = Model('flea_class')->getNextLevelGoodsClassById($gc_id);

        if (empty($trade_child_class)) {
            //无下级分类返回0
            output_data(array('class_list' => 0));
        } else {
            foreach ($trade_child_class as $child_class) {
                $class_item = array();
                $class_item['gc_id'] .= $child_class['gc_id'];
                $class_item['gc_name'] .= $child_class['gc_name'];
                $class_list[] = $class_item;
            }
            output_data(array('class_list' => $class_list));
        }
    }
}
