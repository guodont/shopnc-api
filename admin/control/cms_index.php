<?php
/**
 * cms首页管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class cms_indexControl extends SystemControl{

	public function __construct(){
		parent::__construct();
		Language::read('cms');
	}

	public function indexOp() {
        $this->cms_indexOp();
	}

	/**
	 * cms首页管理
	 */
	public function cms_indexOp() {
        $model_index_module = Model('cms_index_module');
        $module_list = $model_index_module->getList(TRUE, null, 'module_state desc, module_sort asc');
        Tpl::output('list', $module_list);

        $model_module = Model('cms_module');
        $module_list = $model_module->getList(TRUE, null);
        Tpl::output('module_list', $module_list);

        $this->show_menu('cms_index');
        Tpl::showpage('cms_index');
	}

    /**
     * 获取
     */
    public function get_module_frame_listOp() {
        $data = array();

        $model_module_frame = Model('cms_module_frame');
        $module_frame_list = $model_module_frame->getList(TRUE, null);
        $data['frame_list'] = $module_frame_list;

        $model_module_assembly = Model('cms_module_assembly');
        $module_assembly_list = $model_module_assembly->getList(TRUE, null);
        $data['assembly_list'] = $module_assembly_list;

        echo json_encode($data);
    }

    /**
     * 模块添加
     */
    public function add_page_moduleOp() {
        $data = array();
        $data['result'] = TRUE;
        if(empty($_POST['module_name'])) {
            $data['result'] = FALSE;
            $data['message'] = '参数错误';
        } else {
            $model_index_module = Model('cms_index_module');
            $new_module = array();
            $new_module['module_title'] = $_POST['module_title'];
            $new_module['module_name'] = $_POST['module_name'];
            $new_module['module_type'] = $_POST['module_type'];
            $new_module['module_style'] = 'style1';
            $new_module['module_view'] = 1;
            $result = $model_index_module->save($new_module);
            if($result) {
                $data['module_id'] = $result;
                $data['module_style'] = $new_module['module_style'];
                $data['module_view'] = $new_module['module_view'];
            } else {
                $data['result'] = FALSE;
                $data['message'] = '添加失败';
            }
        }
        echo json_encode($data);
    }

    /**
     * 模块删除
     */
    public function drop_page_moduleOp() {
        $data = array();
        $data['result'] = TRUE;
        $module_id = intval($_POST['module_id']);
        if(empty($module_id)) {
            $data['result'] = FALSE;
            $data['message'] = '参数错误';
        } else {
            $model_index_module = Model('cms_index_module');
            $result = $model_index_module->drop(array('module_id'=>$module_id));
            if(!$result) {
                $data['result'] = FALSE;
                $data['message'] = '删除失败';
            }
        }
        echo json_encode($data);
    }

    /**
     * 启用页面模块
     */
    public function update_page_module_showOp() {
        $update = array('module_state'=>1);
        $result = $this->update_page_module($update, $_POST['module_id']);
        echo $result;
    }

    /**
     * 关闭页面模块
     */
    public function update_page_module_hideOp() {
        $update = array('module_state'=>0);
        $result = $this->update_page_module($update, $_POST['module_id']);
        echo $result;
    }

    /**
     * 更新模块标题
     */
    public function update_page_module_titleOp() {
        $new_title = $_POST['value'];
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array('input'=>$new_title,'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"20",'message'=>Language::get('class_name_error')),
        );
        $error = $obj_validate->validate();
        if ($error != ''){
            echo json_encode(array('result'=>FALSE,'message'=>'标题名称不能为空且必须小于10个字'));
            die;
		} else {
            $update = array('module_title'=>$new_title);
            $result = $this->update_page_module($update, $_POST['id']);
            echo $result;
        }

    }

    /**
     * 更新模块主题
     */
    public function update_page_module_styleOp() {
        $update = array('module_style'=>$_POST['module_style']);
        $result = $this->update_page_module($update, $_POST['module_id']);
        echo $result;
    }

    /**
     * 更新模块显示样式
     */
    public function update_page_module_viewOp() {
        $update = array('module_view'=>$_POST['module_view']);
        $result = $this->update_page_module($update, $_POST['module_id']);
        echo $result;
    }

    /**
     * 更新页面模块
     */
    private function update_page_module($update, $module_id) {
        $data = array();
        $data['result'] = TRUE;
        $module_id = intval($module_id);
        if(empty($module_id)) {
            $data['result'] = FALSE;
            $data['message'] = '参数错误';
        } else {
            $model_index_module = Model('cms_index_module');
            $result = $model_index_module->modify($update, array('module_id'=>$module_id));
            if(!$result) {
                $data['result'] = FALSE;
                $data['message'] = '操作失败';
            }
        }
        return json_encode($data);
    }

    /**
     * 更新页面模块排序
     */
    public function update_page_module_indexOp() {
        $data = array();
        $data['result'] = TRUE;
        $page_module_id_string = $_POST['page_module_id_string'];
        if(!empty($page_module_id_string)) {
            $model_index_module = Model('cms_index_module');
            $page_module_id_array = explode(',', $page_module_id_string);
            $index = 0;
            foreach ($page_module_id_array as $module_id) {
                $result = $model_index_module->modify(array('module_sort'=>$index), array('module_id'=>$module_id));
                $index++;
            }
        }
        echo json_encode($data);
    }

    public function cms_index_previewOp() {
        $model_index_module = Model('cms_index_module');
        $module_list = $model_index_module->getList(array('module_state'=>1), null,'module_sort asc');
        for($i=0, $j=count($module_list); $i < $j; $i++) {
            $module_list[$i]['module_template'] = $this->get_module_template_path($module_list[$i]);
        }
        Tpl::output('module_list', $module_list);
		Tpl::showpage('cms_index.template', 'null_layout');
    }

    /**
     * 首页静态文件生成
     */
    public function cms_index_buildOp() {
        $data = array();
        $data['result'] = TRUE;
        $html_path = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'index_html'.DS;
        if(!is_dir($html_path)){
            if (!@mkdir($html_path, 0755)){
                $data = array();
                $data['result'] = FALSE;
                $data['message'] = Language::get('cms_index_build_fail');
                echo json_encode($data);die;
            }
        }
        $model_index_module = Model('cms_index_module');
        $module_list = $model_index_module->getList(array('module_state'=>1), null,'module_sort asc');
        for($i=0, $j=count($module_list); $i < $j; $i++) {
            $module_list[$i]['module_template'] = $this->get_module_template_path($module_list[$i]);
        }
        Tpl::output('module_list', $module_list);
        ob_start();
		Tpl::showpage('cms_index.template', 'null_layout');
        $result = file_put_contents($html_path.'index.html', ob_get_clean());
        if($result) {
            $this->log(Language::get('cms_log_index_build'), 1);
            $data['message'] = Language::get('cms_index_build_success');
        } else {
            $this->log(Language::get('cms_log_index_build'), 0);
            $data['message'] = Language::get('cms_index_build_fail');
        }
        echo json_encode($data);die;
    }

    /**
     * 保存自定义模块
     */
    public function save_moduleOp() {
        $data = array();
        $data['result'] = TRUE;
        if(empty($_POST['frame_name'])) {
            $data['result'] = FALSE;
            $data['message'] = '参数错误';
            echo json_encode($data);die;
        }

        //插入数据库
        $new_module = array();
        $new_module['module_title'] = empty($_POST['module_title'])?'自定义模块':$_POST['module_title'];
        $new_module['module_name'] = 'model'.strval(time());
        $new_module['module_type'] = $_POST['frame_name'];
        $new_module['module_class'] = 2;
        $model_module = Model('cms_module');
        $new_module_id = $model_module->save($new_module);

        //生成模板
        $model_module_frame = Model('cms_module_frame');
        $module_frame = $model_module_frame->getOne(array('frame_name'=>$_POST['frame_name']));
        Tpl::output('frame_structure', json_decode($module_frame['frame_structure'], TRUE));
        Tpl::output('frame_block', $_POST['frame_block']);
        if($_POST['module_display_title_state'] !== 'disable') {
            Tpl::output('module_display_title', TRUE);
        } else {
            Tpl::output('module_display_title', FALSE);
        }
        $html_path = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'module_template'.DS;
        if(!is_dir($html_path)){
            if (!@mkdir($html_path, 0755)){
                $data = array();
                $data['result'] = FALSE;
                $data['message'] = Language::get('cms_index_build_fail');
                echo json_encode($data);die;
            }
        }
        ob_start();
		Tpl::showpage('cms_module.template', 'null_layout');
        $result = file_put_contents($html_path.'cms_module.'.$new_module['module_name'].'.php', ob_get_clean());

        //返回数据
        if($result) {
            $new_module['module_id'] = $new_module_id;
            $data['module_item'] = $new_module;
            echo json_encode($data);die;
        } else {
            $data['result'] = FALSE;
            $data['message'] = '模块添加失败';
            echo json_encode($data);die;
        }
    }

    /**
     * 删除自定义模块
     */
    public function drop_moduleOp() {
        $data = array();
        $data['result'] = TRUE;
        $module_id = intval($_POST['module_id']);
        if($module_id <= 0) {
            $this->return_error('参数错误');
        }

        $model_cms_module = Model('cms_module');
        $module_detail = $model_cms_module->getOne(array('module_id'=>$module_id));

        //模块不存在或者是系统自带模块
        if(empty($module_detail) || intval($module_detail['module_class']) === 1) {
            $this->return_error('参数错误');
        }

        //删除模块数据库记录
        $model_cms_module->drop(array('module_id'=>$module_id));
        $model_cms_index_module = Model('cms_index_module');
        $model_cms_index_module->drop(array('module_name'=>$module_detail['module_name']));

        //删除模板文件
        $module_template = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'module_template'.DS.'cms_module.'.$module_detail['module_name'].'.php';
        if(is_file($module_template)) {
            @unlink($module_template);
        }

        $data['module_name'] = $module_detail['module_name'];
        echo json_encode($data);die;
    }

	/**
	 * cms首页模块编辑
	 */
	public function module_editOp() {
        $module_id = intval($_GET['module_id']);
        if(empty($module_id)) {
            showMessage(Language::get('param_error'),'','','error');
        }

        $model_index_module = Model('cms_index_module');
        $module_detail = $model_index_module->getOne(array('module_id'=>$module_id));
        Tpl::output('module_detail', $module_detail);

        //标签
        $model_tag = Model('cms_tag');
        $tag_list = $model_tag->getList(TRUE, null, 'tag_sort asc');
        Tpl::output('tag_list', $tag_list);

        //获取表单组件
        Tpl::output('module_template', $this->get_module_template_path($module_detail));

        //编辑标志，用于显示模板中的编辑功能
        Tpl::output('edit_flag', TRUE);

        $this->show_menu('module_edit');
        Tpl::showpage('cms_index_module.edit');
	}

    /**
     * cms首页模块保存
     */
    public function save_page_moduleOp() {
        $module_content = array();
        foreach($_POST as $key=>$value) {
            if($key !== 'module_id' && $key !== 'module_drop_image') {
                $module_content[$key] = stripslashes($value);
            }
        }

        if(!empty($_POST['module_drop_image']) && is_array($_POST['module_drop_image'])) {
            foreach ($_POST['module_drop_image'] as $value) {
                $this->image_drop($value);
            }
        }

        $model_cms_index_module = Model('cms_index_module');
        $result = $model_cms_index_module->modify(array('module_content'=>base64_encode(serialize($module_content))), array('module_id'=>$_POST['module_id']));

        if($result) {
            $this->log(Language::get('cms_log_index_edit').$_POST['module_id'], 1);
            showMessage(Language::get('nc_common_save_succ'), 'index.php?act=cms_index&op=cms_index');
        } else {
            $this->log(Language::get('cms_log_index_edit').$_POST['module_id'], 0);
            showMessage(Language::get('nc_common_save_fail'), '', '','error');
        }
    }

    /**
     * 首页图片上传
     */
    public function image_uploadOp() {
        $data = array();
        $data['status'] = 'success';
        if(!empty($_FILES['image_upload']['name'])) {
            $upload	= new UploadFile();
            $upload->set('default_dir',ATTACH_CMS.DS.'index');

            $result = $upload->upfile('image_upload');
            if(!$result) {
                $data['status'] = 'fail';
                $data['error'] = $upload->error;
            }
            $data['file_name'] = $upload->file_name;
            $data['file_url'] = getCMSIndexImageUrl($upload->file_name);
        }
 		if (strtoupper(CHARSET) == 'GBK'){
			$data = Language::getUTF8($data);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		}
        echo json_encode($data);
    }

    /**
     * 首页图片删除
     */
    private function image_drop($image_name) {
        $file = getCMSIndexImagePath($image_name);
        if(is_file($file)) {
            unlink($file);
        }
    }

    /**
     * 获取模块模板路径
     */
    private function get_module_template_path($module_detail) {
        if($module_detail['module_type'] === $module_detail['module_name']) {
            return 'cms_index_widget.'.$module_detail['module_type'].'.php';
        } else {
            return BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'module_template'.DS.'cms_module.'.$module_detail['module_name'].'.php';
        }
    }

    /**
     * 返回错误信息
     */
    private function return_error($message) {
        $data['result'] = FALSE;
        $data['message'] = $message;
        echo json_encode($data);die;
    }

    private function show_menu($menu_key) {
        $menu_array = array(
            'cms_index'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_manage'),'menu_url'=>'index.php?act=cms_index&op=cms_index'),
        );
        if($menu_key == 'module_edit') {
            $menu_array['module_edit'] = array('menu_type'=>'link','menu_name'=>Language::get('nc_edit'),'menu_url'=>'###');
        }
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }

}
