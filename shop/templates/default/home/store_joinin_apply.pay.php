<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

  <div class="joinin-pay">
    <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
      <thead>
        <tr>
          <th colspan="6">公司及联系人信息</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>公司名称：</th>
          <td colspan="5"><?php echo $output['joinin_detail']['company_name'];?></td>
        </tr>
        <tr>
          <th>公司所在地：</th>
          <td><?php echo $output['joinin_detail']['company_address'];?></td>
          <th>公司详细地址：</th>
          <td colspan="3"><?php echo $output['joinin_detail']['company_address_detail'];?></td>
        </tr>
        <tr>
          <th>公司电话：</th>
          <td><?php echo $output['joinin_detail']['company_phone'];?></td>
          <th>员工总数：</th>
          <td><?php echo $output['joinin_detail']['company_employee_count'];?>&nbsp;人</td>
          <th>注册资金：</th>
          <td><?php echo $output['joinin_detail']['company_registered_capital'];?>&nbsp;万元 </td>
        </tr>
        <tr>
          <th>联系人姓名：</th>
          <td><?php echo $output['joinin_detail']['contacts_name'];?></td>
          <th>联系人电话：</th>
          <td><?php echo $output['joinin_detail']['contacts_phone'];?></td>
          <th>电子邮箱：</th>
          <td><?php echo $output['joinin_detail']['contacts_email'];?></td>
        </tr>
      </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
      <thead>
        <tr>
          <th colspan="2">营业执照信息（副本）</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>营业执照号：</th>
          <td><?php echo $output['joinin_detail']['business_licence_number'];?></td>
        </tr>
        <tr>
          <th>营业执照所在地：</th>
          <td><?php echo $output['joinin_detail']['business_licence_address'];?></td>
        </tr>
        <tr>
          <th>营业执照有效期：</th>
          <td><?php echo $output['joinin_detail']['business_licence_start'];?> - <?php echo $output['joinin_detail']['business_licence_end'];?></td>
        </tr>
        <tr>
          <th>法定经营范围：</th>
          <td colspan="20"><?php echo $output['joinin_detail']['business_sphere'];?></td>
        </tr>
        <tr>
          <th>营业执照<br />
            电子版：</th>
          <td colspan="20"><a nctype="nyroModal"  href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['business_licence_number_electronic']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['business_licence_number_electronic']);?>" alt="" /> </a></td>
        </tr>
      </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
      <thead>
        <tr>
          <th colspan="2">组织机构代码证</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>组织机构代码：</th>
          <td><?php echo $output['joinin_detail']['organization_code'];?></td>
        </tr>
        <tr>
          <th>组织机构代码证<br/>
            电子版：</th>
          <td><a nctype="nyroModal"  href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['organization_code_electronic']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['organization_code_electronic']);?>" alt="" /> </a></td>
        </tr>
      </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
      <thead>
        <tr>
          <th colspan="2">一般纳税人证明：</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>一般纳税人证明：</th>
          <td><a nctype="nyroModal"  href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['general_taxpayer']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['general_taxpayer']);?>" alt="" /> </a></td>
        </tr>
      </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
      <thead>
        <tr>
          <th colspan="2">开户银行信息：</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>银行开户名：</th>
          <td><?php echo $output['joinin_detail']['bank_account_name'];?></td>
        </tr>
        <tr>
          <th>公司银行账号：</th>
          <td><?php echo $output['joinin_detail']['bank_account_number'];?></td>
        </tr>
        <tr>
          <th>开户银行支行名称：</th>
          <td><?php echo $output['joinin_detail']['bank_name'];?></td>
        </tr>
        <tr>
          <th>支行联行号：</th>
          <td><?php echo $output['joinin_detail']['bank_code'];?></td>
        </tr>
        <tr>
          <th>开户银行所在地：</th>
          <td colspan="20"><?php echo $output['joinin_detail']['bank_address'];?></td>
        </tr>
        <tr>
          <th>开户银行许可证<br/>
            电子版：</th>
          <td colspan="20"><a nctype="nyroModal"  href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['bank_licence_electronic']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['bank_licence_electronic']);?>" alt="" /> </a></td>
        </tr>
      </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
      <thead>
        <tr>
          <th colspan="2">结算账号信息：</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>银行开户名：</th>
          <td><?php echo $output['joinin_detail']['settlement_bank_account_name'];?></td>
        </tr>
        <tr>
          <th>公司银行账号：</th>
          <td><?php echo $output['joinin_detail']['settlement_bank_account_number'];?></td>
        </tr>
        <tr>
          <th>开户银行支行名称：</th>
          <td><?php echo $output['joinin_detail']['settlement_bank_name'];?></td>
        </tr>
        <tr>
          <th>支行联行号：</th>
          <td><?php echo $output['joinin_detail']['settlement_bank_code'];?></td>
        </tr>
        <tr>
          <th>开户银行所在地：</th>
          <td><?php echo $output['joinin_detail']['settlement_bank_address'];?></td>
        </tr>
      </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
      <thead>
        <tr>
          <th colspan="2">税务登记证</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>税务登记证号：</th>
          <td><?php echo $output['joinin_detail']['tax_registration_certificate'];?></td>
        </tr>
        <tr>
          <th>纳税人识别号：</th>
          <td><?php echo $output['joinin_detail']['taxpayer_id'];?></td>
        </tr>
        <tr>
          <th>税务登记证号<br />
            电子版：</th>
          <td><a nctype="nyroModal"  href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['tax_registration_certificate_electronic']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['tax_registration_certificate_electronic']);?>" alt="" /> </a></td>
        </tr>
      </tbody>
    </table>
    <form id="form_paying_money_certificate" action="index.php?act=store_joinin&op=pay_save" method="post" enctype="multipart/form-data">
      <input id="verify_type" name="verify_type" type="hidden" />
      <input name="member_id" type="hidden" value="<?php echo $output['joinin_detail']['member_id'];?>" />
      <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
        <thead>
          <tr>
            <th colspan="2">店铺经营信息</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>卖家账号：</th>
            <td><?php echo $output['joinin_detail']['seller_name'];?></td>
          </tr>
          <tr>
            <th>店铺名称：</th>
            <td><?php echo $output['joinin_detail']['store_name'];?></td>
          </tr>
          <tr>
            <th>店铺等级：</th>
            <td><?php echo $output['joinin_detail']['sg_name'];?>（开店费用：<?php echo $output['joinin_detail']['sg_price'];?> 元/年）</td>
          </tr>
          <tr>
            <th>开店时长：</th>
            <td><?php echo $output['joinin_detail']['joinin_year'];?> 年</td>
          </tr>
          <tr>
            <th>店铺分类：</th>
            <td><?php echo $output['joinin_detail']['sc_name'];?>（开店保证金：<?php echo $output['joinin_detail']['sc_bail'];?> 元）</td>
          </tr>
          <tr>
            <th>应付总金额：</th>
            <td><?php echo $output['joinin_detail']['paying_amount'];?> 元</td>
          </tr>
          <tr>
            <th>经营类目：</th>
            <td><table border="0" cellpadding="0" cellspacing="0" id="table_category" class="type">
                <thead>
                  <tr>
                    <th>分类1</th>
                    <th>分类2</th>
                    <th>分类3</th>
                    <th>比例</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $store_class_names = unserialize($output['joinin_detail']['store_class_names']);?>
                  <?php $store_class_commis_rates = explode(',', $output['joinin_detail']['store_class_commis_rates']);?>
                  <?php if(!empty($store_class_names) && is_array($store_class_names)) {?>
                  <?php for($i=0, $length = count($store_class_names); $i < $length; $i++) {?>
                  <?php list($class1, $class2, $class3) = explode(',', $store_class_names[$i]);?>
                  <tr>
                    <td><?php echo $class1;?></td>
                    <td><?php echo $class2;?></td>
                    <td><?php echo $class3;?></td>
                    <td><?php echo $store_class_commis_rates[$i];?>%</td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                </tbody>
              </table></td>
          </tr>
          <tr>
            <th>审核意见：</th>
            <td colspan="2"><?php echo $output['joinin_detail']['joinin_message'];?></td>
          </tr>
        </tbody>
      </table>
      <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
        <tbody>
          <tr>
            <th>上传付款凭证：</th>
            <td><input name="paying_money_certificate" type="file" />
              <span></span></td>
          </tr>
          <tr>
            <th>备注：</th>
            <td><textarea name="paying_money_certificate_explain" rows="10" cols="30"></textarea>
              <span></span></td>
          </tr>
        </tbody>
      </table>
    </form>
    <div class="bottom"><a id="btn_paying_money_certificate" href="javascript:;" class="btn">提交</a></div>
  </div>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script> 
<script type="text/javascript">
    $(document).ready(function(){
        $('a[nctype="nyroModal"]').nyroModal();

        $('#form_paying_money_certificate').validate({
            errorPlacement: function(error, element){
                element.nextAll('span').first().after(error);
            },
            rules : {
                paying_money_certificate: {
                    required: true
                },
                paying_money_certificate_explain: {
                    maxlength: 100 
                }
            },
            messages : {
                paying_money_certificate: {
                    required: '请选择上传付款凭证'
                },
                paying_money_certificate_explain: {
                    maxlength: jQuery.validator.format("最多{0}个字")
                }
            }
        });

        $('#btn_paying_money_certificate').on('click', function() {
            $('#form_paying_money_certificate').submit();
        });

    });
</script>
