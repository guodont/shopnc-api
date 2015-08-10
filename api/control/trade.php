<?php
/**
 * 交易（闲置）api
 * Created by PhpStorm.
 * User: guodont
 * Date: 15-8-4
 * Time: 上午11:02
 */

defined('InShopNC') or exit('Access Invalid!');
class tradeControl extends apiHomeControl {



    public function __construct() {
        parent::__construct();


    }


    /**
     * GET 用户的交易（闲置）
     */
    public function user_trade_listOp() {
        if(!isset($_GET['uid'])){
            output_error("缺少用户id参数");die;
        }
        //TODO 查找uid是否存在，不存在则输出错误信息
        $member_id = $_GET['uid'];
        /**
         * 实例化闲置物品模型
         */
        $model_store_goods	= Model('flea');
        /**
         * 闲置分页
         */
        $page = new Page();
        pagecmd('setEachNum',$this->page);
        $list_goods	= array();
        $search_array['member_id']	= $member_id;
        $search_array['keyword']	= trim($_GET['keyword']);
        $search_array['order']	= 'goods_id desc';
        $list_goods	= $model_store_goods->listGoods($search_array,$this->page,'');

        if(is_array($list_goods) and !empty($list_goods)) {
            foreach ($list_goods as $key => $val) {
                $list_goods[$key]['goods_image'] = $list_goods[$key]['goods_image'] == '' ? '' : UPLOAD_SITE_URL.'/'.ATTACH_MALBUM.'/'.$_SESSION['member_id'].'/'.str_replace('_1024', '_240', $val['goods_image']);
            }
        }else{
            output_error("没有交易信息");die;
        }
        $pageCount = pagecmd('gettotalpage',$this->page);
        output_data(array('trades'=>$list_goods),mobile_page($pageCount));
    }


    /**
     * GET 所有交易列表
     */
    public function trade_listOp(){
        $flea_model		= Model('flea');
        $member_model	= Model('member');
        $condition = array();
        /**
         * 闲置物品显示模块
         */
        $page = new Page();
        pagecmd('setEachNum',$this->page);
        $pageCount = pagecmd('gettotalpage',$this->page);
        $listgoods	= $flea_model->listGoods($condition, $page);
//        var_dump($listgoods);
        if($listgoods){
            foreach($listgoods as $replace_key => $replace_val){
                $listgoods[$replace_key]['member_info']		= $flea_model->statistic($replace_val['member_id']);
                if($listgoods[$replace_key]['member_info']['member_avatar']){
                    $listgoods[$replace_key]['member_info']['avatar']	= ATTACH_AVATAR.'/'.$listgoods[$replace_key]['member_info']['member_avatar'];
                }else{
                    $listgoods[$replace_key]['member_info']['avatar']	= TEMPLATES_PATH.'/images/default_user_portrait.gif';
                }

                if($replace_val['goods_image']){
                    $listgoods[$replace_key]['image_url']	= UPLOAD_SITE_URL.DS.ATTACH_MALBUM.'/'.$_SESSION['member_id'].'/'.$replace_val['goods_image'];
                }else{
                    $listgoods[$replace_key]['image_url']	= SHOP_TEMPLATES_URL.'/images/member/default_image.png';
                }

                $exge='/<[^>]*>|\s+/';
                $listgoods[$replace_key]['explain']	= preg_replace($exge,'',$replace_val['goods_body']);
                $listgoods[$replace_key]['time']	= $this->time_comb(intval($replace_val['goods_add_time']));
                switch($replace_val['flea_quality']){
                    case 10:
                        $quality	= Language::get('flea_index_new');
                        break;
                    case 9:
                        $quality	= Language::get('flea_index_almost_new');
                        break;
                    case 8:
                        $quality	= Language::get('flea_index_gently_used');
                        break;
                    default;
                        $quality	= Language::get('flea_index_old');
                        break;
                }
                $listgoods[$replace_key]['quality']	= $quality;
            }
        }else{
            output_error("暂无交易");
        }
        output_data(array('trade_list'=>$listgoods),mobile_page($pageCount));
    }

    /**
     * GET 某分类下的交易
     */

    //TODO

    /**
     * GET 交易详情
     */

    //TODO

    private function time_comb($goods_add_time){
        $now_time	= time();
        $last_time	= $now_time - $goods_add_time;
        if($last_time>2592000)	return intval($last_time/2592000).Language::get('flea_index_mouth');
        if($last_time>86400)	return intval($last_time/86400).Language::get('flea_index_day');
        if($last_time>3600)		return intval($last_time/3600).Language::get('flea_index_hour');
        if($last_time>60)		return intval($last_time/60).Language::get('flea_index_minute');
        return $last_time.Language::get('flea_index_seconds');
    }





}