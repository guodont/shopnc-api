<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-info mt10">
  <h4>操作提示</h4>
  <ul>
    <li>1. 装修图库作为店铺装修时上传的图片的空间，最多可上传100张图片。请定期清理无用的图片以保证正常使用。</li>
    <li>2. 删除图片时请确认该图片已经不为店铺模板装修所使用，否则将影响装修模板显示。</li>
  </ul>
</div>
<?php if(!empty($output['image_list']) && is_array($output['image_list'])) {?>
<div class="ncsc-gallery">
  <ul>
    <?php foreach($output['image_list'] as $key => $value) {?>
    <li>
      <div class="pic-thumb"><a nctype="nyroModal" href="<?php echo $value['image_url'];?>"><img src="<?php echo $value['image_url'];?>" alt="<?php echo $value['image_name'];?>"></a></div>
      <div class="pic-name"><?php echo $value['image_origin_name'];?></div>
      <div class="pic-handle"><span><?php echo $value['upload_time_format'];?></span><a nctype="btn_del_image" href="javascript:void(0);" data-image-id="<?php echo $value['image_id'];?>" class="ncsc-btn-mini"><i class="icon-trash"></i>删除</a></div>
    </li>
    <?php } ?>
  </ul>
</div>
<div class="pagination"><?php echo $output['show_page']; ?></div>
<?php } else { ?>
<div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div>
<?php } ?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
    $('.raty').raty({
        path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
        readOnly: true,
        score: function() {
          return $(this).attr('data-score');
        }
    });

   $('a[nctype="nyroModal"]').nyroModal();
});
</script> 
<script type="text/javascript">
    $(document).ready(function(){
        $('[nctype="btn_del_image"]').on('click', function() {
            if(confirm('确认删除？')) {
                $this = $(this);
                var image_id = $(this).attr('data-image-id');
                $.ajax({
                    type: "POST",
                    url: '<?php echo urlShop('store_decoration', 'decoration_album_del');?>',
                    data: {image_id: image_id},
                    dataType: 'json'
                })
                .done(function(data) {
                    if(typeof data.error == 'undefined') {
                        $this.parents('li').hide();
                    } else {
                        showError(data.error); 
                    }
                })
                .fail(function() {
                   showError('删除失败'); 
                });
            }
        });
    });
</script> 
