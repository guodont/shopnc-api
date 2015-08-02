<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>结算管理</h3>
		<ul class="tab-base">
		<li><a href="index.php?act=bill&op=index"><span>结算管理</span></a></li>
		<li><a class="current" href="JavaScript:void(0);"><span>账单付款</span></a></li>
		</ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="form1" id="form1" action="index.php?act=bill&op=bill_pay&ob_no=<?php echo $_GET['ob_no'];?>">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="site_name">账单编号<?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $_GET['ob_no'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required">付款日期 <?php echo $lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input readonly id="pay_date" class="" name="pay_date" value="" type="text" /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="closed_reason">付款备注<?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="pay_content" rows="6" class="tarea" id="pay_content"></textarea></td>
          <td class="vatop tips"><span class="vatop rowform">请输入汇款单号、支付方式等付款凭证</span></td>
        </tr>
      </tbody>
      <tfoot id="submit-holder">
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" id="ncsubmit" class="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#pay_date').datepicker({dateFormat:'yy-mm-dd',maxDate: '<?php echo date('Y-m-d',TIMESTAMP);?>'});
    $('#ncsubmit').click(function(){
    	if ($('#pay_date').val() == '') return false;
    	if (confirm("操作提醒：\n该操作不可撤销\n提交前请务必确认店铺是否已收到付款\n继续操作吗?")){
    	}else{
    		return false;
    	}
    	$('#form1').submit();
    });
});
</script> 