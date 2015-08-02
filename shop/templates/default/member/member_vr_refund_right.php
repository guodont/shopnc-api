<?php defined('InShopNC') or exit('Access Invalid!');?>

  <div class="ncm-flow-item">
    <div class="title">相关商品交易信息</div>
    <div class="item-goods">
        <?php if (is_array($output['order']) && !empty($output['order'])) { ?>
      <dl>
        <dt>
          <div class="ncm-goods-thumb-mini"><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=> $output['order']['goods_id'])); ?>">
            <img src="<?php echo thumb($output['order'],60); ?>" onMouseOver="toolTip('<img src=<?php echo thumb($output['order'],240); ?>>')" onMouseOut="toolTip()" /></a></div>
        </dt>
        <dd><a target="_blank" href="<?php echo urlShop('goods','index',array('goods_id'=> $output['order']['goods_id'])); ?>"><?php echo $output['order']['goods_name']; ?></a>
            <?php echo $lang['currency'];?><?php echo $output['order']['goods_price']; ?> * <?php echo $output['order']['goods_num']; ?> <font color="#AAA">(数量)</font>
        </dd>
      </dl>
        <?php } ?>
    </div>
    <div class="item-order">
      <dl>
        <dt>使用时效：</dt>
        <dd>即日起 至 <?php echo date("Y-m-d",$output['order']['vr_indate']);?></dd>
      </dl>
      <dl>
        <dt>订单总额：</dt>
        <dd><strong><?php echo $lang['currency'];?><?php echo ncPriceFormat($output['order']['order_amount']); ?>
          <?php if ($output['order']['refund_amount'] > 0) { ?>
          (<?php echo $lang['refund_add'].$lang['nc_colon'].$lang['currency'].$output['order']['refund_amount'];?>)
          <?php } ?>
          </strong> </dd>
      </dl>
      <dl class="line">
        <dt>订单编号：</dt>
        <dd><a target="_blank" href="index.php?act=member_vr_order&op=show_order&order_id=<?php echo $output['order']['order_id']; ?>"><?php echo $output['order']['order_sn'];?></a>
            <a href="javascript:void(0);" class="a">更多<i class="icon-angle-down"></i>
          <div class="more"> <span class="arrow"></span>
            <ul>
              <li><?php echo $lang['member_order_pay_method'].$lang['nc_colon'];?><span><?php echo $output['order']['payment_name']; ?></span></li>
              <li><?php echo $lang['member_order_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order']['add_time']); ?></span></li>
              <?php if ($output['order']['payment_time'] > 0) { ?>
              <li><?php echo $lang['member_show_order_pay_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order']['payment_time']); ?></span></li>
              <?php } ?>
              <?php if ($output['order']['finnshed_time'] > 0) { ?>
              <li><?php echo $lang['member_show_order_finish_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order']['finnshed_time']); ?></span></li>
              <?php } ?>
            </ul>
          </div>
          </a> </dd>
      </dl>
      <dl class="line">
        <dt>商&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;家：</dt>
        <dd><?php echo $output['order']['store_name'];?><a href="javascript:void(0);" class="a" id="store_more">更多<i class="icon-angle-down"></i>
          <div class="more"><span class="arrow"></span>
              <ul>
                <li> 联系电话：<span><?php echo !empty($output['store']['live_store_tel']) ? $output['store']['live_store_tel'] : $output['store']['store_phone']; ?></span> </li>
                <li>地&#12288;&#12288;址： <span><?php echo !empty($output['store']['live_store_address']) ? $output['store']['live_store_address'] : $output['store']['store_address']; ?></span> </li>
                <li>
                  <div id="store_container" class="w270 h200"></div>
                </li>
                <li>交通信息：<?php echo $output['store']['live_store_bus'];?></li>
              </ul>
          </div>
          </a>
        </dd>
      </dl>
    </div>
  </div>
<script type="text/javascript">
var cityName = '';
var address = '<?php echo str_replace("'",'"',$output['store']['live_store_address']);?>';
var store_name = '<?php echo str_replace("'",'"',$output['store']['live_store_name']);?>';
var map = "";
var localCity = "";
var opts = {width : 100,height: 50,title : "商铺名称:"+store_name}
function initialize() {
	map = new BMap.Map("store_container");
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
	  }
}

//加载百度地图。
$(function(){
	$('#store_more').one('mouseover',function(){
		loadScript();
	});
});
</script>