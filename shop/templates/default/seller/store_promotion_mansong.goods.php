<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>
<ul class="goods-list" style="width:760px;">
<?php foreach($output['goods_list'] as $key=>$val){?>
<li><div class="goods-thumb">
    <?php $goods_url = urlShop('goods', 'index', array('goods_id' => $val['goods_id']));?>
    <?php $goods_image_url = thumb($val, 240);?><img src="<?php echo $goods_image_url;?>"/></div>
<dl class="goods-info"><dt><a href="<?php echo $goods_url;?>" target="_blank"><?php echo $val['goods_name'];?></a>
</dt><dd>销售价：<?php echo $lang['currency'].$val['goods_price'];?></dl>
<a nctype="btn_add_mansong_goods" data-goods-id="<?php echo $val['goods_id'];?>" data-goods-name="<?php echo $val['goods_name'];?>" data-goods-image-url="<?php echo $goods_image_url;?>" data-goods-url="<?php echo $goods_url;?>" href="javascript:void(0);" class="ncsc-btn-mini ncsc-btn-green"><i class="icon-ok-circle "></i>选择为礼品</a>
</li>
<?php } ?>
</ul>
<div class="pagination"><?php echo $output['show_page']; ?></div>
<?php } else { ?>
<div><?php echo $lang['no_record'];?></div>
<?php } ?>
