<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php require('groupbuy_head.php');?>
<div class="nch-breadcrumb-layout" style="display: block;">
  <div class="nch-breadcrumb wrapper"> <i class="icon-home"></i> <span> <a href="<?php echo urlShop(); ?>">首页</a> </span> <span class="arrow">></span>
<?php if ($output['groupbuy_info']['is_vr']) { ?>
  <span><a href="<?php echo urlShop('show_groupbuy', 'vr_groupbuy_list'); ?>">虚拟抢</a></span>
<?php } else { ?>
  <span><a href="<?php echo urlShop('show_groupbuy', 'groupbuy_list'); ?>">线上抢</a></span>
<?php } ?>
  <span class="arrow">></span> <span><?php echo $output['groupbuy_info']['groupbuy_name'];?></span> </div>
</div>
<div class="ncg-container wrapper">
  <div class="ncg-layout-l">
    <div class="ncg-main <?php echo $output['groupbuy_info']['state_flag'];?>">
      <div class="ncg-group">
        <h2><?php echo $output['groupbuy_info']['groupbuy_name'];?></h2>
        <h3><?php echo $output['groupbuy_info']['remark'];?></h3>
        <div class="ncg-item">
          <div class="pic"><img src="<?php echo gthumb($output['groupbuy_info']['groupbuy_image'],'max');?>" alt=""></div>
          <div class="button"><span><?php echo $lang['currency'];?><em><?php echo $output['groupbuy_info']['groupbuy_price'];?></em></span><a href="<?php echo $output['groupbuy_info']['goods_url'];?>" target="_blank"><?php echo $output['groupbuy_info']['button_text'];?></a></div>
          <div class="info" id="main-nav-holder">
            <div class="prices">
              <dl>
                <dt><?php echo $lang['text_goods_price'];?></dt>
                <dd><del><?php echo $lang['currency'];?><?php echo $output['groupbuy_info']['goods_price'];?></del></dd>
              </dl>
              <dl>
                <dt><?php echo $lang['text_discount'];?></dt>
                <dd><em><?php echo $output['groupbuy_info']['groupbuy_rebate'];?><?php echo $lang['text_zhe'];?></em></dd>
              </dl>
              <dl>
                <dt><?php echo $lang['text_save'];?></dt>
                <dd><em><?php echo $lang['currency'];?><?php echo sprintf("%01.2f",$output['groupbuy_info']['goods_price']-$output['groupbuy_info']['groupbuy_price']);?></em></dd>
              </dl>
            </div>
            <div class="trim"></div>
            <div class="require">
              <h4><?php echo $lang['text_goods_buy'];?><em><?php echo $output['groupbuy_info']['virtual_quantity']+$output['groupbuy_info']['buy_quantity']; ?></em><?php echo $lang['text_piece'];?></h4>
              <p>
                <?php if ($output['buy_limit'] > 0) { ?>
                每人最多购买<em><?php echo $output['buy_limit']; ?></em>件，
                <?php } ?>
                数量有限，欲购从速!</p>
            </div>
            <div class="time">
              <?php if(!empty($output['groupbuy_info']['count_down'])) { ?>
              <!-- 倒计时 距离本期结束 -->
              <i class="icon-time"></i>剩余时间：<span id="d1">0</span><strong><?php echo $lang['text_tian'];?></strong><span id="h1">0</span><strong><?php echo $lang['text_hour'];?></strong><span id="m1">0</span><strong><?php echo $lang['text_minute'];?></strong><span id="s1">0</span><strong><?php echo $lang['text_second'];?></strong>
              <script type="text/javascript">
                    var tms = [];
                    var day = [];
                    var hour = [];
                    var minute = [];
                    var second = [];

                    tms[tms.length] = "<?php echo $output['groupbuy_info']['count_down'];?>";
                    day[day.length] = "d1";
                    hour[hour.length] = "h1";
                    minute[minute.length] = "m1";
                    second[second.length] = "s1";
                    function groupbuyTakeCount() {
                        for (var i = 0, j = tms.length; i < j; i++) {
                            tms[i] -= 1;
                            //计算天、时、分、秒、
                            var days = Math.floor(tms[i] / (1 * 60 * 60 * 24));
                            var hours = Math.floor(tms[i] / (1 * 60 * 60)) % 24;
                            var minutes = Math.floor(tms[i] / (1 * 60)) % 60;
                            var seconds = Math.floor(tms[i] / 1) % 60;
                            if (days < 0)
                                days = 0;
                            if (hours < 0)
                                hours = 0;
                            if (minutes < 0)
                                minutes = 0;
                            if (seconds < 0)
                                seconds = 0;
                            //将天、时、分、秒插入到html中
                            document.getElementById(day[i]).innerHTML = days;
                            document.getElementById(hour[i]).innerHTML = hours;
                            document.getElementById(minute[i]).innerHTML = minutes;
                            document.getElementById(second[i]).innerHTML = seconds;
                        }
                    }
                    setInterval(groupbuyTakeCount, 1000);
              </script>
              <?php } ?>
            </div>
          </div>
          <div class="clear"></div>
        </div>
        <div class="floating-bar">
          <div class="button"><span><?php echo $lang['currency'];?><em><?php echo $output['groupbuy_info']['groupbuy_price'];?></em></span><a href="<?php echo $output['groupbuy_info']['goods_url'];?>" target="_blank"><?php echo $output['groupbuy_info']['button_text'];?></a></div>
          <div class="prices">
            <dl>
              <dt><?php echo $lang['text_goods_price'];?></dt>
              <dd><del><?php echo $lang['currency'];?><?php echo $output['groupbuy_info']['goods_price'];?></del></dd>
            </dl>
            <dl>
              <dt><?php echo $lang['text_discount'];?></dt>
              <dd><em><?php echo $output['groupbuy_info']['groupbuy_rebate'];?><?php echo $lang['text_zhe'];?></em></dd>
            </dl>
            <dl>
              <dt><?php echo $lang['text_save'];?></dt>
              <dd><em><?php echo $lang['currency'];?><?php echo sprintf("%01.2f",$output['groupbuy_info']['goods_price']-$output['groupbuy_info']['groupbuy_price']);?></em></dd>
            </dl>
            <dl>
              <dt>商品来自</dt>
              <dd><a href="<?php echo urlShop('show_store', 'index', array('store_id' => $output['groupbuy_info']['store_id']));?>"><?php echo $output['groupbuy_info']['store_name'];?></a></dd>
            </dl>
          </div>
        </div>
      </div>
    </div>
    <div class="ncg-title-bar">
      <ul class="tabs-nav">
        <li class="tabs-selected"><a href="javascript:void(0);"><?php echo $lang['goods_info'];?></a></li>
        <li><a href="javascript:void(0);"><?php echo $lang['buyer_list'];?></a></li>
        <li><a href="javascript:void(0);">商品评价(<?php echo $output['evaluate_info']['all'];?>)</a></li>
      </ul>
    </div>
    <div class="ncg-detail-content">
