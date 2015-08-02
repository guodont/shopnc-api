<table class="table tb-type2 order mtw">
  <thead class="thead">
    <tr class="space">
      <th><?php echo $lang['complain_progress'];?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="progress"><span id="state_new" class="text"><?php echo $lang['complain_state_new'];?></span> <span class="next-step"></span> <span id="state_appeal" class="text"><?php echo $lang['complain_state_appeal'];?></span> <span class="next-step"></span> <span id="state_talk" class="text"><?php echo $lang['complain_state_talk'];?></span>
          <span class="next-step">
          </span> <span id="state_handle" class="text"><?php echo $lang['complain_state_handle'];?></span> <span class="next-step"></span> <span id="state_finish" class="text"><?php echo $lang['complain_state_finish'];?></span></td>
    </tr>
  </tbody>
</table>
<table class="table tb-type2 order">
  <thead class="thead">
    <tr class="space">
      <th><?php echo $lang['order_detail'];?></th>
    </tr></thead>
    <tbody>
    <tr class="noborder">
      <td><ul>
          <li><strong><?php echo $lang['order_shop_name'];?>:</strong><a href="<?php echo urlShop('show_store','index', array('store_id'=>$output['order_info']['store_id']));?>" >
            <?php echo $output['order_info']['store_name'];?> </a> </li>
          <li><strong><?php echo $lang['order_state'];?>:</strong><b><?php echo $output['order_info']['order_state_text'];?></b></li>
          <li><strong>订单号:</strong><a href="index.php?act=order&op=show_order&order_id=<?php echo $output['order_info']['order_id'];?>" target="_blank">
            <?php echo $output['order_info']['order_sn'];?></a> </li>
          <li><strong><?php echo $lang['order_datetime'];?>:</strong><?php echo date('Y-m-d H:i:s',$output['order_info']['add_time']);?></li>
          <li><strong><?php echo $lang['order_price'];?>:</strong><?php echo $lang['currency'].$output['order_info']['order_amount'];?>
            <?php if($output['order_info']['refund_amount'] > 0) { ?>
            (退款:<?php echo $lang['currency'].$output['order_info']['refund_amount'];?>)
            <?php } ?>
            </li>
          <?php if(!empty($output['order_info']['voucher_price'])) { ?>
          <li><strong><?php echo $lang['order_voucher_price'];?>:</strong><?php echo $lang['currency'].$output['order_info']['voucher_price'].'.00';?></li>
          <li><strong><?php echo $lang['order_voucher_sn'];?>:</strong><?php echo $output['order_info']['voucher_code'];?></li>
          <?php } ?>
        </ul></td>
    </tr>
  </tbody>
</table>
<script type="text/javascript">
$(document).ready(function(){
    var state = <?php echo empty($output['complain_info']['complain_state'])?0:$output['complain_info']['complain_state'];?>;
    if(state <= 10) {
        $("#state_new").addClass('red');
    }
    if(state == 20 ){
        $("#state_new").addClass('green');
        $("#state_appeal").addClass('red');
    }
    if(state == 30 ){
        $("#state_new").addClass('green');
        $("#state_appeal").addClass('green');
        $("#state_talk").addClass('red');
    }
    if(state == 40 ){
        $("#state_new").addClass('green');
        $("#state_appeal").addClass('green');
        $("#state_talk").addClass('green');
        $("#state_handle").addClass('red');
    }
    if(state == 99 ){
        $("#state_new").addClass('green');
        $("#state_appeal").addClass('green');
        $("#state_talk").addClass('green');
        $("#state_handle").addClass('green');
        $("#state_finish").addClass('green');
    }
});
</script>
