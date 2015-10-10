<?php
/**
 * cms文章专题
 *
 *
 *
 *
 */



defined('InShopNC') or exit('Access Invalid!');
class cms_specialControl extends SystemControl{

    const LINK_CMS_SPECIAL = 'index.php?act=cms_special&op=cms_special_list';
    //专题状态草稿箱
    const SPECIAL_STATE_DRAFT = 1;
    //专题状态待审核
    const SPECIAL_STATE_PUBLISHED = 2;

	public function __construct(){
		parent::__construct();
		Language::read('cms');
	}

	public function indexOp() {
        $this->cms_special_listOp();
	}

    /**
     * cms专题列表
     **/
    public function cms_special_listOp() {
        $model_special = Model('cms_special');
        $condition = array();
        $special_list = $model_special->getList($condition, 10, 'special_id desc');
        Tpl::output('show_page',$model_special->showpage(2));
        Tpl::output('list',$special_list);
        $this->show_menu('special_list');
        Tpl::output('special_state_list', $this->get_special_state_list());
        Tpl::showpage("cms_special.list");
    }

    /**
     * cms专题添加
     **/
    public function cms_special_addOp() {
        $model_special = Model('cms_special');
        $this->show_menu('special_add');
        Tpl::output('special_type_array', $model_special->getSpecialTypeArray());
        Tpl::showpage('cms_special.add');
    }

    /**
     * cms专题编辑
     */
    public function cms_special_editOp() {
        $special_id = intval($_GET['special_id']);
        if(empty($special_id)) {
            showMessage(Language::get('param_error'),'','','error');
        }

        $model_special = Model('cms_special');
        $special_detail = $model_special->getOne(array('special_id'=>$special_id));
        if(empty($special_detail)) {
            showMessage(Language::get('param_error'),'','','error');
        }

        Tpl::output('special_detail', $special_detail);
        Tpl::output('special_type_array', $model_special->getSpecialTypeArray());
        $this->show_menu('special_edit');
        Tpl::showpage('cms_special.add');
    }

    /**
     * cms专题保存
     **/
    public function cms_special_saveOp() {
        $param = array();
        $param['special_title'] = $_POST['special_title'];
        $special_image = $this->cms_special_image_upload('special_image');
        if(!empty($special_image)) {
            $param['special_image'] = $special_image;
            if(!empty($_POST['old_special_image'])) {
                $this->cms_special_image_drop($_POST['old_special_image']);
            }
        }
        $special_background = $this->cms_special_image_upload('special_background');
        if(!empty($special_background)) {
            $param['special_background'] = $special_background;
            if(!empty($_POST['old_special_background'])) {
                $this->cms_special_image_drop($_POST['old_special_background']);
            }
        }
        if(!empty($_POST['special_image_all'])) {
            $special_image_all = array();
            foreach ($_POST['special_image_all'] as $value) {
                $image = array();
                $image['image_name'] = $value;
                $special_image_all[] = $image;
            }
            $param['special_image_all'] = serialize($special_image_all);
        } else {
            $param['special_image_all'] = '';
        }
        $param['special_margin_top'] = intval($_POST['special_margin_top']);
        $param['special_content'] = $_POST['special_content'];
        $param['special_background_color'] = empty($_POST['special_background_color'])?'#FFFFFF':$_POST['special_background_color'];
        $param['special_repeat'] = empty($_POST['special_repeat'])?'no-repeat':$_POST['special_repeat'];
        $param['special_modify_time'] = time();
        $param['special_type'] = intval($_POST['special_type']);
        $admin_info = $this->getAdminInfo();
        $param['special_publish_id'] = $admin_info['id'];
        if($_POST['special_state'] == 'publish') {
            $param['special_state'] = 2;
        } else {
            $param['special_state'] = 1;
        }
        $model_special = Model('cms_special');
        if(empty($_POST['special_id'])) {
            $result = $model_special->save($param);
        } else {
            $model_special->modify($param, array('special_id'=>$_POST['special_id']));
            $result = $_POST['special_id'];
        }
        if($result) {
            if($_POST['special_state'] == 'publish') {
                $this->generate_html($result);
            }
            $this->log(Language::get('cms_log_special_save').$result, 1);
            showMessage(Language::get('nc_common_save_succ'), self::LINK_CMS_SPECIAL);
        } else {
            $this->log(Language::get('cms_log_special_save').$result, 0);
            showMessage(Language::get('nc_common_save_fail'), self::LINK_CMS_SPECIAL);
        }
    }

    /**
     * 专题详细页
     */
    public function cms_special_detailOp() {
        $this->get_cms_special_detail($_GET['special_id']);
    }

    private function get_cms_special_detail($special_id) {
        $model_special = Model('cms_special');
        $special_detail = $model_special->getOne(array('special_id'=>$special_id));
        Tpl::output('special_detail', $special_detail);
        Tpl::showpage('cms_special.detail', 'null_layout');
    }

