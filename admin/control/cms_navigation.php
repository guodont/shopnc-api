<?php
/**
 * cms文章分类
 *
 *
 *
 *
 */



defined('InShopNC') or exit('Access Invalid!');
class cms_navigationControl extends SystemControl{

	public function __construct(){
		parent::__construct();
		Language::read('cms');
	}

	public function indexOp() {
        $this->cms_navigation_listOp();
	}

    /**
     * cms文章分类列表
     **/
    public function cms_navigation_listOp() {
        $model = Model('cms_navigation');
        $list = $model->getList(TRUE);
        $this->show_menu('list');
        Tpl::output('list',$list);
        Tpl::showpage("cms_navigation.list");
    }

    /**
     * cms文章分类添加
     **/
    public function cms_navigation_addOp() {
        $this->show_menu('add');
        Tpl::showpage('cms_navigation.add');
    }

    /**
     * cms文章分类保存
     **/
    public function cms_navigation_saveOp() {
        $obj_validate = new Validate();
        $validate_array = array(
            array('input'=>$_POST['navigation_title'],'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"20",'message'=>Language::get('navigation_title_error')),
            array('input'=>$_POST['navigation_link'],'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"255",'message'=>Language::get('navigation_link_error')),
            array('input'=>$_POST['navigation_sort'],'require'=>'true','validator'=>'Range','min'=>0,'max'=>255,'message'=>Language::get('navigation_sort_error')),
        );
        $obj_validate->validateparam = $validate_array;
        $error = $obj_validate->validate();
        if ($error != ''){
            showMessage(Language::get('error').$error,'','','error');
        }

        $param = array();
        $param['navigation_title'] = trim($_POST['navigation_title']);
        $param['navigation_link'] = trim($_POST['navigation_link']);
        $param['navigation_sort'] = intval($_POST['navigation_sort']);
        if(intval($_POST['navigation_open_type']) === 2) {
            $param['navigation_open_type'] = 2;
        } else {
            $param['navigation_open_type'] = 1;
        }
        $model_class = Model('cms_navigation');
        $result = $model_class->save($param);
        if($result) {
            $this->log(Language::get('cms_log_navigation_save').$result, 1);
            showMessage(Language::get('navigation_add_success'),'index.php?act=cms_navigation&op=cms_navigation_list');
        } else {
            $this->log(Language::get('cms_log_navigation_save').$result, 0);
            showMessage(Language::get('navigation_add_fail'),'index.php?act=cms_navigation&op=cms_navigation_list','','error');
        }

    }

    /**
     * cms导航排序修改
     */
    public function update_navigation_sortOp() {
        $new_sort = intval($_GET['value']);
        if ($new_sort > 255){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('class_sort_error')));
            die;
        } else {
            $this->update_navigation('navigation_sort', $new_sort);
        }
    }

    /**
     * cms导航标题修改
     */
    public function update_navigation_titleOp() {
        $new_value = trim($_GET['value']);
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array('input'=>$new_value,'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"10",'message'=>Language::get('navigation_title_error')),
        );
        $error = $obj_validate->validate();
        if ($error != ''){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('navigation_title_error')));
            die;
		} else {
            $this->update_navigation('navigation_title', $new_value);
        }
    }

    /**
     * cms导航链接修改
     */
    public function update_navigation_linkOp() {
        $new_value = trim($_GET['value']);
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array('input'=>$new_value,'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"255",'message'=>Language::get('navigation_link_error')),
        );
        $error = $obj_validate->validate();
        if ($error != ''){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('navigation_link_error')));
            die;
		} else {
            $this->update_navigation('navigation_link', $new_value);
        }
    }

    /**
     * cms导航修改
     */
    private function update_navigation($column, $new_value) {
        $navigation_id = intval($_GET['id']);
        if($navigation_id <= 0) {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));
            die;
        }

        $model = Model("cms_navigation");
        $result = $model->modify(array($column=>$new_value),array('navigation_id'=>$navigation_id));
        if($result) {
            echo json_encode(array('result'=>TRUE, 'message'=>'success'));
            die;
        } else {
            echo json_encode(array('result'=>FALSE, 'message'=>Language::get('nc_common_save_fail')));
            die;
        }
    }

    /**
     * cms导航删除
     **/
     public function cms_navigation_dropOp() {
        $navigation_id = trim($_POST['navigation_id']);
        $model = Model('cms_navigation');
        $condition = array();
        $condition['navigation_id'] = array('in',$navigation_id);
        $result = $model->drop($condition);
        if($result) {
            $this->log(Language::get('cms_log_navigation_drop').$_POST['navigation_id'], 1);
            showMessage(Language::get('navigation_drop_success'),'');
        } else {
            $this->log(Language::get('cms_log_navigation_drop').$_POST['navigation_id'], 0);
            showMessage(Language::get('navigation_drop_fail'),'','','error');
        }

     }

	/**
	 * ajax操作
	 */
	public function ajaxOp(){

		switch ($_GET['branch']){
			case 'navigation_open_type':
                if(intval($_GET['id']) > 0) {
                    $model= Model('cms_navigation');
                    $condition['navigation_id'] = intval($_GET['id']);
                    $update[$_GET['column']] = trim($_GET['value']);
                    $model->modify($update,$condition);
                    echo 'true';die;
                } else {
                    echo 'false';die;
                }
                break;
		}
	}

    private function show_menu($menu_key) {
        $menu_array = array(
            'list'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_list'),'menu_url'=>'index.php?act=cms_navigation&op=cms_navigation_list'),
            'add'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_new'),'menu_url'=>'index.php?act=cms_navigation&op=cms_navigation_add'),
        );
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }


}
