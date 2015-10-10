<?php defined('InShopNC') or exit('Access Invalid!');?>
  <div class="tabmenu">
  	<?php include template('layout/submenu');?>
  </div>
  <div class="alert alert-block mt10 mb10">
      <h4><?php echo $lang['nc_explain'].$lang['nc_colon'];?></h4>
      <ul>
          <li>1、列表显示结算清单，显示订单总额、消费金额、剩余金额</li>
		  <li>2、抢购有效期作为结算的周期</li>
      </ul>
  </div>
  <table class="ncsc-table-style">
    <thead>
      <tr>
		<th class="w10"></th> 
        <th class="w130">线下抢订单号</th>
		<th class="w80">买家</th>
        <th class="w130">下单时间</th>
        <th class="w80">订单总额</th>
        <th class="w80">支付方式</th>
        <th class="w80">消费金额</th>
		<th class="w80">剩余金额</th>
		<th class="w80">有效期</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($output['list'])>0) { ?>
      <?php foreach($output['list'] as $val) { ?>
      <tr class="bd-line">
	    <td></td>
		<td><?php echo $val['order_sn'];?></td>
		<td><?php echo $val['member_name'];?></td>
		<td><?php echo date("Y-m-d H:i",$val['add_time']);?></td>
		<td><?php echo $val['price'];?></td>
		<td><?php echo orderPaymentName($val['payment_code']);?></td>
		<td><?php echo $val['use_price'];?></td>
		<td><?php echo $val['price']-$val['use_price'];?></td>
		<td><?php echo date("Y-m-d H:i",$val['validity']);?></td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="17" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list'])>0) { ?>
      <tr>
        <td colspan="17"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>

