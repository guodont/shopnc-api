<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default"> <div class="alert">
      <ul>
        <li>1. <?php echo $lang['store_slide_description_one'];?></li>
        <li>2. <?php printf($lang['store_slide_description_two'],intval(C('image_max_filesize'))/1024);?></li>
        <li>3. <?php echo $lang['store_slide_description_three'];?></li>
        <li>4. <?php echo $lang['store_slide_description_fore'];?></li>
      </ul>
    </div>
  <div class="flexslider">
    <ul class="slides">
      <?php if(!empty($output['store_slide']) && is_array($output['store_slide'])){?>
      <?php for($i=0;$i<5;$i++){?>
      <?php if($output['store_slide'][$i] != ''){?>
      <li><a <?php if($output['store_slide_url'][$i] != '' && $output['store_slide_url'][$i] != 'http://'){?>href="<?php echo $output['store_slide_url'][$i];?>"<?php }?>><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS.$output['store_slide'][$i];?>"></a></li>
      <?php }?>
      <?php }?>
      <?php }else{?>
      <li> <img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS;?>f01.jpg"> </li>
      <li> <img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS;?>f02.jpg"> </li>
      <li> <img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS;?>f03.jpg"> </li>
      <li> <img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS;?>f04.jpg"> </li>
      <?php }?>
    </ul>
  </div>
  <form action="index.php?act=store_setting&op=store_slide" id="store_slide_form" method="post" onsubmit="ajaxpost('store_slide_form', '', '', 'onerror');return false;">
    <input type="hidden" name="form_submit" value="ok" />
    <!-- 图片上传部分 -->
    <ul class="ncsc-store-slider" id="goods_images">
      <?php for($i=0;$i<5;$i++){?>
      <li nc_type="handle_pic" id="thumbnail_<?php echo $i;?>">
        <div class="picture" nctype="file_<?php echo $i;?>">
          <?php if (empty($output['store_slide'][$i])) {?>
          <i class="icon-picture"></i>
          <?php } else {?>
          <img nctype="file_<?php echo $i;?>" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SLIDE.DS.$output['store_slide'][$i];?>" />
          <?php }?>
          <input type="hidden" name="image_path[]" nctype="file_<?php echo $i;?>" value="<?php echo $output['store_slide'][$i];?>" /><a href="javascript:void(0)" nctype="del" class="del" title="移除">X</a></div>
        
        <div class="url">
          <label><?php echo $lang['store_slide_image_url'];?></label>
          <input type="text" class="text w150" name="image_url[]" value="<?php if($output['store_slide_url'][$i] == ''){  echo 'http://';}else{echo $output['store_slide_url'][$i];}?>" />
        </div>
         <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
          <input type="file" hidefocus="true" size="1" class="input-file" name="file_<?php echo $i;?>" id="file_<?php echo $i;?>"/>
          </span>
          <p><i class="icon-upload-alt"></i><?php echo $lang['store_slide_image_upload'];?></p>
          </a></div></li>
      <?php } ?>
    </ul>
   <div class="bottom"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['store_slide_submit'];?>"></label></div>
  </form>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script> 
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/store_slide.js" charset="utf-8"></script>
<!-- 引入幻灯片JS --> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.flexslider-min.js"></script> 
<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL;?>";
var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';
var UPLOAD_SITE_URL = '<?php echo UPLOAD_SITE_URL;?>';
var ATTACH_COMMON = '<?php echo ATTACH_COMMON;?>';
var ATTACH_STORE = '<?php echo ATTACH_STORE;?>';
var SHOP_RESOURCE_SITE_URL = '<?php echo SHOP_RESOURCE_SITE_URL;?>';
</script> 
