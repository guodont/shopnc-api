<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>营销分析</h3>
      <?php echo $output['top_link'];?> </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="stat_marketing" />
    <input type="hidden" name="op" value="promotion" />
    <div class="w100pre" style="width: 100%;">
      <table class="tb-type1 noborder search left">
        <tbody>
          <tr>
            <td><select name="search_type" id="search_type" class="querySelect">
                <option value="day" <?php echo $output['search_arr']['search_type']=='day'?'selected':''; ?>>按照天统计</option>
                <option value="week" <?php echo $output['search_arr']['search_type']=='week'?'selected':''; ?>>按照周统计</option>
                <option value="month" <?php echo $output['search_arr']['search_type']=='month'?'selected':''; ?>>按照月统计</option>
              </select></td>
            <td id="searchtype_day" style="display:none;"><input class="txt date" type="text" value="<?php echo @date('Y-m-d',$output['search_arr']['day']['search_time']);?>" id="search_time" name="search_time"></td>
            <td id="searchtype_week" style="display:none;"><select name="searchweek_year" class="querySelect">
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
              </select></td>
            <td id="searchtype_month" style="display:none;"><select name="searchmonth_year" class="querySelect">
                <?php foreach ($output['year_arr'] as $k=>$v){?>
                <option value="<?php echo $k;?>" <?php echo $output['search_arr']['month']['current_year'] == $k?'selected':'';?>><?php echo $v; ?></option>
                <?php } ?>
              </select>
              <select name="searchmonth_month" class="querySelect">
                <?php foreach ($output['month_arr'] as $k=>$v){?>
                <option value="<?php echo $k;?>" <?php echo $output['search_arr']['month']['current_month'] == $k?'selected':'';?>><?php echo $v; ?></option>
                <?php } ?>
              </select></td>
            <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
          </tr>
        </tbody>
      </table>
      <span class="right" style="margin:12px 0px 6px 4px;"> </span> </div>
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
        	<li>走势图展现了各种促销活动时间段内有效订单的下单量、下单总金额、下单商品数走势对比</li>
            <li>饼图则展现了各种促销活动时间段内有效订单的下单量、下单总金额、下单商品数占总数的比例</li>
            <li>统计列表则清晰的展现了各种促销活动的下单量、下单总金额、下单商品数的总数值</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  
  <div class="stat-info"> <span>下单量：
    <strong><?php echo intval($output['statcount']['ordernum']);?></strong>
    </span><span>下单商品数：
    <strong><?php echo intval($output['statcount']['goodsnum']);?></strong>
    </span><span>下单金额：
    <strong><?php echo ncPriceFormat($output['statcount']['orderamount']);?></strong>
    元 </span></div>
  <div id="stat_tabs" class="w100pre close_float ui-tabs">
    <div class="close_float tabmenu">
      <ul class="tab pngFix">
        <li><a href="#ordernum_div" nc_type="showlinelabels" data-param='{"type":"ordernum"}'>下单量</a></li>
        <li><a href="#goodsnum_div" nc_type="showlinelabels" data-param='{"type":"goodsnum"}'>下单商品数</a></li>
        <li><a href="#orderamount_div" nc_type="showlinelabels" data-param='{"type":"orderamount"}'>下单金额</a></li>
      </ul>
    </div>
    <!-- 下单量 -->
    <div id="ordernum_div" class="close_float"></div>
    <!-- 下单商品件数 -->
    <div id="goodsnum_div"></div>
    <!-- 下单金额 -->
    <div id="orderamount_div"></div>
  </div>
  
  <!-- pie stat start -->
  <div class="w100pre close_float" style="max-height:400px">
    <div id="statpie_ordernum" class="w18pre" style="float:left; padding-left:50px;"></div>
    <div id="statpie_goodsnum" class="w18pre" style="float:left; padding-left:50px;"></div>
    <div id="statpie_orderamount" class="w18pre" style="float:left; padding-left:50px;"></div>
  </div>
  <!-- pie stat end --> 
  
  <!-- stat list start -->
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th>促销类型</th>
        <th class="align-center">下单量</th>
        <th class="align-center">下单商品数</th>
        <th class="align-center">下单金额（元）</th>
      </tr>
    <tbody id="datatable">
    <?php if(!empty($output['statlist'])){ ?>
      <?php foreach($output['statlist'] as $k => $v){ ?>
      <tr class="hover member">
        <td><?php echo $v['goodstype_text'];?></td>
        <td class="align-center"><?php echo $v['ordernum']; ?></td>
        <td class="align-center"><?php echo $v['goodsnum']; ?></td>
        <td class="align-center"><?php echo $v['orderamount']; ?></td>
      </tr>
      <?php } ?>
    <?php } else { ?>
        <tr class="no_data">
        	<td colspan="11"><?php echo $lang['no_record']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
  </table>
  <!-- stat list end --> 
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ui.core.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ui.tabs.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script> 
<script>
//切换登录卡
$(function() {
    $('#stat_tabs').tabs();
});

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
	
	//linelabels
	getLineLabels('ordernum');
	$("[nc_type='showlinelabels']").click(function(){
    	var data_str = $(this).attr('data-param');
		eval('data_str = '+data_str);
		getLineLabels(data_str.type);
    });

	$('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
    
	//pie
	$('#statpie_ordernum').highcharts(<?php echo $output['stat_json']['ordernum'];?>);
	$('#statpie_goodsnum').highcharts(<?php echo $output['stat_json']['goodsnum'];?>);
	$('#statpie_orderamount').highcharts(<?php echo $output['stat_json']['orderamount'];?>);
});

//load linelabels
function getLineLabels(stattype){
	var search_type = $("#search_type").val();
	if(!$("#"+stattype+'_div').html()){
		$("#"+stattype+'_div').load('index.php?act=stat_marketing&op=promotiontrend&search_type='+search_type+'&stattype='+stattype+'&t=<?php echo $output['searchtime'];?>');
	}
}
</script>