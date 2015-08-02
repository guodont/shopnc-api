<?php
/**
 * cms文章分类
 *
 *
 *
 *
 */



defined('InShopNC') or exit('Access Invalid!');
class cms_tagControl extends SystemControl{

	public function __construct(){
		parent::__construct();
		Language::read('cms');
	}

	public function indexOp() {
        $this->cms_tag_listOp();
	}

    /**
     * cms文章分类列表
     **/
    public function cms_tag_listOp() {
        $model = Model('cms_tag');
        $list = $model->getList(TRUE, null, 'tag_id desc');
        $this->show_menu('list');
        Tpl::output('list',$list);
        Tpl::showpage("cms_tag.list");
    }

    /**
     * cms文章分类添加
     **/
    public function cms_tag_addOp() {
        $this->show_menu('add');
        Tpl::showpage('cms_tag.add');
    }

    /**
     * cms文章分类保存
     **/
    public function cms_tag_saveOp() {
        $obj_validate = new Validate();
        $validate_array = array(
            array('input'=>$_POST['tag_name'],'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"20",'message'=>Language::get('tag_name_error')),
            array('input'=>$_POST['tag_sort'],'require'=>'true','validator'=>'Range','min'=>0,'max'=>255,'message'=>Language::get('tag_sort_error')),
        );
        $obj_validate->validateparam = $validate_array;
        $error = $obj_validate->validate();
        if ($error != ''){
            showMessage(Language::get('error').$error,'','','error');
        }

        $param = array();
        $param['tag_name'] = trim($_POST['tag_name']);
        $param['tag_sort'] = intval($_POST['tag_sort']);
        $model_class = Model('cms_tag');
        $result = $model_class->save($param);
        if($result) {
            $this->log(Language::get('cms_log_tag_save').$result, 1);
            showMessage(Language::get('tag_add_success'),'index.php?act=cms_tag&op=cms_tag_list');
        } else {
            $this->log(Language::get('cms_log_tag_save').$result, 0);
            showMessage(Language::get('tag_add_fail'),'index.php?act=cms_tag&op=cms_tag_list','','error');
        }


    }

    /**
     * cms标签排序修改
     */
    public function update_tag_sortOp() {
        $new_sort = intval($_GET['value']);
        if ($new_sort > 255){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('class_sort_error')));
            die;
        } else {
            $this->update_tag('tag_sort', $new_sort);
        }
    }

    /**
     * cms标签标题修改
     */
    public function update_tag_nameOp() {
        $new_value = trim($_GET['value']);
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array('input'=>$new_value,'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"10",'message'=>Language::get('tag_name_error')),
        );
        $error = $obj_validate->validate();
        if ($error != ''){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('tag_name_error')));
            die;
		} else {
            $this->update_tag('tag_name', $new_value);
        }
    }

    /**
     * cms标签修改
     */
    private function update_tag($column, $new_value) {
        $tag_id = intval($_GET['id']);
        if($tag_id <= 0) {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));
            die;
        }

        $model = Model("cms_tag");
        $result = $model->modify(array($column=>$new_value),array('tag_id'=>$tag_id));
        if($result) {
            echo json_encode(array('result'=>TRUE, 'message'=>'success'));
            die;
        } else {
            echo json_encode(array('result'=>FALSE, 'message'=>Language::get('nc_common_save_fail')));
            die;
        }
    }

    /**
     * cms标签删除
     **/
     public function cms_tag_dropOp() {
        $tag_id = trim($_POST['tag_id']);
        $model = Model('cms_tag');
        $condition = array();
        $condition['tag_id'] = array('in',$tag_id);
        $result = $model->drop($condition);
        if($result) {
            $this->log(Language::get('cms_log_tag_drop').$_POST['tag_id'], 1);
            showMessage(Language::get('tag_drop_success'),'');
        } else {
            $this->log(Language::get('cms_log_tag_drop').$_POST['tag_id'], 0);
            showMessage(Language::get('tag_drop_fail'),'','','error');
        }

     }

    private function show_menu($menu_key) {
        $menu_array = array(
            'list'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_list'),'menu_url'=>'index.php?act=cms_tag&op=cms_tag_list'),
            'add'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_new'),'menu_url'=>'index.php?act=cms_tag&op=cms_tag_add'),
        );
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }


}
