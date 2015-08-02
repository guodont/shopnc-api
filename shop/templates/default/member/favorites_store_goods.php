<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>
<?php foreach ($output['goods_list'] as $key => $val) { ?>

<li> <a href="<?php echo urlShop('goods', 'index', array('goods_id' => $val['goods_id']));?>" target="_blank"> <span class="thumb size120"><i></i> <img src="<?php echo thumb($val, 240);?>" onload="javascript:DrawImage(this,120,120);" title="<?php echo $val['goods_name'];?>"/> </span> </a> </li>
<?php } ?>
<?php } ?>
