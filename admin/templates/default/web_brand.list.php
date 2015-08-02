<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['brand_list']) && is_array($output['brand_list'])){ ?>

<ul class="brands dialog-brandslist-s2">
  <?php foreach($output['brand_list'] as $k => $v){ ?>
  <li>
    <div class="brands-pic" onclick="select_brand(<?php echo $v['brand_id'];?>);"><span class="ac-ico"></span><span class="thumb size-88x29"><i></i><img brand_id="<?php echo $v['brand_id'];?>" title="<?php echo $v['brand_name'];?>" src="<?php if(!empty($v['brand_pic'])){ echo UPLOAD_SITE_URL.'/'.ATTACH_BRAND.'/'.$v['brand_pic'];}else{ echo ADMIN_SITE_URL.'/templates/'.TPL_NAME.'/images/default_brand_image.gif';}?>" onload="javascript:DrawImage(this,88,30);" /></span></div>
    <div class="brands-name"><?php echo $v['brand_name'];?></div>
  </li>
  <?php } ?>
</ul>
<div id="show_page_brand" class="pagination"> <?php echo $output['show_page'];?> </div>
<div class="clear"></div>
<?php }else { ?>
<?php echo $lang['nc_no_record'];?>
<?php } ?>
<script type="text/javascript">
	$('#show_page_brand .demo').ajaxContent({
		target:'#show_brand_list'
	});
</script>