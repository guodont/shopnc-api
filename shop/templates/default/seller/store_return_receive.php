<div class="eject_con">
  <div id="warning" class="alert alert-error"></div>
  <form action="index.php?act=store_return&op=receive&return_id=<?php echo $output['return']['refund_id']; ?>" method="post" id="post_form">
    <input type="hidden" name="form_submit" value="ok" />
	  <dl>
	    <dt><?php echo '发货时间'.$lang['nc_colon'];?></dt>
	    <dd> <?php echo date("Y-m-d H:i:s",$output['return']['delay_time']); ?> </dd>
	  </dl>
	  <dl>
	    <dt><?php echo '物流信息'.$lang['nc_colon'];?></dt>
	    <dd> <?php echo $output['e_name'].' , '.$output['return']['invoice_no']; ?> </dd>
	  </dl>
    <dl>
      <dt><i class="required">*</i><?php echo '收货情况'.$lang['nc_colon'];?></dt>
      <dd><select name="return_type">
          <option value=""><?php echo $lang['nc_please_choose']; ?></option>
          <option value="4"><?php echo '已收到'; ?></option>
          <?php if ($output['delay_time'] > 0) { ?>
          <option value="3"><?php echo '未收到'; ?></option>
          <?php } ?>
        </select>
        <p class="hint">如果暂时没收到请联系买家，发货 <?php echo $output['return_delay'];?> 天后可以选择未收到，买家可以廷长时间，超过 <?php echo $output['return_confirm'];?> 天不处理按弃货处理。</p>
      </dd>
    </dl>
    <div class="bottom">
        <label class="submit-border"><input type="submit" class="submit" id="confirm_yes" value="<?php echo $lang['nc_ok'];?>" /></label>
    </div>
  </form>
</div>
<script type="text/javascript">
$(function(){
    $('#post_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
         submitHandler: function(form) {
			    	ajaxpost('post_form', '', '', 'onerror');
				 },
        rules : {
            return_type : {
                required   : true
            }
        },
        messages : {
            return_type  : {
                required  : '<i class="icon-exclamation-sign"></i><?php echo '请选择收货情况';?>'
            }
        }
	    });
});
</script>