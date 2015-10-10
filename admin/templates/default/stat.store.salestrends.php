<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="fixed-empty"></div>

<table class="table tb-type2">
	<thead class="thead">
		<tr class="space">
			<th colspan="15"><label>“<?php echo $output['storename'];?>”走势图</label></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<!-- 下单会员数 -->
				<div id="container_membernum" class="close_float" style="height:300px"></div>
				<br>
				<!-- 下单量 -->
				<div id="container_ordernum" class="close_float" style="height:300px"></div>
				<br>
				<!-- 下单金额 -->
				<div id="container_orderamount" class="close_float" style="height:300px"></div>
			</td>
		</tr>
</tbody>
</table>
<script>
$(function () {
	$('#container_membernum').highcharts(<?php echo $output['stat_json']['membernum'];?>);
	$('#container_ordernum').highcharts(<?php echo $output['stat_json']['ordernum'];?>);
	$('#container_orderamount').highcharts(<?php echo $output['stat_json']['orderamount'];?>);
});
</script>