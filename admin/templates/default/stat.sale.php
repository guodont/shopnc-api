<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>销量分析</h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="stat_trade" />
    <input type="hidden" name="op" value="sale" />
    <div class="w100pre" style="width: 100%;">
        <table class="tb-type1 noborder search left">
          <tbody>
            <tr>
             <td>
             	<input type="hidden" name="stat_type" id="stat_type" value="ordernum" />
             	<input type="hidden" name="exporttype" id="exporttype" value="" />
              </td>
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
              <td>
              	<select name="order_type" id="order_type" class="querySelect">
                  <option value="" <?php echo $_REQUEST['order_type']==''?'selected':''; ?>>请选择</option>
                  <option value="<?php echo ORDER_STATE_NEW; ?>" <?php echo $_REQUEST['order_type']!='' && $_REQUEST['order_type']==ORDER_STATE_NEW?'selected':''; ?>>待付款</option>
                  <option value="<?php echo ORDER_STATE_PAY; ?>" <?php echo $_REQUEST['order_type']!='' && $_REQUEST['order_type']==ORDER_STATE_PAY?'selected':''; ?>>待发货</option>
                  <option value="<?php echo ORDER_STATE_SEND; ?>" <?php echo $_REQUEST['order_type']!='' && $_REQUEST['order_type']==ORDER_STATE_SEND?'selected':''; ?>>待收货</option>
                  <option value="<?php echo ORDER_STATE_SUCCESS; ?>" <?php echo $_REQUEST['order_type']!='' && $_REQUEST['order_type']==ORDER_STATE_SUCCESS?'selected':''; ?>>交易完成</option>
                  <option value="<?php echo ORDER_STATE_CANCEL; ?>" <?php echo $_REQUEST['order_type']!='' && $_REQUEST['order_type']==ORDER_STATE_CANCEL?'selected':''; ?>>已取消</option>
                </select></td>
         	  <td>店铺名称<input class="txt-long" type="text" name="store_name" id="store_name" value="<?php echo $_GET['store_name'];?>" /></td>
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
        	<li><?php echo $lang['stat_validorder_explain'];?></li>
        	<li>统计图展示了符合搜索条件的有效订单中的下单总金额和下单数量在时间段内的走势情况及与前一个时间段的趋势对比</li>
        	<li>统计表显示了符合搜索条件的全部有效订单记录并可以点击“导出Excel”将订单记录导出为Excel文件</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  
  <div class="stat-info">
      <span>总销售额：<strong><?php echo ($t = $output['statcount_arr']['orderamount'])?$t:'0.00'; ?></strong>元</span><span>总订单量：<strong><?php echo intval($output['statcount_arr']['ordernum']); ?></strong></span>
  </div>
  
  <div id="stat_tabs" class="w100pre close_float ui-tabs" style="min-height:500px">
      <div class="close_float tabmenu">
      	<ul class="tab pngFix">
      		<li><a href="#orderamount_div" nc_type="showdata" data-param='{"type":"orderamount"}'>下单金额</a></li>
        	<li><a href="#ordernum_div" nc_type="showdata" data-param='{"type":"ordernum"}'>下单量</a></li>
        </ul>
      </div>
      <!-- 下单金额 -->
      <div id="orderamount_div" class="close_float" style="text-align:center;"></div>
      <!-- 下单量 -->
      <div id="ordernum_div" class="close_float" style="text-align:center;"></div>
  </div>
  
  <div style="text-align:right;"><a class="btns" href="javascript:void(0);" id="export_btn"><span>导出Excel</span></a></div>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
      <?php foreach ($output['statlist']['headertitle'] as $v){?>
        <th class="align-center"><?php echo $v; ?></th>
      <?php }?>
      </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['statlist']['data']) && is_array($output['statlist']['data'])){ ?>
    <?php foreach ($output['statlist']['data'] as $k=>$v){?>
      <tr class="hover">
        <td class="align-center"><?php echo $v['order_sn'];?></td>
        <td class="align-center"><?php echo $v['buyer_name'];?></td>
        <td class="align-center"><?php echo $v['store_name'];?></td>
        <td class="align-center"><?php echo date('Y-m-d H:i:s',$v['order_add_time']);?></td>
        <td class="align-center"><?php echo number_format(($v['order_amount']),2); ?></td>
        <td class="align-center"><?php echo $v['order_statetext']; ?></td>
      </tr>
    <?php } ?>
    <?php }else { ?>
    <tr class="no_data">
      <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
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
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ui.core.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ui.tabs.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
</div>
<script>
//展示搜索时间框
function show_searchtime(){
	s_type = $("#search_type").val();
	$("[id^='searchtype_']").hide();
	$("#searchtype_"+s_type).show();
}

$(function () {
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
		$.getJSON('index.php?act=common&op=getweekofmonth',{y:year,m:month},function(data){
	        if(data != null){
	        	for(var i = 0; i < data.length; i++) {
	        		$("[name='searchweek_week']").append('<option value="'+data[i].key+'">'+data[i].val+'</option>');
			    }
	        }
	    });
	});
	
	$('#ncsubmit').click(function(){
		$("#exporttype").val('');
    	$('#formSearch').submit();
    });
	
	//导出图表
    $("#export_btn").click(function(){
        $("#exporttype").val('excel');
    	$('#formSearch').submit();
    });

  	//加载统计数据
    getStatdata('orderamount');
    $("[nc_type='showdata']").click(function(){
    	var data_str = $(this).attr('data-param');
		eval('data_str = '+data_str);
		getStatdata(data_str.type);
    });
});
//加载统计地图
function getStatdata(type){
	var search_type = $("#search_type").val();
	var order_type = $("#order_type").val();
	var store_name = $("#store_name").val();
	$('#'+type+'_div').load('index.php?act=stat_trade&op=sale_trend&search_type='+search_type+'&type='+type+'&order_type='+order_type+'&store_name='+store_name+'&t=<?php echo $output['searchtime'];?>');
}
</script>