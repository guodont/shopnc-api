<?php defined('InShopNC') or exit('Access Invalid!');?>
<!-- 标题 -->
<div class="cms-module-title">
    <h2 id="cms_module_title" nctype="object_module_edit"><?php echo "<?php echo \$module_content['cms_module_title'];?>";?></h2>
    <?php echo "<?php if(\$output['edit_flag']) { ?>";?>
    <div class="cms-index-module-handle"><a nctype="btn_module_title_edit" href="JavaScript:void(0);" class="tip-r" title="<?php echo $lang['cms_index_module_title_edit'];?>"><?php echo $lang['cms_index_module_title_edit'];?></a></div>
    <?php echo "<?php } ?>";?>
</div>

