<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tr p10">
	<input type="hidden" id="export_type" name="export_type" data-param='{"url":"<?php echo $output['actionurl'];?>&orderby=<?php echo $output['orderby'];?>&exporttype=excel"}' value="excel"/>
	<a class="ncsc-btn-mini" id="export_btn" href="javascript:void(0);" title="导出Excel">导出Excel</a>
</div>
<input type="hidden" id="orderby" name="orderby" value="<?php echo $output['orderby']; ?>"/>

<table class="ncsc-default-table">
  <thead>
    <tr class="sortbar-array">
    <?php foreach((array)$output['statheader'] as $k=>$v){?>
    <?php if($v['isorder'] == 1){?>
    <!-- <th class="<?php echo $v['class']?$v['class']:'align-center';?>"> -->
    <th class="align-center">
    	<?php if($output['orderby'] == $v['key'].' desc'){?>
    	<a nc_type="orderitem" href="<?php echo $output['actionurl'];?>&orderby=<?php echo $v['key'].' asc';?>" class="selected desc"><?php echo $v['text'];?><i></i></a></th>
    	<?php } elseif ($output['orderby'] == $v['key'].' asc'){?>
    	<a nc_type="orderitem" href="<?php echo $output['actionurl'];?>&orderby=<?php echo $v['key'].' desc';?>" class="selected asc"><?php echo $v['text'];?><i></i></a></th>
    	<?php } else {?>
    	<a nc_type="orderitem" href="<?php echo $output['actionurl'];?>&orderby=<?php echo $v['key'].' desc';?>"><?php echo $v['text'];?><i></i></a></th>
    	<?php }?>
    <?php } else {?>
    <th class="align-center"><?php echo $v['text'];?></th>
    <?php }?>
    <?php }?>
    </tr>
  </thead>
  <tbody id="datatable">
    <?php if(!empty($output['statlist'])){ ?>
    <?php foreach ((array)$output['statlist'] as $k=>$v){?>
    <tr class="bd-line">
  	    <?php foreach((array)$output['statheader'] as $h_k=>$h_v){?>
  		<td class="<?php echo $h_v['class']?$h_v['class']:'align-center';?>"><?php echo $v[$h_v['key']];?></td>
  	    <?php }?>
  	</tr>
    <?php }?>
    <?php } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
  <?php if (!empty($output['statlist']) && is_array($output['statlist'])) { ?>
  <tfoot>    
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
  </tfoot>
  <?php } ?>
</table>
<script type="text/javascript">
$(document).ready(function(){
	$('#statlist').find('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/transparent.gif",
		target:'#statlist'
	});
	$("[nc_type='orderitem']").ajaxContent({
		event:'click',
		loaderType:"img",
		loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/transparent.gif",
		target:'#statlist'
	});
    
	//导出图表
    $("#export_btn").click(function(){
        var item = $("#export_type");
        var type = $(item).val();
        if(type == 'excel'){
        	download_excel(item);
        }
    });
});
</script>