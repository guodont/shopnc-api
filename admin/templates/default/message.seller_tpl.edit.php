<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_message_set'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>平台可给商家提供站内信、短消息、邮件三种通知方式。平台可以选择开启一种或多种通知方式供商家选择。</li>
            <li>开启强制接收后，商家不能取消该方式通知的接收。</li>
            <li>短消息、邮件需要商家设置正确号码后才能正常接收。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <div class="homepage-focus" nctype="sellerTplContent">
    <h4>模板名称：<?php echo $output['smtpl_info']['smt_name'];?></h4>
    <ul class="tab-menu">
      <li class="current">站内信模板</li>
      <li>手机短信模板</li>
      <li>邮件模板</li>
    </ul>
    <!-- 站内信 S -->
    <form class="tab-content" method="post" name="message_form" >
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="code" value="<?php echo $output['smtpl_info']['smt_code'];?>" />
      <input type="hidden" name="type" value="message" />
      <table class="table tb-type2">
        <tbody>
          <tr class="noborder">
            <td colspan="2" class="required"><label>站内信开关:</label></td>
          </tr>
          <tr class="noborder">
            <td class="vatop rowform onoff">
              <label for="message_switch1" class="cb-enable <?php if($output['smtpl_info']['smt_message_switch'] == 1){?>selected<?php }?>"><span><?php echo $lang['open'];?></span></label>
              <label for="message_switch0" class="cb-disable <?php if($output['smtpl_info']['smt_message_switch'] == 0){?>selected<?php }?>"><span><?php echo $lang['close'];?></span></label>
              <input id="message_switch1" name="message_switch" <?php if($output['smtpl_info']['smt_message_switch'] == 1){?>checked="checked"<?php }?> value="1" type="radio">
              <input id="message_switch0" name="message_switch" <?php if($output['smtpl_info']['smt_message_switch'] == 0){?>checked="checked"<?php }?> value="0" type="radio"></td>
            <td class="vatop tips"></td>
          </tr>
          <tr>
            <td colspan="2" class="required"><label>强制接收:</label></td>
          </tr>
          <tr class="noborder">
            <td class="vatop rowform onoff">
              <label for="message_forced1" class="cb-enable <?php if($output['smtpl_info']['smt_message_forced'] == 1){?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
              <label for="message_forced0" class="cb-disable <?php if($output['smtpl_info']['smt_message_forced'] == 0){?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
              <input id="message_forced1" name="message_forced" <?php if($output['smtpl_info']['smt_message_forced'] == 1){?>checked="checked"<?php }?> value="1" type="radio">
              <input id="message_forced0" name="message_forced" <?php if($output['smtpl_info']['smt_message_forced'] == 0){?>checked="checked"<?php }?> value="0" type="radio"></td>
            <td class="vatop tips"></td>
          </tr>
          <tr>
            <td colspan="2" class="required"><label>消息内容:</label></td>
          </tr>
          <tr class="noborder">
            <td class="vatop rowform">
              <textarea name="message_content" rows="6" class="tarea"><?php echo $output['smtpl_info']['smt_message_content'];?></textarea>
            </td>
            <td class="vatop tips"></td>
          </tr>
        </tbody>
      </table>
      <div class="margintop">
        <a href="JavaScript:void(0);" onclick="document.message_form.submit();" class="btn"><span><?php echo $lang['nc_submit'];?></span></a>
      </div>
    </form>
    <!-- 站内信 E -->
    <!-- 短消息 S -->
    <form class="tab-content" method="post" name="short_name" style="display:none;">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="code" value="<?php echo $output['smtpl_info']['smt_code'];?>" />
      <input type="hidden" name="type" value="short" />
      <table class="table tb-type2">
        <tbody>
          <tr class="noborder">
            <td colspan="2" class="required"><label>手机短信开关:</label></td>
          </tr>
          <tr class="noborder">
            <td class="vatop rowform onoff">
              <label for="short_switch1" class="cb-enable <?php if($output['smtpl_info']['smt_short_switch'] == 1){?>selected<?php }?>"><span><?php echo $lang['open'];?></span></label>
              <label for="short_switch0" class="cb-disable <?php if($output['smtpl_info']['smt_short_switch'] == 0){?>selected<?php }?>"><span><?php echo $lang['close'];?></span></label>
              <input id="short_switch1" name="short_switch" <?php if($output['smtpl_info']['smt_short_switch'] == 1){?>checked="checked"<?php }?> value="1" type="radio">
              <input id="short_switch0" name="short_switch" <?php if($output['smtpl_info']['smt_short_switch'] == 0){?>checked="checked"<?php }?> value="0" type="radio"></td>
            <td class="vatop tips"></td>
          </tr>
          <tr>
            <td colspan="2" class="required"><label>强制接收:</label></td>
          </tr>
          <tr class="noborder">
            <td class="vatop rowform onoff">
              <label for="short_forced1" class="cb-enable <?php if($output['smtpl_info']['smt_short_forced'] == 1){?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
              <label for="short_forced0" class="cb-disable <?php if($output['smtpl_info']['smt_short_forced'] == 0){?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
              <input id="short_forced1" name="short_forced" <?php if($output['smtpl_info']['smt_short_forced'] == 1){?>checked="checked"<?php }?> value="1" type="radio">
              <input id="short_forced0" name="short_forced" <?php if($output['smtpl_info']['smt_short_forced'] == 0){?>checked="checked"<?php }?> value="0" type="radio"></td>
            <td class="vatop tips"></td>
          </tr>
          <tr>
            <td colspan="2" class="required"><label>消息内容:</label></td>
          </tr>
          <tr class="noborder">
            <td class="vatop rowform">
              <textarea name="short_content" rows="6" class="tarea"><?php echo $output['smtpl_info']['smt_short_content'];?></textarea>
            </td>
            <td class="vatop tips"></td>
          </tr>
        </tbody>
      </table>
      <div class="margintop">
        <a href="JavaScript:void(0);" onclick="document.short_name.submit();" class="btn"><span><?php echo $lang['nc_submit'];?></span></a>
      </div>
    </form>
    <!-- 短消息 E -->
    <!-- 邮件 S -->
    <form class="tab-content" method="post" name="mail_form" style="display:none;">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="code" value="<?php echo $output['smtpl_info']['smt_code'];?>" />
      <input type="hidden" name="type" value="mail" />
      <table class="table tb-type2">
        <tbody>
          <tr class="noborder">
            <td colspan="2" class="required"><label>邮件开关:</label></td>
          </tr>
          <tr class="noborder">
            <td class="vatop rowform onoff">
              <label for="mail_switch1" class="cb-enable <?php if($output['smtpl_info']['smt_mail_switch'] == 1){?>selected<?php }?>"><span><?php echo $lang['open'];?></span></label>
              <label for="mail_switch0" class="cb-disable <?php if($output['smtpl_info']['smt_mail_switch'] == 0){?>selected<?php }?>"><span><?php echo $lang['close'];?></span></label>
              <input id="mail_switch1" name="mail_switch" <?php if($output['smtpl_info']['smt_mail_switch'] == 1){?>checked="checked"<?php }?> value="1" type="radio">
              <input id="mail_switch0" name="mail_switch" <?php if($output['smtpl_info']['smt_mail_switch'] == 0){?>checked="checked"<?php }?> value="0" type="radio"></td>
            <td class="vatop tips"></td>
          </tr>
          <tr>
            <td colspan="2" class="required"><label>强制接收:</label></td>
          </tr>
          <tr class="noborder">
            <td class="vatop rowform onoff">
              <label for="mail_forced1" class="cb-enable <?php if($output['smtpl_info']['smt_mail_forced'] == 1){?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
              <label for="mail_forced0" class="cb-disable <?php if($output['smtpl_info']['smt_mail_forced'] == 0){?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
              <input id="mail_forced1" name="mail_forced" <?php if($output['smtpl_info']['smt_mail_forced'] == 1){?>checked="checked"<?php }?> value="1" type="radio">
              <input id="mail_forced0" name="mail_forced" <?php if($output['smtpl_info']['smt_mail_forced'] == 0){?>checked="checked"<?php }?> value="0" type="radio"></td>
            <td class="vatop tips"></td>
          </tr>
          <tr>
            <td colspan="2" class="required"><label>邮件标题:</label></td>
          </tr>
          <tr class="noborder">
            <td class="vatop rowform">
              <textarea name="mail_subject" rows="6" class="tarea"><?php echo $output['smtpl_info']['smt_mail_subject'];?></textarea>
            </td>
            <td class="vatop tips"></td>
          </tr>
          <tr>
            <td colspan="2" class="required"><label>邮件内容:</label></td>
          </tr>
          <tr class="noborder">
            <td colspan="2"><?php showEditor('mail_content', $output['smtpl_info']['smt_mail_content']);?></td>
          </tr>
        </tbody>
      </table>
      <div class="margintop">
        <a href="JavaScript:void(0);" onclick="document.mail_form.submit();" class="btn"><span><?php echo $lang['nc_submit'];?></span></a>
      </div>
    </form>
    <!-- 邮件 E -->
  </div>
</div>
<script>
$(function(){
    $('div[nctype="sellerTplContent"] > ul').find('li').click(function(){
        $(this).addClass('current').siblings().removeClass('current');
        var _index = $(this).index();
        var _form = $('div[nctype="sellerTplContent"]').find('form');
        _form.hide();
        _form.eq(_index).show();
    });
});
</script>