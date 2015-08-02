<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="sns-skin">
  <ul>
    <li <?php if($output['skin_style'] == 'skin_01'){?>class="selected"<?php }?>><a class="styleswitch" href="javascript:void(0);" rel=skin_01><img src="<?php echo SHOP_TEMPLATES_URL;?>/sns/style/skin01/skin_01_thumb.jpg" /></a></li>
    <li <?php if($output['skin_style'] == 'skin_02'){?>class="selected"<?php }?>><a class="styleswitch" href="javascript:void(0);" rel=skin_02><img src="<?php echo SHOP_TEMPLATES_URL;?>/sns/style/skin02/skin_02_thumb.jpg" /></a></li>
    <li <?php if($output['skin_style'] == 'skin_03'){?>class="selected"<?php }?>><a class="styleswitch" href="javascript:void(0);" rel=skin_03><img src="<?php echo SHOP_TEMPLATES_URL;?>/sns/style/skin03/skin_03_thumb.jpg" /></a></li>
    <li <?php if($output['skin_style'] == 'skin_04'){?>class="selected"<?php }?>><a class="styleswitch" href="javascript:void(0);" rel=skin_04><img src="<?php echo SHOP_TEMPLATES_URL;?>/sns/style/skin04/skin_04_thumb.jpg" /></a></li>
    <li <?php if($output['skin_style'] == 'skin_05'){?>class="selected"<?php }?>><a class="styleswitch" href="javascript:void(0);" rel=skin_05><img src="<?php echo SHOP_TEMPLATES_URL;?>/sns/style/skin05/skin_05_thumb.jpg" /></a></li>
    <li <?php if($output['skin_style'] == 'skin_06'){?>class="selected"<?php }?>><a class="styleswitch" href="javascript:void(0);" rel=skin_06><img src="<?php echo SHOP_TEMPLATES_URL;?>/sns/style/skin06/skin_06_thumb.jpg" /></a></li>
  </ul>
</div>
<div class="sns-skin-button"><a href="javascript:void(0);" nctype="skin_save" class="save"><?php echo $lang['nc_common_button_save'];?></a><a href="javascript:void(0);" onclick="DialogManager.close('change_skin');" class="close"><?php echo $lang['nc_cancel'];?></a></div>
<script type="text/javascript">
var skin_path = '<?php echo SHOP_TEMPLATES_URL;?>/sns/style/';
var default_skin = '<?php echo $output['skin_style'];?>';
$(function(){
	$('.styleswitch').click(function(){
		$('.sns-skin').find('li.selected').removeClass();
		$(this).parent().addClass('selected');
		default_skin = $(this).attr('rel');
		$('#skin_link').attr('href', skin_path+default_skin+'.css');
	});
	$('a[nctype="skin_save"]').click(function(){
		$.get("index.php?act=sns_setting&op=skin_save&skin="+default_skin, function(data){
			DialogManager.close('change_skin');
		});
	});
});
</script>