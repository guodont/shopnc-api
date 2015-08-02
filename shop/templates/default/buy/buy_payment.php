<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncc-receipt-info" id="paymentCon">
  <div class="ncc-receipt-info-title">
    <h3>支付方式</h3>
    <?php if (!$output['deny_edit_payment']) {?>
    <a href="javascript:void(0)" nc_type="buy_edit" id="edit_payment">[修改]</a>
    <?php }?>
  </div>
  <div class="ncc-candidate-items">
    <ul>
      <li>在线支付</li>
    </ul>
  </div>
  <div id="payment_list" class="ncc-candidate-items" style="display:none">
    <ul>
      <li>
        <input type="radio" value="online" name="payment_type" id="payment_type_online">
        <label for="payment_type_online">在线支付</label>
      </li>
      <li>
        <input type="radio" value="offline" name="payment_type" id="payment_type_offline">
        <label for="payment_type_offline">货到付款</label>
        <a id="show_goods_list" style="display: none" class="ncc-payment-showgoods" href="javascript:void(0);"><i class="icon-truck"></i>货到付款 (<span data-cod-nums="offline"><?php echo count($output['pay_goods_list']['offline']);?></span>种商品) + <i class="icon-credit-card"></i>在线支付 (<span data-cod-nums="online"><?php echo count($output['pay_goods_list']['online']);?></span>种商品)</a>
      </li>
    </ul>
    <div class="hr16"> <a href="javascript:void(0);" class="ncc-btn ncc-btn-red" id="hide_payment_list">保存支付方式</a></div>
  </div>
  <div id="ncc-payment-showgoods-list" class="ncc-payment-showgoods-list">
    <dl>
      <dt data-hideshow="offline">货到付款</dt>
      <dd data-hideshow="offline" data-cod2-type="offline">
        <?php foreach((array) $output['pay_goods_list']['offline'] as $value) {?>
        <div class="goods-thumb" data-cod2-store="<?php echo $value['store_id']; ?>"><span><img src="<?php echo thumb($value,60);?>"></span></div>
        <?php } ?>
      </dd>
      <dt data-hideshow="online">在线支付</dt>
      <dd data-hideshow="online" data-cod2-type="online">
        <?php foreach((array) $output['pay_goods_list']['online'] as $value) {?>
        <div class="goods-thumb" data-cod2-store="<?php echo $value['store_id']; ?>"><span><img src="<?php echo thumb($value,60);?>"></span></div>
        <?php } ?>
      </dd>
    </dl>
  </div>
</div>

<!-- 在线支付和货到付款组合时，显示弹出确认层内容 -->
<div id="confirm_offpay_goods_list" style="display: none;">
  <dl class="ncc-offpay-list" data-hideshow="offline">
    <dt>以下商品支持<strong>货到付款</strong></dt>
    <dd>
      <ul data-cod-type="offline">
        <?php foreach((array) $output['pay_goods_list']['offline'] as $value) {?>
        <li data-cod-store="<?php echo $value['store_id']; ?>"><span title="<?php echo $value['goods_name'];?>"><img src="<?php echo thumb($value,60);?>"></span></li>
        <?php } ?>
      </ul>
      <label>
        <input type="radio" value="" checked="checked">
        货到付款
      </label>
    </dd>
  </dl>
  <dl class="ncc-offpay-list" data-hideshow="online">
    <dt>以下商品支持<strong>在线支付</strong></dt>
    <dd>
      <ul data-cod-type="online">
        <?php foreach((array) $output['pay_goods_list']['online'] as $value) {?>
        <li data-cod-store="<?php echo $value['store_id']; ?>"><span title="<?php echo $value['goods_name'];?>"><img src="<?php echo thumb($value,60);?>"></span></li>
        <?php } ?>
      </ul>
      <label>
        <input type="radio" value="" checked="checked">
        在线支付
      </label>
    </dd>
  </dl>

  <div class="tc mt10 mb10"><a href="javascript:void(0);" class="ncc-btn ncc-btn-orange" id="close_confirm_button">确认支付方式</a></div>
