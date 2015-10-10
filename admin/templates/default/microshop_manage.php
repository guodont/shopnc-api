<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){

    //文件上传
    var textButton1="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />";
    $(textButton1).insertBefore("#microshop_logo");
    $("#microshop_logo").change(function(){
        $("#textfield1").val($("#microshop_logo").val());
    });
    var textButton2="<input type='text' name='textfield' id='textfield2' class='type-file-text' /><input type='button' name='button' id='button2' value='' class='type-file-button' />";
    $(textButton2).insertBefore("#microshop_header_pic");
    $("#microshop_header_pic").change(function(){
        $("#textfield2").val($("#microshop_header_pic").val());
    });
    var textButton3="<input type='text' name='textfield' id='textfield3' class='type-file-text' /><input type='button' name='button' id='button3' value='' class='type-file-button' />";
    $(textButton3).insertBefore("#microshop_store_banner");
    $("#microshop_store_banner").change(function(){
        $("#textfield3").val($("#microshop_store_banner").val());
    });
    $("input[nc_type='microshop_image']").live("change", function(){
		var src = getFullPath($(this)[0]);
		$(this).parent().prev().find('.low_source').attr('src',src);
		$(this).parent().find('input[class="type-file-text"]').val($(this).val());
	});

    $("#submit").click(function(){
        $("#add_form").submit();
    });

});
</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_microshop_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=microshop&op=manage_save">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="microshop_isuse"><?php echo $lang['microshop_isuse'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="isuse_1" class="cb-enable <?php if($output['setting']['microshop_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="isuse_0" class="cb-disable <?php if($output['setting']['microshop_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="isuse_1" name="microshop_isuse" value="1" <?php echo $output['setting']['microshop_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="isuse_0" name="microshop_isuse" value="0" <?php echo $output['setting']['microshop_isuse']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['microshop_isuse_explain'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="microshop_style"><?php echo $lang['microshop_style'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['setting']['microshop_style'];?>" name="microshop_style" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['microshop_style_explain'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="class_image"><?php echo $lang['nc_microshop'].'LOGO'.$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"> <img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview">
              <?php if(empty($output['setting']['microshop_logo'])) { ?>
              <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MICROSHOP.DS.'default_logo_image.png';?>">
              <?php } else { ?>
              <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MICROSHOP.DS.$output['setting']['microshop_logo'];?>">
              <?php } ?>
            </div>
            </span> <span class="type-file-box">
            <input name="microshop_logo" type="file" class="type-file-file" id="microshop_logo" size="30" hidefocus="true" nc_type="microshop_image">
            </span></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="class_image"><?php echo $lang['microshop_header_image'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"> <img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview">
              <?php if(empty($output['setting']['microshop_header_pic'])) { ?>
              <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MICROSHOP.DS.'default_header_pic_image.png';?>">
              <?php } else { ?>
              <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MICROSHOP.DS.$output['setting']['microshop_header_pic'];?>">
              <?php } ?>
            </div>
            </span> <span class="type-file-box">
            <input name="microshop_header_pic" type="file" class="type-file-file" id="microshop_header_pic" size="30" hidefocus="true" nc_type="microshop_image">
            </span></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="microshop_personal_limit"><?php echo $lang['microshop_personal_limit'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['setting']['microshop_personal_limit'];?>" name="microshop_personal_limit" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['microshop_personal_limit_explain'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['taobao_api_isuse'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="isuse_1" class="cb-enable <?php if($output['setting']['taobao_api_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="isuse_0" class="cb-disable <?php if($output['setting']['taobao_api_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="isuse_1" name="taobao_api_isuse" value="1" <?php echo $output['setting']['taobao_api_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="isuse_0" name="taobao_api_isuse" value="0" <?php echo $output['setting']['taobao_api_isuse']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['taobao_api_isuse_explain'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="taobao_app_key"><?php echo $lang['taobao_app_key'].'(APP KEY)'.$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['setting']['taobao_app_key'];?>" name="taobao_app_key" class="txt"></td>
          <td class="vatop tips"><a style="color:#ffffff; font-weight:bold;" target="_blank" href="http://open.taobao.com"><?php echo $lang['taobao_app_key_explain'];?></a></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="taobao_secret_key"><?php echo $lang['taobao_secret_key'].'(APP SECRET)'.$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['setting']['taobao_secret_key'];?>" name="taobao_secret_key" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label for="microshop_seo_keywords"><?php echo $lang['microshop_seo_keywords'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['setting']['microshop_seo_keywords'];?>" name="microshop_seo_keywords" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="microshop_seo_description"><?php echo $lang['microshop_seo_description'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['setting']['microshop_seo_description'];?>" name="microshop_seo_description" class="txt"></td>
          <td class="vatop tips"></td>
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
