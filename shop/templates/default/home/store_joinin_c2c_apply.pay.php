<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
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
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="joinin-pay">  
  <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
    <thead>
      <tr>
        <th colspan="6">店铺及联系人信息</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>店铺名称：</th>
        <td colspan="5"><?php echo $output['joinin_detail']['company_name'];?></td>
      </tr>
      <tr>
        <th>所在地：</th>
        <td><?php echo $output['joinin_detail']['company_address'];?></td>
        <th>详细地址：</th>
        <td colspan="3"><?php echo $output['joinin_detail']['company_address_detail'];?></td>
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
        <th colspan="2">身份证信息</th>
      </tr>
    </thead>
    <tbody>
	  <tr>
        <th>身份证姓名：</th>
        <td colspan="20"><?php echo $output['joinin_detail']['business_sphere'];?></td>
      </tr>
      <tr>
        <th>身份证号码：</th>
        <td><?php echo $output['joinin_detail']['business_licence_number'];?></td></tr>

      <tr>
        <th>身份证扫描件：</th>
        <td colspan="20"><a nctype="nyroModal"  href="<?php echo getStoreJoininImageUrl($output['joinin_detail']['business_licence_number_electronic']);?>"> <img src="<?php echo getStoreJoininImageUrl($output['joinin_detail']['business_licence_number_electronic']);?>" alt="" /> </a></td>
      </tr>
    </tbody>
  </table>


  <table border="0" cellpadding="0" cellspacing="0" class="store-joinin">
    <thead>
      <tr>
        <th colspan="2">结算（支付宝）账号信息：</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>支付宝帐户名：</th>
        <td><?php echo $output['joinin_detail']['settlement_bank_account_name'];?></td>
      </tr>
      <tr>
        <th>支付宝账号：</th>
        <td><?php echo $output['joinin_detail']['settlement_bank_account_number'];?></td>
      </tr>
    </tbody>
    
  </table>

  <form id="form_paying_money_certificate" action="index.php?act=store_joinin_c2c&op=pay_save" method="post" enctype="multipart/form-data">
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
          <th>卖家帐号：</th>
          <td><?php echo $output['joinin_detail']['seller_name'];?></td>
        </tr>
        <tr>
          <th>店铺名称：</th>
          <td><?php echo $output['joinin_detail']['store_name'];?></td>
        </tr>
        <tr>
          <th>店铺等级：</th>
          <td><?php echo $output['joinin_detail']['sg_name'];?></td>
        </tr>
        <tr>
          <th>店铺分类：</th>
          <td><?php echo $output['joinin_detail']['sc_name'];?></td>
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
          <tbody><tr>
              <th>上传付款凭证：</th>
              <td>
                  <input name="paying_money_certificate" type="file" /><span></span>
              </td>
          </tr>
          <tr>
              <th>备注：</th>
              <td>
                  <textarea name="paying_money_certificate_explain" rows="10" cols="30"></textarea>
                  <span></span>
              </td>
          </tr></tbody>
      </table>
  </form>
  <div class="bottom"><a id="btn_paying_money_certificate" href="javascript:;" class="btn">提交</a></div></div>
