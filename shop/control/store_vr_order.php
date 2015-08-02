<?php
/**
 * 卖家虚拟订单管理
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class store_vr_orderControl extends BaseSellerControl {
    public function __construct() {
        parent::__construct();
        Language::read('member_store_index');
    }

	/**
	 * 虚拟订单列表
	 *
	 */
	public function indexOp() {
        $model_vr_order = Model('vr_order');

        $condition = array();
        $condition['store_id'] = $_SESSION['store_id'];
        if ($_GET['order_sn'] != '') {
            $condition['order_sn'] = $_GET['order_sn'];
        }
        if ($_GET['buyer_name'] != '') {
            $condition['buyer_name'] = $_GET['buyer_name'];
        }
        $allow_state_array = array('state_new','state_pay','state_success','state_cancel');
        if (in_array($_GET['state_type'],$allow_state_array)) {
            $condition['order_state'] = str_replace($allow_state_array,
                    array(ORDER_STATE_NEW,ORDER_STATE_PAY,ORDER_STATE_SUCCESS,ORDER_STATE_CANCEL), $_GET['state_type']);
        } else {
            $_GET['state_type'] = 'store_order';
        }
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
        $start_unixtime = $if_start_date ? strtotime($_GET['query_start_date']) : null;
        $end_unixtime = $if_end_date ? strtotime($_GET['query_end_date']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }

        if ($_GET['skip_off'] == 1) {
            $condition['order_state'] = array('neq',ORDER_STATE_CANCEL);
        }

	    $order_list = $model_vr_order->getOrderList($condition, 20, '*', 'order_id desc');

        foreach ($order_list as $key => $order) {
            //显示取消订单
            $order_list[$key]['if_cancel'] = $model_vr_order->getOrderOperateState('buyer_cancel',$order);

            //追加返回买家信息
            $order_list[$key]['extend_member'] = Model('member')->getMemberInfoByID($order['buyer_id']);
        }

        Tpl::output('order_list',$order_list);
        Tpl::output('show_page',$model_vr_order->showpage());
        self::profile_menu('list',$_GET['state_type']);

        Tpl::showpage('store_vr_order.index');
	}

	/**
	 * 卖家订单详情
	 *
	 */
	public function show_orderOp() {
	    $order_id = intval($_GET['order_id']);
	    if ($order_id <= 0) {
	        showMessage(Language::get('wrong_argument'),'','html','error');
	    }
	    $model_vr_order = Model('vr_order');
	    $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = $_SESSION['store_id'];
	    $order_info = $model_vr_order->getOrderInfo($condition);
	    if (empty($order_info)) {
	        showMessage(Language::get('store_order_none_exist'),'','html','error');
	    }

        //取兑换码列表
        $vr_code_list = $model_vr_order->getOrderCodeList(array('order_id' => $order_info['order_id']));
        $order_info['extend_vr_order_code'] = $vr_code_list;

        //显示取消订单
        $order_info['if_cancel'] = $model_vr_order->getOrderOperateState('buyer_cancel',$order_info);

        //显示订单进行步骤
        $order_info['step_list'] = $model_vr_order->getOrderStep($order_info);

        //显示系统自动取消订单日期
        if ($order_info['order_state'] == ORDER_STATE_NEW) {
            //$order_info['order_cancel_day'] = $order_info['add_time'] + ORDER_AUTO_CANCEL_DAY * 24 * 3600;
			// by abc.com
			$order_info['order_cancel_day'] = $order_info['add_time'] + ORDER_AUTO_CANCEL_DAY + 3 * 24 * 3600;
        }

        Tpl::output('order_info',$order_info);

		Tpl::showpage('store_vr_order.show');
	}

	/**
	 * 卖家订单状态操作
	 *
	 */
	public function change_stateOp() {
	    $model_vr_order = Model('vr_order');
	    $condition = array();
	    $condition['order_id'] = intval($_GET['order_id']);
	    $condition['store_id'] = $_SESSION['store_id'];
	    $order_info	= $model_vr_order->getOrderInfo($condition);
	    if ($_GET['state_type'] == 'order_cancel') {
	        $result = $this->_order_cancel($order_info,$_POST);
	    }
	    if(!$result['state']) {
	        showDialog($result['msg'],'','error');
	    } else {
	        showDialog($result['msg'],'reload','js');
	    }
	}

	/**
	 * 取消订单
	 * @param arrty $order_info
	 * @param arrty $post
	 * @throws Exception
	 */
	private function _order_cancel($order_info, $post) {
	    if(!chksubmit()) {
	        Tpl::output('order_id',$order_info['order_id']);
	        Tpl::output('order_info',$order_info);
	        Tpl::showpage('store_vr_order.cancel','null_layout');
	        exit();
	    } else {
	        $model_vr_order = Model('vr_order');
	        $logic_vr_order = Logic('vr_order');
	        $if_allow = $model_vr_order->getOrderOperateState('store_cancel',$order_info);
            if (!$if_allow) {
                return callback(false,'无权操作');
            }
            $msg = $post['state_info1'] != '' ? $post['state_info1'] : $post['state_info'];
            return $logic_vr_order->changeOrderStateCancel($order_info,'seller', $msg);
	    }
	}

	public function exchangeOp() {
	    $data = $this->_exchange();
	    exit(json_encode($data));
	}

	/**
	 * 兑换码消费
	 */
    private function _exchange() {
        if (chksubmit()) {
            if (!preg_match('/^[a-zA-Z0-9]{15,18}$/',$_GET['vr_code'])) {
                return array('error' => '兑换码格式错误，请重新输入');
            }
            $model_vr_order = Model('vr_order');
            $vr_code_info = $model_vr_order->getOrderCodeInfo(array('vr_code' => $_GET['vr_code']));
            if (empty($vr_code_info) || $vr_code_info['store_id'] != $_SESSION['store_id']) {
                return array('error' => '该兑换码不存在');
            }
            if ($vr_code_info['vr_state'] == '1') {
                return array('error' => '该兑换码已被使用');
            }
            if ($vr_code_info['vr_indate'] < TIMESTAMP) {
                return array('error' => '该兑换码已过期，使用截止日期为： '.date('Y-m-d H:i:s',$vr_code_info['vr_indate']));
            }
            if ($vr_code_info['refund_lock'] > 0) {//退款锁定状态:0为正常,1为锁定(待审核),2为同意
                return array('error' => '该兑换码已申请退款，不能使用');
            }

            //更新兑换码状态
            $update = array();
            $update['vr_state'] = 1;
            $update['vr_usetime'] = TIMESTAMP;
            $update = $model_vr_order->editOrderCode($update, array('vr_code' => $_GET['vr_code']));

            //如果全部兑换完成，更新订单状态
            Logic('vr_order')->changeOrderStateSuccess($vr_code_info['order_id']);

            if ($update) {
                //取得返回信息
                $order_info = $model_vr_order->getOrderInfo(array('order_id'=>$vr_code_info['order_id']));
                if ($order_info['use_state'] == '0') {
                    $model_vr_order->editOrder(array('use_state' => 1), array('order_id' => $vr_code_info['order_id']));
                }
                $order_info['img_60'] = thumb($order_info,60);
                $order_info['img_240'] = thumb($order_info,240);
                $order_info['goods_url'] = urlShop('goods','index',array('goods_id' => $order_info['goods_id']));
                $order_info['order_url'] = urlShop('store_vr_order','show_order',array('order_id' => $order_info['order_id']));
                return array('error'=>'', 'data' => $order_info);
            }

        } else {
            self::profile_menu('exchange','exchange');
            Tpl::showpage('store_vr_order.exchange');
        }
    }

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
     */
    private function profile_menu($menu_type='',$menu_key='') {
        Language::read('member_layout');
        switch ($menu_type) {
        	case 'list':
            $menu_array = array(
            array('menu_key'=>'store_order',		'menu_name'=>Language::get('nc_member_path_all_order'),	'menu_url'=>'index.php?act=store_vr_order'),
            array('menu_key'=>'state_new',			'menu_name'=>Language::get('nc_member_path_wait_pay'),	'menu_url'=>'index.php?act=store_vr_order&op=index&state_type=state_new'),
            array('menu_key'=>'state_pay',			'menu_name'=>'已付款',	'menu_url'=>'index.php?act=store_vr_order&op=index&state_type=state_pay'),
            array('menu_key'=>'state_success',		'menu_name'=>Language::get('nc_member_path_finished'),	'menu_url'=>'index.php?act=store_vr_order&op=index&state_type=state_success'),
            array('menu_key'=>'state_cancel',		'menu_name'=>Language::get('nc_member_path_canceled'),	'menu_url'=>'index.php?act=store_vr_order&op=index&state_type=state_cancel'),
            );
            break;
            case 'exchange':
                $menu_array = array(
                array('menu_key'=>'store_order',		'menu_name'=>Language::get('nc_member_path_all_order'),	'menu_url'=>'index.php?act=store_vr_order'),
                array('menu_key'=>'state_new',			'menu_name'=>Language::get('nc_member_path_wait_pay'),	'menu_url'=>'index.php?act=store_vr_order&op=index&state_type=state_new'),
                array('menu_key'=>'state_pay',			'menu_name'=>'已付款',	'menu_url'=>'index.php?act=store_vr_order&op=index&state_type=state_pay'),
                array('menu_key'=>'state_success',		'menu_name'=>Language::get('nc_member_path_finished'),	'menu_url'=>'index.php?act=store_vr_order&op=index&state_type=state_success'),
                array('menu_key'=>'state_cancel',		'menu_name'=>Language::get('nc_member_path_canceled'),	'menu_url'=>'index.php?act=store_vr_order&op=index&state_type=state_cancel'),
                array('menu_key'=>'exchange',		    'menu_name'=>'兑换码兑换',	'menu_url'=>'index.php?act=store_vr_order&op=exchange'),
                );
                break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
