<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <form method="post" name="form1" id="form1" action="<?php echo urlAdmin('goods', 'goods_verify');?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" value="<?php echo $output["commonids"];?>" name="commonids">
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label>审核通过:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="rewrite_enabled"  class="cb-enable selected" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="rewrite_disabled" class="cb-disable" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="rewrite_enabled" name="verify_state" checked="checked" value="1" type="radio">
            <input id="rewrite_disabled" name="verify_state" value="0" type="radio"></td>
          <td class="vatop tips">
            <?php echo $lang['open_rewrite_tips'];?></td>
        </tr>
        <tr nctype="reason" style="display: none;">
          <td colspan="2" class="required"><label for="verify_reason">未通过理由:</label></td>
        </tr>
        <tr class="noborder" nctype="reason" style="display :none;">
          <td class="vatop rowform"><textarea rows="6" class="tarea" cols="60" name="verify_reason" id="verify_reason"></textarea></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="javascript:void(0);" class="btn" nctype="btn_submit"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/admincp.js" charset="utf-8"></script>
<script>
$(function(){
    $('a[nctype="btn_submit"]').click(function(){
        ajaxpost('form1', '', '', 'onerror');
    });
    $('input[name="verify_state"]').click(function(){
        if ($(this).val() == 1) {
            $('tr[nctype="reason"]').hide();
        } else {
            $('tr[nctype="reason"]').show();
        }
    });
});
</script>