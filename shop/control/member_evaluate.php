<?php
/**
 * 会员中心——买家评价
 ***/


defined('InShopNC') or exit('Access Invalid!');
class member_evaluateControl extends BaseMemberControl{
    public function __construct(){
        parent::__construct() ;
        Language::read('member_layout,member_evaluate');
        Tpl::output('pj_act','member_evaluate');
    }

    /**
     * 订单添加评价
     */
    public function addOp(){
        $order_id = intval($_GET['order_id']);
        if (!$order_id){
            showMessage(Language::get('wrong_argument'),'index.php?act=member_order','html','error');
        }

        $model_order = Model('order');
        $model_store = Model('store');
        $model_evaluate_goods = Model('evaluate_goods');
        $model_evaluate_store = Model('evaluate_store');

        //获取订单信息
        $order_info = $model_order->getOrderInfo(array('order_id' => $order_id));
        //判断订单身份
        if($order_info['buyer_id'] != $_SESSION['member_id']) {
            showMessage(Language::get('wrong_argument'),'index.php?act=member_order','html','error');
        }
        //订单为'已收货'状态，并且未评论
        $order_info['evaluate_able'] = $model_order->getOrderOperateState('evaluation',$order_info);
        if (empty($order_info) || !$order_info['evaluate_able']){
            showMessage(Language::get('member_evaluation_order_notexists'),'index.php?act=member_order','html','error');
        }

        //查询店铺信息
        $store_info = $model_store->getStoreInfoByID($order_info['store_id']);
        if(empty($store_info)){
            showMessage(Language::get('member_evaluation_store_notexists'),'index.php?act=member_order','html','error');
        }

        //获取订单商品
        $order_goods = $model_order->getOrderGoodsList(array('order_id'=>$order_id));
        if(empty($order_goods)){
            showMessage(Language::get('member_evaluation_order_notexists'),'index.php?act=member_order','html','error');
        }

        //判断是否为页面
        if (!$_POST){
            for ($i = 0, $j = count($order_goods); $i < $j; $i++) {
                $order_goods[$i]['goods_image_url'] = cthumb($order_goods[$i]['goods_image'], 60, $store_info['store_id']);
            }
            
            //处理积分、经验值计算说明文字
            $ruleexplain = '';
            $exppoints_rule = C("exppoints_rule")?unserialize(C("exppoints_rule")):array();
            $exppoints_rule['exp_comments'] = intval($exppoints_rule['exp_comments']);
            $points_comments = intval(C('points_comments'));
            if ($exppoints_rule['exp_comments'] > 0 || $points_comments > 0){
                $ruleexplain .= '评价完成将获得';
                if ($exppoints_rule['exp_comments'] > 0){
                    $ruleexplain .= (' “'.$exppoints_rule['exp_comments'].'经验值”');
                }
                if ($points_comments > 0){
                    $ruleexplain .= (' “'.$points_comments.'积分”');
                }
                $ruleexplain .= '。';
            }
            Tpl::output('ruleexplain', $ruleexplain);
                        
            //不显示左菜单
            Tpl::output('left_show','order_view');
            Tpl::output('order_info',$order_info);
            Tpl::output('order_goods',$order_goods);
            Tpl::output('store_info',$store_info);
            Tpl::showpage('evaluation.add');
        }else {
            $evaluate_goods_array = array();
            $goodsid_array = array();
            foreach ($order_goods as $value){
                //如果未评分，默认为5分
                $evaluate_score = intval($_POST['goods'][$value['goods_id']]['score']);
                if($evaluate_score <= 0 || $evaluate_score > 5) {
                    $evaluate_score = 5;
                }
                //默认评语
                $evaluate_comment = $_POST['goods'][$value['goods_id']]['comment'];
                if(empty($evaluate_comment)) {
                    $evaluate_comment = '不错哦';
                }

                $evaluate_goods_info = array();
                $evaluate_goods_info['geval_orderid'] = $order_id;
                $evaluate_goods_info['geval_orderno'] = $order_info['order_sn'];
                $evaluate_goods_info['geval_ordergoodsid'] = $value['rec_id'];
                $evaluate_goods_info['geval_goodsid'] = $value['goods_id'];
                $evaluate_goods_info['geval_goodsname'] = $value['goods_name'];
                $evaluate_goods_info['geval_goodsprice'] = $value['goods_price'];
                $evaluate_goods_info['geval_goodsimage'] = $value['goods_image'];
                $evaluate_goods_info['geval_scores'] = $evaluate_score;
                $evaluate_goods_info['geval_content'] = $evaluate_comment;
                $evaluate_goods_info['geval_isanonymous'] = $_POST['anony']?1:0;
                $evaluate_goods_info['geval_addtime'] = TIMESTAMP;
                $evaluate_goods_info['geval_storeid'] = $store_info['store_id'];
                $evaluate_goods_info['geval_storename'] = $store_info['store_name'];
                $evaluate_goods_info['geval_frommemberid'] = $_SESSION['member_id'];
                $evaluate_goods_info['geval_frommembername'] = $_SESSION['member_name'];

                $evaluate_goods_array[] = $evaluate_goods_info;
                
                $goodsid_array[] = $value['goods_id'];
            }
            $model_evaluate_goods->addEvaluateGoodsArray($evaluate_goods_array, $goodsid_array);

            $store_desccredit = intval($_POST['store_desccredit']);
            if($store_desccredit <= 0 || $store_desccredit > 5) {
                $store_desccredit= 5;
            }
            $store_servicecredit = intval($_POST['store_servicecredit']);
            if($store_servicecredit <= 0 || $store_servicecredit > 5) {
                $store_servicecredit = 5;
            }
            $store_deliverycredit = intval($_POST['store_deliverycredit']);
            if($store_deliverycredit <= 0 || $store_deliverycredit > 5) {
                $store_deliverycredit = 5;
            }
//             //添加店铺评价
            if (!$store_info['is_own_shop']) {
                $evaluate_store_info = array();
                $evaluate_store_info['seval_orderid'] = $order_id;
                $evaluate_store_info['seval_orderno'] = $order_info['order_sn'];
                $evaluate_store_info['seval_addtime'] = time();
                $evaluate_store_info['seval_storeid'] = $store_info['store_id'];
                $evaluate_store_info['seval_storename'] = $store_info['store_name'];
                $evaluate_store_info['seval_memberid'] = $_SESSION['member_id'];
                $evaluate_store_info['seval_membername'] = $_SESSION['member_name'];
                $evaluate_store_info['seval_desccredit'] = $store_desccredit;
                $evaluate_store_info['seval_servicecredit'] = $store_servicecredit;
                $evaluate_store_info['seval_deliverycredit'] = $store_deliverycredit;
            }
            $model_evaluate_store->addEvaluateStore($evaluate_store_info);

            //更新订单信息并记录订单日志
            $state = $model_order->editOrder(array('evaluation_state'=>1), array('order_id' => $order_id));
            $model_order->editOrderCommon(array('evaluation_time'=>TIMESTAMP), array('order_id' => $order_id));
            if ($state){
                $data = array();
                $data['order_id'] = $order_id;
                $data['log_role'] = 'buyer';
                $data['log_msg'] = L('order_log_eval');
                $model_order->addOrderLog($data);
            }

            //添加会员积分
            if (C('points_isuse') == 1){
                $points_model = Model('points');
                $points_model->savePointsLog('comments',array('pl_memberid'=>$_SESSION['member_id'],'pl_membername'=>$_SESSION['member_name']));
            }
            //添加会员经验值
            Model('exppoints')->saveExppointsLog('comments',array('exp_memberid'=>$_SESSION['member_id'],'exp_membername'=>$_SESSION['member_name']));;
            
            showDialog(Language::get('member_evaluation_evaluat_success'),'index.php?act=member_order', 'succ');
        }
    }

