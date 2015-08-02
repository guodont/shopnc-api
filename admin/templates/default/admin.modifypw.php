<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <form id="admin_form" method="post" action='index.php?act=index&op=modifypw' name="adminForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="old_pw"><?php echo $lang['index_modifypw_oldpw']; ?><!-- 原密码 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="old_pw" name="old_pw" class="infoTableInput" type="password"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="new_pw"><?php echo $lang['index_modifypw_newpw']; ?><!-- 新密码 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="new_pw" name="new_pw" class="infoTableInput" type="password"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="new_pw2"><?php echo $lang['index_modifypw_newpw2']; ?><!-- 确认密码-->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="new_pw2" name="new_pw2" class="infoTableInput" type="password"></td>
          <td class="vatop tips"></td>
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
    if($("#admin_form").valid()){
     $("#admin_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$("#admin_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	old_pw : {
        		required : true
            },
        	new_pw : {
                required : true,
				minlength: 6,
				maxlength: 20
            },
            new_pw2 : {
                required : true,
				minlength: 6,
				maxlength: 20,
				equalTo: '#new_pw'
            }
        },
        messages : {
        	old_pw : {
        		required : '<?php echo $lang['admin_add_password_null'];?>'
            },
        	new_pw : {
                required : '<?php echo $lang['admin_add_password_null'];?>',
				minlength: '<?php echo $lang['admin_add_password_max'];?>',
				maxlength: '<?php echo $lang['admin_add_password_max'];?>'
            },
            new_pw2 : {
                required : '<?php echo $lang['admin_add_password_null'];?>',
				minlength: '<?php echo $lang['admin_add_password_max'];?>',
				maxlength: '<?php echo $lang['admin_add_password_max'];?>',
				equalTo:   '<?php echo $lang['admin_edit_repeat_error'];?>'
            }
        }
	});
});
</script> 