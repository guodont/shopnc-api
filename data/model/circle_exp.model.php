<?php
/**
 * Circle Log
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');

class circle_expModel extends Model {
 	public function __construct(){
		parent::__construct();
	}

	/**
	 * Save Experience
	 *
	 * @param array $param
	 */
	public function saveExp($param){
		switch ($param['type']){
			case 'release':		// Release operations
				$this->relOperation($param);
				break;
			case 'reply':		// Reply operations
				$this->relOperation($param);
				break;
			case 'replied':		// Replied operations
				$this->repdOperation($param);
				break;
			case 'delRelease':	// Delete operations for Release
				$this->delRelOperation($param);
				break;
			case 'delReplied':	// Delete operations for Replied
				$this->delRepOperation($param);
				break;
			case 'master':		// Master operations change experience
				$this->masOperation($param);
				break;
		}
	}
	/**
	 * Release & Reply operations
	 * @param array $param
	 */
	private function relOperation($param){
		$exp = 0;
		$today = date('Y-m-d');
		$dexp = $param['type'] == 'release' ? intval(C('circle_exprelease')) : intval(C('circle_expreply'));
		if(intval(C('circle_expreleasemax')) != 0){
			$exp_info = $this->table('circle_expmember')->find($param['member_id']);
			if(!empty($exp_info) && $exp_info['em_time'] == $today){		// there are data
				$exp = ( $dexp > (intval(C('circle_expreleasemax'))-intval($exp_info['em_exp'])) ) ? (intval(C('circle_expreleasemax'))-intval($exp_info['em_exp'])) : $dexp;
			}else{															// There is no data
				$exp = ( $dexp > intval(C('circle_expreleasemax')) ) ? intval(C('circle_expreleasemax')) : $dexp ;
			}
			$insert = array();
			$insert['member_id']	= $param['member_id'];
			$insert['circle_id']	= $param['circle_id'];
			$insert['em_exp']		= empty($exp_info) || $today != $exp_info['em_time'] ? $exp : intval($exp_info['em_exp'])+$exp ;
			$insert['em_time']		= $today;
			$this->table('circle_expmember')->insert($insert, true);
		}else{
			$exp = $dexp;
		}
		if( $exp != 0 ){
			$param['exp'] = $exp;
			return $this->expOperation(1, $param);
		}
	}
	/**
	 * Replied operations
	 * @param array $param
	 */
	private function repdOperation($param){
		$exp = 0; $today = date('Y-m-d');
		if(intval(C('circle_exprepliedmax')) != 0){
			$exp_info = $this->table('circle_exptheme')->find($param['theme_id']);
			if(!empty($exp_info) && $exp_info['et_time'] == $today){			// there are data
				$exp = ( intval(C('circle_expreplied')) > (intval(C('circle_exprepliedmax'))-intval($exp_info['et_exp'])) ) ? (intval(C('circle_exprepliedmax'))-intval($exp_info['et_exp'])) : intval(C('circle_expreplied'));
			}else{																// There is no data
				$exp = ( intval(C('circle_expreplied')) > (intval(C('circle_exprepliedmax'))) ) ? intval(C('circle_exprepliedmax')) : intval(C('circle_expreplied'));
			}
			$insert = array();
			$insert['theme_id']	= $param['theme_id'];
			$insert['et_exp']	= empty($exp_info) || $today != $exp_info['et_time'] ? $exp : intval($exp_info['et_exp'])+$exp;
			$insert['et_time']	= $today;
			$this->table('circle_exptheme')->insert($insert, true);
		}else{
			$exp = intval(C('circle_expelease'));
		}
		if($exp != 0){
			$param['exp'] = $exp;
			return $this->expOperation(1, $param);
		}
	}
	/**
	 * Delete operations for Release
	 * @param array $param
	 */
	private function delRelOperation($param){
		return $this->expOperation(0, $param);
	}
	/**
	 * Delete operations for Replied
	 * @param array $param
	 */
	private function delRepOperation($param){
		return $this->expOperation(0, $param);
	}
	/**
	 * Master operations change experience
	 * @param array $param
	 */
	private function masOperation($param){
		return $this->expOperation(0, $param);
	}
	/**
	 * Experience operations
	 * @param int $type     1 increase, 0 decrease
	 * @param array $param
	 */
	private function expOperation($type, $param){
		$where = array();
		$where['member_id']	= $param['member_id'];
		$where['circle_id']	= $param['circle_id'];
		$cm_info = $this->table('circle_member')->where($where)->find();

		$update = array();
		if($type){
			$update['cm_exp'] = intval($cm_info['cm_exp'])+$param['exp'];
			// upgrade
			if( intval($cm_info['cm_nextexp']) != 0 && (intval($cm_info['cm_exp'])+$param['exp']) >= intval($cm_info['cm_nextexp']) && intval($cm_info['cm_level']) != 16 ){
				$data = rkcache('circle_level', true);
				$ml_info = $this->table('circle_ml')->find($param['circle_id']);
				$update['cm_level']		= intval($cm_info['cm_level'])+1;
				$update['cm_levelname']	= empty($ml_info) ? $data[$update['cm_level']]['mld_name'] : $ml_info['ml_'.$update['cm_level']];
				$update['cm_nextexp']	= $update['cm_level'] == 16 ? 0 : $data[$update['cm_level']+1]['mld_exp'];
			}
		}else{
			$update['cm_exp'] = intval($cm_info['cm_exp'])-$param['exp'];

			$data = rkcache('circle_level', true);
			$level = 0;
			foreach ($data as $val){
				$level = intval($val['mld_id'])-1;
				if(intval($val['mld_exp']) > $update['cm_exp']) break;
			}
			// upgrade
			if($level != intval($cm_info['cm_exp'])){
				$ml_info = $this->table('circle_ml')->find($param['circle_id']);
				$update['cm_level']		= $level;
				$update['cm_levelname']	= empty($ml_info) ? $data[$level]['mld_name'] : $ml_info['ml_'.$level];
				$update['cm_nextexp']	= $update['cm_level'] == 16 ? 0 : $data[$level+1]['mld_exp'];
			}
		}
		$rs = $this->table('circle_member')->where($where)->update($update);
		if($rs){
			$this->recordsLog($type, $param);
		}else{
			return false;
		}
	}
	/**
	 * Records experience log
	 */
	private function recordsLog($type, $param){
		$insert = array();
		$insert['circle_id']	= $param['circle_id'];
		$insert['member_id']	= $param['member_id'];
		$insert['member_name']	= $param['member_name'];
		$insert['el_exp']		= $type ? $param['exp'] : -$param['exp'];
		$insert['el_time']		= time();
		$insert['el_itemid']	= $param['itemid'];
		switch ($param['type']){
			case 'release':
				$update = array();
				$update['theme_id']	= $param['itemid'];
				$update['theme_exp']= array('exp', 'theme_exp+'.$param['exp']);
				$this->table('circle_theme')->update($update);

				$insert['el_type']	= 2;
				$insert['el_desc']	= L('circle_exp_release_theme');
				break;
			case 'reply':
				$update = array();
				$update['reply_exp']= array('exp', 'reply_exp+'.$param['exp']);
				$where = array();
				list($where['theme_id'],$where['reply_id'])	= explode(',', $param['itemid']);
				$this->table('circle_threply')->where($where)->update($update);

				$insert['el_type']	= 3;
				$insert['el_desc']	= L('circle_exp_reply');
				break;
			case 'replied':
				$update = array();
				$update['theme_id']	= $param['theme_id'];
				$update['theme_exp']= array('exp', 'theme_exp+'.$param['exp']);
				$this->table('circle_theme')->update($update);

				$insert['el_type']	= 4;
				$insert['el_desc']	= L('circle_exp_theme_replied');
				break;
			case 'delRelease':
				$insert['el_type']	= 5;
				$insert['el_desc']	= L('circle_exp_theme_delete');
				break;
			case 'delReplied':
				$insert['el_type']	= 6;
				$insert['el_desc']	= L('circle_exp_reply_delete');
				break;
			case 'master':
				$insert['el_type']	= 1;
				$insert['el_desc']	= $param['desc'];
				break;
		}
		$this->table('circle_explog')->insert($insert);
	}
}
