<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="warp-all picture-layout-a">
  <div class="sitenav-bar">
    <div class="sitenav"><?php echo $lang['current_location'];?><?php echo $lang['nc_colon'];?> <a href="<?php echo CMS_SITE_URL;?>"><?php echo $lang['cms_site_name'];?></a> > <a href="<?php echo CMS_SITE_URL.DS.'index.php?act=picture&op=picture_list';?>"><?php echo $lang['cms_picture'];?></a></div>
  </div>
  <div class="picture-detail-header">
    <div class="picture-detail-title">
      <h1><?php echo $output['picture_detail']['picture_title'];?></h1>
    </div>
    <div class="action-bar"><span class="PV"><i></i><?php echo $lang['cms_text_view'];?>&nbsp;<em>(<b><?php echo $output['picture_detail']['picture_click'];?></b>)</em></span> <span id="btn_sns_share" data-title="<?php echo $output['picture_detail']['picture_title'];?>" data-image="<?php echo getCMSArticleImageUrl($output['picture_detail']['picture_attachment_path'], $output['picture_detail']['picture_image'], 'list');?>" data-publisher="<?php echo empty($output['picture_detail']['picture_author'])?$lang['cms_text_guest']:$output['picture_detail']['picture_author'];?>" data-origin="<?php echo empty($output['picture_detail']['picture_origin'])?C('site_name'):$output['picture_detail']['picture_origin'];?>" data-publish_time="<?php echo date('Y-m-d',$output['picture_detail']['picture_publish_time']);?>" data-abstract="<?php echo $output['picture_detail']['picture_abstract'];?>" class="share" title="<?php echo $lang['cms_text_share_count'];?>"><i></i><?php echo $lang['cms_text_share'];?>&nbsp;<em>(<b><?php echo $output['picture_detail']['picture_share_count'];?></b>)</em></span> <span class="all-picture"><a href="<?php echo getPictureImageUrl($output['picture_detail']['picture_id']);?>"><i></i><?php echo $lang['cms_text_all_image'];?></a></span> </div>
  </div>
  <div class="mainbox">
    <div class="picture-detail-content">
      <div class="picture-slide-bar">
        <div class="previous-album">
          <div class="cover thumb">
            <?php if(!empty($output['pre_picture'])) { ?>
            <a href="<?php echo getCMSPictureUrl($output['pre_picture']['picture_id']);?>" class="size60" title="<?php echo $output['pre_picture']['picture_title'];?>"> <img src="<?php echo getCMSArticleImageUrl($output['pre_picture']['picture_attachment_path'], $output['pre_picture']['picture_image']);?>" class="t-img" /> </a>
            <?php } else { ?>
            <span><?php echo $lang['cms_picture_null'];?></span>
            <?php } ?>
          </div>
        </div>
        <div class="picture-nav-pre"><a id="btn_previous_page" href="JavaScript:;"></a></div>
        <div class="picture-nav">
          <ul id="picture_gallery" class="picture-gallery">
            <?php if(!empty($output['picture_image_list']) && is_array($output['picture_image_list'])) {?>
            <?php foreach($output['picture_image_list'] as $key=>$value) {?>
            <li data-image="<?php echo getCMSArticleImageUrl(empty($value['image_path'])?$output['picture_detail']['picture_attachment_path']:$value['image_path'], $value['image_name'], 'max');?>" data-abstract="<?php echo empty($value['image_abstract'])?$output['picture_detail']['picture_abstract']:$value['image_abstract'];?>">
              <div class="thumb"><img src="" data-src="<?php echo getCMSArticleImageUrl(empty($value['image_path'])?$output['picture_detail']['picture_attachment_path']:$value['image_path'], $value['image_name']);?>" <?php echo getMiddleImgStyleString($value['image_width'], $value['image_height'], 60 ,60);?> /></div>
              <div nctype="picture_image_info" style="display:none;">
                <div class="picture-image-info-abstract"><?php echo empty($value['image_abstract'])?$output['picture_detail']['picture_abstract']:$value['image_abstract'];?></div>
                <div class="picture-image-info-goods">
                  <?php if(!empty($value['image_goods'])) { ?>
                  <?php $image_goods_array = unserialize($value['image_goods']);?>
                  <?php foreach ($image_goods_array as $image_value) { ?>
                  <dl class="taobao-item">
                    <dt class="taobao-item-title"><a href="<?php echo $image_value['url'];?>" target="_blank"><?php echo $image_value['title'];?></a></dt>
                    <dd class="taobao-item-img" style="background-image: url(<?php echo $image_value['image'];?>) ;" title="<?php echo $image_value['title'];?>"></dd>
                    <dd class="taobao-item-price"><?php echo $lang['cms_price'];?><?php echo $lang['nc_colon'];?><?php echo $lang['currency'];?><?php echo $image_value['price'];?></dd>
                    <dd  class="taobao-item-go"><a href="<?php echo $image_value['url'];?>" target="_blank"><?php echo $lang['cms_goods_detail'];?></a></dd>
                  </dl>
                  <?php } ?>
                  <?php } ?>
                </div>
              </div>
            </li>
            <?php } ?>
            <?php } ?>
          </ul>
          <div class="clear"></div>
        </div>
        <div class="picture-nav-next"><a id="btn_next_page" href="JavaScript:;"></a></div>
        <div class="next-album">
          <div class="cover thumb">
            <?php if(!empty($output['next_picture'])) { ?>
            <a href="<?php echo getCMSPictureUrl($output['next_picture']['picture_id']);?>" class="size60" title="<?php echo $output['next_picture']['picture_title'];?>"> <img src="<?php echo getCMSArticleImageUrl($output['next_picture']['picture_attachment_path'], $output['next_picture']['picture_image']);?>" class="t-img" /> </a>
            <?php } else { ?>
            <span><?php echo $lang['cms_picture_null'];?></span>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="picture_detail">
        <div class="picture-image-pre" id="btn_previous_image" style="cursor: url('<?php echo CMS_TEMPLATES_URL;?>/images/pre.cur'), auto;"></div>
        
        <div class="picture-image-next" id="btn_next_image" style="cursor: url('<?php echo CMS_TEMPLATES_URL;?>/images/next.cur'), auto;"></div>
        <div id="picture_image_abstract" class="picture-image-abstract"></div>
        <div id="picture_image" class="picture-image"><img src="" alt="" /></div>
      </div>
      <div class="picture-keyword"><?php echo $lang['cms_keyword'];?><?php echo $lang['nc_colon'];?>
        <?php if(!empty($output['picture_detail']['picture_keyword'])) { ?>
        <?php $picture_keyword_array = explode(',', $output['picture_detail']['picture_keyword']);?>
        <?php foreach ($picture_keyword_array as $value) {?>
        <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=picture&op=picture_search&keyword=<?php echo $value;?>" target="_blank"><?php echo $value;?></a>
        <?php } ?>
        <?php } ?>
      </div>
      <?php if(intval(C('cms_comment_flag')) === 1) { ?>
      <section class="article-comment"> 
        <!-- 评论 -->
        <?php require('comment.php');?>
      </section>
      <?php } ?>
      <div class="clear"></div>
    </div>
    <div class="picture-detail-sidebar">
      <div class="picture-tag">
        <h3><?php echo $lang['cms_tag'];?></h3>
        <?php if(!empty($output['cms_tag_list']) && is_array($output['cms_tag_list'])) {?>
        <?php foreach($output['cms_tag_list'] as $key=>$value) {?>
        <a href="<?php echo CMS_SITE_URL.DS.'index.php?act=picture&op=picture_tag_search&tag_id='.$value['tag_id'];?>"><?php echo $value['tag_name'];?></a>
        <?php } ?>
        <?php } ?>
      </div>
      <div class="picture-preface">
        <div class="progress" id="picture_image_index"><span id="current_picture_index" class="numerator"><?php echo empty($_GET['count'])?1:intval($_GET['count'])+1;?></span><span class="denominator"><?php echo $output['picture_detail']['picture_image_count'];?></span></div>
        <?php echo $lang['cms_article_abstract'];?><?php echo $lang['nc_colon'];?><?php echo $output['picture_detail']['picture_abstract'];?></div>
      <div class="picture-sub"> <span class="author"><?php echo $lang['cms_commit'];?><?php echo $lang['nc_colon'];?><?php echo empty($output['picture_detail']['picture_author'])?$lang['cms_text_guest']:$output['picture_detail']['picture_author'];?>(<?php echo date('Y-m-d',$output['picture_detail']['picture_publish_time']);?>)</span><span class="source"><?php echo $lang['cms_text_origin'];?><?php echo $lang['nc_colon'];?> <a href="<?php echo empty($output['picture_detail']['picture_origin_address'])?CMS_SITE_URL:$output['picture_detail']['picture_origin_address'];?>" target="_blank"> <?php echo empty($output['picture_detail']['picture_origin'])?C('site_name'):$output['picture_detail']['picture_origin'];?> </a></span> </div>
      <div class="picture-buy-goods">
        <h3><?php echo $lang['cms_article_goods'];?><?php echo $lang['nc_colon'];?></h3>
        <div id="current_picture_image_info"></div>
      </div>
    </div>
  </div>
</div>
<?php require('widget_sns_share.php');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.flexslider-min.js" charset="utf-8"></script> 
<script type="text/javascript">
$(document).ready(function(){
    var start_count = <?php echo empty($_GET['count'])?0:$_GET['count'];?>;
    $("#picture_gallery").nc_gallery({ 
        show_item_count: 5,
        width: 80,
        btn_previous_page: '#btn_previous_page',
        btn_next_page: '#btn_next_page',
        btn_previous_image: '#btn_previous_image',
        btn_next_image: '#btn_next_image',
        start_item_count: start_count,
        image_lazy_load: true,
        current_item_change_callback: function(index, $current_item) {
            $("#current_picture_index").text(index + 1);
            $("#picture_image").find('img').attr('src', $current_item.attr('data-image'));
            $("#picture_image_abstract").text($current_item.attr('data-abstract'));
            $("#current_picture_image_info").html($current_item.find("[nctype='picture_image_info']").html());
        }
    });

});
</script> 
<script type="text/javascript">
$(window).load(function() {
    $(".cover .t-img").VMiddleImg({"width":60,"height":60});
});
</script> 
