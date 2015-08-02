<?php
/**
 * 前台control父类,店铺control父类,会员control父类
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');

/********************************** 前台control父类 **********************************************/

class CMSControl{

    //文章状态草稿箱
    const ARTICLE_STATE_DRAFT = 1;
    //文章状态待审核
    const ARTICLE_STATE_VERIFY = 2;
    //文章状态已发布
    const ARTICLE_STATE_PUBLISHED = 3;
    //文章状态回收站
    const ARTICLE_STATE_RECYCLE = 4;
    //文章类型用户投稿
    const ARTICLE_TYPE_MEMBER = 1;
    //文章类型管理员发布
    const ARTICLE_TYPE_ADMIN = 2;
    //推荐
    const COMMEND_FLAG_TRUE = 1;
    //文章评论类型
    const ARTICLE = 1;
    const PICTURE = 2;
    //用户中心文章列表页
    const CMS_MEMBER_ARTICLE_URL = 'index.php?act=member_article&op=article_list';
    const CMS_MEMBER_PICTURE_URL = 'index.php?act=member_picture&op=picture_list';

    protected $publisher_name = '';
    protected $publisher_id = 0;
    protected $publisher_type = 0;
    protected $attachment_path = '';
    protected $publish_state;


	/**
	 * 构造函数
	 */
	public function __construct(){
        /**
         * cms开关判断
         */
        if(intval(C('cms_isuse')) !== 1) {
            header('location: '.SHOP_SITE_URL);die;
        }
		/**
		 * 读取通用、布局的语言包
		 */
		Language::read('common');
		Language::read('cms');
		/**
		 * 设置布局文件内容
		 */
		Tpl::setLayout('cms_layout');
		/**
		 * 转码
		 */
		if ($_GET['column'] && strtoupper(CHARSET) == 'GBK'){
			$_GET = Language::getGBK($_GET);
		}
		/**
		 * 获取导航
		 */
		Tpl::output('nav_list',($nav = F('nav'))? $nav :H('nav',true,'file'));
        /**
         * 登录后读取用户头像
         */
        if(!empty($_SESSION['member_id']) && intval($_SESSION['member_id']) > 0) {
            self::get_member_avatar($_SESSION['member_id']);
        }

		/**
		 * 系统状态检查
		 */
		if(!C('site_status')) halt(C('closed_reason'));

        /**
         * seo
         */
        Tpl::output('html_title',C('cms_seo_title').'-'.C('site_name').'');
        Tpl::output('seo_keywords',C('cms_seo_keywords'));
        Tpl::output('seo_description',C('cms_seo_description'));


        /**
         * 判断是不是管理员
         */
        if(!empty($_SESSION['member_name'])) {
            $this->publisher_name = $_SESSION['member_name'];
            $this->publisher_id = $_SESSION['member_id'];
            $this->publisher_type = self::ARTICLE_TYPE_MEMBER;
            $this->publisher_avator = self::get_member_avatar($_SESSION['member_id']);
            $this->attachment_path = $_SESSION['member_id'];
        }

        //发布状态，管理员直接发布，投稿如果后台开启审核未待审核状态
        if(intval(C('cms_submit_verify_flag')) === 1) {
            $this->publish_state = self::ARTICLE_STATE_VERIFY;
        } else {
            $this->publish_state = self::ARTICLE_STATE_PUBLISHED;
        }

	}

    protected function get_member_avatar($member_id) {
        if(!isset($_SESSION['member_avatar'])) {
            $model_member = Model('member');
            $member_info = $model_member->getMemberInfoByID(array('member_id'=>$member_id));
            $_SESSION['member_avatar'] = $member_info['member_avatar'];
        }
        return $_SESSION['member_avatar'];
    }

    protected function check_login() {
        if(!isset($_SESSION['is_login'])) {
            $ref_url = CMS_SITE_URL.request_uri();
            header('location: '.SHOP_SITE_URL.'/index.php?act=login&ref_url='.getRefUrl());die;
        }
    }

