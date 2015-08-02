<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php $block_content = empty($block_content) ? $output['block_content'] : $block_content; ?>
<?php $block_content = unserialize($block_content);?>
<div>
    <?php $image_url = getStoreDecorationImageUrl($block_content['image']);?>
    <?php $hot_area_flag = str_replace('.', '',$block_content['image']);?>
    <img data-image-name="<?php echo $block_content['image'];?>" usemap="#<?php echo $hot_area_flag;?>" src="<?php echo $image_url;?>" alt="<?php echo $block_content['image'];?>">
    <map name="<?php echo $hot_area_flag;?>" id="<?php echo $hot_area_flag;?>">
        <?php if(!empty($block_content['areas']) && is_array($block_content['areas'])) {?>
        <?php foreach($block_content['areas'] as $value) {?>
        <area target="_blank" shape="rect" coords="<?php echo $value['x1'];?>,<?php echo $value['y1'];?>,<?php echo $value['x2'];?>,<?php echo $value['y2'];?>" href ="<?php echo $value['link'];?>" alt="<?php echo $value['link'];?>" />
        <?php } ?>
        <?php } ?>
    </map>
</div>

