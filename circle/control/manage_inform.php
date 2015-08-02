<?php
/**
 * 圈子首页
 *
 *
 *********************************/

defined('InShopNC') or exit('Access Invalid!');

class manage_informControl extends BaseCircleManageControl{
	public function __construct(){
		parent::__construct();
		Language::read('manage_inform');
		$this->circleSEO();
	}
	/**
	 * Inform
	 */
	public function informOp(){
		// Circle information
		$this->circleInfo();
		// Membership information
		$this->circleMemberInfo();
		// Members to join the circle list
		$this->memberJoinCircle();
		$model = Model();
		if (chksubmit()){
			if(empty($_POST['i_id']))
				showDialog(L('wrong_argument'));


			foreach ($_POST['i_id'] as $val){
				$i_rewards = intval($_POST['i_rewards'][$val]);
				$update = array();
				$update['inform_id']	= $val;
				$update['inform_state']	= 1;
				$update['inform_opid']	= $_SESSION['member_id'];
				$update['inform_opname']= $_SESSION['member_name'];
				$update['inform_opexp']	= $i_rewards;
				$update['inform_opresult']	= $_POST['i_result'][$val] == ''? L('nc_nothing') : $_POST['i_result'][$val];

				$rs = $model->table('circle_inform')->update($update);

				// Experience increase or decrease
				if($rs && $i_rewards != 0){
					$inform_info = $model->table('circle_inform')->field('circle_id,member_id,member_name')->find($val);
					if(!empty($inform_info)){
						$param = array();
						$param['circle_id']		= $inform_info['circle_id'];
						$param['member_id']		= $inform_info['member_id'];
						$param['member_name']	= $inform_info['member_name'];
						$param['type']			= 'master';
						$param['exp']			= $i_rewards;
						$param['desc']			= L('circle_exp_inform');
						$param['itemid']		= 0;
						Model('circle_exp')->saveExp($param);
					}
				}
			}

			// Update the inform number
			$count = $model->table('circle_inform')->where(array('circle_id'=>$this->c_id, 'inform_state'=>0))->count();
			$model->table('circle')->update(array('circle_id'=>$this->c_id, 'new_informcount'=>$count));

			showDialog(L('nc_common_op_succ'),'reload','succ');

		}

		$where = array();
		$where['circle_id']	= $this->c_id;
		$where['inform_state'] = $_GET['type'] == 'treated' ? 1 : 0;

		$inform_list = $model->table('circle_inform')->where($where)->page(10)->order('inform_id desc')->select();
		// tidy
		if(!empty($inform_list)){
			foreach ($inform_list as $key=>$val){
				$inform_list[$key]['url']	= spellInformUrl($val);
				$inform_list[$key]['title'] = L('circle_theme,nc_quote1').$val['theme_name'].L('nc_quote2');
				if($val['reply_id'] != 0)
					$inform_list[$key]['title']	.= L('circle_inform_reply_title');
			}
		}
		Tpl::output('inform_list', $inform_list);
		Tpl::output('show_page', $model->showpage(2));

		$type = $_GET['type'] == 'treated' ? 'treated' : 'untreated';
		$this->sidebar_menu('inform', $type);
		$_GET['type'] == 'treated' ? Tpl::showpage('group_manage_inform.treated') : Tpl::showpage('group_manage_inform.untreated');
	}

	/**
	 * Delete Inform
	 */
	public function delinformOp(){
		// Authentication
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			showDialog($rs);
		}
		$inform_id = explode(',', $_GET['i_id']);
		if(empty($inform_id)){
			echo 'false';exit;
		}
		$where = array();
		$where['circle_id']	= $this->c_id;
		$where['inform_id']	= array('in', $inform_id);
		Model()->table('circle_inform')->where($where)->delete();
		showDialog(L('nc_common_del_succ'), 'reload', 'succ');
	}
}
