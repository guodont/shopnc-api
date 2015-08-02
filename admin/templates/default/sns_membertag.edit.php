<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['sns_member_tag'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=sns_member&op=member_tag"><span><?php echo $lang['sns_member_tag_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
<div class="fixed-empty"></div>
  <form id="membertag_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="id" value="<?php echo $output['mtag_info']['mtag_id'];?>" />
    <input type="hidden" name="old_membertag_name" value="<?php echo $output['mtag_info']['mtag_img'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="membertag_name"><?php echo $lang['sns_member_tag_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['mtag_info']['mtag_name'];?>" name="membertag_name" id="membertag_name" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['sns_member_tag_name_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_recommend'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="mtag_recommend1" class="cb-enable <?php if($output['mtag_info']['mtag_recommend'] == 1){?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="mtag_recommend0" class="cb-disable <?php if($output['mtag_info']['mtag_recommend'] == 0){?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="mtag_recommend1" name="membertag_recommend" <?php if($output['mtag_info']['mtag_recommend'] == 1){?>checked="checked"<?php }?> value="1" type="radio">
            <input id="mtag_recommend0" name="membertag_recommend" <?php if($output['mtag_info']['mtag_recommend'] == 0){?>checked="checked"<?php }?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['sns_member_tag_recommend_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="mtag_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['mtag_info']['mtag_sort'];?>" name="membertag_sort" id="mtag_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['sns_member_tag_sort_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['sns_member_tag_desc'];?>:</label></td>
        </tr>
        <tr class="noborder" style="background: none repeat scroll 0% 0% rgb(251, 251, 251);">
          <td class="vatop rowform">
            <textarea class="tarea" rows="6" name="membertag_desc" id="membertag_desc"><?php echo $output['mtag_info']['mtag_desc'];?></textarea>
          </td>
          <td class="vatop tips"><?php echo $lang['sns_member_tag_desc_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['sns_member_tag_img'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/membertag/'.($output['mtag_info']['mtag_img'] != ''?$output['mtag_info']['mtag_img']:'default_tag.gif');?>"></div>
            </span><span class="type-file-box">
            <input name="membertag_img" type="file" class="type-file-file" id="membertag_img" size="30" hidefocus="true">
            </span></td>
          <td class="vatop tips"><?php echo $lang['sns_member_tag_img_tips'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
$(function(){
	var textButton1="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
	$(textButton1).insertBefore("#membertag_img");
	$("#membertag_img").change(function(){$("#textfield1").val($("#membertag_img").val());});

	$("#submitBtn").click(function(){
		if($("#membertag_form").valid()){
			$("#membertag_form").submit();
		}
	});
	
	$('#membertag_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
        	membertag_name : {
                required : true,
                maxlength : 20
            },
            membertag_sort : {
            	digits   : true
            },
            membertag_desc :{
				maxlength : 50
            }
        },
        messages : {
        	membertag_name : {
                required : '<?php echo $lang['sns_member_tag_name_null_error'];?>',
                maxlength : '<?php echo $lang['sns_member_tag_name_max_error'];?>'
            },
            membertag_sort : {
            	digits   : '<?php echo $lang['sns_member_tag_sort_error'];?>'
            },
            membertag_desc :{
				maxlength : '<?php echo $lang['sns_member_tag_desc_max_error'];?>'
            }
        }
    });
});
</script>