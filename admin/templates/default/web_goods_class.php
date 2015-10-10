<?php defined('InShopNC') or exit('Access Invalid!');?>


  <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
  <?php foreach($output['goods_class'] as $k => $v){ ?>
  <dd gc_id="<?php echo $v['gc_id'];?>" title="<?php echo $v['gc_name'];?>" ondblclick="del_goods_class(<?php echo $v['gc_id'];?>);"> 
  	<i onclick="del_goods_class(<?php echo $v['gc_id'];?>);"></i><?php echo $v['gc_name'];?>
    <input name="category_list[goods_class][<?php echo $v['gc_id'];?>][gc_id]" value="<?php echo $v['gc_id'];?>" type="hidden">
    <input name="category_list[goods_class][<?php echo $v['gc_id'];?>][gc_name]" value="<?php echo $v['gc_name'];?>" type="hidden">
  </dd>
  <?php } ?>
  <?php } ?>
