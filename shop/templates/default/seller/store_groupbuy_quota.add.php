<?php defined('InShopNC') or exit('Access Invalid!'); ?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form id="add_form" action="<?php echo urlShop('store_groupbuy', 'groupbuy_quota_add_save');?>" method="post">
    <dl>
      <dt><i class="required">*</i>购买数量</dt>
      <dd>
          <input id="groupbuy_quota_quantity" name="groupbuy_quota_quantity" type="text" class="text w30" /><em class="add-on">月</em><span></span>
        <p class="hint">购买单位为月(30天)，您可以在所购买的周期内发布抢购活动</p>
        <p class="hint"><?php echo '每月(30天)您需要支付'.$output['setting_config']['groupbuy_price'].$lang['nc_yuan'];?> ; </p>
        <p class="hint"><strong style="color: red">相关费用会在店铺的账期结算中扣除</strong></p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input id="submit_button" type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>"></label>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
    	submitHandler:function(form){
            var unit_price = <?php echo C('groupbuy_price');?>;
            var quantity = $("#groupbuy_quota_quantity").val();
            var price = unit_price * quantity;
            showDialog('确认购买？您总共需要支付'+price+'<?php echo $lang['nc_yuan'];?>', 'confirm', '', function(){
            	ajaxpost('add_form', '', '', 'onerror');
            	});
    	},
        rules : {
            groupbuy_quota_quantity : {
                required : true,
                digits : true,
                min : 1
            }
        },
        messages : {
            groupbuy_quota_quantity : {
                required : "<i class='icon-exclamation-sign'></i>数量不能为空且必须为数字",
                digits : "<i class='icon-exclamation-sign'></i>数量不能为空且必须为数字",
                min : "<i class='icon-exclamation-sign'></i>数量不能为空且必须为数字"
            }
        }
    });
});
</script>
