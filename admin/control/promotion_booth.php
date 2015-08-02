<?php
/**
 * 限时折扣管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class promotion_boothControl extends SystemControl{
    public function __construct(){
        parent::__construct();
        //检查审核功能是否开启
        if (intval($_GET['promotion_allow']) !== 1 && intval(C('promotion_allow')) !== 1){
            $url = array(
                array(
                    'url'=>'index.php?act=dashboard&op=welcome',
                    'msg'=>L('close'),
                ),
                array(
                    'url'=>'index.php?act=promotion_bundling&promotion_allow=1',
                    'msg'=>L('open'),
                ),
            );
            showMessage('商品促销功能尚未开启', $url, 'html', 'succ', 1, 6000);
        }
    }

    /**
     * 默认Op
     */
    public function indexOp() {
        //自动开启优惠套装
        if (intval($_GET['promotion_allow']) === 1){
            $model_setting = Model('setting');
            $update_array = array();
            $update_array['promotion_allow'] = 1;
            $model_setting->updateSetting($update_array);
        }
        $this->goods_listOp();
    }

    public function goods_listOp() {
        /**
         * 处理商品分类
         */
        $choose_gcid = ($t = intval($_REQUEST['choose_gcid']))>0?$t:0;
        $gccache_arr = Model('goods_class')->getGoodsclassCache($choose_gcid,3);
	    Tpl::output('gc_json',json_encode($gccache_arr['showclass']));
		Tpl::output('gc_choose_json',json_encode($gccache_arr['choose_gcid']));

        $model_booth = Model('p_booth');
        $where = array();
        if (intval($_GET['choose_gcid']) > 0) {
            $where['gc_id'] = intval($_GET['choose_gcid']);
        }
        $goods_list = $model_booth->getBoothGoodsList($where, 'goods_id', 10);
        if (!empty($goods_list)) {
            $goodsid_array = array();
            foreach ($goods_list as $val) {
                $goodsid_array[] = $val['goods_id'];
            }
            $goods_list = Model('goods')->getGoodsList(array('goods_id' => array('in', $goodsid_array)));
        }
        Tpl::output('gc_list', Model('goods_class')->getGoodsClassForCacheModel());
        Tpl::output('goods_list', $goods_list);
        Tpl::output('show_page', $model_booth->showpage(2));

        // 输出自营店铺IDS
        Tpl::output('flippedOwnShopIds', array_flip(model('store')->getOwnShopIds()));
        Tpl::showpage('promotion_booth_goods.list');
    }

    /**
     * 套餐列表
     */
    public function booth_quota_listOp() {
        $model_booth = Model('p_booth');
        $where = array();
        if ($_GET['store_name'] != '') {
            $where['store_name'] = array('like', '%'.trim($_GET['store_name']).'%');
        }
        $booth_list = $model_booth->getBoothQuotaList($where, '*', 10);

        // 状态数组
        $state_array = array(0=>L('close') , 1=>L('open'));
        Tpl::output('state_array', $state_array);

        Tpl::output('booth_list', $booth_list);
        Tpl::output('show_page', $model_booth->showpage(2));
        Tpl::showpage('promotion_booth_quota.list');
    }

    /**
     * 删除推荐商品
     */
    public function del_goodsOp() {
        $where = array();
        // 验证id是否正确
        if (is_array($_POST['goods_id'])) {
            foreach ($_POST['goods_id'] as $val) {
                if (!is_numeric($val)) {
                    showDialog(L('nc_common_del_fail'));
                }
            }
            $where['goods_id'] = array('in', $_POST['goods_id']);
        } elseif(intval($_GET['goods_id']) >= 0) {
            $where['goods_id'] = intval($_GET['goods_id']);
        } else {
            showDialog(L('nc_common_del_fail'));
        }

        $rs = Model('p_booth')->delBoothGoods($where);
        if ($rs) {
            showDialog(L('nc_common_del_succ'), 'reload', 'succ');
        } else {
            showDialog(L('nc_common_del_fail'));
        }
    }

    /**
     * 设置
     */
    public function booth_settingOp() {
        // 实例化模型
        $model_setting = Model('setting');

        if (chksubmit()){
            // 验证
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input"=>$_POST["promotion_booth_price"], "require"=>"true", 'validator'=>'Number', "message"=>'请填写展位价格'),
                array("input"=>$_POST["promotion_booth_goods_sum"], "require"=>"true", 'validator'=>'Number', "message"=>'不能为空，且不小于1的整数'),
            );
            $error = $obj_validate->validate();
            if ($error != ''){
                showMessage($error);
            }

            $data['promotion_booth_price'] = intval($_POST['promotion_booth_price']);
            $data['promotion_booth_goods_sum'] = intval($_POST['promotion_booth_goods_sum']);

            $return = $model_setting->updateSetting($data);
            if($return){
                $this->log(L('nc_set').' 推荐展位');
                showMessage(L('nc_common_op_succ'));
            }else{
                showMessage(L('nc_common_op_fail'));
            }
        }

        // 查询setting列表
        $setting = $model_setting->GetListSetting();
        Tpl::output('setting',$setting);

        Tpl::showpage('promotion_booth.setting');
    }
}
