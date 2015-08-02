<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncsc-oredr-show">
  <div class="ncsc-order-info">
    <div class="ncsc-order-details">
      <div class="title"><?php echo $lang['store_show_order_info'];?></div>
      <div class="content">
        <dl>
          <dt><?php echo $lang['store_show_order_receiver'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['order_info']['extend_order_common']['reciver_name'];?>&nbsp; <?php echo @$output['order_info']['extend_order_common']['reciver_info']['phone'];?>&nbsp; <?php echo @$output['order_info']['extend_order_common']['reciver_info']['address'];?><?php echo $output['order_info']['extend_order_common']['reciver_info']['dlyp'] ? '[自提服务站]' : '';?></dd>
        </dl>
        <dl>
          <dt>发&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;票：</dt>
          <dd>
            <?php foreach ((array)$output['order_info']['extend_order_common']['invoice_info'] as $key => $value){?>
            <span><?php echo $key;?> (<strong><?php echo $value;?></strong>)</span>
            <?php } ?>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_show_order_buyer_message'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['order_info']['extend_order_common']['order_message']; ?></dd>
        </dl>
        <dl class="line">
          <dt><?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['order_info']['order_sn']; ?><a href="javascript:void(0);">更多<i class="icon-angle-down"></i>
            <div class="more"><span class="arrow"></span>
              <ul>
                <?php if($output['order_info']['payment_name']) { ?>
                <li><?php echo $lang['store_order_pay_method'].$lang['nc_colon'];?><span><?php echo $output['order_info']['payment_name']; ?>
                  <?php if($output['order_info']['payment_code'] != 'offline' && !in_array($output['order_info']['order_state'],array(ORDER_STATE_CANCEL,ORDER_STATE_NEW))) { ?>
                  (<?php echo '付款单号'.$lang['nc_colon'];?><?php echo $output['order_info']['pay_sn']; ?>)
                  <?php } ?>
                  </span></li>
                <?php } ?>
                <li><?php echo $lang['store_order_add_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']); ?></span></li>
                <?php if(intval($output['order_info']['payment_time'])) { ?>
                <li><?php echo $lang['store_show_order_pay_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['payment_time']); ?></span></li>
                <?php } ?>
                <?php if($output['order_info']['extend_order_common']['shipping_time']) { ?>
                <li><?php echo $lang['store_show_order_send_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']); ?></span></li>
                <?php } ?>
                <?php if(intval($output['order_info']['finnshed_time'])) { ?>
                <li><?php echo $lang['store_show_order_finish_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['finnshed_time']); ?></span></li>
                <?php } ?>
              </ul>
            </div>
            </a></dd>
        </dl>
        <dl>
          <dt></dt>
          <dd></dd>
        </dl>
      </div>
    </div>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_CANCEL) { ?>
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-off orange"></i>订单状态：</dt>
        <dd>交易关闭</dd>
      </dl>
      <ul>
        <li><?php echo $output['order_info']['close_info']['log_role'];?> 于 <?php echo date('Y-m-d H:i:s',$output['order_info']['close_info']['log_time']);?> <?php echo $output['order_info']['close_info']['log_msg'];?></li>
      </ul>
    </div>
    <?php } ?>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_NEW) { ?>
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>订单已经提交，等待买家付款</dd>
      </dl>
      <ul>
        <li>1. 买家尚未对该订单进行支付。</li>
        <li>2. 如果买家未对该笔订单进行支付操作，系统将于
          <time><?php echo date('Y-m-d H:i:s',$output['order_info']['order_cancel_day']);?></time>
          自动关闭该订单。</li>
      </ul>
    </div>
    <?php } ?>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_PAY) { ?>
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>
          <?php if ($output['order_info']['payment_code'] == 'offline') { ?>
          订单已提交，等待发货
          <?php } else { ?>
          已支付成功
          <?php } ?>
        </dd>
      </dl>
      <ul>
        <?php if ($output['order_info']['payment_code'] == 'offline') { ?>
        <li>1. 买家已经选择货到付款方式下单成功。</li>
        <li>2. 订单已提交商家进行备货发货准备。</li>
        <?php } else { ?>
        <li>1. 买家已使用“<?php echo orderPaymentName($output['order_info']['payment_code']);?>”方式成功对订单进行支付，支付单号 “<?php echo $output['order_info']['pay_sn'];?>”。</li>
        <li>2. 订单已提交商家进行备货发货准备。</li>
        <?php } ?>
      </ul>
    </div>
    <?php } ?>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_SEND) { ?>
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>已发货</dd>
      </dl>
      <ul>
        <li>1. 商品已发出；
          <?php if ($output['order_info']['shipping_code'] != '') { ?>
          物流公司：<?php echo $output['order_info']['express_info']['e_name']?>；单号：<?php echo $output['order_info']['shipping_code'];?>。
          <?php if ($output['order_info']['if_deliver']) { ?>
          查看 <a href="#order-step" class="blue">“物流跟踪”</a> 情况。
          <?php } ?>
          <?php } else { ?>
          无需要物流。
          <?php } ?>
        </li>
        <li>2. 如果买家没有及时进行收货，系统将于
          <time><?php echo date('Y-m-d H:i:s',$output['order_info']['order_confirm_day']);?></time>
          自动完成“确认收货”，完成交易。</li>
      </ul>
    </div>
    <?php } ?>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_SUCCESS) { ?>
    <?php if ($output['order_info']['evaluation_state'] == 1) { ?>
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>评价完成。</dd>
      </dl>
      <ul>
        <li>1. 买家已对该笔订单进行了商品及交易评价。</li>
        <li>2. 可以在<a href="index.php?act=store_evaluate&op=list" class="ncsc-btn-mini">评价管理</a>查看详细内容。</li>
      </ul>
    </div>
    <?php } else { ?>
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>已经收货。</dd>
      </dl>
      <ul>
        <li>1. 交易已完成，买家可以对购买的商品及服务进行评价。</li>
        <li>2. 评价后的情况会在商品详细页面中显示，以供其它会员在购买时参考。</li>
      </ul>
    </div>
    <?php } ?>
    <?php } ?>
  </div>
  <?php if ($output['order_info']['order_state'] != ORDER_STATE_CANCEL) { ?>
  <div id="order-step" class="ncsc-order-step">
    <dl class="step-first <?php if ($output['order_info']['order_state'] != ORDER_STATE_CANCEL) echo 'current';?>">
      <dt>提交订单</dt>
      <dd class="bg"></dd>
      <dd class="date" title="<?php echo $lang['store_order_add_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']); ?></dd>
    </dl>
    <?php if ($output['order_info']['payment_code'] != 'offline') { ?>
    <dl class="<?php if(intval($output['order_info']['payment_time'])) echo 'current'; ?>">
      <dt>支付订单</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="<?php echo $lang['store_show_order_pay_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['payment_time']); ?></dd>
    </dl>
    <?php } ?>
    <dl class="<?php if($output['order_info']['extend_order_common']['shipping_time']) echo 'current'; ?>">
      <dt>商家发货</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="<?php echo $lang['store_show_order_send_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']); ?></dd>
    </dl>
    <dl class="<?php if(intval($output['order_info']['finnshed_time'])) { ?>current<?php } ?>">
      <dt>确认收货</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="<?php echo $lang['store_show_order_finish_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['finnshed_time']); ?></dd>
    </dl>
    <dl class="<?php if($output['order_info']['evaluation_state'] == 1) { ?>current<?php } ?>">
      <dt>评价</dt>
      <dd class="bg"></dd>
      <dd class="date" title="<?php echo $lang['store_show_order_finish_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['evaluation_time']); ?></dd>
    </dl>
  </div>
  <?php } ?>
  <div class="ncsc-order-contnet">
    <table class="ncsc-default-table order">
      <thead>
        <tr>
          <th class="w10">&nbsp;</th>
          <th colspan="2"><?php echo $lang['store_show_order_goods_name'];?></th>
          <th class="w120"><?php echo $lang['store_show_order_price'];?></th>
          <th class="w60"><?php echo $lang['store_show_order_amount'];?></th>
          <th class="w100">优惠活动</th>
          <th class=""><strong>实付 * 佣金比 = 应付佣金(元)</strong></th>
          <th>交易操作</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($output['order_info']['shipping_code'])) { ?>
        <tr>
          <th colspan="6" style="border-right: 0;"> <div class="order-deliver"> <span>物流公司： <a target="_blank" href="<?php echo $output['order_info']['express_info']['e_url'];?>"><?php echo $output['order_info']['express_info']['e_name'];?></a></span> <span><?php echo $lang['store_order_shipping_no'].$lang['nc_colon'];?> <?php echo $output['order_info']['shipping_code']; ?></span><span><a href="javascript:void(0);" id="show_shipping">物流跟踪<i class="icon-angle-down"></i>
              <div class="more"><span class="arrow"></span>
                <ul id="shipping_ul">
                  <li>加载中...</li>
                </ul>
              </div>
              </a></span> </div></th>
          <th colspan="3" style=" border-left: 0;"><?php if(!empty($output['daddress_info'])) { ?>
            <dl class="daddress-info">
              <dt>发&nbsp;&nbsp;货&nbsp;&nbsp;人：</dt>
              <dd><?php echo $output['daddress_info']['seller_name']; ?><a href="javascript:void(0);">更多<i class="icon-angle-down"></i>
                <div class="more"><span class="arrow"></span>
                  <ul>
                    <li>公&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;司：<span><?php echo $output['daddress_info']['company'];?></span></li>
                    <li>联系电话：<span><?php echo $output['daddress_info']['telphone'];?></span></li>
                    <li>发货地址：<span><?php echo $output['daddress_info']['area_info'];?>&nbsp;<?php echo $output['daddress_info']['address'];?></span></li>
                  </ul>
                </div>
                </a></dd>
            </dl>
            <?php } ?>
          </th>
        </tr>
        <?php } ?>
        <?php $i = 0;?>
        <?php foreach($output['order_info']['goods_list'] as $k => $goods) { ?>
        <?php $i++;?>
        <tr class="bd-line">
          <td>&nbsp;</td>
          <td class="w50"><div class="pic-thumb"><a target="_blank" href="<?php echo $goods['goods_url'];?>"><img src="<?php echo $goods['image_60_url']; ?>" /></a></div></td>
          <td class="tl"><dl class="goods-name">
              <dt><a target="_blank" href="<?php echo $goods['goods_url']; ?>"><?php echo $goods['goods_name']; ?></a></dt>
              <dd>
                <?php if (is_array($output['refund_all']) && !empty($output['refund_all'])) {?>
                退款单号：<a target="_blank" href="index.php?act=store_refund&op=view&refund_id=<?php echo $output['refund_all']['refund_id'];?>"><?php echo $output['refund_all']['refund_sn'];?></a>
                <?php }else if($goods['extend_refund']['refund_type'] == 1) {?>
                退款单号：<a target="_blank" href="index.php?act=store_refund&op=view&refund_id=<?php echo $goods['extend_refund']['refund_id'];?>"><?php echo $goods['extend_refund']['refund_sn'];?></a></dd>
              <?php }else if($goods['extend_refund']['refund_type'] == 2) {?>
              退货单号：<a target="_blank" href="index.php?act=store_return&op=view&return_id=<?php echo $goods['extend_refund']['refund_id'];?>"><?php echo $goods['extend_refund']['refund_sn'];?></a>
              </dd>
              <?php } ?>
            </dl></td>
          <td><?php echo $goods['goods_price']; ?>
            <p class="green">
              <?php if (is_array($output['refund_all']) && !empty($output['refund_all']) && $output['refund_all']['admin_time'] > 0) {?>
              <?php echo $goods['goods_pay_price'];?><span>退</span>
              <?php } elseif ($goods['extend_refund']['admin_time'] > 0) { ?>
              <?php echo $goods['extend_refund']['refund_amount'];?><span>退</span>
              <?php } ?>
            </p></td>
          <td><?php echo $goods['goods_num']; ?></td>
          <td><?php echo $goods['goods_type_cn']; ?></td>
          <td class="commis bdl bdr">
          <?php if ($goods['commis_rate'] != 200) { ?>
          <?php echo $goods['goods_pay_price']; ?> * <?php echo $goods['commis_rate']; ?>% = <b><?php echo ncPriceFormat($goods['goods_pay_price']*$goods['commis_rate']/100); ?></b>
          <?php } ?>
          </td>

          <!-- S 合并TD -->
          <?php if (($output['order_info']['goods_count'] > 1 && $k ==0) || ($output['order_info']['goods_count'] == 1)){?>
          <td class="bdl bdr" rowspan="<?php echo $output['order_info']['goods_count'];?>"><?php echo $output['order_info']['state_desc']; ?>
            <?php if ($output['order_info']['if_lock']) { ?>
            <p>退款退货中</p>
            <?php } ?>

            <!-- 修改价格 -->
            <?php if ($output['order_info']['if_modify_price']) { ?>
            <p><a href="javascript:void(0)" class="ncsc-btn" uri="index.php?act=store_order&op=change_state&state_type=modify_price&order_sn=<?php echo $output['order_info']['order_sn']; ?>&order_id=<?php echo $output['order_info']['order_id']; ?>" dialog_width="480" dialog_title="<?php echo $lang['store_order_modify_price'];?>" nc_type="dialog"  dialog_id="seller_order_adjust_fee" id="order<?php echo $output['order_info']['order_id']; ?>_action_adjust_fee" />修改运费</a></p>
            <?php }?>

            <!-- 取消订单 -->
            <?php if ($output['order_info']['if_cancel']) { ?>
            <p><a href="javascript:void(0)" style="color:#F30; text-decoration:underline;" nc_type="dialog" uri="index.php?act=store_order&op=change_state&state_type=order_cancel&order_sn=<?php echo $output['order_info']['order_sn']; ?>&order_id=<?php echo $output['order_info']['order_id']; ?>" dialog_title="<?php echo $lang['store_order_cancel_order'];?>" dialog_id="seller_order_cancel_order" dialog_width="400" id="order<?php echo $output['order_info']['order_id']; ?>_action_cancel" /><?php echo $lang['store_order_cancel_order'];?></a></p>
            <?php } ?>

            <!-- 发货 -->
            <?php if ($output['order_info']['if_send']) { ?>
            <p><a class="ncsc-btn" href="index.php?act=store_deliver&op=send&order_id=<?php echo $output['order_info']['order_id']; ?>"/><i class="icon-truck"></i><?php echo $lang['store_order_send'];?></a></p>
            <?php } ?></td>
          <?php } ?>
          <!-- E 合并TD -->
        </tr>

        <!-- S 赠品列表 -->
        <?php if (!empty($output['order_info']['zengpin_list']) && $i == count($output['order_info']['goods_list'])) { ?>
        <tr class="bd-line">
          <td>&nbsp;</td>
          <td colspan="6" class="tl"><div class="ncsc-goods-gift">赠品：
          <ul><?php foreach($output['order_info']['zengpin_list'] as $zengpin_info) {?>
          <li><a title="赠品：<?php echo $zengpin_info['goods_name'];?> * <?php echo $zengpin_info['goods_num'];?>" target="_blank" href="<?php echo $zengpin_info['goods_url'];?>"><img src="<?php echo $zengpin_info['image_60_url']; ?>" /></a></li>
          <?php } ?></ul></div>
          </td>
        </tr>
        <?php } ?>
        <!-- E 赠品列表 -->

        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['order_info']['extend_order_common']['promotion_info']) || !empty($output['order_info']['extend_order_common']['voucher_code'])){ ?>
        <tr>
          <td colspan="20"><dl class="ncsc-store-sales">
              <dt>其它信息<?php echo $lang['nc_colon'];?></dt>
              <?php if(!empty($output['order_info']['extend_order_common']['promotion_info'])){ ?>
              <dd><?php echo $output['order_info']['extend_order_common']['promotion_info'];?></dd>
              <?php } ?>
              <?php if(!empty($output['order_info']['extend_order_common']['voucher_code'])){ ?>
              <dd>使用了面额为 <?php echo $output['order_info']['extend_order_common']['voucher_price'];?> 元的代金券，编码：<?php echo $output['order_info']['extend_order_common']['voucher_code'];?></span></dd>
              <?php } ?>
            </dl></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="20"><dl class="freight">
              <dd>
                <?php if(!empty($output['order_info']['shipping_fee']) && $output['order_info']['shipping_fee'] != '0.00'){ ?>
                <?php echo $lang['store_show_order_tp_fee'];?>: <span><?php echo $lang['currency'];?><?php echo $output['order_info']['shipping_fee']; ?></span>
                <?php }else{?>
                <?php echo $lang['nc_common_shipping_free'];?>
                <?php }?>
                <?php if($output['order_info']['refund_amount'] > 0) { ?>
                (<?php echo $lang['store_order_refund'];?>:<?php echo $lang['currency'].$output['order_info']['refund_amount'];?>)
                <?php } ?>
              </dd>
            </dl>
            <dl class="sum">
            
             <!--//zmr>v80-->
             <?php if($output['order_info']['rcb_amount']>0){ ?>
             <dt style="color:blue">充值卡已支付：</dt>
              <dd><em><?php echo $output['order_info']['rcb_amount']; ?></em>元</dd>
               <?php } ?>
               <?php if($output['order_info']['pd_amount']>0){ ?>
            <dt style="color:blue">预存款已支付：</dt>
              <dd><em><?php echo $output['order_info']['pd_amount']; ?></em>元</dd>
               <?php } ?>
               
               
              <dt><?php echo $lang['store_order_sum'].$lang['nc_colon'];?></dt>
              <dd><em><?php echo $output['order_info']['order_amount']; ?></em>元</dd>
            </dl></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<script type="text/javascript">
$(function(){
    $('#show_shipping').on('hover',function(){
        var_send = '<?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']); ?>&nbsp;&nbsp;<?php echo $lang['member_show_seller_has_send'];?><br/>';
    	$.getJSON('index.php?act=store_deliver&op=get_express&e_code=<?php echo $output['order_info']['express_info']['e_code']?>&shipping_code=<?php echo $output['order_info']['shipping_code']?>&t=<?php echo random(7);?>',function(data){
    		if(data){
    			data = var_send+data;
    			$('#shipping_ul').html(data);
    			$('#show_shipping').unbind('hover');
    		}else{
    			$('#shipping_ul').html(var_send);
    			$('#show_shipping').unbind('hover');
    		}
    	});
    });
});
</script>
