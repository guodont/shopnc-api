<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="cms-index-module-index1 module-style-<?php echo $value['module_style'];?>">
  <div class="cms-index-module-index1-1"> 
    <!-- 封面图 -->
    <div class="index1-1-1-content">
        <div class="index1-1-1-content-ul-wrap">
            <ul id="index1_1_1_content" style="height:260px;" nctype="object_module_edit">
                <?php echo html_entity_decode($module_content['index1_1_1_content']);?>
            </ul>
        </div>
        <?php if($output['edit_flag']) { ?>
        <div class="cms-index-module-handle"><a nctype="btn_module_image_edit" image_count="2" href="JavaScript:void(0);" class="tip-l" data-title="<?php echo $lang['cms_index_module_image_focus_edit_title'];?>" title="<?php echo $lang['cms_index_module_image_focus_edit_title'];?>"><?php echo $lang['cms_index_module_image_focus_edit'];?></a></div>
        <?php } ?>
    </div>
    <!-- 圈子|专题 -->
    <div class="cms-index-module-index1-1-2">
        <div id="index1_1_2_content" class="index1-1-2-content" nctype="object_module_edit"> <?php echo html_entity_decode($module_content['index1_1_2_content']);?> </div>
        <?php if($output['edit_flag']) { ?>
        <div class="cms-index-module-handle">
        <a id="btn_module_circle_edit" href="JavaScript:void(0);"><?php echo $lang['cms_index_module_circle_edit'];?></a>
        <a class="tip-r" nctype="btn_module_image_edit" image_count="2" href="JavaScript:void(0);" style="left: 90px;" data-title="<?php echo $lang['cms_index_module_image_circle_edit_title'];?>" title="<?php echo $lang['cms_index_module_image_circle_edit_title'];?>"><?php echo $lang['cms_index_module_image_edit'];?></a></div>
        <?php } ?>
      </div>
  </div>
  <!-- 文章　-->
  <div class="cms-index-module-index1-2">
    <div class="cms-index-module-index1-2-1">
      <div class="title-bar">
        <h3 id="index1_2_1_title" nctype="object_module_edit"><?php echo $module_content['index1_2_1_title'];?></h3>
        <?php if($output['edit_flag']) { ?>
        <div class="cms-index-module-handle"><a nctype="btn_module_title_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_title_edit'];?>"><?php echo $lang['cms_index_module_title_edit'];?></a></div>
        <?php } ?>
      </div>
      <div class="content-box content-big">
        <ul id="index1_2_1_1_content" nctype="object_module_edit">
          <?php echo html_entity_decode($module_content['index1_2_1_1_content']);?>
        </ul>
        <?php if($output['edit_flag']) { ?>
        <div class="cms-index-module-handle">
        <a nctype="btn_module_article_edit" save_function="article_type_4_save" limit_count="1" href="JavaScript:void(0);" class="tip-l"  title="<?php echo $lang['cms_index_module_article_top_edit'];?>"><?php echo $lang['cms_index_module_article_top_edit'];?></a></div>
        <?php } ?>
      </div>
      <div class="content-box content-recommand">
        <ul id="index1_2_1_2_content" nctype="object_module_edit">
          <?php echo html_entity_decode($module_content['index1_2_1_2_content']);?>
        </ul>
        <?php if($output['edit_flag']) { ?>
        <div class="cms-index-module-handle"><a nctype="btn_module_article_edit" save_function="article_type_6_save" limit_count="4" href="JavaScript:void(0);" class="tip-l" title="<?php echo $lang['cms_index_module_article_edit'];?>"><?php echo $lang['cms_index_module_article_edit'];?></a></div>
        <?php } ?>
      </div>
    </div>
    <?php for($i=2; $i<=4; $i++) { ?>
    <div class="articel-block">
      <div class="title-bar">
        <h3 id="index1_2_<?php echo $i;?>_title" nctype="object_module_edit"><?php echo $module_content['index1_2_'.$i.'_title'];?></h3>
        <?php if($output['edit_flag']) { ?>
        <div class="cms-index-module-handle"><a nctype="btn_module_title_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_title_edit'];?>"><?php echo $lang['cms_index_module_title_edit'];?></a></div>
        <?php } ?>
      </div>
      <div class="content-box content-special">
        <ul id="index1_2_<?php echo $i;?>_1_content" nctype="object_module_edit">
          <?php echo html_entity_decode($module_content['index1_2_'.$i.'_1_content']);?>
        </ul>
        <?php if($output['edit_flag']) { ?>
        <div class="cms-index-module-handle"><a nctype="btn_module_article_edit" save_function="article_type_3_save" limit_count="1" href="JavaScript:void(0);" class="tip-l" title="<?php echo $lang['cms_index_module_article_image_edit'];?>" ><?php echo $lang['cms_index_module_article_image_edit'];?></a></div>
        <?php } ?>
      </div>
      <div class="content-box content-normal">
        <ul id="index1_2_<?php echo $i;?>_2_content" nctype="object_module_edit">
          <?php echo html_entity_decode($module_content['index1_2_'.$i.'_2_content']);?>
        </ul>
        <?php if($output['edit_flag']) { ?>
        <div class="cms-index-module-handle"><a nctype="btn_module_article_edit" save_function="article_type_0_save" limit_count="5" href="JavaScript:void(0);"><?php echo $lang['cms_index_module_article_edit'];?></a></div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>
  </div>
  <!-- 商品分类　-->
  <div class="cms-index-module-index1-3">
    <div class="title-bar">
      <h3 id="index1_3_title" nctype="object_module_edit"><?php echo $module_content['index1_3_title'];?></h3>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a nctype="btn_module_title_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_title_edit'];?>"><?php echo $lang['cms_index_module_title_edit'];?></a></div>
      <?php } ?>
    </div>
    <div class="content-box mall-class">
      <div id="index1_3_content" nctype="object_module_edit"> <?php echo html_entity_decode($module_content['index1_3_content']);?> </div>
      <?php if($output['edit_flag']) { ?>
      <div class="cms-index-module-handle"><a nctype="btn_module_goods_class_edit" href="JavaScript:void(0);"><?php echo $lang['cms_index_module_goods_class_edit'];?></a>
        <a class="tip-l" nctype="btn_module_image_edit" image_count="2" href="JavaScript:void(0);" style="right: 90px;" data-title="<?php echo $lang['cms_index_module_image_goods_class_edit_title'];?>" title="<?php echo $lang['cms_index_module_image_goods_class_edit_title'];?>"><?php echo $lang['cms_index_module_image_edit'];?></a></div>
      <?php } ?>
      <div class="goto-mall"><a href="<?php echo SHOP_SITE_URL;?>" target="_blank"><?php echo $lang['cms_index_enter_shop'];?></a></div>
   </div>
   <div class="clear"></div>
  </div>
</div>
<script type="text/javascript">
$(window).load(function() {
//比例局中裁切显示图片
	$(".cms-index-module-index1-1-1 .t-img").VMiddleImg({"width":380,"height":230});
    $(".circle-theme-item .t-img").VMiddleImg({"width":160,"height":100});
	$(".cms-index-module-index1-2 .t-img").VMiddleImg({"width":120,"height":96});

});
</script>
