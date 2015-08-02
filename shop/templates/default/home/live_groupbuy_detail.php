<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.head-app {
	display: none;
}
.ncg-topbar-wrapper, .wrapper {
	width: 1000px !important;
}
</style>
<?php require('groupbuy_head.php');?>
<div class="nch-breadcrumb-layout" style="display: block;">
  <div class="nch-breadcrumb wrapper"> <i class="icon-home"></i> <span> <a href="index.php">首页</a> </span> <span class="arrow">></span> <span><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list">线下抢</a></span> <span class="arrow">></span> <span><?php echo $output['live_groupbuy']['groupbuy_name'];?></span> </div>
</div>
<div class="ncg-container wrapper">
  <div class="ncg-layout-l">
    <div class="ncg-main <?php if($output['groupbuy_state']!='2'){ echo 'not-start';}?>">
      <div class="ncg-group">
        <h2><?php echo $output['live_groupbuy']['groupbuy_name'];?></h2>
        <h3><?php echo $output['live_groupbuy']['groupbuy_remark'];?></h3>
        <div class="ncg-item">
          <div class="pic"><img src="<?php echo lgthumb($output['live_groupbuy']['groupbuy_pic'],'max');?>" alt=""></div>
          <div class="button"> <span><?php echo $lang['currency'];?><em><?php echo $output['live_groupbuy']['groupbuy_price'];?></em></span> <a href="javascript:;" class="buynow">
            <?php if($output['groupbuy_state']=='1'){ echo '未开始';}elseif($output['groupbuy_state']=='2'){ echo '我要抢';}else{ echo '已结束';}?>
            </a> </div>
          <div class="info" id="main-nav-holder">
            <div class="prices">
              <dl>
                <dt><?php echo $lang['text_goods_price'];?></dt>
                <dd><del><?php echo $lang['currency'];?><?php echo $output['live_groupbuy']['original_price'];?></del></dd>
              </dl>
              <dl>
                <dt><?php echo $lang['text_discount'];?></dt>
                <dd><em><?php echo round(($output['live_groupbuy']['groupbuy_price']/$output['live_groupbuy']['original_price'])*10,2);?><?php echo $lang['text_zhe'];?></em></dd>
              </dl>
              <dl>
                <dt><?php echo $lang['text_save'];?></dt>
                <dd><em><?php echo $lang['currency'];?><?php echo sprintf("%01.2f",$output['live_groupbuy']['original_price']-$output['live_groupbuy']['groupbuy_price']);?></em></dd>
              </dl>
            </div>
            <div class="trim"></div>
            <?php if($output['groupbuy_state']==2){//正在进行?>
            <div class="require">
              <h4>本抢购已被抢<em><?php echo $output['live_groupbuy']['buyer_num'];?></em>个</h4>
              <p>
                <?php if(!empty($output['live_groupbuy']['buyer_limit'])) { ?>
                每人最多购买<em><?php echo $output['live_groupbuy']['buyer_limit'];?></em>个，
                <?php } ?>
                数量有限，欲购从速!</p>
            </div>
            <div class="time"> 
              <!-- 倒计时 距离本期结束 --> 
              <i class="icon-time"></i>剩余时间： <span class="process" endtime="<?php echo $output['live_groupbuy']['end_time'];?>"></span> </div>
            <?php }?>
          </div>
          <div class="clear"></div>
        </div>
        <div class="floating-bar">
          <div class="button"><span><?php echo $lang['currency'];?><em><?php echo $output['live_groupbuy']['groupbuy_price'];?></em></span><a href="javascript:;" class="buynow">
            <?php if($output['groupbuy_state']=='1'){ echo '未开始';}elseif($output['groupbuy_state']=='2'){ echo '我要抢';}else{ echo '已结束';}?>
            </a></div>
          <div class="prices">
            <dl>
              <dt><?php echo $lang['text_goods_price'];?></dt>
              <dd><del><?php echo $lang['currency'];?><?php echo $output['live_groupbuy']['original_price'];?></del></dd>
            </dl>
            <dl>
              <dt><?php echo $lang['text_discount'];?></dt>
              <dd><em><?php echo round(($output['live_groupbuy']['groupbuy_price']/$output['live_groupbuy']['original_price'])*10,2);?><?php echo $lang['text_zhe'];?></em></dd>
            </dl>
            <dl>
              <dt><?php echo $lang['text_save'];?></dt>
              <dd><em><?php echo $lang['currency'];?><?php echo sprintf("%01.2f",$output['live_groupbuy']['original_price']-$output['live_groupbuy']['groupbuy_price']);?></em></dd>
            </dl>
            <dl>
              <dt>商品来自</dt>
              <dd>
                <?php 
					if(!empty($output['store_info']['live_store_name'])){ 
						echo $output['store_info']['live_store_name'];
					}else{
						echo $output['store_info']['store_name'];
					}
				?>
              </dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
    <div class="ncg-title-bar">
      <ul class="tabs-nav">
        <li class="tabs-selected"><a href="javascript:void(0);">抢购介绍</a></li>
      </ul>
    </div>
    <div class="ncg-detail-content">
      <div class="ncg-instructions">
        <h4>使用声明</h4>
        <ul>
          <li>1. 本此抢购活动的最终有效期为
            <time><?php echo date("Y-m-d",$output['live_groupbuy']['validity']);?></time>
            日，逾期未使用将被视为自动放弃兑换。</li>
          <li>2. 单人每笔订单最多抢购<strong><?php echo $output['live_groupbuy']['buyer_limit'];?></strong>个兑换码/券，如需更多请再次购买。</li>
          <li>3. 消费抢购兑换码/券时，请向商家提供系统发送的”线下抢购兑换码“，一码一销。</li>
        </ul>
      </div>
      <div class="ncg-intro"><?php echo $output['live_groupbuy']['groupbuy_intro'];?></div>
    </div>
  </div>
  <div class="ncg-layout-r">
    <div class="ncg-store">
      <div class="title"><?php echo $lang['store_info'];?></div>
      <div class="content">
        <div class="ncg-store-info">
          <dl class="name">
            <dt>商&#12288;&#12288;家：</dt>
            <dd>
              <?php if(!empty($output['store_info']['live_store_name'])){?>
              <?php echo $output['store_info']['live_store_name']; ?>
              <?php }else{?>
              <a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$output['store_info']['store_id']));?>" target="_blank"><?php echo $output['store_info']['store_name'];?></a>
              <?php }?>
            </dd>
          </dl>
          <dl class="messenger noborder">
            <dt>在线客服：</dt>
            <dd member_id="<?php echo $output['store_info']['member_id'];?>">
              <?php if(!empty($output['store_info']['store_qq'])){?>
              <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $output['store_info']['store_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $output['store_info']['store_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $output['store_info']['store_qq'];?>:52" style=" vertical-align: middle;"/></a>
              <?php }?>
              <?php if(!empty($output['store_info']['store_ww'])){?>
              <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&amp;uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="<?php echo $lang['nc_message_me'];?>" style=" vertical-align: middle;"/></a>
              <?php }?>
            </dd>
          </dl>
          <dl>
            <dt>电&#12288;&#12288;话：</dt>
            <dd>
              <?php 
					if(!empty($output['store_info']['live_store_tel'])){
						echo $output['store_info']['live_store_tel'];
					}else{
						echo $output['store_info']['store_phone'];
					}	
				?>
            </dd>
          </dl>
          <dl class="noborder">
            <dt>地&#12288;&#12288;址：</dt>
            <dd class="auto">
              <?php 
					if(!empty($output['store_info']['live_store_address'])){
						echo $output['store_info']['live_store_address'];
					}else{
						echo $output['store_info']['store_address'];
					}
				?>
            </dd>
          </dl>
          <div class="map">
            <div id="container" class="window"></div>
          </div>
          <dl class="name">
            <dt>交通信息：</dt>
            <dd class="auto"> <?php echo $output['store_info']['live_store_bus'];?> </dd>
          </dl>
        </div>
      </div>
    </div>
    <div class="ncg-module-sidebar">
      <div class="title"><?php echo $lang['current_hot'];?></div>
      <div class="content">
        <?php if(!empty($output['recommend_live_groupbuy'])) { ?>
        <div class="ncg-group-command">
          <?php foreach($output['recommend_live_groupbuy'] as $hot_groupbuy) { ?>
          <dl>
            <dt class="name"><a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$hot_groupbuy['groupbuy_id']));?>" target="_blank"><?php echo $hot_groupbuy['groupbuy_name'];?></a></dt>
            <dd class="pic-thumb"><a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$hot_groupbuy['groupbuy_id']));?>" target="_blank"><img src="<?php echo lgthumb($hot_groupbuy['groupbuy_pic'],'max');?>"></a></dd>
            <dd class="item"><a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$hot_groupbuy['groupbuy_id']));?>" target="_blank"><?php echo $lang['to_see'];?></a> <span class="price"><?php echo $lang['currency'].$hot_groupbuy['groupbuy_price'];?></span> <span class="buy"><em><?php echo $hot_groupbuy['buyer_num'];?></em><?php echo $lang['text_piece'].$lang['text_buy'];?></span> </dd>
          </dl>
          <?php } ?>
        </div>
        <?php }else{?>
        <div class="nothing">暂无推荐</div>
        <?php }?>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script>
