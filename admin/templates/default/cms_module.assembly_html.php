<?php defined('InShopNC') or exit('Access Invalid!');?>
<!-- 文章　-->
<div class="cms-module-assembly-html">
    <div class="content-box">
        <div id="<?php echo $block_name;?>_html_content" nctype="object_module_edit">
            <?php echo "<?php echo html_entity_decode(\$module_content['".$block_name."_html_content']);?>";?>
        </div>
        <?php echo "<?php if(\$output['edit_flag']) { ?>";?>
        <div class="cms-index-module-handle"><a nctype="btn_module_html_edit" href="JavaScript:void(0);" class="tip-l" title="<?php echo $lang['cms_index_module_html_edit'];?>"><?php echo $lang['cms_index_module_html_edit'];?></a></div>
        <?php echo "<?php } ?>";?>
    </div>
</div>

