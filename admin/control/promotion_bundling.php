<?php
/**
 * 优惠套装管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class promotion_bundlingControl extends SystemControl{

    public function __construct(){
        parent::__construct();

        //读取语言包
        Language::read('promotion_bundling');

        //检查审核功能是否开启
        if (intval($_GET['promotion_allow']) !== 1 && intval(C('promotion_allow')) !== 1){
            $url = array(
                array(
                    'url'=>'index.php?act=dashboard&op=welcome',
                    'msg'=>Language::get('close'),
                ),
                array(
                    'url'=>'index.php?act=promotion_bundling&promotion_allow=1',
                    'msg'=>Language::get('open'),
                ),
            );
            showMessage(Language::get('promotion_unavailable'),$url,'html','succ',1,6000);
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
        $this->bundling_listOp();
    }

    /**
     * 套餐管理
     */
    public function bundling_quotaOp() {
        $model_bundling = Model('p_bundling');

        // 查询添加
        $where = array();
        if ($_GET['store_name'] != '') {
            $where['store_name'] = array('like', '%'. trim($_GET['store_name']) .'%');
        }
        if (is_numeric($_GET['state'])) {
            $where['bl_state'] = intval($_GET['state']);
        }

        $bundling_quota_list = $model_bundling->getBundlingQuotaList($where);
        $page = $model_bundling->showpage(2);
        Tpl::output('show_page', $page);

        // 状态数组
        $state_array = array(0=>Language::get('bundling_state_0') , 1=>Language::get('bundling_state_1'));
        Tpl::output('state_array', $state_array);

        Tpl::output('list',$bundling_quota_list);
        Tpl::showpage('promotion_bundling_quota.list');
    }


    /**
     * 活动管理
     */
    public function bundling_listOp() {
    	$model_bundling = Model('p_bundling');

    	// 查询添加
    	$where = '';
        if ($_GET['bundling_name'] != '') {
            $where['bl_name'] = array('like', '%' . trim($_GET['bundling_name']) . '%');
        }
        if ($_GET['store_name'] != '') {
            $where['store_name'] = array('like', '%'. trim($_GET['store_name']) .'%');
        }
        if (is_numeric($_GET['state'])) {
            $where['bl_state'] = $_GET['state'];
        }
        $bundling_list = $model_bundling->getBundlingList($where);
        $bundling_list = array_under_reset($bundling_list, 'bl_id');
        Tpl::output('show_page',$model_bundling->showpage(2));
        if (!empty($bundling_list)) {
            $blid_array = array_keys($bundling_list);
            $bgoods_array = $model_bundling->getBundlingGoodsList(array('bl_id' => array('in', $blid_array)), 'bl_id,goods_id,count(*) as count', 'bl_appoint desc', 'bl_id');
            $bgoods_array = array_under_reset($bgoods_array, 'bl_id');
            foreach ($bundling_list as $key => $val) {
                $bundling_list[$key]['goods_id'] = $bgoods_array[$val['bl_id']]['goods_id'];
                $bundling_list[$key]['count'] = $bgoods_array[$val['bl_id']]['count'];
            }
        }
        Tpl::output('list', $bundling_list);

        // 状态数组
        $state_array = array(0=>Language::get('bundling_state_0') , 1=>Language::get('bundling_state_1'));
        Tpl::output('state_array', $state_array);


        // 输出自营店铺IDS
        Tpl::output('flippedOwnShopIds', array_flip(model('store')->getOwnShopIds()));
        Tpl::showpage('promotion_bundling.list');
    }

    /**
     * 设置
     */
    public function bundling_settingOp() {
    	// 实例化模型
    	$model_setting = Model('setting');

		if (chksubmit()){
			// 验证
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["promotion_bundling_price"], "require"=>"true", 'validator'=>'Number', "message"=>Language::get('bundling_price_error')),
				array("input"=>$_POST["promotion_bundling_sum"], "require"=>"true", 'validator'=>'Number', "message"=>Language::get('bundling_sum_error')),
				array("input"=>$_POST["promotion_bundling_goods_sum"], "require"=>"true", 'validator'=>'Number', "message"=>Language::get('bundling_goods_sum_error')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}

			$data['promotion_bundling_price']		= intval($_POST['promotion_bundling_price']);
			$data['promotion_bundling_sum']			= intval($_POST['promotion_bundling_sum']);
			$data['promotion_bundling_goods_sum']	= intval($_POST['promotion_bundling_goods_sum']);

			$return = $model_setting->updateSetting($data);
			if($return){
				$this->log(L('nc_set,nc_promotion_bundling'));
				showMessage(L('nc_common_op_succ'));
			}else{
				showMessage(L('nc_common_op_fail'));
			}
		}

		// 查询setting列表
        $setting = $model_setting->GetListSetting();
        Tpl::output('setting',$setting);

        Tpl::showpage('promotion_bundling.setting');
    }

    /**
     * 删除套餐活动
     */
    public function del_bundlingOp() {
        $bl_id = intval($_GET['bl_id']);
        if ($bl_id <= 0) {
            showMessage(L('param_error'), '', 'html', 'error');
        }
        $rs = Model('p_bundling')->delBundlingForAdmin(array('bl_id' => $bl_id));
        if ($rs) {
            showMessage(L('nc_common_op_succ'));
        } else {
            showMessage(L('nc_common_op_fail'), '', 'html', 'error');
        }
    }
}
