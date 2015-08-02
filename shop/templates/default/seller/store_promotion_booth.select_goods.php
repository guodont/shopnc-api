<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>

<ul class="goods-list">
  <?php foreach($output['goods_list'] as $key=>$val){?>
  <li>
    <div class="goods-thumb"><img src="<?php echo thumb($val, 240);?>"/></div>
    <dl class="goods-info">
      <dt><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $val['goods_id']));?>" target="_blank"><?php echo $val['goods_name'];?></a> </dt>
      <dd>销售价格：<?php echo $lang['currency'].$val['goods_price'];?>
    </dl>
    <a nctype="a_choose_goods" data-param='{gid:<?php echo $val['goods_id'];?>}' href="javascript:void(0);" class="ncsc-btn-mini">选择商品</a> </li>
  <?php } ?>
</ul>
<div class="pagination"><?php echo $output['show_page'];?></div>
<?php } else { ?>
<div><?php echo $lang['no_record'];?></div>
<?php } ?>
