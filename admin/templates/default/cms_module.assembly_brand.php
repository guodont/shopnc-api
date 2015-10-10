<?php defined('InShopNC') or exit('Access Invalid!');?>
<!-- 品牌 -->
<div class="cms-module-assembly-brand">
    <div class="title-bar">
        <h3 id="<?php echo $block_name;?>_brand_title" nctype="object_module_edit"><?php echo "<?php echo \$module_content['".$block_name."_brand_title'];?>";?></h3>
        <?php echo "<?php if(\$output['edit_flag']) {?>";?>
        <div class="cms-index-module-handle"><a nctype="btn_module_title_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_title_edit'];?>"><?php echo $lang['cms_index_module_title_edit'];?></a></div>
        <?php echo "<?php } ?>";?>
    </div>
    <div class="content-box">
        <ul id="<?php echo $block_name;?>_brand_content" nctype="object_module_edit">
            <?php echo "<?php echo html_entity_decode(\$module_content['".$block_name."_brand_content']);?>";?>
        </ul>
        <?php echo "<?php if(\$output['edit_flag']) { ?>";?>
        <div class="cms-index-module-handle"><a nctype="btn_module_brand_edit" href="JavaScript:void(0);" class="tip-l" title="<?php echo $lang['cms_index_module_brand_edit'];?>"><?php echo $lang['cms_index_module_brand_edit'];?></a></div>
        <?php echo "<?php } ?>";?>
    </div>
</div>

