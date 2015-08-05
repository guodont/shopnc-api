<?php defined('InShopNC') or exit('Access Invalid!'); ?>

<div class="index_block goods">
    <?php if(!empty($vv['title'])) {?>
    <div class="title"><?php echo $vv['title']; ?></div>
    <?php } ?>
    <div nctype="item_content" class="content">
    <?php foreach ((array) $vv['item'] as $item) { ?>
        <div nctype="item_image" class="goods-item">
            <a nctype="btn_item" href="javascript:;" data-type="goods" data-data="<?php echo $item['goods_id']; ?>">
                <div class="goods-item-pic"><img nctype="goods_image" src="<?php echo $item['goods_image']; ?>" alt=""></div>
                <div class="goods-item-name"><?php echo $item['goods_name']; ?></div>
                <div class="goods-item-price">￥<?php echo $item['goods_promotion_price']; ?></div>
            </a>
        </div>
    <?php } ?>
    </div>
</div>
