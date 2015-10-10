<?php
/**
 * 代金券
 ***/


defined('InShopNC') or exit('Access Invalid!');
class store_voucherControl extends BaseSellerControl{
	//定义代金券类常量
	const SECONDS_OF_30DAY = 2592000;
    private $applystate_arr;
    private $quotastate_arr;
    private $templatestate_arr;

	public function __construct() {
		parent::__construct() ;
		//读取语言包
		Language::read('member_layout,member_voucher');
		//判断系统是否开启代金券功能
		if (C('voucher_allow') != 1){
			showMessage(Language::get('voucher_unavailable'),'index.php?act=store','html','error');
		}
		//申请记录状态
		$this->applystate_arr = array('new'=>array(1,Language::get('voucher_applystate_new')),'verify'=>array(2,Language::get('voucher_applystate_verify')),'cancel'=>array(3,Language::get('voucher_applystate_cancel')));
		//套餐状态
		$this->quotastate_arr = array('activity'=>array(1,Language::get('voucher_quotastate_activity')),'cancel'=>array(2,Language::get('voucher_quotastate_cancel')),'expire'=>array(3,Language::get('voucher_quotastate_expire')));
		//代金券模板状态
		$this->templatestate_arr = array('usable'=>array(1,Language::get('voucher_templatestate_usable')),'disabled'=>array(2,Language::get('voucher_templatestate_disabled')));
		Tpl::output('applystate_arr',$this->applystate_arr);
		Tpl::output('quotastate_arr',$this->quotastate_arr);
		Tpl::output('templatestate_arr',$this->templatestate_arr);
	}
	/*
	 * 默认显示代金券模版列表
	 */
	public function indexOp() {
        $this->templatelistOp();
    }
	/*
	 * 代金券模版列表
	 */
	public function templatelistOp(){
        //检查过期的代金券模板状态设为失效
        $this->check_voucher_template_expire();
        $model = Model('voucher');

        if (checkPlatformStore()) {
            Tpl::output('isOwnShop', true);
        } else {
            //查询是否存在可用套餐
            $current_quota = $model->getCurrentQuota($_SESSION['store_id']);
            Tpl::output('current_quota',$current_quota);
        }

		//查询列表
		$param = array();
		$param['voucher_t_store_id'] = $_SESSION['store_id'];
		if(trim($_GET['txt_keyword'])){
			$param['voucher_t_title'] = array('like','%'.trim($_GET['txt_keyword']).'%');
		}
		$select_state = intval($_GET['select_state']);
		if($select_state){
			$param['voucher_t_state'] = $select_state;
		}
		if($_GET['txt_startdate']){
			$param['voucher_t_end_date'] = array('egt',strtotime($_GET['txt_startdate']));
		}
		if($_GET['txt_enddate']){
			$param['voucher_t_start_date'] = array('elt',strtotime($_GET['txt_enddate']));
		}
		$list = $model->table('voucher_template')->where($param)->order('voucher_t_id desc')->page(10)->select();
		if(is_array($list)){
			foreach ($list as $key=>$val){
				if (!$val['voucher_t_customimg'] || !file_exists(BASE_UPLOAD_PATH.DS.ATTACH_VOUCHER.DS.$_SESSION['store_id'].DS.$val['voucher_t_customimg'])){
					$list[$key]['voucher_t_customimg'] = UPLOAD_SITE_URL.DS.defaultGoodsImage(60);
				}else{
					$list[$key]['voucher_t_customimg'] = UPLOAD_SITE_URL.DS.ATTACH_VOUCHER.DS.$_SESSION['store_id'].DS.str_ireplace('.', '_small.', $val['voucher_t_customimg']);
				}
			}
		}

        $this->profile_menu('voucher','templatelist');
		Tpl::output('list',$list);
		Tpl::output('show_page',$model->showpage(2));
		Tpl::showpage('store_voucher_template.index') ;
	}

