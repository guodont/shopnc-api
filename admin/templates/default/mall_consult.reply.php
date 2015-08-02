<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>平台客服</h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('mall_consult', 'index');?>"><span>平台客服咨询列表</span></a></li>
        <li><a href="<?php echo urlAdmin('mall_consult', 'type_list');?>"><span>平台咨询类型</span></a></li>
        <li><a href="<?php echo urlAdmin('mall_consult', 'type_add');?>"><span>新增类型</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php if ($output['consult_info']['is_reply'] == 0) {?>回复<?php }else{?>编辑<?php }?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="reply_form" method="post" name="reply_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="mc_id" value="<?php echo $output['consult_info']['mc_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required">咨询人:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['consult_info']['member_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required">咨询内容:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['consult_info']['mc_content'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required">咨询时间: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo date('Y-m-d H:i:s', $output['consult_info']['mc_addtime']);?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required">回复: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="reply_content" class="tarea" rows="6"><?php echo $output['consult_info']['mc_reply'];?></textarea></td>
          <td class="vatop tips">不能超过255个字符。</td>
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
$(function(){
    //按钮先执行验证再提交表单
    $("#submitBtn").click(function(){
        if($("#reply_form").valid()){
            $("#reply_form").submit();
        }
    });
    $("#reply_form").validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            reply_content : {
                required : true,
                maxlength : 255
            }
        },
        messages : {
            reply_content : {
                required : '请填写咨询内容',
                maxlength : '咨询内容不能超过255个字符'
            }
        }
    });
});
</script>