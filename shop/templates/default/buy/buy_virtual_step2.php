<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="ncc-main">
 <div class="ncc-title">
    <h3>填写核对购物信息</h3>
    <h5>请仔细填写手机号，以确保电子兑换码准确发到您的手机。</h5>
 </div>
  <form action="<?php echo urlShop('buy_virtual','buy_step3');?>" method="POST" id="form_buy" name="form_buy">
  <input type="hidden" name="goods_id" value="<?php echo $output['goods_info']['goods_id'];?>">
  <input type="hidden" name="quantity" value="<?php echo $output['goods_info']['quantity'];?>">
    <div class="ncc-receipt-info">
      <div class="ncc-receipt-info-title">
        <h3>电子兑换码/券接收方式</h3></div>
      <div id="invoice_list" class="ncc-candidate-items">
        <ul style="overflow: visible;">
          <li>手机号码：
            <div class="parentCls"><input name="buyer_phone" class="inputElem text" autocomplete = "off"  type="text" id="buyer_phone" value="<?php echo $output['member_info']['member_mobile'];?>" maxlength="11"></div>
          </li>
        </ul>
        <p><i class="icon-info-sign"></i>您本次购买的商品不需要收货地址，请正确输入接收手机号码，确保及时获得“电子兑换码”。可使用您已经绑定的手机或重新输入其它手机号码。</p>
      </div>
    </div><div class="ncc-receipt-info"><div class="ncc-receipt-info-title">
      <h3>虚拟服务类商品清单</h3><a href="index.php?act=buy_virtual&op=buy_step1&goods_id=<?php echo $_POST['goods_id'];?>&quantity=<?php echo $_POST['quantity'];?>">返回上一步</a></div>
    <table class="ncc-table-style" nc_type="table_cart">
      <thead>
        <tr>
          <th colspan="3">商品</th>
          <th class="w150">单价(<?php echo $lang['currency_zh'];?>)</th>
          <th class="w80">数量</th>
          <th class="w150">小计(元)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th colspan="20">店铺：<a href="<?php echo urlShop('show_store','index',array('store_id'=>$output['store_info']['store_id']));?>"><?php echo $output['store_info']['store_name'];?></a> <span member_id="<?php echo $output['store_info']['member_id'];?>"></span>
          </th>
        </tr>

        <tr class="shop-list">
          <td class="w10"></td>
          <td class="w60"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$output['goods_info']['goods_id']));?>" target="_blank" class="ncc-goods-thumb"><img src="<?php echo thumb($output['goods_info'],60);?>" alt="<?php echo $output['goods_info']['goods_name']; ?>" /></a></td>
          <td class="tl"><dl class="ncc-goods-info">
              <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$output['goods_info']['goods_id']));?>" target="_blank"><?php echo $output['goods_info']['goods_name']; ?></a></dt>
                <dd>
                <?php if ($output['goods_info']['ifgroupbuy']) { ?>
                <span class="groupbuy">抢购</span>
                <?php } ?>
                </dd>
            </dl></td>
          <td class="w120"><em id="item_price"><?php echo $output['goods_info']['goods_price'];?></em></td>
          <td class="w120"><?php echo $output['goods_info']['quantity'];?></td>
          <td><em id="item_subtotal"><?php echo $output['goods_info']['goods_total'];?></em></td>
        </tr>

        <!-- S 留言 -->
		<tr>
			<td class="w10"></td>
			<td class="tl" colspan="2">买家留言：
				<textarea name="buyer_msg" class="ncc-msg-textarea" maxlength="150" placeholder="选填：对本次交易的说明（建议填写已经和商家达成一致的说明）" title="选填：对本次交易的说明（建议填写已经和商家达成一致的说明）"></textarea></td>
			<td class="tl" colspan="10"></td>
		</tr>
        <!-- E 留言 -->

     <!-- S 预存款/充值卡 -->
     <?php if ($output['member_info']['available_predeposit'] > 0 || $output['member_info']['available_rc_balance'] > 0) { ?>
     <tr id="pd_panel">
        <td class="pd-account" colspan="20"><div class="ncc-pd-account">
        <?php if ($output['member_info']['available_rc_balance'] > 0) { ?>
            <div class="mt5 mb5"><label><input type="checkbox" class="vm mr5" value="1" name="rcb_pay">使用充值卡（可用金额：<em><?php echo $output['member_info']['available_rc_balance'];?></em>元）</label></div>
        <?php } ?>
        <?php if ($output['member_info']['available_predeposit'] > 0) { ?>
            <div class="mt5 mb5"><label><input type="checkbox" class="vm mr5" value="1" name="pd_pay">使用预存款（可用金额：<em><?php echo $output['member_info']['available_predeposit'];?></em>元）</label></div>
        <?php } ?>
      <?php if ($output['member_info']['available_predeposit'] > 0 && $output['member_info']['available_rc_balance'] > 0) { ?>
      <div class="mt5 mb5">如果二者同时使用，系统优先使用充值卡&nbsp;&nbsp;</div>
      <?php } ?>
            <div id="pd_password" style="display: none">支付密码：<input type="password" class="text w120" value="" name="password" id="pay-password" maxlength="35">
            <input type="hidden" value="" name="password_callback" id="password_callback">
              <a class="ncc-btn-mini ncc-btn-orange" id="pd_pay_submit" href="javascript:void(0)">使用</a>
              <?php if (!$output['member_info']['member_paypwd']) {?>
              还未设置支付密码，<a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_security&op=auth&type=modify_paypwd" target="_blank">马上设置</a>
              <?php } ?>
             </div>
          </div></td>
      </tr>
     <?php } ?>
     <!-- E 预存款 -->

    <!-- S voucher list -->
     <?php if (!empty($output['store_voucher_list']) && is_array($output['store_voucher_list'])) {?>
      <tr>
        <td class="tr" colspan="20"><div class="ncc-store-account">
            <dl class="voucher">
              <dt>
                <select nctype="voucher" name="voucher">
                  <option value="|0.00">选择代金券</option>
                  <?php foreach ($output['store_voucher_list'] as $voucher) {?>
                  <option value="<?php echo $voucher['voucher_t_id'];?>|<?php echo $voucher['voucher_price'];?>"><?php echo $voucher['desc'];?></option>
                  <?php } ?>
                </select> ：
              <dd>￥<em id="storeVoucher">-0.00</em></dd>
            </dl>
          </div></td>
      </tr>
    <?php } ?>
    <!-- E voucher list -->
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"><div class="ncc-all-account">商品总价<em id="orderTotal"><?php echo $output['goods_info']['goods_total']; ?></em>元</div></td>
        </tr>
      </tfoot>
    </table>

