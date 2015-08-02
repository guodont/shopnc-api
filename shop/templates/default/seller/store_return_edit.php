<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncsc-flow-layout">
  <div class="ncsc-flow-container">
    <div class="title">
      <h3>退货退款服务</h3>
    </div>
    <div id="saleRefundReturn">
      <div class="ncsc-flow-step">
        <dl class="step-first current">
          <dt>买家申请退货</dt>
          <dd class="bg"></dd>
        </dl>
        <dl class="<?php echo $output['return']['seller_time'] > 0 ? 'current':'';?>">
          <dt>商家处理退货申请</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="<?php echo ($output['return']['ship_time'] > 0 || $output['return']['return_type']==1) ? 'current':'';?>">
          <dt>买家退货给商家</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="<?php echo $output['return']['admin_time'] > 0 ? 'current':'';?>">
          <dt>确认收货，平台审核</dt>
          <dd class="bg"> </dd>
        </dl>
      </div>
      <div class="ncsc-form-default">
        <h3>买家退货退款申请</h3>
        <dl>
          <dt>退货退款编号：</dt>
          <dd><?php echo $output['return']['refund_sn']; ?> </dd>
        </dl>
        <dl>
          <dt>申请人（买家）：</dt>
          <dd><?php echo $output['return']['buyer_name']; ?></dd>
        </dl>
        <dl>
          <dt><?php echo $lang['return_buyer_message'].$lang['nc_colon'];?></dt>
          <dd> <?php echo $output['return']['reason_info']; ?> </dd>
        </dl>
        <dl>
          <dt>退款金额：</dt>
          <dd><?php echo $lang['currency'];?><?php echo $output['return']['refund_amount']; ?> </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['return_order_return'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['return']['return_type']==2 ? $output['return']['goods_num']:'无'; ?></dd>
        </dl>
        <dl>
          <dt>退货说明：</dt>
          <dd> <?php echo $output['return']['buyer_message']; ?> </dd>
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
        <form id="post_form" method="post" action="index.php?act=store_return&op=edit&return_id=<?php echo $output['return']['refund_id']; ?>">
          <input type="hidden" name="form_submit" value="ok" />
          <h3>商家处理意见</h3>
          <dl>
            <dt><i class="required">*</i><?php echo $lang['return_seller_confirm'].$lang['nc_colon'];?></dt>
            <dd>
              <div>
                <label class="mr20">
                  <input type="radio" class="vm" name="seller_state" value="2" />
                  同意</label>
                <label>
                  <input name="return_type" class="vm" type="checkbox" value="1" />
                  弃货</label>
                <p class="hint">如果选择弃货，买家将不用退回原商品，提交后直接由管理员确认退款。</p>
              </div>
              <div class="mt10">
                <label>
                  <input type="radio" class="vm" name="seller_state" value="3" />
                  拒绝</label>
              </div>
              <span class="error"></span>
            </dd>
          </dl>
          <dl>
            <dt><i class="required">*</i><?php echo $lang['return_message'].$lang['nc_colon'];?></dt>
            <dd>
              <textarea name="seller_message" rows="2" class="textarea w300"></textarea>
              <span class="error"></span>
              <p class="hint"> 如是同意退货，请及时关注买家的发货情况，并进行收货（发货5天后可以选择未收到，超过7天不处理按弃货处理）。<br>
              </p>
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
         submitHandler: function(form) {
			    	ajaxpost('post_form', '', '', 'onerror');
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
                required  : '<i class="icon-exclamation-sign"></i><?php echo $lang['return_seller_confirm_null'];?>'
            },
            seller_message  : {
                required   : '<i class="icon-exclamation-sign"></i><?php echo $lang['return_message_null'];?>'
            }
        }
	    });
});
</script>
