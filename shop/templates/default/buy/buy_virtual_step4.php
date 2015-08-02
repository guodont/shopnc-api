<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncc-main">
  <div class="ncc-title">
    <h3>订单完成</h3>
    <h5>订单已支付完成，祝您购物愉快。</h5>
  </div>
  <div class="ncc-receipt-info mb30">
  <div class="ncc-finish-a"><i></i>订单支付成功！您已成功支付订单金额<em>￥<?php echo $_GET['order_amount'];?></em>，订单编号：<?php echo $_GET['order_sn'];?>。</div>
  <div class="ncc-finish-b"><a href="<?php echo SHOP_SITE_URL?>/index.php?act=member_vr_order&op=show_order&order_id=<?php echo $_GET['order_id'];?>">查看订单详情</a></div>
  <div class="ncc-finish-c mb30"><a href="<?php echo SHOP_SITE_URL?>" class="ncc-btn-mini ncc-btn-green mr15"><i class="icon-shopping-cart"></i>继续购物</a><a href="<?php echo SHOP_SITE_URL?>/index.php?act=member_vr_order" class="ncc-btn-mini ncc-btn-acidblue"><i class="icon-file-text-alt"></i>查看我的订单</a></div>
  </div>
</div>