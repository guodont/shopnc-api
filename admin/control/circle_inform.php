<?php
/**
 * Circle Inform
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class circle_informControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('circle_inform');
	}
	/**
	 * inform list
	 */
	public function inform_listOp(){
		$model = Model();
		if(chksubmit()){
			if(empty($_POST['i_id'])){
				showMessage(L('wrong_argument'), '', '', 'error');
			}
			// check
			foreach ($_POST['i_id'] as $key=>$val){
				if (!is_numeric($val)) unset($_POST[$key]);
			}
			$rs = $model->table('circle_inform')->where(array('inform_id'=>array('in', $_POST['i_id'])))->delete();
			if($rs){
				showMessage(L('nc_common_op_succ'));
			}else{
				showMessage(L('nc_common_op_fail'), '', '', 'error');
			}
		}
		$where = array();
		if($_GET['searchname'] != ''){
			$where['member_name'] = array('like', '%'.$_GET['searchname'].'%');
		}
		if($_GET['circlename'] != ''){
			$where['circle_name'] = array('like', '%'.$_GET['circlename'].'%');
		}
		if($_GET['searchstate'] != ''){
			$where['inform_state'] = intval($_GET['searchstate']);
		}
		$inform_list = $model->table('circle_inform')->where($where)->page(10)->order('inform_id desc')->select();
		// tidy
		if(!empty($inform_list)){
			foreach ($inform_list as $key=>$val){
				$inform_list[$key]['url']	= $this->spellInformUrl($val);
				$inform_list[$key]['title'] = L('circle_theme,nc_quote1').$val['theme_name'].L('nc_quote2');
				$inform_list[$key]['state'] = $this->informStatr(intval($val['inform_state']));
				if($val['reply_id'] != 0)
					$inform_list[$key]['title']	.= L('circle_inform_reply_title');
			}
		}
		Tpl::output('inform_list', $inform_list);
		Tpl::output('show_page', $model->showpage(2));

		Tpl::showpage('circle_inform');
	}
	/**
	 * Inform delete
	 */
	public function inform_delOp(){
		$i_id = intval($_GET['i_id']);
		if($i_id <= 0){
			showMessage(L('wrong_argument'), '', '', 'error');
		}
		$rs = Model()->table('circle_inform')->delete($i_id);
		if($rs){
			showMessage(L('nc_common_op_succ'));
		}else{
			showMessage(L('nc_common_op_fail'), '', '', 'error');
		}
	}
	/**
	 * Inform Url link
	 */
	public function spellInformUrl($param){
		if($param['reply_id'] == 0) return $url = 'index.php?act=theme&op=theme_detail&c_id='.$param['circle_id'].'&t_id='.$param['theme_id'];

		$where = array();
		$where['circle_id']	= $param['circle_id'];
		$where['theme_id']	= $param['theme_id'];
		$where['reply_id']	= array('elt', $param['reply_id']);
		$count = Model()->table('circle_threply')->where($where)->count();
		$page = ceil($count/15);
		return $url = 'index.php?act=theme&op=theme_detail&c_id='.$param['circle_id'].'&t_id='.$param['theme_id'].'&curpage='.$page.'#f'.$param['reply_id'];
	}
	/**
	 * Inform state
	 */
	private function informStatr($state){
		switch ($state){
			case 0:
				return L('circle_inform_untreated');
				break;
			case 1:
				return L('circle_inform_treated');
				break;
		}
	}
}
