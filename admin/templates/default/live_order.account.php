<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>线下结算</h3>
      <ul class="tab-base">
        <li><a href="javascript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>

  <!-- 操作说明 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg">
	        <div class="title">
	            <h5><?php echo $lang['nc_prompts'];?></h5>
	            <span class="arrow"></span>
	        </div>
        </th>
      </tr>
      <tr>
        <td>
		  <ul>
            <li>线下结算用于平台查看订单抢购券消费使用情况，方便和商家进行结算</li>
			<li>抢购有效期作为结算时间</li>
          </ul>
		</td>
      </tr>
    </tbody>
  </table>
  <form id="list_form" method='post'>
    <input id="order_id" name="order_id" type="hidden" />
    <table class="table tb-type2">
	  <thead>
		<tr class="thead">
			<th>订单号</th>
			<th>店铺</th>
			<th>买家</th>
			<th class="align-center">下单时间</th>
			<th class="align-center">订单总额</th>
			<th class="align-center">支付方式</th>
			<th class="align-center">消费金额</th>
			<th class="align-center">剩余金额</th>
			<th class="align-center">有效期</th>
		</tr>
	  </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover edit">
		  <td><?php echo $val['order_sn'];?></td>
		  <td><?php echo $val['store_name'];?></td>
		  <td><?php echo $val['member_name'];?></td>
		  <td class="align-center"><?php echo date("Y-m-d",$val['add_time']);?></td>
		  <td class="align-center"><?php echo $val['price'];?></td>
		  <td class="align-center"><?php echo orderPaymentName($val['payment_code']);?></td>
		  <td class="align-center"><?php echo $val['use_price'];?></td>
		  <td class="align-center"><?php echo $val['price']-$val['use_price'];?></td>
		  <td class="align-center"><?php echo date("Y-m-d",$val['validity']);?></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="9"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td></td>
          <td id="batchAction" colspan="15">
            <div class="pagination"><?php echo $output['show_page'];?></div>
          </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>