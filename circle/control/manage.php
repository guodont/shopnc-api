<?php
/**
 * 圈子首页
 *
 *
 *********************************/

defined('InShopNC') or exit('Access Invalid!');

class manageControl extends BaseCircleManageControl{
	public function __construct(){
		parent::__construct();
		Language::read('circle');
		$this->circleSEO();
	}
	/**
	 * 圈子管理
	 */
	public function indexOp(){
		// 圈子信息
		$this->circleInfo();
		// 会员信息
		$this->circleMemberInfo();
		if($this->identity == 2){
			@header("location: ".CIRCLE_SITE_URL.'/index.php?act=manage&op=applying&c_id='.$this->c_id);
		}
		// 会员加入圈子列表
		$this->memberJoinCircle();
		$model = Model();
		if(chksubmit()){
			$update = array();
			$update['circle_id']	= $this->c_id;
			// 上传图片
			if (!empty($_FILES['c_img']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir', ATTACH_CIRCLE.'/group');
				$upload->set('thumb_width',	120);
				$upload->set('thumb_height', 120);
				$upload->set('thumb_ext', '_120x120');
				$upload->set('ifremove', true);
				$result = $upload->upfile('c_img');
				if ($result){
					$update['circle_img']	= $upload->thumb_image;
					$model->table('circle')->update($update);
				}else {
					showDialog($upload->error);
				}
			}
			$update['circle_desc']		= $_POST['c_desc'];
			$update['circle_notice']	= $_POST['c_notice'];
			$update['circle_joinaudit']	= $_POST['c_joinaudit'];

			if($_POST['c_mapply'] == 1){
				$update['mapply_open']	= 1;
				$update['mapply_ml']	= $_POST['c_ml'];
			}else{
				$update['mapply_open']	= 0;
				$update['mapply_ml']	= 0;
				$update['new_mapplycount']	= 0;

				// Delete the application information
				$model->table('circle_mapply')->where(array('circle_id'=>$this->c_id))->delete();
			}

			$model->table('circle')->update($update);
			showDialog(L('nc_common_op_succ'), 'reload', 'succ');
		}
		$circle_info = $model->table('circle')->find($this->c_id);
		Tpl::output('circle_info', $circle_info);

		// member level
		$ml_info = $model->table('circle_ml')->find($this->c_id);
		if(empty($ml_info)){
			$mld_array = rkcache('circle_level') ? rkcache('circle_level') : rkcache('circle_level', true);
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

		$this->sidebar_menu('index');
		Tpl::showpage('group_manage_index');
	}
	/**
	 * 成员管理
	 */
	public function member_manageOp(){
		// 圈子信息
		$this->circleInfo();
		// 会员信息
		$this->circleMemberInfo();
		// 会员加入圈子列表
		$this->memberJoinCircle();
		$model = Model();
		// 条件
		$where = array();
		$where['circle_id']	= $this->c_id;
		$where['cm_state']	= 1;
		if($_GET['mname'] != ''){
			$where['member_name'] = array('like', '%'.$_GET['mname'].'%');
		}
		$cm_list = $model->table('circle_member')->where($where)
					->order('is_identity asc,cm_jointime desc')->page(15)->select();
		Tpl::output('show_page', $model->showpage('2'));
		Tpl::output('cm_list', $cm_list);

		$this->sidebar_menu('member');
		Tpl::showpage('group_manage_member');
	}
	/**
	 * 会员操作 禁言/解禁 设为明星/取消明星
	 */
	public function settingOp(){
		// 身份验证
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			showDialog($rs);
		}
		$cmid_array = explode(',', $_GET['cm_id']);
		if(empty($cmid_array)){
			showDialog(L('wrong_argument'));
		}
		// 条件
		$where = array();
		$where['member_id']	= array('in', $cmid_array);
		$where['circle_id']	= $this->c_id;
		// 更新数据
		$update = array();
		if($_GET['type'] == 'yes'){
			$val = 1;
		}else if($_GET['type'] == 'no'){
			$val = 0;
		}
		if($_GET['sign'] == 'speak'){
			$key = 'is_allowspeak';
			$cmid_array = $this->removeManager($cmid_array);	// 去除圈主和管理
			$where['member_id']	= array('in', $cmid_array);
		}else if($_GET['sign'] == 'star'){
			$key = 'is_star';
		}
		if(isset($val) && isset($key)){
			$update[$key] = $val;
		}else{
			showDialog(L('wrong_argument'));
		}

		Model()->table('circle_member')->where($where)->update($update);
		if($key == 'is_allowspeak'){
			// 话题/回复 屏蔽
			$update = array();
			$update['is_closed'] = ($val == 1)?0:1;
			Model()->table('circle_theme')->where($where)->update($update);
			Model()->table('circle_threply')->where($where)->update($update);
		}
		showDialog(L('nc_common_op_succ'), 'reload', 'succ');
	}
	/**
	 * 删除会员操作
	 */
	public function delmemberOp(){
		// 身份验证
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			showDialog($rs);
		}
		if (chksubmit()) {
    		$cmid_array = explode(',', $_GET['cm_id']);
    		$cmid_array = $this->removeCreator($cmid_array); // 去除圈主
    		if(empty($cmid_array)){
    			showDialog(L('wrong_argument'));
    		}
    		// 条件
    		$where = array();
    		$where['member_id'] = array('in', $cmid_array);
    		$where['circle_id'] = $this->c_id;

    		Model()->table('circle_member')->where($where)->delete();

    		if ($_POST['all']) {
    		    Model()->table('circle_theme')->where($where)->delete();
    		    Model()->table('circle_threply')->where($where)->delete();
    		}

    		// 更新圈子成员数量
    		$count = Model()->table('circle_member')->where(array('circle_id'=>$this->c_id, 'cm_state'=>1))->count();
    		Model()->table('circle')->update(array('circle_id'=>$this->c_id, 'circle_mcount'=>$count));

    		showDialog(L('nc_common_op_succ'), 'reload', 'succ');
		}
		Tpl::showpage('group_manage_memberdel', 'null_layout');
	}
	/**
	 * 设置/取消管理
	 */
	public function setmanageOp(){
		// 身份验证
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			showDialog($rs);
		}

