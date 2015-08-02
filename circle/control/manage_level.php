<?php
/**
 * 圈子等级
 *
 *
 *********************************/

defined('InShopNC') or exit('Access Invalid!');

class manage_levelControl extends BaseCircleManageControl{
	public function __construct(){
		parent::__construct();
		Language::read('manage_level');
		$this->circleSEO();
	}
	/**
	 * circle member level
	 */
	public function levelOp(){
		// Circle information
		$this->circleInfo();
		// Membership information
		$this->circleMemberInfo();
		// Members to join the circle list
		$this->memberJoinCircle();
		if(chksubmit()){
			$insert = array();
			$insert['circle_id']= $this->c_id;
			$mld_array = rkcache('circle_level') ? rkcache('circle_level') : rkcache('circle_level', true);
			if($_POST['levelset'] == 'custom'){
				$insert['mlref_id']	= null;
				$insert['ml_1']		= $_POST['levelname']['1'] != '' ? $_POST['levelname']['1'] : $mld_array['1']['mld_name'];
				$insert['ml_2']		= $_POST['levelname']['2'] != '' ? $_POST['levelname']['2'] : $mld_array['2']['mld_name'];
				$insert['ml_3']		= $_POST['levelname']['3'] != '' ? $_POST['levelname']['3'] : $mld_array['3']['mld_name'];
				$insert['ml_4']		= $_POST['levelname']['4'] != '' ? $_POST['levelname']['4'] : $mld_array['4']['mld_name'];
				$insert['ml_5']		= $_POST['levelname']['5'] != '' ? $_POST['levelname']['5'] : $mld_array['5']['mld_name'];
				$insert['ml_6']		= $_POST['levelname']['6'] != '' ? $_POST['levelname']['6'] : $mld_array['6']['mld_name'];
				$insert['ml_7']		= $_POST['levelname']['7'] != '' ? $_POST['levelname']['7'] : $mld_array['7']['mld_name'];
				$insert['ml_8']		= $_POST['levelname']['8'] != '' ? $_POST['levelname']['8'] : $mld_array['8']['mld_name'];
				$insert['ml_9']		= $_POST['levelname']['9'] != '' ? $_POST['levelname']['9'] : $mld_array['9']['mld_name'];
				$insert['ml_10']	= $_POST['levelname']['10'] != '' ? $_POST['levelname']['10'] : $mld_array['10']['mld_name'];
				$insert['ml_11']	= $_POST['levelname']['11'] != '' ? $_POST['levelname']['11'] : $mld_array['11']['mld_name'];
				$insert['ml_12']	= $_POST['levelname']['12'] != '' ? $_POST['levelname']['12'] : $mld_array['12']['mld_name'];
				$insert['ml_13']	= $_POST['levelname']['13'] != '' ? $_POST['levelname']['13'] : $mld_array['13']['mld_name'];
				$insert['ml_14']	= $_POST['levelname']['14'] != '' ? $_POST['levelname']['14'] : $mld_array['14']['mld_name'];
				$insert['ml_15']	= $_POST['levelname']['15'] != '' ? $_POST['levelname']['15'] : $mld_array['15']['mld_name'];
				$insert['ml_16']	= $_POST['levelname']['16'] != '' ? $_POST['levelname']['16'] : $mld_array['16']['mld_name'];
			}else{
				$levelset = intval($_POST['levelset']);
				if($levelset) $mlref_info = Model()->table('circle_mlref')->find($levelset);
				if(!empty($mlref_info)){
					$insert['mlref_id']	= $mlref_info['mlref_id'];
					$insert['ml_1']		= $mlref_info['mlref_1'];
					$insert['ml_2']		= $mlref_info['mlref_2'];
					$insert['ml_3']		= $mlref_info['mlref_3'];
					$insert['ml_4']		= $mlref_info['mlref_4'];
					$insert['ml_5']		= $mlref_info['mlref_5'];
					$insert['ml_6']		= $mlref_info['mlref_6'];
					$insert['ml_7']		= $mlref_info['mlref_7'];
					$insert['ml_8']		= $mlref_info['mlref_8'];
					$insert['ml_9']		= $mlref_info['mlref_9'];
					$insert['ml_10']	= $mlref_info['mlref_10'];
					$insert['ml_11']	= $mlref_info['mlref_11'];
					$insert['ml_12']	= $mlref_info['mlref_12'];
					$insert['ml_13']	= $mlref_info['mlref_13'];
					$insert['ml_14']	= $mlref_info['mlref_14'];
					$insert['ml_15']	= $mlref_info['mlref_15'];
					$insert['ml_16']	= $mlref_info['mlref_16'];
				}else{
					$insert['mlref_id']	= 0;
					$insert['ml_1']		= $mld_array['1']['mld_name'];
					$insert['ml_2']		= $mld_array['2']['mld_name'];
					$insert['ml_3']		= $mld_array['3']['mld_name'];
					$insert['ml_4']		= $mld_array['4']['mld_name'];
					$insert['ml_5']		= $mld_array['5']['mld_name'];
					$insert['ml_6']		= $mld_array['6']['mld_name'];
					$insert['ml_7']		= $mld_array['7']['mld_name'];
					$insert['ml_8']		= $mld_array['8']['mld_name'];
					$insert['ml_9']		= $mld_array['9']['mld_name'];
					$insert['ml_10']	= $mld_array['10']['mld_name'];
					$insert['ml_11']	= $mld_array['11']['mld_name'];
					$insert['ml_12']	= $mld_array['12']['mld_name'];
					$insert['ml_13']	= $mld_array['13']['mld_name'];
					$insert['ml_14']	= $mld_array['14']['mld_name'];
					$insert['ml_15']	= $mld_array['15']['mld_name'];
					$insert['ml_16']	= $mld_array['16']['mld_name'];
				}
			}
			$rs = Model('circle_level')->levelInsert($insert, true);
			showDialog(L('nc_common_op_succ'), 'reload', 'succ');
		}
		$model = Model();
		// Defaule Member Title list
		$mldefault_list = rkcache('circle_level') ? rkcache('circle_level') : rkcache('circle_level', true);
		if (!empty($mldefault_list)){
			$mld_array = array();
			foreach ($mldefault_list as $val){
				$mld_array[$val['mld_id']]['name']	= $val['mld_name'];
				$mld_array[$val['mld_id']]['exp']	= $val['mld_exp'];
			}
			// Refer to the Member Title list
			$mlref_list = $model->table('circle_mlref')->where(array('mlref_status'=>1))->select();

			// tidy
			if(!empty($mlref_list)){
				$mlr_array = array();
				foreach ($mlref_list as $val){
					$mlr_array[$val['mlref_id']]['name']		= $val['mlref_name'];
					$mlr_array[$val['mlref_id']]['info'][1]['name']	= $val['mlref_1'];
					$mlr_array[$val['mlref_id']]['info'][2]['name']	= $val['mlref_2'];
					$mlr_array[$val['mlref_id']]['info'][3]['name']	= $val['mlref_3'];
					$mlr_array[$val['mlref_id']]['info'][4]['name']	= $val['mlref_4'];
					$mlr_array[$val['mlref_id']]['info'][5]['name']	= $val['mlref_5'];
					$mlr_array[$val['mlref_id']]['info'][6]['name']	= $val['mlref_6'];
					$mlr_array[$val['mlref_id']]['info'][7]['name']	= $val['mlref_7'];
					$mlr_array[$val['mlref_id']]['info'][8]['name']	= $val['mlref_8'];
					$mlr_array[$val['mlref_id']]['info'][9]['name']	= $val['mlref_9'];
					$mlr_array[$val['mlref_id']]['info'][10]['name']= $val['mlref_10'];
					$mlr_array[$val['mlref_id']]['info'][11]['name']= $val['mlref_11'];
					$mlr_array[$val['mlref_id']]['info'][12]['name']= $val['mlref_12'];
					$mlr_array[$val['mlref_id']]['info'][13]['name']= $val['mlref_13'];
					$mlr_array[$val['mlref_id']]['info'][14]['name']= $val['mlref_14'];
					$mlr_array[$val['mlref_id']]['info'][15]['name']= $val['mlref_15'];
					$mlr_array[$val['mlref_id']]['info'][16]['name']= $val['mlref_16'];
				}
			}
			Tpl::output('mld_array',$mld_array);
			Tpl::output('mlr_array',$mlr_array);
		}

		$ml_info = $model->table('circle_ml')->find($this->c_id);
		if(!empty($ml_info)){
			$ml_array = array();
			$cl_array = array();	// checked level
			$ml_array['mlref_id']	= $ml_info['mlref_id'];
			if($ml_info['mlref_id'] == null){
				$ml_array['info'][1]['name']	= $ml_info['ml_1'];
				$ml_array['info'][2]['name']	= $ml_info['ml_2'];
				$ml_array['info'][3]['name']	= $ml_info['ml_3'];
				$ml_array['info'][4]['name']	= $ml_info['ml_4'];
				$ml_array['info'][5]['name']	= $ml_info['ml_5'];
				$ml_array['info'][6]['name']	= $ml_info['ml_6'];
				$ml_array['info'][7]['name']	= $ml_info['ml_7'];
				$ml_array['info'][8]['name']	= $ml_info['ml_8'];
				$ml_array['info'][9]['name']	= $ml_info['ml_9'];
				$ml_array['info'][10]['name']	= $ml_info['ml_10'];
				$ml_array['info'][11]['name']	= $ml_info['ml_11'];
				$ml_array['info'][12]['name']	= $ml_info['ml_12'];
				$ml_array['info'][13]['name']	= $ml_info['ml_13'];
				$ml_array['info'][14]['name']	= $ml_info['ml_14'];
				$ml_array['info'][15]['name']	= $ml_info['ml_15'];
				$ml_array['info'][16]['name']	= $ml_info['ml_16'];
			}
			Tpl::output('ml_info', $ml_array);
		}

		$this->sidebar_menu('level');
		Tpl::showpage('group_manage_memberlevel');
	}
}
