<?php
/**
 * 商品对比功能
 *
 
 */



defined('InShopNC') or exit('Access Invalid!');

class compareControl extends BaseHomeControl{
    const MAXNUM = 4;//最大的商品比较数量

    public function __construct() {
        parent::__construct ();
    }
    /**
     * 商品对比详细页面
     */
    public function indexOp() {
        $gids = trim($_GET['gids']);
        if(!$gids){
            $gids = trim(cookie('comparegoods'));
        }
        $gid_arrtmp = $gids?explode(',',$gids):array();
        if(!empty($gid_arrtmp)){
            foreach($gid_arrtmp as $k=>$v){
                $gid_arr[] = intval($v);
            }
        }
        $model = Model('goods');
        $compare_list = array();//对比商品数组
        if($gid_arr){
            //查询商品信息
            $goods_list = $gcommon_id_arr = array();
            $goods_listtmp = $model->getGoodsList(array('goods_id'=>array('in',$gid_arr),'goods_state'=>1,'goods_verify'=>1));
            if(!empty($goods_listtmp)){
                foreach($goods_listtmp as $k=>$v){
                    $v['goods_spec_arr'] = ($t = $v['goods_spec'])?unserialize($t):array();
                    $goods_list[$v['goods_id']] = $v;
                    $gcommon_id_arr[] = $v['goods_commonid'];
                }
            }
            if(!empty($gcommon_id_arr)){
                $gcommon_listtmp = $model->getGoodsCommonList(array('goods_commonid'=>array('in',$gcommon_id_arr)),'goods_commonid,brand_id,brand_name,goods_attr,spec_name,spec_value');
                if(!empty($gcommon_listtmp)){
                    foreach($gcommon_listtmp as $k=>$v){
                        $v['goods_attr_arr'] = ($t = trim($v['goods_attr']))?unserialize($t):array();
                        $v['spec_name_arr'] = ($t = trim($v['spec_name']))?unserialize($t):array();
                        $v['spec_value_arr'] = ($t = trim($v['spec_value']))?unserialize($t):array();
                        $gcommon_list[$v['goods_commonid']] = $v;
                    }
                }
            }
            if($goods_list && $gcommon_list){
                foreach($goods_list as $k=>$v){
                    $goods_list[$k] = array_merge($goods_list[$k],$gcommon_list[$v['goods_commonid']]);
                }
            }
            //整理对比数组
            $compare_listtmp = array();
            foreach($gid_arr as $k=>$v){
                $compare_listtmp[] = $goods_list[$v];
            }
            //商品图片及名称
            $i = 0;
            $compare_list[$i]['key'] = 'goodsinfo';
            $compare_list[$i]['name'] = '商品图片';
            for ($j=0; $j<self::MAXNUM; $j++){
                $compare_list[$i][] = $compare_listtmp[$j]?array('goods_id'=>$compare_listtmp[$j]['goods_id'],'goods_name'=>$compare_listtmp[$j]['goods_name'],'goods_image'=>$compare_listtmp[$j]['goods_image'],'store_id'=>$compare_listtmp[$j]['store_id']):'';
            }
            $i++;
            //商品价格
            $compare_list[$i]['key'] = 'goodsprice';
            $compare_list[$i]['name'] = '商城价';
            for ($j=0; $j<self::MAXNUM; $j++){
                $compare_list[$i][] = $compare_listtmp[$j]?$compare_listtmp[$j]['goods_promotion_price']:'';
            }
            $i++;
            //品牌
            $compare_list[$i]['key'] = 'brand';
            $compare_list[$i]['name'] = '所属品牌';
            for ($j=0; $j<self::MAXNUM; $j++){
                $compare_list[$i][] = $compare_listtmp[$j]?($compare_listtmp[$j]['brand_id']?array('brand_id'=>$compare_listtmp[$j]['brand_id'],'brand_name'=>$compare_listtmp[$j]['brand_name']):'-'):'';
            }
            $i++;
            //所在地
            $area_name_array = Model('area')->getAreaNames();
            $compare_list[$i]['key'] = '';
            $compare_list[$i]['name'] = '所在地';
            for ($j=0; $j<self::MAXNUM; $j++){
                $compare_list[$i][] = $compare_listtmp[$j]?$area_name_array[$compare_listtmp[$j]['areaid_1']].' '.$area_name_array[$compare_listtmp[$j]['areaid_2']]:'';
            }
            $tmp = $compare_list[$i];
            unset($tmp['key'],$tmp['name']);
            $tmp = array_filter($tmp);
            $difftmp = array_diff($tmp,array($tmp[0]));
            if ($difftmp){
                $compare_list[$i]['isdiff'] = 1;
            } else {
                $compare_list[$i]['isdiff'] = 0;
            }
            unset($tmp,$difftmp);
            $i++;
            //发票信息
            $compare_list[$i]['key'] = '';
            $compare_list[$i]['name'] = '是否开增值税发票';
            for ($j=0; $j<self::MAXNUM; $j++){
                $compare_list[$i][] = $compare_listtmp[$j]?($compare_listtmp[$j]['goods_vat']==1?'是':'否'):'';
            }
            $tmp = $compare_list[$i];
            unset($tmp['key'],$tmp['name']);
            $tmp = array_filter($tmp);
            $difftmp = array_diff($tmp,array($tmp[0]));
            if ($difftmp){
                $compare_list[$i]['isdiff'] = 1;
            } else {
                $compare_list[$i]['isdiff'] = 0;
            }
            unset($tmp,$difftmp);
            $i++;
            //规格处理
            if ($compare_listtmp[0]['spec_name_arr'] && $compare_listtmp[0]['spec_value_arr']){
                foreach ($compare_listtmp[0]['spec_name_arr'] as $k=>$v){
                    $compare_list[$i]['key'] = '';
                    $compare_list[$i]['name'] = $v;
                    for ($j=0;$j<self::MAXNUM;$j++){
                        //对比商品记录是否存在
                        if ($compare_listtmp[$j]){
                            //处理规格值
                            if ($compare_listtmp[0]['spec_value_arr'][$k] && $compare_listtmp[$j]['goods_spec_arr']){
                                $tmp = array_values(array_intersect_assoc($compare_listtmp[0]['spec_value_arr'][$k],$compare_listtmp[$j]['goods_spec_arr']));
                                if ($tmp){
                                    $compare_list[$i][] = $tmp[0];
                                } else {
                                    $compare_list[$i][] = '-';
                                }
                            } else {
                                $compare_list[$i][] = '-';
                            }
                            unset($tmp);
                        } else {
                            $compare_list[$i][] = '';
                        }
                    }
                    $tmp = $compare_list[$i];
                    unset($tmp['key'],$tmp['name']);
                    $tmp = array_filter($tmp);
                    $difftmp = array_diff($tmp,array($tmp[0]));
                    if ($difftmp){
                        $compare_list[$i]['isdiff'] = 1;
                    } else {
                        $compare_list[$i]['isdiff'] = 0;
                    }
                    unset($tmp,$difftmp);
                    $i++;
                }
            }
            //属性处理
            if ($compare_listtmp[0]['goods_attr_arr'] && $compare_listtmp[0]['goods_attr_arr']){
                foreach ($compare_listtmp[0]['goods_attr_arr'] as $k=>$v){
                    $compare_list[$i]['key'] = '';
                    $compare_list[$i]['name'] = $v['name'];
                    for ($j=0;$j<self::MAXNUM;$j++){
                        //对比商品记录是否存在
                        if ($compare_listtmp[$j]){
                            if ($compare_listtmp[$j]['goods_attr_arr'][$k]){
                                $tmp = array_values($compare_listtmp[$j]['goods_attr_arr'][$k]);
                                $compare_list[$i][] = $tmp[1];
                                unset($tmp);
                            } else {
                                $compare_list[$i][] = '-';
                            }
                        } else {
                            $compare_list[$i][] = '';
                        }
                    }
                    $tmp = $compare_list[$i];
                    unset($tmp['key'],$tmp['name']);
                    $tmp = array_filter($tmp);
                    $difftmp = array_diff($tmp,array($tmp[0]));
                    if ($difftmp){
                        $compare_list[$i]['isdiff'] = 1;
                    } else {
                        $compare_list[$i]['isdiff'] = 0;
                    }
                    unset($tmp,$difftmp);
                    $i++;
                }
            }
        }
        //处理商品所属的最小分类
        if ($compare_listtmp[0]['gc_id_3']){
            $cate_id = $compare_listtmp[0]['gc_id_3'];
        } elseif ($compare_listtmp[0]['gc_id_2']){
            $cate_id = $compare_listtmp[0]['gc_id_2'];
        } else {
            $cate_id = $compare_listtmp[0]['gc_id_1'];
        }
        Tpl::output('compare_list', $compare_list);
        Tpl::output('cate_id', $cate_id);
        //隐藏右侧工具条中的对比功能
        Tpl::output('hidden_rtoolbar_compare', 1);
        Tpl::output('maxnum', self::MAXNUM);
        Tpl::showpage('compare');
    }
    /**
     * 增加对比商品
     */
    public function addcompareOp(){
        $gid = intval($_GET['id']);
        if ($gid <= 0){
            exit(json_encode(array('done'=>false,'msg'=>'参数错误')));
        }
        if (cookie('comparegoods')) {//如果cookie已经存在
            $comparegoods_str = cookie('comparegoods');
            if (get_magic_quotes_gpc()) {
                $comparegoods_str = stripslashes($comparegoods_str); //去除斜杠
            }
            if ($comparegoods_str){
                $comparegoods_arr = explode(',',$comparegoods_str);
                if (count($comparegoods_arr) >= self::MAXNUM){
                    exit(json_encode(array('done'=>false,'msg'=>'对比栏已满，您可以删除不需要的栏内商品再继续添加哦！')));
                }
                $comparegoods_arr[] = $gid;
                $comparegoods_arr = array_unique($comparegoods_arr);
            }
        } else {
            $comparegoods_arr[] = $gid;
        }
        $comparegoods_str = $comparegoods_arr?implode(',',$comparegoods_arr):'';
        setNcCookie('comparegoods', $comparegoods_str);
        exit(json_encode(array('done'=>true,'msg'=>'')));
    }
    /**
     * 显示对比商品
     */
    public function showcompareOp(){
        $gids = cookie('comparegoods');
        $gid_arrtmp = $gids?explode(',',$gids):array();
        if(!empty($gid_arrtmp)){
            foreach($gid_arrtmp as $k=>$v){
                $gid_arr[] = intval($v);
            }
        }
        $model = Model('goods');
        $compare_list = array();//对比商品数组
        if($gid_arr){
            //查询商品信息
            $goods_list = array();
            $goodsid_arr = array();
            $goods_listtmp = $model->getGoodsList(array('goods_id'=>array('in',$gid_arr),'goods_state'=>1,'goods_verify'=>1),'goods_id,goods_commonid,goods_name,store_id,gc_id,gc_id_1,gc_id_2,gc_id_3,goods_promotion_price,goods_promotion_type,goods_image');
            if ($goods_listtmp){
                foreach ($goods_listtmp as $k=>$v){
                    $goods_list[$v['goods_id']] = $v;
                }
                foreach ($gid_arr as $v){
                    if ($goods_list[$v]){
                        $compare_list[] = $goods_list[$v];
                        $goodsid_arr[] = $v;
                    }
                }
                //更新cookie数据
                setNcCookie('comparegoods', $goodsid_arr?implode(',',$goodsid_arr):'');
            } else {
                //更新cookie数据
                setNcCookie('comparegoods','',-3600);
            }
        }
        Tpl::output('goodsid_str',$goodsid_arr?implode(',',$goodsid_arr):'');
        Tpl::output('compare_list', $compare_list);
        Tpl::output('freemaxnum', self::MAXNUM - count($compare_list));
        Tpl::showpage('compare_mini','null_layout');
    }
    /**
     * 获得已加入对比的商品ID
     */
    public function checkcompareOp(){
        $gids = cookie('comparegoods');
        $gid_arrtmp = $gids?explode(',',$gids):array();
        if(!empty($gid_arrtmp)){
            foreach($gid_arrtmp as $k=>$v){
                $gid_arr[] = intval($v);
            }
        }
        $model = Model('goods');
        $goodsid_arr = array();//对比商品ID数组
        if($gid_arr){
            //查询商品信息
            $goods_list = array();
            $goods_list = $model->getGoodsList(array('goods_id'=>array('in',$gid_arr),'goods_state'=>1,'goods_verify'=>1),'goods_id,goods_commonid,goods_name,store_id,gc_id,gc_id_1,gc_id_2,gc_id_3,goods_promotion_price,goods_promotion_type,goods_image');
            if ($goods_list){
                foreach ($goods_list as $k=>$v){
                    $goodsid_arr[] = $v['goods_id'];
                }
            }
        }
        echo json_encode($goodsid_arr);
    }
    /**
     * 清除对比栏
     */
    public function delcompareOp(){
        if (trim($_GET['gid']) == 'all'){
            $gid_arr = array();
        } else {
            $gids = cookie('comparegoods');
            $gid_arr = $gids?explode(',',$gids):array();
            $gid = intval($_GET['gid']);
            if ($gid > 0 && $gid_arr){
                unset($gid_arr[array_search($gid,$gid_arr)]);
            }
        }
        $gid_str = $gid_arr?implode(',',$gid_arr):'';
        //更新cookie数据
        if($gid_str){
            setNcCookie('comparegoods', $gid_str);
        } else {
            setNcCookie('comparegoods','',-3600);
        }
        exit(json_encode(array('done'=>true,'gid_str'=>$gid_str)));
    }
}
