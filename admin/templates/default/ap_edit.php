<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['adv_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=adv&op=ap_manage"><span><?php echo $lang['ap_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['ap_change'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="link_form" enctype="multipart/form-data" method="post" name="form1">
    <input type="hidden" name="ref_url" value="<?php echo $output['ref_url'];?>" />
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <?php foreach($output['ap_list'] as $k => $v){ ?>
      <input type="hidden" name="ap_class" value="<?php echo $v['ap_class']; ?>" />
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="ap_name"><?php echo $lang['ap_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="ap_name" id="ap_name" class="txt" value="<?php echo $v['ap_name'];?>"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="sg_description"><?php echo $lang['ap_intro'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea class="tarea" id="sg_description" name="ap_intro" ><?php echo $v['ap_intro'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <?php
				 switch ($v['ap_class']){
				 	case '0':
				        if($v['ap_display'] == '1'){
				 			$display_state1 = "checked";
				 			$display_state2 = "";
				 		}else{
				 			$display_state1 = "";
				 			$display_state2 = "checked";
				 		}
				 		echo
						"<tr>
							<td colspan='2' class='required'><label>".$lang['ap_class'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'>".$lang['adv_pic']."</td>
							<td class='vatop tips'></td>
						</tr>";
				 		echo
						"<tr>
							<td colspan='2' class='required'><label class='validation' for='ap_width_input'>".$lang['ap_width_l'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'><input type='text' value='".$v['ap_width']."' name='ap_width' class='txt' id='ap_width_input'></td>
							<td class='vatop tips'>".$lang['adv_pix']."</td>
						</tr>";
				 		echo
						"<tr>
							<td colspan='2' class='required'><label class='validation' for='ap_height_input'>".$lang['ap_height_l'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'><input type='text' value='".$v['ap_height']."' name='ap_height' id='ap_height_input' class='txt'></td>
							<td class='vatop tips'>".$lang['adv_pix']."</td>
						</tr>";
				 		echo
						"<tr>
							<td colspan='2' class='required'><label>".$lang['ap_show_style'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'>
								<ul class='nofloat'>
									<li><input type='radio' name='ap_display' id='ap_display_1' value='1' ".$display_state1."><label for='ap_display_1'>".$lang['ap_allow_mul_adv']."</label></li>
									<li><input type='radio' name='ap_display' id='ap_display_2' value='2' ".$display_state2."><label for='ap_display_2'>".$lang['ap_allow_one_adv']."</label></li>
								</ul></td>
							<td class='vatop tips'></td>
						</tr>
						</tbody>";
				 		echo
						"<tbody id='adv_pic'>
							<tr>
								<td colspan='2' class='required'><label>".$lang['ap_default_pic_upload']."</label></td>
							</tr>
							<tr class='noborder'>
								<td class='vatop rowform'><span class='type-file-show'><img class='show_image' src='".ADMIN_TEMPLATES_URL."/images/preview.png'>
								<div class='type-file-preview'><img src='".UPLOAD_SITE_URL."/".ATTACH_ADV."/".$v['default_content']."'>
								</div></span><span class='type-file-box'><input name='default_pic' type='file' class='type-file-file' id='change_default_pic' size='30'></span></td>
								<td class='vatop tips'>".$lang['ap_show_defaultpic_when_nothing'].",".$lang['adv_edit_support']."gif,jpg,jpeg,png</td>
							</tr>
						</tbody>
						<tbody>";
				 		break;
				 	case '1':
				        if($v['ap_display'] == '1'){
				 			$display_state1 = "checked";
				 			$display_state2 = "";
				 		}else{
				 			$display_state1 = "";
				 			$display_state2 = "checked";
				 		}
				 		echo
						"<tr>
							<td colspan='2' class='required'><label>".$lang['ap_class'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'>".$lang['adv_word']."</td><td class='vatop tips'></td>
						</tr>";
				 		echo
						"<tr>
							<td colspan='2' class='required'><label class='validation' for='ap_width_input'>".$lang['ap_word_num'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'><input type='text' value='".$v['ap_width']."' name='ap_width' id='ap_width_input' class='txt'></td>
							<td class='vatop tips'>".$lang['adv_byte']."</td>
						</tr>";
				 		echo
						"<tr>
							<td colspan='2' class='required'><label>".$lang['ap_show_style'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'>
								<ul class='nofloat'>
									<li><input type='radio' name='ap_display' value='1' id='ap_display_1' ".$display_state1."><label for='ap_display_1'>".$lang['ap_allow_mul_adv']."</label></li>
									<li><input type='radio' name='ap_display' id='ap_display_2' value='2' ".$display_state2."><label for='ap_display_2'>".$lang['ap_allow_one_adv']."</label></li>
									</ul></td></tr>";
				 		echo
						"<tr>
							<td colspan='2' class='required'><label class='validation' for='default_word'>".$lang['ap_default_word']."</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'><input type='text' value='".$v['default_content']."' name='default_word' class='txt' id='default_word'></td>
							<td class='vatop tips'></td>
						</tr>";
				 		break;
				 	case '3':
				 		if($v['ap_display'] == '1'){
				 			$display_state1 = "checked";
				 			$display_state2 = "";
				 		}else{
				 			$display_state1 = "";
				 			$display_state2 = "checked";
				 		}
				 		echo
						"<tr>
							<td colspan='2' class='required'><label>".$lang['ap_class'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'>Flash</td>
							<td class='vatop tips'></td>
						</tr>";
				 		echo
						"<tr>
							<td colspan='2' class='required'><label for='ap_width' class='validation'>".$lang['ap_width_l'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'>
								<input type='text' value='".$v['ap_width']."' name='ap_width' class='txt' id='ap_width'>
							</td>
							<td class='vatop tips'>".$lang['adv_pix']."</td>
						</tr>";
				 		echo
						"<tr>
							<td colspan='2' class='required'><label for='ap_height_input' class='validation'>".$lang['ap_height_l'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'><input type='text' value='".$v['ap_height']."' name='ap_height' id='ap_height_input' class='txt'></td>
							<td class='vatop tips'>".$lang['adv_pix']."</td>
						</tr>";
				 		echo
						"<tr>
							<td colspan='2' class='required'><label>".$lang['ap_show_style'].":</label></td>
						</tr>
						<tr class='noborder'>
							<td class='vatop rowform'>
								<ul class='nofloat'>
									<li><input type='radio' id='ap_display_1' name='ap_display' value='1' ".$display_state1."><label for='ap_display_1'>".$lang['ap_allow_mul_adv']."</label></li>
									<li><input type='radio' id='ap_display_2' name='ap_display' value='2' ".$display_state2."><label for='ap_display_2'>".$lang['ap_allow_one_adv']."</label></li></ul>
						</td>
						<td class='vatop tips'></td>
						</tr>
						</tbody>";
				 		echo
						"<tbody >
							<tr id='adv_pic'>
								<td colspan='2' class='required'><label>".$lang['ap_default_pic_upload']."</label></td>
							</tr>
							<tr class='noborder'>
								<td class='vatop rowform'>
								<span class='type-file-show'><img class='show_image' src='".ADMIN_TEMPLATES_URL."/images/preview.png'>
									<div class='type-file-preview'><img src='".UPLOAD_SITE_URL."/".ATTACH_ADV."/".$v['default_content']."' /></div></span><span class='type-file-box'><input name='default_pic' type='file' class='type-file-file' id='change_default_pic' size='30'></span></td><td class='vatop tips'>".$lang['ap_show_defaultpic_when_nothing'].",".$lang['adv_edit_support']."gif,jpg,jpeg,png</td></tbody></tr>";
				 		break;
				 }
				?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['ap_is_use'];?>:</label></td>
        </tr>
         <tr class="noborder">
          <td class="vatop rowform"><ul>
              <li>
                <input type="radio" id="is_use_1" name="is_use" value="1" <?php if($v['is_use'] == '1'){echo "checked";}?>>
                <label for="is_use_1"><?php echo $lang['ap_use_s'];?></label>
              </li>
              <li>
                <input type="radio" id="is_use_0" name="is_use" value="0" <?php if($v['is_use'] == '0'){echo "checked";}?>>
                <label for="is_use_0"><?php echo $lang['ap_not_use_s'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <?php }?>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15">
          <a href="JavaScript:void(0);" class="btn" id="submitBtn" onclick="document.form1.submit()"><span><?php echo $lang['adv_change'];?></span></a>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
$(function(){
    var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
	$(textButton).insertBefore("#change_default_pic");
	$("#change_default_pic").change(function(){
	$("#textfield1").val($("#change_default_pic").val());
	});
});
</script>