    /**
     * 虚拟商品评价
     */
    public function add_vrOp(){
        $order_id = intval($_GET['order_id']);
        if (!$order_id){
            showMessage(Language::get('wrong_argument'),'index.php?act=member_vr_order','html','error');
        }

        $model_order = Model('vr_order');
        $model_store = Model('store');
        $model_evaluate_goods = Model('evaluate_goods');
        $model_evaluate_store = Model('evaluate_store');
    
        //获取订单信息
        $order_info = $model_order->getOrderInfo(array('order_id' => $order_id));
        //判断订单身份
        if($order_info['buyer_id'] != $_SESSION['member_id']) {
            showMessage(Language::get('wrong_argument'),'index.php?act=member_vr_order','html','error');
        }
        //订单为'已收货'状态，并且未评论
        $order_info['evaluate_able'] = $model_order->getOrderOperateState('evaluation',$order_info);
        if (!$order_info['evaluate_able']){
            showMessage(Language::get('member_evaluation_order_notexists'),'index.php?act=member_vr_order','html','error');
        }

        //查询店铺信息
        $store_info = $model_store->getStoreInfoByID($order_info['store_id']);
        if(empty($store_info)){
            showMessage(Language::get('member_evaluation_store_notexists'),'index.php?act=member_vr_order','html','error');
        }
        $order_goods = array($order_info);
    
        //判断是否为页面
        if (!$_POST){
            $order_goods[0]['goods_image_url'] = cthumb($order_info['goods_image'], 60, $order_info['store_id']);
            
            //处理积分、经验值计算说明文字
            $ruleexplain = '';
            $exppoints_rule = C("exppoints_rule")?unserialize(C("exppoints_rule")):array();
            $exppoints_rule['exp_comments'] = intval($exppoints_rule['exp_comments']);
            $points_comments = intval(C('points_comments'));
            if ($exppoints_rule['exp_comments'] > 0 || $points_comments > 0){
                $ruleexplain .= '评价完成将获得';
                if ($exppoints_rule['exp_comments'] > 0){
                    $ruleexplain .= (' “'.$exppoints_rule['exp_comments'].'经验值”');
                }
                if ($points_comments > 0){
                    $ruleexplain .= (' “'.$points_comments.'积分”');
                }
                $ruleexplain .= '。';
            }
            Tpl::output('ruleexplain', $ruleexplain);
            
            //不显示左菜单
            Tpl::output('left_show','order_view');
            Tpl::output('order_info',$order_info);
            Tpl::output('order_goods',$order_goods);
            Tpl::output('store_info',$store_info);
            Tpl::showpage('evaluation.add');
        }else {
            $evaluate_goods_array = array();
            $goodsid_array = array();
            foreach ($order_goods as $value){
                //如果未评分，默认为5分
                $evaluate_score = intval($_POST['goods'][$value['goods_id']]['score']);
                if($evaluate_score <= 0 || $evaluate_score > 5) {
                    $evaluate_score = 5;
                }
                //默认评语
                $evaluate_comment = $_POST['goods'][$value['goods_id']]['comment'];
                if(empty($evaluate_comment)) {
                    $evaluate_comment = '不错哦';
                }
    
                $evaluate_goods_info = array();
                $evaluate_goods_info['geval_orderid'] = $order_id;
                $evaluate_goods_info['geval_orderno'] = $order_info['order_sn'];
                $evaluate_goods_info['geval_ordergoodsid'] = $order_id;
                $evaluate_goods_info['geval_goodsid'] = $value['goods_id'];
                $evaluate_goods_info['geval_goodsname'] = $value['goods_name'];
                $evaluate_goods_info['geval_goodsprice'] = $value['goods_price'];
                $evaluate_goods_info['geval_goodsimage'] = $value['goods_image'];
                $evaluate_goods_info['geval_scores'] = $evaluate_score;
                $evaluate_goods_info['geval_content'] = $evaluate_comment;
                $evaluate_goods_info['geval_isanonymous'] = $_POST['anony']?1:0;
                $evaluate_goods_info['geval_addtime'] = TIMESTAMP;
                $evaluate_goods_info['geval_storeid'] = $store_info['store_id'];
                $evaluate_goods_info['geval_storename'] = $store_info['store_name'];
                $evaluate_goods_info['geval_frommemberid'] = $_SESSION['member_id'];
                $evaluate_goods_info['geval_frommembername'] = $_SESSION['member_name'];
    
                $evaluate_goods_array[] = $evaluate_goods_info;
    
                $goodsid_array[] = $value['goods_id'];
            }
            $model_evaluate_goods->addEvaluateGoodsArray($evaluate_goods_array, $goodsid_array);
    
//             $store_desccredit = intval($_POST['store_desccredit']);
//             if($store_desccredit <= 0 || $store_desccredit > 5) {
//                 $store_desccredit= 5;
//             }
//             $store_servicecredit = intval($_POST['store_servicecredit']);
//             if($store_servicecredit <= 0 || $store_servicecredit > 5) {
//                 $store_servicecredit = 5;
//             }
//             $store_deliverycredit = intval($_POST['store_deliverycredit']);
//             if($store_deliverycredit <= 0 || $store_deliverycredit > 5) {
//                 $store_deliverycredit = 5;
//             }
//          //添加店铺评价
//             if (!$store_info['is_own_shop']) {
//                 $evaluate_store_info = array();
//                 $evaluate_store_info['seval_orderid'] = $order_id;
//                 $evaluate_store_info['seval_orderno'] = $order_info['order_sn'];
//                 $evaluate_store_info['seval_addtime'] = time();
//                 $evaluate_store_info['seval_storeid'] = $store_info['store_id'];
//                 $evaluate_store_info['seval_storename'] = $store_info['store_name'];
//                 $evaluate_store_info['seval_memberid'] = $_SESSION['member_id'];
//                 $evaluate_store_info['seval_membername'] = $_SESSION['member_name'];
//                 $evaluate_store_info['seval_desccredit'] = $store_desccredit;
//                 $evaluate_store_info['seval_servicecredit'] = $store_servicecredit;
//                 $evaluate_store_info['seval_deliverycredit'] = $store_deliverycredit;
//                 $model_evaluate_store->addEvaluateStore($evaluate_store_info);
//             }

            //更新订单信息并记录订单日志
            $state = $model_order->editOrder(array('evaluation_state'=>1,'evaluation_time'=>TIMESTAMP), array('order_id' => $order_id));
    
            //添加会员积分
            if (C('points_isuse') == 1){
                $points_model = Model('points');
                $points_model->savePointsLog('comments',array('pl_memberid'=>$_SESSION['member_id'],'pl_membername'=>$_SESSION['member_name']));
            }
            //添加会员经验值
            Model('exppoints')->saveExppointsLog('comments',array('exp_memberid'=>$_SESSION['member_id'],'exp_membername'=>$_SESSION['member_name']));;
    
            showDialog(Language::get('member_evaluation_evaluat_success'),'index.php?act=member_vr_order', 'succ');
        }
    }

