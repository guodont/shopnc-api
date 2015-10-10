<?php
/**
 * 圈子话题管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class circle_memberControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('circle');
	}
	/**
	 * 成员列表
	 */
	public function member_listOp(){
		$model = Model();
		if(chksubmit()){
			if (!empty($_POST['check_param']) && is_array($_POST['check_param'])){
				foreach ($_POST['check_param'] as $val){
					$param = explode('|', $val);
					list($member_id, $circle_id) = $param;
					$where['member_id'] = $member_id;
					$where['circle_id'] = $circle_id;
					Model()->table('circle_member')->where($where)->delete();
				}
			}
			showMessage(L('nc_common_op_succ'));
		}
		$where = array();
		if($_GET['searchname'] != ''){
			$where['member_name'] = array('like', '%'.$_GET['searchname'].'%');
		}
		if($_GET['circlename'] != ''){
			$where['circle_name'] = array('like', '%'.$_GET['circlename'].'%');
		}
		if($_GET['searchrecommend'] != '' && in_array(intval($_GET['searchrecommend']), array(0,1))){
			$where['is_recommend'] = intval($_GET['searchrecommend']);
		}
		if ($_GET['searchidentity'] != '' && in_array(intval($_GET['searchidentity']), array(1,2,3))) {
		    $where['is_identity'] = intval($_GET['searchidentity']);
		}

		$order = array();
		if(intval($_GET['searchsort']) > 0){
			switch (intval($_GET['searchsort'])){
				case 1:
					$order = 'cm_thcount desc';
					break;
				case 2:
					$order = 'cm_comcount desc';
					break;
				default:
					$order = 'cm_jointime desc';
					break;
			}
		}
		$member_list = $model->table('circle_member')->where($where)->page(10)->order($order)->select();
		Tpl::output('show_page', $model->showpage('2'));
		Tpl::output('member_list', $member_list);
		Tpl::showpage('circle_member.list');
	}
	/**
	 * 删除会员
	 */
	public function member_delOp(){
	    if (chksubmit()) {
	        $param = explode(',', $_GET['param']);
	        foreach ($param as $value) {
        		$tpl_param = explode('|', $value);
        		list($member_id, $circle_id) = $tpl_param;
        		$where['member_id'] = $member_id;
        		$where['circle_id'] = $circle_id;
        		Model()->table('circle_member')->where($where)->delete();

        		if ($_POST['all']) {
        		    Model()->table('circle_theme')->where($where)->delete();
        		    Model()->table('circle_threply')->where($where)->delete();
        		}
	        }
    		showMessage(L('nc_common_op_succ'));
	    }
	    Tpl::showpage('circle_member.del', 'null_layout');
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			case 'recommend':
				$array = explode('|', $_GET['id']);
				list($member_id, $circle_id) = $array;
				$where = array();
				$where['member_id']	= $member_id;
				$where['circle_id']	= $circle_id;
				$update = array(
					$_GET['column']=>$_GET['value']
				);
				Model()->table('circle_member')->where($where)->update($update);
				echo 'true';
				break;
		}
	}
}
