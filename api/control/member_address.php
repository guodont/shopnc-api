<?php
/**
 * 我的地址
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */


defined('InShopNC') or exit('Access Invalid!');

class member_addressControl extends apiMemberControl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 地址列表
     */
    public function address_listOp()
    {
        $model_address = Model('address');
        $address_list = $model_address->getAddressList(array('member_id' => $this->member_info['member_id']));
        output_data(array('address_list' => $address_list));
    }

    /**
     * 地址详细信息
     */
    public function address_infoOp()
    {
        $address_id = intval($_POST['address_id']);

        $model_address = Model('address');

        $condition = array();
        $condition['address_id'] = $address_id;
        $address_info = $model_address->getAddressInfo($condition);
        if (!empty($address_id) && $address_info['member_id'] == $this->member_info['member_id']) {
            output_data(array('address_info' => $address_info));
        } else {
            output_error('地址不存在');
        }
    }

    /**
     * 删除地址
     */
    public function address_delOp()
    {
        $address_id = intval($_POST['address_id']);

        $model_address = Model('address');

        $condition = array();
        $condition['address_id'] = $address_id;
        $condition['member_id'] = $this->member_info['member_id'];
        $model_address->delAddress($condition);
        output_data('1');
    }

    /**
     * 新增地址
     */
    public function address_addOp()
    {
        $model_address = Model('address');

        $address_info = $this->_address_valid();

        $result = $model_address->addAddress($address_info);
        if ($result) {
            output_data(array('address_id' => $result));
        } else {
            output_error('保存失败');
        }
    }

    /**
     * 编辑地址
     */
    public function address_editOp()
    {
        $address_id = intval($_POST['address_id']);

        $model_address = Model('address');

        //验证地址是否为本人
        $address_info = $model_address->getOneAddress($address_id);
        if ($address_info['member_id'] != $this->member_info['member_id']) {
            output_error('参数错误');
        }

        $address_info = $this->_address_valid();

        $result = $model_address->editAddress($address_info, array('address_id' => $address_id));
        if ($result) {
            output_data('1');
        } else {
            output_error('保存失败');
        }
    }

    /**
     * 验证地址数据
     */
    private function _address_valid()
    {
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array("input" => $_POST["true_name"], "require" => "true", "message" => '姓名不能为空'),
            array("input" => $_POST["area_info"], "require" => "true", "message" => '地区不能为空'),
            array("input" => $_POST["address"], "require" => "true", "message" => '地址不能为空'),
            array("input" => $_POST['tel_phone'] . $_POST['mob_phone'], 'require' => 'true', 'message' => '联系方式不能为空')
        );
        $error = $obj_validate->validate();
        if ($error != '') {
            output_error($error);
        }

        $data = array();
        $data['member_id'] = $this->member_info['member_id'];
        $data['true_name'] = $_POST['true_name'];
        $data['area_id'] = intval($_POST['area_id']);
        $data['city_id'] = intval($_POST['city_id']);
        $data['area_info'] = $_POST['area_info'];
        $data['address'] = $_POST['address'];
        $data['tel_phone'] = $_POST['tel_phone'];
        $data['mob_phone'] = $_POST['mob_phone'];
        return $data;
    }

    /**
     * 地区列表
     */
    public function area_listOp()
    {
        $area_id = intval($_POST['area_id']);

        $model_area = Model('area');

        $condition = array();
        if ($area_id > 0) {
            $condition['area_parent_id'] = $area_id;
        } else {
            $condition['area_deep'] = 1;
        }
        $area_list = $model_area->getAreaList($condition, 'area_id,area_name');

        output_data(array('area_list' => $area_list));
    }

    public function area_list2Op()
    {

        $model_area = Model('area');

        $condition = array();

        $counties = $model_area->getAreaList($condition, 'area_id,area_name,area_parent_id,area_deep');

        $aress = $this->treeArray($counties);

        echo json_encode($aress);
    }


    /**
     * 生成树数组
     * @param  $data 从数据库出来select出来的数数组
     * @return  [{"id":1,"name":"Folder1", "children":[{"id":1,"name":"File1"}] }]
     * */
    function treeArray($data)
    {
        $result = array();
        //定义索引数组，用于记录节点在目标数组的位置，类似指针
        $p = array();

        foreach($data as $val)
        {
            if($val['area_parent_id'] == 0)
            {
                $i = count($result);
                $result[$i] = isset($p[$val['area_id']])? array_merge($val,$p[$val['area_id']]) : $val;
                $p[$val['area_id']] = & $result[$i];
            } else {
                if($val['area_deep'] == 2) {
                    $i = count($p[$val['area_parent_id']]['cities']);
                    $p[$val['area_parent_id']]['cities'][$i] = $val;
                    $p[$val['area_id']] = & $p[$val['area_parent_id']]['cities'][$i];
                } elseif ($val['area_deep'] == 3) {
                    $i = count($p[$val['area_parent_id']]['counties']);
                    $p[$val['area_parent_id']]['counties'][$i] = $val;
                    $p[$val['area_id']] = & $p[$val['area_parent_id']]['counties'][$i];
                }
            }
        }

        return $result;
    }

}
