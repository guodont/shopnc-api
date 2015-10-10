<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<style>
	.new-general td{ font-size: 14px; }
</style>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_statgeneral'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  
   <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['stat_validorder_explain'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  
  <table class="table tb-type2 new-general">
	<thead class="thead">
		<tr class="space">
			<th colspan="15"><?php echo @date('Y-m-d',$output['stat_time']);?>最新情报</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				下单金额&nbsp;<i title="有效订单的总金额" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['orderamount'];?>元</b>
			</td>
			<td>
				下单会员数&nbsp;<i title="有效订单的下单会员总数" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['ordermembernum'];?></b>
			</td>
			<td>
				下单量&nbsp;<i title="有效订单的总数量" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['ordernum'];?></b>
			</td>
			<td>
				下单商品数&nbsp;<i title="有效订单包含的商品总数量" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['ordergoodsnum'];?></b>
			</td>
		</tr>
		<tr>
			<td>
				平均价格&nbsp;<i title="有效订单包含商品的平均单价" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['priceavg'];?>元</b>
			</td>
			<td>
				平均客单价&nbsp;<i title="有效订单的平均每单的金额" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['orderavg'];?></b>
			</td>
			<td>
				新增会员&nbsp;<i title="期间内新注册会员总数" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['newmember'];?></b>
			</td>
			<td>
				会员数量&nbsp;<i title="平台所有会员的数量" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['membernum'];?></b>
			</td>
		</tr>
		<tr>
			<td>
				新增店铺&nbsp;<i title="期间内新注册店铺总数" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['newstore'];?></b></td>
			<td>
				店铺数量&nbsp;<i title="平台所有店铺的数量" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['storenum'];?></b></td>
			<td>
				新增商品&nbsp;<i title="期间内新增商品总数" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['newgoods'];?></b></td>
			<td>
				商品数量&nbsp;<i title="平台所有商品的数量" class="tip icon-question-sign"></i>
				<br><b><?php echo $output['statnew_arr']['goodsnum'];?></b></td>
		</tr>
	</tbody>
  </table>
  
  <table class="table tb-type2">
	<thead class="thead">
		<tr class="space">
			<th colspan="15"><?php echo @date('Y-m-d',$output['stat_time']);?>销售走势</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><div id="container" class="w100pre close_float" style="height:400px"></div></td>
		</tr>
	</tbody>
  </table>
  
  
  <div class="w40pre floatleft">
  	<table class="table tb-type2">
    	<thead class="thead">
    		<tr class="space">
    			<th colspan="15">7日内店铺销售TOP30&nbsp;<i title="从昨天开始7日内热销店铺前30名" class="tip icon-question-sign"></i></th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr>
    			<td>序号</td>
    			<td>店铺名称</td>
    			<td>下单金额</td>
    		</tr>
    		<?php foreach((array)$output['storetop30_arr'] as $k=>$v){ ?>
    		<tr>
    			<td><?php echo $k+1;?></td>
    			<td><?php echo $v['store_name'];?></td>
    			<td><?php echo $v['orderamount'];?></td>
    		</tr>
    		<?php } ?>
    	</tbody>
      </table>
  </div>
  
  <div class="w50pre floatleft" style="margin-left: 50px;">
  	<table class="table tb-type2">
    	<thead class="thead">
    		<tr class="space">
    			<th colspan="15">7日内商品销售TOP30&nbsp;<i title="从昨天开始7日内热销商品前30名" class="tip icon-question-sign"></i></th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr>
    			<td>序号</td>
    			<td>商品名称</td>
    			<td>销量</td>
    		</tr>
    		<?php foreach((array)$output['goodstop30_arr'] as $k=>$v){ ?>
    		<tr>
    			<td><?php echo $k+1;?></td>
    			<td class="alignleft"><a href='<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>' target="_blank"><?php echo $v['goods_name'];?></a></td>
    			<td><?php echo $v['ordergoodsnum'];?></td>
    		</tr>
    		<?php } ?>
    	</tbody>
      </table>
  </div>
  <div class="close_float"></div>
</div>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>

<script>
$(function () {
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
    
	$('#container').highcharts(<?php echo $output['stattoday_json'];?>);
});
</script>