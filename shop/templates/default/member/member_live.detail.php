<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-oredr-show">
  <div class="ncm-order-info">
    <div class="ncm-order-details">
      <div class="title">线下抢购订单信息</div>
      <div class="content">
        <dl>
          <dt>联系手机：</dt>
          <dd><?php echo $output['order']['mobile'];?></dd>
        </dl>
        <dl>
          <dt>订单留言：</dt>
          <dd><?php echo $output['order']['leave_message'];?></dd>
        </dl>
        <dl class="line">
          <dt>抢购单号：</dt>
          <dd><?php echo $output['order']['order_sn'];?><a href="javascript:void(0);">更多<i class="icon-angle-down"></i>
            <div class="more"><span class="arrow"></span>
              <ul>
                <li>支付方式：<?php echo orderPaymentName($output['order']['payment_code']);?></li>
                <li>订单生成：<span><?php echo date("Y-m-d H:i:s",$output['order']['add_time']);?></span></li>
                <?php if(!empty($output['order']['payment_time'])){?>
				<li>付款完毕：<span><?php echo date("Y-m-d H:i:s",$output['order']['payment_time']);?></span></li>
				<?php }?>
				<?php if(!empty($output['order']['use_time'])){?>
                <li>最近使用：<span><?php echo date("Y-m-d H:i:s",$output['order']['use_time']);?></span></li>
				<?php }?>
				<?php if(!empty($output['order']['finish_time'])){?>
                <li>使用完成：<span><?php echo date("Y-m-d H:i:s",$output['order']['finish_time']);?></span></li>
				<?php }?>
              </ul>
            </div>
            </a></dd>
        </dl>
        <dl class="line">
          <dt>商&#12288;&#12288;家：</dt>
          <dd><?php echo $output['order']['store_name'];?><a href="javascript:void(0);" id="mapmore">更多<i class="icon-angle-down"></i>
            <div class="more"><span class="arrow"></span>
              <ul>
                <li>联系电话：
                  <?php 
						if(!empty($output['store']['live_store_tel'])){
							echo $output['store']['live_store_tel'];
						}else{
							echo $output['store']['store_phone'];
						}	
					?>
                </li>
                <li>地&#12288;&#12288;址： <span>
                  <?php 
						if(!empty($output['store']['live_store_address'])){
							echo $output['store']['live_store_address'];
						}else{
							echo $output['store']['store_address'];
						}
					?>
                  </span> </li>
                <li>
                  <div id="container"></div>
                </li>
                <li>交通信息：<?php echo $output['store']['live_store_bus'];?></li>
              </ul>
            </div>
            </a></dd>
        </dl>
      </div>
    </div>
    <?php if($output['order']['state']==4){//4.取消订单?>
    <!-- S 订单关闭-->
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-off orange"></i>订单状态：</dt>
        <dd>交易关闭</dd>
      </dl>
      <ul>
        <li><?php echo date("Y-m-d H:i:s",$output['order']['cancel_time']);?>取消订单</li>
      </ul>
    </div>
    <!-- E 订单关闭-->
    <?php }elseif($output['order']['state']==1){//1.待支付?>
    <!-- S 下单成功待支付-->
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>订单已经提交，等待买家付款</dd>
      </dl>
      <ul>
        <li>1. 您尚未对该订单进行支付，请<a href="index.php?act=show_live_groupbuy&op=pay&order_sn=<?php echo $output['order']['order_sn']; ?>" class="ncm-btn-mini ncm-btn-orange"><i></i>支付订单</a>以确保抢购兑换码及时发放。</li>
        <li>2. 如果您不想购买此订单抢购，请选择					
		<a href="javascript:void(0)" class="ncm-btn-mini" nc_type="dialog" dialog_width="480" dialog_title="取消抢购" dialog_id="buyer_order_cancel_order" uri="index.php?act=member_live&op=cancel&order_id=<?php echo $output['order']['order_id'];?>"  id="order<?php echo $output['order']['order_id'];?>_action_cancel">取消抢购</a>操作。
		</li>
        <li>3. 如果您未对该笔订单进行支付操作，系统将于
          <time><?php echo date('Y-m-d H:i:s',$output['order']['order_cancel_day']);?></time>
          自动关闭该订单。</li>
      </ul>
    </div>
    <!-- E 下单成功待支付 -->
    <?php }elseif($output['order']['state']==2){?>
    <!-- S 已支付未使用 -->
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>买家已付款，“抢购兑换码”已发放并可使用</dd>
      </dl>
      <ul>
        <li>1. 本此抢购兑换码已由系统自动发送，请查看您的接受手机短信或该页下方“抢购兑换码”。</li>
        <li>2. 您已经使用了&nbsp;<strong class="orange"><?php echo $output['use_pwd'];?></strong>&nbsp;组号码，尚有&nbsp;<strong class="green"><?php echo $output['no_use_pwd'];?></strong>&nbsp;组未被使用；有效期为<time><?php echo date("Y-m-d",$output['order']['validity']);?></time>
          ，逾期未用将自动过期。</li>
      </ul>
    </div>
    <!-- E 已支付未使用-->
    <?php }elseif($output['order']['state']==3){?>
    <!-- S 全部兑换完成订单 -->
    <div class="ncm-order-condition">
      <dl>
        <dt><i class="icon-ok-circle green"></i>订单状态：</dt>
        <dd>兑换使用完成。</dd>
      </dl>
      <ul>
        <li>1. 本次抢购兑换码已全部使用，感谢您的惠顾！</li>
        <li>2. 去商城看看新的<a href="<?php echo urlShop('show_live_groupbuy','index');?>" class="ncm-btn-mini ncm-btn-green" target="_blank">抢购</a>活动。</li>
      </ul>
    </div>
    <!-- E 全部兑换完成订单 -->
    <?php }?>
    <div class="mall-msg">有疑问可咨询<a href="javascript:void(0);" onclick="ajax_form('mall_consult', '平台客服', '<?php echo urlShop('member_mallconsult', 'add_mallconsult', array('inajax' => 1));?>', 640);"><i class="icon-comments-alt"></i>平台客服</a></div>
  </div>
  <?php if($output['order']['state']!=4){?>
  <div class="ncm-order-step">
    <dl class="step-first current">
      <dt>订单生成</dt>
      <dd class="bg"></dd>
      <dd class="date" title="提交线下抢购订单时间"><?php echo date("Y-m-d H:i:s",$output['order']['add_time']);?></dd>
    </dl>
    <dl class="<?php if (!empty($output['order']['payment_time'])){?>current<?php } ?>">
      <dt>支付订单</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="支付该笔订单时间"><?php echo @date('Y-m-d H:i:s',$output['order']['payment_time']);?></dd>
    </dl>
    <dl class="<?php if($output['use_pwd']>0){?> current <?php }?>">
      <dt>抢购兑换</dt>
      <dd class="bg"> </dd>
    </dl>
    <dl class="long <?php if(!empty($output['order']['finish_time'])){ ?>current<?php } ?>">
      <dt>使用完成</dt>
      <dd class="bg"> </dd>
      <dd class="date" title="全部兑换使用完成"><?php echo date("Y-m-d H:i:s",$output['order']['finish_time']); ?></dd>
    </dl>
    <?php if(!empty($output['order_pwd'])){?>
    <div class="code-list tip" title="如列表过长超出显示区域时可滚动鼠标进行查看"><i class="arrow"></i>
      <h5>线下抢购兑换码</h5>
      <div id="codeList">
      <ul>
        <?php foreach($output['order_pwd'] as $pwd){?>
        <li class="<?php if($pwd['state']==1){?><?php }else{?>used<?php }?>"><strong><?php echo $pwd['order_pwd'];?></strong>(
          <?php if($pwd['state']==1){?>
          未使用，有效期至:<?php echo date("Y-m-d",$output['order']['validity']);?>
          <?php }else{?>
          已使用，兑换时间：<?php echo date("Y-m-d H:i:s",$pwd['use_time']);?>
          <?php }?>)
        </li>
        <?php }?>
      </ul>
      </div>
    </div>
    <?php }?>
  </div>
  <?php }?>
  <div class="ncm-order-contnet">
    <table class="ncm-default-table order">
      <thead>
        <tr>
          <th class="w10"></th>
          <th colspan="2">线下抢购活动</th>
          <th class="w120 tl">单价 (元)</th>
          <th class="w60">数量</th>
          <th class="w100">交易状态</th>
          <th class="w120">交易操作</th>
        </tr>
      </thead>
      <tr>
        <th colspan="20"><span class="ml10" title="线下抢购订单编号">线下抢购单号：<?php echo $output['order']['order_sn'];?></span><span>下单时间：<?php echo date("Y-m-d H:i",$output['order']['add_time']);?></span><span><a href="<?php echo urlShop('show_store','index',array('store_id'=>$output['store']['store_id']));?>"  target="_blank" title="<?php echo $output['store']['store_name'];?>"><?php echo $output['store']['store_name'];?></a></span> 
          <!-- QQ --> 
          
          <span member_id="<?php echo $output['store']['member_id'];?>">
          <?php if(!empty($output['store']['store_qq'])){?>
          <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $output['store']['store_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $output['store']['store_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $output['store']['store_qq'];?>:52" style=" vertical-align: middle;"/></a>
          <?php }?>
          
          <!-- wang wang --> 
          
          <?php if(!empty($output['store']['store_ww'])){?>
          <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $output['store']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>"  class="vm" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['store']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="Wang Wang"  style=" vertical-align: middle;"/></a>
          <?php }?>
		  
          </span></th>
      </tr>
      <tbody>
      <td class="bdl"></td>
        <td class="w50"><div class="pic-thumb"><a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$output['order']['groupbuy_id']));?>" target="_blank" onMouseOver="toolTip('<img src=<?php echo lgthumb($output['order']['groupbuy_pic'], 'small');?>>')" onMouseOut="toolTip()"/><img src="<?php echo lgthumb($output['order']['groupbuy_pic'], 'small');?>"/></a></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$output['order']['groupbuy_id']));?>" target="_blank" title="<?php echo $val['item_name'];?>"><?php echo $output['order']['item_name'];?></a></dt>
            <dd><span class="sale-type">有效期：<?php echo date("Y-m-d",$output['order']['validity']);?></span></dd>
          </dl></td>
        <td class="tl"><?php echo $output['order']['groupbuy_price'];?></td>
        <td><?php echo $output['order']['number'];?></td>
        <td class="bdl"><?php 
					if($output['order']['state'] == 1){
						echo '<span style="color:#F30">待付款</span>';
					}elseif($output['order']['state'] == 2){
						echo '<span style="color:#5BB75B">兑换使用</span>';
					}elseif($output['order']['state'] == 3){
						echo '<span style="color:#AAA">使用完成</span>';
					}elseif($output['order']['state'] == 4){
						echo '<span style="color:#AAA">订单取消</span>';
					}
				?>                
                </td>
        <td class="bdl bdr">
		<?php if($output['order']['state'] == 1){?>
			<a href="javascript:void(0)" class="ncm-btn ncm-btn-red" nc_type="dialog" dialog_width="480" dialog_title="取消抢购" dialog_id="buyer_order_cancel_order" uri="index.php?act=member_live&op=cancel&order_id=<?php echo $output['order']['order_id'];?>"  id="order<?php echo $output['order']['order_id'];?>_action_cancel"><i class="icon-ban-circle"></i>取消抢购</a>
		<?php }?>
		</td>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"><dl class="sum">
              <dt><?php echo $lang['member_order_sum'].$lang['nc_colon'];?></dt>
              <dd><em><?php echo $output['order']['price'];?></em>元</dd>
            </dl></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
<script type="text/javascript">
var cityName = '';
var address = '<?php echo str_replace("'",'"',$output['store']['live_store_address']);?>';
var store_name = '<?php echo str_replace("'",'"',$output['store']['live_store_name']);?>';  
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