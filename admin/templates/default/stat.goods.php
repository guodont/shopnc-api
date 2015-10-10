<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>销量分析</h3>
      <?php echo $output['top_link'];?> </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="stat_trade" />
    <input type="hidden" name="op" value="goods" />
    <div class="w100pre" style="width: 100%;">
      <table class="tb-type1 noborder search left">
        <tbody>
          <tr>
            <td><select name="rank_type" id="rank_type" class="querySelect">
                <option value="trade_num" <?php echo $_REQUEST['rank_type']=='trade_num'?'selected':''; ?>>按销量排名</option>
                <option value="trade_amount" <?php echo $_REQUEST['rank_type']=='trade_amount'?'selected':''; ?>>按销售额排名</option>
              </select></td>
            <td><select name="search_type" id="search_type" class="querySelect">
                <option value="day" <?php echo $_REQUEST['search_type']=='day'?'selected':''; ?>>按照天统计</option>
                <option value="week" <?php echo $_REQUEST['search_type']=='week'?'selected':''; ?>>按照周统计</option>
                <option value="month" <?php echo $_REQUEST['search_type']=='month'?'selected':''; ?>>按照月统计</option>
              </select></td>
            <td id="searchtype_day" style="display:none;"><input class="txt date" type="text" value="<?php echo $output['search_time'];?>" id="search_time" name="search_time"></td>
            <td id="searchtype_week" style="display:none;"><select name="search_time_year" class="querySelect">
                <?php foreach ($output['year_arr'] as $k=>$v){?>
                <option value="<?php echo $k;?>" <?php echo $output['current_year'] == $k?'selected':'';?>><?php echo $v; ?></option>
                <?php } ?>
              </select>
              <select name="search_time_month" class="querySelect">
                <?php foreach ($output['month_arr'] as $k=>$v){?>
                <option value="<?php echo $k;?>" <?php echo $output['current_month'] == $k?'selected':'';?>><?php echo $v; ?></option>
                <?php } ?>
              </select>
              <select name="search_time_week" class="querySelect">
                <?php foreach ($output['week_arr'] as $k=>$v){?>
                <option value="<?php echo $v['key'];?>" <?php echo $output['current_week'] == $v['key']?'selected':'';?>><?php echo $v['val']; ?></option>
                <?php } ?>
              </select></td>
            <td id="searchtype_month" style="display:none;"><select name="search_time_year" class="querySelect">
                <?php foreach ($output['year_arr'] as $k=>$v){?>
                <option value="<?php echo $k;?>" <?php echo $output['current_year'] == $k?'selected':'';?>><?php echo $v; ?></option>
                <?php } ?>
              </select>
              <select name="search_time_month" class="querySelect">
                <?php foreach ($output['month_arr'] as $k=>$v){?>
                <option value="<?php echo $k;?>" <?php echo $output['current_month'] == $k?'selected':'';?>><?php echo $v; ?></option>
                <?php } ?>
              </select></td>
            <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
          </tr>
        </tbody>
      </table>
      <span class="right" style="margin:12px 0px 6px 4px;"> </span> </div>
  </form>
  <div class="stat-info"><span>上架商品数：<strong><?php echo intval($output['goods_on_allnum']); ?></strong></span><span>下单商品数：<strong><?php echo intval($output['order_goods_num']); ?></strong></span><span>下单单数：<strong><?php echo intval($output['order_num']); ?></strong></span><span>下单会员数：<strong><?php echo intval($output['order_buyer_num']); ?></strong></span><span>合计金额：<strong><?php echo number_format($output['order_amount'],2); ?></strong>元</span></div>
  <div id="container" class="w100pre close_float" style="height:400px"></div>
  <div style="text-align:right;">
    <input type="hidden" id="export_type" name="export_type" data-param='{"url":"<?php echo $output['actionurl'];?>&exporttype=excel"}' value="excel"/>
    <a class="btns" href="javascript:void(0);" id="export_btn"><span>导出Excel</span></a> </div>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th class="align-center" style="width:30%">排名</th>
        <th class="align-center" style="width:30%">商品名称</th>
        <th class="align-center" style="width:30%"><?php echo $output['table_tip']; ?></th>
      </tr>
    </thead>
    <tbody id="datatable">
      <?php if(!empty($output['goods_list'])){ ?>
      <?php foreach ($output['goods_list'] as $k=>$v){?>
      <tr class="hover">
        <td class="align-center"><?php echo $k+1;?></td>
        <td class="align-left"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>" target="_blank"><?php echo $v['goods_name'];?></a></td>
        <td class="align-center"><?php echo $v['allnum'];?></td>
      </tr>
      <?php } ?>
      <?php }else { ?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php } ?>
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
	<?php if(trim($output['data_null']) == 'yes'){ ?>
	alert('没有找到该店铺相关数据');
	<?php } ?>
	//统计数据类型
	var s_type = $("#search_type").val();
	$('#search_time').datepicker({dateFormat: 'yy-mm-dd'});

	show_searchtime();
	$("#search_type").change(function(){
		show_searchtime();
	});
	
	//更新周数组
	$("[name='search_time_month']").change(function(){
		var year = $("[name='search_time_year']").val();
		var month = $("[name='search_time_month']").val();
		$("[name='search_time_week']").html('');
		$.getJSON('index.php?act=common&op=getweekofmonth',{y:year,m:month},function(data){
	        if(data != null){
	        	for(var i = 0; i < data.length; i++) {
	        		$("[name='search_time_week']").append('<option value="'+data[i].key+'">'+data[i].val+'</option>');
			    }
	        }
	    });
	});
	$('select[name="search_time_year"]').change(function(){
		var s_year = $(this).val();
		$('select[name="search_time_year"]').each(function(){
			$(this).val(s_year);
		});
	});
	$('select[name="search_time_month"]').change(function(){
		var s_month = $(this).val();
		$('select[name="search_time_month"]').each(function(){
			$(this).val(s_month);
		});
	});
	$('#container').highcharts(<?php echo $output['stat_json'];?>);

	$('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });

	//导出图表
    $("#export_btn").click(function(){
        var item = $("#export_type");
        var type = $(item).val();
        if(type == 'excel'){
        	download_excel(item);
        }
    });
    
	$('#ncexport').click(function(){
		$("#")
    	$('#formSearch').submit();
    });
});
</script>