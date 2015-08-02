<div class="eject_con">
  <div id="warning" class="alert alert-error"></div>
  <form method="post" action="<?php echo urlShop('store_goods_online', 'edit_jingle');?>" id="jingle_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="commonid" value="<?php echo $_GET['commonid']; ?>" />
    <dl>
      <dt>商品广告词：</dt>
      <dd>
        <input type="text" class="text w300" name="g_jingle" id="g_jingle" value="" />
        <p class="hint">如不填，所有广告词将制空，请谨慎操作</p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>"/></label>
    </div>
  </form>
</div>
<script>
$(function(){
    $('#jingle_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
        submitHandler:function(form){
            ajaxpost('jingle_form', '', '', 'onerror');
        },
        rules : {
            g_jingle : {
                maxlength: 50
            }
        },
        messages : {
            g_jingle : {
                maxlength: '<i class="icon-exclamation-sign"></i>不能超过50个字符'
            }
        }
    });
});
</script> 
