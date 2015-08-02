<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>虚拟订单结算</h3>
		<ul class="tab-base">
		<li><a href="index.php?act=vr_bill"><span>结算管理</span></a></li>
		<li><a class="current" href="JavaScript:void(0);"><span><?php echo !empty($_GET['os_month']) ? $_GET['os_month'].'期' : null;?> 商家账单列表</span></a></li>
		</ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" target="" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="vr_bill" />
    <input type="hidden" name="op" value="show_statis" />
    <input type="hidden" name="os_month" value="<?php echo $_GET['os_month'];?>">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th>店铺ID/名称</th>
          <td><input class="txt-short" type="text" value="<?php echo $_GET['query_store'];?>" name="query_store" id="query_store"/></td>
          <th>账单状态</th>
          <td>
          <select name="bill_state">
          <option><?php echo L('nc_please_choose');?></option>
          <option <?php if ($_GET['bill_state'] == BILL_STATE_CREATE) {?>selected<?php } ?> value="<?php echo BILL_STATE_CREATE;?>">已出账</option>
          <option <?php if ($_GET['bill_state'] == BILL_STATE_STORE_COFIRM) {?>selected<?php } ?> value="<?php echo BILL_STATE_STORE_COFIRM;?>">商家已确认</option>
          <option <?php if ($_GET['bill_state'] == BILL_STATE_SYSTEM_CHECK) {?>selected<?php } ?> value="<?php echo BILL_STATE_SYSTEM_CHECK?>">平台已审核</option>
          <option <?php if ($_GET['bill_state'] == BILL_STATE_SUCCESS) {?>selected<?php } ?> value="<?php echo BILL_STATE_SUCCESS?>">结算完成</option>
          </select>
          </td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>此处列出了详细的店铺账单信息，点击查看可以查看详细的订单信息、退单信息和店铺费用信息</li>
            <li>账单处理流程为：系统出账 > 商家确认 > 平台审核 > 财务支付(完成结算) 4个环节，其中平台审核和财务支付需要平台介入，请予以关注</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <div style="text-align:right;"><a class="btns" href="index.php?<?php echo $_SERVER['QUERY_STRING'];?>&op=export_bill"><span><?php echo $lang['nc_export'];?>CSV</span></a></div>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th>账单编号</th>
        <th class="align-center">开始日期</th>
        <th class="align-center">结束日期</th>
        <th class="align-center">消费金额</th>
        <th class="align-center">佣金金额</th>
        <th class="align-center">本期应结</th>
        <th class="align-center">出账日期</th>
        <th class="align-center">账单状态</th>
        <th class="align-center">店铺</th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(count($output['bill_list'])>0){?>
      <?php foreach($output['bill_list'] as $bill_info){?>
      <tr class="hover">
        <td><?php echo $bill_info['ob_no'];?></td>
        <td class="nowrap align-center"><?php echo date('Y-m-d',$bill_info['ob_start_date']);?></td>
        <td class="nowrap align-center"><?php echo date('Y-m-d',$bill_info['ob_end_date']);?></td>
        <td class="align-center"><?php echo $bill_info['ob_order_totals'];?></td>
        <td class="align-center"><?php echo $bill_info['ob_commis_totals'];?></td>        
        <td class="align-center"><?php echo $bill_info['ob_result_totals'];?></td>
        <td class="align-center"><?php echo date('Y-m-d',$bill_info['ob_create_date']);?></td>
        <td class="align-center"><?php echo billState($bill_info['ob_state']);?></td>
        <td class="align-center"><?php echo $bill_info['ob_store_name'].'<br/>id:'.$bill_info['ob_store_id'];?></td>
        <td class="align-center">
        <a href="index.php?act=vr_bill&op=show_bill&ob_no=<?php echo $bill_info['ob_no'];?>"><?php echo $lang['nc_view'];?></a>
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
    $('#ncsubmit').click(function(){
    	$('#formSearch').attr('target','_self');
    	$('input[name="op"]').val('show_statis');$('#formSearch').submit();
    });
});
</script> 
