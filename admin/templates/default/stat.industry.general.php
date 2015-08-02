<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_statindustry'];?></h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="stat_industry" />
    <input type="hidden" name="op" value="general" />
    <div class="w100pre" style="width: 100%;">
        <table class="tb-type1 noborder search left">
          <tbody>
            <tr>
              <td id="searchgc_td"></td>
              <input type="hidden" id="choose_gcid" name="choose_gcid" value="0"/>
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
        	<li><?php echo $lang['stat_validorder_explain'];?></li>
            <li>列表展示了搜索类目下子分类的商品数和从昨天开始最近30天该子分类有效订单的销售数据，并可以点击列表上方的“导出Excel”将列表数据导出为Excel文件</li>
            <li>点击每列旁边的箭头对列表进行排序，默认按照“销售额”降序排列</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  
  <div id="statlist" class="w100pre close_float ui-tabs"></div>
  
  <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
</div>
<script>
$(function () {
    $('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
	//商品分类
	init_gcselect(<?php echo $output['gc_choose_json'];?>,<?php echo $output['gc_json']?>);

	//加载统计列表
	var choose_gcid = $("#choose_gcid").val();
    $('#statlist').load('index.php?act=stat_industry&op=general_list&choose_gcid='+choose_gcid);
});
</script>