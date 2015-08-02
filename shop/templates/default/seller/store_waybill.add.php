<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form id="add_form" action="<?php echo urlShop('store_waybill', 'waybill_save');?>" method="post" enctype="multipart/form-data">
    <?php if($output['waybill_info']) { ?>
    <input type="hidden" name="waybill_id" value="<?php echo $output['waybill_info']['waybill_id'];?>">
    <input type="hidden" name="old_waybill_image" value="<?php echo $output['waybill_info']['waybill_image'];?>">
    <?php } ?>
    <dl>
      <dt><i class="required">*</i>模板名称<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input type="text" value="<?php echo $output['waybill_info']?$output['waybill_info']['waybill_name']:'';?>" name="waybill_name" id="waybill_name" class="w120 text">
        <span></span>
        <p class="hint">运单模板名称，最多10个字</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>物流公司<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <select name="waybill_express">
          <?php if(!empty($output['express_list']) && is_array($output['express_list'])) {?>
          <?php foreach($output['express_list'] as $value) {?>
          <option value="<?php echo $value['id'];?>|<?php echo $value['e_name'];?>" <?php if($value['selected']) { echo 'selected'; }?> ><?php echo $value['e_name'];?></option>
          <?php } ?>
          <?php } ?>
        </select>
        <span></span>
        <p class="hint">模板对应的物流公司</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>宽度<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input type="text" value="<?php echo $output['waybill_info']?$output['waybill_info']['waybill_width']:'';?>" name="waybill_width" id="waybill_width" class="w60 text"><em class="add-on">mm</em>
        <span></span>
        <p class="hint">运单宽度，单位为毫米(mm)</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>高度<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input type="text" value="<?php echo $output['waybill_info']?$output['waybill_info']['waybill_height']:'';?>" name="waybill_height" id="waybill_height" class="w60 text"><em class="add-on">mm</em>
        <span></span>
        <p class="hint">运单高度，单位为毫米(mm)</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>上偏移量<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input type="text" value="<?php echo $output['waybill_info']?$output['waybill_info']['waybill_top']:'0';?>" name="waybill_top" id="waybill_top" class="w60 text"><em class="add-on">mm</em>
        <span></span>
        <p class="hint">运单模板上偏移量，单位为毫米(mm)</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>左偏移量<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input type="text" value="<?php echo $output['waybill_info']?$output['waybill_info']['waybill_left']:'0';?>" name="waybill_left" id="waybill_left" class="w60 text"><em class="add-on">mm</em>
        <span></span>
        <p class="hint">运单模板左偏移量，单位为毫米(mm)</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>模板图片<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <?php if($output['waybill_info']) { ?>
        <img width="500" src="<?php echo $output['waybill_info']['waybill_image_url'];?>">
        <?php } ?>
        <input name="waybill_image" type="file" class="type-file-file" >
        <span></span>
        <p class="hint">请上传扫描好的运单图片，图片尺寸必须与快递单实际尺寸相符</p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>启用<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <?php
        if(!empty($output['waybill_info']) && $output['waybill_info']['waybill_usable'] == '1') { 
            $usable = 1;
        } else {
            $usable = 0;
        }
        ?>
        <ul class="ncsc-form-radio-list"><li><label for="waybill_usable_1"><input id="waybill_usable_1" type="radio" name="waybill_usable" value="1" <?php echo $usable ? 'checked' : '';?>>
        是</label></li>
        <li><label for="waybill_usable_0"><input id="waybill_usable_0" type="radio" name="waybill_usable" value="0" <?php echo $usable ? '' : 'checked';?>>
        否</label></li></ul>
        <span></span>
        <p class="hint">请首先设计并测试模板然后再启用，启用后商家可以使用</p>
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
	$("#waybill_image").change(function(){
		$("#waybill_image_name").val($(this).val());
	});

    $("#submit").click(function(){
        $("#add_form").submit();
    });
    $('#add_form').validate({
        onkeyup: false,
        errorPlacement: function(error, element){
            element.nextAll('span').first().after(error);
        },
        submitHandler:function(form){
            ajaxpost('add_form', '', '', 'onerror');
        },
        rules : {
            waybill_name: {
                required : true,
                maxlength : 10
            },
            waybill_width: {
                required : true,
                digits: true 
            },
            waybill_height: {
                required : true,
                digits: true 
            },
            waybill_top: {
                required : true,
                number: true 
            },
            waybill_left: {
                required : true,
                number: true 
            },
            waybill_image: {
                <?php if(!$output['waybill_info']) { ?>
                required : true,
                <?php } ?>
                accept: "jpg|jpeg|png"
            }
        },
        messages : {
            waybill_name: {
                required : "<i class="icon-exclamation-sign"></i>模板名称不能为空",
                maxlength : "<i class="icon-exclamation-sign"></i>模板名称最多10个字" 
            },
            waybill_width: {
                required : "<i class="icon-exclamation-sign"></i>宽度不能为空",
                digits: "<i class="icon-exclamation-sign"></i>宽度必须为数字"
            },
            waybill_height: {
                required : "<i class="icon-exclamation-sign"></i>高度不能为空",
                digits: "<i class="icon-exclamation-sign"></i>高度必须为数字"
            },
            waybill_top: {
                required : "<i class="icon-exclamation-sign"></i>上偏移量不能为空",
                number: "<i class="icon-exclamation-sign"></i>上偏移量必须为数字"
            },
            waybill_left: {
                required : "<i class="icon-exclamation-sign"></i>左偏移量不能为空",
                number: "<i class="icon-exclamation-sign"></i>左偏移量必须为数字"
            },
            waybill_image: {
                <?php if(!$output['waybill_info']) { ?>
                required : '<i class="icon-exclamation-sign"></i>图片不能为空',
                <?php } ?>
                accept: '<i class="icon-exclamation-sign"></i>图片类型不正确' 
            }
        }
    });
});
</script> 
