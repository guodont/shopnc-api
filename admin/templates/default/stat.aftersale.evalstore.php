<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>售后分析</h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="stat_aftersale" />
    <input type="hidden" name="op" value="evalstore" />
    <input type="hidden" id="exporttype" name="exporttype" value=""/>
    <input type="hidden" id="orderby" name="orderby" value="<?php echo $output['orderby']?$output['orderby']:'avgdesccredit desc';?>"/>
    <div class="w100pre" style="width: 100%;">
        <table class="tb-type1 noborder search left">
          <tbody>
            <tr>
              <td id="scategory">
                <select class="querySelect" name="store_class">
                  <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
                  <?php if(is_array($output['class_list'])){ ?>
                  <?php foreach($output['class_list'] as $k => $v){ ?>
                  <option <?php if(intval($_GET['store_class']) == $v['sc_id']){ ?>selected="selected"<?php } ?> value="<?php echo $v['sc_id']; ?>"><?php echo $v['sc_name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td>
              	店铺名称<input type="text" name="storename" value="<?php echo $output['search_arr']['storename'];?>"/>
              </td>
              <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
            </tr>
          </tbody>
        </table>
    </div>
  </form>
  
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li>统计列表为符合条件店铺的动态评分信息列表，并可以点击列表上方的“导出Excel”将列表数据导出为Excel文件</li>
            <li>点击每列旁边的箭头对列表进行排序，默认按照“描述相符度”降序排列</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  
  <div class="w100pre close_float" style="text-align:right;">
  	<a class="btns" href="javascript:void(0);" id="export_btn"><span>导出Excel</span></a>
  </div>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead sortbar-array">
        <th class="align-center">店铺名称</th>
        <th class="align-center"><a href="javascript:void(0);" nc_type="orderitem" data-param='{"orderby":"avgdesccredit"}' class="<?php echo (!$output['orderby'] || $output['orderby']=='avgdesccredit desc')?'selected desc':''; echo $output['orderby']=='avgdesccredit asc'?'selected asc':''; ?>">描述相符度<i></i></a></th>
        <th class="align-center"><a href="javascript:void(0);" nc_type="orderitem" data-param='{"orderby":"avgservicecredit"}' class="<?php echo ($output['orderby']=='avgservicecredit desc')?'selected desc':''; echo $output['orderby']=='avgservicecredit asc'?'selected asc':''; ?>">服务态度<i></i></a></th>
        <th class="align-center"><a href="javascript:void(0);" nc_type="orderitem" data-param='{"orderby":"avgdeliverycredit"}' class="<?php echo ($output['orderby']=='avgdeliverycredit desc')?'selected desc':''; echo $output['orderby']=='avgdeliverycredit asc'?'selected asc':''; ?>">发货速度<i></i></a></th>
      </tr>
    </thead>
    <tbody id="datatable">
    <?php if(!empty($output['statlist'])){ ?>
        <?php foreach ((array)$output['statlist'] as $k=>$v){?>
          <tr class="hover">
            <td class="align-center"><?php echo $v['seval_storename'];?></td>
            <td class="align-center"><?php echo $v['avgdesccredit'];?></td>
            <td class="align-center"><?php echo $v['avgservicecredit'];?></td>
            <td class="align-center"><?php echo $v['avgdeliverycredit'];?></td>
          </tr>
        <?php } ?>
    <?php } else { ?>
        <tr class="no_data">
        	<td colspan="4"><?php echo $lang['no_record']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
    <?php if(!empty($output['statlist']) && is_array($output['statlist'])){ ?>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<script>
$(function () {
	$('#ncsubmit').click(function(){
		$("#exporttype").val('');
    	$('#formSearch').submit();
    });

	//导出图表
    $("#export_btn").click(function(){
    	$("#exporttype").val('excel');
    	$('#formSearch').submit();
    });

    $("[nc_type='orderitem']").click(function(){
    	$("#exporttype").val('');
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
</script>