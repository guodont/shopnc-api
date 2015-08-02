<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if($_GET['op'] === 'cms_index_preview') { ?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo CMS_SITE_URL;?>/resource/js/common.js" charset="utf-8"></script>
<link href="<?php echo CMS_SITE_URL.DS;?>templates/default/css/base.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.VMiddleImg.js"></script>
<?php } ?>
<link href="<?php echo CMS_SITE_URL.DS;?>templates/cms_special.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/jquery.jcarousel.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/slidesjs/jquery.slides.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/skins/personal/skin.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function() {
    if($('#index1_1_1_content').children().length > 0) {
        $('#index1_1_1_content').slidesjs({
            play: {
                active: true,
                    interval: 5000,
                    auto: true,
                    pauseOnHover: false,
                    restartDelay: 2500
            },
            callback: {
                complete: function(number) {
                    var $item = $(".slidesjs-pagination-item");
                    $item.removeClass("current");
                    $item.eq(number - 1).addClass("current");
                }
            },
                width: 380,
                height: 260
        });
        $(".slidesjs-pagination-item").eq(0).addClass("current");
    }

    //图片延迟加载
    $(".lazyload_container").nc_lazyload_init();
    $("img").nc_lazyload();

    //计算自定义块高度
    var frames = $('.cms-module-frame');
    $.each(frames, function(index, frame) {
        var boxs = $(frame).find('[nctype="cms_module_content"]');
        var height = 0;
        $.each(boxs, function(index2, box) {
            var box_height = $(box).height();
            if(box_height > height) {
                height = box_height;
            }
        });
        boxs.height(height);
    });
});
</script>
<?php if($_GET['op'] === 'cms_index_preview') { ?>
<div style="width:1000px;margin:0 auto;">
<?php } ?>
<?php if(!empty($output['module_list']) && is_array($output['module_list'])) {?>
<?php foreach($output['module_list'] as $key=>$value) {?>
<?php $module_content = unserialize(base64_decode($value['module_content']));?>
<?php if($value['module_type'] != 'index' && $value['module_type'] != 'micro') { ?>
<textarea class="lazyload_container" rows="10" cols="30" style="display:none;">
<?php } ?>
<?php require($value['module_template']);?>
<?php if($value['module_type'] != 'index' && $value['module_type'] != 'micro') { ?>
</textarea>
<?php } ?>
<?php } ?>
<?php } ?>
<?php if($_GET['op'] === 'cms_index_preview') { ?>
</div>
<?php } ?>

