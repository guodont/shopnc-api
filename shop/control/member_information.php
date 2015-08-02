<?php
/**
 * 用户中心
 ***/


defined('InShopNC') or exit('Access Invalid!');

class member_informationControl extends BaseMemberControl {
	/**
	 * 用户中心
	 *
	 * @param
	 * @return
	 */
	public function indexOp() {
		$this->memberOp();
	}
	/**
	 * 我的资料【用户中心】
	 *
	 * @param
	 * @return
	 */
	public function memberOp() {

		Language::read('member_home_member');
		$lang	= Language::getLangContent();

		$model_member	= Model('member');

		if (chksubmit()){

			$member_array	= array();
			$member_array['member_truename']	= $_POST['member_truename'];
			$member_array['member_sex']			= $_POST['member_sex'];
			$member_array['member_qq']			= $_POST['member_qq'];
			$member_array['member_ww']			= $_POST['member_ww'];
			$member_array['member_areaid']		= $_POST['area_id'];
			$member_array['member_cityid']		= $_POST['city_id'];
			$member_array['member_provinceid']	= $_POST['province_id'];
			$member_array['member_areainfo']	= $_POST['area_info'];
			if (strlen($_POST['birthday']) == 10){
				$member_array['member_birthday']	= $_POST['birthday'];
			}
			$member_array['member_privacy']		= serialize($_POST['privacy']);
			$update = $model_member->editMember(array('member_id'=>$_SESSION['member_id']),$member_array);

			$message = $update? $lang['nc_common_save_succ'] : $lang['nc_common_save_fail'];
			showDialog($message,'reload',$update ? 'succ' : 'error');
		}

		if($this->member_info['member_privacy'] != ''){
			$this->member_info['member_privacy'] = unserialize($this->member_info['member_privacy']);
		} else {
		    $this->member_info['member_privacy'] = array();
		}
		Tpl::output('member_info',$this->member_info);

		self::profile_menu('member','member');
		Tpl::output('menu_sign','profile');
		Tpl::output('menu_sign_url','index.php?act=member_information&op=member');
		Tpl::output('menu_sign1','baseinfo');
		Tpl::showpage('member_profile');
	}
	/**
	 * 我的资料【更多个人资料】
	 *
	 * @param
	 * @return
	 */
	public function moreOp(){
		/**
		 * 读取语言包
		 */
		Language::read('member_home_member');

		// 实例化模型
		$model = Model();

		if(chksubmit()){
			$model->table('sns_mtagmember')->where(array('member_id'=>$_SESSION['member_id']))->delete();
			if(!empty($_POST['mid'])){
				$insert_array = array();
				foreach ($_POST['mid'] as $val){
					$insert_array[] = array('mtag_id'=>$val,'member_id'=>$_SESSION['member_id']);
				}
				$model->table('sns_mtagmember')->insertAll($insert_array,'',true);
			}
			showDialog(Language::get('nc_common_op_succ'),'','succ');
		}

		// 用户标签列表
		$mtag_array = $model->table('sns_membertag')->order('mtag_sort asc')->limit(1000)->select();

		// 用户已添加标签列表。
		$mtm_array = $model->table('sns_mtagmember')->where(array('member_id'=>$_SESSION['member_id']))->select();
		$mtag_list	= array();
		$mtm_list	= array();
		if(!empty($mtm_array) && is_array($mtm_array)){
			// 整理
			$elect_array = array();
			foreach($mtm_array as $val){
				$elect_array[]	= $val['mtag_id'];
			}
			foreach ((array)$mtag_array as $val){
				if(in_array($val['mtag_id'], $elect_array)){
					$mtm_list[] = $val;
				}else{
					$mtag_list[] = $val;
				}
			}
		}else{
			$mtag_list = $mtag_array;
		}
		Tpl::output('mtag_list', $mtag_list);
		Tpl::output('mtm_list', $mtm_list);

		self::profile_menu('member','more');
		Tpl::output('menu_sign','profile');
		Tpl::output('menu_sign_url','index.php?act=member_information&op=member');
		Tpl::output('menu_sign1','baseinfo');
		Tpl::showpage('member_profile.more');
	}

