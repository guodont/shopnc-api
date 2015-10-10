<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['web_set'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" id="settingForm" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['allowed_visitors_consult'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="guest_comment_enable" class="cb-enable <?php if($output['list_setting']['guest_comment'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="guest_comment_disabled" class="cb-disable <?php if($output['list_setting']['guest_comment'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="guest_comment_enable" name="guest_comment" <?php if($output['list_setting']['guest_comment'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="guest_comment_disabled" name="guest_comment" <?php if($output['list_setting']['guest_comment'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['allowed_visitors_consult_notice'];?></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><?php echo $lang['open_checkcode'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <input type="checkbox" value="1" name="captcha_status_login" id="captcha_status1" <?php if($output['list_setting']['captcha_status_login'] == '1'){ ?>checked="checked"<?php } ?> />
                <label for="captcha_status1"><?php echo $lang['front_login'];?></label>
              </li>
              <li>
                <input type="checkbox" value="1" name="captcha_status_register" id="captcha_status2" <?php if($output['list_setting']['captcha_status_register'] == '1'){ ?>checked="checked"<?php } ?> />
                <label for="captcha_status2"><?php echo $lang['front_regist'];?></label>
              </li>
              <li>
                <input type="checkbox" value="1" name="captcha_status_goodsqa" id="captcha_status3" <?php if($output['list_setting']['captcha_status_goodsqa'] == '1'){ ?>checked="checked"<?php } ?> />
                <label for="captcha_status3"><?php echo $lang['front_goodsqa'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips" >&nbsp;</td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.settingForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
