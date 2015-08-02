<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="block-style-one">
    <div class="title">
        <h3><?php echo $lang['cms_article_tag'];?></h3>
    </div>
    <div class="content">
        <div class="tag-cloud">
            <?php if(!empty($output['cms_tag_list']) && is_array($output['cms_tag_list'])) {?>
            <?php foreach($output['cms_tag_list'] as $key=>$value) {?>
            <a href="<?php echo CMS_SITE_URL.DS.'index.php?act=article&op=article_tag_search&tag_id='.$value['tag_id'];?>"><?php echo $value['tag_name'];?></a>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<div class="block-style-one">
    <div class="title">
        <h3><?php echo $lang['cms_article_good'];?></h3>
    </div>
    <div class="content">
        <?php if(!empty($output['article_commend_image_list']) && is_array($output['article_commend_image_list'])) {?>
        <ol class="article-liked-top">
            <?php $commend_count = 1;?>
            <?php foreach($output['article_commend_image_list'] as $value) {?>
            <li>
            <div class="article-top"><em>0<?php echo $commend_count;?></em><span><i></i><?php echo $value['article_click'];?></span></div>
            <div class="article-cover" style=" background-image:url(<?php echo getCMSArticleImageUrl($value['article_attachment_path'], $value['article_image'], 'list');?>)"></div>
            <div class="article-title"><a href="<?php echo getCMSArticleUrl($value['article_id']);?>"><?php echo $value['article_title'];?></a></div>
            </li>
            <?php $commend_count++;?>
            <?php } ?>
        </ol>
        <?php } ?>
    </div>
</div>
<div class="block-style-one">
    <div class="title">
        <h3><?php echo $lang['cms_article_commend'];?></h3>
    </div>
    <div class="content">
        <?php if(!empty($output['article_commend_list']) && is_array($output['article_commend_list'])) {?>
        <ul class="article-recommand-list">
            <?php $commend_count = 1;?>
            <?php foreach($output['article_commend_list'] as $value) {?>
            <li><a href="index.php?act=article&op=article_list&class_id=<?php echo $value['class_id'];?>" class="class" target="_blank">[<?php echo $value['class_name'];?>]</a><a href="<?php echo getCMSArticleUrl($value['article_id']);?>"><?php echo $value['article_title'];?></a></li>
            <?php if($commend_count % 3 === 0 && $commend_count < 9) { ?>
            <li class="line"></li>
            <?php } ?>
            <?php $commend_count++;?>
            <?php } ?>
        </ul>
        <?php } ?>
    </ul>
</div>
    </div>
