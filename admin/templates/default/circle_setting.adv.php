<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_advmanage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_circle_advmanage'];?></span></a></li>
      </ul>
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
            <li><?php echo $lang['circle_setting_adv_prompts_one'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>  
  <form method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="old_adv_pic1" value="<?php echo $output['list'][1]['pic'];?>" />
    <input type="hidden" name="old_adv_pic2" value="<?php echo $output['list'][2]['pic'];?>" />
    <input type="hidden" name="old_adv_pic3" value="<?php echo $output['list'][3]['pic'];?>" />
    <input type="hidden" name="old_adv_pic4" value="<?php echo $output['list'][4]['pic'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td class="required"><label><?php echo $lang['circle_setting_adv'];?>-01:</label></td><td><?php echo $lang['circle_setting_adv_url_address'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_CIRCLE.'/'.$output['list'][1]['pic']);?>"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png"></a>
            </span><span class="type-file-box">
            <input name="adv_pic1" type="file" class="type-file-file" id="adv_pic1" size="30" hidefocus="true">
            <input type='text' name='textfield' id='textfield1' class='type-file-text' />
            <input type='button' name='button' id='button1' value='' class='type-file-button' />
            </span></td>
          <td class="vatop tips"><input class="txt" type="text" name="adv_url1" value="<?php echo $output['list'][1]['url'];?>" style=" width:300px;">
          </td>
        </tr>
        <tr>
          <td class="required"><label><?php echo $lang['circle_setting_adv'];?>-02:</label></td><td><?php echo $lang['circle_setting_adv_url_address'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_CIRCLE.'/'.$output['list'][2]['pic']);?>"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png"></a>
            </span><span class="type-file-box">
            <input name="adv_pic2" type="file" class="type-file-file" id="adv_pic2" size="30" hidefocus="true">
            <input type='text' name='textfield' id='textfield2' class='type-file-text' />
            <input type='button' name='button' id='button2' value='' class='type-file-button' />
            </span></td>
          <td class="vatop tips"><input class="txt" type="text" name="adv_url2" value="<?php echo $output['list'][2]['url'];?>" style=" width:300px;">
          </td>
        </tr>
        <tr>
          <td class="required"><label><?php echo $lang['circle_setting_adv'];?>-03:</label></td><td><?php echo $lang['circle_setting_adv_url_address'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_CIRCLE.'/'.$output['list'][3]['pic']);?>"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png"></a>
            </span><span class="type-file-box">
            <input name="adv_pic3" type="file" class="type-file-file" id="adv_pic3" size="30" hidefocus="true">
            <input type='text' name='textfield' id='textfield3' class='type-file-text' />
            <input type='button' name='button' id='button3' value='' class='type-file-button' />
            </span></td>
          <td class="vatop tips">
            <input class="txt" type="text" name="adv_url3" value="<?php echo $output['list'][3]['url'];?>" style=" width:300px;">
          </td>
        </tr>
        <tr>
          <td class="required"><label><?php echo $lang['circle_setting_adv'];?>-04:</label></td><td><?php echo $lang['circle_setting_adv_url_address'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><a class="nyroModal" rel="gal" href="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_CIRCLE.'/'.$output['list'][4]['pic']);?>"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png"></a>
            </span><span class="type-file-box">
            <input name="adv_pic4" type="file" class="type-file-file" id="adv_pic4" size="30" hidefocus="true">
            <input type='text' name='textfield' id='textfield4' class='type-file-text' />
            <input type='button' name='button' id='button4' value='' class='type-file-button' />
            </span></td>
          <td class="vatop tips">
            <input class="txt" type="text" name="adv_url4" value="<?php echo $output['list'][4]['url'];?>" style=" width:300px;">
          </td>
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
	$("#adv_pic1").change(function(){$("#textfield1").val($(this).val());});
	$("#adv_pic2").change(function(){$("#textfield2").val($(this).val());});
	$("#adv_pic3").change(function(){$("#textfield3").val($(this).val());});
	$("#adv_pic4").change(function(){$("#textfield4").val($(this).val());});
// 上传图片类型
$('input[class="type-file-file"]').change(function(){
	var filepatd=$(this).val();
	var extStart=filepatd.lastIndexOf(".");
	var ext=filepatd.substring(extStart,filepatd.lengtd).toUpperCase();		
		if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
			alert("<?php echo $lang['circle_setting_adv_img_check'];?>");
			$(this).attr('value','');
			return false;
		}
	});
	
$('#time_zone').attr('value','<?php echo $output['list_setting']['time_zone'];?>');
$('.nyroModal').nyroModal();
});
</script>