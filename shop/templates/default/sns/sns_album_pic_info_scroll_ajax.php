<?php defined('InShopNC') or exit('Access Invalid!');?>
            <?php foreach ($output['pic_list'] as $v) {?>
            <li> <a href="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.$v['ap_cover'];?>" value="<?php echo $v['ap_id'] ?>"> <span class="thumb"><i></i> <img nctype="thumb" title="<?php echo $v['ap_name']?>" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.str_ireplace('.', '_240.', $v['ap_cover']);?>" />
              <input type="hidden" value="" />
              </span> </a> </li>
            <?php }?>

<script type="text/javascript">
  $(function() {
    var galleries = $('.ad-gallery').adGallery({loader_image:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif', start_at_index:0, slideshow:{enable: false,start_label: '<?php echo $lang['album_pinfo_autoplay'];?>', stop_label: '<?php echo $lang['album_pinfo_suspend'];?>'}});
    $('img[nctype="thumb"]').click(function(){
		ajax_change_imgmessage(this.src);
	});
  });
</script>