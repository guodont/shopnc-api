<?php defined('InShopNC') or exit('Access Invalid!');?>
	<div id="container_<?php echo $output['stat_field'];?>" class="w100pre close_float" style="height:400px"></div>
	
  <table class="table tb-type2 nobdb">
  	<thead class="thead">
		<tr class="space">
			<th colspan="15">热卖商品TOP50</th>
		</tr>
		<tr class="thead sortbar-array">
			<th class="align-center w18pre">序号</th>
            <th class="align-center">商品名称</th>
            <th class="align-center"><?php echo $output['sort_text'];?></th>
        </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['statlist'])){ ?>
        <?php foreach ((array)$output['statlist'] as $k=>$v){?>
          <tr class="hover">
          	<td><?php echo $v['sort'];?></td>
          	<td class="alignleft"><a href='<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>' target="_blank"><?php echo $v['goods_name'];?></a></td>
          	<td><?php echo $v[$output['stat_field']];?></td>
          </tr>
        <?php } ?>
    <?php } else {?>
        <tr class="no_data">
        	<td colspan="11"><?php echo $lang['no_record']; ?></td>
        </tr>
    <?php }?>
    </tbody>
  </table>

<script>
$(function () {
	$('#container_<?php echo $output['stat_field'];?>').highcharts(<?php echo $output['stat_json'];?>);
});
</script>