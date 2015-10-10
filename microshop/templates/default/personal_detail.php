<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/qtip/jquery.qtip.min.js"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function(){
	//瀑布流
    $("#pinterest").masonry({
        // options 设置选项
        itemSelector : '.show',//class 选择器
            columnWidth : 74 ,//一列的宽度 Integer
            isAnimated:true,//使用jquery的布局变化  Boolean
            animationOptions:{queue: false, duration: 500 
            //jquery animate属性 渐变效果  Object { queue: false, duration: 500 }
            },
            gutterWidth:0,//列的间隙 Integer
            isFitWidth:true,// 适应宽度   Boolean
            isResizableL:true,// 是否可调整大小 Boolean
            isRTL:false//使用从右到左的布局 Boolean
    });
	
    //图片延迟加载
    $("img.lazy").microshop_lazyload();

    //喜欢
    $("[nc_type=microshop_like]").microshop_like({type:'personal'});

    $('a[nctype="mcard"]').membershipCard({type:"microshop"});
});
</script>

<div class="commend-goods">
  <div class="commend-goods-info">
    <div class="user">
      <div class="user-face"><span class="thumb size60"><i></i><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&member_id=<?php echo $output['detail']['commend_member_id'];?>" target="_blank"> <img src="<?php echo getMemberAvatar($output['detail']['member_avatar']);?>" alt="<?php echo $output['detail']['member_name'];?>" onload="javascript:DrawImage(this,60,60);" /> </a></span></div>
      <dl>
        <dt> <a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=home&member_id=<?php echo $output['detail']['commend_member_id'];?>" target="_blank" nctype="mcard" data-param="{'id':<?php echo $output['detail']['member_id'];?>}"> <?php echo $output['detail']['member_name'];?></a><?php echo $lang['microshop_personal_commend'];?><span class="add-time"><?php echo date('Y-m-d',$output['detail']['commend_time']);?></span></dt>
        <dd><i></i>
          <p><?php echo $output['detail']['commend_message'];?><i></i></p>
        </dd>
      </dl>
      <div class="arrow"></div>
    </div>
    <div class="goods">
      <div class="handle-bar" id="personal_buy">
        <div class="buy-btn">
          <?php $buy_array = unserialize($output['detail']['commend_buy']);?>
          <?php if(!empty($buy_array)) { ?>
          <a href="javascript:void(0)"><span><?php echo $lang['microshop_text_buy'];?></span><i></i></a>
          <?php $buy_array = unserialize($output['detail']['commend_buy']);?>
          <div class="buy-info">
            <?php foreach($buy_array as $val) { ?>
            <dl>
              <dt class="goods-pic"><img src="<?php echo $val['image'];?>" alt="<?php echo $val['title'];?>" title="<?php echo $val['title'];?>" /></dt>
              <dd><a href="<?php echo $val['link'];?>" class="goods-name" title="<?php echo $val['title'];?>" target="_blank"><?php echo $val['title'];?></a>
                <p class="goods-price"><?php echo $lang['currency'].$val['price'];?></p>
              </dd>
            </dl>
            <?php } ?>
          </div>
          <?php } ?>
        </div>
        <div class="buttons"><a nc_type="microshop_like" like_id="<?php echo $output['detail']['personal_id'];?>" href="javascript:void(0)" class="like"><i></i><em><?php echo $output['detail']['like_count']<=999?$output['detail']['like_count']:'999+';?></em></a><a id="btn_sns_share" href="javascript:void(0)" class="share"><i></i><?php echo $lang['microshop_text_share'];?><em></em></a></div>
      </div>
      <?php $personal_image_array = getMicroshopPersonalImageUrl($output['detail']);?>
      <?php if(!empty($personal_image_array)) { ?>
      <?php foreach($personal_image_array as $val) { ?>
      <div class="pic"> <img class="lazy" src="<?php echo MICROSHOP_TEMPLATES_URL;?>/images/loading.gif" data-src="<?php echo $val;?>" /> </div>
      <?php } ?>
      <?php } ?>
      <?php require('widget_comment.php');?>
    </div>
    <div class="clear">&nbsp;</div>
  </div>
  <div id="widget_comment_title" class="commend-goods-sidebar">
    <?php require('widget_sidebar.php');?>
  </div>
  <div class="clear">&nbsp;</div>
</div>
<?php require('widget_sns_share.php');?>
