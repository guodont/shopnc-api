<?php defined('InShopNC') or exit('Access Invalid!');?>
<!-- 商品　-->
<div class="cms-module-assembly-goods">
    <div class="title-bar">
        <h3 id="<?php echo $block_name;?>_goods_title" nctype="object_module_edit"><?php echo "<?php echo \$module_content['".$block_name."_goods_title'];?>";?></h3>
        <?php echo "<?php if(\$output['edit_flag']) {?>";?>
        <div class="cms-index-module-handle"><a nctype="btn_module_title_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_title_edit'];?>"><?php echo $lang['cms_index_module_title_edit'];?></a></div>
        <?php echo "<?php } ?>";?>
    </div>
    <div class="content-box">
        <ul id="<?php echo $block_name;?>_goods_content" nctype="object_module_edit">
            <?php echo "<?php echo html_entity_decode(\$module_content['".$block_name."_goods_content']);?>";?>
        </ul>
        <?php echo "<?php if(\$output['edit_flag']) { ?>";?>
        <div class="cms-index-module-handle"><a nctype="btn_module_goods_edit" href="JavaScript:void(0);" class="tip-l" title="<?php echo $lang['cms_index_module_goods_edit'];?>"><?php echo $lang['cms_index_module_goods_edit'];?></a></div>
        <?php echo "<?php } ?>";?>
    </div>
</div>

