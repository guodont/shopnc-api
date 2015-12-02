<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con group_apply">
  <div id="member_warning"></div>
  <form id="memberedit" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&op=group_memberedit&c_id=<?php echo $output['c_id'];?>" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><?php echo $lang['circle_self_introduction'];?></dt>
      <dd>
        <h4><i class="b"></i><?php echo $lang['circle_introduction_desc'];?></h4>
        <h5><?php echo $lang['circle_introduction_example'];?></h5>
        <textarea name="intro" class="textarea"><?php echo $output['member_info']['cm_intro'];?></textarea>
      </dd>
    </dl>
    <div class="bottom"> <a class="submit-btn" nctype="apply_submit" href="Javascript: void(0)"><?php echo $lang['nc_submit'];?></a><a class="cancel-btn" nctype="apply_cancel" href="Javascript: void(0)"><?php echo $lang['nc_cancel'];?></a>
    </div>
  </form>
</div>
<script type="text/javascript">
$(function(){
	$('a[nctype="apply_submit"]').click(function(){
   	 if($("#memberedit").valid()){
    	    $("#memberedit").submit();
   		}
	});
	$('a[nctype="apply_cancel"]').click(function(){
		DialogManager.close('memberedit');
	});
    $('#memberedit').validate({
        errorLabelContainer: $('#member_warning'),
        invalidHandler: function(form, validator) {
               $('#member_warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('memberedit', '<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&op=group_memberedit&c_id=<?php echo $output['c_id'];?>', '', 'onerror') 
    	},
        rules : {
            intro : {
                required : true,
            	maxlength : 140
            }
        },
        messages : {
            intro  : {
                required : '<?php echo $lang['circle_introduction_not_null'];?>',
            	maxlength : '<?php echo $lang['circle_introduction_maxlength'];?>'
            }
        }
    });
});
</script> 