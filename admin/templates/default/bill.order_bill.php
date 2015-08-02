<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['bill_manage'];?>结算管理</h3>
      <?php //echo $output['top_link'];?>
		<ul class="tab-base">
		<li>
		<a class="current" href="JavaScript:void(0);">
		<span>结算管理</span>
		</a>
		</li>
		</ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" target="" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="bill" />
    <input type="hidden" name="op" value="bill_list" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="add_time_from"><?php echo $lang['order_time_from'];?>账期</label></th>
          <td>
			<select name="query_month" class="querySelect">
			<option value=""><?php echo $lang['nc_please_choose'];?></option>
			<?php foreach($output['month_list'] as $v){?>
			<option value="<?php echo $v;?>" <?php if($_GET['query_month'] == $v){?>selected<?php }?>><?php echo $v;?></option>
			<?php }?>
			</select>
          </td>
          <th><label for="order_amount_from"><?php echo $lang['order_price_from'];?>店铺ID/名称</label></th>
          <td><input class="txt-short" type="text" value="<?php echo $_GET['query_store'];?>" name="query_store" id="query_store"/></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
          
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['order_help1'];?>系统默认只显示上期账单</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <div style="text-align:right;"><a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?>Excel</span></a></div>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['order_number'];?>账单编号</th>
        <th class="align-center"><?php echo $lang['store_name'];?>开始日期</th>
        <th class="align-center"><?php echo $lang['buyer_name'];?>结束日期</th>
        <th class="align-center"><?php echo $lang['order_time'];?>实收订单</th>
        <th class="align-center"><?php echo $lang['order_state'];?>实收佣金</th>
        <th class="align-center"><?php echo $lang['order_state'];?>应结金额</th>
        <th class="align-center"><?php echo $lang['order_total_price'];?>退款订单</th>
        <th class="align-center"><?php echo $lang['nc_handlxe'];?>出账日期</th>
        <th class="align-center"><?php echo $lang['nc_handlse'];?>账单状态</th>
        <th class="align-center"><?php echo $lang['nc_handlse'];?>店铺</th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(count($output['list'])>0){?>
      <?php foreach($output['list'] as $order){?>
      <tr class="hover">
        <td>
            <?php echo $order['ob_no'];?>
        </td>
        <td class="nowrap align-center"><?php echo date('Y-m-d',$order['ob_start_date']);?></td>
        <td class="nowrap align-center"><?php echo date('Y-m-d',$order['ob_end_date']);?></td>
        <td class="align-center"><?php echo $order['ob_state'] ? $order['ob_order_real_totals'] : '';?></td>
        <td class="align-center"><?php echo $order['ob_state'] ? $order['ob_commission_totals'] : '';?></td>        
        <td class="align-center"><?php echo $order['ob_state'] ? number_format($order['ob_order_real_totals']-$order['ob_commission_totals'],2) : '';?></td>        
        <td class="align-center"><?php echo $order['ob_state'] ? $order['ob_order_tdth_totals'] : '';?></td>
        <td class="align-center"><?php echo $order['ob_state'] ? date('Y-m-d',$order['ob_create_date']) : '';?></td>
        <td class="align-center">
        <?php echo str_replace(array('0','1','2','3','4'),array('未出账','已出账','店铺已确认','平台已审核','结算完成'),$order['ob_state']);?>
        </td>
        <td class="align-center"><?php echo $order['ob_store_name'].'<br/>id:'.$order['ob_store_id'];?></td>
        <td class="align-center">
        <a href="index.php?act=bill&op=show_store_month_order&bill_id=<?php echo $order['ob_no'];?>"><?php echo $lang['nc_view'];?></a>
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
    $('#bill_month').datepicker({dateFormat:'yy-mm'});
    $('#ncexport').click(function(){
    	$('input[name="op"]').val('export');
    	$('#formSearch').attr('target','_blank');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('#formSearch').attr('target','_self');
    	$('input[name="op"]').val('bill_list');$('#formSearch').submit();
    });
});
</script> 
