<?php
/**
 * 服务管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');

class serviceControl extends SystemControl
{
    public function __construct()
    {
        parent::__construct();
        Language::read('service,goods,microshop,layout');
    }


    /**
     * 分类管理
     **/
    public function personalclass_listOp()
    {
        $this->class_list('personal');
    }

    private function class_list($type)
    {
        $model_class = Model("micro_{$type}_class");
        $list = $model_class->getList(TRUE);
        Tpl::output('list', $list);
        $menu_function = "show_menu_{$type}_class";
        $this->{$menu_function}("{$type}_class_list");
        Tpl::showpage("microshop_{$type}_class.list");
    }

    /**
     * 分类添加
     **/
    public function personalclass_addOp()
    {
        $this->show_menu_personal_class('personal_class_add');
        Tpl::showpage('microshop_personal_class.add');
    }


    /**
     * 分类编辑
     **/
    public function personalclass_editOp()
    {
        $this->class_edit('personal');
    }

    private function class_edit($type)
    {
        $class_id = intval($_GET['class_id']);
        if (empty($class_id)) {
            showMessage(Language::get('param_error'), '', '', 'error');
        }
        $model_class = Model("micro_{$type}_class");
        $condition = array();
        $condition['class_id'] = $class_id;
        $class_info = $model_class->getOne($condition);
        Tpl::output('class_info', $class_info);

        $menu_function = "show_menu_{$type}_class";
        $this->{$menu_function}("{$type}_class_edit");
        Tpl::showpage("microshop_{$type}_class.add");
    }

    /**
     * 分类保存
     **/
    public function personalclass_saveOp()
    {
        $this->class_save('personal');
    }

    /**
     * 分类保存
     **/
    private function class_save($type)
    {

        $obj_validate = new Validate();
        $validate_array = array(
            array('input' => $_POST['class_name'], 'require' => 'true', "validator" => "Length", "min" => "1", "max" => "10", 'message' => Language::get('class_name_error')),
            array('input' => $_POST['class_sort'], 'require' => 'true', 'validator' => 'Range', 'min' => 0, 'max' => 255, 'message' => Language::get('class_sort_error')),
        );
        if ($type == 'goods') {
            $validate_array[] = array('input' => $_POST['class_parent_id'], 'require' => 'true', 'validator' => 'Number', 'message' => Language::get('parent_id_error'));
        }
        $obj_validate->validateparam = $validate_array;
        $error = $obj_validate->validate();
        if ($error != '') {
            showMessage(Language::get('error') . $error, '', '', 'error');
        }

        $param = array();
        $param['class_name'] = trim($_POST['class_name']);
        if (isset($_POST['class_parent_id']) && intval($_POST['class_parent_id']) > 0) {
            $param['class_parent_id'] = $_POST['class_parent_id'];
        }
        if (isset($_POST['class_keyword'])) {
            $param['class_keyword'] = $_POST['class_keyword'];
        }
        $param['class_sort'] = intval($_POST['class_sort']);
        if (!empty($_FILES['class_image']['name'])) {
            $upload = new UploadFile();
            $upload->set('default_dir', ATTACH_MICROSHOP);
            $result = $upload->upfile('class_image');
            if (!$result) {
                showMessage($upload->error);
            }
            $param['class_image'] = $upload->file_name;
            //删除老图片
            if (!empty($_POST['old_class_image'])) {
                $old_image = BASE_UPLOAD_PATH . DS . ATTACH_MICROSHOP . DS . $_POST['old_class_image'];
                if (is_file($old_image)) {
                    unlink($old_image);
                }
            }
        }

        $model_class = Model("micro_{$type}_class");
        if (isset($_POST['class_id']) && intval($_POST['class_id']) > 0) {
            $result = $model_class->modify($param, array('class_id' => $_POST['class_id']));
        } else {
            $result = $model_class->save($param);
        }
        if ($result) {
            showMessage(Language::get('class_add_success'), "index.php?act=service&op={$type}class_list");
        } else {
            showMessage(Language::get('class_add_fail'), "index.php?act=service&op={$type}class_list", '', 'error');
        }

    }

    /*
     * ajax修改分类排序
     */
    public function personalclass_sort_updateOp()
    {
        $this->update_class_sort('personal');
    }

    private function update_class_sort($type)
    {
        if (intval($_GET['id']) <= 0) {
            echo json_encode(array('result' => FALSE, 'message' => Language::get('param_error')));
            die;
        }
        $new_sort = intval($_GET['value']);
        if ($new_sort > 255) {
            echo json_encode(array('result' => FALSE, 'message' => Language::get('class_sort_error')));
            die;
        } else {
            $model_class = Model("micro_{$type}_class");
            $result = $model_class->modify(array('class_sort' => $new_sort), array('class_id' => $_GET['id']));
            if ($result) {
                echo json_encode(array('result' => TRUE, 'message' => 'class_add_success'));
                die;
            } else {
                echo json_encode(array('result' => FALSE, 'message' => Language::get('class_add_fail')));
                die;
            }
        }
    }

    /*
     * ajax修改分类名称
     */
    public function personalclass_name_updateOp()
    {
        $this->update_class_name('personal');
    }

    private function update_class_name($type)
    {
        $class_id = intval($_GET['id']);
        if ($class_id <= 0) {
            echo json_encode(array('result' => FALSE, 'message' => Language::get('param_error')));
            die;
        }

        $new_name = trim($_GET['value']);
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array('input' => $new_name, 'require' => 'true', "validator" => "Length", "min" => "1", "max" => "10", 'message' => Language::get('class_name_error')),
        );
        $error = $obj_validate->validate();
        if ($error != '') {
            echo json_encode(array('result' => FALSE, 'message' => Language::get('class_name_error')));
            die;
        } else {
            $model_class = Model("micro_{$type}_class");
            $result = $model_class->modify(array('class_name' => $new_name), array('class_id' => $class_id));
            if ($result) {
                echo json_encode(array('result' => TRUE, 'message' => 'class_add_success'));
                die;
            } else {
                echo json_encode(array('result' => FALSE, 'message' => Language::get('class_add_fail')));
                die;
            }
        }

    }


    /**
     * 分类删除
     **/
    public function personalclass_dropOp()
    {

        $class_id = trim($_POST['class_id']);
        $model_class = Model('micro_personal_class');
        $condition = array();
        $condition['class_id'] = array('in', $class_id);
        //删除分类图片
        $list = $model_class->getList($condition);
        if (!empty($list)) {
            foreach ($list as $value) {
                //删除老图片
                if (!empty($value['class_image'])) {
                    $old_image = BASE_UPLOAD_PATH . DS . ATTACH_MICROSHOP . DS . $value['class_image'];
                    if (is_file($old_image)) {
                        unlink($old_image);
                    }
                }
            }
        }

        $result = $model_class->drop($condition);
        if ($result) {
            showMessage(Language::get('class_drop_success'), '');
        } else {
            showMessage(Language::get('class_drop_fail'), '', '', 'error');
        }

    }


    /**
     * 管理
     */
    public function service_manageOp()
    {
        $lang = Language::getLangContent();
        $model_goods = Model('service');
        /**
         * 推荐，编辑，删除
         */
        if ($_POST['form_submit'] == 'ok') {
            if (!empty($_POST['del_id'])) {
                $model_goods->dropGoods(implode(',', $_POST['del_id']));
                showMessage($lang['goods_index_del_succ']);
            } else {
                showMessage($lang['goods_index_choose_del']);
            }
            showMessage($lang['goods_index_argument_invalid']);
        }

        /**
         * 排序
         */
        $condition['keyword'] = trim($_GET['search_service_name']);
        $condition['brand_id'] = intval($_GET['search_brand_id']);
        $condition['gc_id'] = intval($_GET['cate_id']);

        /**
         * 分页
         */
        $page = new Page();
        $page->setEachNum(10);
        $page->setStyle('admin');

        /**
         * 取单位分类
         */
        $model_class = Model('company_class');
        $class_list = $model_class->getClassList($condition);
        $tmp_class_name = array();
        if (is_array($class_list)) {
            foreach ($class_list as $k => $v) {
                $tmp_class_name[$v['class_id']] = $v['class_name'];
            }
        }


        $goods_list = $model_goods->listGoods($condition, $page);
        foreach ($goods_list as $k => $v) {
            /**
             * 所属分类
             */
            if (@array_key_exists($v['gc_id'], $tmp_class_name)) {
                $goods_list[$k]['class_name'] = $tmp_class_name[$v['gc_id']];
            }
        }

        Tpl::output('search', $_GET);
        Tpl::output('goods_class', $goods_class);
        Tpl::output('goods_list', $goods_list);
        Tpl::output('page', $page->show());
        Tpl::output('class_list', $class_list);
        Tpl::showpage('service.manage');
    }

    /**
     * 删除
     */
    public function personal_dropOp()
    {
        $model = Model('micro_personal');
        $condition = array();
        $condition['personal_id'] = array('in', trim($_POST['personal_id']));

        //删除图片
        $list = $model->getList($condition);
        if (!empty($list)) {
            foreach ($list as $personal_info) {
                //计数
                $model_micro_member_info = Model('micro_member_info');
                $model_micro_member_info->updateMemberPersonalCount($personal_info['commend_member_id'], '-');

                $image_array = explode(',', $personal_info['commend_image']);
                foreach ($image_array as $value) {
                    //删除原始图片
                    $image_name = BASE_UPLOAD_PATH . DS . ATTACH_MICROSHOP . DS . $personal_info['commend_member_id'] . DS . $value;
                    if (is_file($image_name)) {
                        unlink($image_name);
                    }
                    //删除列表图片
                    $ext = explode('.', $value);
                    $ext = $ext[count($ext) - 1];
                    $image_name = BASE_UPLOAD_PATH . DS . ATTACH_MICROSHOP . DS . $personal_info['commend_member_id'] . DS . $value . '_list.' . $ext;
                    if (is_file($image_name)) {
                        unlink($image_name);
                    }
                    $image_name = BASE_UPLOAD_PATH . DS . ATTACH_MICROSHOP . DS . $personal_info['commend_member_id'] . DS . $value . '_tiny.' . $ext;
                    if (is_file($image_name)) {
                        unlink($image_name);
                    }
                }
            }
        }

        $result = $model->drop($condition);
        if ($result) {
            showMessage(Language::get('nc_common_del_succ'), '');
        } else {
            showMessage(Language::get('nc_common_del_fail'), '', '', 'error');
        }
    }

    /**
     * 添加服务
     */
    public function service_addOp()
    {
        $lang = Language::getLangContent();
        $model_service = Model('service');
        /**
         * 取单位分类
         */
        $model_class = Model('company_class');
        $class_list = $model_class->getClassList($condition);
        $tmp_class_name = array();
        if (is_array($class_list)) {
            foreach ($class_list as $k => $v) {
                $tmp_class_name[$v['class_id']] = $v['class_name'];
            }
        }
        /**
         * 单位列表
         */
        $model_depart = Model('member_depart');
        $depart_list = $model_depart->getTreedepartList(2);
        if (is_array($depart_list)) {
            $unset_sign = false;
            foreach ($depart_list as $k => $v) {
                $depart_list[$k]['depart_name'] = str_repeat("&nbsp;", $v['deep'] * 2) . $v['depart_name'];
            }
        }
        /**
         * 保存
         */
        if (chksubmit()) {
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["service_name"], "require" => "true", "message" => $lang['service_name_null']),
                array("input" => $_POST["gc_id"], "require" => "true", "message" => $lang['service_add_class_null']),
                array("input" => $_POST["service_price"], "require" => "true", 'validator' => 'Number', "message" => $lang['service_price_error']),
                array("input" => $_POST["service_now_price"], "require" => "true", 'validator' => 'Number', "message" => $lang['service_now_price_error']),
                array("input" => $_POST["service_pphone"], "require" => "true", 'validator' => 'Number', "message" => $lang['service_tel_number']),
                array("input" => $_POST["service_abstract"], 'require' => 'true', "message" => $lang['service_add_abstract_null']),
                array("input" => $_POST["service_content"], "require" => "true", "message" => $lang['service_add_content_null']),
                array("input" => $_POST["service_sort"], "require" => "true", 'validator' => 'Number', "message" => $lang['service_add_sort_int']),
            );
            $error = $obj_validate->validate();
            if ($error != '') {
                showMessage($error);
            } else {

                $insert_array = array();
                $insert_array['service_name'] = trim($_POST['service_name']);
                $insert_array['gc_id'] = intval($_POST['gc_id']);
                $insert_array['depart_id'] = intval($_POST['depart_id']);
                $insert_array['service_price'] = trim($_POST['service_price']);
                $insert_array['service_now_price'] = trim($_POST['service_now_price']);
                $insert_array['service_show'] = trim($_POST['service_show']);
                $insert_array['order_online'] = trim($_POST['service_order']);
                $insert_array['pay_online'] = trim($_POST['service_pay']);
                $insert_array['service_sort'] = trim($_POST['service_sort']);
                $insert_array['service_pname'] = trim($_POST['service_pname']);
                $insert_array['service_pphone'] = trim($_POST['service_pphone']);
                $insert_array['service_abstract'] = trim($_POST['service_abstract']);
                $insert_array['service_content'] = trim($_POST['service_content']);
                $insert_array['service_add_time'] = time();
                $result = $model_service->add($insert_array);
                if ($result) {
                    /**
                     * 更新图片信息ID
                     */
                    $model_upload = Model('upload');
                    if (is_array($_POST['file_id'])) {
                        foreach ($_POST['file_id'] as $k => $v) {
                            $v = intval($v);
                            $update_array = array();
                            $update_array['upload_id'] = $v;
                            $update_array['item_id'] = $result;
                            $model_upload->update($update_array);
                            unset($update_array);
                        }
                    }

                    $url = array(
                        array(
                            'url' => 'index.php?act=service&op=service_manage',
                            'msg' => "{$lang['service_add_tolist']}",
                        ),
                        array(
                            'url' => 'index.php?act=service&op=service_add&gc_id=' . intval($_POST['gc_id']),
                            'msg' => "{$lang['service_add_continueadd']}",
                        ),
                    );
                    $this->log(L('service_add_ok') . '[' . $_POST['service_name'] . ']', null);
                    showMessage("{$lang['service_add_ok']}", $url);
                } else {
                    showMessage("{$lang['service_add_fail']}");
                }
            }
        }

        /**
         * 模型实例化
         */
        $model_upload = Model('upload');
        $condition['upload_type'] = '8';
        $condition['item_id'] = '0';
        $file_upload = $model_upload->getUploadList($condition);
        if (is_array($file_upload)) {
            foreach ($file_upload as $k => $v) {
                $file_upload[$k]['upload_path'] = UPLOAD_SITE_URL . '/' . ATTACH_SERVICE . '/' . $file_upload[$k]['file_name'];
            }
        }

        Tpl::output('PHPSESSID', session_id());
        Tpl::output('gc_id', intval($_GET['gc_id']));
        Tpl::output('class_list', $class_list);
        Tpl::output('depart_list', $depart_list);
        Tpl::output('file_upload', $file_upload);
        Tpl::showpage('service.add');
    }

    /**
     * 服务编辑
     */
    public function service_editOp()
    {
        $lang = Language::getLangContent();
        $model_service = Model('service');

        /**
         * 取单位分类
         */
        $model_class = Model('company_class');
        $class_list = $model_class->getClassList($condition);
        $tmp_class_name = array();
        if (is_array($class_list)) {
            foreach ($class_list as $k => $v) {
                $tmp_class_name[$v['class_id']] = $v['class_name'];
            }
        }
        /**
         * 单位列表
         */
        $model_depart = Model('member_depart');
        $depart_list = $model_depart->getTreedepartList(2);
        if (is_array($depart_list)) {
            $unset_sign = false;
            foreach ($depart_list as $k => $v) {
                $depart_list[$k]['depart_name'] = str_repeat("&nbsp;", $v['deep'] * 2) . $v['depart_name'];
            }
        }

        if (chksubmit()) {
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["service_name"], "require" => "true", "message" => $lang['service_name_null']),
                array("input" => $_POST["gc_id"], "require" => "true", "message" => $lang['service_add_class_null']),
                array("input" => $_POST["service_pphone"], "require" => "true", 'validator' => 'Number', "message" => $lang['service_tel_number']),
                array("input" => $_POST["service_abstract"], 'require' => 'true', "message" => $lang['service_add_abstract_null']),
                array("input" => $_POST["service_content"], "require" => "true", "message" => $lang['service_add_content_null']),
                array("input" => $_POST["service_sort"], "require" => "true", 'validator' => 'Number', "message" => $lang['service_add_sort_int']),
            );
            $error = $obj_validate->validate();
            if ($error != '') {
                showMessage($error);
            } else {

                $update_array = array();
                $update_array['service_id'] = intval($_POST['service_id']);
                $update_array['service_name'] = trim($_POST['service_name']);
                $update_array['gc_id'] = intval($_POST['gc_id']);
                $update_array['depart_id'] = intval($_POST['depart_id']);
                $update_array['service_price'] = trim($_POST['service_price']);
                $update_array['service_now_price'] = trim($_POST['service_now_price']);
                $update_array['service_show'] = trim($_POST['service_show']);
                $update_array['order_online'] = trim($_POST['service_order']);
                $update_array['pay_online'] = trim($_POST['service_pay']);
                $update_array['service_sort'] = trim($_POST['service_sort']);
                $update_array['service_pname'] = trim($_POST['service_pname']);
                $update_array['service_pphone'] = trim($_POST['service_pphone']);
                $update_array['service_abstract'] = trim($_POST['service_abstract']);
                $update_array['service_content'] = trim($_POST['service_content']);
                $update_array['service_add_time'] = time();

                $result = $model_service->update($update_array);
                if ($result) {
                    /**
                     * 更新图片信息ID
                     */
                    $model_upload = Model('upload');
                    if (is_array($_POST['file_id'])) {
                        foreach ($_POST['file_id'] as $k => $v) {
                            $update_array = array();
                            $update_array['upload_id'] = intval($v);
                            $update_array['item_id'] = intval($_POST['service_id']);
                            $model_upload->update($update_array);
                            unset($update_array);
                        }
                    }

                    $url = array(
                        array(
                            'url' => $_POST['ref_url'],
                            'msg' => $lang['service_edit_back_to_list'],
                        ),
                        array(
                            'url' => 'index.php?act=service&op=service_edit&service_id=' . intval($_POST['service_id']),
                            'msg' => $lang['service_edit_edit_again'],
                        ),
                    );
                    $this->log(L('service_edit_succ') . '[' . $_POST['service_name'] . ']', null);
                    showMessage($lang['service_edit_succ'], $url);
                } else {
                    showMessage($lang['service_edit_fail']);
                }
            }
        }

        $service_array = $model_service->getOneservice(intval($_GET['service_id']));
        if (empty($service_array)) {
            showMessage($lang['param_error']);
        }

        /**
         * 模型实例化
         */
        $model_upload = Model('upload');
        $condition['upload_type'] = '8';
        $condition['item_id'] = $service_array['service_id'];
        $file_upload = $model_upload->getUploadList($condition);
        if (is_array($file_upload)) {
            foreach ($file_upload as $k => $v) {
                $file_upload[$k]['upload_path'] = UPLOAD_SITE_URL . '/' . ATTACH_SERVICE . '/' . $file_upload[$k]['file_name'];
            }
        }

        Tpl::output('PHPSESSID', session_id());
        Tpl::output('file_upload', $file_upload);
        Tpl::output('class_list', $class_list);
        Tpl::output('depart_list', $depart_list);
        Tpl::output('service_array', $service_array);
        Tpl::showpage('service.edit');
    }

    /**
     * 更新排序
     */
    public function personal_sort_updateOp()
    {
        $this->update_microshop_sort('micro_personal', 'personal_id');
    }

    private function update_microshop_sort($model_name, $key_name)
    {
        if (intval($_GET['id']) <= 0) {
            echo json_encode(array('result' => FALSE, 'message' => Language::get('param_error')));
            die;
        }
        $new_sort = intval($_GET['value']);
        if ($new_sort > 255) {
            echo json_encode(array('result' => FALSE, 'message' => Language::get('microshop_sort_error')));
            die;
        } else {
            $model_class = Model($model_name);
            $result = $model_class->modify(array('microshop_sort' => $new_sort), array($key_name => $_GET['id']));
            if ($result) {
                echo json_encode(array('result' => TRUE, 'message' => 'nc_common_op_succ'));
                die;
            } else {
                echo json_encode(array('result' => FALSE, 'message' => Language::get('nc_common_op_fail')));
                die;
            }
        }
    }

    /**
     * 服务图片上传
     */
    public function service_pic_uploadOp()
    {
        /**
         * 上传图片
         */
        $upload = new UploadFile();
        $upload->set('default_dir', ATTACH_SERVICE);
        $result = $upload->upfile('fileupload');
        if ($result) {
            $_POST['pic'] = $upload->file_name;
        } else {
            echo 'error';
            exit;
        }
        /**
         * 模型实例化
         */
        $model_upload = Model('upload');
        /**
         * 图片数据入库
         */
        $insert_array = array();
        $insert_array['file_name'] = $_POST['pic'];
        $insert_array['upload_type'] = '8';
        $insert_array['file_size'] = $_FILES['fileupload']['size'];
        $insert_array['upload_time'] = time();
        $insert_array['item_id'] = intval($_POST['item_id']);
        $result = $model_upload->add($insert_array);
        if ($result) {
            $data = array();
            $data['file_id'] = $result;
            $data['file_name'] = $_POST['pic'];
            $data['file_path'] = $_POST['pic'];
            /**
             * 整理为json格式
             */
            $output = json_encode($data);
            echo $output;
        }

    }

    /**
     * 管理
     */
    public function service_yuyueOp()
    {
        $lang = Language::getLangContent();
        $model_goods = Model('service_yuyue');
        /**
         * 推荐，编辑，删除
         */
        if ($_POST['form_submit'] == 'ok') {
            if (!empty($_POST['del_id'])) {
                $model_goods->dropGoods(implode(',', $_POST['del_id']));
                showMessage($lang['goods_index_del_succ']);
            } else {
                showMessage($lang['goods_index_choose_del']);
            }
            showMessage($lang['goods_index_argument_invalid']);
        }

        /**
         * 排序
         */
        $condition['keyword'] = trim($_GET['search_service_name']);
        $condition['brand_id'] = intval($_GET['search_brand_id']);
        $condition['gc_id'] = intval($_GET['cate_id']);

        /**
         * 分页
         */
        $page = new Page();
        $page->setEachNum(10);
        $page->setStyle('admin');

        /**
         * 取服务
         */
        $model_service = Model('service');
        $service_list = $model_service->Listgoods($condition);
        $tmp_service_name = array();
        if (is_array($service_list)) {
            foreach ($service_list as $k => $v) {
                $tmp_service_name[$v['service_id']] = $v['service_name'];
            }
        }


        $goods_list = $model_goods->listGoods($condition, $page);
        foreach ($goods_list as $k => $v) {
            /**
             * 所属服务
             */
            if (@array_key_exists($v['yuyue_service_id'], $tmp_service_name)) {
                $goods_list[$k]['service_name'] = $tmp_service_name[$v['yuyue_service_id']];
            }
        }

        Tpl::output('search', $_GET);
        Tpl::output('goods_list', $goods_list);
        Tpl::output('page', $page->show());
        Tpl::output('service_list', $service_list);
        Tpl::showpage('service_yuyue.manage');
    }


    /**
     * 服务安排
     */
    public function service_yuyue_editOp()
    {
        $lang = Language::getLangContent();
        $model_yuyue = Model('service_yuyue');

        if (chksubmit()) {
            /**
             * 验证
             */
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
                array("input" => $_POST["yuyue_status"], "require" => "true", "message" => $lang['yuyue_status']),
            );
            $error = $obj_validate->validate();
            if ($error != '') {
                showMessage($error);
            } else {

                $update_array = array();
                $update_array['yuyue_id'] = intval($_POST['yuyue_id']);
                $update_array['yuyue_status'] = intval($_POST['yuyue_status']);
                $update_array['yuyue_order_number'] = trim($_POST['yuyue_order_number']);
                $update_array['yuyue_pay_status'] = 1;
                $result = $model_yuyue->update($update_array);
                if ($result) {
                    $url = array(
                        array(
                            'url' => $_POST['ref_url'],
                            'msg' => $lang['service_edit_back_to_list'],
                        ),
                        array(
                            'url' => 'index.php?act=service&op=service_yuyue_edit&yuyue_id=' . intval($_POST['yuyue_id']),
                            'msg' => $lang['service_edit_edit_again'],
                        ),
                    );
                    $this->log(L('service_edit_succ') . '[' . $_POST['yuyue_title'] . ']', null);
                    showMessage($lang['service_yuyue_edit_success'], $url);
                } else {
                    showMessage($lang['service_yuyue_edit_fail']);
                }
            }
        }

        $service_yuyue_array = $model_yuyue->getOneyuyue(intval($_GET['yuyue_id']));
        if (empty($service_yuyue_array)) {
            showMessage($lang['param_error']);
        }


        Tpl::output('PHPSESSID', session_id());
        Tpl::output('service_yuyue_array', $service_yuyue_array);
        Tpl::showpage('service_yuyue.edit');
    }

    /**
     * 预约删除
     */
    public function service_yuyue_dropOp()
    {
        $model = Model('service_yuyue');
        $condition = array();
        $condition['yuyue_id'] = array('in', trim($_POST['yuyue_id']));
        $result = $model->drop($condition);
        if ($result) {
            showMessage(Language::get('nc_common_del_succ'), '');
        } else {
            showMessage(Language::get('nc_common_del_fail'), '', '', 'error');
        }
    }

    /**
     * ajax操作
     */
    public function ajaxOp()
    {

        switch ($_GET['branch']) {
            //店铺街推荐
            case 'store_commend':
                if (intval($_GET['id']) > 0) {
                    $model = Model('micro_store');
                    $condition['shop_store_id'] = intval($_GET['id']);
                    $update[$_GET['column']] = trim($_GET['value']);
                    $model->modify($update, $condition);
                    echo 'true';
                    die;
                } else {
                    echo 'false';
                    die;
                }
                break;
            //分类推荐
            case 'class_show':
                if (intval($_GET['id']) > 0) {
                    $model = Model('micro_personal_class');
                    $condition['class_id'] = intval($_GET['id']);
                    $update[$_GET['column']] = trim($_GET['value']);
                    $model->modify($update, $condition);
                    echo 'true';
                    break;
                } else {
                    echo 'false';
                    break;
                }
                break;
            case 'pay_online':
                $this->log(L('flea_pass_cerify') . '[' . intval($_GET['id']) . ']');
            case 'commend':
                $model_goods = Model('service');
                $update_array = array();
                $update_array[$_GET['column']] = $_GET['value'];
                $model_goods->updateGoods($update_array, $_GET['id']);
                echo 'true';
                break;
            case 'service_show':
                $model_goods = Model('service');
                $update_array = array();
                $update_array[$_GET['column']] = $_GET['value'];
                $model_goods->updateGoods($update_array, $_GET['id']);
                echo 'true';
                break;
            case 'service_name':
                $model_goods = Model('service');
                $update_array = array();
                $update_array[$_GET['column']] = $_GET['value'];
                $model_goods->updateGoods($update_array, $_GET['id']);
                echo 'true';
                exit;
                break;
            //预约开关
            case 'yuyue_status':
                $model_goods = Model('service_yuyue');
                $update_array = array();
                $update_array[$_GET['column']] = $_GET['value'];
                $model_goods->updateGoods($update_array, $_GET['id']);
                echo 'true';
                exit;
                break;
            //支付开关
            case 'yuyue_pay_status':
                $model_goods = Model('service_yuyue');
                $update_array = array();
                $update_array[$_GET['column']] = $_GET['value'];
                $model_goods->updateGoods($update_array, $_GET['id']);
                echo 'true';
                exit;
                break;
            //删除图片
            case 'del_file_upload':
                if (intval($_GET['file_id']) > 0) {
                    $model_upload = Model('upload');
                    /**
                     * 删除图片
                     */
                    $file_array = $model_upload->getOneUpload(intval($_GET['file_id']));
                    @unlink(BASE_UPLOAD_PATH . DS . ATTACH_SERVICE . DS . $file_array['file_name']);
                    /**
                     * 删除信息
                     */
                    $model_upload->del(intval($_GET['file_id']));
                    echo 'true';
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
                break;

        }
    }

    /**
     * 微商城菜单
     */
    private function show_menu($menu_key)
    {
        $menu_array = array(
            "{$menu_key}" => array('menu_type' => 'link', 'menu_name' => Language::get('nc_manage'), 'menu_url' => 'index.php?act=service&op=' . $menu_key),
        );
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu', $menu_array);
    }

    private function show_menu_goods_class($menu_key)
    {
        $menu_array = array(
            'goods_class_list' => array('menu_type' => 'link', 'menu_name' => Language::get('nc_manage'), 'menu_url' => 'index.php?act=service&op=goodsclass_list'),
            'goods_class_add' => array('menu_type' => 'link', 'menu_name' => Language::get('nc_new'), 'menu_url' => 'index.php?act=service&op=goodsclass_add'),
        );
        if ($menu_key == 'goods_class_edit') {
            $menu_array['goods_class_edit'] = array('menu_type' => 'link', 'menu_name' => Language::get('nc_edit'), 'menu_url' => '###');
        }
        if ($menu_key == 'goods_class_binding') {
            $menu_array['goods_class_binding'] = array('menu_type' => 'link', 'menu_name' => Language::get('microshop_goods_class_binding'), 'menu_url' => '###');
        }
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu', $menu_array);
    }

    private function show_menu_personal_class($menu_key)
    {
        $menu_array = array(
            'personal_class_list' => array('menu_type' => 'link', 'menu_name' => Language::get('nc_manage'), 'menu_url' => 'index.php?act=service&op=personalclass_list'),
            'personal_class_add' => array('menu_type' => 'link', 'menu_name' => Language::get('nc_new'), 'menu_url' => 'index.php?act=service&op=personalclass_add'),
        );
        if ($menu_key == 'personal_class_edit') {
            $menu_array['personal_class_edit'] = array('menu_type' => 'link', 'menu_name' => Language::get('nc_edit'), 'menu_url' => '###');
        }
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu', $menu_array);
    }

    private function show_menu_store($menu_key)
    {
        $menu_array = array(
            'store_manage' => array('menu_type' => 'link', 'menu_name' => Language::get('nc_manage'), 'menu_url' => 'index.php?act=service&op=store_manage'),
            'store_add' => array('menu_type' => 'link', 'menu_name' => Language::get('nc_new'), 'menu_url' => 'index.php?act=service&op=store_add'),
        );
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu', $menu_array);
    }

    private function show_menu_adv($menu_key)
    {
        $menu_array = array(
            'adv_manage' => array('menu_type' => 'link', 'menu_name' => Language::get('nc_manage'), 'menu_url' => 'index.php?act=service&op=adv_manage'),
            'adv_add' => array('menu_type' => 'link', 'menu_name' => Language::get('nc_new'), 'menu_url' => 'index.php?act=service&op=adv_add'),
        );

        if ($menu_key == 'adv_edit') {
            $menu_array['adv_edit'] = array('menu_type' => 'link', 'menu_name' => Language::get('nc_edit'), 'menu_url' => '###');
            unset($menu_array['adv_add']);
        }
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu', $menu_array);
    }

}

