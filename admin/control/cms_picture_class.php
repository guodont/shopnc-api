<?php
/**
 * cms画报分类
 *
 *
 *
 *
 */



defined('InShopNC') or exit('Access Invalid!');
class cms_picture_classControl extends SystemControl{

	public function __construct(){
		parent::__construct();
		Language::read('cms');
	}

	public function indexOp() {
        $this->cms_picture_class_listOp();
	}

    /**
     * cms画报分类列表
     **/
    public function cms_picture_class_listOp() {
        $model = Model('cms_picture_class');
        $list = $model->getList(TRUE);
        $this->show_menu('list');
        Tpl::output('list',$list);
        Tpl::showpage("cms_picture_class.list");
    }

    /**
     * cms画报分类添加
     **/
    public function cms_picture_class_addOp() {
        $this->show_menu('add');
        Tpl::showpage('cms_picture_class.add');
    }

    /**
     * cms画报分类保存
     **/
    public function cms_picture_class_saveOp() {
        $obj_validate = new Validate();
        $validate_array = array(
            array('input'=>$_POST['class_name'],'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"10",'message'=>Language::get('class_name_error')),
            array('input'=>$_POST['class_sort'],'require'=>'true','validator'=>'Range','min'=>0,'max'=>255,'message'=>Language::get('class_sort_error')),
        );
        $obj_validate->validateparam = $validate_array;
        $error = $obj_validate->validate();
        if ($error != ''){
            showMessage(Language::get('error').$error,'','','error');
        }

        $param = array();
        $param['class_name'] = trim($_POST['class_name']);
        $param['class_sort'] = intval($_POST['class_sort']);
        $model_class = Model('cms_picture_class');
        $result = $model_class->save($param);
        if($result) {
            $this->log(Language::get('cms_log_picture_class_save').$result, 1);
            showMessage(Language::get('class_add_success'),'index.php?act=cms_picture_class&op=cms_picture_class_list');
        } else {
            $this->log(Language::get('cms_log_picture_class_save').$result, 0);
            showMessage(Language::get('class_add_fail'),'index.php?act=cms_picture_class&op=cms_picture_class_list','','error');
        }


    }

    /**
     * cms画报分类排序修改
     */
    public function update_class_sortOp() {
        if(intval($_GET['id']) <= 0) {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));
            die;
        }
        $new_sort = intval($_GET['value']);
        if ($new_sort > 255){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('class_sort_error')));
            die;
        } else {
            $model_class = Model("cms_picture_class");
            $result = $model_class->modify(array('class_sort'=>$new_sort),array('class_id'=>$_GET['id']));
            if($result) {
                echo json_encode(array('result'=>TRUE,'message'=>'class_add_success'));
                die;
            } else {
                echo json_encode(array('result'=>FALSE,'message'=>Language::get('class_add_fail')));
                die;
            }
        }
    }

    public function update_class_nameOp() {
        $class_id = intval($_GET['id']);
        if($class_id <= 0) {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));
            die;
        }

        $new_name = trim($_GET['value']);
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array('input'=>$new_name,'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"10",'message'=>Language::get('class_name_error')),
        );
        $error = $obj_validate->validate();
        if ($error != ''){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('class_name_error')));
            die;
		} else {
            $model_class = Model("cms_picture_class");
            $result = $model_class->modify(array('class_name'=>$new_name),array('class_id'=>$class_id));
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
     * cms画报分类删除
     **/
     public function cms_picture_class_dropOp() {
        $class_id = trim($_POST['class_id']);
        $model_class = Model('cms_picture_class');
        $condition = array();
        $condition['class_id'] = array('in',$class_id);
        $result = $model_class->drop($condition);
        if($result) {
            $this->log(Language::get('cms_log_picture_class_drop').$result, 1);
            showMessage(Language::get('class_drop_success'),'');
        } else {
            $this->log(Language::get('cms_log_picture_class_drop').$result, 0);
            showMessage(Language::get('class_drop_fail'),'','','error');
        }

     }

    private function show_menu($menu_key) {
        $menu_array = array(
            'list'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_list'),'menu_url'=>'index.php?act=cms_picture_class&op=cms_picture_class_list'),
            'add'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_new'),'menu_url'=>'index.php?act=cms_picture_class&op=cms_picture_class_add'),
        );
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }


}
