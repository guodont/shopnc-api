<div class="eject_con">
  <div id="warning" class="alert alert-error"></div>
  <form method="post" target="_parent" action="index.php?act=store_brand&op=<?php if ($output['brand_array']['brand_id']!='') echo 'brand_edit'; else echo 'brand_save'; ?>"enctype="multipart/form-data" id="brand_apply_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="brand_id" value="<?php echo $output['brand_array']['brand_id']; ?>" />
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_goods_brand_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" name="brand_name" value="<?php echo $output['brand_array']['brand_name']; ?>" id="brand_name" />
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>名称首字母<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" name="brand_initial" value="<?php echo $output['brand_array']['brand_initial'];?>" id="brand_initial" />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_goods_brand_class'].$lang['nc_colon'];?></dt>
      <dd id="gcategory">
        <input type="hidden" value="<?php echo $output['brand_array']['class_id']?>" name="class_id" class="mls_id">
        <input type="hidden" value="<?php echo $output['brand_array']['brand_class']?>" name="brand_class" class="mls_name">
        <?php if($output['brand_array']['brand_id']!=''){?>
        <span><?php echo $output['brand_array']['brand_class']?></span>
        <input class="edit_gcategory" type="button" value="<?php echo $lang['nc_edit'];?>">
        <?php }?>
        <select <?php if($output['brand_array']['brand_id']!=''){?>style="display:none;"<?php }?>>
          <option value="0"><?php echo $lang['nc_please_choose'];?></option>
          <?php if(!empty($output['gc_list'])){ ?>
          <?php foreach($output['gc_list'] as $k => $v){ ?>
          <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_goods_brand_icon'].$lang['nc_colon'];?></dt>
      <dd>
        <div class=""><span class="sign"><img src="<?php echo brandImage($output['brand_array']['brand_pic']);?>" onload="javascript:DrawImage(this,150,50)" nc_type="logo1"/></span></div>
        <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
          <input type="file" hidefocus="true" size="1" class="input-file" name="brand_pic" id="brand_pic" nc_type="logo"/>
          </span>
          <p><i class="icon-upload-alt"></i>图片上传</p>
          </a> </div>
        <p class="hint"><?php echo $lang['store_goods_brand_upload_tip'];?></p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>"/></label>
    </div>
  </form>
</div>
<script>
$(function(){
	$.getScript('<?php echo RESOURCE_SITE_URL;?>/js/common_select.js', function(){
		gcategoryInit('gcategory');
	});

    jQuery.validator.addMethod("initial", function(value, element) {
        return /^[A-Za-z0-9]$/i.test(value);
    }, "");
    $('#brand_apply_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('brand_apply_form', '', '', 'onerror') 
    	},
        rules : {
            brand_name : {
                required : true,
                rangelength: [0,100]
            },
            brand_initial : {
                initial  : true
            }
			<?php if ($output['brand_array']['brand_id']=='') { ?>
			,
            brand_pic : {
                required : true
			}
			<?php } ?>		
        },
        messages : {
            brand_name : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_brand_input_name'];?>',
                rangelength: '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_brand_name_error'];?>'
            },
            brand_initial : {
                initial : '<i class="icon-exclamation-sign"></i>请填写正确首字母',
            }
			<?php if ($output['brand_array']['brand_id']=='') { ?>
			,
            brand_pic : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_brand_icon_null'];?>'
			}
			<?php } ?>
        }
    });
	$('input[nc_type="logo"]').change(function(){
		var src = getFullPath($(this)[0]);
		$('img[nc_type="logo1"]').attr('src', src);
	});
});

</script> 
