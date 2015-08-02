<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block mt10">
  <ul>
    <li>1. 如您需要使用“虚拟抢购”活动功能，并具有线下实体商铺请根据下列表单内容进行认真填写。</li>
    <li>2. 设置后的线下商铺信息将显示于“虚拟抢购”活动详情页面右侧店铺介绍处，但不会影响原有线上店铺信息。</li>
    <li>3. 具体表单填写注意事项请参照下方内容相关提示。</li>
  </ul>
</div>
<div class="ncsc-form-default">
  <form id="add_form" action="index.php?act=store_live&op=store_live" method="post" >
    <dl>
      <dt>兑换码生成前缀<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w50 text" name="store_vrcode_prefix" type="text" maxlength="3" value="<?php echo $output['store']['store_vrcode_prefix'];?>" maxlength="30"  />
        <span></span>
        <p class="hint">该设置将作为兑换码的一部分，用于区别不同店铺之间的兑换码，增加兑换码使用的安全性，只接受字母或数字，最多3个字符。</p>
      </dd>
    </dl>
    <dl>
      <dt>线下商铺名称<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w200 text" name="live_store_name" type="text" id="live_store_name" value="<?php echo $output['store']['live_store_name'];?>" maxlength="30"  />
        <span></span>
        <p class="hint">线下店铺名称仅供线下“虚拟抢购”活动使用，不影响原有线上店铺名称，商铺名称长度最多可输入30个字符。未填写时将显示线上店铺名称。</p>
      </dd>
    </dl>
    <dl>
      <dt>线下商铺电话<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w200 text" name="live_store_tel" type="text" id="live_store_tel" value="<?php echo $output['store']['live_store_tel'];?>" maxlength="30"  />
        <span></span>
        <p class="hint">线下店铺电话用于“虚拟抢购”活动中，买家与商家进行联系沟通使用，请认真填写。未填写内容时将默认显示线上店铺所留商家电话号码。</p>
      </dd>
    </dl>
    <dl>
      <dt>线下商铺地址<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class=" w500 text" name="live_store_address" type="text" id="live_store_address" value="<?php echo $output['store']['live_store_address'];?>" maxlength="30"  />
        <span></span>
        <p class="hint">如您的店铺具有线下实体商铺地址，请认证填写此选项，保存后将更新地图定位，以供买家上门选购或兑换时使用。</p>
        <div id="container" class="w500 h200 mt10"></div>

      </dd>
    </dl>
    <dl>
      <dt>线下交通信息：</dt>
      <dd>
        <textarea class="textarea w500 h50" name="live_store_bus"><?php echo $output['store']['live_store_bus'];?></textarea>
         <p class="hint">此选项用于填写线下店铺周边交通信息或换乘方式，留空将不显示。</p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>">
      </label>
    </div>
  </form>
</div>
</div>

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
$(function(){
	loadScript();
});

</script>
