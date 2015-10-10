<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>

<table class="ncsc-default-table">
  <thead>
    <tr><th class="w30"></th>
      <th class="tl"><?php echo $lang['mansong_name'];?></th>
      <th class="w250"><?php echo $lang['start_time'];?>&nbsp;-&nbsp;<?php echo $lang['end_time'];?></th>
      
      <th class="w300">活动内容</th>
      <th class="w110"><?php echo $lang['nc_state'];?></th>
    </tr>
  </thead>
  <tbody>
    <tr class="bd-line"><td></td>
      <td class="tl"><dl class="goods-name"><dt><?php echo $output['mansong_info']['mansong_name'];?></dt></dl></td>
      <td><p><?php echo date('Y-m-d H:i',$output['mansong_info']['start_time']);?></p><p>至</p><p><?php echo date('Y-m-d H:i',$output['mansong_info']['end_time']);?></p></td>
      <td><ul class="ncsc-mansong-rule-list">
          <?php if(!empty($output['list']) && is_array($output['list'])){?>
          <?php foreach($output['list'] as $key=>$val){?>
          <li>
              <?php echo $lang['level_price'];?><strong><?php echo $val['price'];?></strong>元，&nbsp;
              <?php if(!empty($val['discount'])) { ?>
                  <?php echo $lang['level_discount'];?><strong><?php echo $val['discount'];?></strong>元，&nbsp;
              <?php } ?>
              <?php if(empty($val['goods_id'])) { ?>
                    <!-- <?php echo $lang['gift_name'];?> <span><?php echo $lang['text_not_join'];?></span> -->
              <?php } else { ?>
              		<?php echo $lang['gift_name'];?><a href="<?php echo $val['goods_url'];?>" title="<?php echo $val['mansong_goods_name'];?>" target="_blank" class="goods-thumb"> <img src="<?php echo cthumb($val['goods_image']);?>"/> </a>
              <?php } ?>
          </li>
          <?php }?>
          <?php }?>
        </ul></td>
      <td><?php echo $output['mansong_info']['mansong_state_text'];?></td>
    </tr>
  <tbody> 
</table>
