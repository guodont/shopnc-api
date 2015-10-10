<?php defined('InShopNC') or exit('Access Invalid!');?>
<form method="get" id="formSearch">
<table class="search-form">
  <input type="hidden" id='act' name='act' value='store_bill' />
  <input type="hidden" id='op' name='op' value='show_bill' />
  <input type="hidden" name='ob_no' value='<?php echo $_GET['ob_no'];?>' />
  <input type="hidden" name='type' value='<?php echo $_GET['type'];?>' />
  <tr>
    <td>&nbsp;</td>
    <th>退单编号</th>
    <td class="w180"><input type="text" class="text"  value="" name="query_order_no" /></td>
    <th>退单时间</th>
    <td class="w180">
    	<input type="text" class="text w70" name="query_start_date" id="query_start_date" value="<?php echo $_GET['query_start_date']; ?>"/>
      &#8211;
      <input type="text" class="text w70" name="query_end_date" id="query_end_date" value="<?php echo $_GET['query_end_date']; ?>"/>
    </td>
    <td class="tc w180">
    <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label>
    <label class="submit-border"><input type="button" id="ncexport" class="submit" value="导出" /></label>
    </td>
</table>
</form>
<table class="ncsc-default-table">
    <thead>
      <tr>
        <th class="w10"></th>
        <th>退单编号</th>
        <th>订单编号</th>
        <th>退款金额</th>
        <th>退还佣金</th>
        <th>类型</th>
        <th>退单时间</th>
      </tr>
    </thead>
    <tbody>
      <?php if (is_array($output['refund_list']) && !empty($output['refund_list'])) { ?>
      <?php foreach($output['refund_list'] as $refund_info) { ?>
      <tr class="bd-line">
        <td></td>
        <td><?php echo $refund_info['refund_sn'];?></td>
        <td><?php echo $refund_info['order_sn'];?></td>
        <td><?php echo $refund_info['refund_amount'];?></td>
        <td><?php echo ncPriceFormat($refund_info['commis_amount']);?></td>
        <td><?php echo str_replace(array(1,2), array('退款 ','退货'),$refund_info['refund_type']);?></td>
        <td><?php echo date("Y-m-d",$refund_info['admin_time']);?></td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php if (is_array($output['refund_list']) && !empty($output['refund_list'])) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
<script type="text/javascript">
$(function(){
    $('#ncexport').click(function(){
    	$('input[name="op"]').val('export_refund_order');
    	$('#formSearch').submit();
    });
});
</script>