<div class="eject_con" style="overflow: visible;">
  <form id="add_form" action="index.php?act=member_vr_order&op=resend" method="post"  onsubmit="ajaxpost('add_form','','','onerror')">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="order_id" value="<?php echo $_GET['order_id'];?>" />
    <div class="alert">
    <ul>
    <li>1. 确认接收电子兑换码/券的手机号码，如发生变更请重新输入。</li>
    <li>2. 系统最多重新发送<em>5</em>次电子兑换码。</li>
    </ul>
    </div>
    <dl style="overflow: visible;">
      <dt><i class="required">*</i>接收手机：</dt>
      <dd>
        <div class="parentCls"><input class="inputElem text w200" name="buyer_phone" type="text" id=buyer_phone value="<?php echo $_GET['buyer_phone'];?>" autocomplete="off" autofocus="autofocus" maxlength="11"  /></div>
        <span></span>
        
      </dd>
    </dl>
    <div class="bottom">
        <label class="submit-border">
          <input type="submit" id="submit" class="submit" value="确认发送" />
        </label>
        <a class="ncm-btn ml5" href="javascript:DialogManager.close('vr_code_resend');">取消</a>
    </div>
  </form>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/input_max.js"></script>
<script>
//input内容放大
$(function(){
	new TextMagnifier({
		inputElem: '.inputElem',
			align: 'top'
	});
});

$(document).ready(function(){
	$('#submit').on('click',function(){
		$('#add_form').submit();
	});
	$("#add_form").validate({
		onkeyup: false,
		rules: {
			buyer_phone : { 
				required : true,
				digits : true,
				minlength : 11
			}
		},
		messages: {
			buyer_phone : {
				required : "<i class='icon-exclamation-sign'></i>请填写手机号码",
				digits : "<i class='icon-exclamation-sign'></i>请正确填写手机号码",
				minlength : "<i class='icon-exclamation-sign'></i>请正确填写手机号码"
			}
		}
	});
});
</script>