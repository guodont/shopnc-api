
<div class="goods-gallery"> <a class='sample_demo' id="select_submit" href="index.php?act=flea_album&op=pic_list&item=goods" style="display:none;"><?php echo $lang['nc_submit'];?></a>
  <div class="nav"><span class="l"><?php echo $lang['store_goods_album_users'];?> >
    <?php if(isset($output['class_name']) && $output['class_name'] != ''){echo $output['class_name'];}else{?>
    <?php echo $lang['store_goods_album_all_photo'];?>
    <?php }?>
    </span><span class="r">
    <select name="jumpMenu" id="jumpMenu" style="width:100px;">
      <option value="0" style="width:80px;"><?php echo $lang['nc_please_choose'];?></option>
      <?php foreach($output['class_list'] as $val) { ?>
      <option style="width:80px;" value="<?php echo $val['aclass_id']; ?>" <?php if($val['aclass_id']==$_GET['id']){echo 'selected';}?>><?php echo $val['aclass_name']; ?></option>
      <?php } ?>
    </select>
    </span></div>
  <ul class="list">
    <?php if(!empty($output['pic_list'])){?>
    <?php foreach ($output['pic_list'] as $v){?>
    <li onclick="insert_img(<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$_SESSION['member_id'].DS.$v['file_name'];?>');"><a href="JavaScript:void(0);"><span class="thumb size90"><i></i><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MALBUM.DS.$_SESSION['member_id'].DS.$v['file_name'];?>" onload="javascript:DrawImage(this,90,90);" onerror="this.src='<?php echo SHOP_TEMPLATES_URL.'/images/member/default_image.png';?>'" title='<?php echo $v['apic_name']?>'/></span></a></li>
    <?php }?>
    <?php }else{?>
    <?php echo $lang['no_record'];?>
    <?php }?>
  </ul>
  <div class="clear" style="padding-top:10px;"></div>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
  <div class="clear" style="padding-bottom:20px;"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:'img',
		loadingMsg:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif',
		target:'#demo'
	});
	$('#jumpMenu').change(function(){
		$('#select_submit').attr('href',$('#select_submit').attr('href')+"&id="+$('#jumpMenu').val());
		$('.sample_demo').ajaxContent({
			event:'click', //mouseover
			loaderType:'img',
			loadingMsg:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif',
			target:'#demo'
		});
		$('#select_submit').click();
	});
});
</script>