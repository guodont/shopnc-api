<div class="eject_con">
  <div id="warning" class="alert alert-error"></div>
  <form id="category_form" method="post" target="_parent" action="index.php?act=store_goods_class&op=goods_class_save">
    <?php if ($output['class_info']['stc_id']!=0) { ?>
    <input type="hidden" name="stc_id" value="<?php echo $output['class_info']['stc_id']; ?>" />
    <?php } ?>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_goods_class_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="text w200" type="text" name="stc_name" id="stc_name" value="<?php echo $output['class_info']['stc_name']; ?>" />
      </dd>
    </dl>
    <?php if ($output['class_info']['stc_id']==0) { ?>
    <dl>
      <dt><?php echo $lang['store_goods_class_sup_class'].$lang['nc_colon'];?></dt>
      <dd>
        <select name="stc_parent_id" id="stc_parent_id">
          <option><?php echo $lang['store_create_please_choose'];?></option>
          <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
          <?php foreach ($output['goods_class'] as $val) { ?>
          <option value="<?php echo $val['stc_id']; ?>" <?php if ($val['stc_id'] == $output['class_info']['stc_parent_id']) { ?>selected="selected"<?php } ?>><?php echo $val['stc_name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </dd>
    </dl>
    <?php } ?>
    <dl>
      <dt><?php echo $lang['store_goods_class_sort'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="text w60" type="text" name="stc_sort" value="<?php echo intval($output['class_info']['stc_sort']); ?>"  />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_goods_class_display_state'].$lang['nc_colon'];?></dt>
      <dd>
        <label>
          <input type="radio" name="stc_state" value="1" <?php if ($_GET['class_id']=='' or $output['class_info']['stc_state']==1) echo 'checked="checked"'; ?> />
          <?php echo $lang['store_create_yes'];?></label>
        <label>
          <input type="radio" name="stc_state" value="0" <?php if ($output['class_info']['stc_state']==0 and $_GET['class_id']!='') echo 'checked="checked"'; ?> />
          <?php echo $lang['store_create_no'];?></label>
      </dd>
    </dl>
    <div class="bottom">
        <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['store_goods_class_submit'];?>" /></label>
    </div>
  </form>
</div>
<script type="text/javascript">
$(function(){
    $('#category_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('category_form', '', '', 'onerror') 
    	},
        rules : {
            stc_name : {
                required : true
            },
            stc_sort : {
                number   : true
            }
        },
        messages : {
            stc_name : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_class_name_null'];?>'

            },
            stc_sort  : {
                number   : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_class_input_int'];?>'
            }
        }
    });
});
</script> 
