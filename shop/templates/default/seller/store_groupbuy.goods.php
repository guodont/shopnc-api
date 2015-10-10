<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>
<ul class="goods-list" style="width:760px;">
  <?php foreach($output['goods_list'] as $key=>$val){?>
  <li>
    <div class="goods-thumb"><img src="<?php echo thumb($val, 240);?>"/></div>
    <dl class="goods-info">
      <dt><?php echo $val['goods_name'];?></dt>
      <dd>销售价：<?php echo $lang['currency'].$val['goods_price'];?>
    </dl>
    <a nctype="btn_add_groupbuy_goods" data-goods-commonid="<?php echo $val['goods_commonid'];?>" href="javascript:void(0);" class="ncsc-btn-mini ncsc-btn-green"><i class="icon-ok-circle "></i>选择为抢购商品</a> </li>
  <?php } ?>
</ul>
<div class="pagination"><?php echo $output['show_page']; ?></div>
<?php } else { ?>
<div><?php echo $lang['no_record'];?></div>
<?php } ?>
