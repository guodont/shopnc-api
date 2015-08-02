<?php
/**
 * 前台抢购
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class show_live_groupbuyControl extends BaseHomeControl {

    public function __construct() {
        parent::__construct();

        //读取语言包
        Language::read('member_groupbuy,home_cart_index,live_groupbuy');

		//分类导航
		$nav_link = array(
			0=>array(
				'title'=>Language::get('homepage'),
				'link'=>'index.php'
			),
			1=>array(
				'title'=>Language::get('nc_groupbuy')
			)
		);
		Tpl::output('nav_link_list',$nav_link);
		Tpl::output('index_sign','groupbuy');
		Tpl::setLayout('home_groupbuy_layout');
    }

	/**
	 * 默认跳转到进行中的抢购列表
	 */
    public function indexOp() {
		$this->citylist();//区域列表
		$this->classlist();//分类列表
		$this->onlineclass();

		$model_live_groupbuy = Model('live_groupbuy');
		$condition_live_groupbuy = array();
		$condition_live_groupbuy['start_time']	= array('elt',time());
		$condition_live_groupbuy['end_time']	= array('egt',time());
		$condition_live_groupbuy['is_hot'] = 1;//推荐
		$condition_live_groupbuy['is_audit'] = 2;//审核通过
		$condition_live_groupbuy['is_open'] = 1;//开启

		//区域城市商区
		if(cookie('city_id')){
			$condition_live_groupbuy['city_id']	= cookie('city_id');
		}
		$live_groupbuy = $model_live_groupbuy->getList($condition_live_groupbuy,'',9);
		Tpl::output('live_groupbuy',$live_groupbuy);//线下抢购

		$model_groupbuy = Model('groupbuy');
		$condition_groupbuy = array();
		$groupbuy = $model_groupbuy->getGroupbuyOnlineList($condition_groupbuy,9);
		Tpl::output('groupbuy',$groupbuy);//线上抢购
		Tpl::output('current', 'online');

		$model_setting = Model('setting');
		$list_setting = $model_setting->getListSetting();

		if(!empty($list_setting)){//轮播图片
			$picArr = array();

			if(!empty($list_setting['live_pic1'])){
				$picArr[] = array($list_setting['live_pic1'],$list_setting['live_link1']);
			}

			if(!empty($list_setting['live_pic2'])){
				$picArr[] = array($list_setting['live_pic2'],$list_setting['live_link2']);
			}

			if(!empty($list_setting['live_pic3'])){
				$picArr[] = array($list_setting['live_pic3'],$list_setting['live_link3']);
			}

			if(!empty($list_setting['live_pic4'])){
				$picArr[] = array($list_setting['live_pic4'],$list_setting['live_link4']);
			}

			Tpl::output('picArr', $picArr);
		}

		Tpl::output('list_setting', $list_setting);
		Tpl::showpage('show_live_groupbuy.index');
	}

	/**
	 * 抢购列表
	 **/
	public function live_groupbuy_listOp(){
		$condition = array();
		$condition['is_open'] = 1;//1.开启 2.关闭
		$condition['is_audit']= 2;//1.待审核 2.审核通过 3.审核未通过

		if(isset($_GET['type']) && $_GET['type']=='soon'){
			$condition['start_time']	=	array('egt',time());
			Tpl::output('type', 'soon');
		}elseif(isset($_GET['type']) && $_GET['type']=='end'){
			$condition['end_time']		=	array('elt',time());
			Tpl::output('type', 'end');
		}else{
			$condition['start_time']	=	array('elt',time());
			$condition['end_time']		=	array('egt',time());
			Tpl::output('type', 'immediate');
		}


		//区域城市商区
		if(cookie('city_id')){
			$condition['city_id']	= cookie('city_id');
		}
		if(isset($_GET['area_id']) && !empty($_GET['area_id'])){
			$condition['area_id'] = intval($_GET['area_id']);
			Tpl::output('area_id', intval($_GET['area_id']));
			if(isset($_GET['mall_id']) && !empty($_GET['mall_id'])){
				$condition['mall_id'] = intval($_GET['mall_id']);
				Tpl::output('mall_id', intval($_GET['mall_id']));
			}
		}

		//分类
		if(isset($_GET['class_id']) && !empty($_GET['class_id'])){
			$condition['class_id'] = intval($_GET['class_id']);
			Tpl::output('class_id', intval($_GET['class_id']));
			if(isset($_GET['s_class_id']) && !empty($_GET['s_class_id'])){
				$condition['s_class_id'] = intval($_GET['s_class_id']);
				Tpl::output('s_class_id', intval($_GET['s_class_id']));
			}
		}

		//价格区间
		if(isset($_GET['dis']) && !empty($_GET['dis'])){
			switch($_GET['dis']){
				case 1:
					$condition['groupbuy_price']	=	array('lt',20);
					break;
				case 2:
					$condition['groupbuy_price']	=	array('between','20,49');
					break;
				case 3:
					$condition['groupbuy_price']	=	array('between','50,79');
					break;
				case 4:
					$condition['groupbuy_price']	=	array('between','80,119');
					break;
				case 5:
					$condition['groupbuy_price']	=	array('between','120,199');
					break;
				case 6:
					$condition['groupbuy_price']	=	array('between','200,500');
					break;
				case 7:
					$condition['groupbuy_price']	=	array('gt',500);
					break;
			}
		}

		//抢购排序
		$orderby = '';
		if(isset($_GET['order']) && isset($_GET['sort'])){
			switch($_GET['order']){
				case 'sales':
					$order = 'buyer_num';
					break;
				case 'price':
					$order = 'groupbuy_price';
					break;
				case 'time':
					$order = 'publish_time';
					break;
				default:
					$order = 'groupbuy_id';
					break;
			}

			$sort = in_array($_GET['sort'],array('desc','asc'))?$_GET['sort']:'desc';
			$orderby = $order.' '.$sort;
			Tpl::output('order',trim($_GET['order']));
			Tpl::output('sort',$sort=='desc'?'asc':'desc');
		}else{
			$orderby = 'groupbuy_id desc';
			Tpl::output('sort',empty($_GET['sort'])?'desc':$_GET['sort']);
		}

		$model_live_groupbuy = Model('live_groupbuy');
		$groupbuy_list = $model_live_groupbuy->getList($condition,'','',$orderby);

		Tpl::output('groupbuy_list', $groupbuy_list);
		Tpl::output('show_page', $model_live_groupbuy->showpage(5));

		$this->classlist();//抢购分类
		$this->citylist();//城市列表
		$this->arealist();//区域列表

		$pricedis = $this->pconsume();
		Tpl::output('pricedis',$pricedis);

		$this->onlineclass();
		Tpl::showpage('live_groupbuy_list');
	}

	/*
	 * 选择城市
	 */
	public function select_cityOp(){
		$city_id = intval($_GET['city_id']);
		$model_live_area = Model('live_area');
		$city = $model_live_area->live_areaInfo(array('live_area_id'=>$city_id));
		if(empty($city)&&$city_id!=0){
			showMessage('该城市不存在，请选择其他城市');
		}
		setNcCookie('city_id',$city_id);
		redirect("index.php?act=show_live_groupbuy");
	}


	/*
	 * 区域列表
	 */
	private function arealist(){
		$parent_area_id = cookie('city_id');
		if(!$area_list = F('area_'.$parent_area_id,null,'cache/city')){
			$model_live_area = Model('live_area');
			$area_list = $model_live_area->getList(array('parent_area_id'=>$parent_area_id));

			if(!empty($area_list)){
				foreach($area_list as $key=>$val){
					$area_list[$key][] = $model_live_area->getList(array('parent_area_id'=>$val['live_area_id']));
				}
			}
			F('area_'.$parent_area_id,$area_list,'cache/city');
		}
		Tpl::output('area_list',$area_list);
	}


	/*
	 * 价格区间
	 */
	private function pconsume(){
		return	array(
				1	=>	'20元以下',
				2	=>	'20-50元',
				3	=>	'50-80元',
				4	=>	'80-120元',
				5	=>	'120-200元',
				6	=>	'200-500元',
				7	=>	'500元以上'
		);
	}

	/*
	 * 抢购详情
	 */
	public function groupbuy_detailOp(){
		$groupbuy_id = intval($_GET['groupbuy_id']);
		$model_live_groupbuy = Model('live_groupbuy');
		$condition					= array();
		$condition['groupbuy_id']	= $groupbuy_id;
		$condition['is_audit']		= 2;//2.审核通过
		$condition['is_open']		= 1;//1.开启
		$live_groupbuy = $model_live_groupbuy->live_groupbuyInfo($condition);
		if(empty($live_groupbuy)){
			showMessage('抢购不存在');
		}

		if($live_groupbuy['start_time']>time()){//即将开始
			Tpl::output('groupbuy_state',1);
		}elseif($live_groupbuy['start_time']<time() && $live_groupbuy['end_time']>time()){//正在进行
			Tpl::output('groupbuy_state',2);
		}else{//已经结束
			Tpl::output('groupbuy_state',3);
		}


		Tpl::output('live_groupbuy',$live_groupbuy);

		$recommend_condition = array();
		$recommend_condition['is_hot'] = 1;//0.未推荐 1.已推荐
		$recommend_condition['is_audit'] = 2;//1.待审核 2.审核通过 3.审核未通过
		$recommend_condition['is_open']= 1;//1.开启
		$recommend_condition['start_time']	=	array('elt',time());
		$recommend_condition['end_time']	=	array('egt',time());
		$recommend_live_groupbuy = $model_live_groupbuy->getList($recommend_condition,'','5');
		Tpl::output('recommend_live_groupbuy',$recommend_live_groupbuy);//推荐抢购

		$store_condition = array();//店铺信息
		$store_condition['store_id'] = $live_groupbuy['store_id'];
		$model_store = Model('store');
		$store_info = $model_store->getStoreInfo($store_condition);
		Tpl::output('store_info',$store_info);

		Tpl::showpage('live_groupbuy_detail');
	}


	/*
	 * 抢购购买
	 */
	public function livegroupbuyorderOp(){
		if($_SESSION['is_login'] !== '1'){//检测是否登录
			showMessage('请先登录','index.php?act=login&op=index','','error');
		}

		Language::read('common,home_layout');
		Tpl::setDir('buy');
		Tpl::setLayout('groupbuy_layout');


		$groupbuy_id = intval($_GET['groupbuy_id']);
		$model_live_groupbuy = Model('live_groupbuy');
		$live_groupbuy = $model_live_groupbuy->live_groupbuyInfo(array('groupbuy_id'=>$groupbuy_id));

		if(empty($live_groupbuy)){
			showMessage('该抢购不存在','','','error');
		}

		if($live_groupbuy['start_time']>time()){
			showMessage('抢购即将开始','','','error');
		}

		if($live_groupbuy['end_time']<time()){
			showMessage('抢购已经结束','','','error');
		}
		Tpl::output('live_groupbuy',$live_groupbuy);

		$model_member = Model('member');
		$member = $model_member->getMemberInfo(array('member_id'=>$_SESSION['member_id']));
		Tpl::output('member',$member);

		$model_store = Model('store');
		$store_info = $model_store->getStoreInfo(array('store_id'=>$live_groupbuy['store_id']));
		Tpl::output('store_info',$store_info);
		Tpl::output('buy_step','step1');
		Tpl::showpage('live_groupbuy_order');
	}

	/*
	 * 抢购STEP1
	 */
	public function livegroupbuystep1Op(){
		if($_SESSION['is_login'] !== '1'){//检测是否登录
			showMessage('请先登录','index.php?act=login&op=index','','error');
		}

		Language::read('common,home_layout');
		Tpl::setDir('buy');
		Tpl::setLayout('groupbuy_layout');

		$groupbuy_id = intval($_POST['groupbuy_id']);
		$model_live_groupbuy = Model('live_groupbuy');
		$live_groupbuy = $model_live_groupbuy->live_groupbuyInfo(array('groupbuy_id'=>$groupbuy_id));
		if(empty($live_groupbuy)){
			showMessage('该抢购不存在','','','error');
		}

		if($live_groupbuy['start_time']>time()){
			showMessage('抢购即将开始','','','error');
		}

		if($live_groupbuy['end_time']<time()){
			showMessage('抢购已经结束','','','error');
		}
		Tpl::output('live_groupbuy',$live_groupbuy);
		Tpl::output('q_number',intval($_POST['q_number'])>0?intval($_POST['q_number']):1);

		$model_member = Model('member');
		$member = $model_member->getMemberInfo(array('member_id'=>$_SESSION['member_id']));
		Tpl::output('member',$member);

		$model_store = Model('store');
		$store_info = $model_store->getStoreInfo(array('store_id'=>$live_groupbuy['store_id']));
		Tpl::output('store_info',$store_info);

		Tpl::output('buy_step','step2');
		Tpl::showpage('live_groupbuy_step1');
	}

	/*
	 * 抢购STEP2
	 */
	public function livegroupbuystep2Op(){
		if(chksubmit()){
			$groupbuy_id = intval($_POST['groupbuy_id']);
			$model_live_groupbuy = Model('live_groupbuy');
			$live_groupbuy = $model_live_groupbuy->live_groupbuyInfo(array('groupbuy_id'=>$groupbuy_id));

			if(empty($live_groupbuy)){
				showMessage('该抢购不存在','','','error');
			}

			if($live_groupbuy['start_time']>time()){
				showMessage('抢购即将开始','','','error');
			}

			if($live_groupbuy['end_time']<time()){
				showMessage('抢购已经结束','','','error');
			}

			$model_member = Model('member');
			$member = $model_member->getMemberInfo(array('member_id'=>$_SESSION['member_id']));

			if(empty($member)){
				showMessage('请登录','','','error');
			}

			$params = array();
			$params['order_sn'] = $order_sn = $this->makeOrderSn($member['member_id']);
			$params['member_id']= $_SESSION['member_id'];
			$params['member_name'] = $_SESSION['member_name'];
			$params['mobile']	= trim($_POST['mobile']);
			$params['store_id'] = $live_groupbuy['store_id'];
			$params['store_name']= $live_groupbuy['store_name'];
			$params['add_time'] = time();
			$params['item_id']	= $live_groupbuy['groupbuy_id'];
			$params['item_name']= $live_groupbuy['groupbuy_name'];
			$params['number']	= intval($_POST['number']);
			$params['price']	= intval($_POST['number'])*$live_groupbuy['groupbuy_price'];
			$params['state']	= 1;
			$params['leave_message'] = $_POST['leave_message'];

			if(isset($_POST['pd_pay']) && $_POST['pd_pay']==1){
				$params['payment_code'] = 'predeposit';

				$model_member = Model('member');
				$member = $model_member->getMemberInfo(array('member_id'=>$_SESSION['member_id']));

				if($params['price']>$member['available_predeposit']){//使用预存款支付部分

					$condition				= array();
					$condition['member_id']	= $_SESSION['member_id'];

					$change_type = 'live_groupbuy_part';
					$data = array();
					$data['amount'] = $member['available_predeposit'];
					$data['order_sn'] = $order_sn;
					$data['member_id'] = $_SESSION['member_id'];
					$data['member_name'] = $_SESSION['member_name'];

					$model_predeposit = Model('predeposit');
					$res = $model_predeposit->changePd($change_type,$data);

					if(!$res){
						showMessage('订单支付失败','index.php?act=member_live','html','error');
					}

					$params['py_amount']	= $member['available_predeposit'];
				}else{
					$params['py_amount']	= $params['price'];
				}
			}

			$model_live_order = Model('live_order');
			$res = $model_live_order->add($params);

			if($res){
				//转向到商城支付页面
				$pay_url = 'index.php?act=show_live_groupbuy&op=pay&order_sn='.$order_sn;
				redirect($pay_url);
			}else{
				showMessage('抢购失败','index.php?act=member_live&op=index','html','error');
			}
		}else{
			showMessage('抢购失败','index.php?act=member_live&op=index','html','error');
		}
	}

    /**
     * 下单时支付页面
     */
	public function payOp(){
		$order_sn	= $_GET['order_sn'];
        if (!preg_match('/^\d{18}$/',$order_sn)){
            showMessage('订单不存在','index.php?act=member_live&op=index','html','error');
        }

		//查询支付单信息
        $model_live_order = Model('live_order');
        $order_info = $model_live_order->live_orderInfo(array('order_sn'=>$order_sn,'member_id'=>$_SESSION['member_id']));
        if(empty($order_info)){
            showMessage('订单不存在','','html','error');
        }
        Tpl::output('order_info',$order_info);

		if(!empty($order_info['payment_code'])&&$order_info['payment_code']=='predeposit'){
			$model_member = Model('member');
			$member = $model_member->getMemberInfo(array('member_id'=>$_SESSION['member_id']));

			$price = $member['available_predeposit']-$order_info['price'];
			if($price>0){//使用预存款支付
				$condition = array();
				$condition['order_id'] = $order_info['order_id'];

				$params = array();
				$params['state'] = 2;//已支付
				$params['payment_time'] = time();//支付时间
				$res1 = $model_live_order->updateLiveOrder($condition,$params);//修改订单状态

				$change_type = 'live_groupbuy';
				$data = array();
				$data['amount'] = $order_info['price'];
				$data['order_sn'] = $order_info['order_sn'];
				$data['member_id'] = $_SESSION['member_id'];
				$data['member_name'] = $_SESSION['member_name'];

				$model_predeposit = Model('predeposit');
				$res2 = $model_predeposit->changePd($change_type,$data);

				$groupbuy_params = array();
				$groupbuy_params['buyer_count'] = array('exp','buyer_count-'.$order_info['number']);
				$groupbuy_params['buyer_num'] = array('exp','buyer_num+'.$order_info['number']);

				$groupbuy_condition = array();
				$groupbuy_condition['groupbuy_id'] = $order_info['item_id'];
				$model_live_groupbuy = Model('live_groupbuy');
				$res3 = $model_live_groupbuy->edit($groupbuy_condition,$groupbuy_params);

				if($res1 && $res2 && $res3){


					//转向到商城支付页面
					$pay_url = 'index.php?act=show_live_groupbuy&op=pay_ok&order_sn='.$order_sn;
					redirect($pay_url);
				}else{
					showMessage('抢购失败','index.php?act=member_live&op=index','html','error');
				}
			}else{//使用预存款支付部分
				Tpl::output('member',$member);
				Tpl::output('paymentpart',1);
			}
		}

		//支付方式
		$model_payment = Model('payment');
		$condition = array();
		$payment_list = $model_payment->getPaymentOpenList($condition);
		if (!empty($payment_list)) {
			unset($payment_list['predeposit']);
			unset($payment_list['offline']);
		}
		if (empty($payment_list)) {
			showMessage('暂未找到合适的支付方式','index.php?act=member_live','html','error');
		}
		Tpl::output('payment_list',$payment_list);

		Language::read('common,home_layout');
		Tpl::setDir('buy');
		Tpl::setLayout('groupbuy_layout');
		Tpl::output('buy_step','step3');
		Tpl::showpage('live_groupbuy_step2');
	}

    /**
     * 订单支付
     */
	public function paymentOp(){
		$order_sn = $_POST['order_sn'];
		$payment_code = $_POST['payment_code'];
        $url = 'index.php?act=member_live';

        $valid = !preg_match('/^\d{18}$/',$order_sn) || !preg_match('/^[a-z]{1,20}$/',$payment_code);
        if($valid){
            showMessage(Language::get('para_error'),'','html','error');
        }

		//支付信息
        $model_payment = Model('payment');
		$condition_payment = array();
		$condition_payment['payment_code'] = $payment_code;
		$payment_info = $model_payment->getPaymentOpenInfo($condition_payment);
		if(empty($payment_info)){
			showMessage('暂未找到合适的支付方式','index.php?act=member_live','html','error');
		}

		//订单信息
		$condition = array();
		$condition['order_sn'] = $order_sn;
		$model_live_order = Model('live_order');
		$order_info = $model_live_order->live_orderInfo($condition);

		if(empty($order_info)){
			showMessage('该订单不存在','index.php?act=member_live','html','error');
		}

		if($order_info['py_amount']>0){
			$order = array();
			$order['pay_sn']		= $order_sn;
			$order['subject']		= $order_info['item_name'];
			$order['order_type']	= 'live_groupbuy';//抢购订单
			$order['pay_amount']	= $order_info['price']-$order_info['py_amount'];
			$order['buyer_id']		= $order_info['member_id'];
			$order['api_pay_state'] = 0;
		}else{
			$order = array();
			$order['pay_sn']		= $order_sn;
			$order['subject']		= $order_info['item_name'];
			$order['order_type']	= 'live_groupbuy';//抢购订单
			$order['pay_amount']	= $order_info['price'];
			$order['buyer_id']		= $order_info['member_id'];
			$order['api_pay_state'] = 0;
		}

		//第三方API支付
        $this->_api_pay($order, $payment_info);
	}


	/**
	 * 第三方在线支付接口
	 *
	 */
	private function _api_pay($order_info, $payment_info) {
    	$inc_file = BASE_PATH.DS.'api'.DS.'payment'.DS.$payment_info['payment_code'].DS.$payment_info['payment_code'].'.php';
    	if(!file_exists($inc_file)){
    		showMessage(Language::get('payment_index_lose_file'),'','html','error');
    	}
    	require_once($inc_file);
    	$payment_info['payment_config']	= unserialize($payment_info['payment_config']);
    	$payment_api = new $payment_info['payment_code']($payment_info,$order_info);
    	if($payment_info['payment_code'] == 'chinabank') {
    		$payment_api->submit();
    	} else {
    		@header("Location: ".$payment_api->get_payurl());
    	}
    	exit;
	}

	/**
	 * 支付成功页面
	 */
	public function pay_okOp() {
	    $order_sn	= $_GET['order_sn'];
        if (!preg_match('/^\d{18}$/',$order_sn)){
            showMessage('订单不存在','index.php?act=member_live&op=index','html','error');
        }

		Language::read('common,home_layout');
		Tpl::setDir('buy');
		Tpl::setLayout('buy_layout');

	    //查询支付单信息
	    $model_live_order= Model('live_order');
	    $order_info = $model_live_order->live_orderInfo(array('order_sn'=>$order_sn,'member_id'=>$_SESSION['member_id']));
	    if(empty($order_info)){
	        showMessage('订单不存在','index.php?act=member_live&op=index','html','error');
	    }
	    Tpl::output('order_info',$order_info);

		//生成抢购券
		$sn_str = '';
		for($i=0;$i<$order_info['number'];$i++){
			$sn = $this->_groupbuySN();
			$order_pwd = $model_live_order->getLiveOrderPwd(array('order_pwd'=>$sn));
			if(count($order_pwd)>0){
				$i--;
				continue;
			}
			$params				= array();
			$params['order_id']	= $order_info['order_id'];
			$params['state']	= 1;//1.未使用
			$params['order_pwd']= $sn;

			$model_live_order->addLiveOrderPwd($params);
			$sn_str.=$sn.',';
		}

		//发送短信
		$sn_str = trim($sn_str,',');
		$content = '您的抢购兑换券：'.$sn_str;
		$sms = new Sms;
		$sms->send($order_info['mobile'],$content.'【'.C('site_name').'】');

		Tpl::output('buy_step','step4');
		Tpl::showpage('live_groupbuy_step3');
	}


    /**
     * AJAX验证支付密码
     */
    public function check_pd_pwdOp(){
        if (empty($_GET['password'])) exit('0');
        $buyer_info	= Model('member')->infoMember(array('member_id' => $_SESSION['member_id']));
        echo ($buyer_info['member_paypwd'] != '' && $buyer_info['member_paypwd'] === md5($_GET['password'])) ? '1' : '0';
    }

	/**
	 * 生成支付单编号(两位随机 + 从2000-01-01 00:00:00 到现在的秒数+微秒+会员ID%1000)，该值会传给第三方支付接口
	 * 长度 =2位 + 10位 + 3位 + 3位  = 18位
	 * 1000个会员同一微秒提订单，重复机率为1/100
	 * @return string
	 */
	public function makeOrderSn($member_id) {
		return mt_rand(10,99)
		      . sprintf('%010d',time() - 946656000)
		      . sprintf('%03d', (float) microtime() * 1000)
		      . sprintf('%03d', (int) $member_id % 1000);
	}


    /**
     * AJAX验证支付密码
     */
	private function _groupbuySN(){
		return mt_rand(100000,999999).mt_rand(1000000,9999999);
	}
}
