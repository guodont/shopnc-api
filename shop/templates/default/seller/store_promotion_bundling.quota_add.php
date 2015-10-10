<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <?php if ($output['menu_key'] == 'bundling_quota_add') {?>
  <form id="add_form" action="index.php?act=store_promotion_bundling&op=bundling_quota_add" method="post">
  <?php } else {?>
  <form id="add_form" action="index.php?act=store_promotion_bundling&op=bundling_renew" method="post">
  <?php }?>
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><i class="required">*</i><?php echo $lang['bundling_quota_add_quantity'].$lang['nc_colon'];?></dt>
      <dd>
        <input id="bundling_quota_quantity" name="bundling_quota_quantity" type="text" class="text w50"/><em class="add-on"><?php echo $lang['nc_month'];?></em><span></span>
        <p class="hint"><?php echo $lang['bundling_price_explain1'];?></p>
        <p class="hint"><?php printf($lang['bundling_price_explain2'], intval(C('promotion_bundling_price')));?></p>
        <p class="hint"><strong style="color: red">相关费用会在店铺的账期结算中扣除</strong></p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input id="submit_button" type="submit" value="<?php echo $lang['nc_submit'];?>" class="submit"></label>
    </div>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    //页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			var error_td = element.parent('dd').children('span');
			error_td.append(error);
		},
		submitHandler:function(form){
			var unit_price = parseInt(<?php echo C('promotion_bundling_price');?>);
			var quantity = parseInt($("#bundling_quota_quantity").val());
			var price = unit_price * quantity;
			showDialog('<?php echo $lang['bundling_quota_add_confirm'];?>'+price+'<?php echo $lang['bundling_gold'];?>', 'confirm', '', function(){ajaxpost('add_form', '', '', 'onerror');});
		},
		rules : {
			bundling_quota_quantity : {
				required : true,
				digits : true,
				min : 1,
				max : 12
			}
		},
		messages : {
			bundling_quota_quantity : {
				required : '<i class="icon-exclamation-sign"></i><?php echo $lang['bundling_quota_quantity_error'];?>',
				digits : '<i class="icon-exclamation-sign"></i><?php echo $lang['bundling_quota_quantity_error'];?>',
				min : '<i class="icon-exclamation-sign"></i><?php echo $lang['bundling_quota_quantity_error'];?>',
				max : '<i class="icon-exclamation-sign"></i><?php echo $lang['bundling_quota_quantity_error'];?>'
			}
		}
	});
});
</script> 
