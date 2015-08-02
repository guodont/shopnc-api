<style>
/* 通用弹出式窗口样式 */
.eject_con { background-color: #FFF; overflow: hidden;}
.eject_con h3 { font: 14px/36px "microsoft yahei"; text-align: center; height: 36px; margin-top: 10px;}
.eject_con dl { font-size: 0; *word-spacing:-1px/*IE6、7*/; line-height: 20px; clear: both; padding: 0; margin: 0; overflow: hidden;}
.eject_con dl dt,
.eject_con dl dd { font-size: 12px; line-height: 32px; vertical-align: top; letter-spacing: normal; word-spacing: normal; text-align: right; display: inline-block; width: 34%; padding: 10px 1% 0 0; margin: 0; *display: inline/*IE6,7*/; *zoom: 1;}
.eject_con dl dt i.required { font: 12px/16px Tahoma; color: #F30; vertical-align: middle; margin-right: 4px;}
.eject_con dl dd { text-align: left; width: 65%; padding: 10px 0 0 0; }
.eject_con-list { margin-top: 4px;}
.eject_con-list li { line-height: 24px;}
.eject_con-list li .radio { vertical-align: middle; margin-right: 4px;}
.eject_con .bottom { background-color:#F9F9F9; text-align: center; border-top: 1px solid #EAEAEA; margin-top:12px; }
.bottom .submit-border { margin: 10px auto;}
.bottom .submit { font: 14px/36px "microsoft yahei"; text-align: center; min-width: 100px; *min-width: auto; height: 36px;}
.alert { display: none; color: #C09853; background-color: #FCF8E3; padding: 8px 35px 8px 14px; margin-bottom: 20px; border: 1px solid #FBEED5; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);}
.alert-error { color: #B94A48; background-color: #F2DEDE; border-color: #EED3D7;}
</style>
<div class="eject_con">
  <div id="warning" class="alert alert-error"></div>
  <form method="post" target="_parent" action="<?php echo urlShop('goods', 'arrival_notice_submit')?>" id="arrival_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="goods_id" value="<?php echo $_GET['goods_id']; ?>" />
    <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>" />
    <dl>
      <dt><i class="required">*</i>手机号码<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" name="mobile" id="mobile" value="<?php echo $output['member_info']['member_mobile']; ?>" />
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>邮箱号码<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" name="email" id="email" value="<?php echo $output['member_info']['member_email'];?>" />
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="提交"/></label>
    </div>
  </form>
</div>
<script>
$(function(){
    $('#arrival_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('arrival_form', '', '', 'onerror');
    	},
        rules : {
            mobile : {
                required    : true,
                rangelength : [11, 11],
                digits      : true
            },
            email : {
                required    : true,
                email       : true
            }
        },
        messages : {
            mobile : {
                required    : '<i class="icon-exclamation-sign"></i>请填写手机号码',
                rangelength : '<i class="icon-exclamation-sign"></i>请填写正确的手机号码',
                digits      : '<i class="icon-exclamation-sign"></i>请填写正确的手机号码'
            },
            email : {
                required    : '<i class="icon-exclamation-sign"></i>请填写邮箱号码',
                email       : '<i class="icon-exclamation-sign"></i>请填写正确的邮箱号码'
            }
        }
    });
});

</script> 