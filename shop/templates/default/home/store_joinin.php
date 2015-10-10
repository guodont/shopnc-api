<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="banner">
  <div class="user-box">
    <?php if($_SESSION['is_login'] == '1'){?>
    <div class="user-joinin">
      <h3>亲爱的：<?php echo $_SESSION['member_name'];?></h3>
      <dl>
        <dt><?php echo $lang['welcome_to_site'].$output['setting_config']['site_name']; ?></dt>
        <dd> 若您还没有填写入驻申请资料<br/>
          请点击“<a href="<?php echo urlShop('store_joinin', 'step0');?>" target="_blank">我要入住</a>”进行入驻资料填写</dd>
        <dd>若您的店铺还未开通<br/>
          请通过“<a href="<?php echo urlShop('store_joinin', 'index');?>" target="_blank">查看入驻进度</a>”了解店铺开通的最新状况 </dd>
      </dl>
      <div class="bottom"><a href="<?php echo urlShop('store_joinin', 'step0');?>" target="_blank">我要入住</a><a href="<?php echo urlShop('store_joinin', 'index');?>" target="_blank">查看入驻进度</a></div>
    </div>
     <?php }else { ?>
    <div class="user-login">
      <h3>商务登录<em>（使用已注册的会员账号）</em></h3>
      <form id="login_form" action="index.php?act=login" method="post">
        <?php Security::getToken();?>
        <input type="hidden" name="form_submit" value="ok" />
        <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
        <dl>
          <dt><?php echo $lang['login_index_username'];?>：</dt>
          <dd>
            <input type="text" class="text" autocomplete="off"  name="user_name" id="user_name">
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_index_password'];?>：</dt>
          <dd>
            <input type="password" class="text" name="password" autocomplete="off"  id="password">
            <label></label>
          </dd>
        </dl>
        <?php if(C('captcha_status_login') == '1') { ?>
        <dl>
          <dt><?php echo $lang['login_index_checkcode'];?>：</dt>
          <dd>
            <input type="text" name="captcha" class="text w50 fl" id="captcha" maxlength="4" size="10" />
            <a href="JavaScript:void(0);" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();" class="change" title="<?php echo $lang['login_index_change_checkcode'];?>">
            <img src="index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>" class="fl ml5" name="codeimage" id="codeimage" border="0"/></a>
            <label></label>
          </dd>
        </dl>
        <?php } ?>
        <dl>
          <dt></dt>
          <dd>
            <input type="hidden" value="<?php echo SHOP_SITE_URL?>/index.php?act=show_joinin" name="ref_url">
            <input name="提交" type="submit" class="button" value="登&nbsp;&nbsp;录">
            <a href="index.php?act=login&op=forget_password" target="_blank"><?php echo $lang['login_index_forget_password'];?></a></dd>
        </dl>
      </form>
      <div class="register">还没有成为我们的合作伙伴？ <a href="index.php?act=login&op=register" target="_blank">快速注册</a></div>
    </div>
    <?php } ?>
  </div>
  <ul id="fullScreenSlides" class="full-screen-slides">
    <?php $pic_n = 0;?>
    <?php if(!empty($output['pic_list']) && is_array($output['pic_list'])){ ?>
    <?php foreach($output['pic_list'] as $key => $val){ ?>
    <?php if(!empty($val)){ $pic_n++; ?>
    <li style="background-color: #F1A595; background-image: url(<?php echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON.'/'.$val;?>)" ></li>
    <?php } ?>
    <?php } ?>
    <?php } ?>
  </ul>
</div>
<div class="indextip">
  <div class="container"> <span class="title"><i></i>
    <h3>贴心提示</h3>
    </span> <span class="content"><?php echo $output['show_txt'];?></span></div>
</div>
<div class="main mt30">
  <h2 class="index-title">入驻流程</h2>
  <div class="joinin-index-step"><span class="step"><i class="a"></i>签署入驻协议</span><span class="arrow"></span><span class="step"><i class="b"></i>商家信息提交</span><span class="arrow"></span><span class="step"><i class="c"></i>平台审核资质</span><span class="arrow"></span><span class="step"><i class="d"></i>商家缴纳费用</span><span class="arrow"></span><span class="step"><i class="e"></i>店铺开通</span></div>
  <h2 class="index-title">入驻指南</h2>
  <div class="joinin-info">
    <ul class="tabs-nav">
      <?php if(!empty($output['help_list']) && is_array($output['help_list'])){ $i = 0;?>
      <?php foreach($output['help_list'] as $key => $val){ $i++;?>
      <li class="<?php echo $i==1 ? 'tabs-selected':'';?>">
        <h3><?php echo $val['help_title'];?></h3>
      </li>
      <?php } ?>
      <?php } ?>
    </ul>
      <?php if(!empty($output['help_list']) && is_array($output['help_list'])){ $i = 0;?>
      <?php foreach($output['help_list'] as $key => $val){ $i++;?>
    <div class="tabs-panel <?php echo $i==1 ? '':'tabs-hide';?>"><?php echo $val['help_info'];?></div>
      <?php } ?>
      <?php } ?>
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
			user_name: "<?php echo $lang['login_index_input_username'];?>",
			password: "<?php echo $lang['login_index_input_password'];?>"
			<?php if(C('captcha_status_login') == '1') { ?>
            ,captcha : {
                required : '<?php echo $lang['login_index_input_checkcode'];?>',
                minlength: '<?php echo $lang['login_index_input_checkcode'];?>',
				remote	 : '<?php echo $lang['login_index_wrong_checkcode'];?>'
            }
			<?php } ?>
		}
	});
});
</script>
<?php if( $pic_n > 1) { ?>
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/home_index.js" charset="utf-8"></script>
<?php }else { ?>
<script>
$(document).ready(function(){
    $(".tabs-nav > li > h3").bind('mouseover', (function(e) {
    	if (e.target == this) {
    		var tabs = $(this).parent().parent().children("li");
    		var panels = $(this).parent().parent().parent().children(".tabs-panel");
    		var index = $.inArray(this, $(this).parent().parent().find("h3"));
    		if (panels.eq(index)[0]) {
    			tabs.removeClass("tabs-selected").eq(index).addClass("tabs-selected");
    			panels.addClass("tabs-hide").eq(index).removeClass("tabs-hide");
    		}
    	}
    }));
});
</script>
<?php } ?>
