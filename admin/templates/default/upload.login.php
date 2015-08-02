<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['upload_set'];?></h3>
     <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['login_set_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="old_login_pic1" value="<?php echo $output['list'][0];?>" />
    <input type="hidden" name="old_login_pic2" value="<?php echo $output['list'][1];?>" />
    <input type="hidden" name="old_login_pic3" value="<?php echo $output['list'][2];?>" />
    <input type="hidden" name="old_login_pic4" value="<?php echo $output['list'][3];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label>IMG1:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_PATH.'/login/'.$output['list'][0]);?>"><img class="show_image" title="<?php echo L('login_click_open');?>" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png"></a>
            </span><span class="type-file-box">
            <input name="login_pic1" type="file" class="type-file-file" id="login_pic1" size="30" hidefocus="true">
            </span></td>
          <td class="vatop tips">450px * 350px</td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label>IMG2:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_PATH.'/login/'.$output['list'][1]);?>"><img class="show_image" title="<?php echo L('login_click_open');?>" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png"></a>
            </span><span class="type-file-box">
            <input name="login_pic2" type="file" class="type-file-file" id="login_pic2" size="30" hidefocus="true">
            </span></td>
          <td class="vatop tips">450px * 350px</td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label>IMG3:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_PATH.'/login/'.$output['list'][2]);?>"><img class="show_image" title="<?php echo L('login_click_open');?>" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png"></a>
            </span><span class="type-file-box">
            <input name="login_pic3" type="file" class="type-file-file" id="login_pic3" size="30" hidefocus="true">
            </span></td>
          <td class="vatop tips">450px * 350px</td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label>IMG4:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_PATH.'/login/'.$output['list'][3]);?>"><img class="show_image" title="<?php echo L('login_click_open');?>" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png"></a>
            </span><span class="type-file-box">
            <input name="login_pic4" type="file" class="type-file-file" id="login_pic4" size="30" hidefocus="true">
            </span></td>
          <td class="vatop tips">450px * 350px</td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript">
// 模拟网站LOGO上传input type='file'样式
$(function(){
    var textButton1="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
    var textButton2="<input type='text' name='textfield' id='textfield2' class='type-file-text' /><input type='button' name='button' id='button2' value='' class='type-file-button' />"
    var textButton3="<input type='text' name='textfield' id='textfield3' class='type-file-text' /><input type='button' name='button' id='button3' value='' class='type-file-button' />"
    var textButton4="<input type='text' name='textfield' id='textfield4' class='type-file-text' /><input type='button' name='button' id='button4' value='' class='type-file-button' />"
	$(textButton1).insertBefore("#login_pic1");
	$(textButton2).insertBefore("#login_pic2");
	$(textButton3).insertBefore("#login_pic3");
	$(textButton4).insertBefore("#login_pic4");
	$("#login_pic1").change(function(){$("#textfield1").val($("#login_pic1").val());});
	$("#login_pic2").change(function(){$("#textfield2").val($("#login_pic2").val());});
	$("#login_pic3").change(function(){$("#textfield3").val($("#login_pic3").val());});
	$("#login_pic4").change(function(){$("#textfield4").val($("#login_pic4").val());});
// 上传图片类型
$('input[class="type-file-file"]').change(function(){
	var filepatd=$(this).val();
	var extStart=filepatd.lastIndexOf(".");
	var ext=filepatd.substring(extStart,filepatd.lengtd).toUpperCase();
		if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
			alert("<?php echo $lang['default_img_wrong'];?>");
				$(this).attr('value','');
			return false;
		}
	});

$('#time_zone').attr('value','<?php echo $output['list_setting']['time_zone'];?>');
$('.nyroModal').nyroModal();
});
</script>