    /**
     * 评价列表
     */
    public function listOp(){
        $model_evaluate_goods = Model('evaluate_goods');

        $condition = array();
        $condition['geval_frommemberid'] = $_SESSION['member_id'];
        $goodsevallist = $model_evaluate_goods->getEvaluateGoodsList($condition, 10, 'geval_id desc');
        Tpl::output('goodsevallist',$goodsevallist);
        Tpl::output('show_page',$model_evaluate_goods->showpage());

        Tpl::showpage('evaluation.index');
    }

    public function add_imageOp() {
        $geval_id = intval($_GET['geval_id']);

        $model_evaluate_goods = Model('evaluate_goods');
        $model_store = Model('store');
        $model_sns_alumb = Model('sns_album');

        $geval_info = $model_evaluate_goods->getEvaluateGoodsInfoByID($geval_id);

        if(!empty($geval_info['geval_image'])) {
            showMessage('该商品已经发表过晒单', '', '', 'error');
        }

        if($geval_info['geval_frommemberid'] != $_SESSION['member_id']) {
            showMessage(L('param_error'), '', '', 'error');
        }
        Tpl::output('geval_info', $geval_info);

        $store_info = $model_store->getStoreInfoByID($geval_info['geval_storeid']);
        Tpl::output('store_info', $store_info);

        $ac_id = $model_sns_alumb->getSnsAlbumClassDefault($_SESSION['member_id']);
        Tpl::output('ac_id', $ac_id);

        //不显示左菜单
        Tpl::output('left_show','order_view');
        Tpl::showpage('evaluation.add_image');
    }

