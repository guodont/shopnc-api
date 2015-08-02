<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="warp-all picture-layout-b">
  <div class="sitenav-bar">
      <div class="sitenav"><?php echo $lang['current_location'];?><?php echo $lang['nc_colon'];?> <a href="<?php echo CMS_SITE_URL;?>"><?php echo $lang['cms_site_name'];?></a> > <a href="<?php echo CMS_SITE_URL.DS.'index.php?act=picture&op=picture_list';?>"><?php echo $lang['cms_picture'];?></a></div>
  </div>
  <div class="mainbox">
    <div class="picture-info"><strong><?php echo $output['picture_detail']['picture_title'];?></strong> (<em><?php echo intval($output['picture_detail']['picture_image_count']);?></em>)<?php echo $lang['cms_text_zhang'];?></div>
    <div class="picture-images-list clearfix">
      <ul>
        <?php if(!empty($output['picture_image_list']) && is_array($output['picture_image_list'])) {?>
        <?php $image_count = 0;?>
        <?php foreach($output['picture_image_list'] as $key=>$value) {?>
        <li><a href="<?php echo getCMSPictureUrl($output['picture_detail']['picture_id'], FALSE).'&count='.$image_count;?>"><img src="<?php echo getCMSArticleImageUrl(empty($value['image_path'])?$output['picture_detail']['picture_attachment_path']:$value['image_path'], $value['image_name']);?>"/></a> </li>
        <?php $image_count++;?>
        <?php } ?>
        <?php } ?>
      </ul>
    </div>
    <div class="pagination"> <?php echo $output['show_page'];?> </div>
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
