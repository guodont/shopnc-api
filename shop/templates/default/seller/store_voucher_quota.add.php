<?php defined('InShopNC') or exit('Access Invalid!'); ?>

  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="ncsc-form-default">
    <form id="add_form" action="index.php?act=store_voucher&op=quotaadd" method="post">
    	<input type="hidden" name="form_submit" value="ok"/>
      <dl>
        <dt><i class="required">*</i><?php echo $lang['voucher_apply_addnum'].$lang['nc_colon'];?></dt>
        <dd><input id="quota_quantity" name="quota_quantity" type="text" class="text w50"/><em class="add-on"><?php echo $lang['nc_month'];?></em><span></span>
          <p class="hint"><?php echo $lang['voucher_apply_add_tip1'];?></p>
          <p class="hint"><?php echo sprintf($lang['voucher_apply_add_tip2'],C('promotion_voucher_price'));?>,<?php echo sprintf($lang['voucher_apply_add_tip3'],C('promotion_voucher_storetimes_limit'));?></p>
        <p class="hint"><strong style="color: red">相关费用会在店铺的账期结算中扣除</strong></p>          
        </dd>
      </dl>
      <div class="bottom">
          <label class="submit-border"><input id="submit_button" type="submit" value="<?php echo $lang['nc_submit'];?>"  class="submit"></label>
      </div>
    </form>
  </div>
<script>
$(document).ready(function(){
    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
    	submitHandler:function(form){
            var unit_price = parseInt(<?php echo C('promotion_voucher_price');?>);
            var quantity = parseInt($("#quota_quantity").val());
            var price = unit_price * quantity;
            showDialog('<?php echo $lang['voucher_apply_add_confirm1'];?>'+price+'<?php echo $lang['voucher_apply_add_confirm2'];?>', 'confirm', '', function(){
            	ajaxpost('add_form', '', '', 'onerror');
            });
    	},
        rules : {
            quota_quantity : {
                required : true,
                digits : true,
                min : 1,
                max : 12
            }
        },
        messages : {
            quota_quantity : {
            	required : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_apply_num_error'];?>', 
            	digits : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_apply_num_error'];?>', 
            	min : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_apply_num_error'];?>',
            	max : '<i class="icon-exclamation-sign"></i><?php echo $lang['voucher_apply_num_error'];?>'
            }
       	}
    });
});
</script> 
