<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php 
$control_flag = false;
if($_GET['op'] == 'decoration_edit' || $_GET['op'] == 'decoration_block_add') { 
    $control_flag = true;
} 
$block = empty($block) ? $output['block'] : $block;
$block_content = $block['block_content'];
if($control_flag) { 
    $block_title = '上下拖拽布局块位置可改变排列顺序，无效的可删除。<br/>编辑布局块内容请点击“编辑模块”并选择操作。';
} else {
    $block_title = '';
}
?>
<?php $extend_class = $block['block_full_width'] == '1' ? 'store-decoration-block-full-width' : '';?>
<div id="block_<?php echo $block['block_id'];?>" data-block-id="<?php echo $block['block_id'];?>" nctype="store_decoration_block" class="ncsc-decration-block store-decoration-block-1 <?php echo $extend_class;?> tip" title="<?php echo $block_title;?>">
    <div nctype="store_decoration_block_content" class="ncsc-decration-block-content store-decoration-block-1-content">
        <div nctype="store_decoration_block_module" class="store-decoration-block-1-module">
            <?php if(!empty($block['block_module_type'])) { ?>
            <?php require('store_decoration_module.' . $block['block_module_type'] . '.php');?>
            <?php } ?>
        </div>
        <?php if($control_flag) { ?>
        <a class="edit" nctype="btn_edit_module" data-module-type="<?php echo $block['block_module_type'];?>" href="javascript:;" data-block-id="<?php echo $block['block_id'];?>"><i class="icon-edit"></i>编辑模块</a>
        <?php } ?>
    </div>
    <?php if($control_flag) { ?>
    <a class="delete" nctype="btn_del_block" href="javascript:;" data-block-id=<?php echo $block['block_id'];?> title="删除该布局块"><i class="icon-trash"></i>删除布局块</a>    
    <?php } ?>
</div>
