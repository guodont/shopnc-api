<?php defined('InShopNC') or exit('Access Invalid!');?>
<!-- 地图容器 -->
<div id="container_<?php echo $output['stat_field'];?>" style="height:600px; width:90%; margin: 0 auto;">
		<div class="stat-map-color">高&nbsp;&nbsp;<span style="background-color: #fd0b07;">&nbsp;</span><span style="background-color: #ff9191;">&nbsp;</span><span style="background-color: #f7ba17;">&nbsp;</span><span style="background-color: #fef406;">&nbsp;</span><span style="background-color: #25aae2;">&nbsp;</span>&nbsp;&nbsp;低
        <p>
	备注：按照排名由高到低显示：排名第1、2、3名为第一阶梯；排名第4、5、6名为第二阶梯；排名第7、8、9为第三阶梯；排名第10、11、12为第四阶梯；其余为第五阶梯。
</p></div>
	</div>

<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/map/jquery.vector-map.css"/>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/map/jquery.vector-map.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/map/china-zh.js"></script>
<script>
$(function () {
	getMap(<?php echo $output['stat_json']; ?>,'container_<?php echo $output['stat_field'];?>');
});
</script>