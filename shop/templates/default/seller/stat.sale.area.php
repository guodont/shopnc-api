<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert mt10">
	<ul class="mt5">
		<li>1、<?php echo $lang['stat_validorder_explain'];?></li>
		<li>2、统计图展示了符合搜索条件的有效订单的下单会员数、下单总金额和下单数量在各省级地区的分布情况</li>
		<li>3、统计地图将根据各个区域的有效订单统计数据等级依次显示不同的颜色</li>
		<li>4、地区排行将根据各个区域的有效订单统计数据进行排名显示</li>
    </ul>
</div>
<form method="get" action="index.php" target="_self">
	<input type="hidden" name="act" value="statistics_sale" />
    <input type="hidden" name="op" value="area" />
  <table class="search-form">
    <tr>
    	<td class="tr">
    		<div class="fr">
    			<label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_common_search'];?>" /></label>
    		</div>
    		<div class="fr">
    		  <div class="fl" style="margin-right:3px;">
        		<select name="search_type" id="search_type" class="querySelect">
        			<option value="day" <?php echo $output['search_arr']['search_type']=='day'?'selected':''; ?>>按照天统计</option>
        			<option value="week" <?php echo $output['search_arr']['search_type']=='week'?'selected':''; ?>>按照周统计</option>
        			<option value="month" <?php echo $output['search_arr']['search_type']=='month'?'selected':''; ?>>按照月统计</option>
        		</select>
        	 </div>
        		<div id="searchtype_day" style="display:none;" class="fl">
        			<input type="text" class="text w70" name="search_time" id="search_time" value="<?php echo @date('Y-m-d',$output['search_arr']['day']['search_time']);?>" /><label class="add-on"><i class="icon-calendar"></i></label>
                </div>
                <div id="searchtype_week" style="display:none;" class="fl">
                  	<select name="searchweek_year" class="querySelect">
                  		<?php foreach ($output['year_arr'] as $k=>$v){?>
                  		<option value="<?php echo $k;?>" <?php echo $output['search_arr']['week']['current_year'] == $k?'selected':'';?>><?php echo $v; ?></option>
                  		<?php } ?>
                    </select>
                    <select name="searchweek_month" class="querySelect">
                    	<?php foreach ($output['month_arr'] as $k=>$v){?>
                  		<option value="<?php echo $k;?>" <?php echo $output['search_arr']['week']['current_month'] == $k?'selected':'';?>><?php echo $v; ?></option>
                  		<?php } ?>
                    </select>
                    <select name="searchweek_week" class="querySelect">
                    	<?php foreach ($output['week_arr'] as $k=>$v){?>
                  		<option value="<?php echo $v['key'];?>" <?php echo $output['search_arr']['week']['current_week'] == $v['key']?'selected':'';?>><?php echo $v['val']; ?></option>
                  		<?php } ?>
                    </select>
              </div>
              <div id="searchtype_month" style="display:none;" class="fl">
                  	<select name="searchmonth_year" class="querySelect">
                  		<?php foreach ($output['year_arr'] as $k=>$v){?>
                  		<option value="<?php echo $k;?>" <?php echo $output['search_arr']['month']['current_year'] == $k?'selected':'';?>><?php echo $v; ?></option>
                  		<?php } ?>
                    </select>
                    <select name="searchmonth_month" class="querySelect">
                    	<?php foreach ($output['month_arr'] as $k=>$v){?>
                  		<option value="<?php echo $k;?>" <?php echo $output['search_arr']['month']['current_month'] == $k?'selected':'';?>><?php echo $v; ?></option>
                  		<?php } ?>
                    </select>
              </div>
    		</div>
    	</td>
    </tr>
  </table>
</form>

