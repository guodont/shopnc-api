<?php defined('InShopNC') or exit('Access Invalid!');?>

<form method="post" id="change_password_form" action="<?php echo DELIVERY_SITE_URL?>/index.php?act=d_center&op=change_password">
  <input type="hidden" name="form_submit" value="ok" />
  <dl class="ncd-change-password" id="changePassword">
    <dd>
      <label class="phrases">请输入原密码</label>
      <input class="input-txt" type="password" name="old_password" id="old_password" autocomplete="off" title="正确输入您原有的登录密码。">
      <span></span></dd>
    <dd>
      <label class="phrases">请输入新密码</label>
      <input class="input-txt" type="password" name="password" id="password" autocomplete="off" title="6-20位字符，可由英文、数字及标点符号组成。">
      <span></span></dd>
    <dd>
      <label class="phrases">再次输入新密码，请保持一致</label>
      <input class="input-txt" type="password" name="passwd_confirm" id="passwd_confirm" autocomplete="off"title="请再次输入您新的密码，保持两次一致。">
      <span></span></dd>
    <dd>
      <input type="submit" class="submit" value="提交密码修改">
    </dd>
  </dl>
</form>
<script>
$(function(){
    //input焦点时隐藏/显示填写内容提示信息
    $("#changePassword .input-txt").placeholder();    
    $('#change_password_form').validate({
        errorPlacement: function(error, element){
            element.next().append(error);
        },
        submitHandler:function(form){
            ajaxpost('change_password_form', '', '', 'onerror');
        },
        rules : {
            old_password : {
                required : true
            },
            password : {
                required : true,
                rangelength : [6,20]
            },
            passwd_confirm : {
                equalTo : '#password'
            }
        },
        messages : {
            old_password : {
                required : '请输入原密码'
            },
            password  : {
                required : '请输入新密码',
                rangelength : '密码长度在6-20个字符之间'
            },
            passwd_confirm : {
                equalTo : '请输入相同的密码'
            }
        }
    });
});
</script>