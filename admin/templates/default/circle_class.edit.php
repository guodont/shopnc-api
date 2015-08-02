<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_classmanage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=circle_class&op=class_list"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=circle_class&op=class_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="class_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="class_id" value="<?php echo $output['class_info']['class_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="class_name"><?php echo $lang['circle_class_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="class_name" id="class_name" class="txt" value="<?php echo $output['class_info']['class_name'];?>" /></td>
          <td class="vatop tips"><?php echo $lang['circle_class_name_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="recommend"><?php echo $lang['circle_class_is_recommend'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="recommend1" class="cb-enable <?php if($output['class_info']['is_recommend'] == '1'){?>selected<?php }?>" ><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="recommend0" class="cb-disable <?php if($output['class_info']['is_recommend'] == '0'){?>selected<?php }?>" ><span><?php echo $lang['nc_no'];?></span></label>
            <input id="recommend1" name="recommend" <?php if($output['class_info']['is_recommend'] == '1'){?>checked="checked"<?php }?> value="1" type="radio">
            <input id="recommend0" name="recommend" <?php if($output['class_info']['is_recommend'] == '0'){?>checked="checked"<?php }?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="status"><?php echo $lang['circle_class_status'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="site_status1" class="cb-enable <?php if($output['class_info']['class_status'] == '1'){?>selected<?php }?>" ><span><?php echo $lang['open'];?></span></label>
            <label for="site_status0" class="cb-disable <?php if($output['class_info']['class_status'] == '0'){?>selected<?php }?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="site_status1" name="status" <?php if($output['class_info']['class_status'] == '1'){?>checked="checked"<?php }?> value="1" type="radio">
            <input id="site_status0" name="status" <?php if($output['class_info']['class_status'] == '0'){?>checked="checked"<?php }?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="class_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="class_sort" id="class_sort" class="txt" value="<?php echo $output['class_info']['class_sort'];?>"></td>
          <td class="vatop tips"><?php echo $lang['circle_class_sort_tips'];?></td>
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
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script>
//按钮先执行验证再提交表单
$(function(){
	$("#submitBtn").click(function(){
		if($("#class_form").valid()){
			$("#class_form").submit();
		}
	});
	$('#class_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	class_name : {
        		required : true,
        		maxlength : 8
        	},
        	class_sort : {
            	digits : true,
            	max : 255
            }
        },
        messages : {
        	class_name : {
        		required : '<?php echo $lang['circle_class_name_not_null'];?>',
        		maxlength : '<?php echo $lang['circle_class_name_maxlength'];?>'
        	},
        	class_sort : {
            	digits : '<?php echo $lang['circle_class_sort_is_number'];?>',
            	max : '<?php echo $lang['circle_class_sort_max'];?>'
            }
        }
    });
});
</script>
