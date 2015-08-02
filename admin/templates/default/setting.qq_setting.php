<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['account_syn'];?></h3>
	<?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['qq_isuse'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="qq_isuse_1" class="cb-enable <?php if($output['list_setting']['qq_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['qq_isuse_open'];?>"><span><?php echo $lang['qq_isuse_open'];?></span></label>
            <label for="qq_isuse_0" class="cb-disable <?php if($output['list_setting']['qq_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['qq_isuse_close'];?>"><span><?php echo $lang['qq_isuse_close'];?></span></label>
            <input type="radio" id="qq_isuse_1" name="qq_isuse" value="1" <?php echo $output['list_setting']['qq_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="qq_isuse_0" name="qq_isuse" value="0" <?php echo $output['list_setting']['qq_isuse']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['qqSettings_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="qq_appcode"><?php echo $lang['qq_appcode'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="qq_appcode" rows="6" class="tarea" id="qq_appcode"><?php echo $output['list_setting']['qq_appcode'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="qq_appid"><?php echo $lang['qq_appid'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="qq_appid" name="qq_appid" value="<?php echo $output['list_setting']['qq_appid'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"><a style="color:#ffffff; font-weight:bold;" target="_blank" href="http://connect.qq.com"><?php echo $lang['qq_apply_link']; ?></a></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="qq_appkey"><?php echo $lang['qq_appkey'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="qq_appkey" name="qq_appkey" value="<?php echo $output['list_setting']['qq_appkey'];?>" class="txt" type="text"></td>
          <td class="vatop tips">&nbsp;</td>
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
