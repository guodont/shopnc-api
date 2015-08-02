<?php
/**
 * CMS公共方法
 *
 * 公共方法
 *
 */
defined('InShopNC') or exit('Access Invalid!');

function getRefUrl() {
    return urlencode('http://'.$_SERVER['HTTP_HOST'].request_uri());
}

function getLoadingImage() {
    return CMS_TEMPLATES_URL.DS.'images/loading.gif';
}

/**
 * 画报图片列表
 */
function getPictureImageUrl($picture_id) {
    return CMS_SITE_URL.DS.'index.php?act=picture&op=picture_detail_image&picture_id='.$picture_id;
}

/**
 * 获取商品URL
 */
function getGoodsUrl($goods_id) {
    return SHOP_SITE_URL.DS.'index.php?act=goods&goods_id='.$goods_id;
}

/**
 * 返回图片居中显示的样式字符串 
 *
 * @param
 * $image_width 图片宽度
 * $image_height 图片高度 
 * $box_width 目标图片尺寸宽度 
 * $box_height 目标图片尺寸高度 
 *
 * @return string 图片居中显示style字符串
 *
 */
function getMiddleImgStyleString($image_width, $image_height, $box_width, $box_height) {
    $image_style = array();
    $image_style['width'] = $box_width;
    $image_style['height'] = $box_height;
    $image_style['left'] = 0;
    $image_style['top'] = 0;

    if( ($image_width - $box_width) > ($image_height - $box_height) ) {
        if($image_width > $box_width) {
            $image_style['width'] = $box_height / $image_height * $image_width;
            $image_style['left'] = ($box_width - $image_style['width']) / 2;
        }
    } else {
        if($image_height > $box_height) {
            $image_style['height'] = $box_width / $image_width * $image_height;
            $image_style['top'] = ($box_height - $image_style['height']) / 2;
        }
    }

    $style_string = 'style="';
    $style_string .= 'height: ' . $image_style['height'] . 'px;';
    $style_string .= ' width: ' . $image_style['width'] . 'px;';
    $style_string .= ' left: ' . $image_style['left'] . 'px;';
    $style_string .= 'top: ' . $image_style['top'] . 'px;';
    $style_string .= '"';

    return $style_string;
}

