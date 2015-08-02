<?php
/**
 * SNS首页
 ***/


defined('InShopNC') or exit('Access Invalid!');

class member_snsfriendControl extends BaseMemberControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_sns_friend');
	}
	private function m_sex($sextype){
		switch ($sextype){
			case 1:
				return 'male';
				break;
			case 2:
				return 'female';
				break;
			default:
				return '';
				break;
		}
	}
	/**
	 * 好友首页
	 */
	public function indexOp(){
		$this->findOp();
	}
	/**
	 * 找人首页
	 */
	public function findOp(){
		if(chksubmit()) {
			Tpl::output('type','list');
		}else{

			// 查看推荐
			$model = Model();
			$mtag_list = $model->table('sns_membertag')->where(array('mtag_recommend'=>1))->order('mtag_sort asc')->select();
			if(!empty($mtag_list)){
				// 查询已关注好友 ，不显示已关注好友
				$friend_array = $model->table('sns_friend')->field('friend_tomid')->where(array('friend_frommid'=>$_SESSION['member_id']))->select();
				$friendid_array[] = $_SESSION['member_id'];
				if(!empty($friend_array)){
					foreach ($friend_array as $val){
						$friendid_array[]	= $val['friend_tomid'];
					}
				}

				$mtagid_array = array();
				foreach($mtag_list as $val){
					$mtagid_array[] = $val['mtag_id'];
				}

				// 查询会员
				$where['sns_mtagmember.mtag_id']	= array('in',$mtagid_array); //查询条件
				$where['sns_mtagmember.member_id']	= array('not in',$friendid_array);

				$tagmember_list = $model->table('sns_mtagmember,member')
									->field('sns_mtagmember.*,member.member_avatar,member.member_name')
									->join('left')->on('sns_mtagmember.member_id=member.member_id')
									->where($where)
									->order('sns_mtagmember.recommend desc, sns_mtagmember.member_id asc')
									->limit(count($mtagid_array)*20)->select();
				// 整理
				$tagmember_list = array_under_reset($tagmember_list, 'mtag_id', 2);
				Tpl::output('mtag_list', $mtag_list);
				Tpl::output('tagmember_list', $tagmember_list);
			}
			Tpl::output('type', 'index');
		}
		self::profile_menu('find');
		Tpl::showpage('member_snsfriend_find');
	}
	/**
	 * 找人搜索列表
	 */
	public function findlistOp(){
		if(trim($_POST['searchname']) != ''){
			// 实例化模型
			$model = Model();

			//查询关注会员id
			$followlist = $model->table('sns_friend')->field('friend_tomid, friend_followstate')->where(array('friend_frommid'=>$_SESSION['member_id']))->select();
			unset($condition_arr);
			$followlist_new = array();
			if(!empty($followlist)){
				foreach($followlist as $k=>$v){
					$followlist_new[$v['friend_tomid']] = $v;
				}
			}

			//查询会员

			// 查询条件
			$where = array();
			$where['member_state']	= 1;
			$where['member_id']		= array('neq',$_SESSION['member_id']);
			$where['member_name']	= array('like','%'.trim($_POST['searchname']).'%');// 会员名称
			// 省份
			if(intval($_POST['provinceid']) > 0){
				$where['member_provinceid'] = intval($_POST['provinceid']);
			}
			// 城市
			if(intval($_POST['cityid']) > 0){
				$where['member_cityid'] = intval($_POST['cityid']);
			}
			// 地区
			if(intval($_POST['areaid']) > 0){
				$where['member_areaid'] = intval($_POST['areaid']);
			}
			// 性别
			if(intval($_POST['sex']) > 0){
				$where['member_sex'] = intval($_POST['sex']);
			}
			// 年龄
			if(intval($_POST['age']) > 0){
				switch (intval($_POST['age'])){
					case 1:
					    $s_time = (date('Y')-18).'-'.date('m').'-'.date('d');
						$e_time = date('Y-m-d');
						$where['member_birthday'] = array('BETWEEN',$s_time.','.$e_time);
						break;
					case 2:
						$s_time = (date('Y')-24).'-'.date('m-d');
					    $e_time = (date('Y')-18).'-'.date('m').'-'.(date('d')-1);
						$where['member_birthday'] = array('BETWEEN',$s_time.','.$e_time);
						break;
					case 3:
						$s_time = (date('Y')-30).'-'.date('m-d');
					    $e_time = (date('Y')-24).'-'.date('m').'-'.(date('d')-1);
						$where['member_birthday'] = array('BETWEEN',$s_time.','.$e_time);
						break;
					case 4:
						$s_time = (date('Y')-35).'-'.date('m-d');
						$e_time = (date('Y')-30).'-'.date('m').'-'.(date('d')-1);
						$where['member_birthday'] = array('BETWEEN',$s_time.','.$e_time);
						break;
					case 5:
					    $e_time = (date('Y')-35).'-'.date('m').'-'.(date('d')-1);
						$where['member_birthday'] = array('elt',$e_time);
						break;
				}
			}
			
			$memberlist = $model->table('member')->where($where)->limit(50)->select();
			if(!empty($memberlist)){
				$followid_arr = array_keys($followlist_new);
				foreach($memberlist as $k=>$v){
					if(in_array($v['member_id'],$followid_arr)){
						$v['followstate'] = $followlist_new[$v['member_id']]['friend_followstate'];
					}else{
						$v['followstate'] = 0;
					}
					//性别
					$v['sex_class'] = $this->m_sex($v['member_sex']);
					$memberlist[$k] = $v;
				}
			}
			
		}
		Tpl::output('memberlist',$memberlist);
		self::profile_menu('find');
		Tpl::showpage('member_snsfriend_findlist');
	}
	/**
	 * 加关注
	 */
	public function addfollowOp() {
		$mid = intval($_GET['mid']);
		if($mid<=0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		//验证会员信息
		$member_model = Model('member');
		$condition_arr = array();
		$condition_arr['member_state'] = "1";
		$condition_arr['member_id'] = array('in', array($mid,$_SESSION['member_id']));
		$member_list = $member_model->getMemberList($condition_arr);
		unset($condition_arr);
		if(empty($member_list)){
			showDialog(Language::get('snsfriend_member_error'),'','error');
		}
		$self_info = array();
		$member_info = array();
		foreach($member_list as $k=>$v){
			if($v['member_id'] == $_SESSION['member_id']){
				$self_info = $v;
			}else{
				$member_info = $v;
			}
		}
		if(empty($self_info) || empty($member_info)){
			showDialog(Language::get('snsfriend_member_error'),'','error');
		}
		//验证是否已经存在好友记录
		$friend_model = Model('sns_friend');
		$friend_count = $friend_model->countFriend(array('friend_frommid'=>"{$_SESSION['member_id']}",'friend_tomid'=>"$mid"));
		if($friend_count >0 ){
			showDialog(Language::get('snsfriend_havefollowed'),'','error');
		}
		//查询对方是否已经关注我，从而判断关注状态
		$friend_info = $friend_model->getFriendRow(array('friend_frommid'=>"{$mid}",'friend_tomid'=>"{$_SESSION['member_id']}"));
		$insert_arr = array();
		$insert_arr['friend_frommid'] = "{$self_info['member_id']}";
		$insert_arr['friend_frommname'] = "{$self_info['member_name']}";
		$insert_arr['friend_frommavatar'] = "{$self_info['member_avatar']}";
		$insert_arr['friend_tomid'] = "{$member_info['member_id']}";
		$insert_arr['friend_tomname'] = "{$member_info['member_name']}";
		$insert_arr['friend_tomavatar'] = "{$member_info['member_avatar']}";
		$insert_arr['friend_addtime'] = time();
		if(empty($friend_info)){
			$insert_arr['friend_followstate'] = '1';//单方关注
		}else{
			$insert_arr['friend_followstate'] = '2';//双方关注
		}
		$result = $friend_model->addFriend($insert_arr);
		if($result){
			//更新对方关注状态
			if(!empty($friend_info)){
				$friend_model->editFriend(array('friend_followstate'=>'2'),array('friend_id'=>"{$friend_info['friend_id']}"));
			}

			$return = json_encode(array('state'=>$insert_arr['friend_followstate']));
		}else{
			$return = 'false';
		}
		echo !empty($_GET['callback'])? $_GET['callback'].'('.$return.')' : $return ;exit;
	}
	/**
	 * 加关注
	 */
	public function delfollowOp() {
		$mid = intval($_GET['mid']);
		if($mid<=0){
			showDialog(Language::get('wrong_argument'),'','error');
		}
		//取消关注
		$friend_model = Model('sns_friend');
		$result = $friend_model->delFriend(array('friend_frommid'=>"{$_SESSION['member_id']}",'friend_tomid'=>"$mid"));
		if($result){
			//更新对方的关注状态
			$friend_model->editFriend(array('friend_followstate'=>'1'),array('friend_frommid'=>"$mid",'friend_tomid'=>"{$_SESSION['member_id']}"));
			$return = 'true';
		}else{
			$return = 'false';
		}
		echo !empty($_GET['callback'])? $_GET['callback'].'('.$return.')' : $return ;exit;
	}
	/**
	 * 批量加关注
	 */
	public function batch_addfollowOp() {
		// 验证参数
		if(trim($_GET['ids']) == ''){
			showDialog(Language::get('wrong_argument'), '', 'error');
		}
		$ids = explode(',', trim($_GET['ids']));
		if(empty($ids)){
			showDialog(Language::get('wrong_argument'), '', 'error');
		}

		// 实例化模型
		$model = Model();
		$member_info = $model->table('member')->find($_SESSION['member_id']);
		if(empty($member_info)){
			showDialog(Language::get('snsfriend_member_error'),'','error');
		}

		// 将被关注会员列表
		$pm_array = $model->table('member')->where(array('member_id'=>array('in', $ids)))->select();

		// 查询是否已经关注
		$gz_array	= $model->table('sns_friend')->where(array('friend_frommid'=>$_SESSION['member_id'], 'friend_tomid'=>array('in', $ids)))->select();
		$gz_array	= array_under_reset($gz_array, 'friend_tomid', 1);
		// 查询对方是否关注我
		$bgz_array	= $model->table('sns_friend')->where(array('friend_frommid'=>array('in', $ids), 'friend_tomid'=>$_SESSION['member_id']))->select();
		$bgz_array	= array_under_reset($bgz_array, 'friend_frommid', 1);

		if(!empty($pm_array)){
			$insert_array = array();
			foreach ($pm_array as $val){
				if(isset($gz_array[$val['member_id']]))			// 已关注跳出循环
					continue;
				if($val['member_id'] == $_SESSION['member_id'])	// 不关注自己
					continue;
				$insert = array();
				$insert['friend_frommid']		= $member_info['member_id'];
				$insert['friend_frommname']		= $member_info['member_name'];
				$insert['friend_frommavatar']	= $member_info['member_avatar'];
				$insert['friend_tomid']			= $val['member_id'];
				$insert['friend_tomname']		= $val['member_name'];
				$insert['friend_tomavatar']		= $val['member_avatar'];
				$insert['friend_addtime']		= time();
				if(isset($bgz_array[$val['member_id']])){
					$insert['friend_followstate']	= 2;
					$model->table('sns_friend')->update(array('friend_followstate'=>2, 'friend_id'=>$bgz_array[$val['member_id']]['friend_id']));
				}else{
					$insert['friend_followstate']	= 1;
				}
				$insert_array[]	= $insert;
			}
			// 插入
			$model->table('sns_friend')->insertAll($insert_array);
		}

		showDialog(Language::get('snsfriend_follow_succ'),'','succ');
	}
	/**
	 * 关注列表页面
	 */
	public function followOp() {
		$friend_model = Model('sns_friend');
		//关注列表
		$page	= new Page();
		$page->setEachNum(15);
		$page->setStyle('admin');
		$follow_list = $friend_model->listFriend(array('friend_frommid'=>"{$_SESSION['member_id']}"),'*',$page,'detail');
		if (!empty($follow_list)){
			foreach ($follow_list as $k=>$v){
				$v['sex_class'] = $this->m_sex($v['member_sex']);
				$follow_list[$k] = $v;
			}
		}
		Tpl::output('follow_list',$follow_list);
		Tpl::output('show_page',$page->show());
		self::profile_menu('follow');
		Tpl::showpage('member_snsfriend_follow');
	}
	/**
	 * 粉丝列表
	 */
	public function fanOp() {
		$friend_model = Model('sns_friend');
		//关注列表
		$page	= new Page();
		$page->setEachNum(15);
		$page->setStyle('admin');
		$fan_list = $friend_model->listFriend(array('friend_tomid'=>"{$_SESSION['member_id']}"),'*',$page,'fromdetail');
		if (!empty($fan_list)){
			foreach ($fan_list as $k=>$v){
				$v['sex_class'] = $this->m_sex($v['member_sex']);
				$fan_list[$k] = $v;
			}
		}
		Tpl::output('fan_list',$fan_list);
		Tpl::output('show_page',$page->show());
		self::profile_menu('fan');
		Tpl::showpage('member_snsfriend_fan');
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key) {
		$menu_array = array(
			1=>array('menu_key'=>'find',	'menu_name'=>Language::get('snsfriend_findmember'),	'menu_url'=>'index.php?act=member_snsfriend&op=find'),
			2=>array('menu_key'=>'follow',	'menu_name'=>Language::get('snsfriend_follow'),	'menu_url'=>'index.php?act=member_snsfriend&op=follow'),
			3=>array('menu_key'=>'fan',		'menu_name'=>Language::get('snsfriend_fans'),	'menu_url'=>'index.php?act=member_snsfriend&op=fan')
		);
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
