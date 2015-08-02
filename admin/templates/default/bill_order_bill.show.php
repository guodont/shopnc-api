<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['bill_manage'];?>结算管理</h3>
		<ul class="tab-base">
		<li><a href="index.php?act=bill"><span>结算管理</span></a></li>
		<li><a href="index.php?act=bill&op=show_statis&os_month=<?php echo $output['bill_info']['os_month'];?>"><span><?php echo $output['bill_info']['os_month'];?>期  商家账单列表</span></a></li>
		<li><a class="current" href="JavaScript:void(0);"><span>账单明细</span></a></li>
		</ul>
    </div>
  </div>
<div class="fixed-empty"></div>  
    <table class="table tb-type2 noborder search">
      <tbody>
      <tr><td>店铺 - <?php echo $output['bill_info']['ob_store_name'];?>（ID：<?php echo $output['bill_info']['ob_store_id'];?>） <?php echo $output['bill_info']['os_month'];?> 期 结算单&emsp;
      <?php if ($output['bill_info']['ob_state'] == BILL_STATE_STORE_COFIRM){?>
      <a class="btns" onclick="if (confirm('审核后将无法撤销，进入下一步付款环节，确认审核吗?')){return true;}else{return false;}" href="index.php?act=bill&op=bill_check&ob_no=<?php echo $_GET['ob_no'];?>"><span><?php echo $lang['nc_exdport'];?>审核</span></a>
       <?php }elseif ($output['bill_info']['ob_state'] == BILL_STATE_SYSTEM_CHECK){?>
		<a class="btns" href="index.php?act=bill&op=bill_pay&ob_no=<?php echo $_GET['ob_no'];?>"><span><?php echo $lang['nc_exdport'];?>付款完成</span></a>
       <?php }elseif ($output['bill_info']['ob_state'] == BILL_STATE_SUCCESS){?>
      <a class="btns" target="_blank" href="index.php?act=bill&op=bill_print&ob_no=<?php echo $_GET['ob_no'];?>"><span><?php echo $lang['nc_exposrt'];?>打印</span></a>
      <?php }?>
      </td></tr>
        <tr><td><?php echo $lang['order_time_from'];?>结算单号<?php echo $lang['nc_colon'];?><?php echo $output['bill_info']['ob_no'];?></td></tr>
      	<tr><td>起止日期<?php echo $lang['nc_colon'];?><?php echo date('Y-m-d',$output['bill_info']['ob_start_date']);?> &nbsp;至&nbsp; <?php echo date('Y-m-d',$output['bill_info']['ob_end_date']);?>
      	</td></tr><tr>
      <td>出账日期<?php echo $lang['nc_colon'];?><?php echo date('Y-m-d',$output['bill_info']['ob_create_date']);?></td></tr><tr>
      <td>平台应付金额：<?php echo $output['bill_info']['ob_result_totals'];?> = <?php echo $output['bill_info']['ob_order_totals'];?> (订单金额) - <?php echo $output['bill_info']['ob_commis_totals'];?> (佣金金额) - <?php echo $output['bill_info']['ob_order_return_totals'];?> (退单金额) + <?php echo $output['bill_info']['ob_commis_return_totals'];?> (退还佣金) - <?php echo $output['bill_info']['ob_store_cost_totals'];?> (店铺促销费用)</td>
      </tr>
      <tr><td>结算状态：<?php echo billState($output['bill_info']['ob_state']);?>
      <?php if ($output['bill_info']['ob_state'] == BILL_STATE_SUCCESS){?>
      	&emsp;结算日期<?php echo $lang['nc_colon'];?><?php echo date('Y-m-d',$output['bill_info']['ob_pay_date']);?>，结算备注<?php echo $lang['nc_colon'];?><?php echo $output['bill_info']['ob_pay_content'];?>
      <?php }?>
      </td></tr>
      </tbody>
    </table>
   <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space">
        <th colspan="12"></th>
      </tr>
    </tbody>
  </table>
<?php include template($output['tpl_name']);?>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#query_start_date').datepicker({dateFormat:'yy-mm-dd',minDate: "<?php echo date('Y-m-d',$output['bill_info']['ob_start_date']);?>",maxDate: "<?php echo date('Y-m-d',$output['bill_info']['ob_end_date']);?>"});
    $('#query_end_date').datepicker({dateFormat:'yy-mm-dd',minDate: "<?php echo date('Y-m-d',$output['bill_info']['ob_start_date']);?>",maxDate: "<?php echo date('Y-m-d',$output['bill_info']['ob_end_date']);?>"});
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('show_bill');$('#formSearch').submit();
    });
});
</script> 
