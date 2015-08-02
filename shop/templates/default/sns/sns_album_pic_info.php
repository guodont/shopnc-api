<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="sidebar">
  <div class="ad-image-date">
    <dt><?php echo $lang['album_pinfo_img_name'];?></dt>
    <dd id="img_name"><?php echo $output['pic_info']['ap_name'];?></dd>
    <dt><?php echo $lang['album_pinfo_img_attribute'];?></dt>
    <dd>
      <p id="upload_time"><b><?php echo $lang['album_pinfo_upload_time'].$lang['nc_colon'];?></b><?php echo date('Y-m-d',$output['pic_info']['upload_time']);?></p>
      <p><b><?php echo $lang['album_pinfo_class_name'].$lang['nc_colon'];?></b><?php echo $output['class_info']['ac_name'];?></p>
      
      <p id="default_spec"><b><?php echo $lang['album_pinfo_original_spec'].$lang['nc_colon'];?></b><?php echo $output['pic_info']['ap_spec'];?></p>

    </dd>
  </div>
</div>
<div class="left-content">
  <div class="tabmenu">
    <?php include template('layout/submenu'); ?>
  </div>
  <div id="pictureFolder" class="album">
    <div class="intro mb20">
      <div class="covers"><span class="thumb size60"><i></i><a href="index.php?act=sns_album&op=album_pic_list&id=<?php echo $output['class_info']['ac_id']?>">
        <?php if($output['class_info']['ac_cover'] != ''){ ?>
        <img id="aclass_cover" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.$output['class_info']['ac_cover'];?>"  onerror="this.src='<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>'" onload="javascript:DrawImage(this,60,60);">
        <?php }else{?>
        <img id="aclass_cover" src="<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>" onload="javascript:DrawImage(this,60,60);">
        <?php }?>
        </a></span></div>
      <dl>
        <dt><?php echo $output['class_info']['ac_name']?></dt>
        <dd><?php echo $output['class_info']['ac_des']?></dd>
      </dl>
    </div>
    <div id="gallery" class="ad-gallery">
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
            <?php foreach ($output['pic_list'] as $v) {?>
            <li> <a href="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.$v['ap_cover'];?>" value="<?php echo $v['ap_id'] ?>"> <span class="thumb"><i></i> <img nctype="thumb" title="<?php echo $v['ap_name']?>" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.str_ireplace('.', '_240.', $v['ap_cover']);?>" />
              <input type="hidden" value="" />
              </span> </a> </li>
            <?php }?>
          </ul>
        </div>
      </div>
      <div class="ad-image-wrapper"> </div>
<!--      <div class="ad-controls"> </div>
      <div class="ad-showmode">
        <p><?php echo $lang['album_pinfo_photos_switch_effect'];?>
          <select id="switch-effect">
            <option value="slide-hori"><?php echo $lang['album_pinfo_level_slip_into'];?></option>
            <option value="slide-vert"><?php echo $lang['album_pinfo_vertical_slip_into'];?></option>
            <option value="resize"><?php echo $lang['album_pinfo_contraction_amplification'];?></option>
            <option value="fade"><?php echo $lang['album_pinfo_crossfade'];?></option>
            <option value="none"><?php echo $lang['album_pinfo_null'];?></option>
          </select>
        </p>
      </div>-->
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ad-gallery.js"></script> 
<script type="text/javascript">
  $(function() {
    
    var galleries = $('.ad-gallery').adGallery({loader_image:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif', start_at_index:<?php echo intval($_GET['start_index'])?>, slideshow:{enable: false,start_label: '<?php echo $lang['album_pinfo_autoplay'];?>', stop_label: '<?php echo $lang['album_pinfo_suspend'];?>'}});
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
    

	$('img[nctype="thumb"]').click(function(){
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
			curpage = <?php echo intval($output['curpage'])-1;?>;
		}else{
			if (curpage > 1){
				curpage --;
			}else{
				return;
			}
		}
		$('.ad-thumb-list').load('index.php?act=sns_album&op=album_pic_scroll_ajax&id=<?php echo $_GET['id'];?>&class_id=<?php echo $_GET['class_id'];?>&mid=<?php echo $_GET['mid'];?>&curpage='+curpage);
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
		$('.ad-thumb-list').load('index.php?act=sns_album&op=album_pic_scroll_ajax&id=<?php echo $_GET['id'];?>&class_id=<?php echo $_GET['class_id'];?>&mid=<?php echo $_GET['mid'];?>&curpage='+curpage);
	});	
});
function ajax_change_imgmessage(url){

	$.getJSON("<?php echo SHOP_SITE_URL; ?>/index.php?act=sns_album&op=ajax_change_imgmessage&mid=<?php echo $output['master_id'];?>", {'url':url}, function(data){
		$("#img_name").html(data.img_name);
		$("#upload_time").html('<b><?php echo $lang['album_pinfo_upload_time'].$lang['nc_colon'];?></b>'+data.upload_time);
		$("#default_spec").html('<b><?php echo $lang['album_pinfo_original_spec'].$lang['nc_colon'];?></b>'+data.default_spec);
	});
}
</script>