		$cmid_array = explode(',', $_GET['cm_id']);
		if(empty($cmid_array)){
			showDialog(L('wrong_argument'));
		}
		// 计算允许添加管理员个数
		if($_GET['type'] == 'yes'){
			$cmid_array = $this->removeManager($cmid_array);	// 去除圈主和管理
			$manage_count = Model()->table('circle_member')->where(array('circle_id'=>$this->c_id, 'is_identity'=>2))->count();
			$i = intval(C('circle_managesum')) - intval($manage_count);
			$cmid_array	= array_slice($cmid_array, 0, $i);
		}else{
			$cmid_array = $this->removeCreator($cmid_array);	// 去除圈主
		}
		// 条件
		$where = array();
		$where['member_id'] = array('in', $cmid_array);
		$where['circle_id'] = $this->c_id;

		// 更新数据
		$update = array();
		if($_GET['type'] == 'yes'){
			$update['is_identity'] = 2;
		}else if($_GET['type'] == 'no'){
			$update['is_identity'] = 3;
		}
		Model()->table('circle_member')->where($where)->update($update);
		showDialog(L('nc_common_op_succ'), 'reload', 'succ');
	}
	/**
	 * 正在申请成员列表
	 */
	public function applyingOp(){
		// 圈子信息
		$this->circleInfo();
		// 会员信息
		$this->circleMemberInfo();
		// 会员加入圈子列表
		$this->memberJoinCircle();
		// 成员列表
		$cm_list = Model()->table('circle_member')->where(array('circle_id'=>$this->c_id, 'cm_state'=>0))->order('is_identity asc,cm_jointime desc')->select();
		Tpl::output('cm_list', $cm_list);

		$this->sidebar_menu('applying');
		Tpl::showpage('group_manage_memberapplying');
	}
	/**
	 * 申请中成员操作
	 */
	public function applying_manageOp(){
		// 身份验证
		$rs = $this->checkIdentity('cm');
		if(!empty($rs)){
			showDialog($rs);
		}

		$cmid_array = explode(',', $_GET['cm_id']);
		if(empty($cmid_array)){
			showDialog(L('wrong_argument'));
		}
		$model = Model();

		// 条件
		$where = array();
		$where['circle_id']	= $this->c_id;
		$where['member_id']	= array('in', $cmid_array);

		// 更新数据
		$update = array();
		if($_GET['type'] == 'yes'){
			$update['cm_state'] = 1;
		}elseif ($_GET['type'] == 'no'){
			$update['cm_state'] = 2;
		}
		$model->table('circle_member')->where($where)->update($update);

		// Update the number of members
		$count = $model->table('circle_member')->where(array('circle_id'=>$this->c_id, 'cm_state'=>1))->count();
		$model->table('circle')->update(array('circle_id'=>$this->c_id, 'circle_mcount'=>$count));

		// Update is applying for membership
		$count = $model->table('circle_member')->where(array('circle_id'=>$this->c_id, 'cm_state'=>0))->count();
		$model->table('circle')->update(array('circle_id'=>$this->c_id, 'new_verifycount'=>$count));

		showDialog(L('nc_common_op_succ'), 'reload', 'succ');
	}
	/**
	 * 分类管理
	 */
	public function classOp(){
		// 圈子信息
		$this->circleInfo();
		// 会员信息
		$this->circleMemberInfo();
		// 会员加入圈子列表
		$this->memberJoinCircle();

		$model = Model();
		$thclass_list = $model->table('circle_thclass')->where(array('circle_id'=>$this->c_id))->order('thclass_sort asc')->select();
		Tpl::output('thclass_list', $thclass_list);

		$this->sidebar_menu('class');
		Tpl::showpage('group_manage_class');
	}
	/**
	 * 分类添加
	 */
	public function class_addOp(){
		// 身份验证
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			showDialog($rs);
		}
		if(chksubmit()){
			// 超过10不能继续添加
			$count = Model()->table('circle_thclass')->where(array('circle_id'=>$this->c_id))->count();
			if($count >= 10){
				showDialog(L('circle_tclass_max_10'));
			}

			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["name"], "require"=>"true", "message"=>L('circle_tclass_name_not_null')),
					array("input"=>$_POST["sort"], "require"=>"true", 'validator'=>'Number', "message"=>L('circle_sort_error')),
			);
			$error = $obj_validate->validate();
			if($error != ''){
				showDialog($error);
			}else{
				$insert = array();
				$insert['thclass_name']		= $_POST['name'];
				$insert['thclass_status']	= intval($_POST['status']);
				$insert['is_moderator']		= intval($_POST['moderator']);
				$insert['thclass_sort']		= $_POST['sort'];
				$insert['circle_id']		= $this->c_id;
				Model()->table('circle_thclass')->insert($insert);
				showDialog(L('nc_common_op_succ'), 'reload', 'succ', 'CUR_DIALOG.close();');
			}
		}
		Tpl::showpage('group_manage_classadd', 'null_layout');
	}
	/**
	 * 分类编辑
	 */
	public function class_editOp(){
		// 身份验证
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			showDialog($rs);
		}

		if(chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["name"], "require"=>"true", "message"=>L('circle_tclass_name_not_null')),
					array("input"=>$_POST["sort"], "require"=>"true", 'validator'=>'Number', "message"=>L('circle_sort_error')),
			);
			$error = $obj_validate->validate();
			if($error != ''){
				showDialog($error);
			}else{
				$update = array();
				$update['thclass_id']		= intval($_POST['thc_id']);
				$update['thclass_name']		= $_POST['name'];
				$update['thclass_status']	= intval($_POST['status']);
				$update['is_moderator']		= intval($_POST['moderator']);
				$update['thclass_sort']		= $_POST['sort'];
				$update['circle_id']		= $this->c_id;
				Model()->table('circle_thclass')->where(array('thclass_id'=>intval($_POST['thc_id']), 'circle_id'=>$this->c_id))->update($update);
				showDialog(L('nc_common_op_succ'), 'reload', 'succ', 'CUR_DIALOG.close();');
			}
		}
		$thc_id = intval($_GET['thc_id']);
		if($thc_id <= 0){
			showDialog(L('wrong_argument'));
		}
		$thclass_info = Model()->table('circle_thclass')->where(array('circle_id'=>$this->c_id, 'thclass_id'=>$thc_id))->find();
		if(empty($thclass_info)){
			showDialog(L('wrong_argument'));
		}
		Tpl::output('thclass_info', $thclass_info);
		Tpl::showpage('group_manage_classedit', 'null_layout');
	}
	/**
	 * 删除分类
	 */
	public function class_delOp(){
		// 身份验证
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			showDialog($rs);
		}
		$thcid_array = explode(',', $_GET['thc_id']);
		if(empty($thcid_array)){
			showDialog(L('wrong_argument'));
		}
		// 条件
		$where = array();
		$where['circle_id']	= $this->c_id;
		$where['thclass_id']= array('in', $thcid_array);

		Model()->table('circle_thclass')->where($where)->delete();
		showDialog(L('nc_common_op_succ'), 'reload', 'succ');
	}
	/**
	 * 友情圈子
	 */
	public function friendshipOp(){
		// 圈子信息
		$this->circleInfo();
		// 会员信息
		$this->circleMemberInfo();
		// 会员加入圈子列表
		$this->memberJoinCircle();

		$fs_list = Model()->table('circle_fs')->where(array('circle_id'=>$this->c_id))->order('friendship_sort asc')->select();
		Tpl::output('fs_list', $fs_list);

		$this->sidebar_menu('friendship');
		Tpl::showpage('group_manage_fs');
	}
	/**
	 * 添加友情圈子
	 */
	public function friendship_addOp(){
		// 身份验证
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			showDialog($rs);
		}

		if(chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["cid"], "require"=>"true", 'validator'=>'Number', "message"=>L('fcircle_please_choose')),
					array("input"=>$_POST["sort"], "require"=>"true", 'validator'=>'Number', "message"=>L('circle_sort_error')),
			);
			$error = $obj_validate->validate();
			if($error != ''){
				showDialog($error);
			}else{
				if($_POST['cid'] <= 0){
					showDialog(L('fcircle_please_choose'));
				}
				$insert = array();
				$insert['circle_id']		= $this->c_id;
				$insert['friendship_id']	= $_POST['cid'];
				$insert['friendship_name']	= $_POST['cname'];
				$insert['friendship_sort']	= $_POST['sort'];
				$insert['friendship_status']= $_POST['status']?1:0;
				Model()->table('circle_fs')->insert($insert);
				showDialog(L('nc_common_op_succ'), 'reload', 'succ', 'CUR_DIALOG.close();');
			}

		}
		Tpl::showpage('group_manage_fsadd', 'null_layout');
	}
	/**
	 * ajax根据名称搜索
	 */
	public function search_circleOp(){
		// 身份验证
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			echo 'false';die;
		}
		$model = Model();

		// 查询已加友情圈子
		$circle_list = $model->table('circle_fs')->where(array('circle_id'=>$this->c_id))->select();
		if (!empty($circle_list)){
			$circle_list = array_under_reset($circle_list, 'friendship_id'); $circle_array = array_keys($circle_list);
		}

		$where = array();
		$where['circle_name']	= array('like', '%'.$_GET['name'].'%');
		$where['circle_status']	= 1;
		if(!empty($circle_array)){
			$circle_array[] = $this->c_id;
			$where['circle_id']	= array('not in', $circle_array);
		}else{
			$where['circle_id']	= array('neq', $this->c_id);
		}
		$circle_list = $model->table('circle')->field('circle_id,circle_name')->where($where)->select();
		if (empty($circle_list)) {
		    echo 'false';die;
		}

		if (strtoupper(CHARSET) == 'GBK'){
			$circle_list = Language::getUTF8($circle_list);
		}
		echo json_encode($circle_list);
	}
	/**
	 * 编辑圈子
	 */
	public function friendship_editOp(){
		// 身份验证
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			showDialog($rs);
		}

		if(chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["sort"], "require"=>"true", 'validator'=>'Number', "message"=>L('circle_sort_error')),
			);
			$error = $obj_validate->validate();
			if($error != ''){
				showDialog($error);
			}else{
				$update = array();
				$update['friendship_sort']	= $_POST['sort'];
				$update['friendship_status']= $_POST['status']?1:0;
				Model()->table('circle_fs')->where(array('circle_id'=>$this->c_id, 'friendship_id'=>intval($_GET['fs_id'])))->update($update);
				showDialog(L('nc_common_op_succ'), 'reload', 'succ', 'CUR_DIALOG.close();');
			}

		}

		$fs_id = intval($_GET['fs_id']);
		if($fs_id <= 0){
			showDialog(L('wrong_argument'));
		}
		$friendship_info = Model()->table('circle_fs')->where(array('circle_id'=>$this->c_id, 'friendship_id'=>$fs_id))->find();
		if(empty($friendship_info)){
			showDialog(L('wrong_argument'));
		}
		Tpl::output('fs_id', $fs_id);
		Tpl::output('friendship_info', $friendship_info);

		Tpl::showpage('group_manage_fsedit', 'null_layout');
	}
	/**
	 * 删除友情圈子
	 */
	public function friendship_delOp(){
		// 身份验证
		$rs = $this->checkIdentity('c');
		if(!empty($rs)){
			showDialog($rs);
		}
		$fs_array = explode(',', $_GET['fs_id']);
		if(empty($fs_array)){
			showDialog(L('wrong_argument'));
		}
		$where = array();
		$where['circle_id']	= $this->c_id;
		$where['friendship_id'] = array('in', $fs_array);
		Model()->table('circle_fs')->where($where)->delete();
		showDialog(L('nc_common_op_succ'), 'reload', 'succ');
	}
	/**
	 * 加精/取消加精
	 * 置顶/取消置顶
	 */
	public function ajaxOp(){
		// 身份验证
		$rs = $this->checkIdentity('cm');
		if(!empty($rs)){
			echo 'false';exit;
		}
		$update = array();
		$update['theme_id'] = intval($_GET['id']);
		switch ($_GET['column']){
			case 'digest':
				$update['is_digest'] = $_GET['value'];
				break;
			case 'top':
				$update['is_stick'] = $_GET['value'];
				break;
			case 'shut':
				$update['is_shut'] = $_GET['value'];
				break;
		}
		Model()->table('circle_theme')->update($update);
		echo 'true';exit;
	}
	/**
	 * 编辑话题
	 */
	public function edit_themeOp(){
		// 身份验证
		$rs = $this->checkIdentity('cm');
		if(!empty($rs)){
			showMessage($rs);
		}
		$t_id = intval($_GET['t_id']);
		if($t_id <= 0){
			showMessage(L('wrong_argument'));
		}
		Tpl::output('t_id', $t_id);

		$model = Model();
		if(chksubmit()){
			// 主题分类
			$thclass_id = intval($_POST['thtype']);
			$thclass_name = '';
			if($thclass_id > 0){
				$thclass_info = $model->table('circle_thclass')->find($thclass_id);
				$thclass_name = $thclass_info['thclass_name'];
			}

			$model = Model();
			$update = array();
			$update['theme_id']			= $t_id;
			$update['theme_name']		= circleCenterCensor($_POST['name']);
			$update['theme_content']	= circleCenterCensor($_POST['themecontent']);
			$update['thclass_id']		= $thclass_id;
			$update['thclass_name']		= $thclass_name;
			$update['theme_editname']	= $_SESSION['member_name'];
			$update['theme_edittime']	= time();
			$update['theme_readperm']	= intval($_POST['readperm']);
			$rs = $model->table('circle_theme')->update($update);
			if($rs){
				$has_goods = 0;	// 存在商品标记
				$has_affix = 0;// 存在附件标记
				// 删除原有商品
				$goods_list = Model()->table('circle_thg')->where(array('theme_id'=>$t_id, 'reply_id'=>0))->delete();
				// 插入话题商品
				if(!empty($_POST['goods'])){
					$goods_insert = array();
					foreach ($_POST['goods'] as $key=>$val){
						$p = array();
						$p['theme_id']		= $t_id;
						$p['reply_id']		= 0;
						$p['circle_id']		= $this->c_id;
						$p['goods_id']		= $key;
						$p['goods_name']	= $val['name'];
						$p['goods_price']	= $val['price'];
						$p['goods_image']	= $val['image'];
						$p['store_id']		= $val['storeid'];
						$goods_insert[]		= $p;
					}
					$rs = $model->table('circle_thg')->insertAll($goods_insert);
					$has_goods = 1;
				}

				// 更新话题信息
				$affixe_count = $model->table('circle_affix')->where(array('affix_type'=>1, 'theme_id'=>$t_id))->count();
				if($affixe_count > 0){
					$has_affix = 1;
				}
				if($has_goods || $has_affix){
					$update = array();
					$update['theme_id']		= $t_id;
					$update['has_goods']	= $has_goods;
					$update['has_affix']	= $has_affix;
					$model->table('circle_theme')->update($update);
				}
				// Special theme
				if($_GET['sp'] == 1){
					// Update the vote
					$update = array();
					$update['theme_id']			= $t_id;
					$update['poll_multiple']	= intval($_POST['multiple']);
					$update['poll_startime']	= time();
					$update['poll_endtime']		= intval($_POST['days'])!=0?time()+intval($_POST['days'])*60*60*12:0;
					$update['poll_days']		= intval($_POST['days']);
					$model->table('circle_thpoll')->update($update);

					// Update the voting options
					if(!empty($_POST['polloption'])){
						$insert_array = array();
						foreach ($_POST['polloption'] as $key=>$val){
							$option_info = $model->table('circle_thpolloption')->where(array('pollop_id'=>$key, 'theme_id'=>$t_id))->find();
							if(!empty($option_info)){
								$update = array();
								$update['pollop_id']	= $key;
								$update['pollop_option']= $val;
								$update['pollop_sort']	= $_POST['pollsort'][$key];
								$model->table('circle_thpolloption')->update($update);
							}else{
								if ($val == '') continue;
								$i = array();
								$i['theme_id']		= $t_id;
								$i['pollop_option']	= $val;
								$i['pollop_sort']	= $_POST['pollsort'][$key];
								$insert_array[]	= $i;
							}
						}
						if(!empty($insert_array)) $model->table('circle_thpolloption')->insertAll($insert_array);
					}
				}
				showDialog(L('nc_common_op_succ'), CIRCLE_SITE_URL.'/index.php?act=theme&op=theme_detail&c_id='.$this->c_id.'&t_id='.$t_id, 'succ');
			}else{
				showDialog(L('nc_common_op_fail'));
			}
		}


		// 圈子信息
		$this->circleInfo();

		// 圈主和管理信息
		$this->manageList();

		// 会员信息
		$this->memberInfo();

		// 话题信息
		$this->theme_info = $model->table('circle_theme')->where(array('theme_id'=>$t_id, 'circle_id'=>$this->c_id))->find();
		if(empty($this->theme_info)){
			showMessage(L('wrong_argument'));
		}
		Tpl::output('theme_info', $this->theme_info);


		// 话题商品
		$goods_list = $model->table('circle_thg')->where(array('theme_id'=>$t_id, 'reply_id'=>0))->select();
		$goods_list = tidyThemeGoods($goods_list, 'themegoods_id');
		Tpl::output('goods_list', $goods_list);

		// 话题附件
		$affix_list = $model->table('circle_affix')->where(array('affix_type'=>1, 'theme_id'=>$t_id))->select();
		Tpl::output('affix_list', $affix_list);

		// 话题分类
		$where = array();
		$where['circle_id']		= $this->c_id;
		$where['thclass_status']= 1;
		$thclass_list = $model->table('circle_thclass')->where($where)->select();
		$thclass_list = array_under_reset($thclass_list, 'thclass_id');
		Tpl::output('thclass_list', $thclass_list);

		// Read permissions
		$readperm = $this->readPermissions($this->cm_info);
		Tpl::output('readperm', $readperm);

		// breadcrumb navigation
		$this->breadcrumd(L('nc_edit_theme'));

		if($this->theme_info['theme_special'] == 1){
			$poll_info = $model->table('circle_thpoll')->find($t_id);
			Tpl::output('poll_info', $poll_info);
			$option_list = $model->table('circle_thpolloption')->where(array('theme_id'=>$t_id))->order('pollop_sort asc')->select();
			Tpl::output('option_list', $option_list);

			Tpl::showpage('group_manage_edit_themepoll');
		}else{
			Tpl::showpage('group_manage_edit_theme');
		}
	}
	/**
	 * 附件删除
	 */
	public function delimgOp(){
		// 身份验证
		$rs = $this->checkIdentity('cm');
		if(!empty($rs)){
			echo false;exit;
		}

		$id = intval($_GET['id']);
		if($id <= 0){
			echo false;exit;
		}

		// 附件详细
		$affix_info = Model()->table('circle_affix')->where(array('member_id'=>$_SESSION['member_id'], 'affix_id'=>$id))->find();
		if(empty($affix_info)){
			echo false;exit;
		}

		// 验证是否为该圈子附件
		$theme_info = Model()->table('circle_theme')->where(array('circle_id'=>$this->c_id, 'theme_id'=>$affix_info['theme_id']))->find();
		if(empty($theme_info)){
			echo false;exit;
		}

		@unlink(themeImagePath($affix_info['affix_filename']));
		@unlink(themeImagePath($affix_info['affix_filethumb']));
		Model()->table('circle_affix')->delete($id);
		echo true;exit;
	}
	/**
	 * 删除话题
	 */
	public function del_themeOp(){
		// 身份验证
		$rs = $this->checkIdentity('cm');
		if(!empty($rs)){
			showMessage($rs);
		}
		$model = Model();
		// 验证话题
		$t_id = intval($_GET['t_id']);
		$theme_info = $model->table('circle_theme')->where(array('theme_id'=>$t_id, 'circle_id'=>$this->c_id))->find();
		if(empty($theme_info)){
			showDialog(L('wrong_argument'));
		}

		// 删除附件
		$affix_list = $model->table('circle_affix')->where(array('theme_id'=>$t_id))->select();
		if(!empty($affix_list)){
			foreach ($affix_list as $val){
				@unlink(themeImagePath($val['affix_filename']));
				@unlink(themeImagePath($val['affix_filethumb']));
			}
			$model->table('circle_affix')->where(array('theme_id'=>$t_id))->delete();
		}

		// 删除商品
		$model->table('circle_thg')->where(array('theme_id'=>$t_id))->delete();

		// 删除赞表相关
		$model->table('circle_like')->where(array('theme_id'=>$t_id))->delete();

		// 删除回复
		$model->table('circle_threply')->where(array('theme_id'=>$t_id))->delete();

		// The recycle bin add delete records
		$param = array();
		$param['theme_id']	= $t_id;
		$param['op_id']		= $_SESSION['member_id'];
		$param['op_name']	= $_SESSION['member_name'];
		$param['type']		= 'theme';
		Model('circle_recycle')->saveRecycle($param);

		// 删除话题
		$model->table('circle_theme')->delete($t_id);

		// Experience
		if(intval($theme_info['theme_exp']) > 0){
			$param = array();
			$param['member_id']		= $theme_info['member_id'];
			$param['member_name']	= $theme_info['member_name'];
			$param['circle_id']		= $this->c_id;
			$param['itemid']		= $t_id;
			$param['type']			= 'delRelease';
			$param['exp']			= $theme_info['theme_exp'];
			Model('circle_exp')->saveExp($param);
		}

		showDialog(L('nc_common_op_succ'), CIRCLE_SITE_URL.'/index.php?act=group&c_id='.$this->c_id, 'succ');
	}
	/**
	 * 删除回复
	 */
	public function del_replyOp(){
		// 身份验证
		$rs = $this->checkIdentity('cm');
		if(!empty($rs)){
			showMessage($rs);
		}
		$t_id = intval($_GET['t_id']);
		$r_id = intval($_GET['r_id']);

		// 验证回复
		$model = Model();
		$where = array();
		$where['theme_id']	= $t_id;
		$where['reply_id']	= $r_id;
		$where['circle_id']	= $this->c_id;
		$reply_info = $model->table('circle_threply')->where($where)->find();
		if(empty($reply_info)){
			showDialog(L('circle_reply_not_exists'), 'reload');
		}

		// 删除附件
		$affix_list = $model->table('circle_affix')->where(array('affix_type'=>2, 'theme_id'=>$t_id, 'reply_id'=>$r_id))->select();
		if(!empty($affix_list)){
			foreach ($affix_list as $val){
				@unlink(themeImagePath($val['affix_filename']));
				@unlink(themeImagePath($val['affix_filethumb']));
			}
			$model->table('circle_affix')->where(array('affix_type'=>2 ,'theme_id'=>$t_id, 'reply_id'=>$r_id))->delete();
		}

		// 删除商品
		$model->table('circle_thg')->where(array('theme_id'=>$t_id, 'reply_id'=>$r_id))->delete();

		// The recycle bin add delete records
		$param = array();
		$param['theme_id']	= $t_id;
		$param['reply_id']	= $r_id;
		$param['op_id']		= $_SESSION['member_id'];
		$param['op_name']	= $_SESSION['member_name'];
		$param['type']		= 'reply';
		Model('circle_recycle')->saveRecycle($param);

		// 删除回复
		$rs = $model->table('circle_threply')->where(array('theme_id'=>$t_id, 'reply_id'=>$r_id))->delete();
		// 更新话题回复数
		$model->table('circle_theme')->update(array('theme_id'=>$t_id, 'theme_commentcount'=>array('exp', 'theme_commentcount-1')));
		// Experience
		if(intval($reply_info['reply_exp']) > 0){
			$param = array();
			$param['member_id']		= $reply_info['member_id'];
			$param['member_name']	= $reply_info['member_name'];
			$param['circle_id']		= $this->c_id;
			$param['itemid']		= $t_id.','.$r_id;
			$param['type']			= 'delReplied';
			$param['exp']			= $reply_info['reply_exp'];
			Model('circle_exp')->saveExp($param);
		}
		showDialog(L('nc_common_op_succ'), 'reload', 'succ');
	}
	/**
	 * ajax禁言
	 */
	public function ajax_nospeakOp(){
		// 身份验证
		$rs = $this->checkIdentity('cm');
		if(!empty($rs)){
			showDialog($rs);
		}

		// 条件
		$where = array();
		$where['member_id']	= intval($_GET['m_id']);
		$where['circle_id']	= $this->c_id;

		// 圈主和管理不能被禁言
		$m_info = Model()->table('circle_member')->where($where)->find();
		if(in_array($m_info['is_identity'], array(1,2))){
			showDialog(L('circle_manager_shutup_error'));
		}

		// 更新数据
		$update = array();
		$update['is_allowspeak'] = intval($_GET['value']);

		Model()->table('circle_member')->where($where)->update($update);


		// 话题/回复 屏蔽
		$update = array();
		$update['is_closed'] = (intval($_GET['value']) == 1) ? 0 : 1;
		Model()->table('circle_theme')->where($where)->update($update);
		Model()->table('circle_threply')->where($where)->update($update);

		showDialog(L('nc_common_op_succ'), 'reload', 'succ');
	}



}
