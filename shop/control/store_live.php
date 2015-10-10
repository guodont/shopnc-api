<?php
/**
 * 线下商铺
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_liveControl extends BaseSellerControl {

    public function __construct() {
        parent::__construct();
        //读取语言包
        Language::read('member_live');
    }

    /**
     * 线下商铺
     **/
    public function indexOp() {
        $this->store_liveOp();
    }


    /*
     * 线下商铺
     */
	public function store_liveOp(){
		if(chksubmit()){//编辑商户信息

			$params 		= array();//参数
			$params['store_vrcode_prefix'] = preg_match('/^[a-zA-Z0-9]{1,3}$/',$_POST['store_vrcode_prefix']) ? $_POST['store_vrcode_prefix'] : null;
			$params['live_store_name'] = $_POST['live_store_name'];
			$params['live_store_address']= $_POST['live_store_address'];
			$params['live_store_tel']  = $_POST['live_store_tel'];
			$params['live_store_bus']  = $_POST['live_store_bus'];

			$model_store = Model('store');
			$res = $model_store->editStore($params,array('store_id'=>$_SESSION['store_id']));

			if ($res) {
				showMessage('编辑成功','','','succ');
			}else{
				showMessage('编辑失败','','','error');
			}
		}


		$model_store = Model('store');
		$store = $model_store->getStoreInfo(array('store_id'=>$_SESSION['store_id']));
		if(empty($store)){
			showMessage('该商家不存在');
		}

		Tpl::output('store',$store);
		$this->profile_menu('store_live');

		Tpl::showpage('store_liveinfo');
	}

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key) {
		$menu_array	= array(
				1=>array('menu_key'=>'store_live','menu_name'=>'线下商铺','menu_url'=>'index.php?act=store_live&op=store_live'),
		);
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
