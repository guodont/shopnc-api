<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
   <div class="alert alert-success">
    <h4>操作提示：</h4>
    <ul>
      <li>1. “支付密码”用于结算订单时使用<em>“账户余额”</em>时的密码输入，请牢记并确保安全。</li>
      <li>2. 如修改或找回“支付密码”，请完成安全验证操作后重新提交。</li>
    </ul>
  </div>
  <div class="ncm-default-form">
    <form method="post" id="password_form" name="password_form" action="index.php?act=member_security&op=modify_paypwd">
      <input type="hidden" name="form_submit" value="ok"  />
      <dl>
        <dt><i class="required">*</i>设置支付密码：</dt>
        <dd>
          <input type="password"  maxlength="40" class="password" name="password" id="password"/>
          <label for="password" generated="true" class="error"></label>
          <p class="hint">6-20位字符，可由英文、数字及标点符号组成。</p></dd>
      </dl>
      <dl>
        <dt><i class="required">*</i>确认支付密码：</dt>
        <dd>
          <input type="password" maxlength="40" class="password" name="confirm_password" id="confirm_password" />
          <label for="confirm_password" generated="true" class="error"></label>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['home_member_submit'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function(){
    $('#password_form').validate({
         submitHandler:function(form){
            ajaxpost('password_form', '', '', 'onerror') 
        },
        rules : {
            password : {
                required   : true,
                minlength  : 6,
                maxlength  : 20
            },
            confirm_password : {
                required   : true,
                equalTo    : '#password'
            }
        },
        messages : {
            password  : {
                required  : '<i class="icon-exclamation-sign"></i>请正确输入密码',
                minlength : '<i class="icon-exclamation-sign"></i>请正确输入密码',
                maxlength : '<i class="icon-exclamation-sign"></i>请正确输入密码'
            },
            confirm_password : {
                required   : '<i class="icon-exclamation-sign"></i>请正确输入密码',
                equalTo    : '<i class="icon-exclamation-sign"></i>两次密码输入不一致'
            }
        }
    });
});
</script> 