$(function(){
    //浮动导航  waypoints.js
    $('#main-nav-holder').waypoint(function(event, direction) {
        $(this).parent().parent().toggleClass('sticky', direction === "down");
        event.stopPropagation();
    });

    $('.buynow').click(function(){
    	<?php if ($_SESSION['is_login'] !== '1'){?>
    	login_dialog();
    	return false;
    	<?php }else{?>
		<?php if ($_SESSION['store_id'] == $output['live_groupbuy']['store_id']){?>
		alert('不能抢购自己店铺的商品');
		return false;
		<?php }?>
    	location.href = 'index.php?act=show_live_groupbuy&op=livegroupbuyorder&groupbuy_id='+<?php echo $_GET['groupbuy_id'];?>;
		return false;
    	<?php }?>
    });
});
</script> 
<script type="text/javascript">
	var time = parseInt("<?php echo TIMESTAMP;?>");
    var lag = parseInt($('.process').attr('endtime')) - time;
    if(lag>0){
    	var second = Math.floor(lag % 60);    
        var minite = Math.floor((lag / 60) % 60);
        var hour = Math.floor((lag / 3600) % 24);
        var day = Math.floor((lag / 3600) / 24);
        $(".process").html('<span>'+day+'</span>'+'<strong><?php echo $lang['text_tian'];?></strong>'+'<span>'+hour+'</span>'+'<strong><?php echo $lang['text_hour'];?></strong>'+'<span>'+minite+"</span>"+'<strong><?php echo $lang['text_minute'];?></strong>'+'<span>'+second+'</span>'+'<strong><?php echo $lang['text_second'];?></strong>');    
    }else{
		$('.process').html('<span>已经结束</span');	
    }
    function updateEndTime(){
    	time++;		
        var lag = parseInt($(".process").attr('endTime')) - time;
        if(lag>0){
        	var second = Math.floor(lag % 60);    
            var minite = Math.floor((lag / 60) % 60);
            var hour = Math.floor((lag / 3600) % 24);
            var day = Math.floor((lag / 3600) / 24);
            $(".process").html('<span>'+day+'</span>'+'<strong><?php echo $lang['text_tian'];?></strong>'+'<span>'+hour+'</span>'+'<strong><?php echo $lang['text_hour'];?></strong>'+'<span>'+minite+"</span>"+'<strong><?php echo $lang['text_minute'];?></strong>'+'<span>'+second+'</span>'+'<strong><?php echo $lang['text_second'];?></strong>');    
        }
        setTimeout(updateEndTime,1000);
     }
     setTimeout(updateEndTime,1000);
</script> 
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
loadScript();
</script> 