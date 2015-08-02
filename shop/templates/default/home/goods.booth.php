<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="title">
<h3>推广商品</h3></div>
<div class="content" nc_type="current_display_mode">
  <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>
  <ul class="nch-booth-list squares">
    <?php foreach($output['goods_list'] as $value){?>
    <li nctype_goods="<?php echo $value['goods_id'];?>" nctype_store="<?php echo $value['store_id'];?>">
        <div class="goods-pic"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$value['goods_id']));?>" target="_blank" title="<?php echo $value['goods_name'];?>"><img src="<?php echo thumb($value, 240);?>" title="<?php echo $value['goods_name'];?>" alt="<?php echo $value['goods_name'];?>" /></a> </div>
        <?php if (C('groupbuy_allow') && $value['goods_promotion_type'] == 1) {?>
        <div class="goods-promotion"><span>抢购商品</span></div>
        <?php } elseif (C('promotion_allow') && $value['goods_promotion_type'] == 2)  {?>
        <div class="goods-promotion"><span>限时折扣</span></div>
        <?php }?>
          <div class="goods-name"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$value['goods_id']));?>" target="_blank" title="<?php echo $value['goods_jingle'];?>"><?php echo $value['goods_name'];?></a></div>
          <div class="goods-price" title="商品价格<?php echo $lang['nc_colon'].$lang['currency'].$value['goods_promotion_price'];?>"><?php echo $lang['currency'];?><?php echo $value['goods_promotion_price'];?></div>
    </li>
    <?php }?>
  </ul>
  <?php }?>
</div>