	public function uploadOp() {
		if (!chksubmit()){
			redirect('index.php?act=member_information&op=avatar');
		}
		import('function.thumb');
		Language::read('member_home_member,cut');
		$lang	= Language::getLangContent();
		$member_id = $_SESSION['member_id'];

		//上传图片
		$upload = new UploadFile();
		$upload->set('thumb_width',	500);
		$upload->set('thumb_height',499);
		$ext = strtolower(pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION));
		$upload->set('file_name',"avatar_$member_id.$ext");
		$upload->set('thumb_ext','_new');
		$upload->set('ifremove',true);
		$upload->set('default_dir',ATTACH_AVATAR);
		if (!empty($_FILES['pic']['tmp_name'])){
			$result = $upload->upfile('pic');
			if (!$result){
				showMessage($upload->error,'','html','error');
			}
		}else{
			showMessage('上传失败，请尝试更换图片格式或小图片','','html','error');
		}
		self::profile_menu('member','avatar');
		Tpl::output('menu_sign','profile');
		Tpl::output('menu_sign_url','index.php?act=member_information&op=member');
		Tpl::output('menu_sign1','avatar');
		Tpl::output('newfile',$upload->thumb_image);
		Tpl::output('height',get_height(BASE_UPLOAD_PATH.'/'.ATTACH_AVATAR.'/'.$upload->thumb_image));
		Tpl::output('width',get_width(BASE_UPLOAD_PATH.'/'.ATTACH_AVATAR.'/'.$upload->thumb_image));
		Tpl::showpage('member_profile.avatar');
	}

	/**
	 * 裁剪
	 *
	 */
	public function cutOp(){
		if (chksubmit()){
			$thumb_width = 120;
			$x1 = $_POST["x1"];
			$y1 = $_POST["y1"];
			$x2 = $_POST["x2"];
			$y2 = $_POST["y2"];
			$w = $_POST["w"];
			$h = $_POST["h"];
			$scale = $thumb_width/$w;
			$_POST['newfile'] = str_replace('..', '', $_POST['newfile']);
			if (strpos($_POST['newfile'],"avatar_{$_SESSION['member_id']}_new.") !== 0) {
			    redirect('index.php?act=member_information&op=avatar');
			}
			$src = BASE_UPLOAD_PATH.DS.ATTACH_AVATAR.DS.$_POST['newfile'];
			$avatarfile = BASE_UPLOAD_PATH.DS.ATTACH_AVATAR.DS."avatar_{$_SESSION['member_id']}.jpg";
			import('function.thumb');
			$cropped = resize_thumb($avatarfile, $src,$w,$h,$x1,$y1,$scale);
			@unlink($src);
			Model('member')->editMember(array('member_id'=>$_SESSION['member_id']),array('member_avatar'=>'avatar_'.$_SESSION['member_id'].'.jpg'));
			$_SESSION['avatar'] = 'avatar_'.$_SESSION['member_id'].'.jpg';
			redirect('index.php?act=member_information&op=avatar');
		}
	}

	/**
	 * 更换头像
	 *
	 * @param
	 * @return
	 */
	public function avatarOp() {
		Language::read('member_home_member,cut');
		$member_info = Model('member')->getMemberInfoByID($_SESSION['member_id'],'member_avatar');
		Tpl::output('member_avatar',$member_info['member_avatar']);
		self::profile_menu('member','avatar');
		Tpl::output('menu_sign','profile');
		Tpl::output('menu_sign_url','index.php?act=member_information&op=member');
		Tpl::output('menu_sign1','avatar');
		Tpl::showpage('member_profile.avatar');
	}

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array		= array();
		switch ($menu_type) {
			case 'member':
				$menu_array	= array(
				1=>array('menu_key'=>'member',	'menu_name'=>Language::get('home_member_base_infomation'),'menu_url'=>'index.php?act=member_information&op=member'),
				2=>array('menu_key'=>'more',	'menu_name'=>Language::get('home_member_more'),'menu_url'=>'index.php?act=member_information&op=more'),
				5=>array('menu_key'=>'avatar',	'menu_name'=>Language::get('home_member_modify_avatar'),'menu_url'=>'index.php?act=member_information&op=avatar'));
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