    public function add_image_saveOp() {
        $geval_id = intval($_POST['geval_id']);
        $geval_image = '';
        foreach ($_POST['evaluate_image'] as $value) {
            if(!empty($value)) {
                $geval_image .= $value . ',';
            }
        }
        $geval_image = rtrim($geval_image, ',');

        $model_evaluate_goods = Model('evaluate_goods');

        $geval_info = $model_evaluate_goods->getEvaluateGoodsInfoByID($geval_id);
        if(empty($geval_info)) {
            showDialog(L('param_error'));
        }
        if($geval_info['geval_frommemberid'] != $_SESSION['member_id']) {
            showDialog(L('param_error'));
        }

        $update = array();
        $update['geval_image'] = $geval_image;
        $condition = array();
        $condition['geval_id'] = $geval_id;
        $result = $model_evaluate_goods->editEvaluateGoods($update, $condition);

        list($sns_image) = explode(',', $geval_image);
        $goods_url = urlShop('goods', 'index', array('goods_id' => $geval_info['geval_goodsid']));
        //同步到sns
        $content = "
            <div class='fd-media'>
            <div class='goodsimg'><a target=\"_blank\" href=\"{$goods_url}\"><img src=\"".snsThumb($sns_image, 240)."\" title=\"{$geval_info['geval_goodsname']}\" alt=\"{$geval_info['geval_goodsname']}\"></a></div>
            <div class='goodsinfo'>
            <dl>
            <dt><a target=\"_blank\" href=\"{$goods_url}\">{$geval_info['geval_goodsname']}</a></dt>
            <dd>价格".Language::get('nc_colon').Language::get('currency').$geval_info['geval_goodsprice']."</dd>
            <dd><a target=\"_blank\" href=\"{$goods_url}\">去看看</a></dd>
            </dl>
            </div>
            </div>
            ";

        $tracelog_model = Model('sns_tracelog');
        $insert_arr = array();
        $insert_arr['trace_originalid'] = '0';
        $insert_arr['trace_originalmemberid'] = '0';
        $insert_arr['trace_memberid'] = $_SESSION['member_id'];
        $insert_arr['trace_membername'] = $_SESSION['member_name'];
        $insert_arr['trace_memberavatar'] = $_SESSION['member_avatar'];
        $insert_arr['trace_title'] = '发表了商品晒单';
        $insert_arr['trace_content'] = $content;
        $insert_arr['trace_addtime'] = TIMESTAMP;
        $insert_arr['trace_state'] = '0';
        $insert_arr['trace_privacy'] = 0;
        $insert_arr['trace_commentcount'] = 0;
        $insert_arr['trace_copycount'] = 0;
        $insert_arr['trace_from'] = '1';
        $result = $tracelog_model->tracelogAdd($insert_arr);

        if($result) {
            showDialog(L('nc_common_save_succ'), urlShop('member_evaluate', 'list'), 'succ');
        } else {
            showDialog(L('nc_common_save_succ'), urlShop('member_evaluate', 'list'));
        }
    }
}
