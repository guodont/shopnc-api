<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>会员统计</h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="stat_member" />
    <input type="hidden" name="op" value="buying" />
    <div class="w100pre" style="width: 100%;">
        <table class="tb-type1 noborder search left">
          <tbody>
            <tr>
              <td>
              	<select name="search_type" id="search_type" class="querySelect">
                  <option value="day" <?php echo $output['search_arr']['search_type']=='day'?'selected':''; ?>>按照天统计</option>
                  <option value="week" <?php echo $output['search_arr']['search_type']=='week'?'selected':''; ?>>按照周统计</option>
                  <option value="month" <?php echo $output['search_arr']['search_type']=='month'?'selected':''; ?>>按照月统计</option>
                </select></td>
              <td id="searchtype_day" style="display:none;">
              	<input class="txt date" type="text" value="<?php echo @date('Y-m-d',$output['search_arr']['day']['search_time']);?>" id="search_time" name="search_time">
              </td>
              <td id="searchtype_week" style="display:none;">
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
              </td>
              <td id="searchtype_month" style="display:none;">
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
              </td>
              <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
            </tr>
          </tbody>
        </table>
    </div>
  </form>
  
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
        	<li><?php echo $lang['stat_validorder_explain'];?></li>
            <li>点击“设置价格区间”进入设置价格区间页面，客单价分布图将根据您设置的价格区间进行分布统计</li>
            <li>“购买频次分析”列表统计了该时间段内重复并有效购买过该次数的会员数量及占全部下单会员的比例，助于分析会员的粘性</li>
            <li>“购买时段分布”统计图展示时间段内的有效订单在各个时间段的分布情况，为工作时间的合理安排提供依据</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  
  <table class="table tb-type2">
	<thead class="thead">
		<tr class="space">
			<th colspan="15">客单价分布（<a href="index.php?act=stat_general&op=orderprange" style="font-size:12px; font-weight:normal;">设置价格区间</a>）</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?php if ($output['guestprice_statjson']){ ?>
				<div id="container_guestprice" class="w100pre close_float" style="height:400px"></div>
				<?php } else { ?>
				<div class="w100pre close_float align-center h36 mt10">查看客单价分布情况前，请先设置价格区间。<a href="index.php?act=stat_general&op=orderprange" style="font-size:12px; font-weight:normal;">马上设置</a></div>
				<?php }?>
			</td>
		</tr>
	</tbody>
  </table>
  
  <table class="table tb-type2 nobdb">
    <thead class="thead">
    	<tr class="space">
			<th colspan="15">购买频次分析</th>
		</tr>
		<tr class="thead">
			<th class="align-center">序号</th>
			<th class="align-center">购买频次</th>
			<th class="align-center">下单会员数</th>
			<th class="align-center">人数占比</th>
		</tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['stattimes_arr'])){ ?>
   	 <?php foreach ($output['stattimes_arr'] as $k=>$v){?>
      <tr class="hover">
        <td class="align-center"><?php echo $k;?></td>
        <td class="align-center"><?php echo $v['text'];?></td>
        <td class="align-center"><?php echo $v['num'];?></td>
        <td class="align-center"><?php echo $v['rate'];?>%</td>
      </tr>
      <?php } ?>
    <?php } else { ?>
      <tr class="no_data">
      	<td colspan="15"><?php echo $lang['no_record'];?></td>
      </tr>
    <?php } ?>
    </tbody>
    <?php if(!empty($output['stattimes_arr']) && is_array($output['stattimes_arr'])){ ?>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
  
  <table class="table tb-type2">
	<thead class="thead">
		<tr class="space">
			<th colspan="15">购买时段分布</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><div id="container_hour" class="w100pre close_float" style="height:400px"></div></td>
		</tr>
	</tbody>
  </table>
  
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
</div>
<script>
//展示搜索时间框
function show_searchtime(){
	s_type = $("#search_type").val();
	$("[id^='searchtype_']").hide();
	$("#searchtype_"+s_type).show();
}

$(function () {
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
		$.getJSON('index.php?act=common&op=getweekofmonth',{y:year,m:month},function(data){
	        if(data != null){
	        	for(var i = 0; i < data.length; i++) {
	        		$("[name='searchweek_week']").append('<option value="'+data[i].key+'">'+data[i].val+'</option>');
			    }
	        }
	    });
	});
	
	$('#container_guestprice').highcharts(<?php echo $output['guestprice_statjson'];?>);
	$('#container_hour').highcharts(<?php echo $output['hour_statjson'];?>);
	
	$('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
});
</script>