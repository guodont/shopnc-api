<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_point.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_login.css" rel="stylesheet" type="text/css">
<div class="ncp-container">
  <?php if ($_SESSION['is_login'] == '1'){ ?>
  <div class="ncp-member-top">
    <?php include_once BASE_TPL_PATH.'/home/pointshop.minfo.php'; ?>
  </div>
  <?php } ?>
  <div class="ncp-main-layout">
    <div class="ncp-category">
      <dl class="searchbox">
        <dt>排序方式：</dt>
        <dd><!-- 高级搜索start -->
          <ul>
            <input type="hidden" id="orderby" name="orderby" value="<?php echo $_GET['orderby']?$_GET['orderby']:'default';?>"/>
            
            <!-- 默认排序s -->
            <?php if (!$_GET['orderby'] || $_GET['orderby'] == 'default'){ ?>
            <li class="selected">默认排序</li>
            <?php } else { ?>
            <li nc_type="search_orderby" data-param='{"orderval":"default"}' style="cursor: pointer;">默认排序</li>
            <?php }?>
            <!-- 默认排序e --> 
            
            <!-- 积分值s -->
            <?php if ($_GET['orderby'] == 'pointsdesc'){//降序选中 ?>
            <li class="selected" nc_type="search_orderby" data-param='{"orderval":"pointsasc"}'>积分值<em class="desc"></em></li>
            <?php } elseif ($_GET['orderby'] == 'pointsasc') {//升序选中 ?>
            <li class="selected" nc_type="search_orderby" data-param='{"orderval":"pointsdesc"}'>积分值<em class="asc"></em></li>
            <?php } else {//未选中?>
            <li nc_type="search_orderby" data-param='{"orderval":"pointsdesc"}'>积分值<em class="desc"></em></li>
            <?php } ?>
            <!-- 积分值e --> 
            
            <!-- 上架时间s -->
            <?php if ($_GET['orderby'] == 'stimedesc'){//降序选中 ?>
            <li class="selected" nc_type="search_orderby" data-param='{"orderval":"stimeasc"}'>上架时间<em class="desc"></em></li>
            <?php } elseif ($_GET['orderby'] == 'stimeasc') {//升序选中 ?>
            <li class="selected" nc_type="search_orderby" data-param='{"orderval":"stimedesc"}'>上架时间<em class="asc"></em></li>
            <?php } else {//未选中?>
            <li nc_type="search_orderby" data-param='{"orderval":"stimedesc"}'>上架时间<em class="desc"></em></li>
            <?php } ?>
            <!-- 上架时间e --> 
            <li>&nbsp;</li>
            <!-- 会员等级s -->
            <li>会员等级：
              <select id="level" onchange="javascript:searchpointprod();">
                <option value='' selected >-请选择-</option>
                <?php if (!empty($output['membergrade_arr'])){ ?>
                <?php foreach ($output['membergrade_arr'] as $k=>$v){ ?>
                <option value="<?php echo $v['level'];?>" <?php echo (isset($_GET['level']) && ($_GET['level'] == $v['level']))?'selected':'';?>>V<?php echo $v['level'];?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </li>
            <!-- 会员等级e --> 
            <li>&nbsp;</li>
            <!-- 所需积分s -->
            <li>所需积分：
              <input type="text" id="points_min" class="text w50" value="<?php echo $_GET['points_min'];?>"/>
              ~
              <input type="text" id="points_max" class="text w50" value="<?php echo $_GET['points_max'];?>" />
              <a href="javascript:searchpointprod();" class="ncp-btn">搜索</a> </li>
            <!-- 所需积分e -->
            <li>&nbsp;</li>
            <?php if($_SESSION['is_login'] == '1'){ ?>
            <li>
              <label for="isable"><input type="checkbox" id="isable" <?php echo intval($_GET['isable'])==1?'checked="checked"':'';?> onclick="javascript:searchpointprod();">
              &nbsp;只看我能兑换</label></li>
            <?php } ?>
          </ul>
          <!-- 高级搜索end --> </dd>
      </dl>
    </div>
    <?php if (is_array($output['pointprod_list']) && count($output['pointprod_list'])){?>
    <ul class="ncp-exchange-list">
      <?php foreach ($output['pointprod_list'] as $v){?>
      <li>
        <div class="gift-pic"><a href="<?php echo urlShop('pointprod', 'pinfo', array('id' => $v['pgoods_id']));?>"  > <img src="<?php echo $v['pgoods_image'] ?>" title="<?php echo $v['pgoods_name']; ?>" alt="<?php echo $v['pgoods_name']; ?>"></a></div>
        <div class="gift-name"><a href="<?php echo urlShop('pointprod', 'pinfo', array('id' => $v['pgoods_id']));?>" ><?php echo $v['pgoods_name']; ?></a></div>
        <div class="exchange-rule">
          <?php if (intval($v['pgoods_limitmgrade']) > 0){ ?>
          <span class="pgoods-grade">V<?php echo intval($v['pgoods_limitmgrade']); ?></span>
          <?php } ?>
          <span class="pgoods-price"><?php echo $lang['pointprod_goodsprice'].$lang['nc_colon']; ?><em><?php echo $lang['currency'].$v['pgoods_price']; ?></em></span> <span class="pgoods-points"><?php echo $lang['pointprod_pointsname'].$lang['nc_colon'];?><strong><?php echo $v['pgoods_points']; ?></strong><?php echo $lang['points_unit']; ?></span> </div>
      </li>
      <?php } ?>
    </ul>
    <div class="tc mt20 mb20">
      <div class="pagination"><?php echo $output['show_page'];?></div>
    </div>
    <?php }else{?>
    <div class="norecord"><?php echo $lang['pointprod_list_null'];?></div>
    <?php }?>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/home.js" id="dialog_js" charset="utf-8"></script> 
<script>
$(function () {
	$("[nc_type='search_orderby']").click(function(){
		var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
	    $("#orderby").val(data_str.orderval);
	    searchpointprod();
	});
});
function searchpointprod(){
	var url = 'index.php?act=pointprod&op=index';
	var orderby = $("#orderby").val();
	if(orderby){
		url += ('&orderby='+orderby);
	}
	var level = $("#level").val();
	if(level){
		url += ('&level='+level);
	}
	var points_min = $("#points_min").val();
	if(points_min){
		url += ('&points_min='+points_min);
	}
	var points_max = $("#points_max").val();
	if(points_max){
		url += ('&points_max='+points_max);
	}
	if($("#isable").attr("checked") == 'checked'){
		url += '&isable=1';
	}
	go(url);
}
</script>