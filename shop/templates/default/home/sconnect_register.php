<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_login.css" rel="stylesheet" type="text/css">
<style type="text/css">
.head-search-bar, .head-user-menu, .public-nav-layout  {
	display: none !important;
} /*屏蔽头部搜索及导航菜单*/
</style>
<div class="nc-login-layout">
  <div class="left-pic"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/login_weibo.jpg" /><span><?php echo $output['sinauser_info']['name'];?> </span> </div>
  <div class="nc-login" id="rotate">
    <ul>
      <li><a href="#register_form"><span><?php echo $lang['home_sconnect_register_title']; ?><!-- 完善账号信息 --></span></a></li>
      <li><a href="#log_form"><span><?php echo $lang['home_sconnect_login_title']; ?><!-- 已有账号？绑定我的账号 --></span></a></li>
    </ul>
    <div class="nc-login-content">
      <form name="register_form" id="register_form" method="post" action="index.php?act=sconnect&op=register">
        <input type="hidden" value="ok" name="form_submit">
        <input type='hidden' name="regsname" value="<?php echo $output['sinauser_info']['name'];?>"/>
        <dl class="mt20">
          <dt><?php echo $lang['login_register_username']; ?>: </dt>
          <dd>
            <input type="text" id="user_name" name="user_name" class="text tip" title="<?php echo $lang['login_register_username_to_login'];?>"/>
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_register_pwd']; ?>: </dt>
          <dd>
            <input type="password" id="password" name="password" class="text tip" title="<?php echo $lang['login_register_password_to_login'];?>"/>
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_register_ensure_password']; ?>: </dt>
          <dd>
            <input type="password" id="password_confirm" name="password_confirm" class="text tip" title="<?php echo $lang['login_register_input_password_again'];?>"/>
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_register_email']; ?>: </dt>
          <dd>
            <input type="text" id="email" name="email" class="text tip" title="<?php echo $lang['login_register_input_valid_email'];?>" />
            <label></label>
          </dd>
        </dl>
        <?php if(C('captcha_status_register') == '1') { ?>
        <dl>
          <dt><?php echo $lang['login_register_code'];?>: </dt>
          <dd>
            <input type="text" id="captcha" name="captcha" class="text w50 fl tip" maxlength="4" size="10" title="<?php echo $lang['login_register_input_code'];?>" />
            <img src="index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>" title="<?php echo $lang['login_index_change_checkcode'];?>" name="codeimage" border="0" id="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"  class="fl ml5"><a href="javascript:void(0)" class="fl ml5" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random();"><?php echo $lang['login_index_change_checkcode'];?></a>
            <input name="nchash" type="hidden" value="<?php echo $output['nchash'];?>" />
            <label></label>
          </dd>
        </dl>
        <?php } ?>
        <dl>
          <dt>&nbsp;</dt>
          <dd>
            <input type="submit" name="submit" value='<?php echo $lang['login_register_enter_now'];?>' class="submit fl"/>
            <input type="checkbox" class="fl ml10 mt10 mr5" name="agree" value='1' id="agree" checked="checked" />
            <span for="agreebbrule" class="fl"><?php echo $lang['home_sconnect_login_agree'];?><!-- 同意 --> 
            <a target="_blank" href="index.php?act=document&amp;code=agreement"><?php echo $lang['home_sconnect_login_useragreement']; ?><!-- 用户服务协议 --></a></span>
            <label></label>
          </dd>
        </dl>
      </form>
      <form name="log_form" id="log_form" method="post" action="index.php?act=sconnect&op=login">
        <input type="hidden" value="ok" name="form_submit">
        <input type='hidden' name="loginsname" value="<?php echo $output['sinauser_info']['name'];?>"/>
        <dl class="mt20">
          <dt><?php echo $lang['login_index_username'];?>: </dt>
          <dd style="min-height:54px;">
            <input type="text" id="user_name" name="user_name" class="text" />
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_index_password'];?>: </dt>
          <dd style="min-height:54px;">
            <input type="password" id="password" name="password" class="text" />
            <label></label>
          </dd>
        </dl>
        <?php if(C('captcha_status_login') == '1') { ?>
        <dl>
          <dt><?php echo $lang['login_index_checkcode'];?>: </dt>
          <dd style="min-height:54px;">
            <input type="text" id="captcha_login" name="captcha_login" class="text w50 fl" maxlength="4" size="10" />
            <img src="index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>" title="<?php echo $lang['login_index_change_checkcode'];?>" border="0" id="codeimage2" name="codeimage2" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()" class="fl ml5"><a href="javascript:void(0)" class="fl ml5" onclick="javascript:document.getElementById('codeimage2').src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random();"><?php echo $lang['login_index_change_checkcode'];?></a>
            <input name="nchash" type="hidden" value="<?php echo $output['nchash'];?>" />
            <label></label>
          </dd>
        </dl>
        <?php } ?>
        <dl style="min-height:54px;">
          <dt>&nbsp;</dt>
          <dd>
            <input type="submit" name="Submit" value="<?php echo $lang['login_register_connect_now'];?>" class="submit fl" />
          </dd>
        </dl>
      </form>
      <div class="clear"></div>
    </div>
    <div class="nc-login-bottom"></div>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ui.core.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ui.tabs.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script>  
