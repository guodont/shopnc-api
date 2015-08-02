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
            </li>
            <li><strong><?php echo $lang['order_state'];?>:</strong><?php echo $output['order_info']['state_desc'];?></li>
            <li><strong><?php echo $lang['order_total_price'];?>:</strong><span class="red_common"><?php echo $lang['currency'].$output['order_info']['order_amount'];?> </span>
            </li>
            
             <!--//zmr>v80-->
               <?php if($output['order_info']['rcb_amount']>0){ ?>
             <li><strong  style="color:blue">充值卡已支付:</strong><span class="red_common"><?php echo $lang['currency'].$output['order_info']['rcb_amount'];?> </span>
              <?php } ?>
               <?php if($output['order_info']['pd_amount']>0){ ?>
             
             
              <li><strong style="color:blue">预存款已支付:</strong><span class="red_common"><?php echo $lang['currency'].$output['order_info']['pd_amount'];?> </span> <?php } ?>
              
              
              
            <li><strong><?php echo $lang['order_time'];?><?php echo $lang['nc_colon'];?></strong><?php echo date('Y-m-d H:i:s',$output['order_info']['add_time']);?></li>
            <li><strong><?php echo $lang['buyer_name'];?><?php echo $lang['nc_colon'];?></strong><?php echo $output['order_info']['buyer_name'];?></li>
            <li><strong>接收手机<?php echo $lang['nc_colon'];?></strong><?php echo $output['order_info']['buyer_phone'];?></li>
            <li><strong><?php echo $lang['payment'];?><?php echo $lang['nc_colon'];?></strong><?php echo orderPaymentName($output['order_info']['payment_code']);?></li>
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
            <li><strong><?php echo $lang['store_name'];?><?php echo $lang['nc_colon'];?></strong><?php echo $output['order_info']['store_name'];?></li>
            <li><strong>买家留言<?php echo $lang['nc_colon'];?></strong><?php echo $output['order_info']['buyer_msg'];?></li>
          </ul></td>
      </tr>
      <tr>
        <th><?php echo $lang['product_info'];?></th>
      </tr>
      <tr>
        <td><table class="table tb-type2 goods ">
            <tbody>
              <tr>
                <th></th>
                <th>商品</th>
                <th class="align-center">单价</th>
                <th class="align-center">数量</th>
                <th class="align-center">佣金比例</th>
                <th class="align-center">收取佣金</th>
              </tr>
              <tr>
                <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=goods&goods_id=<?php echo $output['order_info']['goods_id'];?>" target="_blank"><img alt="<?php echo $lang['product_pic'];?>" src="<?php echo thumb($output['order_info'], 60);?>" /></a></span></div></td>
                <td class="w50pre"><p><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=goods&goods_id=<?php echo $output['order_info']['goods_id'];?>" target="_blank"><?php echo $output['order_info']['goods_name'];?></a></p><p><?php if ($output['order_info']['order_promotion_type'] == 1) {?>抢购，<?php } ?>使用时效：即日起 至 <?php echo date("Y-m-d",$output['order_info']['vr_indate']);?>
              <?php if ($output['order_info']['vr_invalid_refund'] == '0') { ?>
              ，过期不退款
              <?php } ?></p></td>
                <td class="w96 align-center"><span class="red_common"><?php echo $lang['currency'].$output['order_info']['goods_price'];?></span></td>
                <td class="w96 align-center"><?php echo $output['order_info']['goods_num'];?></td>
                <td class="w96 align-center"><?php echo $output['order_info']['commis_rate'] == 200 ? '' : $output['order_info']['commis_rate'].'%';?></td>
                <td class="w96 align-center"><?php echo $output['order_info']['commis_rate'] == 200 ? '' : ncPriceFormat($output['order_info']['goods_price']*$output['order_info']['commis_rate']/100);?></td>
              </tr>
            </tbody>
          </table></td>
      </tr>

      <tr>
        <th><?php echo $lang['product_info'];?></th>
      </tr>
      <tr>
        <td><table class="table tb-type2 goods">
            <tbody>
              <tr>
          <th class="w10"></th>
          <th>兑换码</th>
          <th>价格 (元)</th>
          <th>数量</th>
          <th>兑换码状态</th>
              </tr>
         <?php if (!empty($output['order_info']['extend_vr_order_code'])) { ?>
         <?php foreach($output['order_info']['extend_vr_order_code'] as $code_info){?>
            <tr>
            <td></td>
            <td class="w50"><?php echo $code_info['vr_code'];?></td>
            <td class="bdl"><?php echo $output['order_info']['goods_price'];?></td>
            <td class="bdl">1</td>
            </td>
            <td class="bdl"><?php echo $code_info['vr_code_desc'];?></td>
            </tr>
       <?php } ?>
	   <?php } else { ?>
	   <tr><td colspan="20" class="align-center">未生成电子兑换码</td></tr>
	   <?php } ?>
            </tbody>
          </table></td>
      </tr>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td><a href="JavaScript:void(0);" class="btn" onclick="history.go(-1)"><span><?php echo $lang['nc_back'];?></span></a></td>
      </tr>
    </tfoot>
  </table>
</div>
