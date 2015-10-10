<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>店铺帮助</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=help_store&op=help_store"><span><?php echo '帮助内容';?></span></a></li>
        <li><a href="index.php?act=help_store&op=help_type"><span><?php echo '帮助类型';?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '新增类型';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
      	<tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="type_name">类型名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="type_name" name="type_name" value="" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="type_sort"><?php echo $lang['nc_sort'];?>:</label>
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="100" name="type_sort" id="type_sort" class="txt"></td>
          <td class="vatop tips">数字范围为0~255，数字越小越靠前</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['nc_display'];?>:
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="show1" class="cb-enable selected" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="show0" class="cb-disable" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="show1" name="help_show" checked="checked"  value="1" type="radio">
            <input id="show0" name="help_show" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){
	$("#submitBtn").click(function(){
        if($("#post_form").valid()){
            $("#post_form").submit();
    	}
	});
	$("#post_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            type_name : {
                required : true
            },
            type_sort : {
                required : true,
                digits   : true
            }
        },
        messages : {
            type_name : {
                required : "类型名称不能为空"
            },
            type_sort  : {
                required : "排序仅可以为数字",
                digits   : "排序仅可以为数字"
            }
        }
	});
});

</script>