<div id="stat_tabs" class="ui-tabs" style="min-height:500px;padding-top:10px;">
	<div class="tabmenu">
      	<ul class="tab pngFix">
      		<li><a href="#membernum_div" nc_type="showdata" data-param='{"type":"membernum"}'>下单会员数</a></li>
      		<li><a href="#orderamount_div" nc_type="showdata" data-param='{"type":"orderamount"}'>下单金额</a></li>
        	<li><a href="#ordernum_div" nc_type="showdata" data-param='{"type":"ordernum"}'>下单量</a></li>
        </ul>
    </div>
    <!-- 下单会员数 -->
    <div id="membernum_div" nc_type="datacontainer" class="tc">
        <?php if($output['stat_json_map']){ ?>
    	<div class="stat-map-color">高&nbsp;&nbsp;<span style="background-color: #fd0b07;">&nbsp;</span><span style="background-color: #ff9191;">&nbsp;</span><span style="background-color: #f7ba17;">&nbsp;</span><span style="background-color: #fef406;">&nbsp;</span><span style="background-color: #25aae2;">&nbsp;</span>&nbsp;&nbsp;低
    		<p>备注：按照排名由高到低显示：排名第1、2、3名为第一阶梯；排名第4、5、6名为第二阶梯；排名第7、8、9为第三阶梯；排名第10、11、12为第四阶梯；其余为第五阶梯。</p>
    	</div>
        <div id="map_membernum" style="width:400px; height:400px; float:left;"></div>
        <div id="bar_membernum" style="width:500px; height:400px; float:left;"></div>
        <?php } else {?>
        <div class="warning-option"><i class="icon-warning-sign"></i><span>暂无符合条件的数据记录</span></div>
        <?php }?>
    </div>
    <!-- 下单金额 -->
    <div id="orderamount_div" nc_type="datacontainer" class="tc" style="display:none;">
        <?php if($output['stat_json_map']){ ?>
    	<div class="stat-map-color">高&nbsp;&nbsp;<span style="background-color: #fd0b07;">&nbsp;</span><span style="background-color: #ff9191;">&nbsp;</span><span style="background-color: #f7ba17;">&nbsp;</span><span style="background-color: #fef406;">&nbsp;</span><span style="background-color: #25aae2;">&nbsp;</span>&nbsp;&nbsp;低
    		<p>备注：按照排名由高到低显示：排名第1、2、3名为第一阶梯；排名第4、5、6名为第二阶梯；排名第7、8、9为第三阶梯；排名第10、11、12为第四阶梯；其余为第五阶梯。</p>
    	</div>
        <div id="map_orderamount" style="width:400px; height:400px; float:left;"></div>
        <div id="bar_orderamount" style="width:500px; height:400px; float:left;"></div>
        <?php } else {?>
        <div class="warning-option"><i class="icon-warning-sign"></i><span>暂无符合条件的数据记录</span></div>
        <?php } ?>
    </div>
    <!-- 下单量 -->
    <div id="ordernum_div" nc_type="datacontainer" class="tc" style="display:none;">
    	<?php if($output['stat_json_map']){ ?>
    	<div class="stat-map-color">高&nbsp;&nbsp;<span style="background-color: #fd0b07;">&nbsp;</span><span style="background-color: #ff9191;">&nbsp;</span><span style="background-color: #f7ba17;">&nbsp;</span><span style="background-color: #fef406;">&nbsp;</span><span style="background-color: #25aae2;">&nbsp;</span>&nbsp;&nbsp;低
    		<p>备注：按照排名由高到低显示：排名第1、2、3名为第一阶梯；排名第4、5、6名为第二阶梯；排名第7、8、9为第三阶梯；排名第10、11、12为第四阶梯；其余为第五阶梯。</p>
    	</div>
        <div id="map_ordernum" style="width:400px; height:400px; float:left;"></div>
        <div id="bar_ordernum" style="width:500px; height:400px; float:left;"></div>
        <?php } else { ?>
        <div class="warning-option"><i class="icon-warning-sign"></i><span>暂无符合条件的数据记录</span></div>
        <?php } ?>
    </div>
</div>

<div id="statlist" class=""></div>

<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ui.core.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ui.tabs.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/map/jquery.vector-map.css"/>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/map/jquery.vector-map.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/map/china-zh.js"></script>

<script type="text/javascript">
//展示搜索时间框
function show_searchtime(){
	s_type = $("#search_type").val();
	$("[id^='searchtype_']").hide();
	$("#searchtype_"+s_type).show();
}

$(function(){
	//切换登录卡
	$('#stat_tabs').tabs();
	
	//统计数据类型
	var s_type = $("#search_type").val();
	$('#search_time').datepicker({dateFormat: 'yy-mm-dd'});

	show_searchtime();
	$("#search_type").change(function(){
		show_searchtime();
	});
	
	//更新周数组
	$("[name='searchweek_month']").change(function(){
		var year = $("[name='searchweek_year']").val();
		var month = $("[name='searchweek_month']").val();
		$("[name='searchweek_week']").html('');
		$.getJSON('index.php?act=index&op=getweekofmonth',{y:year,m:month},function(data){
	        if(data != null){
	        	for(var i = 0; i < data.length; i++) {
	        		$("[name='searchweek_week']").append('<option value="'+data[i].key+'">'+data[i].val+'</option>');
			    }
	        }
	    });
	});

	<?php if($output['stat_json_map']){ ?>
	getMap(<?php echo $output['stat_json_map']['membernum']; ?>,'map_membernum');
	getMap(<?php echo $output['stat_json_map']['orderamount']; ?>,'map_orderamount');
	getMap(<?php echo $output['stat_json_map']['ordernum']; ?>,'map_ordernum');

	$('#bar_membernum').highcharts(<?php echo $output['stat_json_bar']['membernum'];?>);
	$('#bar_orderamount').highcharts(<?php echo $output['stat_json_bar']['orderamount'];?>);
	$('#bar_ordernum').highcharts(<?php echo $output['stat_json_bar']['ordernum'];?>);
	<?php } ?>
});
</script>