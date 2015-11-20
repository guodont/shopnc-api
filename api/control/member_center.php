<?php
/**
 * 会员中心接口
 * @author guodont
 *
 */

defined('InShopNC') or exit('Access Invalid!');

class member_centerControl extends apiMemberControl
{

    private $member_id;

    public function __construct()
    {
        parent::__construct();
        $this->member_id = $this->member_info['member_id'];
    }

    /**
     * GET 加关注
     */
    public function addfollowOp()
    {

        $mid = intval($_GET['mid']);
        if ($mid <= 0) {
            output_error("用户id错误");
        }
        //验证会员信息
        $member_model = Model('member');
        $condition_arr = array();
        $condition_arr['member_state'] = "1";
        $condition_arr['member_id'] = array('in', array($mid, $this->member_id));
        $member_list = $member_model->getMemberList($condition_arr);
        unset($condition_arr);
        if (empty($member_list)) {
            output_error("关注用户不存在");
        }
        $self_info = array();
        $member_info = array();
        foreach ($member_list as $k => $v) {
            if ($v['member_id'] == $this->member_id) {
                $self_info = $v;
            } else {
                $member_info = $v;
            }
        }
        if (empty($self_info) || empty($member_info)) {
            output_error("用户不存在");
        }
        //验证是否已经存在好友记录
        $friend_model = Model('sns_friend');
        $friend_count = $friend_model->countFriend(array('friend_frommid' => "$this->member_id", 'friend_tomid' => "$mid"));
        if ($friend_count > 0) {
            output_error("已关注过");
        }
        //查询对方是否已经关注我，从而判断关注状态
        $friend_info = $friend_model->getFriendRow(array('friend_frommid' => "{$mid}", 'friend_tomid' => "$this->member_id"));
        $insert_arr = array();
        $insert_arr['friend_frommid'] = "{$self_info['member_id']}";
        $insert_arr['friend_frommname'] = "{$self_info['member_name']}";
        $insert_arr['friend_frommavatar'] = "{$self_info['member_avatar']}";
        $insert_arr['friend_tomid'] = "{$member_info['member_id']}";
        $insert_arr['friend_tomname'] = "{$member_info['member_name']}";
        $insert_arr['friend_tomavatar'] = "{$member_info['member_avatar']}";
        $insert_arr['friend_addtime'] = time();
        if (empty($friend_info)) {
            $insert_arr['friend_followstate'] = '1';//单方关注
        } else {
            $insert_arr['friend_followstate'] = '2';//双方关注
        }
        $result = $friend_model->addFriend($insert_arr);
        if ($result) {
            //更新对方关注状态
            if (!empty($friend_info)) {
                $friend_model->editFriend(array('friend_followstate' => '2'), array('friend_id' => "{$friend_info['friend_id']}"));
            }
            output_data(array('state' => $insert_arr['friend_followstate']));
        } else {
            output_error("关注失败");
        }
    }

    /**
     *GET 取消关注
     */
    public function delfollowOp()
    {
        $mid = intval($_GET['mid']);
        if ($mid <= 0) {
            output_error("用户id错误");
        }
        //取消关注
        $friend_model = Model('sns_friend');
        $result = $friend_model->delFriend(array('friend_frommid' => "", 'friend_tomid' => "$mid"));
        if ($result) {
            //更新对方的关注状态
            $friend_model->editFriend(array('friend_followstate' => '1'), array('friend_frommid' => "$mid", 'friend_tomid' => "$this->member_id"));
            output_data(array('success' => "取消关注成功"));
        } else {
            output_error("取消关注失败");
        }
    }

    /**
     * GET 是否关注
     */
    public function isfollowstateOp()
    {
        $mid = intval($_GET['mid']);
        if ($mid <= 0) {
            output_error("用户id错误");
        }
        //验证是否已经存在好友记录
        $friend_model = Model('sns_friend');
        $friend_count = $friend_model->countFriend(array('friend_frommid' => "$this->member_id", 'friend_tomid' => "$mid"));
        if ($friend_count > 0) {
            //  已关注
            echo 1;
        } else {
            //  未关注
            echo 0;
        }
    }


