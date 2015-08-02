<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_domain_manage'];?></h3>
      <ul class="tab-base">
		<li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_config'];?></span></a></li>
        <li><a href="index.php?act=domain&op=store_domain_list"><span><?php echo $lang['nc_domain_shop'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" id="settingForm" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['if_open_domain'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="enabled_subdomain1" class="cb-enable <?php if($output['list_setting']['enabled_subdomain'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="enabled_subdomain0" class="cb-disable <?php if($output['list_setting']['enabled_subdomain'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input type="radio" id="enabled_subdomain1" <?php if($output['list_setting']['enabled_subdomain'] == '1'){ ?>checked="checked"<?php } ?> value="1" name="enabled_subdomain">
            <input type="radio" id="enabled_subdomain0" <?php if($output['list_setting']['enabled_subdomain'] == '0'){ ?>checked="checked"<?php } ?> value="0" name="enabled_subdomain"></td>
          <td class="vatop tips"><?php echo $lang['open_domain_document'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['domain_edit'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="subdomain_edit1" class="cb-enable <?php if($output['list_setting']['subdomain_edit'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="subdomain_edit0" class="cb-disable <?php if($output['list_setting']['subdomain_edit'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input type="radio" id="subdomain_edit1" <?php if($output['list_setting']['subdomain_edit'] == '1'){ ?>checked="checked"<?php } ?> value="1" name="subdomain_edit">
            <input type="radio" id="subdomain_edit0" <?php if($output['list_setting']['subdomain_edit'] == '0'){ ?>checked="checked"<?php } ?> value="0" name="subdomain_edit"></td>
          <td class="vatop tips"><?php echo  $lang['domain_edit_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="subdomain_times"><?php echo $lang['domain_times'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['list_setting']['subdomain_times'];?>" name="subdomain_times" id="subdomain_times" class="txt" style=" width:50px;"></td>
          <td class="vatop tips"><?php echo $lang['domain_times_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="subdomain_reserved"><?php echo $lang['reservations_domain'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['list_setting']['subdomain_reserved'];?>" name="subdomain_reserved" id="subdomain_reserved" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['please_input_domain'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="subdomain_length"><?php echo $lang['length_limit'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['list_setting']['subdomain_length'];?>" name="subdomain_length" id="subdomain_length" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['domain_length'];?></td>
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

<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#settingForm").valid()){
     $("#settingForm").submit();
	}
	});
});
//
$(document).ready(function(){
	jQuery.validator.addMethod("domain_length", function(value, element) {
			var success = this.optional(element) || /^(\d+)[\/-](\d+)$/i.test(value);
			return success && (parseInt(RegExp.$1)<parseInt(RegExp.$2)) && (parseInt(RegExp.$1)>0);
		}, ""); 
	$("#settingForm").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
            subdomain_times : {
                required : true,
                digits   : true,
                min    :1
            },
            subdomain_length : {
                required : true,
                domain_length   : true
            }
        },
        messages : {
            subdomain_times  : {
                required : '<?php echo $lang['domain_times_null'];?>',
                digits   : '<?php echo $lang['domain_times_digits'];?>',
                min    :'<?php echo $lang['domain_times_min'];?>'
            },
            subdomain_length  : {
                required : '<?php echo $lang['domain_length_tips'];?>',
                domain_length   : '<?php echo $lang['domain_length_tips'];?>'
            }
        }
	});
});
</script>