    /**
     * 用户详细信息
     */
	protected function get_member_detail_info($member_info) {
		//生成缓存的键值
		$member_id  = $member_info['member_id'];
		if($member_id <= 0){
            header('location: '.CMS_SITE_URL);die;
		}
		//写入缓存的数据
		$cachekey_arr = array('member_name','store_id','member_avatar','member_qq','member_email','member_msn','member_ww','member_goldnum','member_points',
				'available_predeposit','member_snsvisitnum','credit_arr','fan_count','attention_count');
		//先查找$member_id缓存
		if ($_cache = rcache($member_id,'sns_member')){
			foreach ($_cache as $k=>$v){
				$member_info[$k] = $v;
			}
		} else {
			$model = Model();
			//粉丝数
			$fan_count = $model->table('sns_friend')->where(array('friend_tomid'=>$member_id))->count();
			$member_info['fan_count'] = $fan_count;
			//关注数
			$attention_count = $model->table('sns_friend')->where(array('friend_frommid'=>$member_id))->count();
			$member_info['attention_count'] = $attention_count;
			//兴趣标签
			$mtag_list = $model->table('sns_membertag,sns_mtagmember')->field('mtag_name')->on('sns_membertag.mtag_id = sns_mtagmember.mtag_id')->join('inner')->where(array('sns_mtagmember.member_id'=>$member_id))->select();
			$tagname_array = array();
			if(!empty($mtag_list)){
				foreach ($mtag_list as $val){
					$tagname_array[] = $val['mtag_name'];
				}
			}
			$member_info['tagname'] = $tagname_array;

			wcache($member_id,$member_info,'sns_member');
		}
        return $member_info;
	}

    /**
     * 获取文章状态列表
     */
    protected function get_article_state_list() {
        $array = array();
        $array[self::ARTICLE_STATE_DRAFT] = Language::get('cms_text_draft');
        $array[self::ARTICLE_STATE_VERIFY] = Language::get('cms_text_verify');
        $array[self::ARTICLE_STATE_PUBLISHED] = Language::get('cms_text_published');
        $array[self::ARTICLE_STATE_RECYCLE] = Language::get('cms_text_recycle');
        return $array;
    }

    /**
     * 获取文章相关文章
     */
    protected function get_article_link_list($article_link) {
        $article_link_list = array();
        if(!empty($article_link)) {
            $model_article = Model('cms_article');
            $condition = array();
            $condition['article_id'] = array('in',$article_link);
            $condition['article_state'] = self::ARTICLE_STATE_PUBLISHED;
            $article_link_list = $model_article->getList($condition , NULL, 'article_id desc');
        }
        return $article_link_list;
    }

    /**
     * 返回json状态
     */
	protected function return_json($message,$result='true') {
        $data = array();
        $data['result'] = $result;
        $data['message'] = $message;
        self::echo_json($data);
    }

    protected function echo_json($data) {
		if (strtoupper(CHARSET) == 'GBK'){
			$data = Language::getUTF8($data);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		}
        echo json_encode($data);die;
    }

    /**
     * 获取主域名
     */
    protected function get_url_domain($url) {
        $url_parse_array = parse_url($url);
        $host = $url_parse_array['host'];
        $host_names = explode(".", $host);
        $bottom_host_name = $host_names[count($host_names)-2] . "." . $host_names[count($host_names)-1];
        return $bottom_host_name;
    }

    //获得分享列表
    protected function get_share_app_list() {
        $app_shop = array();
        $app_array = array();
		if (C('share_isuse') == 1 && isset($_SESSION['member_id'])){
			//站外分享接口
			$model = Model('sns_binding');
			$app_array = $model->getUsableApp($_SESSION['member_id']);
		}
        Tpl::output('app_arr',$app_array);
    }

    protected function share_app_publish($publish_info=array()) {
        $param = array();
        $param['comment'] = "'".$_SESSION['member_name']."'".Language::get('cms_text_zai').C('cms_seo_title').Language::get('share_article');
        $param['title'] = "'".$_SESSION['member_name']."'".Language::get('cms_text_zai').C('cms_seo_title').Language::get('share_article');
        $param['url'] = $publish_info['url'];
        $param['title'] = $publish_info['share_title'];
        $param['image'] = $publish_info['share_image'];
        $param['content'] = self::get_share_app_content($param);
        $param['images'] = '';

        //分享应用
        $app_items = array();
        foreach ($_POST['share_app_items'] as $val) {
            if($val != '') {
                $app_items[$val] = TRUE;
            }
        }

        if (C('share_isuse') == 1 && !empty($app_items)){
            $model = Model('sns_binding');
            //查询该用户的绑定信息
            $bind_list = $model->getUsableApp($_SESSION['member_id']);
            //商城
            if (isset($app_items['shop'])){

                $model_member = Model('member');
                $member_info = $model_member->infoMember(array('member_id'=>$_SESSION['member_id']));

				$tracelog_model = Model('sns_tracelog');
				$insert_arr = array();
				$insert_arr['trace_originalid'] = '0';
				$insert_arr['trace_originalmemberid'] = '0';
				$insert_arr['trace_memberid'] = $_SESSION['member_id'];
				$insert_arr['trace_membername'] = $_SESSION['member_name'];
				$insert_arr['trace_memberavatar'] = $member_info['member_avatar'];
				$insert_arr['trace_title'] = $publish_info['commend_message'];
                $insert_arr['trace_content'] = $param['content'];
				$insert_arr['trace_addtime'] = time();
				$insert_arr['trace_state'] = '0';
				$insert_arr['trace_privacy'] = 0;
				$insert_arr['trace_commentcount'] = 0;
				$insert_arr['trace_copycount'] = 0;
				$insert_arr['trace_from'] = '4';
				$result = $tracelog_model->tracelogAdd($insert_arr);

            }
            //腾讯微博
            if (isset($app_items['qqweibo']) && $bind_list['qqweibo']['isbind'] == true){
                $model->addQQWeiboPic($bind_list['qqweibo'],$param);
            }
            //新浪微博
            if (isset($app_items['sinaweibo']) && $bind_list['sinaweibo']['isbind'] == true){
                $model->addSinaWeiboUpload($bind_list['sinaweibo'],$param);
            }
        }
    }

