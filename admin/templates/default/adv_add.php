<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['adv_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=adv&op=ap_manage"><span><?php echo $lang['ap_manage'];?></span></a></li>
        <li><a href="index.php?act=adv&op=adv&ap_id=<?php echo $_GET['ap_id'];?>"><span><?php echo $lang['adv_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['adv_add'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="adv_form" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2" id="main_table">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="adv_name"><?php echo $lang['adv_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="adv_name" id="adv_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="ap_id"><?php echo $lang['adv_ap_select'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="ap_id" id="ap_id">
              <option value='' ap_type=''></option>
              <?php
				 foreach ($output['ap_list'] as $k=>$v){
				 	echo "<option value='".$v['ap_id']."' ap_type='".$v['ap_class']."' ap_width='".$v['ap_width']."' >".$v['ap_name'];
				 	if($v['ap_class'] == '1'){
				 		echo "(".$v['ap_width'].")";
				 		$word_length = $v['ap_width'];
				 	}else{
				 		echo "(".$v['ap_width']."*".$v['ap_height'].")";
				 	}
				 	echo "</option>";
				 }
				?>
            </select>
            <input type="hidden" name="aptype_hidden" id="aptype_hidden"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="adv_start_time"><?php echo $lang['adv_start_time'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="adv_start_time" id="adv_start_time" class="txt date"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="adv_end_time"><?php echo $lang['adv_end_time'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="adv_end_time" id="adv_end_time" class="txt date"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody id="adv_pic">
        <tr>
          <td colspan="2" class="required"><label for="file_adv_pic"><?php echo $lang['adv_img_upload'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-box">
            <input type="file" class="type-file-file" id="file_adv_pic" name="adv_pic" size="30"/>
            </span></td>
          <td class="vatop tips"><?php echo $lang['adv_edit_support'];?>gif,jpg,jpeg,png</td>
        </tr>
      </tbody>
      <tbody id="adv_pic_url">
        <tr>
          <td colspan="2" class="required"><label for="type_adv_pic_url"><?php echo $lang['adv_url'];?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="adv_pic_url" class="txt" id="type_adv_pic_url"></td>
          <td class="vatop tips"><?php echo $lang['adv_url_donotadd'];?></td>
        </tr>
      </tbody>
      <tbody id="adv_word">
        <tr>
          <td colspan="2" class="required"><label for="type_adv_word"><?php echo $lang['adv_word_content'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="adv_word" id="type_adv_word" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['adv_max'];?><span id="adv_word_len"></span><?php echo $lang['adv_byte'];?></td>
        </tr>
      </tbody>
      <tbody id="adv_word_url">
        <tr>
          <td colspan="2" class="required"><label for="type_adv_word_url"><?php echo $lang['adv_url'];?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="adv_word_url" class="txt" id="type_adv_word_url"></td>
          <td class="vatop tips"><?php echo $lang['adv_url_donotadd'];?></td>
        </tr>
      </tbody>
      <tbody id="adv_flash_swf">
        <tr>
          <td colspan="2" class="required"><label for="file_flash_swf"><?php echo $lang['adv_flash_upload'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-box">
            <input type="file" class="type-file-file" id="file_flash_swf" name="flash_swf" size="30" />
            </span></td>
          <td class="vatop tips"><?php echo $lang['adv_please_file_swf_file']; ?></td>
        </tr>
      </tbody>
      <tbody id="adv_flash_url">
        <tr>
          <td colspan="2" class="required"><label for="type_adv_flash_url"><?php echo $lang['adv_url'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="flash_url" class="txt" id="type_adv_flash_url"></td>
          <td class="vatop tips"><?php echo $lang['adv_url_donotadd'];?></td>
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
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#adv_start_time').datepicker({dateFormat: 'yy-mm-dd'});
    $('#adv_end_time').datepicker({dateFormat: 'yy-mm-dd'});

    $('#adv_pic').hide();
    $('#adv_pic_url').hide();
    $('#adv_word').hide();
    $('#adv_word_url').hide();
    $('#adv_flash_swf').hide();
    $('#adv_flash_url').hide();

    $('#ap_id').change(function(){
    	var select   = document.getElementById("ap_id");
    	var ap_type  = select.item(select.selectedIndex).getAttribute("ap_type");
    	var ap_width = select.item(select.selectedIndex).getAttribute("ap_width");
        if(ap_type == '0'){
    	    $('#adv_pic').show();
            $('#adv_pic_url').show();
            $('#adv_word').hide();
            $('#adv_word_url').hide();
            $('#adv_flash_swf').hide();
            $('#adv_flash_url').hide();
        }
        if(ap_type == '1'){
        	$('#adv_word').show();
            $('#adv_word_url').show();
            $('#adv_word_len').html("<span>"+ap_width+"</span><input type='hidden' name='adv_word_len' value='"+ap_width+"'>");
            $('#adv_pic').hide();
            $('#adv_pic_url').hide();
            $('#adv_flash_swf').hide();
            $('#adv_flash_url').hide();
        }
        if(ap_type == '3'){
        	$('#adv_flash_swf').show();
            $('#adv_flash_url').show();
            $('#adv_pic').hide();
            $('#adv_pic_url').hide();
            $('#adv_word').hide();
            $('#adv_word_url').hide();
        }
        $("#aptype_hidden").val(ap_type);
    });
});
</script>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#adv_form").valid()){
     $("#adv_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#adv_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	adv_name : {
                required : true
            },
            aptype_hidden : {
                required : true
            },
            adv_start_time  : {
                required : true,
                date	 : false
            },
            adv_end_time  : {
            	required : true,
                date	 : false
            }
        },
        messages : {
        	adv_name : {
                required : '<?php echo $lang['adv_can_not_null'];?>'
            },
            aptype_hidden : {
                required : '<?php echo $lang['must_select_ap_id'];?>'
            },
            adv_start_time  : {
                required : '<?php echo $lang['adv_start_time_can_not_null']; ?>'
            },
            adv_end_time  : {
            	required   : '<?php echo $lang['adv_end_time_can_not_null']; ?>'
            }
        }
    });
});
</script>
<script type="text/javascript">
$(function(){
	var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
    $(textButton).insertBefore("#file_adv_pic");
    $("#file_adv_pic").change(function(){
	$("#textfield1").val($("#file_adv_pic").val());
    });

	var textButton="<input type='text' name='textfield' id='textfield3' class='type-file-text' /><input type='button' name='button' id='button3' value='' class='type-file-button' />"
    $(textButton).insertBefore("#file_flash_swf");
    $("#file_flash_swf").change(function(){
	$("#textfield3").val($("#file_flash_swf").val());
    });
    $('#ap_id').val('<?php echo $_GET['ap_id'];?>');
    $('#ap_id').change();
});
</script>