<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form id="add_form" action="<?php echo urlShop('store_account', 'account_edit_save');?>" method="post">
    <input name="seller_id" value="<?php echo $output['seller_info']['seller_id'];?>" type="hidden" />
    <dl>
      <dt><i class="required">*</i>卖家账号名<?php echo $lang['nc_colon'];?></dt>
      <dd> <?php echo $output['seller_info']['seller_name'];?> <span></span>
        <p class="hint"></p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>账号组<?php echo $lang['nc_colon'];?></dt>
      <dd><select name="group_id">
          <?php foreach($output['seller_group_list'] as $value) { ?>
          <option value="<?php echo $value['group_id'];?>" <?php echo $output['seller_info']['seller_group_id'] == $value['group_id']?'selected':'';?>><?php echo $value['group_name'];?></option>
          <?php } ?>
        </select>
        <span></span>
        <p class="hint"></p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>">
      </label>
    </div>
  </form>
</div>
<script>
$(document).ready(function(){
    $('#add_form').validate({
        onkeyup: false,
        errorPlacement: function(error, element){
            element.nextAll('span').first().after(error);
        },
        rules: {
            group_id: {
                required: true
            }
        },
        messages: {
            group_id: {
                required: '<i class="icon-exclamation-sign"></i>请选择账号组'
            }
        }
    });
});
</script> 
