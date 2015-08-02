<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>店铺统计</h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="stat_store" />
    <input type="hidden" name="op" value="storesales" />
    <div class="w100pre" style="width: 100%;">
        <table class="tb-type1 noborder search left">
          <tbody>
            <tr>
            	<td>
              	<select name="search_sclass" id="search_sclass" class="querySelect">
              		<option value="" selected >店铺分类</option>
              	    <?php foreach ($output['store_class'] as $k=>$v){ ?>
              		<option value="<?php echo $v['sc_id'];?>" <?php echo $_REQUEST['search_sclass'] == $v['sc_id']?'selected':''; ?>><?php echo $v['sc_name'];?></option>
              		<?php } ?>
                </select></td>
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
              <td>店铺名称<input class="txt" type="text" value="<?php echo $_GET['search_sname'];?>" id="search_sname" name="search_sname" /></td>
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
            <li>列表展示了店铺在搜索时间段内的有效订单总金额、订单量和下单会员数，并可以点击列表上方的“导出Excel”将列表数据导出为Excel文件</li>
            <li>点击每列旁边的箭头对列表进行排序，默认按照“下单会员数”降序排列</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  
  <div id="statlist" class="w100pre close_float ui-tabs"></div>
  <div id="stattrends" class="w100pre close_float ui-tabs"></div>
  
  <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
</div>
<script>
//展示搜索时间框
function show_searchtime(){
	s_type = $("#search_type").val();
	$("[id^='searchtype_']").hide();
	$("#searchtype_"+s_type).show();
}
//加载统计地图
function getTrends(storeid){
	$('#stattrends').load('index.php?act=stat_store&op=storesales_trends&storeid='+storeid+'&search_type='+s_type+'&t=<?php echo $output['searchtime'];?>');
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
	
	$('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });

	//加载统计列表
	//店铺分类
	var search_sclass = $("#search_sclass").val();
	var search_sname = $("#search_sname").val();
    $('#statlist').load('index.php?act=stat_store&op=storesales_list&search_sclass='+search_sclass+'&search_sname='+search_sname+'&t=<?php echo $output['searchtime'];?>');
    //店铺销售走势
    $("[nc_type='showtrends']").live('click',function(){
    	var data_str = $(this).attr('data-param');
		eval('data_str = '+data_str);
		getTrends(data_str.storeid);
    });
});
</script>