    /**
     * cms生成静态文件
     */
    private function generate_html($special_id) {
        $html_path = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'special_html'.DS;
        if(!is_dir($html_path)){
            if (!@mkdir($html_path, 0755)){
                showMessage(Language::get('cms_special_build_fail'),'','','error');
            }
        }

        ob_start();
        $this->get_cms_special_detail($special_id);
        $result = file_put_contents($html_path.md5('special'.$special_id).'.html', ob_get_clean());
        if(!$result) {
            showMessage(Language::get('cms_special_build_fail'),'','','error');
        }
    }

    /**
     * cms专题删除
     */
    public function cms_special_dropOp() {
        $condition = array();
        $condition['special_id'] = array('in', $_POST['special_id']);
        $model_special = Model('cms_special');
        $special_list = $model_special->getList($condition);
        if(!empty($special_list)) {
            $html_path = BASE_UPLOAD_PATH.DS.ATTACH_CMS.DS.'special_html'.DS;
            foreach ($special_list as $value) {
                //删除图片
                $this->cms_special_image_drop($value['special_background']);
                $this->cms_special_image_drop($value['special_image']);
                $special_image_list = unserialize($value['special_image_all']);
                if(!empty($special_image_list)) {
                    foreach ($special_image_list as $value_image) {
                        $this->cms_special_image_drop($value_image['image_name']);
                    }
                }
                //删除静态文件
                $static_file = $html_path.md5('special'.$value['special_id']).'.html';
                if(is_file($static_file)) {
                    unlink($static_file);
                }
            }
        }
        $result = $model_special->drop($condition);
        if($result) {
            $this->log(Language::get('cms_log_special_drop').$_POST['special_id'], 1);
            showMessage(Language::get('nc_common_del_succ'),'');
        } else {
            $this->log(Language::get('cms_log_special_drop').$_POST['special_id'], 0);
            showMessage(Language::get('nc_common_del_fail'),'');
        }
    }

    /**
     * 上传图片
     */
    private function cms_special_image_upload($image) {
        if(!empty($_FILES[$image]['name'])) {
            $upload	= new UploadFile();
            $upload->set('default_dir',ATTACH_CMS.DS.'special');
            $result = $upload->upfile($image);
            if(!$result) {
                showMessage($upload->error);
            }
            return $upload->file_name;
        }
    }

    /**
     * 图片删除
     */
    private function cms_special_image_drop($image) {
        $file = getCMSSpecialImagePath($image);
        if(is_file($file)) {
            unlink($file);
        }
    }

    /**
     * 专题图片上传
     */
    public function special_image_uploadOp() {
        $data = array();
        $data['status'] = 'success';
        if(!empty($_FILES['special_image_upload']['name'])) {
            $upload	= new UploadFile();
            $upload->set('default_dir',ATTACH_CMS.DS.'special');

            $result = $upload->upfile('special_image_upload');
            if(!$result) {
                $data['status'] = 'fail';
                $data['error'] = $upload->error;
            }
            $data['file_name'] = $upload->file_name;
            $data['origin_file_name'] = $_FILES['special_image_upload']['name'];
            $data['file_url'] = getCMSSpecialImageUrl($upload->file_name);
        }
 		if (strtoupper(CHARSET) == 'GBK'){
			$data = Language::getUTF8($data);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		}
        echo json_encode($data);
    }

    /**
     * 专题图片删除
     */
    public function special_image_dropOp() {
        $data = array();
        $data['status'] = 'success';
        $this->cms_special_image_drop($_GET['image_name']);
        echo json_encode($data);
    }

    /**
     * 图片商品添加
     */
    public function goods_info_by_urlOp() {
        $url = urldecode($_GET['url']);
        if(empty($url)) {
            self::return_json(Language::get('param_error'),'false');
        }
        $model_goods_info = Model('goods_info_by_url');
        $result = $model_goods_info->get_goods_info_by_url($url);
        if($result) {
            self::echo_json($result);
        } else {
            self::return_json(Language::get('param_error'),'false');
        }
    }

    /**
     * 获取专题状态列表
     */
    private function get_special_state_list() {
        $array = array();
        $array[self::SPECIAL_STATE_DRAFT] = Language::get('cms_text_draft');
        $array[self::SPECIAL_STATE_PUBLISHED] = Language::get('cms_text_published');
        return $array;
    }


	private function return_json($message,$result='true') {
        $data = array();
        $data['result'] = $result;
        $data['message'] = $message;
        self::echo_json($data);
    }

    private function echo_json($data) {
        if (strtoupper(CHARSET) == 'GBK'){
            $data = Language::getUTF8($data);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
        }
        echo json_encode($data);
    }

    private function show_menu($menu_key) {
        $menu_array = array(
            'special_list'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_manage'),'menu_url'=>'index.php?act=cms_special&op=cms_special_list'),
            'special_add'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_new'),'menu_url'=>'index.php?act=cms_special&op=cms_special_add'),
            'special_edit'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_edit'),'menu_url'=>'###'),
        );
        if($menu_key != 'special_edit') {
            unset($menu_array['special_edit']);
        }
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }

}
