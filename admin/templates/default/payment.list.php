<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_pay_method'];?></h3>
      <ul class="tab-base"><li><a class="current"><span><?php echo $lang['nc_pay_method'];?></span></a></li></ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['payment_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
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
        <td class="w25pre align-center">
          <?php echo $v['payment_state'] == '1' ? $lang['payment_index_enable_ing'] : $lang['payment_index_disable_ing'];?>
        </td>
        <td class="w156 align-center"><a href="index.php?act=payment&op=edit&payment_id=<?php echo $v['payment_id']; ?>"><?php echo $lang['nc_edit']?></a></td>
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