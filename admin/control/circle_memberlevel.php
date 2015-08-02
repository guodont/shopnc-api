<?php
/**
 * Circle Member Level
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class circle_memberlevelControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('circle_memberlevel');
	}
	/**
	 * Members of the level set
	 */
	public function indexOp(){
		$model = Model();
		if(chksubmit()){
			$insert_all = array();
			foreach ($_POST['cmld'] as $key=>$val){
				$insert_all[$key]['mld_id']	= $val['id'];
				$insert_all[$key]['mld_name']	= $val['name'];
				$insert_all[$key]['mld_exp']	= $val['exp'];
			}
			$insert_all = array_values($insert_all);
			$rs = $model->table('circle_mldefault')->insertAll($insert_all,array(),true);
			if($rs){
				showMessage(L('nc_common_op_succ'));
			}else{
				showMessage(L('nc_common_op_fail'));
			}
		}
		$mld_list = $model->table('circle_mldefault')->select();
		$mld_list = array_under_reset($mld_list, 'mld_id');
		Tpl::output('mld_list', $mld_list);
		Tpl::showpage('circle_memberlevel');
	}
	/**
	 * Reference Title list
	 */
	public function refOp(){
		$model = Model();
		if(chksubmit()){
			$mlrefid_array = $_POST['del_id'];
			if(empty($mlrefid_array)){
				showMessage(L('param_error'));
			}
			$rs = $model->table('circle_mlref')->where(array('mlref_id'=>array('in', $mlrefid_array)))->delete();
			if($rs){
				showMessage(L('nc_common_op_succ'));
			}else{
				showMessage(L('nc_common_op_fail'));
			}
		}
		$mlref_list = $model->table('circle_mlref')->select();
		Tpl::output('mlref_list', $mlref_list);
		Tpl::showpage('circle_memberlevel.ref');
	}
	/**
	 * Add the Reference Title
	 */
	public function ref_addOp(){
		if(chksubmit()){
			$insert_array = array();
			$insert_array['mlref_name']		= $_POST['mlref_name'];
			$insert_array['mlref_addtime']	= time();
			$insert_array['mlref_status']	= intval($_POST['mlref_status']);
			$insert_array['mlref_1']		= $_POST['mlref_1'];
			$insert_array['mlref_2']		= $_POST['mlref_2'];
			$insert_array['mlref_3']		= $_POST['mlref_3'];
			$insert_array['mlref_4']		= $_POST['mlref_4'];
			$insert_array['mlref_5']		= $_POST['mlref_5'];
			$insert_array['mlref_6']		= $_POST['mlref_6'];
			$insert_array['mlref_7']		= $_POST['mlref_7'];
			$insert_array['mlref_8']		= $_POST['mlref_8'];
			$insert_array['mlref_9']		= $_POST['mlref_9'];
			$insert_array['mlref_10']		= $_POST['mlref_10'];
			$insert_array['mlref_11']		= $_POST['mlref_11'];
			$insert_array['mlref_12']		= $_POST['mlref_12'];
			$insert_array['mlref_13']		= $_POST['mlref_13'];
			$insert_array['mlref_14']		= $_POST['mlref_14'];
			$insert_array['mlref_15']		= $_POST['mlref_15'];
			$insert_array['mlref_16']		= $_POST['mlref_16'];
			$rs = Model()->table('circle_mlref')->insert($insert_array);
			if($rs){
				$url = array(
						array(
								'url'=>'index.php?act=circle_memberlevel&op=ref_add',
								'msg'=>L('circle_continue_add'),
						),
						array(
								'url'=>'index.php?act=circle_memberlevel&op=ref',
								'msg'=>L('nc_backlist'),
						)
				);
				showMessage(L('nc_common_op_succ'), $url);
			}else{
				showMessage(L('nc_common_op_fail'));
			}
		}
		Tpl::showpage('circle_memberlevel.ref_add');
	}
	/**
	 * Edit the Reference Title
	 */
	public function ref_editOp(){
		$model = Model();
		if(chksubmit()){
			$update_array = array();
			$update_array['mlref_id']		= intval($_POST['mlref_id']);
			$update_array['mlref_name']		= $_POST['mlref_name'];
			$update_array['mlref_status']	= intval($_POST['mlref_status']);
			$update_array['mlref_1']		= $_POST['mlref_1'];
			$update_array['mlref_2']		= $_POST['mlref_2'];
			$update_array['mlref_3']		= $_POST['mlref_3'];
			$update_array['mlref_4']		= $_POST['mlref_4'];
			$update_array['mlref_5']		= $_POST['mlref_5'];
			$update_array['mlref_6']		= $_POST['mlref_6'];
			$update_array['mlref_7']		= $_POST['mlref_7'];
			$update_array['mlref_8']		= $_POST['mlref_8'];
			$update_array['mlref_9']		= $_POST['mlref_9'];
			$update_array['mlref_10']		= $_POST['mlref_10'];
			$update_array['mlref_11']		= $_POST['mlref_11'];
			$update_array['mlref_12']		= $_POST['mlref_12'];
			$update_array['mlref_13']		= $_POST['mlref_13'];
			$update_array['mlref_14']		= $_POST['mlref_14'];
			$update_array['mlref_15']		= $_POST['mlref_15'];
			$update_array['mlref_16']		= $_POST['mlref_16'];
			$rs = $model->table('circle_mlref')->update($update_array);
			if($rs){
				showMessage(L('nc_common_op_succ'), 'index.php?act=circle_memberlevel&op=ref');
			}else{
				showMessage(L('nc_common_op_fail'));
			}
		}
		$mlref_info = $model->table('circle_mlref')->find(intval($_GET['mlref_id']));
		if(empty($mlref_info)){
			showMessage(L('param_error'));
		}
		Tpl::output('mlref_info', $mlref_info);
		Tpl::showpage('circle_memberlevel.ref_edit');
	}
	/**
	 * elete the Reference Title
	 */
	public function ref_delOp(){
		$mlref_id = intval($_GET['mlref_id']);
		if($mlref_id <= 0){
			showMessage(L('param_error'));
		}
		$rs = Model()->table('circle_mlref')->delete($mlref_id);
		if($rs){
			showMessage(L('nc_common_op_succ'));
		}else{
			showMessage(L('nc_common_op_fail'));
		}
	}
	/**
	 * AJAX operations
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			case 'status':
				$update_array = array();
				$update_array['mlref_id']		= intval($_GET['id']);
				$update_array[$_GET['column']]	= intval($_GET['value']);
				Model()->table('circle_mlref')->update($update_array);
				echo 'true';exit;
				break;
		}
	}

	/**
	 * 更新圈子成员等级缓存
	 */
	public function update_cacheOp() {
		dkcache('circle_level');
		showMessage(L('nc_common_op_succ'), 'index.php?act=circle_memberlevel');

	}
}
