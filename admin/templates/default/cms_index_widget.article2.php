<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="cms-index-module-article2 module-style-<?php echo $value['module_style'];?>">
  <div class="cms-index-module-article-title"> 
    <!-- 标题 -->
    <div class="cms-index-module-article-title-left">
      <h2 id="article2_title" nctype="object_module_edit"><?php echo $module_content['article2_title'];?></h2>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a nctype="btn_module_title_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_title_edit'];?>"><?php echo $lang['cms_index_module_title_edit'];?></a></div>
      <?php } ?>
    </div>
    <!-- 标签 -->
    <div class="cms-index-module-article-title-right">
      <ul id="article2_tag" nctype="object_module_edit">
        <?php echo html_entity_decode($module_content['article2_tag']);?>
      </ul>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a id="btn_module_tag_edit" href="JavaScript:void(0);" class="tip-l" title="<?php echo $lang['cms_index_module_tag_edit'];?>"><?php echo $lang['cms_index_module_tag_edit'];?></a></div>
      <?php } ?>
    </div>
  </div>
  <div class="clear"></div>
  <div class="cms-index-module-article2-1">
    <div class="title-bar">
      <h3 id="article2_1_title" nctype="object_module_edit"><?php echo $module_content['article2_1_title'];?></h3>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a nctype="btn_module_title_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_title_edit'];?>"><?php echo $lang['cms_index_module_title_edit'];?></a></div>
      <?php } ?>
    </div>
    <div class="content-box">
      <ul id="article2_1_content" nctype="object_module_edit">
        <?php echo html_entity_decode($module_content['article2_1_content']);?>
      </ul>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a nctype="btn_module_article_edit" save_function="article_type_3_save" limit_count="4" href="JavaScript:void(0);" class="tip-l" title="<?php echo $lang['cms_index_module_article_image_edit'];?>"><?php echo $lang['cms_index_module_article_image_edit'];?></a></div>
      <?php } ?>
    </div>
  </div>
  <!-- 文章　-->
  <div class="cms-index-module-article2-2">
    <div class="title-bar">
      <h3 id="article2_2_title" nctype="object_module_edit"><?php echo $module_content['article2_2_title'];?></h3>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a nctype="btn_module_title_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_title_edit'];?>"><?php echo $lang['cms_index_module_title_edit'];?></a></div>
      <?php } ?>
    </div>
    <div class="content-box article2-2-1-content">
      <ul id="article2_2_1_content" nctype="object_module_edit"> <?php echo html_entity_decode($module_content['article2_2_1_content']);?>
      </ul>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a nctype="btn_module_article_edit" save_function="article_type_3_save" limit_count="2" href="JavaScript:void(0);" class="tip-l" title="<?php echo $lang['cms_index_module_article_image_edit'];?>"><?php echo $lang['cms_index_module_article_image_edit'];?></a></div>
      <?php } ?>
    </div>
    <div class="content-box article2-2-2-content">
      <ul id="article2_2_2_content" nctype="object_module_edit">
        <?php echo html_entity_decode($module_content['article2_2_2_content']);?>
      </ul>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a nctype="btn_module_article_edit" save_function="article_type_5_save" limit_count="4" href="JavaScript:void(0);" class="tip-l" title="<?php echo $lang['cms_index_module_article_edit'];?>"><?php echo $lang['cms_index_module_article_edit'];?></a></div>
      <?php } ?>
    </div>
  </div>
  <!-- 商品　-->
  <div class="cms-index-module-article2-3">
    <div class="title-bar">
      <h3 id="article2_3_title" nctype="object_module_edit"><?php echo $module_content['article2_3_title'];?></h3>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a nctype="btn_module_title_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_title_edit'];?>"><?php echo $lang['cms_index_module_title_edit'];?></a></div>
      <?php } ?>
    </div>
    <div class="content-box">
      <ul id="article2_3_content" nctype="object_module_edit">
        <?php echo html_entity_decode($module_content['article2_3_content']);?>
      </ul>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a nctype="btn_module_brand_edit" limit_count="12" href="JavaScript:void(0);" class="tip-l" title="<?php echo $lang['cms_index_module_brand_edit'];?>"><?php echo $lang['cms_index_module_brand_edit'];?></a></div>
      <?php } ?>
    </div>
  </div>
  <div class="clear"></div>
</div>
