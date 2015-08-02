<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['account_syn'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <?php if ($output['is_exist']){?>
  <form method="post" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><?php echo $lang['sina_isuse'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="sina_isuse_1" class="cb-enable <?php if($output['list_setting']['sina_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['sina_isuse_open'];?>"><span><?php echo $lang['sina_isuse_open'];?></span></label>
            <label for="sina_isuse_0" class="cb-disable <?php if($output['list_setting']['sina_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['sina_isuse_close'];?>"><span><?php echo $lang['sina_isuse_close'];?></span></label>
            <input type="radio" id="sina_isuse_1" name="sina_isuse" value="1" <?php echo $output['list_setting']['sina_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="sina_isuse_0" name="sina_isuse" value="0" <?php echo $output['list_setting']['sina_isuse']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="sina_appcode"><?php echo $lang['sina_appcode'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="sina_appcode" rows="6" class="tarea" id="sina_appcode"><?php echo $output['list_setting']['sina_appcode'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="sina_wb_akey" class="validation"><?php echo $lang['sina_wb_akey'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="sina_wb_akey" name="sina_wb_akey" value="<?php echo $output['list_setting']['sina_wb_akey'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><a style="color:#ffffff; font-weight:bold;" target="_blank" href="http://open.weibo.com/developers"><?php echo $lang['sina_apply_link']; ?></a></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="sina_wb_skey" class="validation"><?php echo $lang['sina_wb_skey'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="sina_wb_skey" name="sina_wb_skey" value="<?php echo $output['list_setting']['sina_wb_skey'];?>" class="txt" type="text"></td>
          <td class="vatop tips">&nbsp;</td>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.settingForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <?php }else{ ?>
  <table class="table tb-type2">
    <tbody>
      <tr class="noborder">
        <td colspan="2" class="no_data"><?php echo $lang['sina_function_fail_tip']; ?></td>
      </tr>
    </tbody>
  </table>
  <?php }?>
</div>
