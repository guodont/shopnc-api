<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <table class="table tb-type2 order">
    <tbody>
      <tr class="space">
        <th colspan="2"><?php echo $lang['order_detail'];?></th>
      </tr>
      <tr>
        <th><?php echo $lang['order_info'];?></th>
      </tr>
      <tr>
        <td colspan="2"><ul>
            <li>
            <strong><?php echo $lang['order_number'];?>:</strong><?php echo $output['order_info']['order_sn'];?>
            ( 支付单号 <?php echo $lang['nc_colon'];?> <?php echo $output['order_info']['pay_sn'];?> )
            </li>
            <li><strong><?php echo $lang['order_state'];?>:</strong><?php echo orderState($output['order_info']);?></li>
            <li><strong><?php echo $lang['order_total_price'];?>:</strong><span class="red_common"><?php echo $lang['currency'].$output['order_info']['order_amount'];?> </span>
             <!--//zmr>v80-->
             <?php if($output['order_info']['rcb_amount']>0){ ?>
             <li><strong  style="color:blue">充值卡已支付:</strong><span class="red_common"><?php echo $lang['currency'].$output['order_info']['rcb_amount'];?> </span>
              <?php } ?>
               <?php if($output['order_info']['pd_amount']>0){ ?>
             
             
              <li><strong style="color:blue">预存款已支付:</strong><span class="red_common"><?php echo $lang['currency'].$output['order_info']['pd_amount'];?> </span> <?php } ?>
              
              
            	<?php if($output['order_info']['refund_amount'] > 0) { ?>
            	(<?php echo $lang['order_refund'];?>:<?php echo $lang['currency'].$output['order_info']['refund_amount'];?>)
            	<?php } ?></li>
            <li><strong><?php echo $lang['order_total_transport'];?>:</strong><?php echo $lang['currency'].$output['order_info']['shipping_fee'];?></li>
          </ul></td>
      </tr>
      <tr>
        <td><ul>
            <li><strong><?php echo $lang['buyer_name'];?><?php echo $lang['nc_colon'];?></strong><?php echo $output['order_info']['buyer_name'];?></li>
            <li><strong><?php echo $lang['store_name'];?><?php echo $lang['nc_colon'];?></strong><?php echo $output['order_info']['store_name'];?></li>
            <li><strong><?php echo $lang['payment'];?><?php echo $lang['nc_colon'];?></strong><?php echo orderPaymentName($output['order_info']['payment_code']);?></li>
            <li><strong><?php echo $lang['order_time'];?><?php echo $lang['nc_colon'];?></strong><?php echo date('Y-m-d H:i:s',$output['order_info']['add_time']);?></li>
            <?php if(intval($output['order_info']['payment_time'])){?>
            <li><strong><?php echo $lang['payment_time'];?><?php echo $lang['nc_colon'];?></strong><?php echo date('Y-m-d H:i:s',$output['order_info']['payment_time']);?></li>
            <?php }?>
            <?php if(intval($output['order_info']['shipping_time'])){?>
            <li><strong><?php echo $lang['ship_time'];?><?php echo $lang['nc_colon'];?></strong><?php echo date('Y-m-d H:i:s',$output['order_info']['shipping_time']);?></li>
            <?php }?>
            <?php if(intval($output['order_info']['finnshed_time'])){?>
            <li><strong><?php echo $lang['complate_time'];?><?php echo $lang['nc_colon'];?></strong><?php echo date('Y-m-d H:i:s',$output['order_info']['finnshed_time']);?></li>
            <?php }?>
            <?php if($output['order_info']['extend_order_common']['order_message'] != ''){?>
            <li><strong><?php echo $lang['buyer_message'];?><?php echo $lang['nc_colon'];?></strong><?php echo $output['order_info']['extend_order_common']['order_message'];?></li>
            <?php }?>
          </ul></td>
      </tr>
      <tr>
        <th>收货人信息</th>
      </tr>
      <tr>
        <td><ul>
            <li><strong><?php echo $lang['consignee_name'];?><?php echo $lang['nc_colon'];?></strong><?php echo $output['order_info']['extend_order_common']['reciver_name'];?></li>
            <li><strong><?php echo $lang['tel_phone'];?><?php echo $lang['nc_colon'];?></strong><?php echo @$output['order_info']['extend_order_common']['reciver_info']['phone'];?></li>
            <li><strong><?php echo $lang['address'];?><?php echo $lang['nc_colon'];?></strong><?php echo @$output['order_info']['extend_order_common']['reciver_info']['address'];?></li>
            <?php if($output['order_info']['shipping_code'] != ''){?>
            <li><strong><?php echo $lang['ship_code'];?><?php echo $lang['nc_colon'];?></strong><?php echo $output['order_info']['shipping_code'];?></li>
            <?php }?>
          </ul></td>
          </tr>
    <?php if (!empty($output['daddress_info'])) {?>
      <tr>
        <th>发货信息</th>
      </tr>
      <tr>
        <td><ul>
          <li><strong>发货人<?php echo $lang['nc_colon'];?></strong><?php echo $output['daddress_info']['seller_name']; ?></li>
          <li><strong><?php echo $lang['tel_phone'];?>:</strong><?php echo $output['daddress_info']['telphone'];?></li>
          <li><strong>发货地<?php echo $lang['nc_colon'];?></strong><?php echo $output['daddress_info']['area_info'];?>&nbsp;<?php echo $output['daddress_info']['address'];?>&nbsp;<?php echo $output['daddress_info']['company'];?></li>
          </ul></td>
          </tr>
    <?php } ?>
    <?php if (!empty($output['order_info']['extend_order_common']['invoice_info'])) {?>
      <tr>
      	<th>发票信息</th>
      </tr>
      <tr>
      <td><ul>
    <?php foreach ((array)$output['order_info']['extend_order_common']['invoice_info'] as $key => $value){?>
      <li><strong><?php echo $key.$lang['nc_colon'];?></strong><?php echo $value;?></li>
    <?php } ?>
          </ul></td>
      </tr>
    <?php } ?>
      <tr>
        <th><?php echo $lang['product_info'];?></th>
      </tr>
      <tr>
        <td><table class="table tb-type2 goods ">
            <tbody>
              <tr>
                <th></th>
                <th><?php echo $lang['product_info'];?></th>
                <th class="align-center">单价</th>
                <th class="align-center">实际支付额</th>
                <th class="align-center"><?php echo $lang['product_num'];?></th>
                <th class="align-center">佣金比例</th>
                <th class="align-center">收取佣金</th>
              </tr>
              <?php foreach($output['order_info']['extend_order_goods'] as $goods){?>
              <tr>
                <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><img alt="<?php echo $lang['product_pic'];?>" src="<?php echo thumb($goods, 60);?>" /> </a></span></div></td>
                <td class="w50pre"><p><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><?php echo $goods['goods_name'];?></a></p><p><?php echo orderGoodsType($goods['goods_type']);?></p></td>
                <td class="w96 align-center"><span class="red_common"><?php echo $lang['currency'].$goods['goods_price'];?></span></td>
                <td class="w96 align-center"><span class="red_common"><?php echo $lang['currency'].$goods['goods_pay_price'];?></span></td>
                <td class="w96 align-center"><?php echo $goods['goods_num'];?></td>
                <td class="w96 align-center"><?php echo $goods['commis_rate'] == 200 ? '' : $goods['commis_rate'].'%';?></td>
                <td class="w96 align-center"><?php echo $goods['commis_rate'] == 200 ? '' : ncPriceFormat($goods['goods_pay_price']*$goods['commis_rate']/100);?></td>
              </tr>
              <?php }?>
            </tbody>
          </table></td>
      </tr>
    <!-- S 促销信息 -->
      <?php if(!empty($output['order_info']['extend_order_common']['promotion_info']) && !empty($output['order_info']['extend_order_common']['voucher_code'])){ ?>
      <tr>
      	<th>其它信息</th>
      </tr>
      <tr>
          <td>
        <?php if(!empty($output['order_info']['extend_order_common']['promotion_info'])){ ?>
        <?php echo $output['order_info']['extend_order_common']['promotion_info'];?>，
        <?php } ?>
        <?php if(!empty($output['order_info']['extend_order_common']['voucher_code'])){ ?>
        使用了面额为 <?php echo $lang['nc_colon'];?> <?php echo $output['order_info']['extend_order_common']['voucher_price'];?> 元的代金券，
         编码 : <?php echo $output['order_info']['extend_order_common']['voucher_code'];?>
        <?php } ?>
          </td>
      </tr>
      <?php } ?>
    <!-- E 促销信息 -->

    <?php if(is_array($output['refund_list']) and !empty($output['refund_list'])) { ?>
      <tr>
      	<th>退款记录</th>
      </tr>
      <?php foreach($output['refund_list'] as $val) { ?>
      <tr>
        <td>发生时间<?php echo $lang['nc_colon'];?><?php echo date("Y-m-d H:i:s",$val['admin_time']); ?>&emsp;&emsp;退款单号<?php echo $lang['nc_colon'];?><?php echo $val['refund_sn'];?>&emsp;&emsp;退款金额<?php echo $lang['nc_colon'];?><?php echo $lang['currency'];?><?php echo $val['refund_amount']; ?>&emsp;备注<?php echo $lang['nc_colon'];?><?php echo $val['goods_name'];?></td>
      </tr>
    <?php } ?>
    <?php } ?>
    <?php if(is_array($output['return_list']) and !empty($output['return_list'])) { ?>
      <tr>
      	<th>退货记录</th>
      </tr>
      <?php foreach($output['return_list'] as $val) { ?>
      <tr>
        <td>发生时间<?php echo $lang['nc_colon'];?><?php echo date("Y-m-d H:i:s",$val['admin_time']); ?>&emsp;&emsp;退货单号<?php echo $lang['nc_colon'];?><?php echo $val['refund_sn'];?>&emsp;&emsp;退款金额<?php echo $lang['nc_colon'];?><?php echo $lang['currency'];?><?php echo $val['refund_amount']; ?>&emsp;备注<?php echo $lang['nc_colon'];?><?php echo $val['goods_name'];?></td>
      </tr>
    <?php } ?>
    <?php } ?>
    <?php if(is_array($output['order_log']) and !empty($output['order_log'])) { ?>
      <tr>
      	<th><?php echo $lang['order_handle_history'];?></th>
      </tr>
      <?php foreach($output['order_log'] as $val) { ?>
      <tr>
        <td>
          <?php echo $val['log_role']; ?> <?php echo $val['log_user']; ?>&emsp;<?php echo $lang['order_show_at'];?>&emsp;<?php echo date("Y-m-d H:i:s",$val['log_time']); ?>&emsp;<?php echo $val['log_msg']; ?>
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
