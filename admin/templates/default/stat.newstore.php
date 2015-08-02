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
    <input type="hidden" name="op" value="newstore" />
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
                  <option value="day" <?php echo $_REQUEST['search_type']=='day'?'selected':''; ?>>按照天统计</option>
                  <option value="week" <?php echo $_REQUEST['search_type']=='week'?'selected':''; ?>>按照周统计</option>
                  <option value="month" <?php echo $_REQUEST['search_type']=='month'?'selected':''; ?>>按照月统计</option>
                </select></td>
              <td id="searchtype_day" style="display:none;">
              	<input class="txt date" type="text" value="<?php echo $output['search_time'];?>" id="search_time" name="search_time">
              </td>
              <td id="searchtype_week" style="display:none;">
              	<select name="search_time_year" class="querySelect">
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
                </select>
              </td>
              <td id="searchtype_month" style="display:none;">
              	<select name="search_time_year" class="querySelect">
              		<?php foreach ($output['year_arr'] as $k=>$v){?>
              		<option value="<?php echo $k;?>" <?php echo $output['current_year'] == $k?'selected':'';?>><?php echo $v; ?></option>
              		<?php } ?>
                </select>
                <select name="search_time_month" class="querySelect">
                	<?php foreach ($output['month_arr'] as $k=>$v){?>
              		<option value="<?php echo $k;?>" <?php echo $output['current_month'] == $k?'selected':'';?>><?php echo $v; ?></option>
              		<?php } ?>
                </select>
              </td>
              <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
            </tr>
          </tbody>
        </table>
        <span class="right" style="margin:12px 0px 6px 4px;">
        	
        </span>
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
            <li>统计图展示了时间段内新增店铺数的走势和与前一时间段的对比</li>
            <li>统计表展示了时间段内新增店铺数值和与前一时间段的同比数值，点击每条记录后的“查看”，了解新增店铺的详细信息</li>
            <li>点击列表上方的“导出Excel”，将列表数据导出为Excel文件</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  
  <div id="container" class="w100pre close_float" style="height:400px"></div>
  
  <div style="text-align:right;">
  	<input type="hidden" id="export_type" name="export_type" data-param='{"url":"<?php echo $output['actionurl'];?>&exporttype=excel"}' value="excel"/>
  	<a class="btns" href="javascript:void(0);" id="export_btn"><span>导出Excel</span></a>
  </div>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
      <?php foreach ($output['statlist']['headertitle'] as $v){?>
        <th class="align-center"><?php echo $v; ?></th>
      <?php }?>
        <th class="align-center">操作</th>
      </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['statlist']['data']) && is_array($output['statlist']['data'])){ ?>
    <?php foreach ($output['statlist']['data'] as $k=>$v){?>
      <tr class="hover">
        <td class="align-center"><?php echo $v['timetext'];?></td>
        <td class="align-center"><?php echo $v['updata'];?></td>
        <td class="align-center"><?php echo $v['currentdata'];?></td>
        <td class="align-center"><?php echo $v['tbrate'];?></td>
        <td class="align-center"><a href="index.php?act=stat_store&op=showstore&type=newbyday&t=<?php echo $v['seartime'];?>&scid=<?php echo $_REQUEST['search_sclass'];?>">查看</a></td>
      </tr>
    <?php } ?>
    <?php } else { ?>
    <tr class="no_data">
       	<td colspan="5"><?php echo $lang['no_record']; ?></td>
    </tr>
    <?php } ?>
    </tbody>
    <?php if(!empty($output['statlist']['data']) && is_array($output['statlist']['data'])){ ?>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
    <?php } ?>
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
});
</script>