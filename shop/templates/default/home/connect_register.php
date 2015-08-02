<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_login.css" rel="stylesheet" type="text/css">
<style type="text/css">
.head-search-bar, .head-user-menu, .public-nav-layout  {
	display: none !important;
} /*屏蔽头部搜索及导航菜单*/
</style>
<div class="nc-login-layout">
  <div class="left-pic"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/login_qq.jpg" />
    <p><a href="#register_form"><?php echo $output['qquser_info']['nickname']; ?></a></p>
  </div>
  <div class="nc-login" id="rotate">
    <ul>
      <li class="w400"><a href="#register_form"><?php echo $lang['home_qqconnect_register_title']; ?><!-- 完善账号信息 --></a></li>
    </ul>
    <div class="nc-login-content">
      <form name="register_form" id="register_form" method="post" action="index.php?act=connect&op=register">
        <input type="hidden" value="ok" name="form_submit">
        <input type='hidden' name="loginnickname" value="<?php echo $output['qquser_info']['nickname'];?>"/>
        <dl>
          <dt><img src="<?php echo $output['qquser_info']['figureurl_qq_1'];?>" /></dt>
          <dd>
            <label><?php echo $lang['home_qqconnect_register_success']; ?></label>
          </dd>
        </dl>
        <dl class="mt20">
          <dt><?php echo $lang['login_register_username']; ?>: </dt>
          <dd>
            <label><?php echo $_SESSION['member_name'];?></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_register_pwd']; ?>: </dt>
          <dd>
            <input type="text" value="<?php echo $output['user_passwd'];?>" id="password" name="password" class="text tip" title="<?php echo $lang['login_register_password_to_login'];?>"/>
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_register_email']; ?>: </dt>
          <dd>
            <input type="text" id="email" name="email" class="text tip" title="<?php echo $lang['login_register_input_valid_email'];?>"/>
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt>&nbsp;</dt>
          <dd>
            <input type="submit" name="submit" value="<?php echo $lang['login_register_enter_now'];?>" class="submit fl"/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="index.php"><?php echo $lang['home_qqconnect_homepage']; ?></a></span>
            <label></label>
          </dd>
        </dl>
      </form>
      <div class="clear"></div>
    </div>
    <div class="nc-login-bottom"></div>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script> 
<script type="text/javascript">
//注册表单提示
$('.tip').poshytip({
	className: 'tip-yellowsimple',
	showOn: 'focus',
	alignTo: 'target',
	alignX: 'center',
	alignY: 'top',
	offsetX: 0,
	offsetY: 5,
	allowTipHover: false
});
    //注册表单验证
    $(function() {
        $('#register_form').validate({
            errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
            rules: {
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: 'index.php?act=login&op=check_email',
                        type: 'get',
                        data: {
                            email: function() {
                                return $('#email').val();
                            }
                        }
                    }
                }
        },
        messages : {
            password  : {
                required : '<?php echo $lang['login_register_input_password'];?>',
                minlength: '<?php echo $lang['login_register_password_range'];?>',
				maxlength: '<?php echo $lang['login_register_password_range'];?>'
            },
            email : {
                required : '<?php echo $lang['login_register_input_email'];?>',
                email    : '<?php echo $lang['login_register_invalid_email'];?>',
				remote	 : '<?php echo $lang['login_register_email_exists'];?>'
            }
        }
    });
});
</script>
<?php echo $output['nc_synlogin_script'];?>