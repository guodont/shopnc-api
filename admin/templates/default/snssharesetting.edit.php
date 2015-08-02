<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_binding_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=sns_sharesetting&op=sharesetting"><span><?php echo $lang['nc_binding_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['shareset_edit_title'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
      	<tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['shareset_list_appname'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['edit_arr']['name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['shareset_edit_appisuse'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="isuse_1" class="cb-enable <?php if($output['edit_arr']['isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="isuse_0" class="cb-disable <?php if($output['edit_arr']['isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="isuse_1" name="isuse" value="1" <?php echo $output['edit_arr']['isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="isuse_0" name="isuse" value="0" <?php echo $output['edit_arr']['isuse']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"></td>
        </tr>
        <?php if(isset($output['edit_arr']['appcode'])){?>
        <tr>
          <td colspan="2" class="required"><label for="appcode"><?php echo $lang['shareset_edit_appcode'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="appcode" rows="6" class="tarea" id="appcode"><?php echo $output['edit_arr']['appcode'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <?php }?>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="appid"><?php echo $lang['shareset_edit_appid'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="appid" name="appid" value="<?php echo $output['edit_arr']['appid'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><a href="<?php echo $output['edit_arr']['applyurl'];?>" target="_blank" style="color:#ffffff; font-weight:bold;"><?php echo $lang['shareset_edit_applylike'];?></a></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="appkey"><?php echo $lang['shareset_edit_appkey'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="appkey" name="appkey" value="<?php echo $output['edit_arr']['appkey'];?>" class="txt" type="text"></td>
          <td class="vatop tips">&nbsp;</td>
        </tr>
        <?php if(isset($output['edit_arr']['secretkey'])){?>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="appid"><?php echo 'Secret Key'.$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="secretkey" name="secretkey" value="<?php echo $output['edit_arr']['secretkey'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <?php }?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.settingForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>