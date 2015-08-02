<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="warp-all picture-layout-b">
  <div class="sitenav-bar">
    <div class="sitenav"><?php echo $lang['current_location'];?><?php echo $lang['nc_colon'];?> <a href="<?php echo CMS_SITE_URL;?>"><?php echo $lang['cms_site_name'];?></a> > <a href="<?php echo CMS_SITE_URL.DS.'index.php?act=picture&op=picture_list';?>"><?php echo $lang['cms_picture'];?></a> <?php echo empty($_GET['class_id'])?'':' > '.$output['picture_class_list'][$_GET['class_id']]['class_name'];?></div>
  </div>
  <div class="mainbox">
    <div class="picture-info"><?php echo $lang['cms_picture_search1'];?><?php echo $lang['nc_colon'];?><em><?php echo intval($output['total_num']);?></em>&nbsp;<?php echo $lang['cms_picture_search2'];?></div>
    <?php if(!empty($output['picture_list']) && is_array($output['picture_list'])) {?>
    <ul class="picture-list">
      <?php foreach($output['picture_list'] as $value) {?>
      <li>
        <div class="mark"><?php echo $value['picture_image_count'];?></div>
        <div class="thumb"> <a href="<?php echo getCMSPictureUrl($value['picture_id']);?>" target="_blank"><img src="<?php echo getCMSArticleImageUrl($value['picture_attachment_path'], $value['picture_image']);?>" alt="<?php echo $value['picture_title'];?>" class="t-img"/></a></span> </div>
        <p class="title"> <a href="<?php echo getCMSPictureUrl($value['picture_id']);?>" target="_blank"> <?php echo $value['picture_title'];?> </a> </p>
      </li>
      <?php } ?>
    </ul>
    <div class="pagination"> <?php echo $output['show_page'];?> </div>
    <?php } else { ?>
    <div class="no-content-b"><i class="picture"></i><?php echo $lang['no_record'];?></div>
    <?php } ?>
  </div>
  <div class="sidebar">
    <div class="block-style-three">
      <div class="title">
        <h3><?php echo $lang['cms_article_commend'];?></h3>
      </div>
      <div class="content">
        <?php if(!empty($output['hot_picture_list']) && is_array($output['hot_picture_list'])) {?>
        <ul class="recommand-pic-list">
          <?php foreach($output['hot_picture_list'] as $value) {?>
          <li>
            <div class="thumb"> <a href="<?php echo getCMSPictureUrl($value['picture_id']);?>" target="_blank"> <img src="<?php echo getCMSArticleImageUrl($value['picture_attachment_path'], $value['picture_image']);?>" alt="<?php echo $value['picture_title'];?>" class="t-img"/> </a></div>
            <p class="title"> <a href="<?php echo getCMSPictureUrl($value['picture_id']);?>" target="_blank"> <?php echo $value['picture_title'];?> </a> </p>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(window).load(function() {
	$(".picture-list .t-img").VMiddleImg({"width":180,"height":230});
    $(".recommand-pic-list .t-img").VMiddleImg({"width":160,"height":140});
});
</script>
