<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert mt10">
	<ul class="mt5">
		<li>1、<?php echo $lang['stat_validorder_explain'];?></li>
		<li>2、统计图展示了符合搜索条件的有效订单中的下单总金额和下单数量在时间段内的走势情况及与前一个时间段的趋势对比</li>
        <li>3、统计表显示了符合搜索条件的全部有效订单记录并可以点击“导出Excel”将订单记录导出为Excel文件</li>
    </ul>
</div>
<form method="get" action="index.php" target="_self">
  <table class="search-form">
    <input type="hidden" name="act" value="statistics_sale" />
    <input type="hidden" name="op" value="sale" />
    <tr>
    	<td class="tr">
    		<div class="fr">
    			<label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_common_search'];?>" /></label>
    		</div>
    		<div class="fr">&nbsp;
              	<select name="order_type" id="order_type" class="querySelect">
                  <option value="" <?php echo $_REQUEST['order_type']==''?'selected':''; ?>>请选择</option>
                  <option value="<?php echo ORDER_STATE_NEW; ?>" <?php echo $_REQUEST['order_type']!='' && $_REQUEST['order_type']==ORDER_STATE_NEW?'selected':''; ?>>待付款</option>
                  <option value="<?php echo ORDER_STATE_PAY; ?>" <?php echo $_REQUEST['order_type']!='' && $_REQUEST['order_type']==ORDER_STATE_PAY?'selected':''; ?>>待发货</option>
                  <option value="<?php echo ORDER_STATE_SEND; ?>" <?php echo $_REQUEST['order_type']!='' && $_REQUEST['order_type']==ORDER_STATE_SEND?'selected':''; ?>>待收货</option>
                  <option value="<?php echo ORDER_STATE_SUCCESS; ?>" <?php echo $_REQUEST['order_type']!='' && $_REQUEST['order_type']==ORDER_STATE_SUCCESS?'selected':''; ?>>交易完成</option>
                  <option value="<?php echo ORDER_STATE_CANCEL; ?>" <?php echo $_REQUEST['order_type']!='' && $_REQUEST['order_type']==ORDER_STATE_CANCEL?'selected':''; ?>>已取消</option>
                </select>
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

<div class="alert alert-info mt10" style="clear:both;">
	<ul class="mt5">
    <li>
    	<span class="w210 fl h30" style="display:block;">
    		<i title="店铺符合搜索条件的订单总金额" class="tip icon-question-sign"></i>
    		总下单金额：<strong><?php echo $output['statcount_arr']['orderamount'].$lang['currency_zh'];?></strong>
    	</span>
		<span class="w210 fl h30" style="display:block;">
			<i title="店铺符合搜索条件的订单数量" class="tip icon-question-sign"></i>
			总下单量：<strong><?php echo $output['statcount_arr']['ordernum'];?></strong>
		</span>
    </li>
    </ul>
    <div style="clear:both;"></div>
</div>

<div id="stat_tabs" class="ui-tabs" style="min-height:500px;padding-top:10px;">
	<div class="tabmenu">
      	<ul class="tab pngFix">
      		<li><a href="#orderamount_div" nc_type="showdata" data-param='{"type":"orderamount"}'>下单金额</a></li>
        	<li><a href="#ordernum_div" nc_type="showdata" data-param='{"type":"ordernum"}'>下单量</a></li>
        </ul>
    </div>
    <!-- 下单金额 -->
    <div id="orderamount_div" style="width:930px;"></div>
    <!-- 下单量 -->
    <div id="ordernum_div" style="width:930px;"></div>
</div>

<div id="statlist" class=""></div>

<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ui.core.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/ui.tabs.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>

<script type="text/javascript">
//展示搜索时间框
function show_searchtime(){
	s_type = $("#search_type").val();
	$("[id^='searchtype_']").hide();
	$("#searchtype_"+s_type).show();
}

$(function(){
	//Ajax提示
    $('.tip').poshytip({
        className: 'tip-yellowsimple',
        showTimeout: 1,
        alignTo: 'target',
        alignX: 'center',
        alignY: 'top',
        offsetY: 5,
        allowTipHover: false
    });
    
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

	$('#ordernum_div').highcharts(<?php echo $output['stat_json']['ordernum'];?>);
	$('#orderamount_div').highcharts(<?php echo $output['stat_json']['orderamount'];?>);
	
	$('#statlist').load('index.php?act=statistics_sale&op=salelist&t=<?php echo $output['searchtime'];?>&order_type=<?php echo $_REQUEST['order_type'];?>');
});
</script>