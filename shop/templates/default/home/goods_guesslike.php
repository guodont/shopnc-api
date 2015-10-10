<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.goods-guess-like { border: solid 1px #EEE; margin: 0 auto 20px auto;}
.goods-guess-like .title {  font: bold 14px/20px "microsoft yahei"; color: #666; padding: 8px 19px; border-bottom: solid 1px #EEE;}
.goods-pic { width: 200px; height: 200px; margin: 15px auto 0 auto;}
.goods-pic a { line-height: 0; text-align: center; vertical-align: middle; display: table-cell; *display: block; width: 200px; height: 200px; padding: 0; overflow: hidden;}
.goods-pic a img { max-width: 200px; max-height: 200px; margin-top:expression(200-this.height/2); *margin-top:expression(100-this.height/2)/*IE6,7*/;}
.goods-info { width: 200px; margin: 5px auto 15px auto;}
.goods-info dt { line-height: 18px; height: 36px; overflow: hidden;}
.goods-info dd { font: bold 12px/20px Verdana; color: #C00;}
.goods-info dd em { font-size: 14px; font-weight: 600; margin: 0 4px;}
.goods-promotion { font: 700 12px/15px "microsoft yahei"; color: #FFFFFF; background: url("<?php echo SHOP_TEMPLATES_URL;?>/images/2014shop_background_img.png") no-repeat scroll 0 -100px rgba(0, 0, 0, 0); text-align: center; width: 30px; height: 30px; padding: 20px 9px 15px; position: absolute; top: 5px; right: 5px; z-index: 2;}

.noguess { color: #AAA; text-align: center; padding: 50px 0;}


/* 图片滚动 
-------------------------------------------*/
.jcarousel-list-horizontal { font-size: 0; *word-spacing:-1px/*IE6、7*/; }
.jcarousel-container-horizontal { padding: 0 18px;}
.jcarousel-clip { overflow: hidden;}
.jcarousel-clip-horizontal { z-index: 1;}
.jcarousel-item { width: 25%; position: relative; z-index: 1;}
.jcarousel-item-horizontal { font-size: 12px; vertical-align: top; display: inline-block; *display: inline/*IE7*/; *zoom: 1/*IE7*/;}
.jcarousel-direction-rtl .jcarousel-item-horizontal { margin-right: 0;}
.jcarousel-item-placeholder { background: #fff; color: #000;}
.jcarousel-prev-horizontal,
.jcarousel-next-horizontal { background: transparent url(<?php echo SHOP_TEMPLATES_URL;?>/images/member/member_pics.png) no-repeat; width: 9px; height: 16px; padding: 10px 13px; position: absolute; z-index: 9; top: 40%; cursor: pointer;}
.jcarousel-prev-horizontal { background-position: -240px -40px; left: 0; }
.jcarousel-prev-horizontal:hover, 
.jcarousel-prev-horizontal:focus,
.jcarousel-prev-horizontal:active { background-position: -276px -40px;}
.jcarousel-prev-disabled-horizontal:hover,
.jcarousel-prev-disabled-horizontal:focus,
.jcarousel-prev-disabled-horizontal:active { background-position: -240px -40px; cursor: default;}
.jcarousel-next-horizontal { background-position: -240px -76px; right: 0; }
.jcarousel-next-horizontal:hover,
.jcarousel-next-horizontal:focus,
.jcarousel-next-horizontal:active { background-position: -276px -76px;}
.jcarousel-next-disabled-horizontal,
.jcarousel-next-disabled-horizontal:hover,
.jcarousel-next-disabled-horizontal:focus,
.jcarousel-next-disabled-horizontal:active { background-position: -240px -76px; cursor: default;}

</style>
<div class="goods-guess-like">
  <div class="title">猜您喜欢的宝贝</div>
  <div class="content">
    <?php if(!empty($output['goodslist']) && is_array($output['goodslist'])){ ?>
    <ul id="mycarousel" class="jcarousel-skin-tango">
      <?php foreach($output['goodslist'] as $k=>$v){?>
      <li>
        <div class="goods-pic"> <a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" target="_blank"><img alt="" src="<?php echo cthumb($v['goods_image'], 240);?>"></a> </div>
        <?php if ($v['goods_promotion_type'] == 1){ ?>
        <div class="goods-promotion"><span>抢购商品</span></div>
        <?php } elseif ($v['goods_promotion_type'] == 2) { ?>
        <div class="goods-promotion"><span>限时折扣</span></div>
        <?php } ?>
        <dl class="goods-info">
          <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id']));?>" title="<?php echo $v['goods_name'];?>" target="_blank"><?php echo $v['goods_name'];?></a></dt>
          <dd>
            <div>￥<em><?php echo ncPriceFormat($v['goods_promotion_price']);?></em></div>
          </dd>
        </dl>
      </li>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <div class="noguess">暂无商品向您推荐</div>
    <?php }?>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/jquery.jcarousel.min.js"></script> 
<script type="text/javascript">
function mycarousel_initCallback(carousel){
    //Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });
    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });
    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};

$(function(){
    $('#mycarousel').jcarousel({
        initCallback: mycarousel_initCallback,
        auto:2,
        wrap:'last',
    	visible: 4
    });
});

</script>