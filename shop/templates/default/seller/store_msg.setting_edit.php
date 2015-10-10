<div class="eject_con">
	<div id="warning" class="alert alert-error"></div>
	<form method="post" target="_parent"
		action="<?php echo urlShop('store_msg', 'save_msg_setting');?>"
		id="store_msg_setting">
		<input type="hidden" name="form_submit" value="ok" /> <input
			type="hidden" name="code"
			value="<?php echo $output['smt_info']['smt_code']; ?>" />
    <?php if ($output['smt_info']['smt_message_switch']) {?>
    <dl>
			<dt>
				<input type="checkbox" class="checkbox mr5" name="message_forced"
					value="1" <?php if ($output['smt_info']['smt_message_forced']) {?>
					disabled="disabled" checked="checked" <?php }?>
					<?php if ($output['smsetting_info']['sms_message_switch']) {?>
					checked="checked" <?php }?> /> <strong>商家消息提醒<?php echo $lang['nc_colon'];?></strong>
			</dt>
			<dd>系统将自动发送站内消息给商家。</dd>
		</dl>
    <?php }?>
    <?php if ($output['smt_info']['smt_short_switch']) {?>
    <dl>
			<dt>
				<input type="checkbox" class="checkbox mr5" name="short_forced" id="short_forced"
					value="1" <?php if ($output['smt_info']['smt_short_forced']) {?>
					disabled="disabled" checked="checked" <?php }?>
					<?php if ($output['smsetting_info']['sms_short_switch']) {?>
					checked="checked" <?php }?> /> <strong>手机短信提醒<?php echo $lang['nc_colon'];?></strong>
			</dt>
			<dd>
				<input type="text" class="text w250" name="short_number" id="short_number"
					value="<?php echo $output['smsetting_info']['sms_short_number']?>" />
				<p class="hint">选择短信提醒并认真填写接受信息的手机号码。</p>
			</dd>
		</dl>
    <?php }?>
    <?php if ($output['smt_info']['smt_mail_switch']) {?>
    <dl>
			<dt>
				<input type="checkbox" class="checkbox mr5" name="mail_forced" id="mail_forced"
					value="1" <?php if ($output['smt_info']['smt_mail_forced']) {?>
					disabled="disabled" checked="checked" <?php }?>
					<?php if ($output['smsetting_info']['sms_mail_switch']) {?>
					checked="checked" <?php }?> /> <strong>邮件提醒<?php echo $lang['nc_colon'];?></strong>
			</dt>
			<dd>
				<input type="text" class="text w250" name="mail_number" id="mail_number"
					value="<?php echo $output['smsetting_info']['sms_mail_number']?>" />
				<p class="hint">选择邮件提醒并认真填写接受信息的邮件地址。</p>
			</dd>
		</dl>
    <?php }?>
    <div class="bottom">
			<label class="submit-border"> <input type="submit" class="submit"
				value="<?php echo $lang['nc_submit'];?>" />
			</label>
		</div>
	</form>
</div>
<script>
$(function(){
    $('#store_msg_setting').validate({
        errorLabelContainer: $('#warning'),
        submitHandler:function(form){
            ajaxpost('store_msg_setting', '', '', 'onerror');
        },
        rules : {
            short_number : {
                required : '#short_forced:checked',
                digits : true,
                rangelength : [11,11]
            },
            mail_number : {
                required : '#mail_forced:checked',
                email : true
            }
        },
        messages : {
            short_number : {
                required : '<i class="icon-exclamation-sign"></i>请填写正确的手机号',
                digits : '<i class="icon-exclamation-sign"></i>请填写正确的手机号',
                rangelength : '<i class="icon-exclamation-sign"></i>请填写正确的手机号'
            },
            mail_number : {
                required : '<i class="icon-exclamation-sign"></i>请填写正确的邮箱',
                email : '<i class="icon-exclamation-sign"></i>请填写正确的邮箱'
            }
        }
    });
});
</script>