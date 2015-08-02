<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['article_list']) && is_array($output['article_list'])){ ?>

<div class="article-select-box">
  <div class="arrow"></div>
  <ul id="article_search_list" class="article-search-list">
    <?php foreach($output['article_list'] as $value){ ?>
    <li nctype="btn_article_select" article_id="<?php echo $value['article_id'];?>"><a href="<?php echo getCMSArticleUrl($value['article_id']);?>" target="_blank"> <?php echo $value['article_title'];?> </a> <i><?php echo $lang['api_article_add'];?></i> </li>
    <?php } ?>
  </ul>
  <div class="pagination"><?php echo $output['show_page'];?></div>
</div>
<?php }else { ?>
<div class="no-record"><?php echo $lang['no_record'];?></div>
<?php } ?>
