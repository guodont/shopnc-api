<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>

<ul class="search-goods-list">
  <?php foreach($output['goods_list'] as $key => $value){ ?>
  <li>
    <div class="goods-name"><?php echo $value['goods_name'];?></div>
    <div class="goods-price">￥<?php echo $value['goods_promotion_price'];?></div>
    <div class="goods-pic"><img title="<?php echo $value['goods_name'];?>" src="<?php echo thumb($value, 60);?>" /></div>
    <a nctype="btn_add_goods" data-goods-id="<?php echo $value['goods_id'];?>" data-goods-name="<?php echo $value['goods_name'];?>" data-goods-price="<?php echo $value['goods_promotion_price'];?>" data-goods-image="<?php echo thumb($value, 240);?>" href="javascript:;">添加</a> </li>
  <?php } ?>
</ul>
<div id="goods_pagination" class="pagination"> <?php echo $output['show_page'];?> </div>
<?php }else { ?>
<p class="no-record"><?php echo $lang['nc_no_record'];?></p>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#goods_pagination').find('.demo').ajaxContent({
            event:'click', 
            loaderType:"img",
            loadingMsg:"<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif",
            target:'#mb_special_goods_list'
        });
    });
</script> 
