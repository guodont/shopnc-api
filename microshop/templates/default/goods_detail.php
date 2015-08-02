<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/qtip/jquery.qtip.min.js"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function(){
    //图片延迟加载
    $("img.lazy").microshop_lazyload();

    //喜欢
    $("[nc_type=microshop_like]").microshop_like({type:'goods'});

    $('a[nctype="mcard"]').membershipCard({type:"microshop"});
});
</script>

<div class="commend-goods">
  <div class="commend-goods-info">
    <div class="user">
      <div class="user-face"><span class="thumb size60"><i></i><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&member_id=<?php echo $output['detail']['commend_member_id'];?>" target="_blank"> <img src="<?php echo getMemberAvatar($output['detail']['member_avatar']);?>" alt="<?php echo $output['detail']['member_name'];?>" onload="javascript:DrawImage(this,60,60);" /> </a></span> </div>
      <dl>
        <dt><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&member_id=<?php echo $output['detail']['commend_member_id'];?>" target="_blank" nctype="mcard" data-param="{'id':<?php echo $output['detail']['member_id'];?>}"> <?php echo $output['detail']['member_name'];?></a><?php echo $lang['microshop_text_commend_goods'];?><span class="add-time"><?php echo date('Y-m-d',$output['detail']['commend_time']);?></span></dt>
        <dd><i></i>
          <p><?php echo $output['detail']['commend_message'];?><i></i></p>
        </dd>
      </dl>
      <div class="arrow"></div>
    </div>
    <div class="goods">
      <h3><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$output['detail']['commend_goods_id']));?>" target="_blank" title="<?php echo $output['detail']['commend_goods_name'];?>"> <?php echo $output['detail']['commend_goods_name'];?> </a></h3>
      <div class="handle-bar">
        <div class="buy-btn"><a href="javascript:void(0)"><span><?php echo $lang['microshop_text_buy'];?></span><i></i></a>
          <div class="buy-info">
            <dl>
              <dt class="goods-pic"><img src="<?php echo cthumb($output['detail']['commend_goods_image'], 60,$output['detail']['commend_goods_store_id']);?>" alt="<?php echo $output['detail']['commend_goods_name'];?>" /></dt>
              <dd><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$output['detail']['commend_goods_id']));?>" target="_blank" title="<?php echo $output['detail']['commend_goods_name'];?>" class="goods-name"><?php echo $output['detail']['commend_goods_name'];?></a>
                <p class="goods-price"><?php echo $lang['currency'].$output['detail']['commend_goods_price'];?></p>
              </dd>
            </dl>
          </div>
        </div>
        <div class="buttons"><a nc_type="microshop_like" like_id="<?php echo $output['detail']['commend_id'];?>" href="javascript:void(0)" class="like" title="<?php echo $lang['microshop_text_like'];?>"><i></i><em><?php echo $output['detail']['like_count']<=999?$output['detail']['like_count']:'999+';?></em></a><a id="btn_sns_share" href="javascript:;" class="share" title="<?php echo $lang['microshop_text_share'];?>"><i></i><?php echo $lang['microshop_text_share'];?><em></em></a></div>
      </div>
      <div class="pic">
        <?php if(!empty($output['goods_image_list'])) { ?>
        <?php foreach($output['goods_image_list'] as $val) { ?>
        <?php if(!empty($val)) { ?>
        <img class="lazy" src="<?php echo MICROSHOP_TEMPLATES_URL;?>/images/loading.gif" data-src="<?php echo cthumb($val['goods_image'], 1280);?>" title="<?php echo $output['detail']['commend_goods_name'];?>" alt="<?php echo $output['detail']['commend_goods_name'];?>" />
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </div>
      <?php require('widget_comment.php');?>
    </div>
    <div class="clear">&nbsp;</div>
  </div>
  <div class="commend-goods-sidebar">
    <?php require('widget_sidebar.php');?>
  </div>
  <div class="clear">&nbsp;</div>
</div>
<div class="microshop-store-title">
  <h3><?php echo $lang['microshop_text_goods_store'];?></h3>
</div>
<div class="microshop-store-list">
  <div class="top">
    <h2><a href="<?php echo urlShop('show_store', 'index', array('store_id' => $output['store_info']['store_id']), $output['store_info']['store_domain']);?>" target="_blank"><?php echo $output['store_info']['store_name'];?></a></h2>
    <span class="goods-count"><strong><?php echo $output['store_info']['goods_count'];?></strong><?php echo $lang['microshop_text_jian'].$lang['microshop_text_goods'];?></span> </div>
  <div>
    <div class="microshop-store-info">
      <dl>
        <dt><?php echo $lang['microshop_text_store_member_name'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['store_info']['member_name'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['microshop_text_store_area'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['store_info']['area_info'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['microshop_text_store_zy'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['store_info']['store_zy'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['microshop_text_store_favorites'].$lang['nc_colon'];?></dt>
        <dd><strong nctype="store_collect"><?php echo $output['store_info']['store_collect']?></strong><?php echo $lang['nc_person'];?><?php echo $lang['nc_collect'];?></dd>
      </dl>
    </div>
    <div class="microshop-store-info-image">
      <ul>
        <?php if(!empty($output['store_info']['hot_sales_list']) && is_array($output['store_info']['hot_sales_list'])) { ?>
        <?php $i = 1;?>
        <?php foreach($output['store_info']['hot_sales_list'] as $k=>$v){?>
        <li style="background-image: url(<?php echo thumb($v, 240);?>)" title="<?php echo $v['goods_name'];?>"><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$v['goods_id']));?>" target="_blank">&nbsp;</a> <em><?php echo $v['goods_store_price'];?></em> </li>
        <?php if($i >=5) break; ?>
        <?php $i++; ?>
        <?php }?>
        <?php }?>
      </ul>
    </div>
  </div>
</div>
<?php require('widget_sns_share.php');?>
