<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
    <a class="ncm-btn ncm-btn-orange" title="在线充值" href="index.php?act=predeposit&op=recharge_add" style="right: 207px;"><i class="icon-shield"></i>在线充值</a> <a class="ncm-btn ncm-btn-green" href="index.php?act=member_security&op=auth&type=pd_cash" style="right: 107px;"><i class="icon-money"></i>申请提现</a> <a class="ncm-btn ncm-btn-blue" href="index.php?act=predeposit&op=rechargecard_add"><i class="icon-shield"></i>充值卡充值</a> </div>
  <div class="alert"> <span class="mr30">可用充值卡余额：<strong class="mr5 red" style="font-size: 18px;"><?php echo $output['member_info']['available_rc_balance']; ?></strong><?php echo $lang['currency_zh']; ?></span> <span class="mr30">冻结充值卡余额：<strong class="mr5 blue" style="font-size: 18px;"><?php echo $output['member_info']['freeze_rc_balance']; ?></strong><?php echo $lang['currency_zh']; ?></span> </div>
  <table class="ncm-default-table">
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="w150 tl"><?php echo $lang['predeposit_addtime']; ?></th>
        <th class="w150 tl">收入(<?php echo $lang['currency_zh'];?>)</th>
        <th class="w150 tl">支出(<?php echo $lang['currency_zh'];?>)</th>
        <th class="w150 tl">冻结(<?php echo $lang['currency_zh'];?>)</th>
        <th class="tl"><?php echo $lang['predeposit_log_desc'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($output['list']) > 0) { ?>
      <?php foreach ($output['list'] as $v) { ?>
      <tr class="bd-line">
        <td></td>
        <td class="goods-time tl"><?php echo @date('Y-m-d H:i:s',$v['add_time']);?></td>
<?php $availableFloat = (float) $v['available_amount']; if ($availableFloat > 0) { ?>
        <td class="tl red">+<?php echo $v['available_amount']; ?></td>
        <td class="tl green"></td>
<?php } elseif ($availableFloat < 0) { ?>
        <td class="tl red"></td>
        <td class="tl green"><?php echo $v['available_amount']; ?></td>
<?php } else { ?>
        <td class="tl red"></td>
        <td class="tl green"></td>
<?php } ?>

        <td class="tl blue"><?php echo floatval($v['freeze_amount']) ? (floatval($v['freeze_amount']) > 0 ? '+' : null ).$v['freeze_amount'] : null;?></td>
        <td class="tl"><?php echo $v['description'];?></td>
      </tr>
      <?php } ?>
      <?php } else {?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php if (count($output['list']) > 0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