    //CMSsns内容结构
    protected function get_share_app_content($info) {
        $content_str = "
            <div class='fd-media'>
            <div class='goodsimg'><a target=\"_blank\" href=\"{$info['url']}\"><img src=\"".$info['image']."\" onload=\"javascript:DrawImage(this,120,120);\"></a></div>
            <div class='goodsinfo'>
            <dl>
            <dt><a target=\"_blank\" href=\"{$info['url']}\">{$info['title']}</a></dt>
            <dd>{$info['comment']}<a target=\"_blank\" href=\"{$info['url']}\">".Language::get('nc_common_goto')."</a></dd>
            </dl>
            </div>
            </div>
            ";
        return $content_str;
    }

}

class CMSHomeControl extends CMSControl{

	public function __construct() {
		parent::__construct();
        $model_navigation = Model('cms_navigation');
        $navigation_list = $model_navigation->getList(TRUE, null, 'navigation_sort asc');
        Tpl::output('navigation_list', $navigation_list);

        $model_article_class = Model('cms_article_class');
        $article_class_list = $model_article_class->getList(TRUE, null, 'class_sort asc');
        $article_class_list = array_under_reset($article_class_list, 'class_id');
        Tpl::output('article_class_list', $article_class_list);


        $model_picture_class = Model('cms_picture_class');
        $picture_class_list = $model_picture_class->getList(TRUE, null, 'class_sort asc');
        $picture_class_list = array_under_reset($picture_class_list, 'class_id');
        Tpl::output('picture_class_list', $picture_class_list);

        Tpl::output('index_sign','index');
        Tpl::output('top_function_block',TRUE);
    }

    /**
     * 推荐文章
     */
    protected function get_article_comment() {

        $model_article = Model('cms_article');
        $condition = array();
        $condition['article_commend_flag'] = 1;
        $article_commend_list = $model_article->getListWithClassName($condition, NULL, 'article_id desc', '*', 9);
        Tpl::output('article_commend_list', $article_commend_list);

    }

}

class CMSMemberControl extends CMSControl{

	public function __construct() {
		parent::__construct();
        if(empty($this->publisher_name)) {
            @header('Location: index.php');die;
        }

        //发布人信息
        Tpl::output('publisher_info', array('name'=>$this->publisher_name,
                                            'id'=>$this->publisher_id,
                                            'type'=>$this->publisher_type,
                                            'avator'=>$this->publisher_avator,
                                        )
        );
    }

    protected function check_article_auth($article_id) {
        if($article_id > 0) {
            $model_article = Model('cms_article');
            $article_detail = $model_article->getOne(array('article_id'=>$article_id));
            if(!empty($article_detail)) {
                if( $this->publisher_type == self::ARTICLE_TYPE_ADMIN ||
                    ($article_detail['article_type'] != self::ARTICLE_TYPE_ADMIN
                     && $article_detail['article_publisher_id'] == $this->publisher_id)) {
                    return $article_detail;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    protected function check_picture_auth($picture_id) {
        if($picture_id > 0) {
            $model_picture = Model('cms_picture');
            $picture_detail = $model_picture->getOne(array('picture_id'=>$picture_id));
            if(!empty($picture_detail)) {
                if( $this->publisher_type == self::ARTICLE_TYPE_ADMIN ||
                    ($picture_detail['picture_type'] != self::ARTICLE_TYPE_ADMIN
                     && $picture_detail['picture_publisher_id'] == $this->publisher_id)) {
                    return $picture_detail;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * 删除图片
     */
    protected function drop_image($attachment_path, $image_name) {
        $image = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.$attachment_path.DS.$image_name;
        if(is_file($image)) {
            unlink($image);
        }
    }


}
