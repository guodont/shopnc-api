<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){

    //文件上传
    var textButton1="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />";
    $(textButton1).insertBefore("#cms_logo");
    $("#cms_store_banner").change(function(){
        $("#textfield3").val($("#cms_logo").val());
    });
    $("input[nc_type='cms_image']").live("change", function(){
        var src = getFullPath($(this)[0]);
        $(this).parent().prev().find('.low_source').attr('src',src);
        $(this).parent().find('input[class="type-file-text"]').val($(this).val());
    });

    $("input[nc_type='cms_image']").live("change", function(){
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
            <h3><?php echo $lang['nc_cms_manage'];?></h3>
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
  <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=cms_manage&op=cms_manage_save">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="cms_isuse"><?php echo $lang['cms_isuse'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="cms_isuse_1" class="cb-enable <?php if($output['setting']['cms_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="cms_isuse_0" class="cb-disable <?php if($output['setting']['cms_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="cms_isuse_1" name="cms_isuse" value="1" <?php echo $output['setting']['cms_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="cms_isuse_0" name="cms_isuse" value="0" <?php echo $output['setting']['cms_isuse']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['cms_isuse_explain'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="class_image"><?php echo $lang['nc_cms'].'LOGO'.$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"> <img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview">
              <?php if(empty($output['setting']['cms_logo'])) { ?>
              <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_CMS.DS.'cms_default_logo.png';?>">
              <?php } else { ?>
              <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_CMS.DS.$output['setting']['cms_logo'];?>">
              <?php } ?>
            </div>
            </span> <span class="type-file-box">
            <input name="cms_logo" type="file" class="type-file-file" id="cms_logo" size="30" hidefocus="true" nc_type="cms_image">
            </span></td>
          <td class="vatop tips"><?php echo $lang['cms_logo_explain'];?></td>
        </tr>
        <!-- 投稿需要审核 -->
        <tr>
          <td colspan="2" class="required"><label for="taobao_app_key"><?php echo $lang['cms_submit_verify'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="cms_submit_verify_flag_1" class="cb-enable <?php if($output['setting']['cms_submit_verify_flag'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="cms_submit_verify_flag_0" class="cb-disable <?php if($output['setting']['cms_submit_verify_flag'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="cms_submit_verify_flag_1" name="cms_submit_verify_flag" value="1" <?php echo $output['setting']['cms_submit_verify_flag']==1?'checked=checked':''; ?>>
            <input type="radio" id="cms_submit_verify_flag_0" name="cms_submit_verify_flag" value="0" <?php echo $output['setting']['cms_submit_verify_flag']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['cms_submit_verify_explain'];?></td>
        </tr>
        <!-- 允许评论 -->
        <tr>
          <td colspan="2" class="required"><label for="taobao_app_key"><?php echo $lang['cms_comment_allow'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="cms_comment_flag_1" class="cb-enable <?php if($output['setting']['cms_comment_flag'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="cms_comment_flag_0" class="cb-disable <?php if($output['setting']['cms_comment_flag'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="cms_comment_flag_1" name="cms_comment_flag" value="1" <?php echo $output['setting']['cms_comment_flag']==1?'checked=checked':''; ?>>
            <input type="radio" id="cms_comment_flag_0" name="cms_comment_flag" value="0" <?php echo $output['setting']['cms_comment_flag']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['cms_comment_allow_explain'];?></td>
        </tr>
        <!-- 允许心情 -->
        <tr>
          <td colspan="2" class="required"><label for="taobao_app_key"><?php echo $lang['cms_attitude_allow'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="cms_attitude_flag_1" class="cb-enable <?php if($output['setting']['cms_attitude_flag'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="cms_attitude_flag_0" class="cb-disable <?php if($output['setting']['cms_attitude_flag'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="cms_attitude_flag_1" name="cms_attitude_flag" value="1" <?php echo $output['setting']['cms_attitude_flag']==1?'checked=checked':''; ?>>
            <input type="radio" id="cms_attitude_flag_0" name="cms_attitude_flag" value="0" <?php echo $output['setting']['cms_attitude_flag']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['cms_attitude_allow_explain'];?></td>
        </tr>

        <!-- 淘宝接口开关 -->
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['taobao_api_isuse'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="taobao_isuse_1" class="cb-enable <?php if($output['setting']['taobao_api_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="taobao_isuse_0" class="cb-disable <?php if($output['setting']['taobao_api_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="taobao_isuse_1" name="taobao_api_isuse" value="1" <?php echo $output['setting']['taobao_api_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="taobao_isuse_0" name="taobao_api_isuse" value="0" <?php echo $output['setting']['taobao_api_isuse']==0?'checked=checked':''; ?>></td>
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
            <td colspan="2" class="required"><label for="cms_seo_title"><?php echo $lang['cms_seo_title'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['setting']['cms_seo_title'];?>" name="cms_seo_title" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label for="cms_seo_keywords"><?php echo $lang['cms_seo_keywords'];?>关键字<?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['setting']['cms_seo_keywords'];?>" name="cms_seo_keywords" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="cms_seo_description"><?php echo $lang['cms_seo_description'];?><?php echo $lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <textarea name="cms_seo_description" class="tarea" rows="6"><?php echo $output['setting']['cms_seo_description'];?></textarea>
            </td>
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
