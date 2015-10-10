<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <table class="table tb-type2 order">
    <tbody>
      <tr class="space">
        <th colspan="15">订单状态</th>
      </tr>
      <tr>
        <td colspan="2"><ul>
            <li>
				<strong>订单号:</strong><?php echo $output['live_order']['order_sn'];?>
            </li>
            <li>
				<strong>订单状态:</strong>
				<?php 
					if($output['live_order']['state'] == 1){
						echo '待付款';
					}elseif($output['live_order']['state'] == 2){
						echo '兑换使用';
					}elseif($output['live_order']['state'] == 3){
						echo '使用完成';
					}elseif($output['live_order']['state'] == 4){
						echo '取消订单';
					}
				?>
			</li>
            <li>
				<strong>订单总额:</strong>
				<span class="red_common"><?php echo $lang['currency'].$output['live_order']['price'];?> </span>
			</li>
          </ul></td>
      </tr>
      <tr class="space">
        <th colspan="2">订单详情</th>
      </tr>
      <tr>
        <th>订单信息</th>
      </tr>
      <tr>
        <td>
			<ul>
				<li>
					<strong>买家<?php echo $lang['nc_colon'];?></strong>
					<?php echo $output['live_order']['member_name'];?>
				</li>
				<li>
					<strong>店铺<?php echo $lang['nc_colon'];?></strong>
					<?php echo $output['live_order']['store_name'];?>
				</li>
				<li>
					<strong>支付方式<?php echo $lang['nc_colon'];?></strong>
					<?php echo orderPaymentName($output['live_order']['payment_code']);?>
				</li>
				<li>
					<strong>下单时间<?php echo $lang['nc_colon'];?></strong>
					<?php echo date('Y-m-d H:i:s',$output['live_order']['add_time']);?>
				</li>
				<?php if(intval($output['live_order']['payment_time'])){?>
				<li>
					<strong>支付时间<?php echo $lang['nc_colon'];?></strong>
					<?php echo date('Y-m-d H:i:s',$output['live_order']['payment_time']);?>
				</li>
				<?php }?>
				<?php if(intval($output['live_order']['finnshed_time'])){?>
				<li>
					<strong>完成时间<?php echo $lang['nc_colon'];?></strong>
					<?php echo date('Y-m-d H:i:s',$output['live_order']['finnshed_time']);?>
				</li>
				<?php }?>
			  </ul>
		  </td>
      </tr>
      <tr>
        <th>抢购信息</th>
      </tr>
      <tr>
        <td>
		  <table class="table tb-type2 goods ">
            <tbody>
              <tr>
                <th></th>
                <th>抢购信息</th>
                <th class="align-center">单价</th>
                <th class="align-center">数量</th>
                <th class="align-center">总额</th>
              </tr>
              <tr>
                <td class="w60 picture">
					<div class="size-56x56"><span class="thumb size-56x56"><i></i><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=show_live_groupbuy&op=groupbuy_detail&groupbuy_id=<?php echo $output['live_order']['groupbuy_id'];?>" target="_blank"><img src="<?php echo lgthumb($output['live_order']['groupbuy_pic'], 'small');?>" style=" max-width: 56px; max-height: 56px;" /> </a></span></div>
				</td>
                <td class="w50pre">
					<p><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=show_live_groupbuy&op=groupbuy_detail&groupbuy_id=<?php echo $output['live_order']['groupbuy_id'];?>" target="_blank"><?php echo $output['live_order']['item_name'];?></a></p>
				</td>
				<td class="w96 align-center"><span class="red_common"><?php echo $lang['currency'].$output['live_order']['groupbuy_price'];?></span></td>
                <td class="w96 align-center"><span class="red_common"><?php echo $lang['currency'].$output['live_order']['number'];?></span></td>
                <td class="w96 align-center"><span class="red_common"><?php echo $output['live_order']['price'];?></span></td>
              </tr>
            </tbody>
          </table>
		 </td>
      </tr>
	  <?php if(is_array($output['live_order_pwd']) and !empty($output['live_order_pwd'])) { ?>
	  <tr>
		<th>抢购码</th>
	  </tr>
	  <?php foreach($output['live_order_pwd'] as $val) { ?>
	  <tr>
	  	<td>
			<?php
				if($val['state']==1){
					echo $val['order_pwd'].',未使用';
				}elseif($val['state']==2){
					echo $val['order_pwd'].',已使用,使用时间：'.date("Y-m-d H:i",$val['use_time']);
				}
			?>
	  	</td>
	  </tr>
	  <?php } ?>
	  <?php } ?>

    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td><a href="JavaScript:void(0);" class="btn" onclick="history.go(-1)"><span><?php echo $lang['nc_back'];?></span></a></td>
      </tr>
    </tfoot>
  </table>
</div>
