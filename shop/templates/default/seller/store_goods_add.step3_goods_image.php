<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="goods-gallery" nctype="gallery-<?php echo $output['color_id'];?>"> <a class="sample_demo" href="index.php?act=store_album&op=pic_list&item=goods_image&color_id=<?php echo $output['color_id'];?>" style="display:none;"><?php echo $lang['nc_submit'];?></a>
  <div class="nav"><span class="l"><?php echo $lang['store_goods_album_users'];?> >
    <?php if(isset($output['class_name']) && $output['class_name'] != ''){echo $output['class_name'];}else{?>
    <?php echo $lang['store_goods_album_all_photo'];?>
    <?php }?>
    </span><span class="r">
    <select name="jumpMenu" style="width:100px;">
      <option value="0" style="width:80px;"><?php echo $lang['nc_please_choose'];?></option>
      <?php foreach($output['class_list'] as $val) { ?>
      <option style="width:80px;" value="<?php echo $val['aclass_id']; ?>" <?php if($val['aclass_id']==$_GET['id']){echo 'selected';}?>><?php echo $val['aclass_name']; ?></option>
      <?php } ?>
    </select>
    </span></div>
  <ul class="list">
    <?php if(!empty($output['pic_list'])){?>
    <?php foreach ($output['pic_list'] as $v){?>
    <li onclick="insert_img('<?php echo $v['apic_cover'];?>','<?php echo thumb($v, 240);?>', <?php echo $output['color_id'];?>);"><a href="JavaScript:void(0);"><img src="<?php echo thumb($v, 240);?>" title='<?php echo $v['apic_name']?>'/></a></li>
    <?php }?>
    <?php }else{?>
    <?php echo $lang['no_record'];?>
    <?php }?>
  </ul>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
</div>
<script>
$(document).ready(function(){
	$('div[nctype="gallery-<?php echo $output['color_id'];?>"]').find('.demo').unbind().ajaxContent({
		event:'click', //mouseover
		loaderType:'img',
		loadingMsg:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif',
		target:'div[nctype="album-<?php echo $output['color_id'];?>"]'
	});
	$('div[nctype="gallery-<?php echo $output['color_id'];?>"]').find('select[name="jumpMenu"]').unbind().change(function(){
		var $_select_submit = $('div[nctype="gallery-<?php echo $output['color_id'];?>"]').find('.sample_demo');
		var $_href = $_select_submit.attr('href') + "&id=" + $(this).val();
		$_select_submit.attr('href',$_href);
		$_select_submit.unbind().ajaxContent({
			event:'click', //mouseover
			loaderType:'img',
			loadingMsg:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif',
			target:'div[nctype="album-<?php echo $output['color_id'];?>"]'
		});
		$_select_submit.click();
	});
});
</script>