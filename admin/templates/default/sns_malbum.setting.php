<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_album_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=sns_malbum&op=class_list"><span><?php echo $lang['snsalbum_class_list'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['snsalbum_album_setting'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="form_setting" id="form_setting">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['snsalbum_allow_upload_max_count'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" value="<?php echo $output['list_setting']['malbum_max_sum'];?>" name="malbum_max_sum" id="malbum_max_sum"></td>
          <td class="vatop tips"><?php echo $lang['snsalbum_allow_upload_max_count_tip'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#submitBtn").click(function(){
		if($("#form_setting").valid()){
			$("#form_setting").submit();
		}
	});
	
	$('#form_setting').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
        	malbum_max_sum : {
            	required : true,
            	digits   : true
            }
        },
        messages : {
        	malbum_max_sum  : {
            	required : '<?php echo $lang['snsalbum_pls_input_figures'];?>',
            	digits   : '<?php echo $lang['snsalbum_pls_input_figures'];?>'
            }
        }
    });
});
</script>