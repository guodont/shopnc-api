<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert mt10" style="clear:both;">
	<ul class="mt5">
		<li>1、<?php echo $lang['stat_validorder_explain'];?></li>
        <li>2、点击“设置价格区间”进入设置价格区间页面，客单价分布图将根据您设置的价格区间进行分布统计</li>
        <li>3、“购买时段分布”统计图展示符合搜索条件的有效订单在各个时间段的分布情况，为工作时间的合理安排提供依据</li>
    </ul>
</div>
<form method="get" action="index.php" target="_self">
  <table class="search-form">
    <input type="hidden" name="act" value="statistics_sale" />
    <input type="hidden" name="op" value="buying" />
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

<div class="alert alert-info"><strong>客单价分布</strong>（<a href="index.php?act=statistics_general&op=orderprange" target="_blank">设置价格区间</a>）</div>
<table class="ncsc-default-table">
  <tbody>
	<tr id="row_0">
		<td class="tl">
    		<?php if ($output['guestprice_statjson']){ ?>
    		<div id="container_guestprice"></div>
    		<?php } else { ?>
    		<div class="tc h50 mt10">查看分布情况前，请先设置价格区间。<a href="index.php?act=statistics_general&op=orderprange" target="_blank">马上设置</a></div>
    		<?php }?>
		</td>
	</tr>
  </tbody>
</table>

<div class="alert alert-info"><strong>购买时段分布</strong></div>
<table class="ncsc-default-table">
  <tbody>
	<tr id="row_0">
		<td class="tl">
    		<div id="container_hour"></div>
		</td>
	</tr>
  </tbody>
</table>


<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>

<script type="text/javascript">
//展示搜索时间框
function show_searchtime(){
	s_type = $("#search_type").val();
	$("[id^='searchtype_']").hide();
	$("#searchtype_"+s_type).show();
}

$(function(){
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
	<?php if ($output['guestprice_statjson']){ ?>
	$('#container_guestprice').highcharts(<?php echo $output['guestprice_statjson'];?>);
	<?php } ?>
	$('#container_hour').highcharts(<?php echo $output['hour_statjson'];?>);
});
</script>