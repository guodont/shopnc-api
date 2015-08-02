<?php defined('InShopNC') or exit('Access Invalid!');?>

<!-- 公司信息 -->

<div id="apply_company_info" class="apply-company-info">
  <div class="alert">
    <h4>注意事项：</h4>
    以下所需要上传的电子版资质文件仅支持JPG\GIF\PNG格式图片，大小请控制在1M之内。</div>
  <form id="form_company_info" action="index.php?act=store_joinin&op=step2" method="post" enctype="multipart/form-data" >
    <table border="0" cellpadding="0" cellspacing="0" class="all">
      <thead>
        <tr>
          <th colspan="2">公司及联系人信息</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th><i>*</i>公司名称：</th>
          <td><input name="company_name" type="text" class="w200"/>
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>公司所在地：</th>
          <td><input id="company_address" name="company_address" type="hidden" value=""/>
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>公司详细地址：</th>
          <td><input name="company_address_detail" type="text" class="w200">
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>公司电话：</th>
          <td><input name="company_phone" type="text" class="w100">
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>员工总数：</th>
          <td><input name="company_employee_count" type="text" class="w50"/>
            &nbsp;人 <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>注册资金：</th>
          <td><input name="company_registered_capital" type="text" class="w50">
            &nbsp;万元<span></span></td>
        </tr>
        <tr>
          <th><i>*</i>联系人姓名：</th>
          <td><input name="contacts_name" type="text" class="w100" />
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>联系人电话：</th>
          <td><input name="contacts_phone" type="text" class="w100" />
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>电子邮箱：</th>
          <td><input name="contacts_email" type="text" class="w200" />
            <span></span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20">&nbsp;</td>
        </tr>
      </tfoot>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="all">
      <thead>
        <tr>
          <th colspan="20">营业执照信息（副本）</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th><i>*</i>营业执照号：</th>
          <td><input name="business_licence_number" type="text" class="w200" />
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>营业执照所在地：</th>
          <td><input id="business_licence_address" name="business_licence_address" type="hidden" />
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>营业执照有效期：</th>
          <td><input id="business_licence_start" name="business_licence_start" type="text" class="w90" />
            <span></span>-
            <input id="business_licence_end" name="business_licence_end" type="text" class="w90" />
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>法定经营范围：</th>
          <td><textarea name="business_sphere" rows="3" class="w200"></textarea>
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>营业执照电子版：</th>
          <td><input name="business_licence_number_electronic" type="file" class="w200" />
            <span class="block">请确保图片清晰，文字可辨并有清晰的红色公章。</span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20">&nbsp;</td>
        </tr>
      </tfoot>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="all">
      <thead>
        <tr>
          <th colspan="20">组织机构代码证</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th><i>*</i>组织机构代码：</th>
          <td><input name="organization_code" type="text" class="w200"/>
            <span></span></td>
        </tr>
        <tr>
          <th><i>*</i>组织机构代码证电子版：</th>
          <td><input name="organization_code_electronic" type="file" />
            <span class="block">请确保图片清晰，文字可辨并有清晰的红色公章。</span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20">&nbsp;</td>
        </tr>
      </tfoot>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="all">
      <thead>
        <tr>
          <th colspan="20">一般纳税人证明<em>注：所属企业具有一般纳税人证明时，此项为必填。</em></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th class="w150"><i>*</i>一般纳税人证明：</th>
          <td><input name="general_taxpayer" type="file" />
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
  <div class="bottom"><a id="btn_apply_company_next" href="javascript:;" class="btn">下一步，提交财务资质信息</a></div>
</div>
<script type="text/javascript">
$(document).ready(function(){

    $('#company_address').nc_region();
    $('#business_licence_address').nc_region();
    
    $('#business_licence_start').datepicker();
    $('#business_licence_end').datepicker();

    $('#btn_apply_agreement_next').on('click', function() {
        if($('#input_apply_agreement').prop('checked')) {
            $('#apply_agreement').hide();
            $('#apply_company_info').show();
        } else {
            alert('请阅读并同意协议');
        }
    });

    $('#form_company_info').validate({
        errorPlacement: function(error, element){
            element.nextAll('span').first().after(error);
        },
        rules : {
            company_name: {
                required: true,
                maxlength: 50 
            },
            company_address: {
                required: true,
                maxlength: 50 
            },
            company_address_detail: {
                required: true,
                maxlength: 50 
            },
            company_phone: {
                required: true,
                maxlength: 20 
            },
            company_employee_count: {
                required: true,
                digits: true 
            },
            company_registered_capital: {
                required: true,
                digits: true 
            },
            contacts_name: {
                required: true,
                maxlength: 20 
            },
            contacts_phone: {
                required: true,
                maxlength: 20 
            },
            contacts_email: {
                required: true,
                email: true 
            },
            business_licence_number: {
                required: true,
                maxlength: 20
            },
            business_licence_address: {
                required: true,
                maxlength: 50
            },
            business_licence_start: {
                required: true
            },
            business_licence_end: {
                required: true
            },
            business_sphere: {
                required: true,
                maxlength: 500
            },
            business_licence_number_electronic: {
                required: true
            },
            organization_code: {
                required: true,
                maxlength: 20
            },
            organization_code_electronic: {
                required: true
            }
        },
        messages : {
            company_name: {
                required: '请输入公司名称',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            company_address: {
                required: '请选择区域地址',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            company_address_detail: {
                required: '请输入公司详细地址',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            company_phone: {
                required: '请输入公司电话',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            company_employee_count: {
                required: '请输入员工总数',
                digits: '必须为数字'
            },
            company_registered_capital: {
                required: '请输入注册资金',
                digits: '必须为数字'
            },
            contacts_name: {
                required: '请输入联系人姓名',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            contacts_phone: {
                required: '请输入联系人电话',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            contacts_email: {
                required: '请输入常用邮箱地址',
                email: '请填写正确的邮箱地址'
            },
            business_licence_number: {
                required: '请输入营业执照号',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            business_licence_address: {
                required: '请选择营业执照所在地',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            business_licence_start: {
                required: '请选择生效日期'
            },
            business_licence_end: {
                required: '请选择结束日期'
            },
            business_sphere: {
                required: '请填写营业执照法定经营范围',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            business_licence_number_electronic: {
                required: '请选择上传营业执照电子版文件'
            },
            organization_code: {
                required: '请填写组织机构代码',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            organization_code_electronic: {
                required: '请选择上传组织机构代码证电子版文件'
            }
        }
    });

    $('#btn_apply_company_next').on('click', function() {
        if($('#form_company_info').valid()) {
        	$('#company_address').next().attr('name','province_id');
            $('#form_company_info').submit();
        }
    });
});
</script> 
