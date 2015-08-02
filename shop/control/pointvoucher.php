<?php
/**
 * 代金券
 ***/


defined('InShopNC') or exit('Access Invalid!');
class pointvoucherControl extends BasePointShopControl {
	public function __construct() {
		parent::__construct();
		//读取语言包
		Language::read('home_voucher');
		//判断系统是否开启代金券功能
		if (C('voucher_allow') != 1){
			showDialog(L('voucher_pointunavailable'),'index.php','error');
		}
	}
	public function indexOp(){
		$this->pointvoucherOp();
	}
	/**
	 * 代金券列表
	 */
	public function pointvoucherOp(){
	    //查询会员及其附属信息
	    parent::pointshopMInfo();

		$model_voucher = Model('voucher');

		//代金券模板状态
		$templatestate_arr = $model_voucher->getTemplateState();

		//查询会员信息
		$member_info = Model('member')->getMemberInfoByID($_SESSION['member_id']);

		//查询代金券列表
		$where = array();
		$where['voucher_t_state'] = $templatestate_arr['usable'][0];
		$where['voucher_t_end_date'] = array('gt',time());
		if (intval($_GET['sc_id']) > 0){
		    $where['voucher_t_sc_id'] = intval($_GET['sc_id']);
		}
		if (intval($_GET['price']) > 0){
		    $where['voucher_t_price'] = intval($_GET['price']);
		}
		//查询仅我能兑换和所需积分
		$points_filter = array();
		if (intval($_GET['isable']) == 1){
		    $points_filter['isable'] = $member_info['member_points'];
		}
		if (intval($_GET['points_min']) > 0){
		    $points_filter['min'] = intval($_GET['points_min']);
		}
		if (intval($_GET['points_max']) > 0){
		    $points_filter['max'] = intval($_GET['points_max']);
		}
		if (count($points_filter) > 0){
		    asort($points_filter);
		    if (count($points_filter) > 1){
		        $points_filter = array_values($points_filter);
		        $where['voucher_t_points'] = array('between',array($points_filter[0],$points_filter[1]));
		    } else {
		        if ($points_filter['min']){
		            $where['voucher_t_points'] = array('egt',$points_filter['min']);
		        } elseif ($points_filter['max']) {
		            $where['voucher_t_points'] = array('elt',$points_filter['max']);
		        } elseif ($points_filter['isable']) {
		            $where['voucher_t_points'] = array('elt',$points_filter['isable']);
		        }
		    }
		}
		//排序
		switch ($_GET['orderby']){
			case 'exchangenumdesc':
			    $orderby = 'voucher_t_giveout desc,';
			    break;
			case 'exchangenumasc':
			    $orderby = 'voucher_t_giveout asc,';
			    break;
	        case 'pointsdesc':
	            $orderby = 'voucher_t_points desc,';
	            break;
            case 'pointsasc':
                $orderby = 'voucher_t_points asc,';
                break;
		}
		$orderby .= 'voucher_t_id desc';
		$voucherlist = $model_voucher->getVoucherTemplateList($where, '*', 0, 18, $orderby);
		Tpl::output('voucherlist',$voucherlist);
		Tpl::output('show_page', $model_voucher->showpage(2));

		//查询代金券面额
		$pricelist = $model_voucher->getVoucherPriceList();
		Tpl::output('pricelist',$pricelist);

		//查询店铺分类
		$store_class = rkcache('store_class', true);
		Tpl::output('store_class', $store_class);

		//分类导航
		$nav_link = array(
		        0=>array('title'=>Language::get('homepage'),'link'=>SHOP_SITE_URL),
		        1=>array('title'=>'积分中心','link'=>urlShop('pointshop','index')),
		        2=>array('title'=>'代金券列表')
		);
		Tpl::output('nav_link_list', $nav_link);
		Tpl::showpage('pointvoucher');
	}
	/**
	 * 兑换代金券
	 */
	public function voucherexchangeOp(){
		$vid = intval($_GET['vid']);
		if($vid <= 0){
			$vid = intval($_POST['vid']);
		}
		if($_SESSION['is_login'] != '1'){
			$js = "login_dialog();";
			showDialog('','','js',$js);
		}elseif ($_GET['dialog']){
			$js = "CUR_DIALOG = ajax_form('vexchange', '".L('home_voucher_exchangtitle')."', 'index.php?act=pointvoucher&op=voucherexchange&vid={$vid}', 550);";
			showDialog('','','js',$js);
			die;
		}
		$result = true;
		$message = "";
		if ($vid <= 0){
			$result = false;
			L('wrong_argument');
		}
		if ($result){
			//查询可兑换代金券模板信息
			$template_info = Model('voucher')->getCanChangeTemplateInfo($vid,intval($_SESSION['member_id']),intval($_SESSION['store_id']));
			if ($template_info['state'] == false){
				$result = false;
				$message = $template_info['msg'];
			}else {
				//查询会员信息
				$member_info = Model('member')->getMemberInfoByID($_SESSION['member_id'],'member_points');
				Tpl::output('member_info',$member_info);
				Tpl::output('template_info',$template_info['info']);
			}
		}
		Tpl::output('message',$message);
		Tpl::output('result',$result);
		Tpl::showpage('pointvoucher.exchange','null_layout');
	}
	/**
	 * 兑换代金券保存信息
	 *
	 */
	public function voucherexchange_saveOp(){
		if($_SESSION['is_login'] != '1'){
			$js = "login_dialog();";
			showDialog('','','js',$js);
		}
		$vid = intval($_POST['vid']);
		$js = "DialogManager.close('vexchange');";
		if ($vid <= 0){
			showDialog(L('wrong_argument'),'','error',$js);
		}
		$model_voucher = Model('voucher');
		//验证是否可以兑换代金券
		$data = $model_voucher->getCanChangeTemplateInfo($vid,intval($_SESSION['member_id']),intval($_SESSION['store_id']));
		if ($data['state'] == false){
			showDialog($data['msg'],'','error',$js);
		}
		//添加代金券信息
		$data = $model_voucher->exchangeVoucher($data['info'],$_SESSION['member_id'],$_SESSION['member_name']);
		if ($data['state'] == true){
			showDialog($data['msg'],'','succ',$js);
		} else {
		    showDialog($data['msg'],'','error',$js);
		}
	}
}
