<?php
/**
 * 投诉
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class member_complainControl extends BaseMemberControl{
    //定义投诉状态常量
    const STATE_NEW = 10;
    const STATE_APPEAL = 20;
    const STATE_TALK = 30;
    const STATE_HANDLE = 40;
    const STATE_FINISH = 99;
    const STATE_UNACTIVE = 1;
    const STATE_ACTIVE = 2;

    public function __construct() {
        parent::__construct();
        Language::read('member_layout,member_member_index,member_complain');
    }

    /*
     * 我的投诉页面
     */
    public function indexOp() {
        $page = new Page();
        $page->setEachNum(10);
        $page->setStyle('admin');
        /*
         * 得到当前用户的投诉列表
         */
        $model_complain = Model('complain');
        $condition = array();
        $condition['order']        = 'complain_state asc,complain_id desc';
        $condition['accuser_id'] = $_SESSION['member_id'];
        switch(intval($_GET['select_complain_state'])) {
            case 1:
                $condition['progressing'] = 'true';
                break;
            case 2:
                $condition['finish'] = 'true';
                break;
            default :
                $condition['state'] = '';
        }
        $list = $model_complain->getComplain($condition, $page);
        $this->profile_menu('complain_accuser_list');
        Tpl::output('list', $list);
        Tpl::output('show_page', $page->show());
        $goods_list = $model_complain->getComplainGoodsList($list);
        Tpl::output('goods_list', $goods_list);
        Tpl::showpage('complain.list');
    }

    /*
     * 新投诉
     */
    public function complain_newOp() {
        $order_id = intval($_GET['order_id']);
        $goods_id = intval($_GET['goods_id']);//订单商品表编号
		if ($order_id < 1 || $goods_id < 1) {//参数验证
			showMessage(Language::get('wrong_argument'),'index.php?act=member_order&op=index','html','error');
		}
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$model_refund = Model('refund_return');
		$order_info = $model_refund->getRightOrderList($condition, $goods_id);
        //检查订单是否可以投诉
		$model_order = Model('order');
        $if_complain = $model_order->getOrderOperateState('complain',$order_info);
        if($if_complain < 1) {
            showMessage(Language::get('para_error'),'','html','error');
        }
        //检查是不是正在进行投诉
        if($this->check_complain_exist($goods_id)) {
            showMessage(Language::get('complain_repeat'),'','html','error');//'您已经投诉了该订单请等待处理'
        }

        //获取投诉类型
        $model_complain_subject = Model('complain_subject');
        $param = array();
        $complain_subject_list = $model_complain_subject->getActiveComplainSubject($param);
        if(empty($complain_subject_list)) {
            showMessage(Language::get('complain_subject_error'),'','html','error');
        }
        $model_refund = Model('refund_return');
        $order_info['extend_order_goods'] = $order_info['goods_list'];
        $order_list[$order_id] = $order_info;
        $order_list = $model_refund->getGoodsRefundList($order_list);
        if(intval($order_list[$order_id]['extend_complain'][$goods_id]) == 1) {//退款投诉
            $complain_subject = Model()->table('complain_subject')->where(array('complain_subject_id'=> 1))->select();//投诉主题
            $complain_subject_list = array_merge($complain_subject, $complain_subject_list);
        }
        Tpl::output('subject_list',$complain_subject_list);
        Tpl::output('goods_id',$goods_id);
        Tpl::showpage('complain.submit');
    }

    /*
     * 处理投诉请求
     */
    public function complain_showOp() {
        $complain_id = intval($_GET['complain_id']);
        //获取投诉详细信息
        $complain_info = $this->get_complain_info($complain_id);
        Tpl::output('complain_info',$complain_info);
        $complain_pic = array();
        $appeal_pic = array();
        for ($i = 1;$i <= 3;$i++) {
            if(!empty($complain_info['complain_pic'.$i])) {
                $complain_pic[$i] = $complain_info['complain_pic'.$i];
            }
            if(!empty($complain_info['appeal_pic'.$i])) {
                $appeal_pic[$i] = $complain_info['appeal_pic'.$i];
            }
        }
        Tpl::output('complain_pic',$complain_pic);
        Tpl::output('appeal_pic',$appeal_pic);
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $complain_info['order_id'];
		$model_refund = Model('refund_return');
		$model_refund->getRightOrderList($condition, $complain_info['order_goods_id']);
        Tpl::showpage('complain.info');
    }

    /*
     * 保存用户提交的投诉
     */
    public function complain_saveOp() {
        //获取输入的投诉信息
        $input = array();
        $input['order_id'] = intval($_POST['input_order_id']);
        $input['order_goods_id'] = intval($_POST['input_goods_id']);
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $input['order_id'];
		$model_order = Model('order');
		$order_info = $model_order->getOrderInfo($condition);
        $if_complain = $model_order->getOrderOperateState('complain',$order_info);//检查订单是否可以投诉
        if($if_complain < 1) {
            showDialog(Language::get('para_error'),'index.php?act=member_order&op=index','error');
        }
        //检查是不是正在进行投诉
        if($this->check_complain_exist($input['order_goods_id'])) {
            showDialog(Language::get('complain_repeat'),'','error');
        }
        list($input['complain_subject_id'],$input['complain_subject_content']) = explode(',',trim($_POST['input_complain_subject']));
        $input['complain_content'] = trim($_POST['input_complain_content']);
        $input['accuser_id'] = $order_info['buyer_id'];
        $input['accuser_name'] = $order_info['buyer_name'];
        $input['accused_id'] = $order_info['store_id'];
        $input['accused_name'] = $order_info['store_name'];
        $input['complain_datetime'] = time();
        $input['complain_state'] = self::STATE_NEW;
        $input['complain_active'] = self::STATE_UNACTIVE;
        $pic_name = $this->upload_pic();//上传图片
        $input['complain_pic1'] = $pic_name[1];
        $input['complain_pic2'] = $pic_name[2];
        $input['complain_pic3'] = $pic_name[3];

        $model_complain = Model('complain');
        $state = $model_complain->saveComplain($input);//保存投诉信息
		if ($state) {
			showDialog(Language::get('complain_submit_success'),'index.php?act=member_complain&op=index','succ');
		} else {
			showDialog(Language::get('nc_common_save_fail'),'reload','error');
		}
    }

    /*
     * 保存用户提交的补充证据
     */
    public function complain_add_picOp() {
    	$complain_id = intval($_GET['complain_id']);
    	//获取投诉详细信息
        $complain_info = $this->get_complain_info($complain_id);
    	if (chksubmit()){
            $where_array = array();
            $where_array['complain_id'] = $complain_id;
            //获取输入的投诉信息
            $input = array();
            $pic_name = $this->upload_pic($complain_pic);
            $input['complain_pic1'] = $pic_name[1];
            $input['complain_pic2'] = $pic_name[2];
            $input['complain_pic3'] = $pic_name[3];
            //保存投诉信息
            $model_complain = Model('complain');
            $model_complain->updateComplain($input,$where_array);
            showDialog(Language::get('nc_common_save_succ'),'reload','succ');
    	}
    }

    /*
     * 取消用户提交的投诉
     */
    public function complain_cancelOp() {
        $complain_id = intval($_GET['complain_id']);
        $complain_info = $this->get_complain_info($complain_id);
        if(intval($complain_info['complain_state']) === 10) {
            $pics = array();
            if(!empty($complain_info['complain_pic1'])) $pics[] = $complain_info['complain_pic1'];
            if(!empty($complain_info['complain_pic2'])) $pics[] = $complain_info['complain_pic2'];
            if(!empty($complain_info['complain_pic3'])) $pics[] = $complain_info['complain_pic3'];
            if(!empty($pics)) {//删除图片
                foreach($pics as $pic) {
                    $pic = BASE_UPLOAD_PATH.DS.ATTACH_PATH.DS.'complain'.DS.$pic;
                    if(file_exists($pic)) {
                        @unlink($pic);
                    }
                }
            }
            $model_complain = Model('complain');
            $model_complain->dropComplain(array('complain_id' => $complain_id));
            showDialog(Language::get('complain_cancel_success'),'reload','succ');
        } else {
        	showDialog(Language::get('complain_cancel_fail'),'','error');
        }
    }
    /*
     * 处理用户申请仲裁
     */
    public function apply_handleOp() {
        $complain_id = intval($_POST['input_complain_id']);
        //获取投诉详细信息
        $complain_info = $this->get_complain_info($complain_id);
        $complain_state = intval($complain_info['complain_state']);
        //检查当前是不是投诉状态
        if($complain_state < self::STATE_TALK || $complain_state === 99) {
            showMessage(Language::get('para_error'),'','html','error');
        }
        $update_array = array();
        $update_array['complain_state'] = self::STATE_HANDLE;
        $where_array = array();
        $where_array['complain_id'] = $complain_id;
        //保存投诉信息
        $model_complain = Model('complain');
        $complain_id = $model_complain->updateComplain($update_array,$where_array);
        showMessage(Language::get('handle_submit_success'),'index.php?act=member_complain');
    }

    /*
     * 根据投诉id获取投诉对话
     */
    public function get_complain_talkOp() {
        $complain_id = intval($_POST['complain_id']);
        $complain_info = $this->get_complain_info($complain_id);
        $model_complain_talk = Model('complain_talk');
        $param = array();
        $param['complain_id'] = $complain_id;
        $complain_talk_list = $model_complain_talk->getComplainTalk($param);
        $talk_list = array();
        $i=0;
        foreach($complain_talk_list as $talk) {
            $talk_list[$i]['css'] = $talk['talk_member_type'];
            $talk_list[$i]['talk'] = date("Y-m-d H:i:s",$talk['talk_datetime']);
            switch($talk['talk_member_type']){
            case 'accuser':
                $talk_list[$i]['talk'] .= Language::get('complain_accuser');
                break;
            case 'accused':
                $talk_list[$i]['talk'] .= Language::get('complain_accused');
                break;
            case 'admin':
                $talk_list[$i]['talk'] .= Language::get('complain_admin');
                break;
            default:
                $talk_list[$i]['talk'] .= Language::get('complain_unknow');
            }
            if(intval($talk['talk_state']) === 2) {
                $talk['talk_content'] = Language::get('talk_forbit_message');
            }
            $talk_list[$i]['talk'].= '('.$talk['talk_member_name'].')'.Language::get('complain_text_say').':'.$talk['talk_content'];
            $i++;
        }
        if (strtoupper(CHARSET) == 'GBK') {
            $talk_list = Language::getUTF8($talk_list);
        }
        echo json_encode($talk_list);
    }

    /*
     * 根据发布投诉对话
     */
    public function publish_complain_talkOp() {
        $complain_id = intval($_POST['complain_id']);
        $complain_talk = trim($_POST['complain_talk']);
        $talk_len = strlen($complain_talk);
        if($talk_len > 0 && $talk_len < 255) {
            $complain_info = $this->get_complain_info($complain_id);
            $complain_state = intval($complain_info['complain_state']);
            //检查投诉是否是可发布对话状态
            if($complain_state > self::STATE_APPEAL && $complain_state < self::STATE_FINISH) {
                $model_complain_talk = Model('complain_talk');
                $param = array();
                $param['complain_id'] = $complain_id;
                $param['talk_member_id'] = $complain_info['accuser_id'];
                $param['talk_member_name'] = $complain_info['accuser_name'];
                $param['talk_member_type'] = $complain_info['member_status'];
                if (strtoupper(CHARSET) == 'GBK') {
                    $complain_talk = Language::getGBK($complain_talk);
                }
                $param['talk_content'] = $complain_talk;
                $param['talk_state'] =1;
                $param['talk_admin'] = 0;
                $param['talk_datetime'] = time();
                if($model_complain_talk->saveComplainTalk($param)) {
                    echo json_encode('success');
                } else {
                    echo json_encode('error2');
                }
            } else {
                echo json_encode('error');
            }
        } else {
            echo json_encode('error1');
        }
    }

    /*
     * 获取投诉信息
     */
    private function get_complain_info($complain_id) {
        $model_complain = Model('complain');
        $complain_info = $model_complain->getoneComplain($complain_id);
        if($complain_info['accuser_id'] != $_SESSION['member_id']) {
            showMessage(Language::get('para_error'),'','html','error');
        }
        $complain_info['member_status'] = 'accuser';
        $complain_info['complain_state_text'] = $this->get_complain_state_text($complain_info['complain_state']);
        return $complain_info;
    }

    /*
     * 检查投诉是否已经存在
     */
    private function check_complain_exist($goods_id) {
        $model_complain = Model('complain');
        $param = array();
        $param['order_goods_id'] = $goods_id;
        $param['accuser_id'] = $_SESSION['member_id'];
        $param['progressing'] = 'ture';
        return $model_complain->isExist($param);
    }

    /*
     * 获得投诉状态文本
     */
    private function get_complain_state_text($complain_state) {
        switch(intval($complain_state)) {
        case self::STATE_NEW:
            return Language::get('complain_state_new');
            break;
        case self::STATE_APPEAL:
            return Language::get('complain_state_appeal');
            break;
        case self::STATE_TALK:
            return Language::get('complain_state_talk');
            break;
        case self::STATE_HANDLE:
            return Language::get('complain_state_handle');
            break;
        case self::STATE_FINISH:
            return Language::get('complain_state_finish');
            break;
        default:
            showMessage(Language::get('para_error'),'','html','error');
        }
    }

    private function upload_pic() {
        $complain_pic = array();
        $complain_pic[1] = 'input_complain_pic1';
        $complain_pic[2] = 'input_complain_pic2';
        $complain_pic[3] = 'input_complain_pic3';
        $pic_name = array();
        $upload = new UploadFile();
        $uploaddir = ATTACH_PATH.DS.'complain'.DS;
        $upload->set('default_dir',$uploaddir);
        $upload->set('allow_type',array('jpg','jpeg','gif','png'));
        $count = 1;
        foreach($complain_pic as $pic) {
            if (!empty($_FILES[$pic]['name'])){
                $result = $upload->upfile($pic);
                if ($result){
                    $pic_name[$count] = $upload->file_name;
                    $upload->file_name = '';
                } else {
                    $pic_name[$count] = '';
                }
            }
            $count++;
        }
        return $pic_name;
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
            array('menu_key'=>'complain_accuser_list','menu_name'=>Language::get('complain_manage_title'),'menu_url'=>'index.php?act=member_complain')
        );
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
