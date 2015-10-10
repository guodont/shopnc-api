<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_limit_manage'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="admin_form" method="post" action='index.php?act=admin&op=admin_edit&admin_id=<?php echo $output['admininfo']['admin_id'];?>'>
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_index_username'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['admininfo']['admin_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="new_pw"><?php echo $lang['admin_edit_admin_pw']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="new_pw" name="new_pw" class="txt" type="password"></td>
           <td class="vatop tips"><?php echo $lang['admin_edit_pwd_tip1'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><labe for="new_pw2"><?php echo $lang['admin_edit_admin_pw2']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="new_pw2" name="new_pw2" class="txt" type="password"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="gadmin_name"><?php echo $lang['gadmin_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
          <select name="gid">
          <?php foreach((array)$output['gadmin'] as $v){?>
          <option <?php if ($v['gid'] == $output['admininfo']['admin_gid']) echo 'selected';?> value="<?php echo $v['gid'];?>"><?php echo $v['gname'];?></option>
          <?php }?>
          </select>
          </td>
          <td class="vatop tips"><?php echo $lang['admin_add_gid_tip'];?></td>
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
$(document).ready(function(){
	$("#admin_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	new_pw : {
				minlength: 6,
				maxlength: 20
            },
            new_pw2 : {
				minlength: 6,
				maxlength: 20,
				equalTo: '#new_pw'
            },
            gid : {
                required : true
            }
        },
        messages : {
        	new_pw : {
				minlength: '<?php echo $lang['admin_add_password_max'];?>',
				maxlength: '<?php echo $lang['admin_add_password_max'];?>'
            },
            new_pw2 : {
				minlength: '<?php echo $lang['admin_add_password_max'];?>',
				maxlength: '<?php echo $lang['admin_add_password_max'];?>',
				equalTo:   '<?php echo $lang['admin_edit_repeat_error'];?>'
            },
            gid : {
                required : '<?php echo $lang['admin_add_gid_null'];?>',
            }
        }
	});
});
</script>