<?php
/**
 * 资源管理
 *
 *
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class resources_listControl extends SystemControl{
    //资源状态草稿箱
    const resources_state_DRAFT = 1;
    //资源状态待审核
    const resources_state_VERIFY = 2;
    //资源状态已发布
    const resources_state_PUBLISHED = 3;
    //资源状态回收站
    const resources_state_RECYCLE = 4;

	public function __construct(){
		parent::__construct();
		Language::read('resources');
	}

	public function indexOp() {
        $this->cms_article_listOp();
	}

    /**
     * cms资源列表
     **/
    public function cms_article_listOp() {
        $condition = array();
        if(!empty($_GET['resources_state'])) {
            $condition['resources_state'] = $_GET['resources_state'];
        }
        $this->get_cms_article_list($condition, 'list');
    }

    /**
     * 待审核资源列表
     */
    public function resources_list_verifyOp() {
        $condition = array();
        $condition['resources_state'] = self::resources_state_VERIFY;
        $this->get_cms_article_list($condition, 'list_verify');
    }

    /**
     * 已发布资源列表
     */
    public function resources_list_publishedOp() {
        $condition = array();
        $condition['resources_state'] = self::resources_state_PUBLISHED;
        $this->get_cms_article_list($condition, 'list_published');
    }

    private function get_cms_article_list($condition, $menu_key) {
        if(!empty($_GET['resources_title'])) {
            $condition['resources_title'] = array('like', '%'.$_GET['resources_title'].'%');
        }
        if(!empty($_GET['resources_publisher_name'])) {
            $condition['resources_publisher_name'] = array('like', '%'.$_GET['resources_publisher_name'].'%');
        }

        $model_article = Model('resources_list');
        $resources_list = $model_article->getList($condition, 10, 'resources_id desc');
        for ($i = 0, $j = count($resources_list); $i < $j; $i++) {
            if($resources_list[$i]['resources_state'] == self::resources_state_VERIFY) {
                $resources_list[$i]['verify_able'] = true;
            }
            if($resources_list[$i]['resources_state'] == self::resources_state_PUBLISHED) {
                $resources_list[$i]['callback_able'] = true;
            }
        }
        $this->show_menu($menu_key);
        Tpl::output('show_page',$model_article->showpage(2));
        Tpl::output('list',$resources_list);
        Tpl::output('resources_state_list', $this->get_resources_state_list());
        Tpl::showpage("resources.list");
    }

    /**
     * cms资源审核
     */
    public function cms_article_verifyOp() {
        if(intval($_POST['verify_state']) === 1) {
            $this->cms_resources_state_modify(self::resources_state_PUBLISHED);
        } else {
            $this->cms_resources_state_modify(self::resources_state_DRAFT, array('article_verify_reason' => $_POST['verify_reason']));
        }
    }

    /**
     * cms资源收回
     */
    public function resources_callbackOp() {
        $this->cms_resources_state_modify(self::resources_state_DRAFT);
    }

    /**
     * 修改资源状态
     */
    private function cms_resources_state_modify($new_state, $param = array()) {
        $resources_id = $_POST['resources_id'];
        $model_article = Model('resources_list');
        $param['resources_state'] = $new_state;
        $model_article->modify($param, array('resources_id'=>array('in', $resources_id)));
        showMessage(Language::get('nc_common_op_succ'), '');
    }

    /**
     * cms资源分类排序修改
     */
    public function update_resources_sortOp() {
        if(intval($_GET['id']) <= 0) {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));
            die;
        }
        $new_sort = intval($_GET['value']);
        if ($new_sort > 255){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('class_sort_error')));
            die;
        } else {
            $model_class = Model("resources_list");
            $result = $model_class->modify(array('article_sort'=>$new_sort),array('resources_id'=>$_GET['id']));
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
     * cms资源分类排序修改
     */
    public function update_resources_clickOp() {
        if(intval($_GET['id']) <= 0 || intval($_GET['value']) < 0) {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));die;
        }
        $model_class = Model("resources_list");
        $result = $model_class->modify(array('resources_click'=>$_GET['value']),array('resources_id'=>$_GET['id']));
        if($result) {
            echo json_encode(array('result'=>TRUE,'message'=>''));die;
        } else {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));die;
        }
    }


    /**
     * cms资源删除
     **/
     public function resources_dropOp() {
        $resources_id = trim($_POST['resources_id']);
        $model_article = Model('resources_list');
        $condition = array();
        $condition['resources_id'] = array('in',$resources_id);
        $result = $model_article->drop($condition);
        if($result) {
            $this->log(Language::get('cms_log_article_drop').$resources_id, 1);
            showMessage(Language::get('nc_common_del_succ'),'');
        } else {
            $this->log(Language::get('cms_log_article_drop').$resources_id, 0);
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
            case 'resources_commend':
                $flag = TRUE;
                break;
            case 'resources_show':
                $flag = TRUE;
                break;
            case 'resources_order':
                $flag = TRUE;
                break;
            case 'resources_pay':
                $flag = TRUE;
                break;
            }
            if($flag) {
                $model= Model('resources_list');
                $update[$_GET['column']] = trim($_GET['value']);
                $condition['resources_id'] = intval($_GET['id']);
                $model->modify($update,$condition);
                echo 'true';die;
            } else {
                echo 'false';die;
            }
        }
    }


    /**
     * 获取资源状态列表
     */
    private function get_resources_state_list() {
        $array = array();
        $array[self::resources_state_DRAFT] = array('text'=>Language::get('cms_text_draft'));
        $array[self::resources_state_VERIFY] = array('text'=>Language::get('cms_text_verify'));
        $array[self::resources_state_PUBLISHED] = array('text'=>Language::get('cms_text_published'));
        $array[self::resources_state_RECYCLE] = array('text'=>Language::get('cms_text_recycle'));
        return $array;
    }

    private function show_menu($menu_key) {
        $menu_array = array(
            'list'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_list'),'menu_url'=>'index.php?act=resources_list&op=resource_list'),
            'list_verify'=>array('menu_type'=>'link','menu_name'=>Language::get('resources_list_verify'),'menu_url'=>'index.php?act=resources_list&op=resources_list_verify'),
            'list_published'=>array('menu_type'=>'link','menu_name'=>Language::get('resources_list_published'),'menu_url'=>'index.php?act=resources_list&op=resources_list_published'),
        );
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }

}
