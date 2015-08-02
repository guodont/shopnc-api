<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>hsht</title>
        <style>
            body { margin: 0; }
            .waybill_area { position: relative; width: <?php echo $output['waybill_info']['waybill_pixel_width'];?>px; height: <?php echo $output['waybill_info']['waybill_pixel_height'];?>px; }
            .waybill_back { position: relative; width: <?php echo $output['waybill_info']['waybill_pixel_width'];?>px; height: <?php echo $output['waybill_info']['waybill_pixel_height'];?>px; }
            .waybill_back img { width: <?php echo $output['waybill_info']['waybill_pixel_width'];?>px; height: <?php echo $output['waybill_info']['waybill_pixel_height'];?>px; }
            .waybill_design { position: absolute; left: 0; top: 0; width: <?php echo $output['waybill_info']['waybill_pixel_width'];?>px; height: <?php echo $output['waybill_info']['waybill_pixel_height'];?>px; }
            .waybill_item { position: absolute; left: 0; top: 0; width:100px; height: 20px; border: 1px solid #CCCCCC; }
        </style>
    </head>
    <body>
        <div class="waybill_back">
            <img src="<?php echo $output['waybill_info']['waybill_image_url'];?>" alt="">
        </div>
        <div class="waybill_design">
            <?php if(!empty($output['waybill_info']['waybill_data']) && is_array($output['waybill_info']['waybill_data'])) {?>
            <?php foreach($output['waybill_info']['waybill_data'] as $key=>$value) {?>
            <?php if($value['check']) {?>
            <div class="waybill_item" style="left:<?php echo $value['left'];?>px; top:<?php echo $value['top'];?>px; width:<?php echo $value['width'];?>px; height:<?php echo $value['height'];?>px;"><?php echo $value['content'];?></div>
            <?php } ?>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="control">
            <a id="btn" href="javascript:;">打印</a>
        </div>
        <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
        <script>
            $(document).ready(function() {
                $('#btn').on('click', function() {
                    pos();

                    $('.waybill_back').hide();
                    $('.control').hide();

                    window.print();
                });

                var pos = function () {
                    var top = <?php echo $output['waybill_info']['waybill_pixel_top'];?>;
                    var left = <?php echo $output['waybill_info']['waybill_pixel_left'];?>;

                    $(".waybill_design").each(function(index) {
                        var offset = $(this).offset();
                        var offset_top = offset.top + top;
                        var offset_left = offset.left + left;
                        $(this).offset({ top: offset_top, left: offset_left})
                    });
                };
            });
        </script>

    </body>
</html>

