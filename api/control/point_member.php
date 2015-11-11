<?php
/**
 * 积分中心个人操作
 *
 *
 *
 */


defined('InShopNC') or exit('Access Invalid!');

class point_memberControl extends apiMemberControl
{

    public function __construct()
    {
        parent::__construct();
    }

    public function point_prod_listOp()
    {

        $model_pointprod = Model('pointprod');
        
        //展示状态
        $pgoodsshowstate_arr = $model_pointprod->getPgoodsShowState();
        //开启状态
        $pgoodsopenstate_arr = $model_pointprod->getPgoodsOpenState();
        $model_member = Model('member');
        //查询会员等级
        $membergrade_arr = $model_member->getMemberGradeArr();

        //查询兑换商品列表
        $where = array();
        $where['pgoods_show'] = $pgoodsshowstate_arr['show'][0];
        $where['pgoods_state'] = $pgoodsopenstate_arr['open'][0];
        //会员级别
        $level_filter = array();
        if (isset($_GET['level'])){
            $level_filter['search'] = intval($_GET['level']);
        }
        if (intval($_GET['isable']) == 1){
            $level_filter['isable'] = intval($this->member_info['level']);
        }
        if (count($level_filter) > 0){
            if (isset($level_filter['search']) && isset($level_filter['isable'])){
                $where['pgoods_limitmgrade'] = array(array('eq',$level_filter['search']),array('elt',$level_filter['isable']),'and');
            } elseif (isset($level_filter['search'])){
                $where['pgoods_limitmgrade'] = $level_filter['search'];
            } elseif (isset($level_filter['isable'])){
                $where['pgoods_limitmgrade'] = array('elt',$level_filter['isable']);
            } 
        }
        //查询仅我能兑换和所需积分
        $points_filter = array();
        if (intval($_GET['isable']) == 1){
            $points_filter['isable'] = $this->member_info['member_points'];
        }
        if (intval($_GET['points_min']) > 0){
            $points_filter['min'] = intval($_GET['points_min']);
        }
        if (intval($_GET['points_max']) > 0){
            $points_filter['max'] = intval($_GET['points_max']);
        }
        if (count($points_filter) > 0){
            asort($points_filter);
            if (count($points_filter) > 1){
                $points_filter = array_values($points_filter);
                $where['pgoods_points'] = array('between',array($points_filter[0],$points_filter[1]));
            } else {
                if ($points_filter['min']){
                    $where['pgoods_points'] = array('egt',$points_filter['min']);
                } elseif ($points_filter['max']) {
                    $where['pgoods_points'] = array('elt',$points_filter['max']);
                } elseif ($points_filter['isable']) {
                    $where['pgoods_points'] = array('elt',$points_filter['isable']);
                }
            }
        }

        //排序
        switch ($_GET['orderby']){
            case 'stimedesc':
                $orderby = 'pgoods_starttime desc,';
                break;
            case 'stimeasc':
                $orderby = 'pgoods_starttime asc,';
                break;
            case 'pointsdesc':
                $orderby = 'pgoods_points desc,';
                break;
            case 'pointsasc':
                $orderby = 'pgoods_points asc,';
                break;
        }
        $orderby .= 'pgoods_sort asc,pgoods_id desc';

        $pointprod_list = $model_pointprod->getPointProdList($where, '*', $orderby,'',20);
        output_data(array('list_pointsprod' => $pointprod_list));
    }

    public function point_infoOp()
    {
        $pid = intval($_GET['id']);
        if (!$pid){
            output_error("缺少id参数");
            die;
        }
        $model_pointprod = Model('pointprod');
        //查询兑换礼品详细
        $prodinfo = $model_pointprod->getOnlinePointProdInfo(array('pgoods_id'=>$pid));
        if (empty($prodinfo)){
            output_error("没有礼品详细信息");
            die;
        }
        //更新礼品浏览次数
        $tm_tm_visite_pgoods = cookie('tm_visite_pgoods');
        $tm_tm_visite_pgoods = $tm_tm_visite_pgoods?explode(',', $tm_tm_visite_pgoods):array();
        if (!in_array($pid, $tm_tm_visite_pgoods)){//如果已经浏览过该商品则不重复累计浏览次数 
            $result = $model_pointprod->editPointProdViewnum($pid);
            if ($result['state'] == true){//累加成功则cookie中增加该商品ID
                $tm_tm_visite_pgoods[] = $pid;
                // setNcCookie('tm_visite_pgoods',implode(',', $tm_tm_visite_pgoods));
            }
        }
        output_data(array('point_good_info' => $prodinfo));
    }

}
