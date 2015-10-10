<?php
/**
 * cms发布
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class publishControl extends CMSMemberControl{

    public function __construct() {
		parent::__construct();
    }

    public function indexOp() {
        $this->publish_articleOp();
    }

    /**
     * 文章发布
     */
	public function publish_articleOp(){
        $model_article_class = Model('cms_article_class');
        $article_class_list = $model_article_class->getList(TRUE, null, 'class_sort asc');
        Tpl::output('article_class_list', $article_class_list);

        $model_tag = Model('cms_tag');
        $tag_list = $model_tag->getList(TRUE, null, 'tag_sort asc');
        Tpl::output('tag_list', $tag_list);

        Tpl::showpage('publish_article','cms_member_layout');
	}

    /**
     * 文章发布
     */
	public function publish_article_saveOp(){
        if(empty($_POST['article_title'])) {
            showMessage(Language::get('article_title_null'),'','','error');
        }
        //插入文章
        $param = array();
        $param['article_title'] = trim($_POST['article_title']);
        if(empty($_POST['article_title_short'])) {
            $param['article_title_short'] = mb_substr($_POST['article_title'], 0, 12, CHARSET);
        } else {
            $param['article_title_short'] = $_POST['article_title_short'];
        }
        $param['article_class_id'] = intval($_POST['article_class']);
        $param['article_origin'] = trim($_POST['article_origin']);
        $param['article_origin_address'] = trim($_POST['article_origin_address']);
        $param['article_author'] = trim($_POST['article_author']);
        $param['article_abstract'] = mb_substr(trim($_POST['article_abstract']), 0, 140, CHARSET);
        $param['article_content'] = trim($_POST['article_content']);
        $param['article_link'] = trim($_POST['article_link']);
        $param['article_keyword'] = trim($_POST['article_keyword']);
        if(empty($_POST['article_id'])) {
            $param['article_publisher_name'] = $this->publisher_name;
            $param['article_publisher_id'] = $this->publisher_id;
            $param['article_type'] = $this->publisher_type;
            $param['article_attachment_path'] = $this->attachment_path;
            $param['article_sort'] = 255;
        }
        $param['article_commend_flag'] = 0;
        $param['article_tag'] = trim($_POST['article_tag']);

        //文章图片
        if(!empty($_POST['article_image_all'])) {
            $article_image_all = array();
            foreach ($_POST['article_image_all'] as $value) {
                list($file_name, $file_path) = explode(',', $value);
                $file_path = empty($file_path)?$this->attachment_path:$file_path;
                $article_image_url = getCMSArticleImageUrl($file_path, $file_name, 'max');
                list($width, $height, $type, $attr) = getimagesize($article_image_url);
                $article_image_all[$file_name]['name'] = $file_name;
                $article_image_all[$file_name]['width'] = $width;
                $article_image_all[$file_name]['height'] = $height;
                $article_image_all[$file_name]['path'] = $file_path;
            }
            $param['article_image_all'] = serialize($article_image_all);
        }

        if(!empty($_POST['article_image'])) {
            $param['article_image'] = serialize($article_image_all[$_POST['article_image']]);
        }

        //文章商品
        if(!empty($_POST['article_goods_url'])) {
            $article_goods_list = array();
            for ($i = 0,$count = count($_POST['article_goods_url']); $i < $count; $i++) {
                $article_goods = array();
                $article_goods['url'] = $_POST['article_goods_url'][$i];
                $article_goods['title'] = $_POST['article_goods_title'][$i];
                $article_goods['image'] = $_POST['article_goods_image'][$i];
                $article_goods['price'] = $_POST['article_goods_price'][$i];
                $article_goods['type'] = $_POST['article_goods_type'][$i];
                $article_goods_list[] = $article_goods;
            }

            if(!empty($article_goods_list)) {
                $param['article_goods'] = serialize($article_goods_list);
            } else {
                $param['article_goods'] = '';
            }
        }

        //发布时间
        if(!empty($_POST['article_publish_time'])) {
            $param['article_publish_time'] = strtotime($_POST['article_publish_time']);
        } else {
            $param['article_publish_time'] = time();
        }
        $param['article_modify_time'] = time();

        if($_POST['save_type'] == 'publish') {
            $param['article_state'] = $this->publish_state;
        } else {
            $param['article_state'] = self::ARTICLE_STATE_DRAFT;
        }

        $model_article = Model('cms_article');
        $model_tag_relation = Model('cms_tag_relation');
        if(!empty($_POST['article_id'])) {
            $article_id = intval($_POST['article_id']);
            $article_auth = $this->check_article_auth($article_id);
            if($article_auth) {
                $model_article->modify($param,array('article_id'=>$article_id));
                $model_tag_relation->drop(array('relation_type'=>1,'relation_object_id'=>$article_id));
            } else {
                showMessage(Language::get('wrong_argument'),'','','error');
            }
        } else {
            $article_id = $model_article->save($param);
        }

        //插入文章标签
        if(!empty($_POST['article_tag'])) {
            $tag_list = explode(',', $_POST['article_tag']);
            $param = array();
            $param['relation_type'] = 1;
            $param['relation_object_id'] = $article_id;
            $params = array();
            foreach ($tag_list as $value) {
                $param['relation_tag_id'] = $value;
                $params[] = $param;
            }
            $model_tag_relation->saveAll($params);
        }

        if($article_id) {
            showMessage(Language::get('nc_common_save_succ'),self::CMS_MEMBER_ARTICLE_URL);
        } else {
            showMessage(Language::get('nc_common_save_fail'),self::CMS_MEMBER_ARTICLE_URL,'','error');
        }
    }

    /**
     * 画报发布
     */
	public function publish_pictureOp(){
        $model_picture_class = Model('cms_picture_class');
        $picture_class_list = $model_picture_class->getList(TRUE, null, 'class_sort asc');
        Tpl::output('picture_class_list', $picture_class_list);

        $model_tag = Model('cms_tag');
        $tag_list = $model_tag->getList(TRUE, null, 'tag_sort asc');
        Tpl::output('tag_list', $tag_list);

        Tpl::showpage('publish_picture','cms_member_layout');

	}

    /**
     * 画报保存
     */
    public function publish_picture_saveOp() {
        if(empty($_POST['picture_title'])) {
            showMessage(Language::get('article_title_null'),'','','error');
        }
        //插入文章
        $param = array();
        $param['picture_title'] = trim($_POST['picture_title']);
        if(empty($_POST['picture_title_short'])) {
            $param['picture_title_short'] = mb_substr($_POST['picture_title'], 0 ,12, CHARSET);
        } else {
            $param['picture_title_short'] = $_POST['picture_title_short'];
        }
        $param['picture_class_id'] = intval($_POST['picture_class']);
        $param['picture_author'] = trim($_POST['picture_author']);
        $param['picture_abstract'] = mb_substr(trim($_POST['picture_abstract']), 0, 140, CHARSET);
        $param['picture_keyword'] = trim($_POST['picture_keyword']);
        if(empty($_POST['picture_id'])) {
            $param['picture_publisher_name'] = $this->publisher_name;
            $param['picture_publisher_id'] = $this->publisher_id;
            $param['picture_type'] = $this->publisher_type;
            $param['picture_attachment_path'] = $this->attachment_path;
            $param['picture_sort'] = 255;
        }
        $param['picture_commend_flag'] = 0;
        $param['picture_tag'] = trim($_POST['picture_tag']);
        if(!empty($_POST['picture_publish_time'])) {
            $param['picture_publish_time'] = strtotime($_POST['picture_publish_time']);
        } else {
            $param['picture_publish_time'] = time();
        }
        $param['picture_modify_time'] = time();

        if($_POST['save_type'] == 'publish') {
            $param['picture_state'] = $this->publish_state;
        } else {
            $param['picture_state'] = self::ARTICLE_STATE_DRAFT;
        }
        $image_count = count($_POST['picture_image_all']);
        $param['picture_image_count'] = $image_count;

        $model_picture = Model('cms_picture');
        $model_tag_relation = Model('cms_tag_relation');
        $model_picture_image = Model('cms_picture_image');

        if(!empty($_POST['picture_image_all'])) {
            $picture_image_all = array();
            $picture_image_index = 0;
            for ($i = 0; $i < $image_count; $i++) {
                $picture_image = array();
                list($file_name, $file_path) = explode(',', $_POST['picture_image_all'][$i]);

                $file_path = empty($file_path)?$this->attachment_path:$file_path;

                $picture_image_url = getCMSArticleImageUrl($file_path, $file_name, 'max');
                list($width, $height, $type, $attr) = getimagesize($picture_image_url);

                $picture_image['image_name'] = $file_name;
                $picture_image['image_width'] = $width;
                $picture_image['image_height'] = $height;
                $picture_image['image_path'] = $file_path;
                $picture_image['image_abstract'] = $_POST['picture_image_abstract'][$i];
                $picture_image['image_goods'] = '';
                if(isset($_POST['image_goods_url'][$picture_image['image_name']])) {
                    $image_goods_list = array();
                    for ($j = 0,$j_count = count($_POST['image_goods_url'][$picture_image['image_name']]); $j < $j_count; $j++) {
                        $image_goods = array();
                        $image_goods['url'] = $_POST['image_goods_url'][$picture_image['image_name']][$j];
                        $image_goods['image'] = $_POST['image_goods_image'][$picture_image['image_name']][$j];
                        $image_goods['price'] = $_POST['image_goods_price'][$picture_image['image_name']][$j];
                        $image_goods['title'] = $_POST['image_goods_title'][$picture_image['image_name']][$j];
                        $image_goods_list[] = $image_goods;
                    }
                    $picture_image['image_goods'] = serialize($image_goods_list);;
                }
                $picture_image_all[] = $picture_image;

                if($file_name == $_POST['picture_image']) {
                    $picture_image_index = $i;
                }
            }

            //设置封面图
            $picture_image = array();
            $picture_image['name'] = $picture_image_all[$picture_image_index]['image_name'];
            $picture_image['width'] = $picture_image_all[$picture_image_index]['image_width'];
            $picture_image['height'] = $picture_image_all[$picture_image_index]['image_height'];
            $picture_image['path'] = $picture_image_all[$picture_image_index]['image_path'];
            $param['picture_image'] = serialize($picture_image) ;
        }

        if(!empty($_POST['picture_id'])) {
            $picture_id = intval($_POST['picture_id']);
            $picture_auth = $this->check_picture_auth($picture_id);
            if($picture_auth) {

                //删除原画报图片
                $model_picture_image->drop(array('image_picture_id'=>$picture_id));

                $model_picture->modify($param,array('picture_id'=>$picture_id));
                $model_tag_relation->drop(array('relation_type'=>2,'relation_object_id'=>$picture_id));
            } else {
                showMessage(Language::get('wrong_argument'),'','','error');
            }
        } else {
            $picture_id = $model_picture->save($param);
        }

        for($i = 0,$length = count($picture_image_all); $i < $length; $i++) {
            $picture_image_all[$i]['image_picture_id'] = $picture_id;
        }

        $model_picture_image->saveAll($picture_image_all);

        //插入文章标签
        if(!empty($_POST['picture_tag'])) {
            $tag_list = explode(',', $_POST['picture_tag']);
            $param = array();
            $param['relation_type'] = 2;
            $param['relation_object_id'] = $picture_id;
            $params = array();
            foreach ($tag_list as $value) {
                $param['relation_tag_id'] = $value;
                $params[] = $param;
            }
            $model_tag_relation->saveAll($params);
        }

        if($picture_id) {
            showMessage(Language::get('nc_common_save_succ'),self::CMS_MEMBER_PICTURE_URL);
        } else {
            showMessage(Language::get('nc_common_save_fail'),self::CMS_MEMBER_PICTURE_URL,'','error');
        }

    }


    /**
     * 文章图片上传
     */
    public function article_image_uploadOp() {
        $data = array();
        $data['status'] = 'success';
        if(!empty($this->publisher_name)) {
            if(!empty($_FILES['article_image_upload']['name'])) {
                $upload	= new UploadFile();
                $upload->set('default_dir',ATTACH_CMS.DS.'article'.DS.$this->attachment_path);
                $upload->set('thumb_width','1024,240');
                $upload->set('thumb_height', '50000,5000');
                $upload->set('thumb_ext',	'_max,_list');

                $result = $upload->upfile('article_image_upload');
                if(!$result) {
                    $data['status'] = 'fail';
                    $data['error'] = '图片上传失败';
                }
                $data['file_name'] = $upload->file_name;
                $data['origin_file_name'] = $_FILES['article_image_upload']['name'];
                $data['file_url'] = getCMSArticleImageUrl($this->attachment_path, $upload->file_name, 'max');
                $data['file_path'] = $this->attachment_path;
            }
        } else {
            $data['status'] = 'fail';
            $data['error'] = Language::get('no_login');
        }
        self::echo_json($data);
    }

    /**
     * 文章图片删除
     */
    public function article_image_dropOp() {
        $data = array();
        $data['status'] = 'success';
        $image_name = $_GET['image_name'];

        list($name, $ext) = explode(".", $image_name);
        $name = str_replace('/', '', $name);
        $name = str_replace('.', '', $name);
        $image = $name.'.'.$ext;
        $image_list = $name.'_list.'.$ext;
        $image_max = $name.'_max.'.$ext;

        self::drop_image('article'.DS.$this->attachment_path, $image);
        self::drop_image('article'.DS.$this->attachment_path, $image_list);
        self::drop_image('article'.DS.$this->attachment_path, $image_max);
        self::echo_json($data);
    }
}
