<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if($output['stat_msg']){ ?>
	<div class="alert alert-info mt10" style="clear:both;"><?php echo $output['stat_msg'];?></div>
<?php } else {?>
<div class="alert alert-info mt10" style="clear:both;">
	<h6 class="w tc bolder">“<?php echo $output['goods_info']['goods_name'];?>”走势图</h6><br>
	<ul class="mt5">
    <li>
    	<span class="w210 fl h30" style="display:block;">
    		<i title="店铺从昨天开始最近30天有效订单的总金额" class="tip icon-question-sign"></i>
    		近30天下单金额：<strong><?php echo $output['stat_count']['ordergamount'].$lang['currency_zh'];?></strong>
    	</span>
		<span class="w210 fl h30" style="display:block;">
			<i title="店铺从昨天开始最近30天有效订单的总商品数量" class="tip icon-question-sign"></i>
			近30天下单商品数：<strong><?php echo $output['stat_count']['ordergoodsnum'];?></strong>
		</span>
		<span class="w210 fl h30" style="display:block;">
			<i title="店铺从昨天开始最近30天有效订单的总订单数" class="tip icon-question-sign"></i>
			近30天下单量：<strong><?php echo $output['stat_count']['ordernum'];?></strong>
		</span>
    </li>
    </ul>
    <div style="clear:both;"></div>
</div>

<div id="container_ordergamount"></div>
<div id="container_ordergoodsnum"></div>
<div id="container_ordernum"></div>

<script type="text/javascript">
$(function(){
	$('#container_ordergamount').highcharts(<?php echo $output['stat_json']['ordergamount'];?>);
	$('#container_ordergoodsnum').highcharts(<?php echo $output['stat_json']['ordergoodsnum'];?>);
	$('#container_ordernum').highcharts(<?php echo $output['stat_json']['ordernum'];?>);

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
});
</script>
<?php } ?>