<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_setting'];?></h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('circle_setting', 'index');?>"><span><?php echo $lang['nc_circle_setting'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('circle_setting', 'seo');?>"><span><?php echo $lang['circle_setting_seo'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('circle_setting', 'sec');?>"><span><?php echo $lang['circle_setting_sec'];?></span></a></li>
        <li><a href="<?php echo urlAdmin('circle_setting', 'exp');?>"><span><?php echo $lang['circle_setting_exp'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>设置超管</span></a></li>
        <li><a href="<?php echo urlAdmin('circle_setting', 'super_list');?>"><span>超管列表</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="super_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="menber_name">会员名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <input type="text" name="member_name" id="member_name" class="txt" value="" readonly="readonly" />
            <input type="hidden" name="member_id" id="member_id" class="txt" value="" />
          </td>
          <td class="vatop tips"></td>
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
$(function(){
    //按钮先执行验证再提交表单
	$("#submitBtn").click(function(){
		$("#super_form").submit();
	});

	$('#super_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parents('tr:first').prev().find('td:first'));
        },
        rules : {
            member_name : {
        		required : true
            }
        },
        messages : {
            member_name : {
                required : '请选择会员'
            }
        }
    });

	// 选择圈主弹出框
	$('#member_name').focus(function(){
		ajax_form('choose_master', '选择会员', 'index.php?act=circle_setting&op=choose_super', 320);
	});
});

function chooseReturn(data) {
    $('#member_name').val(data.name);
    $('#member_id').val(data.id);
}
</script>
