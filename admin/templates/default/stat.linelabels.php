<?php defined('InShopNC') or exit('Access Invalid!');?>
<div id="container_<?php echo $output['stattype'];?>"></div>
<script>
$(function () {
	$('#container_<?php echo $output['stattype'];?>').highcharts(<?php echo $output['stat_json'];?>);
});
</script>