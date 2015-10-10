<?php
/**
 * 会员中心——买家评价
 ***/


defined('InShopNC') or exit('Access Invalid!');
class member_goodsbrowseControl extends BaseMemberControl{
    public function __construct(){
        parent::__construct() ;
    }
    /**
     * 浏览历史列表
     */
    public function listOp(){
        $model = Model('goods_browse');
        //商品分类缓存
		$gc_list = Model('goods_class')->getGoodsClassForCacheModel();
        //查询浏览记录
        $where = array();
        $where['member_id'] = $_SESSION['member_id'];
        $gc_id = intval($_GET['gc_id']);
        if ($gc_id > 0){
            $where['gc_id_'.$gc_list[$gc_id]['depth']] = $gc_id;
        }
        $browselist_tmp = $model->getGoodsbrowseList($where, '', 20, 0, 'browsetime desc');
        $browselist = array();
        foreach ((array)$browselist_tmp as $k=>$v){
            $browselist[$v['goods_id']] = $v;
        }
        //查询商品信息
        $browselist_new = array();
        if ($browselist){
            $goods_list_tmp = Model('goods')->getGoodsList(array('goods_id' => array('in', array_keys($browselist))), 'goods_id, goods_name, goods_promotion_price,goods_promotion_type, goods_marketprice, goods_image, store_id, gc_id, gc_id_1, gc_id_2, gc_id_3');
            $goods_list = array();
            foreach ((array)$goods_list_tmp as $v){
                $goods_list[$v['goods_id']] = $v;
            }
            foreach ($browselist as $k=>$v){
                if ($goods_list[$k]){
                    $tmp = array();
                    $tmp = $goods_list[$k];
                    $tmp["browsetime"] = $v['browsetime'];                    
                    if (date('Y-m-d',$v['browsetime']) == date('Y-m-d',time())){
                        $tmp['browsetime_day'] = '今天';
                    } elseif (date('Y-m-d',$v['browsetime']) == date('Y-m-d',(time()-86400))){
                        $tmp['browsetime_day'] = '昨天';
                    } else {
                        $tmp['browsetime_day'] = date('Y年m月d日',$v['browsetime']);
                    }
                    $tmp['browsetime_text'] = $tmp['browsetime_day'].date('H:i',$v['browsetime']);
                    $browselist_new[] = $tmp;
                }
            }
        }

        //查询浏览记录商品分类
        $browseclass_list = $model->getGoodsbrowseList(array('member_id'=>$_SESSION['member_id']), 'gc_id, gc_id_1, gc_id_2, gc_id_3', 0, 0, 'gc_id desc', 'gc_id');
        $browseclass_arr = array();
        foreach((array)$browseclass_list as $k=>$v){
            if($v['gc_id_1'] > 0){
                $browseclass_arr[$v['gc_id_1']] = array('gc_name'=>$gc_list[$v['gc_id_1']]['gc_name'],'sonclass'=>array());
            }
            if($v['gc_id_2'] > 0){
                $browseclass_arr[$v['gc_id_1']]['sonclass'][$v['gc_id_2']] = array('gc_name'=>$gc_list[$v['gc_id_2']]['gc_name'],'sonclass'=>array());
            }
        }
        Tpl::output('browseclass_arr',$browseclass_arr);
        Tpl::output('browselist',$browselist_new);
        Tpl::output('show_page',$model->showpage());
        Tpl::showpage('member_goodsbrowse.index');
    }
    /**
     * 删除浏览历史
     */
    public function delOp(){
        $return_arr = array();
        $model = Model('goods_browse');
        if (trim($_GET['goods_id']) == 'all') {
            if ($model->delGoodsbrowse(array('member_id'=>$_SESSION['member_id']))){
                $return_arr = array('done'=>true);
            } else {
                $return_arr = array('done'=>false,'msg'=>'删除失败');
            }
        } elseif (intval($_GET['goods_id']) >= 0) {
            $goods_id = intval($_GET['goods_id']);
            if ($model->delGoodsbrowse(array('member_id'=>$_SESSION['member_id'],'goods_id'=>$goods_id))){
                $return_arr = array('done'=>true);
            } else {
                $return_arr = array('done'=>false,'msg'=>'删除失败');
            }
        } else {
            $return_arr = array('done'=>false,'msg'=>'参数错误');
        }
        echo json_encode($return_arr);
    }

}
