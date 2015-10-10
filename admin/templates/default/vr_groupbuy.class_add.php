<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>虚拟抢购</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=vr_groupbuy&op=class_list"><span>分类管理</span></a></li>
        <li><a href="javascript:;" class="current"><span>添加分类</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=area_list"><span>区域管理</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=area_add"><span>添加区域</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=vr_groupbuy&op=class_add">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="class_name">分类名称<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="class_name" id="class_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="parent_class_id">上级分类<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select id="parent_class_id" name="parent_class_id" class="valid" >
              <option value="0"><?php echo $lang['nc_common_pselect'];?></option>
              <?php if(!empty($output['list']) && is_array($output['list'])) {?>
              <?php foreach($output['list'] as $key=>$val) {?>
              <option value="<?php echo $val['class_id'];?>" <?php if($output['parent_class_id']==$val['class_id']){echo 'selected';}?>><?php echo $val['class_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="class_sort" class="validation"><?php echo $lang['nc_sort'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="class_sort" name="class_sort" type="text" class="txt" value="255" /></td>
          <td class="vatop tips"><?php echo $lang['class_sort_explain'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a id="submit" href="javascript:void(0)" class="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#submit').click(function(){
        $('#add_form').submit();
    });

    $('#add_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            class_name: {
                required : true,
                maxlength : 10
            },
            class_sort: {
                required : true,
                digits: true,
                max: 255,
                min: 0
            }
        },
        messages : {
            class_name: {
                required : "分类名称不能为空",
                maxlength : jQuery.validator.format("分类名称长度最多10个字符")
            },
            class_sort: {
                required : "排序不能为空",
                digits: "排序必须是数字,且数值0-255",
                max : jQuery.validator.format("排序必须是数字,且数值0-255"),
                min : jQuery.validator.format("排序必须是数字,且数值0-255")
            }
        }
    });
});
</script>
