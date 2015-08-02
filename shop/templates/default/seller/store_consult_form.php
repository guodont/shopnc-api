<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div id="warning" class="alert alert-error"></div>
  <form id="message" target="_parent" method="post" action="index.php?act=store_consult&op=reply_save&consult_id=<?php echo $output['consult']['consult_id'];?>">
    <input type="hidden" name="type" value="<?php echo $output['consult']['consult_reply']==""?"reply":"edit"?>"/>
    <dl>
      <dt><?php echo $lang['store_consult_list_consult_content'].$lang['nc_colon'];?></dt>
      <dd><p style="line-height: 18px;"><?php echo nl2br($output['consult']['consult_content']);?></p></dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_consult_list_reply_consult'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="hidden" id="consult_id" name="consult_id" value="<?php echo $output['consult']['consult_id'];?>"/>
        <textarea  name="content" rows="3" class="w300" maxlength="150"><?php echo nl2br($output['consult']['consult_reply']);?></textarea>
      </dd>
    </dl>
    <div class="bottom">
        <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_ok'];?>" /></label>
    </div>
  </form>
</div>
<script>
$(function(){
     $('#message').validate({
        errorLabelContainer: $('#warning'),
    	submitHandler:function(form){
    		ajaxpost('message', '', '', 'onerror');
    	},
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
        rules : {
                     content : {
                         required : true,
                         maxlength: 200
                     }
                  },
        messages : {
                     content : {
                         required : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_consult_reply_input_content'];?>',
                         maxlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['store_consult_reply_input_content_tip'];?>'
                        }
                     }
         });
});
</script> 
