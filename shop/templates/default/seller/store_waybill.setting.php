<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form id="add_form" action="<?php echo urlShop('store_waybill', 'waybill_setting_save');?>" method="post">
    <input type="hidden" name="store_waybill_id" value="<?php echo $output['store_waybill_id'];?>">
    <dl>
      <dt><i class="required">*</i>左偏移<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w60 text" name="store_waybill_left" type="text" value="<?php echo $output['store_waybill_left'];?>" /><em class="add-on">mm</em> <span></span>
        <p class="hint">打印模板左偏移</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>上偏移<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w60 text" name="store_waybill_top" type="text" value="<?php echo $output['store_waybill_top'];?>" /><em class="add-on">mm</em> <span></span>
        <p class="hint">打印模板上偏移</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>显示项目<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <?php if(!empty($output['store_waybill_data']) && is_array($output['store_waybill_data'])) {?>
        <ul class="ncsc-form-checkbox-list">
          <?php foreach($output['store_waybill_data'] as $key => $value) {?>
          <li>
            <input id="<?php echo $key;?>" type="checkbox" class="checkbox" name="data[<?php echo $key;?>]" <?php echo $value['show']?'checked':'';?>>
            <label for="<?php echo $key;?>"><?php echo $value['item_text'];?></label>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>
        <p class="hint">选中需要打印的项目，未勾选的将不会被打印</p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>">
      </label>
    </div>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#add_form').validate({
        onkeyup: false,
        errorPlacement: function(error, element){
            element.nextAll('span').first().after(error);
        },
        submitHandler:function(form){
            ajaxpost('add_form', '', '', 'onerror');
        },
        rules: {
            store_waybill_left: {
                required: true,
                number: true
            },
            store_waybill_top: {
                required: true,
                number: true
            }
        },
        messages: {
            store_waybill_left: {
                required: '<i class="icon-exclamation-sign"></i>上偏移不能为空',
                number: '<i class="icon-exclamation-sign"></i>上偏移必须为数字' 
            },
            store_waybill_top: {
                required: '<i class="icon-exclamation-sign"></i>上偏移不能为空',
                number: '<i class="icon-exclamation-sign"></i>上偏移必须为数字' 
            }
        }
    });
});
</script> 
