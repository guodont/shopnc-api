<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['activity_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=activity&op=activity"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2"><label class="validation" for="activity_title"><?php echo $lang['activity_index_title'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_title" name="activity_title" class="txt"></td>
          <td class="vatop tips"><?php //echo $lang['activity_new_title_tip'];?></td>
        </tr>
        <tr style="display:none;">
          <td colspan="2" class="required"><label class="validation" ><?php echo $lang['activity_index_type'];?>:</label></td>
        </tr>
        <tr class="noborder" style="display:none;">
          <td class="vatop rowform"><select name="activity_type">
              <option value="1"><?php echo $lang['activity_index_goods'];?></option>
              <option value="2"><?php echo $lang['activity_index_group'];?></option>
              </optgroup>
            </select></td>
          <td class="vatop tips"><?php echo $lang['activity_new_type_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" ><?php echo $lang['activity_index_start'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_start_date" name="activity_start_date" class="txt date"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" ><?php echo $lang['activity_index_end'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_end_date" name="activity_end_date" class="txt date"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" ><?php echo $lang['activity_index_banner'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform type-file-box">
              <input type="file" class="type-file-file" id="activity_banner" name="activity_banner" size="30" hidefocus="true"  nc_type="upload_activity_banner" title="<?php echo $lang['activity_index_banner'];?>">
          </td>
          <td class="vatop tips"><?php echo $lang['activity_new_banner_tip'];?></td>
        </tr>
        <tr style="display:none;">
          <td colspan="2" class="required"><label><?php echo $lang['activity_new_style'];?>:</label></td>
        </tr>
        <tr class="noborder" style="display:none;">
          <td class="vatop rowform"><select id="activity_style" name="activity_style">
              <option value="default_style"><?php echo $lang['activity_index_default'];?></option>
            </select></td>
          <td class="vatop tips"><?php echo $lang['activity_new_style_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="activity_desc"><?php echo $lang['activity_new_desc'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="activity_desc" id="activity_desc" rows="6" class="tarea"></textarea></td>
          <td class="vatop tips">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"  for="activity_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_sort" name="activity_sort" class="txt" value="0"></td>
          <td class="vatop tips"><?php echo $lang['activity_new_sort_tip1'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="activity_sort"><?php echo $lang['activity_openstate'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="activity_state1" class="cb-enable selected" ><span><?php echo $lang['activity_openstate_open'];?></span></label>
            <label for="activity_state0" class="cb-disable"><span><?php echo $lang['activity_openstate_close'];?></span></label>
            <input id="activity_state1" name="activity_state" checked="checked" value="1" type="radio">
            <input id="activity_state0" name="activity_state" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/jquery.ui.js";?>"></script> 
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/i18n/zh-CN.js";?>" charset="utf-8"></script> 
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#add_form").valid()){
     $("#add_form").submit();
	}
	});
});
$(document).ready(function(){
	$("#activity_start_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#activity_end_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	activity_title: {
        		required : true
        	},
        	activity_start_date: {
        		required : true,
				date      : false
        	},
        	activity_end_date: {
        		required : true,
				date      : false
        	},
        	activity_banner: {
        		required: true,
				accept : 'png|jpe?g|gif'	
			},
        	activity_sort: {
        		required : true,
        		min:0,
        		max:255
        	}
        },
        messages : {
        	activity_title: {
        		required : '<?php echo $lang['activity_new_title_null'];?>'
        	},
        	activity_start_date: {
        		required : '<?php echo $lang['activity_new_startdate_null'];?>'
        	},
        	activity_end_date: {
        		required : '<?php echo $lang['activity_new_enddate_null'];?>'
        	},
			activity_banner: {
        		required : '<?php echo $lang['activity_new_banner_null'];?>',
				accept   : '<?php echo $lang['activity_new_ing_wrong'];?>'	
			},
        	activity_sort: {
        		required : '<?php echo $lang['activity_new_sort_null'];?>',
        		min:'<?php echo $lang['activity_new_sort_minerror'];?>',
        		max:'<?php echo $lang['activity_new_sort_maxerror'];?>'
        	}
        }
	});
});

$(function(){
// 模拟活动页面横幅Banner上传input type='file'样式
	var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
    $(textButton).insertBefore("#activity_banner");
    $("#activity_banner").change(function(){
	$("#textfield1").val($("#activity_banner").val());
    });
});
</script> 