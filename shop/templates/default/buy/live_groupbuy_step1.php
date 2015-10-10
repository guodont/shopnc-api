<?php defined('InShopNC') or exit('Access Invalid!');?>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/area_array.js"></script>

<div class="ncc-main">
  <div class="ncc-title">
    <h3><?php echo $lang['cart_index_ensure_info'];?></h3>
    <h5>请仔细核对手机号码等信息，以确保抢购券准确发到您的手机。</h5>
  </div>
  <form action="<?php echo urlShop('show_live_groupbuy','livegroupbuystep2');?>" method="POST" id="apply_form" name="apply_form">
    <div class="ncc-receipt-info">
      <div class="ncc-receipt-info-title">
        <h3>联系方式</h3>
      </div>
      <div id="invoice_list" class="ncc-candidate-items">
        <ul>
          <li> 手机号码：
            <input name="mobile" type="text" id="mobile" value="<?php echo $output['member']['member_mobile'];?>" maxlength="11">
          </li>
        </ul>
        <p style="color:orange">请正确输入您的手机号码，确保及时获得“抢购兑换码”。可使用您已经绑定的手机接收或重新输入其它手机号码。</p>
      </div>
    </div>
    <input type="hidden" value="1" name="ifcart">
    <table class="ncc-table-style" nc_type="table_cart">
      <thead>
        <tr>
          <th colspan="3">抢购</th>
          <th class="w120">单价</th>
          <th class="w120">数量</th>
          <th class="w120">总价</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th colspan="20">
			<i class="icon-home"></i>
		  	<?php if(!empty($output['store_info']['live_store_name'])){?>
			<?php echo $output['store_info']['live_store_name']; ?>
			<?php }else{?>
			<a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$output['store_info']['store_id']));?>" target="_blank"><?php echo $output['store_info']['store_name'];?></a>
			<?php }?>
		  <span></span>
		 </th>
        </tr>
        <tr>
          <td class="w10"></td>
          <td class="w60"><a class="ncc-goods-thumb" target="_blank" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$output['live_groupbuy']['groupbuy_id']));?>"> <img alt="<?php echo $output['live_groupbuy']['groupbuy_name'];?>" src="<?php echo lgthumb($output['live_groupbuy']['groupbuy_pic'],'small');?>"> </a></td>
          <td class="tl"><a target="_blank" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$output['live_groupbuy']['groupbuy_id']));?>"><?php echo $output['live_groupbuy']['groupbuy_name'];?></a></td>
          <td><span id="deal-buy-price"><?php echo $output['live_groupbuy']['groupbuy_price'];?></span></td>
          <td><?php echo $output['q_number'];?></td>
          <td><span id="deal-buy-total"><?php echo ncPriceFormat($output['q_number']*$output['live_groupbuy']['groupbuy_price']);?></span></td>
        </tr>
        
		<tr>
			<td class="w10"></td>
			<td class="tl" colspan="2">买家留言：
				<input type="text" value="" class="text w340" name="leave_message" maxlength="150">&nbsp;</td>
			<td class="tl" colspan="10"><div class="ncc-form-default"> </div></td>
		</tr>
        <!-- S 预存款 -->
        <?php if (!empty($output['member']['available_predeposit']) && $output['member']['available_predeposit']>0) { ?>
        <tr id="pd_panel">
          <td class="pd-account" colspan="20"><div class="ncc-pd-account">
              <div class="mt5 mb5">
                <label>
                  <input type="checkbox" checked class="vm mr5" value="1" name="pd_pay">
                  使用预存款支付（当前可用余额：<em>￥<?php echo $output['member']['available_predeposit'];?></em>）</label>
              </div>
              <div id="pd_password">支付密码：
                <input type="password" class="text w120" value="" name="password" id="password" maxlength="35">
                <input type="hidden" value="" name="password_callback" id="password_callback">
                <a class="ncc-btn-mini ncc-btn-orange" id="pd_pay_submit" href="javascript:void(0)">使用</a>
                <?php if (!$output['member']['member_paypwd']) {?>
                还未设置支付密码，<a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_security&op=auth&type=modify_paypwd" target="_blank">马上设置</a>
                <?php } ?>
              </div>
            </div></td>
        </tr>
        <?php } ?>
        <!-- E 预存款 -->
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"><div class="ncc-all-account">订单总额：￥<em id="payment"><?php echo ncPriceFormat($output['q_number']*$output['live_groupbuy']['groupbuy_price']);?></em>元</div></td>
        </tr>
      </tfoot>
    </table>
    <input type="hidden" name="groupbuy_id" value="<?php echo $output['live_groupbuy']['groupbuy_id'];?>">
    <input type="hidden" name="number" value="<?php echo $output['q_number'];?>">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncc-bottom"> <a href="javascript:void(0)" id='submitOrder' class="ncc-btn ncc-btn-acidblue fr"><?php echo $lang['cart_index_submit_order'];?></a> </div>
  </form>
</div>
<script type="text/javascript">
$(function(){
	jQuery.validator.addMethod("phones", function(value, element) {
		return this.optional(element) || /^[1][3-8]+\d{9}/i.test(value);
	}, "phone number please"); 

	$('#apply_form').validate({
		rules:{
			mobile:{
				required:true,
				phones:true
			}
		},
		messages:{
			mobile:{
				required:'手机号不能为空',
				phones:'请填写正确的手机格式'
			}
		}
	});

	<?php if (!empty($output['member']['available_predeposit'])) { ?>
    $('input[name="pd_pay"]').on('change',function(){
        if ($(this).attr('checked')) {
        	$('#password').val('');
        	$('#password_callback').val('');
            $('#pd_password').show();
        } else {
        	$('#pd_password').hide();
        }
    });

    $('#pd_pay_submit').on('click',function(){
        if ($('#password').val() == '') {
        	showDialog('请输入支付密码', 'error','','','','','','','','',2);return false;
        }
        $('#password_callback').val('');
		$.get("index.php?act=show_live_groupbuy&op=check_pd_pwd", {'password':$('#password').val()}, function(data){
            if (data == '1') {
            	$('#password_callback').val('1');
            	$('#pd_password').hide();
            } else {
            	$('#password').val('');
            	showDialog('密码错误', 'error','','','','','','','','',2);
            }
        });
    });
    <?php } ?>

	$('#submitOrder').click(function(){
		$('#submitOrder').click(submitNext());
	});

	function submitNext(){
		if ($('input[name="pd_pay"]').attr('checked') && $('#password_callback').val() != '1') {
			showDialog('使用预存款支付，需输入支付密码并使用  ', 'error','','','','','','','','',2);
			return;
		}
		$('#apply_form').submit();
	}
});
</script>