	/**
     * 购买套餐
     */
	public function quotaaddOp(){
		if (chksubmit()){
	        $quota_quantity = intval($_POST['quota_quantity']);
	        if($quota_quantity <= 0 || $quota_quantity > 12) {
	            showDialog(Language::get('voucher_apply_num_error'));
	        }
	        //获取当前价格
	        $current_price = intval(C('promotion_voucher_price'));

            $model = Model();
	        $model_voucher = Model('voucher');

            //获取该用户已有套餐
            $current_quota = $model_voucher->getCurrentQuota($_SESSION['store_id']);
            $add_time = 86400 *30 * $quota_quantity;
            if(empty($current_quota)) {
                //生成套餐
                $param = array();
                $param['quota_memberid'] = $_SESSION['member_id'];
                $param['quota_membername'] = $_SESSION['member_name'];
                $param['quota_storeid'] = $_SESSION['store_id'];
                $param['quota_storename'] = $_SESSION['store_name'];
                $param['quota_starttime'] = TIMESTAMP;
                $param['quota_endtime'] = TIMESTAMP + $add_time;
                $param['quota_state'] = 1;
                $reault = $model->table('voucher_quota')->insert($param);
            } else {
                $param = array();
                $param['quota_endtime'] = array('exp', 'quota_endtime + ' . $add_time);
                $reault = $model->table('voucher_quota')->where(array('quota_id'=>$current_quota['quota_id']))->update($param);
            }

            //记录店铺费用
            $this->recordStoreCost($current_price * $quota_quantity, '购买代金券套餐');

            $this->recordSellerLog('购买'.$quota_quantity.'份代金券套餐，单价'.$current_price.L('nc_yuan'));

            if($reault){
                showDialog(Language::get('voucher_apply_buy_succ'),'index.php?act=store_voucher&op=quotalist','succ');
            } else {
                showDialog(Language::get('nc_common_op_fail'),'index.php?act=store_voucher&op=quotalist');
            }
        }else {
            //输出导航
	        self::profile_menu('quota_add','quotaadd');
	        Tpl::showpage('store_voucher_quota.add');
		}
    }
	/*
	 * 代金券模版添加
	 */
    public function templateaddOp(){
        $model = Model('voucher');
        if ($isOwnShop = checkPlatformStore()) {
            Tpl::output('isOwnShop', true);
        } else {
            //查询当前可以套餐
            $quotainfo = $model->getCurrentQuota($_SESSION['store_id']);
            if(empty($quotainfo)){
                showMessage(Language::get('voucher_template_quotanull'),'index.php?act=store_voucher&op=quotaadd','html','error');
            }

            //查询该套餐下代金券模板列表
            $count = $model->table('voucher_template')->where(array('voucher_t_quotaid'=>$quotainfo['quota_id'],'voucher_t_state'=>$this->templatestate_arr['usable'][0]))->count();
            if ($count >= C('promotion_voucher_storetimes_limit')){
                $message = sprintf(Language::get('voucher_template_noresidual'),C('promotion_voucher_storetimes_limit'));
                showMessage($message,'index.php?act=store_voucher&op=templatelist','html','error');
            }
        }

        //查询面额列表
        $pricelist =  $model->table('voucher_price')->order('voucher_price asc')->select();
        if(empty($pricelist)){
        	showMessage(Language::get('voucher_template_pricelisterror'),'index.php?act=store_voucher&op=templatelist','html','error');
        }
        if(chksubmit()){
	        //验证提交的内容面额不能大于限额
	        $obj_validate = new Validate();
	        $obj_validate->validateparam = array(
	            array("input"=>$_POST['txt_template_title'], "require"=>"true","validator"=>"Length","min"=>"1","max"=>"50","message"=>Language::get('voucher_template_title_error')),
	            array("input"=>$_POST['txt_template_total'], "require"=>"true","validator"=>"Number","message"=>Language::get('voucher_template_total_error')),
	            array("input"=>$_POST['select_template_price'], "require"=>"true","validator"=>"Number","message"=>Language::get('voucher_template_price_error')),
	            array("input"=>$_POST['txt_template_limit'], "require"=>"true","validator"=>"Double","message"=>Language::get('voucher_template_limit_error')),
	            array("input"=>$_POST['txt_template_describe'], "require"=>"true","validator"=>"Length","min"=>"1","max"=>"255","message"=>Language::get('voucher_template_describe_error')),
	        );
	        $error = $obj_validate->validate();
	        //金额验证
	        $price = intval($_POST['select_template_price'])>0?intval($_POST['select_template_price']):0;
	        foreach($pricelist as $k=>$v){
        		if($v['voucher_price'] == $price){
        			$chooseprice = $v;//取得当前选择的面额记录
        		}
        	}
        	if(empty($chooseprice)){
        		$error.=Language::get('voucher_template_pricelisterror');
        	}
	        $limit = intval($_POST['txt_template_limit'])>0?intval($_POST['txt_template_limit']):0;
	        if($price>=$limit) $error.=Language::get('voucher_template_price_error');
	        if ($error){
	            showDialog($error,'reload','error');
	        }else {
	        	$insert_arr = array();
	        	$insert_arr['voucher_t_title'] = trim($_POST['txt_template_title']);
	        	$insert_arr['voucher_t_desc'] = trim($_POST['txt_template_describe']);
	        	$insert_arr['voucher_t_start_date'] = time();//默认代金券模板的有效期为当前时间
	        	if ($_POST['txt_template_enddate']){
	        		$enddate = strtotime($_POST['txt_template_enddate']);
	        		if (!$isOwnShop && $enddate > $quotainfo['quota_endtime']){
	        			$enddate = $quotainfo['quota_endtime'];
	        		}
	        		$insert_arr['voucher_t_end_date'] = $enddate;
	        	}else {//如果没有添加有效期则默认为套餐的结束时间
                    if ($isOwnShop)
                        $insert_arr['voucher_t_end_date'] = time() + 2592000; // 自营店 默认30天到期
                    else
                        $insert_arr['voucher_t_end_date'] = $quotainfo['quota_endtime'];
	        	}
	        	$insert_arr['voucher_t_price'] = $price;
	        	$insert_arr['voucher_t_limit'] = $limit;
	        	$insert_arr['voucher_t_store_id'] = $_SESSION['store_id'];
	        	$insert_arr['voucher_t_storename'] = $_SESSION['store_name'];
	        	$insert_arr['voucher_t_sc_id'] = intval($_POST['sc_id']);
	        	$insert_arr['voucher_t_creator_id'] = $_SESSION['member_id'];
	        	$insert_arr['voucher_t_state'] = $this->templatestate_arr['usable'][0];
	        	$insert_arr['voucher_t_total'] = intval($_POST['txt_template_total'])>0?intval($_POST['txt_template_total']):0;
	        	$insert_arr['voucher_t_giveout'] = 0;
	        	$insert_arr['voucher_t_used'] = 0;
	        	$insert_arr['voucher_t_add_date'] = time();
	        	$insert_arr['voucher_t_quotaid'] = $quotainfo['quota_id'] ? $quotainfo['quota_id'] : 0;
	        	$insert_arr['voucher_t_points'] = $chooseprice['voucher_defaultpoints'];
	        	$insert_arr['voucher_t_eachlimit'] = intval($_POST['eachlimit'])>0?intval($_POST['eachlimit']):0;
	        	//自定义图片
		        if (!empty($_FILES['customimg']['name'])){
		        	$upload = new UploadFile();
		        	$upload->set('default_dir',	ATTACH_VOUCHER.DS.$_SESSION['store_id']);
		        	$upload->set('thumb_width','160');
					$upload->set('thumb_height','160');
					$upload->set('thumb_ext','_small');
					$result = $upload->upfile('customimg');
					if ($result){
						$insert_arr['voucher_t_customimg'] =  $upload->file_name;
					}
				}
	            $rs = $model->table('voucher_template')->insert($insert_arr);
	            if($rs){
	                showDialog(Language::get('nc_common_save_succ'),'index.php?act=store_voucher&op=templatelist','succ');
	            }else{
	                showDialog(Language::get('nc_common_save_fail'),'index.php?act=store_voucher&op=templatelist','error');
	            }
	        }
        }else{
            //店铺分类
            $store_class = rkcache('store_class', true);
            Tpl::output('store_class', $store_class);
            //查询店铺详情
            $store_info = Model('store')->getStoreInfoByID($_SESSION['store_id']);
            TPL::output('store_info',$store_info);

	        TPL::output('type','add');
	        TPL::output('quotainfo',$quotainfo);
	        TPL::output('pricelist',$pricelist);
	        $this->profile_menu('template','templateadd');
	        Tpl::showpage('store_voucher_template.add');
        }
    }
	/*
	 * 代金券模版编辑
	 */
    public function templateeditOp(){
    	$t_id = intval($_GET['tid']);
    	if ($t_id <= 0){
    		$t_id = intval($_POST['tid']);
    	}
    	if ($t_id <= 0){
    		showMessage(Language::get('wrong_argument'),'index.php?act=store_voucher&op=templatelist','html','error');
    	}
        $model = Model('voucher');
        //查询模板信息
        $param = array();
        $param['voucher_t_id'] = $t_id;
        $param['voucher_t_store_id'] = $_SESSION['store_id'];
        $param['voucher_t_state'] = $this->templatestate_arr['usable'][0];
        $param['voucher_t_giveout'] = array('elt','0');
        $param['voucher_t_end_date'] = array('gt',time());
        $t_info = $model->table('voucher_template')->where($param)->find();
        if (empty($t_info)){
        	showMessage(Language::get('wrong_argument'),'index.php?act=store_voucher&op=templatelist','html','error');
        }

        if ($isOwnShop = checkPlatformStore()) {
            Tpl::output('isOwnShop', true);
        } else {
            //查询套餐信息
            $quotainfo = $model->table('voucher_quota')->where(array('quota_id'=>$t_info['voucher_t_quotaid'],'quota_storeid'=>$_SESSION['store_id']))->find();
            if(empty($quotainfo)){
                showMessage(Language::get('voucher_template_quotanull'),'index.php?act=store_voucher&op=quotaadd','html','error');
            }
        }

        //查询面额列表
        $pricelist =  $model->table('voucher_price')->order('voucher_price asc')->select();
        if(empty($pricelist)){
        	showMessage(Language::get('voucher_template_pricelisterror'),'index.php?act=store_voucher&op=templatelist','html','error');
        }
        if(chksubmit()){
	        //验证提交的内容面额不能大于限额
	        $obj_validate = new Validate();
	        $obj_validate->validateparam = array(
	            array("input"=>$_POST['txt_template_title'], "require"=>"true","validator"=>"Length","min"=>"1","max"=>"50","message"=>Language::get('voucher_template_title_error')),
	            array("input"=>$_POST['txt_template_total'], "require"=>"true","validator"=>"Number","message"=>Language::get('voucher_template_total_error')),
	            array("input"=>$_POST['select_template_price'], "require"=>"true","validator"=>"Number","message"=>Language::get('voucher_template_price_error')),
	            array("input"=>$_POST['txt_template_limit'], "require"=>"true","validator"=>"Double","message"=>Language::get('voucher_template_limit_error')),
	            array("input"=>$_POST['txt_template_describe'], "require"=>"true","validator"=>"Length","min"=>"1","max"=>"255","message"=>Language::get('voucher_template_describe_error')),
	        );
	        $error = $obj_validate->validate();
	        //金额验证
	        $price = intval($_POST['select_template_price'])>0?intval($_POST['select_template_price']):0;
	        foreach($pricelist as $k=>$v){
        		if($v['voucher_price'] == $price){
        			$chooseprice = $v;//取得当前选择的面额记录
        		}
        	}
        	if(empty($chooseprice)){
        		$error.=Language::get('voucher_template_pricelisterror');
        	}
	        $limit = intval($_POST['txt_template_limit'])>0?intval($_POST['txt_template_limit']):0;
	        if($price>=$limit) $error.=Language::get('voucher_template_price_error');
	        if ($error){
	            showDialog($error,'reload','error');
	        }else {
	        	$update_arr = array();
	        	$update_arr['voucher_t_title'] = trim($_POST['txt_template_title']);
	        	$update_arr['voucher_t_desc'] = trim($_POST['txt_template_describe']);
	        	if ($_POST['txt_template_enddate']){
	        		$enddate = strtotime($_POST['txt_template_enddate']);
	        		if (!$isOwnShop && $enddate > $quotainfo['quota_endtime']){
	        			$enddate = $quotainfo['quota_endtime'];
	        		}
	        		$update_arr['voucher_t_end_date'] = $enddate;
	        	}else {//如果没有添加有效期则默认为套餐的结束时间
                    if ($isOwnShop)
                        $update_arr['voucher_t_end_date'] = time() + 2592000; // 自营店 默认30天到期
                    else
                        $update_arr['voucher_t_end_date'] = $quotainfo['quota_endtime'];
	        	}
	        	$update_arr['voucher_t_price'] = $price;
	        	$update_arr['voucher_t_limit'] = $limit;
	        	$update_arr['voucher_t_sc_id'] = intval($_POST['sc_id']);
	        	$update_arr['voucher_t_state'] = intval($_POST['tstate']) == $this->templatestate_arr['usable'][0]?$this->templatestate_arr['usable'][0]:$this->templatestate_arr['disabled'][0];
	        	$update_arr['voucher_t_total'] = intval($_POST['txt_template_total'])>0?intval($_POST['txt_template_total']):0;
	        	$update_arr['voucher_t_points'] = $chooseprice['voucher_defaultpoints'];
	        	$update_arr['voucher_t_eachlimit'] = intval($_POST['eachlimit'])>0?intval($_POST['eachlimit']):0;
	        	//自定义图片
		        if (!empty($_FILES['customimg']['name'])){
		        	$upload = new UploadFile();
		        	$upload->set('default_dir',	ATTACH_VOUCHER.DS.$_SESSION['store_id']);
		        	$upload->set('thumb_width','160');
					$upload->set('thumb_height','160');
					$upload->set('thumb_ext','_small');
					$result = $upload->upfile('customimg');
					if ($result){
						//删除原图
						if (!empty($t_info['voucher_t_customimg'])){//如果模板存在，则删除原模板图片
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_VOUCHER.DS.$_SESSION['store_id'].DS.$t_info['voucher_t_customimg']);
							@unlink(BASE_UPLOAD_PATH.DS.ATTACH_VOUCHER.DS.$_SESSION['store_id'].DS.str_ireplace('.', '_small.', $t_info['voucher_t_customimg']));
						}
						$update_arr['voucher_t_customimg'] =  $upload->file_name;
					}
				}
	            $rs = $model->table('voucher_template')->where(array('voucher_t_id'=>$t_info['voucher_t_id']))->update($update_arr);
	            if($rs){
	                showDialog(Language::get('nc_common_op_succ'),'index.php?act=store_voucher&op=templatelist','succ');
	            }else{
	                showDialog(Language::get('nc_common_op_fail'),'index.php?act=store_voucher&op=templatelist','error');
	            }
	        }
        }else{
	        if (!$t_info['voucher_t_customimg'] || !file_exists(BASE_UPLOAD_PATH.DS.ATTACH_VOUCHER.DS.$_SESSION['store_id'].DS.$t_info['voucher_t_customimg'])){
	        	$t_info['voucher_t_customimg'] = UPLOAD_SITE_URL.DS.defaultGoodsImage(240);
	        }else{
	        	$t_info['voucher_t_customimg'] = UPLOAD_SITE_URL.DS.ATTACH_VOUCHER.DS.$_SESSION['store_id'].DS.str_ireplace('.', '_small.', $t_info['voucher_t_customimg']);
	        }
	        TPL::output('type','edit');
	        TPL::output('t_info',$t_info);

	        //店铺分类
	        $store_class = rkcache('store_class', true);
	        Tpl::output('store_class', $store_class);
	        //查询店铺详情
	        $store_info = Model('store')->getStoreInfoByID($_SESSION['store_id']);
	        TPL::output('store_info',$store_info);

	        TPL::output('quotainfo',$quotainfo);
	        TPL::output('pricelist',$pricelist);
	        $this->profile_menu('templateedit','templateedit');
	        Tpl::showpage('store_voucher_template.add');
        }
    }
    /**
     * 删除代金券
     */
    public function templatedelOp(){
    	$t_id = intval($_GET['tid']);
    	if ($t_id <= 0){
    		showMessage(Language::get('wrong_argument'),'index.php?act=store_voucher&op=templatelist','html','error');
    	}
        $model = Model();
        //查询模板信息
        $param = array();
        $param['voucher_t_id'] = $t_id;
        $param['voucher_t_store_id'] = $_SESSION['store_id'];
        $param['voucher_t_giveout'] = array('elt','0');//会员没领取过代金券才可删除
        $t_info = $model->table('voucher_template')->where($param)->find();
    	if (empty($t_info)){
    		showMessage(Language::get('wrong_argument'),'index.php?act=store_voucher&op=templatelist','html','error');
    	}
        $rs = $model->table('voucher_template')->where(array('voucher_t_id'=>$t_info['voucher_t_id']))->delete();
        if ($rs){
        	//删除自定义的图片
        	if (trim($t_info['voucher_t_customimg'])){
        		@unlink(BASE_UPLOAD_PATH.DS.ATTACH_VOUCHER.DS.$_SESSION['store_id'].DS.$t_info['voucher_t_customimg']);
        		@unlink(BASE_UPLOAD_PATH.DS.ATTACH_VOUCHER.DS.$_SESSION['store_id'].DS.str_ireplace('.', '_small.', $t_info['voucher_t_customimg']));
        	}
        	showDialog(Language::get('nc_common_del_succ'),'reload','succ');
        }else {
        	showDialog(Language::get('nc_common_del_fail'));
        }
    }
    /**
     * 查看代金券详细
     */
    public function templateinfoOp(){
    	$t_id = intval($_GET['tid']);
    	if ($t_id <= 0){
    		showMessage(Language::get('wrong_argument'),'index.php?act=store_voucher&op=templatelist','html','error');
    	}
        $model = Model();
        //查询模板信息
        $param = array();
        $param['voucher_t_id'] = $t_id;
        $param['voucher_t_store_id'] = $_SESSION['store_id'];
        $t_info = $model->table('voucher_template')->where($param)->find();
        TPL::output('t_info',$t_info);
        $this->profile_menu('templateinfo','templateinfo');
        Tpl::showpage('store_voucher_template.info');
    }
	/*
	 * 把代金券模版设为失效
	 */
    private function check_voucher_template_expire($voucher_template_id=''){
        $where_array = array();
        if(empty($voucher_template_id)) {
            $where_array['voucher_t_end_date'] = array('lt',time());
        } else {
            $where_array['voucher_t_id'] = $voucher_template_id;
        }
        $where_array['voucher_t_state'] = $this->templatestate_arr['usable'][0];
        $model = Model();
        $model->table('voucher_template')->where($where_array)->update(array('voucher_t_state'=>$this->templatestate_arr['disabled'][0]));
    }
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		Language::read('member_layout');
		$menu_array	= array();
		switch ($menu_type) {
			case 'voucher':
				$menu_array = array(
				1=>array('menu_key'=>'templatelist','menu_name'=>Language::get('nc_member_path_store_voucher'), 'menu_url'=>'index.php?act=store_voucher&op=templatelist'),
				);
				break;
			case 'quota_add':
				$menu_array = array(
				1=>array('menu_key'=>'templatelist','menu_name'=>Language::get('nc_member_path_store_voucher'),	'menu_url'=>'index.php?act=store_voucher&op=templatelist'),
				4=>array('menu_key'=>'quotaadd','menu_name'=>Language::get('voucher_applyadd'),	'menu_url'=>'index.php?act=store_voucher&op=quotaadd')
				);
				break;
			case 'template':
				$menu_array = array(
				1=>array('menu_key'=>'templatelist','menu_name'=>Language::get('nc_member_path_store_voucher'),	'menu_url'=>'index.php?act=store_voucher&op=templatelist'),
				2=>array('menu_key'=>'templateadd','menu_name'=>Language::get('voucher_templateadd'),	'menu_url'=>'index.php?act=store_voucher&op=templateadd'),
				);
				break;
			case 'templateedit':
				$menu_array = array(
				1=>array('menu_key'=>'templatelist','menu_name'=>Language::get('nc_member_path_store_voucher'),	'menu_url'=>'index.php?act=store_voucher&op=templatelist'),
				2=>array('menu_key'=>'templateedit','menu_name'=>Language::get('voucher_templateedit'),	'menu_url'=>''),
				);
				break;
			case 'templateinfo':
				$menu_array = array(
				1=>array('menu_key'=>'templatelist','menu_name'=>Language::get('nc_member_path_store_voucher'),	'menu_url'=>'index.php?act=store_voucher&op=templatelist'),
				2=>array('menu_key'=>'templateinfo','menu_name'=>Language::get('voucher_templateinfo'), 'menu_url'=>''),
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
