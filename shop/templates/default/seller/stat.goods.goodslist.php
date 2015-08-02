<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert mt10" style="clear:both;">
	<ul class="mt5">
		<li>1、<?php echo $lang['stat_validorder_explain'];?></li>
		<li>2、以下列表为从昨天开始最近30天有效订单中的所有商品数据</li>
        <li>3、近30天下单商品数：从昨天开始最近30天有效订单的某商品总销量</li>
        <li>4、近30天下单金额：从昨天开始最近30天有效订单的某商品总销售额</li>
        <li>5、点击每列旁边的箭头对列表进行排序，默认按照“近30天成交件数”降序排列</li>
        <li>6、点击每条记录后的“走势图”，查看最近30天下单金额、下单商品数、下单量走势</li>
      </ul>
</div>
<form method="get" action="index.php" target="_self" id="formSearch">
  <table class="search-form">
    <input type="hidden" name="act" value="statistics_goods" />
    <input type="hidden" name="op" value="goodslist" />
    <input type="hidden" id="orderby" name="orderby" value="<?php echo $output['orderby'];?>"/>
    <tr>
    	<td class="tr">
    		<div class="fr">&nbsp;&nbsp;商品名称
    			<input type="text" class="text w150" name="search_gname" value="<?php echo $_GET['search_gname']; ?>" />
    			<label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_common_search'];?>" /></label>
    		</div>
    		<div class="fr">商品分类&nbsp;<span id="searchgc_td"></span><input type="hidden" id="choose_gcid" name="choose_gcid" value="0"/></div>
    	</td>
    </tr>
  </table>
</form>
<table class="ncsc-default-table">
  <thead>
    <tr class="sortbar-array">
      <th></th>
      <th>商品名称</th>
      <th>价格</th>
      <th class="align-center"><a title="点击进行排序" nc_type="orderitem" data-param='{"orderby":"ordergoodsnum"}' class="<?php echo (!$output['orderby'] || $output['orderby']=='ordergoodsnum desc')?'selected desc':''; echo $output['orderby']=='ordergoodsnum asc'?'selected asc':''; ?>">近30天下单商品数<i></i></a></th>
      <th class="align-center"><a title="点击进行排序" nc_type="orderitem" data-param='{"orderby":"ordergamount"}' class="<?php echo $output['orderby']=='ordergamount desc'?'selected desc':''; echo $output['orderby']=='ordergamount asc'?'selected asc':''; ?>">近30天下单金额<i></i></a></th>
      <th class="w120"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($output['goodslist']) && is_array($output['goodslist'])) { ?>
    <?php foreach($output['goodslist'] as $v) { ?>
    <tr class="bd-line">
      <td><div class="pic-thumb"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>" target="_blank"><img src="<?php echo thumb($v, 60);?>"/></a></div></td>
      <td class="tl"><span class="over_hidden w400 h20"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>" target="_blank"><?php echo $v['goods_name'];?></a></span></td>
      <td><?php echo $v['goods_price'];?></td>
      <td><?php echo $v['ordergoodsnum'];?></td>
      <td><?php echo $lang['currency'].$v['ordergamount'];?></td>
      <td><a href="javascript:void(0);" nc_type='showdata' data-param='{"gid":"<?php echo $v['goods_id'];?>"}'>走势图</a></td>
    </tr>
    <?php }?>
    <?php } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
  <?php if (!empty($output['goodslist']) && is_array($output['goodslist'])) { ?>
  <tfoot>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
  </tfoot>
  <?php } ?>
</table>
<table class="ncsc-default-table">
	<tbody>
    	<tr>
    		<div id="goodsinfo_div" class="close_float" style="text-align:center;"></div>
    	</tr>
	</tbody>
</table>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" ></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>

<script type="text/javascript">
$(function(){
	//商品分类
	init_gcselect(<?php echo $output['gc_choose_json'];?>,<?php echo $output['gc_json']?>);
	
    $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
    $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});

    //加载商品详情
    <?php if (!empty($output['goodslist']) && is_array($output['goodslist'])) { ?>
    getStatdata(<?php echo $output['goodslist'][0]['goods_id'];?>);
    <?php }?>
    $("[nc_type='showdata']").click(function(){
    	var data_str = $(this).attr('data-param');
		eval('data_str = '+data_str);
		getStatdata(data_str.gid);
    });
    //排序
    $("[nc_type='orderitem']").click(function(){
    	var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
        if($(this).hasClass('desc')){
        	$("#orderby").val(data_str.orderby + ' asc');
        } else {
        	$("#orderby").val(data_str.orderby + ' desc');
        }
        $('#formSearch').submit();
    });
});
function getStatdata(gid){
	$('#goodsinfo_div').load('index.php?act=statistics_goods&op=goodsinfo&gid='+gid);
}
</script>