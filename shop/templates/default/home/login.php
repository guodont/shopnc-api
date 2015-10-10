<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.public-top-layout, .head-app, .head-search-bar, .head-user-menu, .public-nav-layout, .nch-breadcrumb-layout, #faq {
	display: none !important;
}
.public-head-layout {
	margin: 10px auto -10px auto;
}
.wrapper {
	width: 1000px;
}
#footer {
	border-top: none!important;
	padding-top: 30px;
}
</style>
<div class="nc-login-layout">
  <div class="left-pic"><img src="<?php echo $output['lpic'];?>"  border="0"></div>
  <div class="nc-login">
    <div class="nc-login-title">
      <h3><?php echo $lang['login_index_user_login'];?></h3>
    </div>
    <div class="nc-login-content" id="demo-form-site">
      <form id="login_form" method="post" action="index.php?act=login&op=login"  class="bg">
        <?php Security::getToken();?>
        <input type="hidden" name="form_submit" value="ok" />
        <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
        <dl>
          <dt><?php echo $lang['login_index_username'];?></dt>
          <dd style="min-height:54px;">
            <input type="text" class="text" autocomplete="off"  name="user_name" id="user_name" autofocus >
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_index_password'];?> </dt>
          <dd style="min-height:54px;">
            <input type="password" class="text" name="password" autocomplete="off"  id="password">
            <label></label>
          </dd>
        </dl>
        <?php if(C('captcha_status_login') == '1') { ?>
        <dl>
          <dt><?php echo $lang['login_index_checkcode'];?></dt>
          <dd style="min-height:54px;">
            <input type="text" name="captcha" autocomplete="off" class="text w50 fl" id="captcha" maxlength="4" size="10" />
            <img src="<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>" name="codeimage" border="0" id="codeimage" class="fl ml5"> <a href="javascript:void(0)" class="ml5" onclick="javascript:document.getElementById('codeimage').src='<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();"><?php echo $lang['login_index_change_checkcode'];?></a>
            <label></label>
          </dd>
        </dl>
        <?php } ?>
        <dl>
          <dt>&nbsp;</dt>
          <dd>
            <input type="submit" class="submit" value="<?php echo $lang['login_index_login'];?>">
            <a class="forget" href="index.php?act=login&op=forget_password"><?php echo $lang['login_index_forget_password'];?></a>
            <input type="hidden" value="<?php echo $_GET['ref_url']?>" name="ref_url">
          </dd>
        </dl>
      </form>
      <dl class="mt10 mb10">
        <dt>&nbsp;</dt>
        <dd><?php echo $lang['login_index_regist_now_1'];?><a title="" href="index.php?act=login&op=register&ref_url=<?php echo urlencode($output['ref_url']);?>" class="register"><?php echo $lang['login_index_regist_now_2'];?></a></dd>
      </dl>
      <?php if ($output['setting_config']['qq_isuse'] == 1 || $output['setting_config']['sina_isuse'] == 1){?>
      <dl>
        <dd class="nc-login-other">
          <p><?php echo $lang['nc_otherlogintip'];?></p>
          <?php if ($output['setting_config']['qq_isuse'] == 1){?>
          <a href="<?php echo SHOP_SITE_URL;?>/api.php?act=toqq" title="QQ" class="qq">&nbsp;</a>
          <?php } ?>
          <?php if ($output['setting_config']['sina_isuse'] == 1){?>
          <a href="<?php echo SHOP_SITE_URL;?>/api.php?act=tosina" title="<?php echo $lang['nc_otherlogintip_sina']; ?>" class="sina">&nbsp;</a>
          <?php } ?>
        </dd>
      </dl>
      <?php } ?>
    </div>
    <div class="nc-login-bottom"></div>
  </div>
</div>
<script>
$(document).ready(function(){
	$("#login_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
        onkeyup: false,
		rules: {
			user_name: "required",
			password: "required"
			<?php if(C('captcha_status_login') == '1') { ?>
            ,captcha : {
                required : true,
                remote   : {
                    url : '<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha').val();
                        }
                    },
                    complete: function(data) {
                        if(data.responseText == 'false') {
                        	document.getElementById('codeimage').src='<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();
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
            ,captcha : {
                required : '<?php echo $lang['login_index_input_checkcode'];?>',
				remote	 : '<?php echo $lang['login_index_wrong_checkcode'];?>'
            }
			<?php } ?>
		}
	});
});
</script>
