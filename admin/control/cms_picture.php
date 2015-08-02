<?php
/**
 * cms文章分类
 *
 *
 *
 *
 */



defined('InShopNC') or exit('Access Invalid!');
class cms_pictureControl extends SystemControl{
    //文章状态草稿箱
    const ARTICLE_STATE_DRAFT = 1;
    //文章状态待审核
    const ARTICLE_STATE_VERIFY = 2;
    //文章状态已发布
    const ARTICLE_STATE_PUBLISHED = 3;
    //文章状态回收站
    const ARTICLE_STATE_RECYCLE = 4;

	public function __construct(){
		parent::__construct();
		Language::read('cms');
	}

	public function indexOp() {
        $this->cms_picture_listOp();
	}

    /**
     * cms文章列表
     **/
    public function cms_picture_listOp() {
        $condition = array();
        if(!empty($_GET['picture_state'])) {
            $condition['picture_state'] = $_GET['picture_state'];
        }
        $this->get_cms_picture_list($condition, 'list');
    }

    /**
     * 待审核文章列表
     */
    public function cms_picture_list_verifyOp() {
        $condition = array();
        $condition['picture_state'] = self::ARTICLE_STATE_VERIFY;
        $this->get_cms_picture_list($condition, 'list_verify');
    }

    /**
     * 已发布文章列表
     */
    public function cms_picture_list_publishedOp() {
        $condition = array();
        $condition['picture_state'] = self::ARTICLE_STATE_PUBLISHED;
        $this->get_cms_picture_list($condition, 'list_published');
    }


    private function get_cms_picture_list($condition, $menu_key) {
        if(!empty($_GET['picture_title'])) {
            $condition['picture_title'] = array('like', '%'.$_GET['picture_title'].'%');
        }
        if(!empty($_GET['picture_publisher_name'])) {
            $condition['picture_publisher_name'] = array('like', '%'.$_GET['picture_publisher_name'].'%');
        }

        $model_picture = Model('cms_picture');
        $picture_list = $model_picture->getList($condition, 10, 'picture_id desc');
        for ($i = 0, $j = count($picture_list); $i < $j; $i++) {
            if($picture_list[$i]['picture_state'] == self::ARTICLE_STATE_VERIFY) {
                $picture_list[$i]['verify_able'] = true;
            }
            if($picture_list[$i]['picture_state'] == self::ARTICLE_STATE_PUBLISHED) {
                $picture_list[$i]['callback_able'] = true;
            }
        }
        $this->show_menu($menu_key);
        Tpl::output('show_page',$model_picture->showpage(2));
        Tpl::output('list',$picture_list);
        Tpl::output('picture_state_list', $this->get_picture_state_list());
        Tpl::showpage("cms_picture.list");
    }

    /**
     * cms文章审核
     */
    public function cms_picture_verifyOp() {
        if(intval($_POST['verify_state']) === 1) {
            $this->cms_picture_state_modify(self::ARTICLE_STATE_PUBLISHED);
        } else {
            $this->cms_picture_state_modify(self::ARTICLE_STATE_DRAFT, array('picture_verify_reason' => $_POST['verify_reason']));
        }
    }

    /**
     * cms文章回收
     */
    public function cms_picture_callbackOp() {
        $this->cms_picture_state_modify(self::ARTICLE_STATE_DRAFT);
    }

    /**
     * 修改文章状态
     */
    private function cms_picture_state_modify($new_state, $param = array()) {
        $picture_id = $_POST['picture_id'];
        $model_picture = Model('cms_picture');
        $param['picture_state'] = $new_state;
        $model_picture->modify($param,array('picture_id'=>array('in',$picture_id)));
        showMessage(Language::get('nc_common_op_succ'),'');
    }

    /**
     * cms文章分类排序修改
     */
    public function update_picture_sortOp() {
        if(intval($_GET['id']) <= 0) {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));
            die;
        }
        $new_sort = intval($_GET['value']);
        if ($new_sort > 255){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('picture_sort_error')));
            die;
        } else {
            $model_class = Model("cms_picture");
            $result = $model_class->modify(array('picture_sort'=>$new_sort),array('class_id'=>$_GET['id']));
            if($result) {
                echo json_encode(array('result'=>TRUE,'message'=>'class_add_success'));
                die;
            } else {
                echo json_encode(array('result'=>FALSE,'message'=>Language::get('class_add_fail')));
                die;
            }
        }
    }

    /**
     * cms文章分类排序修改
     */
    public function update_picture_clickOp() {
        if(intval($_GET['id']) <= 0 || intval($_GET['value']) < 0) {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));die;
        }
        $model_class = Model("cms_picture");
        $result = $model_class->modify(array('picture_click'=>$_GET['value']),array('picture_id'=>$_GET['id']));
        if($result) {
            echo json_encode(array('result'=>TRUE,'message'=>''));die;
        } else {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));die;
        }
    }


    /**
     * cms文章删除
     **/
     public function cms_picture_dropOp() {
        $picture_id = trim($_POST['picture_id']);
        $model_picture = Model('cms_picture');
        $condition = array();
        $condition['picture_id'] = array('in',$picture_id);
        $result = $model_picture->drop($condition);
        if($result) {
            $this->log(Language::get('cms_log_picture_drop').$picture_id, 1);
            showMessage(Language::get('nc_common_del_succ'),'');
        } else {
            $this->log(Language::get('cms_log_picture_drop').$picture_id, 0);
            showMessage(Language::get('nc_common_del_fail'),'','','error');
        }
     }

    /**
     * ajax操作
     */
    public function ajaxOp(){
        if(intval($_GET['id']) > 0) {
            $flag = FALSE;
            switch ($_GET['branch']){
            case 'picture_commend':
                $flag = TRUE;
                break;
            case 'picture_comment':
                $flag = TRUE;
                break;
            }
            if($flag) {
                $model= Model('cms_picture');
                $update[$_GET['column']] = trim($_GET['value']);
                $condition['picture_id'] = intval($_GET['id']);
                $model->modify($update,$condition);
                echo 'true';die;
            } else {
                echo 'false';die;
            }
        }
    }


    /**
     * 获取文章状态列表
     */
    private function get_picture_state_list() {
        $array = array();
        $array[self::ARTICLE_STATE_DRAFT] = array('text'=>Language::get('cms_text_draft'));
        $array[self::ARTICLE_STATE_VERIFY] = array('text'=>Language::get('cms_text_verify'));
        $array[self::ARTICLE_STATE_PUBLISHED] = array('text'=>Language::get('cms_text_published'));
        $array[self::ARTICLE_STATE_RECYCLE] = array('text'=>Language::get('cms_text_recycle'));
        return $array;
    }

    private function show_menu($menu_key) {
        $menu_array = array(
            'list'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_list'),'menu_url'=>'index.php?act=cms_picture&op=cms_picture_list'),
            'list_verify'=>array('menu_type'=>'link','menu_name'=>Language::get('cms_article_list_verify'),'menu_url'=>'index.php?act=cms_picture&op=cms_picture_list_verify'),
            'list_published'=>array('menu_type'=>'link','menu_name'=>Language::get('cms_article_list_published'),'menu_url'=>'index.php?act=cms_picture&op=cms_picture_list_published'),
        );
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }

}
