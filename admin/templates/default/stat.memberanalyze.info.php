<div style="text-align:right;">
	<input type="hidden" id="export_type_<?php echo $output['stat_field'];?>" name="export_type" data-param='{"url":"index.php?act=stat_member&op=analyzeinfo&type=<?php echo $output['stat_field'];?>&t=<?php echo $_GET['t'];?>&exporttype=excel"}' value="excel"/>
	<a class="btns" href="javascript:void(0);" nc_type="export_btn" data-param='{"type":"<?php echo $output['stat_field'];?>"}'><span>导出Excel</span></a>
</div>
<table class="table tb-type2 nobdb">
  <thead>
    <tr class="thead">
      <th>序号</th>
      <th class="align-center">会员名称</th>
      <th class="align-center"><?php echo $output['caption'];?></th>
    </tr>
  <tbody id="datatable">
  <?php if(!empty($output['memberlist']) && is_array($output['memberlist'])){ ?>
    <?php foreach($output['memberlist'] as $k => $v){ ?>
    <tr class="hover member">
      <td class="w24"><?php echo $v['number'];?></td>
      <td class="align-center"><?php echo $v['statm_membername']; ?></td>
      <td class="w150 align-center"><?php echo $v[$output['stat_field']]; ?></td>
    </tr>
    <?php } ?>
   <?php } else {?>
   <tr class="no_data">
   	<td colspan="11"><?php echo $lang['no_record']; ?></td>
   </tr>
   <?php } ?>
  </tbody>
  <?php if(!empty($output['memberlist']) && is_array($output['memberlist'])){ ?>
  <tfoot class="tfoot">
    <tr>
      <td colspan="3">
        <div class="pagination"><?php echo $output['show_page'];?></div></td>
    </tr>
  </tfoot>
  <?php } ?>
</table>
<script type="text/javascript">
$(document).ready(function(){
	$('#list_<?php echo $output['stat_field'];?>').find('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:"<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif",
		target:'#list_<?php echo $output['stat_field'];?>'
	});
	//导出图表
	$("[nc_type='export_btn']").live('click',function(){
		var data = $(this).attr('data-param');
		if(data == undefined  || data.length<=0){
			showDialog('参数错误');
			return false;
		}
		eval("data = "+data);
        var item = $("#export_type_"+data.type);
        var type = $(item).val();
        if(type == 'excel'){
        	download_excel(item);
        }
    });
});
</script>