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
    <input type="hidden" name="op" value="class_sale" />
    <div class="w100pre" style="width: 100%;">
        <table class="tb-type1 noborder search left">
          <tbody>
            <tr>
            <th><label>类型</label></th>
             <td>
              	<select name="class_type" id="class_type" class="querySelect">
                  <option value="goods_class" <?php echo $_REQUEST['class_type']=='goods_class'?'selected':''; ?>>商品类目</option>
                  <option value="store_class" <?php echo $_REQUEST['class_type']=='store_class'?'selected':''; ?>>店铺类目</option>
                </select></td>
                <th><label>分类</label></th>
          <td id="gcategory"><input type="hidden" id="cate_id" name="cate_id" value="" class="mls_id" />
            <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
            <select class="querySelect">
              <option><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
              <?php foreach($output['goods_class'] as $val) { ?>
              <option value="<?php echo $val['gc_id']; ?>" <?php if($output['search']['cate_id'] == $val['gc_id']){?>selected<?php }?>><?php echo $val['gc_name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
            <td id="scategory">
            <select class="querySelect" name="store_class">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(is_array($output['class_list'])){ ?>
              <?php foreach($output['class_list'] as $k => $v){ ?>
              <option <?php if(intval($_GET['store_class']) == $v['sc_id']){ ?>selected="selected"<?php } ?> value="<?php echo $v['sc_id']; ?>"><?php echo $v['sc_name']; ?></option>
              <?php } ?>
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
  <div id="container" class="w100pre close_float" style="height:400px"></div>
  <div style="text-align:right;">
  	<input type="hidden" id="export_type" name="export_type" data-param='{"url":"<?php echo $output['actionurl'];?>&class_type=<?php echo trim($_GET['class_type']); ?>&cate_id=<?php echo intval($_GET['cate_id']); ?>&store_class=<?php echo intval($_GET['store_class']); ?>&exporttype=excel"}' value="excel"/>
  	<a class="btns" href="javascript:void(0);" id="export_btn"><span>下载分类数据</span></a>
  </div>
  <?php if(trim($_GET['class_type']) == '' || trim($_GET['class_type']) == 'goods_class'){ ?>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
      	<th class="align-center">商品名称</th>
      	<th class="align-center">所属分类</th>
        <th class="align-center">店铺名称</th>
        <th class="align-center">下单单量</th>
        <th class="align-center">下单商品件数</th>
        <th class="align-center">下单金额</th>
      </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['data_list'])){ ?>
    <?php foreach ($output['data_list'] as $k=>$v){?>
      <tr class="hover">
        <td class="align-left"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>" target="_blank"><?php echo $v['goods_name']; ?></a></td>
        <td class="align-center"><?php echo $v['gc_name']; ?></td>
        <td class="align-center"><?php echo $v['store_name']; ?></td>
        <td class="align-center"><?php echo $v['onum']; ?></td>
        <td class="align-center"><?php echo $v['gnum']; ?></td>
        <td class="align-center"><?php echo $v['pnum']; ?>元</td>
      </tr>
    <?php } ?>
    <?php }else { ?>
    <tr class="no_data">
      <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
    </tr>
    <?php } ?>
    </tbody>
  </table>
  <?php } ?>
  <?php if(trim($_GET['class_type']) == 'store_class'){ ?>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
      	<th class="align-center">店铺名称</th>
      	<th class="align-center">所属分类</th>
        <th class="align-center">店主账号</th>
        <th class="align-center">下单单量</th>
        <th class="align-center">下单金额</th>
      </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['data_list'])){ ?>
    <?php foreach ($output['data_list'] as $k=>$v){?>
      <tr class="hover">
        <td class="align-center"><?php echo $v['store_name']; ?></td>
        <td class="align-center"><?php echo $v['sc_name']; ?></td>
        <td class="align-center"><?php echo $v['member_name']; ?></td>
        <td class="align-center"><?php echo $v['onum']; ?></td>
        <td class="align-center"><?php echo $v['pnum']; ?>元</td>
      </tr>
    <?php } ?>
    <?php }else { ?>
    <tr class="no_data">
      <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
    </tr>
    <?php } ?>
    </tbody>
  </table>
  <?php } ?>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>
</div>
<script>
//展示搜索时间框
function show_searchtime(){
	s_type = $("#search_type").val();
	$("[id^='searchtype_']").hide();
	$("#searchtype_"+s_type).show();
}

$(function () {
	//分类相关
	gcategoryInit("gcategory");
	<?php if(trim($_GET['class_type']) == 'store_class'){ ?>
	$('#gcategory').hide();
	<?php }else{ ?>
	$('#scategory').hide();
	<?php } ?>
	$('#class_type').change(function(){
		if($(this).val() == 'store_class'){
			$('#gcategory').hide();
			$('#scategory').show();
		}else{
			$('#scategory').hide();
			$('#gcategory').show();
		}
	});
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