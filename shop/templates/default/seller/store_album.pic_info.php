<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div id="pictureFolder" class="ncsc-picture-folder">
  <dl class="ncsc-album-intro">
    <dt class="albume-name"><a href="index.php?act=store_album&op=album_pic_list&id=<?php echo $output['class_info']['aclass_id']?>"><?php echo $output['class_info']['aclass_name']?></a></dt>
    <dd class="album-covers">
      <?php if($output['class_info']['aclass_cover'] != ''){ ?>
      <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].DS.str_replace('_small', '_tiny', $output['class_info']['aclass_cover']);?>">
      <?php }else{?>
      <i class="icon-picture"></i>
      <?php }?>
      </a></dd>
    <dd class="album-info"><?php echo $output['class_info']['aclass_des']?></dd>
  </dl>
  <div id="gallery" class="ad-gallery">
    <div class="ad-nav">
      <div class="ad-thumbs">
        <ul class="ad-thumb-list">
          <?php foreach ($output['pic_list'] as $v) {?>
          <li><a href="<?php echo thumb($v, 1280);?>" value="<?php echo $v['apic_id'] ?>"> <img title="<?php echo $v['apic_name']?>" src="<?php echo thumb($v, 60);?>" class="image0"/>
            <input type="hidden" value="" />
            </a> </li>
          <?php }?>
        </ul>
      </div>
    </div>
    <div class="ad-image-date">
      <dt><?php echo $lang['album_pinfo_img_name'];?></dt>
      <dd id="img_name"><?php echo $output['pic_info']['apic_name'];?></dd>
      <dt><?php echo $lang['album_pinfo_img_attribute'];?></dt>
      <dd>
        <p id="upload_time"><b><?php echo $lang['album_pinfo_upload_time'].$lang['nc_colon'];?></b><?php echo date('Y-m-d',$output['pic_info']['upload_time']);?></p>
        <p><b><?php echo $lang['album_pinfo_class_name'].$lang['nc_colon'];?></b><?php echo str_cut($output['class_info']['aclass_name'],20);?></p>
        <p id="default_size"><b><?php echo $lang['album_pinfo_original_size'].$lang['nc_colon'];?></b><?php echo $output['pic_info']['apic_size'];?>KB</p>
        <p id="default_spec"><b><?php echo $lang['album_pinfo_original_spec'].$lang['nc_colon'];?></b><?php echo $output['pic_info']['apic_spec'];?></p>
        <p><?php echo $lang['album_pinfo_see_src']?><span><a href="JavaScript:void(0);" target="_black" id="default_popup"  class="view popup"><?php echo $lang['album_pinfo_see'];?></a></span></p>
        <p><?php echo $lang['album_pinfo_see_max']?><span><a href="JavaScript:void(0);" target="_black" id="max_popup" class="view popup"><?php echo $lang['album_pinfo_see'];?></a></span></p>
        <p><?php echo $lang['album_pinfo_see_mid']?><span><a href="JavaScript:void(0);" target="_black" id="mid_popup" class="view popup"><?php echo $lang['album_pinfo_see'];?></a></span></p>
        <p><?php echo $lang['album_pinfo_see_small']?><span><a href="JavaScript:void(0);" target="_black" id="small_popup" class="view popup"><?php echo $lang['album_pinfo_see'];?></a></span></p>
        <p><?php echo $lang['album_pinfo_see_tiny']?><span><a href="JavaScript:void(0);" target="_black" id="tiny_popup" class="view popup"><?php echo $lang['album_pinfo_see'];?></a></span></p>
      </dd>
    </div>
    <div class="ad-image-wrapper"></div>
    <div class="clear"></div>
  </div>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ad-gallery.js"></script> 
