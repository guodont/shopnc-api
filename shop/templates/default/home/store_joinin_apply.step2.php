<?php defined('InShopNC') or exit('Access Invalid!');?>

<!-- 公司资质 -->

<div id="apply_credentials_info" class="apply-credentials-info">
  <div class="alert">
    <h4>注意事项：</h4>
    以下所需要上传的电子版资质文件仅支持JPG\GIF\PNG格式图片，大小请控制在1M之内。</div>
  <form id="form_credentials_info" action="index.php?act=store_joinin&op=step3" method="post" enctype="multipart/form-data" >
    <table border="0" cellpadding="0" cellspacing="0" class="all">
      <thead>
        <tr>
          <th colspan="20">开户银行信息</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th class="w150"><i>*</i>银行开户名：</th>
          <td><input name="bank_account_name" type="text" class="w200" />
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>公司银行账号：</th>
          <td><input name="bank_account_number" type="text" class="w200" />
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>开户银行支行名称：</th>
          <td><input name="bank_name" type="text" class="w200" />
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>支行联行号：</th>
          <td><input name="bank_code" type="text" class="w200" />
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>开户银行所在地：</th>
          <td><input id="bank_address" name="bank_address" type="hidden" />
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>开户银行许可证电子版：</th>
          <td><input name="bank_licence_electronic" type="file" />
            <span class="block">请确保图片清晰，文字可辨并有清晰的红色公章。</span></td>
        </tr>
        <tr>
          <th></th>
          <td><input id="is_settlement_account" name="is_settlement_account" type="checkbox" />
            <label for="is_settlement_account">此账号为结算账号</label></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20">&nbsp;</td>
        </tr>
      </tfoot>
    </table>
    <div id="div_settlement">
      <table border="0" cellpadding="0" cellspacing="0" class="all">
        <thead>
          <tr>
            <th colspan="20">结算账号信息</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="w150"><i>*</i>银行开户名：</th>
            <td><input id="settlement_bank_account_name" name="settlement_bank_account_name" type="text" class="w200"/>
              <span></span></td>
          </tr>
          <tr>
            <th><i>*</i>公司银行账号：</th>
            <td><input id="settlement_bank_account_number" name="settlement_bank_account_number" type="text" class="w200"/>
              <span></span></td>
          </tr>
          <tr>
            <th><i>*</i>开户银行支行名称：</th>
            <td><input id="settlement_bank_name" name="settlement_bank_name" type="text" class="w200"/>
              <span></span></td>
          </tr>
          <tr>
            <th><i>*</i>支行联行号：</th>
            <td><input id="settlement_bank_code" name="settlement_bank_code" type="text" class="w200"/>
              <span></span></td>
          </tr>
          <tr>
            <th><i>*</i>开户银行所在地：</th>
            <td><input id="settlement_bank_address" name="settlement_bank_address" type="hidden" />
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
    <table border="0" cellpadding="0" cellspacing="0" class="all">
      <thead>
        <tr>
          <th colspan="20">税务登记证</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th class="w150"><i>*</i>税务登记证号：</th>
          <td><input name="tax_registration_certificate" type="text" class="w200"/>
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>纳税人识别号：</th>
          <td><input name="taxpayer_id" type="text" class="w200"/>
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>税务登记证号电子版：</th>
          <td><input name="tax_registration_certificate_electronic" type="file" />
            <span class="block">请确保图片清晰，文字可辨并有清晰的红色公章。</span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20">&nbsp;</td>
        </tr>
      </tfoot>
    </table>
  </form>
  <div class="bottom"><a id="btn_apply_credentials_next" href="javascript:;" class="btn">下一步，提交店铺经营信息</a></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var use_settlement_account = true;
    $("#bank_address").nc_region();
    $("#settlement_bank_address").nc_region();

    $("#is_settlement_account").on("click", function() {
        if($(this).prop("checked")) {
            use_settlement_account = false;  
            $("#div_settlement").hide();
            $("#settlement_bank_account_name").val("");
            $("#settlement_bank_account_number").val("");
            $("#settlement_bank_name").val("");
            $("#settlement_bank_code").val("");
            $("#settlement_bank_address").val("");
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
            bank_account_name: {
                required: true,
                maxlength: 50 
            },
            bank_account_number: {
                required: true,
                maxlength: 20 
            },
            bank_name: {
                required: true,
                maxlength: 50 
            },
            bank_code: {
                required: true,
                maxlength: 20 
            },
            bank_address: {
                required: true
            },
            bank_licence_electronic: {
                required: true
            },
            settlement_bank_account_name: {
                required: function() { return use_settlement_account; },    
                maxlength: 50 
            },
            settlement_bank_account_number: {
                required: function() { return use_settlement_account; },
                maxlength: 20 
            },
            settlement_bank_name: {
                required: function() { return use_settlement_account; },
                maxlength: 50 
            },
            settlement_bank_code: {
                required: function() { return use_settlement_account; },
                maxlength: 20 
            },
            settlement_bank_address: {
                required: function() { return use_settlement_account; }
            },
            tax_registration_certificate: {
                required: true,
                maxlength: 20
            },
            taxpayer_id: {
                required: true,
                maxlength: 20
            },
            tax_registration_certificate_electronic: {
                required: true  
            }

        },
        messages : {
            bank_account_name: {
                required: '请填写银行开户名',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            bank_account_number: {
                required: '请填写公司银行账号',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            bank_name: {
                required: '请填写开户银行支行名称',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            bank_code: {
                required: '请填写支行联行号',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            bank_address: {
                required: '请选择开户银行所在地'
            },
            bank_licence_electronic: {
                required: '请选择上传开户银行许可证电子版文件'
            },
            settlement_bank_account_name: {
                required: '请填写银行开户名',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            settlement_bank_account_number: {
                required: '请填写公司银行账号',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            settlement_bank_name: {
                required: '请填写开户银行支行名称',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            settlement_bank_code: {
                required: '请填写支行联行号',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            settlement_bank_address: {
                required: '请选择开户银行所在地'
            },
            tax_registration_certificate: {
                required: '请填写税务登记证号',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            taxpayer_id: {
                required: '请填写纳税人识别号',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            tax_registration_certificate_electronic: {
                required: '请选择上传税务登记证号电子版文件'
            }
        }
    });

    $('#btn_apply_credentials_next').on('click', function() {
        if($('#form_credentials_info').valid()) {
            $('#form_credentials_info').submit();
        }
    });

});
</script>