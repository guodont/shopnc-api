<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['bill_manage'];?>结算管理</h3>
      <?php //echo $output['top_link'];?>
		<ul class="tab-base">
		<li><a href="index.php?act=bill&op=bill_list"><span>结算管理</span></a></li>
		<li><a class="current" href="JavaScript:void(0);"><span>账单明细</span></a></li>
		</ul>
    </div>
  </div>
<div class="fixed-empty"></div>
    <table class="table tb-type2 noborder search">
      <tbody>
      <tr><td>店铺 - <?php echo $output['bill_info']['ob_store_name'];?>（ID：<?php echo $output['bill_info']['ob_store_id'];?>） <?php echo $output['bill_info']['ob_create_month'];?>期 结算单&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php if ($output['bill_info']['ob_state'] == 2){?>
      <a class="btns" onclick="if (confirm('审核后将无法撤销，进入下一步付款环节，确认审核吗?')){return true;}else{return false;}" href="index.php?act=bill&op=bill_check&bill_id=<?php echo $_GET['bill_id'];?>"><span><?php echo $lang['nc_exdport'];?>审核</span></a>
       <?php }elseif ($output['bill_info']['ob_state'] == 3){?>
		<a class="btns" href="index.php?act=bill&op=bill_pay&bill_id=<?php echo $_GET['bill_id'];?>"><span><?php echo $lang['nc_exdport'];?>付款完成</span></a>
       <?php }elseif ($output['bill_info']['ob_state'] == 4){?>
      <a class="btns" target="_blank" href="index.php?act=bill&op=bill_print&bill_id=<?php echo $_GET['bill_id'];?>"><span><?php echo $lang['nc_exposrt'];?>打印</span></a>
      <?php }?>
      <a class="btns" target="_blank" href="index.php?act=bill&op=export_step1&bill_id=<?php echo $_GET['bill_id'];?>"><span><?php echo $lang['nc_exposrt'];?>导出结算明细</span></a>
      </td></tr>
        <tr><td><?php echo $lang['order_time_from'];?>结算单号：<?php echo $output['bill_info']['ob_no'];?></td></tr>
      	<tr><td>起止日期：<?php echo date('Y-m-d',$output['bill_info']['ob_start_date']);?> &nbsp;至&nbsp; <?php echo date('Y-m-d',$output['bill_info']['ob_end_date']);?>
      	</td></tr><tr>
      <td>出账日期：<?php echo date('Y-m-d',$output['bill_info']['ob_create_date']);?></td></tr><tr>
      <td>平台应付金额：<?php echo number_format($output['bill_info']['ob_order_real_totals']-$output['bill_info']['ob_commission_totals'],2,'.','');?> = <?php echo $output['bill_info']['ob_order_real_totals'];?> (实收订单金额) - <?php echo $output['bill_info']['ob_commission_totals'];?> (佣金)</td>
      </tr>
      <tr><td>结算状态：<?php echo str_replace(array('0','1','2','3','4'),array('未出账','已出账，店铺确认中','店铺已确认，平台审核中','平台已审核，正在付款','结算完成'),$output['bill_info']['ob_state']);?>
      <?php if ($output['bill_info']['ob_state'] == 4){?>
      	，结算日期：<?php echo date('Y-m-d',$output['bill_info']['ob_pay_date']);?>，结算备注：<?php echo $output['bill_info']['ob_pay_content'];?>
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
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="bill" />
    <input type="hidden" name="op" value="show_store_month_order" />
    <input type="hidden" name="bill_id" value="<?php echo $_GET['bill_id'];?>" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
        <th><label for="add_time_from"><?php echo $lang['order_time_from'];?>订单类型</label></th>
          <td>
			<select name="query_type" class="querySelect">
			<option value="real" <?php if($_GET['query_type'] == 'real'){?>selected<?php }?>>实收订单</option>
			<option value="refund" <?php if($_GET['query_type'] == 'refund'){?>selected<?php }?>>退款订单</option>
			</select>
          </td>
          <th><label for="add_time_from"><?php echo $lang['order_time_from'];?>下单时间</label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['query_start_date'];?>" id="query_start_date" name="query_start_date">
            <label>~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['query_end_date'];?>" id="query_end_date" name="query_end_date"/></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th class="align-center"><?php echo $lang['order_number'];?>订单编号</th>
        <th class="align-center"><?php echo $lang['store_name'];?>订单金额</th>
        <th class="align-center"><?php echo $lang['buyer_name'];?>商品金额</th>
        <th class="align-center"><?php echo $lang['order_time'];?>运费</th>
        <?php if ($_GET['query_type'] != 'refund'){?>
        <th class="align-center"><?php echo $lang['payment'];?>佣金</th>
        <?php }else{?>
        <th class="align-center"><?php echo $lang['payment'];?>退款类型</th>
        <?php }?>
        <th class="align-center"><?php echo $lang['order_state'];?>下单日期</th>
        <th class="align-center"><?php echo $lang['nc_handlxe'];?><?php echo $_GET['query_type'] != 'refund' ? '成交日期' : '退款日期';?></th>
        <th class="align-center"><?php echo $lang['nc_handlse'];?>优惠</th>
        <th class="align-center"><?php echo $lang['nc_handlse'];?>买家</th>
        <th><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(count($output['list'])>0){?>
      <?php foreach($output['list'] as $order){?>
      <tr class="hover">
        <td class="align-center"><?php echo $order['order_sn'];?></td>
        <td class="align-center"><?php echo number_format($order['goods_amount']+$order['shipping_fee'],2,'.','');?></td>
        <td class="align-center"><?php echo $order['goods_amount'];?></td>
        <td class="align-center"><?php echo $order['shipping_fee'];?></td>
        <?php if ($_GET['query_type'] != 'refund'){?>
        <td class="align-center"><?php echo number_format($order['goods_amount']*$order['commission_rate']/100,2);?></td>
        <?php }else{?>
        <td class="align-center">全部退款</td>
        <?php }?>
        <td class="align-center"><?php echo date('Y-m-d',$order['add_time']);?></td>
        <td class="align-center"><?php echo date('Y-m-d',$order['finnshed_time']);?></td>
        <td class="align-center">
        <?php
	        if (!empty($order['voucher_id'])) echo '代金券:'.$order['voucher_price'];
	        if (!empty($order['group_id'])) echo '[抢购]';
	        if (!empty($order['xianshi_id'])) echo '[限时]';
	        if (!empty($order['mansong_id'])) echo '[满送]';
	        if (!empty($order['bundling_id'])) echo '[组合]';
        ?>
        </td>
        <td class="align-center"><?php echo $order['buyer_name'];?></rd>
        <td>
        <a href="index.php?act=order&op=show_order&order_id=<?php echo $order['order_id'];?>"><?php echo $lang['nc_view'];?></a>
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
    $('#query_start_date').datepicker({dateFormat:'yy-mm-dd',minDate: new Date(<?php echo date('Y,n,j',strtotime('-1 month',$output['bill_info']['ob_start_date']));?>),maxDate: new Date(<?php echo date('Y,n,j',$output['bill_info']['ob_start_date']-1);?>)});
    $('#query_end_date').datepicker({dateFormat:'yy-mm-dd',minDate: new Date(<?php echo date('Y,n,j',strtotime('-1 month',$output['bill_info']['ob_start_date']));?>),maxDate: new Date(<?php echo date('Y,n,j',$output['bill_info']['ob_start_date']-1);?>)});
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('show_store_month_order');$('#formSearch').submit();
    });
});
</script>
