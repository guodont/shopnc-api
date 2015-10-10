<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>手机支付</h3>
      <ul class="tab-base">
          <li><a href="<?php echo urlAdmin('mb_payment', 'payment_list');?>"><span>列表</span></a></li>
          <li><a class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1" action="<?php echo urlAdmin('mb_payment', 'payment_save');?>">
    <input type="hidden" name="payment_id" value="<?php echo $output['payment']['payment_id'];?>" />
    <input type="hidden" name="payment_code" value="<?php echo $output['payment']['payment_code'];?>" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['payment']['payment_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php if ($output['payment']['payment_code'] == 'alipay') { ?>
        <tr>
          <td colspan="2" class="required"><label class="validation">支付宝账号:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
              <input name="alipay_account" id="alipay_account" value="<?php echo $output['payment']['payment_config']['alipay_account'];?>" class="txt" type="text">
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">交易安全校验码（key）:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="alipay_key" id="alipay_key" value="<?php echo $output['payment']['payment_config']['alipay_key'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">合作者身份（partner ID）:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="alipay_partner" id="alipay_partner" value="<?php echo $output['payment']['payment_config']['alipay_partner'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <?php } ?>
        <?php if ($output['payment']['payment_code'] == 'wxpay') { ?>
        <tr>
            <td colspan="2" class="required"><label class="validation">公众号的唯一标识（appid）:</label> </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="wxpay_appid" id="wxpay_appid" value="<?php echo $output['payment']['payment_config']['wxpay_appid'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">商户号（mch_id）: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="wxpay_mch_id" id="wxpay_mch_id" value="<?php echo $output['payment']['payment_config']['wxpay_mch_id'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>

        <tr>
            <td colspan="2" class="required"><label class="validation">公众号的appsecret: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="wxpay_appsecret" id="wxpay_appsecret" value="<?php echo $output['payment']['payment_config']['wxpay_appsecret'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">商户支付key: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="wxpay_key" id="wxpay_key" value="<?php echo 
		  $output['payment']['payment_config']['wxpay_key'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>

        
        <?php } ?>

        <tr>
          <td colspan="2" class="required">启用: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="payment_state1" class="cb-enable <?php if($output['payment']['payment_state'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="payment_state2" class="cb-disable <?php if($output['payment']['payment_state'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_no'];?></span></label>
            <input type="radio" <?php if($output['payment']['payment_state'] == '1'){ ?>checked="checked"<?php }?> value="1" name="payment_state" id="payment_state1">
            <input type="radio" <?php if($output['payment']['payment_state'] == '0'){ ?>checked="checked"<?php }?> value="0" name="payment_state" id="payment_state2"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="btn_submit" ><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(document).ready(function(){
	$('#post_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parentsUntil('tr').parent().prev().find('td:first'));
        },
		<?php if ($output['payment']['payment_code'] == 'alipay') { ?>
        rules : {
            alipay_account : {
                required   : true
            },
            alipay_key : {
                required   : true
            },
            alipay_partner : {
                required   : true
            }
        },
        messages : {
            alipay_account  : {
                required  : '支付宝账号不能为空'
            },
            alipay_key  : {
                required  : '交易安全校验码不能为空'
            },
            alipay_partner  : {
                required  : '合作者身份不能为空'
            }
        }
		<?php } ?>
		<?php if ($output['payment']['payment_code'] == 'wxpay') { ?>
        rules : {
            wxpay_appid : {
                required   : true
            },
            wxpay_mch_id : {
                required   : true
            },
            wxpay_appsecret : {
                required   : true
            },
			wxpay_key  : {
                required   : true
            }
        },
        messages : {
            wxpay_appid  : {
                required  : '公众号的唯一标识（appid）不能为空'
            },
            wxpay_mch_id  : {
                required  : '商户号（mch_id）不能为空'
            },
            wxpay_appsecret  : {
                required  : '公众号的appsecret不能为空'
            },
			wxpay_key  : {
                required  : '商户支付Key不能为空'
            }
        }
    <?php } ?>
    });
    

    $('#btn_submit').on('click', function() {
        $('#post_form').submit();
    });
});
</script>
