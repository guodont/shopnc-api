<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div id="warning"></div>
  <form id="addclass_form" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=class_edit&c_id=<?php echo $output['c_id'];?>" method="post" class="base-form-style">
    <input type="hidden" value="ok" name="form_submit">
    <input type="hidden" name="thc_id" value="<?php echo $output['thclass_info']['thclass_id'];?>" />
    <dl>
      <dt><?php echo $lang['circle_tclass_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" name="name" class="w200 text" value="<?php echo $output['thclass_info']['thclass_name'];?>" />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['circle_tclass_sort'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" name="sort" class="w50 text" value="<?php echo $output['thclass_info']['thclass_sort'];?>" />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['circle_tclass_status'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="radio" name="status" value="1" <?php if($output['thclass_info']['thclass_status'] == 1){?>checked="checked"<?php }?> />
        <?php echo $lang['nc_yes'];?>&nbsp;
        <input type="radio" name="status" value="0" <?php if($output['thclass_info']['thclass_status'] == 0){?>checked="checked"<?php }?> />
        <?php echo $lang['nc_no'];?> </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd><a class="submit-btn" nctype="submit-btn" href="Javascript: void(0)"><?php echo $lang['nc_submit'];?></a></dd>
    </dl>
  </form>
</div>
<script type="text/javascript">
$(function(){
	$('a[nctype="submit-btn"]').click(function(){
		$('#addclass_form').submit();
	});
    $('#addclass_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('addclass_form', '<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=class_edit&c_id=<?php echo $output['c_id'];?>', '', 'onerror');
    	},
        rules : {
        	name : {
                required : true,
            	maxlength : 4
            },
            sort : {
                required : true,
                digits : true,
                max : 255
            }
        },
        messages : {
        	name : {
                required : '<?php echo $lang['circle_tclass_name_not_null'];?>',
            	maxlength : '<?php echo $lang['circle_tclass_man_maxlength'];?>'

            },
            sort  : {
                required : '<?php echo $lang['circle_tclass_sort_not_null'];?>',
                digits : '<?php echo $lang['circle_tclass_sort_is_digits'];?>',
                max : '<?php echo $lang['circle_tclass_sort_max'];?>'
            }
        }
    });
});
</script> 