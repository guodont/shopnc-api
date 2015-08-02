
<form id="post_form" method="post" action="index.php?act=member_return&op=ship&return_id=<?php echo $output['return']['refund_id']; ?>">
  <input type="hidden" name="form_submit" value="ok" />
  <h3>请填写退货发货信息</h3>
  <dl>
    <dt><?php echo '物流公司'.$lang['nc_colon'];?></dt>
    <dd>
      <select name="express_id">
        <option value="0">-请选择-</option>
        <?php if(!empty($output['express_list']) && is_array($output['express_list'])){?>
        <?php foreach($output['express_list'] as $key=> $val){?>
        <option value="<?php echo $val['id']; ?>"><?php echo $val['e_name']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </dd>
  </dl>
  <dl>
    <dt><i class="required">*</i><?php echo '物流单号'.$lang['nc_colon'];?></dt>
    <dd>
      <input type="text" class="text w150" name="invoice_no" value="" />
      <p class="hint">发货 <?php echo $output['return_delay'];?> 天后，当商家选择未收到则要进行延迟时间操作；
        如果超过 <?php echo $output['return_confirm'];?> 天不处理按弃货处理，直接由管理员确认退款。</p>
    </dd>
  </dl>
  <div class="bottom">
    <label class="submit-border">
      <input type="submit" class="submit" id="confirm_button" value="<?php echo $lang['nc_ok'];?>" />
    </label>
      <a href="javascript:history.go(-1);" class="ncm-btn ml10"><i class="icon-reply"></i>返回列表</a>
  </div>
</form>
<script type="text/javascript">
$(function(){
    $('#post_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
		submitHandler:function(form){
			ajaxpost('post_form', '', '', 'onerror')
		},
        rules : {
            invoice_no : {
                required   : true
            }
        },
        messages : {
            invoice_no  : {
                required   : '请填写物流单号'
            }
        }
    });
});
</script>
