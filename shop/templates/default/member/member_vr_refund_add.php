<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-flow-layout">
  <div class="ncm-flow-container">
    <div class="title">
      <h3>服务类型：退款</h3>
    </div>
    <div class="alert">
      <h4>操作提示：</h4>
      <ul>
        <li>1. 有效期内的未使用兑换码都可申请退款，同意退款后，会将退款金额以<em>“预存款”</em>的形式返还到您的余额账户中（充值卡部分只能退回到充值卡余额）。</li>
        <li>2. 已过期兑换码如果“支持过期退款”，请在到期后<em>“<?php echo CODE_INVALID_REFUND;?>天内”</em>申请退款，<?php echo CODE_INVALID_REFUND;?>天后则不能申请。</li>
        <li>3. 如果平台不同意退款，自动解除兑换码的锁定状态，在有效期内可以继续兑换使用。</li>
      </ul>
    </div>
    <div id="saleRefund" show_id="1">
      <div class="ncm-flow-step">
        <dl class="step-first current">
          <dt>买家申请退款</dt>
          <dd class="bg"></dd>
        </dl>
        <dl class="">
          <dt>锁定兑换码</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="">
          <dt>平台审核，退款完成</dt>
          <dd class="bg"> </dd>
        </dl>
      </div>
      <div class=" ncm-default-form">
        <div id="warning"></div>
        <form id="post_form1" enctype="multipart/form-data" method="post" action="index.php?act=member_vr_refund&op=add_refund&order_id=<?php echo $output['order']['order_id']; ?>">
          <input type="hidden" name="form_submit" value="ok" />
          <h3>如果提交退款保存成功，选择的对应兑换码将被锁定即不能进行兑换。</h3>
          <dl>
            <dt><i class="required">*</i>可退款兑换码：</dt>
            <dd>
                <?php if (is_array($output['code_list']) && !empty($output['code_list'])) { ?>
                <?php foreach ($output['code_list'] as $key => $val) { ?>
                <label><input name="rec_id[]" class="vm" type="checkbox" value="<?php echo $val['rec_id'];?>" checked="checked" /><?php echo $val['vr_code'];?></label><br />
                <?php } ?>
                <?php } ?>
              <span class="error"></span>
                </dd>
          </dl>
          <dl>
            <dt><i class="required">*</i>退款说明：</dt>
            <dd>
              <textarea name="buyer_message" rows="3" class="textarea w400"></textarea>
              <br />
              <span class="error"></span> </dd>
          </dl>
          <div class="bottom">
            <label class="submit-border">
              <input type="submit" class="submit" value="确认提交" />
            </label>
            <a href="javascript:history.go(-1);" class="ncm-btn ml10">取消并返回</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php require template('member/member_vr_refund_right');?>
</div>
<script type="text/javascript">
$(function(){
    $('#post_form1').validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parentsUntil('dl').find('span.error'));
        },
		submitHandler:function(form){
			ajaxpost('post_form1', '', '', 'onerror')
		},
        rules : {
            'rec_id[]' : {
                required   : true
            },
            'buyer_message' : {
                required   : true
            }
        },
        messages : {
            'rec_id[]'  : {
                required  : '<i class="icon-exclamation-sign"></i>请选择兑换码'
            },
            'buyer_message'  : {
                required   : '<i class="icon-exclamation-sign"></i>请填写退款说明'
            }
        }
    });
});
</script>