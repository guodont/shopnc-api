<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>虚拟订单结算</h3>
        <ul class="tab-base">
        <li><a class="current" href="JavaScript:void(0);"><span>结算管理</span></a></li>
        <li><a href="index.php?act=vr_bill&op=show_statis"><span>商家账单列表</span></a></li></ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" target="" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="vr_bill" />
    <input type="hidden" name="op" value="index" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><?php echo $lang['order_time_from'];?>按年份搜索</th>
          <td>
			<select name="query_year" class="querySelect">
			<option value=""><?php echo $lang['nc_please_choose'];?></option>
			<?php for($i = date('Y',TIMESTAMP)-5; $i <= date('Y',TIMESTAMP)+2; $i++) { ?>
			<option value="<?php echo $i;?>" <?php if ($_GET['query_year'] == $i) {?>selected<?php } ?>><?php echo $i;?></option>
			<?php } ?>
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
            <li>此处列出了平台每月的结算信息汇总，点击查看可以查看本月详细的店铺账单信息列表</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['order_number'];?>账单（月）</th>
        <th class="align-center">开始日期</th>
        <th class="align-center">结束日期</th>
        <th class="align-center">订单金额</th>
        <th class="align-center">收取佣金</th>
        <th class="align-center">本期应结</th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($output['bill_list']) && !empty($output['bill_list'])){?>
      <?php foreach($output['bill_list'] as $bill){?>
      <tr class="hover">
        <td>
            <?php echo substr($bill['os_month'],0,4).'-'.substr($bill['os_month'],4);?>
        </td>
        <td class="nowrap align-center"><?php echo date('Y-m-d',$bill['os_start_date']);?></td>
        <td class="nowrap align-center"><?php echo date('Y-m-d',$bill['os_end_date']);?></td>
        <td class="align-center"><?php echo $bill['os_order_totals'];?></td>
        <td class="align-center"><?php echo $bill['os_commis_totals'];?></td>
        <td class="align-center"><?php echo $bill['os_result_totals'];?></td>
        <td class="align-center">
        <a href="index.php?act=vr_bill&op=show_statis&os_month=<?php echo $bill['os_month'];?>"><?php echo $lang['nc_view'];?></a>
        </td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php }?>
    </tbody>
    <?php if(is_array($output['bill_list']) && !empty($output['bill_list'])){?>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('index');$('#formSearch').submit();
    });
});
</script>