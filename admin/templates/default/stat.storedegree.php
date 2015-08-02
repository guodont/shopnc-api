<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>店铺统计</h3>
      <?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>  
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="stat_store" />
    <input type="hidden" name="op" value="degree" />
    <input type="hidden" name="" value="" />
    <div class="w100pre" style="width: 100%;">
        <table class="tb-type1 noborder search left">
          <tbody>
            <tr>
            	<td>
              	<select name="search_sclass" id="search_sclass" class="querySelect">
              		<option value="" selected >店铺分类</option>
              	    <?php foreach ($output['store_class'] as $k=>$v){ ?>
              		<option value="<?php echo $v['sc_id'];?>" <?php echo $_REQUEST['search_sclass'] == $v['sc_id']?'selected':''; ?>><?php echo $v['sc_name'];?></option>
              		<?php } ?>
                </select></td>
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
            <li>统计图展示各店铺分类中店铺等级的分布情况</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  
  <table class="table tb-type2 nobdb">
  	<tbody id="datatable">
  	<?php if ($output['stat_json']){ ?>
      <tr class="hover">
        <td class="align-center"><div id="container" class="w100pre close_float" style="height:400px"></div></td>
      </tr>
     <?php } else {?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
     <?php } ?>
    </tbody>
  </table>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
</div>
<script>
$(function(){
	<?php if ($output['stat_json']){ ?>
	$('#container').highcharts(<?php echo $output['stat_json']; ?>);
	<?php } ?>
	
	$('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
})
</script>