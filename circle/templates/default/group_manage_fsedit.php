<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div id="warning"></div>
  <form id="fsedit_form" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=friendship_edit&c_id=<?php echo $output['c_id'];?>&fs_id=<?php echo $output['fs_id'];?>" method="post" class="base-form-style">
    <input type="hidden" value="ok" name="form_submit">
    <dl>
      <dt><?php echo $lang['circle_name'].$lang['nc_colon'];?></dt>
      <dd> <?php echo $output['friendship_info']['friendship_name'];?> </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['fcircle_sort'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" name="sort" class="w50 text" value="<?php echo $output['friendship_info']['friendship_sort'];?>" />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['circle_tclass_status'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="radio" name="status" value="1" <?php if($output['friendship_info']['friendship_status'] == 1){?>checked="checked"<?php }?> />
        <?php echo $lang['nc_show'];?>&nbsp;
        <input type="radio" name="status" value="0" <?php if($output['friendship_info']['friendship_status'] == 0){?>checked="checked"<?php }?> />
        <?php echo $lang['nc_hide'];?> </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd><a class="submit-btn" nctype="submit-btn" href="Javascript: void(0)"><?php echo $lang['nc_submit'];?></a></dd>
    </dl>
  </form>
</div>
<script type="text/javascript">
var c_id = <?php echo $output['c_id'];?>;
var fs_id = <?php echo $output['fs_id'];?>;
$(function(){
	$('a[nctype="submit-btn"]').click(function(){
		$('#fsedit_form').submit();
	});
    $('#fsedit_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('fsedit_form', '<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=friendship_edit&c_id='+c_id+'$fs_id='+fs_id, '', 'onerror');
    	},
        rules : {
            sort : {
                required : true,
                digits : true,
                max : 255
            }
        },
        messages : {
            sort  : {
                required : '<?php echo $lang['fcircle_sort_not_null'];?>',
                digits : '<?php echo $lang['circle_tclass_sort_is_digits'];?>',
                max : '<?php echo $lang['circle_tclass_sort_max'];?>'
            }
        }
    });
});
</script> 