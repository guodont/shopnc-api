<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncsc-oredr-show">
  <div class="ncsc-order-info">
    <div class="ncsc-order-details">
      <div class="title">虚拟订单信息</div>
      <div class="content">
        <dl>
          <dt>虚拟单号：</dt>
          <dd><?php echo $output['order_info']['order_sn'];?><a href="javascript:void(0);">更多<i class="icon-angle-down"></i>
            <div class="more"><span class="arrow"></span>
              <ul>
                <li>支付方式：<?php echo orderPaymentName($output['order_info']['payment_code']);?></li>
                <li>下单时间：<span><?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']);?></span></li>
                <?php if(!empty($output['order_info']['payment_time'])){?>
                <li>付款时间：<span><?php echo date("Y-m-d H:i:s",$output['order_info']['payment_time']);?></span></li>
                <?php } ?>
              </ul>
            </div>
            </a></dd>
        </dl>
        <dl class="line">
          <dt>买&#12288;&#12288;家：</dt>
          <dd><?php echo $output['order_info']['buyer_name'];?></dd>
        </dl>
        <dl class="line">
          <dt>接收手机：</dt>
          <dd><?php echo $output['order_info']['buyer_phone'];?></dd>
        </dl>
        <dl class="line">
          <dt>买家留言：</dt>
          <dd><?php echo $output['order_info']['buyer_msg'];?></dd>
        </dl>
      </div>
    </div>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_CANCEL){ ?>
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-off orange"></i>订单状态：</dt>
        <dd>交易关闭</dd>
      </dl>
      <ul>
        <li><?php echo date("Y-m-d H:i:s",$output['order_info']['close_time']);?> 交易关闭，原因：<?php echo $output['order_info']['close_reason'];?></li>
      </ul>
    </div>
    <?php } elseif ($output['order_info']['order_state'] == ORDER_STATE_NEW){ ?>
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>订单已经生成，等待买家付款</dd>
      </dl>
      <ul>
        <li>1. 买家尚未对该订单进行支付。</li>
        <li>2. 如果该订单是一个无效订单，您可以点击 <a href="javascript:void(0)" class="ncsc-btn-mini" nc_type="dialog" dialog_width="480" dialog_title="取消订单" dialog_id="buyer_order_cancel_order" uri="index.php?act=store_vr_order&op=change_state&state_type=order_cancel&order_id=<?php echo $output['order_info']['order_id']?>&order_sn=<?php echo $output['order_info']['order_sn'];?>"  id="order_action_cancel">取消订单</a>。 </li>
        <li>2. 如果买家未对该笔订单进行支付，系统将于
          <time><?php echo date('Y-m-d H:i:s',$output['order_info']['order_cancel_day']);?></time>
          自动关闭该订单。</li>
      </ul>
    </div>
    <?php } elseif ($output['order_info']['order_state'] == ORDER_STATE_PAY){ ?>
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>买家已付款，电子兑换码已发放</dd>
      </dl>
      <ul>
        <li>1. 该笔订单的电子兑换码已由系统自动发送至买家接收。</li>
        <li>2. 本次交易从即日起至
          <time><?php echo date("Y-m-d",$output['order_info']['vr_indate']);?></time>
          ，逾期自动失效。</li>
      </ul>
    </div>
    <?php } elseif ($output['order_info']['order_state'] == ORDER_STATE_SUCCESS){ ?>
    <div class="ncsc-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>订单完成。</dd>
      </dl>
    </div>
    <?php }?>
  </div>
  <?php if ( $output['order_info']['order_state'] != ORDER_STATE_CANCEL){ ?>
  <div class="ncsc-order-step">
    <dl class="step-first current">
      <dt>生成订单</dt>
      <dd class="bg"></dd>
      <dd class="date" title="订单生成时间"><?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']); ?></dd>
    </dl>
    <dl class="<?php echo $output['order_info']['step_list']['step2'] ? 'current' : null ; ?>">
      <dt>完成付款</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="付款时间"><?php echo @date('Y-m-d H:i:s',$output['order_info']['payment_time']); ?></dd>
    </dl>
    <dl class="<?php echo $output['order_info']['step_list']['step3'] ? 'current' : null ; ?>">
      <dt>发放兑换码</dt>
      <dd class="bg"> </dd>
    </dl>
    <dl class="long <?php echo $output['order_info']['step_list']['step4'] ? 'current' : null ; ?>">
      <dt>订单完成</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="订单完成"><?php echo date("Y-m-d H:i:s",$output['order_info']['finnshed_time']); ?></dd>
    </dl>
    <div class="code-list tip" title="如列表过长超出显示区域时可滚动鼠标进行查看"><i class="arrow"></i>
      <h5>电子兑换码</h5>
      <div id="codeList">
        <ul>
          <?php foreach($output['order_info']['extend_vr_order_code'] as $code_info){ ?>
          <li class="<?php echo $code_info['vr_state'] == 1 ? 'used' : null;?>"><strong><?php echo $code_info['vr_state'] == '0' ? ($code_info['vr_indate'] < TIMESTAMP ? $code_info['vr_code'] : encryptShow($code_info['vr_code'],7,12)) : $code_info['vr_code'];?></strong> <?php echo $code_info['vr_code_desc'];?> </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
  <?php } else { ?>
  <br/>
  <?php }?>
  <div class="ncsc-order-contnet">
    <table class="ncsc-default-table order">
      <thead>
        <tr>
          <th class="w10"></th>
          <th colspan="2">商品</th>
          <th class="w100">单价 (元)</th>
          <th class="w60">数量</th>
          <th class="w240"><strong>实付 * 佣金比 = 应付佣金(元)</strong></th>
          <th class="w100">交易状态</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th colspan="20"><span class="ml10" title="虚拟订单号">虚拟订单号：<?php echo $output['order_info']['order_sn'];?></span><span>下单时间：<?php echo date("Y-m-d H:i",$output['order_info']['add_time']);?></span><span><a href="<?php echo urlShop('show_store','index',array('store_id'=>$output['order_info']['store_id']));?>" title="<?php echo $output['order_info']['store_name'];?>"><?php echo $output['store']['store_name'];?></a></span></th>
        </tr>
        <tr>
          <td class="bdl"></td>
          <td><div class="pic-thumb"><a href="<?php echo urlShop('goods','index',array('goods_id' => $output['order_info']['goods_id']));?>" target="_blank" onMouseOver="toolTip('<img src=<?php echo thumb($output['order_info'], 240);?>>')" onMouseOut="toolTip()"/><img src="<?php echo thumb($output['order_info'], 60);?>"/></a></div></td>
          <td class="tl"><dl class="goods-name">
              <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$output['order_info']['goods_id']));?>" target="_blank" title="<?php echo $output['order_info']['goods_name'];?>"><?php echo $output['order_info']['goods_name'];?></a></dt>
              <dd><span class="sale-type"><?php if ($output['order_info']['order_promotion_type'] == 1) {?>抢购，<?php } ?>使用时效：即日起 至 <?php echo date("Y-m-d",$output['order_info']['vr_indate']);?>
              <?php if ($output['order_info']['vr_invalid_refund'] == '0') { ?>
              ，过期不退款
              <?php } ?>
              </span></dd>
            </dl></td>
          <td><?php echo $output['order_info']['goods_price'];?></td>
          <td><?php echo $output['order_info']['goods_num'];?></td>
          <td class="commis bdl bdr">
          <?php if ($output['order_info']['commis_rate'] != 200) { ?>
          <?php echo ncPriceFormat($output['order_info']['order_amount']);?> * <?php echo $output['order_info']['commis_rate'];?>% = <?php echo ncPriceFormat($output['order_info']['order_amount'] * $output['order_info']['commis_rate']/100);?>
          <?php } ?>
          </td>
          <td class="bdl"><?php echo $output['order_info']['state_desc'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <?php if(!empty($output['order_info']['voucher_code'])){ ?>
        <tr>
          <th colspan="20"><dl class="ncsc-store-sales">
              <?php if(!empty($output['order_info']['voucher_code'])){ ?>
              <dd><span>&emsp;使用了 <strong><?php echo $output['order_info']['voucher_price'];?></strong> 元 代金券（编码：<?php echo $output['order_info']['voucher_code'];?>）</span></dd>
              <?php } ?>
            </dl>
          </th>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="20" class="transportation tl"><dl class="sum">
          
           <!--//zmr>v80-->
             <?php if($output['order_info']['rcb_amount']>0){ ?>
             <dt style="color:blue">充值卡已支付：</dt>
              <dd><em><?php echo $output['order_info']['rcb_amount']; ?></em>元</dd>
               <?php } ?>
               <?php if($output['order_info']['pd_amount']>0){ ?>
            <dt style="color:blue">预存款已支付：</dt>
              <dd><em><?php echo $output['order_info']['pd_amount']; ?></em>元</dd>
               <?php } ?>
               
              <dt>订单金额：</dt>
              <dd><em><?php echo $output['order_info']['order_amount'];?></em>元</dd>
            </dl></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
<script type="text/javascript">
//兑换码列表过多时出现滚条
$(function(){
	$('#codeList').perfectScrollbar();
	//title提示
    	$('.tip').poshytip({
            className: 'tip-yellowsimple',
            showTimeout: 1,
            alignTo: 'target',
            alignX: 'left',
            alignY: 'top',
            offsetX: 5,
            offsetY: -60,
            allowTipHover: false
        });
});
</script>