<?php if ($output['groupbuy_info']['is_vr']) { ?>
      <div class="ncg-instructions">
        <h4>使用声明</h4>
        <ul>
          <li>
            1. 本次抢购活动的最终有效期至
            <time><?php echo date("Y-m-d H:i", $output['groupbuy_info']['end_time']); ?></time>
<?php if ($output['goods_info']['virtual_indate'] > 0) { ?>
            ，兑换码/券的使用期限是<time><?php echo date("Y-m-d H:i", $output['goods_info']['virtual_indate']); ?></time>
            ，逾期未使用将被视为自动放弃兑换
<?php } ?>
            。
          </li>
          <li>2. 消费抢购兑换码/券时，请向商家提供系统发送的“虚拟抢购兑换码”，一码一销。</li>
<?php if ($output['buy_limit'] > 0) { ?>
          <li>3. 单人每笔订单最多抢购<strong><?php echo $output['buy_limit']; ?></strong>个兑换码/券，如需更多请再次购买。</li>
<?php } ?>
        </ul>
      </div>
<?php } ?>
      <div class="ncg-intro"><?php echo $output['groupbuy_info']['groupbuy_intro'];?></div>
    </div>
    <div id="groupbuy_order" class="ncg-detail-content hide"></div>
    <div class="ncg-detail-content hide">
      <div class="ncg-evaluate">
        <div class="top">
          <div class="rate">
            <p><strong><?php echo $output['evaluate_info']['good_percent'];?></strong><sub>%</sub>好评</p>
            <span>共有<?php echo $output['evaluate_info']['all'];?>人参与评分</span></div>
          <div class="percent">
            <dl>
              <dt>好评<em>(<?php echo $output['evaluate_info']['good_percent'];?>%)</em></dt>
              <dd><i style="width: <?php echo $output['evaluate_info']['good_percent'];?>%"></i></dd>
            </dl>
            <dl>
              <dt>中评<em>(<?php echo $output['evaluate_info']['normal_percent'];?>%)</em></dt>
              <dd><i style="width: <?php echo $output['evaluate_info']['normal_percent'];?>%"></i></dd>
            </dl>
            <dl>
              <dt>差评<em>(<?php echo $output['evaluate_info']['bad_percent'];?>%)</em></dt>
              <dd><i style="width: <?php echo $output['evaluate_info']['bad_percent'];?>%"></i></dd>
            </dl>
          </div>
          <div class="btns"><span>您可对已购商品进行评价</span>
            <p><a href="<?php if ($output['groupbuy_info']['is_vr']) { echo urlShop('member_vr_order', 'index');} else { echo urlShop('member_order', 'index');}?>" class="ncg-btn ncg-btn-red" target="_blank"><i class="icon-comment-alt"></i>评价商品</a></p>
          </div>
        </div>
        <!-- 商品评价内容部分 -->
        <div id="groupbuy_evaluate" class="ncg-evaluate-main"></div>
      </div>
    </div>
  </div>
  <div class="ncg-layout-r">

