<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['article_list']) && is_array($output['article_list'])){ ?>
<div class="article-select-box">
    <div class="arrow"></div>
    <ul id="article_search_list" class="article-search-list">
        <?php foreach($output['article_list'] as $value){ ?>
        <li>
        <span nctype="cms_index_not_display" class="article-image">
            <p><img src="<?php echo getCMSArticleImageUrl($value['article_attachment_path'], $value['article_image']);?>" /></p>
        </span>
        <span class="title">
            <em nctype="cms_index_not_display" class="class-name">[<?php echo $value['class_name'];?>]</em>
            <a nctype="article_item" href="<?php echo getCMSArticleUrl($value['article_id']);?>" target="_blank" class_name="<?php echo $value['class_name'];?>" article_abstract="<?php echo $value['article_abstract'];?>" article_click="<?php echo $value['article_click'];?>" article_publish_time="<?php echo date('Y-m-d',$value['article_publish_time']);?>" article_image="<?php echo getCMSArticleImageUrl($value['article_attachment_path'], $value['article_image']);?>">
                <?php echo $value['article_title'];?>
            </a>
            <em nctype="cms_index_not_display" class="publish-time">(<?php echo date('Y-m-d',$value['article_publish_time']);?>)</em>
        </span>
        <span nctype="cms_index_not_display" class="article-abstract" title="<?php echo $value['article_abstract'];?>"><?php echo $lang['cms_article_abstract'];?><?php echo $lang['nc_colon'];?><?php echo $value['article_abstract'];?></span>
        <a nctype="btn_article_select" href="JavaScript:void(0);" class="handle-add" title="<?php echo $lang['cms_text_add'];?>"></a>
        </li>
        <?php } ?>
    </ul>
    <div class="pagination"><?php echo $output['show_page'];?></div>
</div>
<?php }else { ?>
<div class="no-record"><?php echo $lang['no_record'];?></div>
<?php } ?>