</div></form>
  <div class="ncc-bottom"><a id="submitOrder" href="javascript:void(0)" class="ncc-btn ncc-btn-acidblue fr">提交订单</a></div>


<script src="<?php echo RESOURCE_SITE_URL;?>/js/input_max.js"></script>
<script>
//input内容放大
$(function(){
	new TextMagnifier({
		inputElem: '.inputElem',
			align: 'top'
	});
});

//计算应支付金额计算
function calcOrder() {
    var allTotal = parseFloat($('#item_subtotal').html());
    if ($('#storeVoucher').length > 0) {
    	allTotal += parseFloat($('#storeVoucher').html());
    }
    $('#cartTotal').html(number_format(allTotal,2));
}

$(document).ready(function(){

    $('select[nctype="voucher"]').on('change',function(){
        if ($(this).val() == '') {
        	$('#storeVoucher').html('-0.00');
        } else {
            var items = $(this).val().split('|');
            $('#storeVoucher').html('-'+number_format(items[1],2));
        }
        calcOrder();
    });

    <?php if ($output['member_info']['available_predeposit'] > 0 || $output['member_info']['available_rc_balance'] > 0) { ?>
    function showPaySubmit() {
        if ($('input[name="pd_pay"]').attr('checked') || $('input[name="rcb_pay"]').attr('checked')) {
        	$('#pay-password').val('');
        	$('#password_callback').val('');
        	$('#pd_password').show();
        } else {
        	$('#pd_password').hide();
        }
    }
    <?php } ?>

    <?php if ($output['member_info']['available_rc_balance'] > 0) { ?>
    $('input[name="rcb_pay"]').on('change',function(){
    	showPaySubmit();
    	if ($(this).attr('checked') && !$('input[name="pd_pay"]').attr('checked')) {
        	if (<?php echo $output['member_info']['available_rc_balance']; ?> >= parseFloat($('#orderTotal').html())) {
        		$('input[name="pd_pay"]').attr('checked',false).attr('disabled',true);
        	}
    	} else {
    		$('input[name="pd_pay"]').attr('disabled',false);
    	}
    });
    <?php } ?>

    <?php if ($output['member_info']['available_predeposit'] > 0) { ?>
    $('input[name="pd_pay"]').on('change',function(){
    	showPaySubmit();
    	if ($(this).attr('checked') && !$('input[name="rcb_pay"]').attr('checked')) {
        	if (<?php echo $output['member_info']['available_predeposit'] ?> >= parseFloat($('#orderTotal').html())) {
            	$('input[name="rcb_pay"]').attr('checked',false).attr('disabled',true);
        	}
    	} else {
    		$('input[name="rcb_pay"]').attr('disabled',false);
    	}
    });
    <?php } ?>

    $('#pd_pay_submit').on('click',function(){
        if ($('#pay-password').val() == '') {
        	showDialog('请输入支付密码', 'error','','','','','','','','',2);return false;
        }
        $('#password_callback').val('');
		$.get("index.php?act=buy&op=check_pd_pwd", {'password':$('#pay-password').val()}, function(data){
            if (data == '1') {
            	$('#password_callback').val('1');
            	$('#pd_password').hide();
            } else {
            	$('#pay-password').val('');
            	showDialog('密码错误', 'error','','','','','','','','',2);
            }
        });
    });

    var SUBMIT_FORM = true;
    $('#submitOrder').on('click',function(){
        if (!$("#form_buy").valid()) return;
    	if (!SUBMIT_FORM) return;
    	if (($('input[name="pd_pay"]').attr('checked') || $('input[name="rcb_pay"]').attr('checked')) && $('#password_callback').val() != '1') {
    		showDialog('使用充值卡/预存款支付，需输入支付密码并使用  ', 'error','','','','','','','','',2);
    		return;
    	}
    	SUBMIT_FORM = false;
    	$('#form_buy').submit();
    });

	$("#form_buy").validate({
		onkeyup: false,
		rules: {
			buyer_phone : {
				required : true,
				digits : true,
				minlength : 11
			}
		},
		messages: {
			buyer_phone : {
				required : "请填写手机号码",
				digits : "请正确填写手机号码",
				minlength : "请正确填写手机号码"
			}
		}
	});
});
</script>

