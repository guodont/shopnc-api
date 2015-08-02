<?php if($output['class_count'] <20){?>

<div class="eject_con">
  <div id="warning" class="alert alert-error"></div>
  <form id="category_form" method="post" target="_parent" action="index.php?act=store_album&op=album_add_save">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><i class="required">*</i><?php echo $lang['album_class_add_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="w300 text" type="text" name="name" id="name" value="" />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['album_class_add_des'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea class="w300 textarea" rows="3" name="description" id="description"></textarea>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['album_class_add_sort'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="w50 text" type="text" name="sort" id="sort" value="" />
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php echo $lang['album_class_add_submit'];?>" />
      </label>
    </div>
  </form>
</div>
<?php }else{?>
<div class="warning-option"><i class="icon-warning-sign">&nbsp;</i><span><?php echo $lang['album_class_add_max_20'];?></span></div>
<?php }?>
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
                maxlength	: 20,
                remote   : {
                    url :'index.php?act=store_album&op=ajax_check_class_name&column=ok',
                    type:'get',
                    data:{
                        ac_name : function(){
                            return $('#name').val();
                        }
                    }
                }
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
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['album_class_add_name_null'];?>',
                maxlength	: '<i class="icon-exclamation-sign"></i><?php echo $lang['album_class_add_name_max'];?>',
                remote		: '<i class="icon-exclamation-sign"></i><?php echo $lang['album_class_add_name_repeat'];?>'
            },
            description : {
            	maxlength	: '<i class="icon-exclamation-sign"></i><?php echo $lang['album_class_add_des_max'];?>'
            },
            sort  : {
            	digits   : '<i class="icon-exclamation-sign"></i><?php echo $lang['album_class_add_sort_digits'];?>'
            }
        }
    });
});
</script> 
