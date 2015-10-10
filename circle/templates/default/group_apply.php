<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con group_apply">
  <div id="apply_warning"></div>
  <form id="apply_form" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&op=apply&c_id=<?php echo $output['c_id'];?>" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><?php echo $lang['circle_apply_to_join'].$lang['nc_quote1'].$output['circle_info']['circle_name'].$lang['nc_quote1'].$lang['circle_of_reason'];?></dt>
      <dd>
        <h4><i class="a"></i><?php echo $lang['circle_join_tips_h4'];?></h4>
        <h5><?php echo $lang['circle_join_tips_h5'];?></h5>
        <textarea name="apply_content" class="textarea"></textarea>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['circle_newbie_introduction'];?></dt>
      <dd>
        <h4><i class="b"></i><?php echo $lang['circle_introduction_desc'];?></h4>
        <h5><?php echo $lang['circle_introduction_example'];?></h5>
        <textarea name="intro" class="textarea"></textarea>
      </dd>
    </dl>
    <div class="bottom"> <a class="submit-btn" nctype="apply_submit" href="Javascript: void(0)"><?php echo $lang['circle_submit_applications'];?></a><a class="cancel-btn" nctype="apply_cancel" href="Javascript: void(0)"><?php echo $lang['nc_cancel'];?></a>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script> 
<script type="text/javascript">
$(function(){
	$('a[nctype="apply_submit"]').click(function(){
   	 if($("#apply_form").valid()){
    	    $("#apply_form").submit();
   		}
	});
	$('a[nctype="apply_cancel"]').click(function(){
		DialogManager.close('apply_join');
	});
    $('#apply_form').validate({
        errorLabelContainer: $('#apply_warning'),
        invalidHandler: function(form, validator) {
               $('#apply_warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('apply_form', '<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&op=apply&c_id=<?php echo $output['c_id'];?>', '', 'onerror');
    	},
        rules : {
        	apply_content : {
                required : true,
            	maxlength : 140
            },
            intro : {
                required : true,
            	maxlength : 140
            }
        },
        messages : {
        	apply_content : {
                required : '<?php echo $lang['circle_apply_content_null'];?>',
            	maxlength : '<?php echo $lang['circle_apply_content_maxlength'];?>'

            },
            intro  : {
                required : '<?php echo $lang['circle_introduction_not_null'];?>',
            	maxlength : '<?php echo $lang['circle_introduction_maxlength'];?>'
            }
        }
    });
});
</script> 