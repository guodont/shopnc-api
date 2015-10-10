<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <div class="ncm-default-form">
    <dl>
      <dt><?php echo $lang['predeposit_rechargesn'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdr_sn']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_payment'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdr_payment_name']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_recharge_price'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdr_amount']; ?> <?php echo $lang['currency_zh']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_addtime'].$lang['nc_colon'];?></dt>
      <dd><?php echo @date('Y-m-d H:i:s',$output['info']['pdr_add_time']); ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_paytime'].$lang['nc_colon'];?></dt>
      <dd><?php echo intval(date('His',$output['info']['pdr_payment_time'])) ? date('Y-m-d H:i:s',$output['info']['pdr_payment_time']) : date('Y-m-d',$output['info']['pdr_payment_time']); ?></dd>
    </dl>
    <dl>
      <dt><?php echo $output['info']['pdr_payment_name'].$lang['predeposit_trade_no'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdr_trade_sn']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_paystate'].$lang['nc_colon'];?></dt>
      <dd><?php echo !intval($output['info']['pdr_payment_state']) ? L('predeposit_rechargewaitpaying'): L('predeposit_rechargepaysuccess'); ?></dd>
    </dl>
    <dl class="sumbit">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit"  class="submit" value="<?php echo $lang['predeposit_backlist'];?>" onclick="window.location='<?php echo $_SERVER['HTTP_REFERER'];?>'"/>
      </dd>
    </dl>
  </div>
</div>
