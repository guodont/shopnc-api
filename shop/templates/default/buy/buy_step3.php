<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncc-main">
  <div class="ncc-title">
    <h3><?php echo $lang['cart_index_buy_finish'];?></h3>
    <h5>订单已支付完成，祝您购物愉快。</h5>
  </div>
  <div class="ncc-receipt-info mb30">
  <div class="ncc-finish-a"><i></i>订单支付成功！您已成功支付订单金额<em>￥<?php echo $_GET['pay_amount'];?></em>。</div>
  <div class="ncc-finish-b">可通过用户中心<a href="<?php echo SHOP_SITE_URL?>/index.php?act=member_order">已买到的商品</a>查看订单状态。</div>
  <div class="ncc-finish-c mb30"><a href="<?php echo SHOP_SITE_URL?>" class="ncc-btn-mini ncc-btn-green mr15"><i class="icon-shopping-cart"></i>继续购物</a><a href="<?php echo SHOP_SITE_URL?>/index.php?act=member_order" class="ncc-btn-mini ncc-btn-acidblue"><i class="icon-file-text-alt"></i>查看订单</a></div>
  </div>
</div>