<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>商家管理中心登录</title>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<link href="<?php echo SHOP_TEMPLATES_URL?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/css/seller_center.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
<![endif]-->
<!--[if IE 6]>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/IE6_MAXMIX.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/IE6_PNG.js"></script>
<script>
DD_belatedPNG.fix('.pngFix');
</script>
<script>
// <![CDATA[
if((window.navigator.appName.toUpperCase().indexOf("MICROSOFT")>=0)&&(document.execCommand))
try{
document.execCommand("BackgroundImageCache", false, true);
   }
catch(e){}
// ]]>
</script>
<![endif]-->
<script language="JavaScript" type="text/javascript">
window.onload = function() {
    tips = new Array(2);
    tips[0] = document.getElementById("loginBG01");
    tips[1] = document.getElementById("loginBG02");
    index = Math.floor(Math.random() * tips.length);
    tips[index].style.display = "block";
};
$(document).ready(function() {
    //更换验证码
    function change_seccode() {
        $('#codeimage').attr('src', 'index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random());
        $('#captcha').select();
    }

    $('[nctype="btn_change_seccode"]').on('click', function() {
        change_seccode();
    });

    //登陆表单验证
    $("#form_login").validate({
        errorPlacement:function(error, element) {
            element.prev(".repuired").append(error);
        },
        onkeyup: false,
        rules:{
            seller_name:{
                required:true
            },
            password:{
                required:true
            },
            captcha:{
                required:true,
                remote:{
                    url:"index.php?act=seccode&op=check&nchash=<?php echo $output['nchash'];?>",
                    type:"get",
                    data:{
                        captcha:function() {
                            return $("#captcha").val();
                        }
                    },
                    complete: function(data) {
                        if(data.responseText == 'false') {
                            change_seccode();
                        }
                    }
                }
            }
        },
        messages:{
            seller_name:{
                required:"<i class='icon-exclamation-sign'></i>用户名不能为空"
            },
            password:{
                required:"<i class='icon-exclamation-sign'></i>密码不能为空"
            },
            captcha:{
                required:"<i class='icon-exclamation-sign'></i>验证码不能为空",
                remote:"<i class='icon-frown'></i>验证码错误"
            }
        }
    });
	//Hide Show verification code
    $("#hide").click(function(){
        $(".code").fadeOut("slow");
    });
    $("#captcha").focus(function(){
        $(".code").fadeIn("fast");
    });

});
</script>
</head>
<body>
<div id="loginBG01" class="ncsc-login-bg">
  <p class="pngFix"></p>
</div>
<div id="loginBG02" class="ncsc-login-bg">
  <p class="pngFix"></p>
</div>
<div class="ncsc-login-container">
  <div class="ncsc-login-title">
    <h2>商家管理中心</h2>
    <span>请输入您注册商铺时申请的商家名称<br/>
    登录密码为商城用户通用密码</span></div>
  <form id="form_login" action="index.php?act=seller_login&op=login" method="post" >
    <?php Security::getToken();?>
    <input name="nchash" type="hidden" value="<?php echo $output['nchash'];?>" />
    <input type="hidden" name="form_submit" value="ok" />
    <div class="input">
      <label>用户名</label>
      <span class="repuired"></span>
      <input name="seller_name" type="text" autocomplete="off" class="text" autofocus>
      <span class="ico"><i class="icon-user"></i></span> </div>
    <div class="input">
      <label>密码</label>
      <span class="repuired"></span>
      <input name="password" type="password" autocomplete="off" class="text">
      <span class="ico"><i class="icon-key"></i></span> </div>
    <div class="input">
      <label>验证码</label>
      <span class="repuired"></span>
      <input type="text" name="captcha" id="captcha" autocomplete="off" class="text" style="width: 80px;" maxlength="4" size="10" />
      <div class="code">
        <div class="arrow"></div>
        <div class="code-img"><a href="javascript:void(0)" nctype="btn_change_seccode"><img src="index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>" name="codeimage" border="0" id="codeimage"></a></div>
        <a href="JavaScript:void(0);" id="hide" class="close" title="<?php echo $lang['login_index_close_checkcode'];?>"><i></i></a> <a href="JavaScript:void(0);" class="change" nctype="btn_change_seccode" title="<?php echo $lang['login_index_change_checkcode'];?>"><i></i></a> </div>
      <span class="ico"><i class="icon-qrcode"></i></span>
      <input type="submit" class="login-submit" value="商家登录">
    </div>
  </form>
</div>
</body>
</html>
