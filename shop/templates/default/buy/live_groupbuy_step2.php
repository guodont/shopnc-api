<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="ncc-main">
  <div class="ncc-title">
    <h3><?php echo $lang['cart_index_payment'];?></h3>
    <h5>订单详情内容可通过查看<a href="index.php?act=member_live" target="_blank">我的订单</a>进行核对处理。</h5>
  </div>
  <form action="index.php?act=show_live_groupbuy&op=payment" method="POST" id="buy_form">
    <input type="hidden" name="order_sn" value="<?php echo $output['order_info']['order_sn'];?>">
    <input type="hidden" id="payment_code" name="payment_code" value="">
    <div class="ncc-receipt-info">
      <div class="ncc-receipt-info-title">
        <h3>请您及时付款，以便订单尽快处理！
          在线支付金额：
			<strong>
				￥
				<?php
					if($output['order_info']['py_amount']>0){
						echo $output['order_info']['price']-$output['order_info']['py_amount'];
					}else{
						echo $output['order_info']['price']; 
					}
				?>
			</strong>
          </h3>
      </div>
      <table class="ncc-table-style">
        <thead>
          <tr>
            <th class="w50"></th>
            <th class="w250 tl">订单号</th>
            <th class="tl">支付方式</th>
            <th class="w150">金额</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td class="tl"><?php echo $output['order_info']['order_sn']; ?></td>
            <td class="tl">在线支付<?php if($output['paymentpart']==1){ echo '(使用预存款部分支付，支付金额 ￥ '.$output['order_info']['py_amount'].')';}?></td>
            <td>￥<?php echo $output['order_info']['price'];?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="ncc-receipt-info">
      <?php if (!isset($output['payment_list'])) {?>
      <?php }else if (empty($output['payment_list'])){?>
      <div class="nopay"><?php echo $lang['cart_step2_paymentnull_1']; ?> <a href="index.php?act=member_message&op=sendmsg&member_id=<?php echo $output['order']['seller_id'];?>"><?php echo $lang['cart_step2_paymentnull_2'];?></a> <?php echo $lang['cart_step2_paymentnull_3'];?></div>
      <?php } else {?>
      <div class="ncc-receipt-info-title">
        <h3>支付选择</h3>
      </div>
      <ul class="ncc-payment-list">
        <?php foreach($output['payment_list'] as $val) { ?>
        <li payment_code="<?php echo $val['payment_code']; ?>">
          <label for="pay_<?php echo $val['payment_code']; ?>">
          <i></i>
          <div class="logo" for="pay_<?php echo $val['payment_id']; ?>"> <img src="<?php echo SHOP_TEMPLATES_URL?>/images/payment/<?php echo $val['payment_code']; ?>_logo.gif" /> </div>
          </label>
        </li>
        <?php } ?>
      </ul>
      <?php } ?>
    </div>
    <div class="ncc-bottom tc mb50"><a href="javascript:void(0);" id="next_button" class="ncc-btn ncc-btn-green"><i class="icon-shield"></i>确认提交支付</a></div>
  </form>
</div>
<script type="text/javascript">
$(function(){
    $('.ncc-payment-list > li').on('click',function(){
    	$('.ncc-payment-list > li').removeClass('using');
        $(this).addClass('using');
        $('#payment_code').val($(this).attr('payment_code'));
    });
    $('#next_button').on('click',function(){
        if ($('#payment_code').val() == '') {
        	showDialog('请选择支付方式', 'error','','','','','','','','',2);return false;
        }
        $('#buy_form').submit();
    });
});
</script>