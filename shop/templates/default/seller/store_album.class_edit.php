
<div class="eject_con">
  <div id="warning"></div>
  <form id="category_form" method="post" target="_parent" action="index.php?act=store_album&op=album_edit_save">
    <input type="hidden" name="id" value="<?php echo $output['class_info']['aclass_id'];?>" />
    <dl>
      <dt><i class="required">*</i><?php echo $lang['album_class_add_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="w300 text" type="text" name="name" id="name" value="<?php echo $output['class_info']['aclass_name'];?>" />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['album_class_add_des'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea rows="3" class="textarea w300" name="description" id="description"><?php echo $output['class_info']['aclass_des'];?></textarea>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['album_class_add_sort'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text w50" name="sort" id="sort" value="<?php echo $output['class_info']['aclass_sort'];?>" />
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php echo $lang['album_class_add_submit'];?>" />
      </label>
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
        	name : {
                required : true,
                maxlength: 20
            },
            description : {
            	maxlength	: 100
            },
            sort : {
            	digits   : true
            }
        },
        messages : {
        	name : {
                required : '<?php echo $lang['album_class_add_name_null'];?>',
                maxlength	: '<?php echo $lang['album_class_add_name_max'];?>'
            },
            description : {
            	maxlength	: '<?php echo $lang['album_class_add_des_max'];?>'
            },
            sort  : {
            	digits   : '<?php echo $lang['album_class_add_sort_digits'];?>'
            }
        }
    });
});
</script>