<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_limit_manage'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="admin_name"><?php echo $lang['admin_index_username'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="admin_name" name="admin_name" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['admin_add_username_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="admin_password"><?php echo $lang['admin_index_password'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="password" id="admin_password" name="admin_password" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['admin_add_password_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="admin_password"><?php echo $lang['admin_rpassword'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="password" id="admin_rpassword" name="admin_rpassword" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['admin_add_password_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="gadmin_name"><?php echo $lang['gadmin_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
          <select name="gid">
          <?php foreach((array)$output['gadmin'] as $v){?>
          <option value="<?php echo $v['gid'];?>"><?php echo $v['gname'];?></option>
          <?php }?>
          </select>
          </td>
          <td class="vatop tips"><?php echo $lang['admin_add_gid_tip'];?></td>
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
<script>
//按钮先执行验证再提交表
$(document).ready(function(){
	//按钮先执行验证再提交表单
	$("#submitBtn").click(function(){
	    if($("#add_form").valid()){
	     $("#add_form").submit();
		}
	});
	
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            admin_name : {
                required : true,
				minlength: 3,
				maxlength: 20,
				remote	: {
                    url :'index.php?act=admin&op=ajax&branch=check_admin_name',
                    type:'get',
                    data:{
                    	admin_name : function(){
                            return $('#admin_name').val();
                        }
                    }
                }
            },
            admin_password : {
                required : true,
				minlength: 6,
				maxlength: 20
            },
            admin_rpassword : {
                required : true,
                equalTo  : '#admin_password'
            },
            gid : {
                required : true
            }        
        },
        messages : {
            admin_name : {
                required : '<?php echo $lang['admin_add_username_null'];?>',
				minlength: '<?php echo $lang['admin_add_username_max'];?>',
				maxlength: '<?php echo $lang['admin_add_username_max'];?>',
				remote	 : '<?php echo $lang['admin_add_admin_not_exists'];?>'
            },
            admin_password : {
                required : '<?php echo $lang['admin_add_password_null'];?>',
				minlength: '<?php echo $lang['admin_add_password_max'];?>',
				maxlength: '<?php echo $lang['admin_add_password_max'];?>'
            },
            admin_rpassword : {
                required : '<?php echo $lang['admin_add_password_null'];?>',
                equalTo  : '<?php echo $lang['admin_edit_repeat_error'];?>'
            },
            gid : {
                required : '<?php echo $lang['admin_add_gid_null'];?>',
            }
        }
	});
});
</script>
