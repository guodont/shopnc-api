<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
   <div class="alert alert-success">
    <h4>操作提示：</h4>
    <ul>
      <li>1. 绑定手机后可直接通过短信接受安全验证等重要操作。</li>
      <li>2. 更改手机时，请通过安全验证后重新输入新手机号码绑定。</li>
      <li>3. 收到安全验证码后，请在30分钟内完成验证。</li>
    </ul>
  </div>
  <div class="ncm-default-form">
    <form method="post" id="mobile_form" action="index.php?act=member_security&op=modify_mobile">
      <input type="hidden" name="form_submit" value="ok" />
      <dl>
        <dt><i class="required">*</i>绑定手机号码：</dt>
        <dd>
        <p>
          <input type="text" class="text"  maxlength="11" value="<?php echo $output['member_info']['member_mobile'];?>" name="mobile" id="mobile" />
          <label for="email" generated="true" class="error"></label>
          <a href="javascript:void(0);" id="send_auth_code" class="ncm-btn ml5"><span id="sending" style="display:none">正在</span><span class="send_success_tips"><strong id="show_times" class="red mr5"></strong>秒后再次</span>获取短信验证码</a></p>
          <p class="send_success_tips hint mt10">“安全验证码”已发出，请注意查收，请在<strong>“30分种”</strong>内完成验证。</p>
            <!-- <input type="button" value="获取短信验证码" id="send_mobile"><span id="send_success_tips" style="display: none">校验码已发出，请注意查收短信，如果没有收到，您可以在<i style="color: red" id="show_times">10</i>秒要求系统重新发送，收到后，请在30分种内完成验证。</span></p>
          <p class="hint">请您输入正确的手机号码以便接收绑定短信验证码，一个手机号码只能绑定一个账号</p>-->
        </dd>
      </dl>
      <dl>
        <dt><i class="required">*</i>输入短信校验码：</dt>
        <dd>
          <input type="text" class="text"  maxlength="6" value="" name="vcode" id="vcode" />
          <label for="email" generated="true" class="error"></label>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd><label class="submit-border">
          <input type="submit" class="submit" value="立即绑定" /></label>
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
$('.send_success_tips').hide();
var ALLOW_SEND = true;
$(function(){
	function StepTimes() {
		$num = parseInt($('#show_times').html());
		$num = $num - 1;
		$('#show_times').html($num);
		if ($num <= 0) {
			ALLOW_SEND = !ALLOW_SEND;
			$('.send_success_tips').hide();
		} else {
			setTimeout(StepTimes,1000);
		}
	}
	$('#send_auth_code').on('click',function(){
		if ($('#mobile').val() == '') return false;
		if (!ALLOW_SEND) return;
		ALLOW_SEND = !ALLOW_SEND;
		$('#sending').show();
		$.getJSON('index.php?act=member_security&op=send_modify_mobile',{mobile:$('#mobile').val()},function(data){
			if (data.state == 'true') {
				$('#sending').hide();
			    $('.send_success_tips').show();
			    $('#show_times').html(60);
			    setTimeout(StepTimes,1000);
			} else {
				ALLOW_SEND = !ALLOW_SEND;
				$('#sending').hide();
				$('.send_success_tips').hide();
				showDialog(data.msg,'error','','','','','','','','',2);
			}
		});
	});
    $('#mobile_form').validate({
        submitHandler:function(form){
            ajaxpost('mobile_form', '', '', 'onerror') 
        },
        rules : {
        	vcode : {
                required : true,
                maxlength : 6,
                minlength : 6,
                digits : true
            }
        },
        messages : {
        	vcode : {
                required : '<i class="icon-exclamation-sign"></i>请正确输入手机校验码',
                maxlength : '<i class="icon-exclamation-sign"></i>请正确输入手机校验码',
				minlength : '<i class="icon-exclamation-sign"></i>请正确输入手机校验码',
				digits : '<i class="icon-exclamation-sign"></i>请正确输入手机校验码'
            }
        }
    });
});
</script> 
