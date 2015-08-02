<?php defined('InShopNC') or exit('Access Invalid!');?>
<!-- 图片 -->
<div class="cms-module-assembly-image">
    <div class="content-box">
        <ul id="<?php echo $block_name;?>_image" nctype="object_module_edit">
            <?php echo "<?php echo html_entity_decode(\$module_content['".$block_name."_image']);?>";?>
        </ul>
        <?php echo "<?php if(\$output['edit_flag']) { ?>";?>
        <div class="cms-index-module-handle"><a nctype="btn_module_image_edit" image_count="1" href="JavaScript:void(0);" class="tip-l" data-title="<?php echo $lang['cms_index_module_image_edit_title'];?>" title="<?php echo $lang['cms_index_module_image_edit_title'];?>"><?php echo $lang['cms_index_module_image_edit'];?></a></div>
        <?php echo "<?php } ?>";?>
    </div>
</div>
