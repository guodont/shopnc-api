<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-flow-layout">
  <div class="ncm-flow-container">
    <div class="title">
      <h3>服务类型：退款</h3>
    </div>
    <div class="alert">
      <h4>操作提示：</h4>
      <ul>
        <li>1. 若您对订单进行支付后想取消购买且与商家达成一致退款，请填写<em>“订单退款”</em>内容并提交。</li>
        <li>2. 成功完成退款/退货；经过商城审核后，会将退款金额以<em>“预存款”</em>的形式返还到您的余额账户中（充值卡部分只能退回到充值卡余额）。</li>
      </ul>
    </div>
    <div id="saleRefund" show_id="1">
      <div class="ncm-flow-step">
        <dl class="step-first current">
          <dt>买家申请退款</dt>
          <dd class="bg"></dd>
        </dl>
        <dl class="">
          <dt>商家处理退款申请</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="">
          <dt>平台审核，退款完成</dt>
          <dd class="bg"> </dd>
        </dl>
      </div>
      <div class=" ncm-default-form">
        <div id="warning"></div>
        <form id="post_form1" enctype="multipart/form-data" method="post" action="index.php?act=member_refund&op=add_refund_all&order_id=<?php echo $output['order']['order_id']; ?>&goods_id=<?php echo $output['goods']['rec_id']; ?>">
          <input type="hidden" name="form_submit" value="ok" />
          <h3>如果商家不同意，可以再次申请或投诉。</h3>
          <dl>
            <dt>退款原因：</dt>
            <dd>取消订单，全部退款</dd>
          </dl>
          <dl>
            <dt><i class="required">*</i>退款金额：</dt>
            <dd><strong class="green"><?php echo ncPriceFormat($output['order']['order_amount']); ?></strong> 元</dd>
          </dl>
          <dl>
            <dt><i class="required">*</i>退款说明：</dt>
            <dd>
              <textarea name="buyer_message" rows="3" class="textarea w400"></textarea>
              <br />
              <span class="error"></span> </dd>
          </dl>
          <dl>
            <dt>上传凭证：</dt>
            <dd>
              <p>
                <input name="refund_pic1" type="file" />
                <span class="error"></span> </p>
              <p>
                <input name="refund_pic2" type="file" />
                <span class="error"></span> </p>
              <p>
                <input name="refund_pic3" type="file" />
                <span class="error"></span> </p>
            </dd>
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
  <?php require template('member/member_refund_right');?>
</div>
<script type="text/javascript">
$(function(){
    $('#post_form1').validate({
		errorPlacement: function(error, element){
			error.appendTo(element.nextAll('span.error'));
        },
		submitHandler:function(form){
			ajaxpost('post_form1', '', '', 'onerror')
		},
        rules : {
            buyer_message : {
                required   : true
            },
            refund_pic1 : {
                accept : 'jpg|jpeg|gif|png'
            },
            refund_pic2 : {
                accept : 'jpg|jpeg|gif|png'
            },
            refund_pic3 : {
                accept : 'jpg|jpeg|gif|png'
            }
        },
        messages : {
            buyer_message  : {
                required   : '<i class="icon-exclamation-sign"></i>请填写退款说明'
            },
            refund_pic1: {
                accept : '<i class="icon-exclamation-sign"></i>图片必须是jpg/jpeg/gif/png格式'
            },
            refund_pic2: {
                accept : '<i class="icon-exclamation-sign"></i>图片必须是jpg/jpeg/gif/png格式'
            },
            refund_pic3: {
                accept : '<i class="icon-exclamation-sign"></i>图片必须是jpg/jpeg/gif/png格式'
            }
        }
    });
});
</script>