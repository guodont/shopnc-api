<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="alert mt10" style="clear:both;">
	<ul class="mt5">
		<li>1、<?php echo $lang['stat_validorder_explain'];?></li>
        <li>2、以下关于订单和订单商品近30天统计数据的依据为：从昨天开始最近30天的有效订单</li>
    </ul>
</div>
<div class="alert alert-info mt10" style="clear:both;">
    <ul class="mt5">
    <li>
    	<span class="w210 fl h30" style="display:block;">
    		<i title="店铺从昨天开始最近30天有效订单的总金额" class="tip icon-question-sign"></i>
    		近30天下单金额：<strong><?php echo $output['statnew_arr']['orderamount'].$lang['currency_zh'];?></strong>
    	</span>
		<span class="w210 fl h30" style="display:block;">
			<i title="店铺从昨天开始最近30天有效订单的会员总数" class="tip icon-question-sign"></i>
			近30天下单会员数：<strong><?php echo $output['statnew_arr']['ordermembernum'];?></strong>
		</span>
		<span class="w210 fl h30" style="display:block;">
			<i title="店铺从昨天开始最近30天有效订单的总订单数" class="tip icon-question-sign"></i>
			近30天下单量：<strong><?php echo $output['statnew_arr']['ordernum'];?></strong>
		</span>
		<span class="w210 fl h30" style="display:block;">
			<i title="店铺从昨天开始最近30天有效订单的总商品数量" class="tip icon-question-sign"></i>
			近30天下单商品数：<strong><?php echo $output['statnew_arr']['ordergoodsnum'];?></strong>
		</span>
    </li>
    <li>
    	<span class="w210 fl h30" style="display:block;">
    		<i title="店铺从昨天开始最近30天有效订单的平均每个订单的交易金额" class="tip icon-question-sign"></i>
    		平均客单价：<strong><?php echo $output['statnew_arr']['avgorderamount'].$lang['currency_zh'];?></strong>
    	</span>
    	<span class="w210 fl h30" style="display:block;">
    		<i title="店铺从昨天开始最近30天有效订单商品的平均每个商品的成交价格" class="tip icon-question-sign"></i>
    		平均价格：<strong><?php echo $output['statnew_arr']['avggoodsprice'].$lang['currency_zh'];?></strong>
    	</span>
    	<span class="w210 fl h30" style="display:block;">
    		<i title="店铺所有商品的总收藏次数" class="tip icon-question-sign"></i>
    		商品收藏量：<strong><?php echo $output['statnew_arr']['gcollectnum'];?></strong>
    	</span>
    	<span class="w210 fl h30" style="display:block;">
    		<i title="店铺拥有商品的总数（仅计算商品种类，不统计库存）" class="tip icon-question-sign"></i>
    		商品总数：<strong><?php echo $output['statnew_arr']['goodsnum'];?></strong>
    	</span>
    </li>
    <li>
    	<span class="w210 fl h30" style="display:block;">
    		<i title="店铺总收藏次数" class="tip icon-question-sign"></i>
    		店铺收藏量：<strong><?php echo $output['statnew_arr']['store_collect'];?></strong>
    	</span>
    	<span class="w400 fl h30" style="display:block;">
    		<i title="店铺从昨天开始最近30天有效订单的下单频繁的时间点" class="tip icon-question-sign"></i>
    		下单高峰期：<strong><?php echo ($t = $output['statnew_arr']['hothour'])?$t:'暂无';?></strong>
    	</span>
    </li>
  </ul>
  <div style="clear:both;"></div>
</div>

<div id="container"></div>

<div class="w450 fl mr50">
	<div class="alert alert-info" style="margin-bottom:0px;"><strong>建议推广商品</strong>
		&nbsp;<i title="统计店铺从昨天开始7日内热销商品前30名，建议推广以下商品，提升推广回报率" class="tip icon-question-sign"></i>
	</div>
    <table class="ncsc-default-table">
      <thead>
        <tr class="sortbar-array">
        	<th class="align-center">序号</th>
        	<th class="align-center">商品名称</th>
        	<th class="align-center">销量</th>
        </tr>
      </thead>
      <tbody id="datatable">
      	<?php if (!empty($output['goodstop30_arr']) && is_array($output['goodstop30_arr'])) { ?>
            <?php foreach($output['goodstop30_arr'] as $k=>$v) { ?>
            <tr class="bd-line">
            	<td class="w50"><?php echo $k+1;?></td>
            	<td class="tl">
            		<span class="over_hidden w340 h20">
            			<a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>" target="_blank"><?php echo $v['goods_name'];?></a>
            		</span>
            	</td>
            	<td class="w50"><?php echo $v['ordergoodsnum'];?></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
        <tr>
        	<td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
<div class="w450 fl">
	<div class="alert alert-info" style="margin-bottom:0px;"><strong>同行热卖</strong>
		&nbsp;<i title="拥有相同经营类目同行店铺热销商品推荐，了解行业热卖便于调整商品结构" class="tip icon-question-sign"></i>
	</div>
    <table class="ncsc-default-table">
      <thead>
        <tr class="sortbar-array">
        	<th class="align-center">序号</th>
        	<th class="align-center">商品名称</th>
        	<th class="align-center">销量</th>
        </tr>
      </thead>
      <tbody id="datatable">
      	<?php if (!empty($output['othergoodstop30_arr']) && is_array($output['othergoodstop30_arr'])) { ?>
            <?php foreach($output['othergoodstop30_arr'] as $k=>$v) { ?>
            <tr class="bd-line">
            	<td class="w50"><?php echo $k+1;?></td>
            	<td class="tl">
            		<span class="over_hidden w340 h20">
            			<a href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>" target="_blank"><?php echo $v['goods_name'];?></a>
            		</span>
            	</td>
            	<td class="w50"><?php echo $v['ordergoodsnum'];?></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
        <tr>
        	<td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>
<div class="h30 cb">&nbsp;</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
 
<script>
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
    
	$('#container').highcharts(<?php echo $output['stattoday_json'];?>);
});
</script>