<script type="text/javascript">
//切换登录卡

    $(function() {
        $('#rotate > ul').tabs({ fx: { opacity: 'toggle' } })
    });

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
$(function(){
		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[^:%,'\*\"\s\<\>\&]+$/i.test(value);
		}, "Letters only please"); 
		jQuery.validator.addMethod("lettersmin", function(value, element) {
			return this.optional(element) || ($.trim(value.replace(/[^\u0000-\u00ff]/g,"aa")).length>=3);
		}, "Letters min please"); 
		jQuery.validator.addMethod("lettersmax", function(value, element) {
			return this.optional(element) || ($.trim(value.replace(/[^\u0000-\u00ff]/g,"aa")).length<=15);
		}, "Letters max please"); 
    $('#register_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
        rules : {
            user_name : {
                required : true,
                lettersmin : true,
                lettersmax : true,
                lettersonly : true,
                remote   : {
                    url :'index.php?act=login&op=check_member&column=ok',
                    type:'get',
                    data:{
                        user_name : function(){
                            return $('#user_name').val();
                        }
                    }
                }
            },
            password : {
                required : true,
                minlength: 6,
				maxlength: 20
            },
            password_confirm : {
                required : true,
                equalTo  : '#password'
            }, 
            email : {
                required : true,
                email    : true,
                remote   : {
                    url : 'index.php?act=login&op=check_email',
                    type: 'get',
                    data:{
                        email : function(){
                            return $('#email').val();
                        }
                    }
                }
            },
			<?php if(C('captcha_status_register') == '1') { ?>
            captcha : {
                required : true,
                remote   : {
                	url : 'index.php?act=seccode&op=check&nchash=<?php echo $output['nchash'];?>',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha').val();
                        }
                    }
                }
            },
			<?php } ?>
            agree : {
                required : true
            }
        },
        messages : {
            user_name : {
                required : '<?php echo $lang['login_register_input_username'];?>',
                lettersmin : '<?php echo $lang['login_register_username_range'];?>',
                lettersmax : '<?php echo $lang['login_register_username_range'];?>',
				lettersonly: '<?php echo $lang['login_register_username_lettersonly'];?>',
				remote	 : '<?php echo $lang['login_register_username_exists'];?>'
            },
            password  : {
                required : '<?php echo $lang['login_register_input_password'];?>',
                minlength: '<?php echo $lang['login_register_password_range'];?>',
				maxlength: '<?php echo $lang['login_register_password_range'];?>'
            },
            password_confirm : {
                required : '<?php echo $lang['login_register_input_password_again'];?>',
                equalTo  : '<?php echo $lang['login_register_password_not_same'];?>'
            },
            email : {
                required : '<?php echo $lang['login_register_input_email'];?>',
                email    : '<?php echo $lang['login_register_invalid_email'];?>',
				remote	 : '<?php echo $lang['login_register_email_exists'];?>'
            },
			<?php if(C('captcha_status_register') == '1') { ?>
            captcha : {
                required : '<?php echo $lang['login_register_input_text_in_image'];?>',
				remote	 : '<?php echo $lang['login_register_code_wrong'];?>'
            },
			<?php } ?>
            agree : {
                required : '<?php echo $lang['login_register_must_agree'];?>'
            }
        }
    });

    $("#log_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
		rules: {
			user_name: "required",
			password: "required"
			<?php if(C('captcha_status_login') == '1') { ?>
            ,captcha_login : {
                required : true,
                remote   : {
                	url : 'index.php?act=seccode&op=check&nchash=<?php echo $output['nchash'];?>',
                    type: 'get',
                    data:{
            			captcha : function(){
                            return $('#captcha_login').val();
                        }
                    }
                }
            }
			<?php } ?>
		},
		messages: {
			user_name: "<?php echo $lang['login_index_input_username'];?>",
			password: "<?php echo $lang['login_index_input_password'];?>"
			<?php if(C('captcha_status_login') == '1') { ?>
            ,captcha_login : {
                required : '<?php echo $lang['login_index_input_checkcode'];?>',
				remote	 : '<?php echo $lang['login_index_wrong_checkcode'];?>'
            }
			<?php } ?>
		}
	});	
    
});
</script>