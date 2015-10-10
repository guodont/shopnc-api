<?php
/**
 * 圈子首页
 *
 *
 *********************************/

defined('InShopNC') or exit('Access Invalid!');

class groupControl extends BaseCircleThemeControl{
	public function __construct(){
		parent::__construct();
	}
	/**
	 * 首页 话题列表
	 */
	public function indexOp(){
		// 圈子信息
		$this->circleInfo();

		// 圈主和管理信息
		$this->manageList();

		// 会员信息
		$this->memberInfo();

		// sidebar相关
		$this->sidebar();

		$model = Model();
		// 话题列表
		$where = array();
		$where['circle_id']	= $this->c_id;
		$thc_id = intval($_GET['thc_id']);
		if($thc_id > 0){
			$where['thclass_id']= $thc_id;
			Tpl::output('thc_id', $thc_id);
		}
		if(intval($_GET['cream']) == 1){
			$where['is_digest'] = 1;
		}
		$theme_list = $model->table('circle_theme')->where($where)->order('is_stick desc,lastspeak_time desc')->page(20)->select();
		$theme_list = array_under_reset($theme_list, 'theme_id');
		Tpl::output('show_page', $model->showpage('2'));
		Tpl::output('theme_list', $theme_list);

		// 附件列表
		if(!empty($theme_list)){
			$themeid_array = array_keys($theme_list);
			$affix_list = $model->table('circle_affix')->where(array('affix_type'=>1,'theme_id'=>array('in', $themeid_array)))->select();
			$affix_list = array_under_reset($affix_list, 'theme_id', 2);
			Tpl::output('affix_list', $affix_list);
		}

		// 今日话题数
		// 当天时间戳
		$year = date("Y");$month = date("m");$day = date("d");
		$dayBegin = mktime(0,0,0,$month,$day,$year);
		$todaythcount = $model->table('circle_theme')->where(array('theme_addtime'=>array('egt',$dayBegin), 'circle_id'=>$this->c_id))->count();
		Tpl::output('todaythcount', $todaythcount);

		//展示形式，默认以图文展示 list/preview
		if($_GET['type'] != ''){
			$display_mode = ($_GET['type'] == 'list')?'list':'preview';
			setNcCookie('circleDisplayMode', $display_mode, 30*24*60*60);
		}else{
			$display_mode = cookie('circleDisplayMode') ? cookie('circleDisplayMode') : 'preview';
		}
		Tpl::output('display_mode',$display_mode);

		// 话题分类
		$where = array();
		$where['circle_id']		= $this->c_id;
		$where['thclass_status']= 1;
		$thclass_list = $model->table('circle_thclass')->where($where)->order('thclass_sort asc')->select();
		$thclass_list = array_under_reset($thclass_list, 'thclass_id');
		Tpl::output('thclass_list', $thclass_list);

		// Read Permission
		$readperm = $this->readPermissions($this->cm_info);
		Tpl::output('readperm', $readperm);
		Tpl::output('m_readperm', $this->m_readperm);

		$this->circleSEO($this->circle_info['circle_name']);
		// breadcrumb navigation
		$this->breadcrumd();
		Tpl::showpage('group');
	}
	/**
	 * 申请加入
	 */
	public function applyOp(){
		// 会员信息
		$this->memberInfo();
		// 圈子信息
		$this->circleInfo();

		if(in_array($this->identity, array(1,2,3,4))){
			showDialog(L('wrong_argument'), 'reload');
		}
		if(chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["apply_content"], "require"=>"true", "message"=>L('circle_apply_content_null')),
				array("input"=>$_POST["intro"], "require"=>"true", "message"=>L('circle_introduction_not_null')),
			);
			$error = $obj_validate->validate();
			if($error != ''){
				showDialog($error);
			}else{
				// Membership level information
				$data = rkcache('circle_level') ? rkcache('circle_level') : rkcache('circle_level', true);

				$model =  Model();
				$insert = array();
				$insert['cm_applycontent']	= $_POST['apply_content'];
				$insert['cm_intro']			= $_POST['intro'];
				$insert['member_id']		= $_SESSION['member_id'];
				$insert['circle_id']		= $this->c_id;
				$insert['circle_name']		= $this->circle_info['circle_name'];
				$insert['member_name']		= $_SESSION['member_name'];
				$insert['cm_applytime']		= $insert['cm_jointime']	= time();
				$insert['cm_level']			= $data[1]['mld_id'];
				$insert['cm_levelname']		= $data[1]['mld_name'];
				$insert['cm_exp']			= 1;
				$insert['cm_nextexp']		= $data[2]['mld_exp'];
				$insert['cm_state']			= intval($this->circle_info['circle_joinaudit']) == 0 ? 1 : 0;
				$insert['is_identity']		= 3;
				$model->table('circle_member')->insert($insert, true);
				if(intval($this->circle_info['circle_joinaudit']) == 0){
					// Update the number of members
					$update = array(
								'circle_id'=>$this->c_id,
								'circle_mcount'=>array('exp', 'circle_mcount+1')
							);
					$model->table('circle')->update($update);
					showDialog(L('nc_common_op_succ'), 'reload', 'succ', 'CUR_DIALOG.close();');
				}else{
					// Update is applying for membership
					$update = array(
								'circle_id'=>$this->c_id,
								'new_verifycount'=>array('exp', 'new_verifycount+1')
							);
					$model->table('circle')->update($update);
					showDialog(L('nc_apply_op_succ'), 'reload', 'succ', 'CUR_DIALOG.close();');
				}
			}
		}
		$this->circleSEO(L('circle_apply_join').$this->circle_info['circle_name']);
		Tpl::showpage('group_apply', 'null_layout');
	}
	/**
	 * 退出圈子
	 */
	public function quitOp(){
		// 圈子信息
		$this->circleInfo();
		// 会员信息
		$this->memberInfo();
		if(in_array($this->identity, array(2,3))){
			// 删除会员
			Model()->table('circle_member')->where(array('circle_id'=>$this->c_id, 'member_id'=>$_SESSION['member_id']))->delete();

			$update = array();
			$update['circle_id']	= $this->c_id;
			$update['circle_mcount']= array('exp','circle_mcount-1');

			// Whether to apply for management
			$rs = Model()->table('circle_mapply')->where(array('circle_id'=>$this->c_id, 'member_id'=>$_SESSION['member_id']))->find();
			if($rs){
				Model()->table('circle_mapply')->where(array('circle_id'=>$this->c_id, 'member_id'=>$_SESSION['member_id']))->delete();
				$update['new_mapplycount'] = array('exp', 'new_mapplycount-1');
			}

			// 更新圈子成员数
			Model()->table('circle')->update($update);
		}
		showDialog(L('nc_common_op_succ'), 'reload', 'succ');
	}
	/**
	 * 圈子成员列表
	 */
	public function group_memberOp(){
		// 圈子信息
		$this->circleInfo();

		// 圈主和管理信息
		$this->manageList();

		// 会员信息
		$this->memberInfo();

		// sidebar相关
		$this->sidebar();

		// 圈子成员列表
		$model = Model();
		$where = array();
		$where['circle_id']	= $this->c_id;
		$where['cm_state']	= 1;
		if($_SESSION['is_login']) $where['member_id']	= array('neq', $_SESSION['member_id']);
		$cm_list = $model->table('circle_member')->where($where)->order('is_identity asc,cm_jointime desc')->page(15)->select();
		Tpl::output('show_page', $model->showpage(2));
		Tpl::output('cm_list', $cm_list);

		$this->circleSEO(L('circle_member_list').$this->circle_info['circle_name']);

		// breadcrumb navigation
		$this->breadcrumd(L('circle_firend'));
		Tpl::showpage('group.member');
	}
	/**
	 * 圈子成员编辑
	 */
	public function group_membereditOp(){
		$model = Model();
		$where = array();
		$where['circle_id']	= $this->c_id;
		$where['member_id'] = $_SESSION['member_id'];
		if(chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["intro"], "require"=>"true", "message"=>L('circle_introduction_not_null')),
			);
			$error = $obj_validate->validate();
			if($error != ''){
				showDialog($error);
			}
			// 会员信息
			$this->memberInfo();
			if(!in_array($this->identity, array(1,2,3,6))){
				showDialog(L('circle_member_no_join'), 'reload', 'error', 'CUR_DIALOG.close();');
			}
			$update = array();
			$update['cm_intro'] = $_POST['intro'];
			$model->table('circle_member')->where($where)->update($update);
			showDialog(L('nc_deit_op_succ'), 'reload', 'succ', 'CUR_DIALOG.close();');
		}
		$member_info = $model->table('circle_member')->where($where)->find();
		Tpl::output('member_info', $member_info);
		Tpl::showpage('group.member_edit', 'null_layout');
	}
	/**
	 * 圈子商品列表
	 */
	public function group_goodsOp(){
		// 圈子信息
		$this->circleInfo();

		// 圈主和管理信息
		$this->manageList();

		// 会员信息
		$this->memberInfo();

		// sidebar相关
		$this->sidebar();

		// 成员商品列表
		$model = Model();
		$cmid_list	= $model->table('circle_member')->field('member_id')->where(array('circle_id'=>$this->c_id, 'cm_state'=>1))->select();
		$cmid_list	= array_under_reset($cmid_list, 'member_id'); $cmid_array = array_keys($cmid_list);
		$count		= $model->table('sns_sharegoods')->where(array('share_memberid'=>array('in', $cmid_array)))->count();
		$goods_list = $model->table('sns_sharegoods,sns_goods')->join('left')->on('sns_sharegoods.share_goodsid=sns_goods.snsgoods_goodsid')
						->where(array('sns_sharegoods.share_memberid'=>array('in', $cmid_array), 'share_isshare|share_islike'=>1))->order('share_id desc')->page(20, $count)->select();
		if(!empty($goods_list)){
			if($_SESSION['is_login'] == '1'){
				foreach ($goods_list as $k=>$v){
					if (!empty($v['snsgoods_likemember'])){
						$v['snsgoods_likemember_arr'] = explode(',',$v['snsgoods_likemember']);
						$v['snsgoods_havelike'] = in_array($_SESSION['member_id'],$v['snsgoods_likemember_arr'])?1:0;
					}
					$goods_list[$k] = $v;
				}
			}
			$goods_list	= array_under_reset($goods_list, 'share_id'); $shareid_array = array_keys($goods_list);
			Tpl::output('show_page', $model->showpage('2'));
			Tpl::output('goods_list', $goods_list);
			$pic_list	= $model->cls()->table('sns_albumpic')->where(array('item_id'=>array('in', $shareid_array)))->select();
			$pic_list	= array_under_reset($pic_list, 'item_id', 2);
			Tpl::output('pic_list', $pic_list);
		}

		$this->circleSEO(L('circle_member_like_and_show_goods').$this->circle_info['circle_name']);

		// breadcrumb navigation
		$this->breadcrumd(L('site_search_goods'));
		Tpl::showpage('group.goods');
	}
	/**
	 * Applied to be an administrator
	 */
	public function manage_applyOp(){
		$model = Model();
		// Circle information
		$this->circleInfo();
		// Verify membership
		$cm_info = $model->table('circle_member')->where(array('circle_id'=>$this->c_id, 'cm_state'=>1, 'is_identity'=>3))->find();
		if(empty($cm_info) || $this->circle_info['mapply_open'] == 0 || $this->circle_info['mapply_ml'] > $cm_info['cm_level'] || $cm_info['is_identity'] == 1){
			if(chksubmit()){
				showDialog(L('circle_apply_error'), '', 'error', 'DialogManager.close(\'manage_apply\')');
			}else{
				echo '<script>showError("'.L('circle_apply_error').'");DialogManager.close("manage_apply");</script>';exit;
			}
		}
		// Ban repeated application
		$mapply_info = $model->table('circle_mapply')->where(array('circle_id'=>$this->c_id, 'member_id'=>$_SESSION['member_id']))->find();
		if(!empty($mapply_info)){
			if(chksubmit()){
				showDialog(L('circle_repeat_apply_error'), '', 'error', 'DialogManager.close(\'manage_apply\')');
			}else{
				echo '<script>showError("'.L('circle_repeat_apply_error').'");DialogManager.close("manage_apply");</script>';exit;
			}
		}

		if(chksubmit()){
			$update = array();
			$update['circle_id']	= $this->c_id;
			$update['member_id']	= $_SESSION['member_id'];
			$update['mapply_reason']= $_POST['apply_reason'];
			$update['mapply_time']	= time();
			$model->table('circle_mapply')->insert($update);

			// Update the application for membership
			$model->table('circle')->update(array('circle_id'=>$this->c_id, 'new_mapplycount'=>array('exp', 'new_mapplycount+1')));

			showDialog(L('nc_common_op_succ'), 'reload', 'succ', 'DialogManager.close(\'manage_apply\')');
		}

		Tpl::showpage('group.mapply', 'null_layout');
	}
	/**
	 * Level introduction
	 */
	public function level_intrOp(){
		// 圈子信息
		$this->circleInfo();

		// 圈主和管理信息
		$this->manageList();

		// 会员信息
		$this->memberInfo();

		// breadcrumb navigation
		$this->breadcrumd(L('level_introduction'));

		// member level
		$ml_info = Model()->table('circle_ml')->find($this->c_id);
		$mld_array = rkcache('circle_level') ? rkcache('circle_level') : rkcache('circle_level', true);
		if(empty($ml_info)){
			$ml_info['ml_1']	= $mld_array['1']['mld_name'];
			$ml_info['ml_2']	= $mld_array['2']['mld_name'];
			$ml_info['ml_3']	= $mld_array['3']['mld_name'];
			$ml_info['ml_4']	= $mld_array['4']['mld_name'];
			$ml_info['ml_5']	= $mld_array['5']['mld_name'];
			$ml_info['ml_6']	= $mld_array['6']['mld_name'];
			$ml_info['ml_7']	= $mld_array['7']['mld_name'];
			$ml_info['ml_8']	= $mld_array['8']['mld_name'];
			$ml_info['ml_9']	= $mld_array['9']['mld_name'];
			$ml_info['ml_10']	= $mld_array['10']['mld_name'];
			$ml_info['ml_11']	= $mld_array['11']['mld_name'];
			$ml_info['ml_12']	= $mld_array['12']['mld_name'];
			$ml_info['ml_13']	= $mld_array['13']['mld_name'];
			$ml_info['ml_14']	= $mld_array['14']['mld_name'];
			$ml_info['ml_15']	= $mld_array['15']['mld_name'];
			$ml_info['ml_16']	= $mld_array['16']['mld_name'];
		}
		Tpl::output('ml_info', $ml_info);
		Tpl::output('mld_array', $mld_array);
		Tpl::showpage('group.level');
	}
}
