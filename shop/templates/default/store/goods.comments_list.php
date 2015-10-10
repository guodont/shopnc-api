<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_goods.css" rel="stylesheet" type="text/css">
<div class="wrapper">
  <div class="ncs-goods-layout expanded" >
    <div class="ncs-goods-main" id="main-nav-holder">
      <div class="ncs-comment">
        <div class="ncs-goods-title-bar">
          <h4><?php echo $lang['goods_index_evaluation'];?></h4>
        </div>
        <div class="ncs-goods-info-content bd" id="ncGoodsRate">
          <div class="top">
            <div class="rate">
              <p><strong><?php echo $output['goods_evaluate_info']['good_percent'];?></strong><sub>%</sub>好评</p>
              <span>共有<?php echo $output['goods_evaluate_info']['all'];?>人参与评分</span></div>
            <div class="percent">
              <dl>
                <dt>好评<em>(<?php echo $output['goods_evaluate_info']['good_percent'];?>%)</em></dt>
                <dd><i style="width: <?php echo $output['goods_evaluate_info']['good_percent'];?>%"></i></dd>
              </dl>
              <dl>
                <dt>中评<em>(<?php echo $output['goods_evaluate_info']['normal_percent'];?>%)</em></dt>
                <dd><i style="width: <?php echo $output['goods_evaluate_info']['normal_percent'];?>%"></i></dd>
              </dl>
              <dl>
                <dt>差评<em>(<?php echo $output['goods_evaluate_info']['bad_percent'];?>%)</em></dt>
                <dd><i style="width: <?php echo $output['goods_evaluate_info']['bad_percent'];?>%"></i></dd>
              </dl>
            </div>
            <div class="btns"><span>您可对已购商品进行评价</span>
              <p><a href="<?php if ($output['goods']['is_virtual']) { echo urlShop('member_vr_order', 'index');} else { echo urlShop('member_order', 'index');}?>" class="ncs-btn ncs-btn-red" target="_blank"><i class="icon-comment-alt"></i>评价商品</a></p>
            </div>
          </div>
          <!-- 商品评价内容部分 -->
          <div class="ncs-goods-title-nav">
            <ul id="comment_tab">
              <li <?php echo empty($output['type'])?'class="current"':'';?>><a href="<?php echo urlShop('goods', 'comments_list', array('goods_id' => $output['goods']['goods_id']));?>"><?php echo $lang['goods_index_evaluation'];?>(<?php echo $output['goods_evaluate_info']['all'];?>)</a></li>
              <li <?php echo $output['type'] == '1'?'class="current"':'';?>><a href="<?php echo urlShop('goods', 'comments_list', array('goods_id' => $output['goods']['goods_id'],'type' => '1'));?>">好评(<?php echo $output['goods_evaluate_info']['good'];?>)</a></li>
              <li <?php echo $output['type'] == '2'?'class="current"':'';?>><a href="<?php echo urlShop('goods', 'comments_list', array('goods_id' => $output['goods']['goods_id'],'type' => '2'));?>">中评(<?php echo $output['goods_evaluate_info']['normal'];?>)</a></li>
              <li <?php echo $output['type'] == '3'?'class="current"':'';?>><a href="<?php echo urlShop('goods', 'comments_list', array('goods_id' => $output['goods']['goods_id'],'type' => '3'));?>">差评(<?php echo $output['goods_evaluate_info']['bad'];?>)</a></li>
            </ul>
          </div>
          <div id="goodseval" class="ncs-commend-main">
            <?php if(!empty($output['goodsevallist']) && is_array($output['goodsevallist'])){?>
            <?php foreach($output['goodsevallist'] as $k=>$v){?>
            <div id="t" class="ncs-commend-floor">
              <div class="user-avatar"><a <?php if($v['geval_isanonymous'] != 1){?>href="index.php?act=member_snshome&mid=<?php echo $v['geval_frommemberid'];?>" target="_blank" data-param="{'id':<?php echo $v['geval_frommemberid'];?>}" nctype="mcard"<?php }?>><img src="<?php echo getMemberAvatarForID($v['geval_frommemberid']);?>" ></a></div>
              <dl class="detail">
                <dt> <span class="user-name">
                  <?php if($v['geval_isanonymous'] == 1){?>
                  <?php echo str_cut($v['geval_frommembername'],2).'***';?>
                  <?php }else{?>
                  <a href="index.php?act=member_snshome&mid=<?php echo $v['geval_frommemberid'];?>" target="_blank" data-param="{'id':<?php echo $v['geval_frommemberid'];?>}" nctype="mcard"><?php echo $v['geval_frommembername'];?></a>
                  <?php }?>
                  </span>
                  <time pubdate="pubdate">[<?php echo @date('Y-m-d',$v['geval_addtime']);?>]</time>
                </dt>
                <dd>用户评分：<span class="raty" data-score="<?php echo $v['geval_scores'];?>"></span></dd>
                <dd class="content">评价详情：<span><?php echo $v['geval_content'];?></span></dd>
                <?php if (!empty($v['geval_explain'])){?>
                <dd class="explain"><?php echo $lang['nc_credit_explain'];?>：<span><?php echo $v['geval_explain'];?></span></dd>
                <?php }?>
                <?php if(!empty($v['geval_image'])) {?>
                <dd>
                晒单图片：
                <ul class="photos-thumb"><?php $image_array = explode(',', $v['geval_image']);?>
                <?php foreach ($image_array as $value) { ?>
                <li><a nctype="nyroModal"  href="<?php echo snsThumb($value, 1024);?>">
                    <img src="<?php echo snsThumb($value);?>">
                </a></li>
                <?php } ?></ul>
                </dd>
                <?php } ?>
            </dl>
        </div>
            <?php }?>
            <div class="tr pr5 pb5">
              <div class="pagination"> <?php echo $output['show_page'];?></div>
            </div>
            <?php }else{?>
            <div class="ncs-norecord"><?php echo $lang['no_record'];?></div>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
    <div class="ncs-sidebar">
      <div class="ncs-sidebar-container">
        <div class="title">
          <h4>商品信息</h4>
        </div>
        <div class="content">
          <dl class="ncs-comment-goods">
            <dt class="goods-name"> <a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['goods']['goods_id']));?>"> <?php echo $output['goods']['goods_name']; ?> </a> </dt>
            <dd class="goods-pic"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['goods']['goods_id']));?>"> <img src="<?php echo cthumb($output['goods']['goods_image'], 240); ?>" alt="<?php echo $output['goods']['goods_name']; ?>"> </a> </dd>
            <dd class="goods-price"><?php echo $lang['goods_index_goods_price'].$lang['nc_colon'];?><em class="saleP"><?php echo $lang['currency'].$output['goods']['goods_price'];?></em></dd>
            <dd class="goods-raty"><?php echo $lang['goods_index_evaluation'].$lang['nc_colon'];?> <span class="raty" data-score="<?php echo $output['goods_evaluate_info']['star_average'];?>"></span> </dd>
          </dl>
        </div>
        <!--S 店铺信息-->
        <?php include template('store/info');?>
        <!--E 店铺信息 --> 
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
   $('.raty').raty({
        path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
        readOnly: true,
        score: function() {
          return $(this).attr('data-score');
        }
    });

   $('a[nctype="nyroModal"]').nyroModal();
});
</script> 
