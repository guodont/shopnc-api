<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-flow-layout">
  <div class="ncm-flow-container">
    <div class="title">
      <h3>退款服务</h3>
    </div>
    <div class="alert">
      <h4>操作提示：</h4>
      <ul>
        <li>1. 同意退款后，会将退款金额以<em>“预存款”</em>的形式返还到您的余额账户中。</li>
        <li>2. 如果平台不同意退款，自动解除兑换码的锁定状态，在有效期内可以继续兑换使用。</li>
      </ul>
    </div>
    <div id="saleRefund" show_id="1">
      <div class="ncm-flow-step">
        <dl class="step-first current">
          <dt>买家申请退款</dt>
          <dd class="bg"></dd>
        </dl>
        <dl class="<?php echo $output['refund']['add_time'] > 0 ? 'current':'';?>">
          <dt>锁定兑换码</dt>
          <dd class="bg"> </dd>
        </dl>
        <dl class="<?php echo $output['refund']['admin_time'] > 0 ? 'current':'';?>">
          <dt>平台审核，退款完成</dt>
          <dd class="bg"> </dd>
        </dl>
      </div>
      <div class=" ncm-default-form">
      <h3>我的退款申请</h3>
        <dl>
          <dt><?php echo $lang['refund_order_refundsn'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['refund']['refund_sn']; ?> </dd>
        </dl>
        <dl>
          <dt>退款兑换码：</dt>
          <dd>
                <?php if (is_array($output['code_array']) && !empty($output['code_array'])) { ?>
                <?php foreach ($output['code_array'] as $key => $val) { ?>
                <?php echo $val;?><br />
                <?php } ?>
                <?php } ?>
          </dd>
        </dl>
        <dl>
          <dt>退款金额：</dt>
          <dd><?php echo $lang['currency'];?><?php echo $output['refund']['refund_amount']; ?> </dd>
        </dl>
        <dl>
          <dt>退款说明：</dt>
          <dd><?php echo $output['refund']['buyer_message']; ?> </dd>
        </dl>
        <h3>平台审核</h3>
        <dl>
          <dt><?php echo '审核状态'.$lang['nc_colon'];?></dt>
          <dd><?php echo $output['admin_array'][$output['refund']['admin_state']]; ?> </dd>
        </dl>
        <?php if ($output['refund']['admin_time'] > 0) { ?>
        <dl>
          <dt><?php echo '平台备注'.$lang['nc_colon'];?></dt>
          <dd><?php echo $output['refund']['admin_message']; ?> </dd>
        </dl>
        <?php } ?><div class="bottom"><a href="javascript:history.go(-1);" class="ncm-btn"><i class="icon-reply"></i>返回列表</a></div>
      </div>
    </div>
  </div>
  <?php require template('member/member_vr_refund_right');?>
</div>