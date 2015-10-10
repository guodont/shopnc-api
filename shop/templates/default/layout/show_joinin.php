<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
    function show_list(t_id){
        var obj = $(".sidebar dl[show_id='"+t_id+"']");
    	var show_class=obj.find("dt i").attr('class');
    	if(show_class=='hide') {
    		obj.find("dd").show();
    		obj.find("dt i").attr('class','show');
    	}else{
    		obj.find("dd").hide();
    		obj.find("dt i").attr('class','hide');
    	}
    }
</script>
<div class="banner">
  <div class="user-box">
		  <?php if($_SESSION['is_login'] == '1'){?>
			<div class="user-joinin">
				  <h3>亲爱的：<?php echo $_SESSION['member_name'];?></h3>
				  <dl>
					<dt><?php echo $lang['welcome_to_site'];?> <?php echo $GLOBALS['setting_config']['site_name']; ?></dt>
					<dd> 若您还没有填写入驻申请资料<br/>
					  请点击“<a href="<?php echo urlShop('store_joinin','step0');?>" target="_blank">我要入住</a>”进行入驻资料填写</dd>
					<dd>若您的店铺还未开通<br/>
					  请通过“<a href="<?php echo urlShop('store_joinin','index');?>" target="_blank">查看入驻进度</a>”了解店铺开通的最新状况 </dd>
				  </dl>
				  <div class="bottom"><a href="<?php echo urlShop('store_joinin','step0');?>" target="_blank">我要入住</a><a href="<?php echo urlShop('store_joinin','index');?>" target="_blank">查看入驻进度</a></div>
			</div>
		  <?php }else{?>
			<div class="user-login">
			  <h3>商务登录<em>（使用已注册的会员账号）</em></h3>
			  <form id="login_form" action="index.php?act=login" method="post">
				<?php Security::getToken();?>
				<input type="hidden" name="form_submit" value="ok" />
				<input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
				<dl>
				  <dt>用户名：</dt>
				  <dd>
					<input type="text" class="text" autocomplete="off"  name="user_name" id="user_name">
					<label></label>
				  </dd>
				</dl>
				<dl>
				  <dt>密&nbsp;&nbsp;&nbsp;码：</dt>
				  <dd>
					<input type="password" class="text" name="password" autocomplete="off"  id="password">
					<label></label>
				  </dd>
				</dl>
				<?php if(C('captcha_status_login') == '1') { ?>
				<dl>
				  <dt>验证码：</dt>
				  <dd>
					<input type="text" name="captcha" class="text w50 fl" id="captcha" maxlength="4" size="10" />
					<a href="JavaScript:void(0);" onclick="javascript:document.getElementById('codeimage').src='<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();" class="change" title="看不清，换一张">
					<img src="<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>" class="fl ml5" name="codeimage" id="codeimage" border="0"/></a>
					<label></label>
				  </dd>
				</dl>
				<?php } ?>
				<dl>
				  <dt></dt>
				  <dd>
					<input type="hidden" value="<?php echo SHOP_SITE_URL;?>/index.php?act=show_joinin" name="ref_url">
					<input name="提交" type="submit" class="button" value="登&nbsp;&nbsp;录">
					<a href="<?php echo urlShop('login','forget_password');?>" target="_blank">忘记密码？</a></dd>
				</dl>
			  </form>
			  <div class="register">还没有成为我们的合作伙伴？ <a href="<?php echo urlShop('login','register');?>" target="_blank">快速注册</a></div>
			</div>
		  <?php }?>
   </div>
  <ul id="fullScreenSlides" class="full-screen-slides">
                <li style="background-color: #F1A595; background-image: url(<?php echo UPLOAD_SITE_URL;?>/shop/common/store_joinin_1.jpg)" ></li>
                <li style="background-color: #F1A595; background-image: url(<?php echo UPLOAD_SITE_URL;?>/shop/common/store_joinin_2.jpg)" ></li>
                <li style="background-color: #F1A595; background-image: url(<?php echo UPLOAD_SITE_URL;?>/shop/common/store_joinin_3.jpg)" ></li>
              </ul>
</div>
<div class="indextip">
  <div class="container"> <span class="title"><i></i>
    <h3>贴心提示</h3>
    </span> <span class="content"><?php echo $GLOBALS['setting_config']['site_name']; ?>提供各类专业管家服务，协助您开通店铺、运营店铺、组织营销活动及分析运营数据，悉心为您解答各类疑问，引导您按相关规则展开运营；我们将竭尽全力，为您的店铺保驾护航。</span></div>
</div>
<div class="main mt30">
  <h2 class="index-title">入驻流程</h2>
  <div class="joinin-index-step">
	<span class="step"><i class="a"></i>签署入驻协议</span><span class="arrow"></span>
	<span class="step"><i class="b"></i>商家信息提交</span><span class="arrow"></span>
	<span class="step"><i class="c"></i>平台审核资质</span><span class="arrow"></span>
	<span class="step"><i class="d"></i>商家缴纳费用</span><span class="arrow"></span>
	<span class="step"><i class="e"></i>店铺开通</span>
   </div>

</div>


<script>
$(document).ready(function(){
	$("#login_form ").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
		rules: {
			user_name: "required",
			password: "required"
			<?php if(C('captcha_status_login') == '1') { ?>
			,captcha : {
                required : true,
                minlength: 4,
                remote   : {
                    url : '<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha').val();
                        }
                    }
                }
            }
			<?php } ?>
					},
		messages: {
			user_name: "用户名不能为空",
			password: "密码不能为空"
			<?php if(C('captcha_status_login') == '1') { ?>
			,captcha : {
                required : '验证码不能为空',
                minlength: '验证码不能为空',
				remote	 : '验证码错误'
            }
			<?php } ?>
					}
	});
});
</script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/home_index.js" charset="utf-8"></script>
