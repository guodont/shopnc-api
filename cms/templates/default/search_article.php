<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="warp-all article-layout-a">
  <div class="mainbox">
    <div class="sitenav-bar">
      <div><?php echo $lang['current_location'];?><?php echo $lang['nc_colon'];?> <a href="<?php echo CMS_SITE_URL;?>"><?php echo $lang['cms_site_name'];?></a> > <a href="<?php echo CMS_SITE_URL.DS.'index.php?act=article&op=article_list';?>"><?php echo $lang['cms_article'];?></a> > <?php echo $lang['cms_search_result'];?></div>
    </div><div class="picture-info"><?php echo $lang['cms_search_result1'];?><em><?php echo empty($_GET['tag_id'])?$_GET['keyword']:$output['cms_tag_list'][$_GET['tag_id']]['tag_name'];?></em><?php echo $lang['cms_search_result2'];?><em><?php echo intval($output['total_num']);?></em>&nbsp;<?php echo $lang['cms_search_result3'];?></div>
    <?php if(!empty($output['article_list']) && is_array($output['article_list'])) {?>
    <ul class="article-search-list">
      <?php foreach($output['article_list'] as $value) {?>
      <?php $article_url = getCMSArticleUrl($value['article_id']);?>
      <li>
        <div class="article-cover thumb"><a href="<?php echo $article_url;?>" target="_blank" class="size60"> <img src="<?php echo getCMSArticleImageUrl($value['article_attachment_path'], $value['article_image'], 'list');?>" alt="" class="t-img"/></a></div>
        <h3 class="article-title"> <a href="<?php echo $article_url;?>" target="_blank"> <?php echo $value['article_title'];?> </a> </h3>
        <div class="article-sub"><span class="author"><?php echo $lang['cms_text_publisher'];?><?php echo $lang['nc_colon'];?><?php echo empty($value['article_author'])?$lang['cms_text_guest']:$value['article_author'];?></span><span class="source"><?php echo $lang['cms_text_origin'];?><?php echo $lang['nc_colon'];?> <a href="<?php echo empty($value['article_origin_address'])?CMS_SITE_URL:$value['article_origin_address'];?>" target="_blank"> <?php echo empty($value['article_origin'])?C('site_name'):$value['article_origin'];?> </a></span><span class="date"><?php echo date('Y-m-d',$value['article_publish_time']);?></span></div>
        <div class="article-tag"><?php echo $lang['cms_keyword'];?><?php echo $lang['nc_colon'];?>
          <?php if(!empty($value['article_keyword'])) { ?>
          <?php $article_keyword_array = explode(',', $value['article_keyword']);?>
          <?php foreach ($article_keyword_array as $keyword_value) {?>
          <a href="<?php echo CMS_SITE_URL.DS;?>index.php?act=article&op=article_search&keyword=<?php echo rawurlencode($keyword_value);?>" target="_blank"><?php echo $keyword_value;?></a>
          <?php } ?>
          <?php } ?>
        </div>
        <div class="article-preface"><a href="<?php echo $article_url;?>" target="_blank"><?php echo $value['article_abstract'];?></a></div>
      </li>
      <?php } ?>
    </ul>
    <div class="pagination"> <?php echo $output['show_page'];?> </div>
    <?php } else { ?>
    <div class="no-content-b"><i class="search"></i><?php echo $lang['no_record'];?></div>
    <?php } ?>
  </div>
  <div class="sidebar">
    <?php require('article_list.sidebar.php');?>
  </div>
</div>
<script type="text/javascript">
$(window).load(function() {
	$(".article-cover .t-img").VMiddleImg({"width":60,"height":60});
});
</script>
