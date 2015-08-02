<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <?php if ($output['menu_key'] == 'booth_quota_add') {?>
  <form id="add_form" action="<?php echo urlShop('store_promotion_booth', 'booth_quota_add');?>" method="post">
  <?php } else {?>
  <form id="add_form" action="<?php echo urlShop('store_promotion_booth', 'booth_renew');?>" method="post">
  <?php }?>
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><i class="required">*</i>套餐购买数量：</dt>
      <dd>
        <input id="booth_quota_quantity" name="booth_quota_quantity" type="text" class="text w50"/><em class="add-on">月</em><span></span>
        <p class="hint">购买单位为月(30天)，一次最多购买12个月，购买后立即生效，即可添加推荐商品。</p>
        <p class="hint"><?php printf('每月您需要支付%d元。', intval(C('promotion_booth_price')));?></p>
        <p class="hint"><strong style="color: red">相关费用会在店铺的账期结算中扣除</strong></p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input id="submit_button" type="submit" value="<?php echo $lang['nc_submit'];?>" class="submit"></label>
    </div>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    //页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			var error_td = element.parent('dd').children('span');
			error_td.append(error);
		},
		submitHandler:function(form){
			var unit_price = parseInt(<?php echo C('promotion_booth_price');?>);
			var quantity = parseInt($("#booth_quota_quantity").val());
			var price = unit_price * quantity;
			showDialog('确认购买?您总共需要支付'+price+'元', 'confirm', '', function(){ajaxpost('add_form', '', '', 'onerror');});
		},
		rules : {
			booth_quota_quantity : {
				required : true,
				digits : true,
				range : [1,12]
			}
		},
		messages : {
			booth_quota_quantity : {
				required : '<i class="icon-exclamation-sign"></i>套餐购买数量不能为空，且必须为1~12之间的整数',
				digits : '<i class="icon-exclamation-sign"></i>套餐购买数量不能为空，且必须为1~12之间的整数',
				range : '<i class="icon-exclamation-sign"></i>套餐购买数量不能为空，且必须为1~12之间的整数'
			}
		}
	});
});
</script> 
