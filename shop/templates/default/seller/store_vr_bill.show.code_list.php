<?php defined('InShopNC') or exit('Access Invalid!');?>
  <form method="get" id="formSearch">
    <table class="search-form">
      <input type="hidden" id='act' name='act' value='store_vr_bill' />
      <input type="hidden" id='op' name='op' value='show_bill' />
      <input type="hidden" name='ob_no' value='<?php echo $_GET['ob_no'];?>' />
      <input type="hidden" name='type' value='<?php echo $_GET['type'];?>' />
      <tr>
        <td>&nbsp;</td>
        <th>订单编号</th>
        <td class="w180"><input type="text" class="text"  value="<?php echo $_GET['query_order_no'];?>" name="query_order_no" /></td>
        <th><?php echo $_GET['type'] == 'timeout' ? '过期时间' : '消费时间';?></th>
        <td class="w180">
        	<input type="text" class="text w70" name="query_start_date" id="query_start_date" value="<?php echo $_GET['query_start_date']; ?>"/>
          &#8211;
          <input type="text" class="text w70" name="query_end_date" id="query_end_date" value="<?php echo $_GET['query_end_date']; ?>"/>
        </td>
        <td class="tc w200">
        <label class="submit-border"><input type="button" id="ncsubmit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label>
        <label class="submit-border"><input type="button" id="ncexport" class="submit" value="导出" /></label>
        </td>
    </table>
  </form>
<table class="ncsc-default-table">
    <thead>
      <tr>
        <th class="w10"></th>
        <th>兑换码</th>
        <th><?php echo $_GET['type'] == 'timeout' ? '过期时间' : '消费时间';?></th>
        <th>会员</th>
        <th>订单号</th>
        <th>消费金额</th>
        <th>佣金金额</th>
        <th><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (is_array($output['code_list']) && !empty($output['code_list'])) { ?>
      <?php foreach($output['code_list'] as $code_info) { ?>
      <tr class="bd-line">
        <td></td>
        <td class="w90"><?php echo $code_info['vr_code'];?></td>
        <td>
        <?php if ($_GET['type'] == 'timeout') { ?>
        <?php echo date("Y-m-d H:i:s",$code_info['vr_indate']);?></td>
        <?php } else { ?>
        <?php echo date("Y-m-d H:i:s",$code_info['vr_usetime']);?></td>
        <?php } ?>
        <td><?php echo $output['order_list'][$code_info['order_id']]['buyer_name'];?></td>
        <td><?php echo $output['order_list'][$code_info['order_id']]['order_sn'];?></td>
        <td><?php echo $code_info['pay_price'];?></td>
        <td><?php echo ncPriceFormat($code_info['pay_price'] * $code_info['commis_rate']/100);?></td>
        <td>
       	<a target="_blank" href="index.php?act=store_vr_order&op=show_order&order_id=<?php echo $code_info['order_id'];?>"><?php echo $lang['nc_view'];?></a>
        </td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php if (is_array($output['code_list']) && !empty($output['code_list'])) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
<script type="text/javascript">
$(function(){
    $('#ncexport').click(function(){
    	$('input[name="op"]').val('export_order');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('show_bill');
    	$('#formSearch').submit();
    });
});
</script>