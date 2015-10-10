<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="ncc-bottom"> <a href="javascript:void(0)" id='submitOrder' class="ncc-btn ncc-btn-acidblue fr"><?php echo $lang['cart_index_submit_order'];?></a> </div>
<script>
function submitNext(){
	if (!SUBMIT_FORM) return;

	if ($('input[name="cart_id[]"]').size() == 0) {
		showDialog('所购商品无效', 'error','','','','','','','','',2);
		return;
	}
    if ($('#address_id').val() == ''){
		showDialog('<?php echo $lang['cart_step1_please_set_address'];?>', 'error','','','','','','','','',2);
		return;
	}
	if ($('#buy_city_id').val() == '') {
		showDialog('正在计算运费,请稍后', 'error','','','','','','','','',2);
		return;
	}
	if (($('input[name="pd_pay"]').attr('checked') || $('input[name="rcb_pay"]').attr('checked')) && $('#password_callback').val() != '1') {
		showDialog('使用充值卡/预存款支付，需输入支付密码并使用  ', 'error','','','','','','','','',2);
		return;
	}
	if ($('input[name="fcode"]').size() == 1 && $('#fcode_callback').val() != '1') {
		showDialog('请输入并使用F码', 'error','','','','','','','','',2);
		return;
	}
	SUBMIT_FORM = false;

	$('#order_form').submit();
}
$(function(){
    $(document).keydown(function(e) {
        if (e.keyCode == 13) {
        	submitNext();
        	return false;
        }
    });
	$('#submitOrder').on('click',function(){submitNext()});
	calcOrder();
});
</script>