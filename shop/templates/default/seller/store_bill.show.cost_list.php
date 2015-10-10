<?php defined('InShopNC') or exit('Access Invalid!');?>
  <table class="ncsc-default-table">
    <thead>
      <tr>
        <th class="w10"></th>
        <th>促销名称</th>
        <th>促销费用</th>
        <th>申请日期</th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($output['cost_list']) && !empty($output['cost_list'])){?>
      <?php foreach($output['cost_list'] as $cost_info) { ?>
      <tr class="bd-line">
        <td></td>
        <td><?php echo $cost_info['cost_remark'];?></td>
        <td><?php echo ncPriceFormat($cost_info['cost_price']);?></td>
        <td><?php echo date('Y-m-d',$cost_info['cost_time']);?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php if (is_array($output['order_list']) && !empty($output['order_list'])) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>