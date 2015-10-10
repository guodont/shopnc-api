<?php
/**
 * 圈子管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class circle_manageControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('circle');
	}
	/**
	 * 圈子列表
	 */
	public function circle_listOp(){
		$model = Model();
		if(chksubmit()){
			// 批量删除圈子
			if($_POST['submit_type'] == 'batchdel'){
				$id_array = $_POST['check_circleid'];
				if(empty($id_array) && !is_array($id_array)){
					showMessage(L('circle_choose_del_circle'));
				}
				$model = Model();
				$where = array('circle_id'=>array('in',$id_array));
				$circle_list = $model->table('circle')->where($where)->select();

				// 删除圈子logo
				if(!empty($circle_list)){
					foreach ($circle_list as $val){
						@unlink(BASE_UPLOAD_PATH.DS.ATTACH_CIRCLE.'/group/'.$circle_list['circle_id'].'.jpg');
					}
				}
				// 删除附件
				$affix_list = $model->table('circle_affix')->where($where)->select();
				if(!empty($affix_list)){
					foreach ($affix_list as $val){
						@unlink(themeImagePath($val['affix_filename']));
						@unlink(themeImagePath($val['affix_filethumb']));
					}
					$model->table('circle_affix')->where($where)->delete();
				}

				// 删除商品
				$model->table('circle_thg')->where($where)->delete();

				// 删除赞表相关
				$model->table('circle_like')->where($where)->delete();

				// 删除回复
				$model->table('circle_threply')->where($where)->delete();

				// 删除话题
				$model->table('circle_theme')->where($where)->delete();

				// 删除成员
				$model->table('circle_member')->where($where)->delete();

				// 删除圈子
				$model->table('circle')->where($where)->delete();

				$this->log(L('nc_del_circle').'['.implode(',', $id_array).']');
				showMessage(L('nc_common_op_succ'));
			}
		}
		$where = array();
		if(trim($_GET['searchname']) != ''){
			$where['circle_name']		= array('like', '%'.trim($_GET['searchname']).'%');
		}
		if(trim($_GET['searchmaster']) != ''){
			$where['circle_mastername']	= array('like', '%'.trim($_GET['searchmaster']).'%');
		}
		if(trim($_GET['searchstatus']) != ''){
			$where['circle_status']		= intval($_GET['searchstatus']);
		}
		$circle_list = $model->table('circle')->where($where)->page('10')->select();
		Tpl::output('page', $model->showpage('2'));
		Tpl::output('circle_list', $circle_list);
		Tpl::showpage('circle.list');
	}
	/**
	 * 圈子待审核列表
	 */
	public function circle_verifyOp(){
		$model = Model();
		if(chksubmit()){
			$id_array = $_POST['check_circleid'];
			if(empty($id_array) && !is_array($id_array)){
				showMessage(L('circle_choose_del_circle'));
			}
			if($_POST['submit_type'] == 'batchdel'){
				// delete circle
				$where = array('circle_id'=>array('in',$id_array));
				$model->table('circle')->where($where)->delete();
				showMessage(L('nc_common_del_succ'));
			}else if($_POST['submit_type'] == 'pass'){
				// pass circle
				$model->table('circle')->where(array('circle_id'=>array('in', $id_array)))->update(array('circle_status'=>1));
				showMessage(L('nc_common_op_succ'));
			}
		}
		$circle_list = $model->table('circle')->where(array('circle_status'=>2))->page('10')->select();
		Tpl::output('page', $model->showpage('2'));
		Tpl::output('circle_list', $circle_list);
		Tpl::showpage('circle.verify');
	}
	/**
	 * 圈子新增
	 */
	public function circle_addOp(){
		$model = Model();
		// 保存
		if(chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["c_name"], "require"=>"true", "message"=>L('circle_name_not_null')),
			);
			$error = $obj_validate->validate();
			if($error != ''){
				showMessage($error);
			}else{
				$insert = array();
				$insert['circle_name']		= trim($_POST['c_name']);
				$insert['circle_masterid']	= intval($_POST['masterid']);
				$insert['circle_mastername']= trim($_POST['mastername']);
				$insert['circle_desc']		= $_POST['c_desc'];
				$insert['circle_tag']		= $_POST['c_tag'];
				$insert['circle_notice']	= $_POST['c_notice'];
				$insert['circle_status']	= intval($_POST['c_status']);
				$insert['is_recommend']		= intval($_POST['c_recommend']);
				$insert['class_id']			= intval($_POST['classid']);
				$insert['circle_addtime']	= time();
				$circleid = $model->table('circle')->insert($insert);
				if($circleid){
					// 把圈主信息加入圈子会员表
					$insert = array();
					$insert['member_id']	= intval($_POST['masterid']);
					$insert['circle_id']	= $circleid;
					$insert['circle_name']	= $_POST['c_name'];
					$insert['member_name']	= $_POST['mastername'];
					$insert['cm_applytime']	= $insert['cm_jointime'] = time();
					$insert['cm_state']		= 1;
					$insert['is_identity']	= 1;
					$insert['cm_lastspeaktime'] = '';
					$rs = $model->table('circle_member')->insert($insert);
					if($rs){
						$update['circle_mcount']	= 1;
					}
					if (!empty($_POST['c_img'])){
						$update['circle_img']	= $circleid.'.jpg';
						rename(BASE_UPLOAD_PATH.'/'.ATTACH_CIRCLE.'/group/'.$_POST['c_img'],BASE_UPLOAD_PATH.'/'.ATTACH_CIRCLE.'/group/'.$circleid.'.jpg');
					}
					$model->table('circle')->where(array('circle_id'=>$circleid))->update($update);
					$this->log(L('nc_add_circle').'['.$circleid.']');
					showMessage(L('nc_common_op_succ'));
				}else{
					showMessage(L('nc_common_op_fail'));
				}
			}
		}
		// 圈子分类
		$class_list = $model->table('circle_class')->where(array('class_status'=>1))->order('class_sort asc')->select();
		Tpl::output('class_list', $class_list);

		Tpl::showpage('circle.add');
	}
	/**
	 * 圈子编辑
	 */
	public function circle_editOp(){
		$model = Model();
		if(chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["c_name"], "require"=>"true", "message"=>L('circle_name_not_null')),
			);
			$error = $obj_validate->validate();
			if($error != ''){
				showMessage($error);
			}else{
				$update = array();
				$update['circle_id']		= intval($_POST['c_id']);
				$update['circle_name']		= trim($_POST['c_name']);
				$update['circle_masterid']	= intval($_POST['masterid']);
				$update['circle_mastername']= trim($_POST['mastername']);
				$update['circle_desc']		= $_POST['c_desc'];
				$insert['circle_tag']		= $_POST['c_tag'];
				$update['circle_notice']	= $_POST['c_notice'];
				$update['circle_status']	= intval($_POST['c_status']);
				$update['circle_statusinfo']= $_POST['c_statusinfo'];
				$update['is_recommend']		= intval($_POST['c_recommend']);
				$update['class_id']			= intval($_POST['classid']);
				$insert['circle_img']		= $_POST['c_img'];
				$rs = $model->table('circle')->update($update);
				if($rs){
					// 更新圈子会员表 圈主信息。
					$cminfo = $model->table('circle_member')->where(array('member_id'=>intval($_POST['masterid']), 'circle_id'=>intval($_POST['c_id'])))->find();
					if(empty($cminfo)){
						// 取消员圈主圈主身份
						$model->table('circle_member')->where(array('circle_id'=>intval($_POST['c_id']), 'is_identity'=>1))->update(array('is_identity'=>3));
						$model->table('circle_theme')->where(array('circle_id'=>intval($_POST['c_id']), 'is_identity'=>1))->update(array('is_identity'=>3));
						// 把圈主信息加入圈子会员表
						$insert = array();
						$insert['member_id']	= intval($_POST['masterid']);
						$insert['circle_id']	= intval($_POST['c_id']);
						$insert['circle_name']	= $_POST['c_name'];
						$insert['member_name']	= $_POST['mastername'];
						$insert['cm_applytime']	= $insert['cm_jointime'] = time();
						$insert['cm_state']		= 1;
						$insert['is_identity']	= 1;
						$insert['cm_lastspeaktime'] = '';
						$model->table('circle_member')->insert($insert);
					}else{
						if($cminfo['is_identity'] != 1){
							// 取消员圈主圈主身份
							$model->table('circle_member')->where(array('circle_id'=>intval($_POST['c_id']), 'is_identity'=>1))->update(array('is_identity'=>3));
							$model->table('circle_theme')->where(array('circle_id'=>intval($_POST['c_id']), 'is_identity'=>1))->update(array('is_identity'=>3));
							// 任命新圈主
							$model->table('circle_member')->where(array('member_id'=>intval($_POST['masterid']), 'circle_id'=>intval($_POST['c_id'])))->update(array('is_identity'=>1));
							$model->table('circle_theme')->where(array('member_id'=>intval($_POST['masterid']), 'circle_id'=>intval($_POST['c_id'])))->update(array('is_identity'=>1));
						}
					}
					// 更新圈子成员信息
					$count = $model->table('circle_member')->where(array('circle_id'=>intval($_POST['c_id'])))->count();
					$model->table('circle')->update(array('circle_id'=>intval($_POST['c_id']), 'circle_mcount'=>$count));

					// 更新主题圈子名称字段
					$model->table('circle_theme')->where(array('circle_id'=>intval($_POST['c_id'])))->update(array('circle_name'=>$_POST['c_name']));
					$model->table('circle_member')->where(array('circle_id'=>intval($_POST['c_id'])))->update(array('circle_name'=>$_POST['c_name']));

					$this->log(L('nc_edit_circle').'['.intval($_POST['c_id']).']');
					showMessage(L('nc_common_op_succ'), 'index.php?act=circle_manage&op=circle_list');
				}else{
					showMessage(L('nc_common_op_fail'));
				}
			}
		}
		$id = intval($_GET['c_id']);
		if($id <= 0){
			showMessage(L('param_error'));
		}
		// 圈子详细
		$circle_info = $model->table('circle')->find($id);
		Tpl::output('circle_info', $circle_info);

		// 圈子分类
		$class_list = $model->table('circle_class')->where(array('class_status'=>1))->order('class_sort asc')->select();
		Tpl::output('class_list', $class_list);

		Tpl::showpage('circle.edit');
	}
	/**
	 * 选择圈主
	 */
	public function choose_masterOp(){
	    Tpl::output('search_url', (intval($_GET['c_id']) > 0) ? urlAdmin('circle_manage', 'search_member', array('c_id' => intval($_GET['c_id']))) : urlAdmin('circle_manage', 'search_member'));
		Tpl::showpage('circle.choose_master', 'null_layout');
	}
	/**
	 * 搜索会员
	 */
	public function search_memberOp(){
		$model = Model();
		$where = array();
		if($_GET['name'] != ''){
			$where['member_name'] = array('like', '%'.trim($_GET['name']).'%');
		}
		$member_list = $model->table('member')->field('member_id,member_name')->where($where)->select();
		$member_list = array_under_reset($member_list, 'member_id', 1);

		// 允许创建圈子验证
		$where = array();
		if(intval($_GET['c_id']) > 0){
			$where = array('circle_id'=>array('neq',intval($_GET['c_id'])));
		}
		$count_array = $model->table('circle')->field('circle_masterid,count(*) as count')->where($where)->group('circle_masterid')->select();
		if (!empty($count_array)){
			foreach ($count_array as $val){
				if(intval($val['count']) >= C('circle_createsum')) unset($member_list[$val['circle_masterid']]);
			}
		}

		// 允许加入圈子验证
		$where = array();
		if(intval($_GET['c_id']) > 0){
			$where = array('circle_id');
		}
		$count_array = $model->table('circle_member')->field('member_id,count(*) as count')->where($where)->group('member_id')->select();
		if(!empty($count_array)){
			foreach ($count_array as $val){
				if(intval($val['count']) >= C('circle_joinsum')) unset($member_list[$val['member_id']]);
			}
		}

		$member_list = array_values($member_list);
		// 加入圈子数量验证
		if(strtoupper(CHARSET) == 'GBK'){
			$member_list = Language::getUTF8($member_list);
		}
		echo json_encode($member_list);die;
	}
	/**
	 * 删除圈子
	 */
	public function circle_delOp(){
		$id = intval($_GET['c_id']);
		if($id <= 0){
			showMessage(L('param_error'));
		}
		$model = Model();
		$circle_info = $model->table('circle')->find($id);
		if(!empty($circle_info)) @unlink(BASE_UPLOAD_PATH.DS.ATTACH_CIRCLE.'/group/'.$circle_info['circle_id'].'.jpg');

		// 删除附件
		$affix_list = $model->table('circle_affix')->where(array('circle_id'=>$id))->select();
		if(!empty($affix_list)){
			foreach ($affix_list as $val){
				@unlink(themeImagePath($val['affix_filename']));
				@unlink(themeImagePath($val['affix_filethumb']));
			}
			$model->table('circle_affix')->where(array('circle_id'=>$id))->delete();
		}

		// 删除商品
		$model->table('circle_thg')->where(array('circle_id'=>$id))->delete();

		// 删除赞表相关
		$model->table('circle_like')->where(array('circle_id'=>$id))->delete();

		// 删除回复
		$model->table('circle_threply')->where(array('circle_id'=>$id))->delete();

		// 删除话题
		$model->table('circle_theme')->where(array('circle_id'=>$id))->delete();

		// 删除成员
		$model->table('circle_member')->where(array('circle_id'=>$id))->delete();

		// 删除圈子
		$model->table('circle')->delete($id);

		$this->log(L('nc_del_circle').'['.$id.']');
		showMessage(L('nc_common_op_succ'));
	}
	/**
	 * 会员名称检测
	 */
	public function check_memberOp() {
		$model = Model();
		$member_info = Model('member')->table('member')->where(array('member_name'=>trim($_GET['name']), 'member_id'=>intval($_GET['id'])))->select();
		if(empty($member_info)){
			echo 'false';exit;
		}else{
			// 允许创建数量验证
			$where = array();
			$where['circle_masterid']	= intval($_GET['id']);
			if(intval($_GET['c_id']) > 0){
				$where['circle_id']		= array('neq', intval($_GET['c_id']));
			}
			$count = $model->table('circle')->where($where)->count();
			if(intval($count) >= intval(C('circle_createsum'))){
				echo 'false';exit;
			}

			// 允许加入圈子验证
			$where = array();
			$where['member_id']	= intval($_GET['id']);
			if(intval($_GET['c_id']) > 0){
				$where['circle_id']	= array('neq', intval($_GET['c_id']));
			}
			$count = $model->table('circle_member')->where($where)->count();
			if(intval($count) >= intval(C('circle_joinsum'))){
				echo 'false';exit;
			}

			echo 'true';exit;
		}
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			case 'status':
				$this->log(L('nc_circle_pass_cerify').'['.intval($_GET['id']).']');
			case 'recommend':
				$update = array(
					'circle_id'=>intval($_GET['id']),
					$_GET['column']=>$_GET['value']
				);
				Model()->table('circle')->update($update);
				echo 'true';
				break;
			case 'name':
				$where  = array(
					'circle_id'=>intval($_GET['id'])
				);
				$update = array(
					$_GET['column']=>$_GET['value']
				);
				Model()->table('circle')->where($where)->update($update);
				Model()->table('circle_theme')->where($where)->update($update);
				echo 'true';
				break;

		}
	}
	/**
	 * ajax验证圈子名称
	 */
	public function check_circle_nameOp(){
		$name = $_GET['name'];
		if (strtoupper(CHARSET) == 'GBK'){
			$name = Language::getGBK($name);
		}
		$where = array();
		$where['circle_name']	= $name;
		if(intval($_GET['id']) > 0){
			$where['circle_id']	= array('neq', intval($_GET['id']));
		}
		$rs = Model()->table('circle')->where($where)->find();
		if (!empty($rs)){
			echo 'false';
		}else{
			echo 'true';
		}
	}
}
