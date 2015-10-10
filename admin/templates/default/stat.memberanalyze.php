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
    <input type="hidden" name="op" value="analyze" />
    <input type="hidden" name="" value="" />
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
            <li>列表一及统计图展示了时间段内会员有效订单的订单数量、下单商品数量和订单总金额的前15名会员</li>
            <li>列表二展示了时间段内所有会员有效订单的订单数量、下单商品数量和订单总金额统计数据，并可以点击列表上方的“导出Excel”，将列表数据导出为Excel文件</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  
  <div id="stat_tabs" class="w100pre close_float ui-tabs" style="min-height:500px">
  <div class="close_float tabmenu">
  	<ul class="tab pngFix">
    	<li><a href="#ordernum_div">下单量</a></li>
    	<li><a href="#goodsnum_div">下单商品件数</a></li>
    	<li><a href="#orderamount_div">下单金额</a></li>
    </ul>
  </div>
  <!-- 下单量 -->
  <div id="ordernum_div" class="close_float">
  	<div class="w40pre floatleft">
  		<table class="table tb-type2 nobdb">
            <thead>
              <tr class="thead">              
                <th class="align-center">序号</th>
                <th class="align-center">会员名称</th>
                <th class="align-center">下单量</th>
              </tr>
            </thead>
            <tbody id="datatable">
            <?php if(!empty($output['ordernum_listtop15'])){?>
            <?php foreach ($output['ordernum_listtop15'] as $k=>$v){?>
              <tr class="hover">
                <td class="align-center"><?php echo $k+1;?></td>
                <td class="align-center"><?php echo $v['statm_membername'];?></td>
                <td class="align-center"><?php echo $v['ordernum'];?></td>
              </tr>
            <?php } ?>
            <?php } else {?>
            <tr class="no_data">
            	<td colspan="11"><?php echo $lang['no_record']; ?></td>
            </tr>
            <?php }?>
            </tbody>
       </table>
  	</div>
  	<div id="container_ordernum" class="w50pre floatleft"></div>
  	<div id="list_ordernum" class="close_float" style="padding-top:10px;"></div>
  </div>
  
  <!-- 下单商品件数 -->
  <div id="goodsnum_div">
  	<div class="w40pre floatleft">
  		<table class="table tb-type2 nobdb">
            <thead>
              <tr class="thead">              
                <th class="align-center">序号</th>
                <th class="align-center">会员名称</th>
                <th class="align-center">商品件数</th>
              </tr>
            </thead>
            <tbody id="datatable">
            <?php if(!empty($output['goodsnum_listtop15'])){?>
            <?php foreach ($output['goodsnum_listtop15'] as $k=>$v){?>
              <tr class="hover">
                <td class="align-center"><?php echo $k+1;?></td>
                <td class="align-center"><?php echo $v['statm_membername'];?></td>
                <td class="align-center"><?php echo $v['goodsnum'];?></td>
              </tr>
            <?php } ?>
            <?php } else {?>
            <tr class="no_data">
            	<td colspan="11"><?php echo $lang['no_record']; ?></td>
            </tr>
            <?php }?>
            </tbody>
       </table>
  	</div>
  	<div id="container_goodsnum" class="w50pre floatleft"></div>
  	<div id="list_goodsnum" class="close_float" style="padding-top:10px;" ></div>
  </div>
  
  <!-- 下单金额 -->
  <div id="orderamount_div">
  	<div class="w40pre floatleft">
  		<table class="table tb-type2 nobdb">
            <thead>
              <tr class="thead">              
                <th class="align-center">序号</th>
                <th class="align-center">会员名称</th>
                <th class="align-center">下单金额</th>
              </tr>
            </thead>
            <tbody id="datatable">
            <?php if(!empty($output['orderamount_listtop15'])){?>
                <?php foreach ($output['orderamount_listtop15'] as $k=>$v){?>
                  <tr class="hover">
                    <td class="align-center"><?php echo $k+1;?></td>
                    <td class="align-center"><?php echo $v['statm_membername'];?></td>
                    <td class="align-center"><?php echo $v['orderamount'];?></td>
                  </tr>
                <?php } ?>
            <?php } else {?>
                <tr class="no_data">
                	<td colspan="11"><?php echo $lang['no_record']; ?></td>
                </tr>
            <?php }?>
            </tbody>
       </table>
  	</div>
  	<div id="container_orderamount" class="w50pre floatleft"></div>
  	<div id="list_orderamount" class="close_float" style="padding-top:10px;" ></div>
  </div>
  </div>
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
	
	$('#container_ordernum').highcharts(<?php echo $output['statordernum_json'];?>);
	$('#container_goodsnum').highcharts(<?php echo $output['statgoodsnum_json'];?>);
	$('#container_orderamount').highcharts(<?php echo $output['statorderamount_json'];?>);

	//加载详细列表
	$("#list_ordernum").load('index.php?act=stat_member&op=analyzeinfo&type=ordernum&t=<?php echo $output['searchtime'];?>');
	$("#list_orderamount").load('index.php?act=stat_member&op=analyzeinfo&type=orderamount&t=<?php echo $output['searchtime'];?>');
	$("#list_goodsnum").load('index.php?act=stat_member&op=analyzeinfo&type=goodsnum&t=<?php echo $output['searchtime'];?>');
	
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