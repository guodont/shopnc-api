<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['refund_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=refund&op=refund_manage"><span><?php echo '待处理';?></span></a></li>
        <li><a href="index.php?act=refund&op=refund_all"><span><?php echo '所有记录';?></span></a></li>
        <li><a href="index.php?act=refund&op=reason"><span><?php echo '退款退货原因';?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '编辑原因';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1" action="index.php?act=refund&op=edit_reason&reason_id=<?php echo $output['reason']['reason_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
      	<tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="reason_info">原因:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="reason_info" name="reason_info" value="<?php echo $output['reason']['reason_info']?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="sort"><?php echo $lang['nc_sort'];?>:</label>
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['reason']['sort']?>" name="sort" id="sort" class="txt"></td>
          <td class="vatop tips">数字范围为0~255，数字越小越靠前</td>
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
            reason_info : {
                required : true
            },
            sort : {
                required : true,
                digits   : true
            }
        },
        messages : {
            reason_info : {
                required : "原因不能为空"
            },
            sort  : {
                required : "排序仅可以为数字",
                digits   : "排序仅可以为数字"
            }
        }
	});
});

</script>
