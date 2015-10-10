<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
    var use_settlement_account = true;


    $("#is_settlement_account").on("click", function() {
        if($(this).prop("checked")) {
            use_settlement_account = false;  
            $("#div_settlement").hide();
            $("#settlement_bank_account_name").val("");
            $("#settlement_bank_account_number").val("");
        } else {
            use_settlement_account = true;  
            $("#div_settlement").show();
        }
    });

    $('#form_credentials_info').validate({
        errorPlacement: function(error, element){
            element.nextAll('span').first().after(error);
        },
        rules : {

            settlement_bank_account_name: {
                required: function() { return use_settlement_account; },    
                maxlength: 50 
            },
            settlement_bank_account_number: {
                required: function() { return use_settlement_account; },
                maxlength: 20 
            },

        },
        messages : {

            settlement_bank_account_name: {
                required: '请填写支付宝姓名',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            settlement_bank_account_number: {
                required: '请填写支付宝账号',
                maxlength: jQuery.validator.format("最多{0}个字")
            },


        }
    });

    $('#btn_apply_credentials_next').on('click', function() {
        if($('#form_credentials_info').valid()) {
            $('#form_credentials_info').submit();
        }
    });

});
</script>
<!-- 公司资质 -->

<div id="apply_credentials_info" class="apply-credentials-info">
  <div class="alert">
    <h4>注意事项：</h4>
    以下所需要上传的电子版资质文件仅支持JPG\GIF\PNG格式图片，大小请控制在1M之内。</div>
  <form id="form_credentials_info" action="index.php?act=store_joinin_c2c&op=step3" method="post" enctype="multipart/form-data" >
    <div id="div_settlement">
      <table border="0" cellpadding="0" cellspacing="0" class="all">
        <thead>
          <tr>
            <th colspan="20">结算（支付宝）账号信息</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="w150"><i>*</i>支付宝姓名：</th>
            <td><input id="settlement_bank_account_name" name="settlement_bank_account_name" type="text" class="w200"/>
              <span></span></td>
          </tr>
          <tr>
            <th><i>*</i>支付宝账号：</th>
            <td><input id="settlement_bank_account_number" name="settlement_bank_account_number" type="text" class="w200"/>
              <span></span></td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="20">&nbsp;</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </form>
  <div class="bottom"><a id="btn_apply_credentials_next" href="javascript:;" class="btn">下一步，提交店铺经营信息</a></div>
</div>
