<?php
/**
 * 代金券
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class member_informControl extends BaseMemberControl{

	public function __construct() {

		parent::__construct() ;

		/**
		 * 读取语言包
		 */
		Language::read('member_layout,member_inform');

        //定义状态常量
	}

	/*
	 * 默认显示我的举报页面
	 */
	public function indexOp() {

        $this->inform_listOp() ;
    }

	/*
	 * 获取当前用户的举报列表
	 */
    public function inform_listOp() {

		/*
		 * 生成分页
		 */
		$page = new Page() ;
		$page->setEachNum(10);
		$page->setStyle('admin') ;

        /*
		 * 得到当前用户的举报列表
		 */
		$model_inform = Model('inform') ;
        $condition = array();
        $condition['inform_state'] = intval($_GET['select_inform_state']);
        $condition['inform_member_id'] = $_SESSION['member_id'];
        $condition['order']        = 'inform_id desc';
		$list = $model_inform->getInform($condition, $page) ;
        $this->profile_menu('inform_list');
        Tpl::output('list', $list) ;
        Tpl::output('show_page', $page->show()) ;
        Tpl::showpage('member_inform.list');
    }

    /*
     * 提交举报商品
     */
    public function inform_submitOp() {

        //检查当前用户是否允许举报
        $this->check_member_allow_inform();

        $goods_id = intval($_GET['goods_id']);

        //获取商品详细信息
        $goods_info = $this->get_goods_info_byid($goods_id);

        //检查是否是本店商品
        if(!empty($_SESSION['store_id'])) {
            if ($goods_info['store_id'] == $_SESSION['store_id']) {
                showMessage(Language::get('para_error'),'','html','error');
            }
        }

        $model_inform = Model('inform');
        //检查是否当前正在举报
        if($model_inform->isProcessOfInform($goods_id)) {
           showMessage(Language::get('inform_handling'),'','html','error');
        }

        //获取举报类型
        $model_inform_subject_type = Model('inform_subject_type');
        $inform_subject_type_list = $model_inform_subject_type->getActiveInformSubjectType();
        if(empty($inform_subject_type_list)) {
            showMessage(Language::get('inform_type_null'),'','html','error');
        }
        $this->profile_menu('inform_list');

        Tpl::output('goods_info',$goods_info);
        Tpl::output('type_list',$inform_subject_type_list);
        Tpl::showpage('member_inform.submit');
    }

    /*
     * 保存用户提交的商品举报
     */
    public function inform_saveOp() {

        //检查当前用户是否允许举报
        $this->check_member_allow_inform();

        $goods_id = intval($_POST['inform_goods_id']);

        //获取商品详细信息
        $goods_info = $this->get_goods_info_byid($goods_id);

        //检查是否是本店商品
        if(!empty($_SESSION['store_id'])) {
            if ($goods_info['store_id'] == $_SESSION['store_id']) {
            	showDialog(Language::get('para_error'));
            }
        }

        //实例化举报模型
        $model_inform = Model('inform');
        //检查是否当前正在举报
        if($model_inform->isProcessOfInform($goods_id)) {
           showDialog(Language::get('inform_handling'));
        }
        //处理用户输入的数据
        $input = array();
        $input['inform_member_id'] = $_SESSION['member_id'];
        $input['inform_member_name'] = $_SESSION['member_name'];
        $input['inform_goods_id'] = $goods_id;
        $input['inform_goods_name'] = $goods_info['goods_name'];
        $input['inform_goods_image'] = $goods_info['goods_image'];
        list($input['inform_subject_id'],$input['inform_subject_content']) = explode(",",trim($_POST['inform_subject']));
        $input['inform_content'] = trim($_POST['inform_content']);

        //上传图片
        $inform_pic = array();
        $inform_pic[1] = 'inform_pic1';
        $inform_pic[2] = 'inform_pic2';
        $inform_pic[3] = 'inform_pic3';
        $pic_name = $this->inform_upload_pic($inform_pic);
        $input['inform_pic1'] = $pic_name[1];
        $input['inform_pic2'] = $pic_name[2];
        $input['inform_pic3'] = $pic_name[3];

        $input['inform_datetime'] = time();
        $input['inform_store_id'] = $goods_info['store_id'];
        $input['inform_store_name'] = $goods_info['store_name'];
        $input['inform_state'] = 1;
        $input['inform_handle_message'] = '';
        $input['inform_handle_member_id'] = 0;
        $input['inform_handle_datetime'] = 1;

        //验证输入的数据
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array("input"=>$input["inform_content"], "require"=>"true","validator"=>"Length","min"=>"1","max"=>"100","message"=>Language::get('inform_content_null')),
            array("input"=>$input["inform_subject_content"], "require"=>"true", "validator"=>"Length","min"=>"1","max"=>"50","message"=>Language::get('para_error')),
        );
        $error = $obj_validate->validate();
        if ($error != ''){
        	showValidateError($error);
        }

        //保存
        if($model_inform->saveInform($input)) {
            showDialog(Language::get('inform_success'),'index.php?act=member_inform&op=inform_list','succ');
        }
        else {
            showDialog(Language::get('inform_fail'),'index.php?act=member_inform&op=inform_list','error');
        }
    }


    /*
     * 取消用户提交的商品举报
     */
    public function inform_cancelOp() {

        $inform_id = intval($_GET['inform_id']);
        $inform_info = $this->get_inform_info($inform_id);

        if(intval($inform_info['inform_state']) === 1) {
            $pics = array();
            if(!empty($inform_info['inform_pic1'])) $pics[] = $inform_info['inform_pic1'];
            if(!empty($inform_info['inform_pic2'])) $pics[] = $inform_info['inform_pic2'];
            if(!empty($inform_info['inform_pic3'])) $pics[] = $inform_info['inform_pic3'];
            $this->drop_inform($inform_id,$pics);
            showDialog(Language::get('inform_cancel_success'),'reload','succ');
        }
        else {
            showDialog(Language::get('inform_cancel_fail'),'','error');
        }
    }


    /**
     * 商品举报详细
     */
    public function inform_infoOp() {

        $inform_id = intval($_GET['inform_id']);
        $inform_info = $this->get_inform_info($inform_id);
        Tpl::output('inform_info', $inform_info);
        // 商品信息
        $goods_info = Model('goods')->getGoodsInfoByID($inform_info['inform_goods_id']);
        Tpl::output('goods_info', $goods_info);
        // 投诉类型
        $subject_info = Model('inform_subject')->getInformSubject(array('in_inform_subject_id' => $inform_info['inform_subject_id']));
        Tpl::output('subject_info', $subject_info[0]);
        Tpl::showpage('member_inform.info');
    }



    /*
     * 根据id获取投诉详细信息
     */
    private function get_inform_info($inform_id) {

        if (empty($inform_id)) {
            showMessage(Language::get('para_error'),'','html','error');
        }

        $model_inform = Model('inform');
        $inform_info = $model_inform->getoneInform($inform_id);

        if(empty($inform_info)) {
            showMessage(Language::get('para_error'),'','html','error');
        }

        if(intval($inform_info['inform_member_id']) !== intval($_SESSION['member_id'])) {
            showMessage(Language::get('para_error'),'','html','error');
        }

        return $inform_info;

    }


    /*
     * 根据id获取投诉详细信息
     */
    private function drop_inform($inform_id,$inform_pics) {

        $model_inform = Model('inform');
        //删除图片
        if(!empty($inform_pics)) {
            foreach($inform_pics as $pic) {
                $this->inform_delete_pic($pic);
            }
        }
        $model_inform->dropInform(array('inform_id' => $inform_id));
    }

    /*
     * 根据id获取商品详细信息
     */
    private function get_goods_info_byid($goods_id) {

        if(empty($goods_id)) {
            showMessage(Language::get('para_error'),'','html','error');
        }

        $model_goods = Model('goods');
        $goods_info = $model_goods->getGoodsOnlineInfoByID($goods_id);

        //检查该商品是否存在
        if(empty($goods_info)) {
            showMessage(Language::get('goods_null'),'','html','error');
        }
        return $goods_info;
    }


    /*
     * 检查当前用户是否允许举报
     */
    private function check_member_allow_inform() {

        //检查是否允许举报
        $model_member = Model('member');
        if(!$model_member->isMemberAllowInform($_SESSION['member_id'])) {
            showMessage(Language::get('deny_inform'),'','html','error');
        }
    }

    /*
     * 上传用户提供的举报图片
     */
    private function inform_upload_pic($inform_pic) {

        $pic_name = array();
        $upload = new UploadFile();
        $uploaddir = ATTACH_PATH.DS.'inform'.DS;
        $upload->set('default_dir',$uploaddir);
        $upload->set('allow_type',array('jpg','jpeg','gif','png'));
        $count = 1;
        foreach($inform_pic as $pic) {
            if (!empty($_FILES[$pic]['name'])){
                $result = $upload->upfile($pic);
                if ($result){
                    $pic_name[$count] = $upload->file_name;
                    $upload->file_name = '';
                }
                else {
                    $pic_name[$count] = '';
                }
            }
            $count++;
        }
        return $pic_name;

    }

    /*
     * 上传用户提供的举报图片
     */
    private function inform_delete_pic($pic_name) {

        //上传路径
        $pic = BASE_UPLOAD_PATH.DS.ATTACH_PATH.DS.'inform'.DS.$pic_name;
        if(file_exists($pic)) {
            @unlink($pic);
        }

    }


    /*
     * 获取文件名
     */
    private function get_pic_filename() {
        return date('Ymd').substr(implode(NULL,array_map('ord',str_split(substr(uniqid(),7,13),1))) , -8 , 8);
    }


    /*
     * 根据举报类型id获取，举报具体列表
     */
    public function get_subject_by_typeidOp() {

        $inform_subject_type_id = trim($_POST['typeid']);
        if(empty($inform_subject_type_id)) {
            echo '';
        }
        else {
            /*
             * 获得举报主题列表
             */
            $model_inform_subject = Model('inform_subject') ;

            //搜索条件
            $condition = array();
            $condition['order'] = 'inform_subject_id asc';
            $condition['inform_subject_type_id'] = $inform_subject_type_id;
            $condition['inform_subject_state'] = 1;
            $inform_subject_list = $model_inform_subject->getInformSubject($condition,$page,'inform_subject_id,inform_subject_content') ;
            if (strtoupper(CHARSET) == 'GBK'){
                $inform_subject_list = Language::getUTF8($inform_subject_list);
		        }
            echo json_encode($inform_subject_list);

        }
    }


	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @param array 	$array		附加菜单
	 * @return
	 */
	private function profile_menu($menu_key='') {
		$menu_array = array(
			1=>array('menu_key'=>'inform_list','menu_name'=>'违规举报', 'menu_url'=>'index.php?act=member_inform&op=inform_list'),
		);
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
    }

}
