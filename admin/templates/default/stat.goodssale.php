<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>商品统计</h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="stat_goods" />
    <input type="hidden" name="op" value="goods_sale" />
    <input type="hidden" id="exporttype" name="exporttype" value=""/>
    <input type="hidden" id="orderby" name="orderby" value="<?php echo $output['orderby']?$output['orderby']:'goodsnum desc';?>"/>
    <div class="w100pre" style="width: 100%;">
        <table class="tb-type1 noborder search left">
          <tbody>
            <tr>
            	<td colspan='7'>
                  	<select name="search_type" id="search_type" class="querySelect">
                      <option value="day" <?php echo $output['search_arr']['search_type']=='day'?'selected':''; ?>>按照天统计</option>
                      <option value="week" <?php echo $output['search_arr']['search_type']=='week'?'selected':''; ?>>按照周统计</option>
                      <option value="month" <?php echo $output['search_arr']['search_type']=='month'?'selected':''; ?>>按照月统计</option>
                    </select>
                  <span id="searchtype_day" style="display:none;">
                  	<input class="txt date" type="text" value="<?php echo @date('Y-m-d',$output['search_arr']['day']['search_time']);?>" id="search_time" name="search_time">
                  </span>
                  <span id="searchtype_week" style="display:none;">
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
                  </span>
                  <span id="searchtype_month" style="display:none;">
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
                  </span>
                  </td>
         	  </tr>
         	  <tr>
         	  	<td>商品名称<input class="txt-long" type="text" name="goods_name" value="<?php echo $_GET['goods_name'];?>" /></td>
         	  	<td>店铺名称<input class="txt-long" type="text" name="store_name" value="<?php echo $_GET['store_name'];?>" /></td>
         	  	<td>分类</td>
         	  	<td id="searchgc_td"></td><input type="hidden" id="choose_gcid" name="choose_gcid" value="0"/>
         	  	<td>品牌</td>
         	  	<td><div id="ajax_brand" class="ncsc-brand-select">
                      <div class="selection">
                      	<input name="b_name" id="b_name" value="<?php echo $_REQUEST['b_name'];?>" type="text" class="text w180" readonly="readonly" />
                      	<input type="hidden" name="b_id" id="b_id" value="<?php echo $_REQUEST['b_id'];?>" />
                      </div>
                      <div class="ncsc-brand-select-container">
                        <div class="brand-index" data-url="index.php?act=common&op=ajax_get_brand">
                          <div class="letter" nctype="letter">
                            <ul>
                              <li><a href="javascript:void(0);" data-letter="all">全部品牌</a></li>
                              <li><a href="javascript:void(0);" data-letter="A">A</a></li>
                              <li><a href="javascript:void(0);" data-letter="B">B</a></li>
                              <li><a href="javascript:void(0);" data-letter="C">C</a></li>
                              <li><a href="javascript:void(0);" data-letter="D">D</a></li>
                              <li><a href="javascript:void(0);" data-letter="E">E</a></li>
                              <li><a href="javascript:void(0);" data-letter="F">F</a></li>
                              <li><a href="javascript:void(0);" data-letter="G">G</a></li>
                              <li><a href="javascript:void(0);" data-letter="H">H</a></li>
                              <li><a href="javascript:void(0);" data-letter="I">I</a></li>
                              <li><a href="javascript:void(0);" data-letter="J">J</a></li>
                              <li><a href="javascript:void(0);" data-letter="K">K</a></li>
                              <li><a href="javascript:void(0);" data-letter="L">L</a></li>
                              <li><a href="javascript:void(0);" data-letter="M">M</a></li>
                              <li><a href="javascript:void(0);" data-letter="N">N</a></li>
                              <li><a href="javascript:void(0);" data-letter="O">O</a></li>
                              <li><a href="javascript:void(0);" data-letter="P">P</a></li>
                              <li><a href="javascript:void(0);" data-letter="Q">Q</a></li>
                              <li><a href="javascript:void(0);" data-letter="R">R</a></li>
                              <li><a href="javascript:void(0);" data-letter="S">S</a></li>
                              <li><a href="javascript:void(0);" data-letter="T">T</a></li>
                              <li><a href="javascript:void(0);" data-letter="U">U</a></li>
                              <li><a href="javascript:void(0);" data-letter="V">V</a></li>
                              <li><a href="javascript:void(0);" data-letter="W">W</a></li>
                              <li><a href="javascript:void(0);" data-letter="X">X</a></li>
                              <li><a href="javascript:void(0);" data-letter="Y">Y</a></li>
                              <li><a href="javascript:void(0);" data-letter="Z">Z</a></li>
                              <li><a href="javascript:void(0);" data-letter="0-9">其他</a></li>
                            </ul>
                          </div>
                          <div class="search" nctype="search"><input name="search_brand_keyword" id="search_brand_keyword" type="text" class="text" placeholder="品牌名称关键字查找"/><a href="javascript:void(0);" class="ncsc-btn-mini" style="vertical-align: top;">Go</a></div>
                        </div>
                        <div class="brand-list" nctype="brandList">
                        <ul nctype="brand_list">
                            <?php if(is_array($output['brand_list']) && !empty($output['brand_list'])){?>
                            <?php foreach($output['brand_list'] as $val) { ?>
                            <li data-id='<?php echo $val['brand_id'];?>'data-name='<?php echo $val['brand_name'];?>'><em><?php echo $val['brand_initial'];?></em><?php echo $val['brand_name'];?></li>
                            <?php } ?>
                            <?php }?>
                        </ul>
                        </div>
                        <div class="no-result" nctype="noBrandList" style="display: none;">没有符合"<strong>搜索关键字</strong>"条件的品牌</div>
                      	</div>
                      </div>
         	  		
         	  		
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
        	<li>以下列表为符合搜索条件的有效订单中所有商品数据，及其时间段内的销量、下单量、下单总金额</li>
            <li>点击每列旁边的箭头对列表进行排序，默认按照“下单商品件数”降序排列</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  
  <div id="container" class="w100pre close_float">
      <div style="text-align:right;">
      	<a class="btns" href="javascript:void(0);" id="export_btn"><span>导出Excel</span></a>
      </div>
  </div>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead sortbar-array" >
	      <th class="align-center">商品名称</th>
	      <th class="align-center">平台货号</th>
	      <th class="align-center">店铺名称</th>
	      <th class="align-center"><a nc_type="orderitem" data-param='{"orderby":"goodsnum"}' class="<?php echo (!$output['orderby'] || $output['orderby']=='goodsnum desc')?'selected desc':''; echo $output['orderby']=='goodsnum asc'?'selected asc':''; ?>">下单商品件数<i></i></a></th>
	      <th class="align-center"><a nc_type="orderitem" data-param='{"orderby":"ordernum"}' class="<?php echo ($output['orderby']=='ordernum desc')?'selected desc':''; echo $output['orderby']=='ordernum asc'?'selected asc':''; ?>">下单单量<i></i></a></th>
	      <th class="align-center"><a nc_type="orderitem" data-param='{"orderby":"goodsamount"}' class="<?php echo ($output['orderby']=='goodsamount desc')?'selected desc':''; echo $output['orderby']=='goodsamount asc'?'selected asc':''; ?>">下单金额<i></i></a></th>
      </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['goods_list'])){ ?>
    <?php foreach ($output['goods_list'] as $k=>$v){?>
      <tr class="hover">
        <td class="align-left"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>" target="_blank"><?php echo $v['goods_name']; ?></a></td>
        <td class="align-center"><?php echo $v['goods_commonid']; ?></td>
        <td class="align-center"><?php echo $v['store_name']; ?></td>
        <td class="align-center"><?php echo $v['goodsnum']; ?></td>
        <td class="align-center"><?php echo $v['ordernum']; ?></td>
        <td class="align-center"><?php echo $v['goodsamount']; ?></td>
      </tr>
    <?php } ?>
    <?php }else { ?>
    <tr class="no_data">
      <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
    </tr>
    <?php } ?>
    </tbody>
    <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>
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
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
  
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

	$('#ncsubmit').click(function(){
		$("#exporttype").val('');
		$("#orderby").val('');
    	$('#formSearch').submit();
    });

    //导出图表
    $("#export_btn").click(function(){
    	$("#exporttype").val('excel');
    	$('#formSearch').submit();
    });
    //排序
    $("[nc_type='orderitem']").click(function(){
    	$("#exporttype").val('');
    	var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
        if($(this).hasClass('desc')){
        	$("#orderby").val(data_str.orderby + ' asc');
        } else {
        	$("#orderby").val(data_str.orderby + ' desc');
        }
        $('#formSearch').submit();
    });
    
	//商品分类
	init_gcselect(<?php echo $output['gc_choose_json'];?>,<?php echo $output['gc_json']?>);

	/* AJAX选择品牌 */
    $("#ajax_brand").brandinit();
});
</script>
