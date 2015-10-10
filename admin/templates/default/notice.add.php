<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['notice_index_member_notice'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['notice_index_send'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="notice_form" method="POST">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['notice_index_send_type'];?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <label><input type="radio" checked="" value="1" name="send_type"><?php echo $lang['notice_index_spec_member'];?></label>
              </li>
              <li>
                <label><input type="radio" value="2" name="send_type" /><?php echo $lang['notice_index_all_member'];?></label>
              </li>
            </ul>
          </td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody id="user_list">
        <tr>
          <td colspan="2" class="required"><label class="validation" for="user_name"><?php echo $lang['notice_index_member_list'];?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea id="user_name" name="user_name" rows="6" class="tarea" ><?php echo base64_decode(str_replace(' ','+',$_GET['member_name'])); ?></textarea></td>
          <td class="vatop tips"><?php echo $lang['notice_index_member_tip'];?></td>
        </tr>
      </tbody>
      <tbody id="msg">
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['notice_index_content'];?>: </label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="vatop rowform"><textarea name="content1" rows="6" class="tarea"></textarea></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#notice_form").valid()){
        $("#notice_form").submit();
	}
	});
});
$(document).ready(function(){
	$('#notice_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            user_name : {
                required : check_user_name
            },
            content1 :{
            	required : true
            }
        },
        messages : {
            user_name :{
                required     : '<?php echo $lang['notice_index_member_error'];?>'
            },
            content1 :{
            	required : '<?php echo $lang['notice_index_content_null']; ?>'
            }
        },
		submitHandler: function(form) {
			form.submit();
		}
    });
    function check_user_name()
    {
        var rs = $(":input[name='send_type']:checked").val();
        return rs == 1 ? true : false;
    }

    $("input[name='send_type']").click(function(){
        var rs = $(this).val();
        switch(rs)
        {
            case '1':
                $('#user_list').show();
                break;
            case '2':
                $('#user_list').hide();
                break;
        }
    });
});
</script>
