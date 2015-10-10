<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_pay_method'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <table class="table tb-type2">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['payment_index_name'];?></th>
        <th class="align-center"><?php echo $lang['payment_index_enable'];?></th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['payment_list']) && is_array($output['payment_list'])){ foreach($output['payment_list'] as $k => $v){ ?>
      <tr class="hover">
        <td><?php echo $v['payment_name'];?></td>
        <td class="w25pre align-center"><?php if($v['payment_state'] == '1'){ ?>
          <?php echo $lang['nc_yes'];?>
          <?php }else { ?>
          <?php echo $lang['nc_no'];?>
          <?php } ?></td>
        <td class="w156 align-center"><?php if($v['payment_state'] == '1'){ ?>
          <a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['payment_index_ensure_disable'];?>?')){location.href='index.php?act=payment&op=system_update&state=2&payment_id=<?php echo $v['payment_id'];?>'}"> <?php echo $lang['payment_index_disable'];?></a>
          <?php }else { ?>
          <a href="index.php?act=payment&op=system_update&state=1&payment_id=<?php echo $v['payment_id'];?>"><?php echo $lang['payment_index_enable'];?></a>
          <?php } ?>
          | <a href="index.php?act=payment&op=system_edit&payment_id=<?php echo $v['payment_id']; ?>"><?php echo $lang['nc_edit']?></a></td>
      </tr>
      <?php } } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15"></td>
      </tr>
    </tfoot>
  </table>
</div>