</div>
<script type="text/javascript">
$(function(){

var hybrid = <?php echo $output['ifshow_offpay'] === true && count($output['pay_goods_list']['online']) > 0 ? '1' : '0'; ?>;

var failInPage = false;

// 重新调整在线支付/到付的商品展示
var setCodGoodsShow = function() {
    var j = $('#allow_offpay_batch').val();
    var arr = {};
    if (j) {
        $.each(j.split(';'), function(k, v) {
            vv = v.split(':');
            arr[vv[0]] = vv[1] == '1' ? true : false;
        });
    }

    $.each(arr, function(k, v) {
        //console.log(''+k+':'+v);
        if (v) {
            $("[data-cod-type='online'] [data-cod-store='"+k+"']").appendTo("[data-cod-type='offline']");
            $("[data-cod-type='online'] [data-cod-store='"+k+"']").remove();

            $("[data-cod2-type='online'] [data-cod2-store='"+k+"']").appendTo("[data-cod2-type='offline']");
            $("[data-cod2-type='online'] [data-cod2-store='"+k+"']").remove();
        } else {
            $("[data-cod-type='offline'] [data-cod-store='"+k+"']").appendTo("[data-cod-type='online']");
            $("[data-cod-type='offline'] [data-cod-store='"+k+"']").remove();

            $("[data-cod2-type='offline'] [data-cod2-store='"+k+"']").appendTo("[data-cod2-type='online']");
            $("[data-cod2-type='offline'] [data-cod2-store='"+k+"']").remove();
        }
    });

    var off = $("[data-cod2-type='offline'] [data-cod2-store]").length;
    var on = $("[data-cod2-type='online'] [data-cod2-store]").length;

    $("[data-hideshow='offline']")[off ? 'show' : 'hide']();
    $("[data-hideshow='online']")[on ? 'show' : 'hide']();

    $("span[data-cod-nums='offline']").html(off);
    $("span[data-cod-nums='online']").html(on);

    failInPage = ! off;
    hybrid = off && on;

};

	//点击修改支付方式
    $('#edit_payment').on('click',function(){
        $('#edit_payment').parent().next().remove();
        $(this).hide();
        $('#paymentCon').addClass('current_box');
        $('#payment_list').show();
        disableOtherEdit('如需要修改，请先保存支付方式');
    });
    //保存支付方式
    $('#hide_payment_list').on('click',function(){
        var payment_type = $('input[name="payment_type"]:checked').val();
        if ($('input[name="payment_type"]:checked').size() == 0) return;

        setCodGoodsShow();

        //判断该地区(县ID)是否能货到付款
        if (payment_type == 'offline' && ($('#allow_offpay').val() == '0' || failInPage)) {
            showDialog('您目前选择的收货地区不支持货到付款!', 'error','','','','','','','','',2);return;
        }
        $('#payment_list').hide();
        $('#edit_payment').show();
		$('.current_box').removeClass('current_box');
        var content = (payment_type == 'online' ? '在线支付' : '货到付款');
        $('#pay_name').val(payment_type);

        if (payment_type == 'offline'){
            //如果混合支付（在线+货到付款）
            if (hybrid) {
                content = $('#show_goods_list').clone().html();
                $('#edit_payment').parent().after('<div class="ncc-candidate-items"><ul><li>您选择货到付款 + 在线支付完成此订单<br/><a href="javsacript:void(0);" id="show_goods_list" class="ncc-payment-showgoods">'+content+'</a></li></ul></div>');
                $('#show_goods_list').hover(function(){showPayGoodsList(this)},function(){$('#ncc-payment-showgoods-list').fadeOut()});
            } else {
                $('#edit_payment').parent().after('<div class="ncc-candidate-items"><ul><li>'+content+'</li></ul></div>');
                $('input[name="pd_pay"]').attr('checked',false);
                $('#pd_panel').hide();
            }
        }else{
            $('#edit_payment').parent().after('<div class="ncc-candidate-items"><ul><li>'+content+'</li></ul></div>');
            $('#pd_panel').show();
        }
        ableOtherEdit();
    });
    $('#show_goods_list').hover(function(){showPayGoodsList(this)},function(){$('#ncc-payment-showgoods-list').fadeOut()});
    function showPayGoodsList(item){
		var pos = $(item).position();
		var pos_x = pos.left+0;
		var pos_y = pos.top+25;
		$("#ncc-payment-showgoods-list").css({'left' : pos_x, 'top' : pos_y,'position' : 'absolute','display' : 'block'});
        $('#ncc-payment-showgoods-list').addClass('ncc-payment-showgoods-list').fadeIn();
    }
    $('input[name="payment_type"]').on('change',function(){
        if ($(this).val() == 'online'){
            $('#show_goods_list').hide();
        } else {

            setCodGoodsShow();

            //判断该地区(县ID)是否能货到付款
            if (($('#allow_offpay').val() == '0') || failInPage) {
                $('#payment_type_online').attr('checked',true);
                showDialog('您目前选择的收货地区不支持货到付款', 'error','','','','','','','','',2);return;
            }
            html_form('confirm_pay_type', '请确认支付方式', $('#confirm_offpay_goods_list').html(), 500,1);
            $('#show_goods_list').show();
        }
    });

    $('body').on('click','#close_confirm_button',function(){
        DialogManager.close('confirm_pay_type');
    });
})
</script>