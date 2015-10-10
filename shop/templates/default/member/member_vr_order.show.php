<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-oredr-show">
  <div class="ncm-order-info">
    <div class="ncm-order-details">
      <div class="title">虚拟订单信息</div>
      <div class="content">
        <dl>
          <dt>接收手机：</dt>
          <dd><?php echo $output['order_info']['buyer_phone'];?>
            <?php if ($output['order_info']['order_state'] == ORDER_STATE_PAY) { ?>
            <a href="javascript:void(0);" class="ncm-btn-mini ncm-btn-orange" dialog_id="vr_code_resend" dialog_title="发送电子兑换码" dialog_width="480" nc_type="dialog" uri="<?php echo urlShop('member_vr_order', 'resend',array('buyer_phone'=>$output['order_info']['buyer_phone'],'order_id'=>$output['order_info']['order_id']));?>"><i class="icon-mobile-phone"></i>重新发送</a>
            <?php } ?>
          </dd>
        </dl>
        <dl class="line">
          <dt>虚拟单号：</dt>
          <dd><?php echo $output['order_info']['order_sn'];?><a href="javascript:void(0);">更多<i class="icon-angle-down"></i>
            <div class="more"><span class="arrow"></span>
              <ul>
                <li>支付方式：<span><?php echo orderPaymentName($output['order_info']['payment_code']);?></span></li>
                <li>下单时间：<span><?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']);?></span></li>
                <?php if(!empty($output['order_info']['payment_time'])){?>
                <li>付款时间：<span><?php echo date("Y-m-d H:i:s",$output['order_info']['payment_time']);?></span></li>
                <?php } ?>
              </ul>
            </div>
            </a></dd>
        </dl>
        <dl class="line">
          <dt>买家留言：</dt>
          <dd><?php echo $output['order_info']['buyer_msg'];?></dd>
        </dl>
        <dl class="line">
          <dt>商&#12288;&#12288;家：</dt>
          <dd><?php echo $output['order_info']['store_name'];?><a href="javascript:void(0);" id="mapmore">更多<i class="icon-angle-down"></i>
            <div class="more"><span class="arrow"></span>
              <ul>
                <li> 联系电话：<span><?php echo !empty($output['store_info']['live_store_tel']) ? $output['store_info']['live_store_tel'] : $output['store_info']['store_phone']; ?></span> </li>
                <li>地&#12288;&#12288;址： <span><?php echo !empty($output['store_info']['live_store_address']) ? $output['store_info']['live_store_address'] : $output['store_info']['store_address']; ?></span> </li>
                <li>
                  <div id="container"></div>
                </li>
                <li>交通信息：<?php echo $output['store_info']['live_store_bus'];?></li>
              </ul>
            </div>
            </a></dd>
        </dl>
      </div>
    </div>
    <?php if ($output['order_info']['order_state'] == ORDER_STATE_CANCEL){ ?>
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-off orange"></i>订单状态：</dt>
        <dd>交易关闭</dd>
      </dl>
      <ul>
        <li><?php echo date("Y-m-d H:i:s",$output['order_info']['close_time']);?> 交易关闭，原因：<?php echo $output['order_info']['close_reason'];?></li>
      </ul>
    </div>
    <?php } elseif ($output['order_info']['order_state'] == ORDER_STATE_NEW){ ?>
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>订单已生成，待付款</dd>
      </dl>
      <ul>
        <li>1. 您尚未对该订单进行支付，请<a href="index.php?act=buy_virtual&op=pay&order_id=<?php echo $output['order_info']['order_id']; ?>" class="ncm-btn-mini ncm-btn-orange"><i></i>支付订单</a>以确保及时获取电子兑换码。</li>
        <li>2. 如果您不想购买此订单，请点击 <a href="#order-list" class="ncm-btn-mini" >取消订单</a>。 </li>
        <li>3. 系统将于
          <time><?php echo date('Y-m-d H:i:s',$output['order_info']['order_cancel_day']);?></time>
          自动关闭该订单，请您及时付款。</li>
      </ul>
    </div>
    <?php } elseif ($output['order_info']['order_state'] == ORDER_STATE_PAY){ ?>
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>已付款，电子兑换码已发放</dd>
      </dl>
      <ul>
        <li>1. 本次电子兑换码已由系统自动发出，请查看您的接受手机短信或该页下方“电子兑换码”。</li>
        <li>2. 您尚有&nbsp;<strong class="green"><?php echo $output['order_info']['extend_vr_order_code'][0]['vr_code_valid_count'];?></strong>&nbsp;组电子兑换码未被使用；有效期为
          <time><?php echo date("Y-m-d",$output['order_info']['vr_indate']);?></time>
          ，逾期自动失效，请及时使用。</li>
      </ul>
    </div>
    <?php } elseif ($output['order_info']['order_state'] == ORDER_STATE_SUCCESS){ ?>
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>订单已完成。</dd>
      </dl>
      <ul>
        <li>1. 使用期已经结束，感谢您的惠顾！</li>
        <li>2. 去商城看看有没有新的<a href="<?php echo urlShop('search','index');?>" class="ncm-btn-mini ncm-btn-green" target="_blank">虚拟商品</a>。</li>
      </ul>
    </div>
    <?php }?>
    <div class="mall-msg">有疑问可咨询<a href="javascript:void(0);" onclick="ajax_form('mall_consult', '平台客服', '<?php echo urlShop('member_mallconsult', 'add_mallconsult', array('inajax' => 1));?>', 640);"><i class="icon-comments-alt"></i>平台客服</a></div>
  </div>
  <?php if ( $output['order_info']['order_state'] != ORDER_STATE_CANCEL){ ?>
  <div class="ncm-order-step">
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
    <?php if (!empty($output['order_info']['extend_vr_order_code'])){ ?>
    <div class="code-list tip" title="如列表过长超出显示区域时可滚动鼠标进行查看"><i class="arrow"></i>
      <h5>电子兑换码</h5>
      <div id="codeList">
        <ul>
          <?php foreach($output['order_info']['extend_vr_order_code'] as $code_info){ ?>
          <li class="<?php echo $code_info['vr_state'] == 1 ? 'used' : null;?>"><strong><?php echo $code_info['vr_code'];?></strong> <?php echo $code_info['vr_code_desc'];?> </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <?php } ?>
  </div>
  <?php }?>
  <div class="ncm-order-contnet" id="order-list">
    <table class="ncm-default-table order">
      <thead>
        <tr>
          <th class="w10"></th>
          <th colspan="2">商品</th>
          <th class="w100 tl">单价 (元)</th>
          <th class="w60">数量</th>
          <th class="w100">售后</th>
          <th class="w100">交易状态</th>
          <th class="w120">交易操作</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th colspan="20"><span class="ml10" title="虚拟订单号">虚拟订单号：<?php echo $output['order_info']['order_sn'];?></span><span>下单时间：<?php echo date("Y-m-d H:i",$output['order_info']['add_time']);?></span><span><a href="<?php echo urlShop('show_store','index',array('store_id'=>$output['order_info']['store_id']));?>" title="<?php echo $output['order_info']['store_name'];?>"><?php echo $output['store_info']['store_name'];?></a></span>

            <!-- QQ -->
            <span member_id="<?php echo $output['store_info']['member_id'];?>">
            <?php if(!empty($output['store_info']['store_qq'])){?>
            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $output['store_info']['store_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $output['store_info']['store_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $output['store_info']['store_qq'];?>:52" style=" vertical-align: middle;"/></a>
            <?php }?>

            <!-- wang wang -->
            <?php if(!empty($output['store_info']['store_ww'])){?>
            <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>"  class="vm" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="Wang Wang"  style=" vertical-align: middle;"/></a>
            <?php }?>
            </span></th>
        </tr>
        <tr>
          <td class="bdl"></td>
          <td class="w50"><div class="pic-thumb"><a href="<?php echo urlShop('goods','index',array('goods_id' => $output['order_info']['goods_id']));?>" target="_blank" onMouseOver="toolTip('<img src=<?php echo thumb($output['order_info'], 240);?>>')" onMouseOut="toolTip()"/><img src="<?php echo thumb($output['order_info'], 60);?>"/></a></div></td>
          <td class="tl"><dl class="goods-name">
              <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$output['order_info']['goods_id']));?>" target="_blank" title="<?php echo $output['order_info']['goods_name'];?>"><?php echo $output['order_info']['goods_name'];?></a></dt>
              <dd><span class="sale-type"><?php if ($output['order_info']['order_promotion_type'] == 1) {?>抢购，<?php } ?>使用时效：即日起 至 <?php echo date("Y-m-d",$output['order_info']['vr_indate']);?>
              <?php if ($output['order_info']['vr_invalid_refund'] == '0') { ?>
              ，过期不退款
              <?php } ?>
              </span></dd>
            </dl></td>
          <td class="tl"><?php echo $output['order_info']['goods_price'];?></td>
          <td><?php echo $output['order_info']['goods_num'];?></td>
          <td> <?php if($output['order_info']['if_refund']){ ?>
              <a href="index.php?act=member_vr_refund&op=add_refund&order_id=<?php echo $output['order_info']['order_id']; ?>">退款</a>
              <?php } ?></td>
          <td class="bdl"><?php echo $output['order_info']['state_desc'];?></td>
          <td class="bdl bdr">

          <?php if ($output['order_info']['if_cancel']){ ?>
            <a href="javascript:void(0)" class="ncm-btn ncm-btn-red" nc_type="dialog" dialog_width="480" dialog_title="取消订单" dialog_id="buyer_order_cancel_order" uri="index.php?act=member_vr_order&op=change_state&state_type=order_cancel&order_id=<?php echo $output['order_info']['order_id'];?>"  id="order_action_cancel"><i class="icon-ban-circle"></i>取消</a>
            <?php }?>

            <!-- 评价 -->
            <?php if ($output['order_info']['if_evaluation']) { ?>
            <p><a class="ncm-btn ncm-btn-acidblue" href="index.php?act=member_evaluate&op=add_vr&order_id=<?php echo $output['order_info']['order_id']; ?>"><?php echo $lang['member_order_want_evaluate'];?></a></p>
            <?php } ?>

            <!-- 已经评价 -->
            <?php if ($output['order_info']['evaluation_state'] == 1) { echo $lang['order_state_eval'];} ?>

            <!-- 分享  -->
            <?php if ($output['order_info']['if_share']) { ?>
            <p><a href="javascript:void(0)" nc_type="sharegoods" data-param='{"gid":"<?php echo $output['order_info']['goods_id'];?>"}'>分享商品</a></p>
            <?php } ?>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <?php if(!empty($output['order_info']['voucher_code'])){ ?>
        <tr>
          <th colspan="20"><dl class="ncm-store-sales">
              <?php if(!empty($output['order_info']['voucher_code'])){ ?>
              <dd><span>使用了 <strong><?php echo $output['order_info']['voucher_price'];?></strong> 元 代金券（编码：<?php echo $output['order_info']['voucher_code'];?>）</span></dd>
              <?php } ?>
            </dl>
          </th>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="20"><dl class="sum">
             <!--//zmr>v80-->
             <?php if($output['order_info']['rcb_amount']>0){ ?>
             <dt style="color:blue">充值卡已支付：</dt>
              <dd><em><?php echo $output['order_info']['rcb_amount']; ?></em>元</dd>
               <?php } ?>
               <?php if($output['order_info']['pd_amount']>0){ ?>
            <dt style="color:blue">预存款已支付：</dt>
              <dd><em><?php echo $output['order_info']['pd_amount']; ?></em>元</dd>
               <?php } ?>
              <dt>订单应付金额：</dt>
              <dd><em><?php echo $output['order_info']['order_amount'];?></em>元</dd>
            </dl></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" ></script>
<script type="text/javascript">
var cityName = '';
var address = '<?php echo str_replace("'",'"',$output['store_info']['live_store_address']);?>';
var store_name = '<?php echo str_replace("'",'"',$output['store_info']['live_store_name']);?>';
var map = "";
var localCity = "";
var opts = {width : 150,height: 50,title : "商铺名称:"+store_name}
function initialize() {
	map = new BMap.Map("container");
	localCity = new BMap.LocalCity();

	map.enableScrollWheelZoom();
	map.addControl(new BMap.NavigationControl());
	map.addControl(new BMap.ScaleControl());
	map.addControl(new BMap.OverviewMapControl());
	localCity.get(function(cityResult){
	  if (cityResult) {
	  	var level = cityResult.level;
	  	if (level < 13) level = 13;
	    map.centerAndZoom(cityResult.center, level);
	    cityResultName = cityResult.name;
	    if (cityResultName.indexOf(cityName) >= 0) cityName = cityResult.name;
	    	    	getPoint();
	    	  }
	});
}

function loadScript() {
	var script = document.createElement("script");
	script.src = "http://api.map.baidu.com/api?v=1.2&callback=initialize";
	document.body.appendChild(script);
}
function getPoint(){
	var myGeo = new BMap.Geocoder();
	myGeo.getPoint(address, function(point){
	  if (point) {
	    setPoint(point);
	  }
	}, cityName);
}
function setPoint(point){
	  if (point) {
	    map.centerAndZoom(point, 16);
	    var marker = new BMap.Marker(point);
	    var infoWindow = new BMap.InfoWindow("商铺地址:"+address, opts);
			marker.addEventListener("click", function(){
			   this.openInfoWindow(infoWindow);
			});
	    map.addOverlay(marker);
			marker.openInfoWindow(infoWindow);
	  }
}

// 当鼠标放在店铺地图上再加载百度地图。
$(function(){
	$('#mapmore').one('mouseover',function(){
		loadScript();
	});
});
</script>
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
<script>
function closeErrors() {
return true;
}
window.onerror=closeErrors;
</script>