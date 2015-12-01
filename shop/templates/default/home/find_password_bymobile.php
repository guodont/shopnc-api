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
.phonecode{
  width:108px; padding:2px;
}
#footer {
	border-top: none!important;
	padding-top: 30px;
}
</style>
<div class="nc-login-layout">
  <div class="left-pic"> <img src="<?php echo $output['lpic'];?>"  border="0"> </div>
  <div class="nc-login">
    <div class="nc-login-title">
      <h3><?php echo $lang['login_index_find_password'];?></h3>
    </div>
    <div class="nc-login-content" id="demo-form-site">
      <form action="index.php?act=login&op=find_password_mobile" method="POST" id="find_password_form" onsubmit="return register()">
        <?php Security::getToken();?>
        <input type="hidden" name="form_submit" value="ok" />
        <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
        <dl>
          <dt><?php echo $lang['login_password_you_account'];?></dt>
          <dd style="min-height:54px;">
            <input type="text" class="text" name="username" id="username"/>
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt>新登录密码</dt>
          <dd style="min-height:54px;">
            <input type="password" id="password" name="password" class="text tip" title="<?php echo $lang['login_register_password_to_login'];?>" />
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt>手机号码</dt>
          <dd style="min-height:54px;">
            <input type="text" class="text" name="mobile" id="mobile"/>
            <label></label>
          </dd>
        </dl>
        
         <dl>
          <dt>短信验证码</dt>
          <dd style="min-height:54px;">
           <input type="text" autocomplete="off" name="mobile_code" placeholder="" title="短信校验码" id="mobile_code" class="valid text fl tip"  style="width:100px">&nbsp;&nbsp;
                            <input type="button" value="获取短信校验码" onclick="get_mobile_code();" class="phonecode" id="btnGetCode">
                    <label></label>
          </dd>
        </dl>
        
        
        <dl>
          <dt><?php echo $lang['login_register_code'];?></dt>
          <dd style="min-height:54px;">
            <input type="text" name="captcha" class="text w50 fl" id="captcha" maxlength="4" size="10" />
            <img src="index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>" title="<?php echo $lang['login_index_change_checkcode'];?>" name="codeimage" border="0" id="codeimage" class="fl ml5"> <a href="javascript:void(0);" class="ml5" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();"><?php echo $lang['login_password_change_code']; ?></a>
            <label></label>
          </dd>
        </dl>
        <dl class="mb30">
          <dt></dt>
          <dd>
            <input type="button" class="submit" value="重置密码" name="Submit" id="Submit">
            
             <input type="button" class="submit" value="返回登录"  onclick="location='index.php?act=login';">
          </dd>
        </dl>
        <input type="hidden" value="<?php echo $output['ref_url']?>" name="ref_url">
      </form>
    </div>
    <div class="nc-login-bottom"></div>
  </div>
</div>
<script type="text/javascript">
$(function(){
    $('#Submit').click(function(){
        if($("#find_password_form").valid()){
        	ajaxpost('find_password_form', '', '', 'onerror');
        } else{
        	document.getElementById('codeimage').src='<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();
        }
    });
	
	jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[^:%,'\*\"\s\<\>\&]+$/i.test(value);
		}, "Letters only please"); 
		jQuery.validator.addMethod("lettersmin", function(value, element) {
			return this.optional(element) || ($.trim(value.replace(/[^\u0000-\u00ff]/g,"aa")).length>=3);
		}, "Letters min please"); 
		jQuery.validator.addMethod("lettersmax", function(value, element) {
			return this.optional(element) || ($.trim(value.replace(/[^\u0000-\u00ff]/g,"aa")).length<=15);
		}, "Letters max please");
		
    $('#find_password_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
        rules : {
            username : {
                required : true
            },
			 password : {
                required : true,
                minlength: 6,
				maxlength: 20
            },
            mobile : {
                required : true,
				minlength: 11,
				maxlength: 11
            },
			 mobile_code : {
                required : true
            },
            captcha : {
                required : true,
                minlength: 4,
                remote   : {
                    url : 'index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha').val();
                        }
                    }
                }
            } 
        },
        messages : {
            username : {
                required : '<?php echo $lang['login_usersave_login_usersave_username_isnull'];?>'
            },
			 password  : {
                required : '<?php echo $lang['login_register_input_password'];?>',
                minlength: '<?php echo $lang['login_register_password_range'];?>',
				maxlength: '<?php echo $lang['login_register_password_range'];?>'
            },
            mobile  : {
                required : '手机号码不能为空',
				minlength: '手机号码长度应是11个字符',
				maxlength: '手机号码长度应是11个字符'
            },
			 mobile_code  : {
                required : '手机验证码不能为空'
            },
            captcha : {
                required : '<?php echo $lang['login_usersave_code_isnull']	;?>',
                minlength : '<?php echo $lang['login_usersave_wrong_code'];?>',
                remote   : '<?php echo $lang['login_usersave_wrong_code'];?>'
            }
        }
    });
});
</script> 



<script language="javascript">
	function get_mobile_code(){
		    var ok=check_data(false);
			if(ok==false)
			{
				return false;
			}
			$.getJSON('index.php?act=login&op=sendmbcodepwd',{mobile:jQuery.trim($('#mobile').val()),username:jQuery.trim($('#username').val())},function(data){
			if (data.state == 'true') {
				RemainTime();
			}
			else
			{
				alert(data.msg);
			}
        });
	};
	var iTime = 59;
	var Account;
	function RemainTime(){
		document.getElementById('btnGetCode').disabled = true;
		var iSecond,sSecond="",sTime="";
		if (iTime >= 0){
			iSecond = parseInt(iTime%60);
			iMinute = parseInt(iTime/60)
			if (iSecond >= 0){
				if(iMinute>0){
					sSecond = iMinute + "分" + iSecond + "秒";
				}else{
					sSecond = iSecond + "秒";
				}
			}
			sTime=sSecond;
			if(iTime==0){
				clearTimeout(Account);
				sTime='获取手机验证码';
				iTime = 59;
				document.getElementById('btnGetCode').disabled = false;
			}else{
				Account = setTimeout("RemainTime()",1000);
				iTime=iTime-1;
			}
		}else{
			sTime='没有倒计时';
		}
		document.getElementById('btnGetCode').value = sTime;
	}	
	
//提交验证
function register()
{	
    var ok=check_data(true);
	if(ok==false)
	{
		return false;
	}
	ok=check_mobile_code();
	return ok;
}
function check_data(is_submit)
{
	
	var mobile=$("#mobile");
	var mobile_code=$("#mobile_code");
	if (mobile.val() == "")
	{
	    alert("请输入手机号!");
	    mobile.focus();
	    return false;
	}else if(mobile.val().length!=11){
		alert("请输入正确的手机号!");
	    mobile.focus();
	    return false;
	}
	if(is_submit)
	{
	  if (mobile_code.val()== "")
	  {
		alert("请输入收到的验证码!");
		mobile_code.focus();
		return (false);
	  }
	}
	return true;
}
function check_mobile_code()
{
  var mobile=$("#mobile").val();
  var mobile_code=$("#mobile_code").val();
  var myurl = "index.php?act=login&op=check_mobile_code&mobile=" + mobile+"&mobile_code="+mobile_code;
  var htmlobj = $.ajax({ url: myurl, async: false, dataType: "text" });
  var re = htmlobj.responseText;
  if (re == "false") {
	  alert("您输入的手机验证码不正确");
	  return false;
  }
  return true;
}
</script>