<?php if (!$output['store_info']['is_own_shop'] || $output['groupbuy_info']['is_vr']) { ?>
    <div class="ncg-store">
      <div class="title"><?php echo $lang['store_info'];?></div>
      <div class="content">
        <div class="ncg-store-info">
          <dl class="name">
            <dt>商&#12288;&#12288;家：</dt>
            <dd> <?php echo $output['groupbuy_info']['store_name'];?> </dd>
          </dl>
<?php if (!$output['store_info']['is_own_shop']) { ?>
          <dl class="all-rate">
            <dt>综合评分：</dt>
            <dd>
              <div class="rating"><span style=" width:<?php echo $output['store_info']['store_credit_percent'];?>%"></span></div>
              <em><?php echo $output['store_info']['store_credit_average'];?></em>分 </dd>
          </dl>
          <div class="detail-rate">
            <h5><strong>店铺动态评分</strong>与行业相比</h5>
            <ul class="rate">
              <?php  foreach ($output['store_info']['store_credit'] as $value) {?>
              <li> <?php echo $value['text'];?><span class="credit"><?php echo $value['credit'];?> 分</span> <span class="<?php echo $value['percent_class'];?>"><i></i><?php echo $value['percent_text'];?><em><?php echo $value['percent'];?></em></span> </li>
              <?php } ?>
            </ul>
          </div>
<?php } ?>
          <dl class="messenger">
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

<?php if ($output['groupbuy_info']['is_vr']) { ?>
          <dl>
            <dt>电&#12288;&#12288;话：</dt>
            <dd>
              <?php echo $output['store_info']['live_store_tel'] ? $output['store_info']['live_store_tel'] : $output['store_info']['store_phone']; ?>
            </dd>
          </dl>
          <dl class="noborder">
            <dt>地&#12288;&#12288;址：</dt>
            <dd class="auto">
              <?php echo ($address = $output['store_info']['live_store_address'] ? $output['store_info']['live_store_address'] : $output['store_info']['store_address']); ?>
            </dd>
          </dl>
          <div class="map">
            <div id="container" class="window"></div>
          </div>
          <dl class="name">
            <dt>交通信息：</dt>
            <dd class="auto">
              <?php echo $output['store_info']['live_store_bus'];?>
            </dd>
          </dl>
<?php } ?>

          <div class="goto"> <a href="<?php echo urlShop('show_store', 'index', array('store_id' => $output['groupbuy_info']['store_id']));?>" >进入商家店铺</a></div>
        </div>
      </div>
    </div>
<?php } ?>

    <div class="ncg-module-sidebar">
      <div class="title"><?php echo $lang['current_hot'];?></div>
      <div class="content">
        <div class="ncg-group-command">
          <?php $hot_groupbuy_count = 1;?>
          <?php if(is_array($output['commended_groupbuy_list'])) { ?>
          <?php foreach($output['commended_groupbuy_list'] as $hot_groupbuy) { ?>
          <dl <?php if($hot_groupbuy_count === 1) { echo "style=' border:none'";$hot_groupbuy_count++; }?> >
            <dt class="name"><a href="<?php echo $hot_groupbuy['groupbuy_url'];?>" target="_blank"><?php echo $hot_groupbuy['groupbuy_name'];?></a></dt>
            <dd class="pic-thumb"><a href="<?php echo $hot_groupbuy['groupbuy_url'];?>" target="_blank"><img src="<?php echo gthumb($hot_groupbuy['groupbuy_image1'],'max');?>"></a></dd>
            <dd class="item"><a href="<?php echo $hot_groupbuy['groupbuy_url'];?>" target="_blank"><?php echo $lang['to_see'];?></a> <span class="price"><?php echo $lang['currency'].$hot_groupbuy['groupbuy_price'];?></span> <span class="buy"><em><?php echo $hot_groupbuy['virtual_quantity']+$hot_groupbuy['buy_quantity'];?></em><?php echo $lang['text_piece'].$lang['text_buy'];?></span> </dd>
          </dl>
          <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
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
    //首页Tab标签卡滑门切换
    $(".tabs-nav > li > a").live('mouseover', (function(e) {
    	if (e.target == this) {
    		var tabs = $(this).parent().parent().children("li");
    		var panels = $(this).parent().parent().parent().parent().children(".ncg-detail-content");
    		var index = $.inArray(this, $(this).parent().parent().find("a"));
    		if (panels.eq(index)[0]) {
    			tabs.removeClass("tabs-selected").eq(index).addClass("tabs-selected");
    			panels.addClass("hide").eq(index).removeClass("hide");
    		}
    	}
    }));

    $("#groupbuy_order").load('<?php echo urlShop('show_groupbuy', 'groupbuy_order', array('group_id' => $output['groupbuy_info']['groupbuy_id'],'is_vr'=>$output['groupbuy_info']['is_vr']));?>');
    $("#groupbuy_evaluate").load('<?php echo urlShop('show_groupbuy', 'groupbuy_evaluate', array('commonid' => $output['groupbuy_info']['goods_commonid']));?>');
});
</script>

<?php if ($output['groupbuy_info']['is_vr']) { ?>

<script type="text/javascript">
var cityName = '';
var address = '<?php echo str_replace("'", '"', $address); ?>';
var store_name = '<?php echo str_replace("'", '"', $output['store_info']['live_store_name'] ? $output['store_info']['live_store_name'] : $output['store_info']['store_name']); ?>';
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

<?php } ?>
