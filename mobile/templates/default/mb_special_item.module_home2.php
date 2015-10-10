<?php defined('InShopNC') or exit('Access Invalid!'); ?>

<div class="index_block home2">
    <?php if(!empty($vv['title'])) {?>
    <div class="title"><?php echo $vv['title']; ?></div>
    <?php } ?>
    <div class="content">
        <div class="item home2_1">
            <a nctype="btn_item" href="javascript:;" data-type="<?php echo $vv['square_type']; ?>" data-data="<?php echo $vv['square_data']; ?>"><img src="<?php echo $vv['square_image']; ?>" alt=""></a>
        </div>
        <div class="item home2_2">
            <div class="border-left">
                <div class="border-bottom">
                    <a nctype="btn_item" href="javascript:;" data-type="<?php echo $vv['rectangle1_type']; ?>" data-data="<?php echo $vv['rectangle1_data']; ?>"><img src="<?php echo $vv['rectangle1_image']; ?>" alt=""></a>
                </div>
                <div>
                    <a nctype="btn_item" href="javascript:;" data-type="<?php echo $vv['rectangle2_type']; ?>" data-data="<?php echo $vv['rectangle2_data']; ?>"><img src="<?php echo $vv['rectangle2_image']; ?>" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>
