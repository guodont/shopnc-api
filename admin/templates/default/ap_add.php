<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['adv_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=adv&op=ap_manage"><span><?php echo $lang['ap_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['ap_add'];?></span></a><em></em></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="link_form" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="ap_name"><?php echo $lang['ap_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="ap_name" id="ap_name" class="txt">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['ap_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="ap_class" id="ap_class">
              <option value="0"><?php echo $lang['adv_pic'];?></option>
              <option value="1"><?php echo $lang['adv_word'];?></option>
              <option value="3">Flash</option>
            </select>
		  </td>
          <td class="vatop tips"><?php echo $lang['ap_select_showstyle'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['ap_is_use'];?>:</td>
        </tr>
        <tr class="noborder">
			<td class="vatop rowform"><ul>
              <li>
                <input name="is_use" type="radio" value="1" checked="checked">
                <label><?php echo $lang['ap_use_s'];?></label>
              </li>
              <li>
                <input type="radio" name="is_use" value="0">
                <label><?php echo $lang['ap_not_use_s'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody id="ap_display">
        <tr>
          <td colspan="2" class="required"><?php echo $lang['ap_show_style'];?>:</td>
        </tr>
        <tr class="noborder">
 		<td class="vatop rowform"><ul class="nofloat">
              <li>
                <input type="radio" name="ap_display" value="1">
                <label><?php echo $lang['ap_allow_mul_adv'];?></label>
              </li>
              <li>
                <input type="radio" name="ap_display" value="2" checked="checked">
                <label><?php echo $lang['ap_allow_one_adv'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody id="ap_width_media">
        <tr>
          <td colspan="2" class="required"><label class="validation" for="ap_width_media_input"><?php echo $lang['ap_width_l'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="ap_width_media"  class="txt" id="ap_width_media_input"></td>
          <td class="vatop tips"><?php echo $lang['adv_pix'];?></td>
        </tr>
      <tbody id="ap_width_word">
        <tr>
          <td colspan="2" class="required"><label class="validation" for="ap_width_word_input"><?php echo $lang['ap_word_num'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="ap_width_word"  class="txt" id="ap_width_word_input"></td>
          <td class="vatop tips"><?php echo $lang['adv_byte'];?></td>
        </tr>
      </tbody>
      <tbody id="ap_height">
        <tr>
          <td colspan="2" class="required"><label class="validation" for="ap_height_input"><?php echo $lang['ap_height_l'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="ap_height" class="txt" id="ap_height_input"></td>
          <td class="vatop tips"><?php echo $lang['adv_pix'];?></td>
        </tr>
      </tbody>
      <tbody id="default_pic">
        <tr>
          <td colspan="2" class="required"><label class="validation" for="change_default_pic"><?php echo $lang['ap_default_pic']; ?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform type-file-box"><input type="file" name="default_pic" id="change_default_pic" size="30" hidefocus="true" nc_type="change_default_pic">
            </td>
          <td class="vatop tips"><?php echo $lang['ap_show_defaultpic_when_nothing']; ?>,<?php echo $lang['adv_edit_support'];?>gif,jpg,jpeg,png</td>
        </tr>
      </tbody>
      <tbody id="default_word">
        <tr>
          <td colspan="2" class="required"><label for="default_word" class="validation"><?php echo $lang['ap_default_word']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="default_word" value="" name="default_word" class="txt">
            </td>
          <td class="vatop tips"><?php echo $lang['ap_show_defaultword_when_nothing']; ?></td>
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
<script type="text/javascript">
$(function(){
	$("#ap_width_word").hide();
	$("#default_word").hide();
	$("#ap_class").change(function(){
	if($("#ap_class").val() == '1'){
		$("#ap_height").hide();
		$("#ap_width_media").hide();
		$("#default_pic").hide();
		$("#default_word").show();
		$("#ap_width_word").show();
		$("#ap_display").show();
	}else if($("#ap_class").val() == '0'||$("#ap_class").val() == '3'){
		$("#ap_height").show();
		$("#ap_width_media").show();
		$("#default_pic").show();
		$("#default_word").hide();
		$("#ap_width_word").hide();
		$("#ap_display").show();
	}
  });
});
</script>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#link_form").valid()){
     $("#link_form").submit();
	}
	});
});
//
$(document).ready(function(){

	$('#link_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	ap_name : {
                required : true
            },
			ap_width_media:{
				required :function(){return $("#ap_class").val()!=1;},
				digits	 :true,
				min:1
			},
			ap_height:{
				required :function(){return $("#ap_class").val()!=1;},
				digits	 :true,
				min:1
			},
			ap_width_word :{
				required :function(){return $("#ap_class").val()==1;},
				digits	 :true,
				min:1
			},
			default_word  :{
				required :function(){return $("#ap_class").val()==1;}
			},
			change_default_pic:{
				required :true
			}
        },
        messages : {
        	ap_name : {
                required : '<?php echo $lang['ap_can_not_null']; ?>'
            },
            ap_width_media	:{
            	required   : '<?php echo $lang['ap_input_digits_pixel']; ?>',
            	digits	:'<?php echo $lang['ap_input_digits_pixel'];?>',
            	min	:'<?php echo $lang['ap_input_digits_pixel'];?>'
            },
            ap_height	:{
            	required   : '<?php echo $lang['ap_input_digits_pixel']; ?>',
            	digits	:'<?php echo $lang['ap_input_digits_pixel'];?>',
            	min	:'<?php echo $lang['ap_input_digits_pixel'];?>'
            },
            ap_width_word	:{
            	required   : '<?php echo $lang['ap_input_digits_pixel']; ?>',
            	digits	:'<?php echo $lang['ap_input_digits_pixel'];?>',
            	min	:'<?php echo $lang['ap_input_digits_pixel'];?>'
            },
            default_word	:{
            	required   : '<?php echo $lang['ap_default_word_can_not_null']; ?>'
            }
        }
    });
});
</script>