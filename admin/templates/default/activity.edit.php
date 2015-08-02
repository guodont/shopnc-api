<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['activity_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=activity&op=activity"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=activity&op=new"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="activity_id" value="<?php echo $output['activity']['activity_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="activity_title"><?php echo $lang['activity_index_title'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_title" name="activity_title" class="txt" value="<?php echo $output['activity']['activity_title'];?>"></td>
          <td class="vatop tips"></td>
          
        </tr>
        <tr style="display:none;">
          <td colspan="2" class="required"><label for="activity_type"><?php echo $lang['activity_index_type'];?>:</label></td>
        </tr>
        <tr class="noborder" style="display:none;">
          <td class="vatop rowform"><select name="activity_type" id="activity_type">
              <option value="1" <?php if($output['activity']['activity_type']=='1'){?>selected<?php }?>><?php echo $lang['activity_index_goods'];?></option>
              <option value="2" <?php if($output['activity']['activity_type']=='2'){?>selected<?php }?>><?php echo $lang['activity_index_group'];?></option>
            </select></td>
          <td class="vatop tips"><?php echo $lang['activity_new_type_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="activity_start_date"><?php echo $lang['activity_index_start'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_start_date" class="txt date" name="activity_start_date" value="<?php echo date('Y-m-d',$output['activity']['activity_start_date']);?>"/></td>
          <td class="vatop tips"></td>
          
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="activity_end_date"><?php echo $lang['activity_index_end'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_end_date" class="txt date" name="activity_end_date" value="<?php if(!empty($output['activity']['activity_end_date']))echo date('Y-m-d',$output['activity']['activity_end_date']);?>"/></td>
          <td class="vatop tips"></td>
          
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="activity_banner"><?php echo $lang['activity_index_banner'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
          	<span class="type-file-show">
          		<img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png" />
          		<div class="type-file-preview"><img src="<?php if(is_file(BASE_UPLOAD_PATH.DS.ATTACH_ACTIVITY.DS.$output['activity']['activity_banner'])){echo UPLOAD_SITE_URL."/".ATTACH_ACTIVITY."/".$output['activity']['activity_banner'];}else{echo ADMIN_SITE_URL."/templates/".TPL_NAME."/images/sale_banner.jpg";}?>" onload="javascript:DrawImage(this,500,500);"></div>
            </span>
            <span class="type-file-box">
            	<input type="file" class="type-file-file" id="activity_banner" name="activity_banner" size="30" hidefocus="true"  nc_type="upload_activity_banner" title="<?php echo $lang['activity_index_banner'];?>">
            </span>
          </td>
          <td class="vatop tips"><?php echo $lang['activity_new_banner_tip'];?></td>
        </tr>
        <tr style="display:none;">
          <td colspan="2" class="required"><label for="activity_style"><?php echo $lang['activity_new_style'];?>:</label></td>
        </tr>
        <tr class="noborder" style="display:none;">
          <td class="vatop rowform"><select id="activity_style" name="activity_style">
              <option value="default_style" <?php if($output['activity']['activity_style']=="default_style"){?>selected<?php }?>><?php echo $lang['activity_index_default'];?></option>
            </select></td>
          <td class="vatop tips"><?php echo $lang['activity_new_style_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="activity_desc"><?php echo $lang['activity_new_desc'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="activity_desc" rows="6" class="tarea" id="activity_desc"><?php echo nl2br($output['activity']['activity_desc']);?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="activity_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_sort" name="activity_sort" class="txt" value="<?php if($output['activity']['activity_sort']==''){?>255<?php }elseif($output['activity']['activity_sort']=='0'){ echo '0';}else{ echo $output['activity']['activity_sort'];}?>"></td>
          <td class="vatop tips"><?php echo $lang['activity_new_sort_tip1'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="activity_sort"><?php echo $lang['activity_openstate'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="activity_state1" class="cb-enable <?php echo $output['activity']['activity_state'] == 1?'selected':'';?>" ><span><?php echo $lang['activity_openstate_open'];?></span></label>
            <label for="activity_state0" class="cb-disable <?php echo $output['activity']['activity_state'] == 0?'selected':'';?>"><span><?php echo $lang['activity_openstate_close'];?></span></label>
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
	$("#activity_start_date").datepicker();
	$("#activity_end_date").datepicker();
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