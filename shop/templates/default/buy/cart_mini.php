<?php defined('InShopNC') or exit('Access Invalid!');?>

<ul class="cart-list">
  <?php if ($output['cart_list']['list']) { ?>
  <?php foreach($output['cart_list']['list'] as $k => $v){ ?>
  <?php if ($k > 9) break;?>
  <li ncTpye="cart_item_<?php echo $v['cart_id'];?>">
    <div class="goods-pic"><a href="<?php echo $v['goods_url'];?>" title="<?php echo $v['goods_name'];?>" target="_blank";><img src="<?php echo $v['goods_image'];?>" alt="<?php echo $v['goods_name'];?>"/></a></div>
    <dl>
      <dt class="goods-name"><a href="<?php echo $v['goods_url'];?>" title="<?php echo $v['goods_name'];?>" target="_blank";><?php echo $v['goods_name'];?></a></dt>
      <dd><em class="goods-price"><?php echo $lang['currency'].$v['goods_price'];?></em>×<?php echo $v['goods_num'];?></dd>
    </dl>
    <a href="javascript:drop_topcart_item(<?php echo $v['cart_id'];?>);" class="del" title="删除">X</a>
  </li>
  <?php } ?>
<script>
$(function(){
	$('.head-user-menu .my-cart').append('<div class="addcart-goods-num"><?php echo $output['cart_list']['cart_goods_num'];?></div>');
	$('#rtoobar_cart_count').html(<?php echo $output['cart_list']['cart_goods_num'];?>).show();
});
</script>
  <?php } else { ?>
  <li>
    <dl><dd style="text-align: center; ">暂无商品</dd></dl>
  </li>
<script>
$(function(){
  	$('.addcart-goods-num').remove();
  	$('#rtoobar_cart_count').html('').hide();
});
</script>
  <?php } ?>
</ul>
<div class="btn-box">
<?php if ($output['cart_list']['list']) { ?>
<div ncType="rtoolbar_total_price" class="total-price">共计金额：<em class="goods-price">&yen;<?php echo $output['cart_list']['cart_all_price'];?></em></div>
<a href="javascript:void(0);" onclick="javascript:window.location.href='index.php?act=cart'">结算购物车中的商品</a>
<?php } ?>