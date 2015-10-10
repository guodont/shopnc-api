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
        <h3>商家处理意见</h3>
        <dl>
          <dt><?php echo '处理状态'.$lang['nc_colon'];?></dt>
          <dd> <?php echo $output['state_array'][$output['return']['seller_state']]; ?> </dd>
        </dl>
        <?php if ($output['return']['seller_time'] > 0) { ?>
        <dl>
          <dt><?php echo $lang['refund_seller_message'].$lang['nc_colon'];?></dt>
          <dd> <?php echo $output['return']['seller_message']; ?> </dd>
        </dl>
        <?php } ?>
        <?php if ($output['return']['express_id'] > 0 && !empty($output['return']['invoice_no'])) { ?>
        <dl>
          <dt><?php echo '物流信息'.$lang['nc_colon'];?></dt>
          <dd> <?php echo $output['e_name'].' , '.$output['return']['invoice_no']; ?> </dd>
        </dl>
        <?php } ?>
        <?php if ($output['return']['receive_time'] > 0) { ?>
        <dl>
          <dt><?php echo '收货备注'.$lang['nc_colon'];?></dt>
          <dd> <?php echo $output['return']['receive_message']; ?> </dd>
        </dl>
        <?php } ?>
        <?php if ($output['return']['seller_state'] == 2 && $output['return']['refund_state'] >= 2) { ?>
        <h3>商城平台处理审核</h3>
        <dl>
          <dt><?php echo '平台确认'.$lang['nc_colon'];?></dt>
          <dd><?php echo $output['admin_array'][$output['return']['refund_state']]; ?></dd>
        </dl>
        <?php } ?>
        <?php if ($output['return']['admin_time'] > 0) { ?>
        <dl>
          <dt><?php echo '平台备注'.$lang['nc_colon'];?></dt>
          <dd> <?php echo $output['return']['admin_message']; ?> </dd>
        </dl>
        <?php } ?>
        <?php if ($output['return']['express_id'] > 0 && !empty($output['return']['invoice_no'])) { ?>
        <ul class="express-log" id="express_list">
          <li class="loading"><?php echo $lang['nc_common_loading'];?></li>
        </ul>
        <?php } ?>
        <div class="bottom">
            <label class=""><a href="javascript:history.go(-1);" class="ncsc-btn"><i class="icon-reply"></i>返回列表</a></label>
        </div>
      </div>
    </div>
  </div>
  <?php require template('seller/store_refund_right');?>
</div>


<?php if ($output['return']['express_id'] > 0 && !empty($output['return']['invoice_no'])) { ?>
<script type="text/javascript">
$(function(){
	$.getJSON('index.php?act=store_deliver&op=get_express&e_code=<?php echo $output['e_code'];?>&shipping_code=<?php echo $output['return']['invoice_no'];?>&t=<?php echo random(7);?>',function(data){
		if(data){
			$('#express_list').html('<li>物流信息数据</li>'+data);
		} else {
			$('#express_list').html('<li>没有相关物流信息数据</li>');
		}
	});
});
</script>
<?php } ?>
