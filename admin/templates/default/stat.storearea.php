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
    <input type="hidden" name="op" value="storearea" />
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
                    </select>
                </td>
              <td>
              	<input class="txt date" type="text" value="<?php echo ($t = $_GET['search_time'])?@date('Y-m-d',$t):'';?>" id="search_time" name="search_time">
              </td>
              <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
            </tr>
          </tbody>
        </table>
        <span class="right" style="margin:12px 0px 6px 4px;">
        	
        </span>
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
        	<li>统计图展示了店铺分类下到某个时间为止（默认为当前时间）开店数量在各省级地区的分布情况</li>
        	<li>统计地图将根据各个区域的开店数量统计数据等级依次显示不同的颜色</li>
        </ul></td>
      </tr>
    </tbody>
  </table>
  
	<table class="table tb-type2">
		<thead class="thead">
			<tr class="space">
				<th colspan="15">店铺所在地区分布</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<!-- 地图容器 -->
                    <div id="container_storenum" class="close_float" style="height:600px; width:90%; margin: 0 auto;">
                    	<div class="stat-map-color">高&nbsp;&nbsp;<span style="background-color: #fd0b07;">&nbsp;</span><span style="background-color: #ff9191;">&nbsp;</span><span style="background-color: #f7ba17;">&nbsp;</span><span style="background-color: #fef406;">&nbsp;</span><span style="background-color: #25aae2;">&nbsp;</span>&nbsp;&nbsp;低
                    	<p>备注：按照排名由高到低显示：排名第1、2、3名为第一阶梯；排名第4、5、6名为第二阶梯；排名第7、8、9为第三阶梯；排名第10、11、12为第四阶梯；其余为第五阶梯。</p></div>
                    </div>
				
				</td>
			</tr>
		</tbody>
	</table>
	
	<!-- 统计列表 -->
	<table class="table tb-type2">
    	<thead class="thead">
    		<tr>
    			<th class="align-center">序号</th>
    			<th class="align-center">省份</th>
    			<th class="align-center">数量</th>
    			<th class="align-center">操作</th>
    		</tr>
    	</thead>
    	<tbody>
    	<?php if(!empty($output['statlist'])){ ?>
    		<?php foreach($output['statlist'] as $k=>$v){?>
    		<tr>
    			<td class="align-center"><?php echo $v['sort'];?></td>
    			<td class="align-center"><?php echo $v['provincename'];?></td>
    			<td class="align-center"><?php echo $v['storenum'];?></td>
    			<td class="align-center"><a href="<?php echo $output['actionurl']."&provid={$v['province_id']}";?>">查看</a></td>
    		</tr>
    		<?php } ?>
    	<?php } else { ?>
        	<tr class="no_data">
            	<td colspan="3"><?php echo $lang['no_record']; ?></td>
            </tr>
    	<?php }?>
    	</tbody>
    </table>
  </div>
</div>
  <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/highcharts/highcharts.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/statistics.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/map/jquery.vector-map.css"/>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/map/jquery.vector-map.js"></script>
  <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/map/china-zh.js"></script>
  
<script>
$(function () {
	$('#search_time').datepicker({dateFormat: 'yy-mm-dd'});
	$('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
    //地图
	getMap(<?php echo $output['stat_json']; ?>,'container_storenum'); 
});
</script>