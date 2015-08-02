<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['adv_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=adv&op=ap_manage"><span><?php echo $lang['ap_manage'];?></span></a></li>
        <li><a href="index.php?act=adv&op=adv&ap_id=<?php echo $output['adv_list'][0]['ap_id'];?>"><span><?php echo $lang['adv_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['adv_change'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="adv_form" enctype="multipart/form-data" method="post" name="advForm">
    <input type="hidden" name="ref_url" value="<?php echo $output['ref_url'];?>" />
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <?php foreach($output['adv_list'] as $k => $v){ ?>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="adv_name"><?php echo $lang['adv_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="adv_name" id="adv_name" class="txt" value="<?php echo $v['adv_title']; ?>"></td>
          <td class="vatop tips"></td>
        </tr>
        <?php foreach ($output['ap_info'] as $ap_k => $ap_v){ if($v['ap_id'] == $ap_v['ap_id']){ ?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['adv_ap_id'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $ap_v['ap_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['adv_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php switch ($ap_v['ap_class']){ case '0': echo $lang['adv_pic']; break; case '1': echo $lang['adv_word']; break; case '2': echo $lang['adv_slide']; break; case '3': echo "Flash"; break;} ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="adv_start_date"><?php echo $lang['adv_start_time'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="adv_start_date" id="adv_start_date" class="txt date" value="<?php echo date('Y-m-d',$v['adv_start_date']); ?>"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="adv_end_date"><?php echo $lang['adv_end_time'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="adv_end_date" id="adv_end_date" class="txt date" value="<?php echo date('Y-m-d',$v['adv_end_date']); ?>"></td>
          <td class="vatop tips"></td>
        </tr>
        <?php switch ($ap_v['ap_class']){ case '0': $pic_content = unserialize($v['adv_content']); $pic = $pic_content['adv_pic']; $url = $pic_content['adv_pic_url']; ?>
        <tr id="adv_pic" >
          <input type="hidden" name="mark" value="0">
          <td colspan="2" class="required"><label for="file_adv_pic"><?php echo $lang['adv_img_upload'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL."/".ATTACH_ADV."/".$pic;?>" onload="javascript:DrawImage(this,500,500);"></div>
            </span><span class="type-file-box">
            <input type="file" class="type-file-file" id="file_adv_pic" name="adv_pic" size="30" />
            </span>
            <input type="hidden" name="pic_ori" value="<?php echo $pic;?>"></td>
          <td class="vatop tips"><?php echo $lang['adv_edit_support'];?>gif,jpg,jpeg,png </td>
        </tr>
        <tr id="adv_pic_url">
          <td colspan="2" class="required"><label for="adv_pic_url"><?php echo $lang['adv_url'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="adv_pic_url" name="adv_pic_url" value="<?php echo $url; ?>" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['adv_url_donotadd'];?></td>
        </tr>
        <?php break; case '1': $word_content = unserialize($v['adv_content']); $word = $word_content['adv_word']; $url = $word_content['adv_word_url']; ?>
        <tr id="adv_word" >
          <input type="hidden" name="mark" value="1">
          <td colspan="2" class="required"><label for="adv_word"><?php echo $lang['adv_word_content'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="adv_word" id="adv_word" class="txt" value="<?php echo $word; ?>"></td>
          <td class="vatop tips"><?php echo $lang['adv_max'];?><?php echo $ap_v['ap_width'];?><?php echo $lang['adv_byte'];?>
            <input type="hidden" name="adv_word_len" value="<?php echo $ap_v['ap_width'];?>" ></td>
        </tr>
        <tr id="adv_word_url">
          <td colspan="2" class="required"><label for="adv_word_url"><?php echo $lang['adv_url'];?>:</label></td>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="adv_word_url" class="txt"  id="adv_word_url" value="<?php echo $url; ?>"></td>
          <td class="vatop tips"><?php echo $lang['adv_url_donotadd'];?>
            </label></td>
        </tr>
        <?php break; case '3': $flash_content = unserialize($v['adv_content']); $flash = $flash_content['flash_swf']; $url = $flash_content['flash_url']; ?>
        <tr id="adv_flash_swf">
          <input type="hidden" name="mark" value="3">
          <td colspan="2" class="required"><label class="file_flash_swf"><?php echo $lang['adv_flash_upload'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-box">
            <input type="file" name="flash_swf" class="type-file-file" id="file_flash_swf" size="30"/>
            </span></td>
          <td class="vatop tips"><?php echo $lang['adv_please_file_swf_file']; ?></td>
        </tr>
        <tr>
          <td><a href="http://<?php echo $url; ?>" target='_blank'>
            <button style="width:<?php echo $ap_v['ap_width']; ?>px; height:<?php echo $ap_v['ap_height']; ?>px; border:none; padding:0; background:none;" disabled >
            <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $ap_v['ap_width']; ?>" height="<?php echo $ap_v['ap_height']; ?>">
              <param name="movie" value="<?php echo UPLOAD_SITE_URL."/".ATTACH_ADV."/".$flash;?>" />
              <param name="quality" value="high" />
              <param name="wmode" value="opaque" />
              <param name="swfversion" value="9.0.45.0" />
              <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
              <param name="expressinstall" value="<?php echo RESOURCE_SITE_URL;?>/js/expressInstall.swf" />
              <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 -->
              <object type="application/x-shockwave-flash" data="<?php echo UPLOAD_SITE_URL."/".ATTACH_ADV."/".$flash;?>" width="<?php echo $ap_v['ap_width']; ?>" height="<?php echo $ap_v['ap_height']; ?>">
                <param name="quality" value="high" />
                <param name="wmode" value="opaque" />
                <param name="swfversion" value="9.0.45.0" />
                <param name="expressinstall" value="<?php echo RESOURCE_SITE_URL;?>/js/expressInstall.swf" />
                <!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 -->
                <h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4>
                <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获取 Adobe Flash Player" width="112" height="33" /></a></p>
              </object>
            </object>
            </button>
            <input type="hidden" name="flash_ori" value="<?php echo $flash;?>">
            </a></td>
          <td></td>
        </tr>
        <tr id="adv_flash_url">
          <td colspan="2" class="required"><label for="flash_url"><?php echo $lang['adv_url'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="flash_url" id="flash_url" class="txt" value="<?php echo $url; ?>"></td>
          <td class="vatop tips"><?php echo $lang['adv_url_donotadd'];?></td>
        </tr>
        <?php }?>
        <?php }?>
        <?php }?>
        <?php }?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" onclick="document.advForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
    $('#adv_start_date').datepicker({dateFormat: 'yy-mm-dd'});
    $('#adv_end_date').datepicker({dateFormat: 'yy-mm-dd'});
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
});
</script>