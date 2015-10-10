<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="login-layout">

  <div class="top">

   <h5><?php echo $lang['login_index_title_01'];?><em></em></h5>
    <h2><?php echo $lang['login_index_title_02'];?></h2>
    <h6><?php echo $lang['login_index_title_03'];?></h6>

  </div>

   <form method="post" id="form_login">
      <?php Security::getToken();?>
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="SiteUrl" id="SiteUrl" value="<?php echo SHOP_SITE_URL;?>" />

    <div class="lock-holder">

      <div class="form-group pull-left input-username">

        

         <label><?php echo $lang['login_index_username'];?></label>

          <input name="user_name" id="user_name" autocomplete="off" type="text" class="input-text" value="" required>

          

      </div>

      <i class="fa fa-ellipsis-h dot-left"></i> <i class="fa fa-ellipsis-h dot-right"></i>

      <div class="form-group pull-right input-password-box">

           <label><?php echo $lang['login_index_password'];?></label>

                <input name="password" id="password" class="input-password" autocomplete="off" type="password" required pattern="[\S]{6}[\S]*"

title="<?php echo $lang['login_index_password_pattern'];?>">

      </div>

    </div>

    <div class="avatar"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/login/admin.png" alt=""></div>

    <div class="submit"> <span>

<div class="code">

        <div class="arrow"></div>

        <div class="code-img"><img src="index.php?act=seccode&op=makecode&admin=1&nchash=<?php echo getNchash();?>" name="codeimage" id="codeimage" border="0"/></div>

        <a href="JavaScript:void(0);" id="hide" class="close" title="<?php echo $lang['login_index_close_checkcode'];?>"><i></i></a><a href="JavaScript:void(0);" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&admin=1&nchash=<?php echo getNchash();?>&t=' + Math.random();" class="change" title="看不清,点击更换验证码"><i></i></a> </div>

           
            
             <input name="captcha" type="text" required class="input-code" id="captcha" placeholder="<?php echo $lang['login_index_checkcode'];?>" pattern="[A-z0-9]{4}" title="<?php echo $lang['login_index_checkcode_pattern'];?>" autocomplete="off" value="" >

      </span> <span>

      <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
      <input name="" class="input-button" type="submit" value="<?php echo $lang['login_index_button_login'];?>">

      </span> </div>

      <div class="submit2"></div>

  </form>

  <div class="bottom">

</div>

</div>





<script>

$(function(){

        $.supersized({



        // 功能

        slide_interval     : 4000,    

        transition         : 1,    

        transition_speed   : 1000,    

        performance        : 1,    



        // 大小和位置

        min_width          : 0,    

        min_height         : 0,    

        vertical_center    : 1,    

        horizontal_center  : 1,    

        fit_always         : 0,    

        fit_portrait       : 1,    

        fit_landscape      : 0,    



        // 组件

        slide_links        : 'blank',    

        slides             : [    

                                 {image : '<?php echo ADMIN_TEMPLATES_URL;?>/images/login/1.jpg'},

                                 {image : '<?php echo ADMIN_TEMPLATES_URL;?>/images/login/2.jpg'},

                                 {image : '<?php echo ADMIN_TEMPLATES_URL;?>/images/login/3.jpg'},

				 {image : '<?php echo ADMIN_TEMPLATES_URL;?>/images/login/4.jpg'},

				 {image : '<?php echo ADMIN_TEMPLATES_URL;?>/images/login/5.jpg'}

                       ]



    });

	//显示隐藏验证码

    $("#hide").click(function(){

        $(".code").fadeOut("slow");

    });

    $("#captcha").focus(function(){

        $(".code").fadeIn("fast");

    });

    //跳出框架在主窗口登录

   if(top.location!=this.location)	top.location=this.location;

    $('#user_name').focus();

    if ($.browser.msie && ($.browser.version=="6.0" || $.browser.version=="7.0")){

        //window.location.href='<?php echo ADMIN_TEMPLATES_URL;?>/ie6update.html';

    }

    $("#captcha").nc_placeholder();

	//动画登录

    $('.btn-submit').click(function(e){

            $('.input-username,dot-left').addClass('animated fadeOutRight')

            $('.input-password-box,dot-right').addClass('animated fadeOutLeft')

            $('.btn-submit').addClass('animated fadeOutUp')

            setTimeout(function () {

                      $('.avatar').addClass('avatar-top');

                      $('.submit').hide();

                      $('.submit2').html('<div class="progress"><div class="progress-bar progress-bar-success" aria-valuetransitiongoal="100"></div></div>');

                      $('.progress .progress-bar').progressbar({

                          done : function() {$('#form_login').submit();}

                      }); 

              },

          300);



          });



    // 回车提交表单

    $('#form_login').keydown(function(event){

        if (event.keyCode == 13) {

            $('.btn-submit').click();

        }

    });

});



</script>