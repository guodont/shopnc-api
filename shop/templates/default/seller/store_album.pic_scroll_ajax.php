<?php defined('InShopNC') or exit('Access Invalid!');?>
            <?php foreach ((array)$output['pic_list'] as $v) {?>
            <li> <a href="<?php echo thumb($v, 1280);?>" value="<?php echo $v['apic_id'] ?>"> <span class="thumb size90"><i></i> <img title="<?php echo $v['apic_name']?>" src="<?php echo thumb($v, 60);?>" class="image0" onload="javascript:DrawImage(this,90,90);"/>
              <input type="hidden" value="" />
              </span> </a> </li>
            <?php }?>
<script type="text/javascript">
  $(function() {
    var galleries = $('.ad-gallery').adGallery({loader_image:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif', start_at_index:0, slideshow:{enable: false,start_label: '<?php echo $lang['album_pinfo_autoplay'];?>', stop_label: '<?php echo $lang['album_pinfo_suspend'];?>'}});
	$(".image0").click(function(){
		ajax_change_imgmessage(this.src);
	});
  });
</script>