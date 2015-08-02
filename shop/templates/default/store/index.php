<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php 
//加载店铺装修静态页
if(isset($output['decoration_file'])) { 
        require($output['decoration_file']);
} 
?>
<?php if(!$output['store_decoration_only']) {?>
<div class="wrapper mt10">
  <div class="ncs-main">
    <div class="flexslider">
      <ul class="slides">
        <?php if(!empty($output['store_slide']) && is_array($output['store_slide'])){?>
        <?php for($i=0;$i<5;$i++){?>
        <?php if($output['store_slide'][$i] != ''){?>
        <li><a <?php if($output['store_slide_url'][$i] != '' && $output['store_slide_url'][$i] != 'http://'){?>href="<?php echo $output['store_slide_url'][$i];?>"<?php }?>><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS.$output['store_slide'][$i];?>"></a></li>
        <?php }?>
        <?php }?>
        <?php }else{?>
        <li><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS;?>f01.jpg"></li>
        <li><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS;?>f02.jpg"></li>
        <li><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS;?>f03.jpg"></li>
        <li><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS;?>f04.jpg"></li>
        <?php }?>
      </ul>
    </div>
    <div class="ncs-main-container">
      <div class="title"> <span><a href="<?php echo urlShop('show_store', 'goods_all', array('store_id' => $_GET['store_id']));?>" class="more"><?php echo $lang['nc_more'];?></a></span>
        <h4><?php echo $lang['show_store_index_recommend'];?></h4>
      </div>
      <div class="content ncs-goods-list">
        <?php if(!empty($output['recommended_goods_list']) && is_array($output['recommended_goods_list'])){?>
        <ul>
          <?php foreach($output['recommended_goods_list'] as $value){?>
          <li>
            <dl>
              <dt><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$value['goods_id']));?>" class="goods-thumb" target="_blank"><img src="<?php echo thumb($value, 240);?>" alt="<?php echo $value['goods_name'];?>"/></a>
                <ul class="goods-thumb-scroll-show">
                <?php if (is_array($value['image'])) {?>
                  <?php $i=0;foreach ($value['image'] as $val) {$i++?>
                  <li<?php if($i==1) {?> class="selected"<?php }?>><a href="javascript:void(0);"><img src="<?php echo thumb($val, 60);?>"/></a></li>
                  <?php }?>
                <?php } else {?>
                  <li class="selected"><a href="javascript:void(0)"><img src="<?php echo thumb($value, 60);?>"></a></li>
                <?php }?>
                </ul>
              </dt>
              <dd class="goods-name"><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$value['goods_id']));?>" title="<?php echo $value['goods_name'];?>" target="_blank"><?php echo $value['goods_name']?></a></dd>
              <dd class="goods-info"><span class="price"><i><?php echo $lang['currency'];?></i> <?php echo $value['goods_promotion_price']?> </span> <span class="goods-sold"><?php echo $lang['show_store_index_be_sold'];?><strong><?php echo $value['goods_salenum'];?></strong> <?php echo $lang['nc_jian'];?></span></dd>
              <?php if (C('groupbuy_allow') && $value['goods_promotion_type'] == 1) {?>
              <dd class="goods-promotion"><span>抢购商品</span></dd>
              <?php } elseif (C('promotion_allow') && $value['goods_promotion_type'] == 2)  {?>
              <dd class="goods-promotion"><span>限时折扣</span></dd>
              <?php }?>
              </dl>
          </li>
          <?php }?>
        </ul>
        <?php }else{?>
        <div class="nothing">
          <p><?php echo $lang['show_store_index_no_record'];?></p>
        </div>
        <?php }?>
      </div>
    </div>
    <div class="ncs-main-container">
      <div class="title"><span><a href="<?php echo urlShop('show_store', 'goods_all', array('store_id' => $_GET['store_id']));?>" class="more"><?php echo $lang['nc_more'];?></a></span>
        <h4><?php echo $lang['show_store_index_new_goods'];?></h4>
      </div>
      <div class="content ncs-goods-list">
        <?php if(!empty($output['new_goods_list']) && is_array($output['new_goods_list'])){?>
        <ul>
          <?php foreach($output['new_goods_list'] as $value){?>
          <li>
            <dl>
              <dt><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$value['goods_id']));?>" class="goods-thumb" target="_blank"><img src="<?php echo thumb($value, 240)?>" alt="<?php echo $value['goods_name'];?>"/></a>
                <ul class="goods-thumb-scroll-show">
                <?php if (is_array($value['image'])) {?>
                  <?php $i=0;foreach ($value['image'] as $val) {$i++?>
                  <li<?php if($i==1) {?> class="selected"<?php }?>><a href="javascript:void(0);"><img src="<?php echo thumb($val, 60);?>"/></a></li>
                  <?php }?>
                <?php } else {?>
                  <li class="selected"><a href="javascript:void(0)"><img src="<?php echo thumb($value, 60);?>"></a></li>
                <?php }?>
                </ul>
              </dt>
              <dd class="goods-name"><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$value['goods_id']));?>" title="<?php echo $value['goods_name'];?>" target="_blank"><?php echo $value['goods_name'];?></a></dd>
              <dd class="goods-info"><span class="price"><i><?php echo $lang['currency'];?></i> <?php echo $value['goods_promotion_price']?> </span> <span class="goods-sold"><?php echo $lang['show_store_index_be_sold'];?><strong><?php echo $value['goods_salenum'];?></strong> <?php echo $lang['nc_jian'];?></span></dd>
              <?php if (C('groupbuy_allow') && $value['goods_promotion_type'] == 1) {?>
              <dd class="goods-promotion"><span>抢购商品</span></dd>
              <?php } elseif (C('promotion_allow') && $value['goods_promotion_type'] == 2)  {?>
              <dd class="goods-promotion"><span>限时折扣</span></dd>
              <?php }?>
              </dl>
          </li>
          <?php }?>
        </ul>
        <?php }else{?>
        <div class="nothing">
          <p><?php echo $lang['show_store_index_no_record'];?></p>
        </div>
        <?php }?>
      </div>
    </div>
  </div>
  <div class="ncs-sidebar">
    <?php include template('store/left');?>
  </div>
</div>

<!-- 引入幻灯片JS --> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.flexslider-min.js"></script> 
<!-- 绑定幻灯片事件 --> 
<script type="text/javascript">
	$(window).load(function() {
		$('.flexslider').flexslider();


	    // 图片切换效果
	    $('.goods-thumb-scroll-show').find('a').mouseover(function(){
	        $(this).parents('li:first').addClass('selected').siblings().removeClass('selected');
	        var _src = $(this).find('img').attr('src');
	        _src = _src.replace('_60.', '_240.');
	        $(this).parents('dt').find('.goods-thumb').find('img').attr('src', _src);
	    });
	});
</script>
<?php } ?>
