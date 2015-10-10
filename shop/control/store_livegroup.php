<?php
/**
 * 商家中心抢购管理
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class store_livegroupControl extends BaseSellerControl {

    public function __construct() {
        parent::__construct();
        //读取语言包
        Language::read('member_live');
    }

    /**
     * 默认显示抢购列表
     **/
    public function indexOp() {
        $this->store_livegroupOp();
    }


    /*
     * 抢购列表
     */
	public function store_livegroupOp(){
		$condition 		= array();
		$condition['store_id'] = $_SESSION['store_id'];

		if(isset($_GET['txt_keyword']) && !empty($_GET['txt_keyword'])){
			$condition['groupbuy_name'] = array('like',"%{$_GET['txt_keyword']}%");
		}

		if(isset($_GET['is_audit']) && !empty($_GET['is_audit'])){
			$condition['is_audit'] = intval($_GET['is_audit']);
		}

		$model_live_groupbuy = Model('live_groupbuy');
		$list = $model_live_groupbuy->getList($condition);

		Tpl::output('list',$list);
		Tpl::output('show_page',$model_live_groupbuy->showpage('5'));

		$this->profile_menu('store_livegroupbuy');
		Tpl::showpage('store_livegroupbuy');
	}

	/*
	 * 新增抢购
	 */
	public function groupbuy_addOp(){
		if(chksubmit()){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>trim($_POST["groupbuy_name"]),"require"=>"true","message"=>'抢购名称不能为空'),
				array("input"=>trim($_POST["start_time"]),"require"=>"true","message"=>'开始时间不能为空'),
				array("input"=>trim($_POST["end_time"]),"require"=>"true","message"=>'结束时间不能为空'),
			    array("input"=>trim($_POST["validity"]),"require"=>"true","message"=>'有效期时间不能为空'),
				array("input"=>trim($_POST["original_price"]),"require"=>"true","message"=>'原价不能为空'),
				array("input"=>trim($_POST["groupbuy_price"]),"require"=>"true","message"=>'抢购价格不能为空'),
				array("input"=>trim($_POST["buyer_count"]),"require"=>"true","message"=>'购抢数量不能为空'),
				array("input"=>trim($_POST["buyer_limit"]),"require"=>"true","message"=>'购买上线不能为空'),
				array("input"=>intval($_POST["city"]),"require"=>"true","message"=>'城市不能为空'),
				array("input"=>intval($_POST["area"]),"require"=>"true","message"=>'区域不能为空'),
				array("input"=>intval($_POST["mall"]),"require"=>"true","message"=>'商区不能为空'),
				array("input"=>intval($_POST["class"]),"require"=>"true","message"=>'分类不能为空'),
				array("input"=>intval($_POST["s_class"]),"require"=>"true","message"=>'分类不能为空'),
			);
			$error = $obj_validate->validate();
			
			//结束时间大于开始时间
			if (strtotime($_POST["end_time"]) > 0 && strtotime($_POST["end_time"]) <= strtotime($_POST["start_time"])){
			    $error .= "<br>抢购结束时间应大于抢购开始时间";
			}
			//活动有效期应大于抢购结束时间
			if (strtotime($_POST["validity"]) > 0 && strtotime($_POST["validity"]) <= strtotime($_POST["end_time"])){
			    $error .= "<br>活动有效期应大于抢购结束时间";
			}
			//抢购价格应小于原价
			$original_price = floatval(trim($_POST["original_price"]));
			$groupbuy_price = floatval(trim($_POST["groupbuy_price"]));
			if ($groupbuy_price && $groupbuy_price >= $original_price){
			    $error .= "<br>抢购价格应小于原价";
			}
			//购买上限应小于抢购数量
			$buyer_count = intval(trim($_POST["buyer_count"]));
			$buyer_limit = intval(trim($_POST["buyer_limit"]));
			if ($buyer_count < 0 || $buyer_count > 1000000){
			    $error .= "<br>抢购数量数值区间0~1000000";
			}
			if ($buyer_limit < 1){
			    $error .= "<br>购买上限应大于等于1";
			}elseif ($buyer_limit && $buyer_limit >= $buyer_count){
			    $error .= "<br>购买上限应小于抢购数量";
			}
			
			if ($error != ''){
				showMessage(Language::get('error').$error,'','html','error');
			}

			$params = array();
			$params['groupbuy_name'] = trim($_POST['groupbuy_name']);
			$params['groupbuy_remark'] = trim($_POST['remark']);
			$params['start_time']	= strtotime($_POST['start_time']);
			$params['end_time']		= strtotime($_POST['end_time']);
			$params['validity']		= strtotime($_POST['validity']);
			$params['store_id']		= $_SESSION['store_id'];
			$params['store_name']	= $_SESSION['store_name'];
			$params['original_price'] = $_POST['original_price'];
			$params['groupbuy_price'] = $_POST['groupbuy_price'];
			$params['buyer_count']	= intval($_POST['buyer_count']);
			$params['buyer_limit']  = intval($_POST['buyer_limit']);
			$params['groupbuy_intro'] = $_POST['groupbuy_intro'];
			$params['groupbuy_pic'] = $_POST['groupbuy_image'];
			$params['groupbuy_pic1']= $_POST['groupbuy_image1'];
			$params['publish_time'] = time();
			$params['city_id'] = intval($_POST['city']);
			$params['area_id'] = intval($_POST['area']);
			$params['mall_id'] = intval($_POST['mall']);
			$params['class_id']= intval($_POST['class']);
			$params['s_class_id'] = intval($_POST['s_class']);

			$model_live_groupbuy = Model('live_groupbuy');
			$res = $model_live_groupbuy->add($params);

			if($res){
				showMessage('添加成功','index.php?act=store_livegroup&op=store_livegroup','','succ');
			}else{
				showMessage('添加失败','','','error');
			}
		}

		$model_live_class = Model('live_class');
		$classlist = $model_live_class->getList(array('parent_class_id'=>0));
		Tpl::output('classlist',$classlist);//抢购分类

		$model_live_area = Model('live_area');
		$arealist = $model_live_area->getList(array('parent_area_id'=>0,'hot_city'=>1),'','100');
		Tpl::output('arealist',$arealist);//区域分类

		$this->profile_menu('store_livegroupbuyadd');
		Tpl::showpage('store_livegroupbuy.add');
	}

	/*
	 * 编辑抢购
	 */
	public function edit_livegroupbuyOp(){
		if(chksubmit()){//数据验证
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>trim($_POST["groupbuy_name"]),"require"=>"true","message"=>'抢购名称不能为空'),
					array("input"=>trim($_POST["start_time"]),"require"=>"true","message"=>'开始时间不能为空'),
					array("input"=>trim($_POST["end_time"]),"require"=>"true","message"=>'结束时间不能为空'),
			        array("input"=>trim($_POST["validity"]),"require"=>"true","message"=>'有效期时间不能为空'),
					array("input"=>trim($_POST["original_price"]),"require"=>"true","message"=>'原价不能为空'),
					array("input"=>trim($_POST["groupbuy_price"]),"require"=>"true","message"=>'抢购价格不能为空'),
					array("input"=>trim($_POST["buyer_count"]),"require"=>"true","message"=>'购抢数量不能为空'),
					array("input"=>trim($_POST["buyer_limit"]),"require"=>"true","message"=>'购买上线不能为空'),
					array("input"=>intval($_POST["city"]),"require"=>"true","message"=>'城市不能为空'),
					array("input"=>intval($_POST["area"]),"require"=>"true","message"=>'区域不能为空'),
					array("input"=>intval($_POST["mall"]),"require"=>"true","message"=>'商区不能为空'),
					array("input"=>intval($_POST["class"]),"require"=>"true","message"=>'分类不能为空'),
					array("input"=>intval($_POST["s_class"]),"require"=>"true","message"=>'分类不能为空'),
			);
			$error = $obj_validate->validate();
			
			//结束时间大于开始时间
			if (strtotime($_POST["end_time"]) > 0 && strtotime($_POST["end_time"]) <= strtotime($_POST["start_time"])){
			    $error .= "<br>抢购结束时间应大于抢购开始时间";
			}
			//活动有效期应大于抢购结束时间
			if (strtotime($_POST["validity"]) > 0 && strtotime($_POST["validity"]) <= strtotime($_POST["end_time"])){
			    $error .= "<br>活动有效期应大于抢购结束时间";
			}
			//抢购价格应小于原价
			$original_price = floatval(trim($_POST["original_price"]));
			$groupbuy_price = floatval(trim($_POST["groupbuy_price"]));
			if ($groupbuy_price && $groupbuy_price >= $original_price){
			    $error .= "<br>抢购价格应小于原价";
			}
			//购买上限应小于抢购数量
			$buyer_count = intval(trim($_POST["buyer_count"]));
			$buyer_limit = intval(trim($_POST["buyer_limit"]));
			if ($buyer_count < 0 || $buyer_count > 1000000){
			    $error .= "<br>抢购数量数值区间0~1000000";
			}
			if ($buyer_limit < 1){
			    $error .= "<br>购买上限应大于等于1";
			}elseif ($buyer_limit && $buyer_limit >= $buyer_count){
			    $error .= "<br>购买上限应小于抢购数量";
			}
			
			if ($error != ''){
				showMessage(Language::get('error').$error,'','html','error');
			}

			$params = array();
			$params['groupbuy_name'] = trim($_POST['groupbuy_name']);
			$params['groupbuy_remark'] = trim($_POST['remark']);
			$params['start_time']	= strtotime($_POST['start_time']);
			$params['end_time']		= strtotime($_POST['end_time']);
			$params['validity']		= strtotime($_POST['validity']);
			$params['store_id']		= $_SESSION['store_id'];
			$params['store_name']	= $_SESSION['store_name'];
			$params['original_price'] = $_POST['original_price'];
			$params['groupbuy_price'] = $_POST['groupbuy_price'];
			$params['buyer_count']	= intval($_POST['buyer_count']);
			$params['buyer_limit']  = intval($_POST['buyer_limit']);
			$params['groupbuy_intro'] = $_POST['groupbuy_intro'];
			if(!empty($_POST['groupbuy_image'])){
				$params['groupbuy_pic'] = $_POST['groupbuy_image'];
			}
			if(!empty($_POST['groupbuy_image1'])){
				$params['groupbuy_pic1']= $_POST['groupbuy_image1'];
			}
			$params['publish_time'] = time();
			$params['city_id'] = intval($_POST['city']);
			$params['area_id'] = intval($_POST['area']);
			$params['mall_id'] = intval($_POST['mall']);
			$params['class_id']= intval($_POST['class']);
			$params['s_class_id'] = intval($_POST['s_class']);
			$params['is_audit']= 1;//1.待审核

			$condition = array();
			$condition['groupbuy_id'] = intval($_POST['groupbuy_id']);
			$condition['store_id']	  = $_SESSION['store_id'];

			$model_live_groupbuy = Model('live_groupbuy');
			$res = $model_live_groupbuy->edit($condition,$params);
			if($res){
				showMessage('编辑成功','index.php?act=store_livegroup&op=store_livegroup','','succ');
			}else{
				showMessage('编辑失败','index.php?act=store_livegroup&op=store_livegroup','','error');
			}
		}


		$condition = array();
		$condition['groupbuy_id'] = intval($_GET['groupbuy_id']);
		$condition['store_id']	  = $_SESSION['store_id'];

		$model_live_groupbuy = Model('live_groupbuy');
		$groupbuy = $model_live_groupbuy->live_groupbuyInfo($condition);
		if(empty($groupbuy)){
			showMessage('抢购不存在');
		}

		if($groupbuy['is_audit'] == 2){//2.审核通过
			showMessage('该抢购审核通过，不能更改');
		}
		Tpl::output('groupbuy',$groupbuy);

		$model_live_class = Model('live_class');
		$classlist = $model_live_class->getList(array('parent_class_id'=>0));
		Tpl::output('classlist',$classlist);//抢购分类


		//城市
		$model_area = Model('live_area');
		$city_list = $model_area->getList(array('parent_area_id'=>0),'','1000');
		Tpl::output('city_list',$city_list);

		//区域
		$area_list = $model_area->getList(array('parent_area_id'=>$groupbuy['city_id']),'','1000');
		Tpl::output('area_list',$area_list);

		//商区
		$mall_list = $model_area->getList(array('parent_area_id'=>$groupbuy['area_id']),'','1000');
		Tpl::output('mall_list',$mall_list);

		$this->profile_menu('store_livegroupbuyedit');
		Tpl::showpage('store_livegroupbuy.edit');
	}

	/*
	 * 抢购删除
	 */
	public function delgroupOp(){
		$model = Model();
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['groupbuy_id'] = intval($_GET['groupbuy_id']);

		$model_live_groupbuy = Model('live_groupbuy');
		$groupbuy = $model_live_groupbuy->live_groupbuyInfo($condition);

		if(empty($groupbuy)){
			showMessage('抢购不存在');
		}

		if($groupbuy['is_audit'] == 2){//2.审核通过
			showMessage('该抢购审核通过，不能更改');
		}

		$res = $model_live_groupbuy->del(array('groupbuy_id'=>$groupbuy['groupbuy_id']));
		if($res){
			showMessage('删除成功','','','succ');
		}else{
			showMessage('删除失败','','','error');
		}
	}


	/*
	 * ajax 请求
	 */
	public function ajaxOp(){

		//获得请求类型
		$type	=	trim($_GET['type']);
		if(empty($type)){
			echo 'false';exit;
		}

		if($type == 'area'){
			//区域ajax请求
			$area_id = intval($_GET['area_id']);
			if(empty($area_id)){
				echo 'false';exit;
			}
			$condition		= array();
			$condition['parent_area_id']	= $area_id;

			$model_live_area = Model('live_area');
			$area_list = $model_live_area->getList($condition);

			if(!empty($area_list)){
				echo json_encode($area_list);
			}else{
				echo 'false';
			}
		}elseif($type == 'class'){
			//分类ajax请求
			$class_id = intval($_GET['class_id']);
			if(empty($class_id)){
				echo 'false';exit;
			}

			$condition		= array();
			$condition['parent_class_id']	= $class_id;

			$model_live_class = Model('live_class');
			$class_list = $model_live_class->getList($condition);

			if(!empty($class_list)){
				echo json_encode($class_list);
			}else{
				echo 'false';
			}
		}else{
			echo 'false';
		}
		exit;
	}

	/**
	 * 上传图片
	 **/
	public function image_uploadOp() {
		if(!empty($_POST['old_groupbuy_image'])) {
			$this->_image_del($_POST['old_groupbuy_image']);
		}

		$file = 'groupbuy_image';
		$data = array();
		$data['result'] = true;
		if(!empty($_FILES[$file]['name'])) {
			$upload	= new UploadFile();
			$uploaddir = ATTACH_PATH.DS.'livegroupbuy'.DS.$_SESSION['store_id'].DS;
			$upload->set('default_dir', $uploaddir);
			$upload->set('thumb_width',	'480,296,168');
			$upload->set('thumb_height', '480,296,168');
			$upload->set('thumb_ext', '_max,_mid,_small');
			$upload->set('fprefix', $_SESSION['store_id']);
			$result = $upload->upfile($file);
			if($result) {
				$data['file_name'] = $upload->file_name;
				$data['origin_file_name'] = $_FILES[$file]['name'];
				$data['file_url'] = lgthumb($upload->file_name, 'mid');
			} else {
				$data['result'] = false;
				$data['message'] = $upload->error;
			}
		} else {
			$data['result'] = false;
		}
		echo json_encode($data);die;
	}


	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key='') {
		$menu_array	= array(
			array('menu_key'=>'store_livegroupbuy','menu_name'=>'线下抢列表','menu_url'=>'index.php?act=store_livegroup&op=groupbuy'),
		);
		switch($menu_key){
			case 'store_livegroupbuyadd':
				$menu_array[]=array('menu_key'=>'store_livegroupbuyadd','menu_name'=>'新增线下抢','menu_url'=>'index.php?act=store_livegroup&op=groupbuy_add');
				break;
			case 'store_livegroupbuyedit':
				$menu_array[]=array('menu_key'=>'store_livegroupbuyedit','menu_name'=>'编辑线下抢','menu_url'=>'');
				break;
		}

		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
