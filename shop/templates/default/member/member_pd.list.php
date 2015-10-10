<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
    <a class="ncm-btn ncm-btn-orange" title="在线充值" href="index.php?act=predeposit&op=recharge_add"> <i class="icon-shield"></i> 在线充值 </a> </div>
  <div class="alert"><span class="mr30"><?php echo $lang['predeposit_pricetype_available'].$lang['nc_colon']; ?><strong class="mr5 red" style="font-size: 18px;"><?php echo $output['member_info']['available_predeposit']; ?></strong><?php echo $lang['currency_zh'];?></span><span><?php echo $lang['predeposit_pricetype_freeze'].$lang['nc_colon']; ?><strong class="mr5 blue" style="font-size: 18px;"><?php echo $output['member_info']['freeze_predeposit']; ?></strong><?php echo $lang['currency_zh'];?></span></div>
  <form method="get" action="index.php">
    <table class="ncm-search-table">
      <input type="hidden" name="act" value="predeposit" />
      <input type="hidden" name="op" value="index" />
      <tr>
        <td>&nbsp;</td>
        <th><?php echo $lang['predeposit_rechargesn'];?></th>
        <td class="w160 tc"><input type="text" class="text w150" name="pdr_sn" value="<?php echo $_GET['"pdr_sn"'];?>"/></td>
        <td class="w70 tc"><label class="submit-border">
            <input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" />
          </label></td>
      </tr>
    </table>
  </form>
  <table class="ncm-default-table">
    <thead>
      <tr>
        <th><?php echo $lang['predeposit_rechargesn']; ?></th>
        <th class="w150"><?php echo $lang['predeposit_addtime']; ?></th>
        <th class="w150"><?php echo $lang['predeposit_payment']; ?></th>
        <th class="w150"><?php echo $lang['predeposit_recharge_price']; ?>(<?php echo $lang['currency_zh'];?>)</th>
        <th class="w150"><?php echo $lang['predeposit_paystate']; ?></th>
        <th class="w110"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($output['list'])>0) { ?>
      <?php foreach($output['list'] as $val) { ?>
      <tr class="bd-line">
        <td><?php echo $val['pdr_sn'];?></td>
        <td><?php echo date('Y-m-d H:i:s',$val['pdr_add_time']);?></td>
        <td><?php echo $val['pdr_payment_name'];?></td>
        <td class="red">+<?php echo $val['pdr_amount'];?></td>
        <td><?php echo intval($val['pdr_payment_state']) ? '已支付' : '未支付';?></td>
        <td class="ncm-table-handle"><?php if (!intval($val['pdr_payment_state'])){?>
          <span><a class="btn-green" href="index.php?act=buy&op=pd_pay&pay_sn=<?php echo $val['pdr_sn'];?>"> <i class="icon-shield"></i>
          <p>支付</p>
          </a></span> <span><a class="btn-red" href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=predeposit&op=recharge_del&id=<?php echo $val['pdr_id']; ?>');"><i class="icon-trash"></i>
          <p><?php echo $lang['nc_del'];?></p>
          </a></span>
          <?php }else{?>
          <span><a href="index.php?act=predeposit&op=recharge_show&id=<?php echo $val['pdr_id']; ?>" class="btn-blue"><i class="icon-eye-open"></i>
          <p><?php echo $lang['nc_view'];?></p>
          </a></span>
          <?php }?></td>
      </tr>
      <?php } ?>
      <?php } else {?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php if (count($output['list'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>