    /**
     * POST 保存个人资料
     */
    public function save_profileOp()
    {

        $model_member = Model('member');

        if (isset($_POST)) {

            $member_array = array();
            $member_array['member_truename'] = $_POST['member_truename'];
//            $member_array['member_sex'] = $_POST['member_sex'];
//            $member_array['member_qq'] = $_POST['member_qq'];
//            $member_array['member_ww'] = $_POST['member_ww'];
            $member_array['member_areaid'] = $_POST['area_id'];
            $member_array['member_cityid'] = $_POST['city_id'];
            $member_array['member_provinceid'] = $_POST['province_id'];
            $member_array['member_areainfo'] = $_POST['area_info'];

            $member_array['member_shenfen'] = $_POST['member_shenfen'];
            $member_array['member_yjfx'] = $_POST['member_yjfx'];
            $member_array['member_zhuanye'] = $_POST['member_zhuanye'];
            $member_array['member_xueke'] = $_POST['member_xueke'];

//
//            if (strlen($_POST['birthday']) == 10) {
//                $member_array['member_birthday'] = $_POST['birthday'];
//            }
//            $member_array['member_privacy'] = serialize($_POST['privacy']);
            $update = $model_member->editMember(array('member_id' => $this->member_id), $member_array);
            $update ? output_data(array('success' => "保存成功", 'status' => 1)) : output_error("保存失败");
            die;
        }

        output_error("请求方式错误");
    }

