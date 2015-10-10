<?php
/**
 * 满即送管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class promotion_mansongControl extends SystemControl{

    public function __construct(){
        parent::__construct();

        //读取语言包
        Language::read('promotion_mansong');

        //检查审核功能是否开启
        if (intval($_GET['promotion_allow']) !== 1 && intval(C('promotion_allow')) !== 1){
 			$url = array(
				array(
					'url'=>'index.php?act=promotion_mansong&promotion_allow=1',
					'msg'=>Language::get('open'),
				),
				array(
					'url'=>'index.php?act=dashboard&op=welcome',
					'msg'=>Language::get('close'),
				),
			);
			showMessage(Language::get('promotion_unavailable'),$url,'html','succ',1,6000);
        }
    }

    /**
     * 默认Op
     */
    public function indexOp() {

		//自动开启满就送
		if (intval($_GET['promotion_allow']) === 1){
			$model_setting = Model('setting');
			$update_array = array();
			$update_array['promotion_allow'] = 1;
			$model_setting->updateSetting($update_array);
		}

        $this->mansong_listOp();
    }

    /**
     * 活动列表
     **/
    public function mansong_listOp() {
        $model_mansong = Model('p_mansong');

        $param = array();
        if(!empty($_GET['mansong_name'])) {
            $param['mansong_name'] = array('like', '%'.$_GET['mansong_name'].'%');
        }
        if(!empty($_GET['store_name'])) {
            $param['store_name'] = array('like', '%'.$_GET['store_name'].'%');
        }
        if(!empty($_GET['state'])) {
            $param['state'] = $_GET['state'];
        }
        $mansong_list = $model_mansong->getMansongList($param, 10);
        Tpl::output('list', $mansong_list);
        Tpl::output('show_page', $model_mansong->showpage());
        Tpl::output('mansong_state_array', $model_mansong->getMansongStateArray());

        $this->show_menu('mansong_list');

        // 输出自营店铺IDS
        Tpl::output('flippedOwnShopIds', array_flip(model('store')->getOwnShopIds()));
        Tpl::showpage('promotion_mansong.list');
    }

    /**
     * 活动详细信息
     * temp
     **/
    public function mansong_detailOp() {
        $mansong_id = intval($_GET['mansong_id']);

        $model_mansong = Model('p_mansong');
        $model_mansong_rule = Model('p_mansong_rule');

        $mansong_info = $model_mansong->getMansongInfoByID($mansong_id);
        if(empty($mansong_info)) {
            showMessage(L('param_error'));
        }
        Tpl::output('mansong_info', $mansong_info);

        $param = array();
        $param['mansong_id'] = $mansong_id;
        $rule_list = $model_mansong_rule->getMansongRuleListByID($mansong_id);
        Tpl::output('list',$rule_list);

        $this->show_menu('mansong_detail');
        Tpl::showpage('promotion_mansong.detail');
    }

    /**
     * 满即送活动取消
     **/
    public function mansong_cancelOp() {
        $mansong_id = intval($_POST['mansong_id']);
        $model_mansong = Model('p_mansong');
        $result = $model_mansong->cancelMansong(array('mansong_id' => $mansong_id));
        if($result) {
            $this->log('取消满即送活动，活动编号'.$mansong_id);
            showMessage(Language::get('nc_common_op_succ'),'');
        } else {
            showMessage(Language::get('nc_common_op_fail'),'');
        }
    }

    /**
     * 满即送活动删除
     **/
    public function mansong_delOp() {
        $mansong_id = intval($_POST['mansong_id']);
        $model_mansong = Model('p_mansong');
        $result = $model_mansong->delMansong(array('mansong_id' => $mansong_id));
        if($result) {
            $this->log('删除满即送活动，活动编号'.$mansong_id);
            showMessage(Language::get('nc_common_op_succ'),'');
        } else {
            showMessage(Language::get('nc_common_op_fail'),'');
        }
    }


    /**
     * 套餐管理
     **/
    public function mansong_quotaOp() {
        $model_mansong_quota = Model('p_mansong_quota');

        $param = array();
        if(!empty($_GET['store_name'])) {
            $param['store_name'] = array('like', '%'.$_GET['store_name'].'%');
        }
        $list = $model_mansong_quota->getMansongQuotaList($param, 10, 'quota_id desc');
        Tpl::output('list',$list);
        Tpl::output('show_page',$model_mansong_quota->showpage());

        $this->show_menu('mansong_quota');
        Tpl::showpage('promotion_mansong_quota.list');

    }

    /**
     * 设置
     **/
    public function mansong_settingOp() {

        $model_setting = Model('setting');
        $setting = $model_setting->GetListSetting();
        Tpl::output('setting',$setting);

        $this->show_menu('mansong_setting');
        Tpl::showpage('promotion_mansong.setting');
    }

    public function mansong_setting_saveOp() {

        $promotion_mansong_price = intval($_POST['promotion_mansong_price']);
        if($promotion_mansong_price === 0) {
            $promotion_mansong_price = 20;
        }

        $model_setting = Model('setting');
        $update_array = array();
        $update_array['promotion_mansong_price'] = $promotion_mansong_price;

        $result = $model_setting->updateSetting($update_array);
        if ($result === true){
        	$this->log(L('nc_config,nc_promotion_mansong,mansong_price'));
            showMessage(Language::get('setting_save_success'),'');
        }else {
            showMessage(Language::get('setting_save_fail'),'');
        }
    }

    /**
     * 页面内导航菜单
     *
     * @param string 	$menu_key	当前导航的menu_key
     * @param array 	$array		附加菜单
     * @return
     */
    private function show_menu($menu_key) {
        $menu_array = array(
            'mansong_list'=>array('menu_type'=>'link','menu_name'=>Language::get('mansong_list'),'menu_url'=>urlAdmin('promotion_mansong', 'mansong_list')),
            'mansong_quota'=>array('menu_type'=>'link','menu_name'=>Language::get('mansong_quota'),'menu_url'=>urlAdmin('promotion_mansong', 'mansong_quota')),
            'mansong_detail'=>array('menu_type'=>'link','menu_name'=>Language::get('mansong_detail'),'menu_url'=>urlAdmin('promotion_mansong', 'mansong_detail')),
            'mansong_setting'=>array('menu_type'=>'link','menu_name'=>Language::get('mansong_setting'),'menu_url'=>urlAdmin('promotion_mansong', 'mansong_setting')),
        );
        if($menu_key != 'mansong_detail') unset($menu_array['mansong_detail']);
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }

}