<script>
  $(function() {
    
    var galleries = $('.ad-gallery').adGallery({loader_image:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif', start_at_index:<?php echo intval($_GET['start_index']);?>, slideshow:{enable: false,start_label: '<?php echo $lang['album_pinfo_autoplay'];?>', stop_label: '<?php echo $lang['album_pinfo_suspend'];?>'}});
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $('#toggle-slideshow').click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
    $('#toggle-description').click(
      function() {
        if(!galleries[0].settings.description_wrapper) {
          galleries[0].settings.description_wrapper = $('#descriptions');
        } else {
          galleries[0].settings.description_wrapper = false;
        }
        return false;
      }
    );

	//var img_type = '<?php echo $output['img_type'];?>';
	
	//查看原图
	$("#default_popup").click(function(){
		var pic = $(".ad-image > img").attr('src');
		p = pic.lastIndexOf('.')+1;
		img_type = pic.substring(p);
		pic = pic.replace('_1280.'+img_type,'');
		$('#default_popup').attr('href',pic + '.' + img_type);
	});

	//	查看大图
	$("#max_popup").click(function(){
		var pic = $(".ad-image > img").attr('src');
		p = pic.lastIndexOf('.')+1;
		img_type = pic.substring(p);
		pic = pic.replace('_1280'+img_type,'');
		$('#max_popup').attr('href',pic);
	});
	
	//	查看中图
	$("#mid_popup").click(function(){
		var pic = $(".ad-image > img").attr('src');
		p = pic.lastIndexOf('.')+1;
		img_type = pic.substring(p);
		pic = pic.replace('_1280.','_360.');
		$('#mid_popup').attr('href',pic);
	});
	//	查看小图
	$("#small_popup").click(function(){
		var pic = $(".ad-image > img").attr('src');
		p = pic.lastIndexOf('.')+1;
		img_type = pic.substring(p);
		pic = pic.replace('_1280.','_240.');
		$('#small_popup').attr('href',pic);
	});
	//	查看微图
	$("#tiny_popup").click(function(){
		var pic = $(".ad-image > img").attr('src');
		p = pic.lastIndexOf('.')+1;
		img_type = pic.substring(p);
		pic = pic.replace('_1280.','_60.');
		$('#tiny_popup').attr('href',pic);
	});

	$(".image0").click(function(){
		ajax_change_imgmessage(this.src);
	});
	$(".ad-next").click(function(){
		ajax_change_imgmessage($(".ad-image > img").attr('src'));
	});
	$(".ad-prev").click(function(){
		ajax_change_imgmessage($(".ad-image > img").attr('src'));
	});

	$('.ad-back').live('click',function(){
		if (typeof(curpage) == 'undefined'){
			curpage = <?php echo $output['curpage']-1;?>
		}else{
			if (curpage > 1){
				curpage --;
			}else{
				return;
			}
		}
		$('.ad-thumb-list').load('index.php?act=store_album&op=album_ad_ajax&id=<?php echo $_GET['id'];?>&class_id=<?php echo $_GET['class_id'];?>&curpage='+curpage);
	});
	$('.ad-forward').live('click',function(){
		if (typeof(curpage) == 'undefined'){
			curpage = <?php echo intval($output['curpage'])+1;?>;
		}else{
			if (curpage < <?php echo $output['total_page'];?>){
				curpage ++;
			}else{
				return;
			}
		}
		$('.ad-thumb-list').load('index.php?act=store_album&op=album_ad_ajax&id=<?php echo $_GET['id'];?>&class_id=<?php echo $_GET['class_id'];?>&curpage='+curpage);
	});
});

function ajax_change_imgmessage(url){

	$.getJSON("<?php echo SHOP_SITE_URL; ?>/index.php?act=store_album&op=ajax_change_imgmessage", {'url':url}, function(data){
		$("#img_name").html(data.img_name);
		$("#upload_time").html('<b><?php echo $lang['album_pinfo_upload_time'].$lang['nc_colon'];?></b>'+data.upload_time);
		$("#default_size").html('<b><?php echo $lang['album_pinfo_original_size'].$lang['nc_colon'];?></b>'+data.default_size+'KB');
		$("#default_spec").html('<b><?php echo $lang['album_pinfo_original_spec'].$lang['nc_colon'];?></b>'+data.default_spec);
	});
}
</script>