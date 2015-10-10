<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-oredr-show">
  <div class="ncm-order-info">
    <div class="ncm-order-details">
      <div class="title"><?php echo $lang['member_show_order_info'];?></div>
      <div class="content">
        <dl>
          <dt><?php echo $lang['member_show_order_receiver'].$lang['nc_colon'];?></dt>
          <dd><span><?php echo $output['order_info']['extend_order_common']['reciver_name'];?>，</span><span><?php echo @$output['order_info']['extend_order_common']['reciver_info']['phone'];?>，</span><span><?php echo @$output['order_info']['extend_order_common']['reciver_info']['address'];?></span></dd>
        </dl>
        <dl>
          <dt>发&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;票：</dt>
          <dd>
            <?php foreach ((array)$output['order_info']['extend_order_common']['invoice_info'] as $key => $value){?>
            <span title="<?php echo $key;?>"><?php echo $value;?></span>
            <?php } ?>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['member_show_order_buyer_message'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['order_info']['extend_order_common']['order_message']; ?></dd>
        </dl>
        <dl class="line">
          <dt><?php echo $lang['member_change_order_no'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['order_info']['order_sn']; ?><a href="javascript:void(0);">更多<i class="icon-angle-down"></i>
            <div class="more"><span class="arrow"></span>
              <ul>
                <?php if($output['order_info']['payment_name']) { ?>
                <li><?php echo $lang['member_order_pay_method'].$lang['nc_colon'];?><span><?php echo $output['order_info']['payment_name']; ?>
                  <?php if($output['order_info']['payment_code'] != 'offline' && !in_array($output['order_info']['order_state'],array(ORDER_STATE_CANCEL,ORDER_STATE_NEW))) { ?>
                  (<?php echo '付款单号'.$lang['nc_colon'];?><?php echo $output['order_info']['pay_sn']; ?>)
                  <?php } ?>
                  </span> </li>
                <?php } ?>
                <li><?php echo $lang['member_order_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']); ?></span></li>
                <?php if(intval($output['order_info']['payment_time'])) { ?>
                <li><?php echo $lang['member_show_order_pay_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['payment_time']); ?></span></li>
                <?php } ?>
                <?php if($output['order_info']['extend_order_common']['shipping_time']) { ?>
                <li><?php echo $lang['member_show_order_send_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']); ?></span></li>
                <?php } ?>
                <?php if(intval($output['order_info']['finnshed_time'])) { ?>
                <li><?php echo $lang['member_show_order_finish_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['finnshed_time']); ?></span></li>
                <?php } ?>
              </ul>
            </div>
            </a></dd>
        </dl>
        <dl>
          <dt><?php echo $lang['member_show_order_seller_info'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['order_info']['extend_store']['store_name']; ?><a href="javascript:void(0);">更多<i class="icon-angle-down"></i>
            <div class="more"><span class="arrow"></span>
              <ul>
                <li><?php echo $lang['member_address_location'].$lang['nc_colon'];?><span><?php echo $output['order_info']['extend_store']['area_info'].'&nbsp;'.$output['order_info']['extend_store']['store_address']; ?></span></li>
                <li>联系电话：<span><?php echo $output['order_info']['extend_store']['store_phone']; ?></span></li>
              </ul>
            </div>
            </a>
            <div class="msg"> <span member_id="<?php echo $output['order_info']['extend_store']['member_id'];?>"></span>
              <?php if(!empty($output['order_info']['extend_store']['store_qq'])){?>
              <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $output['order_info']['extend_store']['store_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $order_info['extend_store']['store_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $output['order_info']['extend_store']['store_qq'];?>:52" style=" vertical-align: middle;"/></a>
              <?php }?>
              <!-- wang wang -->
              <?php if(!empty($output['order_info']['extend_store']['store_ww'])){?>
              <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $output['order_info']['extend_store']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>"  class="vm" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['order_info']['extend_store']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="Wang Wang"  style=" vertical-align: middle;"/></a>
              <?php }?>
            </div>
          </dd>
        </dl>
      </div>
    </div>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_CANCEL) { ?>
    <div class="ncm-order-condition">
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
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>订单已经提交，等待买家付款</dd>
      </dl>
      <ul>
        <li>1. 您尚未对该订单进行支付，请<a href="index.php?act=buy&op=pay&pay_sn=<?php echo $output['order_info']['pay_sn'];?>" class="ncm-btn-mini ncm-btn-orange"><i></i>支付订单</a>以确保商家及时发货。</li>
        <li>2. 如果您不想购买此订单的商品，请选择<a href="#order-step" class="ncm-btn-mini">取消订单</a>操作。</li>
        <li>3. 如果您未对该笔订单进行支付操作，系统将于
          <time><?php echo date('Y-m-d H:i:s',$output['order_info']['order_cancel_day']);?></time>
          自动关闭该订单。</li>
      </ul>
    </div>
    <?php } ?>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_PAY) { ?>
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>
          <?php if ($output['order_info']['payment_code'] == 'offline') { ?>
          订单已提交，等待卖家发货
          <?php } else { ?>
          已支付成功
          <?php } ?>
        </dd>
      </dl>
      <ul>
        <?php if ($output['order_info']['payment_code'] == 'offline') { ?>
        <li>1. 您已经选择货到付款方式下单成功。</li>
        <li>2. 订单已提交商家进行备货发货准备。</li>
        <li>3. 如果您不想购买此订单的商品，请选择<a href="#order-step" class="ncm-btn-mini">取消订单</a>操作。</li>
        <?php } else { ?>
        <li>1. 您已使用“<?php echo orderPaymentName($output['order_info']['payment_code']);?>”方式成功对订单进行支付，支付单号 “<?php echo $output['order_info']['pay_sn'];?>”。</li>
        <li>2. 订单已提交商家进行备货发货准备。</li>
        <li>3. 如果您想取消购买，请与商家沟通后对订单进行<a class="ncm-btn-mini" href="#order-step">申请退款</a>操作。</li>
        <?php } ?>
      </ul>
    </div>
    <?php } ?>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_SEND) { ?>
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>商家已发货
          <?php if ($output['order_info']['extend_order_common']['dlyo_pickup_code'] != '') { ?>
          ， 提货码：<?php echo $output['order_info']['extend_order_common']['dlyo_pickup_code'];?>
          <?php } ?>
        </dd>
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
        <li>2. 如果您已收到货，且对商品满意，您可以<a href="#order-step" class="ncm-btn-mini ncm-btn-green">确认收货</a>完成交易。</li>
        <li>3. 系统将于
          <time><?php echo date('Y-m-d H:i:s',$output['order_info']['order_confirm_day']);?></time>
          自动完成“确认收货”，完成交易。</li>
      </ul>
    </div>
    <?php } ?>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_SUCCESS) { ?>
    <?php if ($output['order_info']['evaluation_state'] == 1) { ?>
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>评价完成。</dd>
      </dl>
      <ul>
        <li>1. 您已对该笔订单进行了商品及交易评价，感谢您的支持，祝您购物愉快！</li>
        <li>2. 将感兴趣的<a href="index.php?act=member_favorites&op=fglist" class="ncm-btn-mini">收藏商品</a>加入购物车进行购买。</li>
        <li>3. 看一看<a href="<?php echo urlShop('show_store','index',array('store_id'=>$output['order_info']['store_id']), $output['order_info']['extend_store']['store_domain']);?>" class="ncm-btn-mini">该店铺</a>中有什么新商品上架。</li>
      </ul>
    </div>
    <?php } else { ?>
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>已经收货。</dd>
      </dl>
      <ul>
        <li>1. 如果收到货后出现问题，您可以联系商家协商解决。</li>
        <li>2. 如果商家没有履行应尽的承诺，您可以申请 <a href="#order-step" class="red">"投诉维权"</a>。</li>
        <?php if ($output['order_info']['if_evaluation']) { ?>
        <li>3. 交易已完成，你可以对购买的商品及商家的服务进行<a href="#order-step" class="ncm-btn-mini ncm-btn-acidblue">评价</a>及晒单。</li>
        <?php } ?>
      </ul>
    </div>
    <?php } ?>
    <?php } ?>
    <div class="mall-msg">有疑问可咨询<a href="javascript:void(0);" onclick="ajax_form('mall_consult', '平台客服', '<?php echo urlShop('member_mallconsult', 'add_mallconsult', array('inajax' => 1));?>', 640);"><i class="icon-comments-alt"></i>平台客服</a></div>
  </div>
  <?php if ($output['order_info']['order_state'] != ORDER_STATE_CANCEL) { ?>
  <div id="order-step" class="ncm-order-step">
    <dl class="step-first <?php if ($output['order_info']['order_state'] != ORDER_STATE_CANCEL) echo 'current';?>">
      <dt>生成订单</dt>
      <dd class="bg"></dd>
      <dd class="date" title="<?php echo $lang['member_order_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']); ?></dd>
    </dl>
    <?php if ($output['order_info']['payment_code'] != 'offline') { ?>
    <dl class="<?php if(intval($output['order_info']['payment_time'])) echo 'current'; ?>">
      <dt>完成付款</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="<?php echo $lang['member_show_order_pay_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['payment_time']); ?></dd>
    </dl>
    <?php } ?>
    <dl class="<?php if($output['order_info']['extend_order_common']['shipping_time']) echo 'current'; ?>">
      <dt>商家发货</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="<?php echo $lang['member_show_order_send_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']); ?></dd>
    </dl>
    <dl class="<?php if(intval($output['order_info']['finnshed_time'])) { ?>current<?php } ?>">
      <dt>确认收货</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="<?php echo $lang['member_show_order_finish_time'];?>"><?php echo date("Y-m-d H:i:s",$output['order_info']['finnshed_time']); ?></dd>
    </dl>
    <dl class="<?php if($output['order_info']['evaluation_state'] == 1) { ?>current<?php } ?>">
      <dt>评价</dt>
      <dd class="bg"></dd>
      <dd class="date" title="评价时间"><?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['evaluation_time']); ?></dd>
    </dl>
  </div>
  <?php } ?>
  <div class="ncm-order-contnet">
    <table class="ncm-default-table order">
      <thead>
        <tr>
          <th class="w10"></th>
          <th colspan="2"><?php echo $lang['member_order_goods_name'];?></th>
          <th class="w20"></th>
          <th class="w120 tl"><?php echo $lang['member_order_price'];?>（元）</th>
          <th class="w60"><?php echo $lang['member_order_amount'];?></th>
          <th class="w100">优惠活动</th>
          <th class="w100">售后维权</th>
          <th class="w100">交易状态</th>
          <th class="w100">交易操作</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($output['order_info']['shipping_code'])) { ?>
        <tr>
          <th colspan="7" style="border-right: none;"> <div class="order-deliver"><span>物流公司： <a target="_blank" href="<?php echo $output['order_info']['express_info']['e_url'];?>"><?php echo $output['order_info']['express_info']['e_name'];?></a></span><span> <?php echo $lang['member_show_order_shipping_no'].$lang['nc_colon'];?> <?php echo $output['order_info']['shipping_code'];?> </span><span><a href="javascript:void(0);" id="show_shipping">物流跟踪<i class="icon-angle-down"></i>
              <div class="more"><span class="arrow"></span>
                <ul id="shipping_ul">
                  <li>加载中...</li>
                </ul>
              </div>
              </a></span></div></th>
          <th colspan="3" style=" border-left: none;"><?php if(!empty($output['daddress_info'])) { ?>
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
        <?php foreach($output['order_info']['goods_list'] as $k => $goods) {?>
        <?php $i++;?>
        <tr class="bd-line">
          <td>&nbsp;</td>
          <td class="w70"><div class="ncm-goods-thumb"><a target="_blank" href="<?php echo $goods['goods_url']; ?>"><img src="<?php echo $goods['image_60_url']; ?>" onMouseOver="toolTip('<img src=<?php echo $goods['image_240_url']; ?>>')" onMouseOut="toolTip()" /></a></div></td>
          <td class="tl"><dl class="goods-name">
              <dt><a target="_blank" href="<?php echo $goods['goods_url']; ?>"><?php echo $goods['goods_name']; ?></a></dt>
              <dd>
                <?php if (is_array($output['refund_all']) && !empty($output['refund_all'])) {?>
                退款单号：<a target="_blank" href="index.php?act=member_refund&op=view&refund_id=<?php echo $output['refund_all']['refund_id'];?>"><?php echo $output['refund_all']['refund_sn'];?></a>
                <?php }else if($goods['extend_refund']['refund_type'] == 1) {?>
                退款单号：<a target="_blank" href="index.php?act=member_refund&op=view&refund_id=<?php echo $goods['extend_refund']['refund_id'];?>"><?php echo $goods['extend_refund']['refund_sn'];?></a></dd>
              <?php }else if($goods['extend_refund']['refund_type'] == 2) {?>
              退货单号：<a target="_blank" href="index.php?act=member_return&op=view&return_id=<?php echo $goods['extend_refund']['refund_id'];?>"><?php echo $goods['extend_refund']['refund_sn'];?></a>
              </dd>
              <?php } ?>
            </dl></td>
          <td></td>
          <td class="tl refund"><?php echo $goods['goods_price']; ?>
            <p class="green">
              <?php if (is_array($output['refund_all']) && !empty($output['refund_all']) && $output['refund_all']['admin_time'] > 0) {?>
              <?php echo $goods['goods_pay_price'];?><span>退</span>
              <?php } elseif ($goods['extend_refund']['admin_time'] > 0) { ?>
              <?php echo $goods['extend_refund']['refund_amount'];?><span>退</span>
              <?php } ?>
            </p></td>
          <td><?php echo $goods['goods_num']; ?></td>
          <td><?php echo $goods['goods_type_cn']; ?></td>
          <td><!-- 退款 -->
            
            <?php if ($goods['refund'] == 1){?>
            <p><a href="index.php?act=member_refund&op=add_refund&order_id=<?php echo $output['order_info']['order_id']; ?>&goods_id=<?php echo $goods['rec_id']; ?>">退款/退货</a></p>
            <?php }?>
            
            <!-- 投诉 -->
            
            <?php if ($output['order_info']['if_complain']){ ?>
            <p><a href="index.php?act=member_complain&op=complain_new&order_id=<?php echo $output['order_info']['order_id']; ?>&goods_id=<?php echo $goods['rec_id']; ?>">交易投诉</a></p>
            <?php } ?></td>
          
          <!-- S 合并TD -->
          <?php if (($output['order_info']['goods_count'] > 1 && $k ==0) || ($output['order_info']['goods_count'] == 1)){ ?>
          <td class="bdl bdr" rowspan="<?php echo $output['order_info']['goods_count'];?>"><?php echo $output['order_info']['state_desc']; ?></td>
          <td rowspan="<?php echo $output['order_info']['goods_count'];?>"><?php if ($output['order_info']['if_lock']) { ?>
            <p>退款退货中</p>
            <?php } ?>
            
            <!-- 取消订单 -->
            
            <?php if ($output['order_info']['if_cancel']) { ?>
            <p><a href="javascript:void(0)" style="color:#F30; text-decoration:underline;" nc_type="dialog" dialog_width="480" dialog_title="<?php echo $lang['member_order_cancel_order'];?>" dialog_id="buyer_order_cancel_order" uri="index.php?act=member_order&op=change_state&state_type=order_cancel&order_id=<?php echo $output['order_info']['order_id']; ?>"  id="order_action_cancel"><?php echo $lang['member_order_cancel_order'];?></a></p>
            <?php } ?>
            
            <!-- 退款取消订单 -->
            
            <?php if ($output['order_info']['if_refund_cancel']){ ?>
            <p><a href="index.php?act=member_refund&op=add_refund_all&order_id=<?php echo $output['order_info']['order_id']; ?>" class="ncm-btn">订单退款</a></p>
            <?php } ?>
            
            <!-- 收货 -->
            
            <?php if ($output['order_info']['if_receive']) { ?>
            <p><a href="javascript:void(0)" class="ncm-btn" nc_type="dialog" dialog_id="buyer_order_confirm_order" dialog_width="480" dialog_title="<?php echo $lang['member_order_ensure_order'];?>" uri="index.php?act=member_order&op=change_state&state_type=order_receive&order_sn=<?php echo $output['order_info']['order_sn']; ?>&order_id=<?php echo $output['order_info']['order_id']; ?>" id="order_action_confirm"><?php echo $lang['member_order_ensure_order'];?></a></p>
            <?php } ?>
            
            <!-- 评价 -->
            
            <?php if ($output['order_info']['if_evaluation']) { ?>
            <p><a class="ncm-btn ncm-btn-acidblue" href="index.php?act=member_evaluate&op=add&order_id=<?php echo $output['order_info']['order_id']; ?>"><?php echo $lang['member_order_want_evaluate'];?></a></p>
            <?php } ?>
            
            <!-- 已经评价 -->
            
            <?php if ($output['order_info']['evaluation_state'] == 1) { echo $lang['order_state_eval'];} ?>
            
            <!-- 分享  -->
            
            <?php if ($output['order_info']['if_share']) { ?>
            <p><a href="javascript:void(0)" nc_type="sharegoods" data-param='{"gid":"<?php echo $output['order_info']['extend_order_goods'][0]['goods_id'];?>"}'>分享商品</a></p>
            <?php } ?></td>
          <?php } ?>
          <!-- E 合并TD --> 
        </tr>
        
        <!-- S 赠品列表 -->
        <?php if (!empty($output['order_info']['zengpin_list']) && $i == count($output['order_info']['goods_list'])) { ?>
        <tr class="bd-line">
          <td>&nbsp;</td>
          <td colspan="7" class="tl"><div class="ncm-goods-gift">赠品：
              <ul>
                <?php foreach($output['order_info']['zengpin_list'] as $zengpin_info) {?>
                <li><a target="_blank" title="赠品：<?php echo $zengpin_info['goods_name'];?> * <?php echo $zengpin_info['goods_num'];?>" href="<?php echo $zengpin_info['goods_url']; ?>"><img src="<?php echo $zengpin_info['image_60_url']; ?>" onMouseOver="toolTip('<img src=<?php echo $zengpin_info['image_240_url']; ?>>')" onMouseOut="toolTip()" /></a></li>
                <?php } ?>
              </ul>
            </div></td>
        </tr>
        <?php } ?>
        <!-- E 赠品列表 -->
        
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['order_info']['extend_order_common']['promotion_info']) || !empty($output['order_info']['extend_order_common']['voucher_code'])){ ?>
        <tr>
          <th colspan="20"><dl class="ncm-store-sales">
              <?php if(!empty($output['order_info']['extend_order_common']['promotion_info'])){ ?>
              <dd><?php echo $output['order_info']['extend_order_common']['promotion_info'];?></dd>
              <?php } ?>
              <?php if(!empty($output['order_info']['extend_order_common']['voucher_code'])){ ?>
              <dd>使用了面额为 <strong><?php echo $output['order_info']['extend_order_common']['voucher_price'];?></strong> 元的代金券，编码：<?php echo $output['order_info']['extend_order_common']['voucher_code'];?></span></dd>
              <?php } ?>
            </dl>
          </th>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="20"><dl class="freight">
              <dd>
                <?php if(!empty($output['order_info']['shipping_fee']) && $output['order_info']['shipping_fee'] != '0.00'){ ?>
                <?php echo $lang['member_show_order_tp_fee'].$lang['nc_colon'];?><span><?php echo $lang['currency'];?><?php echo $output['order_info']['shipping_fee']; ?></span>
                <?php if ($output['order_info']['shipping_name'] != ''){echo '('.$output['order_info']['shipping_name'].')';};?>
                <?php }else{?>
                <?php echo $lang['nc_common_shipping_free'];?>
                <?php }?>
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
              
              <dt><?php echo $lang['member_order_sum'].$lang['nc_colon'];?></dt>
              <dd><em><?php echo $output['order_info']['order_amount']; ?></em>元</dd>
            </dl></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" ></script> 
<script type="text/javascript">
$(function(){
    $('#show_shipping').on('hover',function(){
        var_send = '<?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']); ?>&nbsp;&nbsp;<?php echo $lang['member_show_seller_has_send'];?><br/>';
    	$.getJSON('index.php?act=member_order&op=get_express&e_code=<?php echo $output['order_info']['express_info']['e_code']?>&shipping_code=<?php echo $output['order_info']['shipping_code']?>&t=<?php echo random(7);?>',function(data){
    		if(data){
    			data = var_send+data.join('<br/>');
    			$('#shipping_ul').html('<li>'+data+'</li>');
    			$('#show_shipping').unbind('hover');
    		}else{
    			$('#shipping_ul').html(var_send);
    			$('#show_shipping').unbind('hover');
    		}
    	});
    });
});
</script> 
