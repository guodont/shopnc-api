<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/qtip/jquery.qtip.min.js"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function(){
    //喜欢
    $("[nc_type=microshop_like]").microshop_like({type:'store',count_target:$(".like em")});

    //图片延迟加载
    $(".lazy").microshop_lazyload();

    $('a[nctype="mcard"]').membershipCard({type:"microshop"});
});
</script>
<div class="microshop-store-top">
  <div class="left-box">
    <dl class="store-intro">
      <dt>
        <h2><a href="<?php echo urlShop('show_store', 'index', array('store_id' => $output['detail']['store_id']), $output['detail']['store_domain']);?>" target="_blank"><?php echo $output['detail']['store_name'];?></a></h2>
        <span><?php echo $lang['microshop_text_store_member_name'];?><?php echo $lang['nc_colon'];?><a href="javascript:;" nctype="mcard" data-param="{'id':<?php echo $output['detail']['member_id'];?>}"><?php echo $output['detail']['member_name'];?></a></span></dt>
      <dd><span><?php echo $lang['microshop_text_store_area'];?><?php echo $lang['nc_colon'];?><?php echo $output['detail']['area_info'];?></span><span><?php echo $lang['microshop_text_store_zy'];?><?php echo $lang['nc_colon'];?><?php echo $output['detail']['store_zy'];?></span> </dd>
      <dd><span><?php echo $lang['microshop_text_store_favorites'];?><?php echo $lang['nc_colon'];?><em nctype="store_collect"><?php echo $output['detail']['store_collect']?></em><?php echo $lang['nc_person'];?><?php echo $lang['nc_collect'];?></span></dd>
    </dl>
    <div class="handle">
      <ul>
        <li class="goods"><i class="pngFix"></i><?php echo $lang['microshop_text_goods'];?><em><?php echo $output['detail']['goods_count'];?></em></li>
        <li class="like"><i class="pngFix"></i><?php echo $lang['microshop_text_like'];?><em><?php echo $output['detail']['like_count']<=999?$output['detail']['like_count']:'999+';?></em></li>
      </ul>
      <div class="btn">
          <a nc_type="microshop_like" like_id="<?php echo $output['detail']['microshop_store_id'];?>" href="javascript:void(0)" class="like mr5"><i class="pngFix"></i><?php echo $lang['microshop_text_like'].$lang['microshop_text_store'];?></a>
          <a id="btn_sns_share" href="javascript:;" class="share"><i class="pngFix"></i><?php echo $lang['microshop_text_share'];?></a></div>
    </div>
  </div>
  <div class="right-box">
    <div class="arrow pngFix"></div>
    <div class="store-logo">
        <a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$output['detail']['store_id']), $output['detail']['store_domain']);?>" target="_blank"> 
            <img src="<?php echo getStoreLogo($output['detail']['store_label']);?>" alt="<?php echo $output['detail']['store_name'];?>" />
        </a>
    </div>
    <p><a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$output['detail']['store_id']), $output['detail']['store_domain']);?>" target="_blank"><?php echo $lang['microshop_text_enter'].$lang['microshop_text_store'];?><i></i></a></p>
  </div>
</div>
<div class="store-goods-list-content">
  <div class="store-goods-list-box">
    <?php $list_length = count($output['list']); ?>
    <?php for ($j = 0; $j < 4; $j++) { ?>
    <div class="store-goods-list">
      <?php if($j === 3) { ?>
      <div class="store-goods-list-comment">
        <?php require('widget_comment.php');?>
      </div>
      <?php } ?>
      <?php for ($i = $j; $i < $list_length; $i+=4) { ?>
      <div class="store-goods-item">
        <div class="picture"> <a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$output['list'][$i]['goods_id']));?>" target="_blank">
          <?php $image_url = cthumb($output['list'][$i]['goods_image'], 240,$output['list'][$i]['store_id']);?>
          <?php $size = getMicroshopImageSize($image_url, 220);?>
          <img class="lazy" height="<?php echo $size['height'];?>" width="<?php echo $size['width'];?>" src="<?php echo MICROSHOP_TEMPLATES_URL;?>/images/loading.gif" data-src="<?php echo $image_url;?>" title="<?php echo $output['list'][$i]['goods_name'];?>" alt="<?php echo $output['list'][$i]['goods_name'];?>" /> </a>
          <div class="price"> <?php echo $lang['currency'];?><strong><?php echo ncPriceFormat($output['list'][$i]['goods_price']);?></strong></div>
        </div>
        <div class="goods-title"> <a href="<?php echo urlShop('goods', 'index',array('goods_id'=>$output['list'][$i]['goods_id']));?>" target="_blank"> <?php echo $output['list'][$i]['goods_name'];?> </a> </div>
        <div class="goods-salenum"><?php echo $lang['microshop_store_selled'];?><em><?php echo $output['list'][$i]['goods_salenum'];?></em><?php echo $lang['microshop_text_jian'];?></div>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</div>
<div class="pagination"> <?php echo $output['show_page'];?> </div>
<?php require('widget_sns_share.php');?>
