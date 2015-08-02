<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['bill_manage'];?>结算管理</h3>
      <?php echo $output['top_link'];?>
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
            <li><?php echo $lang['order_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['order_number'];?>账单（月）</th>
        <th class="align-center"><?php echo $lang['store_name'];?>开始日期</th>
        <th class="align-center"><?php echo $lang['buyer_name'];?>结束日期</th>
        <th class="align-center"><?php echo $lang['order_time'];?>成单金额</th>
        <th class="align-center"><?php echo $lang['order_total_price'];?>退单金额</th>
        <th class="align-center"><?php echo $lang['payment'];?>实际订单金额</th>
        <th class="align-center"><?php echo $lang['order_state'];?>实收佣金</th>
        <th class="align-center"><?php echo $lang['nc_handlxe'];?>生成日期</th>
        <th class="align-center"><?php echo $lang['nc_handlse'];?>账单状态</th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(count($output['list'])>0){?>
      <?php foreach($output['list'] as $order){?>
      <tr class="hover">
        <td>
            <?php echo substr($order['os_month'],0,4).'-'.substr($order['os_month'],4);?>
        </td>
        <td class="nowrap align-center"><?php echo date('Y-m-d',$order['os_start_date']);?></td>
        <td class="nowrap align-center"><?php echo date('Y-m-d',$order['os_end_date']);?></td>
        <td class="align-center"><?php echo $order['os_state'] ? $order['os_order_totals'] : '';?></td>
        <td class="align-center"><?php echo $order['os_state'] ? $order['os_order_tkth_totals'] : '';?></td>
        <td class="align-center"><?php echo $order['os_state'] ? $order['os_order_real_totals'] : '';?></td>
        <td class="align-center"><?php echo $order['os_state'] ? $order['os_commission_totals'] : '';?></td>
        <td><?php echo $order['os_create_date'] ? date('Y-m-d H:i:s',$order['os_create_date']) : '';?></td>
        <td class="align-center"><?php echo $order['os_state'] ? '已出账' : '未出账';?></td>
        <td class="align-center">
        <a href="index.php?act=bill&op=show_month&month=<?php echo $order['os_month'];?>"><?php echo $lang['nc_view'];?></a>
        </td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncexport').click(function(){
    	$('input[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('order_manage');$('#formSearch').submit();
    });
});
</script> 
