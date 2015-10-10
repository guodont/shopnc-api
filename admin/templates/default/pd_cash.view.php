<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_predepositmanage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=predeposit&op=predeposit"><span><?php echo $lang['admin_predeposit_rechargelist']?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_predeposit_cashmanage']; ?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_sn'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdc_sn']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_membername'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdc_member_name']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_cash_price'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdc_amount']; ?>&nbsp;<?php echo $lang['currency_zh'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_cash_shoukuanbank']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdc_bank_name']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_cash_shoukuanaccount'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdc_bank_no']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_cash_shoukuanname']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdc_bank_user']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php if (intval($output['info']['pdc_payment_time'])) {?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_paytime']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo @date('Y-m-d',$output['info']['pdc_payment_time']); ?> 
          ( <?php echo $lang['admin_predeposit_adminname'];?>: <?php echo $output['info']['pdc_payment_admin'];?> ) </td>
          <td class="vatop tips"></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if (!intval($output['info']['pdc_payment_state'])) {?>
        <tfoot id="submit-holder">
        <tr class="tfoot">
        <td colspan="2">
        <a class="btn" href="javascript:if (confirm('<?php echo $lang['admin_predeposit_cash_confirm'];?>')){window.location.href='index.php?act=predeposit&op=pd_cash_pay&id=<?php echo $output['info']['pdc_id']; ?>';}else{}"><span><?php echo $lang['admin_predeposit_payed'];?></span></a>
        </td>
        </tr>
        </tfoot>
     <?php } ?>
    </table>
</div>