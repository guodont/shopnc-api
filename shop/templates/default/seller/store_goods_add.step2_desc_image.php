<div class="goods-gallery add-step2"> <a class="sample_demo" id="select_s" href="index.php?act=store_album&op=pic_list&item=des" style="display:none;"><?php echo $lang['nc_submit'];?></a>
  <div class="nav"><span class="l"><?php echo $lang['store_goods_album_users'];?> >
    <?php if(isset($output['class_name']) && $output['class_name'] != ''){echo $output['class_name'];}else{?>
    <?php echo $lang['store_goods_album_all_photo'];?>
    <?php }?>
    </span><span class="r">
    <select name="jumpMenu" id="jump_menu" style="width:100px;">
      <option value="0" style="width:80px;"><?php echo $lang['nc_please_choose'];?></option>
      <?php foreach($output['class_list'] as $val) { ?>
      <option style="width:80px;" value="<?php echo $val['aclass_id']; ?>" <?php if($val['aclass_id']==$_GET['id']){echo 'selected';}?>><?php echo $val['aclass_name']; ?></option>
      <?php } ?>
    </select>
    </span></div>
  <?php if(!empty($output['pic_list'])){?>
  <ul class="list">
    <?php foreach ($output['pic_list'] as $v){?>
    <li onclick="insert_editor('<?php echo cthumb($v['apic_cover'], 1280, $_SESSION['store_id']);?>');"><a href="JavaScript:void(0);"><img src="<?php echo cthumb($v['apic_cover'], 240, $_SESSION['store_id']);?>" title='<?php echo $v['apic_name']?>'/></span></a></li>
    <?php }?>
  </ul>
  <?php }else{?>
  <div class="warning-option"><i class="icon-warning-sign"></i><span>相册中暂无图片</span></div>
  <?php }?>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
</div>
<script>
$(document).ready(function(){
	$('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:'img',
		loadingMsg:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif',
		target:'#des_demo'
	});
	$('#jump_menu').change(function(){
		$('#select_s').attr('href',$('#select_s').attr('href')+"&id="+$('#jump_menu').val());
		$('.sample_demo').ajaxContent({
			event:'click', //mouseover
			loaderType:'img',
			loadingMsg:'<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif',
			target:'#des_demo'
		});
		$('#select_s').click();
	});
});
</script>