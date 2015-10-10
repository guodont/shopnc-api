<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>虚拟抢购</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=vr_groupbuy&op=class_list"><span>分类管理</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=class_add"><span>添加分类</span></a></li>
        <li><a href="index.php?act=vr_groupbuy&op=area_list"><span>区域管理</span></a></li>
        <li><a href="javascript:;" class="current"><span>编辑区域</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" action="index.php?act=vr_groupbuy&op=area_edit">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="area_name">区域名称<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="area_name" id="area_name" class="txt" value="<?php echo $output['area']['area_name'];?>" ></td>
          <td class="vatop tips"></td>
        </tr>

        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="first_letter">首字母<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <select name='first_letter'>
                <?php foreach($output['letter'] as $lv){?>
                <option value='<?php echo $lv;?>' <?php if($lv==$output['area']['first_letter']){ echo 'selected';}?> ><?php echo $lv;?></option>
                <?php }?>
            </select>
          </td>
        </tr>

        <tr class="noborder">
          <td colspan="2" class="required"><label for="area_number">区号<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['area']['area_number'];?>" name="area_number" id="area_number" class="txt"></td>
        </tr>

        <tr class="noborder">
          <td colspan="2" class="required"><label for="post">邮编<?php echo $lang['nc_colon']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['area']['post'];?>" name="post" id="post" class="txt"></td>
        </tr>

        <?php if ($output['area']['parent_area_id']) { ?>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="area_class">上级区域<?php echo $lang['nc_colon']; ?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <?php echo $output['parent_area_name'];?><input type='hidden' name='parent_area_id' value="<?php echo $output['area_id'];?>">
          </td>
        </tr>
        <?php } else { ?>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="area_class">显示<?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="hot1" class="cb-enable <?php if($output['area']['hot_city']=='1'){ echo 'selected';}?>"><span><?php echo $lang['open'];?></span></label>
            <label for="hot0" class="cb-disable <?php if($output['area']['hot_city']=='0'){ echo 'selected';}?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="hot1" name="is_hot"  value="1" type="radio" <?php if($output['area']['hot_city']=='1'){ echo 'checked';}?> >
            <input id="hot0" name="is_hot"  value="0" type="radio" <?php if($output['area']['hot_city']=='0'){ echo 'checked';}?> >
          </td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a id="submit" href="javascript:void(0)" class="btn">
            <input type="hidden" name="area_id" value="<?php echo $output['area']['area_id'];?>">
            <span><?php echo $lang['nc_submit'];?></span></a>
          </td>
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
