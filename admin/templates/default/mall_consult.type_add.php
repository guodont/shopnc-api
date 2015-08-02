<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>平台客服</h3>
      <ul class="tab-base">
        <li><a href="<?php echo urlAdmin('mall_consult', 'index');?>"><span>平台客服咨询列表</span></a></li>
        <li><a href="<?php echo urlAdmin('mall_consult', 'type_list');?>"><span>平台咨询类型</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>新增类型</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="form_typeadd" id="form_typeadd">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation">类型名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input class="txt" type="text" name="mct_name" value="" /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>类型备注:</label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="vatop rowform"><?php showEditor('mct_introduce');?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation">排序:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input class="txt" type="text" name="mct_sort" value="255" /></td>
          <td class="vatop tips">类型按由小到大循序排列</td>
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
<script type="text/javascript">
$(function(){
    $("#submitBtn").click(function(){
        $("#form_typeadd").submit();
    });
    $("#form_typeadd").validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            mct_name : {
                required : true,
                maxlength : 10
            },
            mct_sort : {
                required : true,
                range : [0,255]
            }
        },
        messages : {
            mct_name : {
                required : '请填写咨询类型名称',
                maxlength : '咨询类型名称长度不能超过10个字符'
            },
            mct_sort : {
                required : '请填写0~255之间的数字',
                range : '请填写0~255之间的数字'
            }
        }
    });
});
</script>
