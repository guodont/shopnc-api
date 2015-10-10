<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/layout.css" rel="stylesheet" type="text/css">
<style type="text/css">
.nc-appbar-tabs a.compare { display: none !important;}
</style>
<div class="nch-container wrapper">
  <div class="nch-all-menu">
    <ul class="tab-bar">
      <li class="current"><a href="javascript:void(0);"><?php echo $lang['category_index_goods_class'];?></a></li>
      <li><a href="<?php echo urlShop('brand', 'index');?>">全部品牌</a></li>
      <li><a href="<?php echo urlShop('search', 'index');?>">全部商品</a></li>
    </ul>
  </div>
  <div class="nch-category-all">
    <?php if(!empty($output['show_goods_class']) && is_array($output['show_goods_class'])){?>
    <ul class="nch-category-container" id="categoryList">
      <?php foreach($output['show_goods_class'] as $key=>$gc_list){?>
      <li class="classes">
        <div class="title"><i></i>
        <a href="<?php echo urlShop('search', 'index', array('cate_id' => $gc_list['gc_id']));?>"><?php echo $gc_list['gc_name'];?></a>
        </div>
        <?php if (!empty($gc_list['class2'])) {?>
        <?php foreach ($gc_list['class2'] as $gc_list2) {?>
        <dl>
          <dt><a href="<?php echo urlShop('search', 'index', array('cate_id' => $gc_list2['gc_id']));?>"><?php echo $gc_list2['gc_name'];?></a></dt>
          <dd>
            <?php if(!empty($gc_list2['class3'])){?>
            <?php foreach($gc_list2['class3'] as $key=>$gc_list3){?>
            <a href="<?php echo urlShop('search', 'index', array('cate_id' => $gc_list3['gc_id']));?>"><?php echo $gc_list3['gc_name'];?></a>
            <?php }?>
            <?php }?>
          </dd>
        </dl>
        <?php }?>
        <?php }?>
      </li>
      <?php }?>
    </ul>
    <?php }?>
  </div>
</div>
<script>
$(function(){
	$("#categoryList").imagesLoaded( function(){
		$("#categoryList").masonry({
			itemSelector : '.classes'
		});
	});
});
</script> 