    /**
     * POST 上传头像图片
     */
    public function uploadOp()
    {
        if (!isset($_POST)) {
            output_error("请求方式错误");
            die;
        }
        import('function.thumb');

        $member_id = $this->member_id;

        //上传图片
        $upload = new UploadFile();
        $upload->set('thumb_width', 500);
        $upload->set('thumb_height', 499);
        $ext = strtolower(pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION));
        $upload->set('file_name', "avatar_$member_id.$ext");
        $upload->set('thumb_ext', '_new');
        $upload->set('ifremove', true);
        $upload->set('default_dir', ATTACH_AVATAR);
        if (!empty($_FILES['pic']['tmp_name'])) {
            $result = $upload->upfile('pic');
            if (!$result) {
                output_error("上传失败");
                die;
            }
        } else {
            output_error('上传失败，请尝试更换图片格式或小图片');
            die;
        }
        $thumb_img = array('newfile' => $upload->thumb_image,
            'height' => get_height(BASE_UPLOAD_PATH . '/' . ATTACH_AVATAR . '/' . $upload->thumb_image),
            'width' => get_width(BASE_UPLOAD_PATH . '/' . ATTACH_AVATAR . '/' . $upload->thumb_image));
        output_data(array('thumb_img' => $thumb_img));
    }


    /**
     * GET 相册图片列表
     *
     */
    public function album_picOp()
    {
        $model = Model();
        $where = array();
        if (intval($_GET['class_id']) > 0) {
            $where['ac_id'] = intval($_GET['class_id']);
        }
        $where['member_id'] = $this->member_id;
        $m_albumpic = $model->table('sns_albumpic')->where($where);

        //设置每页数量和总数！！！
        pagecmd('setEachNum', $this->page);
        pagecmd('setTotalNum', $m_albumpic->count());
        $pageCount = $m_albumpic->gettotalpage();
        $pic_list = $m_albumpic->page($this->page)->select();
        output_data(array('pic_list' => $pic_list), mobile_page($pageCount));
    }

    /**
     * GET 相册列表
     *
     */
    public function album_listOp()
    {
        $model = Model();
        $class_list = $model->table('sns_albumclass')->where(array('member_id' => $this->member_id))->select();
        output_data(array('albums' => $class_list));
    }

    /**
     * POST 上传图片
     *
     */
    public function uploadImageOp()
    {
        /**
         * 读取语言包
         */
        Language::read('sns_home');
        $lang = Language::getLangContent();
        $member_id = $this->member_info['member_id'];
        $class_id = 0;
        $model = Model();
        // 验证图片数量
        /*$count = $model->table('sns_albumpic')->where(array('member_id'=>$member_id))->count();
        if(C('malbum_max_sum') != 0 && $count >= C('malbum_max_sum')){
            echo json_encode(array('state'=>'false','message'=>Language::get('sns_upload_img_max_num_error'), 'origin_file_name' => $_FILES["file"]["name"]));
            exit;
        }*/

        /**
         * 上传图片
         */
        $upload = new UploadFile();
        $upload_dir = ATTACH_MALBUM . DS . $member_id . DS;
        $upload->set('default_dir', $upload_dir . $upload->getSysSetPath());
        $thumb_width = '1024,1024';
        $thumb_height = '2048,1024';

        $upload->set('max_size', C('image_max_filesize'));
        $upload->set('thumb_width', $thumb_width);
        $upload->set('thumb_height', $thumb_height);
        $upload->set('fprefix', $member_id);
        $upload->set('thumb_ext', '_1024,_2048');
        $result = $upload->upfile('file');
        if (!$result) {
            output_error("fail");
            exit;
        }
        $img_path = $upload->getSysSetPath() . $upload->file_name;
        list($width, $height, $type, $attr) = getimagesize(BASE_UPLOAD_PATH . DS . ATTACH_MALBUM . DS . $member_id . DS . $img_path);
        $image = explode('.', $_FILES["file"]["name"]);
        if (strtoupper(CHARSET) == 'GBK') {
            $image['0'] = Language::getGBK($image['0']);
        }
        $insert = array();
        $insert['ap_name'] = $image['0'];
        $insert['ac_id'] = $class_id;
        $insert['ap_cover'] = $img_path;
        $insert['ap_size'] = intval($_FILES['file']['size']);
        $insert['ap_spec'] = $width . 'x' . $height;
        $insert['upload_time'] = time();
        $insert['member_id'] = $member_id;
        $result = $model->table('sns_albumpic')->insert($insert);

        $data = array();
        $data['file_id'] = $result;
        $data['file_name'] = $img_path;
        $data['origin_file_name'] = $_FILES["file"]["name"];
        $data['file_path'] = $img_path;
        $data['file_url'] = snsThumb2($img_path);
        $data['state'] = true;

        output_data($data);

    }

    /**
     * GET 商品收藏列表
     */
    public function goods_fav_listOp()
    {
        $model_favorites = Model('favorites');

        $favorites_list = $model_favorites->getGoodsFavoritesList(array('member_id' => $this->member_id), '*', $this->page);
        $page_count = $model_favorites->gettotalpage();
        $favorites_id = '';
        foreach ($favorites_list as $value) {
            $favorites_id .= $value['fav_id'] . ',';
        }
        $favorites_id = rtrim($favorites_id, ',');

        $model_goods = Model('goods');
        $field = 'goods_id,goods_commonid,store_id,goods_name,goods_price,goods_marketprice,goods_image,goods_salenum,evaluation_good_star,evaluation_count';
        $goods_list = $model_goods->getGoodsList(array('goods_id' => array('in', $favorites_id)), $field);

        foreach ($goods_list as $key => $value) {
            $goods_list[$key]['goods_image_url'] = cthumb($value['goods_image'], 360, $value['store_id']);
        }
        output_data(array('goods_list' => $goods_list), mobile_page($page_count));
    }

    /**
     * GET 交易收藏列表
     */
    public function trade_fav_listOp()
    {
        $model_favorites = Model('trade_favorites');

        $favorites_list = $model_favorites->getFavoritesList(array('member_id' => $this->member_id, 'fav_type' => 'flea'), '*', $this->page);
        $page_count = $model_favorites->gettotalpage();

        $favorites_id = '';
        foreach ($favorites_list as $value) {
            $favorites_id .= $value['fav_id'] . ',';
        }
        $favorites_id = rtrim($favorites_id, ',');

        $model_trade = Model('utrade');
        $field = "member_id,member_name,goods_id,goods_name,gc_name,goods_image,goods_tag,
        flea_quality,commentnum,goods_price,goods_store_price,goods_click,
        flea_collect_num,goods_add_time,goods_body,salenum,flea_area_name,
        flea_pname,flea_pphone,goods_status,goods_leixing";

        $trade_list = $model_trade->getGoodsList(array('goods_id' => array('in', $favorites_id)), $field);

        if (is_array($trade_list) and !empty($trade_list)) {
            foreach ($trade_list as $key => $val) {
                $trade_list[$key]['fav_status'] = 1;
                $trade_list[$key]['member_avatar'] = getMemberAvatarForID($trade_list[$key]['member_id']);
                $trade_list[$key]['goods_image'] = $trade_list[$key]['goods_image'] == '' ? '' : UPLOAD_SITE_URL . '/' . ATTACH_MALBUM . '/' . $trade_list[$key]['member_id'] . '/' . str_replace('_1024', '_240', $val['goods_image']);
            }
        }
        output_data(array('trade_list' => $trade_list), mobile_page($page_count));
    }

    private function getMyThemeIds()
    {
        $model = Model();
        $m_theme = $model->table('circle_theme');
        $field = 'theme_id';
        $ids = $m_theme->where(array("member_id" => $this->member_id))->field($field)->select();
        $themeIds = array();
        foreach ($ids as $key => $val) {
            $themeIds[$key] = $val['theme_id'];
        }
        return $themeIds;
    }

    /**
     * GET 消息中心的回帖列表
     */
    public function repliesOp()
    {
        $themeIds = $this->getMyThemeIds();
        $model = new Model();
        $types = array(5, 6);

        $m_reply = $model->table('circle_threply');

        $where['circle_threply.theme_id'] = array('in', $themeIds);
        $where['circle_theme.thclass_id'] = array('not in', $types);

        $fields = "circle_threply.reply_content,circle_threply.reply_addtime,circle_threply.member_name,circle_threply.member_id,
        circle_threply.circle_id,circle_threply.reply_id,circle_threply.theme_id,circle_theme.theme_name";

        $replies = $model->table('circle_threply,circle_theme')->join('right join')->on('circle_threply.theme_id=circle_theme.theme_id')->where($where)->field($fields)->page($this->page)->order('reply_addtime desc')->select();

        $pageCount = $m_reply->gettotalpage();

        if (!empty($replies)) {
            foreach ($replies as $key => $val) {
                $replies[$key]['member_avatar'] = getMemberAvatarForID($replies[$key]['member_id']);
            }
        }
        output_data(array('receiveReplies' => $replies), mobile_page($pageCount));
    }

    /**
     * GET 消息中心的回答列表
     */
    public function answersOp()
    {
        $themeIds = $this->getMyThemeIds();
        $model = new Model();
        $types = array(5, 6);

        $m_reply = $model->table('circle_threply');

        $where['circle_threply.theme_id'] = array('in', $themeIds);
        $where['circle_theme.thclass_id'] = array('in', $types);

        $fields = "circle_threply.reply_content,circle_threply.reply_addtime,circle_threply.member_name,circle_threply.member_id,
        circle_threply.circle_id,circle_threply.reply_id,circle_threply.theme_id,circle_theme.theme_name";

        $replies = $model->table('circle_threply,circle_theme')->join('right join')->on('circle_threply.theme_id=circle_theme.theme_id')->where($where)->field($fields)->page($this->page)->order('reply_addtime desc')->select();

        $pageCount = $m_reply->gettotalpage();

        if (!empty($replies)) {
            foreach ($replies as $key => $val) {
                $replies[$key]['member_avatar'] = getMemberAvatarForID($replies[$key]['member_id']);
            }
        }
        output_data(array('receiveAnswers' => $replies), mobile_page($pageCount));
    }
}