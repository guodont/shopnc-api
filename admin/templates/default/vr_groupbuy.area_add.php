<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>虚拟抢购</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=vr_groupbuy&op=class_list"><span>分类管理</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=class_add"><span>添加分类</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=area_list"><span>区域管理</span></a></li>
        <li><a href="javascript:;" class="current"><span>添加区域</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" action="index.php?act=vr_groupbuy&op=area_add">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="area_name">区域名称<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="area_name" id="area_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>

        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="first_letter">首字母<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <select name='first_letter'>
                <?php foreach($output['letter'] as $lk=>$lv){?>
                <option value='<?php echo $lv;?>'><?php echo $lv;?></option>
                <?php }?>
            </select>
          </td>
        </tr>

        <tr class="noborder">
          <td colspan="2" class="required"><label for="area_number">区号<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="area_number" id="area_number" class="txt"></td>
        </tr>

        <tr class="noborder">
          <td colspan="2" class="required"><label for="post">邮编<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="post" id="post" class="txt"></td>
        </tr>

        <?php if ($output['area_id']) { ?>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="area_class">上级区域<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <?php echo $output['area_name']; ?><input type='hidden' name='parent_area_id' value="<?php echo $output['area_id'];?>">
          </td>
        </tr>
        <?php } else { ?>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="area_class">显示<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="hot1" class="cb-enable" ><span><?php echo $lang['open'];?></span></label>
            <label for="hot0" class="cb-disable selected" ><span><?php echo $lang['close'];?></span></label>
            <input id="hot1" name="is_hot"  value="1" type="radio">
            <input id="hot0" name="is_hot"  checked="checked" value="0" type="radio">
          </td>
        </tr>
        <?php } ?>
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
    $("#submit").click(function(){
        $("#add_form").submit();
    });

    $('#add_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            area_name: {
                required : true
            },
            area_number:{
                number: true
            },
            post:{
                number: true
            }
        },
        messages : {
            area_name: {
                required : '区域名称不能为空'
            },
            area_number:{
                number:'区号必须是数字'
            },
            post:{
                number:'邮编必须是数字'
            }
        }
    });
});
</script>
