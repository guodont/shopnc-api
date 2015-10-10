<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncsc-flow-layout">
  <div class="ncsc-flow-container">
    <div class="title">
      <h3>退款服务</h3>
    </div>
    <div id="saleRefund">
      <div class="ncsc-flow-step">
        <dl class="step-first current">
          <dt>买家申请退款</dt>
          <dd class="bg"></dd>
        </dl>
        <dl class="<?php echo $output['refund']['seller_time'] > 0 ? 'current':'';?>">
          <dt>商家处理退款申请</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="<?php echo $output['refund']['admin_time'] > 0 ? 'current':'';?>">
          <dt>平台审核，退款完成</dt>
          <dd class="bg"> </dd>
        </dl>
      </div>
    </div>
    <div class="ncsc-form-default">
      <h3>买家退款申请</h3>
      <dl>
        <dt>退款编号：</dt>
        <dd><?php echo $output['refund']['refund_sn']; ?></dd>
      </dl>
      <dl>
        <dt>申请人（买家）：</dt>
        <dd><?php echo $output['refund']['buyer_name']; ?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['refund_buyer_message'].$lang['nc_colon'];?></dt>
        <dd> <?php echo $output['refund']['reason_info']; ?> </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['refund_order_refund'].$lang['nc_colon'];?></dt>
        <dd><strong class="red"><?php echo $lang['currency'];?><?php echo $output['refund']['refund_amount']; ?></strong></dd>
      </dl>
      <dl>
        <dt>退款说明：</dt>
        <dd> <?php echo $output['refund']['buyer_message']; ?> </dd>
      </dl>
      <dl>
        <dt>凭证上传：</dt>
        <dd>
          <?php if (is_array($output['pic_list']) && !empty($output['pic_list'])) { ?>
          <ul class="ncsc-evidence-pic">
            <?php foreach ($output['pic_list'] as $key => $val) { ?>
            <?php if(!empty($val)){ ?>
            <li><a href="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/refund/'.$val;?>" nctype="nyroModal" rel="gal" target="_blank"> <img class="show_image" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_PATH.'/refund/'.$val;?>"></a></li>
            <?php } ?>
            <?php } ?>
          </ul>
          <?php } ?>
        </dd>
      </dl>
      <form id="post_form" method="post" action="index.php?act=store_refund&op=edit&refund_id=<?php echo $output['refund']['refund_id']; ?>">
        <input type="hidden" name="form_submit" value="ok" />
        <h3>商家处理意见</h3>
        <dl>
          <dt><i class="required">*</i><?php echo $lang['refund_seller_confirm'].$lang['nc_colon'];?></dt>
          <dd>
            <label class="mr20">
              <input type="radio" class="radio vm" name="seller_state" value="2" />
              同意</label>
            <label>
              <input type="radio" class="radio vm" name="seller_state" value="3" />
              拒绝</label>
              <span class="error"></span>
          </dd>
        </dl>
        <dl>
          <dt><i class="required">*</i><?php echo $lang['refund_message'].$lang['nc_colon'];?></dt>
          <dd>
            <textarea name="seller_message" rows="2" class="textarea w300"></textarea>
            <span class="error"></span>
            <p class="hint">只能提交一次，请认真选择。<br>
              同意并经过平台确认后会将金额以预存款的形式返还给买家。<br>
              不同意时买家可以向平台投诉或再次申请。</p>
          </dd>
        </dl>
        <div class="bottom">
          <label class="submit-border">
            <a class="submit" id="confirm_button"><?php echo $lang['nc_ok'];?></a>
          </label>
          <label class="submit-border">
            <a href="javascript:history.go(-1);" class="submit"><i class="icon-reply"></i>返回列表</a>
          </label>
        </div>
      </form>
    </div>
  </div>
  <?php require template('seller/store_refund_right');?>
</div>
<script type="text/javascript">
$(function(){
    $("#confirm_button").click(function(){
        $("#post_form").submit();
    });
    $('#post_form').validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parentsUntil('dl').find('span.error'));
        },
		submitHandler:function(form){
			ajaxpost('post_form', '', '', 'onerror')
		},
        rules : {
            seller_state : {
                required   : true
            },
            seller_message : {
                required   : true
            }
        },
        messages : {
            seller_state  : {
                required  : '<i class="icon-exclamation-sign"></i><?php echo $lang['refund_seller_confirm_null'];?>'
            },
            seller_message  : {
                required   : '<i class="icon-exclamation-sign"></i><?php echo $lang['refund_message_null'];?>'
            }
        }
    });
});
</script>
