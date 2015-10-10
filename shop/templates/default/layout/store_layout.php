<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('layout/common_layout');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/shop.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/css/shop_custom.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/store/style/<?php echo $output['store_theme'];?>/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/shop.js" charset="utf-8"></script>
<div id="header" class="ncs-header">
  <div class="ncs-header-container">
    <div class="ncs-store-info">
      <div class="basic">
        <div class="displayed"><a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$output['store_info']['store_id']));?>" title="<?php echo $output['setting_config']['site_name']; ?>"><?php echo $output['store_info']['store_name']; ?></a>
<?php if (!$output['store_info']['is_own_shop']) { ?>
          <span class="all-rate">
            <div class="rating"><span style="width: <?php echo $output['store_info']['store_credit_percent'];?>%"></span></div>
            <em><?php echo $output['store_info']['store_credit_average'];?></em>分
          </span>
<?php } ?>
        </div>
        <div class="sub">
          <div class="store-logo"><img src="<?php echo getStoreLogo($output['store_info']['store_label'],'store_logo');?>" alt="<?php echo $output['store_info']['store_name'];?>" title="<?php echo $output['store_info']['store_name'];?>" /></div>
          <?php include template('store/info');?>
        </div>
      </div>
      <div class="service">
        <div class="displayed"><i></i>在线客服
          <div class="sub">
            <?php include template('store/callcenter');?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    <div id="store_decoration_content" class="background" style="<?php echo $output['decoration_background_style'];?>">
<?php if(!empty($output['decoration_nav'])) {?>
<style><?php echo $output['decoration_nav']['style'];?></style>
<?php } ?>
  <div class="ncsl-nav">
     <?php if(isset($output['decoration_banner'])) { ?>
     <!-- 启用店铺装修 -->
     <?php if($output['decoration_banner']['display'] == 'true') { ?>
     <div id="decoration_banner" class="ncsl-nav">
         <img src="<?php echo $output['decoration_banner']['image_url'];?>" alt="">
     </div>
     <?php } ?>
      <?php } else { ?>
     <!-- 不启用店铺装修 -->
<div class="banner"><a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$output['store_info']['store_id']));?>" class="img">
      <?php if(!empty($output['store_info']['store_banner'])){?>
      <img src="<?php echo getStoreLogo($output['store_info']['store_banner'],'store_logo');?>" alt="<?php echo $output['store_info']['store_name']; ?>" title="<?php echo $output['store_info']['store_name']; ?>" class="pngFix">
      <?php }else{?>
      <div class="ncs-default-banner"></div>
      <?php }?>
      </a></div>
      <?php } ?>
      <?php if(empty($output['decoration_nav']) || $output['decoration_nav']['display'] == 'true') {?>
    <div id="nav" class="ncs-nav">
      <ul>
        <li class="<?php if($output['page'] == 'index'){?>active<?php }else{?>normal<?php }?>"><a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$output['store_info']['store_id']));?>"><span><?php echo $lang['nc_store_index'];?><i></i></span></a></li>
        <li class="<?php if ($output['page'] == 'store_sns') {?>active<?php }else{?>normal<?php }?>"><a href="<?php echo urlShop('store_snshome', 'index', array('sid' => $output['store_info']['store_id']))?>"><span>店铺动态<i></i></span></a></li>
        <?php if(!empty($output['store_navigation_list'])){
      		foreach($output['store_navigation_list'] as $value){
                if($value['sn_if_show']) {
      			if($value['sn_url'] != ''){?>
        <li class="<?php if($output['page'] == $value['sn_id']){?>active<?php }else{?>normal<?php }?>"><a href="<?php echo $value['sn_url']; ?>" <?php if($value['sn_new_open']){?>target="_blank"<?php }?>><span><?php echo $value['sn_title'];?><i></i></span></a></li>
        <?php }else{ ?>
        <li class="<?php if($output['page'] == $value['sn_id']){?>active<?php }else{?>normal<?php }?>"><a href="<?php echo urlShop('show_store', 'show_article', array('store_id' => $output['store_info']['store_id'], 'sn_id' => $value['sn_id']));?>"><span><?php echo $value['sn_title'];?><i></i></span></a></li>
        <?php }}}} ?>
      </ul>
    </div>
<?php } ?>
  </div>
  <?php require_once($tpl_file); ?>
  <div class="clear">&nbsp;</div>
</div>
<?php include template('footer');?>
<script type="text/javascript">
$(function(){
	$('a[nctype="search_in_store"]').click(function(){
		if ($('#keyword').val() == '') {
			return false;
		}
		$('#search_act').val('show_store');
		$('<input type="hidden" value="<?php echo $output['store_info']['store_id'];?>" name="store_id" /> <input type="hidden" name="op" value="goods_all" />').appendTo("#formSearch");
		$('#formSearch').submit();
	});
	$('a[nctype="search_in_shop"]').click(function(){
		if ($('#keyword').val() == '') {
			return false;
		}
		$('#formSearch').submit();
	});
	$('#keyword').css("color","#999999");

	var storeTrends	= true;
	$('.favorites').mouseover(function(){
		var $this = $(this);
		if(storeTrends){
			$.getJSON('index.php?act=show_store&op=ajax_store_trend_count&store_id=<?php echo $output['store_info']['store_id'];?>', function(data){
				$this.find('li:eq(2)').find('a').html(data.count);
				storeTrends = false;
			});
		}
	});

	$('a[nctype="share_store"]').click(function(){
		<?php if ($_SESSION['is_login'] !== '1'){?>
		login_dialog();
		<?php } else {?>
		ajax_form('sharestore', '分享店铺', 'index.php?act=member_snsindex&op=sharestore_one&inajax=1&sid=<?php echo $output['store_info']['store_id'];?>');
		<?php }?>
	});
});
</script>
</body>
</html>
