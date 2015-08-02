<div class="eject_con">
  <form id="post_form" method="post" action="index.php?act=member_return&op=delay&return_id=<?php echo $output['return']['refund_id']; ?>" onsubmit="ajaxpost('post_form','','','onerror')">
    <input type="hidden" name="form_submit" value="ok" />
    <div style="padding: 20px 40px;"> 商家选择没收到已经发货的商品，请联系物流进行确认，提交后将重新计时，商家可以再次确认收货。
    </div>
    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" id="confirm_button" value="<?php echo $lang['nc_ok'];?>" />
      </label><a class="ncm-btn ml5" href="javascript:DialogManager.close('return_delay');">取消</a>
    </div>
  </form>
</div>
