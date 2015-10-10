<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['upload_set'];?></h3>
   	<?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" enctype="multipart/form-data" onsubmit="MySubmit();return false;" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="default_goods_image"><?php echo $lang['default_product_pic'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.'/'.$output['list_setting']['default_goods_image']);?>"></div>
            </span><span class="type-file-box">
            <input class="type-file-file" id="default_goods_image" name="default_goods_image" type="file" size="30" hidefocus="true"  nc_type="change_default_goods_image" title="<?php echo $lang['default_product_pic'];?>">
            </span></td>
          <td class="vatop tips">300px * 300px</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="default_store_logo"><?php echo $lang['default_store_logo'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.'/'.$output['list_setting']['default_store_logo']);?>"></div>
            </span><span class="type-file-box">
            <input class="type-file-file" id="default_store_logo" name="default_store_logo" type="file" size="30" hidefocus="true" nc_type="change_default_store_logo" title="<?php echo $lang['default_store_logo'];?>">
            </span></td>
          <td class="vatop tips">200px * 60px</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="default_store_logo">默认店铺头像:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.'/'.$output['list_setting']['default_store_avatar']);?>"></div>
            </span><span class="type-file-box">
            <input class="type-file-file" id="default_store_avatar" name="default_store_avatar" type="file" size="30" hidefocus="true" nc_type="change_default_store_avatar" title="<?php echo $lang['default_store_avatar'];?>">
            </span></td>
          <td class="vatop tips">100px * 100px</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="default_user_portrait"><?php echo $lang['default_user_pic'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.(ATTACH_COMMON.'/'.$output['list_setting']['default_user_portrait']);?>"></div>
            </span><span class="type-file-box">
            <input class="type-file-file" id="default_user_portrait" name="default_user_portrait" type="file" size="30" hidefocus="true" nc_type="change_default_user_portrait" title="<?php echo $lang['default_user_pic'];?>">
            </span></td>
          <td class="vatop tips">128px * 128px</td>
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
<script type="text/javascript">
$(function(){
// 模拟默认商品图片上传input type='file'样式
	var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
    $(textButton).insertBefore("#default_goods_image");
    $("#default_goods_image").change(function(){
	$("#textfield1").val($("#default_goods_image").val());
    });
// 模拟默认店铺图片上传input type='file'样式
	var textButton="<input type='text' name='textfield' id='textfield2' class='type-file-text' /><input type='button' name='button' id='button2' value='' class='type-file-button' />"
    $(textButton).insertBefore("#default_store_logo");
    $("#default_store_logo").change(function(){
	$("#textfield2").val($("#default_store_logo").val());
    });
    // 模拟默认店铺图片上传input type='file'样式
	var textButton="<input type='text' name='textfield' id='textfield3' class='type-file-text' /><input type='button' name='button' id='button3' value='' class='type-file-button' />"
    $(textButton).insertBefore("#default_store_avatar");
    $("#default_store_avatar").change(function(){
	$("#textfield3").val($("#default_store_avatar").val());
    });
// 模拟默认用户图片上传input type='file'样式
	var textButton="<input type='text' name='textfield' id='textfield4' class='type-file-text' /><input type='button' name='button' id='button4' value='' class='type-file-button' />"
    $(textButton).insertBefore("#default_user_portrait");
    $("#default_user_portrait").change(function(){
	$("#textfield4").val($("#default_user_portrait").val());
    });
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
});
</script> 
