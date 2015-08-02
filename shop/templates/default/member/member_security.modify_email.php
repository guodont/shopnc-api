<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="alert alert-success">
    <h4>操作提示：</h4>
    <ul>
      <li>1. 此邮箱将接收密码找回，订单通知等敏感性安全服务及提醒使用，请务必填写正确地址。</li>
      <li>2. 设置提交后，系统将自动发送验证邮件到您绑定的信箱，您需在24小时内登录邮箱并完成验证。</li>
      <li>3. 更改邮箱时，请通过安全验证后重新输入新邮箱地址绑定。</li>
    </ul>
  </div>
  <div class="ncm-default-form">
    <form method="post" id="email_form" action="index.php?act=member_security&op=send_bind_email">
      <input type="hidden" name="form_submit" value="ok" />
      <dl>
        <dt><i class="required">*</i>绑定邮箱地址：</dt>
        <dd>
          <input type="text" class="text w180"  maxlength="40" value="<?php echo $output['member_info']['member_email'];?>" name="email" id="email" />
          <label for="email" generated="true" class="error"></label>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd><label class="submit-border">
          <input type="submit" class="submit" value="发送验证邮件" /></label>
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function(){
    $('#email_form').validate({
        submitHandler:function(form){
            ajaxpost('email_form', '', '', 'onerror') 
        },
        rules : {
           email : {
                required   : true,
                email      : true
            }
        },
        messages : {
            email : {
                required : '<i class="icon-exclamation-sign"></i>请正确填写邮箱',
                email    : '<i class="icon-exclamation-sign"></i>请正确填写邮箱'
            }
        }
    });
});
</script> 
