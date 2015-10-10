<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert mt10" style="clear:both;">
	<ul class="mt5">
        <li>1、统计图展示了店铺在搜索时间段内的访问量走势情况</li>
    </ul>
</div>
<form method="get" action="index.php" target="_self">
	<input type="hidden" name="act" value="statistics_flow" />
    <input type="hidden" name="op" value="storeflow" />
  <table class="search-form">
    <tr>
    	<td class="tr">
    		<div class="fr">
    			<label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_common_search'];?>" /></label>
    		</div>
    		<div class="fr">
    		  <div class="fl" style="margin-right:3px;">
        		<select name="search_type" id="search_type" class="querySelect">
        			<option value="week" <?php echo $output['search_arr']['search_type']=='week'?'selected':''; ?>>按照周统计</option>
        			<option value="month" <?php echo $output['search_arr']['search_type']=='month'?'selected':''; ?>>按照月统计</option>
        		</select>
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

<div id="container"></div>

<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
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

	$('#container').highcharts(<?php echo $output['stat_json'];?>);
	
});
</script>