<?php
/**
 * 快递模型
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class expressModel extends Model {
    public function __construct(){
        parent::__construct('express');
    }

    /**
	 * 查询快递列表
     *
	 * @param string $id 指定快递编号
     * @return array
	 */
    public function getExpressList() {
        return rkcache('express', true);
    }

    /**
     * 根据编号查询快递列表
     */
    public function getExpressListByID($id = null) {
        $express_list = rkcache('express', true);

        if(!empty($id)) {
            $id_array = explode(',', $id);
            foreach ($express_list as $key => $value) {
                if(!in_array($key, $id_array)) {
                    unset($express_list[$key]);
                }
            }
            return $express_list;
        } else {
            return array();
        }
    }

    /**
     * 查询详细信息
     */
    public function getExpressInfo($id) {
        $express_list = $this->getExpressList();
        return $express_list[$id];
    }
    /**
     * 根据快递公司ecode获得快递公司信息
     * @param $ecode string 快递公司编号
     * @return array 快递公司详情
     */
    public function getExpressInfoByECode($ecode){
        $ecode = trim($ecode);
        if (!$ecode){
            return array('state'=>false,'msg'=>'参数错误');
        }
        $express_list = $this->getExpressList();
        $express_info = array();
        if ($express_list){
            foreach ($express_list as $v){
                if ($v['e_code'] == $ecode){
                    $express_info = $v;
                }
            }
        }
        if (!$express_info){
            return array('state'=>false,'msg'=>'快递公司信息错误');
        } else {
            return array('state'=>true,'data'=>array('express_info'=>$express_info));
        }
    }
}

