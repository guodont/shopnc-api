<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_setting'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_circle_setting'];?></span></a></li>
        <li><a href="index.php?act=circle_setting&op=seo"><span><?php echo $lang['circle_setting_seo'];?></span></a></li>
        <li><a href="index.php?act=circle_setting&op=sec"><span><?php echo $lang['circle_setting_sec'];?></span></a></li>
        <li><a href="index.php?act=circle_setting&op=exp"><span><?php echo $lang['circle_setting_exp'];?></span></a></li>
        <li><a href="index.php?act=circle_setting&op=superadd"><span>设置超管</span></a></li>
        <li><a href="index.php?act=circle_setting&op=super_list"><span>超管列表</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  
    <table id="prompt" class="table tb-type2">
      <tbody>
        <tr class="space odd">
          <th colspan="12" class="nobg"> <div class="title">
              <h5><?php echo $lang['nc_prompts'];?></h5>
              <span class="arrow"></span> </div>
          </th>
        </tr>
        <tr class="odd">
          <td>
            <ul>
              <li><?php echo $lang['circle_setting_prompts_one'];?></li>
              <li><?php echo $lang['circle_setting_prompts_two'];?></li>
              <li><?php echo $lang['circle_setting_prompts_three'];?></li>
            </ul>
          </td>
        </tr>
      </tbody>
    </table>
  <form id="circle_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="old_c_logo" value="<?php echo $output['list_setting']['circle_logo'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="c_isuse"><?php echo $lang['circle_setting_isuse'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="c_isuse1" class="cb-enable <?php if($output['list_setting']['circle_isuse'] == 1) echo 'selected';?>" ><span><?php echo $lang['open'];?></span></label>
            <label for="c_isuse0" class="cb-disable <?php if($output['list_setting']['circle_isuse'] == 0) echo 'selected';?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="c_isuse1" name="c_isuse" <?php if($output['list_setting']['circle_isuse'] == 1) echo 'checked="checked"';?> value="1" type="radio">
            <input id="c_isuse0" name="c_isuse" <?php if($output['list_setting']['circle_isuse'] == 0) echo 'checked="checked"';?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['circle_setting_isuse_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_name"><?php echo $lang['circle_setting_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="c_name" id="c_name" class="txt" value="<?php echo $output['list_setting']['circle_name'];?>"></td>
          <td class="vatop tips"><?php echo $lang['circle_setting_name_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['circle_setting_logo'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_CIRCLE.DS.$output['list_setting']['circle_logo'];?>"></div>
            </span><span class="type-file-box">
              <input type='text' name='textfield' id='textfield' class='type-file-text' />
              <input type='button' name='button' id='button' value='' class='type-file-button' />
              <input name="c_logo" type="file" class="type-file-file" id="c_logo" size="30" hidefocus="true" />
            </span>
          </td>
          <td class="vatop tips"><?php echo $lang['circle_setting_logo_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_iscreate"><?php echo $lang['circle_setting_iscreate'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="c_iscreate1" class="cb-enable <?php if($output['list_setting']['circle_iscreate'] == 1) echo 'selected';?>"><span><?php echo $lang['open'];?></span></label>
            <label for="c_iscreate0" class="cb-disable <?php if($output['list_setting']['circle_iscreate'] == 0) echo 'selected';?>"><span><?php echo $lang['close'];?></span></label>
            <input id="c_iscreate1" name="c_iscreate" <?php if($output['list_setting']['circle_iscreate'] == 1) echo 'checked="checked"';?> value="1" type="radio" />
            <input id="c_iscreate0" name="c_iscreate" <?php if($output['list_setting']['circle_iscreate'] == 0) echo 'checked="checked"';?> value="0" type="radio" />
          </td>
          <td class="vatop tips"><?php echo $lang['circle_setting_iscreate_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_istalk"><?php echo $lang['circle_setting_istalk'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="c_istalk1" class="cb-enable <?php if($output['list_setting']['circle_istalk'] == 1) echo 'selected';?>"><span><?php echo $lang['open'];?></span></label>
            <label for="c_istalk0" class="cb-disable <?php if($output['list_setting']['circle_istalk'] == 0) echo 'selected';?>"><span><?php echo $lang['close'];?></span></label>
            <input id="c_istalk1" name="c_istalk" <?php if($output['list_setting']['circle_istalk'] == 1) echo 'checked="checked"';?> value="1" type="radio" />
            <input id="c_istalk0" name="c_istalk" <?php if($output['list_setting']['circle_istalk'] == 0) echo 'checked="checked"';?> value="0" type="radio" />
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_createsum"><?php echo $lang['circle_setting_create_sum'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="c_createsum" id="c_createsum" class="txt" value="<?php echo $output['list_setting']['circle_createsum'];?>"></td>
          <td class="vatop tips"><?php echo $lang['circle_setting_create_sum_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_joinsum"><?php echo $lang['circle_setting_join_sum'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="c_joinsum" id="c_joinsum" class="txt" value="<?php echo $output['list_setting']['circle_joinsum'];?>"></td>
          <td class="vatop tips"><?php echo $lang['circle_setting_join_sum_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['circle_setting_manage_sum'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="c_managesum" id="c_managesum" class="txt" value="<?php echo $output['list_setting']['circle_managesum'];?>" /></td>
          <td class="vatop tips"><?php echo $lang['circle_setting_manage_sum_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_wordfilter"><?php echo $lang['circle_setting_wordfilter'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <textarea class="tarea" rows="6" name="c_wordfilter" id="c_wordfilter"><?php echo $output['list_setting']['circle_wordfilter'];?></textarea>
          </td>
          <td class="vatop tips"><?php echo $lang['circle_setting_wordfilter_tips'];?></td>
        </tr>
        <!-- 淘宝接口开关 -->
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['taobao_api_isuse'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="taobao_isuse_1" class="cb-enable <?php if($output['list_setting']['taobao_api_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="taobao_isuse_0" class="cb-disable <?php if($output['list_setting']['taobao_api_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="taobao_isuse_1" name="taobao_api_isuse" value="1" <?php echo $output['list_setting']['taobao_api_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="taobao_isuse_0" name="taobao_api_isuse" value="0" <?php echo $output['list_setting']['taobao_api_isuse']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['taobao_api_isuse_explain'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="taobao_app_key"><?php echo $lang['taobao_app_key'].'(APP KEY)'.$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['list_setting']['taobao_app_key'];?>" name="taobao_app_key" class="txt"></td>
          <td class="vatop tips"><a style="color:#ffffff; font-weight:bold;" target="_blank" href="http://open.taobao.com"><?php echo $lang['taobao_app_key_explain'];?></a></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="taobao_secret_key"><?php echo $lang['taobao_secret_key'].'(APP SECRET)'.$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['list_setting']['taobao_secret_key'];?>" name="taobao_secret_key" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script>
//按钮先执行验证再提交表单
$(function(){
	// 图片js
	$("#c_logo").change(function(){$("#textfield").val($("#c_logo").val());});
	$("#submitBtn").click(function(){
		$("#circle_form").submit();
	});
});
</script>
