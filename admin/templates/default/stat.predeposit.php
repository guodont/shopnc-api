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
    <input type="hidden" name="op" value="predeposit" />
    <input type="hidden" name="" value="" />
    <div class="w100pre" style="width: 100%;">
      <table class="tb-type1 noborder search left">
        <tbody>
          <tr>
            <td><select name="pd_type" id="pd_type" class="querySelect">
                <option value="recharge" <?php echo $_GET['pd_type']=='recharge'?'selected':''; ?>>充值</option>
                <option value="order_pay" <?php echo $_GET['pd_type']=='order_pay'?'selected':''; ?>>消费</option>
                <option value="cash_pay" <?php echo $_GET['pd_type']=='cash_pay'?'selected':''; ?>>提现</option>
                <option value="refund" <?php echo $_GET['pd_type']=='refund'?'selected':''; ?>>退款</option>
              </select></td>
            <td><select name="search_type" id="search_type" class="querySelect">
                <option value="day" <?php echo $_GET['search_type']=='day'?'selected':''; ?>>按照天统计</option>
                <option value="week" <?php echo $_GET['search_type']=='week'?'selected':''; ?>>按照周统计</option>
                <option value="month" <?php echo $_GET['search_type']=='month'?'selected':''; ?>>按照月统计</option>
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
  <div class="stat-info"><span>存入金额：
    <strong><?php echo number_format($output['stat_array']['recharge_amount'],2); ?></strong>
    元</span><span>消费金额：
    <strong><?php echo number_format($output['stat_array']['order_amount'],2); ?></strong>
    元</span><span>提现金额：
    <strong><?php echo number_format($output['stat_array']['cash_amount'],2); ?></strong>
    元</span><span>总余额：
    <strong><?php echo number_format($output['usable_amount'],2); ?></strong>
    元</span><span>使用总人数：
    <strong><?php echo intval($output['user_amount']); ?></strong>
    </span></div>
  <div id="container" class="w100pre close_float" style="height:400px"></div>
  <div style="text-align:right;">
    <input type="hidden" id="export_type" name="export_type" data-param='{"url":"<?php echo $output['actionurl'];?>&pd_type=<?php echo trim($_GET['pd_type']); ?>&exporttype=excel"}' value="excel"/>
    <a class="btns" href="javascript:void(0);" id="export_btn"><span>导出Excel</span></a> </div>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th class="align-center">会员名称</th>
        <th class="align-center">创建时间</th>
        <th class="align-center">可用金额（元）</th>
        <th class="align-center">冻结金额（元）</th>
        <th class="align-center">管理员名称</th>
        <th class="align-center">类型</th>
        <th class="align-center">描述</th>
      </tr>
    </thead>
    <tbody id="datatable">
      <?php if(!empty($output['log_list']) && is_array($output['log_list'])){ ?>
      <?php foreach ($output['log_list'] as $k=>$v){?>
      <tr class="hover">
        <td class="align-center"><?php echo $v['lg_member_name']; ?></td>
        <td class="align-center"><?php echo date('Y-m-d H:i:s',$v['lg_add_time']); ?></td>
        <td class="align-center"><?php echo $v['lg_av_amount']; ?></td>
        <td class="align-center"><?php echo $v['lg_freeze_amount']; ?></td>
        <td class="align-center"><?php echo $v['lg_admin_name']; ?></td>
        <td class="align-center"><?php 
    	switch ($v['lg_type']){
			case 'recharge':
				echo '充值';
				break;
			case 'order_pay':
				echo '消费';
				break;
			case 'cash_pay':
				echo '提现';
				break;
			case 'refund':
				echo '退款';
				break;
		}
        ?></td>
        <td class="align-center"><?php echo $v['lg_desc']; ?></td>
      </tr>
      <?php } ?>
      <?php }else { ?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php } ?>
    </tbody>
    <?php if(!empty($output['log_list']) && is_array($output['log_list'])){ ?>
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
	
	$('#container').highcharts(<?php echo $output['stat_json'];?>);

	$('#ncsubmit').click(function(){
    	$('#formSearch').submit();
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