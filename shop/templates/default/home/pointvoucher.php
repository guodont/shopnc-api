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
      <dl>
        <dt>选择分类：</dt>
        <dd>
          <ul>
            <input type="hidden" id="sc_id" value="<?php echo intval($_GET['sc_id'])>0?intval($_GET['sc_id']):'';?>"/>
            <li><a class="<?php echo intval($_GET['sc_id']) <= 0?'selected':'';?>" href="javascript:void(0);" nc_type="search_cate" data-param='{"sc_id":""}'>所有分类</a></li>
            <?php foreach ($output['store_class'] as $k=>$v){?>
            <li><a class="<?php echo intval($_GET['sc_id']) == $v['sc_id']?'selected':'';?>" href="javascript:void(0);" nc_type="search_cate" data-param='{"sc_id":"<?php echo $v['sc_id'];?>"}'><?php echo $v['sc_name'];?></a></li>
            <?php } ?>
          </ul>
        </dd>
      </dl>

      <!-- 高级搜索start -->
      <dl class="searchbox">
        <dt>排序方式：</dt>
        <dd>
          <ul>
            <input type="hidden" id="orderby" name="orderby" value="<?php echo $_GET['orderby']?$_GET['orderby']:'default';?>"/>
            <!-- 默认排序s -->
            <?php if (!$_GET['orderby'] || $_GET['orderby'] == 'default'){ ?>
            <li class="selected">默认排序</li>
            <?php } else { ?>
            <li nc_type="search_orderby" data-param='{"orderval":"default"}'>默认排序</li>
            <?php }?>
            <!-- 默认排序e -->

            <!-- 兑换量s -->
            <?php if ($_GET['orderby'] == 'exchangenumdesc'){//降序选中 ?>
            <li class="selected" nc_type="search_orderby" data-param='{"orderval":"exchangenumasc"}'>兑换量<em class="desc"></em></li>
            <?php } elseif ($_GET['orderby'] == 'exchangenumasc') {//升序选中 ?>
            <li class="selected" nc_type="search_orderby" data-param='{"orderval":"exchangenumdesc"}'>兑换量<em class="asc"></em></li>
            <?php } else {//未选中?>
            <li nc_type="search_orderby" data-param='{"orderval":"exchangenumdesc"}'>兑换量<em class="desc"></em></li>
            <?php } ?>
            <!-- 兑换量e -->

            <!-- 积分值s -->
            <?php if ($_GET['orderby'] == 'pointsdesc'){//降序选中 ?>
            <li class="selected" nc_type="search_orderby" data-param='{"orderval":"pointsasc"}'>积分值<em class="desc"></em></li>
            <?php } elseif ($_GET['orderby'] == 'pointsasc') {//升序选中 ?>
            <li class="selected" nc_type="search_orderby" data-param='{"orderval":"pointsdesc"}'>积分值<em class="asc"></em></li>
            <?php } else {//未选中?>
            <li nc_type="search_orderby" data-param='{"orderval":"pointsdesc"}'>积分值<em class="desc"></em></li>
            <?php } ?>
            <!-- 积分值e -->
            <li>&nbsp;</li>
            <!-- 面额s -->
            <li>优惠券面额：
              <select id="price" onchange="javascript:searchvoucher();">
                <option value='' selected >-请选择-</option>
                <?php if (!empty($output['pricelist'])){ ?>
                <?php foreach ($output['pricelist'] as $k=>$v){ ?>
                <option value="<?php echo $v['voucher_price'];?>" <?php echo intval($_GET['price']) == $v['voucher_price']?'selected':'';?>><?php echo $v['voucher_price'];?><?php echo $lang['currency_zh'];?>代金券</option>
                <?php } ?>
                <?php } ?>
              </select>
            </li>
            <!-- 面额e -->
            <li>&nbsp;</li>
            <!-- 所需积分s -->
            <li>所需积分：
              <input type="text" id="points_min" class="text w50" value="<?php echo $_GET['points_min'];?>"/>
              ~
              <input type="text" id="points_max" class="text w50" value="<?php echo $_GET['points_max'];?>" />
              <a href="javascript:searchvoucher();" class="ncp-btn">搜索</a> </li>
            <!-- 所需积分e -->
            <?php if($_SESSION['is_login'] == '1'){ ?>
            <li>
              <label for="isable"><input type="checkbox" id="isable" <?php echo intval($_GET['isable'])==1?'checked="checked"':'';?> onclick="javascript:searchvoucher();">
              &nbsp;只看我能兑换 </label></li>
            <?php } ?>
          </ul>
        </dd>
      </dl>
      <!-- 高级搜索end --></div>
    <?php if (!empty($output['voucherlist'])){?>
    <ul class="ncp-voucher-list">
      <?php foreach ($output['voucherlist'] as $k=>$v){?>
      <li>
        <div class="ncp-voucher">
          <div class="cut"></div>
          <div class="info"><a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$v['voucher_t_store_id']));?>" class="store"><?php echo $v['voucher_t_storename'];?></a>
            <p class="store-classify"><?php echo $v['voucher_t_sc_name'];?></p>
            <div class="pic"><img src="<?php echo $v['voucher_t_customimg'];?>" onerror="this.src='<?php echo UPLOAD_SITE_URL.DS.defaultGoodsImage(240);?>'"/></div>
          </div>
          <dl class="value">
            <dt><?php echo $lang['currency'];?><em><?php echo $v['voucher_t_price'];?></em></dt>
            <dd>购物满<?php echo $v['voucher_t_limit'];?>元可用</dd>
            <dd class="time">有效期至<?php echo @date('Y-m-d',$v['voucher_t_end_date']);?></dd>
          </dl>
          <div class="point">
            <p class="required">需<em><?php echo $v['voucher_t_points'];?></em>积分</p>
            <p><em><?php echo $v['voucher_t_giveout'];?></em>人兑换</p>
          </div>
          <div class="button"><a target="_blank" href="###" nc_type="exchangebtn" data-param='{"vid":"<?php echo $v['voucher_t_id'];?>"}' class="ncp-btn ncp-btn-red">立即兑换</a></div>
        </div>
      </li>
      <?php }?>
    </ul>
    <div class="tc mt20 mb20">
      <div class="pagination"><?php echo $output['show_page'];?></div>
    </div>
    <?php }else{?>
    <div class="norecord"><?php echo $lang['home_voucher_list_null'];?></div>
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
	    searchvoucher();
	});
	$("[nc_type='search_cate']").click(function(){
		var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
	    $("#sc_id").val(data_str.sc_id);
	    searchvoucher();
	});
});
function searchvoucher(){
	var url = 'index.php?act=pointvoucher&op=index';
	var sc_id = $("#sc_id").val();
	if(sc_id){
		url += ('&sc_id='+sc_id);
	}
	var orderby = $("#orderby").val();
	if(orderby){
		url += ('&orderby='+orderby);
	}
	var price = $("#price").val();
	if(price){
		url += ('&price='+price);
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
