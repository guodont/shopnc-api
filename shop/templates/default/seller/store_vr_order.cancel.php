<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="eject_con">
  <div id="warning"></div>
  <form method="post" id="order_cancel_form" onsubmit="ajaxpost('order_cancel_form', '', '', 'onerror');return false;" action="index.php?act=store_vr_order&op=change_state&state_type=order_cancel&order_id=<?php echo $output['order_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?></dt>
      <dd><span class="num"><?php echo trim($_GET['order_sn']); ?></span></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_order_cancel_reason'].$lang['nc_colon'];?></dt>
      <dd>
        <ul class="checked">
          <li>
            <input type="radio" checked name="state_info" id="d1" value="<?php echo $lang['store_order_lose_goods'];?>" />
            <label for="d1"><?php echo $lang['store_order_lose_goods'];?></label>
          </li>
          <li>
            <input type="radio" name="state_info" id="d2" value="<?php echo $lang['store_order_invalid_order'];?>" />
            <label for="d2"><?php echo $lang['store_order_invalid_order'];?></label>
          </li>
          <li>
            <input type="radio" name="state_info" id="d3" value="<?php echo $lang['store_order_buy_apply'];?>" />
            <label for="d3"><?php echo $lang['store_order_buy_apply'];?></label>
          </li>
          <li>
            <input type="radio" name="state_info" flag="other_reason" id="d4" value="" />
            <label for="d4"><?php echo $lang['store_order_other_reason'];?></label>
          </li>
          <li id="other_reason" style="display:none; height:48px;">
            <textarea name="state_info1" rows="2"  id="other_reason_input" style="width:200px;"></textarea>
          </li>
        </ul>
      </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" id="confirm_button" value="<?php echo $lang['nc_ok'];?>" />
      </dd>
    </dl>
  </form>
</div>
<script type="text/javascript">
$(function(){
        $('#cancel_button').click(function(){
            DialogManager.close('seller_order_cancel_order');
         });
       $("input[name='state_info']").click(function(){
        if ($(this).attr('flag') == 'other_reason')
        {
            $('#other_reason').show();
        }
        else
        {
            $('#other_reason').hide();
        }
    });
});
</script> 
