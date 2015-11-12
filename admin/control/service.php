<?php
/**
 * 服务管理
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
class serviceControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('service,goods,');
	}


    /**
     * 分类管理
     **/
    public function personalclass_listOp() {
        $this->class_list('personal');
    }

    private function class_list($type) {
        $model_class = Model("micro_{$type}_class");
        $list = $model_class->getList(TRUE);
        Tpl::output('list',$list);
        $menu_function = "show_menu_{$type}_class";
        $this->{$menu_function}("{$type}_class_list");
        Tpl::showpage("microshop_{$type}_class.list");
    }

    /**
     * 分类添加
     **/
    public function personalclass_addOp() {
        $this->show_menu_personal_class('personal_class_add');
        Tpl::showpage('microshop_personal_class.add');
    }


    /**
     * 分类编辑
     **/
    public function personalclass_editOp() {
        $this->class_edit('personal');
    }

    private function class_edit($type) {
        $class_id = intval($_GET['class_id']);
        if(empty($class_id)) {
            showMessage(Language::get('param_error'),'','','error');
        }
        $model_class = Model("micro_{$type}_class");
        $condition = array();
        $condition['class_id'] = $class_id;
        $class_info = $model_class->getOne($condition);
        Tpl::output('class_info',$class_info);

        $menu_function = "show_menu_{$type}_class";
        $this->{$menu_function}("{$type}_class_edit");
        Tpl::showpage("microshop_{$type}_class.add");
    }

    /**
     * 分类保存
     **/
    public function personalclass_saveOp() {
        $this->class_save('personal');
    }

    /**
     * 分类保存
     **/
    private function class_save($type) {

        $obj_validate = new Validate();
        $validate_array = array(
            array('input'=>$_POST['class_name'],'require'=>'true',"validator"=>"Length","min"=>"1","max"=>"10",'message'=>Language::get('class_name_error')),
            array('input'=>$_POST['class_sort'],'require'=>'true','validator'=>'Range','min'=>0,'max'=>255,'message'=>Language::get('class_sort_error')),
        );
        if($type == 'goods') {
            $validate_array[] = array('input'=>$_POST['class_parent_id'],'require'=>'true','validator'=>'Number','message'=>Language::get('parent_id_error'));
        }
        $obj_validate->validateparam = $validate_array;
        $error = $obj_validate->validate();
        if ($error != ''){
            showMessage(Language::get('error').$error,'','','error');
        }

        $param = array();
        $param['class_name'] = trim($_POST['class_name']);
        if(isset($_POST['class_parent_id']) && intval($_POST['class_parent_id']) > 0) {
            $param['class_parent_id'] = $_POST['class_parent_id'];
        }
        if(isset($_POST['class_keyword'])) {
            $param['class_keyword'] = $_POST['class_keyword'];
        }
        $param['class_sort'] = intval($_POST['class_sort']);
        if(!empty($_FILES['class_image']['name'])) {
            $upload	= new UploadFile();
            $upload->set('default_dir',ATTACH_MICROSHOP);
            $result = $upload->upfile('class_image');
            if(!$result) {
                showMessage($upload->error);
            }
            $param['class_image'] = $upload->file_name;
            //删除老图片
            if(!empty($_POST['old_class_image'])) {
                $old_image = BASE_UPLOAD_PATH.DS.ATTACH_MICROSHOP.DS.$_POST['old_class_image'];
                if(is_file($old_image)) {
                    unlink($old_image);
                }
            }
        }

        $model_class = Model("micro_{$type}_class");
        if(isset($_POST['class_id']) && intval($_POST['class_id']) > 0) {
            $result = $model_class->modify($param,array('class_id'=>$_POST['class_id']));
        } else {
            $result = $model_class->save($param);
        }
        if($result) {
            showMessage(Language::get('class_add_success'),"index.php?act=service&op={$type}class_list");
        } else {
            showMessage(Language::get('class_add_fail'),"index.php?act=service&op={$type}class_list",'','error');
        }

    }

    /*
     * ajax修改分类排序
     */
    public function personalclass_sort_updateOp() {
        $this->update_class_sort('personal');
    }
    private function update_class_sort($type) {
        if(intval($_GET['id']) <= 0) {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));
            die;
        }
        $new_sort = intval($_GET['value']);
        if ($new_sort > 255){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('class_sort_error')));
            die;
        } else {
            $model_class = Model("micro_{$type}_class");
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

    /*
     * ajax修改分类名称
     */
    public function personalclass_name_updateOp() {
        $this->update_class_name('personal');
    }
    private function update_class_name($type) {
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
            $model_class = Model("micro_{$type}_class");
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
     * 分类删除
     **/
     public function personalclass_dropOp() {

        $class_id = trim($_POST['class_id']);
        $model_class = Model('micro_personal_class');
        $condition = array();
        $condition['class_id'] = array('in',$class_id);
        //删除分类图片
        $list = $model_class->getList($condition);
        if(!empty($list)) {
            foreach ($list as $value) {
                //删除老图片
                if(!empty($value['class_image'])) {
                    $old_image = BASE_UPLOAD_PATH.DS.ATTACH_MICROSHOP.DS.$value['class_image'];
                    if(is_file($old_image)) {
                        unlink($old_image);
                    }
                }
            }
        }

        $result = $model_class->drop($condition);
        if($result) {
            showMessage(Language::get('class_drop_success'),'');
        } else {
            showMessage(Language::get('class_drop_fail'),'','','error');
        }

     }


	/**
	 * 管理
	 */
	public function service_manageOp() {
		$lang	= Language::getLangContent();
		$model_goods = Model('service');
		/**
		 * 推荐，编辑，删除
		 */
		if ($_POST['form_submit'] == 'ok'){
			if (!empty($_POST['del_id'])){
				$model_goods->dropGoods(implode(',',$_POST['del_id']));
				showMessage($lang['goods_index_del_succ']);
			}else {
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
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$goods_list = $model_goods->listGoods($condition,$page);
		
		
		/**
		 * 取单位分类
		*/
		$model_class = Model('company_class');
		$class_list = $model_class->getClassList($condition);
		$tmp_class_name = array();
		if (is_array($class_list)){
			foreach ($class_list as $k => $v){
		    $tmp_class_name[$v['class_id']] = $v['class_name'];
			}
		}
		
		Tpl::output('search',$_GET);
		Tpl::output('goods_class',$goods_class);
		Tpl::output('goods_list',$goods_list);
		Tpl::output('page',$page->show());
		Tpl::output('class_list',$class_list);
		Tpl::showpage('service.manage');
    }

    /**
     * 删除
     */
    public function personal_dropOp() {
        $model = Model('micro_personal');
        $condition = array();
        $condition['personal_id'] = array('in',trim($_POST['personal_id']));

        //删除图片
        $list = $model->getList($condition);
        if(!empty($list)) {
            foreach ($list as $personal_info) {
                //计数
                $model_micro_member_info = Model('micro_member_info');
                $model_micro_member_info->updateMemberPersonalCount($personal_info['commend_member_id'],'-');

                $image_array = explode(',',$personal_info['commend_image']);
                foreach ($image_array as $value) {
                    //删除原始图片
                    $image_name = BASE_UPLOAD_PATH.DS.ATTACH_MICROSHOP.DS.$personal_info['commend_member_id'].DS.$value;
                    if(is_file($image_name)) {
                        unlink($image_name);
                    }
                    //删除列表图片
                    $ext = explode('.', $value);
                    $ext = $ext[count($ext) - 1];
                    $image_name = BASE_UPLOAD_PATH.DS.ATTACH_MICROSHOP.DS.$personal_info['commend_member_id'].DS.$value.'_list.'.$ext;
                    if(is_file($image_name)) {
                        unlink($image_name);
                    }
                    $image_name = BASE_UPLOAD_PATH.DS.ATTACH_MICROSHOP.DS.$personal_info['commend_member_id'].DS.$value.'_tiny.'.$ext;
                    if(is_file($image_name)) {
                        unlink($image_name);
                    }
                }
            }
        }

        $result = $model->drop($condition);
        if($result) {
            showMessage(Language::get('nc_common_del_succ'),'');
        } else {
            showMessage(Language::get('nc_common_del_fail'),'','','error');
        }
    }

	/**
	 * 添加服务
	 */
	public function service_addOp(){
		$lang	= Language::getLangContent();
		/**
		 * 实例化商品分类模型
		 */
		$model_class		= Model('flea_class');
		$goods_class		= $model_class->getTreeClassList(1);
		Tpl::output('goods_class',$goods_class);
		/**
		 * 地区 
		 */
	
		$goods_image_path	= UPLOAD_SITE_URL.DS.ATTACH_MALBUM.'/'.$_SESSION['member_id'].'/';	//店铺商品图片目录地址
		Tpl::output('goods_image_path',$goods_image_path);
		Tpl::output('item_id','');
		//查询会员信息
		Tpl::output('menu_sign','flea');
		Tpl::output('menu_sign_url','index.php?act=member_flea');
		Tpl::output('menu_sign1','add_flea_goods');
        Tpl::showpage('service.add');
    }


    /**
     * 更新排序
     */
    public function personal_sort_updateOp() {
        $this->update_microshop_sort('micro_personal','personal_id');
    }

    private function update_microshop_sort($model_name,$key_name) {
        if(intval($_GET['id']) <= 0) {
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('param_error')));
            die;
        }
        $new_sort = intval($_GET['value']);
        if ($new_sort > 255){
            echo json_encode(array('result'=>FALSE,'message'=>Language::get('microshop_sort_error')));
            die;
        } else {
            $model_class = Model($model_name);
            $result = $model_class->modify(array('microshop_sort'=>$new_sort),array($key_name=>$_GET['id']));
            if($result) {
                echo json_encode(array('result'=>TRUE,'message'=>'nc_common_op_succ'));
                die;
            } else {
                echo json_encode(array('result'=>FALSE,'message'=>Language::get('nc_common_op_fail')));
                die;
            }
        }
    }

    /**
     * 评论管理
     */
	public function comment_manageOp() {
        $condition = array();
        if(!empty($_GET['comment_id'])) {
            $condition['comment_id'] = intval($_GET['comment_id']);
        }
        if(!empty($_GET['member_name'])) {
            $condition['member_name'] = array('like','%'.trim($_GET['member_name']).'%');
        }
        if(!empty($_GET['comment_type'])) {
            $condition['comment_type'] = intval($_GET['comment_type']);
        }
        if(!empty($_GET['comment_object_id'])) {
            $condition['comment_object_id'] = intval($_GET['comment_object_id']);
        }
        if(!empty($_GET['comment_message'])) {
            $condition['comment_message'] = array('like','%'.trim($_GET['comment_message']).'%');
        }
        $model_comment = Model("micro_comment");
        $comment_list = $model_comment->getListWithUserInfo($condition,10,'comment_time desc');
        Tpl::output('list',$comment_list);
        Tpl::output('show_page',$model_comment->showpage(2));
        $this->show_menu('comment_manage');
        Tpl::showpage('microshop_comment.manage');
    }

    /**
     * 评论删除
     */
    public function comment_dropOp() {
        $model = Model('micro_comment');
        $condition = array();
        $condition['comment_id'] = array('in',trim($_POST['comment_id']));
        $result = $model->drop($condition);
        if($result) {
            showMessage(Language::get('nc_common_del_succ'),'');
        } else {
            showMessage(Language::get('nc_common_del_fail'),'','','error');
        }
    }

	/**
	 * ajax操作
	 */
	public function ajaxOp(){

		switch ($_GET['branch']){
            //推荐
			case 'order_online':
                if(intval($_GET['id']) > 0) {
                    $model= Model('micro_goods');
                    $condition['commend_id'] = intval($_GET['id']);
                    $update[$_GET['column']] = trim($_GET['value']);
                    $model->modify($update,$condition);
                    echo 'true';die;
                } else {
                    echo 'false';die;
                }
                break;
            //推荐
			case 'personal_commend':
                if(intval($_GET['id']) > 0) {
                    $model= Model('micro_personal');
                    $condition['personal_id'] = intval($_GET['id']);
                    $update[$_GET['column']] = trim($_GET['value']);
                    $model->modify($update,$condition);
                    echo 'true';die;
                } else {
                    echo 'false';die;
                }
                break;
            //店铺街推荐
			case 'store_commend':
                if(intval($_GET['id']) > 0) {
                    $model= Model('micro_store');
                    $condition['shop_store_id'] = intval($_GET['id']);
                    $update[$_GET['column']] = trim($_GET['value']);
                    $model->modify($update,$condition);
                    echo 'true';die;
                } else {
                    echo 'false';die;
                }
                break;
            //分类推荐
			case 'class_commend':
                if(intval($_GET['id']) > 0) {
                    $model= Model('micro_goods_class');
                    $condition['class_id'] = intval($_GET['id']);
                    $update[$_GET['column']] = trim($_GET['value']);
                    $model->modify($update,$condition);
                    echo 'true';die;
                } else {
                    echo 'false';die;
                }
                break;
			case 'pay_online':
				$this->log(L('flea_pass_cerify').'['.intval($_GET['id']).']');
			case 'commend':
				$model_goods = Model('service');
				$update_array = array();
				$update_array[$_GET['column']] = $_GET['value'];
				$model_goods->updateGoods($update_array,$_GET['id']);
				echo 'true';
				break;
			case 'service_show':
				$model_goods = Model('service');
				$update_array = array();
				$update_array[$_GET['column']] = $_GET['value'];
				$model_goods->updateGoods($update_array,$_GET['id']);
				echo 'true';
				break;				
			case 'service_name':
				$model_goods = Model('service');
				$update_array = array();
				$update_array[$_GET['column']] = $_GET['value'];
				$model_goods->updateGoods($update_array,$_GET['id']);
				echo 'true';exit;
				break;	
		}
	}

    /**
     * 微商城菜单
     */
    private function show_menu($menu_key) {
        $menu_array = array(
            "{$menu_key}"=>array('menu_type'=>'link','menu_name'=>Language::get('nc_manage'),'menu_url'=>'index.php?act=service&op='.$menu_key),
        );
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }

    private function show_menu_goods_class($menu_key) {
        $menu_array = array(
            'goods_class_list'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_manage'),'menu_url'=>'index.php?act=service&op=goodsclass_list'),
            'goods_class_add'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_new'),'menu_url'=>'index.php?act=service&op=goodsclass_add'),
        );
        if($menu_key == 'goods_class_edit') {
            $menu_array['goods_class_edit'] = array('menu_type'=>'link','menu_name'=>Language::get('nc_edit'),'menu_url'=>'###');
        }
        if($menu_key == 'goods_class_binding') {
            $menu_array['goods_class_binding'] = array('menu_type'=>'link','menu_name'=>Language::get('microshop_goods_class_binding'),'menu_url'=>'###');
        }
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }

    private function show_menu_personal_class($menu_key) {
        $menu_array = array(
            'personal_class_list'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_manage'),'menu_url'=>'index.php?act=service&op=personalclass_list'),
            'personal_class_add'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_new'),'menu_url'=>'index.php?act=service&op=personalclass_add'),
        );
        if($menu_key == 'personal_class_edit') {
            $menu_array['personal_class_edit'] = array('menu_type'=>'link','menu_name'=>Language::get('nc_edit'),'menu_url'=>'###');
        }
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }

    private function show_menu_store($menu_key) {
        $menu_array = array(
            'store_manage'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_manage'),'menu_url'=>'index.php?act=service&op=store_manage'),
            'store_add'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_new'),'menu_url'=>'index.php?act=service&op=store_add'),
        );
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }

    private function show_menu_adv($menu_key) {
        $menu_array = array(
            'adv_manage'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_manage'),'menu_url'=>'index.php?act=service&op=adv_manage'),
            'adv_add'=>array('menu_type'=>'link','menu_name'=>Language::get('nc_new'),'menu_url'=>'index.php?act=service&op=adv_add'),
        );

        if($menu_key == 'adv_edit') {
            $menu_array['adv_edit'] = array('menu_type'=>'link','menu_name'=>Language::get('nc_edit'),'menu_url'=>'###');
            unset($menu_array['adv_add']);
        }
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }

}

