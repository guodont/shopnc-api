<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
#fwin_preview_image {
	top: 20px!important;
}
</style>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-store-templet">
  <dl class="current-style">
    <dt class="templet-thumb"><img src="<?php echo $output['curr_theme']['curr_image'];?>" id="current_theme_img" /></dt>
    <dd><?php echo $lang['store_theme_tpl_name'];?><?php echo $lang['nc_colon'];?><strong id="current_template"><?php echo $output['curr_theme']['curr_name'];?></strong></dd>
    <dd><?php echo $lang['store_theme_style_name'];?><?php echo $lang['nc_colon'];?><strong id="current_style"><?php echo $output['curr_theme']['curr_truename'];?></strong></dd>
    <dd><?php echo $lang['store_create_store_name'];?><?php echo $lang['nc_colon'];?><strong><?php echo $output['store_info']['store_name'];?></strong></dd>
    <dd><a href="<?php echo urlShop('show_store', 'index', array('store_id' => $output['store_info']['store_id']));?>" class="ncsc-btn"><?php echo $lang['store_theme_homepage'];?></a></dd>
  </dl>
  <h3><?php echo $lang['store_theme_valid'];?></h3>
  <div class="templet-list">
    <ul>
      <?php foreach((array)$output['theme_list'] as $theme){?>
      <li>
        <dl>
          <dt><a href="javascript:void(0)" onclick="preview_theme('<?php echo $theme['name'];?>');"><img id="themeimg_<?php echo $theme['name'];?>" src="<?php echo $theme['image'];?>"></a></dt>
          <dd><?php echo $lang['store_theme_tpl_name1'];?><?php echo $lang['nc_colon'];?><?php echo $theme['name'];?></dd>
          <dd><?php echo $lang['store_theme_style_name1'];?><?php echo $lang['nc_colon'];?><?php echo $theme['truename'];?></dd>
          <dd class="btn"> <a href="javascript:use_theme('<?php echo $theme['name'];?>','<?php echo $theme['truename'];?>');" class="ncsc-btn"><i class="icon-cogs"></i><?php echo $lang['store_theme_use'];?></a> <a href="javascript:preview_theme('<?php echo $theme['name'];?>');" class="ncsc-btn"><i class="icon-zoom-in"></i><?php echo $lang['store_theme_preview'];?></a> </dd>
        </dl>
      </li>
      <?php }?>
    </ul>
  </div>
</div>
<script>
var curr_template_name = '<?php echo $output['curr_theme']['curr_name'];?>';
var curr_style_name    = '<?php echo $output['curr_theme']['curr_name'];?>';
var preview_img = new Image();
preview_img.onload = function(){
    var d = DialogManager.get('preview_image');
    if (!d)
    {
        return;
    }

    if (d.getStatus() != 'loading')
    {

        return;
    }

    d.setWidth(this.width + 50);
    d.setPosition('center');
    d.setContents($('<img src="' + this.src + '" alt="" />'));
    ScreenLocker.lock();
};
preview_img.onerror= function(){
    alert('<?php echo $lang['store_theme_load_preview_fail'];?>');
    DialogManager.close('preview_image');
};
function preview_theme(style_name){
    var screenshot = '<?php echo SHOP_TEMPLATES_URL;?>/store/style/' + style_name + '/screenshot.jpg';

    var d = DialogManager.create('preview_image');
    d.setTitle('<?php echo $lang['store_theme_effect_preview'];?>');
    d.setContents('loading', {'text':'<?php echo $lang['store_theme_loading1'];?>...'});
    d.setWidth(270);
    d.show('center');

    preview_img.src = screenshot;
}
function use_theme(style,truename){
    ajaxget('index.php?act=store_setting&op=set_theme&style_name=' + style);
}
</script>
