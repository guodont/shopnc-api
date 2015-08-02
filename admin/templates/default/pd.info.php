<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_predepositmanage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_predeposit_rechargelist']?></span></a></li>
        <li><a href="index.php?act=predeposit&op=pd_cash_list"><span><?php echo $lang['admin_predeposit_cashmanage']; ?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2 nobdb">
    <tbody>
      <tr class="noborder">
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_sn']; ?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdr_sn']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_membername']; ?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdr_member_name']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_recharge_price'];?>(<?php echo $lang['currency_zh'];?>):</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdr_amount']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_apptime']?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo @date('Y-m-d H:i:s',$output['info']['pdr_add_time']); ?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php if (intval($output['info']['pdr_payment_time'])) {?>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_payment'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdr_payment_name']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_paytime'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform">
        <?php if (date('His',$output['info']['pdr_payment_time']) == 0) {?>
        <?php echo date('Y-m-d',$output['info']['pdr_payment_time']);?>
        <?php } else {?>
        <?php echo date('Y-m-d H:i:s',$output['info']['pdr_payment_time']);?>
        <?php } ?>
        </td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label>第三方支付平台交易号:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdr_trade_sn'];?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php } ?>
      <!-- 显示管理员名称 -->
      <?php if (trim($output['info']['pdr_admin']) != ''){ ?>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_adminname'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdr_admin']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php }?>
    </tbody>
      <?php if (!intval($output['info']['pdr_payment_state'])) {?>
        <tfoot id="submit-holder">
        <tr class="tfoot">
        <td colspan="2">
        <a class="btn" href="index.php?act=predeposit&op=recharge_edit&id=<?php echo $output['info']['pdr_id']; ?>"><span><?php echo  $lang['admin_predeposit_payed'];?></span></a>
        </td>
        </tr>
        </tfoot>
     <?php } ?>
  </table>
</div>
