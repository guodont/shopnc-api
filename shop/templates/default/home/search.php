<?php defined('InShopNC') or exit('Access Invalid!');?>
<script src="<?php echo SHOP_RESOURCE_SITE_URL.'/js/search_goods.js';?>"></script>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/layout.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
_behavior: url(<?php echo SHOP_TEMPLATES_URL;
?>/css/csshover.htc);
}
</style>
<div class="nch-container wrapper" >
  <div class="left">
    <?php if (!empty($output['goods_class_array'])) {?>
    <div class="nch-module nch-module-style02">
      <div class="title">
        <h3>分类筛选</h3>
      </div>
      <div class="content">
        <ul id="files" class="tree">
          <?php foreach ($output['goods_class_array'] as $value) {?>
          <li><i class="tree-parent tree-parent-collapsed"></i><a href="<?php echo urlShop('search', 'index', array('cate_id' => $value['gc_id'], 'keyword' => $_GET['keyword']));?>" <?php if ($value['gc_id'] == $_GET['cate_id']) {?>class="selected"<?php }?>><?php echo $value['gc_name']?></a>
            <?php if (!empty($value['class2'])) {?>
            <ul>
              <?php foreach ($value['class2'] as $val) {?>
              <li><i class="tree-parent tree-parent-collapsed"></i><a href="<?php echo urlShop('search', 'index', array('cate_id' => $val['gc_id'], 'keyword' => $_GET['keyword']));?>" <?php if ($val['gc_id'] == $_GET['cate_id']) {?>class="selected"<?php }?>><?php echo $val['gc_name']?></a>
                <?php if (!empty($val['class3'])) {?>
                <ul>
                  <?php foreach ($val['class3'] as $v) {?>
                  <li class="tree-parent tree-parent-collapsed"><i></i><a href="<?php echo urlShop('search', 'index', array('cate_id' => $v['gc_id'], 'keyword' => $_GET['keyword']));?>" <?php if ($v['gc_id'] == $_GET['cate_id']) {?>class="selected"<?php }?>><?php echo $v['gc_name']?></a></li>
                  <?php }?>
                </ul>
                <?php }?>
              </li>
              <?php }?>
            </ul>
            <?php }?>
          </li>
          <?php }?>
        </ul>
      </div>
    </div>
    <?php }?>
    <!-- S 推荐展位 -->
    <div nctype="booth_goods" class="nch-module" style="display:none;"> </div>
    <!-- E 推荐展位 -->
    <div class="nch-module"><?php echo loadadv(37,'html');?></div>
    <!-- 最近浏览 -->

    <div class="nch-module nch-module-style03">
      <div class="title">
        <h3><?php echo $lang['goods_class_viewed_goods']; ?></h3>
      </div>
      <div class="content">
        <div class="nch-sidebar-viewed" id="nchSidebarViewed">
          <ul>
            <?php if(!empty($output['viewed_goods']) && is_array($output['viewed_goods'])){?><?php foreach ($output['viewed_goods'] as $k=>$v){?>
            <li class="nch-sidebar-bowers">
              <div class="goods-pic"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id'])); ?>" target="_blank"><img src="<?php echo thumb($v, 60); ?>" title="<?php echo $v['goods_name']; ?>" alt="<?php echo $v['goods_name']; ?>" ></a></div>
              <dl>
                <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$v['goods_id'])); ?>" target="_blank"><?php echo $v['goods_name']; ?></a></dt>
                <dd><?php echo $lang['currency'];?><?php echo $v['goods_promotion_price']; ?></dd>
              </dl>
            </li>
            <?php } ?><?php } ?>
          </ul>
        </div>
        <a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_goodsbrowse&op=list" class="nch-sidebar-all-viewed">全部浏览历史</a></div>
    </div>

  </div>
  <div class="right">
    <?php if(!isset($output['goods_class_array']['child']) && empty($output['goods_class_array']['child']) && !empty($output['goods_class_array'])){?>
    <?php $dl=1;  //dl标记?>
    <?php if((!empty($output['brand_array']) && is_array($output['brand_array'])) || (!empty($output['attr_array']) && is_array($output['attr_array']))){?>
    <div class="nch-module nch-module-style01">
      <div class="title">
        <h3>
          <?php if (!empty($output['show_keyword'])) {?>
          <em><?php echo $output['show_keyword'];?></em> -
          <?php }?>
          商品筛选</h3>
      </div>
      <div class="content">
        <div class="nch-module-filter">
          <?php if((isset($output['checked_brand']) && is_array($output['checked_brand'])) || (isset($output['checked_attr']) && is_array($output['checked_attr']))){?>
          <dl nc_type="ul_filter">
            <dt><?php echo $lang['goods_class_index_selected'].$lang['nc_colon'];?></dt>
            <dd class="list">
              <?php if(isset($output['checked_brand']) && is_array($output['checked_brand'])){?>
              <?php foreach ($output['checked_brand'] as $key=>$val){?>
              <span class="selected" nctype="span_filter"><?php echo $lang['goods_class_index_brand'];?>:<em><?php echo $val['brand_name']?></em><i data-uri="<?php echo removeParam(array('b_id' => $key));?>">X</i></span>
              <?php }?>
              <?php }?>
              <?php if(isset($output['checked_attr']) && is_array($output['checked_attr'])){?>
              <?php foreach ($output['checked_attr'] as $val){?>
              <span class="selected" nctype="span_filter"><?php echo $val['attr_name'].':<em>'.$val['attr_value_name'].'</em>'?><i data-uri="<?php echo removeParam(array('a_id' => $val['attr_value_id']));?>">X</i></span>
              <?php }?>
              <?php }?>
            </dd>
          </dl>
          <?php }?>
          <?php if (!isset($output['checked_brand']) || empty($output['checked_brand'])){?>
          <?php if(!empty($output['brand_array']) && is_array($output['brand_array'])){?>
          <dl <?php if($dl>3){?>class="dl_hide"<?php }?>>
            <dt><?php echo $lang['goods_class_index_brand'].$lang['nc_colon'];?></dt>
            <dd class="list">
              <ul>
                <?php $i = 0;foreach ($output['brand_array'] as $k=>$v){$i++;?>
                <li <?php if ($i>10){?>style="display:none" nc_type="none"<?php }?>><a href="<?php $b_id = (($_GET['b_id'] != '' && intval($_GET['b_id']) != 0)?$_GET['b_id'].'_'.$k:$k); echo replaceParam(array('b_id' => $b_id));?>"><?php echo $v['brand_name'];?></a></li>
                <?php }?>
              </ul>
            </dd>
            <?php if (count($output['brand_array']) > 10){?>
            <dd class="all"><span nc_type="show"><i class="icon-angle-down"></i><?php echo $lang['goods_class_index_more'];?></span></dd>
            <?php }?>
          </dl>
          <?php $dl++;}?>
          <?php }?>
          <?php if(!empty($output['attr_array']) && is_array($output['attr_array'])){?>
          <?php $j = 0;foreach ($output['attr_array'] as $key=>$val){$j++;?>
          <?php if(!isset($output['checked_attr'][$key]) && !empty($val['value']) && is_array($val['value'])){?>
          <dl>
            <dt><?php echo $val['name'].$lang['nc_colon'];?></dt>
            <dd class="list">
              <ul>
                <?php $i = 0;foreach ($val['value'] as $k=>$v){$i++;?>
                <li <?php if ($i>10){?>style="display:none" nc_type="none"<?php }?>><a href="<?php $a_id = (($_GET['a_id'] != '' && $_GET['a_id'] != 0)?$_GET['a_id'].'_'.$k:$k); echo replaceParam(array('a_id' => $a_id));?>"><?php echo $v['attr_value_name'];?></a></li>
                <?php }?>
              </ul>
            </dd>
            <?php if (count($val['value']) > 10){?>
            <dd class="all"><span nc_type="show"><i class="icon-angle-down"></i><?php echo $lang['goods_class_index_more'];?></span></dd>
            <?php }?>
          </dl>
          <?php }?>
          <?php $dl++;} ?>
          <?php }?>
        </div>
      </div>
    </div>
    <?php }?>
    <?php }?>
    <div class="shop_con_list" id="main-nav-holder">
      <nav class="sort-bar" id="main-nav">
        <div class="pagination"><?php echo $output['show_page1']; ?> </div>
        <div class="nch-all-category">
          <div class="all-category">
            <?php require template('layout/home_goods_class');?>
          </div>
        </div>
        <div class="nch-sortbar-array"> 排序方式：
          <ul>
            <li <?php if(!$_GET['key']){?>class="selected"<?php }?>><a href="<?php echo dropParam(array('order', 'key'));?>"  title="<?php echo $lang['goods_class_index_default_sort'];?>"><?php echo $lang['goods_class_index_default'];?></a></li>
            <li <?php if($_GET['key'] == '1'){?>class="selected"<?php }?>><a href="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '1') ? replaceParam(array('key' => '1', 'order' => '1')):replaceParam(array('key' => '1', 'order' => '2')); ?>" <?php if($_GET['key'] == '1'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> title="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '1')?$lang['goods_class_index_sold_asc']:$lang['goods_class_index_sold_desc']; ?>"><?php echo $lang['goods_class_index_sold'];?><i></i></a></li>
            <li <?php if($_GET['key'] == '2'){?>class="selected"<?php }?>><a href="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '2') ? replaceParam(array('key' => '2', 'order' => '1')):replaceParam(array('key' => '2', 'order' => '2')); ?>" <?php if($_GET['key'] == '2'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> title="<?php  echo ($_GET['order'] == '2' && $_GET['key'] == '2')?$lang['goods_class_index_click_asc']:$lang['goods_class_index_click_desc']; ?>"><?php echo $lang['goods_class_index_click']?><i></i></a></li>
            <li <?php if($_GET['key'] == '3'){?>class="selected"<?php }?>><a href="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '3') ? replaceParam(array('key' => '3', 'order' => '1')):replaceParam(array('key' => '3', 'order' => '2')); ?>" <?php if($_GET['key'] == '3'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> title="<?php echo ($_GET['order'] == '2' && $_GET['key'] == '3')?$lang['goods_class_index_price_asc']:$lang['goods_class_index_price_desc']; ?>"><?php echo $lang['goods_class_index_price'];?><i></i></a></li>
          </ul>
        </div>
        <div class="nch-sortbar-owner"><span><a href="<?php if ($_GET['type'] == 1) { echo dropParam(array('type'));} else { echo replaceParam(array('type' => '1'));}?>" <?php if ($_GET['type'] == 1) {?>class="selected"<?php }?>><i></i>平台自营</a></span></div>
        <div class="nch-sortbar-owner"><span><a href="<?php if ($_GET['gift'] == 1) { echo dropParam(array('gift'));} else { echo replaceParam(array('gift' => '1'));}?>" <?php if ($_GET['gift'] == 1) {?>class="selected"<?php }?>><i></i>赠品</a></span></div>
        <div class="nch-sortbar-location">商品所在地：
          <div class="select-layer">
            <div class="holder"><em nc_type="area_name"><?php echo $lang['goods_class_index_area']; ?><!-- 所在地 --></em></div>
            <div class="selected"><a nc_type="area_name"><?php echo $lang['goods_class_index_area']; ?><!-- 所在地 --></a></div>
            <i class="direction"></i>
            <ul class="options">
              <?php require(BASE_TPL_PATH.'/home/goods_class_area.php');?>
            </ul>
          </div>
        </div>
      </nav>
      <!-- 商品列表循环  -->

      <div>
        <?php require_once (BASE_TPL_PATH.'/home/goods.squares.php');?>
      </div>
      <div class="tc mt20 mb20">
        <div class="pagination"> <?php echo $output['show_page']; ?> </div>
      </div>
    </div>

    <!-- 猜你喜欢 -->
    <div id="guesslike_div" style="width:980px;"></div>
  </div>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/search_category_menu.js"></script>
<script type="text/javascript">
var defaultSmallGoodsImage = '<?php echo defaultGoodsImage(240);?>';
var defaultTinyGoodsImage = '<?php echo defaultGoodsImage(60);?>';

$(function(){
    $('#files').tree({
        expanded: 'li:lt(2)'
    });

    //浮动导航  waypoints.js
    $('#main-nav-holder').waypoint(function(event, direction) {
        $(this).parent().toggleClass('sticky', direction === "down");
        event.stopPropagation();
    });
	// 单行显示更多
	$('span[nc_type="show"]').click(function(){
		s = $(this).parents('dd').prev().find('li[nc_type="none"]');
		if(s.css('display') == 'none'){
			s.show();
			$(this).html('<i class="icon-angle-up"></i><?php echo $lang['goods_class_index_retract'];?>');
		}else{
			s.hide();
			$(this).html('<i class="icon-angle-down"></i><?php echo $lang['goods_class_index_more'];?>');
		}
	});

	<?php if(isset($_GET['area_id']) && intval($_GET['area_id']) > 0){?>
  // 选择地区后的地区显示
  $('[nc_type="area_name"]').html('<?php echo $output['province_array'][intval($_GET['area_id'])]; ?>');
	<?php }?>

	<?php if(isset($_GET['cate_id']) && intval($_GET['cate_id']) > 0){?>
	// 推荐商品异步显示
    $('div[nctype="booth_goods"]').load('<?php echo urlShop('search', 'get_booth_goods', array('cate_id' => $_GET['cate_id']))?>', function(){
        $(this).show();
    });
	<?php }?>
	//浏览历史处滚条
	$('#nchSidebarViewed').perfectScrollbar();

	//猜你喜欢
	$('#guesslike_div').load('<?php echo urlShop('search', 'get_guesslike', array()); ?>', function(){
        $(this).show();
    });
});
</script>
