<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>行业分析</h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="stat_industry" />
    <input type="hidden" name="op" value="rank" />
    <div class="w100pre" style="width: 100%;">
        <table class="tb-type1 noborder search left">
          <tbody>
            <tr>
              <td id="searchgc_td"></td>
              <input type="hidden" id="choose_gcid" name="choose_gcid" value="0"/>
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
            <li>统计某行业在不同时间段下单量前50名商品和前30名店铺</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  
  <table class="table tb-type2">
	<thead class="thead">
		<tr class="space">
			<th>行业商品50强</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<div id="container_goods" class="w100pre close_float" style="height:400px"></div>
			</td>
		</tr>
	</tbody>
  </table>
  
  <table class="table tb-type2 nobdb">
  	<thead>
		<tr class="thead sortbar-array">
			<th class="align-center w18pre">序号</th>
            <th class="align-center">商品名称</th>
            <th class="align-center">下单商品数</th>
        </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['goods_list'])){ ?>
        <?php foreach ((array)$output['goods_list'] as $k=>$v){?>
          <tr class="hover">
          	<td class="align-center w18pre"><?php echo $k+1;?></td>
          	<td class="alignleft"><a href='<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>' target="_blank"><?php echo $v['goods_name'];?></a></td>
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
  
  <table class="table tb-type2">
	<thead class="thead">
		<tr class="space">
			<th colspan="15">行业店铺30强</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<div id="container_store" class="w100pre close_float" style="height:400px"></div>
			</td>
		</tr>
	</tbody>
  </table>
  
  <table class="table tb-type2 nobdb">
  	<thead>
		<tr class="thead sortbar-array">
			<th class="align-center w18pre">序号</th>
            <th class="align-center">店铺名称</th>
            <th class="align-center">下单量</th>
        </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['store_list'])){ ?>
        <?php foreach ((array)$output['store_list'] as $k=>$v){?>
          <tr class="hover">
          	<td class="align-center w18pre"><?php echo $k+1;?></td>
          	<td class="alignleft"><?php echo $v['store_name'];?></td>
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
  
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
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
	//商品分类
	init_gcselect(<?php echo $output['gc_choose_json'];?>,<?php echo $output['gc_json']?>);
	
	$('#container_goods').highcharts(<?php echo $output['goods_statjson'];?>);
	$('#container_store').highcharts(<?php echo $output['store_statjson'];?>);
		
	$('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
    
});
</script>